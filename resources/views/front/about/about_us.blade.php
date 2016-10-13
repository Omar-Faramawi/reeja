@extends('front.layout')
@section('title', trans('front.menu.definition'))
@section('content')
        <!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1> {{ trans('labels.system_name') }}
                <small>{{trans('front.menu.definition')}}</small>
            </h1>
        </div>
    </div>
    <!-- END PAGE TOOLBAR -->
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
                <div class="row margin-bottom-20">
                    <div class="col-lg-4 col-md-6">
                        <div class="portlet light">
                            <div class="card-icon">
                                <i class="icon-user-follow font-red-sunglo theme-font"></i>
                            </div>
                            <div class="card-title">
                                <span>{{ trans('about.ajeer_for_job_service.heading') }}</span>
                            </div>
                            <div class="card-desc">
                                <span>{{ trans('about.ajeer_for_job_service.body') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="portlet light">
                            <div class="card-icon">
                                <i class="icon-trophy font-green-haze theme-font"></i>
                            </div>
                            <div class="card-title">
                                <span>{{ trans('about.ajeer_for_companies_service.heading') }}</span>
                            </div>
                            <div class="card-desc">
                                <span>{{ trans('about.ajeer_for_companies_service.body') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="portlet light">
                            <div class="card-icon">
                                <i class="icon-layers font-blue theme-font"></i>
                            </div>
                            <div class="card-title">
                                <span>{{ trans('about.ajeer_for_visitor_service.heading') }}</span>
                            </div>
                            <div class="card-desc">
                                <span>{{ trans('about.ajeer_for_visitor_service.body') }}</span>
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
@endsection
