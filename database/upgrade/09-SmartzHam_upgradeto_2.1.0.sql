DROP TABLE IF EXISTS `candidates`;
CREATE TABLE `candidates` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`title_id` INT(11) NULL DEFAULT NULL,
`gender_id` INT(11) NULL DEFAULT NULL,
`marital_status_id` INT(11) NULL DEFAULT NULL,
`first_name` VARCHAR(50) NULL DEFAULT NULL,
`surname` VARCHAR(50) NULL DEFAULT NULL,
`email` VARCHAR(50) NULL DEFAULT NULL,
`home_address` VARCHAR(50) NULL DEFAULT NULL,
`id_number` VARCHAR(50) NULL,
`phone` VARCHAR(50) NULL,
`position_applying_for` VARCHAR(50) NULL,
`date_available` DATE NULL DEFAULT NULL,
`salary_expectation` INT(10) NULL,
`preferred_notification_id` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1 - Mail, 2 - SMS',
`birth_date` DATE NULL DEFAULT NULL,
`overview` VARCHAR(255) NULL,
`cover` VARCHAR(255) NULL,
`picture` LONGTEXT NULL,
`created_at` datetime DEFAULT CURRENT_TIMESTAMP,
`updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
`deleted_at` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
INDEX `FK_Candidates_MaritalStatuses` (`marital_status_id` ASC) INVISIBLE,
INDEX `FK_Candidates_Genders` (`gender_id` ASC) INVISIBLE,
INDEX `FK_Candidates_Titles` (`title_id` ASC) INVISIBLE,
CONSTRAINT `FK_Candidates_MaritalStatuses`
FOREIGN KEY (`marital_status_id`)
REFERENCES `maritalstatuses` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `FK_Candidates_Genders`
FOREIGN KEY (`gender_id`)
REFERENCES `genders` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `FK_Candidates_Titles`
FOREIGN KEY (`title_id`)
REFERENCES `titles` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `candidate_disability`;
CREATE TABLE `candidate_disability` (
`id` INT(11) NOT NULL AUTO_INCREMENT ,
`candidate_id` INT(11) NULL DEFAULT NULL,
`disability_id` INT(11) NULL DEFAULT NULL,
PRIMARY KEY (`id`),
INDEX `FK_CandidateDisability_Candidates` (`candidate_id` ASC) INVISIBLE,
INDEX `FK_CandidateDisability_Disabilities` (`disability_id` ASC) INVISIBLE,
CONSTRAINT `FK_CandidateDisability_Candidates`
FOREIGN KEY (`candidate_id`)
REFERENCES `candidates` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `FK_CandidateDisability_Disabilities`
FOREIGN KEY (`disability_id`)
REFERENCES `disabilities` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `candidate_skill`;
CREATE TABLE `candidate_skill` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`candidate_id` INT(11) NULL DEFAULT NULL,
`skill_id` INT(11) NULL DEFAULT NULL,
PRIMARY KEY (`id`),
INDEX `FK_CandidateSkill_Candidates` (`candidate_id` ASC) INVISIBLE,
INDEX `FK_CandidateSkill_Skills` (`skill_id` ASC) INVISIBLE,
CONSTRAINT `FK_CandidateSkill_Candidates`
FOREIGN KEY (`candidate_id`)
REFERENCES `candidates` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `FK_CandidateSkill_Skills`
FOREIGN KEY (`skill_id`)
REFERENCES `skills` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `candidate_qualifications`;
CREATE TABLE `candidate_qualifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `institution` varchar(50) DEFAULT NULL,
  `obtained_on` datetime DEFAULT NULL,
  `student_no` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `FK_CandidateQualifications_Candidates` (`candidate_id` ASC) INVISIBLE,
  CONSTRAINT `FK_CandidateQualifications_Candidates`
  FOREIGN KEY (`candidate_id`)
  REFERENCES `candidates` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `candidate_previous_employments`;
CREATE TABLE `candidate_previous_employments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `previous_employer` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `salary` INT(10) NULL,
  `reason_leaving` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `FK_CandidateEmployments_Candidates` (`candidate_id` ASC) INVISIBLE,
  CONSTRAINT `FK_CandidateEmployments_Candidates`
  FOREIGN KEY (`candidate_id`)
  REFERENCES `candidates` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Recruitment
--
DROP TABLE IF EXISTS `interviews`;
CREATE TABLE `interviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4;

