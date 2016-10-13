@extends('front.layout')
@section('title', trans('temp_job.labor_market'))
@section('content')

    <!-- BEGIN CONTENT BODY -->
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <div class="container">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>{{ trans('labels.system_name') }}
                    <small>{{ trans('temp_job.labor_market') }}</small>
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
                        <!-- Begin: life time stats -->
                        <div class="portlet light portlet-fit portlet-datatable ">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject font-dark sbold uppercase">{{ trans('temp_job.search_souq') }}</span>
                                </div>

                                <div class="col-md-12">
                                    <label for="gender">{{ trans('temp_job.service_type') }}</label>
                                    {{ Form::select('service_type', \Tamkeen\Ajeer\Utilities\Constants::serviceTypes(['file' => 'temp_job']), [session()->get('service_type')], ['class' => 'form-control form-filter input-sm bs-select', 'id' => 'service-provider-select', 'data-route' => url('taqawel/market') , 'placeholder' => trans('labels.default')]) }}
                                </div>

                            </div>
                            <div class="portlet-body">
                                <div class="table-container">
                                    <table id="datatable_ajax"
                                           data-token="{{ csrf_token() }}"
                                           class="table table-striped table-bordered table-hover" cellspacing="0"
                                           width="100%">
                                        <thead>
                                            <tr role="row" class="heading">
                                                <th id="id" width="10%"> {{ trans('taqawel_market.id') }}</th>
                                                <th width="550" id="provider.name" class="no-sort">{{ trans
                                                ('tqawel_offer_contract.name') }}  </th>
                                                <th width="150" id="contract_nature.name"
                                                    class="no-sort">{{ trans('tqawel_offer_contract.contract_nature_name') }} </th>
                                                <th width="50" id="responsible_email"
                                                    class="no-sort"> {{ trans('tqawel_offer_contract.email')}} </th>
                                                <th width="90" id="responsible_mobile"
                                                    class="no-sort"> {{ trans('tqawel_offer_contract.mobile') }} </th>
                                                <th id="details" class="no-sort"> {{ trans('tqawel_offer_contract.details') }} </th>
                                            </tr>
                                            <tr role="row" class="filter">
                                                <td class="id">
                                                    <input type="text" class="form-control form-filter input-sm" name="id">
                                                </td>
                                                <td>
                                                    {{ Form::text('name', null, ['class' => "form-control form-filter input-sm", "placeholder" => trans('tqawel_offer_contract.name')]) }}
                                                </td>
                                                <td>
                                                    {{ Form::text('contract_nature_name', null, ['class' => "form-control form-filter input-sm", "placeholder" => trans('tqawel_offer_contract.contract_nature_name')]) }}
                                                </td>
                                                <td>
                                                </td>

                                                <td>
                                                </td>
                                                <td>
                                                    <div class="margin-bottom-5">
                                                        <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                                            <i class="fa fa-search"></i> {{ trans('temp_job.searches') }}
                                                        </button>
                                                        <button class="btn btn-sm red btn-outline filter-cancel">
                                                            <i class="fa fa-times"></i> {{ trans('labels.reset') }}
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                        </thead>
                                        <tbody></tbody>
                                    </table>
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