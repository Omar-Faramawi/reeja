@extends('front.layout')
@section('title', trans('gov_profile.profile'))
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
        {!! Form::model($gov, ['route' => 'government.profile.update', 'method' => 'patch', 'id'=> 'form', "data-url"=> (session()->has('red_url'))?url(session()->pull('red_url')): route('government.profile.edit')]) !!}
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-haze">
                    <i class="icon-folder-open font-green-haze"></i>
                    <span class="caption-subject bold uppercase"> {{trans('gov_profile.profile')}}</span>
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
                                    {{trans('gov_profile.attributes.name')}}
                                </td>
                                <td>
                                    {{$gov->name}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-haze">
                    <i class="icon-folder-open font-green-haze"></i>
                    <span class="caption-subject bold uppercase"> {{trans('gov_profile.responsibles_data')}}</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div id="responsible_data_box">
                    @if(count($gov->responsibles) ==0)
                        <div class="data_box panel panel-default"
                             data-index="0">
                            <div class="panel-body">
                                <div class="col-md-6">
                                    <div class="form-group form-md-floating-label">
                                        {!! Form::number('resp_data[0][id_number]', null, ['class' => "form-control", 'id' => "id_number",
                                                  'data-seg1' => 'resp_data[', 'data-seg2' => '][id_number]', 'min' => 0, 'max' => 4294967295]) !!}
                                        <label for="id_number">{{trans('gov_profile.responsibles_attributes.id_number')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-floating-label">
                                        {!! Form::text('resp_data[0][responsible_name]', null, ['class' => "form-control", 'id' => "responsible_name",
                                                  'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_name]']) !!}
                                        <label for="responsible_name">{{trans('gov_profile.responsibles_attributes.responsible_name')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-floating-label">
                                        {!! Form::text('resp_data[0][job_name]', null, ['class' => "form-control", 'id' => "job_name",
                                                  'data-seg1' => 'resp_data[', 'data-seg2' => '][job_name]']) !!}
                                        <label for="job_name">{{trans('gov_profile.responsibles_attributes.job_name')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-floating-label">
                                        {!! Form::text('resp_data[0][responsible_phone]', null, ['class' => "form-control", 'id' => "responsible_phone",
                                                  'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_phone]']) !!}
                                        <label for="responsible_phone">{{trans('gov_profile.responsibles_attributes.responsible_phone')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-floating-label">
                                        {!! Form::email('resp_data[0][responsible_email]', null, ['class' => "form-control", 'id' => "responsible_email",
                                                  'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_email]']) !!}
                                        <label for="responsible_email">{{trans('gov_profile.responsibles_attributes.responsible_email')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach($gov->responsibles as $key => $resp)
                            <div class="data_box panel panel-default" data-index="0">
                                {!! Form::hidden('resp_data['.$key.'][id]', $resp['id'], ['class' => 'record_id']) !!}
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <div class="form-group form-md-floating-label">
                                            {!! Form::number('resp_data['.$key.'][id_number]', $resp['id_number'], ['class' => "form-control", 'id' => "id_number",
                                                      'data-seg1' => 'resp_data[', 'data-seg2' => '][id_number]', 'min' => 0, 'max' => 4294967295]) !!}
                                            <label for="id_number">{{trans('gov_profile.responsibles_attributes.id_number')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-floating-label">
                                            {!! Form::text('resp_data['.$key.'][responsible_name]', $resp['responsible_name'], ['class' => "form-control", 'id' => "responsible_name",
                                                      'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_name]']) !!}
                                            <label for="responsible_name">{{trans('gov_profile.responsibles_attributes.responsible_name')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-floating-label">
                                            {!! Form::text('resp_data['.$key.'][job_name]', $resp['job_name'], ['class' => "form-control", 'id' => "job_name",
                                                      'data-seg1' => 'resp_data[', 'data-seg2' => '][job_name]']) !!}
                                            <label for="job_name">{{trans('gov_profile.responsibles_attributes.job_name')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-floating-label">
                                            {!! Form::text('resp_data['.$key.'][responsible_phone]', $resp['responsible_phone'], ['class' => "form-control", 'id' => "responsible_phone",
                                                      'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_phone]']) !!}
                                            <label for="responsible_phone">{{trans('gov_profile.responsibles_attributes.responsible_phone')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-floating-label">
                                            {!! Form::email('resp_data['.$key.'][responsible_email]', $resp['responsible_email'], ['class' => "form-control", 'id' => "responsible_email",
                                                      'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_email]']) !!}
                                            <label for="responsible_email">{{trans('gov_profile.responsibles_attributes.responsible_email')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
                <div>
                    <a href="#" class="btn btn-info btn-sm"
                       id="addResp"><i class="fa fa-plus"></i> {{trans('gov_profile.add_responsible')}}</a>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="text-center">
                            {!! Form::submit(trans('labels.save'), ['class' => 'btn btn-primary', 'data-loading-text'=>trans('labels.loading')]) !!}
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