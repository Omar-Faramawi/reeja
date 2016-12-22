@extends('front.layout')
@section('title', trans('temp_job.received_contracts'))
@section('content')
<!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('labels.system_name') }}
                <small>{{ trans('temp_job.received_contracts') }}</small>
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
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-layers font-black"></i>
                                <span class="caption-subject font-black sbold uppercase">{{ trans('temp_job.received_contracts') }}</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th> #</th>
                                        <th width="20%">{{ trans('temp_job.benf_id') }}</th>
                                        <th width="14%">{{ trans('tqawel_offer_contract.contract_nature_name') }}</th>
                                        <th width="20%">{{ trans('tqawel_offer_contract.email') }}</th>
                                        <th width="20%">{{ trans('tqawel_offer_contract.mobile') }}</th>
                                        <th width="50%">{{ trans('temp_job.details') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($mycontracts->count())
                                        @foreach($mycontracts as $contract )
                                            <tr>
                                                <td>{{ $contract->id }}</td>
                                                <td>{{ @\Tamkeen\Ajeer\Models\Contract::getName($contract->benf_type, $contract->benf_id) }}</td>
                                                <td>{{ @$contract->contractNature->name }}</td>
                                                <td>{{ @$contract->responsible_email }}</td>
                                                <td>{{ @$contract->responsible_mobile }}</td>
                                                <td>
                                                    <a type="button"
                                                       href="{{ url('taqawel/offer-taqawel-contract/'.$contract->id.'/edit') }}"
                                                       class="btn blue btn-sm">{{ trans('tqawel_offer_contract.offer_contract') }}</a>
                                                    <a type="button"
                                                       href="{{ url('taqawel/offer-taqawel-contract/'.$contract->id.'/reject') }}"
                                                       class="btn red btn-sm">{{ trans('tqawel_offer_contract.reject') }}</a>
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
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection