#---- SystemsubModules/system_sub_modulesFK_TeamsProducts_Products
ALTER TABLE `system_sub_modules` 
DROP FOREIGN KEY `FK_SystemSubModules_SystemModules`;

ALTER TABLE `system_sub_modules` 
ADD CONSTRAINT `FK_SystemSubModules_SystemModules`
  FOREIGN KEY (`system_module_id`)
  REFERENCES `system_modules` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `system_sub_modules` 
DROP FOREIGN KEY `FK_SystemSubModules_SystemModules`;

ALTER TABLE `system_sub_modules` 
ADD CONSTRAINT `FK_SystemSubModules_SystemModules`
  FOREIGN KEY (`system_module_id`)
  REFERENCES `system_modules` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
#---- Teams/teams
 
ALTER TABLE `teams` 
ADD CONSTRAINT `FK_Teams_TimeGroups`
  FOREIGN KEY (`time_group_id`)
  REFERENCES `time_groups` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


#---- TimeGroupDays/time_group_day_time_period 
ALTER TABLE `day_time_group_time_period` 
ADD CONSTRAINT `FK_TimeGroupDays_Days`
  FOREIGN KEY (`day_id`)
  REFERENCES `days` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_TimeGroupDays_TimeGroups`
  FOREIGN KEY (`time_group_id`)
  REFERENCES `time_groups` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_TimeGroupDays_TimePeriods`
  FOREIGN KEY (`time_period_id`)
  REFERENCES `time_periods` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

 #---- learningmaterials/learning_materials  
ALTER TABLE `learning_materials` 
ADD CONSTRAINT `FK_LearningMaterials_LearningMaterialTypes`
  FOREIGN KEY (`learning_material_type_id`)
  REFERENCES `learning_material_types` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_LearningMaterials_Modules`
  FOREIGN KEY (`module_id`)
  REFERENCES `modules` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

 #---- teamsproducts/team_products    
  ALTER TABLE `product_team` 
ADD CONSTRAINT `FK_TeamsProducts_Products`
  FOREIGN KEY (`product_id`)
  REFERENCES `products` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_TeamsProducts_Teams`
  FOREIGN KEY (`team_id`)
  REFERENCES `teams` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
 #---- titles
 ALTER TABLE `titles` 
ADD INDEX `IX_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC);

#---- genders
ALTER TABLE `genders` 
ADD INDEX `IX_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC);
  
#---- maritalstatuses
ALTER TABLE `maritalstatuses` 
ADD INDEX `IX_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC);

#---- 01 Alter employees
ALTER TABLE `employees` 
ADD INDEX `IX_Employees_Joined_Terminated` (`date_joined` ASC, `date_terminated` ASC, `is_active` ASC);

#---- Laws/laws
ALTER TABLE `laws` 
ADD CONSTRAINT `FK_Laws_Countries`
  FOREIGN KEY (`country_id`)
  REFERENCES `countries` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Laws_LawCategories`
  FOREIGN KEY (`law_category_id`)
  REFERENCES `law_categories` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
#----Policies/policies
ALTER TABLE `policies` 
ADD CONSTRAINT `FK_Policies_PolicyCategories`
  FOREIGN KEY (`policy_category_id`)
  REFERENCES `policy_categories` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

  #---- assets
 
ALTER TABLE `assets` 
ADD CONSTRAINT `FK_Assets_AssetConditions`
  FOREIGN KEY (`asset_condition_id`)
  REFERENCES `asset_conditions` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Assets_AssetGroups`
  FOREIGN KEY (`asset_group_id`)
  REFERENCES `asset_groups` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Assets_Suppliers`
  FOREIGN KEY (`asset_supplier_id`)
  REFERENCES `asset_suppliers` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
#---- asssetallocations /asset_employee
  ALTER TABLE `asset_employee` 
ADD CONSTRAINT `FK_AssetAllocations_Assets`
  FOREIGN KEY (`asset_id`)
  REFERENCES `assets` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_AssetAllocations_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
#---- assetgroups/asset_groups  
ALTER TABLE `asset_groups` 
ADD INDEX `IX_ASSET_GROUP_ACTIVE` (`name` ASC, `is_active` ASC);

