@extends('errors.layout')
@section('title', trans('front.menu.about'))
@section('content')
    <h1 class="text-center"><i class="fa fa-exclamation-triangle"></i></h1>
    <p class="text-center">النظام خارج الخدمة حالياً الرجاء المحاولة لاحقاً.</p>
    <p class="text-center" dir="ltr">The Application is now in maintenance mode. Be right back.</p>
    @unless(empty($sentryID))
        <p class="text-center">Ref: {{ $sentryID }}</p>
        <!-- Sentry JS SDK 2.1.+ required -->
        <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

        <script>
            Raven.showReportDialog({
                eventId: '{{ $sentryID }}',
                @if (auth()->user())
                user: {
                    name: '{{ auth()->user()->name }}',
                    email: '{{ auth()->user()->email }}'
                },
                @endif

                // use the public DSN (dont include your secret!)
                dsn: '{{ config('sentry.public_dsn') }}'
            });
        </script>
    @endunless
@endsection