@extends ('admin.layout')
@section('title', trans('individuals_admin.headings.list'))
@section('content')
<div class="m-heading-1 border-green m-bordered">
    <h3> {{ trans('individuals_admin.headings.list') }} </h3>
    <p> {{ trans('individuals_admin.sub-headings.list') }} </p>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i>
                    <span class="caption-subject bold uppercase"> {{ trans('individuals_admin.headings.list') }}</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6 pull-right">
                            <div class="btn-group pull-right">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover order-column">
                        <thead>
                        <tr class="odd gradeX">
                            {{-- <th width="5%" class="table-checkbox"></th> --}}
                            <th>{{ trans('individuals_admin.attributes.name') }}</th>
                            <th>{{ trans('individuals_admin.attributes.email') }}</th>
                            <th>{{ trans('individuals_admin.attributes.status_title') }}</th>
                            <th width="20%">{{ trans('labels.options') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!count($data))
                            <tr>
                                <td colspan="5">{{ trans('labels.no_data') }}</td>
                            </tr>
                        @else
                            @foreach($data as $single)
                                <tr class="odd gradeX {{ $single->hashids }}">
                                    {{-- <td><input type="checkbox" class="checkboxes" value="{{ $single->hashids }}"/></td> --}}
                                    <td> {{ $single->name }} </td>
                                    <td> {{ $single->email }} </td>
                                    <td>
                                        <span class="{{ trans('labels.span_classes.'.$single->active) }}">
                                        {{ trans("individuals_admin.status.".$single->active) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-lg btn-group-solid margin-bottom-10">
                                            <button data-toggle="modal" data-target="#main"
                                                    data-href="{{ route('admin.users.individuals.edit', $single->hashids) }}"
                                                    class="btn blue">
                                                <i class="fa fa-edit"></i> {{ trans('labels.edit') }}
                                            </button>
                                            <button data-popout="true" data-token="{{ csrf_token() }}"
                                                    data-id="{{ $single->hashids }}"
                                                    data-hreff="{{ route('admin.users.individuals.destroy', $single->hashids) }}"
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
