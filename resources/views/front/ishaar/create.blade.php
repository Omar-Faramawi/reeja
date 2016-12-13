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
                <a href="{{ url(Request::segment(1)) }}">{{trans('ishaar_setup.headings.list')}}</a>
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
                                    <!-- BEGIN FORM-->
                                    {{ Form::open(['route' => 'ishaar.store','method' => 'POST' ,'id'=>'form', 'class'=>'form-horizontal ishaars_form','data-url' => url(Request::segment(1))]) }}
                                    <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.contract_no')}}</label>
                                                <div class="col-md-4">
                                                    <input type="text" name='contract_id' id="contract_id" class="form-control input-circle" value="{{$contract->id or ''}}" disabled="disabled">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.benifit_no')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-circle-left" value="{{$contract->benf_id or ''}}" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.benifit_name')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-circle-left" name='benef_name' id='benef_name' value="{{$contract->benf_name or ''}}" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.benifit_activity')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-circle-left" value="{{$contract->benef->est_activity or ''}}" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.work_start_date')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-circle-left" value="{{$contract->start_date or ''}}" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                           <i class="fa fa-microphone"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.work_end_date')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-circle-left" value="{{$contract->end_date or ''}}" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                           <i class="fa fa-microphone"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.work_region')}}</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control input-circle" value="{{ @$contract->contractLocations[0]->region->name }}" disabled="disabled">
                                                </div>
                                            </div>


                                            <div class="form-group last">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.work_areas')}}</label>
                                                <div class="col-md-4">
                                                    <span class="form-control-static">@foreach($contract->contractLocations as $cc){!! nl2br($cc->desc_location) !!} @endforeach </span>
                                                </div>
                                            </div>


                                        <!-- BEGIN User Details -->
                                    <div class="portlet box yellow">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-comments"></i>{{trans('ishaar_setup.headings.user_details')}} </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-scrollable">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>{{trans('ishaar_setup.form_attributes.id_number')}} </th>
                                                            <th> {{trans('ishaar_setup.form_attributes.name')}} </th>
                                                            <th> {{trans('ishaar_setup.form_attributes.nationality')}} </th>
                                                            <th> {{trans('ishaar_setup.form_attributes.job')}} </th>
                                                            <th> {{trans('ishaar_setup.form_attributes.gender')}} </th>
                                                            <th> {{trans('ishaar_setup.form_attributes.age')}} </th>
                                                            <th> {{trans('ishaar_setup.form_attributes.religion')}} </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($contract->contractEmployee as $ishaar)
                                                        <tr>
                                                            <td class="active"> {{$ishaar->hrPool->id_number or ''}} </td>
                                                            <td class="success"> {{$ishaar->hrPool->name or ''}} </td>
                                                            <td class="warning"> {{$ishaar->hrPool->nationality->name or ''}} </td>
                                                            <td class="danger"> {{$ishaar->hrPool->job->job_name or ''}} </td>
                                                            <td class="active"> @if($ishaar->hrPool){{Tamkeen\Ajeer\Utilities\Constants::gender($ishaar->hrPool->gender)}} @endif</td>
                                                            <td class="success"> {{$ishaar->hrPool->age or ''}} </td>
                                                            <td class="warning"> @if($ishaar->hrPool){{ Tamkeen\Ajeer\Utilities\Constants::religions($ishaar->hrPool->religion)}}@endif </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END User Details -->
                                    <div class='font-red'>
                                        {{trans('ishaar_setup.before_invoice_notice')}}
                                    </div>
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="button" class="btn btn-circle green" id="generate_invoice" >{{trans('ishaar_setup.actions.add_invoice')}}</button>
                                                </div>
                                                
                                                <div class='font-red' id="after_invoice">
                                                    
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