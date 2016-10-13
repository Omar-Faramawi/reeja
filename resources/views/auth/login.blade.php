@extends('front.layout')
@section('title', trans('auth.login'))
@section('content')
        <!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('labels.system_name') }}
                <small>{{ trans('auth.login') }}</small>
            </h1>
        </div>
    </div>
    <!-- END PAGE TOOLBAR -->
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE CONTENT BODY -->
<div class="page-content">
    <div class="container">
        <!-- BEGIN PAGE BREADCRUMBS -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="#">{{ trans('auth.login') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ trans('auth.users') }}</span>
            </li>
        </ul>
        <!-- END PAGE BREADCRUMBS -->
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                @if (count($errors))
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        @foreach($errors->all() as $error)
                            <span>{{$error}}</span><br/>
                        @endforeach
                    </div>
                @endif
                <div class="col-md-6">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> {{ trans('auth.establishments_login') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="slimScrollDiv">
                                {{ Form::open(['url' => url('/login'), 'data-url'=>url('/'), 'id'=>'form']) }}
                                <div class="form-body">
                                    <div class="form-group form-md-line-input form-md-floating-label">
                                        {{ Form::email('email', null, ['id'=>'email', 'autocomplete' => 'off','class'=>'form-control','required'=>'required']) }}
                                        <label for="email">{{ trans('auth.parameters.email') }} <span
                                                    class="required">*</span></label>
                                        <span class="help-block">{{ trans('auth.parameters.email') }} ...</span>
                                    </div>
                                    <div class="form-group form-md-line-input form-md-floating-label">
                                        {{ Form::password('password', ['autocomplete' => 'off','class'=>'form-control','required'=>'required']) }}
                                        <label for="password">{{ trans('auth.parameters.password') }}</label>
                                        <span class="help-block">{{ trans('auth.parameters.password') }} ...</span>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" data-loading-text="{{ trans('labels.loading') }}..."
                                                class="btn green uppercase">{{ trans('auth.login') }}</button>
                                        <a href="{{ url('/password/reset') }}" class="btn btn-default yellow">
                                            {{ trans('auth.forgot_password') }}
                                        </a>
                                        <a href="{{ url('/auth/openid/login') }}"
                                           class="btn btn-primary margin-top-10">{{ trans('auth.open_id_login') }}</a>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> {{ trans('auth.individual_login') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="slimScrollDiv">
                                {{ Form::open(['url' => url('auth/individualsLogin'), 'id'=>'another_form', 'data-url' => url('/')]) }}
                                <div class="form-body">
                                    <div class="form-group form-md-line-input form-md-floating-label">
                                        {{ Form::text('national_id', null, ['id'=>'national_id', 'autocomplete' => 'off','class'=>'form-control','required'=>'required']) }}
                                        <label for="email">{{ trans('auth.parameters.national_id') }} <span
                                                    class="required">*</span></label>
                                        <span class="help-block">{{ trans('auth.parameters.national_id') }} ...</span>
                                    </div>
                                    <div class="form-group form-md-line-input form-md-floating-label">
                                        {{ Form::password('password', ['autocomplete' => 'off','class'=>'form-control','required'=>'required']) }}
                                        <label for="password">{{ trans('auth.parameters.password') }}</label>
                                        <span class="help-block">{{ trans('auth.parameters.password') }} ...</span>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" data-loading-text="{{ trans('labels.loading') }}..."
                                                class="btn green uppercase">{{ trans('auth.login') }}</button>
                                        <a href="{{ url("/register") }}" class="btn btn-default"
                                           class="forget-password">{{ trans('auth.register') }}</a>
                                        <a href="{{ url('/password/reset') }}" class="btn btn-default yellow">
                                            {{ trans('auth.forgot_password') }}
                                        </a>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END PAGE CONTENT BODY -->
@endsection