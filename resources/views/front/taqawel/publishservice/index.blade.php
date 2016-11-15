@extends('front.layout')
@section('title', trans('taqawoul.tqawel_services'))
@section('content')
        <!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('taqawoul.tqawel_services') }}</h1>
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
                                <span class="caption-subject font-dark sbold uppercase">{{ trans('taqawoul.tqawel_services_list') }}</span>
                            </div>
                            <div class="actions">
                                @if($can_add)
                                <a class="btn blue"
                                   data-toggle="modal" data-href='{{url("/taqawel/publishservice/create")}}'  data-target='#main' data-toggle="modal"><i
                                            class="fa fa-plus"></i>
                                    {{ trans('taqawoul.tqawel_services_add') }}</a>
                                @endif
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover"
                                       id="datatable_ajax">
                                    <thead>
                                    <tr role="row" class="heading">
                                        <th id="id" width="8%">#</th>
                                        <th id='contract_nature.name'
                                            class="no-sort">{{ trans('taqawoul.list_attributes.service_type') }}</th>
                                        <th id='description'
                                            class="no-sort">{{ trans('taqawoul.list_attributes.service_description') }}</th>
                                        <th id="serviceEdit" class="no-sort"
                                            width="30%"> {{ trans('taqawoul.list_attributes.details') }}</th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="id">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="service_id"></td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm"
                                                   name="description"></td>
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
                    </div>
                    <!-- End: life time stats -->
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END PAGE CONTENT BODY -->

<!-- Main Modal -->
<div id="main" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="{{ asset('assets/img/loading-spinner-grey.gif') }}" alt="" class="loading">
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
@endsection