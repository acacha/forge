<?php

namespace Tests\Feature;

use Acacha\Forge\Models\Server;
use App\User;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ApiLoggedUserSitesControllerTest.
 *
 * @package Tests\Feature
 */
class ApiLoggedUserSitesControllerTest extends TestCase
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
     * Guests users cannot see his sites
     *
     * @test
     */
    public function guest_users_cannot_see_his_sites() {
        $response = $this->json('GET','/api/v1/user/sites/15789');
        $response->assertStatus(401);
    }

    /**
     * An user cannot see sites if no servers are assigned,
     *
     * @test
     */
    public function user_cannot_see_sites_if_no_servers_are_assigned() {
        $user = factory(User::class)->create();
        $this->actingAs($user,'api');

        $response = $this->json('GET','/api/v1/user/sites/15789');
        $response->assertStatus(403);
    }

    /**
     * An user cannot see sites on no valid servers
     *
     * @test
     */
    public function user_cannot_see_sites_on_no_valid_servers() {
        $user = factory(User::class)->create();

        $server = factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 15689,
        ]);

        $this->actingAs($user,'api');


        $response = $this->json('GET','/api/v1/user/sites/' . $server->forge_id);
        $response->assertStatus(403);
    }

    /**
     * An user cannot see sites on no valid servers_2
     *
     * @test
     */
    public function user_cannot_see_sites_on_no_valid_servers_2() {
        $user = factory(User::class)->create();

        $server = factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 15689,
            'state' => 'valid'
        ]);

        $this->actingAs($user,'api');


        $response = $this->json('GET','/api/v1/user/sites/1589');
        $response->assertStatus(403);
    }

    /**
     * Users cannnot see his sites with incorrect server id.
     *
     * @test
     */
    public function users_cannot_see_his_sites_with_incorrect_server_id() {
        $user = factory(User::class)->create();

        $server = factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 1589,
            'state' => 'valid'
        ]);

        $this->actingAs($user,'api');

        $response = $this->json('GET','/api/v1/user/sites/' . $server->forge_id);
        $response->assertStatus(500);

        $response->assertJsonFragment([
            'exception' => 'Themsaid\\Forge\\Exceptions\\NotFoundException'
        ]);
    }

    /**
     * Users can see his sites.
     *
     * @test
     */
    public function users_can_see_his_sites() {
        $user = factory(User::class)->create();

        $server = factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => random_forge_server()->id,
            'state' => 'valid'
        ]);

        $this->actingAs($user,'api');

        $response = $this->json('GET','/api/v1/user/sites/' . $server->forge_id);

        $response->assertSuccessful();

        $response->assertJsonStructure([[
            'id',
            'serverId',
            'name',
            'directory'
        ]]);
    }
}
