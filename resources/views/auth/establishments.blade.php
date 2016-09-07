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
            @if(session()->get('selected_establishment'))
                <div class="row">
                    {{ trans('front.dashboard.establishment_select') }}
                    {{ session()->get('selected_establishment')->name }}
                </div>
            @endif
            <div class="row">
                @if(!empty(session()->get('user.establishments')))
                @foreach(session()->get('user.establishments') as $establishment)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="dashboard-stat2 ">
                            <div class="display">
                                <div class="number">
                                    <a href="{{ route('establishment.choose',['office'=> $establishment->number()->laborOfficeId(),'sequence'=> $establishment->number()->sequenceNumber()]) }}">
                                        <h4 class="font-green-sharp">
                                            {{ $establishment->name() }}
                                        </h4>
                                        <small>{{ trans('establishments_registration.attributes.labour_office_no') }} :
                                            {{ $establishment->number()->laborOfficeId() }}
                                        </small>
                                        <br/>
                                        <small>{{ trans('establishments_registration.attributes.sequence_no') }} :
                                            {{ $establishment->number()->sequenceNumber() }}
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
