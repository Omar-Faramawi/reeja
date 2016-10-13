@extends('front.layout')
@section('title', trans('est_profile.est_profile'))
@section('content')
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-green-haze">
                            <i class="icon-folder-open font-green-haze"></i>
                            <span class="caption-subject bold uppercase"> {{trans('est_profile.est_profile')}}</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <br>
                        @if(\Illuminate\Support\Facades\Session::has('msg'))
                            <div class="alert alert-{{\Illuminate\Support\Facades\Session::get('status')}}">
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                {{\Illuminate\Support\Facades\Session::get('msg')}}
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

                        {!! Form::model($est, ['route' => 'establishment.profile.update', 'method' => 'patch', 'id'=> 'form','class' =>"form-horizontal", "data-url"=> (session()->has('red_url'))?url(session()->pull('red_url')): route('establishment.profile.edit')]) !!}
                        <div class="form-body">
                            {{-- Est Name--}}
                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label"
                                       for="name">{{trans('est_profile.attributes.name')}}</label>
                                <div class="col-md-10">
                                    <div class="col-md-10">
                                        <div class="form-control form-control-static"> {{$est->name}}</div>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                            </div>

                            {{-- Est Number --}}
                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label"
                                       for="FK_establishment_id">{{trans('est_profile.attributes.FK_establishment_id')}}</label>
                                <div class="col-md-10">
                                    <div class="col-md-10">
                                        <div class="form-control form-control-static"> {{$est->FK_establishment_id}}</div>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                            </div>

                            {{-- Est Size --}}
                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label"
                                       for="est_size">{{trans('est_profile.attributes.est_size')}}</label>
                                <div class="col-md-10">
                                    <div class="col-md-10">
                                        <div class="form-control form-control-static"> {{$est->est_size}}</div>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                            </div>

                            {{-- Est Nitaq --}}
                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label"
                                       for="est_nitaq">{{trans('est_profile.attributes.est_nitaq')}}</label>
                                <div class="col-md-10">
                                    <div class="col-md-10">
                                        <div class="form-control form-control-static"> {{$est->est_nitaq}}</div>
                                        <div class="form-control-focus"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label"
                                       for="est_nitaq">{{trans('est_profile.attributes.status')}}</label>
                                <div class="col-md-10">
                                    <div class="col-md-10">
                                        <span class="label label-{{\Tamkeen\Ajeer\Utilities\Constants::EST_STATUS_CLASSES[$est->status]}}">{{$est->status_name}}</span>
                                    </div>
                                </div>
                            </div>
                            @if(is_null($est->hajj) && is_null($est->catering))
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label"
                                           for="id_number">{{trans('est_profile.est_type')}}</label>
                                    <div class="col-md-10">
                                        <div class="md-checkbox-inline">
                                            <div class="md-checkbox">
                                                {!! Form::checkbox('est_type[hajj]', 1, $est->hajj, ['class' => "md-check", 'id' => 'hajj_est']) !!}
                                                <label for="hajj_est">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{trans('est_profile.hajj_est')}} </label>
                                            </div>
                                            <div class="md-checkbox">
                                                {!! Form::checkbox('est_type[catering]', 1, $est->catering, ['class' => "md-check", 'id' => 'catering_est']) !!}
                                                <label for="catering_est">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{trans('est_profile.catering_est')}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {!! Form::hidden('ignore_est_type', 1) !!}
                                {!! Form::hidden('est_type[hajj]', $est->hajj == 1 ? 1 : null) !!}
                                {!! Form::hidden('est_type[catering]', $est->catering == 1 ? 1 : null) !!}
                            @endif
                            <hr>

                            <h4 class="text-info">{{trans('est_profile.responsibles_data')}}</h4>
                            <br>
                            <div id="responsible_data_box">

                                @if(count($est->responsibles) ==0)
                                    <div class="data_box"
                                         style="border: 1px solid #eee;padding: 4px;margin: 10px auto"
                                         data-index="0">
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-2 control-label"
                                                   for="id_number">{{trans('est_profile.responsibles_attributes.id_number')}}</label>
                                            <div class="col-md-10">
                                                {!! Form::number('resp_data[0][id_number]', null, ['class' => "form-control", 'id' => "id_number",
                                                      'data-seg1' => 'resp_data[', 'data-seg2' => '][id_number]', 'placeholder' => trans('est_profile.responsibles_attributes.id_number'), 'min' => 0, 'max' => 4294967295]) !!}
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-2 control-label"
                                                   for="id_number">{{trans('est_profile.responsibles_attributes.responsible_name')}}</label>
                                            <div class="col-md-10">
                                                {!! Form::text('resp_data[0][responsible_name]', null, ['class' => "form-control", 'id' => "responsible_name",
                                                      'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_name]', 'placeholder' => trans('est_profile.responsibles_attributes.responsible_name')]) !!}
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-2 control-label"
                                                   for="id_number">{{trans('est_profile.responsibles_attributes.job_name')}}</label>
                                            <div class="col-md-10">
                                                {!! Form::text('resp_data[0][job_name]', null, ['class' => "form-control", 'id' => "job_name",
                                                      'data-seg1' => 'resp_data[', 'data-seg2' => '][job_name]', 'placeholder' => trans('est_profile.responsibles_attributes.job_name')]) !!}
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-2 control-label"
                                                   for="id_number">{{trans('est_profile.responsibles_attributes.responsible_phone')}}</label>
                                            <div class="col-md-10">
                                                {!! Form::text('resp_data[0][responsible_phone]', null, ['class' => "form-control", 'id' => "responsible_phone",
                                                      'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_phone]', 'placeholder' => trans('est_profile.responsibles_attributes.responsible_phone')]) !!}
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label class="col-md-2 control-label"
                                                   for="id_number">{{trans('est_profile.responsibles_attributes.responsible_email')}}</label>
                                            <div class="col-md-10">
                                                {!! Form::email('resp_data[0][responsible_email]', null, ['class' => "form-control", 'id' => "responsible_email",
                                                      'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_email]', 'placeholder' => trans('est_profile.responsibles_attributes.responsible_email')]) !!}
                                                <div class="form-control-focus"></div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    @foreach($est->responsibles as $key => $resp)
                                        <div class="data_box"
                                             style="border: 1px solid #eee;padding: 4px;margin: 10px auto"
                                             data-index="{{$key}}">
                                            {!! Form::hidden('resp_data['.$key.'][id]', $resp['id'], ['class' => 'record_id']) !!}
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-2 control-label"
                                                       for="id_number">{{trans('est_profile.responsibles_attributes.id_number')}}</label>
                                                <div class="col-md-10">
                                                    {!! Form::number('resp_data['.$key.'][id_number]', $resp['id_number'], ['class' => "form-control", 'id' => "id_number",
                                                           'data-seg1' => 'resp_data[', 'data-seg2' => '][id_number]','placeholder' => trans('est_profile.responsibles_attributes.id_number')]) !!}
                                                    <div class="form-control-focus"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-2 control-label"
                                                       for="id_number">{{trans('est_profile.responsibles_attributes.responsible_name')}}</label>
                                                <div class="col-md-10">
                                                    {!! Form::text('resp_data['.$key.'][responsible_name]', $resp['responsible_name'], ['class' => "form-control", 'id' => "responsible_name",
                                                           'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_name]','placeholder' => trans('est_profile.responsibles_attributes.responsible_name')]) !!}
                                                    <div class="form-control-focus"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-2 control-label"
                                                       for="id_number">{{trans('est_profile.responsibles_attributes.job_name')}}</label>
                                                <div class="col-md-10">
                                                    {!! Form::text('resp_data['.$key.'][job_name]', $resp['job_name'], ['class' => "form-control", 'id' => "job_name",
                                                           'data-seg1' => 'resp_data[', 'data-seg2' => '][job_name]','placeholder' => trans('est_profile.responsibles_attributes.job_name')]) !!}
                                                    <div class="form-control-focus"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-2 control-label"
                                                       for="id_number">{{trans('est_profile.responsibles_attributes.responsible_phone')}}</label>
                                                <div class="col-md-10">
                                                    {!! Form::text('resp_data['.$key.'][responsible_phone]', $resp['responsible_phone'], ['class' => "form-control", 'id' => "responsible_phone",
                                                           'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_phone]','placeholder' => trans('est_profile.responsibles_attributes.responsible_phone')]) !!}
                                                    <div class="form-control-focus"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-2 control-label"
                                                       for="id_number">{{trans('est_profile.responsibles_attributes.responsible_email')}}</label>
                                                <div class="col-md-10">
                                                    {!! Form::email('resp_data['.$key.'][responsible_email]', $resp['responsible_email'], ['class' => "form-control", 'id' => "responsible_email",
                                                           'data-seg1' => 'resp_data[', 'data-seg2' => '][responsible_email]','placeholder' => trans('est_profile.responsibles_attributes.responsible_email')]) !!}
                                                    <div class="form-control-focus"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="javascript;" class="btn btn-success btn-sm"
                                       id="addResp">{{trans('est_profile.add_responsible')}}</a>
                                </div>
                                <div class="col-md-offset-2 col-md-10">
                                    {!! Form::submit(trans('labels.save'), ['class' => 'btn btn-info', 'data-loading-text'=>trans('labels.loading')]) !!}
                                    {!! Form::submit(trans('labels.save_complete_later'), ['class' => 'btn btn-warning', 'name' => 'later', 'data-loading-text'=>trans('labels.loading')]) !!}
                                    <a href="{{url('/')}}">
                                        {!! Form::button(trans('labels.cancel'), ['class' => 'btn btn-danger']) !!}
                                    </a>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection