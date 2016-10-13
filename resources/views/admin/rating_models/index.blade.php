@extends ('admin.layout')
@section('title', trans('ratingmodels.widgetName'))
@section("styles")
    <link rel="stylesheet"
          href="{{ (app()->getLocale()=="ar") ? asset('assets/css/modal-large-rtl.css') : asset('assets/css/modal-large.css') }}">
    @endsection
    @section('content')
            <!-- BEGIN BREADCRUMBS -->
    <div class="breadcrumbs">
        <h1>{{ trans('ratingmodels.widgetName') }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('admin') }}">{{trans('user.home')}}</a>
            </li>
            <li class="active">{{ trans('ratingmodels.widgetName') }}</li>
        </ol>
    </div>
    <!-- END BREADCRUMBS -->
    <!-- BEGIN PAGE BASE CONTENT -->
    <div class="m-heading-1 border-green m-bordered">
        <h3> {{ trans('ratingmodels.headings.list') }} </h3>
        <p> {{ trans('ratingmodels.sub-headings.list') }} </p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings"></i>
                        <span class="caption-subject bold uppercase"> {{ trans('ratingmodels.widgetName') }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6 pull-right">
                                <div class="btn-group pull-right">
                                    <button data-toggle="modal" data-target="#main"
                                            data-href="{{ url('admin/ratingmodels/create') }}"
                                            class="btn sbold green"> {{ trans('labels.add') }}
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
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
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column">
                            <thead>
                            <tr class="odd gradeX">
                                <th class="table-checkbox" width="5%"></th>
                                <th>{{ trans('ratingmodels.formTitle') }}</th>
                                <th>{{ trans('labels.project_status') }}</th>
                                <th width="20%">{{ trans('labels.options') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($ratingModels))
                                @foreach($ratingModels as $ratingModel)
                                    <tr class="odd gradeX {{ $ratingModel->hashids }}">
                                        <td width="5%"><input type="checkbox" class="checkboxes"
                                                              value="{{ $ratingModel->hashids }}"/></td>
                                        <td>{{ $ratingModel->name }} </td>
                                        <td id="{{ $ratingModel->hashids }}">
                                            @if($ratingModel->status == 0)
                                                <span class="badge label-sm label-danger"> {{ trans('labels.status.'.$ratingModel->status) }} </span>
                                        </td>
                                        @elseif($ratingModel->status == 1)
                                            <span class="badge bg-green-seagreen bg-font-green-seagreen"> {{ trans('labels.status.'.$ratingModel->status) }} </span></td>
                                        @else
                                            <span class="badge label-sm label-danger"> {{ trans('labels.status.'.$ratingModel->status) }} </span></td>
                                        @endif
                                        <td width="20%">
                                            <div class="btn-group btn-group-lg btn-group-solid margin-bottom-10">
                                                <button data-popout="true" data-token="{{ csrf_token() }}" id="taqyeem_enable_btn" @if($ratingModel->status == 1) style="display:none" @endif
                                                        data-id="{{ $ratingModel->hashids }}"
                                                        data-hreff="{{ url('admin/ratingmodels/approve/'. $ratingModel->hashids) }}"
                                                        class="btn green action-ajax" data-type="approve"
                                                        data-trans="{{ trans('labels.status.1') }}"
                                                        data-toggle="confirmation"
                                                        data-original-title="{{ trans('labels.request_approve') }}"
                                                        data-placement="top"
                                                        data-btn-ok-label="{{ trans('labels.accept') }}"
                                                        data-btn-cancel-label="{{ trans('labels.cancel') }}">
                                                    <i class="fa fa-check"></i> {{ trans('labels.accept') }}</button>
                                                <button data-popout="true" data-type="reject" id="taqyeem_disable_btn" @if($ratingModel->status == 0) style="display:none" @endif
                                                        data-token="{{ csrf_token() }}"
                                                        data-id="{{ $ratingModel->hashids }}"
                                                        data-hreff="{{ url('admin/ratingmodels/approve/'. $ratingModel->hashids) }}"
                                                        class="btn yellow action-ajax" data-toggle="confirmation"
                                                        data-trans="{{ trans('labels.status.0') }}"
                                                        data-original-title="{{ trans('labels.reject2') }}"
                                                        data-placement="top"
                                                        data-btn-ok-label="{{ trans('labels.reject2') }}"
                                                        data-btn-cancel-label="{{ trans('labels.cancel') }}">
                                                    <i class="fa fa-times"></i> {{ trans('labels.reject2') }}</button>
                                                <button data-toggle="modal" data-target="#main"
                                                        data-href="{{ url('admin/ratingmodels/'.$ratingModel->hashids . "/edit") }}"
                                                        class="btn blue"><i
                                                            class="fa fa-edit"></i> {{ trans('labels.edit') }}</button>

                                                <button data-toggle="modal" data-target="#main"
                                                        data-href="{{ route('nextToTaqyeem',$ratingModel->id ) }}"
                                                        class="btn blue"><i
                                                            class="fa fa-edit"></i> {{ trans('contractmembertaqyeem.access') }}</button>
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
                    <div class="row text-right">
                        <div class="col-md-12">{!! !empty($ratingModels) ? $ratingModels->appends(Request::except('page'))->links() : '' !!}</div>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
            <div class="clearfix"></div>
            <!-- END PAGE BASE CONTENT -->
        </div>
    </div>
@endsection