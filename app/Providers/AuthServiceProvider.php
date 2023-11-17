<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Extensions\UserProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        auth()->provider('extend_eloquent', function (Application $app, array $config) {
            return new UserProvider($app['hash'], $config['model']);
        });
    }
}
