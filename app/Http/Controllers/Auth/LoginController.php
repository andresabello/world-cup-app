<?php

namespace App\Http\Controllers\Auth;

use App\Services\Auth;
use App\Services\AuthClient;
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
     * @param Auth $auth
     * @param AuthClient $authClient
     */
    public function __construct(Auth $auth, AuthClient $authClient)
    {
        $this->auth = $auth;
        $this->authClient = $authClient;
        $this->middleware('api')->except('logout');
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
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        if ($authenticated = $this->authenticated($request, $this->guard()->user())) {
            $cookie = $this->auth->generateHttpOnlyCookie($authenticated);
            unset($authenticated['refresh_token']);
            return response()->json(array_merge([
                'status' => true,
                'message' => 'logged in'
            ], $authenticated))->cookie($cookie);
        }

        return response()->json([
            'status' => false,
            'message' => 'unable to login, please try again'
        ], 405);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $client = $this->authClient->get('password', env('OAUTH_PASSWORD_CLIENT'));
        //TODO decide the scopes
        $response = $this->auth->attemptLogin($client, $user, $request->get('password'), null);
        return $this->auth->generateHttpOnlyCookie($response);
    }
}
