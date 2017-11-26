<?php

Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {

    Route::get('/check_token',                                               'APICheckTokenController@index');
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

    Route::get('/user/servers',                                              'APILoggedUserServersController@index');

    Route::get('/user/sites/{server_id}',                                    'APILoggedUserSitesController@index');

    Route::post('/user/servers/{serverId}/sites/{siteId}/git',               'APILoggedUserGitController@store');

    Route::post('/user/servers/{serverId}/keys',                             'APILoggedUserKeyController@store');

    Route::post('/user/servers/{serverId}/sites/{siteId}/deploy',            'APILoggedUserAutoDeployController@store');

    Route::post('/user/servers/{serverId}/sites/{siteId}/certificates/letsencrypt',
                                                                                'APILoggedUserLetsEncryptController@store');

    Route::post('/user/servers/{serverId}/sites/{siteId}/certificates/{id}/activate',
                                                                                'APILoggedUserActiveCertificateController@store');

    Route::get('/user/servers/{serverId}/sites/{siteId}/certificates',
                                                                                'APILoggedUserCertificatesController@index');

    Route::post('/user/servers/{serverId}/sites/{siteId}/deployment/deploy',
                                                                                'APILoggedUserDeployController@store');

    Route::post('/user/servers/{serverId}/mysql',                           'APILoggedUserMysqlController@store');


});