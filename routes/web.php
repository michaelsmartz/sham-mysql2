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

            Route::resource('announcements', 'AnnouncementsController');
            Route::fileResource('laws');
            Route::fileResource('policies');
            Route::fileResource('topics');
            Route::fileResource('employees');
            //Route::fileResource('assessments');
            Route::resource('organisationcharts', 'OrganisationChartsController', [ 'only' => ['index']]);
            
            Route::resource('assets', 'AssetsController');
            Route::resource('asset_groups', 'AssetGroupsController');
            Route::resource('asset_suppliers', 'AssetSuppliersController');
            Route::resource('asset_allocations', 'AssetAllocationsController');

            Route::resource('surveys', 'SurveysController' );
            Route::any('surveys/{Id}/results', 'SurveysController@results' );

        #endregion

        #region Configuration parameters routes
            Route::group(['prefix'=>'config'], function(){
                Route::get('employees', 'ConfigDropdownsController@employees')->name('employees');
            });
            Route::resource('law_categories', 'LawCategoriesController');
            Route::resource('policy_categories', 'PolicyCategoriesController');
            Route::resource('genders', 'GendersController');
            Route::resource('titles', 'TitlesController');
            Route::resource('marital_statuses', 'MaritalStatusesController');
            Route::resource('skills', 'SkillsController');
            Route::resource('teams', 'TeamsController');
            Route::resource('tax_statuses', 'TaxStatusesController');
            Route::resource('branches', 'BranchesController');
            Route::resource('countries', 'CountriesController');
            Route::resource('departments', 'DepartmentsController');
            Route::resource('divisions', 'DivisionsController');
            Route::resource('document_categories', 'DocumentCategoriesController');
            Route::resource('document_types', 'DocumentTypesController');
            Route::resource('employee_statuses', 'EmployeeStatusesController');
            Route::resource('ethnic_groups', 'EthnicGroupsController');
            Route::resource('immigration_statuses', 'ImmigrationStatusesController');
            Route::resource('job_titles', 'JobTitlesController');
            Route::resource('languages', 'LanguagesController');
            Route::resource('time_periods', 'TimePeriodsController');
            Route::resource('time_groups', 'TimeGroupsController');
            Route::resource('products', 'ProductsController');
            Route::resource('employee_attachment_types', 'EmployeeAttachmentTypesController');
            Route::resource('assessment_types', 'AssessmentTypesController');
            Route::resource('learning_material_types', 'LearningMaterialTypesController');
            Route::resource('training_delivery_methods', 'TrainingDeliveryMethodsController');
            Route::resource('product_categories', 'ProductCategoriesController');
            Route::resource('category_question_types', 'CategoryQuestionTypesController');
            Route::resource('companies', 'CompaniesController');
            Route::resource('report_templates', 'ReportTemplatesController');
            Route::resource('sham_user_profiles', 'ShamUserProfilesController');
            Route::any('sham_user_profiles/{Id}/matrix', 'ShamUserProfilesController@matrix')->name('sham_user_profiles.matrix');
            Route::resource('sham_users', 'ShamUsersController');
            Route::resource('users', 'UsersController');
            Route::resource('asset_conditions', 'AssetConditionsController');
            Route::resource('violations', 'ViolationsController');
        #endregion

        #region E-Learning
            Route::resource('courses', 'CoursesController' );
            Route::resource('modules', 'ModulesController' );

            Route::get('topics/embed/{file}', 'TopicsController@embedMedia');
            Route::get('topics/snippets', 'TopicsController@getSnippets');
            Route::resource('topics', 'TopicsController' );

            Route::resource('module_assessments', 'ModuleAssessmentsController' );
            Route::resource('training_sessions', 'CourseTrainingSessionsController' );
        #endregion

        #region Quality
            Route::resource('assessments', 'AssessmentsController' );
            Route::resource('assessment_categories', 'AssessmentCategoriesController' );
            Route::resource('category_questions', 'CategoryQuestionsController');
        #endregion
  
    });
#endregion