<!DOCTYPE html>
<!--[if IE 8]><html lang="{{ app()->getLocale() }}" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]><html lang="{{ app()->getLocale() }}" class="ie9 no-js"> <![endif]-->
<html lang="{{ app()->getLocale() }}" dir="{{ (app()->getLocale()=="ar") ? "rtl" : "ltr" }}">

<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>{{ trans('labels.system_name') . ' | '. trans('auth.login')}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="{{ trans('labels.system_name') }}" name="description"/>
    <meta content="Tamkeen" name="author"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.css') }}">
    <link rel="stylesheet" href="{{ (app()->getLocale()=="ar") ? asset('assets/css/login-rtl.css') : asset('assets/css/login.css') }}">
</head>
<!-- END HEAD -->

<body class=" login">
<!-- BEGIN LOGO -->
<div class="logo">

    <img src="{{ asset('assets/img/logo.png') }}" alt=""/>

</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="{{ url('admin/auth/login') }}" method="post">
        {{ csrf_field() }}
        <h3 class="form-title font-green">{{ trans('auth.login') }}</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> {{ trans('auth.login_form_notice') }}</span>
        </div>
        @if (count($errors))
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
                @foreach($errors->all() as $error)
                    <span>{{$error}}</span><br/>
                @endforeach
        </div>
        @endif
        @if(session()->get('status'))
            <div class="alert alert-info">
                <button class="close" data-close="alert"></button>
                <span>{{session('status')}}</span>
            </div>
        @endif
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{ trans('auth.parameters.email') }}</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="email" value="{{ old('email') }}"
                   autocomplete="off" placeholder="{{ trans('auth.parameters.email') }}" name="email"/></div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{ trans('auth.parameters.password') }}</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
                   placeholder="{{ trans('auth.parameters.password') }}" name="password"/></div>
        <div class="form-actions">
            <button type="submit" class="btn green uppercase">{{ trans('auth.login') }}</button>
            <a href="{{ url('/password/reset') }}" class="btn btn-default" id="forget-password"
               class="forget-password">{{ trans('auth.forgot_password') }}</a>
        </div>
        <div class="login-options">
            @if(app()->getLocale() == 'ar')
                <a href="{{ action('UserController@getLocale', 'en')}}" class="pull-right"><i
                            class="fa fa-dribbble"></i> English</a><br>
            @else
                <a href="{{ action('UserController@getLocale', 'ar')}}" class="pull-right"><i
                            class="fa fa-dribbble"></i> العربية</a><br>
            @endif
            <ul class="social-icons">
                <li>

                </li>
            </ul>
        </div>
        <!--<div class="create-account">
            <p>
                <a href="{{ url("/") }}">{{ trans('labels.back_to_main') }}</a>
            </p>
        </div>-->
    </form>
    <!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="forget-form" action="{{ url('admin/password/email') }}" method="post">
        {!! csrf_field() !!}
        <h3 class="font-green">{{ trans('auth.forgot_password') }}</h3>
        <p> {{ trans('passwords.forget_pass') }} </p>
        <div class="form-group">
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off"
                   placeholder="{{ trans('auth.parameters.email') }}" name="email"/></div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn btn-default">{{ trans('labels.back') }}</button>
            <button type="submit" class="btn btn-success uppercase pull-right">{{ trans('passwords.send') }}</button>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
</div>
<div class="copyright"> {{ trans('labels.rights_reserved') }} </div>
<!--[if lt IE 9]>
<script src="{{ asset('assets/js/respond.min.js') }}"></script>
<script src="{{ asset('assets/js/excanvas.min.js') }}"></script>
<![endif]-->

<script src="{{ asset('assets/js/login.js') }}" type="text/javascript"></script>
</body>

</html>