#---- Courses/courses
ALTER TABLE `courses` 
ADD INDEX `IDX_active_public_description` (`is_public` ASC, `is_active` ASC, `description` ASC);

ALTER TABLE `courses` 
ADD INDEX `IDX_course_id_deleted` (`id` ASC, `deleted_at` ASC);

#---- moduletopics/module_topic
ALTER TABLE `module_topic` 
ADD CONSTRAINT `FK_ModuleTopics_Modules`
  FOREIGN KEY (`module_id`)
  REFERENCES `modules` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_ModuleTopics_Topics`
  FOREIGN KEY (`topic_id`)
  REFERENCES `topics` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- courseparticipants/course_employee
  ALTER TABLE `course_employee` 
ADD CONSTRAINT `FK_CourseParticipants_CourseParticipantStatuses`
  FOREIGN KEY (`courseparticipantstatus_id`)
  REFERENCES `courseparticipantstatuses` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_CourseParticipants_Courses`
  FOREIGN KEY (`course_id`)
  REFERENCES `courses` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_CourseParticipants_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- courseprogresses/course_progress
  ALTER TABLE `course_progress` 
ADD CONSTRAINT `FK_CourseProgress_Courses`
  FOREIGN KEY (`course_id`)
  REFERENCES `courses` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_CourseProgress_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_CourseProgress_Modules`
  FOREIGN KEY (`module_id`)
  REFERENCES `modules` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_CourseProgress_Topics`
  FOREIGN KEY (`topic_id`)
  REFERENCES `topics` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
 #--employees
 ALTER TABLE `employees` 
ADD CONSTRAINT `FK_Employees_Branches`
  FOREIGN KEY (`branch_id`)
  REFERENCES `branches` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Employees_Countries`
  FOREIGN KEY (`passport_country_id`)
  REFERENCES `countries` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Employees_Departments`
  FOREIGN KEY (`department_id`)
  REFERENCES `departments` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Employees_Divisions`
  FOREIGN KEY (`division_id`)
  REFERENCES `divisions` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Employees_EmployeeStatuses`
  FOREIGN KEY (`employee_status_id`)
  REFERENCES `employee_statuses` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Employees_EthnicGroups`
  FOREIGN KEY (`ethnic_group_id`)
  REFERENCES `ethnic_groups` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Employees_Genders`
  FOREIGN KEY (`gender_id`)
  REFERENCES `genders` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Employees_ImmigrationStatuses`
  FOREIGN KEY (`immigration_status_id`)
  REFERENCES `immigration_statuses` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Employees_JobTitles`
  FOREIGN KEY (`jobtitle_id`)
  REFERENCES `job_titles` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Employees_Languages`
  FOREIGN KEY (`language_id`)
  REFERENCES `languages` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Employees_MaritalStatuses`
  FOREIGN KEY (`marital_status_id`)
  REFERENCES `maritalstatuses` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Employees_TaxStatuses`
  FOREIGN KEY (`tax_status_id`)
  REFERENCES `tax_statuses` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Employees_Teams`
  FOREIGN KEY (`team_id`)
  REFERENCES `teams` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Employees_Titles`
  FOREIGN KEY (`title_id`)
  REFERENCES `titles` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- addresses
  ALTER TABLE `addresses` 
ADD CONSTRAINT `FK_Addresses_AddressTypes`
  FOREIGN KEY (`address_type_id`)
  REFERENCES `address_types` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Addresses_Countries`
  FOREIGN KEY (`country_id`)
  REFERENCES `countries` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Addresses_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- rewards
ALTER TABLE `rewards` 
ADD CONSTRAINT `FK_Rewards_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- DisciplinaryActions/disciplinary_actions
  ALTER TABLE `disciplinary_actions` 
ADD CONSTRAINT `FK_DisciplinaryActions_Decisions`
  FOREIGN KEY (`disciplinary_decision_id`)
  REFERENCES `disciplinary_decisions` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_DisciplinaryActions_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_DisciplinaryActions_Violations`
  FOREIGN KEY (`violation_id`)
  REFERENCES `violations` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- topicattachments/topic_attachments
  ALTER TABLE `topic_attachments` 
