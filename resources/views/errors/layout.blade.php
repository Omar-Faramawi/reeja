<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ trans('labels.system_name') }} | @yield('title')</title>

  <link rel="stylesheet" href="{{ asset('assets/css/ltr/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/ltr/simple-line-icons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/ltr/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/ltr/uniform.default.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/ltr/bootstrap-switch.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/ltr/components-md.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/ltr/plugins-md.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/ltr/error.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/ltr/custom.min.css') }}">
  <style>
    body {
      margin-top: 25px;;
    }
  </style>
</head>
<body id="app-layout">

<header class="text-center">
  <h1>
    <a href="{{ url('/') }}">
      <img alt="{{ trans('labels.system_name') }}" src="{{ asset('assets/images/logo.png') }}" height="150">

    </a>
  </h1>
</header>
<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">

      <div class="jumbotron">
        @yield('content')

        <a href="{{ action('HomeController@home') }}" class="btn red btn-outline"> {{ trans('user.home') }} </a>
      </div>

    </div>
  </div>
</div>