@extends('front.layout')
@section('title', trans('ishaar_setup.headings.create'))
@section('content')
        <!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{trans('ishaar_setup.headings.create')}}</h1>
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
                <a href="{{url('taqawel/notices')}}">{{trans('ishaar_setup.headings.list')}}</a>
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
                                        <i class="fa fa-gift"></i>{{trans('ishaar_setup.headings.create')}} </div>
                                </div>
                                <div class="portlet-body form">

                                    <div class="alert alert-danger hidden">
                                        <button class="close" data-close="alert"></button>

                                    </div>
                                    <!-- BEGIN FORM-->
                                    {{ Form::open(['route' => 'taqawel.notices.store','method' => 'POST' ,'id'=>'taqawel_notices_form', 'class'=>'form-horizontal ','data-url' => url('/taqawel/notices')]) }}
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label text-right">{{trans('ishaar_setup.form_attributes.contract_no')}}</label>
                                            <div class="col-md-4">
                                                <input type="text" name='contract_id' id="contract_id"
                                                       class="form-control input-circle" value="{{$contract->id or ''}}"
                                                       disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label text-right">{{trans('ishaar_setup.form_attributes.benifit_no')}}</label>
                                            <div class="col-md-4">
                                                <input type="text" name='benef_id' id="benef_id"
                                                       class="form-control input-circle" value="{{$contract->benf_id or ''}}"
                                                       disabled="disabled">
                                            </div>
                                        </div>

                                        @if($contract->contract_ref_no)
                                            <div class="form-group">
                                                <label class="col-md-3 control-label text-right">{{trans('ishaar_setup.form_attributes.ref_no')}}</label>
                                                <div class="col-md-4">
                                                    <input type="text" name='contract_ref_no' id="contract_ref_no"
                                                           class="form-control input-circle"
                                                           value="{{$contract->contract_ref_no or ''}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label class="col-md-3 control-label text-right">{{trans('ishaar_setup.form_attributes.benifit_name')}}</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input type="text" class="form-control input-circle-left"
                                                           name='benef_name' id='benef_name'
                                                           value="{{ $contract->benf_name or ''}}" disabled="disabled">
                                                    <span class="input-group-addon input-circle-right">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label text-right">{{trans('ishaar_setup.form_attributes.benifit_activity')}}</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input  type="text" class="form-control input-circle-left"
                                                           value="{{ $contract->benef->est_activity or ''}}"
                                                           disabled="disabled">
                                                    <span class="input-group-addon input-circle-right">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" value="{{count($accountType)}}" id="oneormore"/>
                                        <input name="provider_activity" id="provider_activity" type="hidden" value="{{$contract->provider->activity_id or ''}}" >
                                        <input name="benf_activity" id="benf_activity" type="hidden" value="{{$contract->benef->activity_id or ''}}" >
                                        <input name="benf_FK" type="hidden" id="benf_FK" value="{{$contract->benef->FK_establishment_id or ''}}" >

                                        @if(!count($accountType))

                                            <div class="form-group">
                                                <label class="col-md-3 control-label text-right">{{trans('ishaar_setup.attributes.ishaar_start_date')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control date-picker input-circle-left"
                                                               value="{{date("Y-m-d")}}"
                                                               id="start_date" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                           <i class="fa fa-microphone"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label text-right">{{trans('ishaar_setup.attributes.ishaar_end_date')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control date-picker input-circle-left"
                                                               value="{{date('Y-m-d', strtotime('+'.$maxdays.' day'))}}"
                                                               id="end_date" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                           <i class="fa fa-microphone"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="form-group">
                                                <label class="col-md-3 control-label text-right">{{trans('ishaar_setup.attributes.ishaar_start_date')}}</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="start_date" required value=""
                                                           class="form-control input-circle date-picker" id="start_date">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label text-right">{{trans('ishaar_setup.attributes.ishaar_end_date')}}</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="end_date" required value=""
                                                           class="form-control input-circle date-picker" id="end_date">
                                                </div>
                                            </div>

                                        @endif
                                        <input type="hidden" id="contract_start_date" value="{{$contract->start_date}}"/>
                                        <input type="hidden" id="contract_end_date" value="{{$contract->end_date}}"/>


                                        <div class="form-group last">
                                            <label class="col-md-3 control-label text-right">{{trans('ishaar_setup.form_attributes.work_areas')}}</label>
                                            <div class="col-md-4">
                                                <span class="form-control-static">
                                                    <select class="bs-select form-control" name="work_areas"
                                                            id="work_areas"
                                                            @if(count($accountType)) multiple="multiple" @endif>
                                                        @if(!count($contract->contractLocations))
                                                            <option>{{ trans('labels.no_data') }}</option>
                                                        @else
                                                            <option>{{ trans('labels.default') }}</option>
                                                            @foreach($contract->contractLocations as $loc)
                                                                <option value="{{$loc->id}}">{{$loc->desc_location}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- BEGIN User Employees -->
                                        @include('front.taqawel.notices.employees')
                                                <!-- BEGIN User Employees -->
                                        <br/><br/>

                                        <!-- BEGIN User Details -->
                                        <div class="portlet box green taqawel_selected_employees_container" style="display:none">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-comments"></i>{{trans('ishaar_setup.headings.user_details')}}
                                                </div>
                                            </div>
                                            <div class="portlet-body selected_employees_parent">
                                                <div class="table table-responsive">
                                                    <table id="taqawel_selected_employees" class="table table-striped table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th> #</th>
                                                            <th class="no-sort">{{trans('ishaar_setup.form_attributes.id_number')}} </th>
                                                            <th class="no-sort"> {{trans('ishaar_setup.form_attributes.name')}} </th>
                                                            <th class="no-sort"> {{trans('ishaar_setup.form_attributes.nationality')}} </th>
                                                            <th class="no-sort"> {{trans('ishaar_setup.form_attributes.job')}} </th>
                                                            <th class="no-sort"> {{trans('labels.options')}} </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END User Details -->
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="button" class="btn btn-circle green left" id="ensure_data"
                                                        data-token="{{csrf_token()}}">{{trans('ishaar_setup.actions.ensure_data')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
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