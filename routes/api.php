<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post('callback', 'ProductController@callbackPaymentMercadoPago')->name('callbackPaymentMercadoPago');
Route::post('/notificacoesMP', 'ProductController@notificacoesMP')->name('api.notificaoMP');
Route::post('/webhook-paggue', 'ProductController@notificacoesPaggue')->name('api.notificaoPaggue');
