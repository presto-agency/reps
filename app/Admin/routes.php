<?php

Route::get('', ['as' => 'admin.dashboard', function () {
    $content = view('admin.dashboard');
    return AdminSection::view($content);
}]);

Route::delete('interviewvariantanswers/destroy/{id}', '\App\Http\Controllers\Admin\InterviewVariantAnswerController@destroy')->name('admin.answers.destroy');

//Route::get('', '\App\Http\Controllers\MyController@index');
Route::get('information', ['as' => 'information', function () {
    $content = 'Define your information here.';
    return AdminSection::view($content, 'Information');
}]);
