<?php

Route::get('', ['as' => 'admin.dashboard', function () {
    $content = view('admin.dashboard');
    return AdminSection::view($content);
}]);


//Route::get('', '\App\Http\Controllers\MyController@index');
Route::get('information', ['as' => 'information', function () {
    $content = 'Define your information here.';
    return AdminSection::view($content, 'Information');
}]);
