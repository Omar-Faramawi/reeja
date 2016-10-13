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
                                                    {{ ($thisContract['benef']['sequence_no']) ? $thisContract['benef']['sequence_no'] : $thisContract['benef']['nid']}}
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
                                                                <a href="{{url("offers/downloadfile/" . $contract['id'])}}"><i
                                                                            class="fa fa-file"></i> </a></td>
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
                                    <br>
                                    @if(isset($canAccept))
                                    <div class="row">
                                        <div class="col-lg-12 col-lg-6">
                                            <div class="input-group">
                                                <div class="icheck-inline">
                                                    <label>
                                                        <input type="checkbox" class="icheck"
                                                               data-checkbox="icheckbox_flat-grey"> {{trans("offers.acceptRules")}}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">

                                        
                                            <div class="col-lg-6"></div>
                                            <div class="col-lg-6">
                                                <div class="form-actions">
                                                    <a class="btn blue"
                                                       data-target="#stack1"
                                                       data-toggle="modal"> {{trans("offers.accept")}} </a>
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
                                {{trans("offers.modal.accept.rulesDetails")}}
                            </p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <button type="button" class="btn default"
                                data-dismiss="modal">{{trans("offers.modal.accept.cancel")}}</button>
                        <a href="{{url("offers/accept/approve/" . $thisContract['id'])}}"
                           data-target="#ajax"
                           data-toggle="modal"
                           class="btn green uppercase">{{trans("offers.modal.accept.approve")}}</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection