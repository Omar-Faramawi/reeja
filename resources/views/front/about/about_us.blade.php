@extends('front.layout')
@section('title', trans('front.menu.about'))
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
            <li>
                <a href="{{ url('/') }}">{{ trans('labels.home') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ trans('front.menu.about') }}</span>
            </li>
        </ul>
        <!-- END PAGE BREADCRUMBS -->
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="row margin-bottom-20">
                    <div class="col-lg-4 col-md-6">
                        <div class="portlet light">
                            <div class="card-icon">
                                <i class="icon-briefcase font-red-sunglo theme-font"></i>
                            </div>
                            <div class="card-title">
                                <span>{{ trans('about.ajeer_for_job_service.heading') }}</span>
                            </div>
                            <div class="card-desc">
                                <div>{{ trans('about.ajeer_for_job_service.body') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="portlet light">
                            <div class="card-icon">
                                <i class="icon-users font-green-haze theme-font"></i>
                            </div>
                            <div class="card-title">
                                <span>{{ trans('about.ajeer_for_companies_service.heading') }}</span>
                            </div>
                            <div class="card-desc">
                                <div>{{ trans('about.ajeer_for_companies_service.body') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="portlet light">
                            <div class="card-icon">
                                <i class="icon-flag font-blue theme-font"></i>
                            </div>
                            <div class="card-title">
                                <span>{{ trans('about.ajeer_for_visitor_service.heading') }}</span>
                            </div>
                            <div class="card-desc">
                                <div>{{ trans('about.ajeer_for_visitor_service.body') }}</div>
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
