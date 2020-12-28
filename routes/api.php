<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => config('l5-swagger.constants.L5_SWAGGER_CONST_VERSION')], function () {
    Route::get('news/last', 'Api\NewsController@last')->name('api.get.news.last');
    Route::get('stream/online', 'Api\StreamController@online')->name('api.get.stream.online.index');
    Route::get('replay', 'Api\ReplaysController@index')->name('api.get.replay.index');
});
