@extends ('admin.layout')
@section('title', trans('labels.reports.invoiceNetaqChart'))

@section('content')
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
        <div id="chartdiv" data-href="{{route('netaqChart')}}" data-value="statusValue" data-title="statusName"
             data-source="sourceField" data-token="{{csrf_token()}}"
             data-action="{{url('admin/reports/get-establishment-by-netaq/')}}"
             data-results_id="chartdiv-data" class="chartdiv">
        </div>
    </div>
    <div class="table-scrollable" style="display: none;" id="chartdiv-data">
        <table class="table table-striped table-bordered table-hover table-checkable order-column">
            <thead>
            <tr class="odd gradeX">
                <th>#</th>
                <th>{{trans('reports.establishment-netaq.est_name')}}</th>
                <th>{{trans('reports.establishment-netaq.est_activity')}}</th>
                <th>{{trans('reports.establishment-netaq.est_netaq')}}</th>
                <th>{{trans('reports.establishment-netaq.est_size')}}</th>

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
