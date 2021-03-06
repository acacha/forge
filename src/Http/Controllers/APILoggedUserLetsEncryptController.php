<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\DestroyAutoDeploy;
use Acacha\Forge\Http\Requests\StoreAutoDeploy;
use Acacha\Forge\Http\Requests\StoreLetsEncrypt;
use Themsaid\Forge\Forge;

/**
 * Class ApiLoggedUserLetsEncryptController
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APILoggedUserLetsEncryptController extends Controller
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
     * @param StoreLetsEncrypt $request
     * @param $serverId
     * @param $siteId
     * @return array
     */
    public function store(StoreLetsEncrypt $request, $serverId, $siteId)
    {
        try {
            $this->forge->site($serverId, $siteId);
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }

        $domains = $request->domains;
        if (!is_array($domains)) {
            $domains = [ $request->domains ];
        }
        try {
            $this->forge->obtainLetsEncryptCertificate($serverId, $siteId, [ 'domains' => $domains], false);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }

        return ['message' => 'Lets Encrypt Certificate created ok!'];
    }
}
