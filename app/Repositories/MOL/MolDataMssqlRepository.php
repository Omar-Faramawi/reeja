<?php namespace Tamkeen\Ajeer\Repositories\MOL;

use Carbon\Carbon;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Mockery\Exception;

class MolDataMssqlRepository implements MolDataRepository
{
    /**
     * @var Connection
     */
    private $db;
    
    /**
     * @var Repository
     */
    private $cache;
    
    /**
     * @param Connection $connection
     * @param Repository $cache
     */
    public function __construct(Connection $connection, Repository $cache)
    {
        $this->db    = $connection;
        $this->cache = $cache;
    }
    
    /**
     * Get the user ID number from MOL.
     *
     * @param int $userId
     *
     * @return int
     */
    public function getUserIdNumber($userId)
    {
        $user = $this->db->table('MOL_User')
            ->select('Id_Number AS id_number', 'Iqama_Number as iqama_number')
            ->where('Id', $userId)
            ->first();
        
        return data_get($user, 'id_number') ?: data_get($user, 'iqama_number');
    }
    
    /**
     * @param int $establishmentId
     *
     * @return array
     *
     * @throws ModelNotFoundException
     */
    public function findEstablishmentById($establishmentId)
    {
        $establishment = $this->db->table(new Expression('[MOL_Establishment] [E] WITH (NOLOCK)'))
            ->join(
                new Expression('[dbo].[Enum_EstablishmentStatus] [ESt] WITH (NOLOCK)'),
                'E.FK_EstablishmentStatusId', '=', 'ESt.Id'
            )
            ->join(
                new Expression('MOL_Nitaqaat.dbo.EconomicActivitiesMapping EAM WITH (NOLOCK)'),
                function (JoinClause $join) {
                    $join->on('E.FK_MainEconomicActivityId', '=', new Expression('EAM.MainEconomicActivityId'));
                    $join->on('E.FK_SubEconomicActivityId', '=', new Expression('EAM.SubEconomicActivityId'));
                }
            )
            ->join(
                new Expression('[MOL_Nitaqaat].[dbo].[Establishment_KPI] [KPI] WITH (NOLOCK)'),
                function (JoinClause $join) {
                    $join->on('E.FK_LaborOfficeId', '=', 'KPI.Lab_Off');
                    $join->on('E.SequenceNumber', '=', 'KPI.Sequence_no');
                }, null, null, 'left'
            )
            ->where('E.PK_EstablishmentId', $establishmentId)
            ->first([
                'E.PK_EstablishmentId AS FK_establishment_id',
                'E.FK_LaborOfficeId AS labor_office_id',
                'E.SequenceNumber AS sequence_number',
                'E.Name AS name',
                'E.FK_EstablishmentStatusId AS status_id',
                'ESt.Description AS status',
                'E.WASELStatus AS wasel_status',
                'E.WASELExpiryDate AS wasel_end_end',
                'E.CommercialRecordNumber AS cr_number',
                'E.CommercialRecordEndDate AS cr_end_date',
                'E.Notes AS notes',
                'E.FK_MainEconomicActivityId AS FK_main_economic_activity_id',
                'E.FK_SubEconomicActivityId AS FK_sub_economic_activity_id',
                'EAM.EconomicActivityId AS FK_economic_activity_id',
                new Expression('CAST(KPI.OriginalEconomicActivityName AS VARBINARY(MAX)) AS economic_activity'),
                'KPI.Fk_ColorId AS nitaqat_color_id',
                'KPI.Fk_SizeId AS size_id',
                'E.MunicipalLicenseSource',
                'E.Telephone1 phone',
                'E.District AS district',
                'E.WASELArea region',
                'E.WASELStreet street',
                'E.WASELCity city',
                new Expression('CAST(KPI.ColorName AS VARBINARY(MAX)) AS nitaqat_color'),
            ]);
        
        $notes = $this->db->table(new Expression('[dbo].[MOL_EstablishmentNote] [EN] WITH (NOLOCK)'))
            ->where('FK_EstablishmentId', $establishmentId)
            ->where('FK_NoteStatusId', 1)
            ->select(['EN.NoteText AS note_text'])
            ->get();
        
        if (count($notes) > 0) {
            $establishment->notes = collect($notes)->transform(function ($item) {
                return iconv('CP1256', 'UTF-8', data_get($item, 'note_text'));
            })->implode('note_text', ',');
        }
        
        $statements = $this->db->table(new Expression('[dbo].[MOL_EstablishmentStatement] WITH (NOLOCK)'))
            ->where('FK_EstablishmentId', $establishmentId)
            ->where('EndDate', '>', new Expression("'" . Carbon::now()->toDateTimeString() . "'"))
            ->whereNull('CancellationDate')
            ->orderBy('EndDate', 'DESC')
            ->get([
                'StatementNumber AS statement_number',
                'FK_StatementTypeId as statement_type_id',
                'EndDate AS statement_end_date',
                'CancellationDate AS statement_cancellation_date',
            ]);
        
        $establishment->statements = collect($statements)->groupBy('statement_type_id');
        
        $establishment->name   = iconv('CP1256', 'UTF-8', data_get($establishment, 'name'));
        $establishment->status = iconv('CP1256', 'UTF-8', data_get($establishment, 'status'));
        $establishment->notes  = iconv('CP1256', 'UTF-8', data_get($establishment, 'notes'));
        
        $establishment->nitaqat_color     = $this->decodeString(data_get($establishment, 'nitaqat_color'));
        $establishment->economic_activity = $this->decodeString(data_get($establishment, 'economic_activity'));
        
        $establishment->MunicipalLicenseSource = iconv('CP1256', 'UTF-8',
            data_get($establishment, 'MunicipalLicenseSource'));
        $establishment->District               = iconv('CP1256', 'UTF-8', data_get($establishment, 'District'));
        $establishment->WASELArea              = iconv('CP1256', 'UTF-8', data_get($establishment, 'WASELArea'));
        
        return $establishment;
    }
    
