<?php

namespace Tests\Feature;

use Acacha\Forge\Models\Assignment;
use Acacha\Forge\Models\Group;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class APIAssignmentsGroupsControllerTest.
 *
 * @package Acacha\Assignments
 */
class APIAssignmentsGroupsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
        initialize_forge_management_permissions();
        $this->withoutExceptionHandling();

    }

    /**
     * Login as groups manager.
     *
     */
    protected function loginAsTeacher()
    {
        $user = factory(User::class)->create();
        $user->assignRole('teacher');
        $this->actingAs($user,'api');
    }

    /**
     * Teacher can add assign assignment to a group.
     *
     * @test
     */
    public function teacher_can_assign_assignment_to_a_group()
    {
        $this->loginAsTeacher();
        $group = factory(Group::class)->create();
        $assignment = factory(Assignment::class)->create();
        $response = $this->post('/api/v1/assignment/' . $assignment->id . '/group/' . $group->id);

        $response->assertSuccessful();

//        $response->dump();

        $this->assertDatabaseHas('assignables', [
            'assignment_id' => $assignment->id,
            'assignable_id' => $group->id,
            'assignable_type' => Group::class,
        ]);

    }

    /**
     * Teacher can add assign assignment to a group with users.
     *
     * @test
     */
    public function teacher_can_assign_assignment_to_a_group_with_users()
    {
        $this->loginAsTeacher();
        $group = factory(Group::class)->create();
        $users = factory(User::class,3)->create();
        //Assign users to group

        $group->users()->saveMany($users);

        $assignment = factory(Assignment::class)->create();
        $response = $this->post('/api/v1/assignment/' . $assignment->id . '/group/' . $group->id);

        $response->assertSuccessful();

//        $response->dump();

        $this->assertDatabaseHas('assignables', [
            'assignment_id' => $assignment->id,
            'assignable_id' => $group->id,
            'assignable_type' => Group::class,
        ]);

        foreach ($users as $user) {
            $this->assertDatabaseHas('assignables', [
                'assignment_id' => $assignment->id,
                'assignable_id' => $user->id,
                'assignable_type' => User::class,
            ]);
        }

    }
}
