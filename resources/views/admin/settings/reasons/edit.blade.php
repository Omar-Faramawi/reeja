<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('reasons.headings') }}</h4>
</div>
@if(isset($reason))
    {{ Form::model($reason, ["files"=>"true", 'route' => ['admin.settings.reasons.update', $reason->hashids], 'method' => 'patch', 'id'=>'form']) }}
@else
    {{ Form::open(['route' => 'admin.settings.reasons.store', "files"=>"true", 'id'=>'form_reasons']) }}
@endif
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-body">
                <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::text('reason', null, ['id'=>'name', 'class'=>'form-control', 'minlength'=>'3', 'maxlength'=>'45', 'required'=>'required']) }}
                    <label {{ isset($reason) ? 'style=top:0;' : "" }} for="name">{{ trans('reasons.attributes.reason') }}
                        <span class="required">*</span></label>
                    <span class="help-block">{{ trans('reasons.attributes.reason') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group form-md-line-input form-md-floating-label">
        {{ Form::select('parent_id', isset($reasons) ? $reasons : array(), null, ['id'=>'parent_id', 'class'=>'form-control bs-select', 'placeholder'=>trans('reasons.select')]) }}
    </div>
</div>
<div class="modal-footer">
    <button name='save' id='save' type="submit" data-loading-text="{{ trans('labels.loading') }}..."
            class="demo-loading-btn btn blue"><i class="fa fa-check"></i> {{ trans('labels.save') }} </button>
    @if(empty($reason))
        <button name='saveandadd' id='save_and_add_more' type="submit"
                data-loading-text="{{ trans('labels.loading') }}..." class="demo-loading-btn btn blue"><i
                    class="fa fa-check"></i> {{ trans('labels.saveAndAdd') }} </button>
    @endif
    <button type="button" data-dismiss="modal" class="btn default">{{ trans('labels.cancel') }}</button>
</div>
{{ Form::close() }}