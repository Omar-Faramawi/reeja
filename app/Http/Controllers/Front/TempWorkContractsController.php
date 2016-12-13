<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\ReceivedContractRequest;
use Tamkeen\Ajeer\Http\Requests\SendVacancyOfferRequest;
use Tamkeen\Ajeer\Http\Requests\TempWorkContractRequest;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Models\ContractLocation;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Models\User;
use Tamkeen\Ajeer\Models\Vacancy;
use Tamkeen\Ajeer\Utilities\Constants;

/**
 * Class ReceivedContractsController
 * @package Tamkeen\Ajeer\Http\Controllers\Front
 */
class TempWorkContractsController extends Controller
{


	/**
	 * @param string $id
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index($id = '')
	{
		$contractTypeId = Constants::CONTRACTTYPES['hire_labor'];
		$isProvider = TRUE;

		if ($id) {
			if (in_array($id, Constants::SERVICETYPES)) {
				session()->replace(['service_type' => $id]);    // save to session
			}
		} elseif (session()->get('service_type')) {
			$id = session()->get('service_type');
		} else {
			$id = Constants::SERVICETYPES['provider'];
			session()->replace(['service_type' => $id]);
		}


		if (Constants::SERVICETYPES['provider'] == $id) {
			$myContracts = Contract::byMe()->getByContractType($contractTypeId)
			                       ->latest()->paginate(20);
		} else {
			$isProvider = FALSE;
			$myContracts = Contract::toMe()->getByContractType($contractTypeId)
			                       ->latest()->paginate(20);
		}

		return view('front.labor_market.temp.list', compact('contractTypeId', 'myContracts', 'isProvider'));
	}


	/**
	 * @param $id
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View Edit the resource
	 *
	 * Edit the resource
	 */
	public function edit($id)
	{
		$contractTypeId = Constants::CONTRACTTYPES['hire_labor'];

		$contract = Contract::byMe()->getByContractType($contractTypeId)
		                    ->with('vacancy.job', 'vacancy.nationality', 'contractLocations')
		                    ->findOrFail($id);

		if( $contract->status == Constants::CONTRACT_STATUSES['approved'] ) {
		    $readonly = ['disabled' => true];
		} else {
		    $readonly = [];
		}

                $jobs = $nationalities = [];
                if (!empty($contract->vacancy)) {
                    $jobs          = Job::pluck('job_name', 'id')->toArray();
                    $nationalities = Nationality::pluck('name', 'id')->toArray();
                }
		$regions       = Region::pluck('name', 'id')->toArray();

		return view('front.labor_market.temp.edit', compact(
			'contract', 'jobs', 'nationalities', 'regions', 'readonly'));
	}


	/**
     * @param $id
     *
     * @return mixed
     *
     * Show the received contract here
     */
    public function show($id = null)
    {
		$occasionalWork = FALSE;
        if (request()->route()->getPrefix() === '/occasional-work') {
            $occasionalWork = TRUE;
        }

        $regions       = Region::pluck('name', 'id')->toArray();
        $nationalities = Nationality::pluck('name', 'id')->toArray();
        $jobs          = Job::pluck('job_name', 'id')->toArray();
       
        list($user_id, $user_name ) = getCurrentUserNameAndId();

        if ( ! empty($id)) {

            try {

                if (session()->get('service_type') === Constants::SERVICETYPES['provider']) {
                    $vacancy = Vacancy::with('job', 'region', 'nationality', 'locations')->findOrFail($id);
                } else {
                    // if the user is beneficial
                    $vacancy = HRPool::with('job', 'region', 'nationality', 'locations')->findOrFail($id);
                }

                if (request()->route()->getPrefix() === '/occasional-work') {
                    $vacancy->where('religion', Constants::RELIGION['muslim']);
                }

                return view('front.labor_market.offer_contract.show',
                    compact('regions', 'nationalities', 'jobs', 'vacancy', 'contracts', 'user_id',
                        'user_name','occasionalWork'))->with('vacancy_id', $id);

            } catch (\Exception $e) {
                abort(404);
            }
        }

        $mycontracts = Contract::byMe()->hireLabor()->with('vacancy.job', 'vacancy.region', 'vacancy.nationality')->requested()->orderBy('id', 'desc')->get();

        return view('front.labor_market.offer_contract.show',
            compact('regions', 'nationalities', 'jobs', 'contracts', 'vacancies', 'mycontracts', 'provider_id',
                'provider_name', 'vacancy','occasionalWork'));
    }


