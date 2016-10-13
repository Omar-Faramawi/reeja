<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\OffersTaqawelRequest;
use Tamkeen\Ajeer\Http\Requests\OfferTaqawelRejectRequest;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\Reason;
use Tamkeen\Ajeer\Utilities\Constants;

class OffersTaqaualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Contract::toMe()->taqawel()->pending()->with([
                "contractNature",
                "marketTaqawoulServices",
            ]);
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
            if (request()->input('service_type')) {
                $data = $data->where(function ($service_q) {
                    $service_q->whereHas("contractNature", function ($nature_q) {
                        $nature_q->where("name", 'LIKE', '%' . request()->input('service_type') . '%');
                    });

                });
            }
            if (request()->input('responsible_email')) {
                $data = $data->where(function ($responsible_q) {
                    $responsible_q->whereHas('establishment', function ($est_q) {
                        $est_q->whereHas("responsibles", function ($estr_q) {
                            $estr_q->where('email', 'LIKE', '%' . request()->input('responsible_email') . '%');
                        });
                    });
                    $responsible_q->orWhereHas('individual', function ($est_q) {
                        $est_q->where('email', 'LIKE', '%' . request()->input('responsible_email') . '%');
                    });
                    $responsible_q->orWhereHas('government', function ($est_q) {
                        $est_q->where('email', 'LIKE', '%' . request()->input('responsible_email') . '%');
                    });
                });
            }
            //ToDo : search with mobile phone check
            if (request()->input('responsible_mobile')) {
                $data = $data->where(function ($responsiblem_q) {
                    $responsiblem_q->whereHas('establishment', function ($est_q) {
                        $est_q->whereHas("responsibles", function ($estr_q) {
                            $estr_q->where('responsible_phone', 'LIKE',
                                "%" . request()->input('responsible_mobile') . "%");
                        });
                    });
                    $responsiblem_q->orWhereHas('individual', function ($est_q) {
                        $est_q->where('phone', '=', request()->input('responsible_mobile'));
                    });
                });
            }
            $columns     = request()->input('columns');
            $buttons     = ['view' => []];
            $total_count = ($data->count()) ? $data->count() : 1;
            $returned    = dynamicAjaxPaginate($data, $columns, $total_count, $buttons);

            return $returned;
        }

        return view("front.tqawel.offers.index");
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
        $thisContract = Contract::toMe()->taqawel()->pending()->with([
            "contractNature",
            "marketTaqawoulServices",
        ]);
        $thisContract = $thisContract->findOrFail($id)->load([
            "contractLocations",
        ]);
        $dateEnded    = getDiffPeriodDay($thisContract->created_at,
            $thisContract->contractType->setup->max_accept_period,
            $thisContract->contractType->setup->max_accept_period_type);
        if ($dateEnded >= Carbon::today()->format("Y-m-d")) {
            $canAccept = true;
        }
        $thisContract = $thisContract->toArray();

        return view("front.tqawel.offers.show", compact("thisContract", "canAccept", "dateEnded"));
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
     * @param  int                      $id
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

    /*
 *
 *
 */
    /**
     * @param OffersTaqawelRequest $offersTaqawelRequest
     * @param                      $id
     *
     * @return string
     * @internal param $ Requests\OffersDirectUploadRequest $
     */
    public function accept(OffersTaqawelRequest $offersTaqawelRequest, $id)
    {
        return "";
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function approvepost($id)
    {
        $contract = Contract::toMe()->taqawel()->pending()->findOrFail($id);

        $contract->status = "approved";
        $contract->save();
        $mail = [
            "mailFrom"     => config("mail.from.address"),
            "mailFromName" => config("mail.from.name"),
            "mailTo"       => $contract->provider->responsibles->first()->responsible_email,
            "mailToName"   => $contract->provider->responsibles->first()->responsible_name,
        ];
        Mail::queue('front.tqawel.offers.emails.approved', ['contract' => $contract],
            function ($m) use ($mail) {
                $m->from($mail['mailFrom'], $mail['mailFromName']);

                $m->to($mail['mailTo'],
                    $mail['mailToName'])->subject(trans("tqaweloffers.modal.accept.mail.subject"));
            });

        return trans("tqaweloffers.modal.accept.offerAccepted");
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function reject($id)
    {
        $reasons = Reason::where('parent_id', 2)->pluck("reason", "id");
        $reasons->prepend("", "");
        
        return view("front.tqawel.offers.reject", compact("reasons", "id"));
    }

    /**
     * @param OfferTaqawelRejectRequest $offerTaqawelRejectRequest
     * @param                           $id
     *
     * @return mixed
     * @internal param OfferRejectRequest $offerRejectRequest
     */
    public function rejectPost(OfferTaqawelRejectRequest $offerTaqawelRejectRequest, $id)
    {
        $contract                   = Contract::toMe()->taqawel()->pending()->findOrFail($id);
        $contract->reason_id        = $offerTaqawelRejectRequest->reason_id;
        $contract->rejection_reason = $offerTaqawelRejectRequest->extraDetails;
        $contract->other_reasons    = $offerTaqawelRejectRequest->other_reason;
        $contract->status           = Constants::CONTRACT_STATUSES['rejected'];
        $contract->save();

        $mail = [
            "mailFrom"     => config("mail.from.address"),
            "mailFromName" => config("mail.from.name"),
            "mailTo"       => $contract->provider->responsibles->first()->responsible_email,
            "mailToName"   => $contract->provider->responsibles->first()->responsible_name,
        ];
        Mail::queue('front.tqawel.offers.emails.reject', ['contract' => $contract], function ($m) use ($mail) {
            $m->from($mail['mailFrom'], $mail['mailFromName']);

            $m->to($mail['mailTo'], $mail['mailToName'])->subject(trans("offersdirect.modal.reject.mail.subject"));
        });

        return trans("tqaweloffers.modal.reject.rejectionSuc");
    }

    /**
     * Force Download Contract file
     *
     * @param int $id hashed
     *
     * @return Response download file
     */
    public function downloadFile($id)
    {
        $contract = Contract::findOrFail($id);

        return response()->download(base_path(Constants::UPLOADPATH . $contract->contract_file));
    }
}
