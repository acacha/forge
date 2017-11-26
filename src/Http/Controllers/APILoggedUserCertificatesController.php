<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\ActivateSSL;
use Acacha\Forge\Http\Requests\ListCertificates;
use Themsaid\Forge\Forge;

/**
 * Class APILoggedUserCertificatesController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APILoggedUserCertificatesController extends Controller
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
     * List certificates.
     */
    protected function index(ListCertificates $request,$serverId, $siteId)
    {
        return $this->forge->certificates($serverId, $siteId);
    }
}