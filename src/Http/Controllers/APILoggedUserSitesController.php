<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\ListSites;
use Themsaid\Forge\Forge;

/**
 * Class APILoggedUserSitesController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APILoggedUserSitesController extends Controller
{
    /**
     * Forge sdk.
     *
     * @var Forge
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
     * Show sites of logged user
     */
    public function index(ListSites $request, $serverId)
    {
        return $this->forge->sites($serverId);
    }
}
