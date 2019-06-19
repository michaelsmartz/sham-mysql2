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

INSERT INTO colours(code) VALUES 
      ('#FF6FFF'), ('#ff77aa'), ('#ff5588'), ('#ff3377'), ('#d44d5c'), 
      ('#2ab7ca'), ('#1B9CFC'), ('#6a89cc'), ('#4169E1'), ('#0c2461'),
      ('#F8DB9D'), ('#F0DC82'), ('#FFDB58'), ('#FF9933'), ('#C59922'),
      ('#be9b7b'), ('#926F5B'), ('#4b3832'), ('#3c2f2f'), ('#63474d'), 
		  ('#5e5656'), ('#AF593E'), ('#A26645'), 
      ('#967BB6'), ('#B57EDC'), ('#6C3082'), ('#76395D'), ('#480656');
