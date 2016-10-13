@extends('front.layout')
@section('title', trans('front.menu.contract_follow'))
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <div class="container">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>{{ trans('labels.system_name') }}
                    <small> {{trans('front.menu.contract_follow')}}</small>
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
                                    <span class="caption-subject font-dark sbold uppercase"> {{trans('front.menu.contract_follow')}}</span>
                                </div>
                            </div>
                            <div class="portlet-body">



                                <div class="table-container">
                                        @if($ct_id == 4)
                                        @if(auth()->user()->user_type_id == \Tamkeen\Ajeer\Utilities\Constants::USERTYPES['saudi'])
                                        <div class="col-md-3">
                                        {!! Form::select('prvd_benf',Constants::directServiceTypes(['file' => 'temp_job'])
                                        , $prvd_benf,
                                         ['class' => 'form-control bs-select form-filter',
                                        'id' => 'prvd_benf',
                                        'data-url1' => route('follow_contracts', ['ct_id' => $ct_id, 'prvd_benf' => 1]),
                                        'data-url2' => route('follow_contracts', ['ct_id' => $ct_id, 'prvd_benf' => 2])])
                                        !!}
                                        </div>
                                         <br><br>
                                        @endif
                                        @else
                                        <div class="col-md-3">
                                        {!! Form::select('prvd_benf',[ 1 => trans('labels.as_provider'), 2 => trans('labels.as_benf')]
                                        , $prvd_benf,
                                         ['class' => 'form-control bs-select form-filter',
                                        'id' => 'prvd_benf',
                                        'data-url1' => route('follow_contracts', ['ct_id' => $ct_id, 'prvd_benf' => 1]),
                                        'data-url2' => route('follow_contracts', ['ct_id' => $ct_id, 'prvd_benf' => 2])])
                                        !!}
                                        </div>
                                        <br><br>
                                        @endif
                               
                                    <table class="table table-striped table-bordered table-hover table-checkable follow_contracts_table"
                                           id="datatable_ajax" data-token="{{ csrf_token() }}">
                                        <thead>
                                        <tr role="row" class="heading">
                                            <th id="id" width="5%">{{trans('contracts.id')}}</th>
                                            <th id="{{$prvd_benf == 1 ? 'benf_name' : 'providername'}}" class="no-sort"
                                                width="20%">
                                                @if($ct_id == 4)
                                                {{$prvd_benf == 1 ? trans('labor_market.job_owner') : trans('labor_market.job_seeker_name')}}
                                                @else
                                                {{$prvd_benf == 1 ? trans('contract_setup.benf') : trans('contract_setup.provider')}}
                                                @endif
                                            </th>
                                            <th id="status_alias"
                                                class="no-sort"
                                                width="20%">{{trans('contracts.status')}}</th>
                                            <th id="end_date"
                                                class="no-sort"
                                                width="0%">{{trans('contracts.end_date')}}</th>
                                            <th id="data.employees"
                                                class="no-sort"
                                                width="0%">{{trans('contracts.end_date')}}</th>
                                            <th id="cancelled_employees"
                                                class="no-sort"
                                                width="0%">{{trans('contracts.end_date')}}</th>
                                            <th id="provider_type"
                                                class="no-sort"
                                                width="0%">{{trans('contracts.end_date')}}</th>
                                            <th id="follow_contract_options" class="no-sort"
                                                width="25%">{{trans('labor_market.details')}}</th>
                                        </tr>
                                        <tr role="row" class="filter">
                                            <td>
                                                {!! Form::text("id", null, ['class' => 'form-control form-filter input-sm']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text($prvd_benf == 1 ? 'benf_name' : 'providername', null, ['class' => 'form-control form-filter input-sm']) !!}
                                            </td>
                                            <td>
                                                {!! Form::select('status', Constants::contract_statuses(['file' => 'contracts.statuses']), null, ['class' => 'form-control bs-select form-filter']) !!}
                                            </td>
                                            <td></td>
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

                                    <br>
                                </div>

                                <div class="col-md-12 text-center table_container" style="display: none;">
                                    <table class="table table-hover table-bordered follow_contracts_list">
                                        <thead>
                                        <tr role="row" class="heading">
                                            <th id="id" class="no-sort" width="10">
                                                {{trans('contracts.id')}}
                                            </th>
                                            <th id="{{$prvd_benf == 1 ? 'benf_name' : 'providername'}}" class="no-sort"
                                                width="15%">
                                                {{$prvd_benf == 1 ? trans('contract_setup.benf') : trans('contract_setup.provider')}}
                                            </th>
                                            <th id="status_alias"
                                                class="no-sort"
                                                width="20%">{{trans('contracts.status')}}</th>
                                            <th id="end_date"
                                                class="no-sort"
                                                width="0%">{{trans('contracts.attributes.end_date')}}</th>
                                            <th id="data.employees"
                                                class="no-sort"
                                                width="0%">{{trans('contracts.attributes.end_date')}}</th>
                                            <th id="cancelled_employees"
                                                class="no-sort"
                                                width="0%">{{trans('contracts.attributes.end_date')}}</th>
                                            <th id="provider_type"
                                                class="no-sort"
                                                width="0%">{{trans('contracts.attributes.end_date')}}</th>
                                            <th id="follow_contract_options" class="no-sort"
                                                width="25%">{{trans('labor_market.details')}}</th>
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
