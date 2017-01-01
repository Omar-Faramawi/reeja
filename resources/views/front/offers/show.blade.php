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
                                        <i class="fa fa-info-circle"></i>{{trans("offers.offerDetails")}}
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
                                                    {{ ($thisContract['contract_locations'][0]['region']['name'])}}
                                                </div>
                                            </div>
                                            @if (is_array($thisContract['contract_locations']))
                                                <div class="row static-info">
                                                    <div class="col-md-3 name">
                                                        {{trans("tqaweloffers.workplaces")}}
                                                    </div>
                                                    <div class="col-md-9 value">
                                                        @foreach($thisContract['contract_locations'] as $location)
                                                            {{$location['desc_location']}}
                                                            <br/>
                                                        @endforeach

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
                                                            <td>
                                                                @if($contract['qualification_upload'])
                                                                    <a href="{{ url('uploads/'. $contract['qualification_upload']) }}"
                                                                       download>
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
                                        <div class="col-lg-3">{{trans("offers.offerValideTo")}}</div>
                                        <div class="col-lg-9">{{$dateEnded}}</div>
                                    </div>
                                    @if(isset($canAccept))
                                        <div class="row">
                                            <div class="col-lg-12 col-lg-6">
                                                <div class="input-group">
                                                    <div class="icheck-inline">
                                                        <label>
                                                            <input type="checkbox" class="icheck"
                                                                   data-checkbox="icheckbox_flat-grey"
                                                                   id="acceptOffer"> {{trans("offers.acceptRules")}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 text-center">
                                                <div class="form-actions">
                                                    @if($seasonalContract)
                                                        <a class="btn blue"
                                                           id="approveButton"> {{trans("offers.accept")}} </a>
                                                        <a href="{{url("offers/accept/approve/" . $thisContract['id'])}}"
                                                           data-target="#ajax"
                                                           data-toggle="modal"
                                                           style="display: none;"
                                                           id="forClickButton"></a>
                                                    @else

                                                        <a class="btn blue"
                                                           id="approveButton"> {{trans("offers.accept")}} </a>
                                                        <a
                                                                data-target="#stack1"
                                                                data-toggle="modal"
                                                                style="display: none;"
                                                                id="forClickButton"></a>
                                                    @endif
                                                    <a class="btn yellow btn-outline sbold"
                                                       href="{{url("offers/reject/" . $thisContract['id'])}}"
                                                       data-target="#ajax"
                                                       data-toggle="modal"> {{trans("offers.decline")}} </a>

                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="alert alert-warning">
                                                {{trans("offers.cannotaccept")}}
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
    <!--DOC: Aplly "modal-cached" class after "modal" class to enable ajax content caching-->
    <div class="modal fade bs-modal-lg in" id="ajax" role="basic" aria-hidden="true" tabindex="-1" data-width="800"
         data-replace="true"
         style="z-index: 10100">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="{{asset('assets/img/loading-spinner-grey.gif')}}" alt="" class="loading">
                    <span> &nbsp;&nbsp;{{trans("labels.loading")}}... </span>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <div id="stack1" class="modal fade" role="dialog" tabindex="-1" data-width="400" data-replace="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{trans("offers.modal.accept.title")}}</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <h2>{{trans("offers.modal.accept.rules")}}</h2>
                            <p>
                                {!! trans("offers.modal.accept.rulesDetails")!!}
                            </p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="form-actions">

                        @if($seasonalContract)
                            <button type="button" class="btn default"
                                    data-dismiss="modal">{{trans("offers.modal.accept.cancel")}}</button>
                            <a href="{{url("offers/accept/approve/" . $thisContract['id'])}}"
                               data-target="#ajax"
                               data-toggle="modal"
                               class="btn green uppercase">{{trans("offers.modal.accept.approve")}}</a>
                        @else
                            {{Form::open([
                            'method'=>'post',
                            'route'=>[
                            'approveTempWork',
                            'id'=>$thisContract['id']
                            ],
                            'id'=>'form',
                            'data-url'=>url('/offers'),
                            ])}}
                            <button class="btn green uppercase">{{trans("offers.modal.accept.approve")}}</button>
                            <button type="button" class="btn default"
                                    data-dismiss="modal">{{trans("offers.modal.accept.cancel")}}</button>
                            {{Form::close()}}
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
