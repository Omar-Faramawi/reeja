<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('regions.headings.list') }}</h4>
</div>
@if(isset($data))
    {{ Form::model($data, ['route' => ['admin.regions.update', $data->hashids], 'method' => 'patch', 'id'=>'form']) }}
@else
    {{ Form::open(['route' => 'admin.regions.store', "files"=>"true", 'id'=>'form']) }}
@endif
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-body">
                <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::text("name", null, ["id" => "name", "class" => "form-control",  "minlength" => "3", "maxlength" => "255", "required" => "" ]) }}
                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="name">{{ trans('regions.attributes.name') }}
                        <span class="required">*</span></label>
                    <span class="help-block">{{ trans('regions.attributes.name') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" data-loading-text="{{ trans('labels.loading') }}..."
            class="demo-loading-btn btn blue"><i class="fa fa-check"></i> {{ trans('labels.save') }} </button>
    <button type="button" data-dismiss="modal" class="btn default">{{ trans('labels.cancel') }}</button>
</div>
{{ Form::close() }}