DROP TABLE IF EXISTS `qualifications_recruitment`;
CREATE TABLE `qualifications_recruitment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4;

DROP TABLE IF EXISTS `recruitments`;
CREATE TABLE `recruitments` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`department_id` INT(11) NULL DEFAULT NULL,
`employee_status_id` INT(11) NULL DEFAULT NULL,
`qualification_id` INT(11) NULL DEFAULT NULL,
`job_title` VARCHAR(50) NULL DEFAULT NULL,
`field_of_study` VARCHAR(50) NULL DEFAULT NULL,
`description` VARCHAR(255) NULL DEFAULT NULL,
`year_experience` int(4) NULL DEFAULT NULL,
`start_date` DATE NULL DEFAULT NULL,
`end_date` DATE NULL DEFAULT NULL,
`min_salary` INT(10) NULL,
`max_salary` INT(10) NULL,
`recruitment_type_id` enum('1','2', '3') NOT NULL DEFAULT '1' COMMENT '1 - Internal, 2 - External, 3 - Both',
`created_at` datetime DEFAULT CURRENT_TIMESTAMP,
`updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
`deleted_at` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
INDEX `FK_Recruitments_Departments` (`department_id` ASC) INVISIBLE,
INDEX `FK_Recruitments_EmployeeStatuses` (`employee_status_id` ASC) INVISIBLE,
INDEX `FK_Recruitments_Qualifications` (`qualification_id` ASC) INVISIBLE,
CONSTRAINT `FK_Recruitments_Departments`
FOREIGN KEY (`department_id`)
REFERENCES `departments` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `FK_Recruitments_EmployeeStatuses`
FOREIGN KEY (`employee_status_id`)
REFERENCES `employee_statuses` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `FK_Recruitments_Qualifications`
FOREIGN KEY (`qualification_id`)
REFERENCES `qualifications_recruitment` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `candidate_recruitment`;
CREATE TABLE `candidate_recruitment` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`candidate_id` INT(11) NULL DEFAULT NULL,
`recruitment_id` INT(11) NULL DEFAULT NULL,
`status` enum('4','3', '2','1','0') NOT NULL DEFAULT '4',
PRIMARY KEY (`id`),
INDEX `FK_CandidateRecruitment_Candidates` (`candidate_id` ASC) INVISIBLE,
INDEX `FK_CandidateRecruitment_Recruitments` (`recruitment_id` ASC) INVISIBLE,
CONSTRAINT `FK_CandidateRecruitment_Candidates`
FOREIGN KEY (`candidate_id`)
REFERENCES `candidates` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `FK_CandidateRecruitment_Recruitments`
FOREIGN KEY (`recruitment_id`)
REFERENCES `recruitments` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `interview_recruitment`;
CREATE TABLE `interview_recruitment` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`recruitment_id` INT(11) NULL DEFAULT NULL,
`interview_id` INT(11) NULL DEFAULT NULL,
PRIMARY KEY (`id`),
INDEX `FK_InterviewRecruitment_Recruitments` (`recruitment_id` ASC) INVISIBLE,
INDEX `FK_InterviewRecruitment_Interviews` (`interview_id` ASC) INVISIBLE,
CONSTRAINT `FK_InterviewRecruitment_Recruitments`
FOREIGN KEY (`recruitment_id`)
REFERENCES `recruitments` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `FK_InterviewRecruitment_Interviews`
FOREIGN KEY (`interview_id`)
REFERENCES `interviews` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `recruitment_skill`;
CREATE TABLE `recruitment_skill` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`recruitment_id` INT(11) NULL DEFAULT NULL,
`skill_id` INT(11) NULL DEFAULT NULL,
PRIMARY KEY (`id`),
INDEX `FK_RecruitmentSkill_Recruitments` (`recruitment_id` ASC) INVISIBLE,
INDEX `FK_RecruitmentSkill_Skills` (`skill_id` ASC) INVISIBLE,
CONSTRAINT `FK_RecruitmentSkill_Recruitments`
FOREIGN KEY (`recruitment_id`)
REFERENCES `recruitments` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `FK_RecruitmentSkill_Skills`
FOREIGN KEY (`skill_id`)
REFERENCES `skills` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `recruitment_status`;
CREATE TABLE `recruitment_status` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`recruitment_id` INT(11) NULL DEFAULT NULL,
`candidate_id` INT(11) NULL DEFAULT NULL,
`status` enum('4','3', '2','1','0') NOT NULL DEFAULT '4',
`comment` varchar(255),
PRIMARY KEY (`id`),
INDEX `FK_RecruitmentStatus_Recruitments` (`recruitment_id` ASC) INVISIBLE,
INDEX `FK_RecruitmentStatus_Candidates` (`candidate_id` ASC) INVISIBLE,
CONSTRAINT `FK_RecruitmentStatus_Recruitments`
FOREIGN KEY (`recruitment_id`)
REFERENCES `recruitments` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `FK_RecruitmentStatus_Candidates`
FOREIGN KEY (`candidate_id`)
REFERENCES `candidates` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `candidate_interview_recruitment`;
CREATE TABLE `candidate_interview_recruitment` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`candidate_id` INT(11) NULL DEFAULT NULL,
`interview_id` INT(11) NULL DEFAULT NULL,
`recruitment_id` INT(11) NULL DEFAULT NULL,
`reasons` varchar(50),
`schedule_at` datetime,
`results` enum('1','2') NOT NULL DEFAULT '1',
`location` varchar(50),
`is_completed` int(1),
PRIMARY KEY (`id`),
INDEX `FK_CandidateInterviewRecruitment_Candidates` (`candidate_id` ASC) INVISIBLE,
INDEX `FK_CandidateInterviewRecruitment_Interviews` (`interview_id` ASC) INVISIBLE,
INDEX `FK_CandidateInterviewRecruitment_Recruitments` (`recruitment_id` ASC) INVISIBLE,
CONSTRAINT `FK_CandidateInterviewRecruitment_Candidates`
FOREIGN KEY (`candidate_id`)
REFERENCES `candidates` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `FK_CandidateInterviewRecruitment_Interviews`
FOREIGN KEY (`interview_id`)
REFERENCES `interviews` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `FK_CandidateInterviewRecruitment_Recruitments`
FOREIGN KEY (`recruitment_id`)
REFERENCES `recruitments` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

