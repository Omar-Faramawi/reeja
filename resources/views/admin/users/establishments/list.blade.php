@extends ('admin.layout')
@section('title', trans('establishments_registration.headings.list'))
@section('content')
<!-- BEGIN BREADCRUMBS -->
<div class="breadcrumbs">
    <h1>{{ trans('establishments_registration.headings.list') }}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('admin') }}">{{trans('user.home')}}</a>
        </li>
        <li class="active">{{ trans('establishments_registration.headings.list') }}</li>
    </ol>
</div>
<!-- END BREADCRUMBS -->
<div class="m-heading-1 border-green m-bordered">
    <h3> {{ trans('establishments_registration.headings.list') }} </h3>
    <p> {{ trans('establishments_registration.sub-headings.list') }} </p>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i>
                    <span class="caption-subject bold uppercase"> {{ trans('establishments_registration.headings.list') }}</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6 pull-right">
                            <div class="btn-group pull-right">
                                <button data-toggle="modal" data-target="#main"
                                        data-href="{{ url('admin/users/establishments_registeration/create') }}"
                                        class="btn sbold green"> {{ trans('labels.add') }}
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                        <tr class="odd gradeX">
                            <th width="5%" class="table-checkbox"></th>
                            <th>{{ trans('establishments_registration.attributes.name') }}</th>
                            <th>{{ trans('establishments_registration.attributes.email') }}</th>
                            <th>{{ trans('establishments_registration.attributes.labour_office_no') }}</th>
                            <th>{{ trans('establishments_registration.attributes.sequence_no') }}</th>
                            <th>{{ trans('establishments_registration.attributes.id_number') }}</th>
                            <th>{{ trans('establishments_registration.attributes.status_title') }}</th>
                            <th width="20%">{{ trans('labels.options') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!count($data))
                            <tr><td colspan="8">{{ trans('labels.no_data') }}</td></tr>
                        @else
                            @foreach($data as $single)
                                <tr class="odd gradeX {{ $single->hashids }}">
                                    <td><input type="checkbox" class="checkboxes" value="{{ $single->hashids }}"/></td>
                                    <td> {{ $single->name }} </td>
                                    <td> {{ $single->email }} </td>
                                    <td> {{ $single->labour_office_no }} </td>
                                    <td> {{ $single->sequence_no }} </td>
                                    <td> {{ $single->id_number }} </td>
                                    <td>
                                        <span class="{{ trans('labels.span_classes.'.$single->status) }}">
                                        {{ trans('establishments_registration.status.'.$single->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-lg btn-group-solid margin-bottom-10">
                                            <button data-toggle="modal" data-target="#main"
                                                    data-href="{{ route('admin.users.establishments_registeration.edit', $single->hashids) }}"
                                                    class="btn blue">
                                                <i class="fa fa-edit"></i> {{ trans('labels.edit') }}
                                            </button>
                                            <button data-popout="true" data-token="{{ csrf_token() }}"
                                                    data-id="{{ $single->hashids }}"
                                                    data-hreff="{{ route('admin.users.establishments_registeration.destroy', $single->hashids) }}"
                                                    class="btn red-mint delete-ajax" data-toggle="confirmation"
                                                    data-original-title="{{ trans('labels.delete_confirmation_message') }}"
                                                    data-placement="top"
                                                    data-btn-ok-label="{{ trans('labels.delete') }}"
                                                    data-btn-cancel-label="{{ trans('labels.cancel') }}">
                                                <i class="fa fa-trash-o"></i> {{ trans('labels.delete') }}
                                            </button>
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
                    <div class="col-md-12">{{ $data->render() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
