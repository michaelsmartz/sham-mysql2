#--01 create disability_categories`  
CREATE TABLE `disability_categories` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(100) NOT NULL,
  `is_system_predefined` TINYINT(1) NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `IX_DISABILITY_CATEGORIES_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC));

#--01 create disability_categories`    
ALTER TABLE `disability_categories` 
AUTO_INCREMENT = 1 ;

INSERT INTO `disability_categories` (`description`, `is_system_predefined`) VALUES ('Aids', '1');
INSERT INTO `disability_categories` (`description`, `is_system_predefined`) VALUES ('Hearing', '1');
INSERT INTO `disability_categories` (`description`, `is_system_predefined`) VALUES ('Learning', '1');
INSERT INTO `disability_categories` (`description`, `is_system_predefined`) VALUES ('Mental', '1');
INSERT INTO `disability_categories` (`description`, `is_system_predefined`) VALUES ('Other', '1');
INSERT INTO `disability_categories` (`description`, `is_system_predefined`) VALUES ('Personality', '1');
INSERT INTO `disability_categories` (`description`, `is_system_predefined`) VALUES ('Visual', '1');

#--01 create disabilities
CREATE TABLE `disabilities` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(100) NOT NULL,
  `disability_category_id` INT(11) NOT NULL,
  `is_system_predefined` TINYINT(1) NULL DEFAULT 1,
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `FK_disability_categories_id_idx` (`disability_category_id` ASC),
  INDEX `IX_DISABILITIES_IS_SYSTEM_PREDEFINED` (`is_system_predefined` ASC),
  CONSTRAINT `FK_disability_categories_id`
    FOREIGN KEY (`disability_category_id`)
    REFERENCES `disability_categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Full blown Aids', '1', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Partially Hearing', '2', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Pre-lingual Loss of Hearing', '2', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Tinnitus', '2', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ("Asperger\'s Syndrome", '3', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Attention Deficit Hyperactivity Disorder (ADHD)', '3', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Down syndrome', '3', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Dyslexia', '3', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Dyspraxia', '3', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Retardation', '3', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Bipolar Disorder & Manic Depression', '4', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Epilepsy', '4', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Obsessive-Compulsive Disorder (OCD)', '4', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Phycopath', '4', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Schizophrenia', '4', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Loss of limbs', '5', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Mobility of limbs', '5', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Polio', '5', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Agoraphobia', '6', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Depression', '6', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Panic Attacks', '6', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Post Traumatic Stress Disorder', '6', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Psychosis', '6', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Social Phobia', '6', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Albinism & Nystagmus', '7', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Cataracts', '7', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Diabetic Retinopathy', '7', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Glaucoma', '7', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Macular Degeneration', '7', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Optic Atropy', '7', '1');
INSERT INTO `disabilities` (`description`, `disability_category_id`, `is_system_predefined`) VALUES ('Retinitis Pigmentosa (RP)', '7', '1');

#--01 create empmloyee_disability`  
CREATE TABLE `employee_disability` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `employee_id` INT(11) NULL,
  `disability_id` INT(11) NULL,
  PRIMARY KEY (`id`),
  INDEX `IX_EMPLOYEE_DISABILITY` (`employee_id` ASC));
  
CREATE TABLE `users`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`email` varchar(512) DEFAULT NULL,
`password` varchar(100) DEFAULT NULL,
`Username` varchar(100) NOT NULL,
`sham_user_profile_id` int(11) DEFAULT NULL,
`employee_id` int(11) DEFAULT NULL,
`created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
`updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
`deleted_at` timestamp NULL DEFAULT NULL,
`cell_number` varchar(20) DEFAULT NULL,
`email_notify` tinyint(1) NOT NULL DEFAULT '1',
`sms_notify` tinyint(1) NOT NULL DEFAULT '1',
`push_notify` tinyint(1) NOT NULL DEFAULT '1',
`silence_start` time DEFAULT NULL,
`silence_end` time DEFAULT NULL,
`is_active` tinyint(1) NOT NULL DEFAULT '1',
`remember_token` varchar(100) DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `FK_users_sham_user_profile_id_idx` (`sham_user_profile_id`),
KEY `IX_users_deleted_at` (`deleted_at`),
CONSTRAINT `FK_users_sham_user_profile_id` FOREIGN KEY (`sham_user_profile_id`) REFERENCES `sham_user_profiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#-- media and mediables
#-- Added date: 28/08/2018
create table `media` (
`id` int unsigned not null auto_increment primary key, 
`disk` varchar(32) not null, 
`directory` varchar(191) not null, 
`filename` varchar(191) not null, 
`extension` varchar(10) not null, 
`mime_type` varchar(128) not null, 
`aggregate_type` varchar(32) not null, 
`size` int unsigned not null,
`comment` varchar(150) null,
`extrable_type` varchar(191) null, 
`extrable_id` int unsigned null, 
`created_at` timestamp null, 
`updated_at` timestamp null) 
default character set utf8mb4 collate utf8mb4_unicode_ci;

alter table `media` add index `media_disk_directory_index`(`disk`, `directory`);
alter table `media` add unique `media_disk_directory_filename_extension_unique`(`disk`, directory(100), filename(100), `extension`);
alter table `media` add index `media_aggregate_type_index`(`aggregate_type`);

create table `mediables` (
`media_id` int unsigned not null, 
`mediable_type` varchar(191) not null, 
`mediable_id` int unsigned not null, 
`tag` varchar(191) not null, 
`order` int unsigned not null) 
default character set utf8mb4 collate utf8mb4_unicode_ci;

alter table `mediables` add primary key `mediables_media_id_mediable_type_mediable_id_tag_primary`(`media_id`, mediable_type(100), `mediable_id`, tag(100));
alter table `mediables` add index `mediables_mediable_id_mediable_type_index`(`mediable_id`, `mediable_type`);
alter table `mediables` add index `mediables_tag_index`(`tag`);
alter table `mediables` add index `mediables_order_index`(`order`);
alter table `mediables` add constraint `mediables_media_id_foreign` foreign key (`media_id`) references `media` (`id`) on delete cascade;