<?php

namespace Tests\Feature;

use Acacha\Forge\Models\Server;
use App\User;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class APILoggedUserKeysControllerTest.
 *
 * @package Tests\Feature
 */
class APILoggedUserKeysControllerTest extends TestCase
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
     * Guests users cannot post git repos.
     *
     * @test
     */
    public function guest_users_cannot_post_git_repos() {
        $response = $this->json('POST','/api/v1/user/servers/1568/keys');
        $response->assertStatus(401);
    }

    /**
     * Not authorized to create git repositories on non owned servers.
     *
     * @test
     */
    public function not_authorized_to_create_git_repositories_on_non_owned_servers() {
        $user = factory(User::class)->create();

        factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 1568,
            'state' => 'valid'
        ]);
        $this->actingAs($user,'api');
        $response = $this->json('POST','/api/v1/user/servers/9999/keys');
        $response->assertStatus(403);
    }

    /**
     * Check validation
     *
     * @test
     */
    public function check_validation() {
        $user = factory(User::class)->create();

        factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 1568,
            'state' => 'valid'
        ]);
        $this->actingAs($user,'api');
        $response = $this->json('POST','/api/v1/user/servers/1568/keys');
        $response->assertStatus(422);
        $response->assertJson([
            'message' => "The given data was invalid.",
            'errors' => [
              'name' => [
                    0 => "The name field is required."
              ],
              'key' => [
                    0 => "The key field is required."
              ]
            ]
        ]);
    }

    /**
     * Can install ssh keys on owned servers.
     *
     * @test
     */
//    public function can_install_ssh_keys_on_owned_servers() {
//        $user = factory(User::class)->create();
//
//        factory(Server::class)->create([
//            'user_id' => $user->id,
//            'forge_id' => 154577,
//            'state' => 'valid'
//        ]);
//        $this->actingAs($user,'api');
//        $response = $this->json('POST','/api/v1/user/servers/154577/keys', [
//            'name' => 'example_key',
//            'key' => 'key_content'
//        ]);
//        $response->assertSuccessful();
//    }


}