	/**
	 * @param ReceivedContractRequest $request
	 *
	 * @return string|\Symfony\Component\Translation\TranslatorInterface
	 */
	public function update(ReceivedContractRequest $request)
	{
		$data = array_except(
			array_merge(
				$request->only(array_keys($request->rules())),
				['contract_type_id' => Constants::CONTRACTTYPES['hire_labor']]
			),
			['region_id', 'status', 'job_id', 'ids']
		);
		$data['status'] = Constants::CONTRACT_STATUSES['pending'];
		$data['job_type'] = $request->job_type_id;
		$contract = Contract::byMe()->hireLabor()->requested()->findOrFail($request->contract_id);

		// Save contract locations
		if( isset($request->region_id) ) {
			foreach ($request->region_id as $region) {
				$contract->contractLocations()->save(new ContractLocation([
					'branch_id'     => session()->get('selected_establishment.branch_no') ?: 1,
					'region_id'     => $region,
                    'desc_location' => $request->contract_locations
				]));
			}
		}

		$contractEmployees = [];
		$data['contract_amount'] = 0;

		foreach ($request->ids as $k => $id) {
			if( $request->hasFile("fileupload_". $id) ) {
				$uploadedFile = customUploadFile("fileupload_".$id, "tempWork");
			} else {
				$uploadedFile = null;
			}
			if( $request->salary[$k] ) {
				$salary = $request->salary[$k];
				$data['contract_amount']+= $salary;
			} else {
				$salary = 0;
			}

			$employee = ContractEmployee::where(['contract_id' => $contract->id, 'id_number' => $id])->first();
			if ($employee) {
				$employee->start_date             = $contract->start_date;
				$employee->end_date               = $contract->end_date;
				$employee->salary                 = $salary;
				$employee->qualification_upload   = $uploadedFile;
				$employee->save();
			} else {
				$employee                         = new ContractEmployee();
				$employee->contract_id            = $contract->id;
				$employee->id_number              = $id;
				$employee->start_date             = $contract->start_date;
				$employee->end_date               = $contract->end_date;
				$employee->ishaar_id              = Constants::CONTRACTTYPES['hire_labor'];
				$employee->salary                 = $salary;
				$employee->qualification_upload   = $uploadedFile;
				$employee->save();
			}
			$contractEmployees[] = $employee->id;
		}
		ContractEmployee::where('contract_id',$contract->id)->whereNotIn('id', $contractEmployees)->delete();
		$contract->update($data);

		return trans('temp_job.updated');
	}


