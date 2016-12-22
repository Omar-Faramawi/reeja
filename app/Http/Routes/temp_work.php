<?php

//Contracts Cancellation
Route::group(['middleware' => ['auth','EstablishmentSelected', 'ResponsibleUpdated']], function () {
    Route::group(['prefix' => 'contracts'], function () {
        //Direct hiring
        Route::get('cancellation/direct_hiring/ishaar/{type}',
            'Front\ContractsController@show_direct_hiring_contracts_ishaar');
        Route::get('cancellation/direct_hiring/ishaar/{type}/{id}',
            'Front\ContractsController@show_direct_hiring_contracts_single_ishaar');
        Route::get('cancellation/direct_hiring/{type}', 'Front\ContractsController@show_direct_hiring_contracts');
        Route::get('cancellation/direct_hiring/{type}/{id}',
            'Front\ContractsController@show_direct_hiring_single_contract');
        Route::post('cancellation/direct_hiring/accept',
            'Front\ContractsController@accept_direct_hiring_contract_cancelation');
        Route::post('cancellation/direct_hiring/refuse',
            'Front\ContractsController@refuse_direct_hiring_contract_cancelation');
        //Hir laobor
        Route::get('cancellation/ishaar/{type}', 'Front\ContractsController@showIshaar');
        Route::get('cancellation/ishaar/{type}/{id}', 'Front\ContractsController@showSingleIshaar');
        Route::get('cancellation/{type}', 'Front\ContractsController@showContracts');
        Route::get('cancellation/{type}/{id}', 'Front\ContractsController@showSingleContract');
        Route::post('cancellation/accept', 'Front\ContractsController@acceptCancel');
        Route::post('cancellation/refuse', 'Front\ContractsController@refuseCancel');
    });

    // Laborer
    Route::get('/laborer', 'Front\LaborerController@index')->name('laborer.index');
    Route::get('/laborer/{id}', 'Front\LaborerController@getLaborer')->name('laborer.edit');
    Route::post('/laborer/add', 'Front\LaborerController@postLaborer')->name('laborer.store');
    Route::post('/laborer/addtolabormarket', 'Front\LaborerController@save')->name('laborer.update');

    // Front-end side
    Route::group(["prefix" => "occasional-work"], function () {
        Route::get('labor-market/{id?}',
            ['as' => 'occasional-labor-market.index', 'uses' => 'Front\LaborMarketController@index']);
        Route::post('labor-market/search',
            ['as' => 'occasional-labor-market.search', 'uses' => 'Front\LaborMarketController@search']);
        Route::get('received-contracts',
            ['as' => 'occasional-received-contracts.view', 'uses' => 'Front\TempWorkContractsController@show']);
        Route::get('received-contracts/{id?}/show',
            ['as' => 'occasional-received-contracts.show', 'uses' => 'Front\TempWorkContractsController@show']);
        Route::post('received-contracts/update',
            ['as' => 'occasional-received-contracts.update', 'uses' => 'Front\TempWorkContractsController@update']);
        Route::post('contract-employee',
            ['as' => 'occasional-contract-employee.index', 'uses' => 'Front\ContractEmployeesController@index']);

        Route::post('list_contract_employees/{contract_id}',
            ['as' => 'contract-employee.list_contract_employees', 'uses' => 'Front\ContractEmployeesController@contractEmployees']);


    });

    Route::group(["prefix" => "temp_work"], function () {
        Route::get('labor-market/{id?}', ['as' => 'labor-market.index', 'uses' => 'Front\LaborMarketController@index']);
        Route::post('labor-market/ask-offer',
            ['as' => 'temp_work_labor_market.ask_offer', 'uses' => 'Front\LaborMarketController@askOffer']);
        Route::post('labor-market/search',
            ['as' => 'labor-market.search', 'uses' => 'Front\LaborMarketController@search']);
        Route::get('received-contracts',
            ['as' => 'received-contracts.view', 'uses' => 'Front\TempWorkContractsController@show']);
        Route::get('received-contracts/{id?}/show-received-contract',
            ['as' => 'received-contracts.show', 'uses' => 'Front\TempWorkContractsController@showReceivedContract']);
        Route::get('received-contracts/{id?}/refuse-received-contract',
            ['as' => 'received-contracts.show', 'uses' => 'Front\TempWorkContractsController@refuseReceivedContract']);
        Route::get('received-contracts/{id?}/show',
            ['as' => 'received-contracts.show', 'uses' => 'Front\TempWorkContractsController@show']);
        Route::post('received-contracts/update',
            ['as' => 'received-contracts.update', 'uses' => 'Front\TempWorkContractsController@update']);
        Route::patch('contracts/{contract}',
            ['as' => 'temp.contracts.update', 'uses' => 'Front\TempWorkContractsController@updateTempWork']);
        Route::post('received-contracts/sendVacancyOffer',
            ['as' => 'received-contracts.sendVacancyOffer', 'uses' => 'Front\TempWorkContractsController@sendVacancyOffer']);
        Route::post('contract-employee',
            ['as' => 'contract-employee.index', 'uses' => 'Front\ContractEmployeesController@index']);
        Route::get("contracts/{id?}", [
            'as'   => 'tempwork.contracts',
            'uses' => 'Front\TempWorkContractsController@index',
        ]);
        
        Route::get("contract/{id?}/edit", [
            'as'   => 'tempwork.contracts.edit',
            'uses' => 'Front\TempWorkContractsController@edit',
        ]);
    });

    Route::group(['prefix' => 'offers'], function () {
        Route::get("downloadfile/{id}", 'Front\OffersController@downloadFile');
        Route::get("accept/{id}", 'Front\OffersController@accept');
        Route::get("accept/approve/{id}", 'Front\OffersController@approve');
        Route::put("accept/approve/{id}", 'Front\OffersController@approvePost');
        Route::POST("accept/approve/{id}",['as'=>'approveTempWork','uses'=> 'Front\OffersController@approvePosted']);
        Route::get("reject/{id}", 'Front\OffersController@reject');
        Route::put("reject/{id}", 'Front\OffersController@rejectPost');
        Route::get("{id}", 'Front\OffersController@show');
        Route::resource("", 'Front\OffersController');
    });
    Route::get("contractdetails/{id}", "Front\ContractsController@anyContractDetails");

    // Front End Shwagher
    Route::resource('vacancies', 'Front\VacanciesController');

    // Front End Ishaar
    Route::resource('ishaar', 'Front\NoticesController');
    Route::get('ishaar/type/{id}','Front\NoticesController@index');
    Route::get('ishaar/{id}/cancel_ishaar', 'Front\NoticesController@cancelIshaar');
    Route::get('ishaar/{id}/show_ishaar', 'Front\NoticesController@showIshaar');
    Route::get('ishaar/{id}/generate_invoice', 'Front\NoticesController@generateInvoice');
    Route::post('ishaar/ask_cancel', 'Front\NoticesController@askCancelIshaar');
    
    // Front End Contracts
    Route::get('temp-work-contracts',
        ['as' => 'contracts.index', 'uses' => 'Front\ContractsController@index']);

    Route::get("direct-hiring-contracts/{id?}", [
        'as'   => 'direct_hiring.contracts',
        'uses' => 'Front\DirectHiringContractsController@index',
    ]);

    Route::get("direct-hiring-contracts/{id?}/show", [
        'as'   => 'direct_hiring.contracts.show',
        'uses' => 'Front\DirectHiringContractsController@show',
    ]);
    
    Route::get("direct-hiring/send-offer/{id?}", [
        'as'   => 'direct_hiring.sendoffer.employee',
        'uses' => 'Front\DirectHiringContractsController@sendOfferToEmployee',
    ]);

    Route::get('direct-hiring-contract/{contracts}/edit',
        ['as' => 'direct_hiring.contracts.edit', 'uses' => 'Front\DirectHiringContractsController@edit']);
    Route::post('direct-hiring-contract/update',
            ['as' => 'direct_hiring.contracts.update', 'uses' => 'Front\DirectHiringContractsController@update']);
    Route::post('direct-hiring-contract/create',
            ['as' => 'direct_hiring.contracts.create', 'uses' => 'Front\DirectHiringContractsController@createContract']);
    Route::get("direct-hiring/received-contracts", [
        'as'   => 'direct_hiring.contracts.received-contracts',
        'uses' => 'Front\DirectHiringContractsController@receivedContracts',
    ]);

    Route::resource('contracts', 'Front\ContractsController');
    Route::put("contracts/{id}/cancel_reset", 'Front\ContractsController@CancelResetContract');

    Route::get('contracts/{contracts}/cancel',
        ['as' => 'contracts.cancel', 'uses' => 'Front\ContractsController@benfCancel']);
    Route::get('contracts/{contracts}/reject',
        ['as' => 'contracts.reject', 'uses' => 'Front\ContractsController@rejectRequest']);
    Route::get('direct-hiring-contracts/{contracts}/reject',
        ['as' => 'direct_hiring.contracts.reject', 'uses' => 'Front\DirectHiringContractsController@rejectRequest']);
    Route::post('contracts/update-status',
        ['as' => 'contracts.update_status', 'uses' => 'Front\ContractsController@updateStatus']);

    Route::get('/follow_contracts/{ct_id}/{prvd_benf}',
        [
            'as'   => 'follow_contracts',
            'uses' => 'Front\ContractsController@followContract'
        ]);
    Route::get('direct-hiring/labor-market','Front\LaborMarketController@directHiringMarket');
});

