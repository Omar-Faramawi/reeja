@extends('front.layout')
@section('title', trans('user.home'))
@section("content")
    <div class="page-content">
        <div class="container">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">
                <div class="row">
                    <div class="col-md-12">

                        @if(isset($thisContract))
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
                                                    {{$thisContract['benf_name']}}
                                                </div>
                                            </div>
                                            @if(isset($thisContract['benef']['est_activity']))
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.providerType")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract['benef']['est_activity']}}
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
                                                    {{ $thisContract['provider']['name'] }}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.benfNo")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ ($thisContract['provider']['id'])}}
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
                                                    {{$thisContract['vacancy']['job']['job_name'] or $thisContract['contract_employee'][0]['hr_pool']['job']['job_name']}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.nationality")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract['vacancy']['nationality']['name'] or $thisContract['contract_employee'][0]['hr_pool']['nationality']['name']}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.gender")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract['vacancy']['gender_name'] or $thisContract['contract_employee'][0]['hr_pool']['gender_name']}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.religion")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract['vacancy']['religion_name'] or $thisContract['contract_employee'][0]['hr_pool']['religion_name']}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.workStartDate")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract['start_date']}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.workEndDate")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract['end_date']}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.region")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract['vacancy']['region']['name'] or $thisContract['contract_employee'][0]['hr_pool']['region']['name']}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.jobtype")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract['vacancy']['job_type_text'] or $thisContract['contract_employee'][0]['hr_pool']['job_type_name']}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.salary")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract['contract_amount']}}
                                                </div>
                                            </div>
                                            @if (is_array($thisContract['contract_locations']))
                                                @foreach($thisContract['contract_locations'] as $location)
                                                    <div class="row static-info">
                                                        <div class="col-md-3 name">
                                                            {{trans("offersdirect.workplaces")}}
                                                        </div>
                                                        <div class="col-md-9 value">
                                                            {!! nl2br($location['desc_location']) !!}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("contracts.contractStatus")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{trans("labels.contractStatus." . $thisContract['status'])}}
                                                </div>
                                            </div>

                                            @if($thisContract['status'] == 'rejected' || $thisContract['status'] == 'cancelled' || $thisContract['status'] == 'benef_cancel' || $thisContract['status'] == 'provider_cancel')
                                                <div class="row static-info">
                                                    <div class="col-md-3 name">
                                                        @if($thisContract['status'] == 'rejected')
                                                            {{ trans('contracts.cancel_reason') }}
                                                        @else
                                                            {{ trans('contracts.rejection_reason') }}
                                                        @endif
                                                    </div>
                                                    <div class="col-md-9 value">
                                                        @if($thisContract['other_reasons'])
                                                            {{ $thisContract['other_reasons'] }}
                                                        @elseif($thisContract['reason_id'])
                                                            {{ $thisContract['reason']['reason'] }}
                                                        @endif
                                                    </div>
                                                </div>
                                                @if($thisContract['rejection_reason'])
                                                <div class="row static-info">
                                                    <div class="col-md-3 name">
                                                        @if($thisContract['status'] == 'rejected')
                                                            {{ trans('contracts.more_details_about_rejection') }}
                                                        @else
                                                            {{ trans('contracts.more_details_about_cancellation') }}
                                                        @endif
                                                    </div>
                                                    <div class="col-md-9 value">
                                                        {!! nl2br($thisContract['rejection_reason']) !!}
                                                    </div>
                                                </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    @if($thisContract['contract_edits'])

                                    <div class="portlet grey-cascade box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>{{trans("offersdirect.contractEdits")}}
                                            </div>
                                        </div>
                                        <div class="portlet-body">

                                            @foreach($thisContract['contract_edits'] as $edit)
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqaweloffers.workplaces")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$edit['contract_locations']}}
                                                </div>
                                            </div>
                                            @if ($edit['contract_file'])
                                                <div class="row static-info">
                                                    <div class="col-lg-3">{{trans("temp_job.attachment")}}</div>
                                                    <div class="col-lg-2">
                                                        <a href="{{ url('uploads/'. $edit['contract_file']) }}"
                                                           download>
                                                            <i class="fa fa-file"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.contractEditsatStatus")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{trans("labels.contractStatus." . $edit['status'])}}
                                                </div>
                                            </div>
                                            <hr>
                                            
                                             @if(!$EditedtoMe)
                                            {{ Form::open(['url' => 'edit_contract/'.$edit['id'].'/approve','id'=>'form', 'class'=>'form-horizontal vacancies_form','data-url' => '']) }}
                                            <button type="submit" class="btn green" data-loading-text="{{ trans('labels.loading') }}..." >{{trans('offersdirect.editApprove')}}</button>

                                             <a type="button" data-loading-text="{{ trans('labels.loading') }}..."  href="{{ url('edit_contract/'.$edit['id'].'/reject') }}" class="btn red contract_edit_reject" >{{ trans('offersdirect.editReject') }}</a>
                                            {{form::close()}}
                                             @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
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