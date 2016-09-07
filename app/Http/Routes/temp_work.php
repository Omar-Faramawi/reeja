<?php

//Contracts Cancelation
Route::group(['middleware' => ['auth', 'contractCancelation']], function () {
    Route::group(['prefix' => 'contracts'], function () {
        //Direct hiring
        Route::get('cancelation/direct_hiring/ishaar/{type}',
            'Front\ContractsController@show_direct_hiring_contracts_ishaar');
        Route::get('cancelation/direct_hiring/ishaar/{type}/{id}',
            'Front\ContractsController@show_direct_hiring_contracts_single_ishaar');
        Route::get('cancelation/direct_hiring/{type}', 'Front\ContractsController@show_direct_hiring_contracts');
        Route::get('cancelation/direct_hiring/{type}/{id}',
            'Front\ContractsController@show_direct_hiring_single_contract');
        Route::post('cancelation/direct_hiring/accept',
            'Front\ContractsController@accept_direct_hiring_contract_cancelation');
        Route::post('cancelation/direct_hiring/refuse',
            'Front\ContractsController@refuse_direct_hiring_contract_cancelation');
        //Hir laobor
        Route::get('cancelation/ishaar/{type}', 'Front\ContractsController@showIshaar');
        Route::get('cancelation/ishaar/{type}/{id}', 'Front\ContractsController@showSingleIshaar');
        Route::get('cancelation/{type}', 'Front\ContractsController@showContracts');
        Route::get('cancelation/{type}/{id}', 'Front\ContractsController@showSingleContract');
        Route::post('cancelation/accept', 'Front\ContractsController@acceptCancel');
        Route::post('cancelation/refuse', 'Front\ContractsController@refuseCancel');
    });
});

Route::group(['middleware' => ['auth', 'indvidualContractCancelation']], function () {
    Route::group(['prefix' => 'contracts/cancelation/seeker'], function () {
        Route::get('direct_hiring/ishaar/provider', 'Front\ContractsController@show_direct_hiring_contracts_ishaar');
        Route::get('direct_hiring/ishaar/provider/{id}',
            'Front\ContractsController@show_direct_hiring_contracts_single_ishaar');
        Route::get('direct_hiring/provider', 'Front\ContractsController@show_direct_hiring_contracts');
        Route::get('direct_hiring/provider/{id}', 'Front\ContractsController@show_direct_hiring_single_contract');
        Route::post('direct_hiring/accept', 'Front\ContractsController@accept_direct_hiring_contract_cancelation');
        Route::post('direct_hiring/refuse', 'Front\ContractsController@refuse_direct_hiring_contract_cancelation');
    });
});

// Laborer
Route::group(['middleware' => ['auth', 'laborer']], function () {
    Route::get('/laborer', 'Front\LaborerController@index')->name('laborer.index');
    Route::get('/laborer/{id}', 'Front\LaborerController@getLaborer')->name('laborer.edit');
    Route::post('/laborer/add', 'Front\LaborerController@postLaborer')->name('laborer.store');
    Route::post('/laborer/addtolabormarket', 'Front\LaborerController@save')->name('laborer.update');
});

