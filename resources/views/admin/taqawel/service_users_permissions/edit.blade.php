@extends ('admin.layout')
@section('title', trans('user.dashboardwidgets'))
@section('content')
    <!-- BEGIN BREADCRUMBS -->
    <div class="breadcrumbs">
        <h1>{{ trans('service_users_permissions.service_users_permissions') }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('/admin')}}">{{trans('user.home')}}</a>
            </li>
            <li class="active">{{ trans('service_users_permissions.service_users_permissions') }}</li>
        </ol>
    </div>
    <!-- END BREADCRUMBS -->
    <!-- BEGIN PAGE BASE CONTENT -->


    <div class="m-heading-1 border-green m-bordered">
        <h3> {{ trans('contract_setup.contract_setup') }} </h3>
        <p> {{ trans('service_users_permissions.service_users_permissions') }} </p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings"></i>
                        <span class="caption-subject bold uppercase"> {{ trans('service_users_permissions.service_users_permissions') }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6 pull-right">
                                @if(!empty($can_add) && $can_add)
                                    <div class="btn-group pull-right">
                                        <button data-toggle="modal" data-target="#main"
                                                data-href="{{ route('admin.contractSetup.create', ['id'=>$occupation->id]) }}"
                                                class="btn sbold green"> {{ trans('actions.add') }}
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(count($errors))
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (Session::has('msg'))
                        <div class="alert alert-info">{{ Session::pull('msg') }}</div>
                    @endif

                    {!! Form::model($estServ->toArray(), ['route' => ['admin.serviceUsersPermissions.contractType.update', $estServ->hashids], 'id' => 'live_form', 'method' => 'PATCH', 'class' => 'removeCheckboxes']) !!}
                    {!! Form::hidden('contract_type_id',null, ['id' => 'contract_type_id']) !!}
                    {!! Form::hidden('service_prvdr_benf_id',null, ['id' => 'service_prvdr_benf_id']) !!}
                    <div class="col-lg-2"></div>
                    <div class="col-lg-10">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="is_slider">{{trans('service_users_permissions.service_providers')}}</label>
                                        <div>
                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                <label id="service_providers" class="active">
                                                    {!! Form::hidden('estIsProvider', 0) !!}
                                                    {!! Form::checkbox('estIsProvider', 1, $estServ->trashed() ? null : 1, ['class' => 'prov_est toggling_checkbox', 'data-boxclass' => '.activities_box, .est_benf_box']) !!}

                                                    <span>{{trans('service_users_permissions.est')}}</span>
                                                </label>
                                            </div>

                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                <label id="service_providers" class="active">
                                                    {!! Form::hidden('indvIsProvider', 0) !!}
                                                    {!! Form::checkbox('indvIsProvider', 1, $indvServ->trashed() ? null : 1, ['class' => 'prov_indv toggling_checkbox', 'data-boxclass' => '.indv_benf_box']) !!}
                                                    <span>{{trans('service_users_permissions.indv')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6 est_benf_box"
                                     style="display: {{!$estServ->trashed() ? 'block' : 'none'}}">
                                    <div class="form-group">
                                        <label for="is_slider">{{trans('service_users_permissions.est_service_beneficials')}}</label>
                                        <div class="beneficials">
                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                <label id="service_beneficials" class="active">
                                                    {!! Form::hidden('benf_est', 0) !!}
                                                    {!! Form::checkbox('benf_est', 1, null, ['class' => 'toggling_checkbox benf_est', 'data-boxclass' => '.est_box']) !!}

                                                    <span>{{trans('service_users_permissions.est')}}</span>
                                                </label>
                                            </div>

                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                <label id="service_beneficials" class="active">
                                                    {!! Form::hidden('benf_gover', 0) !!}
                                                    {!! Form::checkbox('benf_gover', 1, null, ['class' => 'toggling_checkbox benf_gov', 'data-boxclass' => '.gov_box']) !!}

                                                    <span>{{trans('service_users_permissions.gov')}}</span>
                                                </label>
                                            </div>

                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                <label id="service_beneficials" class="active">
                                                    {!! Form::hidden('benf_indv', 0) !!}
                                                    {!! Form::checkbox('benf_indv', 1, null, ['class' => 'toggling_checkbox benf_indv', 'data-boxclass' => 'indv_box']) !!}

                                                    <span>{{trans('service_users_permissions.indv')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 indv_benf_box"
                                     style="display: {{!$indvServ->trashed() ? 'block' : 'none'}}">
                                    <div class="form-group">
                                        <label for="is_slider">{{trans('service_users_permissions.indv_service_beneficials')}}</label>
                                        <div class="beneficials">
                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                <label id="service_beneficials" class="active">
                                                    {!! Form::hidden('benf_indv_from_est', 0) !!}
                                                    {!! Form::checkbox('benf_indv_from_est', null, 1, ['class' => 'toggling_checkbox benf_indv_from_est', 'data-boxclass' => 'indv_box']) !!}

                                                    <span>{{trans('service_users_permissions.indv')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="activities_box" style="display: {{$estServ->trashed() ? "none" : "block"}}">

                                <div class="panel panel-info est_box"
                                     style="display: {{$estServ->benf_est ? 'block' : 'none'}}">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">{{trans('est_permission_activities.est_permission_activities')}}</h3>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-condensed table-hover table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>{{trans('est_permission_activities.attributes.activity_id')}}</th>
                                                <th>{{trans('est_permission_activities.permissions')}}</th>
                                                <th>{{trans('est_permission_activities.attributes.loan_pct')}}</th>
                                                <th>{{trans('est_permission_activities.attributes.borrow_pct')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($activities as $key => $act)
                                                {!! Form::hidden('est_perm_activities['.$key.'][activity_id]', $act['id']) !!}
                                                {!! Form::hidden('est_perm_activities['.$key.'][service_users_permission_id]', $serUserPermId) !!}
                                                <tr>
                                                    <td>{{$act['name']}}</td>
                                                    <td>
                                                        <div>
                                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                                <label id="service_beneficials" class="active">
                                                                    {!! Form::hidden('est_perm_activities['.$key.'][provider]', 0) !!}
                                                                    {!! Form::checkbox('est_perm_activities['.$key.'][provider]', 1,
                                                                    isset($act['establishments'][0]['loan_pct']) && !empty($act['establishments'][0]['provider']) ? 1 : null) !!}

                                                                    <span>{{trans('est_permission_activities.attributes.provider')}}</span>
                                                                </label>
                                                            </div>

                                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                                <label id="service_beneficials" class="active">
                                                                    {!! Form::hidden('est_perm_activities['.$key.'][benf]', 0) !!}
                                                                    {!! Form::checkbox('est_perm_activities['.$key.'][benf]', 1,
                                                                    isset($act['establishments'][0]['loan_pct']) && !empty($act['establishments'][0]['benf']) ? 1 : null) !!}

                                                                    <span>{{trans('est_permission_activities.attributes.benf')}}</span>
                                                                </label>
                                                            </div>

                                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                                <label id="service_beneficials" class="active">
                                                                    {!! Form::hidden('est_perm_activities['.$key.'][benf_activity]', 0) !!}
                                                                    {!! Form::checkbox('est_perm_activities['.$key.'][benf_activity]', 1,
                                                                    isset($act['establishments'][0]['loan_pct']) && !empty($act['establishments'][0]['benf_activity']) ? 1 : null) !!}

                                                                    <span>{{trans('est_permission_activities.attributes.benf_activity')}}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {!! Form::number('est_perm_activities['.$key.'][loan_pct]', isset($act['establishments'][0]['loan_pct']) ? $act['establishments'][0]['loan_pct']: '', ['min' => 0, 'max' => 100]) !!}
                                                    </td>
                                                    <td>
                                                        {!! Form::number('est_perm_activities['.$key.'][borrow_pct]', isset($act['establishments'][0]['borrow_pct']) ? $act['establishments'][0]['borrow_pct']: '', ['min' => 0, 'max' => 100]) !!}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="panel panel-info gov_box"
                                     style="display: {{$estServ->benf_gover ? 'block' : 'none'}}">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">{{trans('gov_permission_activities.gov_permission_activities')}}</h3>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-condensed table-hover table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>{{trans('gov_permission_activities.attributes.activity_id')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($activities as $key => $act)
                                                <tr class="gov_activity">
                                                    {!! Form::hidden('gover_activities['.$key.'][activity_id]', $act['id']) !!}
                                                    <td>{!! Form::checkbox('gover_activities['.$key.'][activity_id]', $act['id'],  in_array($act['id'], array_column($estServ->goverActivities->toArray(), 'activity_id')) ? 1 : 0 ) !!}</td>
                                                    <td>{{$act['name']}}</td>
                                                    {!! Form::hidden('gover_activities['.$key.'][service_users_permission_id]', 1) !!}
                                                    {!! Form::hidden('gover_activities['.$key.'][checked]', 1, ['class' => 'act_checked']) !!}
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                    <div class="row">
                        <div class="col col-lg-2">
                            <label for="" class="col-md-3 control-label">&nbsp;</label>
                        </div>
                        <div class="col col-lg-10">
                            <button type="submit" data-loading-text="{{ trans('contract_setup.saving') }}..."
                                    class="demo-loading-btn btn blue">{{trans('contract_setup.save')}}</button>
                        </div>
                    </div>
                    </form>

                    <div class="clearfix"></div>

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>

    <!-- BEGIN DASHBOARD STATS 1-->

    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->
    <!-- END PAGE BASE CONTENT -->

@endsection