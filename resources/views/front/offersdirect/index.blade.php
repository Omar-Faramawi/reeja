@extends('front.layout')
@section('title', trans('offersdirect.receivedOffers'))
@section('content')
        <!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{trans('offersdirect.receivedOffers')}}</h1>
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
                                <span class="caption-subject font-dark sbold uppercase">{{trans('offersdirect.receivedOffers')}}</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover table-checkable"
                                       id="datatable_ajax">
                                    <thead>
                                    <tr role="row" class="heading">
                                        <th id="benf_name" width="200"
                                            class="no-sort"> {{trans("offersdirect.providerName")}}</th>
                                        <th id="vacancy.job.job_name" width="200"
                                            class="no-sort">{{trans("offersdirect.job")}}</th>
                                        <th id="vacancy.gender_name" width="200"
                                            class="no-sort"> {{trans("offersdirect.gender")}}</th>
                                        <th id="vacancy.religion_name" width="200"
                                            class="no-sort"> {{trans("offersdirect.religion")}}</th>
                                        <th id="vacancy.region.name" width="200"
                                            class="no-sort"> {{trans("offersdirect.region")}}</th>
                                        <th id="start_date" width="200"
                                            class="no-sort"> {{trans("offersdirect.workStartDate")}}</th>
                                        <th id="end_date" class="no-sort"
                                            width="200"> {{trans("offersdirect.workEndDate")}}</th>
                                        <th id="buttons" class="no-sort"
                                            width="5%"> {{trans("offersdirect.details")}}</th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td>
                                            {{ Form::text('benef_name', null, ['class' => 'form-control form-filter']) }}
                                        </td>
                                        <td>
                                            {{ Form::select('job_name', $jobs,null, ['class' => 'form-control form-filter bs-select','placeholder'=>trans('offers.select'), "data-live-search" => "true"]) }}
                                        </td>
                                        <td>
                                            {{ Form::select('gender_name', $genders,null, ['class' => 'form-control form-filter bs-select','placeholder'=>trans('offers.select')]) }}
                                        </td>
                                        <td>
                                            {{ Form::select('religion_name', $religions,null, ['class' => 'form-control form-filter bs-select','placeholder'=>trans('offers.select')]) }}
                                        </td>
                                        <td>
                                            {{ Form::select('region_name', $regions,null, ['class' => 'form-control form-filter bs-select','placeholder'=>trans('offers.select')]) }}
                                        </td>
                                        <td>
                                            <input type="text" class="form-control input-sm date-picker"
                                                   name="start_date">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control input-sm date-picker"
                                                   name="end_date"></td>
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