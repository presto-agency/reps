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

use App\Http\Controllers\Replay\ReplayController;
use App\Http\ViewComposers\LeftSide\ReplaysNavigationComposer;

Route::get('/', 'HomeController@index')->name('home.index');

Route::resource('news', 'NewsController');
Route::post('news/{id}/send_comment', 'NewsController@comment_send')->name('news.comment_send');
Route::post('/loadmore/load_news', 'NewsController@load_news')->name('loadmore.load_news');

Route::resource('forum', 'ForumController');

Route::resource('forum/topic', 'TopicController');/*Route::get('forum/topic/{id}', function (){
    return view('forum.topic');
});*/

//Route::resource('forum/topic/comment','TopicCommentController');
Route::post('forum/topic/{id}/comment', 'TopicCommentController@store')->name('comment.store');


/*Best*/
Route::get('best', 'Best\BestController@show');

/*Replay*/
Route::resource("replay", 'Replay\ReplayUserController');
Route::group(['prefix' => 'replay'], function () {
    Route::get('{id}/download', 'Replay\ReplayController@download')->name('replay.user.download');
    Route::post('{id}/download_count', 'Replay\ReplayController@downloadCount')->name('replay.user.download.count');
});
Route::resource("replay_pro", 'Replay\ReplayProController');
Route::group(['prefix' => 'replay_pro'], function () {
    Route::get('{replay_pro}/download', 'Replay\ReplayController@download')->name('replay_pro.download');
    Route::post('{replay_pro}/download_count', 'Replay\ReplayController@downloadCount')->name('replay.pro.download.count');
    Route::get("show/{type}", 'Replay\ReplayProTypeController@index')->name('replay_pro.type.index');
    Route::get("{replay_pro}/{type}", 'Replay\ReplayProTypeController@show')->name('replay_pro.type.show');
});

Route::get('tournament', function () {
    return view('tournament.index');
});

Route::get('tournament/{id}', function () {
    return view('tournament.show');
});

Route::get('user', function () {
    return view('user.index');
});

Auth::routes();
