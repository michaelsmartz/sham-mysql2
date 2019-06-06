<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Log;
/*

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Collection;
*/
use Collective\Html\FormBuilder as Form;
use App\Macros\Routing\Router;
use App\User;
use Validator;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobFailed;

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

        Queue::after(function (JobProcessed $event) {
            DB::table('job_logs')->insert([
                'loggable_type' => $event->job->resolveName(),
                'message' => 'Job processed',
                'level' => 900,
                'context' => $event->job->resolveName(),
                'extra' => json_encode($event->job),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
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

        Validator::extend('greater_or_equal', function($attribute, $value, $parameters, $validator) {
            $min_field = $parameters[0];
            return (float)$value >= (float)$min_field;
        });

        Validator::extend('less_or_equal', function($attribute, $value, $parameters, $validator) {
            $min_field = $parameters[0];
            return (float)$min_field <= (float)$value;
        });

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
