<?php

namespace Acacha\Forge\Http\Controllers;

use Acacha\Forge\Http\Requests\DestroyAssignment;
use Acacha\Forge\Http\Requests\ListAssignment;
use Acacha\Forge\Http\Requests\ShowAssignment;
use Acacha\Forge\Http\Requests\StoreAssignment;
use Acacha\Forge\Http\Requests\UpdateAssignment;
use Acacha\Forge\Models\Assignment;
use Auth;

/**
 * Class APIAssignmentsController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APIAssignmentsController extends Controller
{

    /**
     * List assignments.
     *
     * @param ListAssignment $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(ListAssignment $request)
    {
        return Assignment::with(['users','groups','assignators'])->get();
    }

    /**
     * Show assignment.
     *
     * @param ShowAssignment $request
     * @param Assignment $assignment
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function show(ShowAssignment $request, Assignment $assignment)
    {
        $assignment->load(['users','groups','assignators']);
        return $assignment;
    }

    /**
     * Store assignment.
     *
     * @param StoreAssignment $request.     *
     * @return mixed
     */
    protected function store(StoreAssignment $request)
    {
        $assignment = Assignment::create($request->only(['name','repository_uri','repository_type','forge_site','forge_server']));

        $assignment->assignators()->save(Auth::user());

        return $assignment;
    }

    /**
     * Update assignment.
     *
     * @param UpdateAssignment $request
     * @param Assignment $assignment
     * @return bool
     */
    protected function update(UpdateAssignment $request, Assignment $assignment)
    {
        $assignment->update($request->only(['name','repository_uri','repository_type','forge_site','forge_server']));
        return $assignment;
    }

    /**
     * Destroy assignment.
     *
     * @param DestroyAssignment $request
     * @param Assignment $assignment
     * @return bool|null
     */
    protected function destroy(DestroyAssignment $request, Assignment $assignment)
    {
        $assignment->delete();
        return $assignment;
    }
}