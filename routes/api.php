<?php

Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {
    Route::get('/check_token', 'APICheckTokenController@index');
    Route::get('/servers', 'APIServersController@index');

    Route::post('/servers/{forgeserver}/sites', 'APIServerSitesController@store');

    Route::get('/users', 'APIUsersController@index');
    Route::get('/users_with_logged_user', 'APIUsersWithLoggedUserController@index');

    Route::post('/users/{user}/servers/{forgeserver}/ask_permission', 'APIPendingServersController@store');

    Route::post('/users/{user}/servers/{forgeserver}/validate', 'APIValidServersController@store');
    Route::delete('/users/{user}/servers/{forgeserver}/validate', 'APIValidServersController@destroy');

    Route::get('/users/{user}/servers', 'APIUserServersController@index');
    Route::post('/users/{user}/servers', 'APIUserServersController@store');
    Route::delete('/users/{user}/servers/{forge_id}', 'APIUserServersController@destroy');

    Route::get('/user/servers', 'APILoggedUserServersController@index');

    Route::get('/user/sites/{server_id}', 'APILoggedUserSitesController@index');

    Route::post('/user/servers/{serverId}/sites/{siteId}/git', 'APILoggedUserGitController@store');

    Route::post('/user/servers/{serverId}/keys', 'APILoggedUserKeyController@store');

    Route::post('/user/servers/{serverId}/sites/{siteId}/deploy', 'APILoggedUserAutoDeployController@store');
    Route::delete('/user/servers/{serverId}/sites/{siteId}/deploy', 'APILoggedUserAutoDeployController@destroy');


    Route::post('/user/servers/{serverId}/sites/{siteId}/certificates/letsencrypt',
                                                                                'APILoggedUserLetsEncryptController@store');

    Route::post('/user/servers/{serverId}/sites/{siteId}/certificates/{id}/activate',
                                                                                'APILoggedUserActiveCertificateController@store');

    Route::get('/user/servers/{serverId}/sites/{siteId}/certificates',
                                                                                'APILoggedUserCertificatesController@index');

    Route::post('/user/servers/{serverId}/sites/{siteId}/deployment/deploy',
                                                                                'APILoggedUserDeployController@store');

    Route::get('/user/servers/{serverId}/sites/{siteId}/deployment/script',
                                                                                'APILoggedUserDeploymentScriptController@show');
    Route::put('/user/servers/{serverId}/sites/{siteId}/deployment/script',
                                                                                'APILoggedUserDeploymentScriptController@update');

    Route::get('/user/servers/{serverId}/mysql',                'APILoggedUserMysqlController@index');
    Route::get('/user/servers/{serverId}/mysql/{databaseId}',   'APILoggedUserMysqlController@show');
    Route::post('/user/servers/{serverId}/mysql',               'APILoggedUserMysqlController@store');


    Route::get('/user/servers/{serverId}/mysql_users',          'APILoggedUserMysqlUsersController@index');
    Route::get('/user/servers/{serverId}/mysql_users/{userId}', 'APILoggedUserMysqlUsersController@show');
    Route::post('/user/servers/{serverId}/mysql_users',         'APILoggedUserMysqlUsersController@store');

    //Assignments
    Route::get('/assignment',                               'APIAssignmentsController@index');
    Route::get('/assignment/{assignment}',                  'APIAssignmentsController@show');
    Route::post('/assignment',                              'APIAssignmentsController@store');
    Route::put('/assignment/{assignment}',                  'APIAssignmentsController@update');
    Route::delete('/assignment/{assignment}',               'APIAssignmentsController@destroy');
    Route::post('/assignment/{assignment}/user/{user}',     'APIAssignmentsUsersController@store');
    Route::post('/assignment/{assignment}/group/{group}',   'APIAssignmentsGroupsController@store');

    //Logged user assignments
    Route::get('/user/assignment',                          'APILoggedUserAssignmentsController@index');
    Route::get('/user/assignment/{assignment}',             'APILoggedUserAssignmentsController@show');

//    $response = $this->post('/api/v1/assignment/' . $assignment->id . '/user/' . $user->id);
});
