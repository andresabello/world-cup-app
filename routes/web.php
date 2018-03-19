<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => 1,
        'redirect_uri' => 'http://reminder-app.localhost/callback',
        'response_type' => 'token',
        'scope' => '*',
    ]);

    return redirect('http://reminder-app.localhost/oauth/authorize?'.$query);
});

Route::get('/callback', function () {
    echo 'Hello World!';
});
//Main Site
//Route::get('{all}', 'HomeController@index')->where(['all' => '.*']);



