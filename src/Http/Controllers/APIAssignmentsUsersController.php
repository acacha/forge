<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\StoreAssignmentUser;
use Acacha\Forge\Models\Assignment;
use App\User;

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
        $assignment->users()->save($user);
    }
}