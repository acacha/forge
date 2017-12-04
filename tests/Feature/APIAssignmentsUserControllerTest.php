<?php

namespace Tests\Feature;

use Acacha\Forge\Models\Assignment;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class APIAssignmentsUserControllerTest.
 *
 * @package Acacha\Assignments
 */
class APIAssignmentsUserControllerTest extends TestCase
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
     * Teacher can add assign assignment to a user.
     *
     * @test
     */
    public function teacher_can_assign_assignment_to_a_user()
    {
        $this->loginAsTeacher();
        $user = factory(User::class)->create();
        $assignment = factory(Assignment::class)->create();
        $response = $this->post('/api/v1/assignment/' . $assignment->id . '/user/' . $user->id);

        $response->assertSuccessful();

//        $response->dump();

        $this->assertDatabaseHas('assignables', [
            'assignment_id' => $assignment->id,
            'assignable_id' => $user->id,
            'assignable_type' => User::class,
        ]);

    }
}
