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

/*Route::get('user', function (){
    return view('user.index');
});*/

Route::group(['prefix' => 'user','middleware' => 'auth'], function () {

    Route::get('/friends_list', 'UserFriendController@getFriendsList')->name('user.friends_list');

    Route::resource("user-gallery", 'User\UserGalleryController');
    Route::resource("user-replay", 'User\UserReplayController');

    Route::get('{id}', 'UserController@show')->name('user_profile');
    Route::get('{id}/topic', 'TopicController@getUserTopic')->name('user.forum_topic');
    Route::get('{id}/edit', 'UserController@edit')->name('edit_profile');
    Route::post('{id}/save', 'UserController@update')->name('save_profile');
    Route::get('{id}/add_friend', 'UserFriendController@addFriend')->name('user.add_friend');
    Route::get('{id}/remove_friend', 'UserFriendController@removeFriend')->name('user.remove_friend');
    Route::get('{id}/friends_list', 'UserFriendController@getFriendsList')->name('user.friends_list.by_id');






    /*Route::get('{id}/topic', function (){
        echo 'dsaf';
    });*/
});
/*Galleries*/
Route::resource("galleries", 'User\GalleriesController');
Route::post('galleries/{id}/send_comment', 'User\GalleryHelper@saveComments')->name('galleries.send.comment');


Auth::routes();
