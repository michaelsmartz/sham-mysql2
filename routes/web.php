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
Route::get('/license', function(){
    return response('Licence agreement ' .rand(1,100));
});
Auth::routes();

#region auth middleware routes
    Route::group(['middleware' => ['auth']], function() {

        // logout using get
        Route::get('auth/logout', 'Auth\LoginController@logout')->name('logout');

        #region Dashboard & Reports
            Route::resource('home', 'HomeController', [ 'only' => ['index'] ]);
            Route::resource('dashboard', 'HomeController', [ 'only' => ['index'] ]);
            
            Route::get('getHeadcountData', 'HomeController@getHeadcountData')->name('getHeadcountData');
            Route::get('getHeadcountDeptData', 'HomeController@getHeadcountDeptData')->name('getHeadcountDeptData');
            Route::get('getNewHiresData', 'HomeController@getNewHiresData')->name('getNewHiresData');
            Route::get('getAssetData', 'HomeController@getAssetData')->name('getAssetData');
            Route::get('getCourseData', 'HomeController@getCourseData')->name('getCourseData');
            Route::get('getRewardCount', 'HomeController@getRewardCount')->name('getRewardCount');
            Route::get('getDisciplinaryActionCount', 'HomeController@getDisciplinaryActionCount')->name('getDisciplinaryActionCount');
            Route::get('getQALastFiveDaysData', 'HomeController@getQALastFiveDaysData')->name('getQALastFiveDaysData');
            Route::get('getQAEvaluationScoresData', 'HomeController@getQAEvaluationScoresData')->name('getQAEvaluationScoresData');
            Route::get('getTotalAssessmentData', 'HomeController@getTotalAssessmentData')->name('getTotalAssessmentData');
            
        #endregion

        #region Central HR
            Route::resource('employees', 'EmployeesController');

            Route::get('employees/{employee?}/qualifications', 'EmployeesController@qualifications')->name('get-qualifications');
            Route::get('employees/{employee?}/check-name', 'EmployeesController@checkEmployee')->name('check-name');
            Route::get('employees/{employee?}/check-id', 'EmployeesController@checkId')->name('check-id');
            Route::get('employees/{employee?}/check-passport', 'EmployeesController@checkPassport')->name('check-passport');
            Route::get('employees/{employee?}/check-employeeno', 'EmployeesController@checkEmployeeNo')->name('check-employeeno');

            Route::resource('medias', 'MediasController');
            Route::any('policies/{Id}/attachment', 'MediasController@show' )->name('policy.show');
            Route::any('policies/{Id}/attachment/attach', 'MediasController@attach' )->name('policy.attach');
            Route::any('policies/{Id}/attachment/{MediaId}/detach', 'MediasController@detach' )->name('policy.detach');
            Route::get('policies/{Id}/attachment/{MediaId}', 'MediasController@download' );
            
            /*
            Route::any('laws/{Id}/attachment', 'MediasController@show' )->name('law.show');
            Route::any('laws/{Id}/attachment/attach', 'MediasController@attach' )->name('law.attach');
            Route::any('laws/{Id}/attachment/{MediaId}/detach', 'MediasController@detach' )->name('law.detach');
            Route::get('laws/{Id}/attachment/{MediaId}', 'MediasController@download' );
            */

            Route::any('employees/{Id}/attachment', 'MediasController@show' )->name('employee.show');
            Route::any('employees/{Id}/attachment/attach', 'MediasController@attach' )->name('employee.attach');
            Route::any('employees/{Id}/attachment/{MediaId}/detach', 'MediasController@detach' )->name('employee.detach');
            Route::get('employees/{Id}/attachment/{MediaId}', 'MediasController@download' );

            Route::any('topics/{Id}/attachment', 'MediasController@show' )->name('topic.show');
            Route::any('topics/{Id}/attachment/attach', 'MediasController@attach' )->name('topic.attach');
            Route::any('topics/{Id}/attachment/{MediaId}/detach', 'MediasController@detach' )->name('topic.detach');
            Route::get('topics/{Id}/attachment/{MediaId}', 'MediasController@download' );

            Route::any('assessments/{Id}/attachment', 'MediasController@show' )->name('assessment.show');
            Route::any('assessments/{Id}/attachment/attach', 'MediasController@attach' )->name('assessment.attach');
            Route::any('assessments/{Id}/attachment/{MediaId}/detach', 'MediasController@detach' )->name('assessment.detach');
            Route::get('assessments/{Id}/attachment/{MediaId}', 'MediasController@download' );

            //Route::resource('laws', 'LawsController');
            Route::fileResource('laws');
            Route::resource('policies', 'PoliciesController');
            Route::resource('assets', 'AssetsController');
            Route::resource('assetgroups', 'AssetGroupsController');
            Route::resource('assetsuppliers', 'AssetSuppliersController');
        #endregion

        #region Configuration parameters routes
            Route::group(['prefix'=>'config'], function(){
                Route::get('employees', 'ConfigDropdownsController@employees')->name('employees');
                Route::resource('assetsuppliers', 'AssetSuppliersController');
            });
        #endregion

        #region E-Learning
            Route::resource('courses', 'CoursesController' );
            Route::resource('modules', 'ModulesController' );

            Route::get('topics/embed/{file}', 'TopicsController@embedMedia');
            Route::get('topics/snippets', 'TopicsController@getSnippets');
            Route::resource('topics', 'TopicsController' );
        #endregion
  
    });
#endregion