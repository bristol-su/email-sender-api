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


Route::middleware('auth:api')->group(function() {
    Route::resource('emails', 'EmailAddressController')->only(['index']);
    Route::post('/email/{email_address}/send', 'SendEmailController@store');
    Route::get('/whoami', 'WhoAmIController@index');
});
