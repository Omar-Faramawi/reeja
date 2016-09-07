<div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
   <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('banks.headings') }}</h4>
</div>
@if(isset($bank))
{{ Form::model($bank, ["files"=>"true", 'route' => ['admin.settings.banks.update', $bank->hashids], 'method' => 'patch', 'id'=>'form']) }}
@else
{{ Form::open(['route' => 'admin.settings.banks.store', "files"=>"true", 'id'=>'form_banks']) }}
@endif
<div class="modal-body">
   <div class="row">
      <div class="col-sm-12">
         <div class="form-body">
            <div class="form-group form-md-line-input form-md-floating-label">
			   {{ Form::text('name', null, ['id'=>'name', 'class'=>'form-control', 'minlength'=>'3', 'maxlength'=>'45', 'required'=>'required']) }}
               <label {{ isset($bank) ? 'style=top:0;' : "" }} for="name">{{ trans('banks.attributes.ar-name') }} <span class="required">*</span></label>
               <span class="help-block">{{ trans('banks.attributes.ar-name') }}</span>
            </div>
			<div class="form-group form-md-line-input form-md-floating-label">
			   <div class='col-sm-6'>
			   @if(isset($bank) && isset($bank->parent_bank_id))
			   @endif
			   {{ Form::radio('type',1,isset($bank) && isset($bank->parent_bank_id) ? false : true,['id'=>'parent']) }}
			   {{ trans('banks.parent') }}
			   </div>
			   <div class='col-sm-6'>
			   {{ Form::radio('type',0,isset($bank) && isset($bank->parent_bank_id) ? true : false,['id'=>'children']) }}
               {{ trans('banks.children') }}
			   </div>
            </div>
			<div class="form-group form-md-line-input form-md-floating-label">
			   {{ Form::select('parent_bank_id', isset($banks) ? $banks : array(), NULL, ['id'=>'parent_bank_id', 'class'=>'form-control', 'style'=> isset($bank) && isset($bank->parent_bank_id) ? '' : 'display:none']) }}
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal-footer">
   <button name='save' id='save' type="submit" data-loading-text="{{ trans('labels.loading') }}..." class="demo-loading-btn btn blue"><i class="fa fa-check"></i> {{ trans('labels.save') }} </button>
   @if(empty($bank))
   <button name='saveandadd' id='save_and_add_more' type="submit" data-loading-text="{{ trans('labels.loading') }}..." class="demo-loading-btn btn blue"><i class="fa fa-check"></i> {{ trans('labels.saveAndAdd') }} </button>
   @endif
   <button type="button" data-dismiss="modal" class="btn default">{{ trans('labels.cancel') }}</button>
</div>
{{ Form::close() }}