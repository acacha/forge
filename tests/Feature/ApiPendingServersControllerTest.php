<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Acacha\Forge\Models\Server;

/**
 * Class ApiPendingServersControllerTest.
 *
 * @package Tests\Feature
 */
class ApiPendingServersControllerTest  extends TestCase
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
     * An user can ask for permission.
     *
     * @test
     */
    public function an_user_can_ask_for_permission()
    {
        $server = factory(Server::class)->create();
        $user = $server->user;
        $this->actingAs($user,'api');

        $response = $this->json('POST','api/v1/users/' . $user->id . '/servers/' . $server->id . '/ask_permission');
//        $response->dump();
        $response->assertSuccessful();
    }
}