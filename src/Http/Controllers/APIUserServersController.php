<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Events\ServerHasBeenAssignedToUser;
use Acacha\Forge\Http\Requests\StoreUserServers;
use Acacha\Forge\Models\Server;
use App\User;

/**
 * Class APIServersController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APIUserServersController extends Controller
{
    /**
     * Store user servers.
     *
     * @param StoreUserServers $request
     * @param User $user
     * @return array
     */
    public function store(StoreUserServers $request, User $user)
    {
        $server = Server::firstOrCreate([
            'forge_id' => $request->server_id,
            'user_id' => $user->id,
            'state' => 'pending'
        ]);

        if(! $server->wasRecentlyCreated){
            abort(400,'The server has been already assigned to user!');
        }

        event(new ServerHasBeenAssignedToUser($server));

        return $server;
    }

}