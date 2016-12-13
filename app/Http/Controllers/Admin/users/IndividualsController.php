<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Models\User;
use Tamkeen\Ajeer\Models\Individual;
use Tamkeen\Ajeer\Models\IndividualLabor;
use Tamkeen\Ajeer\Models\HRPool;

class IndividualsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::whereIn('user_type_id', ['4', '5'])->latest()->paginate(20);

        return view('admin.users.individuals.list', compact('data'));
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
        $this->edit($id);
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
        $data = User::byId($id)->firstOrFail();

        return view('admin.users.individuals.edit', compact('data'));
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
        $data         = User::byId($id)->firstOrFail();
        $data->active = $request->input('active') ? "1" : "0";
        $data->save();

        return trans('individuals_admin.updated');
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
        $data = User::byId($id)->firstOrFail();
        $data->delete();

        $indv = Individual::where([
                'id'           => $data->id_no,
                'user_type_id' => $data->user_type_id,
            ])
            ->first();
        if ($indv) {
            $indv->delete();
        }

        $hrPoolRec = HRPool::where([
                'id_number'     => $data->national_id,
                'provider_type' => $data->user_type_id,
                'provider_id'   => $data->id_no,
                ]
            )->first();
        if ($hrPoolRec) {
            $hrPoolRec->delete();
        }

        $indLabor = IndividualLabor::where('id_number',$data->national_id)->first();
        if ($indLabor) {
            $indLabor->delete();
        }

        return trans('individuals_admin.deleted');
    }
}
