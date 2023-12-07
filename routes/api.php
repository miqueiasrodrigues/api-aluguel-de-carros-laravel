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


Route::apiResource('client', 'App\Http\Controllers\ClientController');
Route::apiResource('brand', 'App\Http\Controllers\BrandController');
Route::apiResource('model', 'App\Http\Controllers\CarModelController');
Route::apiResource('location', 'App\Http\Controllers\LocationController');
Route::apiResource('car', 'App\Http\Controllers\CarController');
