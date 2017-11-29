<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\StoreDeploy;
use Themsaid\Forge\Forge;

/**
 * Class APILoggedUserDeployController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APILoggedUserDeployController extends Controller
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
     * Deploy site.
     *
     * @param StoreDeploy $request
     * @param $serverId
     * @param $siteId
     */
    protected function store(StoreDeploy $request, $serverId, $siteId)
    {
        try {
            $site = $this->forge->site($serverId, $siteId);
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }

        try {
            $site->deploySite();
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