    /**
     * @param int $laborOfficeId
     * @param int $sequenceNumber
     *
     * @return array
     *
     * @throws ModelNotFoundException
     */
    public function findEstablishmentByNumber($laborOfficeId, $sequenceNumber)
    {
        $establishment = $this->db->table(new Expression('MOL_Establishment E WITH (NOLOCK)'))
            ->where('E.FK_LaborOfficeId', $laborOfficeId)
            ->where('E.SequenceNumber', $sequenceNumber)
            ->join(
                new Expression('MOL_Nitaqaat.dbo.EconomicActivitiesMapping EAM WITH (NOLOCK)'),
                function (JoinClause $join) {
                    $join->on('E.FK_MainEconomicActivityId', '=', new Expression('EAM.MainEconomicActivityId'));
                    $join->on('E.FK_SubEconomicActivityId', '=', new Expression('EAM.SubEconomicActivityId'));
                }
            )
            ->first([
                'E.PK_EstablishmentId AS FK_establishment_id',
                'E.FK_LaborOfficeId AS labor_office_id',
                'E.SequenceNumber AS sequence_number',
                'E.Name AS name',
                'E.FK_EstablishmentStatusId AS status_id',
                'ESt.Description AS status',
                'E.WASELStatus AS wasel_status',
                'E.WASELExpiryDate AS wasel_end_end',
                'E.CommercialRecordNumber AS cr_number',
                'E.CommercialRecordEndDate AS cr_end_date',
                'E.Notes AS notes',
                'E.FK_MainEconomicActivityId AS FK_main_economic_activity_id',
                'E.FK_SubEconomicActivityId AS FK_sub_economic_activity_id',
                'EAM.EconomicActivityId AS FK_economic_activity_id',
                new Expression('CAST(KPI.OriginalEconomicActivityName AS VARBINARY(MAX)) AS economic_activity'),
                'KPI.Fk_ColorId AS nitaqat_color_id',
                'KPI.Fk_SizeId AS size_id',
                'E.MunicipalLicenseSource',
                'E.Telephone1 phone',
                'E.District AS district',
                'E.WASELArea region',
                'E.WASELStreet street',
                'E.WASELCity city',
                new Expression('CAST(KPI.ColorName AS VARBINARY(MAX)) AS nitaqat_color'),
            ]);
        
        $notes = $this->db->table(new Expression('[dbo].[MOL_EstablishmentNote] [EN] WITH (NOLOCK)'))
            ->where('FK_EstablishmentId', $establishment->FK_establishment_id)
            ->where('FK_NoteStatusId', 1)
            ->select(['EN.NoteText AS note_text'])
            ->get();
        
        if (count($notes) > 0) {
            $establishment->notes = collect($notes)->transform(function ($item) {
                return iconv('CP1256', 'UTF-8', data_get($item, 'note_text'));
            })->implode('note_text', ',');
        }
        
        $statements = $this->db->table(new Expression('[dbo].[MOL_EstablishmentStatement] WITH (NOLOCK)'))
            ->where('FK_EstablishmentId', $establishment->FK_establishment_id)
            ->where('EndDate', '>', new Expression("'" . Carbon::now()->toDateTimeString() . "'"))
            ->whereNull('CancellationDate')
            ->orderBy('EndDate', 'DESC')
            ->get([
                'StatementNumber AS statement_number',
                'FK_StatementTypeId as statement_type_id',
                'EndDate AS statement_end_date',
                'CancellationDate AS statement_cancellation_date',
            ]);
        
        $establishment->statements = collect($statements)->groupBy('statement_type_id');
        
        $establishment->name   = iconv('CP1256', 'UTF-8', data_get($establishment, 'name'));
        $establishment->status = iconv('CP1256', 'UTF-8', data_get($establishment, 'status'));
        $establishment->notes  = iconv('CP1256', 'UTF-8', data_get($establishment, 'notes'));
        
        $establishment->nitaqat_color     = $this->decodeString(data_get($establishment, 'nitaqat_color'));
        $establishment->economic_activity = $this->decodeString(data_get($establishment, 'economic_activity'));
        
        $establishment->MunicipalLicenseSource = iconv('CP1256', 'UTF-8',
            data_get($establishment, 'MunicipalLicenseSource'));
        $establishment->District               = iconv('CP1256', 'UTF-8', data_get($establishment, 'District'));
        $establishment->WASELArea              = iconv('CP1256', 'UTF-8', data_get($establishment, 'WASELArea'));
        
        return $establishment;
    }
    
