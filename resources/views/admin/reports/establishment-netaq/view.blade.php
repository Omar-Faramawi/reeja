@extends ('admin.layout')
@section('title', trans('labels.reports.invoice_netaq_diff'))

@section('content')
<!-- BEGIN PAGE BASE CONTENT -->
<!-- BEGIN DASHBOARD STATS 1-->

<div class="row">

    <div class="table-scrollable" id="chartdiv-data">
        <table class="table table-striped table-bordered table-hover table-checkable order-column">
            <thead>
            <tr class="odd gradeX">
                <th>#</th>
                <th>{{trans('reports.establishment-netaq.est_name')}}</th>
                <th>{{trans('reports.establishment-netaq.est_activity')}}</th>
                <th>{{trans('reports.establishment-netaq.est_netaq_now')}}</th>
                <th>{{trans('reports.establishment-netaq.est_netaq_old')}}</th>
                <th>{{trans('reports.establishment-netaq.est_size')}}</th>

            </tr>
            </thead>
            <tbody>
            @forelse($establishments as $establishment)
                <tr>
                    <td>{{ $establishment->id }}</td>
                    <td>{{ $establishment->name }}</td>
                    <td>{{ $establishment->est_activity }}</td>
                    <td>{{ $establishment->est_nitaq }}</td>
                    <td>{{ $establishment->est_nitaq_old }}</td>
                    <td>{{ $establishment->estSize->name or '' }}</td>
                </tr>
            @empty
                <tr>
                    <td></td>
                    <td>{{ trans('labels.no_data') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforelse

            </tbody>
        </table>
    </div>
            {{ $establishments->render() }}
</div>
<div class="clearfix"></div>
<!-- END DASHBOARD STATS 1-->
<!-- END PAGE BASE CONTENT -->
@endsection