ADD CONSTRAINT `FK_TopicAttachments_LearningMaterialTypes`
  FOREIGN KEY (`learning_material_type_id`)
  REFERENCES `learning_material_types` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_TopicAttachments_Topics`
  FOREIGN KEY (`topic_id`)
  REFERENCES `topics` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

#---- trainingsessions
ALTER TABLE `training_sessions` 
ADD CONSTRAINT `FK_TrainingSessions_Courses1`
  FOREIGN KEY (`course_id`)
  REFERENCES `courses` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_TrainingSessions_TrainingDeliveryMethods`
  FOREIGN KEY (`training_delivery_method_id`)
  REFERENCES `training_delivery_methods` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


#---- Addressestypes
ALTER TABLE `address_types` 
ADD INDEX `IX_ADDRESS_TYPES_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC);
  
  #---- employeeskills/employee_id_skills
  ALTER TABLE `employee_skill` 
ADD CONSTRAINT `FK_EmployeeSkills_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_EmployeeSkills_Skills`
  FOREIGN KEY (`skill_id`)
  REFERENCES `skills` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
#---- Qualifications
  ALTER TABLE `qualifications` 
ADD CONSTRAINT `FK_Qualifications_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

#---- commentdetails
ALTER TABLE `commentdetails` 
ADD CONSTRAINT `FK_CommentDetails_CourseDiscussions`
  FOREIGN KEY (`course_discussion_iId`)
  REFERENCES `course_discussions` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_CommentDetails_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_CommentDetails_ThreadStatuses`
  FOREIGN KEY (`thread_status_id`)
  REFERENCES `thread_statuses` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

  
  #---- Law Documents
  ALTER TABLE `lawdocuments` 
ADD CONSTRAINT `FK_law_documents_law_id`
  FOREIGN KEY (`LawId`)
  REFERENCES `laws` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
 
  #---- employeeattachments
  ALTER TABLE `employee_attachments` 
ADD CONSTRAINT `FK_EmployeeAttachments_EmployeeAttachmentTypes`
  FOREIGN KEY (`employee_attachment_type_id`)
  REFERENCES `employee_attachment_types` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_EmployeeAttachments_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
 #---- modulequestions
 ALTER TABLE `module_questions` 
ADD CONSTRAINT `FK_ModuleQuestions_ModuleQuestionTypes`
  FOREIGN KEY (`module_question_type_id`)
  REFERENCES `module_question_types` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #----coursediscussions`
  ALTER TABLE `course_discussions` 
ADD CONSTRAINT `FK_CourseDiscussions_Courses`
  FOREIGN KEY (`course_id`)
  REFERENCES `courses` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_CourseDiscussions_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_CourseDiscussions_ThreadStatuses`
  FOREIGN KEY (`thread_status_id`)
  REFERENCES `thread_statuses` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

  
#---- branches  
ALTER TABLE `branches` 
ADD CONSTRAINT `FK_Branches_Companies1`
  FOREIGN KEY (`company_id`)
  REFERENCES `companies` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
# review code after table rename from telephonenumbers to telephone_numbers
#--01 Alter telephone_numbers
#ALTER TABLE `telephonenumbers` 
#ADD CONSTRAINT `FK_TelephoneNumbers_Employees`
#  FOREIGN KEY (`EmployeeId`)
#  REFERENCES `employees` (`id`)
#  ON DELETE NO ACTION
 # ON UPDATE NO ACTION;

 
 #---- AssessmentsAssessmentCategories/assessments_assessment_category
 
ALTER TABLE `assessments_assessment_category` 
ADD CONSTRAINT `FK_AssessmentsAssessmentCategories_AssessmentCategories`
  FOREIGN KEY (`assessmentcategory_id`)
  REFERENCES `assessment_categories` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_AssessmentsAssessmentCategories_Assessments`
  FOREIGN KEY (`assessment_id`)
  REFERENCES `assessments` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

 #---- categoryquestions/category_questions
 
ALTER TABLE `category_questions` 
ADD CONSTRAINT `FK_CategoryQuestions_CategoryQuestionTypes`
  FOREIGN KEY (`category_question_type_id`)
  REFERENCES `category_question_types` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
 
#---- categoryquestionchoices/category_question_choices 
  ALTER TABLE `category_question_choices` 
