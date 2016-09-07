<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\ReceivedContractRequest;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Models\ContractLocation;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Models\Vacancy;
use Tamkeen\Ajeer\Utilities\Constants;

/**
 * Class ReceivedContractsController
 * @package Tamkeen\Ajeer\Http\Controllers\Front
 */
class ReceivedContractsController extends Controller
{

    /**
     * @param $vacancy_id
     *
     * @return mixed
     *
     * Show the received contract here
     */
    public function show($vacancy_id = null)
    {
        $regions       = Region::pluck('name', 'id')->toArray();
        $nationalities = Nationality::pluck('name', 'id')->toArray();
        $jobs          = Job::pluck('job_name', 'id')->toArray();
        $contracts     = Contract::pending($vacancy_id)->get();

        if (session()->get('selected_establishment')) {
            $user_id   = session()->get('selected_establishment.id');
            $user_name = session()->get('selected_establishment.name');
        } elseif (session()->get('government')) {
            $user_id   = session()->get('government.id');
            $user_name = session()->get('government.name');
        } else {
            $user_id   = auth()->user()->id_no;
            $user_name = auth()->user()->name;
        }

        if ( ! empty($vacancy_id)) {
            try {

                if (session()->get('service_type') === Constants::SERVICETYPES['provider']) {
                    $vacancy = Vacancy::with('job', 'region', 'nationality')->findOrFail($vacancy_id);
                } else {
                    // if the user is beneficial
                    $vacancy = HRPool::with('job', 'region', 'nationality')->findOrFail($vacancy_id);
                }

                if (request()->route()->getPrefix() === '/occasional-work') {
                    $vacancy = $vacancy->where('religion', Constants::RELIGION['muslim']);
                }


                return view('front.labor_market.offer_contract.show',
                    compact('regions', 'nationalities', 'jobs', 'vacancy', 'contracts', 'user_id',
                        'user_name'))->with('vacancy_id', $vacancy_id);

            } catch (\Exception $e) {
                abort(404);
            }
        }

        $mycontracts = Contract::byMe()->hireLabor()->with('vacancy.job', 'vacancy.region', 'vacancy.nationality')->pending()->get();
        
        return view('front.labor_market.offer_contract.show',
            compact('regions', 'nationalities', 'jobs', 'contracts', 'vacancies', 'mycontracts', 'provider_id',
                'provider_name', 'vacancy'));
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
                ['contract_type_id' => Constants::CONTRACTTYPES['hire_labor']],
                ['vacancy_id' => $request->vacancy_id]
            ),
            ['region_id', 'status', 'job_id']
        );

        $contract = Contract::create($data);


        // Save contract locations
        if( isset($request->region_id) ) {
            foreach ($request->region_id as $region) {
                $contract->contractLocations()->save(new ContractLocation([
                    'branch_id' => session()->get('selected_establishment.branch_no') ?: 1,
                    'region_id' => $region
                ]));
            }
        }


        foreach ($request->ids as $k => $id) {
            $uploadedFile = customUploadFile("fileupload_".$id, "tempWork");
            // ToDo : return error message
            if (!$uploadedFile) {
                $uploadedFile = '';
            }

            $employee              = new ContractEmployee();
            $employee->contract_id = $contract->id;
            $employee->id_number   = $id;
            $employee->start_date  = $contract->start_date;
            $employee->end_date    = $contract->end_date;
            $employee->ishaar_id   = 3;
            $employee->qualification_upload   = $uploadedFile;
            $employee->save();
        }

        return trans('temp_job.added');
    }

}
