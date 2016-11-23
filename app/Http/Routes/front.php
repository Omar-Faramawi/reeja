<?php

Route::get('/', 'HomeController@home');
//Basic authentication
Route::auth();
Route::post('auth/individualsLogin', 'Auth\AuthController@individualsLogin');
Route::post('citizenRegister', 'Auth\AuthController@citizenRegister');
Route::get("/activation", function(){
    if(session()->has('temp_account_registration')){
        return view('auth.activation');
    }else{
        abort(404);
    }
});
Route::post("/activation", 'Auth\AuthController@activation');
// OpenID auth rules
Route::get('auth/openid/login', 'Auth\AuthController@redirectToOpenID');
Route::get('auth/openid/authenticate', 'Auth\AuthController@handleOpenIDCallback');

// Begin static HTML pages routes
Route::get('/about', 'Front\AboutController@index')->name('about');
Route::get('/faq', 'Front\AboutController@faq')->name('faq');
Route::get('/terms', 'Front\AboutController@terms')->name('terms');
Route::get('/support', 'Front\AboutController@support')->name('support');
// End static HTML pages routes

//Home & Language rules
Route::get('/home', 'HomeController@index');
Route::get('/app/locale/{locale}', 'UserController@getLocale');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'hajj_government'], function () {
        Route::get('hajj_gov_approval', [
            'as'   => 'hajj.gov.approval',
            'uses' => 'EstablishmentController@estApproval',
        ]);
        
        Route::post('hajj_gov_responsibles', [
            'as'   => 'hajj.gov.responsibles',
            'uses' => 'EstablishmentController@getResponsibles',
        ]);
        
        Route::post('hajj_gov_approve', [
            'as'   => 'hajj.gov.approve',
            'uses' => 'EstablishmentController@approve',
        ]);
    });
    Route::get('establishment/choose/{officeNumber}/{sequenceNumber}', [
        'uses' => 'EstablishmentController@choose',
        'as'   => 'establishment.choose',
    ]);
    
    Route::get('establishment/edit', [
        'uses' => 'EstablishmentController@edit',
        'as'   => 'establishment.profile.edit',
    ]);
    
    Route::patch('establishment/update', [
        'uses' => 'EstablishmentController@update',
        'as'   => 'establishment.profile.update',
    ]);

     Route::resource('my_invoices', 'Front\InvoicesController');
     // Select Establishment
    Route::get('establishments', [
        'uses' => 'EstablishmentController@establishments',
        'as'   => 'establishment.select',
    ]);
});
