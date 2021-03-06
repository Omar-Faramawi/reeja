<!DOCTYPE html>
<!--[if IE 8]><html lang="{{ app()->getLocale() }}" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]><html lang="{{ app()->getLocale() }}" class="ie9 no-js"> <![endif]-->
<html lang="{{ app()->getLocale() }}" dir="{{ (app()->getLocale()=="ar") ? "rtl" : "ltr" }}">

<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>{{ trans('labels.system_name') . ' | '. trans('auth.password_reset')}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="{{ trans('labels.system_name') }}" name="description"/>
    <meta content="Tamkeen" name="author"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ (app()->getLocale()=="ar") ? asset('assets/css/login-rtl.css') : asset('assets/css/login.css') }}">
</head>
<!-- END HEAD -->

<body class=" login">
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="{{ url('/') }}">
        <img src="{{ asset('assets/img/logo.png') }}" alt=""/> </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="{{ url('admin/password/reset') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
        <h3 class="form-title font-green">{{ trans('auth.password_reset') }}</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> {{ trans('auth.pass_form_notice') }}</span>
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
            <input readonly="" class="form-control form-control-solid placeholder-no-fix" type="email" value="{{ $email or old('email') }}"
                   placeholder="{{ trans('auth.parameters.email') }}" name="email"/></div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{ trans('auth.parameters.password') }}</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password"
                   placeholder="{{ trans('auth.parameters.password') }}" name="password"/></div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{ trans('auth.parameters.password_confirmation') }}</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password"
                   placeholder="{{ trans('auth.parameters.password_confirmation') }}" name="password_confirmation"/></div>
        <div class="form-actions">
            <button type="submit" class="btn green uppercase">{{ trans('auth.password_reset') }}</button>
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
        <div class="create-account">
            <p>
                <a href="{{ url("/") }}">{{ trans('labels.back_to_main') }}</a>
            </p>
        </div>
    </form>
    <!-- END Reset FORM -->
</div>
<div class="copyright"> {{ trans('labels.rights_reserved') }} </div>
<!--[if lt IE 9]>
<script src="{{ asset('assets/js/respond.min.js') }}"></script>
<script src="{{ asset('assets/js/excanvas.min.js') }}"></script>
<![endif]-->

<script src="{{ asset('assets/js/login.js') }}" type="text/javascript"></script>
</body>

</html>