<?php

namespace Tests\Feature;

use Acacha\Forge\Events\ServerHasBeenAssignedToUser;
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
        $this->actingAs($user,'api');

        //Execute
        $response = $this->json('POST','api/v1/users/' . $otherUser->id . '/servers', [
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
        $this->actingAs($user,'api');

        Event::fake();


        //Execute
        $response = $this->json('POST','api/v1/users/' . $user->id . '/servers', [
            'server_id' => 1
        ]);

        $response->assertSuccessful();

        $response->assertJson([
            'forge_id' => 1,
            'user_id' => $user->id,
            'state' => 'pending'
        ]);

        $server = $response->decodeResponseJson();

        $this->assertDatabaseHas('servers', [
            'forge_id' => 1,
            'user_id' => $user->id,
            'state' => 'pending'
        ]);

        Event::assertDispatched(ServerHasBeenAssignedToUser::class, function ($event) use ($server) {
            return $event->server->id === $server['id'] &&
                   $event->server->user_id === $server['forge_id'] &&
                   $event->server->user_id === $server['user_id'] &&
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
        $this->actingAs($user,'api');

        //Execute
        $response = $this->json('POST','api/v1/users/' . $otherUser->id . '/servers', [
            'server_id' => 1
        ]);

        $response->assertSuccessful();
        $response->assertJson([
            'forge_id' => 1,
            'user_id' => $otherUser->id,
            'state' => 'pending'
        ]);

        $this->assertDatabaseHas('servers', [
            'forge_id' => 1,
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
        $this->actingAs($user,'api');

        //Execute
        $response = $this->json('POST','api/v1/users/' . $user->id . '/servers', [
            'server_id' => $server->forge_id
        ]);

        $response->assertSuccessful();


    }
}
