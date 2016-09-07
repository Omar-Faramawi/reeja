@extends('front.layout')
@section('title', trans('contracts.work_completion_cert'))
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <div class="container">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>{{ trans('labels.system_name') }}
                    <small> {{trans('contracts.work_completion_cert')}}</small>
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
                                    <i class="icon-file-text font-dark"></i>
                                    <span class="caption-subject font-dark sbold uppercase"> {{trans('contracts.work_completion_cert')}}</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-container">
                                    <table class="table table-striped table-bordered table-hover table-checkable"
                                           id="datatable_ajax" data-token="{{ csrf_token() }}">
                                        <thead>
                                        <tr role="row" class="heading">
                                            <th id="id" width="10%">{{trans('contracts.id')}}</th>
                                            <th id="benf_name" class="no-sort"
                                                width="20%">{{trans('labor_market.job_owner')}}</th>
                                            <th id="vacancy.job.job_name"
                                                class="no-sort"
                                                width="15%">{{trans('labor_market.attributes.job_id')}}</th>
                                            <th id="vacancy.region.name"
                                                class="no-sort"
                                                width="15%">{{trans('labor_market.attributes.region_id')}}</th>
                                            <th id="status_name"
                                                class="no-sort"
                                                width="10%">{{trans('contracts.status')}}</th>
                                            <th id="contract_details" class="no-sort"
                                                width="15%">{{trans('labor_market.details')}}</th>
                                        </tr>
                                        <tr role="row" class="filter">
                                            <td>
                                                {!! Form::text("id", null, ['class' => 'form-control form-filter input-sm']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text("owner_name", null, ['class' => 'form-control form-filter input-sm']) !!}
                                            </td>
                                            <td>
                                                <select name="job_id" class="form-control bs-select form-filter">
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
                                                {!! Form::select('status', \Tamkeen\Ajeer\Utilities\Constants::contract_statuses(['file' => 'contracts.statuses']), null, ['class' => 'form-control bs-select form-filter']) !!}
                                            </td>
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

                                    <br>
                                </div>

                                <div class="col-md-12 text-center table_container" style="display: none;">
                                    <table class="table table-hover table-bordered contracts_cert_list">
                                        <thead>
                                        <tr role="row" class="heading">
                                            <th id="id" width="10%">{{trans('contracts.id')}}</th>
                                            <th id="benf_name" class="no-sort"
                                                width="20%">{{trans('labor_market.job_owner')}}</th>
                                            <th id="vacancy.job.job_name"
                                                class="no-sort"
                                                width="15%">{{trans('labor_market.attributes.job_id')}}</th>
                                            <th id="vacancy.region.name"
                                                class="no-sort"
                                                width="15%">{{trans('labor_market.attributes.region_id')}}</th>
                                            <th id="status_name"
                                                class="no-sort"
                                                width="10%">{{trans('contracts.status')}}</th>
                                            <th id="start_date"
                                                class="no-sort"
                                                width="10%">{{trans('contracts.attributes.start_date')}}</th>
                                            <th id="end_date"
                                                class="no-sort"
                                                width="10%">{{trans('contracts.attributes.end_date')}}</th>
                                            <th id="contract_details" class="no-sort"
                                                width="15%">{{trans('labor_market.details')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                    <div class="alert alert-warning">
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">&times;</button>
                                        {!! trans('contracts.undo_invoice_notice') !!}
                                    </div>
                                    <a href="javascript:;"
                                       class="btn btn-info generate_invoice_btn">{!! trans('labels.generate_invoice') !!}</a>
                                </div>
                                <div class="clearfix"></div>
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