ADD CONSTRAINT `FK_CategoryQuestionChoices_CategoryQuestions2`
  FOREIGN KEY (`category_question_id`)
  REFERENCES `category_questions` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

#---- assessmentcategory_categoryquestion/assessment_category_category_question   
  ALTER TABLE `assessment_category_category_question` 
ADD CONSTRAINT `FK_AssessmentCategoriesCategoryQuestions_AssessmentCategories`
  FOREIGN KEY (`assessmentcategory_id`)
  REFERENCES `assessment_categories` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_AssessmentCategoriesCategoryQuestions_CategoryQuestions`
  FOREIGN KEY (`categoryquestion_id`)
  REFERENCES `category_questions` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

#---- evaluations
ALTER TABLE `evaluations` 
ADD CONSTRAINT `FK_Evaluations_Assessments`
  FOREIGN KEY (`assessment_id`)
  REFERENCES `assessments` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Evaluations_Departments`
  FOREIGN KEY (`department_id`)
  REFERENCES `departments` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Evaluations_Employees`
  FOREIGN KEY (`useremployee_id`)
  REFERENCES `employees` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Evaluations_Employees1`
  FOREIGN KEY (`createdbyemployee_id`)
  REFERENCES `employees` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Evaluations_EvaluationStatuses`
  FOREIGN KEY (`evaluationstatus_id`)
  REFERENCES `evaluation_statuses` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Evaluations_Languages`
  FOREIGN KEY (`language_id`)
  REFERENCES `languages` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Evaluations_ProductCategories`
  FOREIGN KEY (`productcategory_id`)
  REFERENCES `product_categories` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;  
  
  #---- evaluationassessors/evaluation_assessors
  ALTER TABLE `evaluation_assessors` 
ADD CONSTRAINT `FK_EvaluationAssessors_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_EvaluationAssessors_Evaluations`
  FOREIGN KEY (`evaluation_id`)
  REFERENCES `evaluations` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- evaluationresults/evaluation_results
  ALTER TABLE `evaluation_results` 
ADD CONSTRAINT `FK_EvaluationResults_AssessmentCategories`
  FOREIGN KEY (`assessmentcategory_id`)
  REFERENCES `assessment_categories` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_EvaluationResults_Assessments`
  FOREIGN KEY (`assessment_id`)
  REFERENCES `assessments` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_EvaluationResults_CategoryQuestions`
  FOREIGN KEY (`categoryquestion_id`)
  REFERENCES `category_questions` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_EvaluationResults_Employees`
  FOREIGN KEY (`assessoremployee_id`)
  REFERENCES `employees` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_EvaluationResults_Evaluations`
  FOREIGN KEY (`evaluation_id`)
  REFERENCES `evaluations` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  
  #---- announcements
  ALTER TABLE `announcements` 
ADD CONSTRAINT `FK_Announcements_AnnouncementStatuses`
  FOREIGN KEY (`announcement_status_id`)
  REFERENCES `announcement_statuses` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- announcementdepartments
  ALTER TABLE `announcement_department` 
ADD CONSTRAINT `FK_AnnouncementsDepartments_Announcements`
  FOREIGN KEY (`announcement_id`)
  REFERENCES `announcements` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_AnnouncementsDepartments_Departments`
  FOREIGN KEY (`department_id`)
  REFERENCES `departments` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- Employee AttendanceRecords
  ALTER TABLE `employee_attendance_records` 
ADD CONSTRAINT `FK_EmployeeAttendanceRecords_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- eventtasks
  ALTER TABLE `event_task` 
ADD CONSTRAINT `FK__EventTask__Event__729BEF18`
  FOREIGN KEY (`event_id`)
  REFERENCES `events` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK__EventTask__TaskI__73901351`
  FOREIGN KEY (`task_id`)
  REFERENCES `tasks` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- historydepartments
  ALTER TABLE `history_departments` 
ADD CONSTRAINT `FK_HistoryDepartments_Departments`
  FOREIGN KEY (`department_id`)
  REFERENCES `departments` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_HistoryDepartments_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- historydisciplinaryactions
  ALTER TABLE `history_disciplinary_actions` 
