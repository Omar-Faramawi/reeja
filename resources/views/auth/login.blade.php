@extends('front.layout')
@section('title', trans('auth.login'))
@section('content')


    <div class="col-md-6 login_form">
        <div class="login_form_content">
            <h2>{{ trans('auth.establishments_login') }}</h2>
            <div class="col-md-12">
                {{ Form::open(['url' => url('/login'), 'data-url'=>url('/'), 'id'=>'form']) }}
                <div class="form-body">
                    <div class="text-center">
                        <a href="{{ url('/auth/openid/login') }}" class="btn btn-primary">{{ trans('auth.open_id_login') }}</a>
                    </div>
                    <div class="text-center" style="margin-top: 5px;">
                        <a href="#" class="btn btn-primary" id="direct_login">{{ trans('auth.direct_login') }}</a>
                    </div>
                    <div style="display: none" id="direct_login_form">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            {{ Form::email('email', null, ['id'=>'email', 'autocomplete' => 'off','class'=>'form-control','required'=>'required']) }}
                          <label for="email">{{ trans('auth.parameters.email') }} <span class="required">*</span></label>
                          <span class="help-block">{{ trans('auth.parameters.email') }} ...</span>
                        </div>
                        <div class="form-group form-md-line-input form-md-floating-label">
                            {{ Form::password('password', ['autocomplete' => 'off','class'=>'form-control','required'=>'required']) }}
                          <label for="password">{{ trans('auth.parameters.password') }}</label>
                          <span class="help-block">{{ trans('auth.parameters.password') }} ...</span>
                        </div>
                        <div class="form-actions text-center">
                            <button type="submit" data-loading-text="{{ trans('labels.loading') }}..."
                                    class="btn btn-primary uppercase">{{ trans('auth.login') }}</button>
                            <a href="{{ url('/password/reset') }}" class="btn btn-default yellow">
                                {{ trans('auth.forgot_password') }}
                            </a>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="col-md-6 login_form">
        <div class="login_form_content">
            <h2>{{ trans('auth.individual_login') }}</h2>
            <div class="col-md-12">
                {{ Form::open(['url' => url('auth/individualsLogin'), 'id'=>'another_form', 'data-url' => url('/')]) }}
                <div class="form-body">
                    <div class="form-group form-md-line-input form-md-floating-label">
                        {{ Form::text('national_id', null, ['id'=>'national_id', 'autocomplete' => 'off','class'=>'form-control','required'=>'required']) }}
                      <label for="email">{{ trans('auth.parameters.national_id') }} <span class="required">*</span></label>
                      <span class="help-block">{{ trans('auth.parameters.national_id') }} ...</span>
                    </div>
                    <div class="form-group form-md-line-input form-md-floating-label">
                        {{ Form::password('password', ['autocomplete' => 'off','class'=>'form-control','required'=>'required']) }}
                      <label for="password">{{ trans('auth.parameters.password') }}</label>
                      <span class="help-block">{{ trans('auth.parameters.password') }} ...</span>
                    </div>
                    <div class="form-actions text-center">
                        <button type="submit" data-loading-text="{{ trans('labels.loading') }}..."
                                class="btn btn-primary uppercase">{{ trans('auth.login') }}</button>
                        <a href="{{ url('/password/reset') }}" class="btn btn-default yellow">
                            {{ trans('auth.forgot_password') }}
                        </a>
                    </div>
                    <div class="text-center" style="margin-top: 5px">
                        <a href="{{ url("/register") }}" class="btn btn-primary"
                           class="forget-password">{{ trans('auth.register') }}</a>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection