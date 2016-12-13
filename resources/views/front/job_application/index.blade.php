@extends('front.layout')
@section('title', trans('labor_market.labor_market'))
@section('content')
        <!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('labels.system_name') }}
                <small> {{trans('labor_market.labor_market')}}</small>
            </h1>
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
        </ul>
        <!-- END PAGE BREADCRUMBS -->
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase"> {{trans('labor_market.labor_market')}}</span>
                            </div>
                            @if(auth()->user()->user_type_id == \Tamkeen\Ajeer\Utilities\Constants::USERTYPES['saudi'])
                            <div class="col-md-12">
                                <label for="service_type">{{ trans('temp_job.service_type') }}</label>
                                <select class="form-control select2me bs-select" name="service_type" id="directHiring-type-select">
                                    <option value="">{{ trans('labels.default') }}</option>
                                    <option value="{{url('direct-hiring/labor-market')}}">{{ trans('temp_job.job_owner') }}</option>
                                    <option value="{{url('job_search')}}" selected>{{ trans('temp_job.job_seeker') }}</option>
                                </select>
                            </div>
                            @endif
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover table-checkable"
                                       id="datatable_ajax" data-token="{{ csrf_token() }}">
                                    <thead>
                                    <tr role="row" class="heading">
                                        <th id="id" width="5%">#</th>
                                        <th id="job.job_name"
                                            class="no-sort">{{trans('labor_market.attributes.job_id')}}</th>
                                        <th id="region.name"
                                            class="no-sort">{{trans('labor_market.attributes.region_id')}}</th>
                                        <th id="work_start_date">{{trans('labor_market.attributes.work_start_date')}}</th>
                                        <th id="work_end_date">{{trans('labor_market.attributes.work_end_date')}}</th>
                                        <th id="owner_name" class="no-sort">{{trans('labor_market.job_owner')}}</th>
                                        <th id="job_type_text"
                                            class="no-sort">{{trans('labor_market.attributes.job_type')}}</th>
                                        {{--<th id="rating" class="no-sort">{{trans('labor_market.rating')}}</th>--}}
                                        <th id="details" class="no-sort"
                                            width="15%">{{trans('labor_market.details')}}</th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="id">
                                        </td>
                                        <td>
                                            <select name="job_id" class="form-control bs-select form-filter" data-live-search="true">
                                                <option value="">{{ trans('labels.choose') }}</option>
                                                @foreach($jobs as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="region_id" class="form-control bs-select form-filter">
                                                <option value="">{{ trans('labels.choose') }}</option>
                                                @foreach($regions as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control form-filter date-picker" name="work_start_date"/>
                                        </td>
                                        <td>
                                            <input class="form-control form-filter date-picker" name="work_end_date"/>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="owner_name">
                                        </td>
                                        <td>
                                            <select name="job_type" class="form-control bs-select form-filter">
                                                <option value="">{{ trans('labels.choose') }}</option>
                                                <option value="0">{{ trans('labor_market.not_paid') }}</option>
                                                <option value="1">{{ trans('labor_market.paid') }}</option>
                                            </select>
                                        </td>
                                        {{--<td>--}}
                                        {{--<input type="text" class="form-control form-filter input-sm"--}}
                                        {{--name="job_owner">--}}
                                        {{--</td>--}}
                                        <td>
                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                                <i class="fa fa-search"></i> {{ trans('labor_market.search') }}
                                            </button>
                                            <button class="btn btn-sm red btn-outline filter-cancel">
                                                <i class="fa fa-times"></i> {{ trans('labor_market.reset') }}
                                            </button>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End: life time stats -->
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END PAGE CONTENT BODY -->
<!-- END CONTENT BODY -->
@endsection
