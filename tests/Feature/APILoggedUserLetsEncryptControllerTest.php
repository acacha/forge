<?php

namespace Tests\Feature;

use Acacha\Forge\Models\Server;
use App\User;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ApiLoggedUserLetsEncryptControllerTest.
 *
 * @package Tests\Feature
 */
class APILoggedUserLetsEncryptControllerTest extends TestCase
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
     * Guests users cannot enable letsencrypt SSl certificates.
     *
     * @test
     */
    public function guest_users_cannot_obtain_lets_encrypt_certificate()
    {
        $response = $this->json('POST', '/api/v1/user/servers/1568/sites/5986/certificates/letsencrypt');
        $response->assertStatus(401);
    }

    /**
     * Not authorized to obtain lets encrypt certificate on non owned servers.
     *
     * @test
     */
    public function not_authorized_to_obtain_lets_encrypt_certificate_on_non_owned_servers()
    {
        $user = factory(User::class)->create();

        factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 1568,
            'state' => 'valid'
        ]);
        $this->actingAs($user, 'api');
        $response = $this->json('POST', '/api/v1/user/servers/9999/sites/5986/certificates/letsencrypt');
        $response->assertStatus(403);
    }

    /**
     * Resource not found on unexisting site.
     *
     * @test
     */
    public function resource_not_found_on_unexisting_site()
    {
        $user = factory(User::class)->create();

        factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 1568,
            'state' => 'valid'
        ]);
        $this->actingAs($user, 'api');
        $response = $this->json('POST', '/api/v1/user/servers/1568/sites/99999/certificates/letsencrypt', [
            'domains' => 'prova.com'
        ]);
        $response->assertStatus(404);
    }

    /**
     * Check validation
     *
     * @test
     */
    public function check_validation()
    {
        $user = factory(User::class)->create();

        factory(Server::class)->create([
            'user_id' => $user->id,
            'forge_id' => 154577,
            'state' => 'valid'
        ]);
        $this->actingAs($user, 'api');
        $response = $this->json('POST', '/api/v1/user/servers/154577/sites/435202/certificates/letsencrypt');
        $response->assertStatus(422);
        $response->assertJson([
            'message' => "The given data was invalid.",
            'errors' => [
                'domains' => [
                    0 => "The domains field is required."
                ]
            ]
        ]);
    }

//    /**
//     * Can obtain lets encrypt certificate on owned servers.
//     *
//     * @test
//     */
//    public function can_obtain_lets_encrypt_certificate_on_owned_servers() {
//        $user = factory(User::class)->create();
//
//        factory(Server::class)->create([
//            'user_id' => $user->id,
//            'forge_id' => 154577,
//            'state' => 'valid'
//        ]);
//        $this->actingAs($user,'api');
//        $response = $this->json('POST','/api/v1/user/servers/154577/sites/435202/certificates/letsencrypt', [
//            'domains' => 'forgepublish.2dam.iesebre.com'
//        ]);
//        $response->assertSuccessful();
//    }
}
