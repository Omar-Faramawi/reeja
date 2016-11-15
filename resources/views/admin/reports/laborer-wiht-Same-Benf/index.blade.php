@extends ('admin.layout')
@section('title', trans('labels.reports.LaborerWithMultipleIshaars'))
@section('content')
<!-- BEGIN BREADCRUMBS -->
<div class="breadcrumbs">
   <h1>{{ trans('labels.reports.LaborerWithSameBenf') }}</h1>
   <ol class="breadcrumb">
      <li>
         <a href="#">{{trans('user.home')}}</a>
      </li>
      <li class="active">{{ trans('labels.reports.mainTitle') }}</li>
   </ol>
</div>
<!-- END BREADCRUMBS -->
<!-- BEGIN PAGE BASE CONTENT -->
<!-- BEGIN DASHBOARD STATS 1-->
<div class="row">
   <div class="table-scrollable">
      <table class="table table-striped table-bordered table-hover order-column">
         <thead>
            <tr class="odd gradeX">
               <th>{{trans('reports.laborer_name')}}</th>
               <th>{{trans('reports.laborer_id')}}</th>
               <th>{{trans('reports.laborer_benf')}}</th>
               <th>{{trans('reports.laborer_period')}}</th>
            </tr>
         </thead>
         <tbody>
            @if(!count($data))
                <tr><td colspan="4">{{ trans('labels.no_data') }}</td></tr>
            @else
         	@foreach($data as $item)
                <tr class="">
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->id_number }}</td>
                  <td>
                    @if(!empty($item->est_name))
                            {{ $item->est_name }}
                    @elseif(!empty($item->ind_name))
                            {{ $item->ind_name }}
                    @elseif(!empty($item->gov_name))
                            {{ $item->gov_name }}
                    @endif
                  </td>
                  <td>{{ $item->period }}</td>
                </tr>
                @endforeach
            @endif
         </tbody>
      </table>
   </div>
    <div class="row text-right">
                        <div class="col-md-12"></div>
                    </div>
</div>
<div class="clearfix"></div>
<!-- END DASHBOARD STATS 1-->
<!-- END PAGE BASE CONTENT -->
@endsection
@section('scripts')
<script src="{{ asset('assets/js/charts.js') }}"></script>
@endsection