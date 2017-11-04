<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\ServerSitesStore;
use Themsaid\Forge\Forge;

/**
 * Class ServerSitesController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class ServerSitesController extends Controller
{

    /**
     * Forge sdk.
     *
     * @var
     */
    protected $forge;

    /**
     * ServerSitesController constructor.
     *
     * @param $sites
     */
    public function __construct(Forge $sites)
    {
        $this->sites = $sites;
    }

    /**
     * Store site to a specific server.
     *
     * @param ServerSitesStore $request
     * @param Server $server
     * @return mixed
     */
    public function store(ServerSitesStore $request, Server $server)
    {

        // Requeriments: Forge SDK: all types of api
        // Server: server id.
        $forge = new \Themsaid\Forge\Forge(env('FORGE_API_TOKEN'));

        $servers = $forge->servers();

        dd($servers);

//        $server = $forge->server($server->id);

        $forge->createSite($server->id, $request->only(['domain','project_type','directory']));

//      This method will ping Forge servers every 5 seconds and see if the newly created Site's status is installed
// and only return when it's so, in case the waiting exceeded 30 seconds a Themsaid\Forge\Exceptions\TimeoutException
// will be thrown.
//
//    You can easily stop this behaviour be setting the $wait argument to false:
//
//$forge->createSite(SERVER_ID, [SITE_PARAMETERS], false);
//You can also set the desired timeout value:
//
//$forge->setTimeout(120)->createSite(SERVER_ID, [SITE_PARAMETERS]);

//        return $this->sites->server($server)->store($request->only(['domain','project_type','directory']));
    }

}