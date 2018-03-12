<?php

namespace App\Http\Middleware;

use Closure;
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
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory $auth
     * @param AuthService $authService
     * @param AuthClient $authClient
     */
    public function __construct(Auth $auth, AuthService $authService, AuthClient $authClient)
    {
        $this->auth = $auth;
        $this->authClient = $authClient;
        $this->authService = $authService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string[] ...$guards
     * @return mixed
     *
     */
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $response = $this->authenticate($guards, $request);
            if ($response['status'] === 200) {
                $cookie = $this->authService->generateHttpOnlyCookie($response);
                unset($response['cookie']);
                unset($response['refresh_token']);
                unset($response['message']);
                return response()->json(array_merge([
                    'status' => 200,
                    'message' => 'refreshed'
                ], $response))->cookie($cookie);
            }
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ], 401);
        }

        return $next($request);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  array $guards
     * @param Request $request
     * @return mixed
     *
     * @throws AuthenticationException
     * @throws \Exception
     */
    protected function authenticate(array $guards, Request $request)
    {
        if (empty($guards)) {
            return $this->auth->authenticate();
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        if (!$this->auth->guard('api')->user()) {
            $client = $this->authClient->get('password', env('OAUTH_PASSWORD_CLIENT'));
            $response = $this->authService->checkCookieToken($client, $request);
            if ($response['status'] !== 200) {
                $message = $response['message'] ?? 'Unauthenticated';
                Log::error($message);
                throw new AuthenticationException($message, $guards);
            }
            return $response;
        }

        throw new AuthenticationException('Unauthenticated.', $guards);
    }
}
