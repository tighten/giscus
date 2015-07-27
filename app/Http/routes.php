<?php

Route::get('/', ['middleware' => 'guest', 'uses' => 'SalesController@index']);

Route::get('logout', 'Auth\AuthController@getLogout');
Route::get('auth/github', 'Auth\AuthController@redirectToProvider');
Route::get('auth/github/callback', 'Auth\AuthController@handleProviderCallback');

Route::group(['middleware' => 'auth'], function() {
    Route::group(['middleware' => 'subscribed'], function() {
        Route::get('home', 'AccountController@index');

        Route::get('user/invoice/{invoice}', 'AccountController@downloadInvoice');

        Route::get('user/confirm-cancel', 'AccountController@confirmCancel');
        Route::get('user/cancel', 'AccountController@cancel');
    });

    Route::get('sign-up', 'SignupController@index');
    Route::post('sign-up', 'SignupController@stripePostback');
});
