<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->middleware('api')->group(function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('reset', 'Auth\ResetPasswordController@reset');
    Route::post('forgot', 'Auth\ForgotPasswordController@forgot');
    Route::post('logout', 'Auth\LoginController@logout');
    Route::get('google/auth', 'Auth\LoginController@redirectToProvider');
    Route::get('google/callback', 'Auth\LoginController@handleProviderCallback');

    Route::apiResource('league', 'API\LeagueController');
    Route::apiResource('groups', 'API\GroupController');
    Route::apiResource('news', 'API\NewsController');

    Route::middleware('auth:api')->group(function () {
        //auth
        Route::post('auth/check', 'Auth\LoginController@check');

        //user settings
        Route::get('settings', 'API\ProfileController@index');
        Route::post('settings', 'API\ProfileController@update');
    });
});


