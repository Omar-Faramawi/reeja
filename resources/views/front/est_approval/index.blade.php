@extends('front.layout')
@section('title', trans('est_approval.est_approval'))
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <br><br>
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-green-haze">
                            <i class="icon-folder-open font-green-haze"></i>
                            <span class="caption-subject bold uppercase"> {{trans('hajj_est.hajj_est')}}</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <br>
                        @if(session()->has('msg'))
                            <div class="alert alert-{{session()->get('status')}}">
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                {{session()->get('msg')}}
                            </div>
                        @endif

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <table class="table table-hover table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>{{trans('hajj_est.hajj_est')}}</th>
                                            <th>{{trans('hajj_est.hajj_est_info')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {!! Form::hidden('token', csrf_token(), ['id' => 'csrf_token']) !!}
                                        @if(count($establishments) == 0)
                                            <tr>
                                                <td colspan="2" class="text-danger text-center">
                                                    {{trans('labels.not_found')}}
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($establishments as $key => $est)
                                                <tr>
                                                    <td>{{$est->name}}</td>
                                                    <td>
                                                        <a href="javascript:;" class="view_resp btn btn-info"
                                                           data-estId="{{$est->id}}"
                                                           data-url="{{route('hajj.gov.responsibles')}}">{{trans('labels.view')}}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                {!! Form::open(['route' => 'hajj.gov.approve', 'method' => 'post','id'=>'form', 'class' =>"form-horizontal", 'data-url' => route('hajj.gov.approval')]) !!}
                                <div class="col-md-8" id="est_responsibles">
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection