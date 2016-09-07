@extends ('admin.layout')
@section('title', trans('ishaar_permissions.ishaar_permissions'))
@section('content')
        <!-- BEGIN BREADCRUMBS -->
<div class="breadcrumbs">
    <h1>{{ trans('ishaar_permissions.ishaar_permissions') }}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">{{trans('user.home')}}</a>
        </li>
        <li class="active">{{ trans('ishaar_permissions.ishaar_permissions') }}</li>
    </ol>
</div>
<!-- END BREADCRUMBS -->
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

                {!! Form::model($ishaarUserPerm, ['route' => ['admin.ishaarPermissions.update', $ishaarUserPerm->hashids], 'id' => 'live_form', 'method' => 'PATCH', 'class' => 'removeCheckboxes']) !!}
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="avl_borrow_labor">{{trans('ishaar_permissions.attributes.labor_borrow_count')}}</label>
                                            {!! Form::number('labor_borrow_count', null, ['min' => 0, 'class' => 'form-control valid']) !!}
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <label for="is_slider">{{trans('ishaar_permissions.service_providers')}}</label>
                                    <div>
                                        <div class="checkbox custom-check checkbox-inline checkbox-red">
                                            <label id="service_providers" class="active">
                                                {!! Form::checkbox('ishaar_issue_est', 1, null , ['class' => 'prov_est toggling_checkbox', 'data-boxclass' => '.activities_box, .est_benf_box']) !!}
                                                <span>{{trans('ishaar_permissions.est')}}</span>
                                            </label>
                                        </div>
                                        <div class="checkbox custom-check checkbox-inline checkbox-red">
                                            <label id="service_providers" class="active">
                                                {!! Form::checkbox('ishaar_issue_gover', 1, null , ['class' => 'prov_gov toggling_checkbox', 'data-boxclass' => '.gov_benf_box']) !!}
                                                <span>{{trans('ishaar_permissions.gov')}}</span>
                                            </label>
                                        </div>
                                        <div class="checkbox custom-check checkbox-inline checkbox-red">
                                            <label id="service_providers" class="active">
                                                {!! Form::checkbox('ishaar_issue_indv', 1, null , ['class' => 'prov_indv toggling_checkbox', 'data-boxclass' => '.indv_benf_box']) !!}
                                                <span>{{trans('ishaar_permissions.indv')}}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-4 est_benf_box"
                                 style="display: {{$ishaarUserPerm->ishaar_issue_est ? 'block' : 'none'}}">
                                <div class="form-group">
                                    <label for="is_slider">{{trans('ishaar_permissions.est_service_beneficials')}}</label>
                                    <div class="beneficials">
                                        <div class="checkbox custom-check checkbox-inline checkbox-red">
                                            <label id="service_beneficials" class="active">
                                                {!! Form::checkbox('ishaar_benf_est', 1, null, ['class' => 'toggling_checkbox benf_est', 'data-boxclass' => '.est_box']) !!}
                                                <span>{{trans('ishaar_permissions.est')}}</span>
                                            </label>
                                        </div>

                                        <div class="checkbox custom-check checkbox-inline checkbox-red">
                                            <label id="service_beneficials" class="active">
                                                {!! Form::checkbox('ishaar_benf_gover', 1, null, ['class' => 'toggling_checkbox benf_gov', 'data-boxclass' => '.gov_box']) !!}
                                                <span>{{trans('ishaar_permissions.gov')}}</span>
                                            </label>
                                        </div>

                                        <div class="checkbox custom-check checkbox-inline checkbox-red">
                                            <label id="service_beneficials" class="active">
                                                {!! Form::checkbox('ishaar_benf_indv', 1, null, ['class' => 'toggling_checkbox benf_indv', 'data-boxclass' => '.indv_box']) !!}
                                                <span>{{trans('ishaar_permissions.indv')}}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 gov_benf_box"
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

                            <div class="col-lg-4 indv_benf_box"
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
                                        @foreach($est_activity as $act)
                                            <tr>
                                                <td>{{$act->activity->name}}</td>
                                                <td>
                                                    <div>
                                                        <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                            <label id="service_beneficials" class="active">
                                                                {!! Form::checkbox('est_perm_activities['.$act->id.'][provider]', 1, empty($act->provider) ? 0 : 1) !!}
                                                                <span>{{trans('est_permission_activities.attributes.provider')}}</span>
                                                            </label>
                                                        </div>

                                                        <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                            <label id="service_beneficials" class="active">
                                                                {!! Form::checkbox('est_perm_activities['.$act->id.'][benf]', 1, empty($act->benf) ? 0 : 1) !!}

                                                                <span>{{trans('est_permission_activities.attributes.benf')}}</span>
                                                            </label>
                                                        </div>

                                                        <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                            <label id="service_beneficials" class="active">
                                                                {!! Form::checkbox('est_perm_activities['.$act->id.'][benf_activity]', 1, empty($act->benf_activity) ? 0 : 1) !!}
                                                                <span>{{trans('est_permission_activities.attributes.benf_activity')}}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {!! Form::number('est_perm_activities['.$act->id.'][loan_pct]', empty($act->loan_pct) ? 0 : $act->loan_pct, ['min' => 0, 'max' => 100]) !!}
                                                </td>
                                                <td>
                                                    {!! Form::number('est_perm_activities['.$act->id.'][borrow_pct]', empty($act->borrow_pct) ? 0 : $act->borrow_pct, ['min' => 0, 'max' => 100]) !!}
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
                                        @foreach($gov_activity as $act)
                                            <tr class="gov_activity">
                                                <td>{!! Form::checkbox('gover_activities['.$act->id.'][chk]', 1, empty($act->chk) ? 0 : 1 ) !!}</td>
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