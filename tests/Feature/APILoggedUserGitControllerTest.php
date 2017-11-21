<?php

namespace Tests\Feature;

use Acacha\Forge\Models\Server;
use App\User;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class APILoggedUserGitController.
 *
 * @package Tests\Feature
 */
class APILoggedUserGitController extends TestCase
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
     * Guests users cannot post git repos.
     *
     * @test
     */
    public function guest_users_cannot_post_git_repos() {
        $response = $this->json('POST','/api/v1/user/servers/1568/sites/5986/git');
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
        $response = $this->json('POST','/api/v1/user/servers/9999/sites/5986/git');
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
        $response = $this->json('POST','/api/v1/user/servers/1568/sites/5986/git');
//        $response->dump();
        $response->assertStatus(422);
        $response->assertJson([
            'message' => "The given data was invalid.",
            'errors' => [
              'repository' => [
                    0 => "The repository field is required."
              ]
            ]
        ]);
    }

    /**
     * Can install git repositories on owned servers.
     *
     * @test
     */
    public function can_install_git_repositories_on_owned_servers() {
        $user = factory(User::class)->create();

        factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 1568,
            'state' => 'valid'
        ]);
        $this->actingAs($user,'api');
        $response = $this->json('POST','/api/v1/user/servers/1568/sites/5986/git', [
            'repository' => 'acacha/prova'
        ]);
        $response->dump();
        $response->assertSuccessful();

    }

//    /**
//     * Users can see his servers
//     * @test
//     */
//    public function users_can_see_his_valid_servers() {
//        $user = factory(User::class)->create();
//
//        factory(Server::class)->create([
//            'user_id' => $user->id,
//            'forge_id' => 1,
//            'state' => 'valid'
//        ]);
//
//        factory(Server::class)->create([
//            'user_id' => $user->id,
//            'forge_id' => 2,
//            'state' => 'valid'
//        ]);
//
//        factory(Server::class)->create([
//            'user_id' => $user->id,
//            'forge_id' => 3
//        ]);
//
//
//        $this->actingAs($user,'api');
//
//        $response = $this->json('GET','/api/v1/user/servers');
//        $this->assertEquals(count(json_decode($response->getContent())) , 2);
//        $response->assertSuccessful();
//        $response->assertJsonStructure([[
//            'id',
//            'name',
//            'forge_id',
//            'ipAddress',
//            'user_id',
//            'state',
//            'created_at',
//            'updated_at',
//        ]]);
//    }
}
