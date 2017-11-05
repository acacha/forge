<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Events\ServerHasBeenAssignedToUser;
use Acacha\Forge\Http\Requests\ListUserServers;
use Acacha\Forge\Http\Requests\StoreUserServers;
use Acacha\Forge\Models\Server;
use App\User;
use Illuminate\Support\Str;
use Themsaid\Forge\Forge;

/**
 * Class APIServersController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APIUserServersController extends Controller
{

    /**
     * Forge sdk.
     *
     * @var
     */
    protected $forge;

    /**
     * APIUserServersController constructor.
     *
     * @param $forge
     */
    public function __construct(Forge $forge)
    {
        $this->forge = $forge;
    }

    /**
     * List user servers.
     *
     * @param ListUserServers $request
     * @param User $user
     * @return mixed
     */
    public function index(ListUserServers $request, User $user)
    {
        return $user->servers;
    }

    /**
     * Get server id
     * @param $id
     */
    protected function getServerById($id)
    {
        $servers = collect($this->forge->servers());
        $result = $servers->search(function ($server) use ($id) {
            return $server->id == $id;
        });
        return $servers->get($result);
    }
    /**
     * Store user servers.
     *
     * @param StoreUserServers $request
     * @param User $user
     * @return array
     */
    public function store(StoreUserServers $request, User $user)
    {
        $forgeServer = $this->getServerById($request->server_id);

        $server = Server::firstOrCreate([
            'forge_id' => $request->server_id,
            'name' => $forgeServer->name,
            'user_id' => $user->id,
            'state' => 'pending'
        ]);

        if(! $server->wasRecentlyCreated){
            abort(400,'The server has been already assigned to user!');
        }

        $server->token = Str::random(60);
        $server->save();

        event(new ServerHasBeenAssignedToUser($server));

        return $server;
    }

}