    /**
     * @param int $owner
     * @param int $laborOfficeId
     * @param int $sequenceNumber
     *
     * @return array
     *
     * @throws ModelNotFoundException
     */
    public function findEstablishmentByOwner($owner, $laborOfficeId, $sequenceNumber)
    {
        $establishment = $this->findEstablishmentByNumber($laborOfficeId, $sequenceNumber);
        
        if (data_get($establishment, 'owner_id') == $owner) {
            throw new ModelNotFoundException;
        }
        
        return $establishment;
    }
    
    /**
     * fetch owner ID for establishment
     *
     * @param $establishment_id
     *
     * @return integer
     */
    public function getOwnerByEstablishmentId($establishment_id)
    {
        $query = $this->link->prepare(
            "SELECT [E].[PK_EstablishmentId], [UN].[SevenHundredNumber], [O].[IdNo] FROM [dbo].[MOL_Establishment] [E]
      LEFT JOIN [dbo].[MOL_UnifiedNumber] [UN] WITH (NOLOCK)
           ON [UN].[PK_UnifiedNumberId] = [E].[FK_UnifiedNumberId]

      LEFT JOIN [dbo].[MOL_Owner] [O] WITH (NOLOCK)
           ON [UN].[FK_OwnerId] = [O].[PK_OwnerId]

      WHERE [E].[PK_EstablishmentId] = ?;"
        );
        $query->execute([$establishment_id]);
        
        if ($establishment = $query->fetch(\PDO::FETCH_ASSOC)) {
            if (!is_null($establishment['IdNo'])) {
                return $establishment['IdNo'];
            }
            
            if (!is_null($establishment['SevenHundredNumber'])) {
                return $establishment['SevenHundredNumber'];
            }
        }
        
        return false;
    }
    
