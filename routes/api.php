<?php

Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {
    //Route::resource('task', 'TasksController');

    Route::get('servers','APIServersController@index');

    Route::post('servers/{server}/sites','ServerSitesController@store');

    Route::get('users','APIUsersController@index');
    Route::get('users_with_logged_user','APIUsersWithLoggedUserController@index');

    Route::post('users/{user}/servers','APIUserServersController@store');

});