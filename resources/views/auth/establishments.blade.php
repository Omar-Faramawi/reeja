@extends('front.layout')
@section('title', trans('front.dashboard.establishments'))
@section('content')
    <div class="page-white">
        <h2>{{ trans('front.dashboard.establishments') }}</h2>

        @if(session()->has('est_status'))
            <div class="alert alert-block alert-danger fade in">
                <button type="button" class="close" data-dismiss="alert"></button>
                <p>{!! session()->pull('est_status') !!} </p>
            </div>
        @endif
        @if(session()->has('choose_est_message'))
            <div class="alert alert-block alert-danger fade in">
                <button type="button" class="close" data-dismiss="alert"></button>
                <p>{!! session()->pull('choose_est_message') !!} </p>
            </div>
        @endif

        <div class="row">
            @if(!empty(session()->get('user.establishments')))
                <div class="col-md-6 col-md-offset-3">
                @foreach(session()->get('user.establishments') as $establishment)
                        <a class="btn btn-default btn-block" href="{{ route('establishment.choose',['office'=> $establishment->labor_office_id,'sequence'=> $establishment->sequence_number]) }}">
                            [{{ $establishment->labor_office_id }} - {{ $establishment->sequence_number }}] {{ $establishment->name }}
                        </a>
                @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
