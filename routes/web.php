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

/*The Email Verification*/
Auth::routes([
    'verify' => true,
]);
//Route::get('/php-info',function (){
//    return phpinfo();
//});
/***---Home---***/
Route::get('/', 'HomeController@index')->name('home.index');

/***---News---***/
Route::resource('news', 'NewsController');
Route::post('news/{id}/send_comment', 'NewsController@comment_send')->name('news.comment_send');
Route::post('/loadmore/load_news', 'NewsController@load_news')->name('loadmore.load_news');
/***---Forum---***/
Route::resource('forum', 'Forum\ForumController');
Route::group(['prefix' => 'forum'], function () {
    Route::post('{forum}/loadmore/load_forum_section', 'Forum\ForumController@loadForumShow')->name('load.more.forum.show');
    Route::post('loadmore/load_forum_sections', 'Forum\ForumController@loadForumIndex')->name('load.more.forum.index');
    /***---Topic---***/
    Route::resource('topic', 'ForumTopic\TopicController');
    Route::group(['prefix' => 'topic'], function () {
        Route::post('{id}/comment', 'ForumTopic\TopicController@saveComments')->name('topic.send_comment');
        /**set reputation like/dislike*/
        Route::get('{id}/get_rating', 'TopicRatingController@getRating')->name('forum.topic.get_rating');
        Route::post('{id}/set_rating', 'TopicRatingController@setRating')->name('forum.topic.set_rating');
    });
});
/***---Interview---***/
Route::resource('interview', 'Interview\InterviewController');
/***---Best---***/
Route::resource('best', 'Best\BestController');
/***---Replay---***/
Route::resource("replay", 'Replay\ReplayController');

Route::group(['prefix' => 'replay'], function () {
    Route::post('loadmore/load_replay', 'Replay\ReplayController@loadReplay')->name('load.more.replay');
    Route::get('{id}/download', 'Replay\ReplayHelper@download')->name('replay.download');
    Route::post('{id}/download_count', 'Replay\ReplayHelper@downloadCount')->name('replay.download.count');
    Route::post('{id}/send_comment', 'Replay\ReplayHelper@saveComments')->name('replay.send_comment');

    /**set reputation like/dislike*/
    Route::get('{id}/get_rating', 'ReplayRatingController@getRating')->name('replay.get_rating');
    Route::post('{id}/set_rating', 'ReplayRatingController@setRating')->name('replay.set_rating');
});
/***---Tournament---***/
Route::resource("tournament", 'Tournament\TournamentController');
Route::get("tournament/{tourney}/{match}/{rep}/download-match",
    'Tournament\TournamentController@downloadMatch')->name('download.match');
//Route::post("{tournament}/download-all-match", 'Tournament\TournamentController@downloadMultipleMatch')->name('download.all.match');
Route::post('tournament/loadmore/load_tournament', 'Tournament\TournamentController@loadTournament')
     ->name('load.more.tournament');

