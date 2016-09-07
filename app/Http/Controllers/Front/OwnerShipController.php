<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Illuminate\Http\Request;

use Mail;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Contract;

class OwnerShipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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

    /**
     * @param $id
     * @param $hashedid
     * @return mixed
     */
    public function approve($id, $hashedid)
    {
        $contract = Contract::myOwnership($hashedid)->pendinOwnerShip()->with("individual")->findOrFail($id);
        if ($contract->count() < 1) {
            return redirect(404);
        }

        return view("front.ownership.approve", compact("id", "hashedid"));
    }

    /**
     * @param $id
     * @param $hashedid
     * @return mixed
     */
    public function approvepost($id, $hashedid)
    {
        $contract = Contract::myOwnership($hashedid)->pendinOwnerShip()->with("individual")->findOrFail($id);
        $contract->status = "approved";
        $contract->save();

        return trans("ownership.accepted");

    }

    public function reject($id, $hashedid)
    {
        return view("front.ownership.reject", compact("id", "hashedid"));
    }

    public function rejectPost($id, $hashedid)
    {
        $contract = Contract::myOwnership($hashedid)->pendinOwnerShip()->with("individual")->findOrFail($id);
        $providerMail = [
            "mailFrom"     => config("mail.from.address"),
            "mailFromName" => config("mail.from.name"),
            "mailTo"       => $contract->provider->email,
            "mailToName"   => $contract->provider->name,
        ];

        Mail::queue('front.ownership.mail.providerreject', ['contract' => $contract],
            function ($m) use ($providerMail) {
                $m->from($providerMail['mailFrom'], $providerMail['mailFromName']);

                $m->to($providerMail['mailTo'],
                    $providerMail['mailToName'])->subject(trans("ownership.rejected",[],[],"en"));
            });

        $benfMail = [
            "mailFrom"     => config("mail.from.address"),
            "mailFromName" => config("mail.from.name"),
            "mailTo"       => $contract->benef->email,
            "mailToName"   => $contract->benef->name,
        ];
        Mail::queue('front.ownership.mail.benfreject', ['contract' => $contract],
            function ($m) use ($benfMail) {
                $m->from($benfMail['mailFrom'], $benfMail['mailFromName']);

                $m->to($benfMail['mailTo'],
                    $benfMail['mailToName'])->subject(trans("ownership.rejected",[],[],"en"));
            });
        $contract->status = "rejected";
        $contract->save();

        return trans("ownership.rejected");
    }
}