ALTER TABLE `candidate_qualifications`
CHANGE COLUMN `obtained_on` `obtained_on` DATE NULL DEFAULT NULL ;

ALTER TABLE `candidate_previous_employments`
ADD COLUMN `start_date` DATE NULL DEFAULT NULL AFTER `reason_leaving`,
ADD COLUMN `end_date` DATE NULL DEFAULT NULL AFTER `start_date`;

ALTER TABLE `candidates`
ADD COLUMN `addr_line_1` VARCHAR(50) NULL DEFAULT NULL AFTER `picture`,
ADD COLUMN `addr_line_2` VARCHAR(50) NULL DEFAULT NULL AFTER `addr_line_1`,
ADD COLUMN `addr_line_3` VARCHAR(50) NULL DEFAULT NULL AFTER `addr_line_2`,
ADD COLUMN `addr_line_4` VARCHAR(50) NULL DEFAULT NULL AFTER `addr_line_3`,
ADD COLUMN `city` VARCHAR(50) NULL DEFAULT NULL AFTER `addr_line_4`,
ADD COLUMN `province` VARCHAR(50) NULL DEFAULT NULL AFTER `city`,
ADD COLUMN `zip` VARCHAR(50) NULL DEFAULT NULL AFTER `province`;

ALTER TABLE `candidates`
DROP COLUMN `home_address`;

