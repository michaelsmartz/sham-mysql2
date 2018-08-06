<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'MiscController@welcome');
Route::get('test', 'MiscController@test');

Auth::routes();
#region auth middleware routes
    Route::group(['middleware' => ['auth']], function() {

        // logout using get
        Route::get('auth/logout', 'Auth\LoginController@logout')->name('logout');
        Route::resource('home', 'HomeController', [ 'only' => ['index'] ]);
        Route::resource('dashboard', 'HomeController', [ 'only' => ['index'] ]);
        
        Route::get('getHeadcountData', 'HomeController@getHeadcountData')->name('getHeadcountData');
        Route::get('getHeadcountDeptData', 'HomeController@getHeadcountDeptData')->name('getHeadcountDeptData');
        Route::get('getNewHiresData', 'HomeController@getNewHiresData')->name('getNewHiresData');
        Route::get('getAssetData', 'HomeController@getAssetData')->name('getAssetData');
        Route::get('getCourseData', 'HomeController@getCourseData')->name('getCourseData');
        Route::any('getRewardCount', 'HomeController@getRewardCount')->name('getRewardCount');
        Route::any('getDisciplinaryActionCount', 'HomeController@getDisciplinaryActionCount')->name('getDisciplinaryActionCount');
        
        #region Configuration parameters routes
            Route::group(['prefix'=>'config'], function(){
                Route::get('employees', 'ConfigDropdownsController@employees')->name('employees');
                Route::resource('assetsuppliers', 'AssetSupplierController');
            });
        #endregion

        #region e-Learning
            Route::resource('courses', 'CoursesController' );
            Route::resource('modules', 'ModulesController' );

            Route::get('topics/embed/{file}', 'TopicsController@embedMedia');
            Route::get('topics/snippets', 'TopicsController@getSnippets');
            Route::resource('topics', 'TopicsController' );
        #endregion
  
    });
#endregion