//Individual routes
Route::group(['middleware' => ['auth','individual']], function (){
    Route::group(['prefix' => 'offersdirect'], function () {
        Route::put("ownership/reject/{id}/{hashedid}", "Front\OwnerShipController@rejectPost");
        Route::get("ownership/reject/{id}/{hashedid}", "Front\OwnerShipController@reject");
        Route::put("ownership/approve/{id}/{hashedid}", "Front\OwnerShipController@approvepost");
        Route::get("ownership/approve/{id}/{hashedid}", "Front\OwnerShipController@approve");
        Route::put("accept/approve/{id}", 'Front\OfferDirectController@approvePost');
        Route::PUT("accept/{id}", "Front\OfferDirectController@accept");
        Route::get("reject/{id}", "Front\OfferDirectController@reject");
        Route::put("reject/{id}", "Front\OfferDirectController@rejectPost");
        Route::get("{id}", "Front\OfferDirectController@show");
        Route::resource("", "Front\OfferDirectController");
    });

    Route::get('cv', 'Front\CVController@edit')->name('cv.edit');
    Route::patch('cv', 'Front\CVController@update')->name('cv.update');
    Route::get('work_completion_certificate','Front\ContractsController@work_completion_certificate');
    Route::post('certificate_generate_invoice','Front\ContractsController@generateCertificateInvoice');
    Route::get('job_search', 'Front\JobApplicationController@index')->name('job_search');
        Route::get('job_search/{id}/apply_to_job','Front\JobApplicationController@apply')->name('job_search.apply_to_job');

    Route::group(['middleware' => 'indvidualContractCancelation'],function () {
        Route::group(['prefix' => 'contracts/cancellation/seeker'],function () {
            Route::get('direct_hiring/ishaar/provider',
                'Front\ContractsController@show_direct_hiring_contracts_ishaar');
            Route::get('direct_hiring/ishaar/provider/{id}',
                'Front\ContractsController@show_direct_hiring_contracts_single_ishaar');
            Route::get('direct_hiring/provider',
                'Front\ContractsController@show_direct_hiring_contracts');
            Route::get('direct_hiring/provider/{id}',
                'Front\ContractsController@show_direct_hiring_single_contract');
            Route::post('direct_hiring/accept',
                'Front\ContractsController@accept_direct_hiring_contract_cancelation');
            Route::post('direct_hiring/refuse',
                'Front\ContractsController@refuse_direct_hiring_contract_cancelation');
        });
    });
});

//All users except admin routes
Route::group(['middleware' => ['AllUsersExceptAdmin']], function (){
    Route::resource('direct_ishaar', 'Front\NoticesController');
    Route::get('direct_ishaar/type/{id}','Front\NoticesController@index');
    Route::get('direct_ishaar/{id}/cancel_ishaar', 'Front\NoticesController@cancelIshaar');
    Route::get('direct_ishaar/{id}/show_ishaar', 'Front\NoticesController@showIshaar');
    Route::post('direct_ishaar/{id}/generate_invoice', 'Front\NoticesController@generateInvoice');
    Route::post('direct_ishaar/ask_cancel', 'Front\NoticesController@askCancelIshaar');
});