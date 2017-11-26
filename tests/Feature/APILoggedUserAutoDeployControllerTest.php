<?php

namespace Tests\Feature;

use Acacha\Forge\Models\Server;
use App\User;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class APILoggedUserAutoDeployControllerTest.
 *
 * @package Tests\Feature
 */
class APILoggedUserAutoDeployControllerTest extends TestCase
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
     * Guests users cannot enable quick deployment.
     *
     * @test
     */
    public function guest_users_cannot_enable_auto_deploy() {
        $response = $this->json('POST','/api/v1/user/servers/1568/sites/5986/deploy');
        $response->assertStatus(401);
    }

    /**
     * Not authorized to enable autodeploy on non owned servers.
     *
     * @test
     */
    public function not_authorized_to_enable_autodeploy_on_non_owned_servers() {
        $user = factory(User::class)->create();

        factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 1568,
            'state' => 'valid'
        ]);
        $this->actingAs($user,'api');
        $response = $this->json('POST','/api/v1/user/servers/9999/sites/5986/deploy');
        $response->assertStatus(403);
    }

    /**
     * Resource not found on unexisting site.
     *
     * @test
     */
    public function resource_not_found_on_unexisting_site() {
        $user = factory(User::class)->create();

        factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 1568,
            'state' => 'valid'
        ]);
        $this->actingAs($user,'api');
        $response = $this->json('POST','/api/v1/user/servers/1568/sites/99999/deploy');
        $response->assertStatus(404);
    }

    /**
     * Can enable autodeploy on owned servers.
     *
     * @test
     */
//    public function can_enable_autodeploy_on_owned_servers() {
//        $user = factory(User::class)->create();
//
//        factory(Server::class)->create([
//            'user_id' => $user->id,
//            'forge_id' => 154577,
//            'state' => 'valid'
//        ]);
//        $this->actingAs($user,'api');
//        $response = $this->json('POST','/api/v1/user/servers/154577/sites/435202/deploy');
//        $response->assertSuccessful();
//    }

}
