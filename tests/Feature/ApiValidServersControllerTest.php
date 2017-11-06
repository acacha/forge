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
     * Unauthorized response with invalid token.
     *
     * @test
     */
    public function unauthorized_response_with_invalid_token()
    {
        $server = factory(Server::class)->create();
        $user = $server->user;

        $response = $this->json('POST','/users/' . $user->id . '/servers/' . $server->id . '/validate', [
            'token' => '4243asdaseq3123wdsa'
        ]);

        $response->assertStatus(403);
    }

    /**
     * Cannot validate already validated servers
     *
     * @test
     */
    public function cannot_validate_already_validated_servers()
    {
        $server = factory(Server::class)->create();
        $server->state = 'valid';
        $server->save();
        $user = $server->user;

        $response = $this->json('POST','/users/' . $user->id . '/servers/' . $server->id . '/validate', [
            'token' => $server->token
        ]);

        $response->assertStatus(400);
        $this->assertContains('Server is already validated', $response->decodeResponseJson()['message']);
    }

    /**
     * Cannot unvalidate already unvalidated servers
     *
     * @test
     */
    public function cannot_unvalidate_already_unvalidated_servers()
    {
        $server = factory(Server::class)->create();
        $user = $server->user;
        $manager = factory(User::class)->create();
        $manager->assignRole('manage-forge');
        $this->actingAs($manager,'api');

        $response = $this->json('DELETE','/api/v1/users/' . $user->id . '/servers/' . $server->id . '/validate', [
            'token' => $server->token
        ]);

        $response->assertStatus(400);
        $this->assertContains('Server is already unvalidated', $response->decodeResponseJson()['message']);
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

    /**
     * User manager can unvalidate a server using token.
     *
     * @test
     */
    public function user_manager_can_unvalidate_a_server_using_token()
    {
        $server = factory(Server::class)->create();
        $server->state = 'valid';
        $server->token = null;
        $server->save();
        $user = $server->user;
        $manager = factory(User::class)->create();
        $manager->assignRole('manage-forge');
        $this->actingAs($manager,'api');

        $response = $this->json('DELETE','api/v1/users/' . $user->id . '/servers/' . $server->id . '/validate');

        $response->assertSuccessful();

        $this->assertDatabaseHas('servers',[
            'id' => $server->id,
            'name' => $server->name,
            'forge_id' => $server->forge_id,
            'user_id' => $user->id,
            'state' => 'pending',
        ]);

        $this->assertDatabaseMissing('servers',[
            'id' => $server->id,
            'name' => $server->name,
            'forge_id' => $server->forge_id,
            'user_id' => $user->id,
            'state' => 'valid',
            'token' => null
        ]);

        $response->assertJsonMissing([ 'token' ]);

        $this->assertNotEmpty(Server::findOrFail($server->id)->token);
    }


}