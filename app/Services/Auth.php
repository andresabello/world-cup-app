<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 2/25/18
 * Time: 5:33 PM
 */

namespace App\Services;


use App\User;
use GuzzleHttp\Client as HTTP;
use Illuminate\Support\Facades\Cookie;
use Laravel\Passport\Client;

class Auth
{
    public $http;
    public $baseUrl;

    /**
     * Auth constructor.
     * @param HTTP $client
     * @param string $url
     */
    public function __construct(HTTP $client, string $url)
    {
        $this->http = $client;
        $this->baseUrl = $url;
    }

    /**
     * @param Client $client
     * @param string $email
     * @param string $password
     * @param null $scopes
     * @return array|string
     * @throws \Exception
     */
    public function attemptLogin(Client $client, string $email, string $password, $scopes = null)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            try {
                return $this->getToken($client, $email, $password, $scopes);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        throw new \Exception('User not found', 404);
    }

    /**
     * @param Client $client
     * @param $email
     * @param $password
     * @param $scopes
     * @return array
     * @throws \Exception
     */
    protected function getToken(Client $client, $email, $password, $scopes = null)
    {

        $response = $this->http->post("{$this->baseUrl}/oauth/token", [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $email,
                'password' => $password,
                //TODO need to know what the scope of the app are
                'scope' => $scopes,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Invalid Credentials', 405);
        }

        $data = json_decode((string)$response->getBody(), true);
        // Create a refresh token cookie

        Cookie::queue(
            'refresh_token',
            $data['refresh_token'],
            864000, //10 days
            null,
            null,
            false,
            true
        );

        return [
            'access_token' => $data['access_token'],
            'expires_in' => $data['expires_in']
        ];
    }


}