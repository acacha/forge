<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\StoreGitRepository;
use Log;
use Themsaid\Forge\Forge;

/**
 * Class APILoggedUserGitController
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APILoggedUserGitController extends Controller
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
     * @param StoreGitRepository $request
     * @param $serverId
     * @param $siteId
     */
    public function store(StoreGitRepository $request, $serverId, $siteId)
    {
        try {
            $site = $this->forge->site($serverId, $siteId);
        } catch (\Exception $e) {
            abort(404,$e->getMessage());
        }

        $provider = $request->provider ? $request->provider : 'github';
        $branch = $request->branch ? $request->branch : 'master';

        $site->installGitRepository([
            "provider" => $provider,
            "repository" => $request->repository,
            "branch" => $branch
        ]);
    }
}