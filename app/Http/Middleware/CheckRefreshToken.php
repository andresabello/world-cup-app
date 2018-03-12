<?php

namespace App\Http\Middleware;

use App\Services\AuthClient;
use Closure;
use App\Services\Auth as AuthService;
use Illuminate\Support\Facades\Auth;

class CheckRefreshToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param AuthService $authService
     * @param AuthClient $authClient
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next, AuthService $authService, AuthClient $authClient)
    {

        if (!$user = Auth::guard('api')->user()) {
            $client = $authClient->get('password', env('OAUTH_PASSWORD_CLIENT'));
            $response = $authService->checkCookieToken($client, $request);

            if (!$response['status']) {
                return response()->json('Unauthorized', 401);
            }

            $request->attributes->add($response);
        }

        return $next($request);
    }
}
