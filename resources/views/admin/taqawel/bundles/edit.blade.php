<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('bundles.headings') }}</h4>
</div>
@if(isset($bundle))
    {{ Form::model($bundle, ['route' => ['admin.bundles.update', $bundle->hashids], 'method' => 'patch', 'id'=>'form']) }}
@else
    {{ Form::open(['route' => 'admin.bundles.store', "files"=>"true", 'id'=>'form']) }}
@endif
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-body">
                <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::number('min_of_num_ishaar',null, ['id'=>'min_of_num_ishaar', 'class'=>'form-control', 'min'=>'1', 'max'=>PHP_INT_MAX, 'required'=>'required']) }}
                    <label {{ isset($bundle) ? 'style=top:0;' : "" }} for="min_of_num_ishaar">{{ trans('bundles.attributes.min_of_num_ishaar') }}
                        <span class="required">*</span></label>
                    <span class="help-block">{{ trans('bundles.attributes.min_of_num_ishaar') }}....</span>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::number('max_of_num_ishaar',null, ['id'=>'max_of_num_ishaar', 'class'=>'form-control', 'min'=>'1', 'max'=>PHP_INT_MAX, 'required'=>'required']) }}
                    <label {{ isset($bundle) ? 'style=top:0;' : "" }} for="max_of_num_ishaar">{{ trans('bundles.attributes.max_of_num_ishaar') }}
                        <span class="required">*</span></label>
                    <span class="help-block">{{ trans('bundles.attributes.max_of_num_ishaar') }}....</span>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::text('monthly_amount',null, ['id'=>'amount', 'class'=>'form-control', 'min'=>'1', 'max'=>PHP_INT_MAX, 'required'=>'required']) }}
                    <label {{ isset($bundle) ? 'style=top:0;' : "" }} for="no_of_ishaar">{{ trans('bundles.attributes.monthly_amount') }}
                        <span class="required">*</span></label>
                    <span class="help-block">{{ trans('bundles.attributes.monthly_amount') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button name='save' id='save' type="submit" data-loading-text="{{ trans('labels.loading') }}..."
            class="demo-loading-btn btn blue"><i class="fa fa-check"></i> {{ trans('labels.save') }} </button>
    <button type="button" data-dismiss="modal" class="btn default">{{ trans('labels.cancel') }}</button>
</div>
{{ Form::close() }}
