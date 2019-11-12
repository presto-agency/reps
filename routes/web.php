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
Route::resource('forum', 'Forum\ForumController');
Route::group(['prefix' => 'forum'], function () {
    Route::post('{forum}/loadmore/load_forum_section', 'Forum\ForumController@loadForumShow')->name('load.more.forum.show');
    Route::post('loadmore/load_forum_sections', 'Forum\ForumController@loadForumIndex')->name('load.more.forum.index');

    /*Topic*/
    Route::resource('topic', 'ForumTopic\TopicController');
    Route::group(['prefix' => 'topic'], function () {
        Route::post('{id}/comment', 'ForumTopic\TopicController@saveComments')->name('topic.send_comment');
    });
});
/*Interview*/
Route::resource('interview', 'Interview\InterviewController');
/*Best*/
Route::resource('best', 'Best\BestController');
/*Replay*/
Route::resource("replay", 'Replay\ReplayController');
Route::group(['prefix' => 'replay'], function () {
    Route::post('loadmore/load_replay', 'Replay\ReplayController@loadReplay')->name('load.more.replay');
    Route::get('{id}/download', 'Replay\ReplayHelper@download')->name('replay.download');
    Route::post('{id}/download_count', 'Replay\ReplayHelper@downloadCount')->name('replay.download.count');
    Route::post('{id}/send_comment', 'Replay\ReplayHelper@saveComments')->name('replay.send_comment');
    /*Search Replay*/
    Route::get('search', 'Replay\ReplaySearchController@index')->name('replay.search');
});
/*Tournament*/
Route::resource("tournament", 'Tournament\TournamentController');
Route::post('/loadmore/load_tournament', 'Tournament\TournamentController@loadTournament')->name('load.more.tournament');

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {

    Route::get('/friends_list', 'UserFriendController@getFriendsList')->name('user.friends_list');

    Route::get('{id}', 'UserController@show')->name('user_profile');
    Route::resource("{id}/user-gallery", 'User\UserGalleryController');
    Route::resource("{id}/user-topics", 'User\UserTopicsController');
    Route::resource("{id}/user-replay", 'User\UserReplayController');
    Route::post('{id}/loadmore/load_replay', 'User\UserReplayController@loadReplay')->name('load.more.user.replay');

    Route::resource("{id}/user-comments", 'User\UserCommentsController');
    Route::resource("{id}/user-rating-list", 'User\UserRatingListController');
    Route::resource("{id}/user-topic-rating-list", 'User\UserTopicRatingListController');

//    Route::get('{id}/topic', 'TopicController@getUserTopic')->name('user.forum_topic');

    Route::get('{id}/edit', 'UserController@edit')->name('edit_profile');
    Route::post('{id}/save', 'UserController@update')->name('save_profile');
    Route::get('{id}/add_friend', 'UserFriendController@addFriend')->name('user.add_friend');
    Route::get('{id}/remove_friend', 'UserFriendController@removeFriend')->name('user.remove_friend');
    Route::get('{id}/friends_list', 'UserFriendController@getFriendsList')->name('user.friends_list.by_id');

});
/*Galleries*/
Route::resource("galleries", 'User\GalleriesController');
//Route::post('/loadmore/load_gallery', 'User\GalleriesController@loadGallery')->name('load.more.gallery');

Route::post('galleries/{id}/send_comment', 'User\GalleryHelper@saveComments')->name('galleries.send.comment');
/*Search*/
Route::get('search', 'Search\SearchController@index')->name('search');
Route::group(['prefix' => 'replay'], function () {
    Route::group(['prefix' => 'loadmore'], function () {
        Route::post('load_search_news', 'Search\SearchController@loadNews')->name('load.more.search.news');
        Route::post('load_search_replays', 'Search\SearchController@loadReplay')->name('load.more.search.replays');
    });
});


Auth::routes();
