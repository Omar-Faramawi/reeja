<header>
    <div class="container">
        <div class="top_header">

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-9 top_navigation">
                    <nav>
                        @if($auth_user)
                            <a href="#">
                                <i class="icon icon-user"></i>
                                {{ $auth_user->name }}
                                @if(session()->has('selected_establishment.name'))
                                    - <span class="establishment">{{ session('selected_establishment.name')  }}</span>
                                @endif
                            </a>
                            @if(session('auth.type') == 'mol')
                                <a href="{{ url('/establishments') }}">
                                    <i class="icon icon-share-alt"></i>
                                    {{ trans('establishments_registration.change') }}
                                </a>
                            @endif
                            @if(session()->has('selected_establishment'))
                                <a href="{{ url('establishment/edit') }}">
                                    <i class="icon icon-wrench"></i>
                                    {{ trans('establishment.can_change') }}
                                </a>
                            @endif

                            <a href="{{ url('/logout') }}">
                                <i class="icon icon-logout"></i>
                                {{ trans('front.header.logout') }}
                            </a>
                        @else
                            <a href="{{ url('/login') }}">
                                <i class="icon icon-user"></i>
                                {{ trans('front.header.login') }}
                            </a>
                        @endif

                        @if(app()->getLocale() == 'ar')
                            <a href="{{ action('UserController@getLocale', 'en')}}">
                                <i class="icon icon-lang-en"></i>
                                English
                            </a>
                        @else
                            <a href="{{ action('UserController@getLocale', 'ar')}}">
                                <i class="icon icon-lang-ar"></i>
                                عربي
                            </a>
                        @endif
                    </nav>
                </div>

                <h1 class="col-md-2 col-sm-2 col-xs-3 logo"><a href="{{ url('/') }}" title="{{ trans('labels.home') }}"></a></h1>

                <div class="col-md-10 col-sm-12  page-header">
                    <!-- Navbar -->
                    <div class="page-header-top">
                        <a class="menu-toggler"></a>

                        <div class="page-header-menu clearfix">
                            <div class="hor-menu">
                                <ul class="nav navbar-nav">
                                    <!--<li class="{{ ($current_route_name === null ) ? "active" : "" }}">
                                        <a href="{{ url('/') }}"> <i class="icon-home"></i> {{ trans('labels.home') }}
                                        </a>
                                    </li>-->
                                    <li>
                                        <a href="{{ url('/about') }}"> <i class="icon-info"></i> {{ trans('front.menu.about') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/terms') }}"> <i class="icon-book-open"></i> {{ trans('front.menu.terms') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/faq') }}"> <i class="icon-question"></i> {{ trans('front.menu.faq') }}
                                        </a>
                                    </li>
                                    @if(auth()->check())
                                    <li class="menu-dropdown classic-menu-dropdown">
                                        <a>
                                            <i class="icon-folder-alt"></i>
                                            {{ trans('front.menu.services') }}
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu pull-left">
                                        @if(auth()->user()->user_type_id == \Tamkeen\Ajeer\Utilities\Constants::USERTYPES['job_seeker'])
                                            <li class="dropdown-submenu">
                                                <a>
                                                    <i class="icon-user"></i>
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
                                                        <a href="{{url('/direct_ishaar')}}"
                                                           class="nav-link"> {{ trans('front.menu.notices') }}</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{url('/work_completion_certificate')}}">
                                                            {{trans('front.menu.work_completion_cert')}}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('contracts/cancelation/seeker/direct_hiring/ishaar/provider') }}">
                                                            {{trans('front.menu.cancel_approve')}}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="menu-dropdown mega-menu-dropdown">
                                                <a href="{{url('/my_invoices')}}">
                                                    <i class="icon-credit-card"></i>
                                                    {{ trans('front.menu.invoices') }}
                                                    <span class="arrow"></span>
                                                </a>
                                            </li>
                                        @elseif(auth()->user()->user_type_id != \Tamkeen\Ajeer\Utilities\Constants::USERTYPES['admin'])
                                            <li class="dropdown-submenu {{ ( in_array($current_route_name, ["labor-market.index", "received-contracts.view"]) ) ? "active" : "" }}">
                                                <a class="nav-link nav-toggle" data-toggle="dropdown"> <i
                                                            class="icon-clock"></i> {{ trans('front.menu.temp_work') }}
                                                    <span class="arrow"></span>
                                                </a>
                                                <ul class="dropdown-menu pull-left">
                                                    <li class="dropdown-submenu">
                                                        <a class="nav-link nav-toggle" data-toggle="dropdown">
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
                                                                <a class="nav-link"
                                                                   data-toggle="dropdown"> {{ trans('front.menu.cancel_approve') }}
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
                                                            <li>
                                                                <a href="{{route('follow_contracts', ['ct_id' => \Tamkeen\Ajeer\Utilities\Constants::CONTRACTTYPES['hire_labor'], 'prvd_benf' => 1])}}">{{trans('front.menu.contract_follow')}}</a>
                                                            </li>
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
                                                        <a class="nav-link" data-toggle="dropdown">
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
                                                                <a href="{{ route('direct_hiring.contracts.received-contracts') }}"
                                                                   class="nav-link"> {{ trans('front.menu.received') }}</a>
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
                                                            <li>
                                                                <a href="{{ url('contracts/cancelation/direct_hiring/ishaar/beneficial') }}">
                                                                    {{trans('front.menu.cancel_approve')}}
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{route('follow_contracts', ['ct_id' => \Tamkeen\Ajeer\Utilities\Constants::CONTRACTTYPES['direct_emp'], 'prvd_benf' => 2])}}">{{ trans('front.menu.contract_follow') }}</a>
                                                            </li>
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
                                            <li class="dropdown-submenu">
                                                <a href="#" data-toggle="dropdown"> <i class="icon-briefcase"></i>
                                                    {{ trans('front.menu.tqawel') }}
                                                    <span class="arrow"></span>
                                                </a>
                                                <ul class="dropdown-menu pull-left">
                                                    <li class="">
                                                        <a class="nav-link"
                                                           href="{{ route('taqawel.market') }}"> {{ trans('front.menu.work_market') }}</a>
                                                    </li>
                                                    <li class="">
                                                        <a class="nav-link"
                                                           href="{{ route('taqawel.received-contracts') }}"> {{ trans('front.menu.received') }}</a>
                                                    </li>
                                                    <li class="">
                                                        <a class="nav-link"
                                                           href="{{ route('taqawel.contracts') }}"> {{ trans('front.menu.contracts') }}</a>
                                                    </li>
                                                    <li class="">
                                                        <a class="nav-link"
                                                           href="{{url("taqawel/offers")}}"> {{ trans('front.menu.receivedOffers') }}</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('follow_contracts', ['ct_id' => \Tamkeen\Ajeer\Utilities\Constants::CONTRACTTYPES['taqawel'], 'prvd_benf' => 1])}}">{{trans('front.menu.contract_follow')}}</a>
                                                    </li>
                                                    <li class="dropdown-submenu">
                                                        <a class="nav-link nav-toggle" data-toggle="dropdown">
                                                            {{ trans('front.menu.cancel_approve') }}
                                                            <span class="arrow"></span>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li class="">
                                                                <a href="{{ url('taqawel/contracts/cancellation/provider') }}"
                                                                   class="nav-link">{{ trans('contracts_cancelation.contracts') }}</a>
                                                            </li>
                                                            <li class="">
                                                                <a href="{{ url('taqawel/contracts/cancellation/ishaar/provider') }}"
                                                                   class="nav-link">{{ trans('contracts_cancelation.ishaar') }}</a>
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
                                                    <li>
                                                        <a class="nav-link"
                                                           href="{{url('/taqawel/packagesubsribe/my_packages')}}"> {{ trans('front.menu.myPackages') }}</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="menu-dropdown mega-menu-dropdown">
                                                <a href="{{url('/my_invoices')}}">
                                                    <i class="icon-credit-card"></i>
                                                    {{ trans('front.menu.invoices') }}
                                                    <span class="arrow"></span>
                                                </a>
                                            </li>
                                        @endif
                                        </ul>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</header>