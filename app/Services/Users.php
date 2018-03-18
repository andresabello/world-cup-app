<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 3/12/18
 * Time: 11:59 PM
 */

namespace App\Services;


use App\User;
use Illuminate\Contracts\Auth\Authenticatable;

class Users
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
}