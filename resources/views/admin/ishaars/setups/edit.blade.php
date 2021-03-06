@extends ('admin.layout')
@section('title', trans('ishaar_setup.headings.list'))
@section('content')
    <div class="breadcrumbs">
        <h1>{{ trans('ishaar_setup.ishaars_bundles_management') }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('/admin')}}">{{trans('user.home')}}</a>
            </li>
            <li class="active">{{ trans('ishaar_setup.headings.list') }}</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase"> {{ trans('ishaar_setup.headings.list') }}</span>
                    </div>
                </div>
                <div class="portlet-body form-body" id="main">
                    @if(isset($data))
                        {{ Form::model($data, ['route' => ['admin.ishaar_setup.update', $data->hashids], 'method' => 'patch', 'id'=>'live_form', 'data-back-url'=>url('/admin/ishaar_setup')]) }}
                    @else
                        {{ Form::open(['route' => 'admin.ishaar_setup.store', 'id'=>'live_form', 'data-back-url'=>url('/admin/ishaar_setup')]) }}
                    @endif
                    {{ Form::hidden("ishaar_type_id", 3) }}

                    <div class="row form-group form-md-line-input no-padding-top">
                        <label {{ isset($data) ? 'style=top:0;' : "" }} for="name" class="col-md-3 no-padding-left">
                            {{ trans('ishaar_setup.attributes.ishaar_name') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-8">
                            {{ Form::text("name", null, ["id" => "name", "class" => "form-control",  "minlength" => "3", "maxlength" => "255", "required" => "" ]) }}
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="row form-group form-md-line-input no-padding-top margin-bottom-10">
                        <label for="min_ishaar_period" class="col-md-3 no-padding-left">{{ trans('ishaar_setup.attributes.min_ishaar_period') }}
                            <span class="required">*</span></label>
                        <div class="col-md-4">
                            {{ Form::number("min_ishaar_period", null, ["class" => "form-control"]) }}
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::select('min_ishaar_period_type',  trans('contract_setup.period_type_array'), null, ['class'=> 'form-control selectpicker', 'id' => 'min_ishaar_period_type']) !!}
                        </div>
                    </div>
                    <div class="row form-group form-md-line-input no-padding-top margin-bottom-10">
                        <label for="max_ishaar_period" class="col-md-3 text-right no-padding-left">{{ trans('ishaar_setup.attributes.max_ishaar_period') }}
                            <span class="required">*</span></label>
                        <div class="col-md-4">
                            {{ Form::number("max_ishaar_period", null, ["class" => "form-control"]) }}
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::select('max_ishaar_period_type',  trans('contract_setup.period_type_array'), null, ['class'=> 'form-control selectpicker', 'id' => 'max_ishaar_period_type']) !!}
                        </div>
                    </div>
                    <div class="row form-group form-md-line-input no-padding-top">
                        <label {{ isset($data) ? 'style=top:0;' : "" }} for="amount" class="col-md-3 text-right no-padding-left">{{ trans('ishaar_setup.attributes.amount'). " [".trans('vacancies.form_attributes.currency')."]" }}
                            <span class="required">*</span></label>
                        <div class="col-md-8">
                            {{ Form::number("amount", null, ["class" => "form-control"]) }}
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="row form-group form-md-line-input no-padding-top">
                        <label {{ isset($data) ? 'style=top:0;' : "" }} for="payment_period" class="col-md-3 text-right no-padding-left">{{ trans('ishaar_setup.attributes.payment_period')." [".trans('labels.day')."]" }}
                            <span class="required">*</span></label>
                        <div class="col-md-8">
                            {{ Form::selectRange("payment_period",1, 90 ,null, ["class" => "form-control bs-select","placeholder"=> trans("ishaar_setup.attributes.default")]) }}
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="row form-group form-md-line-input no-padding-top">
                        <label {{ isset($data) ? 'style=top:0;' : "" }} for="issued_season" class="col-md-3 text-right no-padding-left">{{ trans('ishaar_setup.attributes.issued_season') }}
                                </label>
                        <div class="col-md-8">
                            {{ Form::select("issued_season", [0 => trans('ishaar_setup.attributes.limited_period'), 1 => trans('ishaar_setup.attributes.unlimited_period')], null, ["class" => "form-control auto-hide bs-select","placeholder"=> trans("ishaar_setup.attributes.default")]) }}
                            <span class="help-block"></span>

                            <div class="col-md-6 extra" {{ (isset($data) && empty($data->issued_season)) ? '' : 'style=display:none;' }}>
                                <div class="form-group form-md-line-input">
                                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="period_start_date">{{ trans('ishaar_setup.attributes.period_start_date') }}
                                    <span class="required">*</span></label>
                                    {{ Form::text("period_start_date",isset($readableStartDate) ? $readableStartDate : '', ["id"=>"period_start_date", "class" => "form-control", "data-value" => "0"]) }}
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-6 extra" {{ (isset($data) && empty($data->issued_season)) ? '' : 'style=display:none;' }}>
                                <div class="form-group form-md-line-input">
                                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="period_end_date">{{ trans('ishaar_setup.attributes.period_end_date') }}
                                        <span class="required">*</span></label>
                                    {{ Form::text("period_end_date", isset($readableEndDate) ? $readableEndDate : '', ["id"=>"period_end_date", "class" => "form-control", "data-value" => "0"]) }}
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group form-md-line-input no-padding-top">
                        <label {{ isset($data) ? 'style=top:0;' : "" }} for="regions" class="col-md-3 text-right no-padding-left">{{ trans('ishaar_setup.attributes.regions') }}
                            </label>
                        <div class="col-md-8">
                            {{ Form::select("regions[]", sortDropDownByKey($regions, 1, 2), isset($data->regions) ? $data->regions->lists('id')->toArray() : null, ["id" => "regions-select", "class" => "auto-hide form-control bs-select", "multiple"]) }}
                            <span class="help-block"></span>
                            <div class="form-group form-md-line-input form-md-floating-label extra" {{ !empty($data->region_name) ? '' : 'style=display:none;' }}>
                                <label {{ isset($data) ? 'style=top:0;' : "" }} for="region_name" class="col-md-6">{{ trans('ishaar_setup.attributes.region_name') }}
                                    <span class="required">*</span></label>
                                {{ Form::text("region_name", null, ["class" => "form-control col-md-6 region-name-input", "data-value" => "2", "data-id" => "regions-select"]) }}
                                {{ Form::button(trans('ishaar_setup.attributes.add'), ['data-route' => route('admin.regions.store'), 'class' => 'add-regions']) }}
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group form-md-line-input form-md-floating-label extra" {{ !empty($data->max_labor_from_haj) ? '' : 'style=display:none;' }}>
                                <label {{ isset($data) ? 'style=top:0;' : "" }} for="max_labor_from_haj" class="col-md-7">{{ trans('ishaar_setup.attributes.max_labor_from_haj') }}
                                    <span class="required">*</span></label>
                                    <div class="col-md-5">
                                        {{ Form::number("max_labor_from_haj", null, ["class" => "form-control", "data-value" => "1", "data-id" => "regions-select"]) }}
                                        <span class="help-block"></span>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group form-md-line-input no-padding-top">
                        <label class="col-md-3 text-right no-padding-left">{{ trans('ishaar_setup.attributes.nitaq_active') }}</label>
                        <div class="col-md-8">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    {{ Form::radio("nitaq_active", 0 , null, ["class" => "md-radiobtn", "id" => "nitaq_active_1" ]) }}
                                    <label for="nitaq_active_1">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ trans('ishaar_setup.attributes.yes') }}
                                    </label>
                                </div>
                                <div class="md-radio">
                                    {{ Form::radio("nitaq_active", 1 , null, ["class" => "md-radiobtn", "id" => "nitaq_active_2" ]) }}
                                    <label for="nitaq_active_2">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ trans('ishaar_setup.attributes.no') }} </label>
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
                                            <span class="box"></span>{{ trans('ishaar_setup.attributes.nitaq_haj') }}
                                        </label>
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
                                            <span class="box"></span>{{ trans('ishaar_setup.attributes.nitaq_gover') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif
                        </div>
                    </div>
                    <div class="row form-group form-md-line-input no-padding-top">
                        <label class="col-md-3 text-right no-padding-left">{{ trans('ishaar_setup.attributes.labor_status') }}</label>
                        <div class="col-md-8">
                            <div class="md-checkbox-inline">
                                <div class="md-checkbox">
                                    {{ Form::checkbox("labor_status_employed", 1, null, ["id" => "labor_status_employed", "class" => "md-check"]) }}
                                    <label for="labor_status_employed">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>{{ trans('ishaar_setup.attributes.job_head') }}
                                    </label>
                                </div>
                                <div class="md-checkbox">
                                    {{ Form::checkbox("labor_status_companion", 1, null, ["id" => "labor_status_companion", "class" => "md-check"]) }}
                                    <label for="labor_status_companion">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>{{ trans('ishaar_setup.attributes.morafaq') }}
                                    </label>
                                </div>
                                <div class="md-checkbox">
                                    {{ Form::checkbox("labor_status_visitor", 1, null, ["id" => "labor_status_visitor", "class" => "md-check"]) }}
                                    <label for="labor_status_visitor">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>{{ trans('ishaar_setup.attributes.visitor') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group form-md-line-input no-padding-top">
                        <label {{ isset($data) ? 'style=top:0;' : "" }} for="max_of_notice_renew_time" class="col-md-3 text-right no-padding-left">
                            {{ trans('ishaar_setup.attributes.max_of_notice_renew_time') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-8">
                            {{ Form::number("max_of_notice_renew_time", null, ["id" => "max_of_notice_renew_time", "class" => "form-control",  "min" => "1", "max" => PHP_INT_MAX, "required" => "" ]) }}
                            <span class="help-block"></span>
                        </div>
                    </div>




                    <div class="row form-group form-md-line-input no-padding-top">
                        <label class="col-md-3 text-right no-padding-left"
                               for="form_control_1">{{trans('ishaar_setup.form_attributes.labor_gender')}}</label>
                        <div class="col-md-8">
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
                        <label class="col-md-12 m-heading-1 border-green m-bordered">{{ trans('ishaar_setup.attributes.ishaar_setup_jobs') }}</label>
                        <table class="table table-striped table-bordered table-hover order-column" id="job_nationalities_table">
                            <thead>
                            <tr class="odd gradeX">
                                <th>{{ trans('ishaar_setup.attributes.job') }}</th>
                                <th>{{ trans('ishaar_setup.attributes.nationalities') }}</th>
                                <th>{{ trans('ishaar_setup.actions.details') }}</th>
                            </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>
                                {{ Form::select('', $jobs,'', ['id' => 'jobs', 'class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall'), "data-live-search" => "true"]) }}

                                    </td>
                                    <td>
                                {{ Form::select('', $nationalities,'', ['id' => 'nationalities', 'class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall'), "data-live-search" => "true", "data-actions-box" => "true", "data-selected-text-format" => "count", 'multiple']) }}

                                    </td>
                                    <td>
                                        <button type="button" data-loading-text="{{ trans('labels.loading') }}..." data-error="{{ trans('ishaar_setup.enter_job_and_nationality') }}"
                                                class="btn sbold green" id="add_job_nationalities"><i class="fa fa-check"></i> {{ trans('ishaar_setup.attributes.add') }}</button>

                                    </td>
                                </tr>
                                <tr id="second_row_in_selected" style="display: none;"><td colspan="3">{{trans('ishaar_setup.selected_jobs')}}</td></tr>
                                @if(isset($selected_nationalities))
                                @foreach($selected_nationalities as $key=>$valu)
                                <tr>
                                    <td><input type="hidden" name="job[]" value="{{$key}}">{{$jobs[$key]}}</td>
                                    <td><input type="hidden" name="nationalities[{{$key}}]" value="@foreach($valu as $val){{$val}},@endforeach">@foreach($valu as $val){{$nationalities[$val]}},@endforeach</td>
                                    <td><button type="button" class="btn sbold red" id="delete_job_nationalities"><i class="fa fa-check"></i> {{trans('labels.delete')}} </button></td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                   
                    <button type="submit" data-token="{{ csrf_token()}}" data-loading-text="{{ trans('labels.loading') }}..."
                            class="demo-loading-btn btn blue" id="ishaar_job_national_submit"><i class="fa fa-check"></i> {{ trans('labels.save') }}
                    </button>
                    <a href="{{ url('/admin/ishaar_setup') }}" class="btn default">{{ trans('labels.cancel') }}</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
