<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\ListServers;
use Themsaid\Forge\Forge;

/**
 * Class APIServersController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APIServersController extends Controller
{
    /**
     * Forge sdk.
     *
     * @var
     */
    protected $forge;

    /**
     * APIServersController constructor.
     *
     * @param $forge
     */
    public function __construct(Forge $forge)
    {
        $this->forge = $forge;
    }

    /**
     * @param ListServers $request
     * @return array
     */
    public function index(ListServers $request)
    {
        $servers = [];
        foreach ($this->forge->servers() as $server) {
            $servers[] = [
                'id'   => $server->id,
                'name' => $server->name,
            ];
        }
        return $servers;
    }

}