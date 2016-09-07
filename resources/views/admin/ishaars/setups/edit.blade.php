<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('ishaar_setup.headings.list') }}</h4>
</div>
@if(isset($data))
    {{ Form::model($data, ['route' => ['admin.ishaar_setup.update', $data->hashids], 'method' => 'patch', 'id'=>'form']) }}
@else
    {{ Form::open(['route' => 'admin.ishaar_setup.store', "files"=>"true", 'id'=>'form']) }}
@endif
{{ Form::hidden("ishaar_type_id", 3) }}
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-body">
                <div class="form-group form-md-line-input form-md-floating-label">
                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="name">{{ trans('ishaar_setup.attributes.ishaar_name') }}
                        <span class="required">*</span></label>
                    {{ Form::text("name", null, ["id" => "name", "class" => "form-control",  "minlength" => "3", "maxlength" => "255", "required" => "" ]) }}
                    <span class="help-block">{{ trans('ishaar_setup.attributes.ishaar_name') }}</span>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label">
                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="min_ishaar_period">{{ trans('ishaar_setup.attributes.min_ishaar_period')." [".trans('labels.day')."]" }}
                        <span class="required">*</span></label>
                    {{ Form::selectRange("min_ishaar_period", 1,90, null, ["class" => "form-control bs-select","placeholder"=> trans("ishaar_setup.attributes.default")]) }}
                    <span class="help-block">{{ trans('ishaar_setup.attributes.min_ishaar_period') }}</span>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label">
                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="max_ishaar_period">{{ trans('ishaar_setup.attributes.max_ishaar_period')." [".trans('labels.day')."]" }}
                        <span class="required">*</span></label>
                    {{ Form::selectRange("max_ishaar_period",1 ,90 ,null, ["class" => "form-control bs-select","placeholder"=> trans("ishaar_setup.attributes.default")]) }}
                    <span class="help-block">{{ trans('ishaar_setup.attributes.max_ishaar_period') }}</span>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label">
                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="amount">{{ trans('ishaar_setup.attributes.amount'). " [".trans('vacancies.form_attributes.currency')."]" }}
                        <span class="required">*</span></label>
                    {{ Form::number("amount", null, ["class" => "form-control"]) }}
                    <span class="help-block">{{ trans('ishaar_setup.attributes.amount') }}</span>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label">
                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="payment_period">{{ trans('ishaar_setup.attributes.payment_period')." [".trans('labels.day')."]" }}
                        <span class="required">*</span></label>
                    {{ Form::selectRange("payment_period",1, 90 ,null, ["class" => "form-control bs-select","placeholder"=> trans("ishaar_setup.attributes.default")]) }}
                    <span class="help-block">{{ trans('ishaar_setup.attributes.payment_period') }}</span>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group form-md-line-input">
                            <label {{ isset($data) ? 'style=top:0;' : "" }} for="issued_season">{{ trans('ishaar_setup.attributes.issued_season') }}
                            </label>
                            {{ Form::select("issued_season", [0 => trans('ishaar_setup.attributes.limited_period'), 1 => trans('ishaar_setup.attributes.unlimited_period')], null, ["class" => "form-control auto-hide bs-select","placeholder"=> trans("ishaar_setup.attributes.default")]) }}
                            <span class="help-block">{{ trans('ishaar_setup.attributes.issued_season') }}</span>
                        </div>
                    </div>

                    <div class="col-md-4 extra" {{ empty($data->issued_season) ? '' : 'style=display:none;' }}>
                        <div class="form-group form-md-line-input">
                            <label {{ isset($data) ? 'style=top:0;' : "" }} for="period_start_date">{{ trans('ishaar_setup.attributes.period_start_date') }}
                            </label>
                            {{ Form::text("period_start_date", null, ["class" => "form-control date-picker", "data-value" => "0"]) }}
                            <span class="help-block">{{ trans('ishaar_setup.attributes.period_start_date') }}</span>
                        </div>
                    </div>

                    <div class="col-md-4 extra" {{ empty($data->issued_season) ? '' : 'style=display:none;' }}>
                        <div class="form-group form-md-line-input">
                            <label {{ isset($data) ? 'style=top:0;' : "" }} for="period_end_date">{{ trans('ishaar_setup.attributes.period_end_date') }}
                                <span class="required">*</span></label>
                            {{ Form::text("period_end_date", null, ["class" => "form-control date-picker", "data-value" => "0"]) }}
                            <span class="help-block">{{ trans('ishaar_setup.attributes.period_end_date') }}</span>
                        </div>
                    </div>
                </div>
                @if(empty($data) || (!empty($data) && $data->id != 3))
                    <div class="form-group form-md-line-input form-md-floating-label">
                        <label {{ isset($data) ? 'style=top:0;' : "" }} for="regions">{{ trans('ishaar_setup.attributes.regions') }}
                        </label>
                        {{ Form::select("regions[]", sortDropDownByKey($regions, 1, 2), isset($data->regions) ? $data->regions->lists('id')->toArray() : null, ["id" => "regions-select", "class" => "auto-hide form-control", "multiple"]) }}
                        <span class="help-block">{{ trans('ishaar_setup.attributes.regions') }}</span>
                    </div>
                    <div class="form-group form-md-line-input form-md-floating-label extra" {{ !empty($data->region_name) ? '' : 'style=display:none;' }}>
                        <label {{ isset($data) ? 'style=top:0;' : "" }} for="region_name">{{ trans('ishaar_setup.attributes.region_name') }}
                            <span class="required">*</span></label>
                        {{ Form::text("region_name", null, ["class" => "form-control region-name-input", "data-value" => "2", "data-id" => "regions-select"]) }}
                        {{ Form::button(trans('ishaar_setup.attributes.add'), ['data-route' => route('admin.regions.store'), 'class' => 'add-regions']) }}
                        <span class="help-block">{{ trans('ishaar_setup.attributes.region_name') }}</span>
                    </div>
                    <div class="form-group form-md-line-input form-md-floating-label extra" {{ !empty($data->max_labor_from_haj) ? '' : 'style=display:none;' }}>
                        <label {{ isset($data) ? 'style=top:0;' : "" }} for="max_labor_from_haj">{{ trans('ishaar_setup.attributes.max_labor_from_haj') }}
                            <span class="required">*</span></label>
                        {{ Form::number("max_labor_from_haj", null, ["class" => "form-control", "data-value" => "1", "data-id" => "regions-select"]) }}
                        <span class="help-block">{{ trans('ishaar_setup.attributes.max_labor_from_haj') }}</span>
                    </div>
                @endif

                <div class="form-group form-md-line-input">
                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="name">{{ trans('ishaar_setup.attributes.nitaq_active') }}
                        <div class="col-md-10">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    {{ Form::radio("nitaq_active", 0 , null, ["class" => "md-radiobtn", "id" => "nitaq_active_1" ]) }}
                                    <label for="nitaq_active_1">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ trans('ishaar_setup.attributes.yes') }} </label>
                                </div>
                                <div class="md-radio">
                                    {{ Form::radio("nitaq_active", 1 , null, ["class" => "md-radiobtn", "id" => "nitaq_active_2" ]) }}
                                    <label for="nitaq_active_2">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ trans('ishaar_setup.attributes.no') }} </label>
                                </div>
                            </div>
                        </div>
                </div>
                @if(!empty($data) && $data->id == 3)
                    <div class="form-group form-md-checkboxes extra" {{ !empty($data->nitaq_haj) ? '' : 'style=display:none;' }}>
                    <div class="md-checkbox-inline">
                        <div class="md-checkbox">
                            {{ Form::checkbox("nitaq_haj", 1, null, ["id" => "nitaq_haj", "class" => "md-check", "data-value" => "1",  "data-id" => "regions-select"]) }}
                            <label for="nitaq_haj">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>{{ trans('ishaar_setup.attributes.nitaq_haj') }}</label>
                        </div>
                    </div>
                </div>
                <div class="form-group form-md-checkboxes extra" {{ !empty($data->nitaq_gover) ? '' : 'style=display:none;' }}>
                    <div class="md-checkbox-inline">
                        <div class="md-checkbox">
                            {{ Form::checkbox("nitaq_gover", 1, null, ["id" => "nitaq_gover", "class" => "md-check", "data-value" => "1", "data-id" => "regions-select" ]) }}
                            <label for="nitaq_gover">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>{{ trans('ishaar_setup.attributes.nitaq_gover') }}</label>
                        </div>
                    </div>
                </div>
                @endif
                <div class="form-group form-md-checkboxes">
                    <label class="control-label">{{ trans('ishaar_setup.attributes.labor_status') }}</label>
                    <div class="md-checkbox-inline">
                        <div class="md-checkbox">
                            {{ Form::checkbox("labor_status_employed", 1, null, ["id" => "labor_status_employed", "class" => "md-check"]) }}
                            <label for="labor_status_employed">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>{{ trans('ishaar_setup.attributes.job_head') }}</label>
                        </div>
                    </div>
                    <div class="md-checkbox-inline">
                        <div class="md-checkbox">
                            {{ Form::checkbox("labor_status_companion", 1, null, ["id" => "labor_status_companion", "class" => "md-check"]) }}
                            <label for="labor_status_companion">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>{{ trans('ishaar_setup.attributes.morafaq') }}</label>
                        </div>
                    </div>
                    <div class="md-checkbox-inline">
                        <div class="md-checkbox">
                            {{ Form::checkbox("labor_status_visitor", 1, null, ["id" => "labor_status_visitor", "class" => "md-check"]) }}
                            <label for="labor_status_visitor">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>{{ trans('ishaar_setup.attributes.visitor') }}</label>
                        </div>
                    </div>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label">
                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="max_of_notice_renew_time">{{ trans('ishaar_setup.attributes.max_of_notice_renew_time') }}
                        <span class="required">*</span></label>
                    {{ Form::number("max_of_notice_renew_time", null, ["id" => "max_of_notice_renew_time", "class" => "form-control",  "min" => "1", "max" => PHP_INT_MAX, "required" => "" ]) }}
                    <span class="help-block">{{ trans('ishaar_setup.attributes.max_of_notice_renew_time') }}....</span>
                </div>
                <div class="form-group form-md-checkboxes">
                    <label class="col-md-5 control-label text-right"
                           for="form_control_1">{{trans('ishaar_setup.form_attributes.labor_gender')}}</label>
                    <div class="col-md-4">
                        <div class="md-checkbox-inline">
                            <div class="md-checkbox">
                                {!! Form::checkbox('labor_gender_male', 1, null, ['id' => 'checkbox4', 'class' => 'md-check']) !!}
                                <label for="checkbox4">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{trans('ishaar_setup.gender.1')}}
                                </label>
                            </div>
                            <div class="md-checkbox">
                                {!! Form::checkbox('labor_gender_female', 1, null, ['id' => 'checkbox5', 'class' => 'md-check']) !!}
                                <label for="checkbox5">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{trans('ishaar_setup.gender.0')}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-resonsive">
                    <label class="control-label">{{ trans('ishaar_setup.attributes.ishaar_setup_jobs') }}</label>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                        <tr class="odd gradeX">
                            <th>{{ trans('ishaar_setup.attributes.job') }}</th>
                            <th>{{ trans('ishaar_setup.attributes.nationalities') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($jobs as $job)
                            <tr>
                                <td><input name="job[]" type="hidden" value="{{ $job->id }}" /> {{ $job->job_name }}</td>
                                <td>
                                    <select multiple name="nationalities[{{ $job->id }}][]" class="form-control"
                                            placeholder="{{ trans('ishaar_setup.attributes.default') }}">
                                        @foreach($nationalities as $key => $nation)
                                            <option {{ (isset($data) && in_array($job->id, $selectedJob) && !empty($selected_nationalities[$job->id]) && in_array($key, $selected_nationalities[$job->id])) ? "selected" : ""  }} value="{{ $key }}">{{ $nation }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" data-loading-text="{{ trans('labels.loading') }}..."
            class="demo-loading-btn btn blue"><i class="fa fa-check"></i> {{ trans('labels.save') }} </button>
    <button type="button" data-dismiss="modal" class="btn default">{{ trans('labels.cancel') }}</button>
</div>
{{ Form::close() }}