ADD CONSTRAINT `FK_HistoryDisciplinaryActions_DisciplinaryActions`
  FOREIGN KEY (`disciplinary_action_id`)
  REFERENCES `disciplinary_actions` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_HistoryDisciplinaryActions_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- historyjobtitles
  ALTER TABLE `history_job_titles` 
ADD CONSTRAINT `FK_HistoryJobTitles_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_HistoryJobTitles_JobTitles`
  FOREIGN KEY (`job_title_id`)
  REFERENCES `job_titles` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- historyJoinsTerminations
  ALTER TABLE `history_joins_terminations` 
ADD CONSTRAINT `FK_HistoryJoinsTerminations_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- historyrewards
  ALTER TABLE `history_rewards` 
ADD CONSTRAINT `FK_HistoryRewards_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_HistoryRewards_Rewards`
  FOREIGN KEY (`reward_id`)
  REFERENCES `rewards` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- ModuleAssessmentQuestions
  ALTER TABLE `module_assessment_questions` 
ADD CONSTRAINT `FK_ModuleAssessmentQuestions_ModuleAssessments`
  FOREIGN KEY (`module_assessment_id`)
  REFERENCES `module_assessments` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_ModuleAssessmentQuestions_ModuleQuestions`
  FOREIGN KEY (`module_question_id`)
  REFERENCES `module_questions` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- moduleassessmentresponsedetails
  ALTER TABLE `module_assessment_response_details` 
