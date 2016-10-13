<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('establishments_registration.headings.list') }}</h4>
</div>
{{ Form::open(['route' => 'admin.users.establishments_registeration.index', 'id'=>'form']) }}
<div class="modal-body" data-success_data="{{ trans('establishments_registration.success_data') }}" data-no_data="{{ trans('establishments_registration.no_data') }}">
    <div class="row">
        <div class="form-body">
            <div class="col-md-12 padding-tb-10">
                <div class="col-md-6">
                    <div class="form-group form-md-line-input form-md-floating-label">
                        {{ Form::number('labour_office_no', null, ['class' => 'form-control', 'id' => 'labour_office_no']) }}
                        <label for="labour_office_no">{{ trans('establishments_registration.attributes.labour_office_no') }}
                            <span class="required">*</span></label>
                        <span class="help-block">{{ trans('establishments_registration.attributes.labour_office_no') }}
                            ....</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-md-line-input form-md-floating-label">
                        {{ Form::number('sequence_no', null, ['class' => 'form-control', 'id' => 'sequence_no']) }}
                        <label for="sequence_no">{{ trans('establishments_registration.attributes.sequence_no') }}
                            <span class="required">*</span></label>
                        <span class="help-block">{{ trans('establishments_registration.attributes.sequence_no') }}
                            ....</span>
                    </div>
                </div>
                <div class="col-md-6 margin-top-10">
                    <div class="form-group form-md-line-input form-md-floating-label">
                        {{ Form::number('id_number', null, ['class' => 'form-control', 'id' => 'id_number']) }}
                        <label for="id_number">{{ trans('establishments_registration.attributes.id_number') }}
                        <span class="required">*</span></label>
                        <span class="help-block">{{ trans('establishments_registration.attributes.id_number') }}
                            ....</span>
                    </div>
                </div>
                <div class="col-md-1 no-padding margin-top-20">
                    <button id="mol_search_co" aria-label="Left Align" class="btn green" type="button">
                        <span aria-hidden="true" class="glyphicon glyphicon-search"></span>
                    </button>
                </div>
            </div>
            <div class="col-md-12 padding-tb-10">
                <div class="col-md-4 margin-bottom-5">
                    {{ Form::text('name', null, ['id' => 'name', 'class' => 'form-control', 'readonly', 'placeholder' => trans('establishments_registration.attributes.name')]) }}
                </div>
                <div class="col-md-4 margin-bottom-5">
                    {{ Form::text('est_activity', null, ['id' => 'est_activity', 'class' => 'form-control', 'readonly', 'placeholder' => trans('establishments_registration.attributes.est_activity')]) }}
                </div>
                <div class="col-md-4 margin-bottom-5">
                    {{ Form::text('est_size', null, ['id' => 'est_size', 'class' => 'form-control', 'readonly', 'placeholder' => trans('establishments_registration.attributes.est_size')]) }}
                </div>
                <div class="col-md-4 margin-bottom-5">
                    {{ Form::text('est_nitaq', null, ['id' => 'est_nitaq', 'class' => 'form-control', 'readonly', 'placeholder' => trans('establishments_registration.attributes.est_nitaq')]) }}
                </div>
                <div class="col-md-4 margin-bottom-5">
                    {{ Form::text('district', null, ['id' => 'district', 'class' => 'form-control', 'readonly', 'placeholder' => trans('establishments_registration.attributes.district')]) }}
                </div>
                <div class="col-md-4 margin-bottom-5">
                    {{ Form::text('city', null, ['id' => 'city', 'class' => 'form-control', 'readonly', 'placeholder' => trans('establishments_registration.attributes.city')]) }}
                </div>
                <div class="col-md-4 margin-bottom-5">
                    {{ Form::text('region', null, ['id' => 'region', 'class' => 'form-control', 'readonly', 'placeholder' => trans('establishments_registration.attributes.region')]) }}
                </div>
                <div class="col-md-4 margin-bottom-5">
                    {{ Form::text('wasel_address', null, ['id' => 'wasel_address', 'class' => 'form-control', 'readonly', 'placeholder' => trans('establishments_registration.attributes.wasel_address')]) }}
                </div>
                <div class="col-md-4 margin-bottom-5">
                    {{ Form::text('local_liecense_no', null, ['id' => 'local_liecense_no', 'class' => 'form-control', 'readonly', 'placeholder' => trans('establishments_registration.attributes.local_liecense_no')]) }}
                </div>
                <div class="col-md-4 margin-bottom-5">
                    {{ Form::text('phone', null, ['id' => 'phone', 'class' => 'form-control', 'readonly', 'placeholder' => trans('establishments_registration.attributes.phone')]) }}
                </div>
            </div>
            <div class="col-md-12 padding-tb-10">
                <div class="col-md-6">
                    <div class="form-group form-md-line-input form-md-floating-label">
                        {{ Form::email('email', null, ['class' => 'form-control']) }}
                        <label for="email">{{ trans('establishments_registration.attributes.email') }}
                            <span class="required">*</span></label>
                        <span class="help-block">{{ trans('establishments_registration.attributes.email') }} ....</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-md-line-input form-md-floating-label">
                        {{ Form::number('branch_no', null, ['class' => 'form-control']) }}
                        <label for="branch_no">{{ trans('establishments_registration.attributes.branch_no') }}</label>
                        <span class="help-block">{{ trans('establishments_registration.attributes.branch_no') }}
                            ....</span>
                    </div>
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
