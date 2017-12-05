<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\StoreAssignmentGroup;
use Acacha\Forge\Models\Assignment;
use Acacha\Forge\Models\Group;
use Illuminate\Http\JsonResponse;

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
     * @return JsonResponse
     */
    protected function store(StoreAssignmentGroup $request, Assignment $assignment, Group $group)
    {
        if ($this->skipIfAlreadyAssigned($assignment, $group)) {
            return new JsonResponse(['message' => 'Group is already assigned'], 422);
        }

        $assignment->groups()->save($group);
        $assignment->users()->saveMany($group->users);
    }

    /**
     * Skip if already assigned.
     *
     * @param $assignment
     * @param $group
     * @return bool
     */
    protected function skipIfAlreadyAssigned($assignment, $group)
    {
        return ($assignment->groups->where('name',$group->name)->count() > 0);
    }
}