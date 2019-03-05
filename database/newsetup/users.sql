ALTER TABLE `users`
CHANGE COLUMN `username` `username` VARCHAR(100) NOT NULL AFTER `id`,
CHANGE COLUMN `email` `email` VARCHAR(512) NULL DEFAULT NULL AFTER `sham_user_profile_id`,
CHANGE COLUMN `employee_id` `employee_id` INT(11) NULL DEFAULT NULL AFTER `silence_end`,
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER `employee_id`,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`,
CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL AFTER `updated_at`;

ALTER TABLE `users`
COLLATE = latin1_general_ci ,
CHANGE COLUMN `username` `username` VARCHAR(100) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NOT NULL ;
