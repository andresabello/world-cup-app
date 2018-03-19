<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use App\Services\Users;
use App\Services\AuthClient;
use App\Services\Auth as AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Authenticate
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * @var AuthService
     */
    protected $authService;

    /**
     * @var AuthClient
     */
    protected $authClient;

    /**
     * @var Users
     */
    protected $users;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory $auth
     * @param AuthService $authService
     * @param AuthClient $authClient
     * @param Users $users
     */
    public function __construct(Auth $auth, AuthService $authService, AuthClient $authClient, Users $users)
    {
        $this->auth = $auth;
        $this->authClient = $authClient;
        $this->authService = $authService;
        $this->users = $users;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string[] ...$guards
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next, ...$guards)
    {
        //is this a a socialite provider?
        //if so then auth with provider
        // refresh if necessary
        // return user from provider


        if (!$request->user('api')) {
            $response = $this->authenticate($request);
            if ($response['status'] === 200) {
                $user = $this->users->getAuthUser();
                return response()->json(array_merge([
                    'status' => 200,
                    'message' => 'refreshed',
                    'user' => $user
                ], $response));
            }

            return response()->json($response['message'], $response['status']);
        }


        return $next($request);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    protected function authenticate(Request $request)
    {
        $client = $this->authClient->get('password', env('OAUTH_PASSWORD_CLIENT'));
        $response = $this->authService->checkRefreshToken($client, $request);

        if ($response['status'] !== 200) {
            $user = $this->users->getAuthUser();
            $message = $response['message'] ?? 'Unauthenticated';
            Log::error($message);
            return array_merge($response, ['message' => $message, 'status' => $response['status'], 'user' => $user]);
        }

        return $response;
    }
}
