<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\TeacherListAssignment;
use Auth;

/**
 * Class APILoggedTeacherAssignmentsController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APILoggedTeacherAssignmentsController extends Controller
{

    /**
     * List assignments.
     *
     * @param TeacherListAssignment $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(TeacherListAssignment $request)
    {
        return Auth::user()->createdAssignments;
    }

}