ADD CONSTRAINT `FK_ModuleAssessmentResponseDetails_ModuleAssessmentResponses`
  FOREIGN KEY (`module_assessment_response_id`)
  REFERENCES `module_assessment_responses` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_ModuleAssessmentResponseDetails_ModuleAssessments`
  FOREIGN KEY (`module_assessment_id`)
  REFERENCES `module_assessments` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_ModuleAssessmentResponseDetails_ModuleQuestions`
  FOREIGN KEY (`module_question_id`)
  REFERENCES `module_questions` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_ModuleAssessmentResponseDetails_Modules`
  FOREIGN KEY (`module_id`)
  REFERENCES `modules` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

#---- moduleassessmentresponses
ALTER TABLE `module_assessment_responses` 
ADD CONSTRAINT `FK_ModuleAssessmentResponses_Courses`
  FOREIGN KEY (`course_id`)
  REFERENCES `courses` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_ModuleAssessmentResponses_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_ModuleAssessmentResponses_ModuleAssessments`
  FOREIGN KEY (`module_assessment_id`)
  REFERENCES `module_assessments` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_ModuleAssessmentResponses_Modules`
  FOREIGN KEY (`module_id`)
  REFERENCES `modules` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
#----moduleassessments
ALTER TABLE `module_assessments` 
ADD CONSTRAINT `FK_ModuleAssessments_AssessmentTypes`
  FOREIGN KEY (`assessment_type_id`)
  REFERENCES `assessment_types` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_ModuleAssessments_Employees`
  FOREIGN KEY (`trainer_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_ModuleAssessments_Module`
  FOREIGN KEY (`module_id`)
  REFERENCES `modules` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;  
  
  #---- modulequestionchoices
  ALTER TABLE `module_question_choices` 
ADD CONSTRAINT `FK_ModuleQuestionChoices_ModuleQuestions`
  FOREIGN KEY (`module_question_id`)
  REFERENCES `module_questions` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- policydocuments
  ALTER TABLE `policy_documents` 
ADD CONSTRAINT `FK_PolicyDocuments_Policies`
  FOREIGN KEY (`policy_id`)
  REFERENCES `policies` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #----reporttemplates
  ALTER TABLE `report_templates` 
ADD CONSTRAINT `FK_ReportTemplates_SystemModules`
  FOREIGN KEY (`system_module_id`)
  REFERENCES `system_modules` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #----surveyresponses
  ALTER TABLE `survey_responses` 
ADD CONSTRAINT `FK_SurveyResponses_ShamUsers`
  FOREIGN KEY (`sham_user_id`)
  REFERENCES `sham_users` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_SurveyResponses_Surveys`
  FOREIGN KEY (`survey_id`)
  REFERENCES `surveys` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #----surveys
  ALTER TABLE `surveys` 
ADD CONSTRAINT `FK_Surveys_Forms`
  FOREIGN KEY (`form_id`)
  REFERENCES `forms` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Surveys_NotificationGroups`
  FOREIGN KEY (`notification_group_id`)
  REFERENCES `notification_groups` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Surveys_NotificationRecurrences`
  FOREIGN KEY (`notification_recurrence_id`)
  REFERENCES `notification_recurrences` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Surveys_ShamUsers`
  FOREIGN KEY (`author_sham_user_id`)
  REFERENCES `sham_users` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Surveys_SurveyStatuses`
  FOREIGN KEY (`survey_status_id`)
  REFERENCES `survey_statuses` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #----tasks
  ALTER TABLE `tasks` 
ADD CONSTRAINT `FK_Tasks_Departments`
  FOREIGN KEY (`department_id`)
  REFERENCES `departments` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


#---- timelines
ALTER TABLE `timelines` 
ADD CONSTRAINT `FK_Timelines_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_Timelines_TimelineEventTypes`
  FOREIGN KEY (`timeline_event_type_id`)
  REFERENCES `timeline_event_types` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- trainingsessionparticipants
  ALTER TABLE `employee_training_session` 
ADD CONSTRAINT `FK_TrainingSessionParticipants_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_TrainingSessionParticipants_TrainingSessions`
  FOREIGN KEY (`training_session_id`)
  REFERENCES `training_sessions` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #----
  ALTER TABLE `sham_users` 
ADD CONSTRAINT `FK_ShamUsers_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #---- telephonenumbers/telephone_numbers
  ALTER TABLE `telephone_numbers` 
ADD CONSTRAINT `FK_TelephoneNumbers_Employees`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_TelephoneNumbers_TelephoneNumberTypes`
  FOREIGN KEY (`telephone_number_type_id`)
  REFERENCES `telephone_number_types` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  #----shamuserprofile_shampermission
  ALTER TABLE `sham_permission_sham_user_profile_system_sub_module` 
ADD CONSTRAINT `FK_ShamUserProfilesSubModulePermissions_ShamPermissions`
  FOREIGN KEY (`sham_permission_id`)
  REFERENCES `sham_permissions` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_ShamUserProfilesSubModulePermissions_ShamUserProfiles`
  FOREIGN KEY (`sham_user_profile_id`)
  REFERENCES `sham_user_profiles` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_ShamUserProfilesSubModulePermissions_SystemSubModules`
  FOREIGN KEY (`system_sub_module_id`)
  REFERENCES `system_sub_modules` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

#--- add index on evaluation_results  
ALTER TABLE `evaluation_results` 
ADD INDEX `IX_EvaluationResults_evaluation_accessor` (`evaluation_id` ASC, `assessoremployee_id` ASC);

#--- Added on 20-09-2018
ALTER TABLE `laws` 
ADD INDEX `IX_laws_deleted_at` (`deleted_at` DESC);

ALTER TABLE `announcements`
DROP FOREIGN KEY `FK_Announcements_AnnouncementStatuses`;

ALTER TABLE `announcements`
DROP INDEX `FK_Announcements_AnnouncementStatuses`;

ALTER TABLE `announcements`
CHANGE COLUMN `announcement_status_id` `announcement_status_id` ENUM('1', '2') NOT NULL DEFAULT '1' COMMENT '1 - Enabled, 2 - Disabled' ;

#---- Added on 24/09/2018

ALTER TABLE `course_module`
ADD CONSTRAINT `FK_CourseModules_Course`
  FOREIGN KEY (`course_id`)
  REFERENCES `courses` (`Id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_CourseModules_Module`
  FOREIGN KEY (`module_id`)
  REFERENCES `modules` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


  ALTER TABLE `email_addresses`
ADD CONSTRAINT `FK_EmailAddresses_EmailAddressTypes`
FOREIGN KEY (`email_address_type_id`)
REFERENCES `email_address_types` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_EmailAddresses_Employees`
FOREIGN KEY (`employee_id`)
REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `shamdev`.`employees`
ADD CONSTRAINT `FK_Employees_JobTitles`
  FOREIGN KEY (`job_title_id`)
  REFERENCES `shamdev`.`job_titles` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;