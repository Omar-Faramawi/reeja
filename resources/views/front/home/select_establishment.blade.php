@extends('front.layout')
@section('title', trans('front.dashboard.establishments'))
@section('content')
        <!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{trans('labels.system_name')}}
                <small> {{ trans('front.dashboard.establishments') }}</small>
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
                <div class="portlet light">
                    <div class="alert alert-block alert-success fade in">
                        <button type="button" class="close" data-dismiss="alert"></button>
                        <h4 class="alert-heading">{{ trans('front.dashboard.establishment_select') }}</h4>
                        <p> {{ session()->get('selected_establishment')->name }} </p>
                        <p>
                            <a class="btn green" href="{{ url('establishment/edit') }}"> {{ trans('establishment.can_change') }} </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END PAGE CONTENT BODY -->
@endsection
