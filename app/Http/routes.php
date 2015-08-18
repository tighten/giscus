<?php

Route::get('/', ['middleware' => 'guest', 'uses' => 'WelcomeController@index']);

Route::get('no-email', 'Auth\AuthController@noEmail');

Route::get('logout', 'Auth\AuthController@getLogout');
Route::get('auth/github', 'Auth\AuthController@redirectToProvider');
Route::get('auth/github/callback', 'Auth\AuthController@handleProviderCallback');

Route::group(['middleware' => 'auth'], function () {
    Route::get('home', 'AccountController@index');

    Route::get('user/confirm-cancel', 'AccountController@confirmCancel');
    Route::get('user/cancel', 'AccountController@cancel');

    Route::get('sign-up', 'SignupController@index');
    Route::post('sign-up', 'SignupController@stripePostback');
});
