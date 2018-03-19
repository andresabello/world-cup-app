<?php

namespace App\Services;


use App\OAuthProvider;
use App\User;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Cookie;
use GuzzleHttp\Client as HTTP;

class Auth
{
    const REFRESH_TOKEN = 'refresh_token';

    /**
     * @var Users
     */
    protected $users;

    protected $http;

    /**
     * Auth constructor.
     * @param HTTP $client
     * @param Users $users
     */
    public function __construct(HTTP $client, Users $users)
    {
        $this->http = $client;
        $this->users = $users;
    }

    /**
     * @param Client $client
     * @param User $user
     * @param string $password
     * @param null $scopes
     * @return array
     * @throws \Exception
     */
    public function attemptLogin(Client $client, User $user, string $password, $scopes = null): array
    {
        try {
            return $this->getTokenProxy($client, 'password', [
                'username' => $user->email,
                'password' => (string)$password,
                'scopes' => $scopes
            ]);
        } catch (\Exception $exception) {
            return [
                'status' => $exception->getCode(),
                'message' => (string)$exception->getMessage()
            ];
        }
    }


    /**
     * Attempt to refresh the access token used a refresh token that
     * has been saved in a cookie
     * @param Client $client
     * @param Request $request
     * @return array
     */
    public function attemptRefresh(Client $client, Request $request): array
    {
        try {
            return array_merge([
                'status' => 200
            ], $this->getTokenProxy($client, 'refresh_token', [
                'refresh_token' => $request->get('refresh_token')
            ]));
        } catch (\Exception $exception) {
            return [
                'status' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
        }
    }

    /**
     * Logs out the user. We revoke access token and refresh token.
     * Also instruct the client to forget the refresh cookie.
     * @param User $user
     */
    public function logout(User $user): void
    {
        $accessToken = $user->token();
        $this->updateAuthRefreshToken($accessToken);
        $accessToken->revoke();
        $this->forgetHttpCookie();
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
            1440, //1 day 60 * 24 * 1
            null,
            null,
            false,
            true
        );
    }

    /**
     * @param Client $client
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function checkRefreshToken(Client $client, Request $request): array
    {
        if ($request->has(self::REFRESH_TOKEN)) {
            return $this->attemptRefresh($client, $request);
        }

        if ($request->has('user_token')) {
            $provider = OAuthProvider::find($request->get('user_token'));
            if ($provider) {
                $user = $provider->user;
                return $this->attemptLogin($client, $user, 'dolphins');
            }
        }

        return [
            'status' => 401,
            'message' => 'Please logout and log back in'
        ];
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
            'client_secret' => env('OAUTH_PASSWORD_SECRET', 'secret'),
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

        $response = $this->http->post("oauth/token", [
            'allow_redirects' => false,
            'form_params' => $data,
        ]);

        Log::info((string)$response->getBody());
        if ($response->getStatusCode() !== 200) {
            throw new \Exception((string)$response->getBody(), $response->getStatusCode());
        }

        $responseData = json_decode((string)$response->getBody(), true);
        $response = [
            'status' => $response->getStatusCode(),
            'message' => 'success',
            'access_token' => $responseData['access_token'],
            'expires_in' => $responseData['expires_in'],
            'refresh_expires_in' => 14400,
        ];

        if (isset($responseData['refresh_token'])) {
            $response['refresh_token'] = $responseData['refresh_token'];
        }

        return $response;
    }
}