ALTER TABLE `candidates`
CHANGE COLUMN `position_applying_for` `job_title_id` INT(11) NULL DEFAULT NULL AFTER `marital_status_id`,
ADD INDEX `FK_Candidates_JobTitles` (`job_title_id` ASC) INVISIBLE;
;
ALTER TABLE `candidates`
ADD CONSTRAINT `FK_Candidate_JobTitles`
  FOREIGN KEY (`job_title_id`)
  REFERENCES `job_titles` (`id`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;

ALTER TABLE `recruitments`
ADD COLUMN `quantity` INT(11) NULL DEFAULT NULL AFTER `job_title`,
ADD COLUMN `is_completed` TINYINT NULL DEFAULT 0 AFTER `recruitment_type_id`,
ADD COLUMN `is_approved` TINYINT NULL DEFAULT 0 AFTER `is_completed`,
ADD COLUMN `comments` VARCHAR(255) NULL AFTER `is_approved`,
ADD COLUMN `employee_id` INT(11) NULL DEFAULT NULL AFTER `qualification_id`;

ALTER TABLE `candidate_recruitment`
	CHANGE COLUMN `status` `status` TINYINT NOT NULL DEFAULT '0' AFTER `recruitment_id`;

ALTER TABLE `recruitment_status`
	CHANGE COLUMN `status` `status` TINYINT NOT NULL DEFAULT '0' AFTER `candidate_id`;

ALTER TABLE `candidate_previous_employments`
	CHANGE COLUMN `end_date` `end_date` DATE NULL DEFAULT (CURRENT_DATE) AFTER `start_date`;

ALTER TABLE `candidate_interview_recruitment`
ADD COLUMN `status` ENUM('1', '2', '3') NULL DEFAULT NULL AFTER `recruitment_id`,
CHANGE COLUMN `results` `results` ENUM('1', '2') NULL DEFAULT NULL ;

UPDATE system_modules
SET  deleted_at = NULL
WHERE  id = 4;

INSERT INTO `system_sub_modules` (`id`, `description`, `system_module_id`, `is_active`, `created_at`, `updated_at`) VALUES ('131', 'Candidates', '4', '1', '2018-11-16 11:39:40', '2018-11-16 11:39:40');

INSERT INTO `system_sub_modules` (`id`, `description`, `system_module_id`, `is_active`, `created_at`, `updated_at`) VALUES ('132', 'Interviews', '4', '1', '2018-11-16 11:39:40', '2018-11-16 11:39:40');

INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '1', '132');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '2', '132');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '3', '132');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '4', '132');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '5', '132');


INSERT INTO `system_sub_modules` (`description`, `system_module_id`, `is_active`, `created_at`, `updated_at`) VALUES ('Recruitment Qualifications', '4', '1', '2018-11-16 11:39:40', '2018-11-16 11:39:40');

INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '1', '133');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '2', '133');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '3', '133');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '4', '133');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '5', '133');


DROP TABLE IF EXISTS `contracts`;
CREATE TABLE `contracts` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`description` VARCHAR(100) NOT NULL,
	`content` MEDIUMBLOB NOT NULL,
	`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`deleted_at` DATETIME DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

DROP TABLE IF EXISTS `offers`;
CREATE TABLE `offers` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`description` VARCHAR(100) NOT NULL,
	`content` MEDIUMBLOB NOT NULL,
	`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`deleted_at` DATETIME DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

DROP TABLE IF EXISTS `contract_recruitment`;
CREATE TABLE `contract_recruitment` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`recruitment_id` INT(11) NOT NULL,
	`candidate_id` INT(11) NOT NULL,
	`contract_id` INT(11) NULL DEFAULT NULL,
	`start_date` DATE NULL DEFAULT NULL,
	`signed_on` DATETIME NULL DEFAULT NULL,
	`comments` VARCHAR(250) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_0900_ai_ci'
;

DROP TABLE IF EXISTS `offer_recruitment`;
CREATE TABLE `offer_recruitment` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`recruitment_id` INT(11) NOT NULL,
	`candidate_id` INT(11) NOT NULL,
	`offer_id` INT(11) NULL DEFAULT NULL,
	`signed_on` DATETIME NULL DEFAULT NULL,
	`comments` VARCHAR(250) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_0900_ai_ci'
;

ALTER TABLE `candidates`
ADD COLUMN `employee_no` VARCHAR(45) NULL AFTER `id`;


ALTER TABLE `contract_recruitment`
	ADD COLUMN `master_copy` MEDIUMBLOB NULL DEFAULT NULL AFTER `contract_id`;

ALTER TABLE `offer_recruitment`
	ADD COLUMN `master_copy` MEDIUMBLOB NULL DEFAULT NULL AFTER `offer_id`;

ALTER TABLE `offer_recruitment`
	ADD COLUMN `starting_on` DATE NULL AFTER `master_copy`,
	CHANGE COLUMN `signed_on` `signed_on` DATE NULL DEFAULT NULL AFTER `starting_on`;

