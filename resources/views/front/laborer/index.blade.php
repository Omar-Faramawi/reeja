@extends('front.layout')
@section('title', trans('add_laborer.headings'))
@section('content')
        <!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('labels.system_name') }}
                <small>{{trans('add_laborer.headings')}}</small>
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
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">{{trans('add_laborer.sub-headings')}}</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-lg green" data-toggle="modal"
                                   href="#basic">{{ trans('add_laborer.addnew') }}</a>
                                <a class="btn btn-sm green" data-toggle="modal"
                                   href="#publish">{{ trans('add_laborer.publish-title') }}</a>
                            </div>
                        </div>
                        <div class="portlet-body">
                        <div class="alert alert-warning"><strong>{{ trans('add_laborer.approval') }}:</strong> {{ trans('add_laborer.approval_text') }}</div>
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover table-checkable"
                                       id="datatable_ajax">
                                    <thead>
                                    <tr role="row" class="heading">
                                      <th id='check' class="no-sort"></th>
                                        <th id="id_number" width="200">{{ trans('add_laborer.labels.idnumber') }}</th>
                                        <th id="name" width="200"> {{ trans('add_laborer.labels.name') }}</th>
                                        <th id="nationality.name"
                                            width="200" class="no-sort"> {{ trans('add_laborer.labels.nationality') }}</th>
                                        <th id="gender_name" width="200" class="no-sort"> {{ trans('add_laborer.labels.gender') }}</th>
                                        <th id="job.job_name"
                                            width="200" class="no-sort"> {{ trans('add_laborer.labels.occupation') }}</th>
                                        <th id="age" width="200" class="no-sort"> {{ trans('add_laborer.labels.age') }}</th>
                                        <th id="religion_name"
                                            width="200" class="no-sort"> {{ trans('add_laborer.labels.religion') }}</th>
                                        <th id="details" class="no-sort"> {{ trans('labels.details') }}</th>
                                    </tr>
                                    <tr role="row" class="filter">
                                      <td></td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="id_number">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="name">
                                        </td>
                                        <td>
                                            {{ Form::select('nationality', $nationalities, '', ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall'), "data-live-search" => "true"]) }}
                                        </td>
                                        <td>
                                            {{ Form::select('gender', \Tamkeen\Ajeer\Utilities\Constants::gender(), null, ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall')]) }}
                                        </td>
                                        <td>
                                            {{ Form::select('job', $jobs, '', ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall'), "data-live-search" => "true"]) }}
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="age">
                                        </td>
                                        <td>
                                            {{ Form::select('religion', \Tamkeen\Ajeer\Utilities\Constants::religions() , '', ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.noneSelectedTextValueSmall')]) }}
                                        </td>
                                        <td>
                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                                <i class="fa fa-search"></i> {{ trans('add_laborer.search') }}
                                            </button>
                                            <button class="btn btn-sm red btn-outline filter-cancel">
                                                <i class="fa fa-times"></i> {{ trans('add_laborer.reset') }}
                                            </button>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End: life time stats -->
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        {{ Form::open(['url' => '/laborer/add', "files"=>"false", 'data-url'=>url('/laborer'), 'id'=>'form']) }}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ trans('add_laborer.modal.title') }}</h4>
            </div>
            <div class="modal-body form-body">
                <div class="form-group form-md-line-input has-success form-md-floating-label">
                    <div class="input-icon">
                        {{ Form::text('id_number', null, ['id'=>'laborer_id_number', 'autocomplete' => 'off','class'=>'form-control','required'=>'required']) }}
                        <label for="form_control_1">{{ trans('add_laborer.labels.idnumber') }}</label>
                        <span class="help-block">{{trans('add_laborer.sub-headings')}}</span>
                        <i class="fa fa-user"></i>
                    </div>
                </div>
            <span class="label label-sm label-success" style="display: none;" 
                  id='status-label-exist'>{{ trans('add_laborer.labels.exist') }}</span>
            <span class="label label-sm label-danger" style="display: none;" 
                  id='status-label-not-exist'>{{ trans('add_laborer.labels.not-exist') }}</span>
            <span class="label label-sm label-warning" style="display: none;" 
                  id='status-label-not-active'>{{ trans('add_laborer.labels.not-active') }}</span>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn green" id='add_laborer_button' data-loading-text="{{ trans('labels.loading') }}">{{ trans('labels.save') }}</button>
                <button type="button" class="btn dark btn-outline"
                        data-dismiss="modal">{{ trans('labels.cancel') }}</button>
            </div>
        </div>
        <!-- /.modal-content -->
        {{ Form::close() }}
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="publish" tabindex="-1" role="publish" aria-hidden="true">
    <div class="modal-dialog">
        {{ Form::open(['url' => '/laborer/addtolabormarket', "files"=>"false", 'data-url'=>url('/laborer'), 'id'=>'form']) }}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ trans('add_laborer.publish-title') }}</h4>
            </div>
            <div class="modal-body form-body">
                <p>{{ trans('add_laborer.confirm') }}</p>
                <div class="row">
                    <div class="col-md-6">
                        <label>{{ trans('add_laborer.work_start_date') }}</label>
                        <div class="input-group input-medium" data-date-format="yy-mm-dd">
                            <input type="text" class="form-control date-picker" readonly="" name='startdate'>
                     <span class="input-group-btn">
                     <button class="btn default" type="button">
                         <i class="fa fa-calendar"></i>
                     </button>
                     </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>{{ trans('add_laborer.work_end_date') }}</label>
                        <div class="input-group input-medium" data-date-format="yy-mm-dd">
                            <input type="text" class="form-control date-picker" readonly="" name='enddate'>
                     <span class="input-group-btn">
                     <button class="btn default" type="button">
                         <i class="fa fa-calendar"></i>
                     </button>
                     </span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped table-condensed flip-content" id='in-modal-table'>
                            <tr role="row" class="heading">
                                <th id='check' class="no-sort"></th>
                                <th id="id_number" width="200">{{ trans('add_laborer.labels.idnumber') }}</th>
                                <th id="name" width="200"> {{ trans('add_laborer.labels.name') }}</th>
                                <th id="nationality.name"
                                    width="200"> {{ trans('add_laborer.labels.nationality') }}</th>
                                <th id="gender" width="200"> {{ trans('add_laborer.labels.gender') }}</th>
                                <th id="job.job_name" width="200"> {{ trans('add_laborer.labels.occupation') }}</th>
                                <th id="age" width="200"> {{ trans('add_laborer.labels.age') }}</th>
                                <th id="religion" width="200"> {{ trans('add_laborer.labels.religion') }}</th>
                            </tr>
                            <tr></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" data-loading-text="{{ trans('labels.loading') }}" class="btn green">{{ trans('add_laborer.publish') }}</button>
                <button type="button" class="btn dark btn-outline"
                        data-dismiss="modal">{{ trans('labels.cancel') }}</button>
            </div>
        </div>
        <!-- /.modal-content -->
        {{ Form::close() }}
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- END PAGE CONTENT BODY -->
<!-- END CONTENT BODY -->
@endsection
