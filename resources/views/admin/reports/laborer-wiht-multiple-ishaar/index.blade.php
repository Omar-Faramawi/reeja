@extends ('admin.layout')
@section('title', trans('labels.reports.LaborerWithMultipleIshaars'))
@section('content')
<!-- BEGIN PAGE BASE CONTENT -->
<!-- BEGIN DASHBOARD STATS 1-->
<div class="row">
   <div class="table-scrollable">
      <table class="table table-striped table-bordered table-hover order-column">
         <thead>
            <tr class="odd gradeX">
               <th>{{trans('reports.laborer_name')}}</th>
               <th>{{trans('reports.laborer_id')}}</th>
               <th>{{trans('reports.laborer_provider')}}</th>
               <th>{{trans('reports.laborer_provider_type')}}</th>
            </tr>
         </thead>
         <tbody>
            @if(!count($data))
                <tr><td colspan="4">{{ trans('labels.no_data') }}</td></tr>
            @else
         	@foreach($data as $item)
                <tr class="">
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->nid }}</td>
                  <td>
                    @if(!empty($item->est_name))
                            {{ $item->est_name }}
                    @elseif(!empty($item->ind_name))
                            {{ $item->ind_name }}
                    @elseif(!empty($item->gov_name))
                            {{ $item->gov_name }}
                    @endif
                  </td>
                  <td>{{ \Tamkeen\Ajeer\Utilities\Constants::userTypes()[$item->provider_type] }}</td>
                </tr>
                @endforeach
            @endif
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