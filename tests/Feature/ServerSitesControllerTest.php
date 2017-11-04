<?php

namespace Tests\Feature;

use Acacha\Forge\Models\Server;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ServerSitesControllerTest.
 *
 * @package Tests\Feature
 */
class ServerSitesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        App::setLocale('en');
//        initialize_relationships_management_permissions();
        $this->withoutExceptionHandling();
    }

    /**
     * Logged user can create site on owned server.
     *
     * @test
     * @return void
     */
    public function logged_user_can_create_site_on_owned_server()
    {

        // Prepare
        $server = factory(Server::class)->create();

        $this->actingAs($server->user,'api');

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
