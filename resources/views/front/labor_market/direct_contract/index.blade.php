@extends('front.layout')
@section('title', trans('contracts.contracts'))
@section('content')

    <!-- BEGIN CONTENT BODY -->
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <div class="container">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>{{ trans('contracts.contracts') }}</h1>
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
                    @if(auth()->user()->user_type_id == \Tamkeen\Ajeer\Utilities\Constants::USERTYPES['saudi'])
                    <div class="col-md-12">
                        <label for="gender">{{ trans('temp_job.service_type') }}</label>
                        {{ Form::select('service_type', Constants::directServiceTypes(['file' => 'temp_job']), [session()->get('service_type')], ['class' => 'form-control form-filter input-sm bs-select', 'id' => 'service-provider-select', 'data-route' => route('direct_hiring.contracts') , 'placeholder' => trans('labels.default')]) }}
                    </div>
                    @endif
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-12">
                    </div>
                    <div class="col-md-12">

                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-cogs"></i>{{ trans('contracts.contracts') }} </div>
                            </div>
                            <div class="portlet-body">

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr role="row" class="heading">
                                            <th>#</th>
                                            @if($isProvider)
                                                <th>{{ trans('temp_job.benf_id') }}</th>
                                            @else
                                                <th>{{ trans('temp_job.provider_id') }}</th>
                                            @endif
                                            <th>{{ trans('temp_job.work_start_date') }}</th>
                                            <th>{{ trans('temp_job.work_end_date') }}</th>
                                            <td>{{ trans('contracts.status') }}</td>
                                            <th>{{ trans('temp_job.details') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($myContracts->count())
                                            @foreach($myContracts as $contract )
                                                <tr>
                                                    <td>{{ $contract->id }}</td>
                                                    @if($isProvider)
                                                        <td>{{ $contract->benf_name }}</td>
                                                    @else
                                                        <td>{{ $contract->provider_name }}</td>
                                                    @endif
                                                    <td>{{ $contract->start_date }}</td>
                                                    <td>{{ $contract->end_date }}</td>
                                                    <td>{{ trans('contracts.statuses.'.$contract->status) }}</td>
                                                    <td>
                                                        @if(!$isProvider && ($contract->status == "pending" || $contract->status == "approved"))
                                                            <a type="button"
                                                               href="{{ url('direct-hiring-contract/'.$contract->id.'/edit') }}"
                                                               class="btn blue btn-sm">{{ trans('tqawel_offer_contract.edit') }}</a>
                                                        @endif
                                                        @if(!$isProvider && $contract->status == "requested")
                                                            <a type="button"
                                                               href="{{ url('direct-hiring-contracts/'.$contract->id.'/show') }}"
                                                               class="btn blue btn-sm">{{ trans('contracts.action_buttons.send_offer') }}</a>
                                                            <a type="button" href="{{ url('direct-hiring-contracts/'.$contract->id.'/reject') }}" class="btn red btn-sm">{{ trans('contracts.action_buttons.reject_request') }}</a>
                                                        @endif
                                                        @if($contract->status == "pending" || $contract->status == "approved")
                                                            <a type="button"
                                                               href="{{ url('contracts/'.$contract->id.'/cancel') }}"
                                                               class="btn red btn-sm">{{ trans('temp_job.reset') }}</a>
                                                        @elseif(($isProvider && $contract->status == "provider_cancel") || (!$isProvider && $contract->status == "benef_cancel"))
                                                            <button type="button"
                                                                    data-hreff="{{ url('contracts/'.$contract->id.'/cancel_reset') }}"
                                                                    data-token="{{ csrf_token() }}"
                                                                    data-loading-text="{{ trans('labels.loading') }}..."
                                                                    class="btn red btn-sm cancel_reset">{{ trans('contracts.reset_back') }}</button>
                                                        @elseif($isProvider && $contract->status == "benef_cancel")
                                                            <a type="button"
                                                               href="{{ url('contracts/cancellation/provider/'.$contract->id) }}"
                                                               class="btn red btn-sm">{{ trans('contracts.action_buttons.process_cancel_request') }}</a>
                                                        @elseif(!$isProvider && $contract->status == "provider_cancel")
                                                            <a type="button"
                                                               href="{{ url('contracts/cancelation/beneficial/'.$contract->id) }}"
                                                               class="btn red btn-sm">{{ trans('contracts.action_buttons.process_cancel_request') }}</a>
                                                        @endif
                                                        <a type="button"
                                                           href="{{ url('contractdetails/'.$contract->id) }}"
                                                           class="btn white btn-sm">{{ trans('temp_job.details') }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-left">{{ trans('labels.no_data') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>

                                    </table>
                                </div>

                                <div class="row text-right">
                                    <div class="col-md-12">{{ $myContracts->render() }}</div>
                                </div>

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