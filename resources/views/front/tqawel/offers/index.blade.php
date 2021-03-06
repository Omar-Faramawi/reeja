@extends('front.layout')
@section('title', trans('tqaweloffers.receivedOffers'))
@section('content')
        <!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{trans('tqaweloffers.receivedOffers')}}</h1>
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
                                <span class="caption-subject font-dark sbold uppercase">{{trans('tqaweloffers.receivedOffers')}}</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover table-checkable"
                                       id="datatable_ajax">
                                    <thead>
                                    <tr role="row" class="heading">
                                        <th id="id" width="10%">#</th>
                                        <th id="providername" width="200"
                                            class="no-sort"> {{trans("tqaweloffers.serviceProviderName")}}</th>
                                        <th id="contract_nature.name"
                                            width="200"
                                            class="no-sort">{{trans("tqaweloffers.serviceType")}}</th>
                                        <th id="market_taqawoul_services.responsible_email" width="200"
                                            class="no-sort"> {{trans("tqaweloffers.email")}}</th>
                                        <th id="market_taqawoul_services.responsible_mobile" width="200"
                                            class="no-sort"> {{trans("tqaweloffers.mobile")}}</th>
                                        <th id="offersview" class="no-sort"
                                            width="10%"> {{trans("tqaweloffers.details")}}</th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="id"></td>
                                        <td>
                                            {{ Form::text('provider_name', null, ['class' => 'form-control form-filter']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('service_type', null, ['class' => 'form-control form-filter']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('responsible_email', null, ['class' => 'form-control form-filter']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('responsible_mobile', null, ['class' => 'form-control form-filter']) }}
                                        </td>

                                        <td>
                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                                <i class="fa fa-search"></i> {{trans("labels.pagination.search")}}
                                            </button>
                                            <button class="btn btn-sm red btn-outline filter-cancel">
                                                <i class="fa fa-times"></i> {{trans("labels.cancel")}}
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