<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 2/25/18
 * Time: 5:42 PM
 */

namespace Tests\Unit\Services;


use App\Services\Auth;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AuthTest extends TestCase
{

    protected $headers;
    protected $user;
    protected $scopes = ['*'];

    /**
     * @test
     */
    public function it_can_generate_an_auth_token()
    {
        $user = factory(User::class)->create();
        $client = Client::where('name', 'yes')->where('revoked', false)->first();

        $authService = $this->app->make(Auth::class);
        $loggedIn = $authService->attemptLogin($client, $user, 'secret');

        $this->assertNotFalse($loggedIn);
        $this->assertArrayHasKey('access_token', $loggedIn);
        $this->assertArrayHasKey('expires_in', $loggedIn);
    }

    /**
     * @test
     */
    public function it_stores_token_in_an_http_only_cookie()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create([
            'user_id' => null,
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
            'secret' => 'secret',
            'name' => 'yes'
        ]);

        $authService = $this->app->make(Auth::class);
        $response = $authService->attemptLogin($client, $user, 'secret');
        $this->assertNotFalse($response);
        $this->assertArrayHasKey('access_token', $response);
        $this->assertArrayHasKey('expires_in', $response);
    }

    /**
     * @test
     */
    public function it_can_do_normal_login(){
        $user = factory(User::class)->create();
        factory(Client::class)->create([
            'user_id' => null,
            'personal_access_client' =>false,
            'password_client' => true,
            'revoked' => false,
            'secret' => 'secret',
            'name' => 'yes'
        ]);
        $response = $this->json('POST', '/api/v1/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);

        $this->assertSame(200, $response->getStatusCode());
        $response->assertJsonStructure(['status', 'message', 'access_token', 'expires_in']);
        $response->assertCookieMissing('refresh_token');
    }

    /**
     * @test
     */
    public function it_can_refresh_an_access_token(){
        $user = factory(User::class)->create();
        factory(Client::class)->create([
            'user_id' => null,
            'personal_access_client' =>false,
            'password_client' => true,
            'revoked' => false,
            'secret' => 'secret',
            'name' => 'yes'
        ]);
        $response = $this->json('POST', '/api/v1/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);

        $this->assertSame(200, $response->getStatusCode());
        $response->assertJsonStructure(['status', 'message', 'access_token', 'expires_in']);
        $response->assertCookieMissing('refresh_token');
    }

}