    /**
     * @param int $idNumber
     *
     * @return Collection
     *
     * @throws ModelNotFoundException
     */
    public function findEstablishmentsByUserIdNumber($idNumber)
    {
        $establishments = $this->db->table(new Expression('MOL_VwUserEstablishments WITH (NOLOCK)'))
            ->where('AuthorizedIdNo', $idNumber)
            ->get([
                'Name AS name',
                'SequenceNumber AS sequence_number',
                'FK_LaborOfficeId AS labor_office_id',
            ]);
        
        $establishments = collect($establishments)->keyBy(function ($establishment) {
            return data_get($establishment, 'labor_office_id') . '-' . data_get($establishment, 'sequence_number');
        })->transform(function ($establishment) {
            return iconv('CP1256', 'UTF-8', data_get($establishment, 'name'));
        });
        
        return $establishments;
    }
    
    /**
     * @param int $establishmentId
     *
     * @return Collection
     */
    public function fetchEstablishmentUsers($establishmentId)
    {
        $users = $this->db->table(new Expression('MOL_VwUserEstablishments AS UE WITH (NOLOCK)'))
            ->join(new Expression('MOL_User as U'), 'U.Id_Number', '=', 'UE.AuthorizedIdNo')
            ->where('U.IsEmailVerified', 1)
            ->where('UE.IsVerified', 1)
            ->where('UE.PK_EstablishmentId', $establishmentId)
            ->get([
                'AuthorizedName AS name',
                'AuthorizedIdNo AS id_number',
                'Email as email',
            ]);
        
        return collect($users);
    }
    
    /**
     * @param int $establishmentId
     *
     * @return Collection
     */
    public function fetchEstablishmentLaborers($establishmentId)
    {
        $data          = new \stdClass();
        $laborersCount = $this->connection()
            ->table('MOL_Laborer')
            ->where('FK_EstablishmentId', $establishmentId)
            ->where('FK_LaborerStatusId', 1)
            ->select('PK_LaborerId')
            ->count();
        
        $laborers = $this->connection()
            ->table('MOL_Laborer AS L')
            ->leftJoin('Enum_Gender AS G', 'G.Id', '=', 'L.FK_GenderId')
            ->leftJoin('Enum_LaborerStatus AS LS', 'LS.Id', '=', 'L.FK_LaborerStatusId')
            ->leftJoin('Lookup_Nationality AS N', 'N.Id', '=', 'L.FK_NationalityId')
            ->select(
                'L.PK_LaborerId',
                $this->connection()->raw("CAST(ISNULL([L].[FirstName], '') + ' ' + ISNULL([L].[SecondName], '') + ' ' + ISNULL([L].[ThirdName], '') + ' ' + ISNULL([L].[FourthName], '') AS VARBINARY(MAX)) AS [FullName]"),
                $this->connection()->raw('CAST([G].[Description] AS VARBINARY(MAX)) AS [Gender]'),
                $this->connection()->raw('CAST([N].[Name] AS VARBINARY(MAX)) AS [Nationality]'),
                'L.EstablishmentName',
                'L.FK_EstablishmentId AS EstablishmentIdNo',
                'L.IdNo',
                'L.IdReleaseDate',
                'LS.Description AS LaborerStatus'
            )
            ->where('L.FK_EstablishmentId', $establishmentId)
            ->get();
        
        if (empty($laborers)) {
            $data->error = 'no data';
            
            return $data;
        }
        
        $establishment = [];
        foreach ($laborers as $laborer) {
            foreach ($laborer as $key => $val) {
                if (in_array($key, ['FullName', 'Gender', 'Nationality'])) {
                    $laborer->$key = $this->decodeString($val);
                } else {
                    if (in_array($key, ['IdReleaseDate'])) {
                        $laborer->$key = date('Y-m-d', strtotime($val));
                    } else {
                        if (!is_numeric($laborer->$key)) {
                            $laborer->$key = iconv('CP1256', 'UTF-8//TRANSLIT', $val);
                        }
                    }
                }
            }
            
            if (empty($establishment)) {
                $establishment = [
                    'Name' => $laborer->EstablishmentName,
                    'IdNo' => $laborer->EstablishmentIdNo,
                ];
            }
        }
        
        $data                = new \stdClass();
        $data->laborers      = $laborers;
        $data->establishment = $establishment;
        $data->laborersCount = $laborersCount;
        
        return $data;
    }

