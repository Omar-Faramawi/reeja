<?php

namespace Tamkeen\Ajeer\Http\Controllers\front;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Requests\ApproveAcceptOfferRequest;
use Tamkeen\Ajeer\Http\Requests\OfferRejectRequest;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Reason;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Models\Vacancy;


class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {

            $data = Contract::toMe()->pending()->hireLabor()->with([
                'vacancy' => function ($v_q) {
                    $v_q->with(['job', 'region']);
                },
            ]);
            $total_count = ($data->count()) ? $data->count() : 1;

            $columns = request()->input('columns');
            if (request()->input('job_name') || request()->input('region_name')) {
                $data = $data->whereHas('vacancy', function ($q) {
                    if (request()->input('job_name')) {
                        $q->where('job_id', request()->input('job_name'));

                    }
                    if (request()->input('region_name')) {
                        $q->where('region_id', request()->input('region_name'));
                        /* $q->whereHas('region', function ($reg_q) {
                             $reg_q->where('name', 'LIKE', '%' . request()->input('region_name') . '%');
                         });*/
                    }
                });
            }
            if (request()->input('provider_name')) {

                $data = $data->where(function ($provider_q) {
                    $provider_q->whereHas('establishment', function ($est_q) {
                        $est_q->where('name', 'LIKE', '%' . request()->input('provider_name') . '%');
                    });
                    $provider_q->orWhereHas('individual', function ($est_q) {
                        $est_q->where('name', 'LIKE', '%' . request()->input('provider_name') . '%');
                    });
                    $provider_q->orWhereHas('government', function ($est_q) {
                        $est_q->where('name', 'LIKE', '%' . request()->input('provider_name') . '%');
                    });

                });
            }

            if (request()->input('id')) {
                $data = $data->where('id', request()->input('id'));
            }
            if (request()->input('start_date')) {
                $data = $data->where('start_date', '>=', request()->input('start_date'));
            }
            if (request()->input('end_date')) {
                $data = $data->where('end_date', '<=', request()->input('end_date'));
            }
            $buttons = [
                'view' => [],
            ];


            return dynamicAjaxPaginate($data, $columns, $total_count, $buttons);
        }
        $jobs = Job::get()->pluck('job_name', 'id');
        $regions = Region::get()->pluck('name', 'id');

        return view("front.offers.index", compact('jobs', 'regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $thisContract = Contract::toMe()->hireLabor()
            ->with([
                'contractEmployee' => function ($v_q) {
                    $v_q->with([
                        'hrPool' => function ($hr_q) {
                            $hr_q->with(["job", "region", "nationality"]);
                        }
                    ]);
                }
            ])
            ->findOrFail($id);
        $dateEnded = getDiffPeriodDay($thisContract->updated_at,
            $thisContract->contractType->setup->max_accept_period,
            $thisContract->contractType->setup->max_accept_period_type);
        if (Carbon::now()->format("Y-m-d") <= $dateEnded) {
            $canAccept = true;
        }
        $thisContract = $thisContract->toArray();

        return view("front.offers.show", compact("thisContract", "dateEnded", "canAccept"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Force Download Qualification file
     * @param int $id hashed
     *
     * @return Response download file
     */
    public function downloadFile($id)
    {
        $contractEmplyee = ContractEmployee::findOrFail($id);

        return response()->download(storage_path($contractEmplyee->qualification_upload));
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function reject($id)
    {
        $reasons = Reason::where('parent_id', 1)->lists("reason", "id");

        return view("front.offers.reject", compact("reasons"))
            ->withId($id);
    }

    /**
     * @param OfferRejectRequest $offerRejectRequest
     * @param                    $id
     *
     * @return mixed
     */
    public function rejectPost(OfferRejectRequest $offerRejectRequest, $id)
    {
        $contract = Contract::findOrFail($id);
        $contract->reason_id = $offerRejectRequest->reason_id;
        $contract->other_reasons = $offerRejectRequest->other_reason;
        $contract->rejection_reason = $offerRejectRequest->extraDetails;
        $contract->status = "rejected";
        $contract->save();

        return trans("offers.modal.reject.rejectionSuc");
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function approve($id)
    {
        $contract = new  Contract();
        $thisContract = $contract->toMe()->hireLabor()
            ->with([
                'contractEmployee' => function ($v_q) {
                    $v_q->with(['hrPool']);
                },
            ])
            ->findOrFail($id);
        $dateEnded = getDiffPeriodDay($thisContract->updated_at,
            $thisContract->contractType->setup->max_accept_period,
            $thisContract->contractType->setup->max_accept_period_type);

        return view("front.offers.approve", compact("thisContract", "dateEnded", "id"));
    }

    /**
     * @param ApproveAcceptOfferRequest $approveAcceptOfferRequest
     * @param                           $id
     *
     * @return mixed
     */
    public function approvePost(ApproveAcceptOfferRequest $approveAcceptOfferRequest, $id)
    {
        $contract = new  Contract();
        $thisContract = $contract->toMe()->hireLabor()
            ->with([
                'contractEmployee' => function ($v_q) {
                    $v_q->with(['hrPool']);
                },
            ])
            ->findOrFail($id);

        /*
         * check if offer is still available or not
         */
        $dateEnded = getDiffPeriodDay($thisContract->updated_at,
            $thisContract->contractType->setup->max_accept_period,
            $thisContract->contractType->setup->max_accept_period_type);
        if (Carbon::now()->format("Y-m-d") > $dateEnded) {
            return response()->json(['error' => trans('offers.cannotaccept')], 422);
        }

        if (isset($thisContract->vacancy)) {
            //TODO: CHECK ON EMPLOYESS COUNT

            /*
             * get all Available vacancies
             */
            $allVacancies = $thisContract->vacancy->no_of_vacancies;
            /*
             * get this contract employees
             */
            $thisContractEmployee = $thisContract->contractEmployee->count();
            /*
             * get vacancy approved contracts
             */
            $vacancy = new Vacancy();
            $newVacancy = $vacancy
                ->with([
                    "contract" => function ($v_q) {
                        $v_q->approved();
                    }
                ])->find($thisContract->vacancy->id);
            $contracts = $newVacancy->contract;

            /*
             * Count vacancy approved contract employees
             */
            $contractEmployee = 0;
            foreach ($contracts as $contract) {
                $contractEmployee += $contract->contractEmployee->count();
            }
            /*
             * check if there yet available vacancies
             * if no return error
             */
            if ($allVacancies < ($contractEmployee + $thisContractEmployee)) {
                return response()->json(['error' => trans("offers.vacanciesexceeded")], 422);
            }
        }

        /*
         * save new status for contract
         */
        $thisContract->reason_id = null;
        $thisContract->rejection_reason = null;
        $thisContract->status = "approved";
        $thisContract->save();

        return trans("offers.accepted");
    }
}
