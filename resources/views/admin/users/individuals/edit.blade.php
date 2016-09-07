<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('individuals_admin.headings.list') }}</h4>
</div>
{{ Form::model($data, ['route' => ['admin.users.individuals.update', $data->hashids], 'method' => 'patch', 'id'=>'form']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-body">
                <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::text('name', null, ['readonly', 'class' => 'form-control']) }}
                    <label style='top:0;' for="name">{{ trans('individuals_admin.attributes.name') }}
                        <span class="required">*</span></label>
                    <span class="help-block">{{ trans('individuals_admin.attributes.name') }} ....</span>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::email('email', null, ['readonly', 'class' => 'form-control']) }}
                    <label style='top:0;' for="email">{{ trans('individuals_admin.attributes.email') }}
                        <span class="required">*</span></label>
                    <span class="help-block">{{ trans('individuals_admin.attributes.email') }} ....</span>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label">
                    <label for="labour_office_no">{{ trans('individuals_admin.attributes.status_title') }}
                        <span class="required">*</span></label>
                    <input type="checkbox" name="active" value="1"
                           {{ ($data->active) ? "checked" : "" }} class="make-switch switch-large"
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