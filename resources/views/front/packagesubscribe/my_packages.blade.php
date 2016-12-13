@extends('front.layout')
@section('title', trans('packagesubscribe.myPackages'))
@section('content')
        <!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('packagesubscribe.myPackages') }}</h1>
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
                    <div class="portlet light portlet-fit portlet-datatable ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">{{ trans('packagesubscribe.myPackages') }}</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover"
                                       id="datatable_ajax">
                                    <thead>
                                    <tr role="row" class="heading">
                                        <th id="id" class="sort">#</th>
                                        <th id='num_of_notices' width="20%" class="no-sort">{{ trans('packagesubscribe.ishaarsNoTotal') }}</th>
                                        <th id='num_remaining_notices' width="20%" class="no-sort">{{ trans('packagesubscribe.num_remaining_notices') }}</th>
                                        <th id='expire_date' width="20%">{{ trans('packagesubscribe.expire_date') }}</th>
                                        <th id='status_alias' width="20%" class="no-sort">{{ trans('labels.project_status') }}</th>
                                        <th id='created_at_alias' width="20%" class="no-sort">{{ trans('packagesubscribe.created_at') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END PAGE CONTENT BODY -->
<!-- END CONTENT BODY -->
@endsection