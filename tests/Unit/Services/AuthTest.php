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
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Laravel\Passport\Client;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_generate_an_auth_token()
    {
        $user = factory(User::class)->create();
        $client = Client::where('password_client', 1)->first();
        $authService = (new Auth((new \GuzzleHttp\Client()), env('APP_URL')));
        $loggedIn  = false;

        try {
            $loggedIn = $authService->attemptLogin($client, $user->email, 'secret');
        }catch (\Exception $e) {
            report($e);
        }

        $this->assertNotFalse($loggedIn);
        $this->assertArrayHasKey('access_token', $loggedIn);
        $this->assertArrayHasKey('expires_in', $loggedIn);

    }

    /**
     * @test
     */
    public function it_can_do_normal_login(){
        $user = factory(User::class)->create();
        $response = $this->call('POST', '/api/v1/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertSame(true, $response->original['status']);
        $this->assertSame('logged in', $response->original['message']);
    }

}