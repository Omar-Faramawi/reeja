<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;
use Mail;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Requests\OfferRejectRequest;
use Tamkeen\Ajeer\Http\Requests\OffersDirectUploadRequest;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Reason;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Utilities\Constants;


class OfferDirectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Contract::byMe()->directEmp()->pending()
                ->with([
                    'vacancy' => function ($v_q) {
                        $v_q->with(['job', 'region']);
                    }, 
                    'contractLocations',
                    'contractLocations.region'
                ]);
            if (request()->input('job_name')) {
                $data = $data->whereHas('vacancy', function ($q) {
                    $q->where('job_id', request()->input('job_name'));
                });
            }
            if (request()->input('region_name')) {
                $data = $data->whereHas('contractLocations', function ($q) {
                    $q->where('region_id', request()->input('region_name'));
                });
            }

            if (request()->input('benef_name')) {
                $data = $data->where(function ($benf_q) {
                    $benf_q->whereHas('benfEstablishment', function ($est_q) {
                        $est_q->where('name', 'LIKE', '%' . request()->input('benef_name') . '%');
                    });
                    $benf_q->orWhereHas('benfIndividual', function ($est_q) {
                        $est_q->where('name', 'LIKE', '%' . request()->input('benef_name') . '%');
                    });
                    $benf_q->orWhereHas('benfGovernment', function ($est_q) {
                        $est_q->where('name', 'LIKE', '%' . request()->input('benef_name') . '%');
                    });

                });
            }

            $columns = request()->input('columns');
            if (request()->input('id')) {
                $data = $data->where('id', request()->input('id'));
            }
            if (request()->input('start_date')) {
                $data = $data->where('start_date', '>=', request()->input('start_date'));
            }
            if (request()->input('end_date')) {
                $data = $data->where('end_date', '<=', request()->input('end_date'));
            }
            $buttons = ['view' => [
                'offersview' => true
            ]
            ];
            $total_count = ($data->count()) ? $data->count() : 1;
            $returned = dynamicAjaxPaginate($data, $columns, $total_count, $buttons, false, [], 'start_date');

            return $returned;
        }
        $jobs = Job::get()->pluck('job_name', 'id');
        $regions = Region::get()->pluck('name', 'id');
        $genders = Constants::vacancyGender();
        $religions = Constants::religions(['file' => 'registration.religions']);
        return view("front.offersdirect.index", compact('jobs', 'regions', 'genders', 'religions'));
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $thisContract = Contract::byMe()->pending()->with('contractEmployee')->findOrFail($id);

        $dateEnded = getDiffPeriodDay($thisContract->updated_at,
            $thisContract->contractType->setup->offer_accept_period,
            $thisContract->contractType->setup->offer_accept_period_type);
        if (Carbon::now()->format("Y-m-d") <= $dateEnded) {
            $canAccept = true;
        }

        if ($thisContract->status == "pending") {
            $canAcceptStatus = true;
        }

        $jobSeeker = $thisContract->contractEmployee[0]->hrPool;

        $reasons = Reason::where('parent_id', 1)->lists("reason", "id");

        return view("front.offersdirect.show", compact("thisContract", "dateEnded", "canAccept", "canAcceptStatus", "jobSeeker", "reasons"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /*
     *
     *
     */
    /**
     * @param Requests\OffersDirectUploadRequest $
     */
    public function accept(OffersDirectUploadRequest $offersDirectUploadRequest, $id)
    {
        $qualificationsUploaded = customUploadFile("qualifications", "direct_emp");
        $employee = ContractEmployee::where('contract_id', $id);
        $employee->update(["qualification_upload" => $qualificationsUploaded]);

        return $qualificationsUploaded;

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
        $mail = [
            "mailFrom" => config("mail.from.address"),
            "mailFromName" => config("mail.from.name"),
            "mailTo" => $contract->responsible_email,
            "mailToName" => $contract->benef->name,
        ];
        //TODO: fix this with log
        /*Mail::send('front.offersdirect.emails.reject', ['contract' => $contract], function ($m) use ($mail) {
            $m->from($mail['mailFrom'], $mail['mailFromName']);

            $m->to($mail['mailTo'], $mail['mailToName'])->subject(trans("offersdirect."));
        });*/

        if (isset($offerRejectRequest->other_reason)) {
            $contract->other_reasons = $offerRejectRequest->other_reason;
        } else {
            $contract->other_reasons = NULL;
        }
        $contract->reason_id = $offerRejectRequest->reason_id;
        $contract->rejection_reason = $offerRejectRequest->extraDetails;
        $contract->status = "rejected";
        $contract->save();

        return trans("offers.modal.reject.rejectionSuc");
    }

    public function approvePost($id)
    {
        $contract = Contract::findOrFail($id);

        if (\Auth::getUser()->user_type_id == 4) {
            $contract->status = "approved";
        } else {
            $contract->status = "pending_ownership";
            $mail = [
                "mailFrom" => config("mail.from.address"),
                "mailFromName" => config("mail.from.name"),
                "mailTo" => $contract->benef->email,
                "mailToName" => $contract->benef->name,
            ];
            //TODO: fix this with log
            /*Mail::send('front.offersdirect.emails.pendingownership', ['contract' => $contract],
                function ($m) use ($mail) {
                    $m->from($mail['mailFrom'], $mail['mailFromName']);

                    $m->to($mail['mailTo'],
                        $mail['mailToName'])->subject(trans("offersdirect.modal.reject.mail.subject"));
                });*/

            $ownerShipNumber = $contract->provider->ownership_phone;
            //TODO : SMS MESSAGE AND LINK\
            $ownerShipName = $contract->provider->ownership_name;
            $hashedid = bcrypt(time() . $ownerShipName);
            $contract->ownership_hashed = $hashedid;
            $link = url("offersdirect/ownership/approve/" . $id . "/" . $hashedid);
            $message = trans("offersdirect.smsmessage", ["link" => $link]);
            sendSMS($ownerShipNumber, $message);
        }

        $contract->save();

        return trans("offersdirect.modal.accept.offerAccepted");
    }
}
