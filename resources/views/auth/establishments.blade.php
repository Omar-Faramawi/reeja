@extends('front.layout')
@section('title', 'المنشآت')
@section('content')
        <!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{trans('user.home')}}
                <small>{{ trans('front.dashboard.establishments') }}</small>
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
            @if(session()->has('est_status'))
                <div class="alert alert-block alert-danger fade in">
                <button type="button" class="close" data-dismiss="alert"></button>
                <p>{!! session()->pull('est_status') !!} </p>
            </div>
            @endif
            @if(session()->has('choose_est_message'))
            <div class="alert alert-block alert-danger fade in">
                <button type="button" class="close" data-dismiss="alert"></button>
                <p>{!! session()->pull('choose_est_message') !!} </p>
            </div>
            @endif
            
            @if(session()->get('selected_establishment'))
                <div class="note note-info">
                    <h5 class="success">{{ trans('front.dashboard.establishment_select') }}</h5>
                    <p>{{ session()->get('selected_establishment')->name }}</p>
                </div>
            @endif
            <div class="row">
                @if(!empty(session()->get('user.establishments')))
                @foreach(session()->get('user.establishments') as $establishment)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="dashboard-stat2 ">
                            <div class="display">
                                <div class="number">
                                    <a href="{{ route('establishment.choose',['office'=> $establishment->labor_office_id,'sequence'=> $establishment->sequence_number]) }}">
                                        <h4 class="font-green-sharp">
                                            {{ $establishment->name }}
                                        </h4>
                                        <small>{{ trans('establishments_registration.attributes.labour_office_no') }} :
                                            {{ $establishment->labor_office_id }}
                                        </small>
                                        <br/>
                                        <small>{{ trans('establishments_registration.attributes.sequence_no') }} :
                                            {{ $establishment->sequence_number }}
                                        </small>
                                    </a>
                                </div>
                                <div class="icon">
                                    <i class="icon-pie-chart"></i>
                                </div>
                            </div>
                            <div class="progress-info">
                                <div class="progress">
                                    <span style="width: 100%;" class="progress-bar progress-bar-success green-sharp">
                                        <span class="sr-only">100%</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @endif
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END PAGE CONTENT BODY -->
@endsection
