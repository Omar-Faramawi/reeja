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
<div class="page-content">
   <div class="container">
      <!-- BEGIN PAGE CONTENT INNER -->
      <div class="page-content-inner">
         <div class="col-md-12">
            <div class="portlet box green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-gift"></i> {{trans('registration.title')}}
                  </div>
               </div>
               <div class="portlet-body">
                  <div class="slimScrollDiv">
                     {{ Form::open(['url' => '/register', "files"=>"false", "id"=>"register-form", "data-url"=>url('/')]) }}
                     <div class="form-body">
                        @if (count($errors))
                        <div class="alert alert-danger">
                           <button class="close" data-close="alert"></button>
                           @foreach($errors->all() as $error)
                           <span>{{$error}}</span><br/>
                           @endforeach
                        </div>
                        @endif
                        <div class="md-checkbox">
                           {{ Form::checkbox('saudi', '1', false, ['class'=>'md-check', 'id'=>'checkbox1_1']) }}
                           <label for="checkbox1_1">
                           <span></span>
                           <span class="check"></span>
                           <span class="box"></span> {{ trans('registration.attributes.saudi') }} </label>
                        </div>
                        <div class="form-group">
                           <div class="form-group form-md-line-input form-md-floating-label">
                              {{ Form::text('id_number', null, ['id'=>'id_number', 'autocomplete' => 'off','class'=>'form-control']) }}
                              <label for="id_number" style='display:none' id='saudi-label'>{{ trans('registration.attributes.id_numbers_saudi') }} <span class="required">*</span></label>
                              <label for="id_number" id='non-saudi-label'>{{ trans('registration.attributes.id_numbers_non_saudi') }} <span class="required">*</span></label>
                           </div>
                        </div>
                        <div class="form-group" id='birth_date_group' style='display:none'>
                           <div class="form-group form-md-line-input form-md-floating-label">
                              {{ Form::text('birth_date', null, ['id'=>'birth_date', 'autocomplete' => 'off','class'=>'form-control']) }}
                              <label for="birth_date">{{ trans('registration.attributes.birth_date') }} <span
                                 class="required">*</span></label>
                              <span class="help-block">{{ trans('registration.attributes.birth_date') }} ...</span>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-group form-md-line-input form-md-floating-label">
                              {{ Form::text('first_name', null, ['autocomplete' => 'off','class'=>'form-control']) }}
                              <label for="first_name">{{ trans('registration.attributes.first_name') }} <span
                                 class="required">*</span></label>
                              <span class="help-block">{{ trans('registration.attributes.first_name') }} ...</span>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-group form-md-line-input form-md-floating-label">
                              {{ Form::text('last_name', null, ['autocomplete' => 'off','class'=>'form-control']) }}
                              <label for="last_name">{{ trans('registration.attributes.last_name') }} <span
                                 class="required">*</span></label>
                              <span class="help-block">{{ trans('registration.attributes.last_name') }} ...</span>
                           </div>
                        </div>
                        <div class="form-group form-md-line-input form-md-floating-label">
                           {{ Form::password('password', ['autocomplete' => 'off','class'=>'form-control']) }}  
                           <label for="password">{{ trans('registration.attributes.password') }} <span class="required">*</span></label>
                           <span class="help-block">{{ trans('registration.attributes.password') }} ...</span>
                        </div>
                        <div class="form-group form-md-line-input form-md-floating-label">
                           {{ Form::password('password_confirmation', ['autocomplete' => 'off','class'=>'form-control']) }}  
                           <label for="password_confirmation">{{ trans('registration.attributes.confirm_password') }} <span class="required">*</span></label>
                           <span class="help-block">{{ trans('registration.attributes.confirm_password') }} ...</span>
                        </div>
                        <div class="form-group">
                           <div class="form-group form-md-line-input form-md-floating-label">
                              {{ Form::text('phone', null, ['autocomplete' => 'off','class'=>'form-control']) }}
                              <label for="phone">{{ trans('registration.attributes.phone') }} <span
                                 class="required">*</span></label>
                              <span class="help-block">{{ trans('registration.attributes.phone') }} ...</span>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-group form-md-line-input form-md-floating-label">
                              {{ Form::email('email', null, ['autocomplete' => 'off','class'=>'form-control']) }}
                              <label for="email">{{ trans('registration.attributes.email') }} <span
                                 class="required">*</span></label>
                              <span class="help-block">{{ trans('registration.attributes.email') }} ...</span>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-group form-md-line-input form-md-floating-label">
                              <label for="gender">{{ trans('registration.attributes.gender') }} <span
                                 class="required">*</span></label>
                              <div class="md-radio-inline">
                                 <div class="md-radio">
                                    {{ Form::radio('gender', 1, true, ['id'=>'checkbox1_8', 'class'=>'md-radiobtn']) }}
                                    <label for="checkbox1_8">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ trans('registration.male') }} </label>
                                 </div>
                                 <div class="md-radio">
                                    {{ Form::radio('gender', 0, false, ['id'=>'checkbox1_9', 'class'=>'md-radiobtn']) }}
                                    <label for="checkbox1_9">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ trans('registration.female') }} </label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-group form-md-line-input form-md-floating-label">
                              <label for="religion">{{ trans('registration.attributes.religion') }} <span
                                 class="required">*</span></label>
                              {{ Form::select('religion', \Tamkeen\Ajeer\Utilities\Constants::religions(['file' => 'registration.religions']), NULL, ['id'=>'religion', 'class'=>'selectpicker', 'placeholder'=>trans('registration.choose')]) }}
                           </div>
                        </div>
                        <div class="form-actions">
                           <button type="submit" data-loading-text="{{trans('labels.loading')}}" class="btn green uppercase btn-block">{{ trans('registration.register') }}</button>
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