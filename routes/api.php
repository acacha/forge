<?php

Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {

    Route::get('servers',                                                   'APIServersController@index');

    Route::post('servers/{server}/sites',                                   'ServerSitesController@store');

    Route::get('users',                                                     'APIUsersController@index');
    Route::get('users_with_logged_user',                                    'APIUsersWithLoggedUserController@index');

    Route::get('users/{user}/servers',                                      'APIUserServersController@index');
    Route::post('users/{user}/servers',                                     'APIUserServersController@store');

    Route::post('/users/{user}/servers/{forgeserver}/ask_permission',       'APIPendingServersController@store');

    Route::post('/users/{user}/servers/{forgeserver}/validate',             'APIValidServersController@store');


});