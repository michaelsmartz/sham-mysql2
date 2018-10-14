<?php

namespace App\Macros\Routing;

use Illuminate\Support\Facades\Route as DefaultRouter;
use Illuminate\Support\Str;

/**
 *
 */
class Router
{
    public static function registerMacros()
    {
        if (!DefaultRouter::hasMacro('fileResource')) {
            DefaultRouter::macro('fileResource', function ($module) {

                $url        = str_replace('.', '', Str::plural($module));
                $name       = Str::singular($module);
                $controller = Str::studly(str_replace('.', ' ', $module)) . 'Controller';

                DefaultRouter::group([
                    'middleware' => ['auth'],
                ], function () use ($url, $name, $controller) {
                    DefaultRouter::get($url . '/{' . $name .'}/attachment', $controller . '@attachment' )->name($url . '.attachment');
                    DefaultRouter::get($url . '/{' . $name .'}/attachment/{MediaId}/detach', $controller . '@detach' )->name($url . '.detach');
                    DefaultRouter::get($url . '/{' . $name .'}/attachment/{MediaId}', $controller . '@download' )->name($url . '.download');
                    
                    DefaultRouter::get($url . '/create', $controller . '@create')->name($url . '.create');
                    DefaultRouter::post($url, $controller . '@store')->name($url . '.store');
                    DefaultRouter::get($url, $controller . '@index')->name($url . '.index');
                    DefaultRouter::get($url . '/{' . $name .'}/edit', $controller . '@edit')->name($url . '.edit');
                    DefaultRouter::put($url . '/{' . $name .'}', $controller . '@update')->name($url . '.update');
                    DefaultRouter::patch($url . '/{' . $name .'}', $controller . '@update')->name($url . '.update');
                    DefaultRouter::delete($url . '/{' .$name .'}', $controller . '@destroy')->name($url . '.destroy');
                });
            });
        }

        if (!DefaultRouter::hasMacro('employeeInResource')) {
            DefaultRouter::macro('employeeInResource', function ($module) {

                $url        = str_replace('.', '', Str::plural($module));
                $name       = Str::singular($module);
                $controller = Str::studly(str_replace('.', ' ', $module)) . 'Controller';

                DefaultRouter::group([
                    'middleware' => ['auth'],
                ], function () use ($url, $name, $controller) {
                    DefaultRouter::get($url . '/employee/{employee}', $controller . '@index' )->name($url);
                    
                    DefaultRouter::get($url . '/create', $controller . '@create')->name($url . '.create');
                    DefaultRouter::post($url, $controller . '@store')->name($url . '.store');
                    DefaultRouter::get($url . '/{' . $name .'}/edit', $controller . '@edit')->name($url . '.edit');
                    DefaultRouter::put($url . '/{' . $name .'}', $controller . '@update')->name($url . '.update');
                    DefaultRouter::patch($url . '/{' . $name .'}', $controller . '@update')->name($url . '.update');
                    DefaultRouter::delete($url . '/{' .$name .'}', $controller . '@destroy')->name($url . '.destroy');
                });
            });
        }
    }
}