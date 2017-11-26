<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\ServerSitesStore;
use Acacha\Forge\Models\Server;
use Log;
use Themsaid\Forge\Exceptions\TimeoutException;
use Themsaid\Forge\Forge;

/**
 * Class APIServerSitesController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APIServerSitesController extends Controller
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
     * @param $forge
     */
    public function __construct(Forge $forge)
    {
        $this->forge = $forge;
    }

    /**
     * Store site to a specific server.
     *
     * @param ServerSitesStore $request
     * @param $forge_server
     * @return mixed
     */
    public function store(ServerSitesStore $request, $forge_server)
    {
        return (array) $this->forge->createSite($forge_server, $request->only(['domain','project_type','directory']),false);
    }

}