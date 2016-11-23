@extends('front.layout')
@section('title', trans('invoices.headings.tab_head'))
@section('content')
        <!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('invoices.headings.tab_head') }}</h1>
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
                                <span class="caption-subject font-dark sbold uppercase">{{ trans('invoices.headings.list_tab_head') }}</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover table-checkable"
                                       id="datatable_ajax">
                                    <thead>
                                    <tr role="row" class="heading">
                                        <th id="id" class="sort">#</th>
                                        <th id='bill_number' class="no-sort">{{ trans('invoices.list_attributes.number') }}</th>
                                        <th id='amount' class="no-sort">{{ trans('invoices.list_attributes.amount') }}</th>
                                        <th id='description' width="20%" class="no-sort">{{ trans('invoices.list_attributes.description') }}</th>
                                        <th id='issue_date_formatted' width="10%" class="no-sort">{{ trans('invoices.list_attributes.issue_date') }}</th>
                                        <th id='expiry_date_formatted' width="10%" class="no-sort">{{ trans('invoices.list_attributes.expiry_date') }}</th>
                                        <th id='status_name' class="no-sort">{{ trans('invoices.list_attributes.status') }}</th>
                                        <th id='trans_invoice_type' class="no-sort">{{ trans('invoices.list_attributes.invoice_type') }}</th>
                                        <th id="details" class="no-sort"> {{ trans('vacancies.list_attributes.details') }}</th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td>
                                         
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="id">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="bill_number"></td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="amount"></td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="description"></td>
                                        <td>
                                            <input type="text" class="form-control form-filter date-picker" value=""
                                                   name="issue_date">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-filter date-picker" value=""
                                                   name="expiry_date">
                                        </td>
                                        <td>
                                            {!! Form::select('status', \Tamkeen\Ajeer\Utilities\Constants::invoiceStatues(['file' => 'invoices.statuses']), null, ['class' => 'form-control bs-select form-filter', 'placeholder' => trans('labels.noneSelectedTextValueSmall')]) !!}

                                        </td>
                                        <td>
                                            {!! Form::select('invoice_type', \Tamkeen\Ajeer\Utilities\Constants::invoiceTypes(['file' => 'invoices.types']), null, ['class' => 'form-control bs-select form-filter', 'placeholder' => trans('labels.noneSelectedTextValueSmall')]) !!}

                                        </td>
                                        <td>
                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                                <i class="fa fa-search"></i> {{ trans('labels.search') }}
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