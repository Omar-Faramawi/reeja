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

                    <div class="col-lg-10">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="is_slider">{{trans('contract_setup.attributes.offer_accept_period')}}</label>
                                        {!! Form::number('offer_accept_period', null, ['min' => 0, 'class' => 'form-control valid']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-1">&nbsp;</div>
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="featured">&nbsp;</label>
                                        <div class="select-wrapper select-arrow">
                                            {!! Form::select('offer_accept_period_type', trans('contract_setup.period_type_array'),null,  ['class' => 'form-control']) !!}

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="is_slider">{{trans('contract_setup.attributes.contract_cancel_period')}}</label>
                                        {!! Form::number('contract_cancel_period', null, ['min' => 0, 'class' => 'form-control valid']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-1">&nbsp;</div>
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="featured">&nbsp;</label>
                                        <div class="select-wrapper select-arrow">
                                            {!! Form::select('contract_cancel_period_type', trans('contract_setup.period_type_array'),null,  ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="is_slider">{{trans('contract_setup.cancel_acc')}}</label>

                                        <div>
                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                <label id="provider_cancel_contract" class="active">
                                                    {{--<input type="checkbox" name="provider_cancel_contract" value="1"--}}
                                                    {{--checked="">--}}
                                                    {!! Form::hidden('provider_cancel_contract', 0) !!}
                                                    {!! Form::checkbox('provider_cancel_contract') !!}

                                                    <span>{{trans('contract_setup.provider')}}</span>
                                                </label>
                                            </div>
                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                <label id="benf_cancel_contract" class="active">
                                                    {{--<input type="checkbox" name="benf_cancel_contract" value="1"--}}
                                                    {{--checked="">--}}
                                                    {!! Form::hidden('benf_cancel_contract', 0) !!}
                                                    {!! Form::checkbox('benf_cancel_contract') !!}

                                                    <span>{{trans('contract_setup.benf')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="is_slider">{{trans('contract_setup.ishaar_cancel_acc')}}</label>

                                        <div>
                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                <label id="provider_cancel_ishaar" class="active">
                                                    {{--<input type="checkbox" name="provider_cancel_ishaar" value="1"--}}
                                                    {{--checked="">--}}
                                                    {!! Form::hidden('provider_cancel_ishaar', 0) !!}
                                                    {!! Form::checkbox('provider_cancel_ishaar') !!}

                                                    <span>{{trans('contract_setup.provider')}}</span>
                                                </label>
                                            </div>
                                            <div class="checkbox custom-check checkbox-inline checkbox-red">
                                                <label id="benf_cancel_ishaar" class="active">
                                                    {{--<input type="checkbox" name="benf_cancel_ishaar" value="1"--}}
                                                    {{--checked="">--}}
                                                    {!! Form::hidden('benf_cancel_ishaar', 0) !!}
                                                    {!! Form::checkbox('benf_cancel_ishaar') !!}

                                                    <span>{{trans('contract_setup.benf')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="is_slider">{{trans('contract_setup.attributes.saudi_service_avb')}}</label>

                                        <div class="radio">
                                            <label>
                                                {!! Form::radio('saudi_service_avb', 0, 1) !!}
                                                {{trans('labels.no')}}
                                            </label>
                                        </div>

                                        <div class="radio">
                                            <label>
                                                {!! Form::radio('saudi_service_avb', 1) !!}
                                                {{trans('labels.yes')}}
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <h4 style="background: #eee;padding: 4px">
                                {{trans('contract_setup.additional_options')}}
                            </h4>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="is_slider">{{trans('contract_setup.attributes.contract_accept_period')}}</label>
                                        {!! Form::number('contract_accept_period', null, ['min' => 0, 'class' => 'form-control valid']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-1">&nbsp;</div>
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="featured">&nbsp;</label>
                                        <div class="select-wrapper select-arrow">
                                            {!! Form::select('contract_accept_period_type', trans('contract_setup.period_type_array'),null,  ['class' => 'form-control']) !!}

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="is_slider">{{trans('contract_setup.attributes.substitute_percintage')}}</label>
                                        {!! Form::number('substitute_percintage', null, ['min' => 0, 'max' => 100, 'class' => 'form-control valid', 'placeholder' => '%']) !!}
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="is_slider">{{trans('contract_setup.attributes.max_labor_avb')}}</label>
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