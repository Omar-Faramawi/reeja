<?php
namespace Tamkeen\Ajeer\Services\MOL;

use Illuminate\Database\Connection;
use Illuminate\Database\Query\Expression;
use Tamkeen\Ajeer\Services\MOL\Exceptions\LaborerNotFound;

class MolMsSqlServices implements MolServices
{
    protected $db;

    public function __construct(Connection $connection)
    {
        $this->db = $connection;
    }

    /**
     * get laborer data from MOL database
     *
     * @param $idNumber
     * @param $labor_office
     * @param $sequence_number
     * @return object
     * @throws LaborerNotFound
     */
    public function getLaborerData($idNumber, $labor_office, $sequence_number)
    {
        $laborer = $this->db->table(new Expression('[MOL_Laborer] [L] WITH (NOLOCK)'))
            ->join(new Expression('[Lookup_Nationality] [N] WITH (NOLOCK)'), 'L.FK_NationalityId', '=', 'N.Id')
            ->join(new Expression('[Lookup_Job] [J] WITH (NOLOCK)'), 'L.FK_JobId', '=', 'J.Id')
            ->join(new Expression('[Lookup_EducationalStatus] [ES] WITH (NOLOCK)'), 'L.FK_EducationalStatusId', '=', 'ES.Id')
            ->join(new Expression('[Lookup_Qualification] [Q] WITH (NOLOCK)'), 'L.FK_QualificationId', '=', 'Q.Id')
            ->where('L.IdNo', "$idNumber")
            ->where('l.FK_SaudiFlagId', 2)
            ->where('FK_CurrentLaborOfficeId', $labor_office)
            ->where('EstablishmentSequenceNumber', $sequence_number)
            ->whereIn('L.FK_AccomodationStatusId', [1, 4])
            ->whereNotIn('L.FK_LaborerStatusId', [3, 4, 5, 6, 7])
            ->select([
                new Expression("CAST(ISNULL([L].[FirstName],'') + ' ' + ISNULL([L].[SecondName],'') + ' ' "
                    . "+ ISNULL([L].[ThirdName],'') + ' ' + ISNULL([L].[FourthName],'') AS VARBINARY(MAX)) AS [name]"),
                'L.IdNo AS id_number',
                new Expression('CAST([J].[Name] AS VARBINARY(MAX)) AS [job]'),
                new Expression('CAST([N].[Name] AS VARBINARY(MAX)) AS [nationality]'),
                'L.FK_NationalityId AS nationality_id',
                'L.FK_JobId AS job_id',
                'L.FK_EstablishmentId AS FK_establishment_id',
                'L.YearOfBirth AS birth_year',
                'L.FK_GenderId AS gender',
                'L.FK_ReligionId AS religion',
                'L.KingdomEntryDate AS entry_date',
                new Expression('CAST([ES].[Name] AS VARBINARY(MAX)) AS [educational_status]'),
                new Expression('CAST([Q].[Name] AS VARBINARY(MAX)) AS [qualification]'),
                'L.FK_EducationalStatusId AS educational_status_id',
                'L.FK_QualificationId AS qualification_id',
            ])->first();

        if (!$laborer) {
            throw new LaborerNotFound;
        }

        $laborer->name               = $this->decodeString($laborer->name);
        $laborer->job                = $this->decodeString($laborer->job);
        $laborer->nationality        = $this->decodeString($laborer->nationality);
        $laborer->educational_status = $this->decodeString($laborer->educational_status);
        $laborer->qualification      = $this->decodeString($laborer->qualification);

        if ($laborer->religion != 1)
        {
            $laborer->religion = 2;
        }

        if ($laborer->qualification_id == 0) {
            $laborer->qualification_id = 99;
            $laborer->qualification = 'لا يوجد';
        }

        return $laborer;
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
            $decoded .= chr(hexdec($hex[ $i ] . $hex[ $i + 1 ]));
        }

        return iconv('UCS-2LE', 'UTF-8//TRANSLIT', $decoded);
    }
}