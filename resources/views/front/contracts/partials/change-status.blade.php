{!! Form::hidden('id', $contract->id) !!}
{!! Form::hidden('status', $newStatus) !!}

<div class="form-group form-md-line-input">
    {!! Form::select('reason_id', $reasons,  null, [ 'placeholder' => trans('labels.enter') . " " . trans($reasonLabel),'id' => 'select_reason', 'class' => 'form-control']) !!}
    <span class="help-block">{{ trans($reasonLabel) }}</span>
</div>

<div id="other_reason" class="form-group form-md-line-input" style="display:none">
    {!! Form::text('other_reasons', null, [ 'placeholder' => trans('labels.enter') . " " . trans($reasonLabel), 'class' => 'form-control', 'id' => 'other']) !!}
    <span class="help-block">{{ trans($reasonLabel) }}</span>
</div>

<div class="form-group form-md-line-input">
    {!! Form::textarea('rejection_reason', null, [ 'placeholder' => trans('labels.enter') . " " . trans('contracts.rejection_reasons_details'), 'class' => 'form-control']) !!}
    <span class="help-block">{{ trans('contracts.rejection_reasons_details') }}</span>
</div>

