<?php

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
Route::post('/login', 'AuthController@login')->name('user.login');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('product', 'ProductController@index')->name('product');
    Route::post('product/store', 'ProductController@store')->name('product.store');
    Route::post('product/destroy', 'ProductController@destroy')->name('product.destroy');
    Route::post('product/update', 'ProductController@update')->name('product.update');
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
