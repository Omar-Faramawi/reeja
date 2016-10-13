<div class="page-header">
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top">
        <div class="container">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="logo" class="logo-default">
                </a>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a class="menu-toggler"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark"
                        id="header_notification_bar">
                        @if(app()->getLocale() == 'ar')
                            <a href="{{ action('UserController@getLocale', 'en')}}" class="dropdown-toggle">
                                <i class="icon-social-dribbble"></i> <span class="badge">En</span>
                            </a>
                        @else
                            <a href="{{ action('UserController@getLocale', 'ar')}}" class="dropdown-toggle">
                                <i class="icon-social-dribbble"></i> <span class="margin-top-10 badge">ع ر</span>
                            </a>
                        @endif
                    </li>
                    <!-- END NOTIFICATION DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    @if($auth_user)
                        <li class="dropdown dropdown-user dropdown-dark">
                            <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                               data-close-others="true">
                                <img alt="" class="img-circle" src="{{ asset('assets/img/avatar.png') }}">
                                <span class="username username-hide-mobile">{{ $auth_user->name }}
                                @if(session()->has('selected_establishment.name'))
                                    <br><span class="establishment">{{ session('selected_establishment.name')  }}</span>
                                @endif
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                {{--<li>
                                    <a href="#">
                                        <i class="icon-user"></i> {{ trans('front.header.profile') }} </a>
                                </li>
                                <li class="divider"></li>--}}
                                @if(session('auth.type') == 'mol')
                                    <li>
                                        <a href="{{ url('/establishments') }}">
                                            <i class="icon-reload"></i> {{ trans('establishments_registration.change') }}
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                @elseif(session('auth.type') == 3)
                                    <li>
                                        <a href="{{ url('establishment/edit') }}">
                                            <i class="icon-reload"></i> {{ trans('establishment.can_change') }}
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                @endif
                                <li>
                                    <a href="{{ url('/logout') }}">
                                        <i class="icon-logout"></i> {{ trans('front.header.logout') }} </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <a class="btn btn-primary green margin-top-10" href="{{ url('/login') }}"> <i
                                    class="fa fa-user"></i> {{ trans('front.header.login') }}</a>
                        @endif
                                <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- END HEADER TOP -->
    <!-- BEGIN HEADER MENU -->
    <div class="page-header-menu">
        <div class="container">
            <!-- BEGIN MEGA MENU -->
            <div class="hor-menu">
                <ul class="nav navbar-nav">

                    <li class="menu-dropdown classic-menu-dropdown {{ ($current_route_name === null ) ? "active" : "" }}">
                        <a href="{{ url('/') }}"> <i class="icon-home"></i>  {{ trans('labels.home') }}
                            <span class="arrow"></span>
                        </a>
                    </li>

                    <li class="menu-dropdown mega-menu-dropdown {{ !in_array($current_route_name, ['about', 'faq', 'support', 'terms']) ?: "active" }}">
                        <a> <i class="icon-info"></i>
                            {{ trans('front.menu.about') }}
                            <span class="arrow"></span>
                        </a>
                        <ul class="dropdown-menu pull-left">
                            <li class="">
                                <a href="{{ url('/about') }}"
                                   class="nav-link  "> {{ trans('front.menu.definition') }}</a>
                            </li>
                            {{--<li class="">
                                <a href="{{ url('/terms') }}" class="nav-link  "> {{ trans('front.menu.terms') }}</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/faq') }}" class="nav-link  "> {{ trans('front.menu.faq') }}</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/support') }}"> {{ trans('front.menu.help') }}
                                    <span class="arrow"></span>
                                </a>
                            </li>--}}
                        </ul>
                    </li>

                    @if(auth()->check())
                    @if(auth()->user()->user_type_id == \Tamkeen\Ajeer\Utilities\Constants::USERTYPES['job_seeker'])
                    <li class="menu-dropdown classic-menu-dropdown">
                        <a><i class="icon-briefcase"></i>
                            <span class="arrow"></span>
                            {{ trans('labor_market.job_seeker') }}
                        </a>
                        <ul class="dropdown-menu pull-left">
                            <li>
                                <a href="{{url('/cv')}}">
                                    {{trans('cv_publishment.cv_publishment')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/job_search')}}">
                                    {{trans('labor_market.labor_market')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/offersdirect')}}">
                                    {{trans('offersdirect.receivedOffers')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/work_completion_certificate')}}">
                                    {{trans('front.menu.work_completion_cert')}}
                                </a>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="nav-link nav-toggle">
                                    {{ trans('front.menu.cancel_approve') }}
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ url('contracts/cancelation/seeker/direct_hiring/provider') }}"
                                           class='nav-link'>{{ trans('contracts_cancelation.contracts') }}</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('contracts/cancelation/seeker/direct_hiring/ishaar/provider') }}"
                                           class='nav-link'>{{ trans('contracts_cancelation.ishaar') }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-dropdown mega-menu-dropdown">
                        <a href="{{url('/my_invoices')}}">
                            <i class="icon-layers"></i>
                            {{ trans('front.menu.invoices') }}
                            <span class="arrow"></span>
                        </a>
                    </li>
                    @else
                    <li class="menu-dropdown classic-menu-dropdown {{ ( in_array($current_route_name, ["labor-market.index", "received-contracts.view"]) ) ? "active" : "" }}">
                        <a class=""> <i
                                    class="icon-briefcase"></i> {{ trans('front.menu.temp_work') }}
                            <span class="arrow"></span>
                        </a>
                        <ul class="dropdown-menu pull-left">
                            <li class="dropdown-submenu">
                                <a class="nav-link nav-toggle">
                                    {{ trans('front.menu.hire_labor') }}
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="">
                                        <a href="{{ url('laborer') }}"
                                           class="nav-link">{{ trans('front.menu.laborer') }}</a>
                                    </li>
                                    <li class="">
                                        <a href="{{ route("labor-market.index") }}"
                                           class="nav-link"> {{ trans('front.menu.work_market') }}</a>
                                    </li>
                                    <li class="">
                                        <a href="{{ route("occasional-labor-market.index") }}"
                                           class=""> {{ trans('front.menu.occasional_work') }}</a>
                                    </li>
                                    <li class="">
                                        <a href="{{ route("received-contracts.view") }}"
                                           class="nav-link"> {{ trans('front.menu.received') }}</a>
                                    </li>
                                    <li class="">
                                        <a href="{{ url("offers") }}"
                                           class="nav-link"> {{ trans('offers.receivedOffers') }}</a>
                                    </li>
                                    <li class="">
                                        <a href="{{ route('tempwork.contracts') }}"
                                           class="nav-link"> {{ trans('front.menu.temp_work_contracts') }}</a>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a class="nav-link"> {{ trans('front.menu.cancel_approve') }}
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="nav-link"
                                                   href="{{ url('contracts/cancelation/provider' )}}">{{ trans('contracts_cancelation.contracts') }}</a>
                                            </li>
                                            <li>
                                                <a class="nav-link"
                                                   href="{{ url('contracts/cancelation/ishaar/provider' )}}">{{ trans('contracts_cancelation.ishaar') }}</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="{{route('follow_contracts', ['ct_id' => \Tamkeen\Ajeer\Utilities\Constants::CONTRACTTYPES['hire_labor'], 'prvd_benf' => 1])}}">{{trans('front.menu.contract_follow')}}</a></li>
                                    <li class="">
                                        <a href="{{url('/vacancies')}}"
                                           class="nav-link"> {{ trans('vacancies.headings.tab_head') }}</a>
                                    </li>

                                    <li class="">
                                        <a href="{{url('/ishaar')}}"
                                           class="nav-link"> {{ trans('front.menu.notices') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu ">
                                <a class="nav-link">
                                    {{ trans('front.menu.temp_direct_contract') }}
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    @if(auth()->user()->user_type_id == \Tamkeen\Ajeer\Utilities\Constants::USERTYPES['saudi'])
                                    <li class="">
                                        <a href="{{url('/cv')}}"
                                           class="nav-link"> {{ trans('front.menu.publish_cv') }}</a>
                                    </li>
                                    @endif

                                    <li class="">
                                        <a href="{{url('/direct-hiring/labor-market')}}"
                                           class="nav-link"> {{ trans('front.menu.work_market') }}</a>
                                    </li>
                                    <li class="">
                                        <a href="{{ route('direct_hiring.contracts.received-contracts') }}" class="nav-link"> {{ trans('front.menu.received') }}</a>
                                    </li>

                                    @if(auth()->user()->user_type_id == \Tamkeen\Ajeer\Utilities\Constants::USERTYPES['saudi'])
                                    <li>
                                        <a href="{{url('/offersdirect')}}">
                                            {{trans('offersdirect.receivedOffers')}}
                                        </a>
                                    </li>
                                    @endif

                                    <li class="">
                                        <a href="{{ route('direct_hiring.contracts') }}"
                                           class="nav-link"> {{ trans('front.menu.temp_direct_contract') }}</a>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a class="nav-link">
                                            {{ trans('front.menu.cancel_approve') }}
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>

                                                <a href="{{ url('contracts/cancelation/direct_hiring/beneficial') }}"
                                                   class='nav-link'>{{ trans('contracts_cancelation.contracts') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('contracts/cancelation/direct_hiring/ishaar/beneficial') }}"
                                                   class='nav-link'>{{ trans('contracts_cancelation.ishaar') }}</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="{{route('follow_contracts', ['ct_id' => \Tamkeen\Ajeer\Utilities\Constants::CONTRACTTYPES['direct_emp'], 'prvd_benf' => 2])}}">{{ trans('front.menu.contract_follow') }}</a></li>
                                    <li class="">
                                        <a href="{{url('/vacancies')}}"
                                           class="nav-link"> {{ trans('vacancies.headings.tab_head') }}</a>
                                    </li>
                                    <li class="">
                                        <a href="{{url('/direct_ishaar')}}"
                                           class="nav-link"> {{ trans('front.menu.notices') }}</a>
                                    </li>

                                    @if(auth()->user()->user_type_id == \Tamkeen\Ajeer\Utilities\Constants::USERTYPES['saudi'])
                                    <li>
                                        <a href="{{url('/work_completion_certificate')}}">
                                            {{trans('front.menu.work_completion_cert')}}
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>

                            @if(auth()->check())
                                @if (session('government.hajj') == '1')
                                    <li class="">
                                        <a href="{{route('hajj.gov.approval')}}"
                                           class="nav-link"> {{ trans('hajj_est.hajj_est_approval') }}</a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                    </li>
                    <li class="menu-dropdown classic-menu-dropdown">
                        <a> <i class="icon-briefcase"></i>
                            {{ trans('front.menu.tqawel') }}
                            <span class="arrow"></span>
                        </a>
                        <ul class="dropdown-menu pull-left">
                            <li class="">
                                <a class="nav-link" href="{{ route('taqawel.market') }}"> {{ trans('front.menu.work_market') }}</a>
                            </li>
                            <li class="">
                                <a class="nav-link" href="{{ route('taqawel.received-contracts') }}"> {{ trans('front.menu.received') }}</a>
                            </li>
                            <li class="">
                                <a class="nav-link" href="{{ route('taqawel.contracts') }}"> {{ trans('front.menu.contracts') }}</a>
                            </li>
                            <li class="">
                                <a class="nav-link" href="{{url("taqawel/offers")}}"> {{ trans('front.menu.receivedOffers') }}</a>
                            </li>
                            <li><a href="{{route('follow_contracts', ['ct_id' => \Tamkeen\Ajeer\Utilities\Constants::CONTRACTTYPES['taqawel'], 'prvd_benf' => 1])}}">{{trans('front.menu.contract_follow')}}</a></li>
                            <li class="dropdown-submenu">
                                <a class="nav-link nav-toggle">
                                    {{ trans('front.menu.cancel_approve') }}
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="">
                                        <a href="{{ url('taqawel/contracts/cancellation/provider') }}" class="nav-link">{{ trans('contracts_cancelation.contracts') }}</a>
                                    </li>
                                    <li class="">
                                        <a href="{{ url('taqawel/contracts/cancellation/ishaar/provider') }}" class="nav-link">{{ trans('contracts_cancelation.ishaar') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="">
                                <a class="nav-link"
                                   href="{{url('/taqawel/publishservice')}}"> {{ trans('front.menu.taqawel_services') }}</a>
                            </li>
							<li class="">
                                <a class="nav-link"
                                   href="{{url('/taqawel/taqawelService')}}"> {{ trans('front.menu.taqawel_requests') }}</a>
                            </li>
                            <li class="">
                                <a class="nav-link"
                                   href="{{url('/taqawel/notices')}}"> {{ trans('front.menu.taqawel_notices') }}</a>
                            </li>
                            <li class="">
                                <a class="nav-link"
                                   href="{{url('/taqawel/packagesubsribe')}}"> {{ trans('front.menu.packageSubscribe') }}</a>
                            </li>
                        </ul>
                    </li>
                    {{-- <li class="menu-dropdown mega-menu-dropdown">
                        <a> <i class="icon-bar-chart"></i>
                            {{ trans('front.menu.taqyeem') }}
                            <span class="arrow"></span>
                        </a>
                    </li> --}}
                    <li class="menu-dropdown mega-menu-dropdown">
                         <a href="{{url('/my_invoices')}}">
                          <i class="icon-layers"></i>
                            {{ trans('front.menu.invoices') }}
                            <span class="arrow"></span>
                        </a>
                    </li>
                    @endif
                    @endif
                </ul>
            </div>
            <!-- END MEGA MENU -->
        </div>
    </div>
    <!-- END HEADER MENU -->
</div>
