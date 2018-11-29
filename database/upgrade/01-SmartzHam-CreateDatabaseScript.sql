-- ----------------------------------------------------------------------------
-- MySQL Workbench Migration
-- Migrated Schemata: shamtest
-- Source Schemata: shamtest
-- Created: Sat Aug 25 11:54:31 2018
-- Workbench Version: 6.3.10
-- ----------------------------------------------------------------------------


SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------------------------
-- Schema 
-- ----------------------------------------------------------------------------
DROP SCHEMA IF EXISTS `Shamuat` ;
CREATE SCHEMA IF NOT EXISTS `Shamuat` ;

USE `Shamdev`;
-- ----------------------------------------------------------------------------
-- Table Recurrences
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Recurrences` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Days` INT NOT NULL DEFAULT 1,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table EntityProperties
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `EntityProperties` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `TableName` VARCHAR(100) NOT NULL,
  `ColumnName` VARCHAR(100) NOT NULL,
  `DataType` VARCHAR(100) NOT NULL,
  `MaxLength` INT NOT NULL,
  `AllowDBNull` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ReportTemplates
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ReportTemplates` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Source` VARCHAR(200) NOT NULL,
  `SystemModuleId` INT NULL,
  `Order` INT NULL,
  `Title` VARCHAR(100) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_ReportTemplates_SystemModules`
    FOREIGN KEY (`SystemModuleId`)
    REFERENCES `SystemModules` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table EthnicGroups
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `EthnicGroups` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Rewards
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Rewards` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `Description` LONGTEXT NOT NULL,
  `RewardedBy` VARCHAR(100) NOT NULL,
  `DateReceived` DATETIME(6) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Rewards_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table EvaluationAssessors
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `EvaluationAssessors` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EvaluationId` INT NOT NULL,
  `EmployeeId` INT NOT NULL,
  `Completed` TINYINT(1) NOT NULL DEFAULT 0,
  `Summary` LONGTEXT NULL,
  `Comments` LONGTEXT NULL,
  `StartTime` DATETIME(6) NULL,
  `EndTime` DATETIME(6) NULL,
  `Duration` INT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_EvaluationAssessors_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_EvaluationAssessors_Evaluations`
    FOREIGN KEY (`EvaluationId`)
    REFERENCES `Evaluations` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Roles
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Roles` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `WorkflowId` INT NOT NULL,
  `Name` VARCHAR(100) NOT NULL,
  `ShamUserId` INT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Roles_ShamUsers`
    FOREIGN KEY (`ShamUserId`)
    REFERENCES `ShamUsers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Roles_Workflows`
    FOREIGN KEY (`WorkflowId`)
    REFERENCES `Workflows` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table EvaluationResults
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `EvaluationResults` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EvaluationId` INT NOT NULL,
  `AssessorEmployeeId` INT NOT NULL,
  `AssessmentId` INT NOT NULL,
  `AssessmentCategoryId` INT NOT NULL,
  `CategoryQuestionId` INT NOT NULL,
  `Content` LONGTEXT NOT NULL,
  `Points` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_EvaluationResults_AssessmentCategories`
    FOREIGN KEY (`AssessmentCategoryId`)
    REFERENCES `AssessmentCategories` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_EvaluationResults_Assessments`
    FOREIGN KEY (`AssessmentId`)
    REFERENCES `Assessments` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_EvaluationResults_CategoryQuestions`
    FOREIGN KEY (`CategoryQuestionId`)
    REFERENCES `CategoryQuestions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_EvaluationResults_Employees`
    FOREIGN KEY (`AssessorEmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_EvaluationResults_Evaluations`
    FOREIGN KEY (`EvaluationId`)
    REFERENCES `Evaluations` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ShamPermissions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ShamPermissions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  `Alias` VARCHAR(100) NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Evaluations
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evaluations` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `AssessmentId` INT NOT NULL,
  `UserEmployeeId` INT NOT NULL,
  `DepartmentId` INT NOT NULL,
  `ReferenceNo` VARCHAR(200) NULL,
  `ReferenceSource` VARCHAR(200) NULL,
  `ProductCategoryId` INT NULL,
  `LanguageId` INT NULL,
  `FeedbackDate` DATETIME(6) NOT NULL,
  `QaSample` LONGBLOB NULL,
  `Comments` VARCHAR(512) NULL,
  `EvaluationStatusId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  `CreatedByEmployeeId` INT NULL,
  `OriginalFileName` VARCHAR(256) NULL,
  `UseContent` TINYINT(1) NULL,
  `UrlPath` VARCHAR(256) NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Evaluations_Assessments`
    FOREIGN KEY (`AssessmentId`)
    REFERENCES `Assessments` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Evaluations_Departments`
    FOREIGN KEY (`DepartmentId`)
    REFERENCES `Departments` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Evaluations_Employees`
    FOREIGN KEY (`UserEmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Evaluations_Employees1`
    FOREIGN KEY (`CreatedByEmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Evaluations_EvaluationStatuses`
    FOREIGN KEY (`EvaluationStatusId`)
    REFERENCES `EvaluationStatuses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Evaluations_Languages`
    FOREIGN KEY (`LanguageId`)
    REFERENCES `Languages` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Evaluations_ProductCategories`
    FOREIGN KEY (`ProductCategoryId`)
    REFERENCES `ProductCategories` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ShamSessions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ShamSessions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ShamUserId` INT NOT NULL,
  `Token` VARCHAR(100) NOT NULL,
  `DateCreated` DATETIME(6) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_ShamSessions_ShamUsers`
    FOREIGN KEY (`ShamUserId`)
    REFERENCES `ShamUsers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table EvaluationStatuses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `EvaluationStatuses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ShamUserProfiles
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ShamUserProfiles` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Events
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Events` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NOT NULL,
  `Description` VARCHAR(100) NULL,
  `SystemEvent` TINYINT(1) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ShamUserProfilesSubModulePermissions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ShamUserProfilesSubModulePermissions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ShamUserProfileId` INT NOT NULL,
  `ShamPermissionId` INT NOT NULL,
  `SystemSubModuleId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_ShamUserProfilesSubModulePermissions_ShamPermissions`
    FOREIGN KEY (`ShamPermissionId`)
    REFERENCES `ShamPermissions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ShamUserProfilesSubModulePermissions_ShamUserProfiles`
    FOREIGN KEY (`ShamUserProfileId`)
    REFERENCES `ShamUserProfiles` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ShamUserProfilesSubModulePermissions_SystemSubModules`
    FOREIGN KEY (`SystemSubModuleId`)
    REFERENCES `SystemSubModules` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table EventTaskInstances
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `EventTaskInstances` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EventTaskId` INT NOT NULL,
  `EmployeeCreatedId` INT NOT NULL,
  `DateTimeCreated` DATETIME(6) NOT NULL,
  `DueDate` DATETIME(6) NULL,
  `Completed` TINYINT(1) NULL,
  `LinkTypeId` INT NULL,
  `TargetId` INT NULL,
  `Comment` VARCHAR(250) NULL,
  `EmployeeAllocatedId` INT NULL,
  `DateTimeCompleted` DATETIME(6) NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK__EventTask__Emplo__7948ECA7`
    FOREIGN KEY (`EmployeeCreatedId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK__EventTask__Emplo__7C255952`
    FOREIGN KEY (`EmployeeAllocatedId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK__EventTask__Event__7854C86E`
    FOREIGN KEY (`EventTaskId`)
    REFERENCES `EventTasks` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK__EventTask__LinkT__7A3D10E0`
    FOREIGN KEY (`LinkTypeId`)
    REFERENCES `LinkTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK__EventTask__Targe__7B313519`
    FOREIGN KEY (`TargetId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Addresses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Addresses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `UnitNo` VARCHAR(50) NULL,
  `Complex` VARCHAR(50) NULL,
  `AddrLine1` VARCHAR(50) NULL,
  `AddrLine2` VARCHAR(50) NULL,
  `AddrLine3` VARCHAR(50) NULL,
  `AddrLine4` VARCHAR(50) NULL,
  `City` VARCHAR(50) NULL,
  `Province` VARCHAR(50) NULL,
  `CountryId` INT NULL,
  `ZipCode` VARCHAR(50) NULL,
  `AddressTypeId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Addresses_AddressTypes`
    FOREIGN KEY (`AddressTypeId`)
    REFERENCES `AddressTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Addresses_Countries`
    FOREIGN KEY (`CountryId`)
    REFERENCES `Countries` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Addresses_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ShamUsers
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ShamUsers` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(100) NOT NULL,
  `Password` VARCHAR(100) NULL,
  `ShamUserProfileId` INT NULL,
  `EmailAddress` VARCHAR(512) NULL,
  `CellNumber` VARCHAR(20) NULL,
  `EmailNotify` TINYINT(1) NOT NULL DEFAULT 1,
  `SmsNotify` TINYINT(1) NOT NULL DEFAULT 1,
  `PushNotify` TINYINT(1) NOT NULL DEFAULT 1,
  `SilenceStart` TIME(6) NULL,
  `SilenceEnd` TIME(6) NULL,
  `EmployeeId` INT NULL,
  `DateCreated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  `RememberToken` VARCHAR(100) NULL,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `IX_ShamUsers` (`Username` ASC),
  CONSTRAINT `FK_ShamUsers_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ShamUsers_ShamUserProfiles`
    FOREIGN KEY (`ShamUserProfileId`)
    REFERENCES `ShamUserProfiles` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table EventTasks
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `EventTasks` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EventId` INT NOT NULL,
  `TaskId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK__EventTask__Event__729BEF18`
    FOREIGN KEY (`EventId`)
    REFERENCES `Events` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK__EventTask__TaskI__73901351`
    FOREIGN KEY (`TaskId`)
    REFERENCES `Tasks` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table AddressTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `AddressTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Skills
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Skills` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Forms
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Forms` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `Data` LONGTEXT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table AdvanceMethods
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `AdvanceMethods` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table SuggestionComments
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `SuggestionComments` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `SuggestionId` INT NOT NULL,
  `Comment` VARCHAR(512) NOT NULL,
  `Date` DATETIME(6) NOT NULL,
  `MadeByShamUserId` INT NOT NULL,
  `Approved` TINYINT(1) NOT NULL DEFAULT 0,
  `ApprovedByShamUserId` INT NULL,
  `ApprovedDate` DATETIME(6) NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_SuggestionComments_ShamUsers`
    FOREIGN KEY (`MadeByShamUserId`)
    REFERENCES `ShamUsers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_SuggestionComments_ShamUsers1`
    FOREIGN KEY (`ApprovedByShamUserId`)
    REFERENCES `ShamUsers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_SuggestionComments_Suggestions`
    FOREIGN KEY (`SuggestionId`)
    REFERENCES `Suggestions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Genders
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Genders` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Announcements
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Announcements` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(256) NOT NULL,
  `StartDate` DATETIME(6) NOT NULL,
  `EndDate` DATETIME(6) NOT NULL,
  `Priority` TINYINT UNSIGNED NOT NULL,
  `AnnouncementStatusId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Announcements_AnnouncementStatuses`
    FOREIGN KEY (`AnnouncementStatusId`)
    REFERENCES `AnnouncementStatuses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Suggestions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Suggestions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(512) NOT NULL,
  `Private` TINYINT(1) NOT NULL DEFAULT 0,
  `AuthorShamUserId` INT NOT NULL,
  `SuggestionStatusId` INT NOT NULL,
  `ReviewerShamUserId` INT NULL,
  `Date` DATETIME(6) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Suggestions_ShamUsers`
    FOREIGN KEY (`AuthorShamUserId`)
    REFERENCES `ShamUsers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Suggestions_ShamUsers1`
    FOREIGN KEY (`ReviewerShamUserId`)
    REFERENCES `ShamUsers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Suggestions_SuggestionStatuses`
    FOREIGN KEY (`SuggestionStatusId`)
    REFERENCES `SuggestionStatuses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table HistoryDepartments
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `HistoryDepartments` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `DepartmentId` INT NOT NULL,
  `Date` DATETIME(6) NOT NULL,
  `UpdatedBy` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_HistoryDepartments_Departments`
    FOREIGN KEY (`DepartmentId`)
    REFERENCES `Departments` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_HistoryDepartments_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table AnnouncementsDepartments
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `AnnouncementsDepartments` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `AnnouncementId` INT NOT NULL,
  `DepartmentId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_AnnouncementsDepartments_Announcements`
    FOREIGN KEY (`AnnouncementId`)
    REFERENCES `Announcements` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_AnnouncementsDepartments_Departments`
    FOREIGN KEY (`DepartmentId`)
    REFERENCES `Departments` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table SuggestionStatuses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `SuggestionStatuses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table HistoryDisciplinaryActions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `HistoryDisciplinaryActions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `DisciplinaryActionId` INT NOT NULL,
  `Date` DATETIME(6) NOT NULL,
  `UpdatedBy` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_HistoryDisciplinaryActions_DisciplinaryActions`
    FOREIGN KEY (`DisciplinaryActionId`)
    REFERENCES `DisciplinaryActions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_HistoryDisciplinaryActions_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table AnnouncementStatuses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `AnnouncementStatuses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table SurveyResponses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `SurveyResponses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ShamUserId` INT NOT NULL,
  `Response` LONGTEXT NOT NULL,
  `Date` DATETIME(6) NOT NULL,
  `SurveyId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_SurveyResponses_ShamUsers`
    FOREIGN KEY (`ShamUserId`)
    REFERENCES `ShamUsers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_SurveyResponses_Surveys`
    FOREIGN KEY (`SurveyId`)
    REFERENCES `Surveys` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table HistoryJobTitles
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `HistoryJobTitles` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `JobTitleId` INT NOT NULL,
  `Date` DATETIME(6) NOT NULL,
  `UpdatedBy` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_HistoryJobTitles_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_HistoryJobTitles_JobTitles`
    FOREIGN KEY (`JobTitleId`)
    REFERENCES `JobTitles` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Applicants
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Applicants` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `TitleId` INT NULL,
  `FirstName` VARCHAR(50) NULL,
  `Initials` VARCHAR(10) NULL,
  `Surname` VARCHAR(50) NULL,
  `GenderId` INT NULL,
  `DateOfBirth` DATETIME NULL,
  `IdNumber` VARCHAR(50) NULL,
  `MaritalStatusId` INT NULL,
  `LanguageId` INT NULL,
  `AdditionalInformation` VARCHAR(512) NULL,
  `FileAttachmentName` VARCHAR(100) NULL,
  `FileAttchment` LONGTEXT NULL,
  `Telephone` VARCHAR(20) NULL,
  `Mobile` VARCHAR(20) NULL,
  `Email` VARCHAR(128) NULL,
  `UnitNo` VARCHAR(10) NULL,
  `Complex` VARCHAR(100) NULL,
  `AddressLine1` VARCHAR(100) NULL,
  `AddressLine2` VARCHAR(100) NULL,
  `AddressLine3` VARCHAR(100) NULL,
  `AddressLine4` VARCHAR(100) NULL,
  `City` VARCHAR(100) NULL,
  `Country` VARCHAR(100) NULL,
  `Province` VARCHAR(100) NULL,
  `ZipCode` VARCHAR(10) NULL,
  `BackGroundChecked` TINYINT(1) NULL,
  `BackgroundCheckedBy` VARCHAR(100) NULL,
  `BackGroundCheckedDate` DATETIME(6) NULL,
  `BackGroundCheckDetails` VARCHAR(1024) NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Applicants_Genders`
    FOREIGN KEY (`GenderId`)
    REFERENCES `Genders` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Applicants_Languages`
    FOREIGN KEY (`LanguageId`)
    REFERENCES `Languages` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Applicants_Titles`
    FOREIGN KEY (`TitleId`)
    REFERENCES `Titles` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Surveys
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Surveys` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(100) NOT NULL,
  `StartDate` DATETIME(6) NOT NULL,
  `EndDate` DATETIME(6) NOT NULL,
  `NotificationRecurrenceId` INT NOT NULL,
  `NotificationGroupId` INT NOT NULL,
  `FormId` INT NOT NULL,
  `Final` TINYINT(1) NOT NULL DEFAULT 0,
  `AuthorShamUserId` INT NOT NULL,
  `SurveyStatusId` INT NOT NULL DEFAULT 0,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Surveys_Forms`
    FOREIGN KEY (`FormId`)
    REFERENCES `Forms` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Surveys_NotificationGroups`
    FOREIGN KEY (`NotificationGroupId`)
    REFERENCES `NotificationGroups` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Surveys_NotificationRecurrences`
    FOREIGN KEY (`NotificationRecurrenceId`)
    REFERENCES `NotificationRecurrences` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Surveys_ShamUsers`
    FOREIGN KEY (`AuthorShamUserId`)
    REFERENCES `ShamUsers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Surveys_SurveyStatuses`
    FOREIGN KEY (`SurveyStatusId`)
    REFERENCES `SurveyStatuses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table HistoryJoinsTerminations
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `HistoryJoinsTerminations` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `Joined` TINYINT(1) NOT NULL,
  `Date` DATETIME(6) NOT NULL,
  `UpdatedBy` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_HistoryJoinsTerminations_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Applications
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Applications` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ApplicantId` INT NOT NULL,
  `VacancyId` INT NOT NULL,
  `Date` DATETIME(6) NOT NULL,
  `Retained` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Applications_Applicants`
    FOREIGN KEY (`ApplicantId`)
    REFERENCES `Applicants` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Applications_Vacancies`
    FOREIGN KEY (`VacancyId`)
    REFERENCES `Vacancies` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table SurveyStatuses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `SurveyStatuses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table HistoryQualifications
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `HistoryQualifications` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `QualificationId` INT NOT NULL,
  `Date` DATETIME(6) NOT NULL,
  `UpdatedBy` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_HistoryQualifications_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_HistoryQualifications_Qualifications`
    FOREIGN KEY (`QualificationId`)
    REFERENCES `Qualifications` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ApplicationTestForms
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ApplicationTestForms` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `VacancyId` INT NOT NULL,
  `Description` VARCHAR(100) NULL,
  `Data` LONGTEXT NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table SysConfigValues
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `SysConfigValues` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Key` VARCHAR(50) NOT NULL,
  `Value` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table HistoryRewards
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `HistoryRewards` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `RewardId` INT NOT NULL,
  `Date` DATETIME(6) NOT NULL,
  `UpdatedBy` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_HistoryRewards_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_HistoryRewards_Rewards`
    FOREIGN KEY (`RewardId`)
    REFERENCES `Rewards` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ApplicationTests
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ApplicationTests` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ApplicantId` INT NOT NULL,
  `Date` DATE NOT NULL,
  `Time` TIME(6) NOT NULL,
  `Duration` DECIMAL(19,4) NOT NULL,
  `Description` VARCHAR(100) NULL,
  `ApplicationTestTypeId` INT NOT NULL,
  `InternalTestId` VARCHAR(20) NULL,
  `TestProvider` VARCHAR(100) NULL,
  `Venue` VARCHAR(100) NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_ApplicationTests_Applicants`
    FOREIGN KEY (`ApplicantId`)
    REFERENCES `Applicants` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ApplicationTests_ApplicationTestTypes`
    FOREIGN KEY (`ApplicationTestTypeId`)
    REFERENCES `ApplicationTestTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table SystemModules
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `SystemModules` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ImmigrationStatuses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ImmigrationStatuses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ApplicationTestTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ApplicationTestTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table SystemSubModules
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `SystemSubModules` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `SystemModuleId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_SystemSubModules_SystemModules`
    FOREIGN KEY (`SystemModuleId`)
    REFERENCES `SystemModules` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table InterviewForms
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `InterviewForms` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `VacancyId` INT NOT NULL,
  `Description` VARCHAR(100) NULL,
  `Data` LONGTEXT NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_InterviewForms_Vacancies`
    FOREIGN KEY (`VacancyId`)
    REFERENCES `Vacancies` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table AssessmentCategories
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `AssessmentCategories` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(1024) NOT NULL,
  `Description` VARCHAR(1024) NOT NULL,
  `ELearningModule` VARCHAR(100) NOT NULL,
  `Threshold` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  `PassmarkPercentage` DOUBLE NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TaskCategories
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TaskCategories` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(100) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Interviews
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Interviews` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ApplicantId` INT NOT NULL,
  `Date` DATE NOT NULL,
  `Time` TIME(6) NOT NULL,
  `Duration` DECIMAL(19,4) NOT NULL,
  `Venue` VARCHAR(100) NULL,
  `Attendees` VARCHAR(100) NULL,
  `SelectionCriteria` LONGTEXT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Interviews_Applicants`
    FOREIGN KEY (`ApplicantId`)
    REFERENCES `Applicants` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table AssessmentCategoriesCategoryQuestions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `AssessmentCategoriesCategoryQuestions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `AssessmentCategoryId` INT NOT NULL,
  `CategoryQuestionId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_AssessmentCategoriesCategoryQuestions_AssessmentCategories`
    FOREIGN KEY (`AssessmentCategoryId`)
    REFERENCES `AssessmentCategories` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_AssessmentCategoriesCategoryQuestions_CategoryQuestions`
    FOREIGN KEY (`CategoryQuestionId`)
    REFERENCES `CategoryQuestions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Tasks
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Tasks` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NOT NULL,
  `Description` VARCHAR(100) NULL,
  `Priority` INT NOT NULL,
  `Duration` INT NULL,
  `DepartmentId` INT NULL,
  `SystemTask` TINYINT(1) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Tasks_Departments`
    FOREIGN KEY (`DepartmentId`)
    REFERENCES `Departments` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table JobAdverts
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `JobAdverts` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `VacancyId` INT NOT NULL,
  `IssueDate` DATETIME(6) NULL,
  `Provider` VARCHAR(100) NULL,
  `Days` INT NULL,
  `Verified` TINYINT(1) NOT NULL,
  `AttachmentName` VARCHAR(100) NULL,
  `Attachment` LONGTEXT NULL,
  `VerifiedDate` DATETIME(6) NULL,
  `VerifiedBy` VARCHAR(100) NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_JobAdverts_Vacancies`
    FOREIGN KEY (`VacancyId`)
    REFERENCES `Vacancies` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Assessments
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Assessments` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(1024) NOT NULL,
  `Description` VARCHAR(1024) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  `PassmarkPercentage` DOUBLE NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TaxStatuses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TaxStatuses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table JobTitles
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `JobTitles` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Manager` TINYINT(1) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table AssessmentsAssessmentCategories
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `AssessmentsAssessmentCategories` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `AssessmentId` INT NOT NULL,
  `AssessmentCategoryId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_AssessmentsAssessmentCategories_AssessmentCategories`
    FOREIGN KEY (`AssessmentCategoryId`)
    REFERENCES `AssessmentCategories` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_AssessmentsAssessmentCategories_Assessments`
    FOREIGN KEY (`AssessmentId`)
    REFERENCES `Assessments` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Teams
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Teams` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  `TimeGroupId` INT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Teams_TimeGroups`
    FOREIGN KEY (`TimeGroupId`)
    REFERENCES `TimeGroups` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Languages
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Languages` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  `Preferred` TINYINT(1) NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table AssessmentTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `AssessmentTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TeamsProducts
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TeamsProducts` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `TeamId` INT NOT NULL,
  `ProductId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_TeamsProducts_Products`
    FOREIGN KEY (`ProductId`)
    REFERENCES `Products` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TeamsProducts_Teams`
    FOREIGN KEY (`TeamId`)
    REFERENCES `Teams` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table LawCategories
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `LawCategories` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table AssetAllocations
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `AssetAllocations` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `AssetId` INT NOT NULL,
  `EmployeeId` INT NOT NULL,
  `DateOut` DATETIME(6) NOT NULL,
  `DateIn` DATETIME(6) NULL,
  `Comment` VARCHAR(1024) NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_AssetAllocations_Assets`
    FOREIGN KEY (`AssetId`)
    REFERENCES `Assets` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_AssetAllocations_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TelephoneNumbers
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TelephoneNumbers` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `TelNumber` VARCHAR(20) NOT NULL,
  `TelephoneNumberTypeId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_TelephoneNumbers_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TelephoneNumbers_TelephoneNumberTypes`
    FOREIGN KEY (`TelephoneNumberTypeId`)
    REFERENCES `TelephoneNumberTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table AssetConditions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `AssetConditions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TelephoneNumberTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TelephoneNumberTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Laws
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Laws` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `MainHeading` VARCHAR(100) NULL,
  `SubHeading` VARCHAR(100) NULL,
  `CountryId` INT NULL,
  `LawCategoryId` INT NULL,
  `Content` LONGTEXT NOT NULL,
  `Public` TINYINT(1) NULL,
  `UpdatedBy` VARCHAR(100) NULL,
  `UpdatedWhen` DATETIME(6) NULL,
  `ExpiryDate` DATETIME(6) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Laws_Countries`
    FOREIGN KEY (`CountryId`)
    REFERENCES `Countries` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Laws_LawCategories`
    FOREIGN KEY (`LawCategoryId`)
    REFERENCES `LawCategories` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table AssetGroups
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `AssetGroups` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TemporaryJobs
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TemporaryJobs` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `JobTitleId` INT NOT NULL,
  `JobDescription` LONGTEXT NOT NULL,
  `StartDate` DATETIME(6) NOT NULL,
  `EndDate` DATETIME(6) NOT NULL,
  `RatePerHour` DECIMAL(19,4) NOT NULL,
  `EmployeeStatusId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_TemporaryJobs_EmployeeStatuses`
    FOREIGN KEY (`EmployeeStatusId`)
    REFERENCES `EmployeeStatuses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TemporaryJobs_JobTitles`
    FOREIGN KEY (`JobTitleId`)
    REFERENCES `JobTitles` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table LearningMaterials
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `LearningMaterials` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ModuleId` INT NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `LearningMaterialTypeId` INT NOT NULL,
  `Content` LONGTEXT NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_LearningMaterials_LearningMaterialTypes`
    FOREIGN KEY (`LearningMaterialTypeId`)
    REFERENCES `LearningMaterialTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_LearningMaterials_Modules`
    FOREIGN KEY (`ModuleId`)
    REFERENCES `Modules` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Assets
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Assets` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NOT NULL,
  `AssetGroupId` INT NOT NULL,
  `AssetSupplierId` INT NOT NULL,
  `Tag` VARCHAR(50) NOT NULL,
  `SerialNo` VARCHAR(20) NOT NULL,
  `PurchasePrice` DECIMAL(19,4) NOT NULL,
  `PoNumber` VARCHAR(20) NOT NULL,
  `WarrantyExpiryDate` DATETIME(6) NOT NULL,
  `AssetConditionId` INT NOT NULL,
  `Comments` VARCHAR(256) NOT NULL,
  `Available` TINYINT(1) NOT NULL DEFAULT 1,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Assets_AssetConditions`
    FOREIGN KEY (`AssetConditionId`)
    REFERENCES `AssetConditions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Assets_AssetGroups`
    FOREIGN KEY (`AssetGroupId`)
    REFERENCES `AssetGroups` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Assets_Suppliers`
    FOREIGN KEY (`AssetSupplierId`)
    REFERENCES `AssetSuppliers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ThreadStatuses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ThreadStatuses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(300) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table LearningMaterialTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `LearningMaterialTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table AssetSuppliers
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `AssetSuppliers` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NOT NULL,
  `Address1` VARCHAR(100) NULL,
  `Address2` VARCHAR(100) NULL,
  `Address3` VARCHAR(100) NULL,
  `Address4` VARCHAR(100) NULL,
  `Telephone` VARCHAR(20) NULL,
  `EmailAddress` VARCHAR(512) NULL,
  `Comments` VARCHAR(256) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TimeGroupDays
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TimeGroupDays` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `TimeGroupId` INT NOT NULL,
  `DayId` INT NOT NULL,
  `TimePeriodId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_TimeGroupDays_Days`
    FOREIGN KEY (`DayId`)
    REFERENCES `Days` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TimeGroupDays_TimeGroups`
    FOREIGN KEY (`TimeGroupId`)
    REFERENCES `TimeGroups` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TimeGroupDays_TimePeriods`
    FOREIGN KEY (`TimePeriodId`)
    REFERENCES `TimePeriods` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table LeaveApplicationForms
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `LeaveApplicationForms` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `Paid` TINYINT(1) NOT NULL,
  `DaysDue` INT NOT NULL,
  `DayRequired` INT NOT NULL,
  `FirstDayOfLeave` DATETIME(6) NOT NULL,
  `LastDayOfLeave` DATETIME(6) NOT NULL,
  `LeaveTypeId` INT NOT NULL,
  `Granted` TINYINT(1) NULL,
  `ReasonNotGranted` VARCHAR(512) NULL,
  `Authorised` TINYINT(1) NULL,
  `SickNoteAttached` TINYINT(1) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_LeaveApplicationForms_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_LeaveApplicationForms_LeaveTypes`
    FOREIGN KEY (`LeaveTypeId`)
    REFERENCES `LeaveTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table BankAccountTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `BankAccountTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TimeGroups
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TimeGroups` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  `StartTime` TIME(6) NULL,
  `EndTime` TIME(6) NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table LeaveApplications
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `LeaveApplications` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `Date` DATETIME(6) NOT NULL,
  `ManagerId` INT NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table BankingDetails
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `BankingDetails` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `Bank` VARCHAR(100) NOT NULL,
  `BranchCode` VARCHAR(20) NOT NULL,
  `AccountNumber` VARCHAR(20) NOT NULL,
  `AccountHolderName` VARCHAR(100) NOT NULL,
  `AccountHolderRelation` VARCHAR(100) NOT NULL,
  `Account` CHAR(10) CHARACTER SET 'utf8mb4' NOT NULL,
  `BankAccountTypeId` INT NOT NULL,
  `SwiftCode` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_BankingDetails_BankAccountTypes`
    FOREIGN KEY (`BankAccountTypeId`)
    REFERENCES `BankAccountTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_BankingDetails_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TimelineEventTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TimelineEventTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(100) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table LeaveDays
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `LeaveDays` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `LeaveApplicationId` INT NOT NULL,
  `LeaveTypeId` INT NOT NULL,
  `LeaveDate` DATETIME(6) NOT NULL,
  `Paid` TINYINT(1) NOT NULL,
  `Approved` TINYINT(1) NULL,
  `ApprovedBy` INT NULL,
  `Cancelled` TINYINT(1) NULL,
  `CancelledBy` INT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_LeaveDays_LeaveApplications`
    FOREIGN KEY (`LeaveApplicationId`)
    REFERENCES `LeaveApplications` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_LeaveDays_LeaveTypes`
    FOREIGN KEY (`LeaveTypeId`)
    REFERENCES `LeaveTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Branches
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Branches` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `CompanyId` INT NOT NULL,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Branches_Companies1`
    FOREIGN KEY (`CompanyId`)
    REFERENCES `Companies` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Timelines
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Timelines` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `TimelineEventTypeId` INT NOT NULL,
  `EventId` CHAR(10) CHARACTER SET 'utf8mb4' NULL,
  `EventDate` DATETIME(6) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Timelines_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Timelines_TimelineEventTypes`
    FOREIGN KEY (`TimelineEventTypeId`)
    REFERENCES `TimelineEventTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table LeaveScheduleItems
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `LeaveScheduleItems` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `LeaveScheduleId` INT NOT NULL,
  `LeaveTypeId` INT NOT NULL,
  `YearlyEntitlement` INT NOT NULL,
  `YearlyCarriedOver` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_LeaveScheduleItems_LeaveSchedules`
    FOREIGN KEY (`LeaveScheduleId`)
    REFERENCES `LeaveSchedules` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_LeaveScheduleItems_LeaveTypes`
    FOREIGN KEY (`LeaveTypeId`)
    REFERENCES `LeaveTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Buildings
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Buildings` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NOT NULL,
  `Addr1` VARCHAR(100) NULL,
  `Addr2` VARCHAR(100) NULL,
  `Addr3` VARCHAR(100) NULL,
  `Addr4` VARCHAR(100) NULL,
  `ContactTelephone` VARCHAR(20) NULL,
  `ContactPerson` VARCHAR(100) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TimePeriods
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TimePeriods` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `StartTime` TIME(6) NOT NULL,
  `EndTime` TIME(6) NOT NULL,
  `TimePeriodType` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table LeaveSchedules
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `LeaveSchedules` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `DateCreated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table CalendarEvents
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `CalendarEvents` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `CalendarParentEventsId` INT NOT NULL,
  `Title` VARCHAR(100) NOT NULL,
  `Description` VARCHAR(256) NOT NULL,
  `StartDate` DATETIME(6) NOT NULL,
  `EndDate` DATETIME(6) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_CalendarEvents_CalendarParentEvents`
    FOREIGN KEY (`CalendarParentEventsId`)
    REFERENCES `CalendarParentEvents` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Titles
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Titles` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table LeaveTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `LeaveTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table CalendarParentEvents
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `CalendarParentEvents` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(100) NOT NULL,
  `Description` VARCHAR(256) NOT NULL,
  `StartDate` DATETIME(6) NOT NULL,
  `EndDate` DATETIME(6) NOT NULL,
  `Weekday` INT NULL,
  `Repeats` TINYINT(1) NULL DEFAULT 0,
  `RepeatFrequency` INT NULL,
  `AllDay` TINYINT(1) NULL DEFAULT 0,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TopicAttachments
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TopicAttachments` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `TopicId` INT NOT NULL,
  `LearningMaterialTypeId` INT NOT NULL,
  `Content` LONGTEXT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  `Comment` VARCHAR(100) NULL,
  `OriginalFileName` VARCHAR(512) NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_TopicAttachments_LearningMaterialTypes`
    FOREIGN KEY (`LearningMaterialTypeId`)
    REFERENCES `LearningMaterialTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TopicAttachments_Topics`
    FOREIGN KEY (`TopicId`)
    REFERENCES `Topics` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table LinkTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `LinkTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table CategoryQuestionChoices
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `CategoryQuestionChoices` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `CategoryQuestionId` INT NOT NULL,
  `ChoiceText` LONGTEXT NOT NULL,
  `Points` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_CategoryQuestionChoices_CategoryQuestions2`
    FOREIGN KEY (`CategoryQuestionId`)
    REFERENCES `CategoryQuestions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Topics
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Topics` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Header` VARCHAR(300) NOT NULL,
  `Description` VARCHAR(300) NULL,
  `Data` LONGTEXT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table MaritalStatuses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `MaritalStatuses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table CategoryQuestions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `CategoryQuestions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `CategoryQuestionTypeId` INT NOT NULL,
  `Title` VARCHAR(1024) NOT NULL,
  `Description` VARCHAR(1024) NULL,
  `Points` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  `ZeroMark` TINYINT(1) NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_CategoryQuestions_CategoryQuestionTypes`
    FOREIGN KEY (`CategoryQuestionTypeId`)
    REFERENCES `CategoryQuestionTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TrainingDeliveryMethods
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrainingDeliveryMethods` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ModuleAssessmentQuestions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ModuleAssessmentQuestions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ModuleAssessmentId` INT NOT NULL,
  `ModuleQuestionId` INT NOT NULL,
  `Sequence` INT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_ModuleAssessmentQuestions_ModuleAssessments`
    FOREIGN KEY (`ModuleAssessmentId`)
    REFERENCES `ModuleAssessments` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ModuleAssessmentQuestions_ModuleQuestions`
    FOREIGN KEY (`ModuleQuestionId`)
    REFERENCES `ModuleQuestions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table CategoryQuestionTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `CategoryQuestionTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TrainingSessionParticipants
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrainingSessionParticipants` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `TrainingSessionId` INT NOT NULL,
  `EmployeeId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_TrainingSessionParticipants_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TrainingSessionParticipants_TrainingSessions`
    FOREIGN KEY (`TrainingSessionId`)
    REFERENCES `TrainingSessions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ModuleAssessmentResponseDetails
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ModuleAssessmentResponseDetails` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ModuleAssessmentId` INT NOT NULL,
  `ModuleId` INT NOT NULL,
  `ModuleQuestionId` INT NOT NULL,
  `ModuleAssessmentResponseId` INT NOT NULL,
  `Content` LONGTEXT NULL,
  `Points` DOUBLE NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  `Sequence` INT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_ModuleAssessmentResponseDetails_ModuleAssessmentResponses`
    FOREIGN KEY (`ModuleAssessmentResponseId`)
    REFERENCES `ModuleAssessmentResponses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ModuleAssessmentResponseDetails_ModuleAssessments`
    FOREIGN KEY (`ModuleAssessmentId`)
    REFERENCES `ModuleAssessments` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ModuleAssessmentResponseDetails_ModuleQuestions`
    FOREIGN KEY (`ModuleQuestionId`)
    REFERENCES `ModuleQuestions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ModuleAssessmentResponseDetails_Modules`
    FOREIGN KEY (`ModuleId`)
    REFERENCES `Modules` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table CommentDetails
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `CommentDetails` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `CourseDiscussionId` INT NOT NULL,
  `Comment` LONGTEXT NOT NULL,
  `PostDate` DATETIME(6) NULL,
  `EmployeeId` INT NULL,
  `ThreadStatusId` INT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_CommentDetails_CourseDiscussions`
    FOREIGN KEY (`CourseDiscussionId`)
    REFERENCES `CourseDiscussions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CommentDetails_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CommentDetails_ThreadStatuses`
    FOREIGN KEY (`ThreadStatusId`)
    REFERENCES `ThreadStatuses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TrainingSessions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrainingSessions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NOT NULL,
  `CourseId` INT NOT NULL,
  `TrainingDeliveryMethodId` INT NOT NULL,
  `Final` TINYINT(1) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_TrainingSessions_Courses1`
    FOREIGN KEY (`CourseId`)
    REFERENCES `Courses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TrainingSessions_TrainingDeliveryMethods`
    FOREIGN KEY (`TrainingDeliveryMethodId`)
    REFERENCES `TrainingDeliveryMethods` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ModuleAssessmentResponses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ModuleAssessmentResponses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ModuleId` INT NOT NULL,
  `EmployeeId` INT NOT NULL,
  `StartTime` DATETIME(6) NULL,
  `EndTime` DATETIME(6) NULL,
  `DateCompleted` DATETIME(6) NULL,
  `Reviewed` TINYINT(1) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  `ModuleAssessmentId` INT NULL,
  `CourseId` INT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_ModuleAssessmentResponses_Courses`
    FOREIGN KEY (`CourseId`)
    REFERENCES `Courses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ModuleAssessmentResponses_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ModuleAssessmentResponses_ModuleAssessments`
    FOREIGN KEY (`ModuleAssessmentId`)
    REFERENCES `ModuleAssessments` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ModuleAssessmentResponses_Modules`
    FOREIGN KEY (`ModuleId`)
    REFERENCES `Modules` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Companies
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Companies` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TrainingVenueBookings
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrainingVenueBookings` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `TrainingSessionId` INT NOT NULL,
  `TrainingVenueId` INT NOT NULL,
  `From` DATETIME(6) NOT NULL,
  `To` DATETIME(6) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_TrainingVenueBookings_TrainingSessions`
    FOREIGN KEY (`TrainingSessionId`)
    REFERENCES `TrainingSessions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TrainingVenueBookings_TrainingVenues`
    FOREIGN KEY (`TrainingVenueId`)
    REFERENCES `TrainingVenues` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ModuleAssessments
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ModuleAssessments` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ModuleId` INT NOT NULL,
  `AssessmentTypeId` INT NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `Data` LONGTEXT NOT NULL,
  `PassMark` DOUBLE NOT NULL,
  `TrainerId` INT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_ModuleAssessments_AssessmentTypes`
    FOREIGN KEY (`AssessmentTypeId`)
    REFERENCES `AssessmentTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ModuleAssessments_Employees`
    FOREIGN KEY (`TrainerId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ModuleAssessments_Module`
    FOREIGN KEY (`ModuleId`)
    REFERENCES `Modules` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table CompanyDocuments
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `CompanyDocuments` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `OriginalFullName` VARCHAR(1024) NOT NULL,
  `SavedFolderPath` VARCHAR(1024) NOT NULL,
  `SavedFileName` VARCHAR(1024) NOT NULL,
  `DateUploaded` DATETIME(6) NOT NULL,
  `UploadedByShamUserId` INT NOT NULL,
  `DocumentTypeId` INT NOT NULL,
  `DocumentCategoryId` INT NOT NULL,
  `Content` LONGTEXT NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_CompanyDocuments_DocumentCategories`
    FOREIGN KEY (`DocumentCategoryId`)
    REFERENCES `DocumentCategories` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CompanyDocuments_DocumentTypes`
    FOREIGN KEY (`DocumentTypeId`)
    REFERENCES `DocumentTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CompanyDocuments_ShamUsers`
    FOREIGN KEY (`UploadedByShamUserId`)
    REFERENCES `ShamUsers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TrainingVenues
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TrainingVenues` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `RoomNumber` VARCHAR(10) NOT NULL,
  `Floor` INT NOT NULL,
  `BuildingId` INT NOT NULL,
  `Capacity` INT NOT NULL,
  `AvailableFrom` DATETIME(6) NOT NULL,
  `AvaiableTo` DATETIME(6) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_TrainingVenues_Buildings`
    FOREIGN KEY (`BuildingId`)
    REFERENCES `Buildings` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ModulePrerequisites
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ModulePrerequisites` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ModuleId` INT NOT NULL,
  `PrerequisiteModuleId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_ModulePrerequisites_Module`
    FOREIGN KEY (`ModuleId`)
    REFERENCES `Modules` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ModulePrerequisites_Module1`
    FOREIGN KEY (`PrerequisiteModuleId`)
    REFERENCES `Modules` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Countries
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Countries` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  `Preferred` TINYINT(1) NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TravelExpenseClaims
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TravelExpenseClaims` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `TravelRequestId` INT NOT NULL,
  `CountryId` INT NOT NULL,
  `CustomerId` INT NULL,
  `TravelRequestAttachmentId` INT NULL,
  `Date` DATETIME(6) NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `Amount` DECIMAL(19,4) NOT NULL,
  `CurrencieId` INT NOT NULL,
  `TravelExpenseClaimStatusId` INT NOT NULL,
  `ReviewerEmployeeId` INT NULL,
  `ReviewerComments` VARCHAR(100) NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_TravelExpenseClaims_Countries`
    FOREIGN KEY (`CountryId`)
    REFERENCES `Countries` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TravelExpenseClaims_Currencies`
    FOREIGN KEY (`CurrencieId`)
    REFERENCES `Currencies` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TravelExpenseClaims_Customers`
    FOREIGN KEY (`CustomerId`)
    REFERENCES `Customers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TravelExpenseClaims_Employees`
    FOREIGN KEY (`ReviewerEmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TravelExpenseClaims_TravelExpenseClaimStatuses`
    FOREIGN KEY (`TravelExpenseClaimStatusId`)
    REFERENCES `TravelExpenseClaimStatuses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TravelExpenseClaims_TravelRequestAttachments`
    FOREIGN KEY (`TravelRequestAttachmentId`)
    REFERENCES `TravelRequestAttachments` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TravelExpenseClaims_TravelRequests`
    FOREIGN KEY (`TravelRequestId`)
    REFERENCES `TravelRequests` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ModuleQuestionChoices
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ModuleQuestionChoices` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ModuleQuestionId` INT NOT NULL,
  `ChoiceText` LONGTEXT NULL,
  `CorrectAnswer` TINYINT(1) NULL,
  `Points` DOUBLE NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_ModuleQuestionChoices_ModuleQuestions`
    FOREIGN KEY (`ModuleQuestionId`)
    REFERENCES `ModuleQuestions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table CourseDiscussions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `CourseDiscussions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `CourseId` INT NOT NULL,
  `EmployeeId` INT NOT NULL,
  `Title` LONGTEXT NULL,
  `ThreadStatusId` INT NULL,
  `PostDate` DATETIME(6) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  `ParentId` INT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_CourseDiscussions_Courses`
    FOREIGN KEY (`CourseId`)
    REFERENCES `Courses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CourseDiscussions_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CourseDiscussions_ThreadStatuses`
    FOREIGN KEY (`ThreadStatusId`)
    REFERENCES `ThreadStatuses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TravelExpenseClaimStatuses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TravelExpenseClaimStatuses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ModuleQuestions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ModuleQuestions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ModuleQuestionTypeId` INT NOT NULL,
  `Title` VARCHAR(300) NULL,
  `Points` DOUBLE NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_ModuleQuestions_ModuleQuestionTypes`
    FOREIGN KEY (`ModuleQuestionTypeId`)
    REFERENCES `ModuleQuestionTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table CourseModules
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `CourseModules` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `CourseId` INT NOT NULL,
  `ModuleId` INT NOT NULL,
  `Optional` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_CourseModules_Course`
    FOREIGN KEY (`CourseId`)
    REFERENCES `Courses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CourseModules_Module`
    FOREIGN KEY (`ModuleId`)
    REFERENCES `Modules` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TravelRequestAttachments
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TravelRequestAttachments` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `TravelRequestId` INT NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `OriginalFileName` VARCHAR(1024) NOT NULL,
  `Content` LONGTEXT NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_TravelRequestAttachments_TravelRequests`
    FOREIGN KEY (`TravelRequestId`)
    REFERENCES `TravelRequests` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ModuleQuestionTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ModuleQuestionTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(300) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table CourseParticipants
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `CourseParticipants` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `CourseId` INT NOT NULL,
  `EmployeeId` INT NOT NULL,
  `CourseParticipantStatusId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_CourseParticipants_CourseParticipantStatuses`
    FOREIGN KEY (`CourseParticipantStatusId`)
    REFERENCES `CourseParticipantStatuses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CourseParticipants_Courses`
    FOREIGN KEY (`CourseId`)
    REFERENCES `Courses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CourseParticipants_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TravelRequests
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TravelRequests` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `DestinationCountries` VARCHAR(100) NULL,
  `Customers` VARCHAR(100) NULL,
  `StartDate` DATETIME(6) NOT NULL,
  `EndDate` DATETIME(6) NOT NULL,
  `Motivation` VARCHAR(256) NULL,
  `PlannedActivities` VARCHAR(256) NULL,
  `TransportationBudget` DECIMAL(19,4) NULL,
  `TransportationCurrencyId` INT NULL,
  `TransportationRequestAdvance` TINYINT(1) NULL,
  `AccomodationBudget` DECIMAL(19,4) NULL,
  `AccomodationCurrencyId` INT NULL,
  `AccomodationRequestAdvance` TINYINT(1) NULL,
  `PerDiemBudget` DECIMAL(19,4) NULL,
  `PerDiemCurrencyId` INT NULL,
  `PerDiemRequestAdvance` TINYINT(1) NULL,
  `OtherFeesBudget` DECIMAL(19,4) NULL,
  `OtherFeesCurrencyId` INT NULL,
  `OtherFeesRequestAdvance` TINYINT(1) NULL,
  `OtherFeesDescription` VARCHAR(100) NULL,
  `PreferredAdvanceMethodId` INT NULL,
  `EmergencyContact` VARCHAR(100) NULL,
  `EmergencyContactNumber` VARCHAR(20) NULL,
  `RequestedByEmployeeId` INT NOT NULL,
  `RequestDate` DATETIME(6) NOT NULL,
  `TravelRequestStatusId` INT NOT NULL,
  `ReviewedByEmployeeId` INT NULL,
  `ReviewDate` DATETIME(6) NULL,
  `ReviewComment` VARCHAR(50) NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_TravelRequests_AdvanceMethods`
    FOREIGN KEY (`PreferredAdvanceMethodId`)
    REFERENCES `AdvanceMethods` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TravelRequests_Currencies`
    FOREIGN KEY (`TransportationCurrencyId`)
    REFERENCES `Currencies` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TravelRequests_Currencies1`
    FOREIGN KEY (`AccomodationCurrencyId`)
    REFERENCES `Currencies` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TravelRequests_Currencies2`
    FOREIGN KEY (`PerDiemCurrencyId`)
    REFERENCES `Currencies` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TravelRequests_Currencies3`
    FOREIGN KEY (`OtherFeesCurrencyId`)
    REFERENCES `Currencies` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TravelRequests_Employees`
    FOREIGN KEY (`RequestedByEmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TravelRequests_Employees1`
    FOREIGN KEY (`ReviewedByEmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_TravelRequests_TravelRequestStatuses`
    FOREIGN KEY (`TravelRequestStatusId`)
    REFERENCES `TravelRequestStatuses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Modules
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Modules` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(256) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  `Public` TINYINT(1) NULL,
  `Overview` LONGTEXT NULL,
  `Objectives` LONGTEXT NULL,
  `PassmarkPercentage` DOUBLE NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table CourseParticipantStatuses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `CourseParticipantStatuses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(300) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TravelRequestStatuses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TravelRequestStatuses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ModuleTopics
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ModuleTopics` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ModuleId` INT NOT NULL,
  `TopicId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_ModuleTopics_Modules`
    FOREIGN KEY (`ModuleId`)
    REFERENCES `Modules` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ModuleTopics_Topics`
    FOREIGN KEY (`TopicId`)
    REFERENCES `Topics` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table CoursePrerequisites
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `CoursePrerequisites` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `CourseId` INT NOT NULL,
  `PrerequisiteCourseId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_CoursePrerquisites_Course`
    FOREIGN KEY (`CourseId`)
    REFERENCES `Courses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CoursePrerquisites_Course1`
    FOREIGN KEY (`PrerequisiteCourseId`)
    REFERENCES `Courses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Triggers
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Triggers` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `EntityName` VARCHAR(50) NULL,
  `PropertyName` VARCHAR(100) NULL,
  `ParserExpressionId` INT NULL,
  `PropertyClrType` VARCHAR(100) NULL,
  `PropertySqlType` VARCHAR(100) NULL,
  `TriggerTypeId` INT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Triggers_ParserExpressions`
    FOREIGN KEY (`ParserExpressionId`)
    REFERENCES `ParserExpressions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Triggers_TriggerTypes`
    FOREIGN KEY (`TriggerTypeId`)
    REFERENCES `TriggerTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table NotificationGroups
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `NotificationGroups` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table CourseProgresses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `CourseProgresses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `CourseId` INT NOT NULL,
  `ModuleId` INT NOT NULL,
  `TopicId` INT NOT NULL,
  `Completed` TINYINT(1) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  `CompletedOn` DATETIME(6) NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_CourseProgress_Courses`
    FOREIGN KEY (`CourseId`)
    REFERENCES `Courses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CourseProgress_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CourseProgress_Modules`
    FOREIGN KEY (`ModuleId`)
    REFERENCES `Modules` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_CourseProgress_Topics`
    FOREIGN KEY (`TopicId`)
    REFERENCES `Topics` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table TriggerTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `TriggerTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table NotificationGroupsShamUsers
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `NotificationGroupsShamUsers` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `NotificationGroupId` INT NOT NULL,
  `ShamUserId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_NotificationGroupsShamUsers_NotificationGroups`
    FOREIGN KEY (`NotificationGroupId`)
    REFERENCES `NotificationGroups` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_NotificationGroupsShamUsers_ShamUsers`
    FOREIGN KEY (`ShamUserId`)
    REFERENCES `ShamUsers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Courses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Courses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  `Public` TINYINT(1) NULL,
  `Overview` LONGTEXT NULL,
  `Objectives` LONGTEXT NULL,
  `PassmarkPercentage` INT NULL,
  `StartDate` DATETIME(6) NULL,
  `EndDate` DATETIME(6) NULL,
  `Durations` DOUBLE NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Vacancies
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vacancies` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `RecruitmentRequestId` INT NOT NULL,
  `CompanyId` INT NULL,
  `DivisionId` INT NULL,
  `BranchId` INT NULL,
  `DepartmentId` INT NULL,
  `Position` VARCHAR(100) NULL,
  `Quantity` INT NULL,
  `PositionDescription` LONGTEXT NULL,
  `Salary` DECIMAL(19,4) NULL,
  `IssueDate` DATETIME(6) NULL,
  `ClosingDate` DATETIME(6) NULL,
  `StartDate` DATETIME(6) NULL,
  `EndDate` DATETIME(6) NULL,
  `Probationary` TINYINT(1) NULL,
  `BackgroundCheck` TINYINT(1) NULL,
  `DriversLicence` TINYINT(1) NULL,
  `CertificateRequirement` VARCHAR(1024) NULL,
  `OtherRequirements` VARCHAR(1024) NULL,
  `AdvertisingRequirements` VARCHAR(1024) NULL,
  `Open` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Vacancies_ApplicationTestForms`
    FOREIGN KEY (`Id`)
    REFERENCES `ApplicationTestForms` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Vacancies_Branches`
    FOREIGN KEY (`BranchId`)
    REFERENCES `Branches` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Vacancies_Companies`
    FOREIGN KEY (`CompanyId`)
    REFERENCES `Companies` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Vacancies_Departments`
    FOREIGN KEY (`DepartmentId`)
    REFERENCES `Departments` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Vacancies_Divisions`
    FOREIGN KEY (`DivisionId`)
    REFERENCES `Divisions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Vacancies_RecruitmentRequests`
    FOREIGN KEY (`RecruitmentRequestId`)
    REFERENCES `RecruitmentRequests` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table NotificationParticipants
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `NotificationParticipants` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `WorkflowStepId` INT NOT NULL,
  `ShamUserId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_NotificationParticipants_ShamUsers`
    FOREIGN KEY (`ShamUserId`)
    REFERENCES `ShamUsers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_NotificationParticipants_WorkflowSteps`
    FOREIGN KEY (`WorkflowStepId`)
    REFERENCES `WorkflowSteps` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_NotificationParticipants_WorkflowSteps1`
    FOREIGN KEY (`WorkflowStepId`)
    REFERENCES `WorkflowSteps` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Currencies
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Currencies` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ViewedComments
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ViewedComments` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `CommentDetailId` INT NOT NULL,
  `EmployeeId` INT NOT NULL,
  `Read` TINYINT(1) NOT NULL DEFAULT 0,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_ViewedComments_CommentDetails`
    FOREIGN KEY (`CommentDetailId`)
    REFERENCES `CommentDetails` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_ViewedComments_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table NotificationRecurrences
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `NotificationRecurrences` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(20) NOT NULL,
  `Days` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Customers
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Customers` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Violations
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Violations` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Notifications
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Notifications` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `NotificationTypeId` INT NOT NULL,
  `StartDate` DATETIME(6) NULL,
  `NotificationRecurrenceId` INT NOT NULL,
  `NotificationGroupId` INT NOT NULL,
  `NotificationTimesId` INT NOT NULL,
  `Title` VARCHAR(100) NOT NULL,
  `BodyText` LONGTEXT NOT NULL,
  `NotificationStatusId` INT NOT NULL,
  `Attachment` LONGTEXT NULL,
  `AttachmentFileName` VARCHAR(512) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  `TriggerId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Notifications_NotificationGroups`
    FOREIGN KEY (`NotificationGroupId`)
    REFERENCES `NotificationGroups` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Notifications_NotificationRecurrences`
    FOREIGN KEY (`NotificationRecurrenceId`)
    REFERENCES `NotificationRecurrences` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Notifications_NotificationStatuses`
    FOREIGN KEY (`NotificationStatusId`)
    REFERENCES `NotificationStatuses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Notifications_NotificationTimes`
    FOREIGN KEY (`NotificationTimesId`)
    REFERENCES `NotificationTimes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Notifications_NotificationTypes`
    FOREIGN KEY (`NotificationTypeId`)
    REFERENCES `NotificationTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Notifications_Triggers`
    FOREIGN KEY (`TriggerId`)
    REFERENCES `Triggers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Days
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Days` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) NOT NULL,
  `DayNumber` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table WorkflowInstanceRoles
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `WorkflowInstanceRoles` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) NOT NULL,
  `WorkflowInstanceId` INT NOT NULL,
  `ShamUserId` INT NULL,
  `RoleId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_WorkflowInstanceRoles_Roles`
    FOREIGN KEY (`RoleId`)
    REFERENCES `Roles` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_WorkflowInstanceRoles_ShamUsers`
    FOREIGN KEY (`ShamUserId`)
    REFERENCES `ShamUsers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_WorkflowInstanceRoles_WorkflowInstances`
    FOREIGN KEY (`WorkflowInstanceId`)
    REFERENCES `WorkflowInstances` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table NotificationStatuses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `NotificationStatuses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Departments
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Departments` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table WorkflowInstances
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `WorkflowInstances` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Entity` VARCHAR(50) NULL,
  `EntityId` INT NULL,
  `TargetEndDate` DATETIME(6) NULL,
  `ReminderSent` TINYINT(1) NULL,
  `StartDate` DATETIME(6) NULL,
  `EndDate` DATETIME(6) NULL,
  `Completed` TINYINT(1) NOT NULL DEFAULT 0,
  `PercentageCompleted` TINYINT UNSIGNED NULL,
  `Diagram` LONGTEXT NULL,
  `WorkflowId` INT NOT NULL,
  `CurrentWorkflowInstanceStepId` INT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_WorkflowInstances_WorkflowInstanceSteps`
    FOREIGN KEY (`CurrentWorkflowInstanceStepId`)
    REFERENCES `WorkflowInstanceSteps` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_WorkflowInstances_Workflows`
    FOREIGN KEY (`WorkflowId`)
    REFERENCES `Workflows` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table NotificationTimes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `NotificationTimes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(20) NOT NULL,
  `Days` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table DisciplinaryActions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `DisciplinaryActions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `ViolationId` INT NOT NULL,
  `ViolationDate` DATETIME(6) NOT NULL,
  `EmployeeStatement` LONGTEXT NOT NULL,
  `EmployerStatement` LONGTEXT NOT NULL,
  `Decision` LONGTEXT NOT NULL,
  `UpdatedBy` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 0,
  `IssueDate` DATETIME(6) NULL,
  `ExpiryDate` DATETIME(6) NULL,
  `DisciplinaryDecisionId` INT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_DisciplinaryActions_DisciplinaryDecisions`
    FOREIGN KEY (`DisciplinaryDecisionId`)
    REFERENCES `DisciplinaryDecisions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_DisciplinaryActions_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_DisciplinaryActions_Violations`
    FOREIGN KEY (`ViolationId`)
    REFERENCES `Violations` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table WorkflowInstanceSteps
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `WorkflowInstanceSteps` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `WorkflowStepTypeId` INT NOT NULL,
  `WorkflowInstanceId` INT NOT NULL,
  `WorkflowStepId` INT NOT NULL,
  `TargetEndDate` DATETIME(6) NULL,
  `StartDate` DATETIME(6) NOT NULL,
  `EndDate` DATETIME(6) NULL,
  `ReminderSent` TINYINT(1) NOT NULL DEFAULT 0,
  `Completed` TINYINT(1) NOT NULL DEFAULT 0,
  `Result` VARCHAR(100) NULL,
  `WorkflowStepStateId` INT NOT NULL,
  `Param1` VARCHAR(50) NULL,
  `Param2` VARCHAR(50) NULL,
  `Param3` VARCHAR(50) NULL,
  `Param4` VARCHAR(50) NULL,
  `Param5` VARCHAR(50) NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_WorkflowInstanceSteps_WorkflowInstances`
    FOREIGN KEY (`WorkflowInstanceId`)
    REFERENCES `WorkflowInstances` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_WorkflowInstanceSteps_WorkflowSteps`
    FOREIGN KEY (`WorkflowStepId`)
    REFERENCES `WorkflowSteps` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_WorkflowInstanceSteps_WorkflowStepStates`
    FOREIGN KEY (`WorkflowStepStateId`)
    REFERENCES `WorkflowStepStates` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_WorkflowInstanceSteps_WorkflowStepTypes`
    FOREIGN KEY (`WorkflowStepTypeId`)
    REFERENCES `WorkflowStepTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table NotificationTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `NotificationTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table DisciplinaryDecisions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `DisciplinaryDecisions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(200) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table WorkflowInstanceTransitions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `WorkflowInstanceTransitions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `Value` VARCHAR(100) NOT NULL,
  `SourceWorkflowInstanceStepId` INT NOT NULL,
  `TargetWorkflowInstanceStepId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_WorkflowInstanceTransitions_WorkflowInstanceSteps`
    FOREIGN KEY (`SourceWorkflowInstanceStepId`)
    REFERENCES `WorkflowInstanceSteps` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_WorkflowInstanceTransitions_WorkflowInstanceSteps1`
    FOREIGN KEY (`SourceWorkflowInstanceStepId`)
    REFERENCES `WorkflowInstanceSteps` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_WorkflowInstanceTransitions_WorkflowInstanceSteps2`
    FOREIGN KEY (`TargetWorkflowInstanceStepId`)
    REFERENCES `WorkflowInstanceSteps` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table OfferResponses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `OfferResponses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Divisions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Divisions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table WorkflowNotifications
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `WorkflowNotifications` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ShamUserId` INT NOT NULL,
  `InteractUri` VARCHAR(1024) NOT NULL,
  `DateCreated` DATETIME(6) NOT NULL,
  `Sent` TINYINT(1) NOT NULL DEFAULT 0,
  `DateSent` DATETIME(6) NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_WorkflowNotifications_ShamUsers`
    FOREIGN KEY (`ShamUserId`)
    REFERENCES `ShamUsers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Offers
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Offers` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ApplicationId` INT NOT NULL,
  `Date` DATETIME(6) NOT NULL,
  `Description` VARCHAR(100) NULL,
  `AttachmentFileName` VARCHAR(100) NULL,
  `Attachment` LONGTEXT NULL,
  `Offer` CHAR(10) CHARACTER SET 'utf8mb4' NULL,
  `OfferResponseId` INT NULL,
  `ResponseDate` DATETIME(6) NULL,
  `ResponseReason` VARCHAR(100) NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Offers_Applications`
    FOREIGN KEY (`ApplicationId`)
    REFERENCES `Applications` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Offers_OfferResponses`
    FOREIGN KEY (`OfferResponseId`)
    REFERENCES `OfferResponses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table DocumentCategories
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `DocumentCategories` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Workflows
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Workflows` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NOT NULL,
  `TriggerId` INT NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `TargetDate` DATE NULL,
  `RecurrenceId` INT NULL,
  `MaxDuration` INT NOT NULL,
  `Diagram` LONGTEXT NOT NULL,
  `SystemSubModuleId` INT NOT NULL,
  `ShamUserId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Workflows_Recurrences`
    FOREIGN KEY (`RecurrenceId`)
    REFERENCES `Recurrences` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Workflows_ShamUsers`
    FOREIGN KEY (`ShamUserId`)
    REFERENCES `ShamUsers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Workflows_SystemSubModules`
    FOREIGN KEY (`SystemSubModuleId`)
    REFERENCES `SystemSubModules` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Workflows_Triggers`
    FOREIGN KEY (`TriggerId`)
    REFERENCES `Triggers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table OrganisationCharts
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `OrganisationCharts` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `Diagram` LONGTEXT NOT NULL,
  `Author` VARCHAR(50) NOT NULL,
  `DateCreated` DATETIME(6) NOT NULL,
  `LastEditBy` VARCHAR(50) NULL,
  `LastEditDate` DATETIME(6) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table DocumentTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `DocumentTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Extension` VARCHAR(10) NOT NULL,
  `Description` CHAR(10) CHARACTER SET 'utf8mb4' NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table EmployeeAttachments
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `EmployeeAttachments` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `Comment` VARCHAR(100) NULL,
  `EmployeeAttachmentTypeId` INT NULL,
  `OriginalFileName` VARCHAR(512) NOT NULL,
  `Content` LONGBLOB NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_EmployeeAttachments_EmployeeAttachmentTypes`
    FOREIGN KEY (`EmployeeAttachmentTypeId`)
    REFERENCES `EmployeeAttachmentTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_EmployeeAttachments_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table WorkflowSteps
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `WorkflowSteps` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `WorkflowId` INT NOT NULL,
  `Name` VARCHAR(50) NOT NULL,
  `WorkflowStepTypeId` INT NOT NULL,
  `WorkflowStepStateId` INT NOT NULL,
  `Description` VARCHAR(50) NOT NULL,
  `MaxDurationDays` INT NOT NULL,
  `Param1` VARCHAR(50) NOT NULL,
  `Param2` VARCHAR(50) NOT NULL,
  `Param3` VARCHAR(50) NOT NULL,
  `Param4` VARCHAR(50) NOT NULL,
  `Param5` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_WorkflowSteps_Workflows`
    FOREIGN KEY (`WorkflowId`)
    REFERENCES `Workflows` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_WorkflowSteps_WorkflowStepStates`
    FOREIGN KEY (`WorkflowStepStateId`)
    REFERENCES `WorkflowStepStates` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_WorkflowSteps_WorkflowStepTypes`
    FOREIGN KEY (`WorkflowStepTypeId`)
    REFERENCES `WorkflowStepTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ParserExpressions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParserExpressions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `ShamUserId` INT NOT NULL,
  `Name` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `Text` VARCHAR(2048) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `IX_ParserExpressions` (`Name` ASC),
  CONSTRAINT `FK_ParserExpressions_ShamUsers`
    FOREIGN KEY (`ShamUserId`)
    REFERENCES `ShamUsers` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table EmailAddresses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `EmailAddresses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `EmailAddress` VARCHAR(512) NOT NULL,
  `EmailAddressTypeId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_EmailAddresses_EmailAddressTypes`
    FOREIGN KEY (`EmailAddressTypeId`)
    REFERENCES `EmailAddressTypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_EmailAddresses_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table WorkflowStepStates
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `WorkflowStepStates` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Policies
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Policies` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(100) NOT NULL,
  `Content` LONGTEXT NOT NULL,
  `PolicyCategoryId` INT NOT NULL,
  `UpdatedBy` VARCHAR(100) NULL,
  `UpdatedWhen` DATETIME(6) NULL,
  `ExpiryDate` DATETIME(6) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Policies_PolicyCategories`
    FOREIGN KEY (`PolicyCategoryId`)
    REFERENCES `PolicyCategories` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table EmailAddressTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `EmailAddressTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table WorkflowStepTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `WorkflowStepTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table PolicyCategories
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `PolicyCategories` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table LawDocuments
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `LawDocuments` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `LawId` INT NOT NULL,
  `Name` VARCHAR(100) NOT NULL,
  `Content` LONGTEXT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_LawDocuments_Laws`
    FOREIGN KEY (`LawId`)
    REFERENCES `Laws` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table WorkflowTransitions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `WorkflowTransitions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `WorkflowId` INT NOT NULL,
  `Name` VARCHAR(50) NOT NULL,
  `Description` VARCHAR(50) NOT NULL,
  `SourceWorkflowStepId` INT NOT NULL,
  `TargetWorkflowStepId` INT NULL,
  `Value` VARCHAR(100) NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_WorkflowTransitions_Workflows`
    FOREIGN KEY (`WorkflowId`)
    REFERENCES `Workflows` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_WorkflowTransitions_WorkflowSteps`
    FOREIGN KEY (`SourceWorkflowStepId`)
    REFERENCES `WorkflowSteps` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_WorkflowTransitions_WorkflowSteps1`
    FOREIGN KEY (`TargetWorkflowStepId`)
    REFERENCES `WorkflowSteps` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table EmployeeAttachmentTypes
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `EmployeeAttachmentTypes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table PolicyDocuments
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `PolicyDocuments` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `PolicyId` INT NOT NULL,
  `Name` VARCHAR(50) NOT NULL,
  `Content` LONGTEXT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_PolicyDocuments_Policies`
    FOREIGN KEY (`PolicyId`)
    REFERENCES `Policies` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table ProductCategories
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ProductCategories` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(256) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table EmployeeAttendanceRecords
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `EmployeeAttendanceRecords` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `Date` DATE NOT NULL,
  `TimeIn` TIME(6) NOT NULL,
  `TimeOut` TIME(6) NULL,
  `SysUserCreated` VARCHAR(50) NULL,
  `DateTimeCreated` DATETIME(6) NULL,
  `SysUserUpdated` VARCHAR(50) NULL,
  `DateTimeUpdated` DATETIME(6) NULL,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `IX_EmployeeAttendanceRecords_EmployeeId_Date` (`EmployeeId` ASC, `Date` ASC),
  CONSTRAINT `FK_EmployeeAttendanceRecords_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Products
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Products` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NOT NULL,
  `Description` VARCHAR(100) NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Employees
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Employees` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `TitleId` INT NULL,
  `Initials` VARCHAR(10) NULL,
  `FirstName` VARCHAR(50) NULL,
  `Surname` VARCHAR(50) NULL,
  `KnownAs` VARCHAR(50) NULL,
  `DateOfBirth` DATE NULL,
  `MaritalStatusId` INT NULL,
  `IdNumber` VARCHAR(50) NOT NULL,
  `PassportCountryId` INT NULL,
  `Nationality` VARCHAR(50) NULL,
  `LanguageId` INT NULL,
  `GenderId` INT NULL,
  `EthnicGroupId` INT NULL,
  `ImmigrationStatusId` INT NULL,
  `TimeGroupId` INT NULL,
  `PassportNo` VARCHAR(50) NULL,
  `SpouseFullName` VARCHAR(50) NULL,
  `EmployeeNo` VARCHAR(50) NOT NULL,
  `EmployeeCode` VARCHAR(50) NOT NULL,
  `TaxNumber` VARCHAR(50) NULL,
  `TaxStatusId` INT NULL,
  `JoinedDate` DATETIME NULL,
  `TerminationDate` DATETIME NULL,
  `DepartmentId` INT NULL,
  `TeamId` INT NULL,
  `EmployeeStatusId` INT NULL,
  `PhysicalFileNo` VARCHAR(50) NULL,
  `JobTitleId` INT NULL,
  `DivisionId` INT NULL,
  `BranchId` INT NULL,
  `Active` TINYINT(1) NOT NULL,
  `Picture` LONGTEXT NULL,
  `LineManagerId` INT NULL,
  `LeaveBalanceAtStart` INT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `IX_Employees` (`IdNumber` ASC, `EmployeeCode` ASC),
  UNIQUE INDEX `IX_Employees_EmployeeCode` (`EmployeeCode` ASC),
  UNIQUE INDEX `IX_Employees_EmployeeNo` (`EmployeeNo` ASC),
  CONSTRAINT `FK_Employees_Branches`
    FOREIGN KEY (`BranchId`)
    REFERENCES `Branches` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Employees_Countries`
    FOREIGN KEY (`PassportCountryId`)
    REFERENCES `Countries` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Employees_Departments`
    FOREIGN KEY (`DepartmentId`)
    REFERENCES `Departments` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Employees_Divisions`
    FOREIGN KEY (`DivisionId`)
    REFERENCES `Divisions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Employees_EmployeeStatuses`
    FOREIGN KEY (`EmployeeStatusId`)
    REFERENCES `EmployeeStatuses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Employees_EthnicGroups`
    FOREIGN KEY (`EthnicGroupId`)
    REFERENCES `EthnicGroups` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Employees_Genders`
    FOREIGN KEY (`GenderId`)
    REFERENCES `Genders` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Employees_ImmigrationStatuses`
    FOREIGN KEY (`ImmigrationStatusId`)
    REFERENCES `ImmigrationStatuses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Employees_JobTitles`
    FOREIGN KEY (`JobTitleId`)
    REFERENCES `JobTitles` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Employees_Languages`
    FOREIGN KEY (`LanguageId`)
    REFERENCES `Languages` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Employees_MaritalStatuses`
    FOREIGN KEY (`MaritalStatusId`)
    REFERENCES `MaritalStatuses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Employees_TaxStatuses`
    FOREIGN KEY (`TaxStatusId`)
    REFERENCES `TaxStatuses` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Employees_Teams`
    FOREIGN KEY (`TeamId`)
    REFERENCES `Teams` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Employees_Titles`
    FOREIGN KEY (`TitleId`)
    REFERENCES `Titles` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table PublicHolidays
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `PublicHolidays` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Date` DATE NOT NULL,
  `Description` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `IX_PublicHolidays` (`Date` ASC))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Employees_Audit
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Employees_Audit` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `UpdateType` CHAR(10) NOT NULL,
  `TitleId` INT NULL,
  `Initials` VARCHAR(10) NULL,
  `FirstName` VARCHAR(50) NULL,
  `Surname` VARCHAR(50) NULL,
  `KnownAs` VARCHAR(50) NULL,
  `DateOfBirth` DATETIME NULL,
  `MaritalStatusId` INT NULL,
  `IdNumber` VARCHAR(50) NULL,
  `PassportCountryId` INT NULL,
  `Nationality` VARCHAR(50) NULL,
  `LanguageId` INT NULL,
  `GenderId` INT NULL,
  `EthnicGroupId` INT NULL,
  `ImmigrationStatusId` INT NULL,
  `TimeGroupId` INT NULL,
  `PassportNo` VARCHAR(50) NULL,
  `SpouseFullName` VARCHAR(50) NULL,
  `EmployeeNo` VARCHAR(50) NULL,
  `EmployeeCode` VARCHAR(50) NULL,
  `TaxNumber` VARCHAR(50) NULL,
  `TaxStatusId` INT NULL,
  `JoinedDate` DATETIME NULL,
  `TerminationDate` DATETIME NULL,
  `DepartmentId` INT NULL,
  `TeamId` INT NULL,
  `EmployeeStatusId` INT NULL,
  `PhysicalFileNo` VARCHAR(50) NULL,
  `JobTitleId` INT NULL,
  `DivisionId` INT NULL,
  `BranchId` INT NULL,
  `Active` TINYINT(1) NULL,
  `Picture` LONGTEXT NULL,
  `LineManagerId` INT NULL,
  `LeaveBalanceAtStart` INT NULL,
  `Timestamp` DATETIME(6) NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table Qualifications
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `Qualifications` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `Reference` VARCHAR(50) NULL,
  `Description` VARCHAR(50) NULL,
  `Institution` VARCHAR(50) NULL,
  `DateObtained` DATETIME NULL,
  `StudentNo` VARCHAR(50) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Qualifications_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table EmployeeSkills
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `EmployeeSkills` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `SkillId` INT NOT NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_EmployeeSkills_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_EmployeeSkills_Skills`
    FOREIGN KEY (`SkillId`)
    REFERENCES `Skills` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table RecruitmentRequestReasons
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `RecruitmentRequestReasons` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(100) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table EmployeesLeaveSchedules
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `EmployeesLeaveSchedules` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `EmployeeId` INT NOT NULL,
  `LeaveScheduleId` INT NOT NULL,
  `EffectiveFrom` DATE NOT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_EmployeesLeaveSchedules_Employees`
    FOREIGN KEY (`EmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_EmployeesLeaveSchedules_LeaveSchedules`
    FOREIGN KEY (`LeaveScheduleId`)
    REFERENCES `LeaveSchedules` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table RecruitmentRequests
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `RecruitmentRequests` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `BranchId` INT NULL,
  `DivisionId` INT NULL,
  `DepartmentId` INT NULL,
  `Position` VARCHAR(50) NULL,
  `Quantity` INT NULL,
  `HiringManagerEmployeeId` INT NULL,
  `Classification` VARCHAR(50) NULL,
  `SkillLevel` VARCHAR(100) NULL,
  `TimeGroupId` INT NULL,
  `JobDescription` VARCHAR(512) NULL,
  `ContractType` VARCHAR(100) NULL,
  `MinSalary` DECIMAL(19,4) NULL,
  `MaxSalary` DECIMAL(19,4) NULL,
  `Deadline` DATETIME(6) NULL,
  `StartDate` DATETIME(6) NULL,
  `EndDate` DATETIME(6) NULL,
  `RecruitmentRequestReasonId` INT NULL,
  `RecruitmentRequestReasonText` VARCHAR(128) NULL,
  `Justification` VARCHAR(1024) NULL,
  `Probation` TINYINT(1) NOT NULL DEFAULT 1,
  `BackgroundCheck` TINYINT(1) NOT NULL DEFAULT 1,
  `DriversLicence` TINYINT(1) NOT NULL DEFAULT 0,
  `QualificationRequirements` VARCHAR(1024) NULL,
  `OtherRequirements` VARCHAR(1024) NULL,
  `AdvertisingRequirements` VARCHAR(1024) NULL,
  `RequestDate` DATETIME(6) NULL,
  `Approved` TINYINT(1) NULL,
  `ApprovalDate` DATETIME(6) NULL,
  `ApprovedBy` VARCHAR(100) NULL,
  `Active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`),
  CONSTRAINT `FK_RecruitmentRequests_Branches`
    FOREIGN KEY (`BranchId`)
    REFERENCES `Branches` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_RecruitmentRequests_Departments`
    FOREIGN KEY (`DepartmentId`)
    REFERENCES `Departments` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_RecruitmentRequests_Divisions`
    FOREIGN KEY (`DivisionId`)
    REFERENCES `Divisions` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_RecruitmentRequests_Employees`
    FOREIGN KEY (`HiringManagerEmployeeId`)
    REFERENCES `Employees` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_RecruitmentRequests_RecruitmentRequestReasons`
    FOREIGN KEY (`RecruitmentRequestReasonId`)
    REFERENCES `RecruitmentRequestReasons` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_RecruitmentRequests_TimeGroups`
    FOREIGN KEY (`TimeGroupId`)
    REFERENCES `TimeGroups` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Table EmployeeStatuses
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `EmployeeStatuses` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(50) NOT NULL,
  `Active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Id`))ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- Trigger DeleteEmployeeTrigger
-- ----------------------------------------------------------------------------
-- DELIMITER $$
-- USE `shamtest`$$
-- CREATE TRIGGER [dbo].[DeleteEmployeeTrigger] ON [dbo].[Employees]

--     FOR DELETE

-- AS

--     BEGIN

--         DECLARE @Employees TABLE

--             (

--               Id INT NOT NULL ,

--               TitleId INT NULL ,

--               Initials VARCHAR(10) NULL ,

--               FirstName VARCHAR(50) NULL ,

--               Surname VARCHAR(50) NULL ,

--               KnownAs VARCHAR(50) NULL ,

--               DateOfBirth SMALLDATETIME NULL ,

--               MaritalStatusId INT NULL ,

--               IdNumber VARCHAR(50) NOT NULL ,

--               PassportCountryId INT NULL ,

--               Nationality VARCHAR(50) NULL ,

--               LanguageId INT NULL ,

--               GenderId INT NULL ,

--               EthnicGroupId INT NULL ,

--               ImmigrationStatusId INT NULL ,

--               TimeGroupId INT NULL ,

--               PassportNo VARCHAR(50) NULL ,

--               SpouseFullName VARCHAR(50) NULL ,

--               EmployeeNo VARCHAR(50) NOT NULL ,

--               EmployeeCode VARCHAR(50) NOT NULL ,

--               TaxNumber VARCHAR(50) NULL ,

--               TaxStatusId INT NULL ,

--               JoinedDate SMALLDATETIME NULL ,

--               TerminationDate SMALLDATETIME NULL ,

--               DepartmentId INT NULL ,

--               TeamId INT NULL ,

--               EmployeeStatusId INT NULL ,

--               PhysicalFileNo VARCHAR(50) NULL ,

--               JobTitleId INT NULL ,

--               DivisionId INT NULL ,

--               BranchId INT NULL ,

--               Active BIT NOT NULL ,

--               Picture VARCHAR(MAX) NULL ,

--               LineManagerId INT NULL ,

--               LeaveBalanceAtStart INT NULL

--             )ENGINE = InnoDB;

-- 

--         INSERT  INTO @Employees

--                 ( Id ,

--                   TitleId ,

--                   Initials ,

--                   FirstName ,

--                   Surname ,

--                   KnownAs ,

--                   DateOfBirth ,

--                   MaritalStatusId ,

--                   IdNumber ,

--                   PassportCountryId ,

--                   Nationality ,

--                   LanguageId ,

--                   GenderId ,

--                   EthnicGroupId ,

--                   ImmigrationStatusId ,

--                   TimeGroupId ,

--                   PassportNo ,

--                   SpouseFullName ,

--                   EmployeeNo ,

--                   EmployeeCode ,

--                   TaxNumber ,

--                   TaxStatusId ,

--                   JoinedDate ,

--                   TerminationDate ,

--                   DepartmentId ,

--                   TeamId ,

--                   EmployeeStatusId ,

--                   PhysicalFileNo ,

--                   JobTitleId ,

--                   DivisionId ,

--                   BranchId ,

--                   Active ,

--                   Picture ,

--                   LineManagerId ,

--                   LeaveBalanceAtStart

-- 		        )

--                 SELECT  Id ,

--                         TitleId ,

--                         Initials ,

--                         FirstName ,

--                         Surname ,

--                         KnownAs ,

--                         DateOfBirth ,

--                         MaritalStatusId ,

--                         IdNumber ,

--                         PassportCountryId ,

--                         Nationality ,

--                         LanguageId ,

--                         GenderId ,

--                         EthnicGroupId ,

--                         ImmigrationStatusId ,

--                         TimeGroupId ,

--                         PassportNo ,

--                         SpouseFullName ,

--                         EmployeeNo ,

--                         EmployeeCode ,

--                         TaxNumber ,

--                         TaxStatusId ,

--                         JoinedDate ,

--                         TerminationDate ,

--                         DepartmentId ,

--                         TeamId ,

--                         EmployeeStatusId ,

--                         PhysicalFileNo ,

--                         JobTitleId ,

--                         DivisionId ,

--                         BranchId ,

--                         Active ,

--                         Picture ,

--                         LineManagerId ,

--                         LeaveBalanceAtStart

--                 FROM    DELETED;

-- 

--         INSERT  INTO dbo.Employees_Audit

--                 ( EmployeeId ,

--                   UpdateType ,

--                   TitleId ,

--                   Initials ,

--                   FirstName ,

--                   Surname ,

--                   KnownAs ,

--                   DateOfBirth ,

--                   MaritalStatusId ,

--                   IdNumber ,

--                   PassportCountryId ,

--                   Nationality ,

--                   LanguageId ,

--                   GenderId ,

--                   EthnicGroupId ,

--                   ImmigrationStatusId ,

--                   TimeGroupId ,

--                   PassportNo ,

--                   SpouseFullName ,

--                   EmployeeNo ,

--                   EmployeeCode ,

--                   TaxNumber ,

--                   TaxStatusId ,

--                   JoinedDate ,

--                   TerminationDate ,

--                   DepartmentId ,

--                   TeamId ,

--                   EmployeeStatusId ,

--                   PhysicalFileNo ,

--                   JobTitleId ,

--                   DivisionId ,

--                   BranchId ,

--                   Active ,

--                   Picture ,

--                   LineManagerId ,

--                   LeaveBalanceAtStart ,

--                   [Timestamp]

--                 )

--                 SELECT  Id ,

--                         'D' ,

--                         TitleId ,

--                         Initials ,

--                         FirstName ,

--                         Surname ,

--                         KnownAs ,

--                         DateOfBirth ,

--                         MaritalStatusId ,

--                         IdNumber ,

--                         PassportCountryId ,

--                         Nationality ,

--                         LanguageId ,

--                         GenderId ,

--                         EthnicGroupId ,

--                         ImmigrationStatusId ,

--                         TimeGroupId ,

--                         PassportNo ,

--                         SpouseFullName ,

--                         EmployeeNo ,

--                         EmployeeCode ,

--                         TaxNumber ,

--                         TaxStatusId ,

--                         JoinedDate ,

--                         TerminationDate ,

--                         DepartmentId ,

--                         TeamId ,

--                         EmployeeStatusId ,

--                         PhysicalFileNo ,

--                         JobTitleId ,

--                         DivisionId ,

--                         BranchId ,

--                         Active ,

--                         Picture ,

--                         LineManagerId ,

--                         LeaveBalanceAtStart ,

--                         GETDATE()

--                 FROM    @Employees;

--     END;

-- ----------------------------------------------------------------------------
-- Trigger InsertEmployeeTrigger
-- ----------------------------------------------------------------------------
-- DELIMITER $$
-- USE `shamtest`$$
-- CREATE TRIGGER [dbo].[InsertEmployeeTrigger] ON [dbo].[Employees]

--     FOR INSERT

-- AS

--     BEGIN

--         DECLARE @Employees TABLE

--             (

--               Id INT NOT NULL ,

--               TitleId INT NULL ,

--               Initials VARCHAR(10) NULL ,

--               FirstName VARCHAR(50) NULL ,

--               Surname VARCHAR(50) NULL ,

--               KnownAs VARCHAR(50) NULL ,

--               DateOfBirth SMALLDATETIME NULL ,

--               MaritalStatusId INT NULL ,

--               IdNumber VARCHAR(50) NOT NULL ,

--               PassportCountryId INT NULL ,

--               Nationality VARCHAR(50) NULL ,

--               LanguageId INT NULL ,

--               GenderId INT NULL ,

--               EthnicGroupId INT NULL ,

--               ImmigrationStatusId INT NULL ,

--               TimeGroupId INT NULL ,

--               PassportNo VARCHAR(50) NULL ,

--               SpouseFullName VARCHAR(50) NULL ,

--               EmployeeNo VARCHAR(50) NOT NULL ,

--               EmployeeCode VARCHAR(50) NOT NULL ,

--               TaxNumber VARCHAR(50) NULL ,

--               TaxStatusId INT NULL ,

--               JoinedDate SMALLDATETIME NULL ,

--               TerminationDate SMALLDATETIME NULL ,

--               DepartmentId INT NULL ,

--               TeamId INT NULL ,

--               EmployeeStatusId INT NULL ,

--               PhysicalFileNo VARCHAR(50) NULL ,

--               JobTitleId INT NULL ,

--               DivisionId INT NULL ,

--               BranchId INT NULL ,

--               Active BIT NOT NULL ,

--               Picture VARCHAR(MAX) NULL ,

--               LineManagerId INT NULL ,

--               LeaveBalanceAtStart INT NULL

--             )ENGINE = InnoDB;

-- 

--         INSERT  INTO @Employees

--                 ( Id ,

--                   TitleId ,

--                   Initials ,

--                   FirstName ,

--                   Surname ,

--                   KnownAs ,

--                   DateOfBirth ,

--                   MaritalStatusId ,

--                   IdNumber ,

--                   PassportCountryId ,

--                   Nationality ,

--                   LanguageId ,

--                   GenderId ,

--                   EthnicGroupId ,

--                   ImmigrationStatusId ,

--                   TimeGroupId ,

--                   PassportNo ,

--                   SpouseFullName ,

--                   EmployeeNo ,

--                   EmployeeCode ,

--                   TaxNumber ,

--                   TaxStatusId ,

--                   JoinedDate ,

--                   TerminationDate ,

--                   DepartmentId ,

--                   TeamId ,

--                   EmployeeStatusId ,

--                   PhysicalFileNo ,

--                   JobTitleId ,

--                   DivisionId ,

--                   BranchId ,

--                   Active ,

--                   Picture ,

--                   LineManagerId ,

--                   LeaveBalanceAtStart

-- 		        )

--                 SELECT  Id ,

--                         TitleId ,

--                         Initials ,

--                         FirstName ,

--                         Surname ,

--                         KnownAs ,

--                         DateOfBirth ,

--                         MaritalStatusId ,

--                         IdNumber ,

--                         PassportCountryId ,

--                         Nationality ,

--                         LanguageId ,

--                         GenderId ,

--                         EthnicGroupId ,

--                         ImmigrationStatusId ,

--                         TimeGroupId ,

--                         PassportNo ,

--                         SpouseFullName ,

--                         EmployeeNo ,

--                         EmployeeCode ,

--                         TaxNumber ,

--                         TaxStatusId ,

--                         JoinedDate ,

--                         TerminationDate ,

--                         DepartmentId ,

--                         TeamId ,

--                         EmployeeStatusId ,

--                         PhysicalFileNo ,

--                         JobTitleId ,

--                         DivisionId ,

--                         BranchId ,

--                         Active ,

--                         Picture ,

--                         LineManagerId ,

--                         LeaveBalanceAtStart

--                 FROM    INSERTED;

-- 

--         INSERT  INTO dbo.Employees_Audit

--                 ( EmployeeId ,

--                   UpdateType ,

--                   TitleId ,

--                   Initials ,

--                   FirstName ,

--                   Surname ,

--                   KnownAs ,

--                   DateOfBirth ,

--                   MaritalStatusId ,

--                   IdNumber ,

--                   PassportCountryId ,

--                   Nationality ,

--                   LanguageId ,

--                   GenderId ,

--                   EthnicGroupId ,

--                   ImmigrationStatusId ,

--                   TimeGroupId ,

--                   PassportNo ,

--                   SpouseFullName ,

--                   EmployeeNo ,

--                   EmployeeCode ,

--                   TaxNumber ,

--                   TaxStatusId ,

--                   JoinedDate ,

--                   TerminationDate ,

--                   DepartmentId ,

--                   TeamId ,

--                   EmployeeStatusId ,

--                   PhysicalFileNo ,

--                   JobTitleId ,

--                   DivisionId ,

--                   BranchId ,

--                   Active ,

--                   Picture ,

--                   LineManagerId ,

--                   LeaveBalanceAtStart ,

--                   [Timestamp]

--                 )

--                 SELECT  Id ,

--                         'I' ,

--                         TitleId ,

--                         Initials ,

--                         FirstName ,

--                         Surname ,

--                         KnownAs ,

--                         DateOfBirth ,

--                         MaritalStatusId ,

--                         IdNumber ,

--                         PassportCountryId ,

--                         Nationality ,

--                         LanguageId ,

--                         GenderId ,

--                         EthnicGroupId ,

--                         ImmigrationStatusId ,

--                         TimeGroupId ,

--                         PassportNo ,

--                         SpouseFullName ,

--                         EmployeeNo ,

--                         EmployeeCode ,

--                         TaxNumber ,

--                         TaxStatusId ,

--                         JoinedDate ,

--                         TerminationDate ,

--                         DepartmentId ,

--                         TeamId ,

--                         EmployeeStatusId ,

--                         PhysicalFileNo ,

--                         JobTitleId ,

--                         DivisionId ,

--                         BranchId ,

--                         Active ,

--                         Picture ,

--                         LineManagerId ,

--                         LeaveBalanceAtStart ,

--                         GETDATE()

--                 FROM    @Employees;

--     END;

-- ----------------------------------------------------------------------------
-- Trigger UpdateEmployeeTrigger
-- ----------------------------------------------------------------------------
-- DELIMITER $$
-- USE `shamtest`$$
-- CREATE TRIGGER [dbo].[UpdateEmployeeTrigger] ON [dbo].[Employees]

--     FOR UPDATE

-- AS

--     BEGIN

--         DECLARE @Employees TABLE

--             (

--               Id INT NOT NULL ,

--               TitleId INT NULL ,

--               Initials VARCHAR(10) NULL ,

--               FirstName VARCHAR(50) NULL ,

--               Surname VARCHAR(50) NULL ,

--               KnownAs VARCHAR(50) NULL ,

--               DateOfBirth SMALLDATETIME NULL ,

--               MaritalStatusId INT NULL ,

--               IdNumber VARCHAR(50) NOT NULL ,

--               PassportCountryId INT NULL ,

--               Nationality VARCHAR(50) NULL ,

--               LanguageId INT NULL ,

--               GenderId INT NULL ,

--               EthnicGroupId INT NULL ,

--               ImmigrationStatusId INT NULL ,

--               TimeGroupId INT NULL ,

--               PassportNo VARCHAR(50) NULL ,

--               SpouseFullName VARCHAR(50) NULL ,

--               EmployeeNo VARCHAR(50) NOT NULL ,

--               EmployeeCode VARCHAR(50) NOT NULL ,

--               TaxNumber VARCHAR(50) NULL ,

--               TaxStatusId INT NULL ,

--               JoinedDate SMALLDATETIME NULL ,

--               TerminationDate SMALLDATETIME NULL ,

--               DepartmentId INT NULL ,

--               TeamId INT NULL ,

--               EmployeeStatusId INT NULL ,

--               PhysicalFileNo VARCHAR(50) NULL ,

--               JobTitleId INT NULL ,

--               DivisionId INT NULL ,

--               BranchId INT NULL ,

--               Active BIT NOT NULL ,

--               Picture VARCHAR(MAX) NULL ,

--               LineManagerId INT NULL ,

--               LeaveBalanceAtStart INT NULL

--             )ENGINE = InnoDB;

-- 

--         INSERT  INTO @Employees

--                 ( Id ,

--                   TitleId ,

--                   Initials ,

--                   FirstName ,

--                   Surname ,

--                   KnownAs ,

--                   DateOfBirth ,

--                   MaritalStatusId ,

--                   IdNumber ,

--                   PassportCountryId ,

--                   Nationality ,

--                   LanguageId ,

--                   GenderId ,

--                   EthnicGroupId ,

--                   ImmigrationStatusId ,

--                   TimeGroupId ,

--                   PassportNo ,

--                   SpouseFullName ,

--                   EmployeeNo ,

--                   EmployeeCode ,

--                   TaxNumber ,

--                   TaxStatusId ,

--                   JoinedDate ,

--                   TerminationDate ,

--                   DepartmentId ,

--                   TeamId ,

--                   EmployeeStatusId ,

--                   PhysicalFileNo ,

--                   JobTitleId ,

--                   DivisionId ,

--                   BranchId ,

--                   Active ,

--                   Picture ,

--                   LineManagerId ,

--                   LeaveBalanceAtStart

-- 		        )

--                 SELECT  Id ,

--                         TitleId ,

--                         Initials ,

--                         FirstName ,

--                         Surname ,

--                         KnownAs ,

--                         DateOfBirth ,

--                         MaritalStatusId ,

--                         IdNumber ,

--                         PassportCountryId ,

--                         Nationality ,

--                         LanguageId ,

--                         GenderId ,

--                         EthnicGroupId ,

--                         ImmigrationStatusId ,

--                         TimeGroupId ,

--                         PassportNo ,

--                         SpouseFullName ,

--                         EmployeeNo ,

--                         EmployeeCode ,

--                         TaxNumber ,

--                         TaxStatusId ,

--                         JoinedDate ,

--                         TerminationDate ,

--                         DepartmentId ,

--                         TeamId ,

--                         EmployeeStatusId ,

--                         PhysicalFileNo ,

--                         JobTitleId ,

--                         DivisionId ,

--                         BranchId ,

--                         Active ,

--                         Picture ,

--                         LineManagerId ,

--                         LeaveBalanceAtStart

--                 FROM    INSERTED;

-- 

--         INSERT  INTO dbo.Employees_Audit

--                 ( EmployeeId ,

--                   UpdateType ,

--                   TitleId ,

--                   Initials ,

--                   FirstName ,

--                   Surname ,

--                   KnownAs ,

--                   DateOfBirth ,

--                   MaritalStatusId ,

--                   IdNumber ,

--                   PassportCountryId ,

--                   Nationality ,

--                   LanguageId ,

--                   GenderId ,

--                   EthnicGroupId ,

--                   ImmigrationStatusId ,

--                   TimeGroupId ,

--                   PassportNo ,

--                   SpouseFullName ,

--                   EmployeeNo ,

--                   EmployeeCode ,

--                   TaxNumber ,

--                   TaxStatusId ,

--                   JoinedDate ,

--                   TerminationDate ,

--                   DepartmentId ,

--                   TeamId ,

--                   EmployeeStatusId ,

--                   PhysicalFileNo ,

--                   JobTitleId ,

--                   DivisionId ,

--                   BranchId ,

--                   Active ,

--                   Picture ,

--                   LineManagerId ,

--                   LeaveBalanceAtStart ,

--                   [Timestamp]

--                 )

--                 SELECT  Id ,

--                         'U' ,

--                         TitleId ,

--                         Initials ,

--                         FirstName ,

--                         Surname ,

--                         KnownAs ,

--                         DateOfBirth ,

--                         MaritalStatusId ,

--                         IdNumber ,

--                         PassportCountryId ,

--                         Nationality ,

--                         LanguageId ,

--                         GenderId ,

--                         EthnicGroupId ,

--                         ImmigrationStatusId ,

--                         TimeGroupId ,

--                         PassportNo ,

--                         SpouseFullName ,

--                         EmployeeNo ,

--                         EmployeeCode ,

--                         TaxNumber ,

--                         TaxStatusId ,

--                         JoinedDate ,

--                         TerminationDate ,

--                         DepartmentId ,

--                         TeamId ,

--                         EmployeeStatusId ,

--                         PhysicalFileNo ,

--                         JobTitleId ,

--                         DivisionId ,

--                         BranchId ,

--                         Active ,

--                         Picture ,

--                         LineManagerId ,

--                         LeaveBalanceAtStart ,

--                         GETDATE()

--                 FROM    @Employees;

--     END;
SET FOREIGN_KEY_CHECKS = 1;
