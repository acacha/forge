<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\UserListAssignment;
use Acacha\Forge\Http\Requests\UserShowAssignment;
use Acacha\Forge\Http\Requests\UserUpdateAssignment;
use Acacha\Forge\Models\Assignment;
use Auth;

/**
 * Class APILoggedUserAssignmentsController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APILoggedUserAssignmentsController extends Controller
{

    /**
     * List assignments.
     *
     * @param UserListAssignment $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(UserListAssignment $request)
    {
        return Auth::user()->assignments;
    }

    /**
     * Show assignment.
     *
     * @param UserShowAssignment $request
     * @param Assignment $assignment
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function show(UserShowAssignment $request, Assignment $assignment)
    {
        return $assignment;
    }

    /**
     * Update assignment.
     *
     * @param UserUpdateAssignment $request
     * @param Assignment $assignment
     * @return bool
     */
    protected function update(UserUpdateAssignment $request, Assignment $assignment)
    {
        //TODO
//        $assignment->update($request->only(['name','repository_uri','repository_type','forge_site','forge_server']));
        return $assignment;
    }

}