<?php

namespace Tamkeen\Ajeer\Http\Controllers;

use Illuminate\Http\Request;

use Tamkeen\Ajeer\Http\Requests;
use Illuminate\Support\Facades\DB;
use Tamkeen\Ajeer\Jobs\Job;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\ContractLocation;
use Tamkeen\Ajeer\Models\Nationality;

class MigrationController extends Controller
{
    /**
     * @var
     */
    protected $oldConnection;
    protected $baseConnection;
    protected $oldEstablishmentId = NULL;
    protected $establishmentId;
    protected $establishmentsIndex = [];

    public function __construct()
    {
    	$this->oldConnection = \DB::connection('mysqlOld');
    	$this->baseConnection = \DB::connection('mysql');
        $this->establishmentId = session()->get('selected_establishment.FK_establishment_id');

        $oldEstablishment = $this->oldConnection->select('select * from `establishments` where FK_establishment_id='.$this->establishmentId);
        if (isset($oldEstablishment[0])) {
            $this->oldEstablishmentId = $oldEstablishment[0]->id;
        }
    }

    public function index()
    {
        $this->hr_pool();
        $this->hr_pool('temp_work_notices');
        $this->contracts();
        $this->contractEmployees();
        $this->contractEmployees('temp_work_notices');
        $this->invoices();
        $this->invoices('temp_work_notices');
        $this->invoicesIdForContractEmployees();
        $this->invoicesIdForContractEmployees('temp_work_notices');
        $this->invoiceBundles();
        
        /* // general setups
        $this->activities();
        $this->jobs();
        $this->nationalities();
        $this->ishaar_setup();
        $this->bundles();
        $this->users(); */

        return view('front.establishment.migration');
    }

    /*
     * Bundles Migration
     */
    public function bundles()
    {
        //select  premium_ranges table in old connection
        $premium_ranges = $this->oldConnection->table('premium_ranges')->get();
        if($premium_ranges){
            $inserts = [];
            foreach ($premium_ranges as $range){
                $inserts[] = ['id' => $range->id+1,
                                'min_of_num_ishaar' => $range->min_notices,
                                'max_of_num_ishaar' => $range->max_notices,
                                'monthly_amount' => $range->notice_price,
                                'status' => $range->status,
                                'created_by' => 0,
                                'created_at' => $range->created_at,
                                'updated_at' => $range->updated_at,
                                'deleted_at' => $range->deleted_at? $range->deleted_at : null];
            }
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $bundles = \DB::table('bundles')->insert($inserts);
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return $bundles;
        }
    }

    /*
     * Bundles invoiceBundles
     */
    public function invoiceBundles()
    {
        //select  premium_ranges table in old connection
        $subscriptions = $this->oldConnection->table('subscriptions')->where('establishment_id', $this->oldEstablishmentId)->get();
        if($subscriptions){
            $inserts = [];
            foreach ($subscriptions as $range){
                if ($range->is_trial) {
                    $bundle_id = 1;
                } else {
                    $bundle_id = $range->range_id + 1;
                }

                if ($range->expiry_at) {
                    $range->expiry_at = date('Y-m-d', strtotime($range->expiry_at));
                }
                
                $inserts[] = ['id' => $range->id,
                                'provider_id' => $this->establishmentId,
                                'provider_type' => 3,
                                'status' => $range->status,
                                'bundle_id' => $bundle_id,
                                'num_of_notices' => $range->amount,
                                'num_remaining_notices' => $range->remaining,
                                'expire_date' => $range->expiry_at,
                                'created_at' => $range->created_at,
                                'updated_at' => $range->updated_at,
                                'created_by' => 0];
            }
            
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $bundles = \DB::table('invoice_bundles')->insert($inserts);
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return $bundles;
        }
    }