    /**
     * @param TempWorkContractRequest $request
     *
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function updateTempWork(TempWorkContractRequest $request)
    {
        $contract = Contract::byMe()->hireLabor()->editable()->findOrFail($request->contract_id);

        $data = array_except(
            array_merge(
                $request->only(array_keys($request->rules())),
                ['contract_type_id' => Constants::CONTRACTTYPES['hire_labor']]
            ),
            ['region_id', 'status', 'job_id', 'ids']
        );

        if ($contract->status == Constants::CONTRACT_STATUSES['approved']) {
            $data = [];
        }

        $data['status'] = Constants::CONTRACT_STATUSES['pending'];
        
        if ($request->hasFile('contract_file')) {
            $data['contract_file'] = customUploadFile('contract_file', 'TempWork');
        } else {
            unset($data['contract_file']);
        }

        // Save contract locations
        if( isset($request->region_id) ) {
            $contractLocation = ContractLocation::where(['contract_id' => $contract->id])->first();
            $contractLocation->update([
                'branch_id'     => session()->get('selected_establishment.branch_no') ?: 1,
                'region_id'     => $request->region_id[0],
                'desc_location' => $request->contract_locations
            ]);
        }

        if ($contract->status != Constants::CONTRACT_STATUSES['approved']) {
            $contractEmployees = [];
            $data['contract_amount'] = 0;

            foreach ($request->ids as $k => $id) {
                if( $request->hasFile("fileupload_". $id) ) {
                    $uploadedFile = customUploadFile("fileupload_".$id, "tempWork");
                } else {
                    $uploadedFile = null;
                }

                $salary = 0;
                if( isset($request->salary[$k]) ) {
                    if( $request->salary[$k] ) {
                        $salary = $request->salary[ $k ];
                        $data['contract_amount'] += $salary;
                    }
                }

                $employee = ContractEmployee::where(['contract_id' => $contract->id, 'id_number' => $id])->first();
                if ($employee) {
                    $employee->start_date               = $contract->start_date;
                    $employee->end_date                 = $contract->end_date;
                    $employee->salary                   = $salary;
                    if ($uploadedFile) {
                        $employee->qualification_upload = $uploadedFile;
                    }
                } else {
                    $employee                           = new ContractEmployee();
                    $employee->contract_id              = $contract->id;
                    $employee->id_number                = $id;
                    $employee->start_date               = $contract->start_date;
                    $employee->end_date                 = $contract->end_date;
                    $employee->ishaar_id                = Constants::CONTRACTTYPES['hire_labor'];
                    $employee->salary                   = $salary;
                    if ($uploadedFile) {
                        $employee->qualification_upload = $uploadedFile;
                    }  
                }
                $employee->save();
                $contractEmployees[] = $employee->id;
            }
            ContractEmployee::where('contract_id',$contract->id)->whereNotIn('id', $contractEmployees)->delete();
        }
        $contract->update($data);

        return trans('temp_job.updated');
    }

    /**
     * @param SendVacancyOfferRequest $request
     *
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function sendVacancyOffer(SendVacancyOfferRequest $request)
    {
        $vacancy = Vacancy::with('job')->findOrFail($request->vacancy_id);

        $data = array_except(
            array_merge(
                $request->only(array_keys($request->rules())),
                ['contract_type_id' => Constants::CONTRACTTYPES['hire_labor']],
                ['vacancy_id' => $request->vacancy_id]
            ),
            ['region_id', 'status', 'job_id', 'ids', 'contract_file']
        );

        // Calculate contract amount
        $data['contract_amount'] = 0;
        foreach ($request->salary as $salary) {
            if ($salary) {
                $data['contract_amount']+= $salary;
            }
        }
        $data['status'] = Constants::CONTRACT_STATUSES['pending'];

        if( $request->hasFile("contract_file") ) {
            $data['contract_file']  = customUploadFile("contract_file", "tempWork");
        }

        $contract = Contract::create($data);

        // send notify email to beneficial
        \Mail::send('emails.send_vacancy_offer',['vacancy' => $vacancy->job->job_name, 'contractId' => $contract->id], function ($message) use ($contract) {
            $message->from(config('mail.from.address'))
                    ->to($contract->responsible_email)
                    ->subject(trans('email.subject_send_offer'));
        });

        // Save contract locations
        if( isset($request->region_id) ) {
            foreach ($request->region_id as $region) {
                $contract->contractLocations()->save(new ContractLocation([
                    'branch_id'     => session()->get('selected_establishment.branch_no') ?: 1,
                    'region_id'     => $region,
                    'desc_location' => $request->contract_locations
                ]));
            }
        }

        foreach ($request->ids as $k => $id) {
            if( $request->hasFile("fileupload_". $id) ) {
                $uploadedFile = customUploadFile("fileupload_".$id, "tempWork");
            } else {
                $uploadedFile = null;
            }

            if ($request->salary[$k]) {
                $salary = $request->salary[$k];
            } else {
                $salary = 0;
            }

            $employee                         = new ContractEmployee();
            $employee->contract_id            = $contract->id;
            $employee->id_number              = $id;
            $employee->salary                 = $salary;
            $employee->start_date             = $contract->start_date;
            $employee->end_date               = $contract->end_date;
            $employee->ishaar_id              = Constants::CONTRACTTYPES['hire_labor'];;
            $employee->qualification_upload   = $uploadedFile;
            $employee->save();
        }

        return trans('temp_job.added');
    }

    /**
     * Show received Contract
     *
     * @param $contract_id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showReceivedContract($contract_id)
    {
        try {
            $contract = Contract::byMe()->hireLabor()->with('contractEmployee','contractEmployee.hrPool','contractEmployee.hrPool.job', 'contractEmployee.hrPool.nationality','contractEmployee.hrPool.region')->requested()->findOrFail($contract_id);

            list($user_id, $user_name) = getCurrentUserNameAndId();
            $regions       = Region::pluck('name', 'id')->toArray();
            $nationalities = Nationality::pluck('name', 'id')->toArray();
            $jobs          = Job::pluck('job_name', 'id')->toArray();

            return view('front.labor_market.offer_contract.show_recieved_contracts', compact('regions', 'nationalities', 'jobs', 'contract','user_id','user_name','contract_id'));

        } catch (ModelNotFoundException $e) {
        }
    }

    public function refuseReceivedContract($contract_id)
    {
        try {
            Contract::byMe()->findOrFail($contract_id)->update(['status' => 'rejected']);

            return trans('temp_job.refused');

        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }
}
