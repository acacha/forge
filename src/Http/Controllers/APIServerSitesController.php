<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\ServerSitesStore;
use Acacha\Forge\Models\Server;
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
     * @param Server $forgeserver
     * @return mixed
     */
    public function store(ServerSitesStore $request, Server $forgeserver)
    {
        $response = [];
        try {
            $response = $this->forge->createSite(159526, $request->only(['domain','project_type','directory']));
        } catch (TimeoutException $exception) {
            abort(500,'Timeout exception connecting to Laravel Forge');
        }

        return (array) $response;
    }

}