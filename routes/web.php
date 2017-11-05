<?php

Route::group(['middleware' => 'auth'], function () {
    //Route::get('/link1', function ()

    //Add this to your app routes:
//    Route::view('/home','acacha-forge::home');

    Route::view('/servers','acacha-forge::servers');
});


Route::post('/users/{user}/servers/{forgeserver}/validate',         'APIValidServersController@store');
