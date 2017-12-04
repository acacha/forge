<?php

namespace Tests\Feature;

use Acacha\Forge\Models\Assignment;
use App;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ApiLoggedTeacherAssignmentsControllerTest.
 *
 * @package Tests\Feature
 */
class ApiLoggedTeacherAssignmentsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        App::setLocale('en');
        initialize_forge_management_permissions();
        $this->withoutExceptionHandling();
    }

    /**
     * Login as teacher.
     *
     */
    protected function loginAsTeacher()
    {
        $user = factory(User::class)->create();
        $user->assignRole('teacher');
        $this->actingAs($user,'api');
        return $user;
    }

    /**
     * Teachers can list assignments.
     *
     * @test
     * @return void
     */
    public function teachers_can_list_assignments()
    {
        $teacher = $this->loginAsTeacher();

        $assignments = factory(Assignment::class,3)->create();

        $teacher->createdAssignments()->saveMany($assignments);

        $response = $this->get('/api/v1/teacher/assignment');
        $response->assertSuccessful();

        $this->assertCount(3, json_decode($response->getContent()));
//        $response->dump();

        $response->assertJson([
            [
                'id' => $assignments[0]->id,
                'name' => $assignments[0]->name,
                'repository_uri' => $assignments[0]->repository_uri,
                'repository_type' => $assignments[0]->repository_uri,
                'forge_site' => $assignments[0]->forge_site,
                'forge_server' => $assignments[0]->forge_server,
            ],
            [
                'id' => $assignments[1]->id,
                'name' => $assignments[1]->name,
                'repository_uri' => $assignments[1]->repository_uri,
                'repository_type' => $assignments[1]->repository_uri,
                'forge_site' => $assignments[1]->forge_site,
                'forge_server' => $assignments[1]->forge_server,
            ],
            [
                'id' => $assignments[2]->id,
                'name' => $assignments[2]->name,
                'repository_uri' => $assignments[2]->repository_uri,
                'repository_type' => $assignments[2]->repository_uri,
                'forge_site' => $assignments[2]->forge_site,
                'forge_server' => $assignments[2]->forge_server,
            ],

        ]);
    }

    /**
     * Teachers can show an assignment.
     *
     * @test
     * @return void
     */
    public function teachers_can_show_an_assignment()
    {
        $this->loginAsTeacher();

        $assignment = factory(Assignment::class)->create();

        $response = $this->get('/api/v1/assignment/' . $assignment->id);

        $response->assertJson([
            'id' => $assignment->id,
            'name' => $assignment->name,
            'repository_uri' => $assignment->repository_uri,
            'repository_type' => $assignment->repository_uri,
            'forge_site' => $assignment->forge_site,
            'forge_server' => $assignment->forge_server,
        ]);
    }

    /**
     * Teachers can create assignments.
     *
     * @test
     * @return void
     */
    public function teachers_can_create_assignments()
    {
        $this->loginAsTeacher();

        $response = $this->post('/api/v1/assignment',[
            'name' => 'Assignment name'
        ]);

        $response->assertSuccessful();

//        $response->dump();

        $response->assertJson([
            'name' => 'Assignment name'
        ]);

        $this->assertDatabaseHas('assignments', [
            'name' => 'Assignment name'
        ]);
    }

    /**
     * Teachers can create assignments.
     *
     * @test
     * @return void
     */
    public function teachers_can_update_assignments()
    {
        $this->loginAsTeacher();
        $oldAssignment = factory(Assignment::class)->create();

        $response = $this->put('/api/v1/assignment/' . $oldAssignment->id,[
            'name' => 'New name',
            'repository_uri' => 'acacha/prova',
            'repository_type' => 'github',
            'forge_site' => 1526,
            'forge_server' => 1256,
        ]);

        $response->assertSuccessful();

//        $response->dump();

        $response->assertJson([
            'id' => $oldAssignment->id,
            'name' => 'New name',
            'repository_uri' => 'acacha/prova',
            'repository_type' => 'github',
            'forge_site' => 1526,
            'forge_server' => 1256,
        ]);

        $this->assertDatabaseHas('assignments', [
            'id' => $oldAssignment->id,
            'name' => 'New name',
            'repository_uri' => 'acacha/prova',
            'repository_type' => 'github',
            'forge_site' => 1526,
            'forge_server' => 1256,
        ]);

        $this->assertDatabaseMissing('assignments', [
            'id' => $oldAssignment->id,
            'name' => $oldAssignment->name,
            'repository_uri' => $oldAssignment->repository_uri,
            'repository_type' => $oldAssignment->repository_uri,
            'forge_site' => $oldAssignment->forge_site,
            'forge_server' => $oldAssignment->forge_server,
        ]);
    }

    /**
     * Teachers can destroy assignments.
     *
     * @test
     * @return void
     */
    public function teachers_can_destroy_assignments()
    {
        $this->loginAsTeacher();
        $assignment = factory(Assignment::class)->create();
        $response = $this->delete('/api/v1/assignment/' . $assignment->id);

        $response->assertSuccessful();

//        $response->dump();

        $response->assertJson([
            'id' => $assignment->id,
            'name' => $assignment->name,
            'repository_uri' => $assignment->repository_uri,
            'repository_type' => $assignment->repository_uri,
            'forge_site' => $assignment->forge_site,
            'forge_server' => $assignment->forge_server,
        ]);

        $this->assertDatabaseMissing('assignments', [
            'id' => $assignment->id,
            'name' => $assignment->name,
            'repository_uri' => $assignment->repository_uri,
            'repository_type' => $assignment->repository_uri,
            'forge_site' => $assignment->forge_site,
            'forge_server' => $assignment->forge_server,
        ]);
    }
}
