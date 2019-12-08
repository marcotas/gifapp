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

Route::post('signup', 'SignUpController')->middleware('guest')->name('signup');

Route::middleware('auth:api')->group(function () {
    Route::apiResource('gifs', 'GifController');
    Route::get('me', 'UserController@me');

    Route::apiResource('searches', 'SearchHistoryController', ['only' => ['index', 'store']]);

    Route::post('favorites', 'FavoriteGifController@toggle')->name('favorites.toggle');

    Route::post('short-url', 'ShortUrlController@show')->name('short-url.show');
});
