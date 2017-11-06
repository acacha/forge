<?php

Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {

    Route::get('/servers',                                                   'APIServersController@index');

    Route::post('/servers/{forgeserver}/sites',                              'APIServerSitesController@store');

    Route::get('/users',                                                     'APIUsersController@index');
    Route::get('/users_with_logged_user',                                    'APIUsersWithLoggedUserController@index');

    Route::post('/users/{user}/servers/{forgeserver}/ask_permission',        'APIPendingServersController@store');

    Route::post('/users/{user}/servers/{forgeserver}/validate',              'APIValidServersController@store');
    Route::delete('/users/{user}/servers/{forgeserver}/validate',            'APIValidServersController@destroy');

    Route::get('/users/{user}/servers',                                      'APIUserServersController@index');
    Route::post('/users/{user}/servers',                                     'APIUserServersController@store');
    Route::delete('/users/{user}/servers/{forge_id}',                        'APIUserServersController@destroy');


});