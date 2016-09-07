@extends ('admin.layout')
@section('title', trans('user.dashboardwidgets'))
@section('content')
        <!-- BEGIN BREADCRUMBS -->
<div class="breadcrumbs">
    <h1>{{ trans('user.dashboardwidgets') }}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#">{{trans('user.home')}}</a>
        </li>
        <li class="active">{{ trans('user.dashboardwidgets') }}</li>
    </ol>
</div>
<!-- END BREADCRUMBS -->
<!-- BEGIN PAGE BASE CONTENT -->
<!-- BEGIN DASHBOARD STATS 1-->
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat blue">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">233</div>
                <div class="desc"> </div>
            </div>
            <a class="more" href="#"> {{ trans('user.more') }}
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat red">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">644</div>
                <div class="desc"> </div>
            </div>
            <a class="more" href="#"> {{ trans('user.more') }}
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat green">
            <div class="visual">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
                <div class="number">23</div>
                <div class="desc"> </div>
            </div>
            <a class="more" href="#"> {{ trans('user.more') }}
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat purple">
            <div class="visual">
                <i class="fa fa-globe"></i>
            </div>
            <div class="details">
                <div class="number">2323</div>
                <div class="desc"> </div>
            </div>
            <a class="more" href="#"> {{ trans('user.more') }}
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<!-- END DASHBOARD STATS 1-->
<!-- END PAGE BASE CONTENT -->
@endsection