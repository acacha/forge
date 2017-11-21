<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\StoreGitRepository;

/**
 * Class APILoggedUserGitController
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APILoggedUserGitController extends Controller
{
    /**
     * Show servers of logged user
     */
    public function store(StoreGitRepository $request, $serverId, $siteId)
    {
//            Route::post('/user/servers/{serverId}/sites/{siteId}/git',               'APILoggedUserGitController@store');

//        return Auth::user()->servers()->valid()->get();
    }
}