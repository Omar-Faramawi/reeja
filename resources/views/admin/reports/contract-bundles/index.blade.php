@extends ('admin.layout')
@section('title', trans('contract_bundle_reports.heading'))
@section('content')
        <!-- BEGIN BREADCRUMBS -->
<div class="breadcrumbs">
    <h1>{{ trans('contract_bundle_reports.heading') }}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#">{{trans('user.home')}}</a>
        </li>
        <li class="active">{{ trans('contract_bundle_reports.heading') }}</li>
    </ol>
</div>
<!-- END BREADCRUMBS -->
<!-- BEGIN PAGE BASE CONTENT -->
<!-- BEGIN DASHBOARD STATS 1-->

<div class="row">
    <div class="col-md-12">
        <div class="form-group ">
            <input id="startDate" name="startDate" type="datetime" class="date-picker"
                   data-toastr="{{trans('reports.start-date-error')}}" placeholder="{{trans('reports.start-date')}}">
            <input id="endDate" name="endDate" type="datetime" class="date-picker"
                   data-toastr="{{trans('reports.end-date-error')}}" data-toastr-greater="{{trans('reports.end_date_should_be_greater')}}" placeholder="{{trans('reports.end-date')}}">
            <button class="btn btn-default" id="changeDate">{{trans('reports.changedate')}}</button>
            <button class="btn btn-default" id="showAll">{{trans('reports.showAll')}}</button>
        </div>

        <div id="packages-contracts" data-href="{{route('reports.packages.chart')}}" data-value="bundleValue" data-title="bundleName"
             data-source="sourceField" data-token="{{csrf_token()}}" data-action="{{url('admin/reports/packages/contracts-by-package/')}}"
             data-results_id="packages-contracts-data" class="chartdiv">
        </div>
    </div>

    <div class="table-scrollable" style="display: none;" id="packages-contracts-data">
        <table class="table table-striped table-bordered table-hover order-column">
            <thead>
            <tr class="odd gradeX">
                <th>#</th>
                <th>{{trans('reports.provider_name')}}</th>
                <th>{{trans('reports.benf_name')}}</th>
                <th>{{trans('reports.bundle_name')}}</th>
                <th>{{trans('reports.contract_status')}}</th>
            </tr>
            </thead>
            <tbody>
            <tr class="">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="clearfix"></div>
<!-- END DASHBOARD STATS 1-->
<!-- END PAGE BASE CONTENT -->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/charts.js') }}"></script>
@endsection
