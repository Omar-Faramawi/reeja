@extends('front.layout')
@section('title', trans('vacancies.headings.tab_head'))
@section('content')
        <!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('vacancies.headings.tab_head') }}</h1>
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
                                <span class="caption-subject font-dark sbold uppercase">{{ trans('vacancies.headings.list_tab_head') }}</span>
                            </div>
                            <div class="actions">
                                <a href="{{ url('/vacancies/create') }}" class="btn btn-circle btn-sm green"><i
                                            class="fa fa-plus"></i>
                                    {{ trans('vacancies.headings.Add') }}</a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover"
                                       id="datatable_ajax">
                                    <thead>
                                    <tr role="row" class="heading">
                                        <th id="id" width="8%">#</th>
                                        <th id='job.job_name' class="no-sort">{{ trans('vacancies.list_attributes.job') }}</th>
                                        <th id='region.name'
                                            class="no-sort">{{ trans('vacancies.list_attributes.work_area') }}</th>
                                        <th id='no_of_vacancies'>{{ trans('vacancies.list_attributes.needed_number') }}</th>
                                        <th id="details" class="no-sort"
                                            width="20%"> {{ trans('vacancies.list_attributes.details') }}</th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="id">
                                        </td>
                                        <td>
                                         {{ Form::select('job_id', $jobs, null, ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.default')]) }}

                                        <td>
                                        {{ Form::select('region_id', $regions, null, ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.default')]) }}

                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="no_of_vacancies"></td>
                                        <td>
                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                                <i class="fa fa-search"></i> {{ trans('labels.search') }}
                                            </button>
                                           <!-- <button class="btn btn-sm red btn-outline filter-cancel">
                                                <i class="fa fa-times"></i> {{ trans('labels.reset') }}
                                            </button>-->
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