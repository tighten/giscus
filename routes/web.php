<?php

Route::get('/', ['middleware' => 'guest', 'uses' => 'WelcomeController@index'])->name('welcome');

Route::get('no-email', 'Auth\AuthController@noEmail');

Route::get('logout', 'Auth\AuthController@getLogout');

Route::get('unsubscribe', 'UnsubscribeController@index')->name('unsubscribe');

Route::group(['middleware' => 'auth'], function () {
    Route::get('home', 'AccountController@index');

    Route::get('user/confirm-cancel', 'AccountController@confirmCancel');
    Route::get('user/cancel', 'AccountController@cancel');
});

Route::group(['prefix' => 'auth/github'], function () {
    Route::post('/', 'Auth\AuthController@redirectToProvider');
    Route::get('callback', 'Auth\AuthController@handleProviderCallback');
});
