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
                                                <i class="fa fa-info-circle"></i>{{trans("offers.providerInfo")}}</div>
                                        </div>

                                        <div class="portlet-body">

                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offers.providerName")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract['providername']}}
                                                </div>
                                            </div>
											@if(isset($thisContract['provider']['est_activity']))
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offers.providerType")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract['provider']['est_activity']}}
                                                </div>
                                            </div>
											@endif
                                        </div>
                                    </div>

                                    <div class="portlet grey-cascade box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>{{trans("offers.benfInfo")}}</div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offers.benfName")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $thisContract['benef']['name']}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offers.benfNo")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $thisContract['benef']['id'] }}
                                                    {{--$thisContract->byNo($thisContract->benf_type,$thisContract->benf_id)--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portlet grey-cascade box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>{{trans("tqaweloffers.contractInfo")}}
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqaweloffers.contractNo")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ ($thisContract['id'])}}
                                                </div>
                                            </div>
                                            @if(isset($thisContract['vacancy']))
                                                <div class="row static-info">
                                                    <div class="col-md-3 name">
                                                        {{trans("temp_job.job_id")}}
                                                    </div>
                                                    <div class="col-md-9 value">
                                                        {{ ($thisContract['vacancy']['job']['job_name'])}}
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-3 name">
                                                        {{trans("temp_job.nationality_id")}}
                                                    </div>
                                                    <div class="col-md-9 value">
                                                        {{ ($thisContract['vacancy']['nationality']['name'])}}

                                                    </div>
                                                </div>

                                                <div class="row static-info">
                                                    <div class="col-md-3 name">
                                                        {{trans("temp_job.gender.name")}}
                                                    </div>
                                                    <div class="col-md-9 value">
                                                        {{ ($thisContract['vacancy']['gender_name'])}}
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-3 name">
                                                        {{trans("temp_job.religion_id")}}
                                                    </div>
                                                    <div class="col-md-9 value">
                                                        {{ ($thisContract['vacancy']['religion_name'])}}
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqaweloffers.workStartDate")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract['start_date']}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqaweloffers.workEndDate")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract['end_date']}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("temp_job.region_id")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    @if($thisContract['contract_locations'][0]){{ $thisContract['contract_locations'][0]['region']['name'] }}@endif
                                                </div>
                                            </div>
                                            @if($thisContract['contract_locations'][0])
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqaweloffers.workplaces")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {!! nl2br($thisContract['contract_locations'][0]['desc_location']) !!}
                                                </div>
                                            </div>
                                            @endif
                                            @if ($thisContract['contract_file'])
                                                <div class="row static-info">
                                                    <div class="col-lg-3">{{trans("temp_job.attachment")}}</div>
                                                    <div class="col-lg-2">
                                                        <a href="{{ url('uploads/'. $thisContract['contract_file']) }}"
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
                                    <br>

                                    <div class="portlet grey-cascade box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>
                                                {{trans("offers.empInfo")}}
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th> #</th>
                                                        <th>{{trans("offers.empName")}}</th>
                                                        <th>{{trans("offers.jobTitle")}}</th>
                                                        <th>{{trans("offers.gender")}}</th>
                                                        <th>{{trans("offers.nationality")}}</th>
                                                        <th>{{trans("offers.jobArea")}}</th>
                                                        <th>{{trans("offers.qualifications")}}</th>
                                                        <th>{{trans("offers.startDate")}}</th>
                                                        <th>{{trans("offers.endDate")}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php($i = 1)
                                                    @foreach($thisContract['contract_employee'] as $contract)
                                                        <tr>
                                                            <td> {{$i}}</td>
                                                            <td>{{$contract['hr_pool']['name']}}</td>
                                                            <td>{{$contract['hr_pool']['job']['job_name']}}</td>
                                                            <td>{{Tamkeen\Ajeer\Utilities\Constants::gender($contract['hr_pool']['gender'])}}</td>
                                                            <td>{{$contract['hr_pool']['nationality']['name']}}</td>
                                                            <td>{{$contract['hr_pool']['region']['name']}}</td>
                                                            <td class="text-center">
                                                                @if($contract['qualification_upload'])
                                                                <a href="{{ url('uploads/'. $contract['qualification_upload']) }}" download>
                                                                    <i class="fa fa-file"></i>
                                                                </a>
                                                                @endif
                                                            </td>
                                                            <td>{{$contract['hr_pool']['work_start_date']}}</td>
                                                            <td>{{$contract['hr_pool']['work_end_date']}}</td>
                                                        </tr>
                                                        @php($i++)
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
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
                                                    {!! nl2br($edit['contract_locations']) !!}
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

                                            @if($EditedtoMe)
                                            {{ Form::open(['url' => url('/edit_contract/'.$edit['id'].'/approve'),'id'=>'form', 'class'=>'form-horizontal vacancies_form','data-url' => '']) }}
                                            <button type="submit" class="btn green" data-loading-text="{{ trans('labels.loading') }}..." >{{trans('offersdirect.editApprove')}}</button>

                                            <a type="button" data-loading-text="{{ trans('labels.loading') }}..."  href="{{ url('edit_contract/'.$edit['id'].'/reject') }}" class="btn red contract_edit_reject" >{{ trans('offersdirect.editReject') }}</a>
                                            {{form::close()}}
                                            @endif
                                            <hr>
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
                                        <i class="fa fa-warning"></i>{{trans("offers.error")}}
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    {{trans("offers.errorDetails")}}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection