@extends('front.layout')
@section('content')

    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <div class="container">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>{{ trans('labels.system_name') }}
                    <small> {{trans('cv_publishment.cv_publishment')}}</small>
                </h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
    </div>
    <!-- END PAGE HEAD-->


    <div class="container">
        <br>
        @if(!is_null($data->age()) && $data->age() >= 18)
            <div class="row">
                @if(\Illuminate\Support\Facades\Session::has('msg'))
                    <div class="alert alert-{{\Illuminate\Support\Facades\Session::get('status')}}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{\Illuminate\Support\Facades\Session::get('msg')}}
                    </div>
                @endif

                <div class="row">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="portlet light portlet-fit portlet-form ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=" icon-layers font-red"></i>
                                <span class="caption-subject font-red sbold uppercase">{{trans('cv_publishment.cv_publishment')}}</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            {!! Form::model($data, ['route' => 'cv.update', 'method' => 'PATCH','id' => 'form', 'class' => 'form-horizontal', 'data-url' => route('cv.edit')]) !!}
                            {!! Form::hidden('dataId', $data->hashids) !!}
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-sm-3"> {{trans('cv_publishment.attributes.name')}} </label>
                                    <div class="col-sm-9">
                                        <span>{{$data->name}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3"> {{trans('cv_publishment.attributes.age')}} </label>
                                    <div class="col-sm-9">
                                        <span dir="rtl">{{$data->age().' '.trans('cv_publishment.years')}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3"> {{trans('cv_publishment.attributes.gender')}} </label>
                                    <div class="col-sm-9">
                                        <span>{{$data->gender_name or ''}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3"> {{trans('cv_publishment.attributes.nationality_id')}} </label>
                                    <div class="col-sm-9">
                                        <span>{{$data->nationality->name or ''}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3"> {{trans('cv_publishment.attributes.religion')}} </label>
                                    <div class="col-sm-9">
                                        <span>{{$data->religion_name}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3"> {{trans('cv_publishment.attributes.chk')}} </label>
                                    <div class="col-sm-9">
                            <span class="label label-{{$data->chk ? 'info' : 'danger'}}">
                                {{$data->chk ? trans('cv_publishment.published') : trans('cv_publishment.not_published')}}
                            </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3"> {{trans('cv_publishment.attributes.email')}} </label>
                                    <div class="col-sm-9">
                                        <span>{{$data->email}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3"> {{trans('cv_publishment.attributes.phone')}} </label>
                                    <div class="col-sm-9">
                                        <span>{{$data->phone}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3"
                                           for="job_id">{{trans('cv_publishment.attributes.job_id')}}</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('job_id', [null => trans('labels.choose')] + $jobs->toArray(), null, ['class'=> 'form-control selectpicker', 'id' => 'job_id']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3"
                                           for="qualification_id">{{trans('cv_publishment.attributes.qualification_id')}}</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('qualification_id', [null => trans('labels.choose')] + $qualifications->toArray(), null, ['class'=> 'form-control selectpicker', 'id' => 'qualification_id']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3"
                                           for="region_id">{{trans('cv_publishment.attributes.region_id')}}</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('region_id', [null => trans('labels.choose')] + $regions->toArray(), null, ['class'=> 'form-control selectpicker', 'id' => 'region_id']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3"
                                           for="experience_id">{{trans('cv_publishment.attributes.experience_id')}}</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('experience_id', [null => trans('labels.choose')] + $experiences->toArray(), null, ['class'=> 'form-control selectpicker', 'id' => 'experience_id']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3"> {{trans('cv_publishment.attributes.job_type')}} </label>
                                    <div class="col-md-9">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                {!! Form::radio('job_type', 1, null, ['class' => 'md-radiobtn', 'id' => 'paid']) !!}
                                                <label for="paid">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{trans('cv_publishment.paid')}} </label>
                                            </div>
                                            <div class="md-radio">
                                                {!! Form::radio('job_type', 0, null, ['class' => 'md-radiobtn', 'id' => 'not_paid']) !!}
                                                <label for="not_paid">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{trans('cv_publishment.not_paid')}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3"
                                           for="work_start_date">{{trans('cv_publishment.attributes.work_start_date')}}</label>
                                    <div class='col-sm-9'>
                                        <div class='input-group'>
                                            {!! Form::text('work_start_date', $data->work_start_date, ['id' => "work_start_date",
                                                   'class' => "form-control form-control-inline input-medium date-picker work_start_date"]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3"
                                           for="work_end_date">{{trans('cv_publishment.attributes.work_end_date')}}</label>
                                    <div class='col-sm-9'>
                                        <div class='input-group'>
                                            {!! Form::text('work_end_date', $data->work_end_date, ['id' => "work_end_date",
                                                   'class' => "form-control form-control-inline input-medium date-picker work_end_date"]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div style="text-align:left;padding-bottom: 20px;">
                                    {!! Form::submit(trans('cv_publishment.save'), ['class' => "btn btn-primary", "data-loading-text" => trans('labels.loading').'...']) !!}
                                    {!! Form::submit(trans('cv_publishment.save_complete_later'), ['class' => "btn btn-warning", 'name' => 'later', "data-loading-text" => trans('labels.loading').'...']) !!}
                                    <a href="{{url('/')}}">
                                        {!! Form::button(trans('labels.cancel'), ['class' => "btn btn-danger"]) !!}
                                    </a>
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning">
                <button  type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{trans('cv_publishment.age_alert')}}
            </div>
        @endif
    </div>
@endsection