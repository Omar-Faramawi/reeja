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

                                <h5>{{ trans('temp_job.service_provider_info') }}</h5><br>
                                <div class="form-group form-md-line-input">
                                    {!! Form::text('', $username, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.service_provider_name'), 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    <label for="form_control_1">{{ trans('temp_job.service_provider_name') }}</label>
                                    <span class="help-block">{{ trans('temp_job.service_provider_name') }}</span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    {!! Form::text('', \Tamkeen\Ajeer\Utilities\Constants::userTypes(\Auth::user()->user_type_id), [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.est_activity'), 'class' => 'form-control',  'disabled' => 'disabled' ]) !!}
                                    <label for="form_control_1">{{ trans('temp_job.est_activity') }}</label>
                                    <span class="help-block">{{ trans('temp_job.est_activity') }}</span>
                                </div>
                                <h5>{{ trans('temp_job.service_benf_info') }}</h5><br>

                                <div class="form-group form-md-line-input">
                                    {!! Form::text('', $marketServices->providername, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.service_benf_name'), 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    <label for="form_control_1">{{ trans('temp_job.service_benf_name') }}</label>
                                    <span class="help-block">{{ trans('temp_job.service_benf_name') }}</span>
                                </div>

                                <div class="form-group form-md-line-input">
                                    {!! Form::text('', \Tamkeen\Ajeer\Utilities\Constants::userTypes
                                    ($marketServices->service_prvdr_benf_id), [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.est_activity'), 'class' => 'form-control',  'disabled' => 'disabled' ]) !!}
                                    <label for="form_control_1">{{ trans('temp_job.est_activity') }}</label>
                                    <span class="help-block">{{ trans('temp_job.est_activity') }}</span>
                                </div>

                                <div class="caption">
                                    <h5>{{ trans('tqawel_offer_contract.contract_details') }}</h5><br>
                                </div>

                                <div class="form-group form-md-line-input">
                                    {!! Form::text('', $marketServices->contractNature->name, [
                                    'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.contract_nature_id'), 'class' => 'form-control',  'disabled' => 'disabled' ]) !!}
                                    {!! Form::hidden('market_taqaual_services_id', $id) !!}
                                    <label for="form_control_1">{{ trans('tqawel_offer_contract.contract_nature') }}</label>
                                    <span class="help-block">{{ trans('tqawel_offer_contract.contract_nature') }}</span>
                                </div>

                                <div class="form-group form-md-line-input">
                                    {!! Form::text('contract_name', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.contract_name'), 'class' => 'form-control' ]) !!}
                                    <label for="form_control_1">{{ trans('tqawel_offer_contract.contract_name')
                                        }}</label>
                                        <span class="help-block">{{ trans('tqawel_offer_contract.contract_name')
                                        }}</span>
                                </div>


                                <div class="form-group form-md-line-input">
                                    {!! Form::textarea('contract_desc', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.contract_desc'), 'class' => 'form-control' ]) !!}
                                    <label for="form_control_1">{{ trans('tqawel_offer_contract.contract_desc')
                                        }}</label>
                                        <span class="help-block">{{ trans('tqawel_offer_contract.contract_desc')
                                        }}</span>
                                </div>


                                <div class="form-group form-md-line-input">
                                    {!! Form::number('contract_amount', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.contract_amount'), 'class' => 'form-control' ]) !!}
                                    <label for="form_control_1">{{ trans('tqawel_offer_contract.contract_amount')
                                        }}</label>
                                        <span class="help-block">{{ trans('tqawel_offer_contract.contract_amount')
                                        }}</span>
                                </div>


                                <div class="form-group form-md-line-input">
                                    {!! Form::text('start_date', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.start_date'), 'class' => 'form-control date-picker-event from' ]) !!}
                                    <label for="form_control_1">{{ trans('tqawel_offer_contract.start_date')
                                        }}</label>
                                        <span class="help-block">{{ trans('tqawel_offer_contract.start_date')
                                        }}</span>
                                </div>


                                <div class="form-group form-md-line-input">
                                    {!! Form::text('end_date', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.end_date'), 'class' => 'form-control date-picker-event to' ]) !!}
                                    <label for="form_control_1">{{ trans('tqawel_offer_contract.end_date')
                                        }}</label>
                                        <span class="help-block">{{ trans('tqawel_offer_contract.end_date')
                                        }}</span>
                                </div>


                                <div class="form-group form-md-line-input">
                                    {!! Form::number('duration', null, [ 'placeholder' => trans('tqawel_offer_contract.duration'), 'class' => 'form-control  duration', 'disabled' => 'disabled']) !!}
                                    <label for="form_control_1">{{ trans('tqawel_offer_contract.duration')}} {{ trans('tqawel_offer_contract.inmonth')}}</label> <div id="not_allowed_period" class="font-red"></div>
                                        <span class="help-block">{{ trans('tqawel_offer_contract.duration')
                                        }}</span>
                                </div>

                                <div class="form-group form-md-radios form-md-line-input">
                                    <label class="col-md-3 control-label"
                                           for="form_control_1">{{ trans('tqawel_offer_contract.contract_type') }}</label>
                                    <div class="col-md-9">
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
                                <br>


                                <div class="form-group form-md-line-input" style="display: none;">
                                    {!! Form::select('contract_ref_no', $contracts, [], [ 'placeholder' =>  trans('tqawel_offer_contract.contract_ref_no'), 'class' => 'form-control' ]) !!}

                                    <label for="form_control_1">{{ trans('tqawel_offer_contract.contract_ref_no')
                                        }}</label>
                                        <span class="help-block">{{ trans('tqawel_offer_contract.contract_ref_no')
                                        }}</span>
                                </div>


                                <div class="form-group form-md-line-input add-input">
                                    <label class="control-label col-md-1">{{ trans('tqawel_offer_contract.work_locations') }}</label>
                                    <div class="col-md-10 container-inputs">
                                        {!! Form::text('desc_location[]', null, ['class' => 'bs-select form-control desc-location']) !!}
                                    </div>
                                </div>

                                @if($hasInvoices)
                                    <div class="form-group form-md-line-input">
                                        <div class="col-md-11">
                                            <a href="#" class="btn green add-new" style="margin-top:20px">{{ trans('tqawel_offer_contract.add_new') }}</a>
                                        </div>
                                    </div>
                                @endif

                                <div class="clearfix"></div>

                                <br><br>
                                <div class="form-group">
                                    <label class="control-label col-md-1">{{ trans('tqawel_offer_contract.attached_file') }}</label>
                                    @include('components.fileupload', ['name' => 'file_contract'])
                                </div>

                                <br><br>

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