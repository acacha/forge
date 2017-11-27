<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\DestroyAutoDeploy;
use Acacha\Forge\Http\Requests\ShowDeploymentScript;
use Acacha\Forge\Http\Requests\StoreAutoDeploy;
use Acacha\Forge\Http\Requests\UpdateDeploymentScript;
use Themsaid\Forge\Forge;

/**
 * Class APILoggedUserDeploymentScriptController
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APILoggedUserDeploymentScriptController extends Controller
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
     * Get deployment script.
     *
     * @param ShowDeploymentScript $request
     * @param $serverId
     * @param $siteId
     * @return string
     */
    public function show(ShowDeploymentScript $request, $serverId, $siteId)
    {
        try {
            $this->forge->site($serverId, $siteId);
        } catch (\Exception $e) {
            abort(404,$e->getMessage());
        }

        try {
            return $this->forge->siteDeploymentScript($serverId, $siteId);
        } catch (\Exception $e) {
            abort(500,['message' => $e->getMessage()]);
        }
    }

    /**
     * Update deployment script.
     *
     * @param UpdateDeploymentScript $request
     * @param $serverId
     * @param $siteId
     */
    public function update(UpdateDeploymentScript $request, $serverId, $siteId)
    {
        try {
            $this->forge->site($serverId, $siteId);
        } catch (\Exception $e) {
            abort(404,$e->getMessage());
        }

        $this->forge->updateSiteDeploymentScript($serverId, $siteId, $request->only(['content']));

    }
}