@extends ('admin.layout')
@section('title', trans('loan_pcnt.headings'))
@section('content')
<!-- BEGIN PAGE BASE CONTENT -->
<div class="m-heading-1 border-green m-bordered">
    <h3> {{ trans('loan_pcnt.headings') }} </h3>
    <p> {{ trans('loan_pcnt.sub-headings') }} </p>
</div>
{{ Form::open(['url'=>url('/admin/loan_pcnt'), 'id'=>'live_form', 'method'=>'PATCH']) }}
<div class="row form-body">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i>
                    <span class="caption-subject bold uppercase"> {{ trans('loan_pcnt.headings') }}</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        @foreach($loan_pcnts as $percentage)
                            <div class="col-md-6 margin-top-15">
                                <div class="form-group form-md-line-input">
                                    {{ Form::number('percentages['.$percentage->id.']', $percentage->pct_hire_labor_tmp_work, ['class'=>'form-control', 'min'=>'0', 'max'=>'100', 'required'=>'required']) }}
                                    <label style='top:0;'>{{ $percentage->name }} <span
                                                class="required">*</span></label>
                                    <span class="help-block">{{ $percentage->name }}....</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-12">
                        <button type="submit" data-loading-text="{{ trans('contract_setup.saving') }}..."
                                class="btn blue">{{trans('contract_setup.save')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
<div class="clearfix"></div>
<!-- END DASHBOARD STATS 1-->
<!-- END PAGE BASE CONTENT -->

@endsection