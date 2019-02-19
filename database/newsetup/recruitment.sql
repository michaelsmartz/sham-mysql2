INSERT INTO `system_sub_modules` (`id`, `description`, `system_module_id`, `is_active`, `created_at`, `updated_at`) VALUES ('131', 'Candidates', '4', '1', '2018-11-16 11:39:40', '2018-11-16 11:39:40');

--
-- activate recruitment request
--
UPDATE system_modules
SET  deleted_at = NULL
WHERE  id = 4;

--
-- Recruitment module tables
--

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

CREATE TABLE `interviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE `qualifications_recruitment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET = utf8mb4;

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
INDEX `FK_Recruitments_Skills` (`skill_id` ASC) INVISIBLE,
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
CONSTRAINT `FK_Recruitments_Skills`
FOREIGN KEY (`skill_id`)
REFERENCES `skills` (`id`)
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