    /**
     * @param int $establishmentId
     *
     * @return int
     */
    public function fetchEstablishmentLaborersCount($establishmentId)
    {
        return $this->connection()
            ->table('MOL_Laborer')
            ->where('FK_EstablishmentId', $establishmentId)
            ->where('FK_LaborerStatusId', 1)
            ->select('PK_LaborerId')
            ->count();
    }
    
    /**
     * Get the laborer date.
     *
     * @param int $idNumber
     * @param int $establishmentId
     *
     * @return array
     */
    public function findLaborer($idNumber, $establishmentId = null, $fallbackToAjeerLaborers = false)
    {
        $query = $this->db->table(new Expression('[MOL_Laborer] [L] WITH (NOLOCK)'))
            ->join(new Expression('[Lookup_Nationality] [N] WITH (NOLOCK)'), 'L.FK_NationalityId', '=', 'N.Id')
            ->join(new Expression('[Lookup_Job] [J] WITH (NOLOCK)'), 'L.FK_JobId', '=', 'J.Id')
            ->where('L.IdNo', "$idNumber")
            ->whereIn('L.FK_AccomodationStatusId', [1, 4])
            ->whereNotIn('L.FK_LaborerStatusId', [3, 4, 5, 6, 7])
            ->select([
                new Expression("CAST(ISNULL([L].[FirstName],'') + ' ' + ISNULL([L].[SecondName],'') + ' ' "
                    . "+ ISNULL([L].[ThirdName],'') + ' ' + ISNULL([L].[FourthName],'') AS VARBINARY(MAX)) AS [name]"),
                'L.IdNo AS id_number',
                new Expression('CAST([J].[Name] AS VARBINARY(MAX)) AS [occupation]'),
                new Expression('CAST([N].[Name] AS VARBINARY(MAX)) AS [nationality]'),
                'L.FK_NationalityId AS FK_nationality_id',
                'L.FK_JobId AS FK_occupation_id',
                'L.FK_EstablishmentId AS FK_establishment_id',
            ]);
        
        if ($establishmentId) {
            $query->where('L.FK_EstablishmentId', $establishmentId);
        }
        
        $laborer = $query->first();
        
        if (!$laborer) {
            if ($fallbackToAjeerLaborers) {
                return $this->findAjeerLaborer($idNumber, $establishmentId);
            }
            
            throw new ModelNotFoundException;
        }
        
        $laborer->name        = $this->decodeString($laborer->name);
        $laborer->occupation  = $this->decodeString($laborer->occupation);
        $laborer->nationality = $this->decodeString($laborer->nationality);
        
        return $laborer;
    }
    
