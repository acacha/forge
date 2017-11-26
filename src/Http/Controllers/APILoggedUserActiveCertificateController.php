<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\ActivateSSL;
use Themsaid\Forge\Forge;

/**
 * Class APILoggedUserActiveCertificateController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APILoggedUserActiveCertificateController extends Controller
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
     * Show servers of logged user.
     *
     * @param ActivateSSL $request
     * @param $serverId
     * @param $siteId
     * @return array
     */
    public function store(ActivateSSL $request, $serverId, $siteId, $certificateId)
    {
        try {
            $this->forge->site($serverId, $siteId);
        } catch (\Exception $e) {
            abort(404,$e->getMessage());
        }

        try {
            $this->forge->activateCertificate($serverId, $siteId, $certificateId ,false);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }

        return ['message' => 'Certificate activated ok!'];
    }
}