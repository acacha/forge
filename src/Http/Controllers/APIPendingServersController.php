<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\AskServerPermission;
use Acacha\Forge\Models\Server;
use Acacha\Forge\Notifications\ServerPermissionRequested;
use Acacha\Forge\NotifierManager;
use App\User;

/**
 * Class APIPendingServersController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APIPendingServersController extends Controller
{
    /**
     * Ask for server permission.
     *
     * @param AskServerPermission $request
     * @param User $user
     * @param Server $forgeserver
     * @return Server
     */
    public function store(AskServerPermission $request, User $user, Server $forgeserver)
    {
        if ($forgeserver->state === 'pending') {
            resolve(\Illuminate\Notifications\ChannelManager::class)->send(null, new ServerPermissionRequested($forgeserver));
            return $forgeserver;
        }
        abort(400, 'Server is already validated');
    }
}
