<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Models\ContractLocation;
use Tamkeen\Ajeer\Models\Reason;
use Tamkeen\Ajeer\Utilities\Constants;
use Tamkeen\Ajeer\Http\Requests\ReceivedContractRequest;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\ContractEdit;

class DirectHiringContractsController extends Controller
{

    /**
     * List all the current index for the contract
     *
     * @param null $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id = null)
    {
        $isProvider = TRUE;
        $userType = \Auth::user()->user_type_id;
        if (!$id && $userType != Constants::USERTYPES['saudi'] && $userType != Constants::USERTYPES['job_seeker']) {
            $id = Constants::SERVICETYPES['benf'];
        }

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
            $myContracts = Contract::byMe()->getByContractType(Constants::CONTRACTTYPES['direct_emp'])
                 ->with(['contractEdits' => function($q) {
                            $q->where('status', Constants::CONTRACT_STATUSES['pending']);
                        }])
                                   ->latest()->paginate(20);
        } else {
            $isProvider = FALSE;
            $myContracts = Contract::toMe()->getByContractType(Constants::CONTRACTTYPES['direct_emp'])
                 ->with(['contractEdits' => function($q) {
                            $q->where('status', Constants::CONTRACT_STATUSES['pending']);
                        }])
                                   ->latest()->paginate(20);
        }

        return view('front.labor_market.direct_contract.index', compact('contractTypeId', 'myContracts', 'isProvider'));

    }


    /**
     * Show the direct contract to apply for offer
     *
     * @param $contract_id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($contract_id)
    {
        try {
            $contract = Contract::toMe()->directEmployee()->with('vacancy', 'vacancy.locations','contractEmployee','contractEmployee.hrPool','contractEmployee.hrPool.job', 'contractEmployee.hrPool.nationality','contractEmployee.hrPool.region')->requested()->findOrFail($contract_id);
            $jobSeeker = $contract->contractEmployee[0]->hrPool;
            $regions = Region::pluck('name', 'id')->toArray();

            return view('front.labor_market.direct_contract.show_recieved_contracts', compact('regions', 'contract', 'contract_id', 'jobSeeker'));
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    /**
     * Send offer to employee
     * @param $employeeId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendOfferToEmployee($employeeId)
    {
        try {
            list($userId, $username) = getCurrentUserNameAndId();

            $employee = HRPool::jobseeker()->byOthers()->checked()->with('region', 'nationality', 'job')->findOrFail($employeeId);
            $regions = Region::pluck('name', 'id')->toArray();

            return view('front.labor_market.direct_contract.send_offer_to_employee', compact('userId', 'username', 'regions', 'employeeId', 'employee'));
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    /**
     * Received Contracts Page
     *
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function receivedContracts()
    {
        $regions       = Region::pluck('name', 'id')->toArray();
        $nationalities = Nationality::pluck('name', 'id')->toArray();
        $jobs          = Job::pluck('job_name', 'id')->toArray();

        $mycontracts = Contract::toMe()->directEmployee()->with('vacancy.job', 'vacancy.region', 'vacancy.nationality')->requested()->orderBy('id', 'desc')->get();

        return view('front.labor_market.direct_contract.show',
            compact('regions', 'nationalities', 'jobs', 'contracts', 'vacancies', 'mycontracts', 'provider_id',
                'provider_name', 'vacancy','occasionalWork'));
     }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View Edit the resource
     *
     * Edit the resource
     */
    public function edit($contract_id, $createCopy = false)
    {
        try {
            if ($createCopy) {
                $contract = Contract::toMe()->directEmp()->with('vacancy', 'contractLocations','contractEmployee','contractEmployee.hrPool','contractEmployee.hrPool.job', 'contractEmployee.hrPool.nationality','contractEmployee.hrPool.region')->status(Constants::CONTRACT_STATUSES['rejected'])->findOrFail($contract_id);
            } else {
                $contract = Contract::toMe()->directEmp()->with('vacancy', 'contractLocations','contractEmployee','contractEmployee.hrPool','contractEmployee.hrPool.job', 'contractEmployee.hrPool.nationality','contractEmployee.hrPool.region')->editable()->findOrFail($contract_id);
            }
            $jobSeeker = $contract->contractEmployee[0]->hrPool;
            $regions = Region::pluck('name', 'id')->toArray();

            return view('front.labor_market.direct_contract.edit', compact('contract', 'contract_id', 'jobSeeker', 'regions', 'createCopy'));
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    /**
     * @param $id
     * @param $createCopy
     */
    public function resendContract($id)
    {
        return $this->edit($id, true);
    }

    /**
     * @param ReceivedContractRequest $request
     *
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function update(ReceivedContractRequest $request)
    {
        if ($request->createCopy) {
            $contract = Contract::toMe()->directEmp()->status(Constants::CONTRACT_STATUSES['rejected'])->findOrFail($request->contract_id);
        } else {
            $contract = Contract::toMe()->directEmp()->editable()->findOrFail($request->contract_id);
        }

        if ($contract->status == Constants::CONTRACT_STATUSES['approved']) {
            $contractEdit = new ContractEdit;
            $contractEdit->contract_id = $request->contract_id;
            if ($request->hasFile('contract_file')) {
                $contractEdit->contract_file = customUploadFile('contract_file', 'TempWork');
            }
            $contractEdit->contract_locations = $request->contract_locations;
            $contractEdit->status = Constants::CONTRACT_STATUSES['pending'];
            $contractEdit->save();
            $msg = trans('temp_job.updated');
        } else {
            $data = array_except($request->only(array_keys($request->rules())),
                ['contract_locations', 'region_id', 'contract_file']);
            $data['job_type'] = $request->job_type_id;
            $data['contract_amount'] = $request->contract_amount;
            $data['status'] = Constants::CONTRACT_STATUSES['pending'];
            
            if ($request->hasFile('contract_file')) {
                $data['contract_file'] = customUploadFile('contract_file', 'TempWork');
            }

            if ($request->createCopy) {
                $newContract = $contract->replicate();
                $newContract->fill($data);
                $newContract->save();

                $employee = $contract->contractEmployee[0]->replicate();
                $newContract->contractEmployee()->save($employee);
                $contract = $newContract;

                $msg = trans('temp_job.resend_success');
            } else {
                $contract->update($data);
                $contract->contractLocations()->delete();

                $msg = trans('temp_job.updated');
            }

            $contract->contractLocations()->save(new ContractLocation([
                'branch_id'     => session()->get('selected_establishment.branch_no') ?: 1,
                'region_id'     => $request->region_id[0],
                'desc_location' => $request->contract_locations
            ]));
        }

        return $msg;
    }

    /**
     * @param ReceivedContractRequest $request
     *
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function createContract(ReceivedContractRequest $request)
    {
        $employee = HRPool::jobseeker()->byOthers()->checked()->with('region', 'nationality', 'job')->findOrFail($request->employee_id);

        $data = array_except($request->only(array_keys($request->rules())),
            ['contract_locations', 'region_id', 'contract_file']);

        $contract = [
            'contract_type_id' => Constants::CONTRACTTYPES['direct_emp'],
            'benf_id'          => getCurrentUserNameAndId()[0],
            'benf_type'        => \Auth::user()->user_type_id,
            'provider_type'    => $employee->provider_type,
            'provider_id'      => $employee->provider_id,
            'status'           => Constants::CONTRACT_STATUSES['pending'],
            'start_date'       => $data['start_date'],
            'end_date'         => $data['end_date'],
            'contract_amount'  => $request->contract_amount,
            'job_type'         => $request->job_type_id
        ];

        if ($request->hasFile('contract_file')) {
            $contract['contract_file'] = customUploadFile('contract_file', 'TempWork');
        }

        if ($contract_record = Contract::create($contract)) {
            $contract_record->employees()->create([
                'id_number'  => $employee->id,
                'start_date' => $data['start_date'],
                'end_date'   => $data['end_date'],
                'salary'     => $request->contract_amount,
                'status'     => Constants::CONTRACT_STATUSES['pending'],
                'ishaar_id'  => Constants::CONTRACTTYPES['direct_emp'],
            ]);
        }

        $contract_record->contractLocations()->save(new ContractLocation([
            'branch_id'     => session()->get('selected_establishment.branch_no') ?: 1,
            'region_id'     => $request->region_id[0],
            'desc_location' => $request->contract_locations
        ]));

        // send notify email to provider(job seeker)
        \Mail::send('emails.send_direct_hiring_offer', ['benfName' => $contract_record->benf_name, 'contractId' => $contract_record->id], function ($message) use ($contract_record) {
            $message->from(config('mail.from.address'))
                    ->to($contract_record->provider_responsible_email)
                    ->subject(trans('email.subject_send_offer'));
        });

        return trans('temp_job.added');
    }

    public function rejectRequest($id)
    {
        try {
            $contract = Contract::toMe()->directEmp()->with('vacancy', 'vacancy.locations','contractEmployee','contractEmployee.hrPool','contractEmployee.hrPool.job', 'contractEmployee.hrPool.nationality','contractEmployee.hrPool.region')->findOrFail($id);
            $jobSeeker = $contract->contractEmployee[0]->hrPool;
            $reasons = Reason::forTempWorkCancel()->pluck('reason', 'id')->toArray();
            $reasonLabel = 'contracts.cancel_reason';
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $status = 'rejected';

        return view('front.contracts.directemp_details',
            compact('contract', 'reasons', 'status', 'reasonLabel', 'jobSeeker'));

    }
}
