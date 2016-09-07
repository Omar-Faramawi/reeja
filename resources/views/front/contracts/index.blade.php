@extends('front.layout')
@section('title', trans('contracts.contracts'))
@section('content')

        <!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('contracts.contracts') }}</h1>
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
                </div>
                <div class="col-md-12">

                    <div class="portlet light portlet-fit portlet-form ">

                        <div class="portlet-body">

                            <div class="caption page-container">
                                <div class="table-container">
                                    <table class="table table-striped table-bordered table-hover table-checkable"
                                           id="datatable_ajax" data-url="{{ url("/contracts/{$contractTypeId}") }}">
                                        <thead>
                                            <tr role="row" class="heading">
                                                <th id="id" class="no-sort" width="2%">{{ trans('temp_job.id') }}</th>
                                                <th id="start_date" class="no-sort">{{ trans('temp_job.work_start_date') }}</th>
                                                <th id="end_date" class="no-sort">{{ trans('temp_job.work_end_date') }}</th>
                                                <th id="benf_name" class="no-sort">{{ trans('temp_job.benf_id') }}</th>
                                                <th id="details" class="no-sort" width="200">{{ trans('temp_job.details') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>

                                    </table>
                                </div>
                            </div> <!-- end caption page container -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT BODY -->
<!-- END CONTENT BODY -->

@endsection