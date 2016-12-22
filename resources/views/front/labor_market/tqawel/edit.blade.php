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
                                    <i class=" icon-layers font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">
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
                                    {!! Form::model($contract, ['route' => [ 'taqawel.contracts.update', $contract->id ], 'method' => 'PUT', 'id' =>'form','files' => true , 'data-url'=> route('taqawel.received-contracts'), 'class' => 'taqawel_contract_edit_form' ]) !!}
                                @else
                                    {!! Form::model($contract, ['route' => [ 'taqawel.contracts.update', $contract->id ], 'method' => 'PUT', 'id' =>'form','files' => true , 'data-url'=> route('taqawel.contracts'), 'class' => 'taqawel_contract_edit_form' ]) !!}
                                @endif

                                {!! Form::hidden('contract_id', $contract->id) !!}
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
                                                    {{ $contract->provider_name }}
                                                </div>
                                            </div>
                                            @if($contract->provider_type == Constants::USERTYPES['est'])
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
                                                    {{ @$contract->benf_name }}
                                                </div>
                                            </div>
                                            @if($contract->benf_type == Constants::USERTYPES['est'])
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("temp_job.est_activity")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $contract->benef->est_activity }}
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
                                                    {{ $contract->contractNature->name }}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name padding-top-8">
                                                    {{ trans('tqawel_offer_contract.contract_name') }}
                                                </div>
                                                @if($contract->status == 'approved')
                                                <div class="col-md-9 value form-group padding-top-8">
                                                    {{ $contract->contract_name }}
                                                </div>
                                                @else
                                                <div class="col-md-9 value form-group no-padding-top">
                                                   {!! Form::text('contract_name', null,
                                                        [ 'placeholder' => trans('labels.enter') . " ". trans('tqawel_offer_contract.contract_name'),
                                                        'class' => 'form-control' ]) !!}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name padding-top-8">
                                                    {{ trans('tqawel_offer_contract.contract_desc') }}
                                                </div>
                                                @if($contract->status == 'approved')
                                                <div class="col-md-9 value form-group padding-top-8">
                                                    {!! nl2br($contract->contract_desc) !!}
                                                </div>
                                                @else
                                                <div class="col-md-9 value form-group no-padding-top">
                                                    {!! Form::textarea('contract_desc', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.contract_desc'), 'class' => 'form-control' ]) !!}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name padding-top-8">
                                                    {{ trans('tqawel_offer_contract.contract_amount') }}
                                                </div>
                                                @if($contract->status == 'approved')
                                                <div class="col-md-9 value form-group padding-top-8">
                                                    {{ $contract->contract_amount }}
                                                </div>
                                                @else
                                                <div class="col-md-9 value form-group no-padding-top">
                                                    {!! Form::text('contract_amount', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.contract_amount'), 'class' => 'form-control' ]) !!}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name padding-top-8">
                                                    {{ trans('tqawel_offer_contract.start_date') }}
                                                </div>
                                                @if($contract->status == 'approved')
                                                <div class="col-md-9 value form-group padding-top-8">
                                                    {{ $contract->start_date }}
                                                </div>
                                                @else
                                                <div class="col-md-9 value form-group no-padding-top">
                                                    {!! Form::text('start_date', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.start_date'), 'class' => 'form-control date-picker-event from' ]) !!}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name padding-top-8">
                                                    {{ trans('tqawel_offer_contract.end_date') }}
                                                </div>
                                                @if($contract->status == 'approved')
                                                <div class="col-md-9 value form-group padding-top-8">
                                                    {{ $contract->end_date }}
                                                </div>
                                                @else
                                                <div class="col-md-9 value form-group no-padding-top">
                                                    {!! Form::text('end_date', null, [ 'placeholder' => trans('labels.enter') . " " . trans('tqawel_offer_contract.end_date'), 'class' => 'form-control date-picker-event to' ]) !!}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name padding-top-8">
                                                {{ trans('tqawel_offer_contract.duration') }} {{ trans('tqawel_offer_contract.inmonth')}}
                                                </div>
                                                @if($contract->status == 'approved')
                                                <div class="col-md-9 value form-group padding-top-8">
                                                    {{ $period }}
                                                </div>
                                                @else
                                                <div class="col-md-9 value form-group no-padding-top">
                                                {!! Form::number('duration', (isset($period)?$period:''), [ 'placeholder' => trans('tqawel_offer_contract.duration'), 'class' => 'form-control  duration',(isset($contract->start_date)?'':'disabled') ]) !!}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="row static-info padding-top-5">
                                                <div class="col-md-3 name padding-top-5">
                                                    {{ trans('tqawel_offer_contract.contract_type') }}
                                                </div>
                                                @if($contract->status == 'approved')
                                                <div class="col-md-9 value form-group padding-top-8">
                                                    @if($contract->contract_ref_no)
                                                        {{ trans('tqawel_offer_contract.indirect_hiring') }}
                                                    @else
                                                        {{ trans('tqawel_offer_contract.direct_hiring') }}
                                                    @endif
                                                </div>
                                                @else
                                                <div class="col-md-9 value form-group no-padding-top">
                                                    <div class="md-radio-inline">
                                                        <div class="md-radio">
                                                            <input type="radio" id="radio6" name="contract_type" value="2"
                                                                   class="md-radiobtn"
                                                                   @if(!$contract->contract_ref_no) checked @endif>
                                                            <label for="radio6">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> {{ trans('tqawel_offer_contract.direct_hiring') }}
                                                            </label>
                                                        </div>

                                                        <div class="md-radio">
                                                            <input type="radio" id="radio7" name="contract_type" value="1"
                                                                   class="md-radiobtn"
                                                                   @if($contract->contract_ref_no) checked @endif>
                                                            <label for="radio7">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> {{ trans('tqawel_offer_contract.indirect_hiring') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="row static-info" @if(!$contract->contract_ref_no) style="display: none;" @endif>
                                                <span class="col-md-3 name padding-top-8">
                                                    {{ trans('tqawel_offer_contract.contract_ref_no') }}
                                                </span>
                                                @if($contract->status == 'approved')
                                                <span class="col-md-9 value form-group padding-top-8">
                                                    {{ $contract->contract_ref_no }}
                                                </span>
                                                @else
                                                <span class="col-md-9 value form-group no-padding-top">
                                                    {!! Form::select('contract_ref_no', $contracts, [$contract->contract_ref_no], [ 'placeholder' =>  trans('tqawel_offer_contract.contract_ref_no'), 'class' => 'form-control' ]) !!}
                                                </span>
                                                @endif
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name padding-top-8">
                                                    {{ trans('tqawel_offer_contract.work_locations') }}
                                                </div>
                                                <div class="col-md-9 value form-group no-padding-top container-inputs">
                                                    @if($contract->contractLocations->pluck('desc_location')->count() > 0)
                                                        @foreach($contract->contractLocations->pluck('desc_location')->toArray() as $location)
                                                            @if(!empty($location))
                                                                <label class="col-md-12 no-padding-right">
                                                                    {{ $location }}&nbsp;
                                                                    <button class="btn red-intense remove_location" type="button">{{ trans('labels.delete') }}</button>
                                                                    <input type="hidden" name="desc_location[]" value="{{ $location }}">
                                                                </label>
                                                            @endif
                                                        @endforeach
                                                    @endif
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
                                                    {!! Form::hidden('file_contract_old', @$contract->contract_file) !!}
                                                    @include('components.fileupload', ['name' => 'file_contract', 'value' => @$contract->contract_file])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                        <button type="submit" name="status" class="submit_contract_edit_btn btn green update_contract"
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
<div class="modal fade" id="contract_edit_endorsement">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{trans('labels.endorsement')}}</h4>
            </div>
            <div class="modal-body">
                <div class="well">
                    @if($contract->status == 'requested')
                        {!! trans('endorsements.offer_taqawel_contract_disclaimer') !!}
                    @else
                        {!! trans('endorsements.edit_taqawel_contract_disclaimer', ['contract_number' => $contract->id, 'start_date' => $contract->start_date, 'now' => date('Y-m-d', time())]) !!}
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="taqawel_edit_contract_modal_approve btn btn-success"
                        data-dismiss="modal">{{trans('labels.approve')}}</button>
                <button type="button"
                        class="taqawel_edit_contract_modal_deny btn btn-danger">{{trans('labels.cancel')}}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->