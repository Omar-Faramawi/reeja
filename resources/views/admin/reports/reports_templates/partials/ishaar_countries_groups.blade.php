<div class="row">
    <h4 class="text-center text-info">
        {{trans('reports.ishaars_country_chart')}}
    </h4>
    <div class="col-md-12">
        <div id="ishaars_country_chart"
             data-href="{{route('admin.reports.countriesIshaarsData', ['chartOrValue' => '4chart'])}}"
             data-value="statusValue"
             data-title="statusName"
             data-fromDate="{{$from}}"
             data-toDate="{{$to}}"
             data-custom_action="1"
             data-source="sourceField" data-token="{{csrf_token()}}"
             data-action="{{route('admin.reports.countriesIshaarsData', ['chartOrValue' => '4table'])}}"
             data-results_id="ishaars_countries_data" class="chartdiv">
        </div>
    </div>
    <div id="ishaars_countries_data" class="table-scrollable col-md-12" style="display: none;">
        <table class="table table-striped table-bordered table-hover table-checkable order-column">
            <thead>
            <tr class="odd gradeX">
                <th>#</th>
                <th>{{trans('reports.labels.laborer_name')}}</th>
                <th>{{trans('reports.labels.job')}}</th>
                <th>{{trans('reports.labels.nationality')}}</th>
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
            </tr>
            </tbody>
        </table>
    </div>
</div>