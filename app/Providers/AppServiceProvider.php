<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use DB;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if( env('APP_DEBUG') === true ){
            DB::listen(function($query) {
                $logFile = storage_path('logs/query.log');
                $monolog = new Logger('log');
                $monolog->pushHandler(new StreamHandler($logFile), Logger::INFO);
                $monolog->info($query->sql, compact('bindings', 'time'));
            });
        }

        $this->app->singleton('current_user', function ($app) {
            return $app['auth']->user();
        });
		
		if ($this->app->runningInConsole()) {
            Schema::defaultStringLength(191);
		}
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
