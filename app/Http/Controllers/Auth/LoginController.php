<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use App\Services\Auth as AuthService;
use App\Services\AuthClient;
use App\Services\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $authClient;
    protected $auth;

    /**
     * Create a new controller instance.
     *
     * @param AuthService $auth
     * @param AuthClient $authClient
     */
    public function __construct(AuthService $auth, AuthClient $authClient)
    {
        $this->auth = $auth;
        $this->authClient = $authClient;
    }

    public function check(Request $request)
    {
        $user = $request->user('api');

        return response()->json([
            'user' => $user
        ], 200);
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        return $this->requestPasswordGrant($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->check(
            $this->credentials($request), $request->filled('remember')
        );
    }


    public function requestPasswordGrant($request)
    {
        $response = $this->authenticated($request, $this->guard()->user());

        if ($response['status'] === 200) {
            $this->clearLoginAttempts($request);
            return response()->json(array_merge([
                'status' => true,
                'message' => 'logged in'
            ], $response));
        }

        $this->incrementLoginAttempts($request);
        return response()->json($response, $response['status']);
    }
    /**
     * Log the user out of the application.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return response()->json([
            'status' => true,
            'message' => 'logout success'
        ]);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     * @throws \Exception
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$user) {
            $user = User::where('email', $request->get('email'))->first();
        }
        $client = $this->authClient->get('password', env('OAUTH_PASSWORD_CLIENT'));
        return array_merge(['user' => $user], $this->auth->attemptLogin($client, $user, $request->get('password'), null));
    }

    protected function guard()
    {
        return auth()->guard('api');
    }
}
