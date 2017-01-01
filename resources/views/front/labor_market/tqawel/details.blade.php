@extends('front.layout')
@section('title', trans('contracts.details_contract'))
@section('content')

    <!-- BEGIN PAGE CONTENT BODY -->
    <div class="page-content">
        <div class="container">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">
                <div class="row">

                    <div class="col-md-12">

                        <div class="portlet light portlet-fit portlet-form ">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class=" icon-layers font-dark"></i>
                                    <span class="caption-subject font-dark sbold uppercase">{{ trans('contracts.details_contract') }}</span>
                                </div>
                            </div>
                            <div class="portlet-body">


                                <div class="form-body">

                                    @if(isset($canCancel) && !$canCancel)
                                        <div class="alert alert-info">
                                            {{ trans('contracts.can_delete') }}
                                        </div>
                                    @endif
                                    <div class="portlet grey-cascade box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>{{trans("temp_job.service_provider_info")}}
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("temp_job.service_provider_name")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$contract->provider_name}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("temp_job.service_provider_number")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$contract->provider_id}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="portlet grey-cascade box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>{{trans("temp_job.service_benf_info")}}
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("temp_job.service_benf_name")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$contract->benf_name}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("temp_job.service_benf_number")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$contract->benf_id}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="portlet grey-cascade box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>{{trans("temp_job.application_info")}}
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqawel_offer_contract.contract_name")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$contract->contract_name}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqawel_offer_contract.contract_desc")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$contract->contract_desc}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqawel_offer_contract.contract_nature")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$contract->contractNature->name}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqawel_offer_contract.work_locations")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    @if($contract->contractLocations->pluck('desc_location')->count() > 0)
                                                        @foreach($contract->contractLocations->pluck('desc_location')->toArray() as $location)
                                                            @if(!empty($location))
                                                                {{$location }} <br>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqawel_offer_contract.start_date")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$contract->start_date}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqawel_offer_contract.end_date")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$contract->end_date}}
                                                </div>
                                            </div>
                                            @if ($contract->contract_file)
                                                <div class="row static-info">
                                                    <div class="col-lg-3">{{trans("tqawel_offer_contract.attached_file")}}</div>
                                                    <div class="col-lg-2">
                                                        <a href="{{ url('uploads/'. $contract->contract_file) }}"
                                                           download>
                                                            <i class="fa fa-file"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("contracts.contractStatus")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{trans("labels.contractStatus." . $contract->status)}}
                                                </div>
                                            </div>

                                            @if($contract->status == 'rejected' || $contract->status == 'cancelled' || $contract->status == 'benef_cancel' || $contract->status == 'provider_cancel')
                                                <div class="row static-info">
                                                    <div class="col-md-3 name">
                                                        @if($contract->status == 'rejected')
                                                            {{ trans('contracts.cancel_reason') }}
                                                        @else
                                                            {{ trans('contracts.rejection_reason') }}
                                                        @endif
                                                    </div>
                                                    <div class="col-md-9 value">
                                                        @if($contract->other_reasons)
                                                            {{ $contract->other_reasons }}
                                                        @elseif($contract->reason_id)
                                                            {{ $contract->reason->reason }}
                                                        @endif
                                                    </div>
                                                </div>
                                                @if($contract->rejection_reason)
                                                <div class="row static-info">
                                                    <div class="col-md-3 name">
                                                        @if($contract->status == 'rejected')
                                                            {{ trans('contracts.more_details_about_rejection') }}
                                                        @else
                                                            {{ trans('contracts.more_details_about_cancellation') }}
                                                        @endif
                                                    </div>
                                                    <div class="col-md-9 value">
                                                        {!! nl2br($contract->rejection_reason) !!}
                                                    </div>
                                                </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(isset($wantReject))
							<div class="text-align-left col-md-12">
								<button type="button" class="btn btn-primary btn-danger btn-lg" data-toggle="modal" data-target="#myModal">{{ trans('tqawel_offer_contract.reject') }}</button>
								@include('components.modal', ['id' => 'myModal', 'title' => trans('contracts.cancel_reason'), 'content' => 'front.contracts.partials.change-status', 'route' => 'contracts.update_status', 'dataUrl' => route('taqawel.received-contracts') ])
							</div>
                        @elseif(isset($canCancel) && isset($wantDelete) && $contract->status !== 'cancelled')

							<div class="text-align-left col-md-12">
								<button type="button" class="btn btn-primary btn-danger btn-lg" data-toggle="modal" data-target="#myModal">{{ trans('contracts.reset') }}</button>
								@include('components.modal', ['id' => 'myModal', 'title' => trans('contracts.rejection_reason'), 'content' => 'front.contracts.partials.change-status', 'route' => 'contracts.update_status', 'dataUrl' => route('taqawel.contracts') ])
							</div>
						@elseif($contract->status == 'cancelled')
							<div class="text-align-left col-md-12">
								<button type="button" class="btn btn-primary btn-danger btn-lg" data-toggle="modal" data-target="#myModal">{{ trans('contracts.reset_back') }}</button>
								@include('components.modal', ['id' => 'myModal', 'title' => trans('contracts.reset_back_reason'), 'content' => 'front.contracts.partials.cancel', 'route' => 'contracts.update_status', 'dataUrl' => route('taqawel.contracts') ])
							</div>
						@endif
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT BODY -->
    <!-- END CONTENT BODY -->

@endsection