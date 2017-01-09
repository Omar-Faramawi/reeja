{!! Form::hidden('id', $contract->id) !!}
@if(@$contract->status == "pending" && @$newStatus == 'provider_cancel')
    {!! Form::hidden('status', 'cancelled') !!}
@else
    {!! Form::hidden('status', isset($newStatus) ? $newStatus : $status) !!}
@endif

<div class="form-group form-md-line-input">
    {!! Form::select('reason_id', $reasons,  null, [ 'placeholder' => trans('labels.enter') . " " . trans($reasonLabel),'id' => 'select_reason', 'class' => 'form-control']) !!}
    <span class="help-block">{{ trans($reasonLabel) }}</span>
</div>

<div id="other_reason" class="form-group form-md-line-input" style="display:none">
    {!! Form::text('', null, [ 'placeholder' => trans('labels.enter') . " " . trans($reasonLabel), 'class' => 'form-control', 'id' => 'other', 'data-name' => 'other_reasons']) !!}
    <span class="help-block">{{ trans($reasonLabel) }}</span>
</div>

<div class="form-group form-md-line-input">
    {!! Form::textarea('rejection_reason', null, [ 'placeholder' => trans('labels.enter') . " " . trans('contracts.rejection_reasons_details'), 'class' => 'form-control']) !!}
    <span class="help-block">{{ trans('contracts.rejection_reasons_details') }}</span>
</div>

@if(isset($showTqawelCancelDisclaimers))
<div class="well">
    {!! trans('endorsements.offer_taqawel_contract_cancel_'.$contract->byMeOrToMe(), ['contract_number' => $contract->id, 'start_date' => $contract->start_date, 'now' => date('Y-m-d', time()), 'contract_period' => getDatesDiff($contract->start_date, $contract->end_date), 'pevd_benf_name' => $contract->byMeOrToMe() ? $contract->benf_name : $contract->providername]) !!}
</div>
@endif