ALTER TABLE `contract_recruitment`
	CHANGE COLUMN `signed_on` `signed_on` DATE NULL DEFAULT NULL;

INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '1', '131');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '2', '131');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '3', '131');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '4', '131');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '5', '131');

INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '1', '36');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '2', '36');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '3', '36');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '4', '36');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '5', '36');

--
-- Table structure for table `authentication_log`
-- Created from migration
--
CREATE TABLE `authentication_log` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`authenticatable_id` INT(10) UNSIGNED NOT NULL,
	`authenticatable_type` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`ip_address` VARCHAR(45) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`user_agent` TEXT NULL COLLATE 'utf8mb4_unicode_ci',
	`login_at` TIMESTAMP NULL DEFAULT NULL,
	`logout_at` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `authentication_log_authenticatable_id_authenticatable_type_index` (`authenticatable_id`, `authenticatable_type`)
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
;

CREATE TABLE `absence_types` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`description` VARCHAR(100) NOT NULL,
	`duration_unit` TINYINT(2) NULL DEFAULT '0' COMMENT '0-Days, 1-Hours',
	`eligibility_begins` TINYINT(2) NULL DEFAULT '0' COMMENT '0 - From the first day at work,1 - After probation period',
	`eligibility_ends` TINYINT(2) NULL DEFAULT '0' COMMENT '0 - Last day of working year, 1 - When probation ends',
	`amount_earns` TINYINT(2) NULL DEFAULT NULL COMMENT 'either days or hours',
	`accrue_period` TINYINT(2) NULL DEFAULT '0' COMMENT '0 - Every 12 months, 1 -  Every 1 month, 2 - Every 24 months, 3 - Every 36 months',
	`created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
	`deleted_at` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

CREATE TABLE `eligibility_employee` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`employee_id` INT(11) NOT NULL DEFAULT '0',
	`absence_type_id` INT(11) NOT NULL DEFAULT '0',
	`start_date` DATE NOT NULL,
	`end_date` DATE NOT NULL,
	`total` SMALLINT(4) NULL DEFAULT '0',
	`taken` SMALLINT(4) NULL DEFAULT '0',
	`is_manually_adjusted` TINYINT(1) NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	INDEX `absence_type_id` (`absence_type_id`),
	INDEX `employee_id` (`employee_id`),
	CONSTRAINT `FKELIGIBILITY_EMPLOYEE_EMPLOYEE_ID` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	CONSTRAINT `FKELIGIBILITY_EMPLOYEE_ABSENCE_TYPE_ID` FOREIGN KEY (`absence_type_id`) REFERENCES `absence_types` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

CREATE TABLE `absence_type_job_title` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`absence_type_id` INT NULL,
	`job_title_id` INT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `FKABSENCETYPEJOBTITLE_ABSENCE_TYPE_ID` FOREIGN KEY (`absence_type_id`) REFERENCES `absence_types` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	CONSTRAINT `FKABSENCETYPEJOBTITLE_JOB_TITLE_ID` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

CREATE TABLE `absence_type_employee` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`absence_type_id` INT NOT NULL DEFAULT '0',
	`employee_id` INT NOT NULL DEFAULT '0',
	`starts_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`ends_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`status` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0 - pending, 1 - approved, 2 - denied, 3 - cancelled',
	`approved_by_employee_id` INT NOT NULL DEFAULT '0',
	`is_processed` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'processed by job scheduler, skip if already processed',
	PRIMARY KEY (`id`),
	CONSTRAINT `FKABSENCE_TYPE_EMPLOYEE_EMPLOYEE_ID` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
	CONSTRAINT `FKABSENCE_TYPE_EMPLOYEE_ABSENCE_TYPE_ID` FOREIGN KEY (`absence_type_id`) REFERENCES `absence_types` (`id`)
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

INSERT INTO `sys_config_values` (`key`, `value`) VALUES ('WORKING_YEAR_START', '2019-01-01');
INSERT INTO `sys_config_values` (`key`, `value`) VALUES ('WORKING_YEAR_END', '2019-12-31');

--
-- Alter table `employees` : Add probation_end_date
--
ALTER TABLE `employees`
ADD COLUMN `probation_end_date` DATE NULL AFTER `deleted_at`;

INSERT INTO `system_modules` (`description`, `is_active`) VALUES ('Leave', '1');
INSERT INTO `system_sub_modules` (`description`, `system_module_id`, `is_active`) VALUES ('Absence Types', '14', '1');
INSERT INTO `system_sub_modules` (`description`, `system_module_id`, `is_active`) VALUES ('Entitlements', '14', '1');
INSERT INTO `system_sub_modules` (`description`, `system_module_id`, `is_active`) VALUES ('Leaves', '14', '1');

INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '1', '134');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '2', '134');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '3', '134');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '4', '134');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '5', '134');

INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '1', '135');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '2', '135');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '3', '135');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '4', '135');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '5', '135');

INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '1', '136');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '2', '136');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '3', '136');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '4', '136');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '5', '136');

ALTER TABLE `eligibility_employee`
	ADD INDEX `IXELIGIBILITY_EMPLOYEE_START_END` (`start_date`, `end_date`);

ALTER TABLE `absence_types`
	CHANGE COLUMN `amount_earns` `amount_earns` DECIMAL(4,2) NULL DEFAULT NULL COMMENT 'either days or hours' AFTER `eligibility_ends`;

ALTER TABLE `eligibility_employee`
	CHANGE COLUMN `total` `total` DECIMAL(4,2) NULL DEFAULT '0' AFTER `end_date`,
	CHANGE COLUMN `taken` `taken` DECIMAL(4,2) NULL DEFAULT '0' AFTER `total`;

ALTER TABLE `absence_type_employee`
    CHANGE COLUMN `starts_at` `starts_at` DATETIME NOT NULL ,
    CHANGE COLUMN `ends_at` `ends_at` DATETIME NOT NULL ;

CREATE TABLE `jobs` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`queue` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`payload` LONGTEXT NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`attempts` TINYINT(3) UNSIGNED NOT NULL,
	`reserved_at` INT(10) UNSIGNED NULL DEFAULT NULL,
	`available_at` INT(10) UNSIGNED NOT NULL,
	`created_at` INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `jobs_queue_index` (`queue`)
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB;

UPDATE `system_sub_modules` SET `is_active` = '1' WHERE (`id` = '26');
UPDATE `system_sub_modules` SET `deleted_at` = null WHERE (`id` = '26');

INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '1', '26');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '2', '26');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '3', '26');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '4', '26');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '5', '26');

CREATE TABLE `job_logs` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`loggable_id` INT(10) UNSIGNED NULL DEFAULT NULL,
	`loggable_type` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`level` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`message` TEXT NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`context` TEXT NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`extra` TEXT NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`created_at` DATETIME NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `job_logs_loggable_id_loggable_type_index` (`loggable_id`, `loggable_type`)
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
;

ALTER TABLE `absence_types`
ADD COLUMN `non_working_days` TINYINT(1) NOT NULL DEFAULT '0' AFTER `accrue_period`;

ALTER TABLE `eligibility_employee` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `eligibility_employee` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `eligibility_employee` ADD `deleted_at` DATETIME NULL;

ALTER TABLE `absence_type_employee` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `absence_type_employee` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `absence_type_employee` ADD `deleted_at` DATETIME NULL;
ALTER TABLE `eligibility_employee`
	CHANGE COLUMN `total` `total` DECIMAL(6,2) NULL DEFAULT '0.00' AFTER `end_date`,
	CHANGE COLUMN `taken` `taken` DECIMAL(6,2) NULL DEFAULT '0.00' AFTER `total`;

	ALTER TABLE `absence_types`
CHANGE COLUMN `amount_earns` `amount_earns` DECIMAL(6,2) NULL DEFAULT NULL COMMENT 'either days or hours';

ALTER TABLE `eligibility_employee`
ADD COLUMN `is_processed` TINYINT(1) NULL DEFAULT 0 AFTER `is_manually_adjusted`;

#--23/04/19
DROP TABLE IF EXISTS `history_teams`;
CREATE TABLE IF NOT EXISTS `history_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `date_occurred` date NOT NULL,
  `updated_by_employee_id` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_HistoryTeam_Employees` (`employee_id`),
  KEY `FK_HistoryTeam_Teams` (`team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;