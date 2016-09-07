
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
                    <small>{{ trans('tqawel_offer_contract.taqawel-contracts') }}</small></h1>
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
                            <div class="portlet light portlet-fit portlet-form ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class=" icon-layers font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">{{ trans('tqawel_offer_contract.taqawel-contracts') }}</span>
                                    </div>
                                </div>


                                <div class="portlet-body">

                                    @if( !$mycontracts->isEmpty() )
                                        <div class="table-container">
                                            <table class="table table-striped table-bordered table-hover table-checkable">
                                                <thead>
                                                <tr role="row" class="heading">
                                                    <th width="20%">{{ trans('temp_job.benf_id') }}</th>
                                                    <th width="12%">{{ trans('tqawel_offer_contract.email') }}</th>
                                                    <th width="12%">{{ trans('tqawel_offer_contract.mobile') }}</th>
                                                    <th width="12%">{{ trans('tqawel_offer_contract.start_date') }}</th>
                                                    <th width="12%">{{ trans('tqawel_offer_contract.end_date') }}</th>
                                                    <th width="50%">{{ trans('temp_job.details') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($mycontracts as $contract )
                                                    <tr>
                                                        <td>{{ @\Tamkeen\Ajeer\Models\Contract::getName
                                                        ($contract->benf_type, $contract->benf_id) }}</td>
                                                        <td>{{ $contract->responsible_email }}</td>
                                                        <td>{{ $contract->responsible_mobile }}</td>
                                                        <td>{{ $contract->start_date }}</td>
                                                        <td>{{ $contract->end_date }}</td>
                                                        <td>
                                                            @if(session()->get('service_type') == Constants::SERVICETYPES['provider'])
                                                                <a type="button" href="{{ url('taqawel/offer-taqawel-contract/'.$contract->id.'/edit') }}" class="btn blue btn-sm">{{ trans('tqawel_offer_contract.edit') }}</a>
                                                            @endif
                                                            @if($contract->status == "pending" || $contract->status == "approved")
                                                                <a type="button" href="{{ url('taqawel/offer-taqawel-contract/'.$contract->id.'/cancel') }}" class="btn red btn-sm">{{ trans('temp_job.reset') }}</a>
                                                            @elseif((session()->get('service_type') == Constants::SERVICETYPES['provider'] && $contract->status == "provider_cancel") || (session()->get('service_type') == Constants::SERVICETYPES['benf'] && $contract->status == "benef_cancel"))
                                                                <button type="button" data-hreff="{{ url('taqawel/offer-taqawel-contract/'.$contract->id.'/cancel_reset') }}" data-token="{{ csrf_token() }}" data-loading-text="{{ trans('labels.loading') }}..." class="btn red btn-sm cancel_reset">{{ trans('contracts.reset_back') }}</button>
                                                            @elseif(session()->get('service_type') == Constants::SERVICETYPES['provider'] && $contract->status == "benef_cancel")
                                                                <a type="button" href="{{ url('taqawel/contracts/cancellation/provider/'.$contract->id) }}" class="btn red btn-sm">{{ trans('contracts.action_buttons.process_cancel_request') }}</a>
                                                            @elseif(session()->get('service_type') == Constants::SERVICETYPES['benf'] && $contract->status == "provider_cancel")
                                                                <a type="button" href="{{ url('taqawel/contracts/cancellation/beneficial/'.$contract->id) }}" class="btn red btn-sm">{{ trans('contracts.action_buttons.process_cancel_request') }}</a>
                                                            @endif
                                                            <a type="button" href="{{ url('taqawel/offer-taqawel-contract/'.$contract->id.'/details') }}" class="btn white btn-sm">{{ trans('temp_job.details') }}</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <h5 class="portlet-title page-title-heading">{{ trans('labels.no_data') }}</h5>
                                    @endif
                                </div>
                            </div>

                    </div>


                </div>

            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT BODY -->
    <!-- END CONTENT BODY -->

@endsection