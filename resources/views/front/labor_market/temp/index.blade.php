@extends('front.layout')
@section('title', trans('temp_job.labor_market'))
@section('content')

        <!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('labels.system_name') }}
                <small>{{ trans('temp_job.labor_market') }}</small>
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
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">{{ trans('temp_job.search_souq') }}</span>
                            </div>

                            <div class="col-md-12">
                                <label for="gender">{{ trans('temp_job.service_type') }}</label>
								@if( $occasionalWork )
									{{ Form::select('service_type', Constants::serviceTypes(['file' => 'temp_job']), [session()->get('service_type')], ['class' => 'form-control form-filter input-sm bs-select', 'id' => 'service-provider-select', 'data-route' => url('occasional-work/labor-market') , 'placeholder' => trans('labels.default')]) }}
								@else
									{{ Form::select('service_type', Constants::serviceTypes(['file' => 'temp_job']), [session()->get('service_type')], ['class' => 'form-control form-filter input-sm bs-select', 'id' => 'service-provider-select', 'data-route' => url('temp_work/labor-market') , 'placeholder' => trans('labels.default')]) }}
								@endif
                            </div>

                        </div>
                        <div class="portlet-body">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">{{trans("temp_job.search_souq")}}</div>
                                </div>
                                <div class="portlet-body labor_employee_data_benf">
                                    <div class="table-container">
                                        <table id="datatable_ajax"
                                               data-token="{{ csrf_token() }}"
                                               class="table table-striped table-bordered table-hover" cellspacing="0"
                                               width="100%">
                                            <thead>

                                            <tr role="row" class="heading">
                                                <th id="check" class="no-sort"></th>
                                                <th id="{{ ( session()->get('service_type') === Constants::SERVICETYPES['provider'] ) ? 'vacancy_name' : 'provider_name' }}"
                                                    class="no-sort" width="120"> {{ ( session()->get('service_type') === Constants::SERVICETYPES['provider'] ) ? trans('temp_job.benf_id') : trans('temp_job.provider_id') }} </th>
                                                @if( session()->get('service_type') === Constants::SERVICETYPES['benf'])
                                                <th id="name" width="120"
                                                    class="no-sort"> {{ trans('temp_job.name') }} </th>
                                                @endif
                                                <th id="job.job_name"
                                                    class="no-sort"> {{ trans('temp_job.job_id') }} </th>
                                                <th id="gender_name"
                                                    class="no-sort"> {{ trans('temp_job.gender.name') }} </th>
                                                <th id="nationality.name"
                                                    class="no-sort"> {{ trans('temp_job.nationality_id') }} </th>
                                                <th id="region.name" width="80"
                                                    class="no-sort"> {{ trans('temp_job.region_id') }} </th>
                                                <th id="work_start_date" width="70"
                                                    class="no-sort"> {{ trans('temp_job.work_start_date') }} </th>
                                                <th id="work_end_date" width="70"
                                                    class="no-sort"> {{ trans('temp_job.work_end_date') }} </th>
                                                <th id="details"
                                                    class="no-sort"> {{ trans('temp_job.details') }} </th>
                                            </tr>

                                            <tr role="row" class="filter">
                                                <td></td>
                                                <td>
                                                    {{ Form::text('benf_id', null, ['class' => "form-control form-filter input-sm"]) }}
                                                </td>
                                                @if( session()->get('service_type') === Constants::SERVICETYPES['benf'])
                                                <td>
                                                    {{ Form::text('name', null, ['class' => 'form-control form-filter input-sm']) }}
                                                </td>
                                                @endif
                                                <td>
                                                    {{ Form::select('job_id', @$jobs , null, ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall'), "data-live-search" => "true"]) }}
                                                </td>
                                                <td>
                                                    @if( session()->get('service_type') === Constants::SERVICETYPES['provider'])
                                                        {{ Form::select('gender', Constants::vacancyGender(), null, ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall')]) }}
                                                    @else
                                                        {{ Form::select('gender', Constants::gender(), null, ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall')]) }}
                                                    @endif
                                                <td>
                                                    {{ Form::select('nationality_id', $nationalities, null, ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall'), "data-live-search" => "true"]) }}
                                                </td>
                                                <td>
                                                    {{ Form::select('region_id', $regions, null, ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall')]) }}
                                                </td>
                                                <td>
                                                    <div class="input-group margin-bottom-5">
                                                        {{ Form::text('work_start_date', null, ['class' => "form-control form-filter input-sm date-picker"]) }}
                                                        <span class="input-group-btn">
                                                                <button class="btn btn-sm default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group margin-bottom-5">
                                                        {{ Form::text('work_end_date', null, ['class' => "form-control form-filter input-sm date-picker"]) }}
                                                        <span class="input-group-btn">
                                                                <button class="btn btn-sm default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="margin-bottom-5">
                                                        <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                                            <i class="fa fa-search"></i> {{ trans('temp_job.searches') }}
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>

                                    @if( session()->get('service_type') === Constants::SERVICETYPES['benf'] )
                                        <button type="button" class="btn blue pull-right" id="select_employees_benf"
                                            value="pending">{{ trans('temp_job.add') }}</button>
                                    @endif
                                        <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="portlet box blue" id="contract_requests" style="display: none">
                                <div class="portlet-title">
                                    <div class="caption">{{ trans('temp_job.contract_requests') }}</div>
                                </div>
                                <div class="portlet-body selected_employees_parent">
                                    <div class="table table-responsive">
                                        <table id="selected_employees_benf" class="table table-striped table-bordered">
                                            <thead>
                                                <tr role="row" class="heading">
                                                    <th width="120"> {{ ( session()->get('service_type') === Constants::SERVICETYPES['provider'] ) ? trans('temp_job.benf_id') : trans('temp_job.provider_id') }} </th>
                                                    <th width="120"> {{ trans('temp_job.name') }} </th>
                                                    <th> {{ trans('temp_job.job_id') }} </th>
                                                    <th> {{ trans('temp_job.gender.name') }} </th>
                                                    <th> {{ trans('temp_job.nationality_id') }} </th>
                                                    <th width="90"> {{ trans('temp_job.region_id') }} </th>
                                                    <th width="70"> {{ trans('temp_job.work_start_date') }} </th>
                                                    <th width="70"> {{ trans('temp_job.work_end_date') }} </th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End: life time stats -->
                </div>
            </div>

            @if( session()->get('service_type') === Constants::SERVICETYPES['benf'] )
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary btn-lg pull-right" value="" name="id" data-token="{{ csrf_token() }}" data-url="{{ request()->fullUrl() }}" data-route="{{ route('temp_work_labor_market.ask_offer') }}" id="ask-offer">{{ trans('temp_job.get_offer') }}</button>
                </div>
            </div>
            @endif
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END PAGE CONTENT BODY -->
<!-- END CONTENT BODY -->

@endsection