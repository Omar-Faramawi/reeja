@extends('front.layout')
@section('title', trans('ishaar_setup.headings.list'))
@section('content')
<!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('labels.system_name') }}
                <small>{{trans('ishaar_setup.headings.list')}}</small>
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
                    <!-- Begin: List Employee Contracts  -->
                    <div class="portlet light portlet-fit portlet-datatable ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">{{trans('ishaar_setup.headings.list')}}</span>
                            </div>
                        </div>
                        <div class="col-md-2">

                                <label for="service_type">{{ trans('temp_job.service_type') }}</label>
                        </div>
                        <div class="col-md-10">
                                {{ Form::select('service_type', \Tamkeen\Ajeer\Utilities\Constants::serviceTypes(['file' => 'temp_job']), [session()->get('service_type')], ['class' => 'form-control form-filter input-sm bs-select', 'id' => 'taqawel-type-select', 'data-route' => url('taqawel/notices') , 'placeholder' => trans('labels.default')]) }}
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover table-checkable"
                                       id="datatable_ajax">
                                    <thead>
                                    <tr role="row" class="heading">
                                        <th id="id"> {{trans('ishaar_setup.attributes.ishaar_number')}}</th>
                                        @if(session()->get('service_type') === \Tamkeen\Ajeer\Utilities\Constants::SERVICETYPES['provider'])
                                        <th class="no-sort" id="contract.benf_name"> {{trans('ishaar_setup.attributes.ishaar_establishment_name')}}</th>
                                        @else
                                        <th class="no-sort" id="contract.providername"> {{trans('ishaar_setup.attributes.ishaar_cancel_provider')}}</th>
                                        @endif
                                        <th class="no-sort" id="hr_pool.name"> {{trans('ishaar_setup.attributes.name')}}</th>
                                        <th class="no-sort" id="hr_pool.id_number"> {{trans('ishaar_setup.attributes.id_number')}}</th>
                                        <th class="no-sort" id="hr_pool.job.job_name"> {{trans('ishaar_setup.attributes.job')}}</th>
                                        <th class="no-sort" id="start_date"> {{trans('ishaar_setup.attributes.ishaar_start_date')}}</th>
                                        <th class="no-sort" id="end_date"> {{trans('ishaar_setup.attributes.ishaar_end_date')}}</th>
                                        <th class="no-sort" id="translated_status"> {{trans('ishaar_setup.attributes.ishaar_status')}}</th>
                                        <th class="no-sort" id="details"> {{trans('ishaar_setup.attributes.details')}}</th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm" name="id">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="benf_name">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="name">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="id_number">
                                        </td>
                                        <td>
                                        {{ Form::select('job_id', $jobs, null, ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall'), "data-live-search" => "true"]) }}

                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-filter date-picker" value=""
                                                   name="start_date">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-filter date-picker" value=""
                                                   name="end_date">
                                        </td>
                                        <td>
                                            {!! Form::select('status', \Tamkeen\Ajeer\Utilities\Constants::contract_statuses(['file' => 'contracts.statuses']), null, ['class' => 'form-control bs-select form-filter', 'placeholder' => trans('labels.noneSelectedTextValueSmall')]) !!}
                                        </td>
                                        <td>
                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                                <i class="fa fa-search"></i> {{ trans('labels.search') }}
                                            </button>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End: list -->
                @if(session()->get('service_type') === \Tamkeen\Ajeer\Utilities\Constants::SERVICETYPES['provider'] && $canBeProvider)
                    <!-- Begin: Add Emplyee Contract -->
                    <div class="portlet light portlet-fit portlet-datatable ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">{{trans('ishaar_setup.headings.create')}}</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            {{-- select Contract First --}}
                            <div class="form-group">
                                <label class="control-label col-md-2">{{trans('ishaar_setup.form_attributes.contract_no')}}
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <select class="form-control bs-select" name="contract_id" id="taqawel_contract_id">
                                        @if(!count($contracts))
                                        <option>{{ trans('labels.no_data') }}</option>
                                        @else
                                        <option value="">{{ trans('labels.default') }}</option>
                                        @foreach($contracts as $contract)
                                        <option value="{{$contract->id}}" >{{$contract->id}}</option>
                                       @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    {{-- <a href="" class="btn btn-circle btn-sm green"
                                        id="add_notice"> {{trans('ishaar_setup.headings.create')}}</a>--}}
                                    <button type="button" class="btn btn-circle btn-sm green" id='add_notice' data-toggle="modal" href="#taqael_generate_or_subscribe" data-ref="" disabled="">{{ trans('ishaar_setup.headings.create') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
    </div>
    <!-- END PAGE CONTENT BODY -->
    <!-- END CONTENT BODY -->
    <div class="modal fade" id="taqael_generate_or_subscribe" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            {{ Form::open(['data-url'=>'',"files"=>"false",'id'=>'form','data-url' => url('taqawel/notices/')]) }}
            <div class="modal-content">
                <div class="modal-body form-body">
                    <img src="{{asset('assets/img/comparison.jpg')}}" width="100%" />
                </div>
                <div class="modal-footer">
                    <a class="btn green" id="continuetogenerate" href="">{{ trans('labels.continue') }}</a>
                    <a class="btn btn-danger" href="{{url('taqawel/packagesubsribe')}}">{{ trans('labels.subscribe') }}</a>
                </div>
            </div>
            <!-- /.modal-content -->
            {{ Form::close() }}
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
@endsection
