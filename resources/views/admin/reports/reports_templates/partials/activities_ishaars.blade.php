<div class="row">
    <h4 class="text-center text-info">
        {{trans('reports.providers')}}
    </h4>
    <div class="col-md-12">
        <div id="top_ten_activities_provider"
             data-href="{{route('admin.reports.activityIshaarsData', ['chartOrValue' => '4chart', 'prvd_benf' => Constants::SERVICETYPES['provider']])}}"
             data-value="statusValue"
             data-title="statusName"
             data-fromDate="{{$from}}"
             data-toDate="{{$to}}"
             data-source="sourceField" data-token="{{csrf_token()}}"
             data-custom_action="1"
             data-action="{{route('admin.reports.activityIshaarsData', ['chartOrValue' => '4table', 'prvd_benf' => Constants::SERVICETYPES['provider']])}}"
             data-results_id="top_ten_activities_provider_table" class="chartdiv">
        </div>
    </div>
    <div id="top_ten_activities_provider_table" class="table-scrollable col-md-12" style="display: none;">
        <table class="table table-striped table-bordered table-hover table-checkable order-column">
            <thead>
            <tr class="odd gradeX">
                <th>#</th>
                <th>{{trans('reports.labels.est_name')}}</th>
                <th>{{trans('reports.labels.activity')}}</th>
                <th>{{trans('reports.labels.nitaq')}}</th>
                <th>{{trans('reports.labels.side_type')}}</th>
                <th>{{trans('reports.labels.ishaar_type')}}</th>
            </tr>
            </thead>
            <tbody>
            <tr class="">
                <td></td>
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
<hr>
<div class="clearfix"></div>
<div class="row">
    <h4 class="text-center text-info">
        {{trans('reports.beneficials')}}
    </h4>
    <div class="col-md-12">
        <div id="top_ten_activities_benef"
             data-href="{{route('admin.reports.activityIshaarsData', ['chartOrValue' => '4chart', 'prvd_benf' => Constants::SERVICETYPES['benf']])}}"
             data-value="statusValue"
             data-title="statusName"
             data-fromDate="{{$from}}"
             data-toDate="{{$to}}"
             data-custom_action="1"
             data-source="sourceField" data-token="{{csrf_token()}}"
             data-action="{{route('admin.reports.activityIshaarsData', ['chartOrValue' => '4table', 'prvd_benf' => Constants::SERVICETYPES['benf']])}}"
             data-results_id="top_ten_activities_benef_table" class="chartdiv">
        </div>
    </div>
    <div id="top_ten_activities_benef_table" class="table-scrollable col-md-12" style="display: none;">
        <table class="table table-striped table-bordered table-hover table-checkable order-column">
            <thead>
            <tr class="odd gradeX">
                <th>#</th>
                <th>{{trans('reports.labels.est_name')}}</th>
                <th>{{trans('reports.labels.activity')}}</th>
                <th>{{trans('reports.labels.nitaq')}}</th>
                <th>{{trans('reports.labels.side_type')}}</th>
                <th>{{trans('reports.labels.ishaar_type')}}</th>
            </tr>
            </thead>
            <tbody>
            <tr class="">
                <td></td>
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