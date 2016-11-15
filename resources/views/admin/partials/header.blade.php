<!-- BEGIN HEADER -->
<header class="page-header">
    <nav class="navbar mega-menu" role="navigation">
        <div class="container-fluid">
            <div class="clearfix navbar-fixed-top">
                <!-- Brand and toggle get grouped for better mobile display -->
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target=".navbar-responsive-collapse">
                    <span class="sr-only">{{ trans('teleworkportal.actions') }}</span>
                    <span class="toggle-icon">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </span>
                </button>
                <!-- End Toggle Button -->
                <!-- BEGIN LOGO -->
                <a id="index" class="page-logo" href="{{ url('/admin') }}">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo"> </a>
                <!-- END LOGO -->
                <!-- BEGIN SEARCH -->
                {{--<form class="search" action="#" method="GET">--}}
                {{--<input type="name" class="form-control" name="query"--}}
                {{--placeholder="{{ trans('user.action_search') }}...">--}}
                {{--<a href="javascript:;" class="btn submit">--}}
                {{--<i class="fa fa-search"></i>--}}
                {{--</a>--}}
                {{--</form>--}}
                        <!-- END SEARCH -->
                <!-- BEGIN TOPBAR ACTIONS -->
                <div class="topbar-actions">
                    <!-- BEGIN GROUP NOTIFICATION -->
                    <div class="btn-group-notification btn-group pull-right" id="header_notification_bar">
                        @if(app()->getLocale() == 'ar')
                            <a href="{{ action('UserController@getLocale', 'en')}}">
                                <button type="button" class="quick-sidebar-toggler btn btn-sm dropdown-toggle"><i
                                            class="icon-social-dribbble"></i> <span class="badge">En</span></button>
                            </a>
                        @else
                            <a href="{{ action('UserController@getLocale', 'ar')}}">
                                <button type="button" class="quick-sidebar-toggler btn btn-sm dropdown-toggle"><i
                                            class="icon-social-dribbble"></i> <span class="badge">ع ر</span></button>
                            </a>
                        @endif
                    </div>
                    <!-- END GROUP NOTIFICATION -->
                    <!-- BEGIN USER PROFILE -->
                    <div class="btn-group-img btn-group">
                        <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown"
                                data-hover="dropdown" data-close-others="true">
                            <span>{{ $auth_user->name }}</span>
                            <img src="{{ asset('assets/img/avatar.png') }}" alt=""></button>
                    </div>
                    <!-- END USER PROFILE -->
                    <!-- BEGIN GROUP INFORMATION -->
                    <div class="btn-group-red btn-group">
                        <a href="{{ url('/logout') }}" class="label-danger">
                            <button type="button" class="btn btn-sm dropdown-toggle" title="{{ trans('auth.logout') }}">
                                <i class="fa fa-sign-out"></i>
                            </button>
                        </a>
                    </div>
                    <!-- END GROUP INFORMATION -->
                </div>
                <!-- END TOPBAR ACTIONS -->
            </div>
            <!-- BEGIN HEADER MENU -->
            <div class="nav-collapse collapse navbar-collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">

                    <li class="dropdown dropdown-fw {{ (request()->path()=='admin' || request()->is( "admin/users*" ) || request()->is('admin/reports*') )? 'active open selected':'' }}">
                        <a href="javascript:;" class="text-uppercase">
                            <i class="icon-home"></i> {{ trans('user.dashboardwidgets') }} </a>
                        <ul class="dropdown-menu dropdown-menu-fw">
                            <li class="active">
                                <a href="{{ url('/admin') }}"><i
                                            class="icon-home"></i> {{ trans('user.dashboardwidgets') }}</a>
                            </li>
                            {{--<li class="active"><a href="{{ url('admin/users/user_types') }}">--}}
                            {{--<i class="icon-puzzle"></i> {{ trans('user_types.headings.list') }}</a>--}}
                            {{--</li>--}}
                            <li class="active"><a href="{{ url('admin/users/governments_registeration') }}">
                                    <i class="icon-puzzle"></i> {{ trans('governments_registeration.headings.list') }}
                                </a>
                            </li>
                            <li class="active"><a href="{{ url('admin/users/establishments_registeration') }}">
                                    <i class="icon-puzzle"></i> {{ trans('establishments_registration.headings.list') }}
                                </a>
                            </li>
                            <li class="active"><a href="{{ url('admin/users/individuals') }}">
                                    <i class="icon-puzzle"></i> {{ trans('user_types.individuals') }}</a>
                            </li>
                            <li class="dropdown more-dropdown-sub active">
                                <a href="javascript:;">
                                    <i class="fa fa-puzzle"></i> {{ trans('labels.reports.mainTitle') }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-fw">
                                    <li class="active">
                                        <a href="{{ route('admin.reports.jobsChart') }}">{{ trans('labels.reports.jobsChart') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ route('admin.reports.activityIshaars') }}">{{ trans('labels.reports.activityIshaars') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ route('admin.reports.ishaarTypesGrouped') }}">{{ trans('labels.reports.ishaarTypesGrouped') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ route('admin.reports.countriesIshaars') }}">{{ trans('labels.reports.countriesIshaars') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ route('IshaarReportChart') }}">{{ trans('labels.reports.ishaarReport') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ route('contractSatusChart') }}">{{ trans('labels.reports.contractStatusReport') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ route('reports.packages.chart.contracts') }}">{{ trans('contract_bundle_reports.heading') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ route('invoiceNetaqChart') }}">{{ trans('labels.reports.invoiceNetaqChart') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ route('reports.packages.chart.invoices') }}">{{ trans('invoices_bundle_reports.heading') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ route('IshaarRegionsReport') }}">{{ trans('labels.reports.ishaarRegionsReport') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ route('IshaarLaborerStatusReport') }}">{{ trans('labels.reports.ishaarLaborerStatusReport') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ route('reports.netaq.establishment') }}">{{ trans('labels.reports.invoice_netaq_diff') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ route('LaborerWithSameBenf') }}">{{ trans('labels.reports.LaborerWithSameBenf') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ route('LaborerWithMultipleIshaars') }}">{{ trans('labels.reports.LaborerWithMultipleIshaars') }}</a>
                                    </li>
                                </ul>
                            </li>
                            {{--<li class="dropdown more-dropdown-sub active">--}}
                            {{--<a href="javascript:;" class="text-uppercase">--}}
                            {{--<i class="icon-puzzle"></i> {{ trans('professions.settings') }}</a>--}}
                            {{--<ul class="dropdown-menu">--}}
                            {{--<li class="active">--}}
                            {{--<a href="{{ url('admin/settings/nationalities') }}">{{ trans('nationalities.headings') }}</a>--}}
                            {{--</li>--}}
                            {{--<li class="active">--}}
                            {{--<a href="{{ url('admin/settings/reasons') }}">{{ trans('reasons.headings') }}</a>--}}
                            {{--</li>--}}
                            {{--<li class="active">--}}
                            {{--<a href="{{ url('admin/settings/banks') }}">{{ trans('banks.headings') }}</a>--}}
                            {{--</li>--}}
                            {{--<li class="active">--}}
                            {{--<a href="{{ url('admin/settings/experiences') }}">{{ trans('experiences.headings') }}</a>--}}
                            {{--</li>--}}
                            {{--<li class="active">--}}
                            {{--<a href="{{ url('admin/settings/estsizes') }}">{{ trans('est_sizes.headings') }}</a>--}}
                            {{--</li>--}}
                            {{--</ul>--}}
                            {{--</li>--}}
                        </ul>
                    </li>

                    {{--<li class="dropdown dropdown-fw {{ in_array(request()->segment(2),['ishaar_types', 'regions', 'ishaar_setup']) ? 'active open selected' : '' }} ">--}}
                    {{--<a href="javascript:;" class="text-uppercase">--}}
                    {{--<i class="icon-briefcase"></i> {{ trans('labels.menu.ishaar_name') }} </a>--}}
                    {{--<ul class="dropdown-menu dropdown-menu-fw">--}}
                    {{--<li class="active">--}}
                    {{--<a href="{{ route('admin.ishaar_types.index') }}"><i--}}
                    {{--class="icon-briefcase"></i> {{ trans('ishaar_types.menu_name') }}</a>--}}
                    {{--</li>--}}
                    {{--<li class="active">--}}
                    {{--<a href="{{ route('admin.regions.index') }}"><i--}}
                    {{--class="icon-briefcase"></i> {{ trans('regions.menu_name') }} </a>--}}
                    {{--</li>--}}
                    {{--<li class="active">--}}
                    {{--<a href="{{ route('admin.ishaar_setup.index') }}"><i--}}
                    {{--class="icon-briefcase"></i> {{ trans('ishaar_setup.menu_name') }}--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--</ul>--}}
                    {{--</li>--}}

                    <li class="dropdown dropdown-fw
                    {{ in_array(request()->segment(2),['settings', 'loan_pcnt','bundles', 'ishaar_setup', 'saudi_percentage', 'serviceUsersPermissions', 'contractnatures','contracttypes', 'contractSetup', 'usersPermissions', 'ishaarPermissions', 'taqawel_ishaar_management']) ? 'active open selected':'' }}"
                    >
                        <a href="javascript:;" class="text-uppercase">
                            <i class="icon-tag"></i>{{ trans('labels.menu.contract_name') }} </a>
                        <ul class="dropdown-menu dropdown-menu-fw">
                            {{--<li class="active">--}}
                            {{--<a href="{{url("admin/contracttypes")}}"><i--}}
                            {{--class="icon-tag"></i> {{ trans('contract_setup.contract_setup') }}</a>--}}
                            {{--</li>--}}
                            <li class="active">
                                <a href="{{url("admin/contractnatures")}}"><i
                                            class="icon-tag"></i> {{ trans('contractnature.headings.list') }}</a>
                            </li>
                            <li class="dropdown more-dropdown-sub active">
                                <a href="javascript:;">
                                    <i class="fa fa-balance-scale"></i> {{ trans('contractnature.headings.taqawel') }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-fw">
                                    <li class="active">
                                        <a href="{{ url('admin/settings/professions') }}">{{ trans('professions.headings.list') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{route('admin.contractSetup.edit', Hashids::encode(1))}}">  {{trans('contract_setup.contract_setup')}}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{route('admin.serviceUsersPermissions.contractType.edit', Hashids::encode(1))}}">
                                            {{trans('service_users_permissions.service_users_permissions')}}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{  route('admin.saudi_percentage.index') }}">  {{ trans('saudi_percentage.menu_name') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ route('admin.taqawel_ishaar_management.edit') }}">
                                            {{ trans('ishaar_setup.ishaars_bundles_management') }}
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ url('admin/bundles') }}">{{ trans('bundles.headings') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown more-dropdown-sub active">
                                <a href="javascript:;">
                                    <i class="fa fa-balance-scale"></i> {{ trans('contractnature.headings.temp_jobs') }}
                                </a>
                                <ul class="dropdown-menu">
                                    {{--<li class="active">--}}
                                    {{--<a href="{{ url('admin/settings/qualifications') }}">{{ trans('qualifications.headings') }}</a>--}}
                                    {{--</li>--}}
                                    <li class="active">
                                        <a href="{{ url('admin/settings/attachments') }}">{{ trans('attachments.headings') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ url('admin/settings/occupation_management') }}">{{ trans('occupation_managment.headings.list') }}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{route('admin.contractSetup.edit', Hashids::encode(2))}}">
                                            {{trans('contract_setup.hire_labor_contracts_setup') }}
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="{{route('admin.contractSetup.edit', Hashids::encode(3))}}"> {{trans('contract_setup.direct_emp_contracts_setup') }}
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ route('admin.ishaar_setup.index') }}">
                                            {{ trans('ishaar_setup.menu_name') }}
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="{{ url('/admin/loan_pcnt') }}">{{ trans('loan_pcnt.headings') }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown dropdown-fw  {{ (request()->path()=='admin/ratingmodels')?'active open selected':'' }}">
                        <a href="javascript:;" class="text-uppercase">
                            <i class="icon-layers"></i> {{ trans('labels.menu.taqeem_name') }} </a>
                        <ul class="dropdown-menu dropdown-menu-fw">
                            <li class="active">
                                <a href="{{url("admin/ratingmodels")}}"><i
                                            class="icon-layers"></i>{{trans('ratingmodels.formTitle')}}</a>
                            </li>

                        </ul>
                    </li>

                </ul>
            </div>
            <!-- END HEADER MENU -->
        </div>
        <!--/container-->
    </nav>
</header>
<!-- END HEADER -->
