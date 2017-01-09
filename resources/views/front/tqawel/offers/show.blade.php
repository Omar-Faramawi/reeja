@extends('front.layout')
@section('title', trans('tqaweloffers.offerDetails'))
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
                                        <i class="fa fa-info-circle"></i>{{trans("tqaweloffers.offerDetails")}}
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="portlet grey-cascade box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>{{trans("tqaweloffers.providerInfo")}}
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqaweloffers.providerName")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract['providername']}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqaweloffers.providerNo")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{$thisContract['provider']['id']}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="portlet grey-cascade box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-info-circle"></i>{{trans("tqaweloffers.benfInfo")}}
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqaweloffers.benfName")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ $thisContract['benf_name'] }}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqaweloffers.benfNo")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ ($thisContract['benef']['id'])}}
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
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqaweloffers.contractNature")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ ($thisContract['contract_nature']['name'])}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqaweloffers.contractType")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    @if($thisContract['contract_ref_no'])
                                                        {{ trans("tqaweloffers.subContract")}}
                                                    @else
                                                        {{ trans("tqaweloffers.directContract")}}
                                                    @endif
                                                </div>
                                            </div>
                                            @if($thisContract['contract_ref_no'])
                                                <div class="row static-info">
                                                    <div class="col-md-3 name">
                                                        {{trans("tqaweloffers.contractRefNo")}}
                                                    </div>
                                                    <div class="col-md-9 value">
                                                        {{ ($thisContract['contract_ref_no'])}}
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqaweloffers.contratactDesc")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ ($thisContract['contract_desc'])}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-3 name">
                                                    {{trans("tqaweloffers.contratactName")}}
                                                </div>
                                                <div class="col-md-9 value">
                                                    {{ ($thisContract['contract_name'])}}
                                                </div>
                                            </div>
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
                                                    <div class="col-lg-3">{{trans("tqaweloffers.attachment")}}</div>
                                                    <div class="col-lg-2">
                                                        <a href="{{ url('uploads/'. $thisContract['contract_file']) }}" download>
                                                            <i class="fa fa-file"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if(isset($canAccept))
                                        {{Form::open(['url' => url('/taqawel/offers/accept/' . $thisContract['id']), 'data-url'=>url('/taqawel/offers/' . $thisContract['id']), 'id'=>'acceptform',"method"=>"PUT","role"=>"form"])}}
                                        <div class="row static-info">
                                            <div class="col-lg-3">{{trans("tqaweloffers.offerValideTo")}}</div>
                                            <div class="col-lg-9">{{$dateEnded}}</div>
                                        </div>
                                        <div class="row static-info">
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
                                        </div>
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
                                                <br>
                                                <div class="col-lg-12 text-center">
                                                    <button type="submit" class="btn blue"
                                                            data-loading-text="{{ trans('labels.loading') }}..."
                                                    > {{trans("offersdirect.accept")}} </button>
                                                    <button type="button" class="btn yellow btn-outline sbold" data-toggle="modal" data-target="#rejectModal">{{trans("offersdirect.decline")}}</button>
                                                </div>
                                            </div>
                                        </div>
                                        {{Form::close()}}
                                    @else
                                        <div class="alert alert-warning">
                                            {{trans("offersdirect.cannotaccept")}}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="portlet box red">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-warning"></i>{{trans("tqaweloffers.error")}}
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    {{trans("tqaweloffers.errorDetails")}}
                                </div>
                            </div>
                        @endif
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
                        <h4 class="modal-title">{{trans("tqaweloffers.modal.accept.title")}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h2>{{trans("tqaweloffers.modal.accept.rules")}}</h2>
                                <p>
                                    {!! trans("tqaweloffers.modal.accept.rulesDetails")!!}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{ Form::open(['url' => url('/taqawel/offers/accept/approve/' . $thisContract['id']), 'data-url'=>url('/taqawel/offers/'), 'id'=>'form',"method"=>"PUT","role"=>"form"]) }}
                        <div class="form-actions">
                            <button type="submit" class="btn blue"
                                    data-loading-text="{{ trans('labels.loading') }}..."
                                    class="btn green uppercase">{{trans("tqaweloffers.modal.accept.approve")}}</button>
                            <button type="button" class="btn default"
                                    data-dismiss="modal">{{trans("tqaweloffers.modal.accept.cancel")}}</button>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('front.tqawel.offers.reject')
@endsection