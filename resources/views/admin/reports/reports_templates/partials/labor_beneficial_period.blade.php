<div class="row">
    <h4 class="text-center text-info">
        {{trans('reports.labor_benf_period')}}
    </h4>
    <div class="table-scrollable col-md-12">
        <table class="table table-striped table-bordered table-hover order-column">
            <thead>
            <tr class="odd gradeX">
                <th>{{trans('reports.labels.laborer_name')}}</th>
                <th>{{trans('reports.benf_name')}}</th>
                <th>{{trans('reports.number_of_consequitive_months')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($over6Months as $record)
            <tr class="">
                <td width="40%">{{$record['info']['emp_name']}}</td>
                <td width="40%">{{$record['info']['benf_name']}}</td>
                <td width="20%">{{$record['period']}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>