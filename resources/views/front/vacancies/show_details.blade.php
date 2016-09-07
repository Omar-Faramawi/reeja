@extends('front.layout')
@section('title', trans('vacancies.headings.list_one'))
@section('content')
<!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{trans('vacancies.headings.list_one')}}</h1>
        </div>
        <!-- END PAGE TITLE -->
    </div>
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE CONTENT BODY -->
<div class="page-content">
    <div class="container">
        <!-- BEGIN PAGE BREADCRUMBS -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ url('/') }}">{{trans('ishaar_setup.headings.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ url('/vacancies') }}">{{trans('vacancies.headings.tab_head')}}</a>
                <i class="fa fa-circle"></i>
            </li>
        </ul>
        <!-- END PAGE BREADCRUMBS -->
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="col-md-12">

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_0">
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i>{{trans('vacancies.headings.list_one')}} </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form class="form-horizontal" id='form'>

                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('vacancies.form_attributes.region_id')}}</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control input-circle" value="{{$vacancy->region->name or ''}}" disabled="disabled">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('vacancies.form_attributes.job')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-circle-left" value="{{$vacancy->job->job_name or ''}}" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('vacancies.form_attributes.gender')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-circle-left" value="{{Tamkeen\Ajeer\Utilities\Constants::gender($vacancy->gender)}} " disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('vacancies.form_attributes.nationality')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-circle-left" value="{{$vacancy->nationality->name or ''}}" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('vacancies.form_attributes.religion')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-circle-left" value="{{Tamkeen\Ajeer\Utilities\Constants::religions($vacancy->religion)}}" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                            <i class="fa fa-microphone"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('vacancies.form_attributes.job_type')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-circle-left" value="{{Tamkeen\Ajeer\Utilities\Constants::jobTypes($vacancy->job_type)}}" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                            <i class="fa fa-microphone"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('vacancies.form_attributes.salary')}}</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control input-circle" value="{{$vacancy->salary or ''}}" disabled="disabled">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('vacancies.form_attributes.work_start_date')}}</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control input-circle" value="{{$vacancy->work_start_date or ''}}" disabled="disabled">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('vacancies.form_attributes.work_end_date')}}</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control input-circle" value="{{$vacancy->work_end_date or ''}}" disabled="disabled">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('vacancies.form_attributes.required_number')}}</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control input-circle" value="{{$vacancy->no_of_vacancies or ''}}" disabled="disabled">
                                                </div>
                                            </div>


                                            <div class="form-group last">
                                                <label class="col-md-3 control-label">{{trans('vacancies.form_attributes.work_areas')}}</label>
                                                <div class="col-md-4">
                                                    <span class="form-control-static">@foreach($vacancy->locations as $cc){{$cc->location}} @endforeach </span>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-9">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END FORM-->
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END PAGE CONTENT BODY -->
<!-- END CONTENT BODY -->
@endsection