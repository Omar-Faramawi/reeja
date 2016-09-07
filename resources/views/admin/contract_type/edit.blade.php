<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('contracttype.widgetName') }}</h4>
</div>
@if(isset($contractsTypes))
    {{ Form::model($contractsTypes, ["files"=>"true", 'route' => ['admin.contracttypes.update', $contractsTypes->hashids], 'method' => 'patch', 'id'=>'form']) }}
@else
    {{ Form::open(['route' => 'admin.contracttypes.index', "files"=>"true", 'id'=>'form']) }}
@endif
<div class="modal-body">
    <div class="form-body">
        <div class="row">
            <div class="col-md-5 margin-top-10">
                <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::text('name', null, ['id'=>'name', 'class'=>'form-control', 'required']) }}
                    <label {{ isset($contractsTypes) ? 'style=top:0;' : "" }} for="name">{{ trans('contracttype.formTitle') }}
                        <span class="required">*</span></label>
                    <span class="help-block">{{ trans('contracttype.formTitle') }} ...</span>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

    </div>
</div>
</div>
<div class="modal-footer">
    <button type="submit" data-loading-text="{{ trans('labels.loading') }}..." class="demo-loading-btn btn blue">
        <i class="fa fa-check"></i> {{ trans('labels.save') }} </button>
    <button type="button" data-dismiss="modal" class="btn default">{{ trans('labels.cancel') }}</button>
</div>
{{form::close()}}

