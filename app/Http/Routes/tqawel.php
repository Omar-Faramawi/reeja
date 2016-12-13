<?php

/** Taqawel */
use Illuminate\Routing\Router;

$router->group(['prefix' => 'taqawel', 'middleware' => ['auth', 'EstablishmentSelected', 'EstablishmentUpdated']], function (Router $router) {
    $router->post('market/offer', 'Front\TaqawelServicesController@askTaqawelOffer');
    $router->get('taqawelService/{id}/delete', 'Front\TaqawelServicesController@destroy');
    $router->get('market/{id?}', ['as' => 'taqawel.market', 'uses' => 'Front\TaqawelServicesController@listMarketServices']);
    $router->get("offer-taqawel-contract/{id}/show", [
        'as'   => 'taqawel.apply_taqawel_contract',
        'uses' => 'Front\TaqawelServicesController@applyTaqawelContract',
    ]);
    $router->post("offer-taqawel-contract/store", [
        'as'   => 'taqawel.store',
        'uses' => 'Front\TaqawelServicesController@storeTaqawelContract',
    ]);
    $router->get("received-contracts", [
        'as'   => 'taqawel.received-contracts',
        'uses' => 'Front\TaqawelServicesController@showRecievedOffers',
    ]);
    $router->get("contracts/{id?}", [
        'as'   => 'taqawel.contracts',
        'uses' => 'Front\TaqawelServicesController@showContracts',
    ]);
    $router->get("offer-taqawel-contract/{id}/edit", [
        'as'   => 'taqawel.contracts.edit',
        'uses' => 'Front\TaqawelServicesController@editContract',
    ]);

    $router->put("offer-taqawel-contract/update/{contract}", [
        'as'   => 'taqawel.contracts.update',
        'uses' => 'Front\TaqawelServicesController@updateContract',
    ]);

    $router->get("offer-taqawel-contract/{id}/details", 'Front\TaqawelServicesController@showReceivedOffersDetails');
    $router->get("offer-taqawel-contract/{id}/cancel", 'Front\TaqawelServicesController@cancelReceivedOffers');
    $router->get("offer-taqawel-contract/{id}/reject", 'Front\TaqawelServicesController@rejectReceivedRequest');
    $router->put("offer-taqawel-contract/{id}/cancel_reset", 'Front\TaqawelServicesController@CancelResetContract');
    
    $router->group(['prefix' => 'offers'], function (Router $router) {
        $router->get("downloadfile/{id}", 'Front\OffersTaqaualController@downloadFile');
        $router->get("reject/{id}", 'Front\OffersTaqaualController@reject');
        $router->put("reject/{id}", 'Front\OffersTaqaualController@rejectPost');
        $router->get("{id}", "Front\OffersTaqaualController@show");
        $router->put("accept/approve/{id}", 'Front\OffersTaqaualController@approvePost');
        $router->PUT("accept/{id}", "Front\OffersTaqaualController@accept");
        $router->resource("", "Front\OffersTaqaualController");
    });
    $router->group(['prefix' => 'packagesubsribe'], function (Router $router) {
        $router->put("accept/approve", "Front\PackageSubscribeController@approve");
        $router->put("accept", "Front\PackageSubscribeController@accept");
        $router->put("activate", "Front\PackageSubscribeController@activate");
        $router->get("invoice", "Front\PackageSubscribeController@invoice");
        $router->get("my_packages", "Front\PackageSubscribeController@myPackages");
        $router->resource("", "Front\PackageSubscribeController");
    });

    $router->resource('taqawelService', 'Front\TaqawelServicesController');
    $router->get('taqawelService/{id}/delete', 'Front\TaqawelServicesController@destroy');
    $router->resource('notices', 'Front\TaqawelNoticesController');
    $router->get('notices/type/{id}', 'Front\TaqawelNoticesController@index');
    $router->get('notices/{id}/cancel_ishaar', 'Front\TaqawelNoticesController@cancelIshaar');
    $router->get('notices/{id}/show_ishaar', 'Front\TaqawelNoticesController@showIshaar');
    $router->post('notices/ask_cancel', 'Front\TaqawelNoticesController@askCancelIshaar');
    $router->resource('publishservice', 'Front\PublishServiceTaqaualController');
    
    /** Approve Taqawel contracts cancellation */
    $router->group(['prefix' => 'contracts/cancellation'], function (Router $router) {
            $router->get("/ishaar/{type}", "Front\TaqawelContractController@taqawelIshaarsList");
            $router->get("/ishaar/{type}/{id}", "Front\TaqawelContractController@singleTaqawelIshaar");
            $router->get("/{type}", "Front\TaqawelContractController@taqawelContractsList");
            $router->get("/{type}/{id}", "Front\TaqawelContractController@singleTaqawelContract");
            $router->post("/accept", "Front\TaqawelContractController@acceptTaqawelContractCancel");
            $router->post("/refuse", "Front\TaqawelContractController@refuseTaqawelContractCancel");
        }
    );
    
});
