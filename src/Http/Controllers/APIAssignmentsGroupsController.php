<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\StoreAssignmentGroup;
use Acacha\Forge\Models\Assignment;
use Acacha\Forge\Models\Group;

/**
 * Class APIAssignmentsGroupsController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APIAssignmentsGroupsController extends Controller
{

    /**
     * Store assignment.
     *
     * @param StoreAssignmentGroup $request
     * @param Assignment $assignment
     * @param Group $group
     */
    protected function store(StoreAssignmentGroup $request, Assignment $assignment, Group $group)
    {
        $assignment->groups()->save($group);
        $assignment->users()->saveMany($group->users);
    }
}