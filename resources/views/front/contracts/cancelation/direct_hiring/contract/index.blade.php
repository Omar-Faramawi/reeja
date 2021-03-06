@extends('front.layout')
@section('title', trans('front.menu.cancel_approve'))
@section('content')
<!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
   <div class="container">
      <!-- BEGIN PAGE TITLE -->
      <div class="page-title">
         <h1>{{ trans('front.menu.cancel_approve') }}</h1>
      </div>
      <!-- END PAGE TITLE -->
   </div>
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE CONTENT BODY -->
<div class="page-content">
   <div class="container">
      <!-- BEGIN PAGE BREADCRUMBS -->
      <ul class="page-breadcrumb breadcrumb">
         <li>
            <a href="{{ url('/') }}">{{trans('contracts_cancelation.home')}}</a>
            <i class="fa fa-circle"></i>
         </li>
         <li>
            <span>{{ trans('front.menu.temp_direct_contract') }}</span>
            <i class="fa fa-circle"></i>
         </li>
         <li>
            <span>{{ trans('front.menu.cancel_approve') }}</span>
         </li>
      </ul>
      <!-- END PAGE BREADCRUMBS -->
      <!-- BEGIN PAGE CONTENT INNER -->
      <div class="page-content-inner">
         <div class="row">
            <div class="col-md-12">
               <!-- Begin: life time stats -->
               <div class="portlet light portlet-fit portlet-datatable ">
                  <div class="portlet-title">
                     <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">{{ trans('front.menu.cancel_approve') }}</span>
                     </div>
                  </div>
                  <div class="portlet-body">
                     <div class="row">
                        <div class="col-md-6">
                           <span class="caption-subject font-dark sbold uppercase">{{ trans('contracts_cancelation.contracts') }}</span>
                        </div>
                        @if(Request::segment(3) != 'seeker')
                        <div class="col-md-6">
                           <div class="btn-group pull-right">
                              <button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              @if(Request::is('contracts/cancellation/direct_hiring/beneficial'))
                              {{ trans('temp_job.job_owner') }}
                              @else
                              {{ trans('temp_job.job_seeker') }}
                              @endif  
                              <i class="fa fa-angle-down"></i>
                              </button>
                               @if(auth()->user()->user_type_id == \Tamkeen\Ajeer\Utilities\Constants::USERTYPES['saudi'])
                              <ul class="dropdown-menu pull-right" role="menu">
                                 <li>
                                    <a href="{{ url('contracts/cancellation/direct_hiring/provider') }}">
                                    <i class="icon-user"></i> {{ trans('temp_job.job_seeker') }}</a>
                                 </li>
                                 <li>
                                    <a href="{{ url('contracts/cancellation/direct_hiring/beneficial') }}">
                                    <i class="icon-user"></i> {{ trans('temp_job.job_owner') }}</a>
                                 </li>
                              </ul>
                               @endif
                           </div>
                        </div>
                        @endif
                     </div>
                     <div class="table-container">
                        <table class="table table-striped table-bordered table-hover table-checkable"
                           id="datatable_ajax">
                           <thead>
                              <tr role="row" class="heading">
                                 <th id="id" width="10%"> {{ trans('contracts_cancelation.contract_number') }}</th>
                                 <th class="no-sort" id="start_date" width="200">{{ trans('contracts_cancelation.contract_start_date') }} </th>
                                 <th class="no-sort" id="end_date" width="200"> {{ trans('contracts_cancelation.contract_end_date') }}</th>
                                 @if(Request::is('contracts/cancellation/direct_hiring/beneficial'))
                                 <th class="no-sort" id="providername" width="200">{{ trans('labor_market.job_seeker_name') }}</th>
                                 @else
                                  <th class="no-sort" id="benf_name" width="200">{{ trans('labor_market.job_owner') }}</th>
                                  @endif
                                 <th class="no-sort" id="details"> {{ trans('labels.details') }}</th>
                              </tr>
                              <tr role="row" class="filter">
                                 <td>
                                    <input type="text" class="form-control form-filter input-sm"
                                       name="id">
                                 </td>
                                 <td>
                                    <input type="text" class="form-control input-sm date-picker"
                                       name="start_date">
                                 </td>
                                 <td>
                                    <input type="text" class="form-control input-sm date-picker"
                                       name="end_date">
                                 </td>
                                 <td>
                                    <input type="text" class="form-control form-filter input-sm"
                                       name="name">
                                 </td>
                                 <td>
                                    <input type="text" class="form-control form-filter input-sm"
                                       name="name2">
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
      <!-- END PAGE CONTENT INNER -->
   </div>
</div>
<!-- END PAGE CONTENT BODY -->
<!-- END CONTENT BODY -->
@endsection