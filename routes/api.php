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


Route::middleware('auth:api')->namespace('Api')->group(function() {
    Route::resource('emails', 'EmailAddressController')->only(['index']);
    Route::get('/email/{email_address}/send', 'SendEmailController@index');
    Route::get('/whoami', 'WhoAmIController@index');
});
