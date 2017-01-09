@extends('front.layout')
@section('title', trans('est_profile.est_profile'))
@section('content')
<div class="row">
    <div class="col-md-12">
        @if(\Illuminate\Support\Facades\Session::has('msg'))
            <div class="alert alert-{{\Illuminate\Support\Facades\Session::get('status')}}">
                <button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true">&times;</button>
                {{\Illuminate\Support\Facades\Session::get('msg')}}
            </div>
        @endif
        {!! Form::model($est, ['route' => 'establishment.profile.update', 'method' => 'patch', 'id'=> 'form', "data-url"=> (session()->has('red_url'))?url(session()->pull('red_url')): route('establishment.profile.edit')]) !!}
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-haze">
                    <i class="icon-folder-open font-green-haze"></i>
                    <span class="caption-subject bold uppercase"> {{trans('est_profile.est_profile')}}</span>
                </div>
                <div class="pull-right">
                    <a href="{{ url('/migrate') }}" class="btn btn-danger">{{trans('est_profile.import_from_old_ajeer')}}</a>
                </div>
            </div>
            <div class="portlet-body form">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="table-scrollable table-scrollable-borderless form-body">
                    <table class="table table-hover table-light">
                        <tbody>
                            <tr>
                                <td width="20%">
                                    {{trans('est_profile.attributes.name')}}
                                </td>
                                <td>
                                    {{$est->name}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{trans('est_profile.attributes.FK_establishment_id')}}
                                </td>
                                <td>
                                    {{$est->labour_office_no}} - {{ $est->sequence_no }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{trans('est_profile.attributes.est_size')}}
                                </td>
                                <td>
                                    {{$est->est_size_name}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{trans('est_profile.attributes.est_nitaq')}}
                                </td>
                                <td>
                                    {{$est->est_nitaq}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{trans('est_profile.attributes.status')}}
                                </td>
                                <td>
                                    <span class="label label-{{\Tamkeen\Ajeer\Utilities\Constants::EST_STATUS_CLASSES[$est->status]}}">{{$est->status_name}}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            {!! Form::hidden('ignore_est_type', 1) !!}

            </div>
        </div>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-haze">
                    <i class="icon-folder-open font-green-haze"></i>
                    <span class="caption-subject bold uppercase"> {{trans('est_profile.responsibles_data')}}</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div id="responsible_data_box">
                    @if(count($est->responsibles) ==0)
                        <div class="data_box panel panel-default"
                             data-index="0">
                            <div class="panel-body">
                                <div class="col-md-6">
                                    <div class="form-group form-md-floating-label">
                                        {!! Form::number('resp_data[0][id_number]', null, ['class' => "form-control", 'id' => "id_number",
                                                  'data-seg1' => 'resp_data[', 'data-seg2' => '][id_number]', 'min' => 0, 'max' => 4294967295]) !!}
                                        <label for="id_number">{{trans('est_profile.responsibles_attributes.id_number')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-floating-label">
                                        {!! Form::text('resp_data[0][responsible_name]', null, ['class' => "form-control", 'id' => "responsible_name",
                                                  'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_name]']) !!}
                                        <label for="responsible_name">{{trans('est_profile.responsibles_attributes.responsible_name')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-floating-label">
                                        {!! Form::text('resp_data[0][job_name]', null, ['class' => "form-control", 'id' => "job_name",
                                                  'data-seg1' => 'resp_data[', 'data-seg2' => '][job_name]']) !!}
                                        <label for="job_name">{{trans('est_profile.responsibles_attributes.job_name')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-floating-label">
                                        {!! Form::text('resp_data[0][responsible_phone]', null, ['class' => "form-control", 'id' => "responsible_phone",
                                                  'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_phone]']) !!}
                                        <label for="responsible_phone">{{trans('est_profile.responsibles_attributes.responsible_phone')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-floating-label">
                                        {!! Form::email('resp_data[0][responsible_email]', null, ['class' => "form-control", 'id' => "responsible_email",
                                                  'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_email]']) !!}
                                        <label for="responsible_email">{{trans('est_profile.responsibles_attributes.responsible_email')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach($est->responsibles as $key => $resp)
                            <div class="data_box panel panel-default" data-index="0">
                                {!! Form::hidden('resp_data['.$key.'][id]', $resp['id'], ['class' => 'record_id']) !!}
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-floating-label">
                                            {!! Form::number('resp_data['.$key.'][id_number]', $resp['id_number'], ['class' => "form-control", 'id' => "id_number",
                                                      'data-seg1' => 'resp_data[', 'data-seg2' => '][id_number]', 'min' => 0, 'max' => 4294967295]) !!}
                                            <label for="id_number">{{trans('est_profile.responsibles_attributes.id_number')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-floating-label">
                                            {!! Form::text('resp_data['.$key.'][responsible_name]', $resp['responsible_name'], ['class' => "form-control", 'id' => "responsible_name",
                                                      'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_name]']) !!}
                                            <label for="responsible_name">{{trans('est_profile.responsibles_attributes.responsible_name')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-floating-label">
                                            {!! Form::text('resp_data['.$key.'][job_name]', $resp['job_name'], ['class' => "form-control", 'id' => "job_name",
                                                      'data-seg1' => 'resp_data[', 'data-seg2' => '][job_name]']) !!}
                                            <label for="job_name">{{trans('est_profile.responsibles_attributes.job_name')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-floating-label">
                                            {!! Form::text('resp_data['.$key.'][responsible_phone]', $resp['responsible_phone'], ['class' => "form-control", 'id' => "responsible_phone",
                                                      'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_phone]']) !!}
                                            <label for="responsible_phone">{{trans('est_profile.responsibles_attributes.responsible_phone')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-floating-label">
                                            {!! Form::email('resp_data['.$key.'][responsible_email]', $resp['responsible_email'], ['class' => "form-control", 'id' => "responsible_email",
                                                      'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_email]']) !!}
                                            <label for="responsible_email">{{trans('est_profile.responsibles_attributes.responsible_email')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
                <div>
                    <a href="#" class="btn btn-info btn-sm"
                       id="addResp"><i class="fa fa-plus"></i> {{trans('est_profile.add_responsible')}}</a>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="text-center">
                            {!! Form::submit(trans('labels.save'), ['class' => 'btn btn-primary', 'data-loading-text'=>trans('labels.loading')]) !!}
                            {!! Form::submit(trans('labels.save_complete_later'), ['class' => 'btn btn-primary', 'name' => 'later', 'data-loading-text'=>trans('labels.loading')]) !!}
                            <a href="{{url('/home')}}" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection