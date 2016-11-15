@extends ('admin.layout')
@section('title', trans('labels.reports.ishaarReport'))
@section('content')
<!-- BEGIN BREADCRUMBS -->
<div class="breadcrumbs">
   <h1>{{ trans('labels.reports.ishaarReport') }}</h1>
   <ol class="breadcrumb">
      <li>
         <a href="#">{{trans('user.home')}}</a>
      </li>
      <li class="active">{{ trans('labels.reports.ishaarReport') }}</li>
   </ol>
</div>
<!-- END BREADCRUMBS -->
<!-- BEGIN PAGE BASE CONTENT -->
<!-- BEGIN DASHBOARD STATS 1-->
<div class="row">
   <div class="col-md-12">
      <div class="btn-group bootstrap-select bs-select form-control">
         <button type="button" class="btn dropdown-toggle btn-default btn-success" data-toggle="dropdown" title="Mustard" aria-expanded="false"><span class="filter-option pull-left">
         	{{ Request::segment(4) == 'benf_type' ? trans('reports.benf_name') : trans('reports.provider_name') }}
         </span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>

         <div class="dropdown-menu open" style="max-height: 140px; overflow: hidden; min-height: 0px;">
            <ul class="dropdown-menu inner" role="menu" style="max-height: 138px; overflow-y: auto; min-height: 0px;">
               <li data-original-index="0" class="selected">
               	<a tabindex="0" data-tokens="null" href="{{ route('IshaarReportChart') }}">
               		<span class="text">{{trans('reports.provider_name')}}</span><span class="fa fa-check check-mark"></span>
               	</a>
               </li>
               <li data-original-index="0" class="selected">
               	<a tabindex="0" data-tokens="null" href="{{ route('IshaarReportChart', 'benf_type') }}">
               		<span class="text">{{trans('reports.benf_name')}}</span><span class="fa fa-check check-mark"></span>
               	</a>
               </li>
            </ul>
         </div>
      </div>
   </div>
</div>
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
      <div id="chartdiv" data-href="{{ Request::segment(4) == 'benf_type' ? route('reportChart', 'benf_type') : route('reportChart','provider_type') }}" data-value="statusValue" data-title="statusName"
         data-source="sourceField" data-token="{{csrf_token()}}"
         data-action="{{ Request::segment(4) == 'benf_type' ? url('admin/reports/get-ishaar-by-user-type/benf_type') : url('admin/reports/get-ishaar-by-user-type/provider_type') }}"
         data-results_id="chartdiv-data" class="chartdiv">
      </div>
   </div>
   <div class="table-scrollable" style="display: none;" id="chartdiv-data">
      <table class="table table-striped table-bordered table-hover table-checkable order-column">
         <thead>
            <tr class="odd gradeX">
               <th>#</th>
               <th>{{trans('reports.name')}}</th>
               <th>{{trans('reports.type')}}</th>
               <th>{{trans('reports.part_type')}}</th>
               <th>{{trans('reports.ishaar_type')}}</th>
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