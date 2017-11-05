<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Acacha\Forge\Models\Server;

/**
 * Class ApiValidServersControllerTest.
 *
 * @package Tests\Feature
 */
class ApiValidServersControllerTest  extends TestCase
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
     * Anyone can validate a server using token.
     *
     * @test
     */
    public function anyone_can_validate_a_server_using_token()
    {
        $server = factory(Server::class)->create();
        $user = $server->user;

        $response = $this->json('POST','/users/' . $user->id . '/servers/' . $server->id . '/validate', [
            'token' => $server->token
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('servers',[
            'id' => $server->id,
            'name' => $server->name,
            'forge_id' => $server->forge_id,
            'user_id' => $user->id,
            'state' => 'valid',
            'token' => null
        ]);
    }

    /**
     * User manager can validate a server using token.
     *
     * @test
     */
    public function user_manager_can_validate_a_server_using_token()
    {
        $server = factory(Server::class)->create();
        $user = $server->user;
        $manager = factory(User::class)->create();
        $manager->assignRole('manage-forge');
        $this->actingAs($manager,'api');

        $response = $this->json('POST','api/v1/users/' . $user->id . '/servers/' . $server->id . '/validate');

        $response->assertSuccessful();

        $this->assertDatabaseHas('servers',[
            'id' => $server->id,
            'name' => $server->name,
            'forge_id' => $server->forge_id,
            'user_id' => $user->id,
            'state' => 'valid',
            'token' => null
        ]);

    }
}