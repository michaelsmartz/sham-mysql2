<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
/*
use DB;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Collection;
*/
use Collective\Html\FormBuilder as Form;
use App\Macros\Routing\Router;
use App\User;
use App\Observers\UserObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);

        $this->app->singleton('current_user', function ($app) {
            return $app['auth']->user();
        });

        /*
        if( env('LOG_QUERIES') === true ){
            DB::listen(function($query) {
                $logFile = storage_path('logs/query.log');
                $monolog = new Logger('log');
                $monolog->pushHandler(new StreamHandler($logFile), Logger::INFO);
                $monolog->info($query->sql, compact('bindings', 'time'));
            });
        }
        */

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Router::registerMacros();

        /*
        if (!$this->app->runningInConsole()) {
            Form::macro(
                'groupRelationSelect', 
                function ($name, $collection, $relation, $groupName = 'name', $optName = 'name', $optValue = 'id', $selected = null, $attributes = []) 
                {
                    $groups = [];
                    foreach ($collection as $model) {
                        foreach($model->$relation as $rel) {
                            $groups[$model->$groupName][$rel->$optValue] = $rel->$optName;
                        }
                    }

                    return Form::select($name, $groups, $selected, $attributes);
                }
            );

            Form::macro(
                'groupSelect', 
                function ($name, $collection, $groupName = 'name', $optName = 'name', $optValue = 'id', $selected = null, $attributes = []) 
                {
                    $groups = [];
                    foreach ($collection as $model) {
                        $groups[$model->$groupName][$model->$optValue] = $model->$optName;
                    }

                    return Form::select($name, $groups, $selected, $attributes);
                }
            );
        
        }
        
        Collection::macro('toAssoc', function () {
            return $this->reduce(function ($assoc, $keyValuePair) {
                list($key, $value) = $keyValuePair;
                $assoc[$key] = $value;
                return $assoc;
            }, new static);
        });
        Collection::macro('mapToAssoc', function ($callback) {
            return $this->map($callback)->toAssoc();
        });
        */

        
    }
}
