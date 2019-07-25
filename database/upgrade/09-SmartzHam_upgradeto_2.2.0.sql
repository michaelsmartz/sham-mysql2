CREATE TABLE `colours` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`code` VARCHAR(7) NOT NULL COMMENT 'Hex code with the #',
	`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`deleted_at` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `code` (`code`)
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

CREATE TABLE `calendar_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `manager_only` int(11) DEFAULT NULL,
  `calendable_id` int(11) NOT NULL,
  `calendable_type` varchar(155) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO colours(code) VALUES 
      ('#FF6FFF'), ('#FF77AA'), ('#FF5588'), ('#FF3377'), ('#D44D5C'), 
      ('#2AB7CA'), ('#1B9CFC'), ('#6A89CC'), ('#4169E1'), ('#0C2461'),
      ('#F8DB9D'), ('#F0DC82'), ('#FFDB58'), ('#FF9933'), ('#C59922'),
      ('#BE9B7B'), ('#926F5B'), ('#4B3832'), ('#3C2F2F'), ('#63474D'), 
		  ('#5E5656'), ('#AF593E'), ('#A26645'), 
      ('#967BB6'), ('#B57EDC'), ('#6C3082'), ('#76395D'), ('#480656');

UPDATE colours set code=upper(code) where id <>0;

ALTER TABLE `candidates`
DROP FOREIGN KEY `FK_Candidate_JobTitles`;
ALTER TABLE `candidates`
DROP COLUMN `job_title_id`,
DROP INDEX `FK_Candidates_JobTitles`;

ALTER TABLE `candidates`
ADD COLUMN `passport_no` VARCHAR(50) NULL DEFAULT NULL AFTER `id_number`,
ADD COLUMN `passport_country_id` INT(11) NULL DEFAULT NULL AFTER `passport_no`,
ADD COLUMN `nationality` VARCHAR(50) NULL DEFAULT NULL AFTER `passport_country_id`,
ADD COLUMN `immigration_status_id` INT(11) NULL DEFAULT NULL AFTER `nationality`,
ADD COLUMN `notice_period` INT(2) NULL DEFAULT NULL AFTER `salary_expectation`;

ALTER TABLE `candidate_previous_employments`
ADD COLUMN `contact` INT(20) NULL DEFAULT NULL AFTER `end_date`;

DROP TABLE IF EXISTS `candidate_interviewers`;
CREATE TABLE `candidate_interviewers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_interview_recruitment_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `FK_CandidateInterviewers_CandidateInterviewRecruitmemt` (`candidate_interview_recruitment_id` ASC) INVISIBLE,
  CONSTRAINT `FK_CandidateInterviewers_CandidateInterviewRecruitmemt`
  FOREIGN KEY (`candidate_interview_recruitment_id`)
  REFERENCES `candidate_interview_recruitment` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
  INDEX `FK_CandidateInterviewers_Employee` (`employee_id` ASC) INVISIBLE,
  CONSTRAINT `FK_CandidateInterviewers_Employee`
  FOREIGN KEY (`employee_id`)
  REFERENCES `employees` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `absence_types`
ADD `colour_id` INT(11) NULL DEFAULT '0' AFTER `duration_unit`;

ALTER TABLE `absence_type_employee` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `absence_type_employee` ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `absence_type_employee` ADD `deleted_at` DATETIME NULL;

ALTER TABLE `absence_type_employee`
ADD COLUMN `comments` TEXT NULL AFTER `updated_at`;

ALTER TABLE `job_logs`
	CHANGE COLUMN `message` `message` MEDIUMTEXT NOT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `level`;

ALTER TABLE `candidates`
ADD COLUMN `is_hired` TINYINT NULL DEFAULT 0 AFTER `zip`;

UPDATE system_sub_modules
SET deleted_at = null
WHERE id = 23;

INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '1', '23');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '2', '23');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '3', '23');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '4', '23');
INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES ('1', '5', '23');

ALTER TABLE `recruitments`
CHANGE COLUMN `description` `description` VARCHAR(10000) NULL DEFAULT NULL ;

ALTER TABLE `recruitments`
ADD COLUMN `posted_on` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `end_date`;

ALTER TABLE `candidates`
ADD COLUMN `is_internal` TINYINT(4) NULL DEFAULT '0' AFTER `is_hired`;

ALTER TABLE `candidates`
	ADD COLUMN `password` VARCHAR(100) NULL DEFAULT NULL AFTER `deleted_at`,
	ADD COLUMN `remember_token` VARCHAR(100) NULL DEFAULT NULL AFTER `password`;

ALTER TABLE `candidates`
DROP COLUMN `salary_expectation`;

ALTER TABLE `candidate_recruitment`
ADD COLUMN `salary_expectation` INT(10) NULL DEFAULT NULL AFTER `status`;

ALTER TABLE `candidates`
CHANGE COLUMN `zip` `zip_code` VARCHAR(50) NULL DEFAULT NULL ;

ALTER TABLE  `candidates`
ADD COLUMN `profill_complete` TINYINT(4) NULL AFTER `remember_token`;

ALTER TABLE `candidates`
	CHANGE COLUMN `profill_complete` `profil_complete` TINYINT(4) NULL DEFAULT NULL AFTER `remember_token`;

ALTER TABLE `recruitments`
	CHANGE COLUMN `start_date` `start_date` DATETIME NULL DEFAULT NULL AFTER `year_experience`;
ALTER TABLE `recruitments`
	CHANGE COLUMN `end_date` `end_date` DATETIME NULL DEFAULT NULL AFTER `start_date`;  