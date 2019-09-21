<?php

Route::get('', ['as' => 'admin.dashboard', function () {

    return AdminSection::view("123", 'Dashboard');
}]);
//Route::get('', '\App\Http\Controllers\MyController@index');
Route::get('information', ['as' => 'information', function () {
    $content = 'Define your information here.';
    return AdminSection::view($content, 'Information');
}]);
