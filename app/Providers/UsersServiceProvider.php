<?php

namespace App\Providers;

use App\User;
use App\Services\Users;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class UsersServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     *
     */
    public function register()
    {
        $this->app->bind(Users::class, function () {
            return new Users((new User()));
        });
    }
}
