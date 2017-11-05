<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class APIUsersControllerTest.
 *
 * @package Tests\Feature
 */
class APIUsersControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        App::setLocale('en');
        initialize_forge_management_permissions();
//        $this->withoutExceptionHandling();
    }

    /**
     * Logged user can list users.
     *
     * @test
     * @return void
     */
    public function logged_user_can_list_users()
    {
        // Prepare
        factory(User::class,2)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user,'api');

        //Execute
        $response = $this->json('GET','api/v1/users_with_logged_user/');
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'logged' => [
                'id',
                'name',
                'email'
            ],
            'users' => [[
                'id',
                'name',
                'email'
            ]]
        ]);

    }
}
