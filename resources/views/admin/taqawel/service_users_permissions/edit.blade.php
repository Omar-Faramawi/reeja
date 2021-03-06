@extends ('admin.layout')
@section('title', trans('service_users_permissions.service_users_permissions'))
@section('content')
        <!-- BEGIN PAGE BASE CONTENT -->

<div class="m-heading-1 border-green m-bordered">
    <h3> {{ trans('contract_setup.contract_setup') }} </h3>
    <p> {{ trans('service_users_permissions.service_users_permissions') }} </p>
    <div class="row">
        <div class="form-body">

            <div class="col-md-2 pull-right">
                <div class="form-group">
                    {{Form::select('',$filterActivites,null,['id'=>'filter','placeholder'=>trans('service_users_permissions.selectActivity')])}}
                </div>
            </div>
        </div>
    </div>
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
                <div class="form-body">
                    {!! Form::model($estServ->toArray(), ['route' => ['admin.serviceUsersPermissions.contractType.update', $estServ->hashids], 'id' => 'live_form', 'method' => 'PATCH', 'class' => 'removeCheckboxes']) !!}
                    {!! Form::hidden('contract_type_id',null, ['id' => 'contract_type_id']) !!}
                    {!! Form::hidden('service_prvdr_benf_id',null, ['id' => 'service_prvdr_benf_id']) !!}
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="is_slider col-lg-12">
                                        {{trans('service_users_permissions.service_providers')}}
                                        {!! Form::hidden('estIsProvider', 0) !!}
                                        {!! Form::hidden('govIsProvider', 0) !!}
                                        {!! Form::hidden('indvIsProvider', 0) !!}
                                    </label>
                                    <div class="checkbox-list col-lg-12">
                                        <label class="checkbox-inline">
                                            {!! Form::checkbox('estIsProvider', 1, $estServ->trashed() ? null : 1, ['id' => 'inlineCheckbox21','class' => 'prov_est toggling_checkbox', 'data-boxclass' => '.activities_box, .est_benf_box']) !!}
                                            {{trans('service_users_permissions.est')}}
                                        </label>
                                        <label class="checkbox-inline">
                                            {!! Form::checkbox('govIsProvider', 1, $govServ->trashed() ? null : 1, ['id' => 'inlineCheckbox22','class' => 'prov_gov toggling_checkbox']) !!}
                                            {{trans('service_users_permissions.gov')}}
                                        </label>
                                        <label class="checkbox-inline">
                                            {!! Form::checkbox('indvIsProvider', 1, $indvServ->trashed() ? null : 1, ['id' => 'inlineCheckbox23','class' => 'prov_indv toggling_checkbox', 'data-boxclass' => '.indv_benf_box']) !!}
                                            {{trans('service_users_permissions.indv')}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-6 est_benf_box"
                                 style="display: {{!$estServ->trashed() ? 'block' : 'none'}}">
                                <div class="form-group">
                                    <label for="is_slider col-lg-12">
                                        {{trans('service_users_permissions.est_service_beneficials')}}
                                        {!! Form::hidden('benf_est', 0) !!}
                                        {!! Form::hidden('benf_gover', 0) !!}
                                        {!! Form::hidden('benf_indv', 0) !!}
                                    </label>
                                    <div class="beneficials checkbox-list col-lg-12">
                                        <label id="service_beneficials" class="checkbox-inline">
                                            {!! Form::checkbox('benf_est', 1, null, ['class' => 'toggling_checkbox benf_est', 'data-boxclass' => '.est_box']) !!}
                                            {{trans('service_users_permissions.est')}}
                                        </label>
                                        <label id="service_beneficials" class="checkbox-inline">
                                            {!! Form::checkbox('benf_gover', 1, null, ['class' => 'toggling_checkbox benf_gov', 'data-boxclass' => '.gov_box']) !!}
                                            {{trans('service_users_permissions.gov')}}
                                        </label>
                                        <label id="service_beneficials" class="checkbox-inline">
                                            {!! Form::checkbox('benf_indv', 1, null, ['class' => 'toggling_checkbox benf_indv', 'data-boxclass' => 'indv_box']) !!}
                                            {{trans('service_users_permissions.indv')}}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{--                                <div class="col-lg-6 indv_benf_box" style="display: {{!$indvServ->trashed() ? 'block' : 'none'}}">
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
                                                            </div>--}}
                        </div>

                        <div class="activities_box" style="display: {{$estServ->trashed() ? "none" : "block"}}">

                            <div class="panel panel-info est_box"
                                 style="display: {{$estServ->benf_est ? 'block' : 'none'}}">
                                <div class="panel-heading">
                                    <h3 class="panel-title">{{trans('est_permission_activities.est_permission_activities')}}</h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-condensed table-hover table-striped table-bordered"
                                           id="table">
                                        <thead>
                                        <tr>
                                            <th>{{trans('est_permission_activities.attributes.activity_id')}}</th>
                                            <th>{{trans('est_permission_activities.permissions')}}</th>
