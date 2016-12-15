@extends('front.layout')
@section('title', trans('temp_job.offer_contract'))
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
                                <i class=" icon-layers font-red"></i>
                                <span class="caption-subject font-red sbold uppercase">{{ trans('temp_job.offer_contract') }}</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!-- BEGIN FORM-->
                            {!! Form::open(['route' => 'taqawel.store', 'id' => 'form', 'files' => true , 'data-url' => route('taqawel.market') ]) !!}

                            <div class="form-body">
                                <div class="portlet blue box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-info-circle"></i>
                                            {{trans("temp_job.service_provider_info")}}
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row static-info">
                                            <div class="col-md-3 name">
                                                {{ trans("temp_job.service_provider_name") }}
                                            </div>
                                            <div class="col-md-9 value">
                                                {{ $username }}
                                            </div>
                                        </div>
                                        @if(\Auth::user()->user_type_id == Constants::USERTYPES['est'])
                                        <div class="row static-info">
                                            <div class="col-md-3 name">
                                                {{trans("temp_job.est_activity")}}
                                            </div>
                                            <div class="col-md-9 value">
                                                {{ session()->get('selected_establishment')->est_activity }}
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
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
                                                {{trans("temp_job.service_benf_name")}}
                                            </div>
                                            <div class="col-md-9 value">
                                                {{ $marketServices->providername }}
                                            </div>
                                        </div>
                                        @if($marketServices->service_prvdr_benf_id == Constants::USERTYPES['est'])
                                        <div class="row static-info">
                                            <div class="col-md-3 name">
                                                {{trans("temp_job.est_activity")}}
                                            </div>
                                            <div class="col-md-9 value">
                                                {{ $marketServices->provider->est_activity }}
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="portlet blue box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            {{ trans('tqawel_offer_contract.contract_details') }}
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row static-info">
                                            <div class="col-md-3 name">
                                                {{ trans('tqawel_offer_contract.contract_nature') }}
                                            </div>
                                            <div class="col-md-9 value form-group no-padding-top">
                                                {{ $marketServices->contractNature->name }}
                                                {!! Form::hidden('market_taqaual_services_id', $id) !!}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-3 name padding-top-8">
                                                {{ trans('tqawel_offer_contract.contract_name') }}
                                            </div>
                                            <div class="col-md-9 value form-group no-padding-top">
                                                {!! Form::text('contract_name', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.contract_name'), 'class' => 'form-control' ]) !!}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-3 name padding-top-8">
                                                {{ trans('tqawel_offer_contract.contract_desc') }}
                                            </div>
                                            <div class="col-md-9 value form-group no-padding-top">
                                                {!! Form::textarea('contract_desc', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.contract_desc'), 'class' => 'form-control' ]) !!}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-3 name padding-top-8">
                                                {{ trans('tqawel_offer_contract.contract_amount') }}
                                            </div>
                                            <div class="col-md-9 value form-group no-padding-top">
                                                {!! Form::number('contract_amount', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.contract_amount'), 'class' => 'form-control' ]) !!}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-3 name padding-top-8">
                                                {{ trans('tqawel_offer_contract.start_date') }}
                                            </div>
                                            <div class="col-md-9 value form-group no-padding-top">
                                                {!! Form::text('start_date', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.start_date'), 'class' => 'form-control date-picker-event from' ]) !!}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-3 name padding-top-8">
                                                {{ trans('tqawel_offer_contract.end_date') }}
                                            </div>
                                            <div class="col-md-9 value form-group no-padding-top">
                                                {!! Form::text('end_date', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.end_date'), 'class' => 'form-control date-picker-event to' ]) !!}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-3 name padding-top-8">
                                                {{ trans('tqawel_offer_contract.duration') }} {{ trans('tqawel_offer_contract.inmonth')}}
                                            </div>
                                            <div class="col-md-9 value form-group no-padding-top">
                                                {!! Form::number('duration', null, [ 'placeholder' => trans('tqawel_offer_contract.duration'), 'class' => 'form-control  duration', 'disabled' => 'disabled']) !!}
                                            </div>
                                        </div>
                                        <div class="row static-info padding-top-5">
                                            <div class="col-md-3 name padding-top-5">
                                                {{ trans('tqawel_offer_contract.contract_type') }}
                                            </div>
                                            <div class="col-md-9 value form-group no-padding-top">
                                                <div class="md-radio-inline">
                                                    <div class="md-radio">
                                                        <input type="radio" id="radio6" name="contract_type" checked value="2" class="md-radiobtn">
                                                        <label for="radio6">
                                                            <span></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> {{ trans('tqawel_offer_contract.direct_hiring') }}
                                                        </label>
                                                    </div>

                                                    <div class="md-radio">
                                                        <input type="radio" id="radio7" name="contract_type" value="1" class="md-radiobtn">
                                                        <label for="radio7">
                                                            <span></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> {{ trans('tqawel_offer_contract.indirect_hiring') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row static-info" style="display: none;">
                                            <span class="col-md-3 name padding-top-8">
                                                {{ trans('tqawel_offer_contract.contract_ref_no') }}
                                            </span>
                                            <span class="col-md-9 value form-group no-padding-top">
                                                {!! Form::select('contract_ref_no', $contracts, [], [ 'placeholder' =>  trans('tqawel_offer_contract.contract_ref_no'), 'class' => 'form-control' ]) !!}
                                            </span>
                                        </div>

                                        <div class="row static-info padding-top-5">
                                            <div class="col-md-3 name padding-top-5">
                                                {{ trans('tqawel_offer_contract.work_locations') }}
                                            </div>
                                            <div class="col-md-9 value form-group no-padding-top container-inputs">
                                                <input id="pac-input" class="form-control" type="text" placeholder="{{ trans('labels.enter') . " " . trans('tqawel_offer_contract.work_locations') }}">
                                            </div>
                                        </div>
                                        @if($hasInvoices)
                                        <div class="row static-info">
                                            <div class="col-md-3 name padding-top-8"></div>
                                            <div class="col-md-9 value form-group no-padding-top">
                                                <a href="#" class="btn green add-new pull-right" data-error="{{ trans('tqawel_offer_contract.invalid_location') }}">{{ trans('tqawel_offer_contract.add_new') }}</a>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="row static-info">
                                            <div class="col-md-12 name no-padding-top">
                                                @include('components.map')
                                            </div>
                                        </div>

                                        <div class="row static-info">
                                            <div class="col-md-3 name padding-top-8">
                                                {{ trans('tqawel_offer_contract.attached_file') }}
                                            </div>
                                            <div class="col-md-9 name no-padding-top">
                                                @include('components.fileupload', ['name' => 'file_contract'])
                                            </div>
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

        <div class="row">
            <div class="col-md-12">
                <div class="text-align-left col-md-12">
                    @include('components.disclaimer_modal', ['id' => 'confirm', 'title' => trans('contracts.disclaimers'), 'content' => 'front.disclaimers.taqawel_apply_offer_disclaimer' ])

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirm">{{ trans('temp_job.save_and_send') }}</button>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>
<!-- END PAGE CONTENT BODY -->
<!-- END CONTENT BODY -->

@endsection