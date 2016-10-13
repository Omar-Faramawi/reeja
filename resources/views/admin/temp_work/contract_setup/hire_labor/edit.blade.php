@extends ('admin.layout')
@section('title', trans('user.dashboardwidgets'))
@section('content')
    <!-- BEGIN BREADCRUMBS -->
    <div class="breadcrumbs">
        <h1>{{ trans('contract_setup.temp_work_contract_setup') }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('/admin')}}">{{trans('user.home')}}</a>
            </li>
            <li class="active">{{ trans('contract_setup.temp_work_contract_setup') }}</li>
        </ol>
    </div>
    <!-- END BREADCRUMBS -->
    <!-- BEGIN PAGE BASE CONTENT -->


    <div class="m-heading-1 border-green m-bordered">
        <h3> {{ trans('contract_setup.hire_labor') }} </h3>
        <p> {{ trans('contract_setup.temp_work_contract_setup') }} </p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings"></i>
                        <span class="caption-subject bold uppercase"> {{ trans('contract_setup.hire_labor_contracts_setup') }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6 pull-right">
                                @if(!empty($can_add) && $can_add)
                                    <div class="btn-group pull-right">
                                        <button data-toggle="modal" data-target="#main"
                                                data-href="{{ route('admin.contractSetup.create', ['id'=>$occupation->id]) }}"
                                                class="btn sbold green"> {{ trans('actions.add') }}
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
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


                    <div class="col-lg-2"></div>
                    {!! Form::model($contractSetup, ['route' => ['admin.contractSetup.update', $contractSetup->hashids], 'id' => 'live_form', 'method' => 'PATCH']) !!}
                    {!! Form::hidden('contract_type_id',null, ['id' => 'contract_type_id']) !!}

                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="is_slider">{{trans('contract_setup.attributes.offer_accept_period')}}</label>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    {!! Form::number('offer_accept_period', null, ['min' => 0, 'class' => 'form-control valid']) !!}
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="select-wrapper select-arrow">
                                        {!! Form::select('offer_accept_period_type', trans('contract_setup.period_type_array'),null,  ['class' => 'form-control']) !!}

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="is_slider">{{trans('contract_setup.attributes.contract_cancel_period')}}</label>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    {!! Form::number('contract_cancel_period', null, ['min' => 0, 'class' => 'form-control valid']) !!}
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="select-wrapper select-arrow">
                                        {!! Form::select('contract_cancel_period_type', trans('contract_setup.period_type_array'),null,  ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="is_slider">{{trans('contract_setup.cancel_acc')}}</label>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <div class="md-checkbox-inline">
                                        <div class="md-checkbox">
                                            {!! Form::checkbox('provider_cancel_contract', @$contractSetup->provider_cancel_contract, null, ['class' => 'md-check', 'id' => 'provider_cancel_contract']) !!}
                                            <label for="provider_cancel_contract" class="text-right">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> {{trans('contract_setup.provider')}}
                                            </label>
                                        </div>

                                        <div class="md-checkbox">
                                            {!! Form::checkbox('benf_cancel_contract', @$contractSetup->benf_cancel_contract, null, ['class' => 'md-check', 'id' => 'benf_cancel_contract']) !!}
                                            <label for="benf_cancel_contract" class="text-right">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> {{trans('contract_setup.benf')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3">
                                <label for="is_slider">{{trans('contract_setup.ishaar_cancel_acc')}}</label>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <div class="md-checkbox-inline">
                                        <div class="md-checkbox">
                                            {!! Form::checkbox('provider_cancel_ishaar', @$contractSetup->provider_cancel_ishaar, null, ['class' => 'md-check', 'id' => 'provider_cancel_ishaar']) !!}
                                            <label for="provider_cancel_ishaar" class="text-right">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> {{trans('contract_setup.provider')}}
                                            </label>
                                        </div>

                                        <div class="md-checkbox">
                                            {!! Form::checkbox('benf_cancel_ishaar', @$contractSetup->benf_cancel_ishaar, null, ['class' => 'md-check', 'id' => 'benf_cancel_ishaar']) !!}
                                            <label for="benf_cancel_ishaar" class="text-right">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> {{trans('contract_setup.benf')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3">
                                <label for="is_slider">{{trans('contract_setup.attributes.saudi_service_avb')}}</label>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            {!! Form::hidden('saudi_service_avb') !!}
                                            {!! Form::radio('saudi_service_avb', 1, null, ['class' => 'md-radiobtn', 'id' => 'saudi_service_avb_yes']) !!}
                                            <label for="saudi_service_avb_yes">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> {{trans('labels.no')}} </label>
                                        </div>
                                        <div class="md-radio">
                                            {!! Form::radio('saudi_service_avb', 0, null, ['class' => 'md-radiobtn', 'id' => 'saudi_service_avb_no']) !!}
                                            <label for="saudi_service_avb_no">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> {{trans('labels.yes')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-11">
                                <h4 style="background: #eee;padding: 4px">
                                    {{trans('contract_setup.additional_options')}}
                                </h4>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="is_slider">{{trans('contract_setup.attributes.contract_accept_period')}}</label>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    {!! Form::number('contract_accept_period', null, ['min' => 0, 'class' => 'form-control valid']) !!}
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="select-wrapper select-arrow">
                                        {!! Form::select('contract_accept_period_type', trans('contract_setup.period_type_array'),null,  ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3">
                                <label for="is_slider">{{trans('contract_setup.attributes.substitute_percintage')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    {!! Form::number('substitute_percintage', null, ['min' => 0, 'max' => 100, 'class' => 'form-control valid', 'placeholder' => '%']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3">
                                <label for="is_slider">{{trans('contract_setup.attributes.max_labor_avb')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    {!! Form::number('max_labor_avb', null, ['min' => 0, 'max' => 365, 'class' => 'form-control valid']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col col-lg-2">
                                <label for="" class="col-md-3 control-label">&nbsp;</label>
                            </div>
                            <div class="col col-lg-10">
                                <button type="submit"
                                        data-loading-text="{{ trans('contract_setup.saving') }}..."
                                        class="demo-loading-btn btn blue">{{trans('contract_setup.save')}}</button>
                            </div>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                    {!! Form::close() !!}
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