@extends('front.layout')
@section('title', trans('vacancies.headings.Add'))
@section('content')
        <!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('labels.system_name') }}
                <small>{{ trans('vacancies.headings.Add') }}</small>
            </h1>
        </div>
        <!-- END PAGE TITLE -->
    </div>
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE CONTENT BODY -->
<div class="page-content">
    <div class="container">
        <!-- BEGIN PAGE BREADCRUMBS -->
        <ul class="page-breadcrumb breadcrumb">
        </ul>
        <!-- END PAGE BREADCRUMBS -->
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light portlet-fit portlet-datatable ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">{{ trans('vacancies.headings.Add') }}</span>
                            </div>

                        </div>
                        <div class="portlet-body">
                            <section>
                                {{ Form::open(['route' => 'vacancies.index','id'=>'form', 'class'=>'form-horizontal vacancies_form','data-url' => url('/vacancies')]) }}
                                <div class="form-body row">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group form-md-line-input">
                                                <label class="control-label text-right col-md-3">{{trans('vacancies.form_attributes.region_id')}}
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <select class="form-control select2me bs-select" name="region_id"
                                                            id="region_id">
                                                        @if(!count($regions))
                                                            <option>{{ trans('labels.no_data') }}</option>
                                                        @else
                                                            <option value="">{{ trans('labels.default') }}</option>
                                                            @foreach($regions as $region)
                                                                @if (old('region_id') == $region->id || ($region->id == 1 && !empty($hajj)) )
                                                                    <option value="{{$region->id}}"
                                                                            selected>{{$region->name}}</option>
                                                                @else
                                                                    <option value="{{$region->id}}">{{$region->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- start of Ta2eed Area --}}
                                    <div id="tayeed_area" class="col-md-12">

                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover"
                                                   cellspacing="0" width="100%">
                                                <thead>
                                                <tr role="row" class="heading">
                                                    <th>{{ trans('vacancies.list_attributes.taeed_side') }}</th>
                                                    <th>{{ trans('vacancies.list_attributes.job') }}</th>
                                                    <th>{{ trans('vacancies.list_attributes.approved_number') }}</th>
                                                    <th>{{ trans('vacancies.list_attributes.taeed_start_date') }}</th>
                                                    <th>{{ trans('vacancies.list_attributes.taeed_end_date') }}</th>
                                                    <th>{{ trans('vacancies.list_attributes.details') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(!count($taeed_vacancies))
                                                    <tr>
                                                        <td colspan="6"
                                                            class="text-center">{{ trans('labels.no_data') }}</td>
                                                    </tr>
                                                @else
                                                    @foreach($taeed_vacancies as $vacancy)
                                                        <tr role="row">
                                                            <td>{{ trans('vacancies.list_attributes.taeed_side_default') }}</td>
                                                            <td> {{$vacancy->job->job_name or ''}} </td>
                                                            <td> {{$vacancy->no_of_vacancies}}</td>
                                                            <td> {{$vacancy->work_start_date}}</td>
                                                            <td> {{$vacancy->work_end_date}}</td>

                                                            <td>
                                                                <div class="btn-group btn-group-lg btn-group-solid margin-bottom-10">
                                                                    <a class="btn btn-small btn-info"
                                                                       href="{{ URL::to('vacancies/edit/'.$vacancy->id)}}">{{ trans('vacancies.buttons.details') }}
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                                </tbody>
                                                <tfoot>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- end of Ta2eed Area --}}

                                    {{-- start of vacancies area --}}
                                    <div class="col-md-12">
                                        <div id="vacancies_area">
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                    <label class="control-label text-right col-md-3">{{trans('vacancies.form_attributes.job')}}
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-8">
                                                        <select class="form-control select2me bs-select" name="job_id"
                                                                id="job" data-live-search="true">
                                                            @if(!count($jobs))
                                                                <option>{{ trans('labels.no_data') }}</option>
                                                            @else
                                                                <option value="">{{ trans('labels.default') }}</option>
                                                                @foreach($jobs as $job)
                                                                    @if (old('job_id') == $job->id)
                                                                        <option value="{{$job->id}}"
                                                                                selected>{{$job->job_name}}</option>
                                                                    @else
                                                                        <option value="{{$job->id}}">{{$job->job_name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group md-radio-inline">
                                                    <label class="control-label text-right col-md-3">{{trans('vacancies.form_attributes.gender')}}
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-8">
                                                        <div class="md-checkbox-inline">
                                                            <div class="md-checkbox">
                                                                {!! Form::checkbox('gender_male', 1, null, ['id' => 'checkbox4', 'class' => 'md-check']) !!}
                                                                <label for="checkbox4">
                                                                    <span></span>
                                                                    <span class="check"></span>
                                                                    <span class="box"></span> {{trans('ishaar_setup.gender.1')}}
                                                                </label>
                                                            </div>
                                                            <div class="md-checkbox">
                                                                {!! Form::checkbox('gender_female', 1, null, ['id' => 'checkbox5', 'class' => 'md-check']) !!}
                                                                <label for="checkbox5">
                                                                    <span></span>
                                                                    <span class="check"></span>
                                                                    <span class="box"></span> {{trans('ishaar_setup.gender.0')}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group form-md-line-input">
                                                    <label class="control-label text-right col-md-3">{{trans('vacancies.form_attributes.nationality')}}
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-8">
                                                        <select name='nationality_id'
                                                                class="form-control select2me bs-select"
                                                                id="nationality" data-live-search="true">
                                                            @if(!count($nationalities))
                                                                <option>{{ trans('labels.no_data') }}</option>
                                                            @else
                                                                <option value="">{{ trans('labels.default') }}</option>
                                                                @foreach($nationalities as $nationality)
                                                                    @if (old('nationality_id') == $nationality->id)
                                                                        <option value="{{$nationality->id}}"
                                                                                selected>{{$nationality->name}}</option>
                                                                    @else
                                                                        <option value="{{$nationality->id}}">{{$nationality->name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group md-radio-inline">
                                                    <label class="control-label text-right col-md-3">{{trans('vacancies.form_attributes.religion')}}
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-8">
                                                        <div class="md-radio">
                                                            <input type="radio" id="muslim" required
                                                                   name="religion" value="1" checked
                                                                   class="md-radiobtn">
                                                            <label for="muslim">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> {{trans('vacancies.religion.1')}}
                                                            </label>
                                                        </div>
                                                        <div class="md-radio">
                                                            <input type="radio" id="non_muslim" required
                                                                   name="religion" value="2"
                                                                   class="md-radiobtn">
                                                            <label for="non_muslim">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> {{trans('vacancies.religion.2')}}
                                                            </label>
                                                        </div>
                                                        <div class="md-radio">
                                                            <input type="radio" id="na" required
                                                                   name="religion" value="3"
                                                                   class="md-radiobtn">
                                                            <label for="na">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> {{trans('vacancies.religion.3')}}
                                                            </label>
                                                        </div>
                                                        <div id="form_2_religion_error"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group md-radio-inline">
                                                    <label class="control-label text-right col-md-3"
                                                           for="job_type">{{trans('vacancies.form_attributes.job_type')}}
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-8">
                                                        <div class="md-radio">
                                                            <input type="radio" id="salary" required
                                                                   name="job_type" value="1" checked
                                                                   class="md-radiobtn">
                                                            <label for="salary">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> {{trans('vacancies.job_type.1')}}
                                                            </label>
                                                        </div>
                                                        <div class="md-radio">
                                                            <input type="radio" id="no_salary" required
                                                                   name="job_type" value="0"
                                                                   class="md-radiobtn">
                                                            <label for="no_salary">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> {{trans('vacancies.job_type.0')}}
                                                            </label>
                                                        </div>
                                                        <div id="form_2_job_type_error"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                    <label class="col-md-3 control-label text-right">{{trans('vacancies.form_attributes.salary')}}
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                        <input type="text" name="salary" class="form-control"/>
                                                        <div class="form-control-focus"></div>
                                                        <span class="help-block">{{ trans('vacancies.form_attributes.currency') }}
                                                            ...</span>
                                                    </div>
                                                </div>
                                                <div class="form-group form-md-checkboxes">
                                                    <label class="col-md-5 control-label text-right"
                                                           for="form_control_1">{{trans('vacancies.hide_option')}}</label>
                                                    <div class="col-md-1">
                                                        <div class="md-checkbox-list">
                                                            <div class="md-checkbox">
                                                                <input type="checkbox" name="hide_salary"
                                                                       id="hide_salary" class="md-check" value="1">
                                                                <label for="hide_salary">
                                                                    <span></span>
                                                                    <span class="check"></span>
                                                                    <span class="box"></span> </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group form-md-line-input">
                                                    <label class="control-label text-right col-md-4">{{trans('vacancies.form_attributes.work_start_date')}}</label>
                                                    <div class="col-md-6">
                                                        <input type="text" name="work_start_date" required
                                                               value="" class="form-control date-picker">
                                                        <div class="form-control-focus"></div>
                                                        <span class="help-block">{{ trans('vacancies.form_attributes.work_start_date') }}
                                                            ...</span>
                                                    </div>
                                                </div>

                                                <div class="form-group form-md-line-input">
                                                    <label class="control-label text-right col-md-4">
                                                        {{trans('vacancies.form_attributes.work_end_date')}}</label>
                                                    <div class="col-md-6">
                                                        <input type="text" name="work_end_date" required
                                                               value="" class="form-control date-picker">
                                                        <div class="form-control-focus"></div>
                                                        <span class="help-block">{{ trans('vacancies.form_attributes.work_end_date') }}
                                                            ...</span>
                                                    </div>
                                                </div>

                                                <div class="form-group form-md-line-input">
                                                    <label for="no_of_vacancies"
                                                           class="control-label text-right col-md-4">{{trans('vacancies.form_attributes.required_number')}}
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                        <input class="form-control" type="text" name="no_of_vacancies"
                                                               required/>
                                                        <div class="form-control-focus"></div>
                                                        <span class="help-block">{{ trans('vacancies.form_attributes.required_number') }}
                                                            ...</span>
                                                    </div>
                                                </div>

                                                <div class="form-group form-md-line-input">
                                                    <label for="work_areas"
                                                           class="control-label text-right col-md-4">{{trans('vacancies.form_attributes.work_areas')}}</label>
                                                    <div class="col-sm-6">
                                                    <textarea class="form-control" rows="5" id="work_areas"
                                                              name="work_areas"></textarea>
                                                        <div class="form-control-focus"></div>
                                                        <span class="help-block">{{ trans('vacancies.form_attributes.work_areas') }}
                                                            ...</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions row">
                                                <div class="row">
                                                    <div class="col-md-offset-1 col-md-9">

                                                        <button type="submit" class="btn green"
                                                                data-loading-text="{{ trans('labels.loading') }}..."
                                                                id="save_and_publish">{{trans('vacancies.buttons.save_and_publish')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{form::close()}}
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection