@extends('front.layout')
@section('title', trans('contracts.edit_contract'))
@section('content')
    <!-- BEGIN PAGE CONTENT BODY -->
    <div class="page-content">
        <div class="container">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">
                <div class="row">

                    <div class="col-md-12">
                        <!-- BEGIN VALIDATION STATES-->
                        <div class="portlet light portlet-fit portlet-form ">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class=" icon-layers font-dark"></i>
                                    <span class="caption-subject font-dark sbold uppercase">{{ trans('contracts.edit_contract') }}</span>
                                </div>
                            </div>
                            <div class="portlet-body">

                                <!-- BEGIN FORM-->
                                {!! Form::model($contract, ['route' => [ 'contracts.update',  $contract->id] , 'id' => 'form', 'method' => 'PATCH', 'data-url' => request()->fullUrl() ]) !!}

                                {!! Form::hidden('contract_id', $contract->id) !!}

                                <div class="form-body">

                                    <div class="caption">
                                        <h5>{{ trans('temp_job.application_info') }}</h5><br>
                                    </div>

                                    @if(!empty($contract->vacancy_id))
                                    <div class="form-group form-md-line-input">
                                        {!! Form::select('job_id', $jobs, @$contract->vacancy->job->id, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.job_id'), 'class' => 'form-control' ]) !!}
                                        <label for="form_control_1">{{ trans('temp_job.job_id') }}</label>
                                        <span class="help-block">{{ trans('temp_job.job_id') }}</span>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        {!! Form::select('nationality_id', $nationalities, @$contract->vacancy->nationality->id, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.nationality_id'), 'class' => 'form-control' ]) !!}
                                        <label for="form_control_1">{{ trans('temp_job.nationality_id') }}</label>
                                        <span class="help-block">{{ trans('temp_job.nationality_id') }}</span>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        {!! Form::select('gender', \Tamkeen\Ajeer\Utilities\Constants::gender(), @$contract->vacancy->gender, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.gender.name'), 'class' => 'form-control']) !!}
                                        <label for="form_control_1">{{ trans('temp_job.gender.name') }}</label>
                                        <span class="help-block">{{ trans('temp_job.gender.name') }}</span>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        {!! Form::select('religion_id', \Tamkeen\Ajeer\Utilities\Constants::religions()  ,@$contract->vacancy->religion, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.religion_id'), 'class' => 'form-control']) !!}
                                        <label for="form_control_1">{{ trans('temp_job.religion_id') }}</label>
                                        <span class="help-block">{{ trans('temp_job.religion_id') }}</span>
                                    </div>

                                    @endif

                                    <div class="form-group form-md-line-input">
                                        {!! Form::text('start_date', null, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.work_start_date'), 'class' => 'form-control date-picker' ]) !!}
                                        <label for="form_control_1">{{ trans('temp_job.work_start_date') }}<span
                                                    class="required">*</span></label>
                                        <span class="help-block">{{ trans('temp_job.work_start_date') }}</span>
                                    </div>


                                    <div class="form-group form-md-line-input">
                                        {!! Form::text('end_date', null, [ 'placeholder' => trans('labels.enter') . " " . trans('temp_job.work_end_date'), 'class' => 'form-control date-picker' ]) !!}
                                        <label for="form_control_1">{{ trans('temp_job.work_end_date') }}<span
                                                    class="required">*</span></label>
                                        <span class="help-block">{{ trans('temp_job.work_end_date') }}</span>
                                    </div>


                                    <br><br>

                                    <div class="form-group form-md-radios form-md-line-input">
                                        <label class="col-md-3 control-label"
                                               for="form_control_1">{{ trans('temp_job.job_type.name') }}</label>
                                        <div class="col-md-9">
                                            <div class="md-radio-inline">
                                                <div class="md-radio">
                                                    <input type="radio" id="radio6" name="job_type"
                                                           {{ @$contract->vacancy->job_type == 0 ? "checked" : "" }} value="0"
                                                           class="md-radiobtn">
                                                    <label for="radio6">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> {{ trans('temp_job.job_type.salary') }}
                                                    </label>
                                                </div>

                                                <div class="md-radio">
                                                    <input type="radio" id="radio7" name="job_type"
                                                           {{ @$contract->vacancy->job_type == 1 ? "checked" : "" }} value="1"
                                                           class="md-radiobtn">
                                                    <label for="radio7">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> {{ trans('temp_job.job_type.no_salary') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <label class="control-label col-md-1">{{ trans('temp_job.region_id') }}</label>
                                        <div class="col-md-11">
                                            {!! Form::select('region_id[]', $regions , @$contract->contractLocations->lists('region_id')->toArray() , ['class' => 'bs-select form-control', 'multiple' => true ,  'placeholder' => trans("temp_job.region_id") ]) !!}
                                        </div>
                                    </div>
                                    <br><br>

                                    <div class="form-group form-md-line-input">
                                        <label class="control-label col-md-1">{{ trans('temp_job.contract_locations') }}</label>
                                        <div class="col-md-11">
                                            {!! Form::text('contract_locations', $contract->contract_locations , ['class' => 'form-control',  'placeholder' => trans("temp_job.region_id") ]) !!}
                                        </div>
                                    </div>
                                    <br><br>

                                     <div class="form-group form-md-line-input">
                                        <label class="control-label col-md-1">{{ trans('temp_job.attachment') }}</label>
                                        <div class="col-md-11">
                                            @include('components.fileupload', ['name' => 'contract_file'])
                                        </div>
                                    </div>
                                    <br><br>



                                    <div class="caption page-container">
                                        <i class="icon-layers font-blue-sharp title"></i>
                                        <span class="caption-subject font-blue-sharp bold uppercase">{{ trans('contracts.employee_signed') }}</span>

                                        <div class="table-container">
                                            <table class="table table-striped table-bordered table-hover table-checkable"
                                                   id="datatable_ajax" data-url="{{ route('contract-employee.list_contract_employees', ['id' => $contract->id]) }}"
                                                   data-token="{{ csrf_token() }}" data-type="POST">
                                                <thead>
                                                <tr role="row" class="heading">
                                                    <th id="check" class="no-sort"></th>
                                                    <th id="id" class="no-sort"
                                                        width="2%">{{ trans('temp_job.record') }}</th>
                                                    <th id="name" class="no-sort"
                                                        width="100">{{ trans('temp_job.name') }}</th>
                                                    <th id="nationality.name"
                                                        class="no-sort">{{ trans('temp_job.nationality_id')  }}</th>
                                                    <th id="gender_name"
                                                        class="no-sort">{{ trans('temp_job.gender.name') }}</th>
                                                    <th id="job.job_name"
                                                        class="no-sort">{{ trans('temp_job.job_id') }}</th>
                                                    <th id="age" class="no-sort">{{ trans('temp_job.age') }}</th>
                                                    <th id="religion_name"
                                                        class="no-sort"> {{ trans('temp_job.religion_id') }}</th>
                                                    <th id="details" class="no-sort"
                                                        width="5">{{ trans('temp_job.details') }}</th>
                                                </tr>
                                                <tr role="row" class="filter">
                                                    <td></td>
                                                    <td>
                                                        <input type="text" class="form-control form-filter input-sm"
                                                               name="id">
                                                    </td>

                                                    <td>
                                                        {{ Form::text('name', null, ['class' => "form-control form-filter input-sm", "placeholder" => trans('temp_job.employee_name')]) }}
                                                    </td>

                                                    <td>
                                                        {{ Form::select('nationality', $nationalities, null, ['class' => 'form-control form-filter input-sm', 'placeholder' => trans('labels.default')]) }}
                                                    </td>

                                                    <td>
                                                        {{ Form::select('gender_name', \Tamkeen\Ajeer\Utilities\Constants::gender(), null, ['class' => 'form-control form-filter input-sm', 'placeholder' => trans('labels.default')]) }}
                                                    </td>

                                                    <td>
                                                        {{ Form::select('job', $jobs , null, ['class' => 'form-control form-filter input-sm', 'placeholder' => trans('labels.default')]) }}
                                                    </td>

                                                    <td>
                                                        {{ Form::text('age', null, ['class' => "form-control form-filter input-sm", "placeholder" => trans('temp_job.age')]) }}</td>


                                                    <td>
                                                        {{ Form::select('religion', \Tamkeen\Ajeer\Utilities\Constants::religions() , null, ['class' => 'form-control form-filter input-sm', 'placeholder' => trans('labels.default')]) }}
                                                    </td>


                                                    <td>
                                                        <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                                            <i class="fa fa-search"></i> {{ trans('labels.search') }}
                                                        </button>
                                                        <button class="btn btn-sm red btn-outline filter-cancel">
                                                            <i class="fa fa-times"></i> {{ trans('labels.reset') }}
                                                        </button>
                                                    </td>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <!-- END FORM-->
                                </div>
                            </div>
                            <!-- END VALIDATION STATES-->
                        </div>

                        <div class="text-align-left col-md-12">
                            <button type="submit" name="status" class="btn green">{{ trans('contracts.save') }}</button>
                            <button type="reset" class="btn default">{{ trans('contracts.reset') }}</button>
                        </div>
                        <br><br>

                    </div>

                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT BODY -->
    <!-- END CONTENT BODY -->

@endsection