    public function hr_pool($table = 'laborer_rental_notices')
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0');
    	$this->oldConnection
             ->table($table)
             ->select('laborer_id_number', 'laborer_name','FK_laborer_occupation_id','FK_laborer_nationality_id','deleted_at','created_at','updated_at','gender','birthday', 'provider_id', 'benef_id')
             ->where('provider_id', $this->oldEstablishmentId)
             ->orWhere('benef_id', $this->oldEstablishmentId)
             ->chunk(100, function($oldData) {
                foreach ($oldData as $data) {
                    if ($data->gender == '2') {
                        $data->gender = '0';
                    }

                    $existed = $this->baseConnection->table('hr_pool')->where('id_number', $data->laborer_id_number)->first();
                    if (!$existed) {
                        if ($this->oldEstablishmentId == $data->provider_id) {
                            $providerId = $this->establishmentId;
                        } else {
                            $providerId = $this->establishment($data->benef_id);
                        }

                        $this->baseConnection->table('hr_pool')->insert([
                            'provider_type'  => '3',
                            'provider_id'    => $providerId,
                            'id_number'      => $data->laborer_id_number,
                            'name'           => $data->laborer_name,
                            'job_id'         => $data->FK_laborer_occupation_id,
                            'nationality_id' => $data->FK_laborer_nationality_id,
                            'gender'         => $data->gender,
                            'birth_date'     => $data->birthday,
                            'deleted_at'     => $data->deleted_at,
                            'created_at'     => $data->created_at,
                            'updated_at'     => $data->updated_at,
                            'created_by'     => 1
                        ]);
                    }
                }
            });
    }

   public function ishaar_setup()
   {
   		DB::statement('SET FOREIGN_KEY_CHECKS=0');

   		/* Import free_notices_config table into ishaar setup */

   		$this->oldConnection
   			 ->table('free_notices_config')
   			 ->select('max_notices','notice_period','max_laborer_notices','created_at','updated_at','deleted_at','max_same_stakeholders_notices')
   			 ->chunk(100, function($oldData){
   			 	foreach($oldData as $data){
   			 		if($data->created_at == "0000-00-00 00:00:00"){
				    	$data->created_at = NULL;
				    }
   			 		$this->baseConnection
   			 			 ->table('ishaar_setup')
   			 			 ->insert([
						    'created_by' => 1,
						    'max_no_of_ishaars' => $data->max_notices,
						    'max_ishaar_period' => $data->notice_period,
						    'max_no_of_ishaar_labor' => $data->max_laborer_notices,
							'created_at' => $data->created_at,
							'updated_at' => $data->updated_at,
							'deleted_at' => $data->deleted_at,
							'labor_same_benef_max_num_of_ishaar' => $data->max_same_stakeholders_notices,
							'ishaar_type_id' => 5,
							'frequency' => 0,
							'name' => " ",
   			 			 ]);
   			 	}
   			 });

   		/* Import premium_notices_config table into ishaar setup */

   		$this->oldConnection
   			 ->table('premium_notices_config')
   			 ->select('bundle_valid_period','bundle_valid_pay_period','notice_max_period','max_laborer_notices','created_at','updated_at','deleted_at','trial_balance','max_same_stakeholders_notices')
   			 ->chunk(100, function($oldData){
   			 	foreach($oldData as $data){
   			 		if($data->created_at == "0000-00-00 00:00:00"){
				    	$data->created_at = NULL;
				    }
   			 		$this->baseConnection
   			 			 ->table('ishaar_setup')
   			 			 ->insert([
						    'created_by'=> 1,
						    'paid_ishaar_valid_expiry_period'=> $data->bundle_valid_period,
						    'paid_ishaar_payment_expiry_period'=> $data->bundle_valid_pay_period,
						    'max_ishaar_period'=> $data->notice_max_period,
						    'max_no_of_ishaar_labor'=> $data->max_laborer_notices,
							'created_at'=> $data->created_at,
							'updated_at'=> $data->updated_at,
							'deleted_at'=> $data->deleted_at,
							'trial_ishaar_num'=> $data->trial_balance,
							'labor_same_benef_max_num_of_ishaar'=> $data->max_same_stakeholders_notices,
							'ishaar_type_id' => 6,
							'frequency' => 0,
							'name' => " ",
   			 			 ]);
   			 	}
   			 });

   		 /* Import leasing_notices_config table into ishaar setup */

	   	$this->oldConnection
	   			->table('leasing_notices_config')
	   			->select('notice_min_period','notice_max_period','notice_price','notice_valid_pay_period','created_at','updated_at','deleted_at')
	   			->chunk(100, function($oldData){
	   			 foreach($oldData as $data){
	   			 	if($data->created_at == "0000-00-00 00:00:00"){
					    $data->created_at = NULL;
					}
	   			 	$this->baseConnection
	   			 			->table('ishaar_setup')
	   			 			->insert([
                                'created_by'=> 1,
                                'min_ishaar_period'=> $data->notice_min_period,
                                'max_ishaar_period'=> $data->notice_max_period,
                                'amount'=> $data->notice_price,
                                'payment_period'=> $data->notice_valid_pay_period,
                                'created_at'=> $data->created_at,
                                'updated_at'=> $data->updated_at,
                                'deleted_at'=> $data->deleted_at,
                                'ishaar_type_id' => 3,
                                'frequency' => 0,
                                'name' => " ",
	   			 			]);
	   			 }
	   			});
   }

    /**
     * Contract Employees import from old table and insert into the new one
     *
     * @return bool $inserted
     */
    public function contractEmployees($oldTable = 'laborer_rental_notices')
    {
        $status = [
            1 => "pending",
            2 => "pending",
            3 => "approved",
            4 => "cancelled",
            5 => "approved",
        ];

        /** @var $newTable */
        $newTable = 'contract_employees';

        $tableColumnsValues = [];

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->oldConnection
             ->table($oldTable)
             ->where('provider_id', $this->oldEstablishmentId)
             ->orWhere('benef_id', $this->oldEstablishmentId)
             ->chunk(100, function($workNotices) use ($status, $oldTable, $newTable) {
                $tableColumnsValues = [];

                foreach ($workNotices as $workNotice) {
                    $hr_pool = $this->baseConnection->table('hr_pool')->where('id_number', $workNotice->laborer_id_number)->first();
                    if ($hr_pool) {
                        if ($oldTable == 'laborer_rental_notices') {
                            $deleted_at = (isset($workNotice->deleted_at)) ? $workNotice->deleted_at : null;
                            if ($this->oldEstablishmentId == $workNotice->benef_id) {
                                $benef_id = $this->establishmentId;
                                $provider_id = $this->establishment($workNotice->provider_id);
                            } else {
                                $provider_id = $this->establishmentId;
                                $benef_id = $this->establishment($workNotice->benef_id);
                            }

                            $contract = Contract::create([
                                'contract_type_id' => 4,
                                'contract_desc' => '',
                                'start_date' => $workNotice->issue_date,
                                'end_date' => $workNotice->expiry_date,
                                'contract_locations' => '',
                                'deleted_at' => $deleted_at,
                                'created_at' => $workNotice->created_at,
                                'updated_at' => $workNotice->updated_at,
                                'provider_type' => 3,
                                'provider_id' => $provider_id,
                                'benf_type' => 3,
                                'benf_id' => $benef_id,
                                'contract_name' => ' ',
                                'created_by' => 0,
                                'vacancy_id' => 0,
                            ]);

                            $workNotice->contract_id = $contract->id;
                        }

                        $tableColumnsValues[] = [
                            'id'          => $workNotice->id,
                            'contract_id' => $workNotice->contract_id,
                            'id_number'   => $hr_pool->id,
                            'start_date'  => $workNotice->issue_date,
                            'end_date'    => $workNotice->expiry_date,
                            'status'      => $status[$workNotice->status],
                            'created_at'  => $workNotice->created_at,
                            'updated_at'  => $workNotice->updated_at,
                            'deleted_at'  => $workNotice->deleted_at,
                        ];
                    }
                }

                \DB::table($newTable)->insert($tableColumnsValues);
            });
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return true;
    }

    /**
     * Import the activities from the old table and insert to the new one
     *
     * @return bool $inserted
     */
    public function activities()
    {
        /** @var  $oldTable */
        $oldTable = 'mol_activities';

        /** @var $newTable */
        $newTable = 'activities';


        $oldActivities = $this
            ->oldConnection
            ->table($oldTable)
            ->get();


        foreach ($oldActivities as $oldActivity) {
            $tableColumnsValues[] = [
                'name'       => $oldActivity->job_name,
                'created_at' => $oldActivity->created_at,
                'updated_at' => $oldActivity->updated_at,
                'deleted_at' => $oldActivity->deleted_at,
            ];
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $inserted = \DB::table($newTable)->insert($tableColumnsValues);

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return $inserted;
    }

    public function jobs()
    {
        $oldTableName = 'mol_jobs_lookup';
        $newTableName = 'ad_jobs';

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $oldJobs = $this
            ->oldConnection
            ->table($oldTableName)
            ->chunk(100, function($oldJobs) use($newTableName) {
                $tableColumnsValues = [];
                foreach ($oldJobs as $oldJob) {
                    $tableColumnsValues[] = [
                        'id'         => $oldJob->id,
                        'job_name'   => $oldJob->name,
                        'created_by' => 1,
                    ];
                }

                \DB::table($newTableName)->insert($tableColumnsValues);
            });

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return true;
    }

    public function users($limit = 100, $offset = 0)
    {
        $oldTableName = 'users';
        $newTableName = 'users';

        $oldUsers = $this
            ->oldConnection
            ->table($oldTableName)
            ->limit($limit)
            ->offset($offset)
            ->get();
        if ($oldUsers) {
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            foreach ($oldUsers as $oldUser) {
                $insertedInd = NULL;

                // ajeer = 1
                if ($oldUser->ajeer == 1) {
                    $oldUser->user_type_id = 3;
                } // mol = 1
                elseif ($oldUser->mol == 1) {
                    $oldUser->password = '';
                    $oldUser->user_type_id = 3;
                } // nic = 1 => INDIVIDUAL
                elseif ($oldUser->nic == 1) {
                    // is saudi
                    if (intval(substr($oldUser->id_number, 0, 1)) == 1) {
                        $oldUser->user_type_id = 4;
                    } // is job seeker
                    else {
                        $oldUser->user_type_id = 5;
                    }

                    $indRecord = [
                        'user_type_id' => $oldUser->user_type_id,
                        'name'         => $oldUser->name,
                        'email'        => $oldUser->email,
                        'phone'        => $oldUser->mobile,
                        'gender'       => '1',
                        'religion'     => '2',
                        'nid'          => $oldUser->id_number,
                        'created_by'   => '1',
                    ];

                    $insertedInd = \DB::table('indviduals')->insertGetId($indRecord);
                }

                $tableColumnsValues[] = [
                    'national_id'    => $oldUser->id_number,
                    'name'           => $oldUser->name,
                    'email'          => $oldUser->email,
                    'password'       => $oldUser->password,
                    'active'         => $oldUser->active,
                    'remember_token' => $oldUser->remember_token,
                    'deleted_at'     => $oldUser->deleted_at,
                    'created_at'     => $oldUser->created_at,
                    'updated_at'     => $oldUser->updated_at,
                    'user_type_id'   => $oldUser->user_type_id,
                    'created_by'     => 1,
                    'id_no'          => $insertedInd
                ];
            }

            $inserted = \DB::table($newTableName)->insert($tableColumnsValues);

            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        return true;
    }

    public function contractLocationByContractID($contractID = '')
    {
        $oldLocations = $this->oldConnection->select('select * from `locations` where `Contract_id`="' . $contractID . '"');
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($oldLocations as $location) {
            $oldLocationsMigrated = ContractLocation::find($location->id);
            if (!$oldLocationsMigrated) {
                ContractLocation::create([
                    'id' => $location->id,
                    'contract_id' => $location->contract_id,
                    'branch_id' => 1,
                    'desc_location' => $location->address,
                    'created_at' => $location->created_at,
                    'created_by' => 1,
                    'updated_at' => $location->updated_at,
                    'deleted_at' => $location->deleted_at,
                ]);
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return;
    }

    public function nationalities()
    {
        $oldNationalities = $this->oldConnection->select('select distinct(FK_laborer_nationality_id) as FK_laborer_nationality_id,laborer_nationality from `temp_work_notices`');
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($oldNationalities as $nationality) {
            $oldNationalitiesMigrated = Nationality::find($nationality->FK_laborer_nationality_id);
            if (!$oldNationalitiesMigrated) {
                Nationality::create([
                    'id' => $nationality->FK_laborer_nationality_id,
                    'name' => $nationality->laborer_nationality,
                    'created_by' => 1
                ]);
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return true;
    }

    public function establishment($id)
    {
        if (isset($this->establishmentsIndex[$id])) {
            return $this->establishmentsIndex[$id];
        }
        
        $oldEstablishment = $this->oldConnection->select('SELECT `establishments`.*,establishment_details.main_economic_activity,establishment_details.MunicipalLicenseNumber,establishment_details.District,establishment_details.WASELArea,establishment_details.sizeName,establishment_details.colorName_current,establishment_details.WASELCity FROM `establishments` left outer JOIN `establishment_details` ON `establishments`.`FK_establishment_id` = `establishment_details`.`FK_establishment_id` where establishments.id='.$id);
        if (isset($oldEstablishment[0])) {
            $existed = $this->baseConnection->select('SELECT * FROM `establishments` where FK_establishment_id='.$oldEstablishment[0]->FK_establishment_id);
            if ($existed) {
                return $existed[0]->id;
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            $estSizes = array(
                'ضئيل' 	=> '1',
                'صغير' 	=> '2',
                'متوسط' => '3',
                'كبير' 	=> '4',
                'ضخم' 	=> '5'
            );

            $data = [
                'FK_establishment_id' => $oldEstablishment[0]->FK_establishment_id,
                'activity_id'         => $oldEstablishment[0]->FK_economic_activity_id,
                'labour_office_no'    => $oldEstablishment[0]->labor_office_id,
                'sequence_no'         => $oldEstablishment[0]->sequence_number,
                'name'                => $oldEstablishment[0]->name,
                'phone'               => isset($oldEstablishment[0]->mobile) ? $oldEstablishment[0]->mobile : '0',
                'email'               => isset($oldEstablishment[0]->email) ? $oldEstablishment[0]->email : '',
                'created_at'          => $oldEstablishment[0]->created_at,
                'updated_at'          => $oldEstablishment[0]->updated_at,
                'deleted_at'          => $oldEstablishment[0]->deleted_at,
                'local_liecense_no'   =>$oldEstablishment[0]->MunicipalLicenseNumber,
                'district'            => $oldEstablishment[0]->District,
                'region'              => $oldEstablishment[0]->WASELArea,
                'est_size'            => isset($estSizes[$oldEstablishment[0]->sizeName]) ? $estSizes[$oldEstablishment[0]->sizeName] : '',
                'est_nitaq'           => $oldEstablishment[0]->colorName_current,
                'est_nitaq_old'       => $oldEstablishment[0]->colorName_current,
                'city'                => $oldEstablishment[0]->WASELCity,
                'est_activity'        => $oldEstablishment[0]->main_economic_activity,
                'status'              => '1'
            ];

            $establishmentId = \DB::table('establishments')->insertGetId($data);

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            $this->establishmentsIndex[$id] = $establishmentId;

            return $establishmentId;
        }
    }


     /*
     *  invoice
     */
    public function invoices($table = 'laborer_rental_notices')
    {
        if ($table == "temp_work_notices") {
            $billable_type = "Tamkeen\Ajeer\Models\TempWorkNotice";
            $invoice_type = 0;
        } else {
            $billable_type = "Tamkeen\Ajeer\Models\LeasingNotice";
            $invoice_type = 3;
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //select  premium_ranges table in old connection
        $this->oldConnection->table('billables')->where('billable_type',$billable_type)
            ->join($table, function ($join) use($table) {
                $join->on('billables.billable_id', '=', $table.'.id')
                 ->where($table.'.provider_id', '=', $this->oldEstablishmentId);
                })
            ->join('bills', 'billables.bill_id', '=', 'bills.id')
            ->select([DB::RAW('DISTINCT(bills.id) as billID'),'bills.bill_number','bills.amount','bills.account_number','bills.status','bills.issue_date','bills.expiry_date','bills.created_at','bills.updated_at'])
            ->chunk(100, function($bills) use($invoice_type) {
                $inserts = [];
                foreach ($bills as $range){
                    $inserts[] = [  'id' => $range->billID,
                                    'bill_number' => $range->bill_number,
                                    'amount' => $range->amount,
                                    'account_no' => $range->account_number,
                                    'status' => $range->status,
                                    'benf_name' => '',
                                    'provider_id' => $this->establishmentId,
                                    'provider_type' => 3,
                                    'invoice_type' => $invoice_type,
                                    'issue_date' => $range->issue_date,
                                    'paid_date' => $range->issue_date,
                                    'expiry_date' => $range->expiry_date,
                                    'created_at' => $range->created_at,
                                    'updated_at' => $range->updated_at,
                                    'created_by' => 0];
                }

                \DB::table('invoices')->insert($inserts);
            });
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return true;
    }

    public function contracts()
    {
        $establishments = $this->oldConnection
            ->select("select * from `temp_work_notices` where `provider_id`= '" . $this->oldEstablishmentId . "' or `benef_id`='" . $this->oldEstablishmentId . "'");
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($establishments as $establishment) {
            $contract = $this->oldConnection->select("select * from `contracts` where `id`='" . $establishment->contract_id . "'");
            if ($this->oldEstablishmentId == $establishment->benef_id) {
                $benef_id = $this->establishmentId;
                $provider_id = $this->establishment($establishment->provider_id);
            } else {
                $provider_id = $this->establishmentId;
                $benef_id = $this->establishment($establishment->benef_id);
            }

            $contract = (count($contract) > 0) ? $contract[0] : $contract;
            $oldMigratedContract = Contract::find($establishment->contract_id);
            if (!$oldMigratedContract && $contract) {
                $contractDateEnded = (isset($contract->start_date)) ? date_format(date_add(date_create($contract->start_date),
                    date_interval_create_from_date_string($contract->duration . " days")), 'Y-m-d') : null;
                $deleted_at = (isset($contract->deleted_at)) ? $contract->deleted_at : null;
                $contractToMigrate = Contract::create([
                    'id' => $contract->id,
                    'contract_type_id' => $contract->type,
                    'contract_desc' => $contract->description,
                    'start_date' => $contract->start_date,
                    'end_date' => $contractDateEnded,
                    'contract_locations' => $contract->location,
                    'deleted_at' => $deleted_at,
                    'created_at' => $contract->created_at,
                    'updated_at' => $contract->updated_at,
                    'provider_type' => 3,
                    'provider_id' => $provider_id,
                    'benf_type' => 3,
                    'benf_id' => $benef_id,
                    'contract_name' => ' ',
                    'created_by' => 0,
                    'vacancy_id' => 0,
                ]);
                $this->contractLocationByContractID($contract->id);
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return true;
    }

    public function invoicesIdForContractEmployees($table = 'laborer_rental_notices')
    {
        if ($table == "temp_work_notices") {
            $billable_type = "Tamkeen\Ajeer\Models\TempWorkNotice";
        } else {
            $billable_type = "Tamkeen\Ajeer\Models\LeasingNotice";
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $this->oldConnection->table('billables')
            ->select('bill_id', 'billable_id')
            ->where('billable_type',$billable_type)
            ->join($table, function ($join) use($table) {
                $join->on('billables.billable_id', '=', $table.'.id')
                    ->where($table.'.provider_id', '=', $this->oldEstablishmentId);
                })
            ->chunk(100, function($billables) {
                foreach ($billables as $bill) {
                    \DB::table('contract_employees')->where('id', $bill->billable_id)->update(['ishaar_id' => '4', 'invoices_id' => $bill->bill_id]);
                }
            });
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return true;
    }
}