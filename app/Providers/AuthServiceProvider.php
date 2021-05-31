<?php

namespace App\Providers;

use App\Auth\Guard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('api_key', function ($app, $name, array $config) {
            return new Guard(
                Auth::createUserProvider($config['provider']),
                $app['request'],
                config('app.auth_headers.api_key'),
                config('app.auth_headers.user_id'),
            );
        });
    }
}
