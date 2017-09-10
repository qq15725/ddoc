<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('ddoc/readme', 'Wxm\DDoc\Controllers\DDocController@readme');

    Route::get('ddoc/api', 'Wxm\DDoc\Controllers\DDocController@apiDoc');

    Route::get('ddoc/database', 'Wxm\DDoc\Controllers\DDocController@databaseDoc');

    Route::get('ddoc', ['as' => 'ddoc', 'uses' => 'Wxm\DDoc\Controllers\DDocController@index']);

    Route::get('ddoc/login.html', function () {
        return view('ddoc::login');
    });

    Route::post('ddoc', 'Wxm\DDoc\Controllers\DDocController@login');
});