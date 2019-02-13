<?php

namespace App\Providers;

use App\Extensions\AccessTokenGuard;
use App\Extensions\TokenToUserProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Auth\CacheUserProvider;
use Illuminate\Support\Facades\Auth;

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

        // Cache user
        Auth::provider('cache-user', function() {
            return resolve(CacheUserProvider::class);
        });

        /*Auth::extend('access_token', function ($app, $name, array $config) {
			// automatically build the DI, put it as reference
			$userProvider = app(TokenToUserProvider::class);
			$request = app('request');
			return new AccessTokenGuard($userProvider, $request, $config);
		});*/
    }
}
