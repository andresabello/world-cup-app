<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 3/12/18
 * Time: 11:59 PM
 */

namespace App\Services;


use App\User;
use App\Services\Interfaces\PiModel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class Users implements PiModel
{
    /**
     * @var User
     */
    protected $user;

    /**
     * Users constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function find(string $field, string $value)
    {
        $this->user->where($field, $value)->first();
    }

    public function getAuthUser(string $token = null, string $email = null)
    {
        $user = null;

        if (request()->user('api')) {
            $user = request()->user('api');
        }

        if ((request()->has('email') || $email)&& !$user) {
            $email = request()->has('email') ? request()->get('email') : $email;
            $user =  User::where('email', $email)->first();
        }

        if (auth()->guard('api') && !$user) {
            $user =  auth()->guard('api')->user();
        }

        if ($token && !$user) {
            $user = $this->findByToken($token);
        }

        //find based on generated uuid on login with another provider

        return $user;
    }

    public function getDummyPassword($email, $name)
    {
        return bcrypt('dolphins');
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function findByToken(string $token)
    {
        return  User::whereHas('tokens', function ($tokens) use($token) {
            $tokens->where('id', decrypt($token));
        })->first();
    }

}