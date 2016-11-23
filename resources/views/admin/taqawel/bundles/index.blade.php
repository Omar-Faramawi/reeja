@extends ('admin.layout')
@section('title', trans('bundles.headings'))
@section('content')
    <!-- BEGIN BREADCRUMBS -->
    <div class="breadcrumbs">
        <h1>{{ trans('contractnature.headings.taqawel') }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('admin') }}">{{trans('user.home')}}</a>
            </li>
            <li class="active">{{ trans('bundles.headings') }}</li>
        </ol>
    </div>
    <!-- END BREADCRUMBS -->
    <!-- BEGIN PAGE BASE CONTENT -->
    <div class="m-heading-1 border-green m-bordered">
        <h3> {{ trans('bundles.headings') }} </h3>
        <p> {{ trans('bundles.sub-headings') }} </p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings"></i>
                        <span class="caption-subject bold uppercase"> {{ trans('bundles.headings') }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6 pull-right">
                                <div class="btn-group pull-right">
                                    <button data-toggle="modal" data-target="#main"
                                            data-href="{{ route('admin.bundles.create') }}"
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
                                <th width="5%">{{ trans('bundles.attributes.id') }}</th>
                                <th>{{ trans('bundles.attributes.min_of_num_ishaar') }}</th>
                                <th>{{ trans('bundles.attributes.max_of_num_ishaar') }}</th>
                                <th>{{ trans('bundles.attributes.monthly_amount') }}</th>
                                <th width="20%">{{ trans('labels.options') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bundles as $bundle)
                                <tr class="odd gradeX {{ $bundle->hashids }}">
                                    <td>{{ $bundle->id }}</td>
                                    <td>{{ $bundle->min_of_num_ishaar }}</td>
                                    <td>{{ $bundle->max_of_num_ishaar }}</td>
                                    <td>{{ $bundle->monthly_amount }}</td>
                                    <td>
                                        <div class="btn-group btn-group-lg btn-group-solid margin-bottom-10">
                                            <button data-toggle="modal" data-target="#main"
                                                    data-href="{{ route('admin.bundles.edit', $bundle->hashids) }}"
                                                    class="btn blue"><i
                                                        class="fa fa-edit"></i> {{ trans('labels.edit') }}</button>
                                            <button data-popout="true" data-token="{{ csrf_token() }}"
                                                    data-id="{{ $bundle->hashids }}"
                                                    data-hreff="{{ route('admin.bundles.destroy', $bundle->hashids) }}"
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
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row text-right">
                        <div class="col-md-12">{{ $bundles->render() }}</div>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->
    <!-- END PAGE BASE CONTENT -->

@endsection
