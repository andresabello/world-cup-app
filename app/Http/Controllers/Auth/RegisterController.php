<?php

namespace App\Http\Controllers\Auth;

use App\Services\Auth;
use App\Services\AuthClient;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';


    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var AuthClient
     */
    protected $authClient;

    /**
     * Create a new controller instance.
     *
     * @param Auth $auth
     * @param AuthClient $authClient
     */
    public function __construct(Auth $auth, AuthClient $authClient)
    {
        $this->middleware('guest');
        $this->auth = $auth;
        $this->authClient = $authClient;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        $this->guard()->login($user);
        $client = $this->authClient->get('password', env('OAUTH_PASSWORD_CLIENT'));
        //TODO decide the scopes
        $response = $this->auth->attemptLogin($client, $user, $request->get('password'), null);
        if (is_array($response)) {
            $cookie = $this->auth->generateHttpOnlyCookie($response);
            unset($response['refresh_token']);
            return $this->registered($request, $user) ?: response()->json(array_merge([
                'status' => true,
                'message' => 'registered'
            ], $response))->cookie($cookie);
        }

        return response()->json($response, 422);
    }
}
