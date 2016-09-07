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
        Route::patch('contractSetup/{id}/update',
            'Admin\ContractSetupController@update')->name('admin.contractSetup.update');
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
            Route::get('professions', 'Admin\Settings\ProfessionsController@index');
            Route::patch('professions/update', [
                'as'   => 'admin.settings.professions.update',
                'uses' => 'Admin\Settings\ProfessionsController@update',
            ]);
            Route::get('occupation_management', 'Admin\Settings\OccupationManagementController@index');
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
        Route::resource('saudi_percentage', 'Admin\SaudiPercentageController');
        
        Route::get('/taqawel_ishaar_management',
            'Admin\IshaarSetupsController@taqawelIshaarManagement')->name('admin.taqawel_ishaar_management.edit');
        Route::patch('/taqawel_ishaar_management/{id}',
            'Admin\IshaarSetupsController@updateTaqawelIshaarManagement')->name('admin.taqawel_ishaar_management.update');
        
        Route::get('/loan_pcnt', 'Admin\LoanPcntController@index');
        Route::patch('/loan_pcnt', 'Admin\LoanPcntController@update');
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