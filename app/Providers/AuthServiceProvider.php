<?php

namespace App\Providers;

use App\Services\Auth;
use App\Services\Users;
use App\User;
use GuzzleHttp\Client;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        Passport::enableImplicitGrant();
        Passport::tokensExpireIn(now()->addMinutes(10));
        Passport::refreshTokensExpireIn(now()->addDays(10));
    }

    /**
     *
     */
    public function register()
    {
        $this->app->bind(Auth::class, function ($app) {
            return new Auth(
                (new Client(['base_uri' => env('APP_URL')])),
                new Users(new User())
            );
        });
    }
}
