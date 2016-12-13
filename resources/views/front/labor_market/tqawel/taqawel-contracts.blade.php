@extends('front.layout')
@section('title', trans('tqawel_offer_contract.taqawel-contracts'))
@section('content')
        <!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('labels.system_name') }}
                <small>{{ trans('tqawel_offer_contract.taqawel-contracts') }}</small>
            </h1>
        </div>
        <!-- END PAGE TITLE -->
    </div>
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE CONTENT BODY -->
<div class="page-content">
    <div class="container">

        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="col-md-12">
                    <label for="gender">{{ trans('temp_job.service_type') }}</label>
                    {{ Form::select('service_type', Constants::serviceTypes(['file' => 'temp_job']), [session()->get('service_type')], ['class' => 'form-control form-filter input-sm bs-select', 'id' => 'service-provider-select', 'data-route' => route('taqawel.contracts') , 'placeholder' => trans('labels.default')]) }}
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>{{ trans('tqawel_offer_contract.taqawel-contracts') }} </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th> #</th>
                                        @if($isProvider)
                                            <th width="15%">{{ trans('temp_job.benf_id') }}</th>
                                        @else
                                            <th width="15%">{{ trans('temp_job.provider_id') }}</th>
                                        @endif
                                        <th>{{ trans('tqawel_offer_contract.email') }}</th>
                                        <th>{{ trans('tqawel_offer_contract.mobile') }}</th>
                                        <th>{{ trans('tqawel_offer_contract.start_date') }}</th>
                                        <th>{{ trans('tqawel_offer_contract.end_date') }}</th>
                                        <th>{{ trans('contracts.status') }}</th>
                                        <th width="25%">{{ trans('temp_job.details') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($mycontracts->count())
                                        @foreach($mycontracts as $contract )
                                            <tr>
                                                <td>{{ $contract->id }}</td>
                                                @if($isProvider)
                                                    <td>{{ @$contract->benf_name }}</td>
                                                @else
                                                    <td>{{ @$contract->provider_name }}</td>
                                                @endif
                                                <td>{{ $contract->responsible_email }}</td>
                                                <td>{{ $contract->responsible_mobile }}</td>
                                                <td>{{ $contract->start_date }}</td>
                                                <td>{{ $contract->end_date }}</td>
                                                <td>{{ trans('contracts.statuses.'.$contract->status) }}</td>
                                                <td>
                                                    @if($isProvider)
                                                        @if($contract->status == "requested")
                                                            <a type="button"
                                                               href="{{ url('taqawel/offer-taqawel-contract/'.$contract->id.'/edit') }}"
                                                               class="btn blue btn-sm">{{ trans('tqawel_offer_contract.offer_contract') }}</a>
                                                            <a type="button" href="{{ url('taqawel/offer-taqawel-contract/'.$contract->id.'/reject') }}" class="btn red btn-sm">{{ trans('tqawel_offer_contract.reject') }}</a>
                                                        @elseif($contract->status == "provider_cancel")
                                                            <button type="button"
                                                                    data-hreff="{{ url('taqawel/offer-taqawel-contract/'.$contract->id.'/cancel_reset') }}"
                                                                    data-token="{{ csrf_token() }}"
                                                                    data-loading-text="{{ trans('labels.loading') }}..."
                                                                    class="btn red btn-sm cancel_reset">{{ trans('contracts.reset_back') }}</button>
                                                        @elseif($contract->status == "benef_cancel")
                                                            <a type="button"
                                                               href="{{ url('taqawel/contracts/cancellation/provider/'.$contract->id) }}"
                                                               class="btn red btn-sm">{{ trans('contracts.action_buttons.process_cancel_request') }}</a>
                                                        @elseif($contract->status == "pending" || $contract->status == "approved")
                                                            <a type="button"
                                                               href="{{ url('taqawel/offer-taqawel-contract/'.$contract->id.'/edit') }}"
                                                               class="btn blue btn-sm">{{ trans('tqawel_offer_contract.edit') }}</a>
                                                            <button type="button" class="btn btn-primary btn-danger btn-sm" data-toggle="modal" data-target="#taqawelModal" data-contract_id="{{$contract->id}}">{{ trans('contracts.reset') }}</button>
                                                            @include('components.modal', ['id' => 'taqawelModal', 'title' => trans('contracts.rejection_reason'), 'content' => 'front.contracts.partials.change-status', 'route' => 'contracts.update_status', 'dataUrl' => route('taqawel.contracts') ])
                                                        @endif
                                                    @else
                                                        @if($contract->status == "provider_cancel")
                                                            <a type="button"
                                                               href="{{ url('taqawel/contracts/cancellation/beneficial/'.$contract->id) }}"
                                                               class="btn red btn-sm">{{ trans('contracts.action_buttons.process_cancel_request') }}</a>
                                                        @elseif($contract->status == "benef_cancel")
                                                            <button type="button"
                                                                    data-hreff="{{ url('taqawel/offer-taqawel-contract/'.$contract->id.'/cancel_reset') }}"
                                                                    data-token="{{ csrf_token() }}"
                                                                    data-loading-text="{{ trans('labels.loading') }}..."
                                                                    class="btn red btn-sm cancel_reset">{{ trans('contracts.reset_back') }}</button>
                                                        @elseif($contract->status == "approved")
                                                            <button type="button" class="btn btn-primary btn-danger btn-sm" data-toggle="modal" data-target="#taqawelModal" data-contract_id="{{$contract->id}}">{{ trans('contracts.reset') }}</button>
                                                            @include('components.modal', ['id' => 'taqawelModal', 'title' => trans('contracts.rejection_reason'), 'content' => 'front.contracts.partials.change-status', 'route' => 'contracts.update_status', 'dataUrl' => route('taqawel.contracts') ])
                                                        @elseif($contract->status == "pending")
                                                            <a type="button"
                                                                href="{{ url('taqawel/offers/'.$contract->id) }}"
                                                                class="btn blue btn-sm">{{ trans('contracts.action_buttons.offer_details') }}</a>
                                                        @endif
                                                    @endif
                                                    <a type="button"
                                                       href="{{ url('taqawel/offer-taqawel-contract/'.$contract->id.'/details') }}"
                                                       class="btn white btn-sm">{{ trans('temp_job.details') }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-left">{{ trans('labels.no_data') }}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="row text-right">
                                <div class="col-md-12">{{ $mycontracts->links() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection