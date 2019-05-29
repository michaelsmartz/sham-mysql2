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