<?php

//Admin Auth
Route::controller('/admin/auth', 'Admin\Auth\AuthController');
Route::controllers(['/admin/password' => 'Admin\Auth\PasswordController']);
Route::group(['middleware' => ['admin_auth']], function () {

    Route::group(['prefix' => 'admin'], function () {
        Route::resource("/contractnatures", "Admin\ContractNatureController");
        Route::patch("/contractnatures/approve/{id}", "Admin\ContractNatureController@approve");
        Route::patch("/contractnatures/reject/{id}", "Admin\ContractNatureController@reject");
        Route::patch("/ratingmodels/addSession", "Admin\RatingModelsController@addSession");
        Route::patch("/ratingmodels/removeFromSession/{id}", "Admin\RatingModelsController@removeFromSession");
        Route::resource("/ratingmodels", "Admin\RatingModelsController");
        Route::patch("/ratingmodels/approve/{id}", "Admin\RatingModelsController@approve");
        Route::patch("/ratingmodels/reject/{id}", "Admin\RatingModelsController@reject");
        Route::get('contractSetup/{id}/edit', 'Admin\ContractSetupController@edit')->name('admin.contractSetup.edit');
        Route::get('contract-members-taqyeem',
            ['as' => 'nextToTaqyeemFromForm', 'uses' => 'Admin\ContractMembersTaqyeemController@index']);
        Route::get('contract-members-taqyeem/{id}',
            ['as' => 'nextToTaqyeem', 'uses' => 'Admin\ContractMembersTaqyeemController@index']);
        Route::post('contract-members-taqyeem',
            ['as' => 'nextToTaqyeemPost', 'uses' => 'Admin\ContractMembersTaqyeemController@store']);

        Route::get('view-resident-details',
            ['as' => 'view.resident.details', 'uses' => 'Admin\ContractMembersTaqyeemController@viewResidentDetails']);
        Route::get('view-taqyeem-ajeer/{taqyeem_tempplate_id}', [
            'as'   => 'view.taqyeem.ajeer',
            'uses' => 'Admin\ContractMembersTaqyeemController@viewTaqyeemContractAjeer'
        ]);
        Route::get('view-taqyeem-individuals/{taqyeem_template_id}', [
            'as'   => 'view.taqyeem.individuals',
            'uses' => 'Admin\ContractMembersTaqyeemController@viewTaqyeemContractIndividuals'
        ]);
        Route::get('searchTaqyeemUsers', [
            'as'   => 'view.taqyeem.search.users',
            'uses' => 'Admin\ContractMembersTaqyeemController@searchTaqyeemUsers'
        ]);

        Route::patch('contractSetup/{id}/update',
            'Admin\ContractSetupController@update')->name('admin.contractSetup.update');
        Route::patch('contractSetup/{id}/updateTaqawel',
            'Admin\ContractSetupController@updateTaqawel')->name('admin.contractSetup.updateTaqawel');

        Route::get('serviceUsersPermissions/contractType/{id}/edit',
            'Admin\ServiceUsersPermissionsController@edit')->name('admin.serviceUsersPermissions.contractType.edit');
        Route::patch('serviceUsersPermissions/contractType/{id}/update',
            'Admin\ServiceUsersPermissionsController@update')->name('admin.serviceUsersPermissions.contractType.update');
        Route::resource('ishaarPermissions', 'Admin\IshaarPermissionsController');
        Route::resource("/contracttypes", "Admin\ContractTypeController");
        Route::patch("/contracttypes/approve/{id}", "Admin\ContractTypeController@approve");
        Route::patch("/contracttypes/reject/{id}", "Admin\ContractTypeController@reject");
        Route::resource('/', 'Admin\AdminController');

        // Users Routes
        Route::group(['prefix' => 'users'], function () {
            Route::resource('/user_types', 'Admin\Users\UserTypesController');
            Route::resource('/governments_registeration', 'Admin\Users\GovernmentsRegistrationController');
            Route::get('/establishments_registeration/establishmentData', [
                'as'   => 'admin.users.establishments_registeration.establishmentData',
                'uses' => 'Admin\Users\EstablishmentsRegistrationController@establishmentData',
            ]);
            Route::resource('/establishments_registeration', 'Admin\Users\EstablishmentsRegistrationController');
            Route::resource('/individuals', 'Admin\Users\IndividualsController');
        });

        Route::resource('/ishaar_types', 'Admin\IshaarTypeController');

        /* Settings Routes */
        Route::group(['prefix' => 'settings'], function () {
            Route::get('professions',
                ['as' => 'admin.settings.professions.index', 'uses' => 'Admin\Settings\ProfessionsController@index']);
            Route::get('professions/search', [
                'as'   => 'admin.settings.professions.search',
                'uses' => 'Admin\Settings\ProfessionsController@search',
            ]);
            Route::patch('professions/search/update', [
                'as'   => 'admin.settings.professions.updateforsearch',
                'uses' => 'Admin\Settings\ProfessionsController@updateForSearch',
            ]);
            Route::patch('professions/update', [
                'as'   => 'admin.settings.professions.update',
                'uses' => 'Admin\Settings\ProfessionsController@update',
            ]);
            Route::get('occupation_management', [
                'as'   => 'admin.settings.occupation_management.index',
                'uses' => 'Admin\Settings\OccupationManagementController@index'
            ]);
            Route::get('occupation_management/search', [
                'as'   => 'admin.settings.occupation_management.search',
                'uses' => 'Admin\Settings\OccupationManagementController@search',
            ]);
            Route::patch('occupation_management/search/update', [
                'as'   => 'admin.settings.occupation_management.updateforsearch',
                'uses' => 'Admin\Settings\OccupationManagementController@updateForSearch',
            ]);
            Route::patch('occupation_management/update', [
                'as'   => 'admin.settings.occupation_management.update',
                'uses' => 'Admin\Settings\OccupationManagementController@update',
            ]);
            Route::resource('nationalities', 'Admin\Settings\NationalitiesController');
            Route::resource('qualifications', 'Admin\Settings\QualificationsController');
            Route::resource('experiences', 'Admin\Settings\ExperiencesController');
            Route::resource('attachments', 'Admin\Settings\AttachmentsController');
            Route::resource('banks', 'Admin\Settings\BanksController');
            Route::resource('reasons', 'Admin\Settings\ReasonsController');
            Route::resource('estsizes', 'Admin\Settings\EstSizesController');
        });
        Route::resource('/bundles', 'Admin\Settings\BundlesController');
        Route::resource('/regions', 'Admin\RegionsController');
        Route::resource('/ishaar_setup', 'Admin\IshaarSetupsController');
        /*
         * Removed temporarily
         * Route::resource('saudi_percentage', 'Admin\SaudiPercentageController');
         */

        Route::get('/taqawel_ishaar_management',
            'Admin\IshaarSetupsController@taqawelIshaarManagement')->name('admin.taqawel_ishaar_management.edit');
        Route::patch('/taqawel_ishaar_management/{id}',
            'Admin\IshaarSetupsController@updateTaqawelIshaarManagement')->name('admin.taqawel_ishaar_management.update');

        Route::get('/loan_pcnt', 'Admin\LoanPcntController@index');
        Route::patch('/loan_pcnt', 'Admin\LoanPcntController@update');

        Route::group(['prefix' => 'reports'], function () {

            // Hazem's Reports
            Route::get('/contractTypesIshaars/{from?}/{to?}',
                'Admin\Reports\ReportController@contractTypesIshaars')->name('admin.reports.contractTypesIshaars');
            Route::get('/topTenPrvdBenfActivities/{from?}/{to?}',
                'Admin\Reports\ReportController@topTenPrvdBenfActivities')->name('admin.reports.topTenPrvdBenfActivities');
            Route::get('/activityIshaars/{from?}/{to?}',
                'Admin\Reports\ReportController@activityIshaars')->name('admin.reports.activityIshaars');
            Route::get('/countriesIshaars/{from?}/{to?}',
                'Admin\Reports\ReportController@countriesIshaars')->name('admin.reports.countriesIshaars');
            Route::get('/jobsChart/{from?}/{to?}',
                'Admin\Reports\ReportController@jobsChart')->name('admin.reports.jobsChart');
            Route::get('/ishaarTypesGrouped/{from?}/{to?}',
                'Admin\Reports\ReportController@ishaarTypesGrouped')->name('admin.reports.ishaarTypesGrouped');

            // Charts' Datatables Data Grabber
            Route::get('/ishaarTypesGroupedData/{chartOrvalue?}/{from?}/{to?}',
                'Admin\Reports\ReportController@ishaarTypesGroupedData')->name('admin.reports.ishaarTypesGroupedData');
            Route::get('/countriesIshaarsData/{chartOrvalue?}/{from?}/{to?}',
                'Admin\Reports\ReportController@countriesIshaarsData')->name('admin.reports.countriesIshaarsData');
            Route::get('/activityIshaarsData/{chartOrValue?}/{prvd_benf?}/{from?}/{to?}',
                'Admin\Reports\ReportController@activityIshaarsData')->name('admin.reports.activityIshaarsData');
            Route::get('/jobsChartData/{chartOrvalue?}/{from?}/{to?}',
                'Admin\Reports\ReportController@jobsChartData')->name('admin.reports.jobsChartData');
            Route::get('/topTenPrvdBenfActivitiesData/{chartOrValue?}/{prvd_benf?}/{from?}/{to?}',
                'Admin\Reports\ReportController@topTenPrvdBenfActivitiesData')->name('admin.reports.topTenPrvdBenfActivitiesData');
            Route::get('/contractTypesIshaarsData/{from?}/{to?}',
                'Admin\Reports\ReportController@contractTypesIshaarsData')->name('admin.reports.contractTypesIshaarsData');
            Route::get('/employeesBenfPeriod',
                'Admin\Reports\ReportController@employeesBenfPeriod')->name('admin.reports.employeesBenfPeriod');
            // -- Hazem's Reports --

            /* Ishaar Reports */
            Route::get('/ishaar-report/{type?}',
                ['as' => 'IshaarReportChart', 'uses' => 'Admin\Reports\IshaarReportController@index']);

            Route::get('/ishaar-report-chart/{type?}/{startDate?}/{endDate?}',
                ['as' => 'reportChart', 'uses' => 'Admin\Reports\IshaarReportController@ishaarReportChart']);

            Route::get('/get-ishaar-by-user-type/{type}/{user_type}',
                [
                    'as'   => 'getIshaarByUserType',
                    'uses' => 'Admin\Reports\IshaarReportController@getIshaarByUserType'
                ]);

            /* Ishaar Regions Reports*/
            Route::get('/ishaar-regions-report',
                ['as' => 'IshaarRegionsReport', 'uses' => 'Admin\Reports\IshaarRegionsReportController@index']);

            Route::get('/ishaar-regions-report-chart/{startDate?}/{endDate?}',
                [
                    'as'   => 'reportRegionChart',
                    'uses' => 'Admin\Reports\IshaarRegionsReportController@ishaarRegionsReportChart'
                ]);

            Route::get('/get-ishaar-by-region/{region}',
                [
                    'as'   => 'getIshaarByRegion',
                    'uses' => 'Admin\Reports\IshaarRegionsReportController@getIshaarByRegion'
                ]);

            /* Ishaar  Status reports*/
            Route::get('/ishaar-status-report',
                ['as' => 'IshaarStatusReport', 'uses' => 'Admin\Reports\IshaarStatusReportController@index']);

            Route::get('/ishaar-status-report-chart/{startDate?}/{endDate?}',
                [
                    'as'   => 'reportStatusChart',
                    'uses' => 'Admin\Reports\IshaarStatusReportController@ishaarStatusReportChart'
                ]);

            Route::get('/get-ishaar-by-status/{status}',
                [
                    'as'   => 'getIshaarByIshaarStatus',
                    'uses' => 'Admin\Reports\ishaarStatusReportController@getIshaarByIshaarStatus'
                ]);

            /* Ishaar Laborer status Reports*/
            Route::get('/ishaar-laborer-status-report',
                [
                    'as'   => 'IshaarLaborerStatusReport',
                    'uses' => 'Admin\Reports\IshaarLaborerStatusReportController@index'
                ]);

            Route::get('/ishaar-laborer-status-report-chart/{startDate?}/{endDate?}',
                [
                    'as'   => 'reportLaborerStatusChart',
                    'uses' => 'Admin\Reports\IshaarLaborerStatusReportController@ishaarLaborerStatusReportChart'
                ]);

            Route::get('/get-ishaar-by-laborer-status/{status}',
                [
                    'as'   => 'getIshaarByLaborerStatus',
                    'uses' => 'Admin\Reports\IshaarLaborerStatusReportController@getIshaarByStatus'
                ]);

            /* Laborer With Multiple Ishaars at same time*/
            Route::get('/laborer-with-multi-ishaar',
                [
                    'as'   => 'LaborerWithMultipleIshaars',
                    'uses' => 'Admin\Reports\LaborerWithMultipleIshaarsController@index'
                ]);


            // chart 9 : Contracts count based on its status
            Route::get('/contract-status-report',
                ['as' => 'contractSatusChart', 'uses' => 'Admin\Reports\ContractStatusReportController@index']);
            Route::get('/contract-status-chart/{startDate}/{endDate}',
                [
                    'as'   => 'statusChartWithDates',
                    'uses' => 'Admin\Reports\ContractStatusReportController@contractStatusChart'
                ]);
            Route::get('/contract-status-chart',
                ['as' => 'statusChart', 'uses' => 'Admin\Reports\ContractStatusReportController@contractStatusChart']);
            Route::get('/get-contract-by-status/{contract_status}',
                [
                    'as'   => 'getContractByStatus',
                    'uses' => 'Admin\Reports\ContractStatusReportController@getContractByStatus'
                ]);

            // packages(bundles)
            Route::group(['prefix' => 'packages'], function () {
                // chart 10 : contracts count based on bundle
                Route::get('contracts', [
                    'as'   => 'reports.packages.chart.contracts',
                    'uses' => 'Admin\Reports\ContractsBundleReportsController@index'
                ]);
                Route::get('contracts-charts', [
                    'as'   => 'reports.packages.chart',
                    'uses' => 'Admin\Reports\ContractsBundleReportsController@chartData'
                ]);
                Route::get('contracts-charts/{start_date}/{end_date}', [
                    'as'   => 'reports.packages.chart.date.filter',
                    'uses' => 'Admin\Reports\ContractsBundleReportsController@chartData'
                ]);
                Route::get('contracts-by-package/{contract_bundle}', [
                    'as'   => 'reports.contracts.packages',
                    'uses' => 'Admin\Reports\ContractsBundleReportsController@contractByBundle'
                ]);

                // chart 11 : invoice status per bundles
                Route::get('invoices', [
                    'as'   => 'reports.packages.chart.invoices',
                    'uses' => 'Admin\Reports\InvoicesBundleReportsController@index'
                ]);
                Route::get('invoices-contracts-charts', [
                    'as'   => 'reports.packages.invoices.chart',
                    'uses' => 'Admin\Reports\InvoicesBundleReportsController@chartData'
                ]);
                Route::get('invoices-contracts-charts/{start_date}/{end_date}', [
                    'as'   => 'reports.packages.invoices.chart.date.filter',
                    'uses' => 'Admin\Reports\InvoicesBundleReportsController@chartData'
                ]);
                Route::get('invoices-by-package/{contract_bundle}', [
                    'as'   => 'reports.contracts.invoices.packages',
                    'uses' => 'Admin\Reports\InvoicesBundleReportsController@contractByBundle'
                ]);
            });

            Route::get('establishment-netaq', [
                'as'   => 'reports.netaq.establishment',
                'uses' => 'Admin\Reports\NitaqEstablishmentsReportsController@index'
            ]);


            // chart 12 : paid invoice based on netaq of establishments
            Route::get('/invoice-netaq-report',
                ['as' => 'invoiceNetaqChart', 'uses' => 'Admin\Reports\InvoiceNetaqReportController@index']);
            Route::get('/invoice-netaq-chart',
                ['as' => 'netaqChart', 'uses' => 'Admin\Reports\InvoiceNetaqReportController@netaqChart']);
            Route::get('/invoice-netaq-chart/{startDate}/{endDate}',
                ['as' => 'netaqChartWithDate', 'uses' => 'Admin\Reports\InvoiceNetaqReportController@netaqChart']);
            Route::get('/get-establishment-by-netaq/{netaq}',
                [
                    'as'   => 'getEstablishmentByNetaq',
                    'uses' => 'Admin\Reports\InvoiceNetaqReportController@getEstablishmentByNetaq'
                ]);

            /* Laborer With same Benf for 6 months period*/
            Route::get('/laborer-with-same-benf',
                [
                    'as'   => 'LaborerWithSameBenf',
                    'uses' => 'Admin\Reports\LaborerWithMultipleIshaarsController@sameBenfEmployees'
                ]);
        });
    });
});

//Billing System Routes
Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => '2.0'], function () {
        Route::get('notify-payment', 'Api\BillingController@notifyPayment');
        Route::post('notify-payment', 'Api\BillingController@notifyPayment');
    });
});

// Dummy Billing Routes
Route::post('/Billing/api/1.0/get-account', 'Api\DummyBillingController@getAccount');
Route::post('/Billing/api/1.0/create-bill', 'Api\DummyBillingController@createBill');
