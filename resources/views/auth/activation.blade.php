@extends('front.layout')

@section('title', trans('registration.title_active'))

@section('content')
<div class="page-head">
   <div class="container">
      <!-- BEGIN PAGE TITLE -->
      <div class="page-title">
         <h1>{{ trans('labels.system_name') }}
            <small>{{trans('registration.title_active')}}</small>
         </h1>
      </div>
   </div>
   <!-- END PAGE TOOLBAR -->
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE CONTENT BODY -->
<div class="page-content">
   <div class="container">
      <!-- BEGIN PAGE CONTENT INNER -->
      <div class="page-content-inner">
         <div class="col-md-12">
            <div class="portlet box green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-gift"></i> {{trans('registration.title_active')}}
                  </div>
               </div>
               <div class="portlet-body">
                  <div class="slimScrollDiv">
                     {{ Form::open(['url' => '/activation', "files"=>"false", "id"=>"register-form", "data-url"=>url('/')]) }}
                     <div class="form-body">
                        @if (count($errors))
                        <div class="alert alert-danger">
                           <button class="close" data-close="alert"></button>
                           @foreach($errors->all() as $error)
                           <span>{{$error}}</span><br/>
                           @endforeach
                        </div>
                        @endif
                        <div class="form-group">
                           <div class="form-group form-md-line-input form-md-floating-label">
                              {{ Form::text('activation_number', null, ['id'=>'activation_number', 'autocomplete' => 'off','class'=>'form-control']) }}
                              <label for="activation_number" id='non-saudi-label'>{{ trans('registration.activation_number') }} <span class="required">*</span></label>
                           </div>
                        </div>
                        <div class="form-actions">
                           <button type="submit" data-loading-text="{{trans('labels.loading')}}" class="btn green uppercase btn-block">{{ trans('registration.activate') }}</button>
                        </div>
                     </div>
                     {{ Form::close() }}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection