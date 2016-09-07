@extends('front.layout')
@section('title', trans('user.home'))
@section('content')
        <!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1> {{ trans('labels.system_name') }}
                <small>{{trans('user.home')}}</small>
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
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-green-sharp">
                                    <span data-counter="counterup" data-value="7800">7800</span>
                                </h3>
                                <small>{{ trans('front.dashboard.new_est') }}</small>
                            </div>
                            <div class="icon">
                                <i class="icon-pie-chart"></i>
                            </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress">
                                <span style="width: 76%;" class="progress-bar progress-bar-success green-sharp">
                                    <span class="sr-only">76%</span>
                                </span>
                            </div>
                            <div class="status">
                                <div class="status-title"> {{ trans('front.dashboard.rate') }} </div>
                                <div class="status-number"> 76%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-haze">
                                    <span data-counter="counterup" data-value="1349">1349</span>
                                </h3>
                                <small>{{ trans('front.dashboard.new_users') }}</small>
                            </div>
                            <div class="icon">
                                <i class="icon-like"></i>
                            </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress">
                                <span style="width: 85%;" class="progress-bar progress-bar-success red-haze">
                                    <span class="sr-only">85%</span>
                                </span>
                            </div>
                            <div class="status">
                                <div class="status-title"> {{ trans('front.dashboard.rate') }} </div>
                                <div class="status-number"> 85%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-blue-sharp">
                                    <span data-counter="counterup" data-value="567">567</span>
                                </h3>
                                <small>{{ trans('front.dashboard.chances') }}</small>
                            </div>
                            <div class="icon">
                                <i class="icon-basket"></i>
                            </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress">
                                <span style="width: 45%;" class="progress-bar progress-bar-success blue-sharp">
                                    <span class="sr-only">45%</span>
                                </span>
                            </div>
                            <div class="status">
                                <div class="status-title"> {{ trans('front.dashboard.rate') }} </div>
                                <div class="status-number"> 45%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-purple-soft">
                                    <span data-counter="counterup" data-value="276">276</span>
                                </h3>
                                <small>{{ trans('front.menu.work_market') }}</small>
                            </div>
                            <div class="icon">
                                <i class="icon-user"></i>
                            </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress">
                                <span style="width: 57%;" class="progress-bar progress-bar-success purple-soft">
                                    <span class="sr-only">56% change</span>
                                </span>
                            </div>
                            <div class="status">
                                <div class="status-title"> {{ trans('front.dashboard.rate') }} </div>
                                <div class="status-number"> 57%</div>
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