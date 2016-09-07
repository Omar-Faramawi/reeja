<?php

/** Taqawel */

Route::group(['prefix' => 'taqawel', 'middleware' => ['auth']], function () {
    Route::get("offer-contract",
        ['as' => 'taqawel.offer_contract', 'uses' => 'Front\ContractsController@taqawelOfferContract']);
    Route::post('market/offer', 'Front\TaqawelServicesController@askTaqawelOffer');
    Route::get('taqawelService/{id}/delete', 'Front\TaqawelServicesController@destroy');
    Route::get('market/{id?}', ['as' => 'taqawel.market', 'uses' => 'Front\TaqawelServicesController@market']);
    Route::get("offer-taqawel-contract/{id}/show", [
        'as'   => 'taqawel.apply_taqawel_contract',
        'uses' =>
            'Front\TaqawelServicesController@applyTaqawelContract',
    ]);
    Route::post("offer-taqawel-contract/store", [
        'as'   => 'taqawel.store',
        'uses' =>
            'Front\TaqawelServicesController@storeTaqawelContract',
    ]);
    Route::get("received-contracts", [
        'as'   => 'taqawel.received-contracts',
        'uses' => 'Front\TaqawelServicesController@showRecievedOffers',
    ]);
    Route::get("contracts/{id?}", [
        'as'   => 'taqawel.contracts',
        'uses' => 'Front\TaqawelServicesController@showContracts',
    ]);
    Route::get("offer-taqawel-contract/{id}/edit", [
        'as'   => 'taqawel.contracts.edit',
        'uses' => 'Front\TaqawelServicesController@editContract',
    ]);

    Route::put("offer-taqawel-contract/update/{contract}", [
        'as'   => 'taqawel.contracts.update',
        'uses' => 'Front\TaqawelServicesController@updateContract',
    ]);

    Route::get("offer-taqawel-contract/{id}/details", 'Front\TaqawelServicesController@showReceivedOffersDetails');
    Route::get("offer-taqawel-contract/{id}/cancel", 'Front\TaqawelServicesController@cancelReceivedOffers');
    Route::get("offer-taqawel-contract/{id}/reject", 'Front\TaqawelServicesController@rejectReceivedRequest');
    Route::put("offer-taqawel-contract/{id}/cancel_reset", 'Front\TaqawelServicesController@CancelResetContract');
    
    Route::group(['prefix' => 'offers'], function () {
        Route::get("downloadfile/{id}", 'Front\OffersTaqaualController@downloadFile');
        Route::get("reject/{id}", 'Front\OffersTaqaualController@reject');
        Route::put("reject/{id}", 'Front\OffersTaqaualController@rejectPost');
        Route::get("{id}", "Front\OffersTaqaualController@show");
        Route::put("accept/approve/{id}", 'Front\OffersTaqaualController@approvePost');
        Route::PUT("accept/{id}", "Front\OffersTaqaualController@accept");
        Route::resource("", "Front\OffersTaqaualController");
    });
    Route::group(['prefix' => 'packagesubsribe'], function () {
        Route::put("accept/approve", "Front\PackageSubscribeController@approve");
        Route::put("accept", "Front\PackageSubscribeController@accept");
        Route::put("activate", "Front\PackageSubscribeController@activate");
        Route::get("invoice",  "Front\PackageSubscribeController@invoice");
        Route::resource("", "Front\PackageSubscribeController");
    });


    Route::resource('taqawelService', 'Front\TaqawelServicesController');
    Route::get('taqawelService/{id}/delete', 'Front\TaqawelServicesController@destroy');
    Route::resource('notices', 'Front\TaqawelNoticesController');
    Route::get('notices/type/{id}', 'Front\TaqawelNoticesController@index');
    Route::get('notices/{id}/cancel_ishaar', 'Front\TaqawelNoticesController@cancelIshaar');
    Route::get('notices/{id}/show_ishaar', 'Front\TaqawelNoticesController@showIshaar');
    Route::post('notices/ask_cancel', 'Front\TaqawelNoticesController@askCancelIshaar');
    Route::resource('publishservice', 'Front\PublishServiceTaqaualController');
});

/** Approve Taqawel contracts cancellation */
Route::group(['prefix' => 'taqawel/contracts/cancellation', 'middleware' => ['auth', 'contractCancelation']],
    function () {
        Route::get("/ishaar/{type}", "Front\TaqawelContractController@taqawelIshaarsList");
        Route::get("/ishaar/{type}/{id}", "Front\TaqawelContractController@singleTaqawelIshaar");
        Route::get("/{type}", "Front\TaqawelContractController@taqawelContractsList");
        Route::get("/{type}/{id}", "Front\TaqawelContractController@singleTaqawelContract");
        Route::post("/accept", "Front\TaqawelContractController@acceptTaqawelContractCancel");
        Route::post("/refuse", "Front\TaqawelContractController@refuseTaqawelContractCancel");
    });