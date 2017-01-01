@extends('front.layout')
@section('title', trans('temp_job.service_benf_info'))
@section('content')

    <!-- BEGIN CONTENT BODY -->
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <div class="container">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>{{ trans('labels.system_name') }}
                    <small>{{ trans('temp_job.offer_contract') }}</small>
                </h1>
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
                        <!-- BEGIN VALIDATION STATES-->
                        <div class="portlet light portlet-fit portlet-datatable">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class=" icon-layers font-dark"></i>
                                    <span class="caption-subject font-dark sbold uppercase">{{ trans("temp_job.service_benf_info")}}</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <!-- BEGIN FORM-->
                                {!! Form::open(['route' => 'taqawel.get_establishment', 'id' => 'form', 'data-url' => url('taqawel/create') ]) !!}

                                <div class="form-body">

                                    <div class="portlet blue box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                {{trans("temp_job.service_benf_info")}}
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("establishments_registration.attributes.labour_office_no")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {!! Form::text('labour_office_no', null, [ 'placeholder' => trans('labels.enter') . " ". trans('establishments_registration.attributes.labour_office_no'), 'class' => 'form-control' ]) !!}
                                                </div>
                                            </div>

                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("establishments_registration.attributes.sequence_no")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {!! Form::text('sequence_no', null, [ 'placeholder' => trans('labels.enter') . " ". trans('establishments_registration.attributes.sequence_no'), 'class' => 'form-control' ]) !!}

                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="text-align-left col-md-12">
                                                <button type="submit" data-loading-text="{{ trans('labels.loading') }}..." class="btn btn-primary pull-end">{{ trans('temp_job.next') }}</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- END FORM-->
                            </div>
                        </div>
                        <!-- END VALIDATION STATES-->
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
    <!-- END PAGE CONTENT BODY -->
    <!-- END CONTENT BODY -->

@endsection