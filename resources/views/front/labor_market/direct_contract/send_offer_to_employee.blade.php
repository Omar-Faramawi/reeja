@extends('front.layout')
@section('title', trans('temp_job.received_contracts'))
@section('content')

    <!-- BEGIN CONTENT BODY -->
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <div class="container">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>{{ trans('labels.system_name') }}
                    <small>{{ trans('temp_job.received_contracts') }}</small>
                </h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
    </div>
    <!-- END PAGE HEAD-->
    <!-- BEGIN PAGE CONTENT BODY -->
    <div class="page-content">
        <div class="container">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN VALIDATION STATES-->
                        <div class="portlet light portlet-fit portlet-datatable">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class=" icon-layers font-red"></i>
                                    <span class="caption-subject font-red sbold uppercase">{{ trans('temp_job.offer_contract') }}</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <!-- BEGIN FORM-->
                                {!! Form::model($employee, ['route' => 'direct_hiring.contracts.create', 'id' => 'form', 'files' => true , 'data-url' => url('/direct-hiring/labor-market') ]) !!}
                                {!! Form::hidden('employee_id', @$employeeId) !!}
                                <div class="form-body">
                                    <div class="portlet blue box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                {{trans("offersdirect.providerInfo")}}
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.providerName")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$username}}
                                                </div>
                                            </div>
                                            @if (session()->get('selected_establishment'))
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.providerType")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{session()->get('selected_establishment.est_activity')}}
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="portlet blue box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                {{trans("offersdirect.benfInfo")}}
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.benfName")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$employee->provider_name}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.benfNo")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$employee->provider_id}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="portlet blue box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                {{ trans('temp_job.application_info') }}
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info padding-top-8">
                                            <div class="col-md-3 name">
                                                {{trans("offersdirect.job")}}
                                            </div>
                                            <div class="col-md-9 value">
                                                {{ $employee->job->job_name }}
                                            </div>
                                            </div>
                                            <div class="row static-info padding-top-8">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.nationality")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $employee->nationality->name }}
                                                </div>
                                            </div>
                                            <div class="row static-info padding-top-8">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.gender")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $employee->gender_name }}
                                                </div>
                                            </div>
                                            <div class="row static-info padding-top-8">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.religion")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $employee->religion_name }}
                                                </div>
                                            </div>
                                            <div class="row static-info padding-top-5">
                                                <div class="col-md-3 name padding-top-8">
                                                    {{ trans('temp_job.work_start_date') }}
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="col-md-9 value form-group form-md-line-input no-padding-top">
                                                    {!! Form::text('start_date', null, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.work_start_date'), 'class' => 'form-control date-picker' ]) !!}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name padding-top-8">
                                                    {{ trans('temp_job.work_end_date') }}
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="col-md-9 value form-group form-md-line-input no-padding-top">
                                                    {!! Form::text('end_date', null, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.work_end_date'), 'class' => 'form-control date-picker' ]) !!}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name padding-top-8">
                                                    {{ trans('temp_job.region_id') }}
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="col-md-9 value form-group form-md-line-input no-padding-top">
                                                    {!! Form::select('region_id[]', $regions ,$employee->region_id, ['class' => 'bs-select form-control', 'readonly' => 'readonly',  'placeholder' => trans("temp_job.region_id") ]) !!}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name padding-top-5">
                                                    {{ trans('temp_job.job_type.name') }}
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="col-md-9 value form-group form-md-line-input no-padding-top">
                                                    <div class="md-radio-inline">
                                                        <div class="md-radio">
                                                            <input type="radio" id="radio6" name="job_type_id" value="1"
                                                                   class="md-radiobtn" @if($employee->job_type ==1) checked @endif>
                                                            <label for="radio6">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> {{ trans('temp_job.job_type.salary') }}
                                                            </label>
                                                        </div>

                                                        <div class="md-radio">
                                                            <input type="radio" id="radio7" name="job_type_id" value="0"
                                                                   class="md-radiobtn" @if($employee->job_type ==0) checked @endif>
                                                            <label for="radio7">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> {{ trans('temp_job.job_type.no_salary') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name padding-top-8">
                                                    {{ trans('temp_job.salary') }}
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="col-md-9 value form-group form-md-line-input no-padding-top">
                                                    {!! Form::text('contract_amount', null, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.salary'), 'class' => 'form-control' ]) !!}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name padding-top-8">
                                                    {{ trans('temp_job.contract_locations') }}
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="col-md-9 value form-group form-md-line-input no-padding-top">
                                                    {!! Form::textarea('contract_locations', null, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.contract_locations'), 'class' => 'form-control' ]) !!}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name padding-top-8">
                                                    {{ trans('temp_job.attachment') }}
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="col-md-9 value no-padding-top">
                                                    @include('components.fileupload', ['name' => 'contract_file'])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <!-- END FORM-->
                            </div>
                        </div>
                        <!-- END VALIDATION STATES-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-align-left col-md-12">
                        <button type="submit" name="status" class="btn green"
                                value="pending">{{ trans('temp_job.save_and_send') }}</button>
                        <button type="reset" class="btn default">{{ trans('temp_job.reset') }}</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <!-- END PAGE CONTENT BODY -->
    <!-- END CONTENT BODY -->
@endsection