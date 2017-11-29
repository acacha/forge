<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\ListMySQL;
use Acacha\Forge\Http\Requests\ShowMySQL;
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
     * List mysql database.
     *
     * @param ListMySQL $request
     * @param $serverId
     * @return \Themsaid\Forge\Resources\MysqlDatabase[]
     */
    protected function index(ListMySQL $request, $serverId)
    {
        try {
            return $this->forge->mysqlDatabases($serverId);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * List mysql database.
     *
     * @param ShowMySQL $request
     * @param $serverId
     * @return \Themsaid\Forge\Resources\MysqlDatabase
     */
    protected function show(ShowMySQL $request, $serverId, $databaseId)
    {
        try {
            return $this->forge->mysqlDatabase($serverId, $databaseId);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * Create mysql database.
     *
     * @param StoreMySQL $request
     * @param $serverId
     */
    protected function store(StoreMySQL $request, $serverId)
    {
        try {
            $this->forge->createMysqlDatabase($serverId, $request->only(['name','user','password']), false);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
