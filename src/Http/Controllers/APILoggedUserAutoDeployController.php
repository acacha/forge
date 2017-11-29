<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\DestroyAutoDeploy;
use Acacha\Forge\Http\Requests\StoreAutoDeploy;
use Themsaid\Forge\Forge;

/**
 * Class APILoggedUserAutoDeployController
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APILoggedUserAutoDeployController extends Controller
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
     * Enable autodeploy.
     *
     * @param StoreAutoDeploy $request
     * @param $serverId
     * @param $siteId
     */
    public function store(StoreAutoDeploy $request, $serverId, $siteId)
    {
        try {
            $this->forge->site($serverId, $siteId);
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }

        try {
            $this->forge->enableQuickDeploy($serverId, $siteId);
        } catch (\Exception $e) {
        }
    }

    /**
     * Disable autodeploy.
     *
     * @param DestroyAutoDeploy $request
     * @param $serverId
     * @param $siteId
     */
    public function destroy(DestroyAutoDeploy $request, $serverId, $siteId)
    {
        try {
            $this->forge->site($serverId, $siteId);
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }

        $this->forge->disableQuickDeploy($serverId, $siteId);
    }
}
