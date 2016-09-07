<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('contractnature.widgetName') }}</h4>
</div>
@if(isset($contractNature))
    {{ Form::model($contractNature, ["files"=>"true", 'route' => ['admin.contractnatures.update', $contractNature->hashids], 'method' => 'patch', 'id'=>'form']) }}
@else
    {{ Form::open(['route' => 'admin.contractnatures.index', "files"=>"true", 'id'=>'form']) }}
@endif
<div class="modal-body">
    <div class="form-body">
        <div class="row">
            <div class="col-md-5 margin-top-10">
                <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::text('name', null, ['id'=>'name', 'class'=>'form-control', 'required']) }}
                    <label {{ isset($contractNature) ? 'style=top:0;' : "" }} for="name">{{ trans('contractnature.formTitle') }}
                        <span class="required">*</span></label>
                    <span class="help-block">{{ trans('contractnature.formTitle') }} ...</span>
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

