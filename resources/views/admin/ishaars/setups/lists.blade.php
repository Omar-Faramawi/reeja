@extends ('admin.layout')
@section('title', trans('ishaar_setup.headings.list'))
@section('content')
    <div class="m-heading-1 border-green m-bordered">
        <h3> {{ trans('ishaar_setup.headings.list') }} </h3>
        <p> {{ trans('ishaar_setup.sub-headings.list') }} </p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings"></i>
                        <span class="caption-subject bold uppercase"> {{ trans('ishaar_setup.headings.list') }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6 pull-right">
                                <div class="btn-group pull-right">
                                    <a href="{{ route('admin.ishaar_setup.create') }}" class="btn sbold green">
                                        {{ trans('labels.add') }} <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover order-column">
                            <thead>
                            <tr class="odd gradeX">
                                {{-- <th width="5%" class="table-checkbox"></th> --}}
                                <th>{{ trans('ishaar_setup.attributes.ishaar_name') }}</th>
                                <th>{{ trans('ishaar_setup.attributes.amount') }}</th>
                                <th>{{ trans('ishaar_setup.attributes.payment_period') }}</th>
                                <th>{{ trans('ishaar_setup.attributes.regions') }}</th>
                                <th width="20%">{{ trans('labels.options') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $single)
                                <tr class="odd gradeX {{ $single->hashids }}">
                                    {{-- <td><input type="checkbox" class="checkboxes" value="{{ $single->hashids }}"/></td> --}}
                                    <td> {{ $single->name }} </td>
                                    <td> {{ $single->amount }} {{ trans('ishaar_setup.attributes.currency') }}</td>
                                    <td> {{ $single->payment_period }} {{ trans('ishaar_setup.attributes.day') }} </td>
                                    <td> {{ implode( '- ', $single->regions->pluck('name')->toArray() ) }} </td>
                                    <td>
                                        <div class="btn-group btn-group-lg btn-group-solid margin-bottom-10">
                                            <a href="{{ route('admin.ishaar_setup.edit', $single->hashids) }}" class="btn blue">
                                                <i class="fa fa-edit"></i> {{ trans('labels.edit') }}
                                            </a>
                                            <a class="btn green" href="{{ url('/admin/ishaarPermissions/'.$single->hashids.'/edit') }}">{{ trans('ishaar_setup.edit_permission') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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