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
                                        <i class="fa fa-info-circle"></i>{{trans("offersdirect.requestDetails")}}
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
                                                    {{$thisContract->benf_name}}
                                                </div>
                                            </div>
                                            @if(isset($thisContract->benef->est_activity))
                                                <div class="row static-info">
                                                    <div class="col-md-3 name">
                                                        {{trans("offersdirect.providerType")}}
                                                    </div>
                                                    <div class="col-md-9 value">
                                                        {{$thisContract->benef->est_activity}}
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
                                                    {{ $thisContract->provider->name }}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.benfNo")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $thisContract->provider_id }}
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
                                                    {{$jobSeeker->job->job_name}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.nationality")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$jobSeeker->nationality->name}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.gender")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$jobSeeker->gender_name}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.religion")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$jobSeeker->religion_name}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.workStartDate")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract->start_date}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.workEndDate")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract->end_date}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.region")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$jobSeeker->region->name}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.jobtype")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$jobSeeker->job_type_name}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("offersdirect.salary")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract->contract_amount}}
                                                </div>
                                            </div>
                                            @if (is_array($thisContract->contract_locations))
                                                @foreach($thisContract->contract_locations as $location)
                                                    <div class="row static-info">
                                                        <div class="col-md-3 name">
                                                            {{trans("offersdirect.workplaces")}}
                                                        </div>
                                                        <div class="col-md-9 value">
                                                            {{$location->desc_location}}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                    {{Form::open(['url' => url('/offersdirect/accept/' . $thisContract->id), 'data-url'=>url('/offersdirect/' . $thisContract->id), 'id'=>'acceptform',"method"=>"PUT","role"=>"form"])}}
                                    <div class="row static-info">
                                        <div class="col-lg-3">{{trans("offersdirect.offerValideTo")}}</div>
                                        <div class="col-lg-9">{{$dateEnded}}</div>
                                    </div>
                                    <div class="row static-info">
                                        <div class="col-lg-3">{{trans("offersdirect.qualifications")}}</div>
                                        <div class="col-lg-9">
                                            <div class="form-group">
                                                {!! Form::file('qualifications',["class"=>"form-control"]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <br>
                                    <div class="row">
                                        <div class="form-body">
                                            @if (count($errors))
                                                <div class="alert alert-danger">
                                                    <button class="close" data-close="alert"></button>
                                                    @foreach($errors->all() as $error)
                                                        <span>{{$error}}</span><br/>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        @if(isset($canAccept) && isset($canAcceptStatus))
                                            <div class="col-lg-12 col-lg-6">
                                                <div class="input-group">
                                                    <div class="icheck-inline">
                                                        <label>
                                                            <input type="checkbox" class="icheck" name="agree" value="1"
                                                                   data-checkbox="icheckbox_flat-grey"> {{trans("offersdirect.acceptRules")}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6"></div>
                                            <div class="col-lg-6">
                                                <div class="form-actions">
                                                    <button type="submit" class="btn blue"
                                                            data-loading-text="{{ trans('labels.loading') }}..."
                                                    > {{trans("offersdirect.accept")}} </button>
                                                    <a class="btn yellow btn-outline sbold"
                                                       href="{{url("offersdirect/reject/" . $thisContract->id)}}"
                                                       data-target="#ajax"
                                                       data-toggle="modal"> {{trans("offersdirect.decline")}} </a>

                                                </div>

                                            </div>
                                        @else
                                            @if (!isset($canAccept))
                                                <div class="alert alert-warning">
                                                    {{trans("offersdirect.cannotaccept")}}
                                                </div>
                                            @endif
                                            @if (!isset($canAcceptStatus))
                                                @if ($thisContract->status=="pending_ownership")
                                                    <div class="alert alert-warning">
                                                        {{trans("offersdirect.pending_ownership_error")}}
                                                    </div>
                                                @endif
                                                @if ($thisContract->status=="rejected")
                                                    <div class="alert alert-warning">
                                                        {{trans("offersdirect.offer_rejected")}}
                                                    </div>
                                                @endif
                                                @if ($thisContract->status=="approved")
                                                    <div class="alert alert-warning">
                                                        {{trans("offersdirect.offer_approved")}}
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                    </div>

                                    {{Form::close()}}
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
                    <h4 class="modal-title">{{trans("offersdirect.modal.accept.title")}}</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <h2>{{trans("offersdirect.modal.accept.rules")}}</h2>
                            <p>{!! trans("offersdirect.modal.accept.rulesDetails")!!}
                            </p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    {{ Form::open(['url' => url('/offersdirect/accept/approve/' . $thisContract->id), 'data-url'=>url('/offersdirect'), 'id'=>'form',"method"=>"PUT","role"=>"form"]) }}
                    <div class="form-actions">
                        <button type="submit" class="btn blue"
                                data-loading-text="{{ trans('labels.loading') }}..."
                                class="btn green uppercase">{{trans("offersdirect.modal.accept.approve")}}</button>
                        <button type="button" class="btn default"
                                data-dismiss="modal">{{trans("offersdirect.modal.accept.cancel")}}</button>
                    </div>
                    {{Form::close()}}
                </div>

            </div>
        </div>
    </div>
@endsection