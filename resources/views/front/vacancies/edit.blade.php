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
                                <span class="caption-subject font-dark sbold uppercase">{{ trans('vacancies.headings.update') }}</span>
                            </div>

                        </div>
                        <div class="portlet-body">
                            <section>
                                {{ Form::model($vacancy ,['route' => ['vacancies.update', $vacancy->id],'id'=>'form','method' => 'PATCH', 'class'=>'form-horizontal vacancies_form_updated','data-url'=>'/vacancies']) }}
                                <div class="form-body row">
                                    <input type="hidden" name="status" value=""/>
                                    <div class="col-md-6">
                                        <div class="form-group form-md-line-input">
                                            <label class="control-label text-right col-md-3">
                                                {{trans('vacancies.form_attributes.region_id')}}
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
                                                            @if($vacancy->region_id == 1)
                                                                <option value="{{$region->id}}"
                                                                        selected>{{$region->name}}</option>
                                                                @break;
                                                            @endif
                                                            @if($region->id !=1){
                                                            @if (old('region_id') == $region->id || $vacancy->region_id == $region->id)
                                                                <option value="{{$region->id}}"
                                                                        selected>{{$region->name}}</option>
                                                            @else
                                                                <option value="{{$region->id}}">{{$region->name}}</option>
                                                            @endif
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>


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
                                                                id="job">
                                                            @if(!count($jobs))
                                                                <option>{{ trans('labels.no_data') }}</option>
                                                            @else
                                                                <option value="">{{ trans('labels.default') }}</option>
                                                                @foreach($jobs as $job)
                                                                    @if($vacancy->region_id == 1)
                                                                        @if($vacancy->job_id == $job->id)
                                                                            <option value="{{$job->id}}"
                                                                                    selected>{{$job->job_name}}</option>
                                                                        @endif
                                                                    @else
                                                                        @if (old('job_id') == $job->id || $vacancy->job_id == $job->id)
                                                                            <option value="{{$job->id}}"
                                                                                    selected>{{$job->job_name}}</option>
                                                                        @else
                                                                            <option value="{{$job->id}}">{{$job->job_name}}</option>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group form-md-line-input">
                                                    <label class="control-label text-right col-md-3">{{trans('vacancies.form_attributes.gender')}}
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-8">
                                                        <div class="form-group md-radio-inline"
                                                             data-error-container="#form_2_gender_error">
                                                            <div class="md-radio">
                                                                <input type="radio" name="gender" value="1"
                                                                       class="md-radiobtn"
                                                                       @if ($vacancy->gender == 1) checked @endif />

                                                                <label for="male">
                                                                    <span></span>
                                                                    <span class="check"></span>
                                                                    <span class="box"></span> {{ trans('vacancies.gender.1') }}
                                                                </label>
                                                            </div>
                                                            <div class="md-radio">
                                                                <input type="radio" name="gender" value="0"
                                                                       class="md-radiobtn"
                                                                       @if ($vacancy->gender == 0) checked @endif/>

                                                                <label for="female">
                                                                    <span></span>
                                                                    <span class="check"></span>
                                                                    <span class="box"></span> {{ trans('vacancies.gender.0') }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div id="form_2_gender_error"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group form-md-line-input">
                                                    <label class="control-label text-right col-md-3">{{trans('vacancies.form_attributes.nationality')}}
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-8">
                                                        <select name='nationality_id'
                                                                class="form-control select2me bs-select"
                                                                id="nationality">
                                                            @if(!count($nationalities))
                                                                <option>{{ trans('labels.no_data') }}</option>
                                                            @else
                                                                <option value="">{{ trans('labels.default') }}</option>
                                                                @foreach($nationalities as $nationality)
                                                                    @if (old('nationality_id') == $nationality->id || $vacancy->nationality_id ==$nationality->id)
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

                                                <div class="form-group form-md-line-input md-radio-inline">
                                                    <label class="control-label text-right col-md-3">{{trans('vacancies.form_attributes.religion')}}
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-8">
                                                        @if($vacancy->region_id !=1)
                                                            <div class="md-radio">
                                                                <input type="radio" name='religion' value="1"
                                                                       class="md-radiobtn"
                                                                       @if ($vacancy->religion == 1) checked @endif>
                                                              <label for="muslim">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> {{trans('vacancies.religion.1')}}
                                                                </label>
                                                            </div>
                                                            <div class="md-radio">
                                                                <input type="radio" name='religion' value="2"
                                                                       class="md-radiobtn"
                                                                       @if ($vacancy->religion == 2) checked @endif>
                                                                <label for="non_muslim">
                                                                    <span></span>
                                                                    <span class="check"></span>
                                                                    <span class="box"></span> {{trans('vacancies.religion.2')}}
                                                                </label>
                                                            </div>
                                                            <div class="md-radio">
                                                                <input type="radio" name='religion' value="3"
                                                                       class="md-radiobtn"
                                                                       @if ($vacancy->religion == 3) checked @endif>

                                                                <label for="na">
                                                                    <span></span>
                                                                    <span class="check"></span>
                                                                    <span class="box"></span> {{trans('vacancies.religion.3')}}
                                                                </label>
                                                            </div>
                                                        @else
                                                            <div class="md-radio">
                                                                <input type="radio" name='religion' value="1"
                                                                       class="md-radiobtn"
                                                                       @if ($vacancy->religion == 1) checked @endif>

                                                                <label for="muslim">
                                                                    <span></span>
                                                                    <span class="check"></span>
                                                                    <span class="box"></span> {{trans('vacancies.religion.1')}}
                                                                </label>
                                                            </div>
                                                        @endif

                                                        <div id="form_2_religion_error"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group form-md-line-input md-radio-inline">
                                                    <label class="control-label text-right col-md-3"
                                                           for="job_type">{{trans('vacancies.form_attributes.job_type')}}
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-8">
                                                        <div class="md-radio">
                                                            <input type="radio" name='job_type' value="1"
                                                                   class="md-radiobtn"
                                                                   @if($vacancy->job_type ==1) checked @endif>
                                                            <label for="salary">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> {{trans('vacancies.job_type.1')}}
                                                            </label>
                                                        </div>
                                                        <div class="md-radio">
                                                            <input type="radio" name='job_type' value="0"
                                                                   class="md-radiobtn"
                                                                   @if($vacancy->job_type ==0) checked @endif>

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
                                                        <input type="text" name="salary" data-required="1"
                                                               class="form-control"
                                                               value="{{$vacancy->salary or old('salary')}}"/>
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
                                                                       id="hide_salary" class="md-check" value="1" @if (old('hide_salary')=='1' || $vacancy->hide_salary =='1') checked @endif />
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
                                                        <input type="text" name="work_start_date"
                                                               value="{{$vacancy->work_start_date or old('work_start_date')}}"
                                                               class="form-control date-picker"
                                                               @if($vacancy->region_id ==1) readonly @endif>
                                                        <div class="form-control-focus"></div>
                                                        <span class="help-block">{{ trans('vacancies.form_attributes.work_start_date') }}
                                                            ...</span>
                                                    </div>
                                                </div>

                                                <div class="form-group form-md-line-input">
                                                    <label class="control-label text-right col-md-4">
                                                        {{trans('vacancies.form_attributes.work_end_date')}}</label>
                                                    <div class="col-md-6">
                                                        <input type="text" name="work_end_date"
                                                               value="{{$vacancy->work_end_date or old('work_end_date')}}"
                                                               class="form-control date-picker"
                                                               @if($vacancy->region_id ==1) readonly @endif>
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
                                                        @if($vacancy->region_id ==1)
                                                            {{ $vacancy->no_of_vacancies or ''}}
                                                        @else
                                                            <input class="form-control" type="text" name="no_of_vacancies" data-required="1"
                                                                   value="{{ $vacancy->no_of_vacancies or old('no_of_vacancies') }}"/>
                                                        @endif
                                                        <div class="form-control-focus"></div>
                                                        <span class="help-block">{{ trans('vacancies.form_attributes.required_number') }}
                                                            ...</span>
                                                    </div>
                                                </div>

                                                @if($vacancy->region_id !=1)

                                                    <div class="form-group form-md-line-input">
                                                        <label for="work_areas"
                                                               class="control-label text-right col-md-4">{{trans('vacancies.form_attributes.work_areas')}}</label>
                                                        <div class="col-sm-6">
                                                    <textarea class="form-control" rows="5" id="work_areas"
                                                              name="work_areas">@if(count($vacancy->locations))@foreach($vacancy->locations as $locations) {{$locations->location}} @endforeach @endif {{old('work_areas')}}</textarea>
                                                            <div class="form-control-focus"></div>
                                                        <span class="help-block">{{ trans('vacancies.form_attributes.work_areas') }}
                                                            ...</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-actions row">
                                                <div class="row">
                                                    <div class="col-md-offset-1 col-md-9">

                                                        <button type="submit" class="btn btn-primary" name="status"
                                                                value="0" data-loading-text="{{ trans('labels.loading') }}..."
                                                                id="update_draft">{{trans('vacancies.buttons.update_draft')}}</button>

                                                        <button type="submit" class="btn green" name="status" value="1"
                                                                data-loading-text="{{ trans('labels.loading') }}..."
                                                                id="update_and_publish">{{trans('vacancies.buttons.update_and_publish')}}</button>

                                                        <button type="reset" class="btn default"
                                                                name="cancel">{{trans('vacancies.buttons.cancel')}}</button>
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