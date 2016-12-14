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
                        @if(empty($contract))
                            <div class="portlet light portlet-fit portlet-form ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class=" icon-layers font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">{{ trans('temp_job.received_contracts') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if(!empty($contract))
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
                                    {!! Form::model($contract, ['route' => 'received-contracts.update', 'id' => 'form', 'files' => true , 'data-url' => url('/temp_work/received-contracts') ]) !!}
                                    {!! Form::hidden('contract_id', @$contract_id) !!}
                                    <div class="form-body">
                                        <div class="portlet blue box">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-info-circle"></i>
                                                    {{trans("temp_job.service_benf_info")}}
                                                </div>
                                            </div>
                                            <div class="portlet-body">

                                                <div class="row static-info">
                                                    <div class="col-md-3 name">
                                                        {{trans("temp_job.service_benf_number")}}
                                                    </div>
                                                    <div class="col-md-9 value">
                                                        {{$contract->benf_id}}
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-3 name">
                                                        {{trans("temp_job.service_benf_name")}}
                                                    </div>
                                                    <div class="col-md-9 value">
                                                        {{$contract->benf_name}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="portlet blue box">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-info-circle"></i>
                                                    {{trans("temp_job.service_provider_info")}}
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="row static-info">
                                                    <div class="col-md-3 name">
                                                        {{trans("temp_job.service_provider_number")}}
                                                    </div>
                                                    <div class="col-md-9 value">
                                                        {{$contract->provider_id}}
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-3 name">
                                                        {{trans("temp_job.service_provider_name")}}
                                                    </div>
                                                    <div class="col-md-9 value">
                                                        {{$contract->provider_name}}
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
                                                <div class="row static-info">
                                                    <div class="col-md-3 name padding-top-8">
                                                        {{ trans('temp_job.work_start_date') }}
                                                        <span class="required">*</span>
                                                    </div>
                                                    <div class="col-md-9 value form-group form-md-line-input no-padding-top">
                                                        {!! Form::text('start_date', $contract->work_start_date, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.work_start_date'), 'class' => 'form-control date-picker' ]) !!}
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-3 name padding-top-8">
                                                        {{ trans('temp_job.work_end_date') }}
                                                        <span class="required">*</span>
                                                    </div>
                                                    <div class="col-md-9 value form-group form-md-line-input no-padding-top">
                                                        {!! Form::text('end_date', $contract->work_end_date, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.work_end_date'), 'class' => 'form-control date-picker' ]) !!}
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-3 name padding-top-8">
                                                        {{ trans('temp_job.region_id') }}
                                                        <span class="required">*</span>
                                                    </div>
                                                    <div class="col-md-9 value form-group form-md-line-input no-padding-top">
                                                        @if(request()->segment(1) !== "occasional-work")
                                                            {!! Form::select('region_id[]', $regions , $contract->region_id, ['class' => 'bs-select form-control', 'placeholder' => trans("labels.noneSelectedTextValueSmall")]) !!}
                                                        @else
                                                            {!! Form::select('region_id[]', $regions , [1], ['class' => 'bs-select form-control', 'readonly' => 'readonly',  'placeholder' => trans("labels.noneSelectedTextValueSmall") ]) !!}
                                                        @endif
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
                                                    <div class="col-md-3 name padding-top-5">
                                                        {{ trans('temp_job.job_type.name') }}
                                                        <span class="required">*</span>
                                                    </div>
                                                    <div class="col-md-9 value form-group form-md-line-input no-padding-top">
                                                        <div class="md-radio-inline">
                                                            <div class="md-radio">
                                                                <input type="radio" id="radio6" name="job_type_id" value="1"
                                                                       class="md-radiobtn" @if($contract->job_type ==1) checked @endif>
                                                                <label for="radio6">
                                                                    <span></span>
                                                                    <span class="check"></span>
                                                                    <span class="box"></span> {{ trans('temp_job.job_type.salary') }}
                                                                </label>
                                                            </div>

                                                            <div class="md-radio">
                                                                <input type="radio" id="radio7" name="job_type_id" value="0"
                                                                       class="md-radiobtn" @if($contract->job_type ==0) checked @endif>
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
														{{ trans('temp_job.attachment') }}
													</div>
													<div class="col-md-9 form-group">
														@include('components.fileupload', ['name' => 'contract_file'])
													</div>
												</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="portlet box grey-cascade labor_employee_data">
                                        <div class="portlet-title">
                                            <div class="caption">{{ trans('temp_job.employees') }}</div>
                                        </div>
                                        <div class="portlet-body">
                                            <table class="table table-striped table-bordered table-hover table-checkable dataTable no-footer"
                                                   id="datatable_ajax" data-url="{{ route('contract-employee.index') }}"
                                                   data-token="{{ csrf_token() }}" data-type="POST">
                                                <thead>
                                                <tr role="row" class="heading">
                                                    <th id="check" class="no-sort"></th>
                                                    <th id="id" class="no-sort">{{ trans('temp_job.record') }}</th>
                                                    <th id="id_number" class="no-sort">{{ trans('temp_job.national_id') }}</th>
                                                    <th id="name" class="no-sort" width="200">{{ trans('temp_job.name') }}</th>
                                                    <th id="nationality.name" class="no-sort">{{ trans('temp_job.nationality_id')  }}</th>
                                                    <th id="gender_name" class="no-sort">{{ trans('temp_job.gender.name') }}</th>
                                                    <th id="job.job_name" class="no-sort">{{ trans('temp_job.job_id') }}</th>
                                                    <th id="age" class="no-sort">{{ trans('temp_job.age') }}</th>
                                                    <th id="religion_name" class="no-sort"> {{ trans('temp_job.religion_id') }}</th>
                                                    <th id="work_start_date" class="no-sort">{{ trans('temp_job.work_start_date') }}</th>
                                                    <th id="work_end_date" class="no-sort">{{ trans('temp_job.work_end_date') }}</th>
                                                    <th id="region.name" class="no-sort">{{ trans('temp_job.region_id') }}</th>
                                                    <th id="details" class="no-sort">{{ trans('temp_job.details') }}</th>
                                                </tr>
                                                <tr role="row" class="filter">
                                                    <td></td>
                                                    <td>
                                                        <input type="text" class="form-control form-filter input-sm"
                                                               name="id">
                                                    </td>
                                                    <td>
                                                        {{ Form::text('id_number', '', ['class' => "form-control form-filter input-sm"]) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('name', '', ['class' => "form-control form-filter input-sm"]) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::select('nationality_id', $nationalities, '', ['class' => 'form-control form-filter bs-select input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall'), "data-live-search" => "true"]) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::select('gender', \Tamkeen\Ajeer\Utilities\Constants::gender(), '', ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall')]) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::select('job_id', $jobs , '', ['class' => 'form-control form-filter bs-select input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall'), "data-live-search" => "true"]) }}
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        {{ Form::select('religion', \Tamkeen\Ajeer\Utilities\Constants::religions() , '', ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall')]) }}
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                                            <i class="fa fa-search"></i> {{ trans('labels.search') }}
                                                        </button>
                                                        <button class="btn btn-sm red btn-outline filter-cancel">
                                                            <i class="fa fa-times"></i> {{ trans('labels.reset') }}
                                                        </button>
                                                    </td>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                            <button type="button" class="btn blue pull-right" id="labor_click"
                                                    value="pending">{{ trans('temp_job.add') }}</button>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                    <div class="portlet box blue" id="contract_requests" @if(!$contract->contractEmployee) style="display: none" @endif>
                                        <div class="portlet-title">
                                            <div class="caption">{{ trans('temp_job.registered_employee') }}</div>
                                        </div>
                                        <div class="portlet-body selected_employees_parent">
                                            <div class="table table-responsive">
                                                <table id="selected_employees" class="table table-striped table-bordered">
                                                    <thead>
                                                    <tr role="row" class="heading">
                                                        <th id="id" class="no-sort">{{ trans('temp_job.record') }}</th>
                                                        <th id="id_number" class="no-sort">{{ trans('temp_job.national_id') }}</th>
                                                        <th id="name" class="no-sort" width="200">{{ trans('temp_job.employee_name') }}</th>
                                                        <th id="nationality.name" class="no-sort">{{ trans('temp_job.nationality_id')  }}</th>
                                                        <th id="gender_name" class="no-sort">{{ trans('temp_job.gender.name') }}</th>
                                                        <th id="job.job_name" class="no-sort">{{ trans('temp_job.job_id') }}</th>
                                                        <th id="age" class="no-sort">{{ trans('temp_job.age') }}</th>
                                                        <th id="religion_name" class="no-sort"> {{ trans('temp_job.religion_id') }}</th>
                                                        <th id="work_start_date" class="no-sort">{{ trans('temp_job.work_start_date') }}</th>
                                                        <th id="work_end_date" class="no-sort">{{ trans('temp_job.work_end_date') }}</th>
                                                        <th id="region.name" class="no-sort">{{ trans('temp_job.region_id') }}</th>
                                                        <th>{{ trans('temp_job.salary') }}</th>
                                                        <th>{{ trans('temp_job.attach_qualifications') }}</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(isset($contract->contractEmployee))
                                                        @foreach($contract->contractEmployee as $employee)
                                                            <tr id="selected_row_{{ $employee->id_number }}">
                                                                <td>{{ $employee->id }}</td>
                                                                <td>{{ @$employee->hrPool->id_number }}</td>
                                                                <td>{{ @$employee->hrPool->name }}</td>
                                                                <td>{{ @$employee->hrPool->nationality->name }}</td>
                                                                <td>{{ @$employee->hrPool->gender_name }}</td>
                                                                <td>{{ @$employee->hrPool->job->job_name }}</td>
                                                                <td>{{ @$employee->hrPool->age }}</td>
                                                                <td>{{ @$employee->hrPool->religion_name }}</td>
                                                                <td>{{ @$employee->hrPool->work_start_date }}</td>
                                                                <td>{{ @$employee->hrPool->work_end_date }}</td>
                                                                <td>{{ @$employee->hrPool->region->name }}</td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input class="form-control form-filter input-sm salary-input" name="salary[]" type="text">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <div class="col-md-3">
                                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                                <div class="input-group input-small">
                                                                                    <div class="form-control input-fixed input-small" data-trigger="fileinput">
                                                                                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                                        <span class="fileinput-filename"> </span>
                                                                                    </div>
                                                                                    <span class="input-group-addon btn default btn-file">
                                                                                        <span class="fileinput-new">{!! trans('labels.select_file') !!}</span>
                                                                                        <span class="fileinput-exists">{!! trans('labels.change') !!}</span>
                                                                                        <input type="file" name="fileupload_{{ $employee->id_number }}">
                                                                                    </span>
                                                                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">{!! trans('labels.remove') !!}</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <a class="del_tr"></a><input type="hidden" name="ids[]" value="{{ $employee->id_number }}">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END FORM-->
                                </div>
                            </div>
                            <!-- END VALIDATION STATES-->
                        </div>
                    @endif
                </div>
            </div>
            @if(!empty($contract))
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-align-left col-md-12">
                            @include('components.disclaimer_modal', ['id' => 'confirm', 'title' => trans('contracts.disclaimers'), 'content' => 'front.disclaimers.temp_work_apply_offer_disclaimer' ])

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirm">{{ trans('temp_job.save_and_send') }}</button>

                        </div>
                    </div>
                </div>
            @endif
            {!! Form::close() !!}
        </div>
    </div>
    <!-- END PAGE CONTENT BODY -->
    <!-- END CONTENT BODY -->
@endsection