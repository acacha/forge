<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\StoreAssignmentUser;
use Acacha\Forge\Models\Assignment;
use App\User;
use Illuminate\Http\JsonResponse;

/**
 * Class APIAssignmentsUsersController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APIAssignmentsUsersController extends Controller
{

    /**
     * Store assignment.
     *
     * @param StoreAssignmentUser $request.
     * @return mixed
     */
    protected function store(StoreAssignmentUser $request, Assignment $assignment, User $user)
    {
        if ($this->skipIfAlreadyAssigned($assignment, $user)) {
            return new JsonResponse(['message' => 'Group is already assigned'], 422);
        }
        $assignment->users()->save($user);
    }

    /**
     * Skip if already assigned.
     *
     * @param $assignment
     * @param $user
     * @return bool
     */
    protected function skipIfAlreadyAssigned($assignment, $user)
    {
        return ($assignment->users->where('name',$user->name)->count() > 0);
    }
}