// Front-end side
Route::group(['middleware' => 'auth'], function () {

    Route::get('cv', 'CVController@edit')->name('cv.edit');
    Route::patch('cv', 'CVController@update')->name('cv.update');

    Route::group(["prefix" => "occasional-work"], function () {
        Route::get('labor-market/{id?}',
            ['as' => 'occasional-labor-market.index', 'uses' => 'Front\LaborMarketController@index']);
        Route::post('labor-market/search',
            ['as' => 'occasional-labor-market.search', 'uses' => 'Front\LaborMarketController@search']);
        Route::get('received-contracts',
            ['as' => 'occasional-received-contracts.view', 'uses' => 'Front\ReceivedContractsController@show']);
        Route::get('received-contracts/{id?}/show',
            ['as' => 'occasional-received-contracts.show', 'uses' => 'Front\ReceivedContractsController@show']);
        Route::post('received-contracts/update',
            ['as' => 'occasional-received-contracts.update', 'uses' => 'Front\ReceivedContractsController@update']);
        Route::post('contract-employee',
            ['as' => 'occasional-contract-employee.index', 'uses' => 'Front\ContractEmployeesController@index']);
    });

    Route::group(["prefix" => "temp_work"], function () {
        Route::get('labor-market/{id?}', ['as' => 'labor-market.index', 'uses' => 'Front\LaborMarketController@index']);
        Route::post('labor-market/ask-offer',
            ['as' => 'temp_work_labor_market.ask_offer', 'uses' => 'Front\LaborMarketController@askOffer']);
        Route::post('labor-market/search',
            ['as' => 'labor-market.search', 'uses' => 'Front\LaborMarketController@search']);
        Route::get('received-contracts',
            ['as' => 'received-contracts.view', 'uses' => 'Front\ReceivedContractsController@show']);
        Route::get('received-contracts/{id?}/show',
            ['as' => 'received-contracts.show', 'uses' => 'Front\ReceivedContractsController@show']);
        Route::post('received-contracts/update',
            ['as' => 'received-contracts.update', 'uses' => 'Front\ReceivedContractsController@update']);
        Route::post('contract-employee',
            ['as' => 'contract-employee.index', 'uses' => 'Front\ContractEmployeesController@index']);

    });

    Route::group(['prefix' => 'offers'], function () {
        Route::get("downloadfile/{id}", 'Front\OffersController@downloadFile');
        Route::get("accept/{id}", 'Front\OffersController@accept');
        Route::get("accept/approve/{id}", 'Front\OffersController@approve');
        Route::put("accept/approve/{id}", 'Front\OffersController@approvePost');
        Route::get("reject/{id}", 'Front\OffersController@reject');
        Route::put("reject/{id}", 'Front\OffersController@rejectPost');
        Route::get("{id}", 'Front\OffersController@show');
        Route::resource("", 'Front\OffersController');
    });
    route::get("contractdetails/{id}", "Front\ContractsController@anyContractDetails");
    Route::group(['prefix' => 'offersdirect', 'middleware' => 'individual'], function () {

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

    Route::group(['middleware' => 'individual'], function () {
        Route::get('job_search', 'Front\JobApplicationController@index')->name('job_search');
        Route::get('job_search/{id}/apply_to_job',
            'Front\JobApplicationController@apply')->name('job_search.apply_to_job');

        Route::get('cv', 'Front\CVController@edit')->name('cv.edit');
        Route::patch('cv', 'Front\CVController@update')->name('cv.update');

        Route::get('work_completion_certificate', 'Front\ContractsController@work_completion_certificate');
    });

// Front End Shwagher
    Route::group(['middleware' => ['shwagher_auth']], function () {
        Route::resource('vacancies', 'Front\VacanciesController');
    });

// Front End Ishaar
    Route::resource('ishaar', 'Front\NoticesController');
    Route::get('ishaar/type/{id}','Front\NoticesController@index');
    Route::get('ishaar/{id}/cancel_ishaar', 'Front\NoticesController@cancelIshaar');
    Route::get('ishaar/{id}/show_ishaar', 'Front\NoticesController@showIshaar');
    Route::get('ishaar/{id}/generate_invoice', 'Front\NoticesController@generateInvoice');
    Route::post('ishaar/ask_cancel', 'Front\NoticesController@askCancelIshaar');
    Route::resource('direct_ishaar', 'Front\NoticesController');
    Route::get('direct_ishaar/type/{id}','Front\NoticesController@index');
    Route::get('direct_ishaar/{id}/cancel_ishaar', 'Front\NoticesController@cancelIshaar');
    Route::get('direct_ishaar/{id}/show_ishaar', 'Front\NoticesController@showIshaar');
    Route::post('direct_ishaar/{id}/generate_invoice', 'Front\NoticesController@generateInvoice');
    Route::post('direct_ishaar/ask_cancel', 'Front\NoticesController@askCancelIshaar');


// Front End Contracts
    Route::get('/contracts/{contract_type_id}',
        ['as' => 'contracts.index', 'uses' => 'Front\ContractsController@index']);
    Route::get('{contract_type_id}/contracts/{contracts}/edit',
        ['as' => 'contracts.edit', 'uses' => 'Front\ContractsController@edit']);
    Route::resource('contracts', 'Front\ContractsController');
    Route::get('contracts/{contracts}/cancel',
        ['as' => 'contracts.cancel', 'uses' => 'Front\ContractsController@benfCancel']);
    Route::post('contracts/update-status',
        ['as' => 'contracts.update_status', 'uses' => 'Front\ContractsController@updateStatus']);

    Route::get('/follow_contracts/{ct_id}/{prvd_benf}',
        [
            'as'   => 'follow_contracts',
            'uses' => 'Front\ContractsController@followContract'
        ]);
});
