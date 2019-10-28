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

use App\Http\ViewComposers\LeftSide\ReplaysNavigationComposer;

Route::get('/', 'HomeController@index')->name('home.index');

Route::resource('news', 'NewsController');
Route::post('news/{id}/send_comment', 'NewsController@comment_send')->name('news.comment_send');

Route::resource('forum', 'ForumController');
Route::post('/loadmore/load_news', 'NewsController@load_news')->name('loadmore.load_news');

Route::resource('forum/topic', 'TopicController');/*Route::get('forum/topic/{id}', function (){
    return view('forum.topic');
});*/

//Route::resource('forum/topic/comment','TopicCommentController');
Route::post('forum/topic/{id}/comment', 'TopicCommentController@store')->name('comment.store');


/*best with:views(left-side:forum-topics)*/
Route::get('best', 'Best\BestController@show');

/*replay with:views(left-side:replays;search)*/
Route::group(['prefix' => 'replay'], function () {
    Route::get("/", 'Replay\ReplayController@showUser')->name('replay.user');
    Route::group(['prefix' => 'pro'], function () {
        Route::get("/", 'Replay\ReplayController@showPro')->name('replay.pro');
        foreach (ReplaysNavigationComposer::$replayTypes as $type) {
            Route::get("/{$type}", ['uses' => 'Replay\ReplayController@showType'])->name("replay.$type");
        }
    });
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

Route::get('replays/download/{id}', '\App\Http\Controllers\Admin\ReplayController@download')->name('replay.download');
