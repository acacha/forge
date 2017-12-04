<?php

namespace Tests\Feature;

use Acacha\Forge\Events\ServerHasBeenAssignedToUser;
use Acacha\Forge\Events\ServerHasBeenUnAssignedToUser;
use Acacha\Forge\Models\Server;
use App\User;
use Event;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ApiUserServersControllerTest.
 *
 * @package Tests\Feature
 */
class ApiUserServersControllerTest extends TestCase
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
     * An user can propose to assign himself a server.
     *
     * @test
     * @return void
     */
    public function an_user_cannot_propose_to_assign_another_user_a_server()
    {
        // Prepare
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        $this->actingAs($user, 'api');

        //Execute
        $response = $this->json('POST', 'api/v1/users/' . $otherUser->id . '/servers', [
            'server_id' => 1
        ]);
        $response->assertStatus(403);
    }

    /**
     * An user can propose to assign himself a server.
     *
     * @test
     * @return void
     */
    public function an_user_can_propose_to_assign_himself_a_server()
    {
        // Prepare
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $forge_id = random_forge_server()->id;

        Event::fake();

        //Execute
        $response = $this->json('POST', 'api/v1/users/' . $user->id . '/servers', [
            'server_id' => $forge_id
        ]);

        $response->assertSuccessful();

        $response->assertJson([
            'forge_id' => $forge_id,
            'user_id' => $user->id,
            'state' => 'pending'
        ]);

        $response->assertJsonMissing([ 'token' ]);
        $server = $response->decodeResponseJson();

        $this->assertDatabaseHas('servers', [
            'forge_id' => $forge_id,
            'user_id' => $user->id,
            'state' => 'pending',
        ]);

        $this->assertNotEmpty(Server::findOrFail($server['id'])->token);

        Event::assertDispatched(ServerHasBeenAssignedToUser::class, function ($event) use ($server, $forge_id) {
            return $event->server->id === $server['id'] &&
                   $event->server->forge_id === $forge_id &&
                   $event->server->user_id === $server['user_id'] &&
                   $event->server->state === $server['state'];
        });
    }

    /**
     * Can not unassign a non assigned server
     *
     * @test
     * @return void
     */
    public function cannot_unassign_a_non_assigned_server()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $forge_id = random_forge_server()->id;

        //Execute
        $response = $this->json('DELETE', 'api/v1/users/' . $user->id . '/servers/' . $forge_id);

        $response->assertStatus(404);
        $this->assertContains('No server found assigned to the specified user', json_decode($response->getContent())->message);
    }

    /**
     * An user can propose to unassign himself a server.
     *
     * @test
     * @return void
     */
    public function an_user_can_propose_to_unassign_himself_a_server()
    {
        $server = factory(Server::class)->create();
        $user = $server->user;
        $this->actingAs($user, 'api');

        Event::fake();

        //Execute
        $uri = '/api/v1/users/' . $user->id . '/servers/' . $server->forge_id;

        $response = $this->json('DELETE', $uri);

        $response->assertSuccessful();

        $response->assertJson([
            'forge_id' => $server->forge_id,
            'user_id' => $user->id,
            'state' => 'pending'
        ]);

        $response->assertJsonMissing([ 'token' ]);
        $serverResponse = $response->decodeResponseJson();
        $this->assertDatabaseMissing('servers', [
            'forge_id' => $server['forge_id'],
            'user_id' => $server['user_id'],
        ]);

        $this->assertDatabaseMissing('servers', [
            'id' => $server['id']
        ]);

        $forge_id = $server['forge_id'];

        Event::assertDispatched(ServerHasBeenUnAssignedToUser::class, function ($event) use ($server, $forge_id) {
            return $event->server->id === $server['id'] &&
                $event->server->forge_id == $forge_id &&
                $event->server->user_id == $server['user_id'] &&
                $event->server->state === $server['state'];
        });
    }

    /**
     * A manager user can propose to assign any user a server.
     *
     * @test
     * @return void
     */
    public function a_manager_user_can_propose_to_assign_any_user_a_server()
    {
        // Prepare
        $user = factory(User::class)->create();
        $user->assignRole('manage-forge');
        $otherUser = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $forge_id = random_forge_server()->id;
        //Execute
        $response = $this->json('POST', 'api/v1/users/' . $otherUser->id . '/servers', [
            'server_id' => $forge_id
        ]);

        $response->assertSuccessful();
        $response->assertJson([
            'forge_id' => $forge_id,
            'user_id' => $otherUser->id,
            'state' => 'pending'
        ]);

        $this->assertDatabaseHas('servers', [
            'forge_id' => $forge_id,
            'user_id' => $otherUser->id,
            'state' => 'pending'
        ]);
    }

    /**
     * An error is thrown if an already assigned_server.
     *
     * @test
     * @return void
     */
    public function an_error_is_thrown_if_an_already_assigned_server()
    {
        // Prepare
        $server = factory(Server::class)->create();
        $user = $server->user;
        $user->assignRole('manage-forge');
        $this->actingAs($user, 'api');

//        dd($server->forge_id);

        //Execute
        $response = $this->json('POST', 'api/v1/users/' . $user->id . '/servers', [
            'server_id' => $server->forge_id
        ]);
        $response->assertStatus(400);
        $this->assertContains('The server has been already assigned to user!', json_decode($response->getContent())->message);
    }

    /**
     * An user can see his own servers.
     *
     * @test
     * @return void
     */
    public function an_user_can_see_his_own_servers()
    {
        $user = factory(User::class)->create();

        factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 1
        ]);

        factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 2
        ]);

        factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 3
        ]);


        $this->actingAs($user, 'api');

        $response = $this->json('GET', 'api/v1/users/' . $user->id . '/servers');
        $this->assertEquals(count(json_decode($response->getContent())), 3);
        $response->assertSuccessful();
        $response->assertJsonStructure([[
            'id',
            'name',
            'forge_id',
            'user_id',
            'state',
            'created_at',
            'updated_at',
        ]]);
    }
}
