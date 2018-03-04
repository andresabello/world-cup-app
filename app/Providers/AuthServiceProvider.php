<?php

namespace App\Providers;

use App\Services\Auth;
use GuzzleHttp\Client;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Optimus\ApiConsumer\Facade\ApiConsumer;

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
        Passport::tokensExpireIn(now()->addMinutes(10));
        Passport::refreshTokensExpireIn(now()->addDays(10));
    }

    /**
     *
     */
    public function register()
    {
        $this->app->bind(/**
         * @return Auth
         */
            Auth::class, function () {

            return new Auth((new ApiConsumer()), env('APP_URL'));
        });
    }
}
