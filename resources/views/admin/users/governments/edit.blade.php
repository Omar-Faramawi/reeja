<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('governments_registeration.headings.list') }}</h4>
</div>
@if(isset($data))
    {{ Form::model($data, ['route' => ['admin.users.governments_registeration.update', $data->hashids], 'method' => 'patch', 'id'=>'form']) }}
@else
    {{ Form::open(['route' => 'admin.users.governments_registeration.index', 'id'=>'form']) }}
@endif
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-body">
                <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::text('name', null, ['class' => 'form-control', 'minlength' => '3', 'maxlength' => '255', 'required']) }}
                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="name">{{ trans('governments_registeration.attributes.name') }}
                        <span class="required">*</span></label>
                    <span class="help-block">{{ trans('governments_registeration.attributes.name') }} ....</span>
                </div>
                @if (empty($data))
                <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::email('email', null, ['class' => 'form-control']) }}
                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="email">{{ trans('governments_registeration.attributes.email') }}
                        <span class="required">*</span></label>
                    <span class="help-block">{{ trans('governments_registeration.attributes.email') }} ....</span>
                </div>
                @endif
                <div class="form-group form-md-line-input form-md-floating-label">
                    <label for="labour_office_no">{{ trans('governments_registeration.attributes.hajj') }}
                        <span class="required">*</span></label>
                    <input type="checkbox" name="hajj" value="1"
                           {{ !empty($data->hajj) ? "checked" : "" }} class="make-switch switch-large"
                           data-on-color="success" data-off-color="warning"
                           data-label-icon="fa fa-fullscreen" data-on-text="<i class='fa fa-check'></i>"
                           data-off-text="<i class='fa fa-times'></i>"/>
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