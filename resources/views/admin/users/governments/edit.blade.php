<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
        @if(isset($data))
        <i class="fa fa-edit"></i> {{ trans('governments_registeration.headings.edit') }}
        @else
        <i class="fa fa-edit"></i> {{ trans('governments_registeration.headings.create') }}
        @endif
    </h4>
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
                <input type="hidden" value="{{isset($user) ?$user->id : 0}}" name="user_id" />
                <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::text('name', null, ['class' => 'form-control', 'minlength' => '3', 'maxlength' => '255', 'required']) }}
                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="name">{{ trans('governments_registeration.attributes.name') }}
                        <span class="required">*</span></label>
                    <span class="help-block">{{ trans('governments_registeration.attributes.name') }} ....</span>
                </div>
                @if (empty($data))
                <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::email('email', null, ['class' => 'form-control', 'required']) }}
                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="email">{{ trans('governments_registeration.attributes.email') }}
                        <span class="required">*</span></label>
                    <span class="help-block">{{ trans('governments_registeration.attributes.email') }} ....</span>
                </div>
                @else
                @if($user && $user->password)
                     <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::email('oldemail', $data->email, ['class' => 'form-control', 'disabled']) }}
                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="email">{{ trans('governments_registeration.attributes.email') }}
                        <span class="required"></span></label>
                </div>
                
                @else
                <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::email('email', null, ['class' => 'form-control', 'required']) }}
                    <label {{ isset($data) ? 'style=top:0;' : "" }} for="email">{{ trans('governments_registeration.attributes.email') }}
                        <span class="required">*</span></label>
                    <span class="help-block">{{ trans('governments_registeration.attributes.email') }} ....</span>
                </div>
                @endif
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
            class="demo-loading-btn btn blue"><i class="fa fa-check"></i> {{ isset($data) ? trans('labels.save') : trans('labels.just_add') }} </button>
    <button type="button" data-dismiss="modal" class="btn default">{{ trans('labels.cancel') }}</button>
</div>
{{ Form::close() }}