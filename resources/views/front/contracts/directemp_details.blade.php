@extends('front.layout')
@section('title', trans('user.home'))
@section("content")
    <div class="page-content">
        <div class="container">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">
                <div class="row">
                    <div class="col-md-12">

                        @if(isset($contract))
                            <div class="portlet light portlet-fit portlet-datatable">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-info-circle"></i>{{trans("contracts.contractDetails")}}
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="portlet grey-cascade box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>{{trans("offersdirect.providerInfo")}}
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.providerName")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $contract->benf_name }}
                                                </div>
                                            </div>
                                            @if(isset($contract->benef->est_activity))
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.providerType")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $contract->benef->est_activity }}
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="portlet grey-cascade box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>{{trans("offersdirect.benfInfo")}}
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.benfName")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $contract->provider_name }}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.benfNo")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $contract->provider_id }}
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="portlet grey-cascade box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                {{trans("offersdirect.offerDetails")}}
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.job")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $contract->vacancy->job->job_name or $jobSeeker->job->job_name }}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.nationality")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $contract->vacancy->nationality->name or $jobSeeker->nationality->name }}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.gender")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $contract->vacancy->gender_name or $jobSeeker->gender_name }}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.religion")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $contract->vacancy->religion_name or $jobSeeker->religion_name }}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.workStartDate")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $contract->start_date }}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.workEndDate")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $contract->end_date }}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.region")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $contract->vacancy->region->name or $jobSeeker->region->name }}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.jobtype")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $contract->vacancy->job_type_text or $jobSeeker->job_type_name }}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.salary")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $contract->contract_amount }}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.workplaces")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {!! nl2br(@$contract->vacancy->locations[0]->location) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">{{trans("contracts.contractStatus")}}</div>
                                        <div class="col-lg-2">{{trans("labels.contractStatus." . $contract->status)}}</div>
                                        <div class="col-lg-7"></div>
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="text-align-left col-md-12">
                                            @if($contract->status == 'requested')
                                                <div class="text-align-left col-md-12">
                                                    <button type="button" class="btn btn-primary btn-danger btn-lg" data-toggle="modal" data-target="#myModal">{{ trans('temp_job.refuse') }}</button>
                                                    @include('components.modal', ['id' => 'myModal', 'title' => trans('contracts.cancel_reason'), 'content' => 'front.contracts.partials.change-status', 'route' => 'contracts.update_status', 'dataUrl' => route('direct_hiring.contracts.received-contracts') ])
                                                </div>
                                            @elseif(isset($canCancel) && $canCancel)
                                                <button type="button" class="btn btn-primary btn-danger btn-lg" data-toggle="modal"
                                                        data-target="#myModal">
                                                    {{ trans('contracts.reset') }}
                                                </button>
                                                @include('components.modal', ['id' => 'myModal', 'title' => trans('contracts.reason'), 'content' => 'front.contracts.partials.cancel', 'route' => 'contracts.update_status', 'dataUrl' => route('direct_hiring.contracts') ])
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        @else
                            <div class="portlet box red">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-warning"></i>{{trans("offersdirect.error")}}
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    {{trans("offersdirect.errorDetails")}}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection