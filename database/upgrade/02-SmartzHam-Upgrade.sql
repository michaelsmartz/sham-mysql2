#--01 Alter shampermissions --ok

ALTER TABLE `shampermissions` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1';

ALTER TABLE `shampermissions` 
RENAME TO  `sham_permissions`;

#--01 Alter systemmodules --ok
ALTER TABLE `systemmodules` 
RENAME TO  `system_modules` ;


#--01 Alter systemsubmodules --ok
ALTER TABLE `systemsubmodules` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `SystemModuleId` `systemmodule_id` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL ;

ALTER TABLE `systemsubmodules` 
CHANGE COLUMN `systemmodule_id` `system_module_id` INT(11) NOT NULL ;

ALTER TABLE `systemsubmodules` 
RENAME TO  `system_sub_modules`;


#--01 Alter shamuserprofiles --ok

ALTER TABLE `shamuserprofiles` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ;

#--01 Alter addresses -- Ok
ALTER TABLE `addresses` 
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(),
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

/*----Error 01 Users table not exist
#--01 Alter users
ALTER TABLE `users` 
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `RememberToken`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

ALTER TABLE `users` 
CHANGE COLUMN `RememberToken` `remember_token` VARCHAR(100) NULL DEFAULT NULL ;

ALTER TABLE `users` 
CHANGE COLUMN `email` `email` VARCHAR(512) NULL DEFAULT NULL AFTER `Id`,
CHANGE COLUMN `password` `password` VARCHAR(100) NULL DEFAULT NULL AFTER `email`,
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `ShamUserProfileId`,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;
----*/
			
#--01 Alter employees -- Ok
ALTER TABLE `employees`
ADD INDEX `IX_Employees_TerminationDate_Active` (`TerminationDate` ASC, `Active` ASC);

			
#--01 Alter teams  --Ok	
ALTER TABLE `teams` 
DROP FOREIGN KEY `FK_Teams_TimeGroups`;

ALTER TABLE `teams` 
CHANGE COLUMN `TimeGroupId` `timegroup_id` INT(11) NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL ;

#ALTER TABLE `teams` 
#DROP FOREIGN KEY `FK_Teams_TimeGroups`;

ALTER TABLE `teams` 
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `timegroup_id` `time_group_id` INT(11) NULL DEFAULT NULL ;

#--01 Alter timegroups  --Ok
ALTER TABLE `timegroups` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL ,
CHANGE COLUMN `StartTime` `start` TIME NULL ,
CHANGE COLUMN `EndTime` `end` TIME NULL DEFAULT NULL ;

ALTER TABLE `timegroups` 
RENAME TO  `time_groups` ;

#--01 Alter timeperiods -- Ok
ALTER TABLE `timeperiods` 
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `StartTime` `start_time` TIME NOT NULL ,
CHANGE COLUMN `EndTime` `end_time` TIME NOT NULL ,
CHANGE COLUMN `TimePeriodType` `time_period_type` ENUM('1', '2') NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL ;

ALTER TABLE `timeperiods` 
RENAME TO  `time_periods`;

#--01 Alter titles --Ok
ALTER TABLE `titles` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `is_active` ;

#--01 Alter days --Ok
ALTER TABLE `days` 
CHANGE COLUMN `daynumber` `day_number` INT(11) NOT NULL ;

#--01 Alter timegroupdays` --Ok
ALTER TABLE `timegroupdays` 
DROP FOREIGN KEY `FK_TimeGroupDays_Days`,
DROP FOREIGN KEY `FK_TimeGroupDays_TimeGroups`,
DROP FOREIGN KEY `FK_TimeGroupDays_TimePeriods`;

ALTER TABLE `timegroupdays` 
DROP COLUMN `Active`,
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `TimeGroupId` `time_group_id` INT(11) NOT NULL ,
CHANGE COLUMN `DayId` `day_id` INT(11) NOT NULL ,
CHANGE COLUMN `TimePeriodId` `time_period_id` INT(11) NOT NULL ;

ALTER TABLE `timegroupdays` 
RENAME TO  `time_group_day_time_period` ;

#--01 Alter genders --Ok
ALTER TABLE `genders` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `is_active` ;

#--01 Alter learningmaterialtypes` --Ok
ALTER TABLE `learningmaterialtypes` 
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ;

ALTER TABLE `learningmaterialtypes` 
RENAME TO  `learning_material_types` ;

#--01 Alter learningmaterials` --Ok
ALTER TABLE `learningmaterials` 
DROP FOREIGN KEY `FK_LearningMaterials_LearningMaterialTypes`,
DROP FOREIGN KEY `FK_LearningMaterials_Modules`;

ALTER TABLE `learningmaterials` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `ModuleId` `module_id` INT(11) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `LearningMaterialTypeId` `learning_material_type_id` INT(11) NOT NULL ,
CHANGE COLUMN `Content` `content` LONGTEXT NOT NULL ;

ALTER TABLE `learningmaterials` 
RENAME TO  `learning_materials` ;

#--01 Alter teamsproducts --Ok
ALTER TABLE `teamsproducts` 
DROP FOREIGN KEY `FK_TeamsProducts_Products`,
DROP FOREIGN KEY `FK_TeamsProducts_Teams`;

ALTER TABLE `teamsproducts` 
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `TeamId` `team_id` INT(11) NOT NULL ,
CHANGE COLUMN `ProductId` `product_id` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ;

ALTER TABLE `teamsproducts` 
RENAME TO  `team_products` ;

#--01 Alter maritalstatuses` -- Ok
ALTER TABLE `maritalstatuses` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `is_active` ;

/*----Error users table does not exist
#--01 Alter users
ALTER TABLE `users` 
ADD INDEX `IX_USERS_ID_DELETED_AT` (`id` ASC, `deleted_at` ASC);
----*/

#--01 Alter laws  --Ok
ALTER TABLE `laws` 
DROP FOREIGN KEY `FK_Laws_Countries`,
DROP FOREIGN KEY `FK_Laws_LawCategories`;

ALTER TABLE `laws` 
DROP COLUMN `UpdatedWhen`,
DROP COLUMN `UpdatedBy`,
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `MainHeading` `mainHeading` VARCHAR(100) NULL DEFAULT NULL ,
CHANGE COLUMN `SubHeading` `subHeading` VARCHAR(100) NULL ,
CHANGE COLUMN `CountryId` `country_id` INT(11) NULL ,
CHANGE COLUMN `LawCategoryId` `lawcategory_id` INT(11) NULL ,
CHANGE COLUMN `Content` `content` LONGTEXT NOT NULL ,
CHANGE COLUMN `Public` `is_public` TINYINT(1) NULL ,
CHANGE COLUMN `ExpiryDate` `expires_on` DATETIME NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ;

#--01 Alter policies  --Ok
ALTER TABLE `policies` 
DROP FOREIGN KEY `FK_Policies_PolicyCategories`;
ALTER TABLE `policies` 
DROP COLUMN `UpdatedWhen`,
DROP COLUMN `UpdatedBy`,
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Title` `title` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Content` `content` LONGTEXT NOT NULL ,
CHANGE COLUMN `PolicyCategoryId` `policycategory_id` INT(11) NOT NULL ,
CHANGE COLUMN `ExpiryDate` `expires_on` DATETIME NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ;

#--01 Alter assets  --ok
ALTER TABLE `assets` 
DROP FOREIGN KEY `FK_Assets_AssetConditions`,
DROP FOREIGN KEY `FK_Assets_AssetGroups`,
DROP FOREIGN KEY `FK_Assets_Suppliers`;

ALTER TABLE `assets` 
DROP INDEX `FK_Assets_AssetConditions`,
DROP INDEX `FK_Assets_AssetGroups`,
DROP INDEX `FK_Assets_Suppliers`;

ALTER TABLE `assets` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `AssetGroupId` `assetgroup_id` INT(11) NOT NULL ,
CHANGE COLUMN `AssetSupplierId` `assetsupplier_id` INT(11) NOT NULL ,
CHANGE COLUMN `Tag` `tag` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `SerialNo` `serialno` VARCHAR(20) NOT NULL ,
CHANGE COLUMN `PurchasePrice` `purchase_price` DECIMAL(19,4) NOT NULL ,
CHANGE COLUMN `PoNumber` `po_number` VARCHAR(20) NOT NULL ,
CHANGE COLUMN `WarrantyExpiryDate` `warrantyexpires_at` DATETIME NOT NULL ,
CHANGE COLUMN `AssetConditionId` `assetcondition_id` INT(11) NOT NULL ,
CHANGE COLUMN `Comments` `comments` VARCHAR(256) NOT NULL ,
CHANGE COLUMN `Available` `is_available` TINYINT(1) NOT NULL DEFAULT '1' ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ;

#---Code below raising errors
#ALTER TABLE `assets` 
#DROP FOREIGN KEY `FK_Assets_AssetConditions`,
#DROP FOREIGN KEY `FK_Assets_AssetGroups`,
#DROP FOREIGN KEY `FK_Assets_Suppliers`;

ALTER TABLE `assets` 
CHANGE COLUMN `assetgroup_id` `asset_group_id` INT(11) NOT NULL ,
CHANGE COLUMN `assetsupplier_id` `asset_supplier_id` INT(11) NOT NULL ,
CHANGE COLUMN `assetcondition_id` `asset_condition_id` INT(11) NOT NULL ;
  
ALTER TABLE `assets` 
CHANGE COLUMN `serialno` `serial_no` VARCHAR(20) NOT NULL ;

/*----Error field does not exist in asset table
ALTER TABLE `assets` 
CHANGE COLUMN `warranty_expiry_date` `warranty_expiry_date` DATE NOT NULL ;  
----*/

#--01 Alter assetsuppliers  --Ok
ALTER TABLE `assetsuppliers` 
CHANGE COLUMN `emailaddress` `email_address` VARCHAR(100) NULL ;

#--01 Alter assetgroups --Ok
ALTER TABLE `assetgroups` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ;

#--01 Alter assetallocations --Ok
ALTER TABLE `assetallocations` 
DROP FOREIGN KEY `FK_AssetAllocations_Assets`,
DROP FOREIGN KEY `FK_AssetAllocations_Employees`;

ALTER TABLE `assetallocations` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `AssetId` `asset_id` INT(11) NOT NULL ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `DateOut` `date_out` DATETIME NOT NULL ,
CHANGE COLUMN `DateIn` `date_in` DATETIME NULL ,
CHANGE COLUMN `Comment` `comment` VARCHAR(1024) NULL ;

ALTER TABLE `assetallocations` 
RENAME TO  `asset_employee` ;

#--01 Alter assetconditions --Ok
ALTER TABLE `assetconditions` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ;

ALTER TABLE `assetconditions` 
RENAME TO  `asset_conditions` ;

#--01 Alter assetgroups --Ok
ALTER TABLE `assetgroups` 
RENAME TO  `asset_groups`;

#--01 Alter courses -- ok
ALTER TABLE `courses` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
CHANGE COLUMN `Public` `is_public` TINYINT(1) NULL DEFAULT 0 ,
CHANGE COLUMN `Overview` `overview` LONGTEXT NULL DEFAULT NULL ,
CHANGE COLUMN `Objectives` `objectives` LONGTEXT NULL DEFAULT NULL ,
CHANGE COLUMN `PassmarkPercentage` `passmark_percentage` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `StartDate` `starts_at` DATETIME NULL DEFAULT NULL ,
CHANGE COLUMN `EndDate` `ends_at` DATETIME NULL DEFAULT NULL ,
CHANGE COLUMN `Durations` `durations` DOUBLE NULL DEFAULT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `durations`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

#--01 Alter modules --ok
ALTER TABLE `modules` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(256) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
CHANGE COLUMN `Public` `is_public` TINYINT(1) NULL DEFAULT 0 ,
CHANGE COLUMN `Overview` `overview` LONGTEXT NULL DEFAULT NULL ,
CHANGE COLUMN `Objectives` `objectives` LONGTEXT NULL DEFAULT NULL ,
CHANGE COLUMN `PassmarkPercentage` `passmark_percentage` DOUBLE NULL DEFAULT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `passmark_percentage`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
ADD INDEX `IDX_active_public_description` (`is_active` ASC, `is_public` ASC, `description` ASC);

#--01 Alter coursemodules` -- ok
ALTER TABLE `coursemodules` 
RENAME TO  `course_modules` ;

#--01 Alter topics --ok
ALTER TABLE `topics` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Header` `header` VARCHAR(300) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(300) NULL ,
CHANGE COLUMN `Data` `data` LONGTEXT NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
ADD INDEX `idx_id_is_active` (`id` ASC, `is_active` ASC);

#--01 Alter moduletopics --Ok
ALTER TABLE `moduletopics` 
DROP FOREIGN KEY `FK_ModuleTopics_Modules`,
DROP FOREIGN KEY `FK_ModuleTopics_Topics`;

ALTER TABLE `moduletopics` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `ModuleId` `module_id` INT(11) NOT NULL ,
CHANGE COLUMN `TopicId` `topic_id` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ;

ALTER TABLE `moduletopics` 
RENAME TO  `module_topic`;

#--01 Alter courseparticipantstatuses` --ok
ALTER TABLE `courseparticipantstatuses` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(300) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

#--01 Alter courseparticipants` --ok
ALTER TABLE `courseparticipants` 
DROP FOREIGN KEY `FK_CourseParticipants_CourseParticipantStatuses`,
DROP FOREIGN KEY `FK_CourseParticipants_Courses`,
DROP FOREIGN KEY `FK_CourseParticipants_Employees`;

ALTER TABLE `courseparticipants` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `CourseId` `course_id` INT(11) NOT NULL ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `CourseParticipantStatusId` `courseparticipantstatus_id` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ;

ALTER TABLE `courseparticipants` 
RENAME TO  `course_employee` ;

#--01 Alter courseprogresses` --Ok
ALTER TABLE `courseprogresses` 
DROP FOREIGN KEY `FK_CourseProgress_Courses`,
DROP FOREIGN KEY `FK_CourseProgress_Employees`,
DROP FOREIGN KEY `FK_CourseProgress_Modules`,
DROP FOREIGN KEY `FK_CourseProgress_Topics`;

ALTER TABLE `courseprogresses` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `CourseId` `course_id` INT(11) NOT NULL ,
CHANGE COLUMN `ModuleId` `module_id` INT(11) NOT NULL ,
CHANGE COLUMN `TopicId` `topic_id` INT(11) NOT NULL ,
CHANGE COLUMN `Completed` `is_completed` TINYINT(1) NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
CHANGE COLUMN `CompletedOn` `completed_at` DATETIME NULL DEFAULT NULL ,
ADD INDEX `IDX_courseprogress_id_employee_course` (`id` ASC, `employee_id` ASC, `course_id` ASC);

ALTER TABLE `courseprogresses` 
RENAME TO  `course_progress` ;

#--01 Alter employees --Ok
ALTER TABLE `employees` 
DROP FOREIGN KEY `FK_Employees_Branches`,
DROP FOREIGN KEY `FK_Employees_Countries`,
DROP FOREIGN KEY `FK_Employees_Departments`,
DROP FOREIGN KEY `FK_Employees_Divisions`,
DROP FOREIGN KEY `FK_Employees_EmployeeStatuses`,
DROP FOREIGN KEY `FK_Employees_EthnicGroups`,
DROP FOREIGN KEY `FK_Employees_Genders`,
DROP FOREIGN KEY `FK_Employees_ImmigrationStatuses`,
DROP FOREIGN KEY `FK_Employees_JobTitles`,
DROP FOREIGN KEY `FK_Employees_Languages`,
DROP FOREIGN KEY `FK_Employees_MaritalStatuses`,
DROP FOREIGN KEY `FK_Employees_TaxStatuses`,
DROP FOREIGN KEY `FK_Employees_Teams`,
DROP FOREIGN KEY `FK_Employees_Titles`;

ALTER TABLE `employees` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `TitleId` `title_id` INT(11) NULL ,
CHANGE COLUMN `Initials` `initials` VARCHAR(10) NULL DEFAULT NULL ,
CHANGE COLUMN `FirstName` `first_name` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `Surname` `surname` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `KnownAs` `known_as` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `DateOfBirth` `birth_date` DATE NULL DEFAULT NULL ,
CHANGE COLUMN `MaritalStatusId` `maritalstatus_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `IdNumber` `id_number` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `PassportCountryId` `passportcountry_id` INT(11) NULL ,
CHANGE COLUMN `Nationality` `nationality` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `LanguageId` `language_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `GenderId` `gender_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `EthnicGroupId` `ethnicgroup_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `ImmigrationStatusId` `immigrationstatus_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `TimeGroupId` `timegroup_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `PassportNo` `passport_no` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `SpouseFullName` `spouse_full_name` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `EmployeeNo` `employee_no` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `EmployeeCode` `employee_code` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `TaxNumber` `tax_number` VARCHAR(50) NULL ,
CHANGE COLUMN `TaxStatusId` `taxstatus_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `JoinedDate` `date_joined` DATETIME NULL DEFAULT NULL ,
CHANGE COLUMN `TerminationDate` `date_terminated` DATETIME NULL DEFAULT NULL ,
CHANGE COLUMN `DepartmentId` `department_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `TeamId` `team_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `EmployeeStatusId` `employeestatus_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `PhysicalFileNo` `physical_file_no` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `JobTitleId` `jobtitle_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `DivisionId` `division_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `BranchId` `branch_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
CHANGE COLUMN `Picture` `picture` LONGTEXT NULL ,
CHANGE COLUMN `LineManagerId` `linemanager_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `LeaveBalanceAtStart` `leave_balance_at_start` INT(11) NULL DEFAULT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `leave_balance_at_start`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

#--01 Alter addresses --Ok
ALTER TABLE `addresses` 
DROP FOREIGN KEY `FK_Addresses_AddressTypes`,
DROP FOREIGN KEY `FK_Addresses_Countries`,
DROP FOREIGN KEY `FK_Addresses_Employees`;

ALTER TABLE `addresses` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `UnitNo` `unit_no` VARCHAR(50) NULL ,
CHANGE COLUMN `Complex` `complex` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `AddrLine1` `addr_line_1` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `AddrLine2` `addr_line_2` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `AddrLine3` `addr_line_3` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `AddrLine4` `addr_line_4` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `City` `city` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `Province` `province` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `CountryId` `country_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `ZipCode` `zip_code` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `AddressTypeId` `addresstype_id` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ;

#--01 Alter companies --Ok
ALTER TABLE `companies` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(50) NOT NULL ;

#--01 Alter rewards --Ok
ALTER TABLE `rewards` 
DROP FOREIGN KEY `FK_Rewards_Employees`;
ALTER TABLE `rewards` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `Description` `description` LONGTEXT NOT NULL ,
CHANGE COLUMN `RewardedBy` `rewarded_by` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `DateReceived` `date_received` DATETIME NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

#--01 Alter disciplinaryactions  --Ok
ALTER TABLE `disciplinaryactions` 
DROP FOREIGN KEY `FK_DisciplinaryActions_DisciplinaryDecisions`,
DROP FOREIGN KEY `FK_DisciplinaryActions_Employees`,
DROP FOREIGN KEY `FK_DisciplinaryActions_Violations`;

ALTER TABLE `disciplinaryactions` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `ViolationId` `violation_id` INT(11) NOT NULL ,
CHANGE COLUMN `ViolationDate` `violation_date` DATETIME NOT NULL ,
CHANGE COLUMN `EmployeeStatement` `employee_statement` LONGTEXT NOT NULL ,
CHANGE COLUMN `EmployerStatement` `employer_statement` LONGTEXT NOT NULL ,
CHANGE COLUMN `Decision` `decision` LONGTEXT NOT NULL ,
CHANGE COLUMN `UpdatedBy` `updated_by` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
CHANGE COLUMN `IssueDate` `date_issued` DATETIME NULL ,
CHANGE COLUMN `ExpiryDate` `date_expires` DATETIME NULL DEFAULT NULL ,
CHANGE COLUMN `DisciplinaryDecisionId` `disciplinary_decision_id` INT(11) NULL DEFAULT NULL, 
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `disciplinary_decision_id`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

ALTER TABLE `disciplinaryactions` 
RENAME TO  `disciplinary_actions` ;

/*----Error Check if this table has been renamed properly
#--01 Alter shamuserprofile_shampermission`			
ALTER TABLE `shamuserprofile_shampermission` 
CHANGE COLUMN `shamuserprofile_id` `sham_user_profile_id` INT(11) NOT NULL ,
CHANGE COLUMN `shampermission_id` `sham_permission_id` INT(11) NOT NULL ,
CHANGE COLUMN `systemsubmodule_id` `system_sub_module_id` INT(11) NOT NULL ;

ALTER TABLE `shamuserprofile_shampermission` 
ADD INDEX `IX_shamuserprofile_shampermission_profile_id` (`sham_user_profile_id` ASC);

----*/

#--01 Alter systemmodules` -- Ok
ALTER TABLE `system_modules` 
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ;

ALTER TABLE `system_modules` 
ADD INDEX `IX_SYSTEMMODULES_ACTIVE` (`is_active` ASC);

#--01 Alter topicattachments --Ok
ALTER TABLE `topicattachments` 
DROP FOREIGN KEY `FK_TopicAttachments_LearningMaterialTypes`,
DROP FOREIGN KEY `FK_TopicAttachments_Topics`;

ALTER TABLE `topicattachments` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `TopicId` `topic_id` INT(11) NOT NULL ,
CHANGE COLUMN `LearningMaterialTypeId` `learning_material_type_id` INT(11) NOT NULL ,
CHANGE COLUMN `Content` `content` LONGTEXT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
CHANGE COLUMN `Comment` `comment` VARCHAR(100) NULL ,
CHANGE COLUMN `OriginalFileName` `original_file_name` VARCHAR(512) NULL DEFAULT NULL ;

ALTER TABLE `topicattachments` 
RENAME TO  `topic_attachments`;

#--01 Alter trainingsessions`
ALTER TABLE `trainingsessions` 
DROP FOREIGN KEY `FK_TrainingSessions_Courses1`,
DROP FOREIGN KEY `FK_TrainingSessions_TrainingDeliveryMethods`;

ALTER TABLE `trainingsessions` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `CourseId` `course_id` INT(11) NOT NULL ,
CHANGE COLUMN `TrainingDeliveryMethodId` `training_delivery_method_id` INT(11) NOT NULL ,
CHANGE COLUMN `Final` `is_final` TINYINT(1) NULL DEFAULT 0 ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_final`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ;

ALTER TABLE `trainingsessions` 
RENAME TO  `course_training_sessions`;

#--01 Alter trainingdeliverymethods` --Ok
ALTER TABLE `trainingdeliverymethods` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

ALTER TABLE `trainingdeliverymethods` 
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `description`;  

ALTER TABLE `trainingdeliverymethods` 
RENAME TO  `training_delivery_methods`;

#--01 Alter taxstatuses` --Ok
ALTER TABLE `taxstatuses` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ;

#--01 Alter departments --Ok
ALTER TABLE `departments` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `description`,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

ALTER TABLE `departments` 
ADD INDEX `IX_DEPARTMENTS_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC);

#--01 Alter divisions --Ok
ALTER TABLE `divisions` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ;

#--01 Alter branches
ALTER TABLE `branches` 
DROP FOREIGN KEY `FK_Branches_Companies1`; 

ALTER TABLE `branches` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `CompanyId` `company_iId` INT(11) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `description`,
ADD INDEX `IX_BRANCHES_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC);

  #--01 Alter addresstypes --Ok
ALTER TABLE `addresstypes` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 1 AFTER `description`,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_system_predefined`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;
  
ALTER TABLE `addresstypes` 
RENAME TO  `address_types` ;

#--01 Alter addresses --Ok
#ALTER TABLE `addresses` 
#DROP FOREIGN KEY `FK_Addresses_AddressTypes`;

ALTER TABLE `addresses` 
CHANGE COLUMN `addresstype_id` `address_type_id` INT(11) NOT NULL ;

#--01 Alter ethnicgroups`
ALTER TABLE `ethnicgroups` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL ;  

ALTER TABLE `ethnicgroups`
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `Active`, 
ADD INDEX `IX_ETHNIC_GROUPS_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC);

ALTER TABLE `ethnicgroups` 
RENAME TO  `ethnic_groups` ;

#--01 Alter employees
#ALTER TABLE `employees` 
#DROP FOREIGN KEY `FK_Employees_EthnicGroups`;

ALTER TABLE `employees` 
CHANGE COLUMN `ethnicgroup_id` `ethnic_group_id` INT(11) NULL DEFAULT NULL ;

#ALTER TABLE `employees` 
#DROP FOREIGN KEY `FK_Employees_ImmigrationStatuses`;

ALTER TABLE `employees` 
CHANGE COLUMN `immigrationstatus_id` `immigration_status_id` INT(11) NULL DEFAULT NULL ;

#--01 Alter immigrationstatuses
ALTER TABLE `immigrationstatuses` 
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `Active`,
ADD INDEX `IX_IMMIGRATION_STATUSES_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC);

ALTER TABLE `immigrationstatuses` 
RENAME TO  `immigration_statuses` ;

#--01 Alter jobtitles
ALTER TABLE `jobtitles` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Manager` `is_manager` TINYINT(1) NOT NULL ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `is_manager`,
ADD INDEX `IX_JOB_TITLES_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC);

ALTER TABLE `jobtitles` 
RENAME TO  `job_titles` ;

ALTER TABLE `job_titles` 
ADD INDEX `IX_JOB_TITLES_IS_MANAGER` (`is_manager` ASC);
  
#--01 Alter branches
#ALTER TABLE `branches` 
#DROP FOREIGN KEY `FK_Branches_Companies1`;

ALTER TABLE `branches` 
CHANGE COLUMN `company_iId` `company_id` INT(11) NOT NULL ;

#--01 Alter employees
#ALTER TABLE `employees` 
#DROP FOREIGN KEY `FK_Employees_Countries`,
#DROP FOREIGN KEY `FK_Employees_EmployeeStatuses`,
#DROP FOREIGN KEY `FK_Employees_MaritalStatuses`,
#DROP FOREIGN KEY `FK_Employees_TaxStatuses`;

ALTER TABLE `employees` 
CHANGE COLUMN `maritalstatus_id` `marital_status_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `passportcountry_id` `passport_country_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `timegroup_id` `time_group_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `taxstatus_id` `tax_status_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `employeestatus_id` `employee_status_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `linemanager_id` `line_manager_id` INT(11) NULL DEFAULT NULL ;

#--01 Alter skills
ALTER TABLE `skills` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
Add COLUMN `Level` SMALLINT NULL ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `level`,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_system_predefined`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
ADD INDEX `IX_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC);

#--01 Alter employeeskills --Ok
ALTER TABLE `employeeskills` 
DROP FOREIGN KEY `FK_EmployeeSkills_Employees`,
DROP FOREIGN KEY `FK_EmployeeSkills_Skills`;

ALTER TABLE `employeeskills` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `SkillId` `sklll_id` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '0' ;

ALTER TABLE `employeeskills` 
RENAME TO  `employee_skill` ;

#--01 Alter qualifications --Ok
ALTER TABLE `qualifications` 
DROP FOREIGN KEY `FK_Qualifications_Employees`;

ALTER TABLE `qualifications` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `Reference` `reference` VARCHAR(50) NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `Institution` `institution` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `DateObtained` `obtained_on` DATETIME NULL DEFAULT NULL ,
CHANGE COLUMN `StudentNo` `student_no` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;


  
#--01 Alter disciplinarydecisions --Ok
ALTER TABLE `disciplinarydecisions` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `is_active`,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_system_predefined`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`, RENAME TO  `disciplinary_decisions` ;

#--01 Alter employeestatuses --Ok
ALTER TABLE `employeestatuses` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `is_active`,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_system_predefined`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
ADD INDEX `IX_EMPLOYEE_STATUS_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC);

ALTER TABLE `employeestatuses` 
RENAME TO  `employee_statuses`;

#--01 Alter emailaddresstypes` --Ok
ALTER TABLE `emailaddresstypes` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `description`,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_system_predefined`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

ALTER TABLE `emailaddresstypes` 
ADD INDEX `IX_EMAIL_ADDRESS_TYPES_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC);

ALTER TABLE `emailaddresstypes` 
RENAME TO  `email_address_types` ;

#--01 Alter emailaddresses --Ok
ALTER TABLE `emailaddresses` 
RENAME TO  `email_addresses` ;

#--01 Alter course_modules --ok
ALTER TABLE `course_modules` 
CHANGE COLUMN `optional` `is_optional` TINYINT(1) NOT NULL DEFAULT 0 ;

#--01 Alter commentdetails --Ok
ALTER TABLE `commentdetails` 
DROP FOREIGN KEY `FK_CommentDetails_CourseDiscussions`,
DROP FOREIGN KEY `FK_CommentDetails_Employees`,
DROP FOREIGN KEY `FK_CommentDetails_ThreadStatuses`;

ALTER TABLE `commentdetails` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `CourseDiscussionId` `course_discussion_iId` INT(11) NOT NULL ,
CHANGE COLUMN `Comment` `comment` LONGTEXT NOT NULL ,
CHANGE COLUMN `PostDate` `date_posted` DATETIME NULL ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `ThreadStatusId` `thread_status_id` INT(11) NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

#--01 Alter taxstatuses --Ok
ALTER TABLE `taxstatuses` 
RENAME TO  `tax_statuses` ;

#--01 Alter sysconfigvalues --Ok
ALTER TABLE `sysconfigvalues` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Key` `key` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Value` `value` VARCHAR(100) NOT NULL ,
ADD INDEX `IX_SYS_CONFIG_VALUES_KEY` (`key` ASC);

ALTER TABLE `sysconfigvalues` 
RENAME TO  `sys_config_values` ;

#--01 Alter laws --Ok
#ALTER TABLE `laws` 
#DROP FOREIGN KEY `FK_Laws_LawCategories`;

ALTER TABLE `laws` 
CHANGE COLUMN `lawcategory_id` `law_category_id` INT(11) NULL DEFAULT NULL ;

ALTER TABLE `laws` 
CHANGE COLUMN `mainHeading` `main_heading` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `subHeading` `sub_heading` VARCHAR(100) NULL DEFAULT NULL ;

/*----Error check if table policy_documents has been renamed
  #--01 Alter policy_documents
ALTER TABLE `policy_document` 
RENAME TO  `policy_documents` ;
----*/

#--01 Alter policies --Ok
#ALTER TABLE `policies` 
#DROP FOREIGN KEY `FK_Policies_PolicyCategories`;

ALTER TABLE `policies` 
CHANGE COLUMN `policycategory_id` `policy_category_id` INT(11) NULL DEFAULT NULL ;

ALTER TABLE `policies` 
CHANGE COLUMN `expires_on` `expires_on` DATE NULL DEFAULT NULL ;

#--01 Alter laws --Ok
ALTER TABLE `laws` 
CHANGE COLUMN `expires_on` `expires_on` DATE NULL DEFAULT NULL ;

#--01 Alter telephonenumbertypes --ok
ALTER TABLE `telephonenumbertypes` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 1 AFTER `description`,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_system_predefined`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
ADD INDEX `IX_TELEPHONE_NUMBER_TYPES_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC), RENAME TO  `telephone_number_types` ;

#--01 Alter emailaddresstypes --Ok
ALTER TABLE `employeeattachmenttypes` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `is_active`,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_system_predefined`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
ADD INDEX `IX_EMPLOYEE_ATTACHMENT_TYPES_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC), RENAME TO  `employee_attachment_types` ;

#--01 Alter employeeattachments --Ok
ALTER TABLE `employeeattachments` 
DROP FOREIGN KEY `FK_EmployeeAttachments_EmployeeAttachmentTypes`,
DROP FOREIGN KEY `FK_EmployeeAttachments_Employees`;

ALTER TABLE `employeeattachments` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `Comment` `comment` VARCHAR(100) NULL ,
CHANGE COLUMN `EmployeeAttachmentTypeId` `employee_attachment_type_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `OriginalFileName` `original_file_name` VARCHAR(512) NOT NULL ,
CHANGE COLUMN `Content` `content` LONGBLOB NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '0' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

ALTER TABLE `employeeattachments` 
RENAME TO  `employee_attachments` ;  

#--01 Alter customers -- Ok
ALTER TABLE `customers` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(100) NOT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `name`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

#--01 Alter documentcategories --Ok
ALTER TABLE `documentcategories` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '0' ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `is_active`,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_system_predefined`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
ADD INDEX `IX_DOCUMENT_CATEGORIES` (`is_system_predefined` ASC), RENAME TO  `document_categories` ;

#--01 Alter documenttypes --Ok
ALTER TABLE `documenttypes` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Extension` `extension` VARCHAR(10) NOT NULL ,
CHANGE COLUMN `Description` `description` CHAR(10) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `is_active`,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_system_predefined`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
ADD INDEX `IX_DOCUMENT_TYPES_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC), RENAME TO  `document_types` ;

#--01 Alter modulequestiontypes --Ok
ALTER TABLE `modulequestiontypes` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(300) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL AFTER `is_active`,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_system_predefined`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
ADD INDEX `IX_MODULE_QUESTION_TYPES_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC), RENAME TO  `module_question_types` ;

#--01 Alter modulequestions --Ok
ALTER TABLE `modulequestions` 
DROP FOREIGN KEY `FK_ModuleQuestions_ModuleQuestionTypes`;

ALTER TABLE `modulequestions` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `ModuleQuestionTypeId` `module_question_type_id` INT(11) NOT NULL ,
CHANGE COLUMN `Title` `title` VARCHAR(300) NULL ,
CHANGE COLUMN `Points` `points` DOUBLE NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

ALTER TABLE `modulequestions` 
RENAME TO  `module_questions` ;

#--01 Alter assessmenttypes --Ok
ALTER TABLE `assessmenttypes` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `is_active`,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_system_predefined`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
ADD INDEX `IX_ASSESSMENT_TYPES` (`is_system_predefined` ASC), RENAME TO  `assessment_types` ;

#--01 Alter products --Ok
ALTER TABLE `products` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

#--01 Alter threadstatuses --Ok
ALTER TABLE `threadstatuses` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(300) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT 1 ,
ADD COLUMN `is_system_predefined` TINYINT(1) NULL DEFAULT 0 AFTER `is_active`,
ADD COLUMN `created_by` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_system_predefined`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_by`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
ADD INDEX `IX_THREAD_STATUSES_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC), RENAME TO  `thread_statuses` ;

#--01 Alter coursediscussions --Ok
ALTER TABLE `coursediscussions` 
DROP FOREIGN KEY `FK_CourseDiscussions_Courses`,
DROP FOREIGN KEY `FK_CourseDiscussions_Employees`,
DROP FOREIGN KEY `FK_CourseDiscussions_ThreadStatuses`;

ALTER TABLE `coursediscussions` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `CourseId` `course_id` INT(11) NOT NULL ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `Title` `title` LONGTEXT NULL ,
CHANGE COLUMN `ThreadStatusId` `thread_status_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `PostDate` `date_posted` DATETIME NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
CHANGE COLUMN `ParentId` `parent_id` INT(11) NULL ,
ADD INDEX `IX_COURSE_DISCUSSIONS_PARENT_ID` (`parent_id` ASC);

ALTER TABLE `coursediscussions` 
RENAME TO  `course_discussions`;

#--01 Alter Assessments Table for QA -- Ok
ALTER TABLE `assessments` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(1024) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(1024) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
CHANGE COLUMN `PassmarkPercentage` `passmark_percentage` DOUBLE NULL DEFAULT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `passmark_percentage`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

#--02 Alter AssessmentCategories --Ok
ALTER TABLE `assessmentcategories` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(1024) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(1024) NOT NULL ,
CHANGE COLUMN `ELearningModule` `eLearning_module` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Threshold` `threshold` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
CHANGE COLUMN `PassmarkPercentage` `passmark_percentage` DOUBLE NULL DEFAULT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `passmark_percentage`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `assessmentcategories` 
RENAME TO  `assessment_categories` ;


#--03Alter AssessmentsAssessmentCategories --Ok

ALTER TABLE `assessmentsassessmentcategories` 
DROP FOREIGN KEY `FK_AssessmentsAssessmentCategories_AssessmentCategories`,
DROP FOREIGN KEY `FK_AssessmentsAssessmentCategories_Assessments`;

#--
ALTER TABLE `assessmentsassessmentcategories` 
DROP INDEX `FK_AssessmentsAssessmentCategories_Assessments` ,
DROP INDEX `FK_AssessmentsAssessmentCategories_AssessmentCategories` ;

ALTER TABLE `assessmentsassessmentcategories` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `AssessmentId` `assessment_id` INT(11) NOT NULL ,
CHANGE COLUMN `AssessmentCategoryId` `assessmentcategory_id` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ;

ALTER TABLE `assessmentsassessmentcategories` 
RENAME TO  `assessments_assessment_category` ;

#--04Alter CategoryQuestions table -- Ok
ALTER TABLE `categoryquestions` 
DROP FOREIGN KEY `FK_CategoryQuestions_CategoryQuestionTypes`;

ALTER TABLE `categoryquestions` 
DROP INDEX `FK_CategoryQuestions_CategoryQuestionTypes`;

ALTER TABLE `categoryquestions` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `CategoryQuestionTypeId` `categoryquestiontype_Id` INT(11) NOT NULL ,
CHANGE COLUMN `Title` `title` VARCHAR(1024) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(1024) NULL DEFAULT NULL ,
CHANGE COLUMN `Points` `points` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
CHANGE COLUMN `ZeroMark` `is_zeromark` TINYINT(1) NULL DEFAULT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_zeromark`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;
  
ALTER TABLE `categoryquestions` 
RENAME TO  `category_questions` ;

#--05Alter CategoryQuestionChoices table  --Ok
ALTER TABLE `categoryquestionchoices` 
DROP FOREIGN KEY `FK_CategoryQuestionChoices_CategoryQuestions2`;

ALTER TABLE `categoryquestionchoices` 
DROP INDEX `FK_CategoryQuestionChoices_CategoryQuestions2`;

ALTER TABLE `categoryquestionchoices` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `CategoryQuestionId` `categoryquestion_id` INT(11) NOT NULL ,
CHANGE COLUMN `ChoiceText` `choicetext` LONGTEXT NOT NULL ,
CHANGE COLUMN `Points` `points` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;
  
ALTER TABLE `categoryquestionchoices` 
RENAME TO  `category_question_choices` ;

#--06 ALter CategoryQuestionTypes table --Ok
ALTER TABLE `categoryquestiontypes` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `categoryquestiontypes` 
RENAME TO  `category_question_types` ;

#--07 ALter ProductCategories table --Ok
ALTER TABLE `productcategories` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(256) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '0' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `productcategories` 
RENAME TO  `product_categories` ;

#--08 ALter EvaluationStatuses table  --Ok
ALTER TABLE `evaluationstatuses` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `evaluationstatuses` 
RENAME TO  `evaluation_statuses` ;

#--09 ALter assessmentcategoriescategoryquestions` table --Ok
ALTER TABLE `assessmentcategoriescategoryquestions` 
RENAME TO  `assessmentcategory_categoryquestion` ;

ALTER TABLE `assessmentcategory_categoryquestion` 
DROP FOREIGN KEY `FK_AssessmentCategoriesCategoryQuestions_AssessmentCategories`,
DROP FOREIGN KEY `FK_AssessmentCategoriesCategoryQuestions_CategoryQuestions`;

ALTER TABLE `assessmentcategory_categoryquestion` 
DROP INDEX `FK_AssessmentCategoriesCategoryQuestions_AssessmentCategories`,
DROP INDEX `FK_AssessmentCategoriesCategoryQuestions_CategoryQuestions`;

ALTER TABLE `assessmentcategory_categoryquestion` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `AssessmentCategoryId` `assessmentcategory_id` INT(11) NOT NULL ,
CHANGE COLUMN `CategoryQuestionId` `categoryquestion_id` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `assessmentcategory_categoryquestion` 
RENAME TO  `assessment_category_category_question` ;

#--10 ALter 'Evaluations' table --Ok
ALTER TABLE `evaluations` 
DROP FOREIGN KEY `FK_Evaluations_Assessments`,
DROP FOREIGN KEY `FK_Evaluations_Departments`,
DROP FOREIGN KEY `FK_Evaluations_Employees`,
DROP FOREIGN KEY `FK_Evaluations_Employees1`,
DROP FOREIGN KEY `FK_Evaluations_EvaluationStatuses`,
DROP FOREIGN KEY `FK_Evaluations_Languages`,
DROP FOREIGN KEY `FK_Evaluations_ProductCategories`;

ALTER TABLE `evaluations` 
DROP INDEX `FK_Evaluations_Assessments`,
DROP INDEX `FK_Evaluations_Departments`,
DROP INDEX `FK_Evaluations_Employees`,
DROP INDEX `FK_Evaluations_Employees1`,
DROP INDEX `FK_Evaluations_EvaluationStatuses`,
DROP INDEX `FK_Evaluations_Languages`,
DROP INDEX `FK_Evaluations_ProductCategories`;


ALTER TABLE `evaluations` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `AssessmentId` `assessment_id` INT(11) NOT NULL ,
CHANGE COLUMN `UserEmployeeId` `useremployee_id` INT(11) NOT NULL ,
CHANGE COLUMN `DepartmentId` `department_id` INT(11) NOT NULL ,
CHANGE COLUMN `ReferenceNo` `referenceno` VARCHAR(200) NULL DEFAULT NULL ,
CHANGE COLUMN `ReferenceSource` `referencesource` VARCHAR(200) NULL DEFAULT NULL ,
CHANGE COLUMN `ProductCategoryId` `productcategory_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `LanguageId` `language_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `FeedbackDate` `feedback_date` DATETIME(6) NOT NULL ,
CHANGE COLUMN `QaSample` `qasample` LONGBLOB NULL DEFAULT NULL ,
CHANGE COLUMN `Comments` `comments` VARCHAR(512) NULL DEFAULT NULL ,
CHANGE COLUMN `EvaluationStatusId` `evaluationstatus_id` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
CHANGE COLUMN `CreatedByEmployeeId` `createdbyemployee_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `OriginalFileName` `originalfilename` VARCHAR(256) NULL DEFAULT NULL ,
CHANGE COLUMN `UseContent` `is_usecontent` TINYINT(1) NULL DEFAULT NULL ,
CHANGE COLUMN `UrlPath` `urlpath` VARCHAR(256) NULL DEFAULT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `urlpath`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

#--11 ALter 'EvaluationAssessors' table --Ok  
ALTER TABLE `evaluationassessors` 
DROP FOREIGN KEY `FK_EvaluationAssessors_Employees`,
DROP FOREIGN KEY `FK_EvaluationAssessors_Evaluations`;

ALTER TABLE `evaluationassessors` 
DROP INDEX `FK_EvaluationAssessors_Employees`,
DROP INDEX `FK_EvaluationAssessors_Evaluations`;

ALTER TABLE `evaluationassessors` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EvaluationId` `evaluation_id` INT(11) NOT NULL ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `Completed` `is_completed` TINYINT(1) NOT NULL DEFAULT '0' ,
CHANGE COLUMN `Summary` `summary` LONGTEXT NULL DEFAULT NULL ,
CHANGE COLUMN `Comments` `comments` LONGTEXT NULL DEFAULT NULL ,
CHANGE COLUMN `StartTime` `starttime` DATETIME(6) NULL DEFAULT NULL ,
CHANGE COLUMN `EndTime` `endtime` DATETIME(6) NULL DEFAULT NULL ,
CHANGE COLUMN `Duration` `duration` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `evaluationassessors` 
RENAME TO  `evaluation_assessors` ;


#--12 ALter 'EvaluationResults' table  --Ok 
ALTER TABLE `evaluationresults` 
DROP FOREIGN KEY `FK_EvaluationResults_AssessmentCategories`,
DROP FOREIGN KEY `FK_EvaluationResults_Assessments`,
DROP FOREIGN KEY `FK_EvaluationResults_CategoryQuestions`,
DROP FOREIGN KEY `FK_EvaluationResults_Employees`,
DROP FOREIGN KEY `FK_EvaluationResults_Evaluations`;

ALTER TABLE `evaluationresults` 
DROP INDEX `FK_EvaluationResults_AssessmentCategories`,
DROP INDEX `FK_EvaluationResults_Assessments`,
DROP INDEX `FK_EvaluationResults_CategoryQuestions`,
DROP INDEX `FK_EvaluationResults_Employees`,
DROP INDEX `FK_EvaluationResults_Evaluations`;

ALTER TABLE `evaluationresults` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EvaluationId` `evaluation_id` INT(11) NOT NULL ,
CHANGE COLUMN `AssessorEmployeeId` `assessoremployee_id` INT(11) NOT NULL ,
CHANGE COLUMN `AssessmentId` `assessment_id` INT(11) NOT NULL ,
CHANGE COLUMN `AssessmentCategoryId` `assessmentcategory_id` INT(11) NOT NULL ,
CHANGE COLUMN `CategoryQuestionId` `categoryquestion_id` INT(11) NOT NULL ,
CHANGE COLUMN `Content` `content` LONGTEXT NOT NULL ,
CHANGE COLUMN `Points` `points` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;
  
ALTER TABLE `evaluationresults` 
RENAME TO  `evaluation_results` ;

#---- employee_skills
ALTER TABLE `employee_skill` 
CHANGE COLUMN `sklll_id` `skill_id` INT(11) NOT NULL ;

ALTER TABLE `announcements` 
DROP FOREIGN KEY `FK_Announcements_AnnouncementStatuses`;

#---- announcements
ALTER TABLE `announcements` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Title` `title` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(256) NOT NULL ,
CHANGE COLUMN `StartDate` `date_start` DATETIME(6) NOT NULL ,
CHANGE COLUMN `EndDate` `date_end` DATETIME(6) NOT NULL ,
CHANGE COLUMN `Priority` `priority` TINYINT(3) UNSIGNED NOT NULL DEFAULT 1,
CHANGE COLUMN `AnnouncementStatusId` `announcement_status_id` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

#---- announcementdepartments
ALTER TABLE `announcementsdepartments` 
DROP FOREIGN KEY `FK_AnnouncementsDepartments_Announcements`,
DROP FOREIGN KEY `FK_AnnouncementsDepartments_Departments`;

ALTER TABLE `announcementsdepartments` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `AnnouncementId` `announcement_id` INT(11) NOT NULL ,
CHANGE COLUMN `DepartmentId` `department_id` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `announcementsdepartments` 
RENAME TO  `announcement_department` ;


#---- announcementstatuses
ALTER TABLE `announcementstatuses` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `announcementstatuses` 
RENAME TO  `announcement_statuses` ;

#---- countries
ALTER TABLE `countries` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL ,
CHANGE COLUMN `Preferred` `is_preferred` TINYINT(1) NULL DEFAULT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_preferred`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

#---- days
ALTER TABLE `days` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

#---- EmployeeAttendanceRecords
ALTER TABLE `employeeattendancerecords` 
DROP FOREIGN KEY `FK_EmployeeAttendanceRecords_Employees`;

ALTER TABLE `employeeattendancerecords` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `Date` `date` DATE NOT NULL ,
CHANGE COLUMN `TimeIn` `time_in` TIME(6) NOT NULL ,
CHANGE COLUMN `TimeOut` `time_out` TIME(6) NULL DEFAULT NULL ,
CHANGE COLUMN `SysUserCreated` `sys_user_created` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `DateTimeCreated` `date_created` DATETIME(6) NULL DEFAULT NULL ,
CHANGE COLUMN `SysUserUpdated` `sys_user_updated` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `DateTimeUpdated` `date_updated` DATETIME(6) NULL DEFAULT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `date_updated`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `employeeattendancerecords` 
RENAME TO  `employee_attendance_records` ;

#---- events
ALTER TABLE `events` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NULL DEFAULT NULL ,
CHANGE COLUMN `SystemEvent` `is_system_event` TINYINT(1) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL ,
ADD COLUMN `eventscol` VARCHAR(45) NULL AFTER `is_active`,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `eventscol`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

#--- eventtaskinstances
ALTER TABLE `eventtaskinstances` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EventTaskId` `event_task_id` INT(11) NOT NULL ,
CHANGE COLUMN `EmployeeCreatedId` `employee_created_Id` INT(11) NOT NULL ,
CHANGE COLUMN `DateTimeCreated` `date_created` DATETIME(6) NOT NULL ,
CHANGE COLUMN `DueDate` `date_due` DATETIME(6) NULL DEFAULT NULL ,
CHANGE COLUMN `Completed` `is_completed` TINYINT(1) NULL DEFAULT NULL ,
CHANGE COLUMN `LinkTypeId` `link_type_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `TargetId` `target_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `Comment` `comment` VARCHAR(250) NULL DEFAULT NULL ,
CHANGE COLUMN `EmployeeAllocatedId` `employee_allocated_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `DateTimeCompleted` `date_completed` DATETIME(6) NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `eventtaskinstances` 
RENAME TO  `event_task_instances`;


#---- eventtasks
ALTER TABLE `eventtasks` 
DROP FOREIGN KEY `FK__EventTask__Event__729BEF18`,
DROP FOREIGN KEY `FK__EventTask__TaskI__73901351`;

ALTER TABLE `eventtasks` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EventId` `event_id` INT(11) NOT NULL ,
CHANGE COLUMN `TaskId` `task_id` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `eventtasks` 
RENAME TO  `event_task` ;

#---- forms
ALTER TABLE `forms` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Title` `title` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Data` `sata` LONGTEXT NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

#---- historydepartments
ALTER TABLE `historydepartments` 
DROP FOREIGN KEY `FK_HistoryDepartments_Departments`,
DROP FOREIGN KEY `FK_HistoryDepartments_Employees`;

ALTER TABLE `historydepartments` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `DepartmentId` `department_id` INT(11) NOT NULL ,
CHANGE COLUMN `Date` `date` DATETIME(6) NOT NULL ,
CHANGE COLUMN `UpdatedBy` `updated_by` VARCHAR(50) NOT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `updated_by`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `historydepartments` 
RENAME TO  `history_departments`;

#---- historydisciplinaryactions
ALTER TABLE `historydisciplinaryactions` 
DROP FOREIGN KEY `FK_HistoryDisciplinaryActions_DisciplinaryActions`,
DROP FOREIGN KEY `FK_HistoryDisciplinaryActions_Employees`;

ALTER TABLE `historydisciplinaryactions` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `DisciplinaryActionId` `disciplinary_action_id` INT(11) NOT NULL ,
CHANGE COLUMN `Date` `date_occurred` DATETIME(6) NOT NULL ,
CHANGE COLUMN `UpdatedBy` `updated_by_employeeid` VARCHAR(50) NOT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `updated_by_employeeid`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `historydisciplinaryactions` 
RENAME TO  `history_disciplinary_actions` ;

#---- historyjobtitles
ALTER TABLE `historyjobtitles` 
DROP FOREIGN KEY `FK_HistoryJobTitles_Employees`,
DROP FOREIGN KEY `FK_HistoryJobTitles_JobTitles`;

ALTER TABLE `historyjobtitles` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `JobTitleId` `job_title_id` INT(11) NOT NULL ,
CHANGE COLUMN `Date` `date_occurred` DATETIME(6) NOT NULL ,
CHANGE COLUMN `UpdatedBy` `updated_by_employee_id` VARCHAR(50) NOT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `updated_by_employee_id`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `historyjobtitles` 
RENAME TO  `history_job_titles` ;

#---- historyjoinsterminations
ALTER TABLE `historyjoinsterminations` 
DROP FOREIGN KEY `FK_HistoryJoinsTerminations_Employees`;

ALTER TABLE `historyjoinsterminations` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `Joined` `is_joined` TINYINT(1) NOT NULL ,
CHANGE COLUMN `Date` `date_occurred` DATETIME(6) NOT NULL ,
CHANGE COLUMN `UpdatedBy` `updated_by_employee_id` VARCHAR(50) NOT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `updated_by_employee_id`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `historyjoinsterminations` 
RENAME TO  `history_joins_terminations` ;


#---- historyrewards
ALTER TABLE `historyrewards` 
DROP FOREIGN KEY `FK_HistoryRewards_Employees`,
DROP FOREIGN KEY `FK_HistoryRewards_Rewards`;

ALTER TABLE `historyrewards` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `RewardId` `reward_id` INT(11) NOT NULL ,
CHANGE COLUMN `Date` `date_occurred` DATETIME(6) NOT NULL ,
CHANGE COLUMN `UpdatedBy` `updated_by_employee_id` VARCHAR(50) NOT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `updated_by_employee_id`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `historyrewards` 
RENAME TO  `history_rewards` ;

#---- languages
ALTER TABLE `languages` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL ,
CHANGE COLUMN `Preferred` `is_preferred` TINYINT(1) NULL DEFAULT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_preferred`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

#---- lawcategories
ALTER TABLE `lawcategories` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

#---- linktypes
ALTER TABLE `linktypes` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `linktypes` 
RENAME TO  `link_types`;

#---- moduleassessmentquestions
ALTER TABLE `moduleassessmentquestions` 
DROP FOREIGN KEY `FK_ModuleAssessmentQuestions_ModuleAssessments`,
DROP FOREIGN KEY `FK_ModuleAssessmentQuestions_ModuleQuestions`;

ALTER TABLE `moduleassessmentquestions` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `ModuleAssessmentId` `module_assessment_id` INT(11) NOT NULL ,
CHANGE COLUMN `ModuleQuestionId` `module_question_id` INT(11) NOT NULL ,
CHANGE COLUMN `Sequence` `sequence` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `moduleassessmentquestions` 
RENAME TO  `module_assessment_questions`;

#---- moduleassessmentresponsedetails
ALTER TABLE `moduleassessmentresponsedetails` 
DROP FOREIGN KEY `FK_ModuleAssessmentResponseDetails_ModuleAssessmentResponses`,
DROP FOREIGN KEY `FK_ModuleAssessmentResponseDetails_ModuleAssessments`,
DROP FOREIGN KEY `FK_ModuleAssessmentResponseDetails_ModuleQuestions`,
DROP FOREIGN KEY `FK_ModuleAssessmentResponseDetails_Modules`;

ALTER TABLE `moduleassessmentresponsedetails` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `ModuleAssessmentId` `module_assessment_id` INT(11) NOT NULL ,
CHANGE COLUMN `ModuleId` `module_id` INT(11) NOT NULL ,
CHANGE COLUMN `ModuleQuestionId` `module_question_id` INT(11) NOT NULL ,
CHANGE COLUMN `ModuleAssessmentResponseId` `module_assessment_response_id` INT(11) NOT NULL ,
CHANGE COLUMN `Content` `content` LONGTEXT NULL DEFAULT NULL ,
CHANGE COLUMN `Points` `points` DOUBLE NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
CHANGE COLUMN `Sequence` `sequence` INT(11) NULL DEFAULT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `sequence`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `moduleassessmentresponsedetails` 
RENAME TO  `module_assessment_response_details` ;

#---- moduleassessmentresponses
ALTER TABLE `moduleassessmentresponses` 
DROP FOREIGN KEY `FK_ModuleAssessmentResponses_Courses`,
DROP FOREIGN KEY `FK_ModuleAssessmentResponses_Employees`,
DROP FOREIGN KEY `FK_ModuleAssessmentResponses_ModuleAssessments`,
DROP FOREIGN KEY `FK_ModuleAssessmentResponses_Modules`;

ALTER TABLE `moduleassessmentresponses` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `ModuleId` `module_id` INT(11) NOT NULL ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `StartTime` `date_start` DATETIME(6) NULL DEFAULT NULL ,
CHANGE COLUMN `EndTime` `date_end` DATETIME(6) NULL DEFAULT NULL ,
CHANGE COLUMN `DateCompleted` `date_completed` DATETIME(6) NULL DEFAULT NULL ,
CHANGE COLUMN `Reviewed` `is_reviewed` TINYINT(1) NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
CHANGE COLUMN `ModuleAssessmentId` `module_assessment_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `CourseId` `course_id` INT(11) NULL DEFAULT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `course_id`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `moduleassessmentresponses` 
RENAME TO  `module_assessment_responses`;

#---- moduleassessments

ALTER TABLE `moduleassessments` 
DROP FOREIGN KEY `FK_ModuleAssessments_AssessmentTypes`,
DROP FOREIGN KEY `FK_ModuleAssessments_Employees`,
DROP FOREIGN KEY `FK_ModuleAssessments_Module`;

ALTER TABLE `moduleassessments` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `ModuleId` `module_id` INT(11) NOT NULL ,
CHANGE COLUMN `AssessmentTypeId` `assessment_type_id` INT(11) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Data` `data` LONGTEXT NOT NULL ,
CHANGE COLUMN `PassMark` `pass_mark` DOUBLE NOT NULL ,
CHANGE COLUMN `TrainerId` `trainer_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `moduleassessments` 
RENAME TO  `module_assessments` ;

#---- modulequestionchoices
ALTER TABLE `modulequestionchoices` 
DROP FOREIGN KEY `FK_ModuleQuestionChoices_ModuleQuestions`;

ALTER TABLE `modulequestionchoices` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `ModuleQuestionId` `module_question_id` INT(11) NOT NULL ,
CHANGE COLUMN `ChoiceText` `choice_text` LONGTEXT NULL DEFAULT NULL ,
CHANGE COLUMN `CorrectAnswer` `correct_answer` TINYINT(1) NULL DEFAULT NULL ,
CHANGE COLUMN `Points` `points` DOUBLE NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `modulequestionchoices` 
RENAME TO  `module_question_choices` ;

#--- notificationgroups
ALTER TABLE `notificationgroups` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `notificationgroups` 
RENAME TO  `notification_groups` ;

#--- notificationrecurrences
ALTER TABLE `notificationrecurrences` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(20) NOT NULL ,
CHANGE COLUMN `Days` `days` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `notificationrecurrences` 
RENAME TO  `notification_recurrences` ;


#---- organisationcharts
ALTER TABLE `organisationcharts` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Title` `title` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Diagram` `diagram` LONGTEXT NOT NULL ,
CHANGE COLUMN `Author` `author` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `DateCreated` `date_created` DATETIME(6) NOT NULL ,
CHANGE COLUMN `LastEditBy` `last_edit_by` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `LastEditDate` `date_last_edit` DATETIME(6) NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `organisationcharts` 
RENAME TO  `organisation_charts` ;

#----PolicyCategories
ALTER TABLE `policycategories` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `policycategories` 
RENAME TO  `policy_categories` ;

#---- policydocuments
ALTER TABLE `policydocuments` 
DROP FOREIGN KEY `FK_PolicyDocuments_Policies`;

ALTER TABLE `policydocuments` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `PolicyId` `policy_id` INT(11) NOT NULL ,
CHANGE COLUMN `Name` `name` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Content` `content` LONGTEXT NULL DEFAULT NULL ,
ADD COLUMN `is_active` TINYINT(1) NULL AFTER `content`,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `policydocuments` 
RENAME TO  `policy_documents` ;


#----reporttemplates
ALTER TABLE `reporttemplates` 
DROP FOREIGN KEY `FK_ReportTemplates_SystemModules`;

ALTER TABLE `reporttemplates` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Source` `source` VARCHAR(200) NOT NULL ,
CHANGE COLUMN `SystemModuleId` `system_module_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `Order` `order` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `Title` `title` VARCHAR(100) NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `reporttemplates` 
RENAME TO  `report_templates` ;

#----surveyresponses
ALTER TABLE `surveyresponses` 
DROP FOREIGN KEY `FK_SurveyResponses_ShamUsers`,
DROP FOREIGN KEY `FK_SurveyResponses_Surveys`;

ALTER TABLE `surveyresponses` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `ShamUserId` `sham_user_id` INT(11) NOT NULL ,
CHANGE COLUMN `Response` `response` LONGTEXT NOT NULL ,
CHANGE COLUMN `Date` `date_occurred` DATETIME(6) NOT NULL ,
CHANGE COLUMN `SurveyId` `survey_id` INT(11) NOT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `survey_id`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `surveyresponses` 
RENAME TO  `survey_responses` ;

#----surveys
ALTER TABLE `surveys` 
DROP FOREIGN KEY `FK_Surveys_Forms`,
DROP FOREIGN KEY `FK_Surveys_NotificationGroups`,
DROP FOREIGN KEY `FK_Surveys_NotificationRecurrences`,
DROP FOREIGN KEY `FK_Surveys_ShamUsers`,
DROP FOREIGN KEY `FK_Surveys_SurveyStatuses`;

ALTER TABLE `surveys` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Title` `title` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `StartDate` `date_start` DATETIME(6) NOT NULL ,
CHANGE COLUMN `NotificationRecurrenceId` `notification_recurrence_id` INT(11) NOT NULL ,
CHANGE COLUMN `NotificationGroupId` `notification_group_id` INT(11) NOT NULL ,
CHANGE COLUMN `FormId` `form_id` INT(11) NOT NULL ,
CHANGE COLUMN `Final` `final` TINYINT(1) NOT NULL DEFAULT '0' ,
CHANGE COLUMN `AuthorShamUserId` `author_sham_user_id` INT(11) NOT NULL ,
CHANGE COLUMN `SurveyStatusId` `survey_status_id` INT(11) NOT NULL DEFAULT '0' ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

#----surveystatuses
ALTER TABLE `surveystatuses` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `surveystatuses` 
RENAME TO  `survey_statuses` ;

#----tasks
ALTER TABLE `tasks` 
DROP FOREIGN KEY `FK_Tasks_Departments`;

ALTER TABLE `tasks` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Priority` `priority` INT(11) NOT NULL ,
CHANGE COLUMN `Duration` `duration` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `DepartmentId` `department_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `SystemTask` `system_task` TINYINT(1) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;



#--timelineeventtypes
ALTER TABLE `timelineeventtypes` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(50) NOT NULL ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `timelineeventtypes` 
RENAME TO  `timeline_event_types` ;

#---- timelines
ALTER TABLE `timelines` 
DROP FOREIGN KEY `FK_Timelines_Employees`,
DROP FOREIGN KEY `FK_Timelines_TimelineEventTypes`;

ALTER TABLE `timelines` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `TimelineEventTypeId` `timeline_event_type_id` INT(11) NOT NULL ,
CHANGE COLUMN `EventId` `event_id` CHAR(10) CHARACTER SET 'utf8mb4' NULL DEFAULT NULL ,
CHANGE COLUMN `EventDate` `date_event` DATETIME(6) NOT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `date_event`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

#----trainingsessionparticipants

ALTER TABLE `trainingsessionparticipants` 
DROP FOREIGN KEY `FK_TrainingSessionParticipants_Employees`,
DROP FOREIGN KEY `FK_TrainingSessionParticipants_TrainingSessions`;

ALTER TABLE `trainingsessionparticipants` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `TrainingSessionId` `training_session_id` INT(11) NOT NULL ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `trainingsessionparticipants` 
RENAME TO  `training_session_participants`;


#----violations
ALTER TABLE `violations` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Description` `description` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

#----shamusers

ALTER TABLE `shamusers` 
DROP FOREIGN KEY `FK_ShamUsers_Employees`;

ALTER TABLE `shamusers` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Username` `username` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Password` `password` VARCHAR(100) NULL DEFAULT NULL ,
CHANGE COLUMN `EmailAddress` `email_address` VARCHAR(512) NULL DEFAULT NULL ,
CHANGE COLUMN `CellNumber` `cell_number` VARCHAR(20) NULL DEFAULT NULL ,
CHANGE COLUMN `EmailNotify` `email_notify` TINYINT(1) NOT NULL DEFAULT '1' ,
CHANGE COLUMN `SmsNotify` `sms_notify` TINYINT(1) NOT NULL DEFAULT '1' ,
CHANGE COLUMN `PushNotify` `push_notify` TINYINT(1) NOT NULL DEFAULT '1' ,
CHANGE COLUMN `SilenceStart` `silence_start` TIME(6) NULL DEFAULT NULL ,
CHANGE COLUMN `SilenceEnd` `silence_end` TIME(6) NULL DEFAULT NULL ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `DateCreated` `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ,
CHANGE COLUMN `RememberToken` `remember_token` VARCHAR(100) NULL DEFAULT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `remember_token`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `shamusers` 
RENAME TO  `sham_users` ;

ALTER TABLE `shamuserprofiles` 
RENAME TO `sham_user_profiles`;

#---- telephonenumbers
ALTER TABLE `telephonenumbers` 
DROP FOREIGN KEY `FK_TelephoneNumbers_Employees`,
DROP FOREIGN KEY `FK_TelephoneNumbers_TelephoneNumberTypes`;

ALTER TABLE `telephonenumbers` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `TelNumber` `tel_number` VARCHAR(20) NOT NULL ,
CHANGE COLUMN `TelephoneNumberTypeId` `telephone_number_type_id` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL ,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `telephonenumbers` 
RENAME TO  `telephone_numbers` ;


#----shamuserprofilesubmodulepermissions / shamuserprofile_shampermission
ALTER TABLE `shamuserprofilessubmodulepermissions` 
DROP FOREIGN KEY `FK_ShamUserProfilesSubModulePermissions_ShamPermissions`,
DROP FOREIGN KEY `FK_ShamUserProfilesSubModulePermissions_ShamUserProfiles`,
DROP FOREIGN KEY `FK_ShamUserProfilesSubModulePermissions_SystemSubModules`;

ALTER TABLE `shamuserprofilessubmodulepermissions` 
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `ShamUserProfileId` `sham_user_profile_id` INT(11) NOT NULL ,
CHANGE COLUMN `ShamPermissionId` `sham_permission_id` INT(11) NOT NULL ,
CHANGE COLUMN `SystemSubModuleId` `system_sub_module_id` INT(11) NOT NULL ;


#---- sham_users_profile
ALTER TABLE `sham_user_profiles` 
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

#--- shamuserprofilessubmodulepermissions
ALTER TABLE `shamuserprofilessubmodulepermissions` 
RENAME TO  `shamuserprofile_shampermission` ;

#--- asset_groups
ALTER TABLE `asset_groups` 
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

#---- assets
ALTER TABLE `assets` 
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

#---Added on 20-09-2018

ALTER TABLE `laws` 
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

ALTER TABLE `announcement_statuses` 
ADD COLUMN `is_system_predefined` TINYINT(1) NOT NULL DEFAULT 1 AFTER `description`;

ALTER TABLE `genders` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `genders` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `genders` ADD `deleted_at` DATETIME NULL;

ALTER TABLE `titles` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `titles` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `titles` ADD `deleted_at` DATETIME NULL;

ALTER TABLE `maritalstatuses` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `maritalstatuses` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `maritalstatuses` ADD `deleted_at` DATETIME NULL;

ALTER TABLE `tax_statuses` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `tax_statuses` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `tax_statuses` ADD `deleted_at` DATETIME NULL;

ALTER TABLE `bankaccounttypes` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `bankaccounttypes` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `bankaccounttypes` ADD `deleted_at` DATETIME NULL;

ALTER TABLE `branches` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `branches` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `branches` ADD `deleted_at` DATETIME NULL;

ALTER TABLE `companies` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `companies` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `companies` ADD `deleted_at` DATETIME NULL;

ALTER TABLE `divisions` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `divisions` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `divisions` ADD `deleted_at` DATETIME NULL;

ALTER TABLE `ethnic_groups` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `ethnic_groups` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `ethnic_groups` ADD `deleted_at` DATETIME NULL;

ALTER TABLE `immigration_statuses` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `immigration_statuses` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `immigration_statuses` ADD `deleted_at` DATETIME NULL;

ALTER TABLE `job_titles` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `job_titles` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `job_titles` ADD `deleted_at` DATETIME NULL;

ALTER TABLE `time_groups` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `time_groups` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `time_groups` ADD `deleted_at` DATETIME NULL;

ALTER TABLE `time_groups` CHANGE `description` `name` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

RENAME TABLE `course_modules` TO `course_module`;
RENAME TABLE `team_products` TO `product_team`;

ALTER TABLE `system_modules` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `system_modules` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `system_modules` ADD `deleted_at` DATETIME NULL;

ALTER TABLE `asset_conditions` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `asset_conditions` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `asset_conditions` ADD `deleted_at` DATETIME NULL;
ALTER TABLE `asset_conditions` ADD `is_system_predefined` TINYINT(1) NOT NULL DEFAULT '0' AFTER `deleted_at`;

#--- Added on 22/09/2018

ALTER TABLE `addresses`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `assessments`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `assessment_categories`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `category_questions`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `category_question_choices`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `category_question_types`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `product_categories`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `evaluation_statuses`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `assessment_category_category_question`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `evaluations`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `evaluation_assessors`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `evaluation_results`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `forms`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `asset_groups`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `assets`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `laws`
CHANGE COLUMN `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL ;

#---- Added on 24/09/2018
ALTER TABLE `course_module`
DROP FOREIGN KEY `FK_CourseModules_Course`,
DROP FOREIGN KEY `FK_CourseModules_Module`;

ALTER TABLE `course_module`
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `CourseId` `course_id` INT(11) NOT NULL ,
CHANGE COLUMN `ModuleId` `module_id` INT(11) NOT NULL ;

#---- Asset suppliers
ALTER TABLE `assetsuppliers`
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`,
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `Name` `name` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `Address1` `address1` VARCHAR(100) NULL DEFAULT NULL ,
CHANGE COLUMN `Address2` `address2` VARCHAR(100) NULL DEFAULT NULL ,
CHANGE COLUMN `Address3` `address3` VARCHAR(100) NULL DEFAULT NULL ,
CHANGE COLUMN `Telephone` `telephone` VARCHAR(20) NULL DEFAULT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' ;

#---- assetsuppliers
ALTER TABLE `assetsuppliers`
RENAME TO  `asset_suppliers` ;

#---- category_questions
#--ALTER TABLE `category_questions`
#--DROP FOREIGN KEY `FK_CategoryQuestions_CategoryQuestionTypes`;

#---- category_questions
ALTER TABLE `category_questions`
CHANGE COLUMN `categoryquestiontype_Id` `category_question_type_id` INT(11) NOT NULL ;

#---- time_group_day_time_period/day_time_group_time_period
RENAME TABLE `time_group_day_time_period` TO `day_time_group_time_period`;

#---- shamuserprofile_shampermission/sham_permission_sham_user_profile_system_sub_module
RENAME TABLE `shamuserprofile_shampermission` TO `sham_permission_sham_user_profile_system_sub_module`;

#---- Added on 2018-09-25
#---- Law Categories
ALTER TABLE `lawcategories`
RENAME TO  `law_categories` ;

#----course_training_sessions/training_sessions
ALTER TABLE `course_training_sessions`
RENAME TO  `training_sessions`;

#---- training_session_participants/employee_training_session
ALTER TABLE `training_session_participants`
RENAME TO  `employee_training_session`;


#---- Added on 30/09/2018

#--ALTER TABLE `category_question_choices`
#--DROP FOREIGN KEY `FK_CategoryQuestionChoices_CategoryQuestions2`;

#---- category_question_choices
ALTER TABLE `category_question_choices`
CHANGE COLUMN `categoryquestion_id` `category_question_id` INT(11) NOT NULL ,
CHANGE COLUMN `choicetext` `choice_text` LONGTEXT NOT NULL ;

#---- asset_employee
ALTER TABLE `asset_employee`
ALTER `date_out` DROP DEFAULT;

#---- asset_employee
ALTER TABLE `asset_employee`
CHANGE COLUMN `date_out` `date_out` DATE NOT NULL AFTER `employee_id`,
CHANGE COLUMN `date_in` `date_in` DATE NULL DEFAULT NULL AFTER `date_out`;

#---- telephone_numbers
ALTER TABLE `telephone_numbers`
CHANGE COLUMN `is_active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `telephone_number_type_id`;

#---- email_addresses
ALTER TABLE `email_addresses`
DROP FOREIGN KEY `FK_EmailAddresses_EmailAddressTypes`,
DROP FOREIGN KEY `FK_EmailAddresses_Employees`;

ALTER TABLE `email_addresses`
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`,
CHANGE COLUMN `Id` `id` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `EmployeeId` `employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `EmailAddress` `email_address` VARCHAR(512) NOT NULL ,
CHANGE COLUMN `EmailAddressTypeId` `email_address_type_id` INT(11) NOT NULL ,
CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL ;

ALTER TABLE `email_addresses`
CHANGE COLUMN `is_active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `email_address_type_id`;

UPDATE `sham_permissions` SET `Alias` = 'List' WHERE `sham_permissions`.`id` = 1;
UPDATE `sham_permissions` SET `Alias` = 'Read' WHERE `sham_permissions`.`id` = 2;
UPDATE `sham_permissions` SET `Alias` = 'Write' WHERE `sham_permissions`.`id` = 3;
UPDATE `sham_permissions` SET `Alias` = 'Delete' WHERE `sham_permissions`.`id` = 4;
UPDATE `sham_permissions` SET `Alias` = 'Create' WHERE `sham_permissions`.`id` = 5;

# Above Code reviewed on 2018-10-01

#-- Added on 2018-10-01
#---- employees
ALTER TABLE `employees`
CHANGE COLUMN `jobtitle_id` `job_title_id` INT(11) NULL DEFAULT NULL ;

#---- surveys
ALTER TABLE `surveys` CHANGE `notification_recurrence_id` `notification_recurrence_id` INT(11) NULL, CHANGE `notification_group_id` `notification_group_id` INT(11) NULL, CHANGE `form_id` `form_id` INT(11) NULL;

#---- forms
ALTER TABLE `forms` CHANGE `description` `description` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;

#---- assessment_categories
ALTER TABLE `assessment_categories`
CHANGE COLUMN `eLearning_module` `eLearning_module` VARCHAR(100) NULL ,
CHANGE COLUMN `threshold` `threshold` INT(11) NULL ;

#---- Surveys
ALTER TABLE `surveys` CHANGE `date_start` `date_start` DATE NOT NULL, CHANGE `EndDate` `date_end` DATE NOT NULL;

#---- assessments_assessment_category
#--ALTER TABLE `assessments_assessment_category`
#--DROP FOREIGN KEY `FK_AssessmentsAssessmentCategories_AssessmentCategories`;

ALTER TABLE `assessments_assessment_category`
CHANGE COLUMN `assessmentcategory_id` `assessment_category_id` INT(11) NOT NULL ;

#---- assessment_category_category_question
#--ALTER TABLE `assessment_category_category_question`
#--DROP FOREIGN KEY `FK_AssessmentCategoriesCategoryQuestions_AssessmentCategories`,
#--DROP FOREIGN KEY `FK_AssessmentCategoriesCategoryQuestions_CategoryQuestions`;

ALTER TABLE `assessment_category_category_question`
CHANGE COLUMN `assessmentcategory_id` `assessment_category_id` INT(11) NOT NULL ,
CHANGE COLUMN `categoryquestion_id` `category_question_id` INT(11) NOT NULL ;


ALTER TABLE `announcement_department`
  DROP `created_at`,
  DROP `updated_at`,
  DROP `deleted_at`;

ALTER TABLE `announcements` CHANGE `date_start` `start_date` DATE NOT NULL, CHANGE `date_end` `end_date` DATE NOT NULL;

#--- Added on 08/10/2018
#--- Evaluations
#---ALTER TABLE `evaluations`
#---DROP FOREIGN KEY `FK_Evaluations_Employees`,
#---DROP FOREIGN KEY `FK_Evaluations_Employees1`,
#---DROP FOREIGN KEY `FK_Evaluations_EvaluationStatuses`;

ALTER TABLE `evaluations`
CHANGE COLUMN `useremployee_id` `user_employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `referenceno` `reference_no` VARCHAR(200) NULL DEFAULT NULL ,
CHANGE COLUMN `referencesource` `reference_source` VARCHAR(200) NULL DEFAULT NULL ,
CHANGE COLUMN `qasample` `qa_sample` LONGBLOB NULL DEFAULT NULL ,
CHANGE COLUMN `evaluationstatus_id` `evaluation_status_id` INT(11) NOT NULL ,
CHANGE COLUMN `createdbyemployee_id` `createdby_employee_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `originalfilename` `original_filename` VARCHAR(256) NULL DEFAULT NULL ,
CHANGE COLUMN `urlpath` `url_path` VARCHAR(256) NULL DEFAULT NULL;

#--- Tax statuses
ALTER TABLE `tax_statuses`
	ALTER `Description` DROP DEFAULT,
	ALTER `Active` DROP DEFAULT;
ALTER TABLE `tax_statuses`
	CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL AFTER `id`,
	CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL AFTER `description`;

#--- Divisions
ALTER TABLE `divisions`
	ALTER `Description` DROP DEFAULT,
	ALTER `Active` DROP DEFAULT;
ALTER TABLE `divisions`
	CHANGE COLUMN `Description` `description` VARCHAR(50) NOT NULL AFTER `id`,
	CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL AFTER `description`;

ALTER TABLE `forms` CHANGE `title` `title` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE `immigration_statuses` CHANGE `Id` `id` INT(11) NOT NULL AUTO_INCREMENT, 
CHANGE `Description` `description` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE `employees` 
	CHANGE `date_joined` `date_joined` DATE NULL DEFAULT NULL, 
	CHANGE `date_terminated` `date_terminated` DATE NULL DEFAULT NULL;

ALTER TABLE `timelines` CHANGE `date_event` `date_event` DATE NOT NULL;

ALTER TABLE `history_departments`
	ALTER `date` DROP DEFAULT;
ALTER TABLE `history_departments`
	CHANGE COLUMN `date` `date_occurred` DATETIME(6) NOT NULL AFTER `department_id`;

ALTER TABLE `history_departments` CHANGE `date_occurred` `date_occurred` DATE NOT NULL;

ALTER TABLE `rewards`
	ALTER `date_received` DROP DEFAULT;
ALTER TABLE `rewards`
	CHANGE COLUMN `date_received` `date_received` DATE NOT NULL AFTER `rewarded_by`;

ALTER TABLE `history_rewards` CHANGE `date_occurred` `date_occurred` DATE NOT NULL;

ALTER TABLE `history_disciplinary_actions` 
CHANGE `date_occurred` `date_occurred` DATE NOT NULL;

ALTER TABLE `disciplinary_actions`
	ALTER `violation_date` DROP DEFAULT;
ALTER TABLE `disciplinary_actions`
	CHANGE COLUMN `violation_date` `violation_date` DATE NOT NULL AFTER `violation_id`,
	CHANGE COLUMN `date_issued` `date_issued` DATE NULL DEFAULT NULL AFTER `is_active`,
	CHANGE COLUMN `date_expires` `date_expires` DATE NULL DEFAULT NULL AFTER `date_issued`;

RENAME TABLE `history_joins_terminations` TO `history_join_terminations`;

#--ALTER TABLE `history_join_terminations`
#--	ALTER `date` DROP DEFAULT;
    
#--ALTER TABLE `history_join_terminations`
#--	CHANGE COLUMN `date` `date_occurred` DATETIME(6) NOT NULL AFTER `is_joined`;

ALTER TABLE `history_join_terminations` CHANGE `date_occurred` `date_occurred` DATE NOT NULL;

ALTER TABLE `history_job_titles` CHANGE `date_occurred` `date_occurred` DATE NOT NULL;

RENAME TABLE `historyqualifications` TO `history_qualifications`;

ALTER TABLE `history_qualifications`
DROP FOREIGN KEY `FK_HistoryQualifications_Employees`,
DROP FOREIGN KEY `FK_HistoryQualifications_Qualifications`;

ALTER TABLE `history_qualifications` 
	CHANGE `EmployeeId` `employee_id` INT(11) NOT NULL, 
	CHANGE `QualificationId` `qualification_id` INT(11) NOT NULL, 
	CHANGE `Id` `id` INT(11) NOT NULL AUTO_INCREMENT, 
	CHANGE `Date` `date` DATE NOT NULL;

ALTER TABLE `history_qualifications` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `history_qualifications` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `history_qualifications` ADD `deleted_at` DATETIME NULL;

#-- 19/10/2018

ALTER TABLE `evaluation_assessors`
CHANGE COLUMN `starttime` `start_time` DATETIME NULL DEFAULT NULL,
CHANGE COLUMN `endtime` `end_time` DATETIME NULL DEFAULT NULL;

ALTER TABLE `evaluation_assessors`
RENAME TO  `employee_evaluation` ;

ALTER TABLE `module_assessment_responses`
CHANGE COLUMN `date_start` `date_start` DATE NULL DEFAULT NULL AFTER `employee_id`,
CHANGE COLUMN `date_end` `date_end` DATE NULL DEFAULT NULL AFTER `date_start`,
CHANGE COLUMN `date_completed` `date_completed` DATE NULL DEFAULT NULL AFTER `date_end`,
CHANGE COLUMN `is_reviewed` `is_reviewed` TINYINT(1) NULL DEFAULT '0' AFTER `date_completed`;

#-- 22/10/2018
#--ALTER TABLE `evaluation_results`
#--DROP FOREIGN KEY `FK_EvaluationResults_AssessmentCategories`,
#--DROP FOREIGN KEY `FK_EvaluationResults_CategoryQuestions`,
#--DROP FOREIGN KEY `FK_EvaluationResults_Employees`;

ALTER TABLE `evaluation_results`
CHANGE COLUMN `assessoremployee_id` `assessor_employee_id` INT(11) NOT NULL ,
CHANGE COLUMN `assessmentcategory_id` `assessment_category_id` INT(11) NOT NULL ,
CHANGE COLUMN `categoryquestion_id` `category_question_id` INT(11) NOT NULL ;


#-- 25/10/2018
ALTER TABLE `sham_permissions`
	CHANGE COLUMN `Alias` `alias` VARCHAR(100) NULL DEFAULT NULL AFTER `is_active`;

ALTER TABLE `evaluations`
CHANGE COLUMN `feedback_date` `feedback_date` DATE NOT NULL ;

ALTER TABLE `system_sub_modules`
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `is_active`,
ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP() AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

#--12/11/2018
ALTER TABLE `branches`
	CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `is_system_predefined`;

ALTER TABLE `countries`
	CHANGE COLUMN `is_active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `description`;
ALTER TABLE `countries`
	CHANGE COLUMN `is_preferred` `is_preferred` TINYINT(1) NULL DEFAULT '0' AFTER `is_active`;

ALTER TABLE `divisions`
	CHANGE COLUMN `is_active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `description`;

ALTER TABLE `ethnic_groups`
	CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `description`;

ALTER TABLE `immigration_statuses`
	CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `description`;

ALTER TABLE `job_titles`
	CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `is_system_predefined`;

ALTER TABLE `languages`
	CHANGE COLUMN `is_active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `description`,
	CHANGE COLUMN `is_preferred` `is_preferred` TINYINT(1) NULL DEFAULT '0' AFTER `is_active`;

ALTER TABLE `skills`
	CHANGE COLUMN `Level` `Level` SMALLINT(6) NULL DEFAULT '1' AFTER `is_active`;

ALTER TABLE `tax_statuses`
	CHANGE COLUMN `is_active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `description`;

ALTER TABLE `teams`
	CHANGE COLUMN `is_active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `description`;

ALTER TABLE `time_groups`
	CHANGE COLUMN `is_active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `name`;

ALTER TABLE `time_periods`
	CHANGE COLUMN `is_active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `time_period_type`;

#-- 13/11/2018
ALTER TABLE `policies`
	ADD COLUMN `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_active`,
	ADD COLUMN `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
	ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `updated_at`;

ALTER TABLE `timelines`
	ALTER `date_event` DROP DEFAULT;
ALTER TABLE `timelines`
	CHANGE COLUMN `date_event` `event_date` DATE NOT NULL AFTER `event_id`;

ALTER TABLE `history_departments`
	ALTER `updated_by` DROP DEFAULT;
ALTER TABLE `history_departments`
	CHANGE COLUMN `updated_by` `updated_by_employee_id` VARCHAR(50) NOT NULL AFTER `date_occurred`;

#-- 16/11/2018
ALTER TABLE `asset_suppliers`
	CHANGE COLUMN `Comments` `comments` VARCHAR(256) NULL DEFAULT NULL AFTER `email_address`;

ALTER TABLE `assets`
	ALTER `warrantyexpires_at` DROP DEFAULT;
ALTER TABLE `assets`
	CHANGE COLUMN `warrantyexpires_at` `warranty_expiry_date` DATE NOT NULL AFTER `po_number`;

ALTER TABLE `companies`
	CHANGE COLUMN `Active` `is_active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `name`

ALTER TABLE `training_sessions` CHANGE `training_delivery_method_id` `training_delivery_method_id` INT(11) NULL DEFAULT NULL;

#-- 12/12/2018
ALTER TABLE `disabilities` CHANGE `is_system_predefined` `is_system_predefined` TINYINT(1) NULL DEFAULT '0';
ALTER TABLE `disability_categories` CHANGE `is_system_predefined` `is_system_predefined` TINYINT(1) NULL DEFAULT '0';