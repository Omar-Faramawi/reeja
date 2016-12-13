@extends ('admin.layout')
@section('title', trans('reports.'.isset($title) ? $title : 'heading') )
@section('content')
    <!-- BEGIN PAGE BASE CONTENT -->
    <div class="m-heading-1 border-green m-bordered">
        <h3> {{ trans('reports.'.isset($title) ? $title : 'heading') }} </h3>
        <p> {{ trans('reports.'.isset($title) ? $title : 'heading') }} </p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings"></i>
                        <span class="caption-subject bold uppercase"> {{ trans('reports.headings') }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    @if(isset($from) && isset($to))
                    <div class="col-md-4 col-md-offset-4" style="border: 1px solid #eee;padding: 10px;">
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
                    @endif
                    <div class="clearfix"></div>

                    @include('admin.reports.reports_templates.partials.'.$partial)

                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
    </div>
    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->
    <!-- END PAGE BASE CONTENT -->

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/charts.js') }}"></script>
    <script src="{{ asset('assets/js/morris.min.js') }}"></script>
@endsection