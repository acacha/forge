<?php

namespace Acacha\Forge\Http\Controllers;

use Auth;

/**
 * Class APIServersController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APILoggedUserServersController extends Controller
{

    /**
     * Show servers of logged user
     */
    public function index()
    {
        return Auth::user()->servers()->valid()->get();
    }
}