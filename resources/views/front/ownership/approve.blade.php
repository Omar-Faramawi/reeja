@extends('front.layout')
@section('title', trans('user.home'))
@section("content")
    <div class="page-content">
        <div class="container">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-info-circle"></i>{{trans("ownership.requestApprove")}}
                                </div>
                            </div>
                            <div class="portlet-body">
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
                                {{ Form::open(['url' => url('offersdirect/ownership/approve/' . $id . "/" . $hashedid), 'data-url'=>url('/'), 'id'=>'form',"method"=>"PUT","role"=>"form"]) }}

                                <button type="submit" data-loading-text="{{ trans('labels.loading') }}..."
                                        class="btn green uppercase"> {{trans("offers.accept")}} </button>
                                <a class="btn yellow btn-outline sbold"
                                   href="{{url("offersdirect/ownership/reject/" .  $id . "/" . $hashedid)}}"
                                   data-target="#ajax"
                                   data-toggle="modal"> {{trans("offers.decline")}} </a>
                                {{Form::close()}}

                            </div>
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
@endsection