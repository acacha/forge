<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ApiServerControllerTest.
 *
 * @package Tests\Feature
 */
class ApiServersControllerTest extends TestCase
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
     * Logged user can list forge servers.
     *
     * @test
     * @return void
     */
    public function logged_user_can_list_forge_servers()
    {
        // Prepare
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        //Execute
        $response = $this->json('GET', 'api/v1/servers/');

        $response->assertSuccessful();
        $response->assertJsonStructure([[
            'id',
            'name',
            'ipAddress'
        ]]);
    }
}
