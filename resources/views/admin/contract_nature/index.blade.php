@extends ('admin.layout')
@section('title', trans('contractnature.widgetName'))
@section('content')
<!-- BEGIN PAGE BASE CONTENT -->
<div class="m-heading-1 border-green m-bordered">
    <h3> {{ trans('contractnature.headings.list') }} </h3>
    <p> {{ trans('contractnature.sub-headings.list') }} </p>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i>
                    <span class="caption-subject bold uppercase"> {{ trans('contractnature.widgetName') }}</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6 pull-right">
                            <div class="btn-group pull-right">
                                <button data-toggle="modal" data-target="#main"
                                        data-href="{{ url('admin/contractnatures/create') }}"
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
                    <table class="table table-striped table-bordered table-hover order-column">
                        <thead>
                        <tr class="odd gradeX">
                            {{-- <th class="table-checkbox" width="5%"></th> --}}
                            <th>{{ trans('contractnature.formTitle') }}</th>
                            <th>{{ trans('labels.project_status') }}</th>
                            <th width="20%">{{ trans('labels.options') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($contractsNatures))
                            @foreach($contractsNatures as $contractsNature)
                                <tr class="odd gradeX {{ $contractsNature->hashids }}">
                                    {{-- <td width="5%"><input type="checkbox" class="checkboxes"
                                                          value="{{ $contractsNature->hashids }}"/></td> --}}
                                    <td>{{ $contractsNature->name }} </td>
                                    <td id="{{ $contractsNature->hashids }}">
                                        @if($contractsNature->status == 0)
                                            <span class="badge label-sm label-info"> {{ trans('labels.status.'.$contractsNature->status) }} </span>
                                    </td>
                                    @elseif($contractsNature->status == 1)
                                        <span class="badge bg-green-seagreen bg-font-green-seagreen"> {{ trans('labels.status.'.$contractsNature->status) }} </span></td>
                                    @else
                                        <span class="badge label-sm label-danger"> {{ trans('labels.status.'.$contractsNature->status) }} </span></td>
                                    @endif
                                    <td width="20%">
                                        <div class="btn-group btn-group-lg btn-group-solid margin-bottom-10">

                                            <button data-popout="true" data-token="{{ csrf_token() }}"
                                                    data-id="{{ $contractsNature->hashids }}"
                                                    data-hreff="{{ url('admin/contractnatures/approve/'. $contractsNature->hashids) }}"
                                                    class="btn green action-ajax" data-type="approve"
                                                    data-trans="{{ trans('labels.status.1') }}"
                                                    data-toggle="confirmation"
                                                    data-original-title="{{ trans('labels.request_approve') }}"
                                                    data-placement="top"
                                                    data-btn-ok-label="{{ trans('labels.accept') }}"
                                                    data-btn-cancel-label="{{ trans('labels.cancel') }}">
                                                <i class="fa fa-check"></i> {{ trans('labels.accept') }}</button>
                                            <button data-popout="true" data-type="reject"
                                                    data-token="{{ csrf_token() }}"
                                                    data-id="{{ $contractsNature->hashids }}"
                                                    data-hreff="{{ url('admin/contractnatures/approve/'. $contractsNature->hashids) }}"
                                                    class="btn yellow action-ajax" data-toggle="confirmation"
                                                    data-trans="{{ trans('labels.status.0') }}"
                                                    data-original-title="{{ trans('labels.reject') }}"
                                                    data-placement="top"
                                                    data-btn-ok-label="{{ trans('labels.reject') }}"
                                                    data-btn-cancel-label="{{ trans('labels.cancel') }}">
                                                <i class="fa fa-times"></i> {{ trans('labels.reject') }}</button>
                                            <button data-toggle="modal" data-target="#main"
                                                    data-href="{{ url('admin/contractnatures/'.$contractsNature->hashids . "/edit") }}"
                                                    class="btn blue"><i
                                                        class="fa fa-edit"></i> {{ trans('labels.edit') }}</button>
                                            <button data-popout="true" data-token="{{ csrf_token() }}"
                                                    data-id="{{ $contractsNature->hashids }}"
                                                    data-hreff="{{ route('admin.contractnatures.destroy', $contractsNature->hashids) }}"
                                                    class="btn red-mint delete-ajax" data-toggle="confirmation"
                                                    data-original-title="{{ trans('labels.delete_confirmation_message') }}"
                                                    data-placement="top"
                                                    data-btn-ok-label="{{ trans('labels.delete') }}"
                                                    data-btn-cancel-label="{{ trans('labels.cancel') }}">
                                                <i class="fa fa-trash-o"></i> {{ trans('labels.delete') }}</button>
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
                    <div class="col-md-12">{!! !empty($contractsNatures) ? $contractsNatures->appends(Request::except('page'))->links() : '' !!}</div>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
    <div class="clearfix"></div>
    <!-- END PAGE BASE CONTENT -->
</div>
@endsection