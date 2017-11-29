<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\ListUsers;
use App\User;
use Auth;

/**
 * Class APIUsersController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APIUsersController extends Controller
{

    /**
     * @param ListUsers $request
     * @return array
     */
    public function index(ListUsers $request)
    {
        return User::all();
    }
}
