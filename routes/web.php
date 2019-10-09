<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home.index');

Route::resource('news', 'NewsController');
Route::resource('forum', 'ForumController');

Route::get('forum/topic/{id}', function (){
    return view('forum.topic');
});

Route::get('replay', function (){
    return view('replay.index');
});

Route::get('best', function (){
    return view('best.index');
});

Route::get('tournament', function (){
    return view('tournament.index');
});

Auth::routes();

Route::get('replays/download/{id}', '\App\Http\Controllers\Admin\ReplayController@download')->name('replay.download');
