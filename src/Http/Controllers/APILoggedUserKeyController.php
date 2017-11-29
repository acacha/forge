<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\StoreSSHKey;
use Themsaid\Forge\Forge;

/**
 * Class APILoggedUserKeyController
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APILoggedUserKeyController extends Controller
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
     * Store SSH key on server.
     *
     * @param StoreSSHKey $request
     * @param $serverId
     * @return \Themsaid\Forge\Resources\SSHKey
     */
    public function store(StoreSSHKey $request, $serverId)
    {
        try {
            $result  = $this->forge->createSSHKey($serverId, $request->only(['name','key']), true);
        } catch (\Exception $e) {
            return json_encode($e);
        }
        return json_encode($result);
    }
}
