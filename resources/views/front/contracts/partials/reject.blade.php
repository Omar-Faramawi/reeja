{!! Form::hidden('id', $contract->id) !!}
{!! Form::hidden('status', 'rejected') !!}

<div class="form-group form-md-line-input">
    {!! Form::select('reason_id', $reasons,  null, [ 'placeholder' => trans('labels.enter') . " " . trans('contracts.cancel_reason'), 'class' => 'form-control']) !!}
    <label for="form_control_1">{{ trans('contracts.cancel_reason') }}</label>
    <span class="help-block">{{ trans('contracts.cancel_reason') }}</span>
</div>

<div class="form-group form-md-line-input" style="display:none">
    {!! Form::textarea('rejection_reason', null, [ 'placeholder' => trans('labels.enter') . " " . trans('contracts.reason'), 'class' => 'form-control']) !!}
    <label for="form_control_1">{{ trans('contracts.reason') }}</label>
    <span class="help-block">{{ trans('contracts.reason') }}</span>
</div>

