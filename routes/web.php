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


/*Home*/
Route::get('/', 'HomeController@index')->name('home.index');

/*News*/
Route::resource('news', 'NewsController');
Route::post('news/{id}/send_comment', 'NewsController@comment_send')->name('news.comment_send');
Route::post('/loadmore/load_news', 'NewsController@load_news')->name('loadmore.load_news');
/*Forum*/
Route::resource('forum', 'ForumController');
/*Forum topic*/
Route::resource('forum/topic', 'TopicController');/*Route::get('forum/topic/{id}', function (){
    return view('forum.topic');
});*/
//Route::resource('forum/topic/comment','TopicCommentController');
Route::post('forum/topic/{id}/comment', 'TopicCommentController@store')->name('comment.store');

/*Interview*/
Route::resource('interview', 'Interview\InterviewController');

/*Best*/
Route::resource('best', 'Best\BestController');

/*Replay*/
Route::resource("replay", 'Replay\ReplayUserController');
Route::post('/loadmore/load_replays', 'Replay\ReplayController@loadNews')->name('load.more.replays');
Route::post('replay/{id}/send_comment', 'Replay\ReplayController@saveComments')->name('replay.send_comment');
Route::group(['prefix' => 'replay'], function () {
    Route::get('{id}/download', 'Replay\ReplayController@download')->name('replay.user.download');
    Route::post('{id}/download_count', 'Replay\ReplayController@downloadCount')->name('replay.user.download.count');
});
Route::resource("replay_pro", 'Replay\ReplayProController');
Route::group(['prefix' => 'replay_pro'], function () {
    Route::get('{id}/download', 'Replay\ReplayController@download')->name('replay_pro.download');
    Route::post('{id}/download_count', 'Replay\ReplayController@downloadCount')->name('replay.pro.download.count');
    Route::get("{type}/show", 'Replay\ReplayProTypeController@index')->name('replay_pro.type.index');
    Route::get("{type}/show/{replay_pro}", 'Replay\ReplayProTypeController@show')->name('replay_pro.type.show');
    Route::get('{type}/show/{id}/download', 'Replay\ReplayController@download')->name('replay_pro.type.download');
    Route::post('{type}/show/{id}/download_count', 'Replay\ReplayController@downloadCount')->name('replay_pro.type.download.count');
});
/*Tournament*/
Route::resource("tournament", 'Tournament\TournamentController');

Route::get('user', function () {
    return view('user.index');
});

/*User Gallery*/
Route::group(['prefix' => 'user'], function () {
    Route::resource("gallery", 'User\UserGalleryController');
});


Auth::routes();
