<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\ContractMembersTaqyeemRequest;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\Establishment;
use Tamkeen\Ajeer\Models\Government;
use Tamkeen\Ajeer\Models\Individual;
use Tamkeen\Ajeer\Models\PermissionServiceEnviroment;
use Tamkeen\Ajeer\Models\PermissionSpecificUser;
use Tamkeen\Ajeer\Models\RatingModels;
use Tamkeen\Ajeer\Models\TaqyeemTemplatePermission;
use Tamkeen\Ajeer\Utilities\Constants;

class ContractMembersTaqyeemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return $this->create($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $ratingModel = RatingModels::whereId($id)->withCount('taqyeemTemplatePermission')->with([
            'taqyeemTemplatePermission' => function ($q) {
                $q->with(['contractType', 'permissionServiceEnvironment']);
            }
        ])->firstOrFail();

        if ($ratingModel->taqyeem_template_permission_count > 0) {
            if ($ratingModel->taqyeemTemplatePermission->taqyeem_type == 1) {
                $permissions = $ratingModel->taqyeemTemplatePermission->permissionServiceEnvironment->toArray();
                $contractsId = array_pluck($permissions, 'contract_type_id');

                return view('admin.contract_members_taqyeem.edit_member_permision',
                    compact('ratingModel', 'contractsId', 'permissions'));
            } else {
                $permision = RatingModels::has('taqyeemTemplatePermission')->where('id', $id);
                if ($permision) {
                    $permisionToCompact = $permision->with('taqyeemTemplatePermission.specificUsers')->first();

                    if (!empty($permisionToCompact->taqyeemTemplatePermission->specificUsers)) {
                        $specificUsers = $permisionToCompact->taqyeemTemplatePermission->specificUsers;
                        foreach ($specificUsers as $user) {
                            switch ($user->user_type) {
                                case '3':
                                    $est = Establishment::find($user->user_id);
                                    if ($est) {
                                        $est->userType = '3';
                                        $results[] = $est;
                                    }
                                    break;
                                case '2':
                                    $gov = Government::find($user->user_id);
                                    if ($gov) {
                                        $gov->userType = '2';
                                        $results[] = $gov;
                                    }
                                    break;
                                case '5':
                                    $indv = Individual::find($user->user_id);
                                    if ($indv) {
                                        $indv->userType = $indv->user_type_id;
                                        $results[] = $indv;
                                    }
                                    break;
                            }
                        }
                    }

                    return view('admin.contract_members_taqyeem.edit_taqyeem_type',
                        compact('permisionToCompact', 'results'));
                }
            }
        }

        return view('admin.contract_members_taqyeem.index', compact('ratingModel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractMembersTaqyeemRequest $contractMembersTaqyeemRequest)
    {
        $taqyeemTemplatePermision = TaqyeemTemplatePermission::where('taqyeem_template_id',
            $contractMembersTaqyeemRequest->taqyeem_template_id)->first();
        if (!$taqyeemTemplatePermision) {
            $taqyeemTemplatePermision = new TaqyeemTemplatePermission();
        }

        $taqyeemTemplatePermision->link_period = $contractMembersTaqyeemRequest->link_period;
        $taqyeemTemplatePermision->taqyeem_template_id = $contractMembersTaqyeemRequest->taqyeem_template_id;
        $taqyeemTemplatePermision->taqyeem_type = $contractMembersTaqyeemRequest->taqyeem_type;
        $taqyeemTemplatePermision->periodic_or_date = $contractMembersTaqyeemRequest->periodic_or_date;
        $taqyeemTemplatePermision->periodic_period = $contractMembersTaqyeemRequest->periodic_period;
        $taqyeemTemplatePermision->taqyeem_date = $contractMembersTaqyeemRequest->taqyeem_date;
        $taqyeemTemplatePermision->residents = $contractMembersTaqyeemRequest->residents;
        if (!is_array($contractMembersTaqyeemRequest->userTypeResidents)) {
            $taqyeemTemplatePermision->est = false;
            $taqyeemTemplatePermision->ind = false;
            $taqyeemTemplatePermision->gov = false;
        } else {
            $taqyeemTemplatePermision->est = (array_key_exists(3,
                $contractMembersTaqyeemRequest->userTypeResidents)) ? $contractMembersTaqyeemRequest->userTypeResidents[3] : 0;
            $taqyeemTemplatePermision->gov = (array_key_exists(2,
                $contractMembersTaqyeemRequest->userTypeResidents)) ? $contractMembersTaqyeemRequest->userTypeResidents[2] : 0;
            $taqyeemTemplatePermision->ind = (array_key_exists(5,
                $contractMembersTaqyeemRequest->userTypeResidents)) ? $contractMembersTaqyeemRequest->userTypeResidents[5] : 0;
        }
        $taqyeemTemplatePermision->save();

        if ($taqyeemTemplatePermision->taqyeem_type == 1) {
            if (in_array('taqawel_services', $contractMembersTaqyeemRequest->portal_services)) {
                $permissionServiceEnviroment = PermissionServiceEnviroment::firstOrNew([
                    'template_permission_id' => $taqyeemTemplatePermision->id,
                    'contract_type_id'       => Constants::CONTRACTTYPES['taqawel']
                ]);

                $permissionServiceEnviroment->provider = $permissionServiceEnviroment->benf = 0;
                if (in_array(Constants::SERVICETYPES['provider'], $contractMembersTaqyeemRequest->taqawel_services)) {
                    $permissionServiceEnviroment->provider = 1;
                }
                if (in_array(Constants::SERVICETYPES['benf'], $contractMembersTaqyeemRequest->taqawel_services)) {
                    $permissionServiceEnviroment->benf = 1;
                }
                $permissionServiceEnviroment->save();
            } else {
                PermissionServiceEnviroment::where([
                    'template_permission_id' => $taqyeemTemplatePermision->id,
                    'contract_type_id'       => Constants::CONTRACTTYPES['taqawel']
                ])->delete();
            }

            if (in_array('hire_labore', $contractMembersTaqyeemRequest->portal_services)) {
                $permissionServiceEnviroment = PermissionServiceEnviroment::firstOrNew([
                    'template_permission_id' => $taqyeemTemplatePermision->id,
                    'contract_type_id'       => Constants::CONTRACTTYPES['hire_labor']
                ]);

                $permissionServiceEnviroment->provider = $permissionServiceEnviroment->benf = 0;
                if (in_array(Constants::SERVICETYPES['provider'], $contractMembersTaqyeemRequest->hire_labore)) {
                    $permissionServiceEnviroment->provider = 1;
                }
                if (in_array(Constants::SERVICETYPES['benf'], $contractMembersTaqyeemRequest->hire_labore)) {
                    $permissionServiceEnviroment->benf = 1;
                }
                $permissionServiceEnviroment->save();
            } else {
                PermissionServiceEnviroment::where([
                    'template_permission_id' => $taqyeemTemplatePermision->id,
                    'contract_type_id'       => Constants::CONTRACTTYPES['hire_labor']
                ])->delete();
            }

            if (in_array('direct_emp', $contractMembersTaqyeemRequest->portal_services)) {
                $permissionServiceEnviroment = PermissionServiceEnviroment::firstOrNew([
                    'template_permission_id' => $taqyeemTemplatePermision->id,
                    'contract_type_id'       => Constants::CONTRACTTYPES['direct_emp']
                ]);

                $permissionServiceEnviroment->provider = $permissionServiceEnviroment->benf = 0;
                if (in_array(Constants::SERVICETYPES['provider'], $contractMembersTaqyeemRequest->direct_emp)) {
                    $permissionServiceEnviroment->provider = 1;
                }
                if (in_array(Constants::SERVICETYPES['benf'], $contractMembersTaqyeemRequest->direct_emp)) {
                    $permissionServiceEnviroment->benf = 1;
                }
                $permissionServiceEnviroment->save();
            } else {
                PermissionServiceEnviroment::where([
                    'template_permission_id' => $taqyeemTemplatePermision->id,
                    'contract_type_id'       => Constants::CONTRACTTYPES['direct_emp']
                ])->delete();
            }

            PermissionSpecificUser::where('template_permission_id', $taqyeemTemplatePermision->id)->delete();
        } elseif ($taqyeemTemplatePermision->taqyeem_type == 2) {
            $userIds = [];
            if ($taqyeemTemplatePermision->residents == '2' && !empty($contractMembersTaqyeemRequest->ids) && is_array($contractMembersTaqyeemRequest->ids)) {
                foreach ($contractMembersTaqyeemRequest->ids as $k => $id) {
                    $userPermission = PermissionSpecificUser::firstOrCreate([
                        'template_permission_id' => $taqyeemTemplatePermision->id,
                        'user_type'              => $userType = $contractMembersTaqyeemRequest->userType[$k],
                        'user_id'                => $id
                    ]);
                    $userIds[] = $userPermission->id;
                    if ($taqyeemTemplatePermision->periodic_or_date == '1') {
                        switch ($userType) {
                            case Constants::USERTYPES['est']:
                                $userDetails = Establishment::with('responsibles')->find($id);
                                break;
                            case Constants::USERTYPES['gov'];
                                $userDetails = Government::find($id);
                                break;
                            default:
                                $userDetails = Individual::find($id);
                                break;
                        }
                        // Send email
                        \Mail::queue('emails.taqyem_template_notify',
                            ['url' => url('rating/' . $contractMembersTaqyeemRequest->taqyeem_template_id)],
                            function ($m) use ($userDetails, $userType) {
                                $m->from(config('mail.from.address'), config('mail.from.name'));
                                if ($userType == Constants::USERTYPES['est'] && !$userDetails->responsibles->isEmpty()) {
                                    $m->to($userDetails->responsibles[0]->responsible_email);
                                } else {
                                    $m->to($userDetails->email);
                                }
                                $m->subject(trans('rating.added'));
                            });
                    }
                }
                PermissionSpecificUser::whereNotIn('id', $userIds)->delete();
            } else {
                if ($taqyeemTemplatePermision->periodic_or_date == '1') {
                    $establishment = Establishment::with('responsibles')->get()->toArray();
                    if (!$taqyeemTemplatePermision->est) {
                        $establishment = [];
                    }
                    $governments = Government::all()->toArray();
                    if (!$taqyeemTemplatePermision->gov) {
                        $governments = [];
                    }
                    $individual = Individual::all()->toArray();
                    if (!$taqyeemTemplatePermision->ind) {
                        $governments = [];
                    }
                    foreach (array_merge($establishment, $governments, $individual) as $user) {
                        if (!empty($user['email']) || !empty($user['responsibles']['responsible_email'])) {
                            \Mail::queue('emails.taqyem_template_notify',
                                ['url' => url('rating/' . $contractMembersTaqyeemRequest->taqyeem_template_id)],
                                function ($m) use ($user) {
                                    $m->from(config('mail.from.address'), config('mail.from.name'));
                                    if (isset($user['FK_establishment_id']) && isset($user['responsibles']['responsible_email'])) {
                                        $m->to($user['responsibles']['responsible_email']);
                                    } else {
                                        $m->to($user['email']);
                                    }
                                    $m->subject(trans('rating.added'));
                                });
                        }
                    }
                }

                PermissionSpecificUser::where('template_permission_id', $taqyeemTemplatePermision->id)->delete();
            }

            PermissionServiceEnviroment::where('template_permission_id', $taqyeemTemplatePermision->id)->delete();
        }

        return trans('contractmembertaqyeem.permisionAddSaved');
    }

    /**
     * view TaqyeemContract Ajeer
     *
     * @param $id
     *
     * @return string
     */
    public function viewTaqyeemContractAjeer($id)
    {
        if (!request()->ajax()) {
            abort(404);
        }

        $hideTaqyeemType = true;
        $ratingModel = RatingModels::whereId($id)->with([
            'taqyeemTemplatePermission' => function ($q) {
                $q->with(['contractType', 'permissionServiceEnvironment', 'specificUsers']);
            }
        ])->first();

        $permisionToCompact = $results = '';
        if (isset($ratingModel->taqyeemTemplatePermission)) {
            $permisionToCompact = $ratingModel;

            if (!empty($permisionToCompact->taqyeemTemplatePermission->specificUsers)) {
                $specificUsers = $permisionToCompact->taqyeemTemplatePermission->specificUsers;
                foreach ($specificUsers as $user) {
                    switch ($user->user_type) {
                        case '3':
                            $est = Establishment::find($user->user_id);
                            if ($est) {
                                $est->userType = '3';
                                $results[] = $est;
                            }
                            break;
                        case '2':
                            $gov = Government::find($user->user_id);
                            if ($gov) {
                                $gov->userType = '2';
                                $results[] = $gov;
                            }
                            break;
                        case '5':
                            $indv = Individual::find($user->user_id);
                            if ($indv) {
                                $indv->userType = $indv->user_type_id;
                                $results[] = $indv;
                            }
                            break;
                    }
                }
            }

            return view('admin.contract_members_taqyeem.edit_taqyeem_type',
                compact('permisionToCompact', 'results', 'hideTaqyeemType'))->render();
        }

        $taqyeemType = '2';

        return view('admin.contract_members_taqyeem.index',
            compact('ratingModel', 'hideTaqyeemType', 'taqyeemType'))->render();
    }

    /**
     * View Taqyeem Contract Individual
     *
     * @param $id
     *
     * @return string
     */
    public function viewTaqyeemContractIndividuals($id)
    {
        if (!request()->ajax()) {
            abort(404);
        }

        $hideTaqyeemType = true;
        $ratingModel = RatingModels::whereId($id)->with([
            'taqyeemTemplatePermission' => function ($q) {
                $q->with(['contractType', 'permissionServiceEnvironment']);
            }
        ])->first();

        if (isset($ratingModel->taqyeemTemplatePermission) && $ratingModel->taqyeemTemplatePermission->taqyeem_type == 1) {
            $permissions = $ratingModel->taqyeemTemplatePermission->permissionServiceEnvironment->toArray();
            $contractsId = array_pluck($permissions, 'contract_type_id');
            if ($ratingModel->taqyeemTemplatePermission->taqyeem_type == 1) {
                return view('admin.contract_members_taqyeem.edit_member_permision',
                    compact('ratingModel', 'contractsId', 'permissions', 'hideTaqyeemType'))->render();
            }
        }

        $taqyeemType = '1';

        return view('admin.contract_members_taqyeem.index',
            compact('ratingModel', 'hideTaqyeemType', 'taqyeemType'))->render();
    }

    /**
     * Search for the current taqyeem users
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchTaqyeemUsers()
    {
        $request = request()->only('name', 'type');
        $results = [];
        $isSearch = true;
        $userType = $request['type'];
        switch ($userType) {
            case '3':
                $results = Establishment::where(function ($query) use ($request) {
                    $query->where('id', '!=', 0);
                    if (isset($request['name'])) {
                        $query->where('name', 'LIKE', '%' . $request['name'] . '%');
                    }
                })->simplePaginate(5);
                break;
            case '2':
                $results = Government::where(function ($query) use ($request) {
                    $query->where('id', '!=', 0);
                    if (isset($request['name'])) {
                        $query->where('name', 'LIKE', '%' . $request['name'] . '%');
                    }
                })->simplePaginate(5);
                break;
            case '5':
                $results = Individual::where(function ($query) use ($request) {
                    $query->where('id', '!=', 0);
                    if (isset($request['name'])) {
                        $query->where('name', 'LIKE', '%' . $request['name'] . '%');
                    }
                })->simplePaginate(5);
                break;
        }

        return view('admin.contract_members_taqyeem.view_taqyeem_search_results',
            compact('results', 'userType', 'isSearch'));
    }


    public function viewResidentDetails()
    {
        if (!request()->ajax()) {
            abort(404);
        }

        return view('admin.contract_members_taqyeem.view_taqyeem_users_search')->render();
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
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public static function sendToMembers()
    {
        $taqawelTemplatePermisionEnv = PermissionServiceEnviroment::taqawel()->with('taqyeemTemplatePermission')->get();
        $directTemplatePermisionEnv = PermissionServiceEnviroment::direct()->with('taqyeemTemplatePermission')->get();
        $hireTemplatePermisionEnv = PermissionServiceEnviroment::hire()->with('taqyeemTemplatePermission')->get();
        foreach ($taqawelTemplatePermisionEnv as $item) {
            if ($item->taqyeemTemplatePermission->ratingModels->status == '1') {
                $endedContracts = Contract::taqawel()->approved()->where('end_date',
                    Carbon::now()->toDateString())->get();
                if ($item->benf == '1') {
                    foreach ($endedContracts as $endedContract) {
                        $mail = [
                            "mailFrom"     => config("mail.from.address"),
                            "mailFromName" => config("mail.from.name"),
                            "mailTo"       => $endedContract->responsible_email,
                        ];
                        Mail::queue('admin.rating_models.emails.taqyeem',
                            [
                                'taqyeemID'  => $item->taqyeemTemplatePermission->ratingModels->id,
                                'contractID' => $endedContract->id
                            ],
                            function ($m) use ($mail) {
                                $m->from($mail['mailFrom'], $mail['mailFromName']);

                                $m->to($mail['mailTo'])->subject(trans("ratingmodels.email.subject"));
                            });
                    }
                }
                if ($item->provider == '1') {
                    foreach ($endedContracts as $endedContract) {
                        $mail = [
                            "mailFrom"     => config("mail.from.address"),
                            "mailFromName" => config("mail.from.name"),
                            "mailTo"       => $endedContract->provider_responsible_email,
                        ];
                        Mail::queue('admin.rating_models.emails.taqyeem',
                            [
                                'taqyeemID'  => $item->taqyeemTemplatePermission->ratingModels->id,
                                'contractID' => $endedContract->id
                            ],
                            function ($m) use ($mail) {
                                $m->from($mail['mailFrom'], $mail['mailFromName']);

                                $m->to($mail['mailTo'])->subject(trans("ratingmodels.email.subject"));
                            });
                    }
                }
            }
        }
        foreach ($directTemplatePermisionEnv as $item) {
            if ($item->taqyeemTemplatePermission->ratingModels->status == '1') {
                $endedContracts = Contract::directEmp()->approved()->where('end_date',
                    Carbon::now()->toDateString())->get();
                if ($item->benf == '1') {
                    foreach ($endedContracts as $endedContract) {
                        $mail = [
                            "mailFrom"     => config("mail.from.address"),
                            "mailFromName" => config("mail.from.name"),
                            "mailTo"       => $endedContract->responsible_email,
                        ];
                        Mail::queue('admin.rating_models.emails.taqyeem',
                            [
                                'taqyeemID'  => $item->taqyeemTemplatePermission->ratingModels->id,
                                'contractID' => $endedContract->id
                            ], function ($m) use ($mail) {
                                $m->from($mail['mailFrom'], $mail['mailFromName']);

                                $m->to($mail['mailTo'])->subject(trans("ratingmodels.email.subject"));
                            });
                    }
                }
                if ($item->provider == '1') {
                    foreach ($endedContracts as $endedContract) {
                        $mail = [
                            "mailFrom"     => config("mail.from.address"),
                            "mailFromName" => config("mail.from.name"),
                            "mailTo"       => $endedContract->provider_responsible_email,
                        ];
                        Mail::queue('admin.rating_models.emails.taqyeem',
                            [
                                'taqyeemID'  => $item->taqyeemTemplatePermission->ratingModels->id,
                                'contractID' => $endedContract->id
                            ], function ($m) use ($mail) {
                                $m->from($mail['mailFrom'], $mail['mailFromName']);

                                $m->to($mail['mailTo'])->subject(trans("ratingmodels.email.subject"));
                            });
                    }
                }
            }
        }
        foreach ($hireTemplatePermisionEnv as $item) {
            if ($item->taqyeemTemplatePermission->ratingModels->status == '1') {
                $endedContracts = Contract::directEmp()->approved()->where('end_date',
                    Carbon::now()->toDateString())->get();
                if ($item->benf == '1') {
                    foreach ($endedContracts as $endedContract) {
                        $mail = [
                            "mailFrom"     => config("mail.from.address"),
                            "mailFromName" => config("mail.from.name"),
                            "mailTo"       => $endedContract->responsible_email,
                        ];
                        Mail::queue('admin.rating_models.emails.taqyeem',
                            [
                                'taqyeemID'  => $item->taqyeemTemplatePermission->ratingModels->id,
                                'contractID' => $endedContract->id
                            ], function ($m) use ($mail) {
                                $m->from($mail['mailFrom'], $mail['mailFromName']);

                                $m->to($mail['mailTo'])->subject(trans("ratingmodels.email.subject"));
                            });
                    }
                }
                if ($item->provider == '1') {
                    foreach ($endedContracts as $endedContract) {
                        $mail = [
                            "mailFrom"     => config("mail.from.address"),
                            "mailFromName" => config("mail.from.name"),
                            "mailTo"       => $endedContract->provider_responsible_email,
                        ];
                        Mail::queue('admin.rating_models.emails.taqyeem',
                            [
                                'taqyeemID'  => $item->taqyeemTemplatePermission->ratingModels->id,
                                'contractID' => $endedContract->id
                            ], function ($m) use ($mail) {
                                $m->from($mail['mailFrom'], $mail['mailFromName']);

                                $m->to($mail['mailTo'])->subject(trans("ratingmodels.email.subject"));
                            });
                    }
                }
            }
        }
    }
}
