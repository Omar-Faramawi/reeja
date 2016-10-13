@extends('front.layout')
@if($contract->status == 'requested')
    @section('title', trans('temp_job.offer_contract'))
@else
    @section('title', trans('tqawel_offer_contract.edit'))
@endif
@section('content')

        <!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('labels.system_name') }}
                <small>
                    @if($contract->status == 'requested')
                        {{ trans('temp_job.offer_contract') }}
                    @else
                        {{ trans('tqawel_offer_contract.edit') }}
                    @endif
                </small>
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
                                <span class="caption-subject font-red sbold uppercase">
                                    @if($contract->status == 'requested')
                                        {{ trans('temp_job.offer_contract') }}
                                    @else
                                        {{ trans('tqawel_offer_contract.edit') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="portlet-body">

                            <!-- BEGIN FORM-->
                            @if($contract->status == 'requested')
                                {!! Form::model($contract, ['route' => [ 'taqawel.contracts.update', $contract->id ], 'method' => 'PUT', 'id' =>'form','files' => true , 'data-url'=> route('taqawel.received-contracts') ]) !!}
                            @else
                                {!! Form::model($contract, ['route' => [ 'taqawel.contracts.update', $contract->id ], 'method' => 'PUT', 'id' =>'form','files' => true , 'data-url'=> route('taqawel.contracts') ]) !!}
                            @endif

                            {!! Form::hidden('contract_id', $contract->id) !!}
                            <div class="form-body">

                                <h5>{{ trans('temp_job.service_provider_info') }}</h5><br>
                                <div class="form-group form-md-line-input">
                                    {!! Form::text('provider_id', $username, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.service_provider_name'), 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    <label for="form_control_1">{{ trans('temp_job.service_provider_name') }}</label>
                                    <span class="help-block">{{ trans('temp_job.service_provider_name') }}</span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    {!! Form::text('provider_type', \Tamkeen\Ajeer\Utilities\Constants::userTypes(\Auth::user()->user_type_id), [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.est_activity'), 'class' => 'form-control',  'disabled' => 'disabled' ]) !!}
                                    <label for="form_control_1">{{ trans('temp_job.est_activity') }}</label>
                                    <span class="help-block">{{ trans('temp_job.est_activity') }}</span>
                                </div>
                                <h5>{{ trans('temp_job.service_benf_info') }}</h5><br>

                                <div class="form-group form-md-line-input">
                                    {!! Form::text('benf_id', @$contract->benf_name, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.service_benf_name'), 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    <label for="form_control_1">{{ trans('temp_job.service_benf_name') }}</label>
                                    <span class="help-block">{{ trans('temp_job.service_benf_name') }}</span>
                                </div>

                                <div class="form-group form-md-line-input">
                                    {!! Form::text('benf_type', \Tamkeen\Ajeer\Utilities\Constants::userTypes
                                    ($contract->benf_type), [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.est_activity'), 'class' => 'form-control',  'disabled' => 'disabled' ]) !!}
                                    <label for="form_control_1">{{ trans('temp_job.est_activity') }}</label>
                                    <span class="help-block">{{ trans('temp_job.est_activity') }}</span>
                                </div>

                                <div class="caption">
                                    <h5>{{ trans('tqawel_offer_contract.contract_details') }}</h5><br>
                                </div>

                                <div class="form-group form-md-line-input">
                                    {!! Form::text('', $contract->contractNature->name, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    <label for="form_control_1">{{ trans('tqawel_offer_contract.contract_nature') }}</label>
                                    <span class="help-block">{{ trans('tqawel_offer_contract.contract_nature') }}</span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    @if($contract->status == 'approved')
                                        {!! Form::text('contract_name', null,
                                        [ 'placeholder' => trans('labels.enter') . " ". trans('tqawel_offer_contract.contract_name'), 'disabled' => 'disabled',
                                        'class' => 'form-control' ]) !!}
                                    @else
                                        {!! Form::text('contract_name', null,
                                        [ 'placeholder' => trans('labels.enter') . " ". trans('tqawel_offer_contract.contract_name'),
                                        'class' => 'form-control' ]) !!}
                                    @endif
                                    <label for="form_control_1">{{ trans('tqawel_offer_contract.contract_name')
                                        }}</label>
                                        <span class="help-block">{{ trans('tqawel_offer_contract.contract_name')
                                        }}</span>
                                </div>


                                <div class="form-group form-md-line-input">
                                    @if($contract->status == 'approved')
                                        {!! Form::textarea('contract_desc', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.contract_desc'), 'class' => 'form-control', 'disabled' => 'disabled' ]) !!}
                                    @else
                                        {!! Form::textarea('contract_desc', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.contract_desc'), 'class' => 'form-control' ]) !!}
                                    @endif
                                    <label for="form_control_1">{{ trans('tqawel_offer_contract.contract_desc')
                                        }}</label>
                                        <span class="help-block">{{ trans('tqawel_offer_contract.contract_desc')
                                        }}</span>
                                </div>


                                <div class="form-group form-md-line-input">
                                    @if($contract->status == 'approved')
                                        {!! Form::text('contract_amount', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.contract_amount'), 'class' => 'form-control', 'disabled' => 'disabled' ]) !!}
                                    @else
                                        {!! Form::text('contract_amount', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.contract_amount'), 'class' => 'form-control' ]) !!}
                                    @endif
                                    <label for="form_control_1">{{ trans('tqawel_offer_contract.contract_amount')
                                        }}</label>
                                        <span class="help-block">{{ trans('tqawel_offer_contract.contract_amount')
                                        }}</span>
                                </div>


                                <div class="form-group form-md-line-input">
                                    @if($contract->status == 'approved')
                                        {!! Form::text('start_date', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.start_date'), 'class' => 'form-control date-picker-event from', 'disabled' => 'disabled' ]) !!}
                                    @else
                                        {!! Form::text('start_date', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.start_date'), 'class' => 'form-control date-picker-event from' ]) !!}
                                    @endif
                                    <label for="form_control_1">{{ trans('tqawel_offer_contract.start_date')
                                        }}</label>
                                        <span class="help-block">{{ trans('tqawel_offer_contract.start_date')
                                        }}</span>
                                </div>


                                <div class="form-group form-md-line-input">
                                    @if($contract->status == 'approved')
                                        {!! Form::text('end_date', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.end_date'), 'class' => 'form-control date-picker-event to', 'disabled' => 'disabled' ]) !!}
                                    @else
                                        {!! Form::text('end_date', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.end_date'), 'class' => 'form-control date-picker-event to' ]) !!}
                                    @endif
                                    <label for="form_control_1">{{ trans('tqawel_offer_contract.end_date')
                                        }}</label>
                                        <span class="help-block">{{ trans('tqawel_offer_contract.end_date')
                                        }}</span>
                                </div>



                                <div class="form-group form-md-radios form-md-line-input">
                                    <label class="col-md-3 control-label"
                                           for="form_control_1">{{ trans('tqawel_offer_contract.contract_type') }}</label>
                                    <div class="col-md-9">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" id="radio6" name="contract_type" value="2" class="md-radiobtn" @if($contract->status == 'approved') disabled="" @endif @if(!$contract->contract_ref_no) checked @endif>
                                                <label for="radio6">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{ trans('tqawel_offer_contract.direct_hiring') }}
                                                </label>
                                            </div>

                                            <div class="md-radio">
                                                <input type="radio" id="radio7" name="contract_type" value="1" class="md-radiobtn" @if($contract->status == 'approved') disabled="" @endif @if($contract->contract_ref_no) checked @endif>
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


                                <div class="form-group form-md-line-input" @if(!$contract->contract_ref_no) style="display: none;" @endif>
                                     @if($contract->status == 'approved')
                                        {!! Form::text('contract_ref_no', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.contract_ref_no'), 'class' => 'form-control', 'disabled' => 'disabled' ]) !!}
                                    @else
                                    {!! Form::select('contract_ref_no', $contracts, [$contract->contract_ref_no], [ 'placeholder' =>  trans('tqawel_offer_contract.contract_ref_no'), 'class' => 'form-control' ]) !!}
                                     @endif
                                    <label for="form_control_1">{{ trans('tqawel_offer_contract.contract_ref_no')
                                        }}</label>
                                        <span class="help-block">{{ trans('tqawel_offer_contract.contract_ref_no')
                                        }}</span>
                                </div>

                                @if($contract->contractLocations->pluck('desc_location')->count() > 0)
                                    <div class="form-group form-md-line-input add-input">
                                        <label class="control-label col-md-1">{{ trans('tqawel_offer_contract.work_locations') }}</label>
                                        <div class="col-md-11 container-inputs">
                                            @foreach($contract->contractLocations->pluck('desc_location')->toArray() as $location)
                                                @if(!empty($location))
                                                    {!! Form::text('desc_location[]', $location, ['class' => 'bs-select form-control desc-location']) !!}
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group form-md-line-input add-input">
                                        <label class="control-label col-md-1">{{ trans('tqawel_offer_contract.work_locations') }}</label>
                                        <div class="col-md-11 container-inputs">
                                            {!! Form::text('desc_location[]', '', ['class' => 'bs-select form-control desc-location']) !!}
                                        </div>
                                    </div>
                                @endif
                                    @if($hasInvoices > 0)
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
                                    {{--<label class="control-label col-md-1">{{ trans('tqawel_offer_contract.file_upload') }}</label>--}}
                                    @include('components.fileupload', ['name' => 'file_contract'])
                                </div>

                                <br><br>

                                @if($contract->contract_file)
                                    <div class="form-group form-md-line-input">
                                        <ul>
                                            <li><a href="{{ url('uploads/' . $contract->contract_file) }}">{{ basename($contract->contract_file) }}</a></li>
                                        </ul>
                                    </div>
                                @endif

                            </div>
                            <div class="clear"></div>


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
                    <button type="submit" name="status" class="btn green update_contract"
                            value="pending">{{ trans('temp_job.save_and_send') }}</button>
                </div>
            </div>
        </div>

        {!! Form::close() !!}

    </div>
</div>
<!-- END PAGE CONTENT BODY -->
<!-- END CONTENT BODY -->

@endsection