Route::group(['middleware' => ['auth', 'ban', 'verified']], function () {
    /**comments rating: like/dislike*/
    Route::post('comment/{id}/set_rating', 'CommentsRatingController@setRating')
         ->name('comment.set_rating');
    //    Route::get('comment/{id}/get_rating', 'CommentsRatingController@getRating')->name('comment.ger_rating');
});

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'ban', 'verified'],], function () {
    Route::get('/friends_list', 'UserFriendController@getFriendsList')->name('user.friends_list');

    Route::get('messages', 'UserMessagingController@getUser')->name('user.messages_all');
    /***---Reputation Gallery---***/
    Route::get('/user-gallery/{id}/get_rating', 'UserGalleryRatingController@getRating')->name('gallery.get_rating');
    Route::post('/user-gallery/{id}/set_rating', 'UserGalleryRatingController@setRating')->name('gallery.set_rating');
    Route::get('{id}', 'UserController@show')->name('user_profile');
    Route::resource("{id}/user-gallery", 'User\UserGalleryController');
    Route::post('{id}/loadmore/load_gallery', 'User\UserGalleryController@loadGallery')->name('load.more.user.gallery');

    Route::resource("{id}/user-topics", 'User\UserTopicsController');
    /*** Ajax pagination user-sections(topics) ***/
    //    Route::post('{id}/user-topics/load_sections', 'User\UserTopicsController@forumSectionsAjaxLoad')
    //        ->name('user.topics.load.sections');
    /*** Ajax pagination user-sections-topics ***/
    Route::post('{id}/user-topics/load_sections_topics', 'User\UserTopicsController@forumSectionsTopicsAjaxLoad')
         ->name('user.topics.load.sections.topics');

    Route::resource("{id}/user-replay", 'User\UserReplayController');
    Route::post('replay_set_iframe', 'User\UserReplayController@iframe')->name('set.iframe');
    Route::post('{id}/loadmore/load_replay', 'User\UserReplayController@loadReplay')
         ->name('load.more.user.replay');

    Route::resource("{id}/user-comments", 'User\UserCommentsController');
    /*** Ajax pagination user-sections-topics ***/
    Route::post('{id}/user-comments/load_sections_comments', 'User\UserCommentsController@forumSectionsCommentsAjaxLoad')
         ->name('user.comments.load.sections.comments');

    Route::resource("{id}/user-rating-list", 'User\UserRatingListController');

    Route::get('{id}/edit', 'UserController@edit')->name('edit_profile');
    Route::put('{id}/save', 'UserController@update')->name('save_profile');
    Route::get('{id}/add_friend', 'UserFriendController@addFriend')->name('user.add_friend');
    Route::get('{id}/remove_friend', 'UserFriendController@removeFriend')->name('user.remove_friend');
    Route::get('{id}/friends_list', 'UserFriendController@getFriendsList')->name('user.friends_list.by_id');

    Route::get('{id}/messages', 'UserMessagingController@getUser')->name('user.messages');
    Route::post('send_message', 'UserMessagingController@send')->name('user.send_message');
    Route::get('/message/{dialogue_id}/load', 'UserMessagingController@loadMoreMessages')->name('user.message_load');

    /**get user reputation list*/
    //        Route::get('{id}/get_rating', 'RatingController@getRatingUser')->name('user.get_rating');
});

Route::group(['prefix' => 'chat'], function () {
    /*Route::get('/', function (){
        return view('stream-section.test-chat');
    });*/

    Route::group(['middleware' => ['auth', 'ban', 'verified']], function () {
        Route::post('/insert_message', 'ChatController@insert_message')->name('chat.add_message');
        Route::delete('/delete/{id}', 'ChatController@destroy')->name('chat.delete_message');
    });

    Route::get('/get_messages', 'ChatController@get_messages')->name('chat.get_messages');
    //    Route::post('/get_message', 'ChatController@get_message')->name('chat.get_message');

    Route::get('/get_externalsmiles', 'ChatController@get_externalsmiles')->name('chat.get_smiles');
    Route::get('/get_externalimages', 'ChatController@get_externalimages')->name('chat.get_images');
});
/***---Galleries---***/
Route::resource('galleries', 'Gallery\GalleriesController');
Route::post('galleries/loadmore/load_galleries', 'Gallery\GalleriesController@loadGalleries')->name('load.more.galleries');
Route::post('galleries/{id}/send_comment', 'User\GalleryHelper@saveComments')->name('galleries.send.comment');
/***---Search Replay---***/
Route::get('replay-search', 'Replay\ReplaySearchController@index')->name('replay.only.search');
Route::group(['prefix' => 'replay-search'], function () {
    Route::post('loadmore/load_search_replays_only', 'Replay\ReplaySearchController@loadReplay')->name('load.more.replay.only.search');
});
/***---Search---***/
Route::get('replay-news-search', 'Search\SearchController@index')->name('search');
Route::group(['prefix' => 'replay-news-search'], function () {
    Route::group(['prefix' => 'loadmore'], function () {
        Route::post('load_search_news', 'Search\SearchController@loadNews')->name('load.more.search.news');
        Route::post('load_search_replays', 'Search\SearchController@loadReplay')->name('load.more.search.replays');
    });
});

Auth::routes();
