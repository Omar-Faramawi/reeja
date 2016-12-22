@extends('front.layout')
@section('title', trans('front.menu.tqawel'))
@section('content')
<!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
   <div class="container">
      <!-- BEGIN PAGE TITLE -->
      <div class="page-title">
         <h1>{{ trans('front.menu.tqawel') }}</h1>
      </div>
      <!-- END PAGE TITLE -->
   </div>
</div>

<div class="page-content">
   <div class="container">
      <!-- BEGIN PAGE BREADCRUMBS -->
      <ul class="page-breadcrumb breadcrumb">
         <li>
            <a href="{{ url('/') }}">{{trans('taqawel_market.home')}}</a>
            <i class="fa fa-circle"></i>
         </li>
         <li>
            <span>{{ trans('front.menu.tqawel') }}</span>
            <i class="fa fa-circle"></i>
         </li>
         <li>
            <span>{{trans('taqawel_market.market')}}</span>
         </li>
      </ul>

       <div class="page-content-inner">
         <div class="row">

            <div class="col-md-12">
               <!-- Begin: life time stats -->
               <div class="portlet light portlet-fit portlet-datatable ">
                  <div class="portlet-title">
                     <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">{{ trans('taqawel_market.list_services') }}</span>
                     </div>
                  </div>
                   <div class="col-md-12">
                       <label for="gender">{{ trans('temp_job.service_type') }}</label>
                       {{ Form::select('service_type', \Tamkeen\Ajeer\Utilities\Constants::serviceTypes(['file' => 'temp_job']), [session()->get('service_type')], ['class' => 'form-control form-filter input-sm bs-select', 'id' => 'service-provider-select', 'data-route' => url('taqawel/market') , 'placeholder' => trans('labels.default')]) }}
                   </div>

                  <div class="portlet-body">
                     <div class="table-container">
                        <table class="table table-striped table-bordered table-hover table-checkable"
                           id="datatable_ajax">
                           <thead>
                              <tr role="row" class="heading">
                                 <th id="id" width="10%"> # </th>
                                 <th class="no-sort" id="providername" width="200">{{ trans('taqawel_market.provider_name') }} </th>
                                 <th class="no-sort" id="contract_nature.name" width="200"> {{ trans('taqawel_market.service_type') }}</th>
                                 <th class="no-sort" id="responsible_email" width="200">{{ trans('taqawel_market.email') }}</th>
                                 <th class="no-sort" id="responsible_mobile" width="200">{{ trans('taqawel_market.phone') }}</th>
                                 <th class="no-sort" id="description" width="200">{{ trans('taqawel_market.description') }}</th>
                                 <th class="no-sort" id="service_details" data-> {{ trans('labels.details') }}</th>
                              </tr>
                              <tr role="row" class="filter">
                                 <td>
                                    <input type="text" class="form-control form-filter input-sm" name="id">
                                 </td>
                                 <td>
                                    <input type="text" class="form-control form-filter input-sm" name="provider_name">
                                 </td>
                                 <td>
                                    <input type="text" class="form-control form-filter input-sm" name="service_type">
                                 </td>
                                 <td>
                                    <input type="text" class="form-control form-filter input-sm" name="responsible_email">
                                 </td>
                                 <td>
                                    <input type="text" class="form-control form-filter input-sm" name="phone">
                                 </td>
                                 <td>
                                    <input type="text" class="form-control form-filter input-sm" name="description">
                                 </td>
                                 <td>
                                    <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                    <i class="fa fa-search"></i> {{ trans('add_laborer.search') }}
                                    </button>
                                    <button class="btn btn-sm red btn-outline filter-cancel">
                                    <i class="fa fa-times"></i> {{ trans('add_laborer.reset') }}
                                    </button>
                                 </td>
                              </tr>
                           </thead>
                           <tbody></tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <!-- End: life time stats -->
            </div>
         </div>
      </div>
    </div>
</div>
<div class="modal fade" id="ask_offer" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog">
      {{ Form::open(['url' => 'contracts/cancellation/direct_hiring/refuse', 'data-url'=>'', "files"=>"false",'id'=>'form']) }}
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">{{ trans('contracts_cancelation.refuse') }}</h4>
         </div>
         <div class="modal-body form-body">
          
         </div>
         <div class="modal-footer">
            <button type="submit" data-loading-text="{{ trans('labels.loading') }}" class="btn green">{{ trans('contracts_cancelation.confirm') }}</button>
         </div>
      </div>
      <!-- /.modal-content -->
      {{ Form::close() }}
   </div>
   <!-- /.modal-dialog -->
</div>
@endsection