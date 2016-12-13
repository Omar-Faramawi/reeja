@extends ('admin.layout')
@section('title', trans('ishaar_permissions.ishaar_permissions'))
@section('content')
<!-- BEGIN PAGE BASE CONTENT -->

<div class="m-heading-1 border-green m-bordered">
    <h3> {{ trans('contract_setup.contract_setup') }} </h3>
    <p> {{ trans('ishaar_permissions.ishaar_permissions') }} </p>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i>
                    <span class="caption-subject bold uppercase"> {{ trans('ishaar_permissions.ishaar_permissions') }}</span>
                </div>
            </div>
            <div class="portlet-body">
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
                {!! Form::model($ishaarUserPerm, ['route' => ['admin.ishaarPermissions.update', $ishaarUserPerm->hashids], 'id' => 'live_form', 'method' => 'PATCH', 'class' => 'removeCheckboxes']) !!}
                    <div class="col-lg-2"></div>
                    <div class="col-lg-10">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="col-lg-4">
                                            <label for="avl_borrow_labor">{{trans('ishaar_permissions.attributes.labor_borrow_count')}}</label>
                                            {!! Form::hidden('ishaar_issue_est', 0) !!}
                                            {!! Form::hidden('ishaar_issue_gover', 0) !!}
                                            {!! Form::hidden('ishaar_issue_indv', 0) !!}
                                        </div>
                                        <div class="col-lg-3">
                                            {!! Form::number('labor_borrow_count', null, ['min' => 0, 'class' => 'form-control valid']) !!}
                                        </div>
                                        <div class="clearfix"></div>
                                        <label for="is_slider">{{trans('ishaar_permissions.service_providers')}}</label>
                                        <div class="checkbox-list margin-top-10">
                                            <label class="checkbox-inline">
                                                {!! Form::checkbox('ishaar_issue_est', 1, $ishaarUserPerm->ishaar_issue_est ? 1 :null , ['class' => 'prov_est toggling_checkbox', 'data-boxclass' => '.activities_box, .est_benf_box']) !!}
                                                {{trans('ishaar_permissions.est')}}
                                            </label>
                                            <label class="checkbox-inline">
                                                {!! Form::checkbox('ishaar_issue_gover', 1, $ishaarUserPerm->ishaar_issue_gover ? 1 :null , ['class' => 'prov_gov toggling_checkbox', 'data-boxclass' => '.gov_benf_box']) !!}
                                                {{trans('ishaar_permissions.gov')}}
                                            </label>
                                            <label class="checkbox-inline">
                                                {!! Form::checkbox('ishaar_issue_indv', 1, $ishaarUserPerm->ishaar_issue_indv ? 1 :null , ['class' => 'prov_indv toggling_checkbox', 'data-boxclass' => '.indv_benf_box']) !!}
                                                {{trans('ishaar_permissions.indv')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6 est_benf_box"
                                     style="display: {{$ishaarUserPerm->ishaar_issue_est ? 'block' : 'none'}}">
                                    <div class="form-group">
                                        <label for="is_slider">{{trans('ishaar_permissions.est_service_beneficials')}}</label>
                                        {!! Form::hidden('ishaar_benf_est', 0) !!}
                                        {!! Form::hidden('ishaar_benf_gover', 0) !!}
                                        {!! Form::hidden('ishaar_benf_indv', 0) !!}
                                        <div class="beneficials checkbox-list margin-top-10">
                                            <label id="service_beneficials" class="checkbox-inline">
                                                {!! Form::checkbox('ishaar_benf_est', 1, $ishaarUserPerm->ishaar_benf_est ? 1 :null, ['class' => 'toggling_checkbox benf_est', 'data-boxclass' => '.est_box']) !!}
                                                {{trans('ishaar_permissions.est')}}
                                            </label>
                                            <label id="service_beneficials" class="checkbox-inline">
                                                {!! Form::checkbox('ishaar_benf_gover', 1, $ishaarUserPerm->ishaar_benf_gover ? 1 :null, ['class' => 'toggling_checkbox benf_gov', 'data-boxclass' => '.gov_box']) !!}
                                                {{trans('ishaar_permissions.gov')}}
                                            </label>
                                            <label id="service_beneficials" class="checkbox-inline">
                                                {!! Form::checkbox('ishaar_benf_indv', 1, $ishaarUserPerm->ishaar_benf_indv ? 1 :null, ['class' => 'toggling_checkbox benf_indv', 'data-boxclass' => '.indv_box']) !!}
                                                {{trans('ishaar_permissions.indv')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 gov_benf_box"
                                     style="display: {{$ishaarUserPerm->ishaar_issue_gover ? 'block' : 'none'}}">
                                    <div class="form-group">
                                        <label for="is_slider">{{trans('ishaar_permissions.gov_service_beneficials')}}</label>
                                        <div class="beneficials">
                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                <label id="service_beneficials" class="active">
                                                    {!! Form::checkbox('ishaar_issue_gover', 1, 1, ['class' => 'toggling_checkbox', 'data-boxclass' => '.indv_box', 'disabled']) !!}
                                                    <span>{{trans('ishaar_permissions.indv')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 indv_benf_box"
                                     style="display: {{$ishaarUserPerm->ishaar_issue_indv ? 'block' : 'none'}}">
                                    <div class="form-group">
                                        <label for="is_slider">{{trans('ishaar_permissions.indv_service_beneficials')}}</label>
                                        <div class="beneficials">
                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                <label id="service_beneficials" class="active">
                                                    {!! Form::checkbox('ishaar_issue_indv', 1, 1, ['class' => 'toggling_checkbox', 'data-boxclass' => '.indv_box', 'disabled']) !!}
                                                    <span>{{trans('ishaar_permissions.indv')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="activities_box"
                                 style="display: {{$ishaarUserPerm->ishaar_issue_est ? "block": "none" }}">

                                <div class="panel panel-info est_box"
                                     style="display: {{$ishaarUserPerm->ishaar_benf_est ? "block":  'none'}}">
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
                                            @foreach($est_activity as $key=>$act)
                                                <tr>
                                                    <td>{!! Form::hidden('est_perm_activities['.$key.'][activity_id]', $act->activity_id) !!}
                                                {!! Form::hidden('est_perm_activities['.$key.'][provider]', 0) !!}
                                                {!! Form::hidden('est_perm_activities['.$key.'][benf]', 0) !!}
                                                {!! Form::hidden('est_perm_activities['.$key.'][benf_activity]', 0) !!}
                                                {!! Form::hidden('activities['.$key.'][activity_name]', $act->activity->name) !!}{{$act->activity->name}}</td>
                                                    <td>
                                                        <div>
                                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                                <label id="service_beneficials" class="active">

                                                                    {!! Form::checkbox('est_perm_activities['.$key.'][provider]', 1, isset($act->loan_pct) && !empty($act->provider) ? 1 : null) !!}
                                                                    <span>{{trans('est_permission_activities.attributes.provider')}}</span>
                                                                </label>
                                                            </div>

                                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                                <label id="service_beneficials" class="active">
                                                                    {!! Form::checkbox('est_perm_activities['.$key.'][benf]', 1, !empty($act->benf) ? 1 : null) !!}

                                                                    <span>{{trans('est_permission_activities.attributes.benf')}}</span>
                                                                </label>
                                                            </div>

                                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                                <label id="service_beneficials" class="active">
                                                                    {!! Form::checkbox('est_perm_activities['.$key.'][benf_activity]', 1, !empty($act->benf_activity) ? 1 : null) !!}
                                                                    <span>{{trans('est_permission_activities.attributes.benf_activity')}}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                    {!! Form::number('est_perm_activities['.$key.'][loan_pct]', isset($act->loan_pct) ? ($act->loan_pct !=0? $act->loan_pct: '') : '', ['min' => 0, 'max' => 100]) !!}

                                                    </td>
                                                    <td>
                                                        {!! Form::number('est_perm_activities['.$key.'][borrow_pct]', isset($act->borrow_pct) ? ($act->borrow_pct !=0? $act->borrow_pct: '') : '', ['min' => 0, 'max' => 100]) !!}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="panel panel-info gov_box"
                                     style="display: {{$ishaarUserPerm->ishaar_benf_gover ? 'block' : 'none'}}">
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
                                            @foreach($gov_activity as $key=>$act)
                                                <tr class="gov_activity">
                                                    <td>{!! Form::hidden('gover_activities['.$key.'][activity_id]', $act->activity_id) !!}
                                                        {!! Form::checkbox('gover_activities['.$key.'][chk]', 1, empty($act->chk) ? 0 : 1 ) !!}</td>
                                                    <td>{{$act->activity->name}}</td>
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

@endsection