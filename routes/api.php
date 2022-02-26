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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('getState', [App\Http\Controllers\ApiController::class, 'getState']);
Route::get('getParlimen', [App\Http\Controllers\ApiController::class, 'getParlimen']);
Route::get('getDun', [App\Http\Controllers\ApiController::class, 'getDun']);
Route::get('getDm', [App\Http\Controllers\ApiController::class, 'getDm']);