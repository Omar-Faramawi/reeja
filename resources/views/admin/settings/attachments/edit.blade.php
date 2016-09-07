<div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
   <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('attachments.headings') }}</h4>
</div>
@if(isset($attachment))
{{ Form::model($attachment, ["files"=>"true", 'route' => ['admin.settings.attachments.update', $attachment->hashids], 'method' => 'patch', 'id'=>'form']) }}
@else
{{ Form::open(['route' => 'admin.settings.attachments.store', "files"=>"true", 'id'=>'form_attachments']) }}
@endif
<div class="modal-body">
   <div class="row">
      <div class="col-sm-12">
         <div class="form-body">
            <div class="form-group form-md-line-input form-md-floating-label">
			   {{ Form::text('name', null, ['id'=>'name', 'class'=>'form-control', 'minlength'=>'3', 'maxlength'=>'45', 'required'=>'required']) }}
               <label {{ isset($attachment) ? 'style=top:0;' : "" }} for="name">{{ trans('attachments.attributes.ar-name') }} <span class="required">*</span></label>
               <span class="help-block">{{ trans('attachments.attributes.ar-name') }}</span>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal-footer">
   <button name='save' id='save' type="submit" data-loading-text="{{ trans('labels.loading') }}..." class="demo-loading-btn btn blue"><i class="fa fa-check"></i> {{ trans('labels.save') }} </button>
   @if(empty($attachment))
   <button name='saveandadd' id='save_and_add_more' type="submit" data-loading-text="{{ trans('labels.loading') }}..." class="demo-loading-btn btn blue"><i class="fa fa-check"></i> {{ trans('labels.saveAndAdd') }} </button>
   @endif
   <button type="button" data-dismiss="modal" class="btn default">{{ trans('labels.cancel') }}</button>
</div>
{{ Form::close() }}