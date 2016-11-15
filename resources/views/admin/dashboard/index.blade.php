@extends ('admin.layout')
@section('title', trans('user.dashboardwidgets'))
@section('content')
        <!-- BEGIN BREADCRUMBS -->
<div class="breadcrumbs">
    <h1>{{ trans('user.dashboardwidgets') }}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#">{{trans('user.home')}}</a>
        </li>
        <li class="active">{{ trans('user.dashboardwidgets') }}</li>
    </ol>
</div>

<div class="row">
    <div class="col-md-4 col-md-offset-4 margin-bottom-10" style="border: 1px solid #eee;padding: 10px;">
        <legend>{{trans('reports.period')}}</legend>
        <div class="col-md-6">
            <div class="form-group ">
                <label for="endDate">{{trans('reports.from')}}</label>
                <input id="startDate" name="startDate" type="datetime" class="date-picker form-control"
                       data-toastr="{{trans('reports.start-date-error')}}"
                       placeholder="{{trans('reports.from')}}" value="{{$from}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group ">
                <label for="endDate">{{trans('reports.to')}}</label>
                <input id="endDate" name="endDate" type="datetime" class="date-picker form-control"
                       data-toastr="{{trans('reports.end-date-error')}}"
                                                           data-toastr-greater="{{trans('reports.end_date_should_be_greater')}}"
                       placeholder="{{trans('reports.to')}}" value="{{$to}}">
            </div>
        </div>
        <input type="hidden" id="js_func" value="{{$js_func}}">
        <input type="hidden" id="charts_ids" value="{{$charts_ids}}">
        <button class="btn btn-info" id="changeDate">{{trans('reports.period_results')}}</button>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i>
                    <span class="caption-subject bold uppercase"> {{ trans('reports.ishaars_types_chart') }}</span>
                </div>
            </div>
            <div class="portlet-body">
                @include('admin.reports.reports_templates.partials.contract_types_ishaars_1')
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i>
                    <span class="caption-subject bold uppercase"> {{ trans('reports.top_ten_ishaars') }}</span>
                </div>
            </div>
            <div class="portlet-body">
                @include('admin.reports.reports_templates.partials.providers_beneficials_activities')
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/charts.js') }}"></script>
    <script src="{{ asset('assets/js/morris.min.js') }}"></script>
@endsection