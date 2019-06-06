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
