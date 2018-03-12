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
    //login
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('reset', 'Auth\ResetPasswordController@reset');
    Route::post('forgot', 'Auth\ForgotPasswordController@forgot');
    Route::post('logout', 'Auth\LoginController@logout');
    //register
    //logout

    //once logged in
    Route::middleware('auth:api')->group(function () {
        Route::get('auth/check', 'Auth\LoginController@check');
    });
});


