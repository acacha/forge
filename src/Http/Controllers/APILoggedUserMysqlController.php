<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\StoreMySQL;
use Themsaid\Forge\Forge;

/**
 * Class APILoggedUserMysqlController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APILoggedUserMysqlController extends Controller
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
     * @param StoreMySQL $request
     * @param $serverId
     */
    protected function store(StoreMySQL $request, $serverId)
    {
        try {
            $this->forge->createMysqlDatabase($serverId, $request->only(['name','user','password']), false);
        } catch (\Exception $e) {
            abort(500,$e->getMessage());
        }
    }
}