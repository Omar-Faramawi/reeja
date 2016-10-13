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
    <link href="//fonts.googleapis.com/css?family=Oswald:400,300,700" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet"
          href="{{ (app()->getLocale()=="ar") ? asset('assets/css/front-rtl.css') : asset('assets/css/front.css') }}">
    @yield('styles')
</head>

<body class="page-container-bg-solid page-boxed page-md">

@include('front.partials.header')

<div class="page-container">
    <div class="page-content-wrapper">
        @yield('content')
    </div>
</div>

@include('front.partials.footer')

<!--[if lt IE 9]>
<script src="{{ asset('assets/metronic/js/respond.min.js') }}/"></script>
<script src="{{ asset('assets/metronic/js/excanvas.min.js') }}"></script>
<![endif]-->
<script>
    var locale = '{!! app()->getLocale() !!}';
    var error_msg = '{!! trans('auth.error') !!}';
    var bug_msg = '{!! trans('auth.bug_error') !!}';
    var defaultContent = '{!! trans('labels.default_content') !!}';
    var remove = '{!! trans('labels.remove') !!}';
    var change = '{!! trans('labels.change') !!}';
    var select_file = '{!! trans('labels.select_file') !!}';
    var generate_invoce = '{!! trans('labels.generate_invoice') !!}';
    var noneSelectedTextValue = '{!! trans('labels.noneSelectedTextValue') !!}';
    var select_at_least_one = '{!! trans('temp_job.select_at_least_one') !!}';
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
    var confirm_delete = '{!! trans('ishaar_setup.cancelIshaar_confirmation') !!}';
    var after_generate_invoice = '{!! trans('ishaar_setup.after_generate_invoice') !!}';
    var add_employee = '{!! trans('ishaar_setup.actions.add_emp') !!}';
    var delete_employee = '{!! trans('ishaar_setup.actions.delete_emp') !!}';
    var only_one_employee = "{!! trans('ishaar_setup.only_one_employee') !!}";
    var must_have_employee = '{!! trans('ishaar_setup.must_have_employee') !!}';
    var already_added = '{!! trans('ishaar_setup.already_added') !!}';
    var minimum_contract_period = '{!! trans('tqawel_offer_contract.minimum_contract_period') !!}';
</script>
@if(app()->getLocale() == "ar")
    <script src="{{ asset('assets/js/front-rtl.js') }}"></script>
@else
    <script src="{{ asset('assets/js/front.js') }}"></script>
@endif
@yield('scripts')
</body>
</html>