<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\ListMySQL;
use Acacha\Forge\Http\Requests\ListMySQLUsers;
use Acacha\Forge\Http\Requests\ShowMySQL;
use Acacha\Forge\Http\Requests\ShowMySQLUser;
use Acacha\Forge\Http\Requests\StoreMySQL;
use Acacha\Forge\Http\Requests\StoreMySQLUser;
use Themsaid\Forge\Forge;

/**
 * Class APILoggedUserMysqlUsersController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APILoggedUserMysqlUsersController extends Controller
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
     * List mysql users.
     *
     * @param ListMySQLUsers $request
     * @param $serverId
     * @return \Themsaid\Forge\Resources\MysqlUser[]
     */
    protected function index(ListMySQLUsers $request, $serverId)
    {
        try {
            return $this->forge->mysqlUsers($serverId);
        } catch (\Exception $e) {
            abort(500,$e->getMessage());
        }
    }

    /**
     * List mysql user.
     *
     * @param ShowMySQLUser $request
     * @param $serverId
     * @param $userId
     * @return \Themsaid\Forge\Resources\MysqlUser
     */
    protected function show(ShowMySQLUser $request, $serverId, $userId)
    {
        try {
            return $this->forge->mysqlUser($serverId, $userId);
        } catch (\Exception $e) {
            abort(500,$e->getMessage());
        }
    }

    /**
     * Create mysql user.
     *
     * @param StoreMySQLUser $request
     * @param $serverId
     */
    protected function store(StoreMySQLUser $request, $serverId)
    {

        try {
            $this->forge->createMysqlUser($serverId, $request->only(['name','password','databases']), false);
        } catch (\Exception $e) {
            abort(500,$e->getMessage());
        }
    }
}