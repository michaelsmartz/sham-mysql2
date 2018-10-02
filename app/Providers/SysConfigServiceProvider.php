<?php

namespace App\Providers;

use App\SysConfigValue;
use Illuminate\Support\ServiceProvider;

class SysConfigServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('settings', function ($app) {
            return $app['cache']->remember('site.settings', 120, function () {
                return SysConfigValue::pluck('value', 'key')->toArray();
            });
        });
    }
}