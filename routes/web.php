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
Route::get('vue-test', 'MiscController@vueTest');

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

            Route::resource('reports', 'ReportController' );
        #endregion

        #region MyPortal
            Route::resource('selfservice-portal', 'SSPController');

            Route::get('my-details/getProfile', 'SSPMyDetailsController@getProfile');
            Route::resource('my-details', 'SSPMyDetailsController',[
                'only'=>['index','update']
            ]);

            Route::resource('my-elearning/my-assessments', 'SSPMyCourseAssessmentsController',[
                'only'=>['index']
            ]);
            Route::post('my-elearning/enrol', 'SSPMyCourseController@enrol')->name('courseEnrol');;
            Route::get('my-elearning/my-courses', 'SSPMyCourseController@myCourses');
            Route::get('my-course/{Id}','SSPMyCourseController@renderTopic');
            Route::any('my-courses/{Id}/assessment/{assmId}', 'SSPMyCourseController@manageAssessment');
            Route::any('my-courses/{Id}/assessment/{assmId}/post/{status}', 'SSPMyCourseController@manageAssessment');
            Route::get('topic-attachment/{Id}/download', 'SSPMyCourseController@download')->name('sspmycourses.download');
            Route::get('my-courses/{Id}/getAssessmentData/', 'SSPMyCourseController@getAssessmentData')->name('sspmycourses.getassessmentdata');
            Route::get('my-courses/{Id}/getattachments/', 'SSPMyCourseController@getTopicAttachments');
            Route::get('my-courses/{Id}/restart/', 'SSPMyCourseController@restartCourse');
            Route::get('my-courses/{Id}/getattachments/', 'SSPMyCourseController@getTopicAttachments');
            Route::post('my-courses/progress', 'SSPMyCourseController@updateCourseProgress');
            Route::resource('my-courses', 'SSPMyCourseController',[
                'only'=>['index']
            ]);

            Route::resource('my-surveys', 'SSPMySurveysController');
            Route::any('survey-thumbnail/{formId}', 'SSPMySurveysController@getFormData');
        #endregion

        #region Central HR
            // "duplicate" routes to work with both create and edit mode
            Route::get('employees/check-id', 'EmployeesController@checkId');
            Route::get('employees/{employee}/check-id', 'EmployeesController@checkId');    
            Route::get('employees/check-name', 'EmployeesController@checkEmployee');
            Route::get('employees/{employee}/check-name', 'EmployeesController@checkEmployee');
            Route::get('employees/check-passport', 'EmployeesController@checkPassport');
            Route::get('employees/{employee}/check-passport', 'EmployeesController@checkPassport');
            Route::get('employees/check-employeeno', 'EmployeesController@checkEmployeeNo');
            Route::get('employees/{employee}/check-employeeno', 'EmployeesController@checkEmployeeNo')->name('check-employeeno');

            Route::any('employees/{employee?}/departmentid', 'EmployeesController@getEmployeeDepartmentId')->name('get-departmentid');
            Route::get('employees/{employee?}/qualifications', 'EmployeesController@qualifications')->name('get.qualifications');
            Route::any('employees/{employee?}/edit/employee-history', 'EmployeesController@editEmployeeHistory')->name('employee-history');
            Route::any('employees/{employee?}/update/employee-history', 'EmployeesController@updateEmployeeHistory')->name('employees-history.update');
            
            Route::resource('employees', 'EmployeesController');

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
            Route::get('surveys/{Id}/results', 'SurveysController@results' );
            
            Route::resource('timelines', 'TimelinesController', [
                'parameters' => ['index' => 'employee'],
                'names' => ['show' => 'timelines.index'],
                'only' => ['show']
            ]);
            Route::employeeInResource('rewards');
            Route::employeeInResource('disciplinary_actions');
            
        #endregion

        #region Configuration parameters routes
            Route::group(['prefix'=>'config'], function(){
                Route::get('employees', 'ConfigDropdownsController@employees')->name('employees');
            });
            Route::resource('disciplinary_decisions', 'DisciplinaryDecisionsController');
            Route::resource('disabilities', 'DisabilitiesController');
            Route::resource('disability_categories', 'DisabilityCategoriesController');
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
            //Route::resource('employee_attachment_types', 'EmployeeAttachmentTypesController');
            Route::resource('assessment_types', 'AssessmentTypesController');
            //Route::resource('learning_material_types', 'LearningMaterialTypesController');
            //Route::resource('training_delivery_methods', 'TrainingDeliveryMethodsController');
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

            Route::resource('contracts', 'ContractsController');
            Route::resource('interviews', 'InterviewsController');
            Route::resource('offers', 'OffersController');
            Route::resource('qualification-recruitments', 'QualificationRecruitmentsController');
        #endregion

        #region E-Learning
            Route::get('elearning', 'MiscController@elearningHelper');
            Route::resource('courses', 'CoursesController' );
            Route::resource('modules', 'ModulesController' );

            Route::get('topics/embed/{file}', 'TopicsController@embedMedia');
            Route::get('topics/{topic?}/snippets', 'TopicsController@getSnippets');
            Route::resource('topics', 'TopicsController' );

            Route::resource('module_assessments', 'ModuleAssessmentsController' );
            Route::resource('module_assessments/{module_assessment}/responses', 'ModuleAssessmentResponsesController',[
                'only'=>['index', 'update']
            ]);
            Route::get('module_assessments/{response}/responses/{module_assessment}/employee/{employee_id}/editAssessment', 'ModuleAssessmentResponsesController@editAssessment');
            Route::resource('course_training_sessions', 'CourseTrainingSessionsController' );
        #endregion

        #region Quality
            Route::any('assessments/assessment/{assessment}/clone', 'AssessmentsController@clone')->name('assessment.clone');
            Route::get('assessments/assessment/{assessment}/cloneForm', 'AssessmentsController@cloneForm')->name('assessments.clone-assessment-form');
            Route::get('assessments/assessment/{assessment}/preview', 'AssessmentsController@preview')->name('assessments.preview');
            Route::resource('assessments', 'AssessmentsController' );
            Route::any('assessments/duplicates/', 'AssessmentsController@duplicates')->name('assessment.duplicates');
            Route::resource('assessment_categories', 'AssessmentCategoriesController');
            Route::resource('category_questions', 'CategoryQuestionsController');
            Route::fileResource('evaluations', 'EvaluationsController');
            Route::any('instances', 'EvaluationsController@showInstances')->name('evaluations.instances');
            Route::get('evaluations/{id}/EvaluationId/{EvaluationId}/assess', 'EvaluationsController@loadAssessment')->name('evaluations.load_assessment');
            Route::post('evaluations/{id}/EvaluationId/{EvaluationId}/submitassessment', 'EvaluationsController@submitAssessment')->name('evaluations.submit_assessment');
            Route::get('evaluations/{assessor}/score/{evaluationid}/show', 'EvaluationsController@score')->name('evaluations.score');
            Route::get('evaluations/{assessor}/score/{evaluationid}/show-score-modal', 'EvaluationsController@scoreCompletedEvaluation')->name('evaluations.score-completed-evaluation');
            Route::any('evaluations/{Id}/name/{name}/downloadscorepdf', 'EvaluationsController@downloadScorePdf' )->name('evaluations.pdfscores');
            Route::any('evaluations/{Id}/EvaluationId/{EvaluationId}/AssessorId/{AssessorId}/summary', 'EvaluationsController@summary')->name('evaluations.summary');
            Route::get('getaudio', 'EvaluationsController@getaudio');
            Route::get('getaudio1', 'EvaluationsController@getaudio1');
            Route::get('getaudiolist', 'EvaluationsController@getaudiolist');
        #endregion

        #region Imports
            Route::get('import', 'ImportsController@getImport')->name('import');
            Route::post('import_parse', 'ImportsController@parseImport')->name('import_parse');
            Route::post('import_process', 'ImportsController@processImport')->name('import_process');
        #endregion

        #region Recruitment
        Route::resource('recruitment', 'RecruitmentsController');

	    Route::post('recruitment_requests/{recruitment_request}/candidate/{candidate}/interview/{interview}/delete-media', 'RecruitmentRequestsController@deleteInterviewMedia')->name('recruitment_requests.delete-interview-media');
        Route::get('recruitment_requests/{recruitment_request}/candidate/{candidate}/interview/{interview}/download-media/{media}', 'RecruitmentRequestsController@downloadInterviewMedia')->name('recruitment_requests.download-interview-media');

        Route::get('recruitment_requests/{recruitment_request}/stages/{interview}/candidate/{candidate?}/edit-interview', 'RecruitmentRequestsController@editInterview')->name('recruitment_requests.edit-interview');
        Route::patch('recruitment_requests/{recruitment_request}/stages/{interview}/candidate/{candidate?}/update-interview', 'RecruitmentRequestsController@updateInterview')->name('recruitment_requests.update-interview');
        Route::fileResource('recruitment_requests', 'RecruitmentRequestsController');
        Route::get('recruitment_requests/{recruitment_request}/stages', 'RecruitmentRequestsController@showStages')->name('recruitment_requests.stages');
        Route::get('recruitment_requests/{recruitment_request}/candidates', 'RecruitmentRequestsController@getCandidates')->name('recruitment_requests.candidates-list');
        Route::get('recruitment_requests/{recruitment_request}/offer-letters', 'RecruitmentRequestsController@getOfferLetters')->name('recruitment_requests.offer-letters-list');
        Route::get('recruitment_requests/{recruitment_request}/contracts', 'RecruitmentRequestsController@getContracts')->name('recruitment_requests.contracts-list');
        Route::post('recruitment_requests/{recruitment_request}/switch/{candidate}/{state}', 'RecruitmentRequestsController@stateSwitch')->name('recruitment_requests.update-status');
        Route::post('recruitment_requests/{recruitment_request}/interviewing/{candidate}', 'RecruitmentRequestsController@getInterviewing')->name('recruitment_requests.get-interviewing');
        Route::post('recruitment_requests/{recruitment_request}/upload-offer', 'RecruitmentRequestsController@saveSignedOfferForm')->name('recruitment_requests.upload-offer');

        Route::post('recruitment_requests/{recruitment_request}/candidate/{candidate}/download-offer', 'RecruitmentRequestsController@downloadOffer')->name('recruitment_requests.download-offer');
        Route::post('recruitment_requests/{recruitment_request}/candidate/{candidate}/download-signed-offer', 'RecruitmentRequestsController@downloadSignedOffer')->name('recruitment_requests.download-signed-offer');
        Route::get('recruitment_requests/{recruitment_request}/candidate/{candidate}/offer/{offer}/upload-offer-form', 'RecruitmentRequestsController@uploadSignedOfferForm')->name('recruitment_requests.upload-offer-form');

        Route::post('recruitment_requests/{recruitment_request}/upload-contract', 'RecruitmentRequestsController@saveSignedContractForm')->name('recruitment_requests.upload-contract');
        Route::post('recruitment_requests/{recruitment_request}/candidate/{candidate}/download-contract', 'RecruitmentRequestsController@downloadContract')->name('recruitment_requests.download-contract');
        Route::post('recruitment_requests/{recruitment_request}/candidate/{candidate}/download-signed-contract', 'RecruitmentRequestsController@downloadSignedContract')->name('recruitment_requests.download-signed-contract');
        Route::get('recruitment_requests/{recruitment_request}/candidate/{candidate}/contract/{contract}/upload-contract-form', 'RecruitmentRequestsController@uploadSignedContractForm')->name('recruitment_requests.upload-contract-form');

        Route::any('recruitment_requests/{recruitment_request}/candidate/{candidate}/hired', 'RecruitmentRequestsController@importHiredCandidate')->name('recruitment_requests.hired');
        Route::any('recruitment_requests/{recruitment_request}/candidate/{candidate}/update-interview-comment', 'RecruitmentRequestsController@updateInterviewComment')->name('recruitment_requests.update-interview-comment');
        Route::get('recruitment_requests/{request?}/manage-candidate', 'RecruitmentRequestsController@manageCandidate');
        Route::patch('recruitment_requests/{request?}/update-candidate', 'RecruitmentRequestsController@updateCandidate')->name('recruitment_requests.update-candidate');
        Route::fileResource('candidates', 'CandidatesController');
        Route::get('candidates/{candidate?}/candidate-qualifications', 'CandidatesController@qualifications')->name('get-candidate-qualifications');
        Route::get('candidates/{candidate?}/previous_employments', 'CandidatesController@previousEmployments')->name('get-candidate-employments');
        #endregion

        #region Leaves
            Route::resource('absence_types', 'AbsenceTypesController');
        #endregion
    });
#endregion