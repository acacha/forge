<?php

namespace Tests\Feature;

use Acacha\Forge\Models\Server;
use App\User;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ApiLoggedUserServersControllerTest.
 *
 * @package Tests\Feature
 */
class ApiLoggedUserServersControllerTest extends TestCase
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
     * Guests users cannot see his servers
     * @test
     */
    public function guest_users_cannot_see_his_servers() {
        $response = $this->json('GET','/api/v1/user/servers');
        $response->assertStatus(401);
    }

    /**
     * Users can see his servers
     * @test
     */
    public function users_can_see_his_valid_servers() {
        $user = factory(User::class)->create();

        factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 1,
            'state' => 'valid'
        ]);

        factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 2,
            'state' => 'valid'
        ]);

        factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 3
        ]);


        $this->actingAs($user,'api');

        $response = $this->json('GET','/api/v1/user/servers');
        $this->assertEquals(count(json_decode($response->getContent())) , 2);
        $response->assertSuccessful();
        $response->assertJsonStructure([[
            'id',
            'name',
            'forge_id',
            'ipAddress',
            'user_id',
            'state',
            'created_at',
            'updated_at',
        ]]);
    }
}
