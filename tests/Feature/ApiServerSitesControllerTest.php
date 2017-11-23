<?php

namespace Tests\Feature;

use Acacha\Forge\Models\Server;
use App\User;
use Faker\Factory;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ApiServerSitesControllerTest.
 *
 * @package Tests\Feature
 */
class ApiServerSitesControllerTest extends TestCase
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
     * Check sites validation
     *
     * @test
     * @return void
     */
    public function check_sites_validation()
    {
        // Prepare
        $server = factory(Server::class)->create();
        $server->user->assignRole('manage-forge');

        $this->actingAs($server->user, 'api');

        //Execute
        $response = $this->json('POST', 'api/v1/servers/' . $server->id . '/sites');
        $response->assertStatus(422);
    }

    /**
     * Logged user cannot create site on non owned server.
     *
     * @test
     * @return void
     */
    public function logged_user_cannot_create_site_on_non_owned_server()
    {
        // Prepare
        $server = factory(Server::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user,'api');

        //Execute
        $response = $this->json('POST','api/v1/servers/' . $server->id . '/sites',[
            'domain' => 'site.com',
            'project_type' => 'php',
            'directory' => '/test'
        ]);

        $response->assertStatus(403);
    }

    /**
     * Logged user can create site on owned server.
     * TODO MOCK TO NOT CREATE NEW SITES ON LARAVEL FORGE!!!!
     *
     * @return void
     */
    public function logged_user_can_create_site_on_owned_server()
    {
        // Prepare
        $server = factory(Server::class)->create();

//        $faker = Factory::create();
//        $domain = $faker->domainName;
//        $directory = "/$domain";
        $domain = ' prova.com';
        $directory = "/prova.com";

        $this->actingAs($server->user,'api');

        //Execute
        $response = $this->json('POST','api/v1/servers/' . $server->id . '/sites',[
            'domain' => $domain,
            'project_type' => 'php',
            'directory' => $directory
        ]);

//        $response->dump();

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'site' => [
                'id',
                'name',
                'directory',
                'wildcards',
                'status',
                'repository',
                'repository_provider',
                'repository_branch',
                'repository_status',
                'quick_deploy',
                'project_type',
                'app',
                'app_status',
                'hipchat_room',
                'slack_channel',
                'created_at'
            ]
        ]);

    }

    /**
     * Manager user can create site on any server.
     * TODO MOCK!!!!!!!!
     *
     * @return void
     */
    public function manager_user_can_create_site_on_any_server()
    {
        // Prepare
        $server = factory(Server::class)->create();
        $manager = factory(User::class)->create();
        $manager->assignRole('manage-forge');
        $this->actingAs($manager,'api');

        //Execute
        $response = $this->json('POST','api/v1/servers/' . $server->id . '/sites',[
            'domain' => 'site.com',
            'project_type' => 'php',
            'directory' => '/test'
        ]);

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'site' => [
                'id',
                'name',
                'directory',
                'wildcards',
                'status',
                'repository',
                'repository_provider',
                'repository_branch',
                'repository_status',
                'quick_deploy',
                'project_type',
                'app',
                'app_status',
                'hipchat_room',
                'slack_channel',
                'created_at'
            ]
        ]);

    }
}
