CREATE TABLE `colours` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`code` CHAR(7) NOT NULL COMMENT 'Hex code with the #',
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
  `event_type` tinyint(4) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `manager_only` int(11) DEFAULT NULL,
  `calendable_id` int(11) NOT NULL,
  `calendable_type` varchar(155) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;