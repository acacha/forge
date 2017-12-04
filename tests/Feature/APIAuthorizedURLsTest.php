<?php

namespace Tests\Feature;

use Acacha\Events\Models\Event;
use Acacha\Forge\Models\Assignment;
use Acacha\Groups\Models\Group;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class APIAuthorizedURLsTest.
 *
 * @package Tests\Feature
 */
class APIAuthorizedURLsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
        $user = factory(User::class)->create();
        $assignment = factory(Assignment::class)->create();
        $group = factory(Group::class)->create();
        initialize_forge_management_permissions();
        $this->actingAs( $user,'api');
//        $this->withoutExceptionHandling();
    }

    /**
     * Authorizated URIs provider.
     *
     * @return array
     */
    public function authorizatedURIs()
    {
        return [
            ['get','/api/v1/assignment'],
            ['get','/api/v1/assignment/1'],
            ['post','/api/v1/assignment'],
            ['put','/api/v1/assignment/1'],
            ['delete','/api/v1/assignment/1'],
            ['post','/api/v1/assignment/1/user/1'],
            ['post','/api/v1/assignment/1/group/1'],

            ['get','/api/v1/user/assignment'],
            ['get','/api/v1/user/assignment/1']

        ];
    }

    /**
     * URI requires authorizated user.
     *
     * @test
     * @dataProvider authorizatedURIs
     */
    public function uri_requires_authorizated_user($method , $uri)
    {
        $response = $this->json($method, $uri);
        $response->assertStatus(403);
    }

}