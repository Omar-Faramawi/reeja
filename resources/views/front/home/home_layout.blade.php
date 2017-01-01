@extends('front.layout')
@section('title', trans('user.home'))
@section('content')
<!-- BEGIN PAGE CONTENT BODY -->
<div class="page-content">
    <div class="container">
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