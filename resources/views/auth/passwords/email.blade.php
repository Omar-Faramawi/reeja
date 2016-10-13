@extends('front.layout')
@section('title', trans('auth.reset_password'))
@section('content')
        <!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('labels.system_name') }}
                <small>{{ trans('auth.password_reset') }}</small>
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
                                <i class="fa fa-gift"></i> {{ trans('auth.password_reset') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="slimScrollDiv">
                                <form id="form" action="{{ url('/password/email') }}" method="post" data-url="{{ url('/') }}">
                                    <div class="form-body">
                                        {{ csrf_field() }}
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <input class="form-control" type="email"
                                                   value="{{ $email or old('email') }}"
                                                   autocomplete="off" name="email" required/>
                                            <label for="email">{{ trans('auth.parameters.email') }} <span
                                                        class="required">*</span></label>
                                            <span class="help-block">{{ trans('auth.parameters.email') }} ...</span>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" data-loading-text="{{ trans('labels.loading') }}..."
                                                    class="btn green uppercase">{{ trans('auth.password_reset') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
@endsection