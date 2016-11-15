<div class="clearfix"></div>
<div id="ishaarsLineChart"
     data-label1="{!! trans('reports.labels.taqawel')!!}"
     data-label2="{!! trans('reports.labels.temp_work')!!}"
     data-label3="{!! trans('reports.labels.hajj')!!}"
     data-fromDate="{{$from}}"
     data-toDate="{{$to}}"
     data-custom_action="1"
     style="height: 250px;"></div>
<div class="clearfix"></div>
<div class="col-md-12" style="margin: 20px auto">
    <div class="col-md-4">
        <div class="col-md-2" style="background: #a93535;height: 10px"></div>
        <div class="col-md-10"
             style="color: #a93535;font-weight: 900">{!! trans('reports.labels.taqawel')!!}</div>
    </div>
    <div class="col-md-4">
        <div class="col-md-2" style="background: #98e454;height: 10px"></div>
        <div class="col-md-10"
             style="color: #98e454;font-weight: 900">{!! trans('reports.labels.temp_work') !!}</div>
    </div>
    <div class="col-md-4">
        <div class="col-md-2" style="background: #2692a5;height: 10px"></div>
        <div class="col-md-10"
             style="color: #2692a5;font-weight: 900">{!! trans('reports.labels.hajj') !!}</div>
    </div>
</div>
<div class="clearfix"></div>