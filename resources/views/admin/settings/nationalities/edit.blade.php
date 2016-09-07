<div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
   <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('nationalities.headings') }}</h4>
</div>
@if(isset($nationality))
{{ Form::model($nationality, ["files"=>"true", 'route' => ['admin.settings.nationalities.update', $nationality->hashids], 'method' => 'patch', 'id'=>'form']) }}
@else
{{ Form::open(['route' => 'admin.settings.nationalities.store', "files"=>"true", 'id'=>'form_nationalities']) }}
@endif
<div class="modal-body">
   <div class="row">
      <div class="col-sm-12">
         <div class="form-body">
            <div class="form-group form-md-line-input form-md-floating-label">
               <input type="text" name="name" id="name" class="form-control" minlength="3" maxlength="45"
                  value="{{ isset($nationality) ? $nationality->name : old('name') }}" required/>
               <label {{ isset($nationality) ? 'style=top:0;' : "" }} for="name">{{ trans('nationalities.attributes.ar-name') }} <span class="required">*</span></label>
               <span class="help-block">{{ trans('nationalities.attributes.ar-name') }}</span>
            </div>
            <div class="form-group form-md-line-input form-md-floating-label">
               <input type="text" name="eng_name" id="en-name" class="form-control" minlength="3" maxlength="45"
                  value="{{ isset($nationality) ? $nationality->eng_name : old('eng_name') }}" required/>
               <label {{ isset($nationality) ? 'style=top:0;' : "" }} for="eng_name">{{ trans('nationalities.attributes.en-name') }} <span class="required">*</span></label>
               <span class="help-block">{{ trans('nationalities.attributes.en-name') }}</span>
            </div>
            <div class="form-group form-md-line-input form-md-floating-label">
               <input type="text" name="abbr" id="abbr" class="form-control" minlength="3" maxlength="3"
                  value="{{ isset($nationality) ? $nationality->abbr : old('abbr') }}" required/>
               <label  {{ isset($nationality) ? 'style=top:0;' : "" }} for="abbr">{{ trans('nationalities.attributes.abbr-name') }} <span class="required">*</span></label>
               <span class="help-block">{{ trans('nationalities.attributes.abbr-name') }}</span>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal-footer">
   <button type="submit" data-loading-text="{{ trans('labels.loading') }}..." class="demo-loading-btn btn blue"><i class="fa fa-check"></i> {{ trans('labels.save') }} </button>
   @if(empty($nationality))
   <button name='saveandadd' id='save_and_add_more' type="submit" data-loading-text="{{ trans('labels.loading') }}..." class="demo-loading-btn btn blue"><i class="fa fa-check"></i> {{ trans('labels.saveAndAdd') }} </button>
   @endif
   <button type="button" data-dismiss="modal" class="btn default">{{ trans('labels.cancel') }}</button>
</div>
{{ Form::close() }}
