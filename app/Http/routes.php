<?php

Route::get('/', ['middleware' => 'guest', 'uses' => 'WelcomeController@index']);

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

// Route::get('test', function (\Illuminate\Contracts\Bus\Dispatcher $bus) {
//     $message = "# Hello world!\n*this* is _great_ :+1:\nyup yup";
//     // $body = json_encode([
//     //     'text' => $message
//     // ]);

//     $user = \App\User::first();
//     $parser = app('App\GitHubMarkdownParser', [$user]);

//     // $client = new Github\Client();
//     // $client->authenticate($user->token, \Github\Client::AUTH_HTTP_TOKEN);
//     // $response = $client->getHttpClient()->post('markdown', $body);
//     // $output = \Github\HttpClient\Message\ResponseMediator::getContent($response);
//     // dd($output);
//     dd($parser->parse($message));

//     // $client = app('Github\Client');
//     // $user = \App\User::first();
//     // $client->authenticate($user->token, \Github\Client::AUTH_HTTP_TOKEN);
//     $bus->dispatch(new \App\Jobs\NotifyUserOfNewGistComments(
//         \App\User::first()
//     ));

//     return rand();
// });
