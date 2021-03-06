@extends ('admin.layout')
@section('title', trans('saudi_percentage.headings.list'))
@section('content')
<div class="m-heading-1 border-green m-bordered">
    <h3> {{ trans('saudi_percentage.headings.list') }} </h3>
    <p> {{ trans('saudi_percentage.sub-headings.list') }} </p>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i>
                    <span class="caption-subject bold uppercase"> {{ trans('saudi_percentage.headings.list') }}</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6 pull-right">
                            <div class="btn-group pull-right">
                                <button data-toggle="modal" data-target="#main"
                                        data-href="{{ route('admin.saudi_percentage.create') }}"
                                        class="btn sbold green"> {{ trans('labels.add') }}
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover order-column">
                        <thead>
                        <tr class="odd gradeX">
                            {{-- <th width="5%" class="table-checkbox"></th> --}}
                            <th width="15%">{{ trans('saudi_percentage.attributes.provider_activity') }}</th>
                            <th width="15%">{{ trans('saudi_percentage.attributes.benf_activity') }}</th>
                            <th width="15%">{{ trans('saudi_percentage.attributes.provider_size') }}</th>
                            <th width="15%">{{ trans('saudi_percentage.attributes.benf_size') }}</th>
                            <th width="15%">{{ trans('saudi_percentage.attributes.name') }}</th>
                            <th width="20%">{{ trans('labels.options') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($data))
                        @foreach($data as $single)

                            <tr class="odd gradeX {{ $single->hashids }}">
                                {{-- <td><input type="checkbox" class="checkboxes" value="{{ $single->hashids }}"/></td> --}}
                                <td> {{ $activities[$single->provider_activity_id] }} </td>
                                <td> {{ $activities[$single->benf_activity_id] }} </td>
                                <td> {{ $sizes[$single->provider_size_id] }} </td>
                                <td> {{ $sizes[$single->benf_size_id] }} </td>
                                <td> {{ $single->saudi_pct }} %</td>
                                <td>
                                    <div class="btn-group btn-group-lg btn-group-solid margin-bottom-10">
                                        <button data-toggle="modal" data-target="#main"
                                                data-href="{{ route('admin.saudi_percentage.edit', $single->hashids) }}"
                                                class="btn blue">
                                            <i class="fa fa-edit"></i> {{ trans('labels.edit') }}
                                        </button>
                                        <button data-popout="true" data-token="{{ csrf_token() }}"
                                                data-id="{{ $single->hashids }}"
                                                data-hreff="{{ route('admin.saudi_percentage.destroy', $single->hashids) }}"
                                                class="btn red-mint delete-ajax" data-toggle="confirmation"
                                                data-original-title="{{ trans('labels.delete_confirmation_message') }}"
                                                data-placement="top" data-btn-ok-label="{{ trans('labels.delete') }}"
                                                data-btn-cancel-label="{{ trans('labels.cancel') }}">
                                            <i class="fa fa-trash-o"></i> {{ trans('labels.delete') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @else
                            <tr><td colspan="6" class="text-center">{{ trans('labels.no_data') }}</td></tr>
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
