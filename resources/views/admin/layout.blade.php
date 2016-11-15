<!DOCTYPE html>
<!--[if IE 8]>
<html lang="{{ app()->getLocale() }}" dir="{{ (app()->getLocale()=="
      ar") ? "rtl" : "ltr" }} class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="{{ app()->getLocale() }}" dir="{{ (app()->getLocale()=="
      ar") ? "rtl" : "ltr" }} class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ app()->getLocale() }}" dir="{{ (app()->getLocale()=="ar") ? "rtl" : "ltr" }}">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ trans('labels.system_name') }} | @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @if (app()->getLocale()=="en")
    <link href="//fonts.googleapis.com/css?family=Oswald:400,300,700" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    @endif
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet"
          href="{{ (app()->getLocale()=="ar") ? asset('assets/css/app-rtl.css') : asset('assets/css/app.css') }}">
    @yield('styles')
</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-md">
<div class="wrapper">

    @include('admin.partials.header')

    {{--@include('partials.sidemenu')--}}
    <div class="container-fluid">
        <div class="page-content">
            @yield('content')
        </div>
    </div>
    @include('admin.partials.footer')
</div>
<!-- ./wrapper -->

<!--[if lt IE 9]>
<script src="{{ asset('assets/metronic/js/respond.min.js')}}/"></script>
<script src="{{ asset('assets/metronic/js/excanvas.min.js')}}"></script>
<![endif]-->
<script>
    var locale = '{!! app()->getLocale() !!}';
    var default_placeholder = '{!! trans('ishaar_setup.attributes.default') !!}';
    var no_data = '{!! trans('labels.no_data') !!}';
    var missing_required_fields = '{!! trans('labels.missing_required_fields') !!}';
    var loading_img = '{!! asset('assets/img/loading-spinner-grey.gif') !!}';
    var noneSelectedTextValue = '{!! trans('labels.noneSelectedTextValue') !!}';
    var noSearchResult = '{!! trans('labels.noSearchResult') !!}';
    var itemSelected = '{!! trans('labels.itemSelected') !!}';
    var itemsSelected = '{!! trans('labels.itemsSelected') !!}';
    var selectAll = '{!! trans('labels.selectAll') !!}';
    var deselectAll = '{!! trans('labels.deselectAll') !!}';
    var paginatation = {
        loading: '{!! trans('labels.loading') !!}....',
        search: '{!! trans('labels.pagination.search') !!}....',
        sProcessing: '{!! trans('labels.pagination.sProcessing') !!}',
        sLengthMenu: '{!! trans('labels.pagination.sLengthMenu') !!}',
        sZeroRecords: '{!! trans('labels.pagination.sZeroRecords') !!}',
        emptyTable: '{!! trans('labels.no_data') !!}',
        info: '{!! trans('labels.pagination.info') !!}',
        sInfoEmpty: '{!! trans('labels.pagination.sInfoEmpty') !!}',
        sInfoFiltered: '{!! trans('labels.pagination.sInfoFiltered') !!}',
        sInfoPostFix: '{!! trans('labels.pagination.sInfoPostFix') !!}',
        sSearch: '{!! trans('labels.pagination.sSearch') !!}',
        sUrl: '{!! trans('labels.pagination.sUrl') !!}',
        sPage: '{!! trans('labels.pagination.sPage') !!}',
        oPaginate: {
            sFirst:'{!! trans('labels.pagination.oPaginate.sFirst') !!}',
            sPrevious:'{!! trans('labels.pagination.oPaginate.sPrevious') !!}',
            sNext:'{!! trans('labels.pagination.oPaginate.sNext') !!}',
            sLast:'{!! trans('labels.pagination.oPaginate.sLast') !!}',
            page:'{!! trans('labels.pagination.oPaginate.page') !!}',
            pageOf:'{!! trans('labels.pagination.oPaginate.pageOf') !!}'
        },
        oAria: {
            sSortAscending:'{!! trans('labels.pagination.oAria.sSortAscending') !!}',
            sSortDescending:'{!! trans('labels.pagination.oAria.sSortDescending') !!}'
        }
    }
</script>
@if(app()->getLocale() == "ar")
    <script src="{{ asset('assets/js/app-rtl.js') }}"></script>
@else
    <script src="{{ asset('assets/js/app.js') }}"></script>
@endif
@yield('scripts')
</body>
</html>