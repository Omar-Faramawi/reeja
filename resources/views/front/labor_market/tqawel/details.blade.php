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
                                    <i class=" icon-layers font-red"></i>
                                    <span class="caption-subject font-red sbold uppercase">{{ trans('contracts.details_contract') }}</span>
                                </div>
                            </div>
                            <div class="portlet-body">


                                <div class="form-body">

                                    @if(isset($canCancel) && !$canCancel)
                                        <div class="alert alert-info">
                                            {{ trans('contracts.can_delete') }}
                                        </div>
                                    @endif
                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('temp_job.service_provider_name') }}</p>
                                        <p><i>{{ $contract->provider_name  }}</i></p>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('temp_job.service_provider_number') }}</p>
                                        <p><i>{{ $contract->provider_id }}</i></p>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('temp_job.service_benf_name') }}</p>
                                        <p><i>{{ $contract->benf_name }}</i></p>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('temp_job.service_benf_number') }}</p>
                                        <p><i>{{ $contract->benf_id }}</i></p>
                                    </div>

                                    <div class="caption">
                                        <h5>{{ trans('temp_job.application_info') }}</h5><br>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('tqawel_offer_contract.contract_name') }}</p>
                                        <p><i>{{ $contract->contract_name }}</i></p>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('tqawel_offer_contract.contract_desc') }}</p>
                                        <p><i>{{ $contract->contract_desc }}</i></p>
                                    </div>


                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('tqawel_offer_contract.contract_nature') }}</p>
                                        <p><i>{{ $contract->contractNature->name }}</i></p>
                                    </div>


                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('tqawel_offer_contract.work_locations') }}</p>
                                        <p>
                                            @if($contract->contractLocations->pluck('desc_location')->count() > 0)
                                                @foreach($contract->contractLocations->pluck('desc_location')->toArray() as $location)
                                                    @if(!empty($location))
                                                    {{$location }} <br>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </p>
                                    </div>



                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('tqawel_offer_contract.start_date') }}</p>
                                        <p><i>{{ $contract->start_date }}</i></p>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('tqawel_offer_contract.end_date') }}</p>
                                        <p><i>{{ $contract->end_date }}</i></p>
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