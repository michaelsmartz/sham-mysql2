CREATE TABLE `absence_types` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`description` VARCHAR(100) NOT NULL,
	`duration_unit` TINYINT(2) NULL DEFAULT '0' COMMENT '0-Days, 1-Hours',
	`eligilibity_begins` TINYINT(2) NULL DEFAULT '0' COMMENT '0 - From the first day at work,1 - When probation starts, 2 - After probation period',
	`eligibility_ends` TINYINT(2) NULL DEFAULT '0' COMMENT '0 - last day at work, 1 - When probation ends',
	`amount_earns` TINYINT(2) NULL COMMENT 'either days or hours',
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