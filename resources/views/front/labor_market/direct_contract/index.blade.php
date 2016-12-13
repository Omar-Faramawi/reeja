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
                    @if(auth()->user()->user_type_id == Constants::USERTYPES['saudi'])
                    <div class="col-md-12">
                        <label for="gender">{{ trans('temp_job.service_type') }}</label>
                        {{ Form::select('service_type', Constants::directServiceTypes(['file' => 'temp_job']), [session()->get('service_type')], ['class' => 'form-control form-filter input-sm bs-select', 'id' => 'service-provider-select', 'data-route' => route('direct_hiring.contracts') , 'placeholder' => trans('labels.default')]) }}
                    </div>
                    @endif
                </div>
                <br><br>
                <div class="row">
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
                                                <th>{{ trans('temp_job.the_job_owner') }}</th>
                                            @else
                                                <th>{{ trans('temp_job.the_job_seeker') }}</th>
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
                                                        @if($isProvider)
                                                            @if($contract->status == "pending")
                                                                <a type="button"
                                                                    href="{{ url('offersdirect/'.$contract->id) }}"
                                                                    class="btn blue btn-sm">{{ trans('contracts.action_buttons.offer_details') }}</a>
                                                            @endif
                                                        @else
                                                            @if($contract->status == "pending" || $contract->status == "approved")
                                                                <a type="button"
                                                                   href="{{ url('direct-hiring-contract/'.$contract->id.'/edit') }}"
                                                                   class="btn blue btn-sm">{{ trans('tqawel_offer_contract.edit') }}</a>
                                                            @elseif($contract->status == "requested")
                                                                <a type="button"
                                                                   href="{{ url('direct-hiring-contracts/'.$contract->id.'/show') }}"
                                                                   class="btn blue btn-sm">{{ trans('contracts.action_buttons.send_offer') }}</a>
                                                                <a type="button" href="{{ url('direct-hiring-contracts/'.$contract->id.'/reject') }}" class="btn red btn-sm">{{ trans('contracts.action_buttons.reject_request') }}</a>
                                                            @endif
                                                        @endif
                                                        
                                                        <a type="button"
                                                            href="{{ url('contractdetails/'.$contract->id) }}"
                                                            class="btn white btn-sm">{{ trans('temp_job.details') }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center">{{ trans('labels.no_data') }}</td>
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