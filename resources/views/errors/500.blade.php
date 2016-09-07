<!DOCTYPE html>
<!--[if IE 8]> <html lang="{{ app()->getLocale() }}" dir="{{ (app()->getLocale()=="ar") ? "rtl" : "ltr" }} class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="{{ app()->getLocale() }}" dir="{{ (app()->getLocale()=="ar") ? "rtl" : "ltr" }} class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ app()->getLocale() }}" dir="{{ (app()->getLocale()=="ar") ? "rtl" : "ltr" }}">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ trans('labels.system_name') . ' | '.trans('user.error')}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link rel="shortcut icon" href="{{ asset('assets/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/ltr/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ltr/simple-line-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ltr/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ltr/uniform.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ltr/bootstrap-switch.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ltr/components-md.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ltr/plugins-md.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ltr/error.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ltr/custom.min.css') }}">
</head>

<body class=" page-500-full-page">
<div class="row">
    <div class="col-md-12 page-500">
        <div class=" number font-red"> 500 </div>
        <div class=" details">
            <h3>{{ trans('user.500') }}</h3>
            <p>
                <a href="{{ action('HomeController@home') }}" class="btn red btn-outline"> {{ trans('user.home') }} </a>
                <br>
            </p>
        </div>
    </div>
</div>
</body>
</html>