    /**
     * Get the laborer date.
     *
     * @param int $idNumber
     * @param int $establishmentId
     *
     * @return array
     */
    public function findAjeerLaborer($idNumber, $establishmentId = null)
    {
        $query = $this->db->table(new Expression('[MOL_Ajeer].[dbo].[MOL_ContractLaborer] [CL] WITH (NOLOCK)'))
            ->join(new Expression('[MOL_Ajeer].[dbo].[MOL_Contract] [C] WITH (NOLOCK)'), 'C.PK_ContractId', '=',
                'CL.FK_ContractId')
            ->join(new Expression('[MOL_Laborer] [L] WITH (NOLOCK)'), 'L.IdNo', '=', 'CL.IdNo')
            ->join(new Expression('[Lookup_Nationality] [N] WITH (NOLOCK)'), 'L.FK_NationalityId', '=', 'N.Id')
            ->join(new Expression('[Lookup_Job] [J] WITH (NOLOCK)'), 'L.FK_JobId', '=', 'J.Id')
            ->where('CL.IdNo', $idNumber)
            ->select([
                new Expression("CAST(ISNULL([L].[FirstName],'') + ' ' + ISNULL([L].[SecondName],'') + ' ' "
                    . "+ ISNULL([L].[ThirdName],'') + ' ' + ISNULL([L].[FourthName],'') AS VARBINARY(MAX)) AS [name]"),
                'L.IdNo AS id_number',
                new Expression('CAST([J].[Name] AS VARBINARY(MAX)) AS [occupation]'),
                new Expression('CAST([N].[Name] AS VARBINARY(MAX)) AS [nationality]'),
                'L.FK_NationalityId AS FK_nationality_id',
                'L.FK_JobId AS FK_occupation_id',
                'L.FK_EstablishmentId AS FK_establishment_id',
            ]);
        
        if ($establishmentId) {
            $query->where('L.FK_EstablishmentId', $establishmentId);
        }
        
        $laborer = $query->first();
        
        if (!$laborer) {
            throw new ModelNotFoundException;
        }
        
        $laborer->name        = $this->decodeString($laborer->name);
        $laborer->occupation  = $this->decodeString($laborer->occupation);
        $laborer->nationality = $this->decodeString($laborer->nationality);
        
        return $laborer;
    }
    
    /**
     * Get the current economic activities list.
     *
     * @return array
     */
    public function fetchActivities()
    {
        $activities = $this->db->table('Lookup_NewEconomicActivity AS NEA')
            ->select(['NEA.Id AS id', 'NEA.Name AS name'])
            ->get();
        
        
        return collect($activities)->transform(function ($activity) {
            $activity->name = iconv('CP1256', 'UTF-8', data_get($activity, 'name'));
            
            return $activity;
            
        })->lists('name', 'id');
    }
    
    /**
     * Get the jobs list.
     *
     * @param bool $withoutSaudisOnlyJobs
     *
     * @return Collection
     */
    public function fetchJobsLookup($withoutSaudisOnlyJobs = false)
    {
        $results = $this->db->table(new Expression('[dbo].[Lookup_Job] WITH (NOLOCK)'))
            ->select([
                'Id as id',
                new Expression('CAST(Name AS VARBINARY(MAX)) AS name'),
                'IsValidWPJob',
                'IsForSaudiOnly',
            ])
            ->where('Id', '>', 1000000)
            ->get();
        
        $jobs = collect($results)->keyBy('id');
        
        $jobs->transform(function ($job) {
            $job->name = $this->decodeString($job->name);
            
            return $job;
        });
        
        if ($withoutSaudisOnlyJobs) {
            $jobs = $jobs->whereLoose('IsForSaudiOnly', 0);
        }
        
        return $jobs;
    }
    
    /**
     * Get the nationality list.
     *
     * @return Collection
     */
    public function fetchNationalitiesLookup()
    {
        $nationalities = $this->cache->remember('mol.nationalities', Carbon::tomorrow(), function () {
            $results = $this->db->table(new Expression('[dbo].[Lookup_Nationality] WITH (NOLOCK)'))
                ->select([
                    'Id as id',
                    new Expression('CAST(Name AS VARBINARY(MAX)) AS name'),
                ])
                ->get();
            
            $nationalities = collect($results)->keyBy('id');
            
            $nationalities->transform(function ($nationality) {
                $nationality->name = $this->decodeString($nationality->name);
                
                return $nationality;
            });
            
            return $nationalities;
        });
        
        
        return $nationalities;
    }
    
    /**
     * @param string $string
     *
     * @return string
     */
    private function decodeString($string)
    {
        $hex = bin2hex($string);
        
        $decoded = '';
        
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $decoded .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }
        
        return iconv('UCS-2LE', 'UTF-8//TRANSLIT', $decoded);
    }
}
