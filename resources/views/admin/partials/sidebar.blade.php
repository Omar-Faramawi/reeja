<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar navbar-collapse collapse">
		<!-- BEGIN SIDEBAR MENU -->
		<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
			<li class="nav-item start {{ request()->is( "admin/users*" ) ? 'active open selected' : '' }}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-users"></i>
					<span class="title">{{ trans('labels.menu.manage_users') }}</span>
					<span class="arrow"></span>
				</a>
				<ul class="sub-menu">
					<li class="nav-item start {{ request()->is( "admin/users/governments_registeration*" ) ? 'active open selected' : '' }}">
						<a href="{{ url('admin/users/governments_registeration') }}" class="nav-link">
							<i class="icon-users"></i>
							<span class="title">{{ trans('governments_registeration.headings.list') }}</span>
						</a>
					</li>
					<li class="nav-item start {{ request()->is( "admin/users/establishments_registeration*" ) ? 'active open selected' : '' }}">
						<a href="{{ url('admin/users/establishments_registeration') }}" class="nav-link ">
							<i class="icon-users"></i>
							<span class="title">{{ trans('establishments_registration.headings.list') }}</span>
						</a>
					</li>
				</ul>
			</li>
			<li class="heading">
				<h3 class="uppercase">{{ trans('labels.menu.contract_name') }}</h3>
			</li>
			<li class="nav-item {{ request()->is( "admin/contractnature*" ) ? 'active open selected' : '' }}">
				<a href="{{url('admin/contractnatures')}}" class="nav-link ">
					<i class="icon-notebook"></i>
					<span class="title">{{ trans('contractnature.headings.list') }}</span>
				</a>
			</li>
			<li class="nav-item {{ request()->is('admin/contractSetup/yroea-panlp-*', 'admin/settings/professions*') || in_array(request()->segment(2),['bundles', 'saudi_percentage', 'serviceUsersPermissions', 'taqawel_ishaar_management']) ? 'active open selected':'' }}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-book-open"></i>
					<span class="title">{{ trans('contractnature.headings.taqawel') }}</span>
					<span class="arrow"></span>
				</a>
				<ul class="sub-menu">
					<li class="nav-item {{ request()->is( "admin/settings/professions*" ) ? 'active open selected' : '' }}">
						<a href="{{ url('admin/settings/professions') }}" class="nav-link ">
							<span class="title">{{ trans('professions.headings.list') }}</span>
						</a>
					</li>
					<li class="nav-item {{ (request()->is('admin/contractSetup/yroea-panlp-*') )? 'active open selected':'' }}">
						<a href="{{route('admin.contractSetup.edit', Hashids::encode(1))}}" class="nav-link ">
							<span class="title">{{trans('contract_setup.contract_setup')}}</span>
						</a>
					</li>
					<li class="nav-item {{ (request()->route()->getName() == 'admin.serviceUsersPermissions.contractType.edit' )? 'active open selected':'' }}">
						<a href="{{route('admin.serviceUsersPermissions.contractType.edit', Hashids::encode(1))}}" class="nav-link ">
							<span class="title">{{trans('service_users_permissions.service_users_permissions')}}</span>
						</a>
					</li>
					{{--
					@Removed temporarily
					<li class="nav-item {{ (request()->route()->getName() == 'admin.saudi_percentage.index' )? 'active open selected':'' }}">
						<a href="{{  route('admin.saudi_percentage.index') }}" class="nav-link ">
							<span class="title">{{ trans('saudi_percentage.menu_name') }}</span>
						</a>
					</li> --}}
					<li class="nav-item {{ (request()->route()->getName() == 'admin.taqawel_ishaar_management.edit' )? 'active open selected':'' }}">
						<a href="{{ route('admin.taqawel_ishaar_management.edit') }}" class="nav-link ">
							<span class="title">{{ trans('ishaar_setup.ishaars_bundles_management') }}</span>
						</a>
					</li>
					<li class="nav-item {{ request()->is( "admin/bundles*" ) ? 'active open selected' : '' }}">
						<a href="{{ url('admin/bundles') }}" class="nav-link ">
							<span class="title">{{ trans('bundles.headings') }}</span>
						</a>
					</li>
				</ul>
			</li>
			<li class="nav-item {{ request()->is( 'admin/settings/attachments*', 'admin/settings/occupation_management*', 'admin/contractSetup/np-lae-agboe*', 'admin/contractSetup/gbrlaroape-n*', 'admin/ishaar_setup*', 'admin/loan_pcnt*' ) ? 'active open selected' : '' }}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-clock"></i>
					<span class="title">{{ trans('contractnature.headings.temp_jobs') }}</span>
					<span class="arrow"></span>
				</a>
				<ul class="sub-menu">
					<li class="nav-item {{ request()->is( "admin/settings/attachments*" ) ? 'active open selected' : '' }}">
						<a class="nav-link" href="{{ url('admin/settings/attachments') }}">{{ trans('attachments.headings') }}</a>
					</li>
					<li class="nav-item {{ request()->is( "admin/settings/occupation_management*" ) ? 'active open selected' : '' }}">
						<a class="nav-link" href="{{ url('admin/settings/occupation_management') }}">{{ trans('occupation_managment.headings.list') }}</a>
					</li>
					<li class="nav-item {{ (request()->is('admin/contractSetup/np-lae-agboe*') )? 'active open selected':'' }}">
						<a class="nav-link" href="{{route('admin.contractSetup.edit', Hashids::encode(3))}}">
							{{trans('contract_setup.hire_labor_contracts_setup') }}
						</a>
					</li>
					<li class="nav-item {{ (request()->is('admin/contractSetup/gbrlaroape-n*') )? 'active open selected':'' }}">
						<a class="nav-link" href="{{route('admin.contractSetup.edit', Hashids::encode(4))}}"> {{trans('contract_setup.direct_emp_contracts_setup') }}
						</a>
					</li>
					<li class="nav-item {{ (request()->route()->getName() == 'admin.ishaar_setup.index' )? 'active open selected':'' }}">
						<a class="nav-link" href="{{ route('admin.ishaar_setup.index') }}">
							{{ trans('ishaar_setup.menu_name') }}
						</a>
					</li>
					<li class="nav-item {{ request()->is( "admin/loan_pcnt*" ) ? 'active open selected' : '' }}">
						<a class="nav-link" href="{{ url('admin/loan_pcnt') }}">{{ trans('loan_pcnt.headings') }}</a>
					</li>
				</ul>
			</li>
			<li class="nav-item {{ request()->is( "admin/ratingmodels*" ) ? 'active open selected' : '' }}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-star"></i>
					<span class="title">{{ trans('labels.menu.taqeem_name') }}</span>
					<span class="arrow"></span>
				</a>
				<ul class="sub-menu">
					<li class="nav-item {{ request()->is( "admin/ratingmodels*" ) ? 'active open selected' : '' }}">
						<a href="{{url('admin/ratingmodels')}}" class="nav-link ">
							<span class="title">{{trans('ratingmodels.formTitle')}}</span>
						</a>
					</li>
				</ul>
			</li>
			<li class="nav-item {{ (request()->is('admin/reports*') )? 'active open selected':'' }}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-bar-chart"></i>
					<span class="title">{{ trans('labels.reports.mainTitle') }}</span>
					<span class="arrow"></span>
				</a>
				<ul class="sub-menu">
					<li class="nav-item {{ (request()->route()->getName() == 'admin.reports.jobsChart' )? 'active open selected':'' }}">
						<a class="nav-link" href="{{ route('admin.reports.jobsChart') }}">{{ trans('labels.reports.jobsChart') }}</a>
					</li>
					<li class="nav-item {{ (request()->route()->getName() == 'admin.reports.activityIshaars' )? 'active open selected':'' }}">
						<a class="nav-link" href="{{ route('admin.reports.activityIshaars') }}">{{ trans('labels.reports.activityIshaars') }}</a>
					</li>
					<li class="nav-item {{ (request()->route()->getName() == 'admin.reports.ishaarTypesGrouped' )? 'active open selected':'' }}">
						<a class="nav-link" href="{{ route('admin.reports.ishaarTypesGrouped') }}">{{ trans('labels.reports.ishaarTypesGrouped') }}</a>
					</li>
					<li class="nav-item {{ (request()->route()->getName() == 'admin.reports.countriesIshaars' )? 'active open selected':'' }}">
						<a class="nav-link" href="{{ route('admin.reports.countriesIshaars') }}">{{ trans('labels.reports.countriesIshaars') }}</a>
					</li>
					<li class="nav-item {{ (request()->route()->getName() == 'IshaarReportChart' )? 'active open selected':'' }}">
						<a class="nav-link" href="{{ route('IshaarReportChart') }}">{{ trans('labels.reports.ishaarReport') }}</a>
					</li>
					<li class="nav-item {{ (request()->route()->getName() == 'contractSatusChart' )? 'active open selected':'' }}">
						<a class="nav-link" href="{{ route('contractSatusChart') }}">{{ trans('labels.reports.contractStatusReport') }}</a>
					</li>
					<li class="nav-item {{ (request()->route()->getName() == 'reports.packages.chart.contracts' )? 'active open selected':'' }}">
						<a class="nav-link" href="{{ route('reports.packages.chart.contracts') }}">{{ trans('contract_bundle_reports.heading') }}</a>
					</li>
					<li class="nav-item {{ (request()->route()->getName() == 'invoiceNetaqChart' )? 'active open selected':'' }}">
						<a class="nav-link" href="{{ route('invoiceNetaqChart') }}">{{ trans('labels.reports.invoiceNetaqChart') }}</a>
					</li>
					<li class="nav-item {{ (request()->route()->getName() == 'reports.packages.chart.invoices' )? 'active open selected':'' }}">
						<a class="nav-link" href="{{ route('reports.packages.chart.invoices') }}">{{ trans('invoices_bundle_reports.heading') }}</a>
					</li>
					<li class="nav-item {{ (request()->route()->getName() == 'IshaarRegionsReport' )? 'active open selected':'' }}">
						<a class="nav-link" href="{{ route('IshaarRegionsReport') }}">{{ trans('labels.reports.ishaarRegionsReport') }}</a>
					</li>
					<li class="nav-item {{ (request()->route()->getName() == 'IshaarLaborerStatusReport' )? 'active open selected':'' }}">
						<a class="nav-link" href="{{ route('IshaarLaborerStatusReport') }}">{{ trans('labels.reports.ishaarLaborerStatusReport') }}</a>
					</li>
					<li class="nav-item {{ (request()->route()->getName() == 'reports.netaq.establishment' )? 'active open selected':'' }}">
						<a class="nav-link" href="{{ route('reports.netaq.establishment') }}">{{ trans('labels.reports.invoice_netaq_diff') }}</a>
					</li>
					<li class="nav-item {{ (request()->route()->getName() == 'LaborerWithSameBenf' )? 'active open selected':'' }}">
						<a class="nav-link" href="{{ route('LaborerWithSameBenf') }}">{{ trans('labels.reports.LaborerWithSameBenf') }}</a>
					</li>
					<li class="nav-item {{ (request()->route()->getName() == 'LaborerWithMultipleIshaars' )? 'active open selected':'' }}">
						<a class="nav-link" href="{{ route('LaborerWithMultipleIshaars') }}">{{ trans('labels.reports.LaborerWithMultipleIshaars') }}</a>
					</li>
				</ul>
			</li>
		</ul>
		<!-- END SIDEBAR MENU -->
	</div>
	<!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->