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
                                                            <td>
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
                                    <div class="row">
                                        <div class="col-lg-3">{{trans("contracts.contractStatus")}}</div>
                                        <div class="col-lg-9">{{trans("labels.contractStatus." . $thisContract['status'])}}</div>
                                    </div>

                                    @if($thisContract['status'] == 'rejected' || $thisContract['status'] == 'cancelled')
                                        <div class="row">
                                            <div class="col-lg-3">
                                                @if($thisContract['status'] == 'rejected')
                                                    {{ trans('contracts.cancel_reason') }}
                                                @else
                                                    {{ trans('contracts.rejection_reason') }}
                                                @endif
                                            </div>
                                            <div class="col-lg-9">
                                                @if($thisContract['other_reasons'])
                                                    {{ $thisContract['other_reasons'] }}
                                                @elseif($thisContract['reason_id'])
                                                    {{ $thisContract['reason']['reason'] }}
                                                @endif
                                            </div>
                                        </div>
                                        @if($thisContract['rejection_reason'])
                                        <div class="row">
                                            <div class="col-lg-3">
                                                @if($thisContract['status'] == 'rejected')
                                                    {{ trans('contracts.more_details_about_rejection') }}
                                                @else
                                                    {{ trans('contracts.more_details_about_cancellation') }}
                                                @endif
                                            </div>
                                            <div class="col-lg-9">
                                                {!! nl2br($thisContract['rejection_reason']) !!}
                                            </div>
                                        </div>
                                        @endif
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