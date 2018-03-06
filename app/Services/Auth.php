<?php

namespace App\Services;


use App\User;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Cookie;
use GuzzleHttp\Client as HTTP;

class Auth
{
    const REFRESH_TOKEN = 'refresh_token';
    public $http;

    /**
     * Auth constructor.
     * @param HTTP $client
     */
    public function __construct(HTTP $client)
    {
        $this->http = $client;
    }

    /**
     * @param Client $client
     * @param User $user
     * @param string $password
     * @param null $scopes
     * @return array|string
     */
    public function attemptLogin(Client $client, User $user, string $password, $scopes = null)
    {
        try {
            return $this->getTokenProxy($client, 'password', [
                'username' => $user->email,
                'password' => (string)$password,
                'scopes' => $scopes
            ]);
        } catch (\Exception $e) {
            Log::error(json_encode($e));
            return $e->getMessage();
        }
    }


    /**
     * Attempt to refresh the access token used a refresh token that
     * has been saved in a cookie
     * @param Client $client
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function attemptRefresh(Client $client, Request $request)
    {
        $refreshToken = $request->cookie(self::REFRESH_TOKEN);
        return $this->getTokenProxy($client, self::REFRESH_TOKEN, [
            'refresh_token' => $refreshToken
        ]);
    }

    /**
     * Logs out the user. We revoke access token and refresh token.
     * Also instruct the client to forget the refresh cookie.
     * @param User $user
     */
    public function logout(User $user)
    {
        $accessToken = $user->token();
        $this->updateAuthRefreshToken($accessToken);
        $accessToken->revoke();
        $this->forgetHttpCookie();
    }

    /**
     * @param Client $client
     * @param $type
     * @param array $data
     * @return array
     * @throws \Exception
     */
    protected function getTokenProxy(Client $client, $type, array $data = []): array
    {
        $data = $this->buildParams($client, $type, $data);
        //Request behind an internal api consumer
        $response = $this->http->post("oauth/token", [
            'allow_redirects' => false,
            'form_params' => $data,
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Invalid Credentials', 405);
        }

        $data = json_decode((string)$response->getBody(), true);

        return [
            'access_token' => $data['access_token'],
            'expires_in' => $data['expires_in'],
            'refresh_token' => $data['refresh_token']
        ];
    }

    /**
     * Create a refresh token inside an Http Only Cookie
     * @param array $data
     * @return Cookie
     */
    public function generateHttpOnlyCookie(array $data): Cookie
    {
        $refreshToken = $data[self::REFRESH_TOKEN];
        return cookie(
            self::REFRESH_TOKEN,
            $refreshToken,
            864000,
            null,
            null,
            false,
            true
        );
    }

    /**
     * @param Client $client
     * @param $type
     * @param array $data
     * @return array
     */
    protected function buildParams(Client $client, $type, array $data = []): array
    {
        return array_merge($data, [
            'grant_type' => $type,
            'client_id' => $client->id,
            'client_secret' => env('OAUTH_PASSWORD_SECRET'),
        ]);
    }

    protected function forgetHttpCookie(): void
    {
        Cookie::queue(Cookie::forget(self::REFRESH_TOKEN));
    }

    /**
     * @param $accessToken
     */
    protected function updateAuthRefreshToken($accessToken): void
    {
        try {
            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update([
                    'revoked' => true
                ]);

        } catch (\Exception $exception) {
            Log::error(json_encode($exception));
        }
    }
}