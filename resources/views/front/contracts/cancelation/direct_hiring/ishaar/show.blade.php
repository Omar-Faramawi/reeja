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
      <div class="page-content-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="portlet light portlet-fit portlet-datatable ">
                  <div class="portlet-title">
                     <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">{{ trans('front.menu.cancel_approve') }}</span>
                     </div>
                  </div>
                  <div class="portlet-body">
                     <div class="row">
                        <h4>{{ trans('contracts_cancelation.details') }}</h4>
                        <div class="row">
                           <div class="col-md-6"><label>{{ trans('contracts_cancelation.contract_number') }}</label> : <span id='id'>{{ $contractEmployee->contract->id }}</span></div>
                           <div class="col-md-6"><label>{{ trans('contracts_cancelation.contract_benef') }}</label> : <span id='benf_name'>{{ $contractEmployee->contract->benf_name }}</span></div>
                           <div class="col-md-6"><label>{{ trans('contracts_cancelation.contract_start_date') }} </label> : <span id='start_date'>{{ $contractEmployee->contract->start_date }}</span></div>
                           <div class="col-md-6"><label>{{ trans('contracts_cancelation.contract_end_date') }}</label> : <span id='end_date'>{{ $contractEmployee->contract->end_date }}</span></div>
                           <div class="col-md-6"><label id='amount'>{{ trans('contracts_cancelation.amount') }} : </label><span id='amount'>{{ $contractEmployee->contract->contract_amount }}</span></div>
                           <div class="col-md-6"><label id='job'>{{ trans('contracts_cancelation.job') }} : </label><span id='job'>{{ $contractEmployee->contract->vacancy->job->job_name }}</span></div>
                           <div class="col-md-6"><label id='nationality'>{{ trans('contracts_cancelation.nationality') }} : </label><span id='nationality'>{{ $contractEmployee->contract->vacancy->nationality->name }}</span></div>
                           <div class="col-md-6"><label id='gender'>{{ trans('contracts_cancelation.gender') }} : </label><span id='gender'>{{  \Tamkeen\Ajeer\Utilities\Constants::gender()[$contractEmployee->contract->vacancy->gender] }}</span></div>
                           <div class="col-md-6"> <label id='religion'>{{ trans('contracts_cancelation.religion') }} : </label><span id='religion'>{{
                              \Tamkeen\Ajeer\Utilities\Constants::religions()[$contractEmployee->contract->vacancy->religion] }}</span>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <h4>{{ trans('contracts_cancelation.single_ishaar') }}</h4>
                         <div class="col-md-6"><label>{{ trans('contracts_cancelation.ishaar_number') }}</label> : <span id='id'>{{ $contractEmployee->id }}</span></div>
                         <div class="col-md-6"><label>{{ trans('contracts_cancelation.ishaar_benef') }}</label> : <span id='benf_name'>{{ $contractEmployee->hrPool->name }}</span></div>
                           <div class="col-md-6"><label>{{ trans('contracts_cancelation.ishaar_start_date') }} </label> : <span id='start_date'>{{ $contractEmployee->start_date }}</span></div>
                           <div class="col-md-6"><label>{{ trans('contracts_cancelation.ishaar_end_date') }}</label> : <span id='end_date'>{{ $contractEmployee->end_date }}</span></div>
                     </div>
                     @if($contractEmployee->status == 'benef_cancel' || $contractEmployee->status == 'provider_cancel')
                     <div class="row">
                     	 <div class="col-md-12">
                           <button class="btn btn-success" id='accept_cancel' data-toggle="modal" href="#basic" data-type="contract">{{ trans('contracts_cancelation.accept_cancel') }}</button>

                           <button class="btn btn-danger" id='refuse_cancel' data-toggle="modal" href="#refuse" data-type="contract">{{ trans('contracts_cancelation.cancel') }}</button>
                        </div>
                     </div>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="basic" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog">
      {{ Form::open(['url' => 'contracts/cancelation/direct_hiring/accept', 'data-url'=>'', "files"=>"false",'id'=>'form']) }}
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">{{ trans('contracts_cancelation.endorsement') }}</h4>
         </div>
         <div class="modal-body form-body">
            <input type="hidden" name='type' value='ishaar'>
            <input type="hidden" name='id' value='{{ $contractEmployee->id }}'>
            <div class="md-checkbox">
               <input type="checkbox" id="checkbox1" name='confirmed' class="md-check" required>
               <label for="checkbox1">
               <span class="inc"></span>
               <span class="check"></span>
               <span class="box"></span> {{ trans('contracts_cancelation.endorsement_statment') }} </label>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{ trans('labels.cancel') }}</button>
            <button type="submit" data-loading-text="{{ trans('labels.loading') }}" class="btn green">{{ trans('contracts_cancelation.confirm') }}</button>
         </div>
      </div>
      <!-- /.modal-content -->
      {{ Form::close() }}
   </div>
   <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="refuse" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog">
      {{ Form::open(['url' => 'contracts/cancelation/direct_hiring/refuse', 'data-url'=>'', "files"=>"false",'id'=>'form']) }}
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">{{ trans('contracts_cancelation.refuse') }}</h4>
         </div>
         <div class="modal-body form-body">
            <input type="hidden" id='modal-type-r' name='type_r' value='ishaar'>
            <input type="hidden" id='modal-id-r' name='id_r' value='{{ $contractEmployee->id }}'>
            <div class="form-group form-md-line-input has-info">
               <select class="form-control" id="select_reason" name='reason'>
                     <option value=""></option>
                     @foreach($reasons as $reason)
                        <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                     @endforeach
                        <option value='other'>{{ trans('contracts_cancelation.other') }}</option>
               </select>
               <label for="form_control_1">{{ trans('contracts_cancelation.refusereason') }}</label>
            </div>
            <div class="form-group form-md-line-input" style="display:none;" id='other_reason'>
               <input type="text" class="form-control" id="other_reason" name='other'>
               <label for="form_control_1">{{ trans('contracts_cancelation.other') }}</label>
               <span class="help-block">{{ trans('contracts_cancelation.other') }}</span>
            </div>
            <div class="form-group form-md-line-input">
               <textarea  class="form-control" id="details" name='details'></textarea>
               <label for="form_control_1">{{ trans('contracts_cancelation.details') }}</label>
               <span class="help-block">{{ trans('contracts_cancelation.details') }}</span>
            </div>
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
