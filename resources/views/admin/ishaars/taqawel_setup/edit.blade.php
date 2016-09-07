@extends ('admin.layout')
@section('title', trans('ishaar_setup.ishaars_bundles_management'))
@section('content')
    <!-- BEGIN BREADCRUMBS -->
    <div class="breadcrumbs">
        <h1>{{ trans('ishaar_setup.ishaars_bundles_management') }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('/admin')}}">{{trans('user.home')}}</a>
            </li>
            <li class="active">{{ trans('ishaar_setup.ishaars_bundles_management') }}</li>
        </ol>
    </div>
    <!-- END BREADCRUMBS -->
    <!-- BEGIN PAGE BASE CONTENT -->

    <div class="m-heading-1 border-green m-bordered">
        <h3> {{ trans('ishaar_setup.ishaars_bundles_management') }} </h3>
        <p> {{ trans('ishaar_setup.taqawel_ishaars_management') }} </p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase"> {{ trans('ishaar_setup.ishaars_bundles_management') }}</span>
                    </div>

                    <ul class="nav nav-tabs nav-tabs">
                        <li class="active"><a href="#tab1" role="tab"
                               data-toggle="tab">{{trans('ishaar_setup.general_ishaars_preferences')}}</a>
                        </li>
                        <li><a href="#tab2" role="tab"
                               data-toggle="tab">{{trans('ishaar_setup.free_ishaars_management')}}</a></li>
                        <li><a href="#tab3" role="tab"
                                              data-toggle="tab">{{trans('ishaar_setup.paid_ishaars_management')}}</a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">
                    @if(count($errors))
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (Session::has('msg'))
                        <div class="alert alert-info">{{ Session::pull('msg') }}</div>
                @endif

                <!-- TAB NAVIGATION -->

                    <!-- TAB CONTENT -->
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1">
                            {!! Form::model($taqawel_free->toArray(), ['route' => ['admin.taqawel_ishaar_management.update', $taqawel_free->hashids], 'id' => 'form', 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('ishaar_type_name', 'taqawel') !!}
                            {!! Form::hidden('ishaar_setup_id', $taqawel_free->id) !!}
                            <div class="form-body">
                                <div class="form-group form-md-checkboxes">
                                    <label class="col-md-2 control-label text-right"
                                           for="form_control_1">{{trans('ishaar_setup.form_attributes.labor_status')}}</label>
                                    <div class="col-md-10">
                                        <div class="md-checkbox-inline">
                                            <div class="md-checkbox">
                                                {!! Form::checkbox('labor_status_employed', 1, null, ['class' => 'md-check', 'id' => 'labor_status_work_head']) !!}
                                                <label for="labor_status_work_head" class="text-right">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{trans('ishaar_setup.form_attributes.labor_status_work_head')}}
                                                </label>
                                            </div>
                                            <div class="md-checkbox">
                                                {!! Form::checkbox('labor_status_companion', 1, null, ['class' => 'md-check', 'id' => 'labor_status_companion']) !!}
                                                <label for="labor_status_companion" class="text-right">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{trans('ishaar_setup.form_attributes.labor_status_companion')}}
                                                </label>
                                            </div>
                                            <div class="md-checkbox">
                                                {!! Form::checkbox('labor_status_visitor', 1, null, ['class' => 'md-check', 'id' => 'labor_status_visitor']) !!}
                                                <label for="labor_status_visitor" class="text-right">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{trans('ishaar_setup.form_attributes.labor_status_visitor')}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-checkboxes">
                                    <label class="col-md-2 control-label text-right"
                                           for="form_control_1">{{trans('ishaar_setup.form_attributes.labor_gender')}}</label>
                                    <div class="col-md-10">
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
                                <div class="form-group form-md-checkboxes">
                                    <label class="col-md-2 control-label text-right"
                                           for="form_control_1">{{trans('ishaar_setup.form_attributes.ishaar_cancel_type')}}</label>
                                    <div class="col-md-10">
                                        <div class="md-checkbox-inline">
                                            <div class="md-checkbox">
                                                {!! Form::hidden('ishaar_cancel_free', 0) !!}
                                                {!! Form::checkbox('ishaar_cancel_free', 1, null, ['id' => 'checkbox6', 'class' => 'md-check']) !!}
                                                <label for="checkbox6">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{trans('ishaar_setup.free')}} </label>
                                            </div>
                                            <div class="md-checkbox">
                                                {!! Form::hidden('ishaar_cancel_paid', 0) !!}
                                                {!! Form::checkbox('ishaar_cancel_paid', 1, null, ['id' => 'checkbox7', 'class' => 'md-check']) !!}
                                                <label for="checkbox7">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{trans('ishaar_setup.paid')}} </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-checkboxes">
                                    <label class="col-md-2 control-label text-right"
                                           for="form_control_1">{{trans('ishaar_setup.form_attributes.ishaar_cancel_permission')}}</label>
                                    <div class="col-md-10">
                                        <div class="md-checkbox-inline">
                                            <div class="md-checkbox">
                                                {!! Form::hidden('ishaar_cancel_provider', 0) !!}
                                                {!! Form::checkbox('ishaar_cancel_provider', 1, null, ['id' => 'checkbox8', 'class' => 'md-check']) !!}
                                                <label for="checkbox8">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{trans('ishaar_setup.attributes.ishaar_cancel_provider')}}
                                                </label>
                                            </div>
                                            <div class="md-checkbox">
                                                {!! Form::hidden('ishaar_cancel_benf', 0) !!}
                                                {!! Form::checkbox('ishaar_cancel_benf', 1, null, ['id' => 'checkbox9', 'class' => 'md-check']) !!}
                                                <label for="checkbox9">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{trans('ishaar_setup.attributes.ishaar_cancel_benf')}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-radios">
                                    <label class="control-label col-sm-2 text-right"> {{trans('ishaar_setup.attributes.nitaq_active')}} </label>
                                    <div class="col-md-10">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                {!! Form::hidden('nitaq_active') !!}
                                                {!! Form::radio('nitaq_active', 1, null, ['class' => 'md-radiobtn', 'id' => 'nitaq_yes']) !!}
                                                <label for="nitaq_yes">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{trans('labels.yes')}} </label>
                                            </div>
                                            <div class="md-radio">
                                                {!! Form::radio('nitaq_active', 0, null, ['class' => 'md-radiobtn', 'id' => 'nitaq_no']) !!}
                                                <label for="nitaq_no">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{trans('labels.no')}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col col-lg-2">
                                    <label for="" class="col-md-3 control-label">&nbsp;</label>
                                </div>
                                <div class="col col-lg-10">
                                    <button type="submit" data-loading-text="{{ trans('contract_setup.saving') }}..."
                                            class="demo-loading-btn btn blue">{{trans('contract_setup.save')}}</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="tab-pane fade" id="tab2">
                            {!! Form::model($taqawel_free->toArray(), ['route' => ['admin.taqawel_ishaar_management.update', $taqawel_free->hashids], 'id' => 'another_form', 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('ishaar_setup_id', $taqawel_free->id) !!}
                            {!! Form::hidden('ishaar_type_name', 'taqawel_free') !!}
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 text-right"
                                           for="min_ishaar_period">{{trans('ishaar_setup.attributes.min_ishaar_period')}}</label>
                                    <div class="col-sm-9">
                                        <div class="col-md-6">
                                            {!! Form::number('min_ishaar_period', null, ['class'=> 'form-control', 'id' => 'min_ishaar_period']) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::select('min_ishaar_period_type',  trans('contract_setup.period_type_array'), null, ['class'=> 'form-control selectpicker', 'id' => 'min_ishaar_period_type']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3 text-right"
                                           for="max_ishaar_period">{{trans('ishaar_setup.attributes.max_ishaar_period')}}</label>
                                    <div class="col-sm-9">
                                        <div class="col-md-6">
                                            {!! Form::number('max_ishaar_period', null, ['class'=> 'form-control', 'id' => 'max_ishaar_period']) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::select('max_ishaar_period_type',  trans('contract_setup.period_type_array'), null, ['class'=> 'form-control selectpicker', 'id' => 'max_ishaar_period_type']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3 text-right"
                                           for="min_no_of_ishaars">{{trans('ishaar_setup.attributes.min_no_of_ishaars')}}</label>
                                    <div class="col-sm-9">
                                        {!! Form::number('min_no_of_ishaars',  null, ['class'=> 'form-control', 'id' => 'min_no_of_ishaars']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3 text-right"
                                           for="max_no_of_ishaars">{{trans('ishaar_setup.attributes.max_no_of_ishaars')}}</label>
                                    <div class="col-sm-9">
                                        {!! Form::number('max_no_of_ishaars',  null, ['class'=> 'form-control', 'id' => 'max_no_of_ishaars']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3 text-right"
                                           for="total_period_labor">{{trans('ishaar_setup.attributes.total_period_labor')}}</label>
                                    <div class="col-sm-9">
                                        {!! Form::number('total_period_labor',  null, ['class'=> 'form-control', 'id' => 'total_period_labor']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3 text-right"
                                           for="ishaar_lobor_times">{{trans('ishaar_setup.attributes.ishaar_lobor_times')}}</label>
                                    <div class="col-sm-9">
                                        {!! Form::number('ishaar_lobor_times',  null, ['class'=> 'form-control', 'id' => 'ishaar_lobor_times']) !!}
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col col-lg-2">
                                    <label for="" class="col-md-3 control-label">&nbsp;</label>
                                </div>
                                <div class="col col-lg-10">
                                    <button type="submit" data-loading-text="{{ trans('contract_setup.saving') }}..."
                                            class="demo-loading-btn btn blue">{{trans('contract_setup.save')}}</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="tab-pane fade" id="tab3">
                            {!! Form::model($taqawel_paid->toArray(), ['route' => ['admin.taqawel_ishaar_management.update', $taqawel_paid->hashids], 'id' => 'another_form1', 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('ishaar_setup_id', $taqawel_paid->id) !!}
                            {!! Form::hidden('ishaar_type_name', 'taqawel_paid') !!}
                            <div class="form-body">

                                <div class="col-md-12">
                                    <div class="form-group form-md-line-input form-md-floating-label col-md-9">
                                        {!! Form::number('trial_ishaar_num', null, ['class'=> 'form-control', 'id' => 'trial_ishaar_num']) !!}
                                        <label for="trial_ishaar_num">{{trans('ishaar_setup.attributes.trial_ishaar_num')}}</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input form-md-floating-label col-md-9">
                                        {!! Form::number('paid_ishaar_payment_expiry_period', null, ['class'=> 'form-control', 'id' => 'paid_ishaar_payment_expiry_period']) !!}
                                        <label for="paid_ishaar_payment_expiry_period">{{trans('ishaar_setup.attributes.paid_ishaar_payment_expiry_period')}}</label>
                                    </div>
                                    <div class="form-group col-md-3">
                                        {!! Form::select('paid_ishaar_payment_expiry_period_type',  trans('contract_setup.period_type_array'), null, ['class'=> 'form-control selectpicker', 'id' => 'paid_ishaar_payment_expiry_period_type']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input form-md-floating-label col-md-9">
                                        {!! Form::number('paid_ishaar_valid_expiry_period', null, ['class'=> 'form-control', 'id' => 'paid_ishaar_valid_expiry_period']) !!}
                                        <label for="paid_ishaar_valid_expiry_period">{{trans('ishaar_setup.attributes.paid_ishaar_valid_expiry_period')}}</label>

                                    </div>
                                    <div class="form-group col-md-3">
                                        {!! Form::select('paid_ishaar_valid_expiry_period_type',  trans('contract_setup.period_type_array'), null, ['class'=> 'form-control selectpicker', 'id' => 'paid_ishaar_valid_expiry_period_type']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input form-md-floating-label col-md-9">
                                        {!! Form::number('max_ishaar_period', null, ['class'=> 'form-control', 'id' => 'max_ishaar_period']) !!}
                                        <label for="max_ishaar_period">{{trans('ishaar_setup.attributes.max_ishaar_period')}}</label>
                                    </div>
                                    <div class="form-group col-md-3">
                                        {!! Form::select('max_ishaar_period_type',  trans('contract_setup.period_type_array'), null, ['class'=> 'form-control selectpicker', 'id' => 'max_ishaar_period_type']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input form-md-floating-label col-md-9">
                                        {!! Form::number('min_ishaar_period', null, ['class'=> 'form-control', 'id' => 'min_ishaar_period']) !!}
                                        <label for="max_ishaar_period">{{trans('ishaar_setup.attributes.min_ishaar_period')}}</label>
                                    </div>
                                    <div class="form-group col-md-3">
                                        {!! Form::select('min_ishaar_period_type',  trans('contract_setup.period_type_array'), null, ['class'=> 'form-control selectpicker', 'id' => 'min_ishaar_period_type']) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-md-checkboxes">
                                        <label class="col-md-2 control-label text-right"
                                               for="form_control_1">{{trans('ishaar_setup.attributes.labor_follow_permissions_text')}}</label>
                                        <div class="col-md-10">
                                            <div class="md-checkbox-inline">
                                                @foreach(trans('ishaar_setup.attributes.labor_follow_permissions') as $key => $perm)
                                                    <div class="md-checkbox">
                                                        {!! Form::checkbox($key, 1, null, ['id' => $key, 'class' => 'md-check']) !!}
                                                        <label for="{{ $key }}">
                                                            <span></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> {{ $perm }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-radios">
                                        <label class="control-label col-md-8 text-right"> {{trans('ishaar_setup.attributes.labor_multi_regions_perm')}} </label>
                                        <div class="col-md-4">
                                            <div class="md-radio-inline">
                                                <div class="md-radio">
                                                    {!! Form::radio('labor_multi_regions_perm', 1, null, ['class' => 'md-radiobtn auto-hide1', 'id' => 'yes', ]) !!}
                                                    <label for="yes">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> {{trans('labels.yes')}} </label>
                                                </div>
                                                <div class="md-radio">
                                                    {!! Form::radio('labor_multi_regions_perm', 0, null, ['class' => 'md-radiobtn auto-hide1', 'id' => 'no']) !!}
                                                    <label for="no">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> {{trans('labels.no')}}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input form-md-floating-label col-md-12 extra" {{ !empty($taqawel_paid->labor_multi_regions_perm) ? '' : 'style=display:none;' }}>
                                        {!! Form::number('labor_multi_regions_perm_num', null, ['class'=> 'form-control', 'id' => 'labor_multi_regions_perm_num', 'data-value'=>'1']) !!}
                                        <label for="labor_multi_regions_perm_num">{{trans('ishaar_setup.attributes.labor_multi_regions_perm_num')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-md-line-input form-md-floating-label col-md-6">
                                        {!! Form::number('total_period_labor', null, ['class'=> 'form-control', 'id' => 'total_period_labor']) !!}
                                        <label for="total_period_labor">{{trans('ishaar_setup.attributes.total_period_labor')}}</label>
                                    </div>
                                </div>
                                <h5 class="text-success col-md-12">{{ trans('ishaar_setup.attributes.labor_same_benef') }}</h5>
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input form-md-floating-label col-md-12">
                                        {!! Form::number('labor_same_benef_max_num_of_ishaar', null, ['class'=> 'form-control', 'id' => 'labor_same_benef_max_num_of_ishaar']) !!}
                                        <label for="labor_benef_max_num_of_ishaar">{{trans('ishaar_setup.attributes.labor_same_benef_max_num_of_ishaar')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input form-md-floating-label col-md-9">
                                        {!! Form::number('labor_same_benef_max_period_of_ishaar', null, ['class'=> 'form-control', 'id' => 'labor_same_benef_max_period_of_ishaar']) !!}
                                        <label for="labor_same_benef_max_period_of_ishaar">{{trans('ishaar_setup.attributes.labor_same_benef_max_period_of_ishaar')}}</label>
                                    </div>
                                    <div class="form-group col-md-3">
                                        {!! Form::select('labor_same_benef_max_period_of_ishaar_type',  trans('contract_setup.period_type_array'), null, ['class'=> 'form-control selectpicker', 'id' => 'labor_same_benef_max_period_of_ishaar_type']) !!}
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <button type="submit" data-loading-text="{{ trans('contract_setup.saving') }}..."
                                        class="demo-loading-btn btn blue">{{trans('contract_setup.save')}}</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>


                    <div class="clearfix"></div>

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>

    <!-- BEGIN DASHBOARD STATS 1-->

    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->
    <!-- END PAGE BASE CONTENT -->

@endsection