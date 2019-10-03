<?php

Route::get('', ['as' => 'admin.dashboard', function () {
    $content = view('admin.dashboard');
    return AdminSection::view($content);
}]);

Route::delete('interview_variant_answers/delete/{id}', '\App\Http\Controllers\Admin\InterviewVariantAnswerController@delete')
    ->name('admin.answers.delete');

Route::get('interview_questions/show/{id}', '\App\Http\Controllers\Admin\InterviewQuestionsController@show');





//Route::get('', '\App\Http\Controllers\MyController@index');
Route::get('information', ['as' => 'information', function () {
    $content = 'Define your information here.';
    return AdminSection::view($content, 'Information');
}]);

Route::get('forum_topics/show/{id}', '\App\Http\Controllers\Admin\ForumTopicController@show');
Route::post('forum_topics/show/{id}/send_comment', '\App\Http\Controllers\Admin\TopicCommentController@store')->name('admin.forum.topic.comment_send');


