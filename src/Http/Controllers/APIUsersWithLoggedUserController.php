<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\ListUsers;
use App\User;
use Auth;

/**
 * Class APIUsersWithLoggedUserController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APIUsersWithLoggedUserController extends Controller
{

    /**
     * List users with logged user
     * @param ListUsers $request
     * @return array
     */
    public function index(ListUsers $request)
    {
        return array_merge([
                'logged' => Auth::guard('api')->user()
            ],
            [
                'users' => User::all()->toArray()
            ]);
    }
}
