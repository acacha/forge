<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ApiCheckTokenControllerTest.
 *
 * @package Tests\Feature
 */
class ApiCheckTokenControllerTest extends TestCase
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
     * Logged user can check token
     *
     * @test
     * @return void
     */
    public function logged_user_can_check_token()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $response = $this->json('GET', '/api/v1/check_token');
        $response->assertJson([
          'message' => 'Token is valid'
       ]);
        $response->assertSuccessful();
    }
}