<!--                                            <th>{{trans('est_permission_activities.attributes.loan_pct')}}</th>
                                            <th>{{trans('est_permission_activities.attributes.borrow_pct')}}</th>-->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($activities as $key => $act)

                                            <tr>
                                                <td>
                                                    {!! Form::hidden('est_perm_activities['.$key.'][activity_id]', $act['id']) !!}
                                                    {!! Form::hidden('est_perm_activities['.$key.'][service_users_permission_id]', $serUserPermId) !!}
                                                    {!! Form::hidden('est_perm_activities['.$key.'][provider]', 0) !!}
                                                    {!! Form::hidden('est_perm_activities['.$key.'][benf]', 0) !!}
                                                    {!! Form::hidden('est_perm_activities['.$key.'][benf_activity]', 0) !!}
                                                    {!! Form::hidden('value_to_compare', 0) !!}
                                                    {!! Form::hidden('est_activities['.$key.'][activity_name]', $act['name']) !!}
                                                    {{$act['name']}}
                                                </td>
                                                <td>
                                                    <div class="checkbox-list">
                                                        <label class="checkbox-inline">
                                                            {!! Form::checkbox('est_perm_activities['.$key.'][provider]', 1,
                                                            isset($act['establishments'][0]['loan_pct']) && !empty($act['establishments'][0]['provider']) ? 1 : null) !!}

                                                            {{trans('est_permission_activities.attributes.provider')}}
                                                        </label>

                                                        <label class="checkbox-inline">
                                                            {!! Form::checkbox('est_perm_activities['.$key.'][benf]', 1,
                                                            isset($act['establishments'][0]['loan_pct']) && !empty($act['establishments'][0]['benf']) ? 1 : null) !!}

                                                            {{trans('est_permission_activities.attributes.benf')}}
                                                        </label>

                                                        <label class="checkbox-inline">

                                                            {!! Form::checkbox('est_perm_activities['.$key.'][benf_activity]', 1,
                                                            isset($act['establishments'][0]['loan_pct']) && !empty($act['establishments'][0]['benf_activity']) ? 1 : null) !!}

                                                            {{trans('est_permission_activities.attributes.benf_activity')}}
                                                        </label>

                                                    </div>
                                                </td>
<!--                                                <td>
                                                    {!! Form::number('est_perm_activities['.$key.'][loan_pct]', isset($act['establishments'][0]['loan_pct']) ? ($act['establishments'][0]['loan_pct'] !=0? $act['establishments'][0]['loan_pct']: '') : '', ['min' => 0, 'max' => 100]) !!}

                                                </td>
                                                <td>
                                                    {!! Form::number('est_perm_activities['.$key.'][borrow_pct]', isset($act['establishments'][0]['borrow_pct']) ? ($act['establishments'][0]['borrow_pct'] !=0 ?$act['establishments'][0]['borrow_pct'] : '') : '', ['min' => 0, 'max' => 100]) !!}
                                                </td>-->
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
                                    <table class="table table-condensed table-hover table-striped table-bordered"
                                           id="table2">
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
                                                <td>{!! Form::checkbox('gover_activities['.$key.'][service_users_permission_id]',1,(empty($act['governments'])?false:true)) !!}</td>
                                                <td>{{$act['name']}}</td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                    <div class="row">
                        <div class="col col-lg-12">
                            <button type="submit" data-loading-text="{{ trans('contract_setup.saving') }}..."
                                    class="demo-loading-btn btn blue">{{trans('contract_setup.save')}}</button>
                            <a href="{{route('admin.serviceUsersPermissions.contractType.edit', Hashids::encode(1))}}"
                               class="btn red">{{ trans('labels.cancel') }}</a>
                        </div>
                    </div>
                    </form>
                </div>
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
<style>
    .tr_has_error {
        background-color: #fbe1e3;
    }
</style>
@endsection