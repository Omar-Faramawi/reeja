@extends('front.layout')

@section('title', trans('registration.title'))

@section('content')
<div class="page-head">
   <div class="container">
      <!-- BEGIN PAGE TITLE -->
      <div class="page-title">
         <h1>{{ trans('labels.system_name') }}
            <small>{{trans('registration.title')}}</small>
         </h1>
      </div>
   </div>
   <!-- END PAGE TOOLBAR -->
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE CONTENT BODY -->
            <div class="portlet box green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-gift"></i> {{trans('registration.title')}}
                  </div>
               </div>
               <div class="portlet-body">
                  <div class="slimScrollDiv">
                     {{ Form::open(['url' => '/register', "files"=>"false", "id"=>"register-for2m", "data-url"=>url('/')]) }}
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
                              {{ Form::text('id_number', null, ['id'=>'id_number', 'autocomplete' => 'off','class'=>'form-control']) }}
                              <label for="id_number" id='saudi-label'>{{ trans('registration.attributes.id_number_saudi') }} <span class="required">*</span></label>
                              <label for="id_number" style='display:none' id='resident-label'>{{ trans('registration.attributes.id_number_resident') }} <span class="required">*</span></label>
                              <label for="id_number" style='display:none' id='visitor-label'>{{ trans('registration.attributes.id_number_visitor') }} <span class="required">*</span></label>
                           </div>
                        </div>
                        <div class="form-group" id='birth_date_group'>
                           <div class="form-group form-md-line-input form-md-floating-label">
                              {{ Form::text('birth_date', null, ['id'=>'birth_date', 'autocomplete' => 'off','class'=>'form-control', 'readonly' => 'readonly']) }}
                              <label for="birth_date">{{ trans('registration.attributes.birth_date') }} <span
                                 class="required">*</span></label>
                              <span class="help-block">{{ trans('registration.attributes.birth_date') }} ...</span>
                           </div>
                        </div>
                           <div class="row">
                        <div class="form-group col-sm-6">
                           <div class="form-group form-md-line-input form-md-floating-label">
                              {{ Form::text('first_name', null, ['autocomplete' => 'off','class'=>'form-control']) }}
                              <label for="first_name">{{ trans('registration.attributes.first_name') }} <span
                                 class="required">*</span></label>
                             
                           </div>
                        </div>
                        <div class="form-group col-sm-6">
                           <div class="form-group form-md-line-input form-md-floating-label">
                              {{ Form::text('last_name', null, ['autocomplete' => 'off','class'=>'form-control']) }}
                              <label for="last_name">{{ trans('registration.attributes.last_name') }} <span
                                 class="required">*</span></label>
                              
                           </div>
                        </div>
                           </div>
                        <div class="form-group form-md-line-input form-md-floating-label">
                           {{ Form::password('password', ['autocomplete' => 'off','class'=>'form-control']) }}  
                           <label for="password">{{ trans('registration.attributes.password') }} <span class="required">*</span></label>
                          
                        </div>
                        <div class="form-group form-md-line-input form-md-floating-label">
                           {{ Form::password('password_confirmation', ['autocomplete' => 'off','class'=>'form-control']) }}  
                           <label for="password_confirmation">{{ trans('registration.attributes.confirm_password') }} <span class="required">*</span></label>
                           
                        </div>
                        <div class="form-group">
                           <div class="form-group form-md-line-input form-md-floating-label">
                              {{ Form::text('phone', null, ['autocomplete' => 'off','class'=>'form-control']) }}
                              <label for="phone">{{ trans('registration.attributes.phone') }} <span
                                 class="required">*</span></label>
                             
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-group form-md-line-input form-md-floating-label">
                              {{ Form::email('email', null, ['autocomplete' => 'off','class'=>'form-control']) }}
                              <label for="email">{{ trans('registration.attributes.email') }} <span
                                 class="required">*</span></label>
                              
                           </div>
                        </div>
                        <div class="form-actions text-center">
                           <button type="submit" data-loading-text="{{trans('labels.loading')}}" class="btn green uppercase">{{ trans('registration.register') }}</button>
                        </div>
                     </div>
                     {{ Form::close() }}
                  </div>
               </div>
            </div>
@endsection