<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\ValidateServerPermission;
use Acacha\Forge\Models\Server;
use App\User;

/**
 * Class APIValidServersController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APIValidServersController extends Controller
{
    /**
     * Ask for server permission.
     *
     * @param ValidateServerPermission $request
     * @param User $user
     * @param Server $forgeserver
     * @return Server
     */
    public function store(ValidateServerPermission $request, User $user, Server $forgeserver)
    {
        if ($forgeserver->state === 'pending') {
            $forgeserver->state='valid';
            $forgeserver->token= null;
            $forgeserver->save();
            return $forgeserver;
        }
        abort(400,'Server is already validated');
    }

}