-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 29, 2018 at 07:14 AM
-- Server version: 5.7.21
-- PHP Version: 7.1.16


SET GLOBAL FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------------------------
-- Schema
-- ----------------------------------------------------------------------------
DROP SCHEMA IF EXISTS `Shamdev_recruitment_2` ;
CREATE SCHEMA IF NOT EXISTS `Shamdev_recruitment_2` ;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

USE `Shamdev_recruitment_2`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shamuat`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `unit_no` varchar(50) DEFAULT NULL,
  `complex` varchar(50) DEFAULT NULL,
  `addr_line_1` varchar(50) DEFAULT NULL,
  `addr_line_2` varchar(50) DEFAULT NULL,
  `addr_line_3` varchar(50) DEFAULT NULL,
  `addr_line_4` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `zip_code` varchar(50) DEFAULT NULL,
  `address_type_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Addresses_AddressTypes` (`address_type_id`),
  KEY `FK_Addresses_Countries` (`country_id`),
  KEY `FK_Addresses_Employees` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `address_types`
--

DROP TABLE IF EXISTS `address_types`;
CREATE TABLE IF NOT EXISTS `address_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_system_predefined` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_ADDRESS_TYPES_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `advancemethods`
--

DROP TABLE IF EXISTS `advancemethods`;
CREATE TABLE IF NOT EXISTS `advancemethods` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` varchar(256) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `priority` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `announcement_status_id` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1 - Enabled, 2 - Disabled',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_department`
--

DROP TABLE IF EXISTS `announcement_department`;
CREATE TABLE IF NOT EXISTS `announcement_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `announcement_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_AnnouncementsDepartments_Announcements` (`announcement_id`),
  KEY `FK_AnnouncementsDepartments_Departments` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_statuses`
--

DROP TABLE IF EXISTS `announcement_statuses`;
CREATE TABLE IF NOT EXISTS `announcement_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_system_predefined` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

DROP TABLE IF EXISTS `applicants`;
CREATE TABLE IF NOT EXISTS `applicants` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TitleId` int(11) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `Initials` varchar(10) DEFAULT NULL,
  `Surname` varchar(50) DEFAULT NULL,
  `GenderId` int(11) DEFAULT NULL,
  `DateOfBirth` datetime DEFAULT NULL,
  `IdNumber` varchar(50) DEFAULT NULL,
  `MaritalStatusId` int(11) DEFAULT NULL,
  `LanguageId` int(11) DEFAULT NULL,
  `AdditionalInformation` varchar(512) DEFAULT NULL,
  `FileAttachmentName` varchar(100) DEFAULT NULL,
  `FileAttchment` longtext,
  `Telephone` varchar(20) DEFAULT NULL,
  `Mobile` varchar(20) DEFAULT NULL,
  `Email` varchar(128) DEFAULT NULL,
  `UnitNo` varchar(10) DEFAULT NULL,
  `Complex` varchar(100) DEFAULT NULL,
  `AddressLine1` varchar(100) DEFAULT NULL,
  `AddressLine2` varchar(100) DEFAULT NULL,
  `AddressLine3` varchar(100) DEFAULT NULL,
  `AddressLine4` varchar(100) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `Province` varchar(100) DEFAULT NULL,
  `ZipCode` varchar(10) DEFAULT NULL,
  `BackGroundChecked` tinyint(1) DEFAULT NULL,
  `BackgroundCheckedBy` varchar(100) DEFAULT NULL,
  `BackGroundCheckedDate` datetime(6) DEFAULT NULL,
  `BackGroundCheckDetails` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Applicants_Genders` (`GenderId`),
  KEY `FK_Applicants_Languages` (`LanguageId`),
  KEY `FK_Applicants_Titles` (`TitleId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

DROP TABLE IF EXISTS `applications`;
CREATE TABLE IF NOT EXISTS `applications` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ApplicantId` int(11) NOT NULL,
  `VacancyId` int(11) NOT NULL,
  `Date` datetime(6) NOT NULL,
  `Retained` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Applications_Applicants` (`ApplicantId`),
  KEY `FK_Applications_Vacancies` (`VacancyId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `applicationtestforms`
--

DROP TABLE IF EXISTS `applicationtestforms`;
CREATE TABLE IF NOT EXISTS `applicationtestforms` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `VacancyId` int(11) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Data` longtext NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `applicationtests`
--

DROP TABLE IF EXISTS `applicationtests`;
CREATE TABLE IF NOT EXISTS `applicationtests` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ApplicantId` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time(6) NOT NULL,
  `Duration` decimal(19,4) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `ApplicationTestTypeId` int(11) NOT NULL,
  `InternalTestId` varchar(20) DEFAULT NULL,
  `TestProvider` varchar(100) DEFAULT NULL,
  `Venue` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_ApplicationTests_Applicants` (`ApplicantId`),
  KEY `FK_ApplicationTests_ApplicationTestTypes` (`ApplicationTestTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `applicationtesttypes`
--

DROP TABLE IF EXISTS `applicationtesttypes`;
CREATE TABLE IF NOT EXISTS `applicationtesttypes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

DROP TABLE IF EXISTS `assessments`;
CREATE TABLE IF NOT EXISTS `assessments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(1024) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `passmark_percentage` double DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assessments_assessment_category`
--

DROP TABLE IF EXISTS `assessments_assessment_category`;
CREATE TABLE IF NOT EXISTS `assessments_assessment_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assessment_id` int(11) NOT NULL,
  `assessment_category_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_AssessmentsAssessmentCategories_AssessmentCategories` (`assessment_category_id`),
  KEY `FK_AssessmentsAssessmentCategories_Assessments` (`assessment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_categories`
--

DROP TABLE IF EXISTS `assessment_categories`;
CREATE TABLE IF NOT EXISTS `assessment_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(1024) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `eLearning_module` varchar(100) DEFAULT NULL,
  `threshold` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `passmark_percentage` double DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_category_category_question`
--

DROP TABLE IF EXISTS `assessment_category_category_question`;
CREATE TABLE IF NOT EXISTS `assessment_category_category_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assessment_category_id` int(11) NOT NULL,
  `category_question_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_AssessmentCategoriesCategoryQuestions_AssessmentCategories` (`assessment_category_id`),
  KEY `FK_AssessmentCategoriesCategoryQuestions_CategoryQuestions` (`category_question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_types`
--

DROP TABLE IF EXISTS `assessment_types`;
CREATE TABLE IF NOT EXISTS `assessment_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_ASSESSMENT_TYPES` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `assetdata_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `assetdata_view`;
CREATE TABLE IF NOT EXISTS `assetdata_view` (
`name` varchar(50)
,`total` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
CREATE TABLE IF NOT EXISTS `assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `asset_group_id` int(11) NOT NULL,
  `asset_supplier_id` int(11) NOT NULL,
  `tag` varchar(50) NOT NULL,
  `serial_no` varchar(20) NOT NULL,
  `purchase_price` decimal(19,4) NOT NULL,
  `po_number` varchar(20) NOT NULL,
  `warranty_expiry_date` date NOT NULL,
  `asset_condition_id` int(11) NOT NULL,
  `comments` varchar(256) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Assets_AssetConditions` (`asset_condition_id`),
  KEY `FK_Assets_AssetGroups` (`asset_group_id`),
  KEY `FK_Assets_Suppliers` (`asset_supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `asset_conditions`
--

DROP TABLE IF EXISTS `asset_conditions`;
CREATE TABLE IF NOT EXISTS `asset_conditions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `is_system_predefined` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `asset_employee`
--

DROP TABLE IF EXISTS `asset_employee`;
CREATE TABLE IF NOT EXISTS `asset_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date_out` date NOT NULL,
  `date_in` date DEFAULT NULL,
  `comment` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_AssetAllocations_Assets` (`asset_id`),
  KEY `FK_AssetAllocations_Employees` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `asset_groups`
--

DROP TABLE IF EXISTS `asset_groups`;
CREATE TABLE IF NOT EXISTS `asset_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_ASSET_GROUP_ACTIVE` (`name`,`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `asset_suppliers`
--

DROP TABLE IF EXISTS `asset_suppliers`;
CREATE TABLE IF NOT EXISTS `asset_suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `address3` varchar(100) DEFAULT NULL,
  `Address4` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `comments` varchar(256) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `audits`
--

DROP TABLE IF EXISTS `audits`;
CREATE TABLE IF NOT EXISTS `audits` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` int(10) UNSIGNED NOT NULL,
  `auditable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_values` text COLLATE utf8mb4_unicode_ci,
  `new_values` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audits_auditable_id_auditable_type_index` (`auditable_id`,`auditable_type`),
  KEY `audits_user_id_user_type_index` (`user_id`,`user_type`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audits_pivot`
--

DROP TABLE IF EXISTS `audits_pivot`;
CREATE TABLE IF NOT EXISTS `audits_pivot` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `event` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` int(10) UNSIGNED NOT NULL,
  `auditable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relation_id` int(10) UNSIGNED NOT NULL,
  `relation_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audits_pivot_auditable_id_auditable_type_index` (`auditable_id`,`auditable_type`),
  KEY `audits_pivot_relation_id_relation_type_index` (`relation_id`,`relation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bankaccounttypes`
--

DROP TABLE IF EXISTS `bankaccounttypes`;
CREATE TABLE IF NOT EXISTS `bankaccounttypes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(50) NOT NULL,
  `Active` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bankingdetails`
--

DROP TABLE IF EXISTS `bankingdetails`;
CREATE TABLE IF NOT EXISTS `bankingdetails` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(11) NOT NULL,
  `Bank` varchar(100) NOT NULL,
  `BranchCode` varchar(20) NOT NULL,
  `AccountNumber` varchar(20) NOT NULL,
  `AccountHolderName` varchar(100) NOT NULL,
  `AccountHolderRelation` varchar(100) NOT NULL,
  `Account` char(10) CHARACTER SET utf8mb4 NOT NULL,
  `BankAccountTypeId` int(11) NOT NULL,
  `SwiftCode` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_BankingDetails_BankAccountTypes` (`BankAccountTypeId`),
  KEY `FK_BankingDetails_Employees` (`EmployeeId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
CREATE TABLE IF NOT EXISTS `branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_BRANCHES_IS_SYSTEM_PREDEFINED` (`is_system_predefined`),
  KEY `FK_Branches_Companies1` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

DROP TABLE IF EXISTS `buildings`;
CREATE TABLE IF NOT EXISTS `buildings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Addr1` varchar(100) DEFAULT NULL,
  `Addr2` varchar(100) DEFAULT NULL,
  `Addr3` varchar(100) DEFAULT NULL,
  `Addr4` varchar(100) DEFAULT NULL,
  `ContactTelephone` varchar(20) DEFAULT NULL,
  `ContactPerson` varchar(100) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `calendarevents`
--

DROP TABLE IF EXISTS `calendarevents`;
CREATE TABLE IF NOT EXISTS `calendarevents` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CalendarParentEventsId` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` varchar(256) NOT NULL,
  `StartDate` datetime(6) NOT NULL,
  `EndDate` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_CalendarEvents_CalendarParentEvents` (`CalendarParentEventsId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `calendarparentevents`
--

DROP TABLE IF EXISTS `calendarparentevents`;
CREATE TABLE IF NOT EXISTS `calendarparentevents` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) NOT NULL,
  `Description` varchar(256) NOT NULL,
  `StartDate` datetime(6) NOT NULL,
  `EndDate` datetime(6) NOT NULL,
  `Weekday` int(11) DEFAULT NULL,
  `Repeats` tinyint(1) DEFAULT '0',
  `RepeatFrequency` int(11) DEFAULT NULL,
  `AllDay` tinyint(1) DEFAULT '0',
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category_questions`
--

DROP TABLE IF EXISTS `category_questions`;
CREATE TABLE IF NOT EXISTS `category_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_question_type_id` enum('1','2','3') NOT NULL DEFAULT '1',
  `title` varchar(1024) NOT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `points` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_zeromark` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category_question_choices`
--

DROP TABLE IF EXISTS `category_question_choices`;
CREATE TABLE IF NOT EXISTS `category_question_choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_question_id` int(11) NOT NULL,
  `choice_text` longtext NOT NULL,
  `points` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_CategoryQuestionChoices_CategoryQuestions2` (`category_question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category_question_types`
--

DROP TABLE IF EXISTS `category_question_types`;
CREATE TABLE IF NOT EXISTS `category_question_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `commentdetails`
--

DROP TABLE IF EXISTS `commentdetails`;
CREATE TABLE IF NOT EXISTS `commentdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_discussion_iId` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `date_posted` datetime DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `thread_status_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_CommentDetails_CourseDiscussions` (`course_discussion_iId`),
  KEY `FK_CommentDetails_Employees` (`employee_id`),
  KEY `FK_CommentDetails_ThreadStatuses` (`thread_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `companydocuments`
--

DROP TABLE IF EXISTS `companydocuments`;
CREATE TABLE IF NOT EXISTS `companydocuments` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `OriginalFullName` varchar(1024) NOT NULL,
  `SavedFolderPath` varchar(1024) NOT NULL,
  `SavedFileName` varchar(1024) NOT NULL,
  `DateUploaded` datetime(6) NOT NULL,
  `UploadedByShamUserId` int(11) NOT NULL,
  `DocumentTypeId` int(11) NOT NULL,
  `DocumentCategoryId` int(11) NOT NULL,
  `Content` longtext NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_CompanyDocuments_DocumentCategories` (`DocumentCategoryId`),
  KEY `FK_CompanyDocuments_DocumentTypes` (`DocumentTypeId`),
  KEY `FK_CompanyDocuments_ShamUsers` (`UploadedByShamUserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_preferred` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courseparticipantstatuses`
--

DROP TABLE IF EXISTS `courseparticipantstatuses`;
CREATE TABLE IF NOT EXISTS `courseparticipantstatuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(300) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courseprerequisites`
--

DROP TABLE IF EXISTS `courseprerequisites`;
CREATE TABLE IF NOT EXISTS `courseprerequisites` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CourseId` int(11) NOT NULL,
  `PrerequisiteCourseId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_CoursePrerquisites_Course` (`CourseId`),
  KEY `FK_CoursePrerquisites_Course1` (`PrerequisiteCourseId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_public` tinyint(1) DEFAULT '0',
  `overview` longtext,
  `objectives` longtext,
  `passmark_percentage` int(11) DEFAULT NULL,
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `durations` double DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_active_public_description` (`is_public`,`is_active`,`description`),
  KEY `IDX_course_id_deleted` (`id`,`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_discussions`
--

DROP TABLE IF EXISTS `course_discussions`;
CREATE TABLE IF NOT EXISTS `course_discussions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `title` longtext,
  `thread_status_id` int(11) DEFAULT NULL,
  `date_posted` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_COURSE_DISCUSSIONS_PARENT_ID` (`parent_id`),
  KEY `FK_CourseDiscussions_Courses` (`course_id`),
  KEY `FK_CourseDiscussions_Employees` (`employee_id`),
  KEY `FK_CourseDiscussions_ThreadStatuses` (`thread_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_employee`
--

DROP TABLE IF EXISTS `course_employee`;
CREATE TABLE IF NOT EXISTS `course_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `courseparticipantstatus_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_CourseParticipants_CourseParticipantStatuses` (`courseparticipantstatus_id`),
  KEY `FK_CourseParticipants_Courses` (`course_id`),
  KEY `FK_CourseParticipants_Employees` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_module`
--

DROP TABLE IF EXISTS `course_module`;
CREATE TABLE IF NOT EXISTS `course_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `is_optional` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_CourseModules_Course` (`course_id`),
  KEY `FK_CourseModules_Module` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_progress`
--

DROP TABLE IF EXISTS `course_progress`;
CREATE TABLE IF NOT EXISTS `course_progress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `is_completed` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `completed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_courseprogress_id_employee_course` (`id`,`employee_id`,`course_id`),
  KEY `FK_CourseProgress_Courses` (`course_id`),
  KEY `FK_CourseProgress_Employees` (`employee_id`),
  KEY `FK_CourseProgress_Modules` (`module_id`),
  KEY `FK_CourseProgress_Topics` (`topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `csv_data`
--

DROP TABLE IF EXISTS `csv_data`;
CREATE TABLE IF NOT EXISTS `csv_data` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `csv_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `csv_header` tinyint(1) NOT NULL DEFAULT '0',
  `csv_data` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE IF NOT EXISTS `currencies` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(50) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

DROP TABLE IF EXISTS `days`;
CREATE TABLE IF NOT EXISTS `days` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `day_number` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `day_time_group_time_period`
--

DROP TABLE IF EXISTS `day_time_group_time_period`;
CREATE TABLE IF NOT EXISTS `day_time_group_time_period` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_group_id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `time_period_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_TimeGroupDays_Days` (`day_id`),
  KEY `FK_TimeGroupDays_TimeGroups` (`time_group_id`),
  KEY `FK_TimeGroupDays_TimePeriods` (`time_period_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_DEPARTMENTS_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `disabilities`
--

DROP TABLE IF EXISTS `disabilities`;
CREATE TABLE IF NOT EXISTS `disabilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `disability_category_id` int(11) NOT NULL,
  `is_system_predefined` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_disability_categories_id_idx` (`disability_category_id`),
  KEY `IX_DISABILITIES_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

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


-- --------------------------------------------------------

--
-- Table structure for table `disability_categories`
--

DROP TABLE IF EXISTS `disability_categories`;
CREATE TABLE IF NOT EXISTS `disability_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_system_predefined` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_DISABILITY_CATEGORIES_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

INSERT INTO `disability_categories` (`description`, `is_system_predefined`) VALUES ('Aids', '1');
INSERT INTO `disability_categories` (`description`, `is_system_predefined`) VALUES ('Hearing', '1');
INSERT INTO `disability_categories` (`description`, `is_system_predefined`) VALUES ('Learning', '1');
INSERT INTO `disability_categories` (`description`, `is_system_predefined`) VALUES ('Mental', '1');
INSERT INTO `disability_categories` (`description`, `is_system_predefined`) VALUES ('Other', '1');
INSERT INTO `disability_categories` (`description`, `is_system_predefined`) VALUES ('Personality', '1');
INSERT INTO `disability_categories` (`description`, `is_system_predefined`) VALUES ('Visual', '1');

-- --------------------------------------------------------

--
-- Table structure for table `disability_employee`
--

DROP TABLE IF EXISTS `disability_employee`;
CREATE TABLE IF NOT EXISTS `disability_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `disability_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_EMPLOYEE_DISABILITY` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `disciplinary_actions`
--

DROP TABLE IF EXISTS `disciplinary_actions`;
CREATE TABLE IF NOT EXISTS `disciplinary_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `violation_id` int(11) NOT NULL,
  `violation_date` date NOT NULL,
  `employee_statement` longtext NOT NULL,
  `employer_statement` longtext NOT NULL,
  `decision` longtext NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `date_issued` date DEFAULT NULL,
  `date_expires` date DEFAULT NULL,
  `disciplinary_decision_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_DisciplinaryActions_Decisions` (`disciplinary_decision_id`),
  KEY `FK_DisciplinaryActions_Employees` (`employee_id`),
  KEY `FK_DisciplinaryActions_Violations` (`violation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `disciplinary_decisions`
--

DROP TABLE IF EXISTS `disciplinary_decisions`;
CREATE TABLE IF NOT EXISTS `disciplinary_decisions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

DROP TABLE IF EXISTS `divisions`;
CREATE TABLE IF NOT EXISTS `divisions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `document_categories`
--

DROP TABLE IF EXISTS `document_categories`;
CREATE TABLE IF NOT EXISTS `document_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_DOCUMENT_CATEGORIES` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

DROP TABLE IF EXISTS `document_types`;
CREATE TABLE IF NOT EXISTS `document_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `extension` varchar(10) NOT NULL,
  `description` char(10) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_DOCUMENT_TYPES_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_addresses`
--

DROP TABLE IF EXISTS `email_addresses`;
CREATE TABLE IF NOT EXISTS `email_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `email_address` varchar(512) NOT NULL,
  `email_address_type_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_EmailAddresses_EmailAddressTypes` (`email_address_type_id`),
  KEY `FK_EmailAddresses_Employees` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_address_types`
--

DROP TABLE IF EXISTS `email_address_types`;
CREATE TABLE IF NOT EXISTS `email_address_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_EMAIL_ADDRESS_TYPES_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_id` int(11) DEFAULT NULL,
  `initials` varchar(10) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `known_as` varchar(50) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `marital_status_id` int(11) DEFAULT NULL,
  `id_number` varchar(50) NOT NULL,
  `passport_country_id` int(11) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `ethnic_group_id` int(11) DEFAULT NULL,
  `immigration_status_id` int(11) DEFAULT NULL,
  `time_group_id` int(11) DEFAULT NULL,
  `passport_no` varchar(50) DEFAULT NULL,
  `spouse_full_name` varchar(50) DEFAULT NULL,
  `employee_no` varchar(50) NOT NULL,
  `employee_code` varchar(50) NOT NULL,
  `tax_number` varchar(50) DEFAULT NULL,
  `tax_status_id` int(11) DEFAULT NULL,
  `date_joined` date DEFAULT NULL,
  `date_terminated` date DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `employee_status_id` int(11) DEFAULT NULL,
  `physical_file_no` varchar(50) DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `picture` longtext,
  `line_manager_id` int(11) DEFAULT NULL,
  `leave_balance_at_start` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IX_Employees` (`id_number`,`employee_code`),
  UNIQUE KEY `IX_Employees_EmployeeCode` (`employee_code`),
  UNIQUE KEY `IX_Employees_EmployeeNo` (`employee_no`),
  KEY `IX_Employees_TerminationDate_Active` (`date_terminated`,`is_active`),
  KEY `IX_Employees_Joined_Terminated` (`date_joined`,`date_terminated`,`is_active`),
  KEY `FK_Employees_Branches` (`branch_id`),
  KEY `FK_Employees_Countries` (`passport_country_id`),
  KEY `FK_Employees_Departments` (`department_id`),
  KEY `FK_Employees_Divisions` (`division_id`),
  KEY `FK_Employees_EmployeeStatuses` (`employee_status_id`),
  KEY `FK_Employees_EthnicGroups` (`ethnic_group_id`),
  KEY `FK_Employees_Genders` (`gender_id`),
  KEY `FK_Employees_ImmigrationStatuses` (`immigration_status_id`),
  KEY `FK_Employees_JobTitles` (`job_title_id`),
  KEY `FK_Employees_Languages` (`language_id`),
  KEY `FK_Employees_MaritalStatuses` (`marital_status_id`),
  KEY `FK_Employees_TaxStatuses` (`tax_status_id`),
  KEY `FK_Employees_Teams` (`team_id`),
  KEY `FK_Employees_Titles` (`title_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employeesleaveschedules`
--

DROP TABLE IF EXISTS `employeesleaveschedules`;
CREATE TABLE IF NOT EXISTS `employeesleaveschedules` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(11) NOT NULL,
  `LeaveScheduleId` int(11) NOT NULL,
  `EffectiveFrom` date NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_EmployeesLeaveSchedules_Employees` (`EmployeeId`),
  KEY `FK_EmployeesLeaveSchedules_LeaveSchedules` (`LeaveScheduleId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employees_audit`
--

DROP TABLE IF EXISTS `employees_audit`;
CREATE TABLE IF NOT EXISTS `employees_audit` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(11) NOT NULL,
  `UpdateType` char(10) NOT NULL,
  `TitleId` int(11) DEFAULT NULL,
  `Initials` varchar(10) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `Surname` varchar(50) DEFAULT NULL,
  `KnownAs` varchar(50) DEFAULT NULL,
  `DateOfBirth` datetime DEFAULT NULL,
  `MaritalStatusId` int(11) DEFAULT NULL,
  `IdNumber` varchar(50) DEFAULT NULL,
  `PassportCountryId` int(11) DEFAULT NULL,
  `Nationality` varchar(50) DEFAULT NULL,
  `LanguageId` int(11) DEFAULT NULL,
  `GenderId` int(11) DEFAULT NULL,
  `EthnicGroupId` int(11) DEFAULT NULL,
  `ImmigrationStatusId` int(11) DEFAULT NULL,
  `TimeGroupId` int(11) DEFAULT NULL,
  `PassportNo` varchar(50) DEFAULT NULL,
  `SpouseFullName` varchar(50) DEFAULT NULL,
  `EmployeeNo` varchar(50) DEFAULT NULL,
  `EmployeeCode` varchar(50) DEFAULT NULL,
  `TaxNumber` varchar(50) DEFAULT NULL,
  `TaxStatusId` int(11) DEFAULT NULL,
  `JoinedDate` datetime DEFAULT NULL,
  `TerminationDate` datetime DEFAULT NULL,
  `DepartmentId` int(11) DEFAULT NULL,
  `TeamId` int(11) DEFAULT NULL,
  `EmployeeStatusId` int(11) DEFAULT NULL,
  `PhysicalFileNo` varchar(50) DEFAULT NULL,
  `JobTitleId` int(11) DEFAULT NULL,
  `DivisionId` int(11) DEFAULT NULL,
  `BranchId` int(11) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT NULL,
  `Picture` longtext,
  `LineManagerId` int(11) DEFAULT NULL,
  `LeaveBalanceAtStart` int(11) DEFAULT NULL,
  `Timestamp` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_attachments`
--

DROP TABLE IF EXISTS `employee_attachments`;
CREATE TABLE IF NOT EXISTS `employee_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `comment` varchar(100) DEFAULT NULL,
  `employee_attachment_type_id` int(11) DEFAULT NULL,
  `original_file_name` varchar(512) NOT NULL,
  `content` longblob,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_EmployeeAttachments_EmployeeAttachmentTypes` (`employee_attachment_type_id`),
  KEY `FK_EmployeeAttachments_Employees` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_attachment_types`
--

DROP TABLE IF EXISTS `employee_attachment_types`;
CREATE TABLE IF NOT EXISTS `employee_attachment_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_EMPLOYEE_ATTACHMENT_TYPES_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_attendance_records`
--

DROP TABLE IF EXISTS `employee_attendance_records`;
CREATE TABLE IF NOT EXISTS `employee_attendance_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time(6) NOT NULL,
  `time_out` time(6) DEFAULT NULL,
  `sys_user_created` varchar(50) DEFAULT NULL,
  `date_created` datetime(6) DEFAULT NULL,
  `sys_user_updated` varchar(50) DEFAULT NULL,
  `date_updated` datetime(6) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IX_EmployeeAttendanceRecords_EmployeeId_Date` (`employee_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_evaluation`
--

DROP TABLE IF EXISTS `employee_evaluation`;
CREATE TABLE IF NOT EXISTS `employee_evaluation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluation_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT '0',
  `summary` longtext,
  `comments` longtext,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_EvaluationAssessors_Employees` (`employee_id`),
  KEY `FK_EvaluationAssessors_Evaluations` (`evaluation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_skill`
--

DROP TABLE IF EXISTS `employee_skill`;
CREATE TABLE IF NOT EXISTS `employee_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_EmployeeSkills_Employees` (`employee_id`),
  KEY `FK_EmployeeSkills_Skills` (`skill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_statuses`
--

DROP TABLE IF EXISTS `employee_statuses`;
CREATE TABLE IF NOT EXISTS `employee_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_EMPLOYEE_STATUS_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_training_session`
--

DROP TABLE IF EXISTS `employee_training_session`;
CREATE TABLE IF NOT EXISTS `employee_training_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `training_session_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_TrainingSessionParticipants_Employees` (`employee_id`),
  KEY `FK_TrainingSessionParticipants_TrainingSessions` (`training_session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `entityproperties`
--

DROP TABLE IF EXISTS `entityproperties`;
CREATE TABLE IF NOT EXISTS `entityproperties` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TableName` varchar(100) NOT NULL,
  `ColumnName` varchar(100) NOT NULL,
  `DataType` varchar(100) NOT NULL,
  `MaxLength` int(11) NOT NULL,
  `AllowDBNull` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ethnic_groups`
--

DROP TABLE IF EXISTS `ethnic_groups`;
CREATE TABLE IF NOT EXISTS `ethnic_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_ETHNIC_GROUPS_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

DROP TABLE IF EXISTS `evaluations`;
CREATE TABLE IF NOT EXISTS `evaluations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assessment_id` int(11) NOT NULL,
  `user_employee_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `reference_no` varchar(200) DEFAULT NULL,
  `reference_source` varchar(200) DEFAULT NULL,
  `productcategory_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `feedback_date` date NOT NULL,
  `qa_sample` longblob,
  `comments` varchar(512) DEFAULT NULL,
  `evaluation_status_id` enum('1','2') NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `createdby_employee_id` int(11) DEFAULT NULL,
  `original_filename` varchar(256) DEFAULT NULL,
  `is_usecontent` tinyint(1) DEFAULT NULL,
  `url_path` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Evaluations_Assessments` (`assessment_id`),
  KEY `FK_Evaluations_Departments` (`department_id`),
  KEY `FK_Evaluations_Employees` (`user_employee_id`),
  KEY `FK_Evaluations_Employees1` (`createdby_employee_id`),
  KEY `FK_Evaluations_Languages` (`language_id`),
  KEY `FK_Evaluations_ProductCategories` (`productcategory_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_results`
--

DROP TABLE IF EXISTS `evaluation_results`;
CREATE TABLE IF NOT EXISTS `evaluation_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluation_id` int(11) NOT NULL,
  `assessor_employee_id` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `assessment_category_id` int(11) NOT NULL,
  `category_question_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `points` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_EvaluationResults_AssessmentCategories` (`assessment_category_id`),
  KEY `FK_EvaluationResults_Assessments` (`assessment_id`),
  KEY `FK_EvaluationResults_CategoryQuestions` (`category_question_id`),
  KEY `FK_EvaluationResults_Employees` (`assessor_employee_id`),
  KEY `IX_EvaluationResults_evaluation_accessor` (`evaluation_id`,`assessor_employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_statuses`
--

DROP TABLE IF EXISTS `evaluation_statuses`;
CREATE TABLE IF NOT EXISTS `evaluation_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `is_system_event` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `eventscol` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_task`
--

DROP TABLE IF EXISTS `event_task`;
CREATE TABLE IF NOT EXISTS `event_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__EventTask__Event__729BEF18` (`event_id`),
  KEY `FK__EventTask__TaskI__73901351` (`task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_task_instances`
--

DROP TABLE IF EXISTS `event_task_instances`;
CREATE TABLE IF NOT EXISTS `event_task_instances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_task_id` int(11) NOT NULL,
  `employee_created_Id` int(11) NOT NULL,
  `date_created` datetime(6) NOT NULL,
  `date_due` datetime(6) DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT NULL,
  `link_type_id` int(11) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `comment` varchar(250) DEFAULT NULL,
  `employee_allocated_id` int(11) DEFAULT NULL,
  `date_completed` datetime(6) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__EventTask__Emplo__7948ECA7` (`employee_created_Id`),
  KEY `FK__EventTask__Emplo__7C255952` (`employee_allocated_id`),
  KEY `FK__EventTask__Event__7854C86E` (`event_task_id`),
  KEY `FK__EventTask__LinkT__7A3D10E0` (`link_type_id`),
  KEY `FK__EventTask__Targe__7B313519` (`target_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `sata` longtext NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

DROP TABLE IF EXISTS `genders`;
CREATE TABLE IF NOT EXISTS `genders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `headcountbydepartment_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `headcountbydepartment_view`;
CREATE TABLE IF NOT EXISTS `headcountbydepartment_view` (
`Id` int(11)
,`Department` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `headcountbygender_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `headcountbygender_view`;
CREATE TABLE IF NOT EXISTS `headcountbygender_view` (
`Id` int(11)
,`Sex` varchar(50)
,`Ethnicity` varchar(50)
,`TerminationDate` date
,`JoinedDate` date
,`YearsService` bigint(21)
,`Size` int(1)
);

-- --------------------------------------------------------

--
-- Table structure for table `history_departments`
--

DROP TABLE IF EXISTS `history_departments`;
CREATE TABLE IF NOT EXISTS `history_departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `date_occurred` date NOT NULL,
  `updated_by_employee_id` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_HistoryDepartments_Departments` (`department_id`),
  KEY `FK_HistoryDepartments_Employees` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history_disciplinary_actions`
--

DROP TABLE IF EXISTS `history_disciplinary_actions`;
CREATE TABLE IF NOT EXISTS `history_disciplinary_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `disciplinary_action_id` int(11) NOT NULL,
  `date_occurred` date NOT NULL,
  `updated_by_employeeid` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_HistoryDisciplinaryActions_DisciplinaryActions` (`disciplinary_action_id`),
  KEY `IX_HistoryDisciplinaryActions_employee_id` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history_job_titles`
--

DROP TABLE IF EXISTS `history_job_titles`;
CREATE TABLE IF NOT EXISTS `history_job_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `job_title_id` int(11) NOT NULL,
  `date_occurred` date NOT NULL,
  `updated_by_employee_id` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_HistoryJobTitles_JobTitles` (`job_title_id`),
  KEY `IX_HistoryJobTitle_employee_id` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history_join_terminations`
--

DROP TABLE IF EXISTS `history_join_terminations`;
CREATE TABLE IF NOT EXISTS `history_join_terminations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `is_joined` tinyint(1) NOT NULL,
  `date_occurred` date NOT NULL,
  `updated_by_employee_id` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_HistoryJoinsTerminations_Employees` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history_qualifications`
--

DROP TABLE IF EXISTS `history_qualifications`;
CREATE TABLE IF NOT EXISTS `history_qualifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `qualification_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `UpdatedBy` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_HistoryQualifications_Employees` (`employee_id`),
  KEY `FK_HistoryQualifications_Qualifications` (`qualification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history_rewards`
--

DROP TABLE IF EXISTS `history_rewards`;
CREATE TABLE IF NOT EXISTS `history_rewards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `reward_id` int(11) NOT NULL,
  `date_occurred` date NOT NULL,
  `updated_by_employee_id` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_HistoryRewards_Employees` (`employee_id`),
  KEY `FK_HistoryRewards_Rewards` (`reward_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `immigration_statuses`
--

DROP TABLE IF EXISTS `immigration_statuses`;
CREATE TABLE IF NOT EXISTS `immigration_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_IMMIGRATION_STATUSES_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `interviewforms`
--

DROP TABLE IF EXISTS `interviewforms`;
CREATE TABLE IF NOT EXISTS `interviewforms` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `VacancyId` int(11) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Data` longtext NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_InterviewForms_Vacancies` (`VacancyId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `interviews`
--

DROP TABLE IF EXISTS `interviews`;
CREATE TABLE IF NOT EXISTS `interviews` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ApplicantId` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time(6) NOT NULL,
  `Duration` decimal(19,4) NOT NULL,
  `Venue` varchar(100) DEFAULT NULL,
  `Attendees` varchar(100) DEFAULT NULL,
  `SelectionCriteria` longtext,
  PRIMARY KEY (`Id`),
  KEY `FK_Interviews_Applicants` (`ApplicantId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jobadverts`
--

DROP TABLE IF EXISTS `jobadverts`;
CREATE TABLE IF NOT EXISTS `jobadverts` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `VacancyId` int(11) NOT NULL,
  `IssueDate` datetime(6) DEFAULT NULL,
  `Provider` varchar(100) DEFAULT NULL,
  `Days` int(11) DEFAULT NULL,
  `Verified` tinyint(1) NOT NULL,
  `AttachmentName` varchar(100) DEFAULT NULL,
  `Attachment` longtext,
  `VerifiedDate` datetime(6) DEFAULT NULL,
  `VerifiedBy` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_JobAdverts_Vacancies` (`VacancyId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_titles`
--

DROP TABLE IF EXISTS `job_titles`;
CREATE TABLE IF NOT EXISTS `job_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_manager` tinyint(1) NOT NULL,
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_JOB_TITLES_IS_SYSTEM_PREDEFINED` (`is_system_predefined`),
  KEY `IX_JOB_TITLES_IS_MANAGER` (`is_manager`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_preferred` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `laws`
--

DROP TABLE IF EXISTS `laws`;
CREATE TABLE IF NOT EXISTS `laws` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main_heading` varchar(100) NOT NULL,
  `sub_heading` varchar(100) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `law_category_id` int(11) DEFAULT NULL,
  `content` longtext NOT NULL,
  `is_public` tinyint(1) DEFAULT NULL,
  `expires_on` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Laws_Countries` (`country_id`),
  KEY `FK_Laws_LawCategories` (`law_category_id`),
  KEY `IX_laws_deleted_at` (`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `law_categories`
--

DROP TABLE IF EXISTS `law_categories`;
CREATE TABLE IF NOT EXISTS `law_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `law_documents`
--

DROP TABLE IF EXISTS `law_documents`;
CREATE TABLE IF NOT EXISTS `law_documents` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `LawId` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Content` longtext,
  PRIMARY KEY (`Id`),
  KEY `FK_law_documents_law_id` (`LawId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `learning_materials`
--

DROP TABLE IF EXISTS `learning_materials`;
CREATE TABLE IF NOT EXISTS `learning_materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `learning_material_type_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_LearningMaterials_LearningMaterialTypes` (`learning_material_type_id`),
  KEY `FK_LearningMaterials_Modules` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `learning_material_types`
--

DROP TABLE IF EXISTS `learning_material_types`;
CREATE TABLE IF NOT EXISTS `learning_material_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leaveapplicationforms`
--

DROP TABLE IF EXISTS `leaveapplicationforms`;
CREATE TABLE IF NOT EXISTS `leaveapplicationforms` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(11) NOT NULL,
  `Paid` tinyint(1) NOT NULL,
  `DaysDue` int(11) NOT NULL,
  `DayRequired` int(11) NOT NULL,
  `FirstDayOfLeave` datetime(6) NOT NULL,
  `LastDayOfLeave` datetime(6) NOT NULL,
  `LeaveTypeId` int(11) NOT NULL,
  `Granted` tinyint(1) DEFAULT NULL,
  `ReasonNotGranted` varchar(512) DEFAULT NULL,
  `Authorised` tinyint(1) DEFAULT NULL,
  `SickNoteAttached` tinyint(1) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  KEY `FK_LeaveApplicationForms_Employees` (`EmployeeId`),
  KEY `FK_LeaveApplicationForms_LeaveTypes` (`LeaveTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leaveapplications`
--

DROP TABLE IF EXISTS `leaveapplications`;
CREATE TABLE IF NOT EXISTS `leaveapplications` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(11) NOT NULL,
  `Date` datetime(6) NOT NULL,
  `ManagerId` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leavedays`
--

DROP TABLE IF EXISTS `leavedays`;
CREATE TABLE IF NOT EXISTS `leavedays` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `LeaveApplicationId` int(11) NOT NULL,
  `LeaveTypeId` int(11) NOT NULL,
  `LeaveDate` datetime(6) NOT NULL,
  `Paid` tinyint(1) NOT NULL,
  `Approved` tinyint(1) DEFAULT NULL,
  `ApprovedBy` int(11) DEFAULT NULL,
  `Cancelled` tinyint(1) DEFAULT NULL,
  `CancelledBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_LeaveDays_LeaveApplications` (`LeaveApplicationId`),
  KEY `FK_LeaveDays_LeaveTypes` (`LeaveTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leavescheduleitems`
--

DROP TABLE IF EXISTS `leavescheduleitems`;
CREATE TABLE IF NOT EXISTS `leavescheduleitems` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `LeaveScheduleId` int(11) NOT NULL,
  `LeaveTypeId` int(11) NOT NULL,
  `YearlyEntitlement` int(11) NOT NULL,
  `YearlyCarriedOver` int(11) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  KEY `FK_LeaveScheduleItems_LeaveSchedules` (`LeaveScheduleId`),
  KEY `FK_LeaveScheduleItems_LeaveTypes` (`LeaveTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leaveschedules`
--

DROP TABLE IF EXISTS `leaveschedules`;
CREATE TABLE IF NOT EXISTS `leaveschedules` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leavetypes`
--

DROP TABLE IF EXISTS `leavetypes`;
CREATE TABLE IF NOT EXISTS `leavetypes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `link_types`
--

DROP TABLE IF EXISTS `link_types`;
CREATE TABLE IF NOT EXISTS `link_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `maritalstatuses`
--

DROP TABLE IF EXISTS `maritalstatuses`;
CREATE TABLE IF NOT EXISTS `maritalstatuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `disk` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `directory` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aggregate_type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int(10) UNSIGNED NOT NULL,
  `comment` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extrable_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extrable_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_disk_directory_filename_extension_unique` (`disk`,`directory`(100),`filename`(100),`extension`),
  KEY `media_disk_directory_index` (`disk`,`directory`),
  KEY `media_aggregate_type_index` (`aggregate_type`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mediables`
--

DROP TABLE IF EXISTS `mediables`;
CREATE TABLE IF NOT EXISTS `mediables` (
  `media_id` int(10) UNSIGNED NOT NULL,
  `mediable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mediable_id` int(10) UNSIGNED NOT NULL,
  `tag` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`media_id`,`mediable_type`(100),`mediable_id`,`tag`(100)),
  KEY `mediables_mediable_id_mediable_type_index` (`mediable_id`,`mediable_type`),
  KEY `mediables_tag_index` (`tag`),
  KEY `mediables_order_index` (`order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `moduleprerequisites`
--

DROP TABLE IF EXISTS `moduleprerequisites`;
CREATE TABLE IF NOT EXISTS `moduleprerequisites` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ModuleId` int(11) NOT NULL,
  `PrerequisiteModuleId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_ModulePrerequisites_Module` (`ModuleId`),
  KEY `FK_ModulePrerequisites_Module1` (`PrerequisiteModuleId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(256) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_public` tinyint(1) DEFAULT '0',
  `overview` longtext,
  `objectives` longtext,
  `passmark_percentage` double DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_active_public_description` (`is_active`,`is_public`,`description`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `module_assessments`
--

DROP TABLE IF EXISTS `module_assessments`;
CREATE TABLE IF NOT EXISTS `module_assessments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `assessment_type_id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `data` longtext NOT NULL,
  `pass_mark` double NOT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ModuleAssessments_AssessmentTypes` (`assessment_type_id`),
  KEY `FK_ModuleAssessments_Employees` (`trainer_id`),
  KEY `FK_ModuleAssessments_Module` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `module_assessment_questions`
--

DROP TABLE IF EXISTS `module_assessment_questions`;
CREATE TABLE IF NOT EXISTS `module_assessment_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_assessment_id` int(11) NOT NULL,
  `module_question_id` int(11) NOT NULL,
  `sequence` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ModuleAssessmentQuestions_ModuleAssessments` (`module_assessment_id`),
  KEY `FK_ModuleAssessmentQuestions_ModuleQuestions` (`module_question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `module_assessment_responses`
--

DROP TABLE IF EXISTS `module_assessment_responses`;
CREATE TABLE IF NOT EXISTS `module_assessment_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `date_completed` date DEFAULT NULL,
  `is_reviewed` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `module_assessment_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ModuleAssessmentResponses_Courses` (`course_id`),
  KEY `FK_ModuleAssessmentResponses_Employees` (`employee_id`),
  KEY `FK_ModuleAssessmentResponses_ModuleAssessments` (`module_assessment_id`),
  KEY `FK_ModuleAssessmentResponses_Modules` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `module_assessment_response_details`
--

DROP TABLE IF EXISTS `module_assessment_response_details`;
CREATE TABLE IF NOT EXISTS `module_assessment_response_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_assessment_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `module_question_id` int(11) NOT NULL,
  `module_assessment_response_id` int(11) NOT NULL,
  `content` longtext,
  `points` double DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sequence` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ModuleAssessmentResponseDetails_ModuleAssessmentResponses` (`module_assessment_response_id`),
  KEY `FK_ModuleAssessmentResponseDetails_ModuleAssessments` (`module_assessment_id`),
  KEY `FK_ModuleAssessmentResponseDetails_ModuleQuestions` (`module_question_id`),
  KEY `FK_ModuleAssessmentResponseDetails_Modules` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `module_questions`
--

DROP TABLE IF EXISTS `module_questions`;
CREATE TABLE IF NOT EXISTS `module_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_question_type_id` int(11) NOT NULL,
  `title` varchar(300) DEFAULT NULL,
  `points` double DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ModuleQuestions_ModuleQuestionTypes` (`module_question_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `module_question_choices`
--

DROP TABLE IF EXISTS `module_question_choices`;
CREATE TABLE IF NOT EXISTS `module_question_choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_question_id` int(11) NOT NULL,
  `choice_text` longtext,
  `correct_answer` tinyint(1) DEFAULT NULL,
  `points` double DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ModuleQuestionChoices_ModuleQuestions` (`module_question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `module_question_types`
--

DROP TABLE IF EXISTS `module_question_types`;
CREATE TABLE IF NOT EXISTS `module_question_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(300) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_system_predefined` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_MODULE_QUESTION_TYPES_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `module_topic`
--

DROP TABLE IF EXISTS `module_topic`;
CREATE TABLE IF NOT EXISTS `module_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_ModuleTopics_Modules` (`module_id`),
  KEY `FK_ModuleTopics_Topics` (`topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `newhires_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `newhires_view`;
CREATE TABLE IF NOT EXISTS `newhires_view` (
`Year` bigint(20)
,`Count` bigint(21)
,`Type` bigint(20)
,`Name` varchar(10)
);

-- --------------------------------------------------------

--
-- Table structure for table `notificationgroupsshamusers`
--

DROP TABLE IF EXISTS `notificationgroupsshamusers`;
CREATE TABLE IF NOT EXISTS `notificationgroupsshamusers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `NotificationGroupId` int(11) NOT NULL,
  `ShamUserId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_NotificationGroupsShamUsers_NotificationGroups` (`NotificationGroupId`),
  KEY `FK_NotificationGroupsShamUsers_ShamUsers` (`ShamUserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notificationparticipants`
--

DROP TABLE IF EXISTS `notificationparticipants`;
CREATE TABLE IF NOT EXISTS `notificationparticipants` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `WorkflowStepId` int(11) NOT NULL,
  `ShamUserId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_NotificationParticipants_ShamUsers` (`ShamUserId`),
  KEY `FK_NotificationParticipants_WorkflowSteps1` (`WorkflowStepId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `NotificationTypeId` int(11) NOT NULL,
  `StartDate` datetime(6) DEFAULT NULL,
  `NotificationRecurrenceId` int(11) NOT NULL,
  `NotificationGroupId` int(11) NOT NULL,
  `NotificationTimesId` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `BodyText` longtext NOT NULL,
  `NotificationStatusId` int(11) NOT NULL,
  `Attachment` longtext,
  `AttachmentFileName` varchar(512) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  `TriggerId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Notifications_NotificationGroups` (`NotificationGroupId`),
  KEY `FK_Notifications_NotificationRecurrences` (`NotificationRecurrenceId`),
  KEY `FK_Notifications_NotificationStatuses` (`NotificationStatusId`),
  KEY `FK_Notifications_NotificationTimes` (`NotificationTimesId`),
  KEY `FK_Notifications_NotificationTypes` (`NotificationTypeId`),
  KEY `FK_Notifications_Triggers` (`TriggerId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notificationstatuses`
--

DROP TABLE IF EXISTS `notificationstatuses`;
CREATE TABLE IF NOT EXISTS `notificationstatuses` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notificationtimes`
--

DROP TABLE IF EXISTS `notificationtimes`;
CREATE TABLE IF NOT EXISTS `notificationtimes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  `Days` int(11) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notificationtypes`
--

DROP TABLE IF EXISTS `notificationtypes`;
CREATE TABLE IF NOT EXISTS `notificationtypes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification_groups`
--

DROP TABLE IF EXISTS `notification_groups`;
CREATE TABLE IF NOT EXISTS `notification_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification_recurrences`
--

DROP TABLE IF EXISTS `notification_recurrences`;
CREATE TABLE IF NOT EXISTS `notification_recurrences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `days` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offerresponses`
--

DROP TABLE IF EXISTS `offerresponses`;
CREATE TABLE IF NOT EXISTS `offerresponses` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

DROP TABLE IF EXISTS `offers`;
CREATE TABLE IF NOT EXISTS `offers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ApplicationId` int(11) NOT NULL,
  `Date` datetime(6) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `AttachmentFileName` varchar(100) DEFAULT NULL,
  `Attachment` longtext,
  `Offer` char(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `OfferResponseId` int(11) DEFAULT NULL,
  `ResponseDate` datetime(6) DEFAULT NULL,
  `ResponseReason` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Offers_Applications` (`ApplicationId`),
  KEY `FK_Offers_OfferResponses` (`OfferResponseId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `organisation_charts`
--

DROP TABLE IF EXISTS `organisation_charts`;
CREATE TABLE IF NOT EXISTS `organisation_charts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `diagram` longtext NOT NULL,
  `author` varchar(50) NOT NULL,
  `date_created` datetime(6) NOT NULL,
  `last_edit_by` varchar(50) DEFAULT NULL,
  `date_last_edit` datetime(6) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `parserexpressions`
--

DROP TABLE IF EXISTS `parserexpressions`;
CREATE TABLE IF NOT EXISTS `parserexpressions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ShamUserId` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `Text` varchar(2048) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `IX_ParserExpressions` (`Name`),
  KEY `FK_ParserExpressions_ShamUsers` (`ShamUserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `policies`
--

DROP TABLE IF EXISTS `policies`;
CREATE TABLE IF NOT EXISTS `policies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `policy_category_id` int(11) DEFAULT NULL,
  `expires_on` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Policies_PolicyCategories` (`policy_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `policy_categories`
--

DROP TABLE IF EXISTS `policy_categories`;
CREATE TABLE IF NOT EXISTS `policy_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `policy_documents`
--

DROP TABLE IF EXISTS `policy_documents`;
CREATE TABLE IF NOT EXISTS `policy_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `content` longtext,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_PolicyDocuments_Policies` (`policy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE IF NOT EXISTS `product_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(256) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_team`
--

DROP TABLE IF EXISTS `product_team`;
CREATE TABLE IF NOT EXISTS `product_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_TeamsProducts_Products` (`product_id`),
  KEY `FK_TeamsProducts_Teams` (`team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `publicholidays`
--

DROP TABLE IF EXISTS `publicholidays`;
CREATE TABLE IF NOT EXISTS `publicholidays` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Date` date NOT NULL,
  `Description` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `IX_PublicHolidays` (`Date`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `qaevaluationscoresview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `qaevaluationscoresview`;
CREATE TABLE IF NOT EXISTS `qaevaluationscoresview` (
`EvaluationId` int(11)
,`AssessmentId` int(11)
,`AssessorEmployeeId` int(11)
,`Feedbackdate` date
,`Points` decimal(32,0)
,`Percentage` decimal(11,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `qaevaluationsview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `qaevaluationsview`;
CREATE TABLE IF NOT EXISTS `qaevaluationsview` (
`assessment_id` int(11)
,`TotalPoints` decimal(32,0)
,`Feedbackdate` date
,`TotalThreshold` decimal(32,0)
,`description` varchar(256)
);

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

DROP TABLE IF EXISTS `qualifications`;
CREATE TABLE IF NOT EXISTS `qualifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `institution` varchar(50) DEFAULT NULL,
  `obtained_on` datetime DEFAULT NULL,
  `student_no` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Qualifications_Employees` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `recruitmentrequestreasons`
--

DROP TABLE IF EXISTS `recruitmentrequestreasons`;
CREATE TABLE IF NOT EXISTS `recruitmentrequestreasons` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `recruitmentrequests`
--

DROP TABLE IF EXISTS `recruitmentrequests`;
CREATE TABLE IF NOT EXISTS `recruitmentrequests` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `BranchId` int(11) DEFAULT NULL,
  `DivisionId` int(11) DEFAULT NULL,
  `DepartmentId` int(11) DEFAULT NULL,
  `Position` varchar(50) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `HiringManagerEmployeeId` int(11) DEFAULT NULL,
  `Classification` varchar(50) DEFAULT NULL,
  `SkillLevel` varchar(100) DEFAULT NULL,
  `TimeGroupId` int(11) DEFAULT NULL,
  `JobDescription` varchar(512) DEFAULT NULL,
  `ContractType` varchar(100) DEFAULT NULL,
  `MinSalary` decimal(19,4) DEFAULT NULL,
  `MaxSalary` decimal(19,4) DEFAULT NULL,
  `Deadline` datetime(6) DEFAULT NULL,
  `StartDate` datetime(6) DEFAULT NULL,
  `EndDate` datetime(6) DEFAULT NULL,
  `RecruitmentRequestReasonId` int(11) DEFAULT NULL,
  `RecruitmentRequestReasonText` varchar(128) DEFAULT NULL,
  `Justification` varchar(1024) DEFAULT NULL,
  `Probation` tinyint(1) NOT NULL DEFAULT '1',
  `BackgroundCheck` tinyint(1) NOT NULL DEFAULT '1',
  `DriversLicence` tinyint(1) NOT NULL DEFAULT '0',
  `QualificationRequirements` varchar(1024) DEFAULT NULL,
  `OtherRequirements` varchar(1024) DEFAULT NULL,
  `AdvertisingRequirements` varchar(1024) DEFAULT NULL,
  `RequestDate` datetime(6) DEFAULT NULL,
  `Approved` tinyint(1) DEFAULT NULL,
  `ApprovalDate` datetime(6) DEFAULT NULL,
  `ApprovedBy` varchar(100) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  KEY `FK_RecruitmentRequests_Branches` (`BranchId`),
  KEY `FK_RecruitmentRequests_Departments` (`DepartmentId`),
  KEY `FK_RecruitmentRequests_Divisions` (`DivisionId`),
  KEY `FK_RecruitmentRequests_Employees` (`HiringManagerEmployeeId`),
  KEY `FK_RecruitmentRequests_RecruitmentRequestReasons` (`RecruitmentRequestReasonId`),
  KEY `FK_RecruitmentRequests_TimeGroups` (`TimeGroupId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `recurrences`
--

DROP TABLE IF EXISTS `recurrences`;
CREATE TABLE IF NOT EXISTS `recurrences` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Days` int(11) NOT NULL DEFAULT '1',
  `Active` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `report_templates`
--

DROP TABLE IF EXISTS `report_templates`;
CREATE TABLE IF NOT EXISTS `report_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(200) NOT NULL,
  `system_module_id` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ReportTemplates_SystemModules` (`system_module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

DROP TABLE IF EXISTS `rewards`;
CREATE TABLE IF NOT EXISTS `rewards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `rewarded_by` varchar(100) NOT NULL,
  `date_received` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Rewards_Employees` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `WorkflowId` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `ShamUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Roles_ShamUsers` (`ShamUserId`),
  KEY `FK_Roles_Workflows` (`WorkflowId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shamsessions`
--

DROP TABLE IF EXISTS `shamsessions`;
CREATE TABLE IF NOT EXISTS `shamsessions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ShamUserId` int(11) NOT NULL,
  `Token` varchar(100) NOT NULL,
  `DateCreated` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_ShamSessions_ShamUsers` (`ShamUserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sham_permissions`
--

DROP TABLE IF EXISTS `sham_permissions`;
CREATE TABLE IF NOT EXISTS `sham_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `alias` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sham_permissions`
--

INSERT INTO `sham_permissions` (`id`, `name`, `description`, `is_active`, `alias`) VALUES
(1, 'getList', 'Permission to retrieve a listing on the main view and perform filtering search', 1, 'List'),
(2, 'get', 'Permission to retrieve one record in read mode', 1, 'Read'),
(3, 'modify', 'General permission to alter data on the concerned entify', 1, 'Write'),
(4, 'remove', 'General permission to delete or deactivate the relevant entity', 1, 'Delete'),
(5, 'add', 'General permission to add new records', 1, 'Create');

-- --------------------------------------------------------

--
-- Table structure for table `sham_permission_sham_user_profile_system_sub_module`
--

DROP TABLE IF EXISTS `sham_permission_sham_user_profile_system_sub_module`;
CREATE TABLE IF NOT EXISTS `sham_permission_sham_user_profile_system_sub_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sham_user_profile_id` int(11) NOT NULL,
  `sham_permission_id` int(11) NOT NULL,
  `system_sub_module_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ShamUserProfilesSubModulePermissions_ShamPermissions` (`sham_permission_id`),
  KEY `FK_ShamUserProfilesSubModulePermissions_ShamUserProfiles` (`sham_user_profile_id`),
  KEY `FK_ShamUserProfilesSubModulePermissions_SystemSubModules` (`system_sub_module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sham_permission_sham_user_profile_system_sub_module`
--

INSERT INTO `sham_permission_sham_user_profile_system_sub_module` (`id`, `sham_user_profile_id`, `sham_permission_id`, `system_sub_module_id`) VALUES
(391, 2, 1, 1),
(392, 2, 2, 1),
(393, 2, 3, 1),
(394, 2, 5, 1),
(395, 2, 1, 2),
(396, 2, 2, 2),
(397, 2, 3, 2),
(398, 2, 5, 2),
(399, 2, 1, 4),
(400, 2, 2, 4),
(401, 2, 3, 4),
(402, 2, 5, 4),
(403, 2, 1, 5),
(404, 2, 2, 5),
(405, 2, 3, 5),
(406, 2, 5, 5),
(407, 2, 1, 6),
(408, 2, 2, 6),
(409, 2, 3, 6),
(410, 2, 5, 6),
(411, 2, 1, 7),
(412, 2, 2, 7),
(413, 2, 3, 7),
(414, 2, 5, 7),
(415, 2, 1, 8),
(416, 2, 2, 8),
(417, 2, 3, 8),
(418, 2, 5, 8),
(419, 2, 1, 9),
(420, 2, 2, 9),
(421, 2, 3, 9),
(422, 2, 5, 9),
(423, 2, 1, 10),
(424, 2, 2, 10),
(425, 2, 3, 10),
(426, 2, 5, 10),
(427, 2, 1, 11),
(428, 2, 2, 11),
(429, 2, 3, 11),
(430, 2, 5, 11),
(431, 2, 1, 12),
(432, 2, 2, 12),
(433, 2, 3, 12),
(434, 2, 5, 12),
(435, 2, 1, 13),
(436, 2, 2, 13),
(437, 2, 3, 13),
(438, 2, 5, 13),
(439, 2, 1, 16),
(440, 2, 2, 16),
(441, 2, 3, 16),
(442, 2, 5, 16),
(443, 2, 1, 17),
(444, 2, 2, 17),
(445, 2, 3, 17),
(446, 2, 5, 17),
(447, 2, 1, 18),
(448, 2, 2, 18),
(449, 2, 3, 18),
(450, 2, 5, 18),
(451, 2, 1, 19),
(452, 2, 2, 19),
(453, 2, 3, 19),
(454, 2, 5, 19),
(455, 2, 1, 20),
(456, 2, 2, 20),
(457, 2, 3, 20),
(458, 2, 5, 20),
(459, 2, 1, 21),
(460, 2, 2, 21),
(461, 2, 3, 21),
(462, 2, 5, 21),
(463, 2, 1, 22),
(464, 2, 2, 22),
(465, 2, 3, 22),
(466, 2, 5, 22),
(467, 2, 1, 23),
(468, 2, 2, 23),
(469, 2, 3, 23),
(470, 2, 5, 23),
(495, 2, 1, 36),
(496, 2, 2, 36),
(497, 2, 3, 36),
(498, 2, 5, 36),
(499, 2, 1, 37),
(500, 2, 2, 37),
(501, 2, 3, 37),
(502, 2, 5, 37),
(503, 2, 1, 38),
(504, 2, 2, 38),
(505, 2, 3, 38),
(506, 2, 5, 38),
(507, 2, 1, 39),
(508, 2, 2, 39),
(509, 2, 3, 39),
(510, 2, 5, 39),
(511, 2, 1, 40),
(512, 2, 2, 40),
(513, 2, 3, 40),
(514, 2, 5, 40),
(515, 2, 1, 41),
(516, 2, 2, 41),
(517, 2, 3, 41),
(518, 2, 5, 41),
(519, 2, 1, 42),
(520, 2, 2, 42),
(521, 2, 3, 42),
(522, 2, 5, 42),
(523, 2, 1, 43),
(524, 2, 2, 43),
(525, 2, 3, 43),
(526, 2, 5, 43),
(527, 2, 1, 44),
(528, 2, 2, 44),
(529, 2, 3, 44),
(530, 2, 5, 44),
(531, 2, 1, 45),
(532, 2, 2, 45),
(533, 2, 3, 45),
(534, 2, 5, 45),
(535, 2, 1, 46),
(536, 2, 2, 46),
(537, 2, 3, 46),
(538, 2, 5, 46),
(539, 2, 1, 70),
(540, 2, 2, 70),
(541, 2, 3, 70),
(542, 2, 5, 70),
(543, 2, 1, 72),
(544, 2, 2, 72),
(545, 2, 3, 72),
(546, 2, 5, 72),
(547, 2, 1, 73),
(548, 2, 2, 73),
(549, 2, 3, 73),
(550, 2, 5, 73),
(551, 2, 1, 74),
(552, 2, 2, 74),
(553, 2, 3, 74),
(554, 2, 5, 74),
(555, 2, 1, 75),
(556, 2, 2, 75),
(557, 2, 3, 75),
(558, 2, 5, 75),
(559, 2, 1, 76),
(560, 2, 2, 76),
(561, 2, 3, 76),
(562, 2, 5, 76),
(563, 2, 1, 77),
(564, 2, 2, 77),
(565, 2, 3, 77),
(566, 2, 5, 77),
(567, 2, 1, 78),
(568, 2, 2, 78),
(569, 2, 3, 78),
(570, 2, 5, 78),
(571, 2, 1, 79),
(572, 2, 2, 79),
(573, 2, 3, 79),
(574, 2, 5, 79),
(575, 2, 1, 80),
(576, 2, 2, 80),
(577, 2, 3, 80),
(578, 2, 5, 80),
(579, 2, 1, 81),
(580, 2, 2, 81),
(581, 2, 3, 81),
(582, 2, 5, 81),
(583, 2, 1, 82),
(584, 2, 2, 82),
(585, 2, 3, 82),
(586, 2, 5, 82),
(587, 2, 1, 83),
(588, 2, 2, 83),
(589, 2, 3, 83),
(590, 2, 5, 83),
(591, 2, 1, 84),
(592, 2, 2, 84),
(593, 2, 3, 84),
(594, 2, 5, 84),
(595, 2, 1, 85),
(596, 2, 2, 85),
(597, 2, 3, 85),
(598, 2, 5, 85),
(599, 2, 1, 86),
(600, 2, 2, 86),
(601, 2, 3, 86),
(602, 2, 5, 86),
(603, 2, 1, 87),
(604, 2, 2, 87),
(605, 2, 3, 87),
(606, 2, 5, 87),
(607, 2, 1, 88),
(608, 2, 2, 88),
(609, 2, 3, 88),
(610, 2, 5, 88),
(611, 2, 1, 89),
(612, 2, 2, 89),
(613, 2, 3, 89),
(614, 2, 5, 89),
(615, 2, 1, 90),
(616, 2, 2, 90),
(617, 2, 3, 90),
(618, 2, 5, 90),
(619, 2, 1, 91),
(620, 2, 2, 91),
(621, 2, 3, 91),
(622, 2, 5, 91),
(623, 2, 1, 92),
(624, 2, 2, 92),
(625, 2, 3, 92),
(626, 2, 5, 92),
(627, 2, 1, 93),
(628, 2, 2, 93),
(629, 2, 3, 93),
(630, 2, 5, 93),
(631, 2, 1, 94),
(632, 2, 2, 94),
(633, 2, 3, 94),
(634, 2, 5, 94),
(635, 2, 1, 95),
(636, 2, 2, 95),
(637, 2, 3, 95),
(638, 2, 5, 95),
(639, 2, 1, 96),
(640, 2, 2, 96),
(641, 2, 3, 96),
(642, 2, 5, 96),
(643, 2, 1, 97),
(644, 2, 2, 97),
(645, 2, 3, 97),
(646, 2, 5, 97),
(647, 2, 1, 98),
(648, 2, 2, 98),
(649, 2, 3, 98),
(650, 2, 5, 98),
(651, 2, 1, 99),
(652, 2, 2, 99),
(653, 2, 3, 99),
(654, 2, 5, 99),
(655, 2, 1, 100),
(656, 2, 2, 100),
(657, 2, 3, 100),
(658, 2, 5, 100),
(659, 2, 1, 101),
(660, 2, 2, 101),
(661, 2, 3, 101),
(662, 2, 5, 101),
(663, 2, 1, 103),
(664, 2, 2, 103),
(665, 2, 3, 103),
(666, 2, 5, 103),
(667, 2, 1, 104),
(668, 2, 2, 104),
(669, 2, 3, 104),
(670, 2, 5, 104),
(671, 2, 1, 105),
(672, 2, 2, 105),
(673, 2, 3, 105),
(674, 2, 5, 105),
(675, 2, 1, 106),
(676, 2, 2, 106),
(677, 2, 3, 106),
(678, 2, 5, 106),
(679, 2, 1, 107),
(680, 2, 2, 107),
(681, 2, 3, 107),
(682, 2, 5, 107),
(683, 2, 1, 108),
(684, 2, 2, 108),
(685, 2, 3, 108),
(686, 2, 5, 108),
(687, 2, 1, 109),
(688, 2, 2, 109),
(689, 2, 3, 109),
(690, 2, 5, 109),
(691, 2, 1, 111),
(692, 2, 2, 111),
(693, 2, 3, 111),
(694, 2, 5, 111),
(695, 3, 1, 16),
(696, 3, 2, 16),
(697, 3, 3, 16),
(698, 3, 5, 16),
(699, 3, 1, 17),
(700, 3, 2, 17),
(701, 3, 3, 17),
(702, 3, 5, 17),
(711, 3, 1, 20),
(712, 3, 2, 20),
(713, 3, 3, 20),
(714, 3, 5, 20),
(715, 3, 1, 21),
(716, 3, 2, 21),
(717, 3, 3, 21),
(718, 3, 5, 21),
(730, 2, 1, 113),
(731, 2, 2, 113),
(732, 2, 3, 113),
(733, 2, 4, 113),
(734, 2, 5, 113),
(740, 2, 1, 115),
(741, 2, 2, 115),
(742, 2, 3, 115),
(743, 2, 4, 115),
(744, 2, 5, 115),
(760, 3, 1, 114),
(765, 4, 1, 30),
(766, 4, 2, 30),
(767, 4, 3, 30),
(768, 4, 4, 30),
(769, 4, 5, 30),
(770, 4, 1, 31),
(771, 4, 2, 31),
(772, 4, 3, 31),
(773, 4, 4, 31),
(774, 4, 5, 31),
(775, 4, 1, 32),
(776, 4, 2, 32),
(777, 4, 3, 32),
(778, 4, 4, 32),
(779, 4, 5, 32),
(780, 4, 1, 33),
(781, 4, 2, 33),
(782, 4, 3, 33),
(783, 4, 4, 33),
(784, 4, 5, 33),
(790, 4, 1, 114),
(795, 4, 1, 16),
(796, 4, 2, 16),
(797, 4, 3, 16),
(799, 4, 5, 16),
(800, 4, 1, 17),
(801, 4, 2, 17),
(802, 4, 3, 17),
(804, 4, 5, 17),
(805, 4, 1, 70),
(806, 4, 2, 70),
(807, 4, 3, 70),
(808, 4, 4, 70),
(809, 4, 5, 70),
(810, 5, 1, 16),
(811, 5, 2, 16),
(812, 5, 3, 16),
(813, 5, 4, 16),
(814, 5, 5, 16),
(815, 5, 1, 17),
(816, 5, 2, 17),
(817, 5, 3, 17),
(818, 5, 4, 17),
(819, 5, 5, 17),
(825, 5, 1, 114),
(830, 6, 1, 1),
(831, 6, 2, 1),
(832, 6, 3, 1),
(833, 6, 5, 1),
(838, 6, 1, 4),
(839, 6, 2, 4),
(840, 6, 3, 4),
(841, 6, 5, 4),
(842, 6, 1, 5),
(843, 6, 2, 5),
(844, 6, 3, 5),
(845, 6, 5, 5),
(846, 6, 1, 6),
(847, 6, 2, 6),
(848, 6, 3, 6),
(849, 6, 5, 6),
(850, 6, 1, 7),
(851, 6, 2, 7),
(852, 6, 3, 7),
(853, 6, 5, 7),
(854, 6, 1, 8),
(855, 6, 2, 8),
(856, 6, 3, 8),
(857, 6, 5, 8),
(858, 6, 1, 9),
(859, 6, 2, 9),
(860, 6, 3, 9),
(861, 6, 5, 9),
(862, 6, 1, 10),
(863, 6, 2, 10),
(864, 6, 3, 10),
(865, 6, 5, 10),
(866, 6, 1, 11),
(867, 6, 2, 11),
(868, 6, 3, 11),
(869, 6, 5, 11),
(878, 6, 1, 16),
(879, 6, 2, 16),
(880, 6, 3, 16),
(881, 6, 5, 16),
(882, 6, 1, 17),
(883, 6, 2, 17),
(884, 6, 3, 17),
(885, 6, 5, 17),
(894, 6, 1, 20),
(895, 6, 2, 20),
(896, 6, 3, 20),
(897, 6, 5, 20),
(898, 6, 1, 21),
(899, 6, 2, 21),
(900, 6, 3, 21),
(901, 6, 5, 21),
(930, 6, 1, 41),
(931, 6, 2, 41),
(932, 6, 3, 41),
(933, 6, 5, 41),
(934, 6, 1, 42),
(935, 6, 2, 42),
(936, 6, 3, 42),
(937, 6, 5, 42),
(938, 6, 1, 43),
(939, 6, 2, 43),
(940, 6, 3, 43),
(941, 6, 5, 43),
(946, 6, 1, 45),
(947, 6, 2, 45),
(948, 6, 3, 45),
(949, 6, 5, 45),
(954, 6, 1, 70),
(955, 6, 2, 70),
(956, 6, 3, 70),
(957, 6, 5, 70),
(958, 6, 1, 72),
(959, 6, 2, 72),
(960, 6, 3, 72),
(961, 6, 5, 72),
(966, 6, 1, 74),
(967, 6, 2, 74),
(968, 6, 3, 74),
(969, 6, 5, 74),
(970, 6, 1, 75),
(971, 6, 2, 75),
(972, 6, 3, 75),
(973, 6, 5, 75),
(974, 6, 1, 76),
(975, 6, 2, 76),
(976, 6, 3, 76),
(977, 6, 5, 76),
(978, 6, 1, 77),
(979, 6, 2, 77),
(980, 6, 3, 77),
(981, 6, 5, 77),
(982, 6, 1, 78),
(983, 6, 2, 78),
(984, 6, 3, 78),
(985, 6, 5, 78),
(986, 6, 1, 79),
(987, 6, 2, 79),
(988, 6, 3, 79),
(989, 6, 5, 79),
(990, 6, 1, 80),
(991, 6, 2, 80),
(992, 6, 3, 80),
(993, 6, 5, 80),
(994, 6, 1, 81),
(995, 6, 2, 81),
(996, 6, 3, 81),
(997, 6, 5, 81),
(998, 6, 1, 82),
(999, 6, 2, 82),
(1000, 6, 3, 82),
(1001, 6, 5, 82),
(1002, 6, 1, 83),
(1003, 6, 2, 83),
(1004, 6, 3, 83),
(1005, 6, 5, 83),
(1006, 6, 1, 84),
(1007, 6, 2, 84),
(1008, 6, 3, 84),
(1009, 6, 5, 84),
(1010, 6, 1, 85),
(1011, 6, 2, 85),
(1012, 6, 3, 85),
(1013, 6, 5, 85),
(1014, 6, 1, 86),
(1015, 6, 2, 86),
(1016, 6, 3, 86),
(1017, 6, 5, 86),
(1018, 6, 1, 87),
(1019, 6, 2, 87),
(1020, 6, 3, 87),
(1021, 6, 5, 87),
(1022, 6, 1, 88),
(1023, 6, 2, 88),
(1024, 6, 3, 88),
(1025, 6, 5, 88),
(1026, 6, 1, 89),
(1027, 6, 2, 89),
(1028, 6, 3, 89),
(1029, 6, 5, 89),
(1030, 6, 1, 90),
(1031, 6, 2, 90),
(1032, 6, 3, 90),
(1033, 6, 5, 90),
(1034, 6, 1, 91),
(1035, 6, 2, 91),
(1036, 6, 3, 91),
(1037, 6, 5, 91),
(1038, 6, 1, 92),
(1039, 6, 2, 92),
(1040, 6, 3, 92),
(1041, 6, 5, 92),
(1042, 6, 1, 93),
(1043, 6, 2, 93),
(1044, 6, 3, 93),
(1045, 6, 5, 93),
(1046, 6, 1, 94),
(1047, 6, 2, 94),
(1048, 6, 3, 94),
(1049, 6, 5, 94),
(1050, 6, 1, 95),
(1051, 6, 2, 95),
(1052, 6, 3, 95),
(1053, 6, 5, 95),
(1054, 6, 1, 96),
(1055, 6, 2, 96),
(1056, 6, 3, 96),
(1057, 6, 5, 96),
(1058, 6, 1, 97),
(1059, 6, 2, 97),
(1060, 6, 3, 97),
(1061, 6, 5, 97),
(1062, 6, 1, 98),
(1063, 6, 2, 98),
(1064, 6, 3, 98),
(1065, 6, 5, 98),
(1066, 6, 1, 99),
(1067, 6, 2, 99),
(1068, 6, 3, 99),
(1069, 6, 5, 99),
(1070, 6, 1, 100),
(1071, 6, 2, 100),
(1072, 6, 3, 100),
(1073, 6, 5, 100),
(1074, 6, 1, 101),
(1075, 6, 2, 101),
(1076, 6, 3, 101),
(1077, 6, 5, 101),
(1078, 6, 1, 103),
(1079, 6, 2, 103),
(1080, 6, 3, 103),
(1081, 6, 5, 103),
(1082, 6, 1, 104),
(1083, 6, 2, 104),
(1084, 6, 3, 104),
(1085, 6, 5, 104),
(1086, 6, 1, 105),
(1087, 6, 2, 105),
(1088, 6, 3, 105),
(1089, 6, 5, 105),
(1090, 6, 1, 106),
(1091, 6, 2, 106),
(1092, 6, 3, 106),
(1093, 6, 5, 106),
(1094, 6, 1, 107),
(1095, 6, 2, 107),
(1096, 6, 3, 107),
(1097, 6, 5, 107),
(1098, 6, 1, 108),
(1099, 6, 2, 108),
(1100, 6, 3, 108),
(1101, 6, 5, 108),
(1102, 6, 1, 109),
(1103, 6, 2, 109),
(1104, 6, 3, 109),
(1105, 6, 5, 109),
(1106, 6, 1, 111),
(1107, 6, 2, 111),
(1108, 6, 3, 111),
(1109, 6, 5, 111),
(1110, 6, 1, 113),
(1111, 6, 2, 113),
(1112, 6, 3, 113),
(1113, 6, 4, 113),
(1114, 6, 5, 113),
(1115, 6, 1, 115),
(1116, 6, 2, 115),
(1117, 6, 3, 115),
(1118, 6, 4, 115),
(1119, 6, 5, 115),
(1120, 6, 1, 102),
(1121, 6, 2, 102),
(1122, 6, 5, 102),
(1123, 6, 3, 102),
(1124, 6, 4, 1),
(1125, 4, 1, 21),
(1126, 4, 2, 21),
(1127, 4, 3, 21),
(1129, 4, 5, 21),
(1130, 5, 1, 21),
(1131, 5, 2, 21),
(1132, 5, 3, 21),
(1133, 5, 5, 21),
(1134, 5, 1, 1),
(1135, 5, 2, 1),
(1136, 5, 3, 1),
(1137, 5, 5, 1),
(1148, 2, 1, 120),
(1149, 2, 2, 120),
(1150, 2, 3, 120),
(1151, 2, 5, 120),
(1152, 6, 1, 118),
(1153, 6, 2, 118),
(1154, 6, 3, 118),
(1155, 6, 4, 118),
(1156, 6, 5, 118),
(1157, 6, 1, 120),
(1158, 6, 2, 120),
(1159, 6, 3, 120),
(1160, 6, 4, 120),
(1161, 6, 5, 120),
(1166, 6, 5, 30),
(1171, 6, 5, 31),
(1176, 6, 5, 32),
(1181, 6, 5, 33),
(1187, 6, 4, 111),
(1193, 2, 1, 71),
(1194, 2, 2, 71),
(1195, 2, 3, 71),
(1196, 2, 4, 71),
(1197, 2, 5, 71),
(1198, 4, 1, 71),
(1199, 4, 2, 71),
(1200, 4, 3, 71),
(1201, 4, 4, 71),
(1202, 4, 5, 71),
(1203, 6, 1, 71),
(1204, 6, 2, 71),
(1205, 6, 3, 71),
(1206, 6, 4, 71),
(1207, 6, 5, 71),
(1213, 6, 1, 127),
(1214, 6, 2, 127),
(1215, 6, 3, 127),
(1216, 6, 4, 127),
(1217, 6, 5, 127),
(1218, 2, 1, 127),
(1219, 2, 2, 127),
(1220, 2, 3, 127),
(1221, 2, 4, 127),
(1222, 2, 5, 127),
(1223, 7, 1, 1),
(1224, 7, 2, 1),
(1225, 7, 1, 4),
(1226, 7, 2, 4),
(1227, 7, 1, 5),
(1228, 7, 2, 5),
(1229, 7, 1, 6),
(1230, 7, 2, 6),
(1231, 7, 1, 7),
(1232, 7, 2, 7),
(1233, 7, 1, 8),
(1234, 7, 2, 8),
(1235, 7, 1, 9),
(1236, 7, 2, 9),
(1237, 7, 1, 16),
(1238, 7, 2, 16),
(1239, 7, 3, 16),
(1240, 7, 4, 16),
(1241, 7, 5, 16),
(1242, 7, 1, 17),
(1243, 7, 2, 17),
(1244, 7, 3, 17),
(1245, 7, 4, 17),
(1246, 7, 5, 17),
(1247, 7, 1, 20),
(1248, 7, 2, 20),
(1249, 7, 3, 20),
(1250, 7, 4, 20),
(1251, 7, 5, 20),
(1252, 7, 1, 21),
(1253, 7, 2, 21),
(1254, 7, 3, 21),
(1255, 7, 4, 21),
(1256, 7, 5, 21),
(1262, 7, 1, 111),
(1263, 7, 2, 111),
(1264, 7, 1, 114),
(1269, 5, 1, 30),
(1270, 5, 2, 30),
(1271, 5, 3, 30),
(1272, 8, 1, 1),
(1273, 8, 2, 1),
(1274, 8, 1, 4),
(1275, 8, 2, 4),
(1276, 8, 3, 4),
(1277, 8, 4, 4),
(1278, 8, 5, 4),
(1279, 8, 1, 5),
(1280, 8, 2, 5),
(1281, 8, 3, 5),
(1282, 8, 4, 5),
(1283, 8, 5, 5),
(1284, 8, 1, 41),
(1285, 8, 2, 41),
(1286, 8, 3, 41),
(1287, 8, 4, 41),
(1288, 8, 5, 41),
(1289, 8, 1, 42),
(1290, 8, 2, 42),
(1291, 8, 3, 42),
(1292, 8, 4, 42),
(1293, 8, 5, 42),
(1294, 8, 1, 43),
(1295, 8, 2, 43),
(1296, 8, 3, 43),
(1297, 8, 4, 43),
(1298, 8, 5, 43),
(1299, 8, 1, 45),
(1300, 8, 2, 45),
(1301, 8, 3, 45),
(1302, 8, 4, 45),
(1303, 8, 5, 45),
(1304, 8, 1, 120),
(1305, 8, 2, 120),
(1306, 8, 3, 120),
(1307, 8, 4, 120),
(1308, 8, 5, 120),
(1309, 8, 1, 95),
(1310, 8, 2, 95),
(1311, 8, 3, 95),
(1312, 8, 4, 95),
(1313, 8, 5, 95),
(1314, 8, 1, 113),
(1315, 8, 2, 113),
(1316, 8, 3, 113),
(1317, 8, 4, 113),
(1318, 8, 5, 113),
(1319, 9, 1, 1),
(1320, 9, 2, 1),
(1321, 9, 1, 16),
(1322, 9, 2, 16),
(1323, 9, 3, 16),
(1324, 9, 1, 17),
(1325, 9, 2, 17),
(1326, 9, 1, 20),
(1327, 9, 1, 21),
(1328, 9, 1, 30),
(1329, 9, 1, 8),
(1330, 9, 2, 8),
(1331, 9, 3, 8),
(1333, 7, 3, 8),
(1334, 7, 5, 8),
(1342, 10, 1, 1),
(1343, 10, 2, 1),
(1344, 10, 1, 6),
(1345, 10, 2, 6),
(1346, 10, 3, 6),
(1347, 10, 5, 6),
(1348, 10, 1, 75),
(1349, 10, 2, 75),
(1350, 10, 3, 75),
(1351, 10, 5, 75),
(1352, 2, 1, 35),
(1353, 2, 2, 35),
(1398, 4, 1, 20),
(1399, 4, 2, 20),
(1400, 4, 3, 20),
(1401, 4, 5, 20),
(1406, 9, 5, 16),
(1407, 9, 3, 17),
(1408, 9, 5, 17),
(1409, 9, 2, 20),
(1410, 9, 3, 20),
(1411, 9, 5, 20),
(1412, 9, 2, 21),
(1413, 9, 3, 21),
(1414, 9, 5, 21),
(1415, 9, 1, 70),
(1416, 9, 2, 70),
(1417, 9, 1, 71),
(1418, 9, 2, 71),
(1419, 9, 2, 30),
(1420, 9, 1, 31),
(1421, 9, 2, 31),
(1422, 9, 1, 32),
(1423, 9, 2, 32),
(1424, 9, 1, 33),
(1425, 9, 2, 33),
(1426, 9, 1, 35),
(1427, 9, 2, 35),
(1428, 9, 3, 35),
(1430, 9, 3, 30),
(1432, 9, 3, 31),
(1434, 9, 3, 32),
(1436, 9, 3, 33),
(1438, 9, 3, 70),
(1439, 9, 5, 70),
(1440, 9, 3, 71),
(1441, 9, 5, 71),
(1442, 3, 1, 11),
(1443, 3, 2, 11),
(1444, 6, 1, 35),
(1445, 6, 2, 35),
(1456, 3, 1, 121),
(1457, 3, 1, 123),
(1459, 3, 1, 126),
(1460, 3, 1, 4),
(1461, 3, 1, 5),
(1462, 3, 1, 10),
(1463, 3, 1, 110),
(1465, 3, 2, 123),
(1466, 3, 3, 123),
(1467, 3, 4, 123),
(1468, 3, 5, 123),
(1485, 6, 1, 114),
(1486, 6, 3, 114),
(1487, 6, 5, 114),
(1488, 6, 1, 121),
(1489, 6, 3, 121),
(1490, 6, 5, 121),
(1491, 6, 1, 123),
(1492, 6, 2, 123),
(1493, 6, 3, 123),
(1494, 6, 4, 123),
(1495, 6, 5, 123),
(1496, 6, 1, 126),
(1497, 6, 2, 126),
(1498, 6, 3, 126),
(1499, 6, 4, 126),
(1500, 6, 5, 126),
(1501, 3, 5, 121),
(1502, 3, 2, 126),
(1503, 3, 3, 126),
(1504, 3, 4, 126),
(1505, 3, 5, 126),
(1506, 3, 1, 127),
(1507, 3, 2, 127),
(1508, 3, 3, 127),
(1509, 3, 4, 127),
(1510, 3, 5, 127),
(1511, 3, 2, 4),
(1513, 3, 5, 114),
(1514, 3, 3, 121),
(1517, 3, 3, 114),
(1518, 3, 1, 112),
(1519, 3, 2, 112),
(1520, 3, 1, 124),
(1521, 3, 2, 124),
(1533, 11, 1, 1),
(1534, 11, 2, 1),
(1535, 11, 3, 1),
(1536, 11, 4, 1),
(1537, 11, 5, 1),
(1538, 11, 1, 5),
(1539, 11, 2, 5),
(1540, 11, 3, 5),
(1541, 11, 4, 5),
(1542, 11, 5, 5),
(1543, 11, 1, 6),
(1544, 11, 2, 6),
(1545, 11, 3, 6),
(1546, 11, 4, 6),
(1547, 11, 5, 6),
(1548, 11, 1, 7),
(1549, 11, 2, 7),
(1550, 11, 3, 7),
(1551, 11, 4, 7),
(1552, 11, 5, 7),
(1553, 11, 1, 8),
(1554, 11, 2, 8),
(1555, 11, 3, 8),
(1556, 11, 4, 8),
(1557, 11, 5, 8),
(1558, 11, 1, 9),
(1559, 11, 2, 9),
(1560, 11, 3, 9),
(1561, 11, 4, 9),
(1562, 11, 5, 9),
(1563, 11, 1, 10),
(1564, 11, 2, 10),
(1565, 11, 3, 10),
(1566, 11, 4, 10),
(1567, 11, 5, 10),
(1568, 11, 1, 11),
(1569, 11, 2, 11),
(1570, 11, 3, 11),
(1571, 11, 4, 11),
(1572, 11, 5, 11),
(1573, 11, 1, 14),
(1574, 11, 2, 14),
(1575, 11, 3, 14),
(1576, 11, 4, 14),
(1577, 11, 5, 14),
(1578, 11, 1, 15),
(1579, 11, 2, 15),
(1580, 11, 3, 15),
(1581, 11, 4, 15),
(1582, 11, 5, 15),
(1583, 11, 1, 16),
(1584, 11, 2, 16),
(1585, 11, 3, 16),
(1586, 11, 4, 16),
(1587, 11, 5, 16),
(1588, 11, 1, 17),
(1589, 11, 2, 17),
(1590, 11, 3, 17),
(1591, 11, 4, 17),
(1592, 11, 5, 17),
(1593, 11, 1, 18),
(1594, 11, 2, 18),
(1595, 11, 3, 18),
(1596, 11, 4, 18),
(1597, 11, 5, 18),
(1598, 11, 1, 19),
(1599, 11, 2, 19),
(1600, 11, 3, 19),
(1601, 11, 4, 19),
(1602, 11, 5, 19),
(1603, 11, 1, 20),
(1604, 11, 2, 20),
(1605, 11, 3, 20),
(1606, 11, 4, 20),
(1607, 11, 5, 20),
(1608, 11, 1, 21),
(1609, 11, 2, 21),
(1610, 11, 3, 21),
(1611, 11, 4, 21),
(1612, 11, 5, 21),
(1613, 11, 1, 22),
(1614, 11, 2, 22),
(1615, 11, 3, 22),
(1616, 11, 4, 22),
(1617, 11, 5, 22),
(1618, 11, 1, 23),
(1619, 11, 2, 23),
(1620, 11, 3, 23),
(1621, 11, 4, 23),
(1622, 11, 5, 23),
(1623, 11, 1, 24),
(1624, 11, 2, 24),
(1625, 11, 3, 24),
(1626, 11, 4, 24),
(1627, 11, 5, 24),
(1628, 11, 1, 26),
(1629, 11, 2, 26),
(1630, 11, 3, 26),
(1631, 11, 4, 26),
(1632, 11, 5, 26),
(1633, 11, 1, 27),
(1634, 11, 2, 27),
(1635, 11, 3, 27),
(1636, 11, 4, 27),
(1637, 11, 5, 27),
(1638, 11, 1, 30),
(1639, 11, 2, 30),
(1640, 11, 3, 30),
(1641, 11, 4, 30),
(1642, 11, 5, 30),
(1643, 11, 1, 31),
(1644, 11, 2, 31),
(1645, 11, 3, 31),
(1646, 11, 4, 31),
(1647, 11, 5, 31),
(1648, 11, 1, 32),
(1649, 11, 2, 32),
(1650, 11, 3, 32),
(1651, 11, 4, 32),
(1652, 11, 5, 32),
(1653, 11, 1, 33),
(1654, 11, 2, 33),
(1655, 11, 3, 33),
(1656, 11, 4, 33),
(1657, 11, 5, 33),
(1658, 11, 1, 34),
(1659, 11, 2, 34),
(1660, 11, 3, 34),
(1661, 11, 4, 34),
(1662, 11, 5, 34),
(1663, 11, 1, 36),
(1664, 11, 2, 36),
(1665, 11, 3, 36),
(1666, 11, 4, 36),
(1667, 11, 5, 36),
(1668, 11, 1, 41),
(1669, 11, 2, 41),
(1670, 11, 3, 41),
(1671, 11, 4, 41),
(1672, 11, 5, 41),
(1673, 11, 1, 42),
(1674, 11, 2, 42),
(1675, 11, 3, 42),
(1676, 11, 4, 42),
(1677, 11, 5, 42),
(1678, 11, 1, 43),
(1679, 11, 2, 43),
(1680, 11, 3, 43),
(1681, 11, 4, 43),
(1682, 11, 5, 43),
(1683, 11, 1, 45),
(1684, 11, 2, 45),
(1685, 11, 3, 45),
(1686, 11, 4, 45),
(1687, 11, 5, 45),
(1688, 11, 1, 55),
(1689, 11, 2, 55),
(1690, 11, 3, 55),
(1691, 11, 4, 55),
(1692, 11, 5, 55),
(1693, 11, 1, 59),
(1694, 11, 2, 59),
(1695, 11, 3, 59),
(1696, 11, 4, 59),
(1697, 11, 5, 59),
(1698, 11, 1, 60),
(1699, 11, 2, 60),
(1700, 11, 3, 60),
(1701, 11, 4, 60),
(1702, 11, 5, 60),
(1703, 11, 1, 64),
(1704, 11, 2, 64),
(1705, 11, 3, 64),
(1706, 11, 4, 64),
(1707, 11, 5, 64),
(1708, 11, 1, 70),
(1709, 11, 2, 70),
(1710, 11, 3, 70),
(1711, 11, 4, 70),
(1712, 11, 5, 70),
(1713, 11, 1, 71),
(1714, 11, 2, 71),
(1715, 11, 3, 71),
(1716, 11, 4, 71),
(1717, 11, 5, 71),
(1718, 11, 1, 73),
(1719, 11, 2, 73),
(1720, 11, 3, 73),
(1721, 11, 4, 73),
(1722, 11, 5, 73),
(1723, 11, 1, 74),
(1724, 11, 2, 74),
(1725, 11, 3, 74),
(1726, 11, 4, 74),
(1727, 11, 5, 74),
(1728, 11, 1, 75),
(1729, 11, 2, 75),
(1730, 11, 3, 75),
(1731, 11, 4, 75),
(1732, 11, 5, 75),
(1733, 11, 1, 77),
(1734, 11, 2, 77),
(1735, 11, 3, 77),
(1736, 11, 4, 77),
(1737, 11, 5, 77),
(1738, 11, 1, 78),
(1739, 11, 2, 78),
(1740, 11, 3, 78),
(1741, 11, 4, 78),
(1742, 11, 5, 78),
(1743, 11, 1, 79),
(1744, 11, 2, 79),
(1745, 11, 3, 79),
(1746, 11, 4, 79),
(1747, 11, 5, 79),
(1748, 11, 1, 80),
(1749, 11, 2, 80),
(1750, 11, 3, 80),
(1751, 11, 4, 80),
(1752, 11, 5, 80),
(1753, 11, 1, 82),
(1754, 11, 2, 82),
(1755, 11, 3, 82),
(1756, 11, 4, 82),
(1757, 11, 5, 82),
(1758, 11, 1, 83),
(1759, 11, 2, 83),
(1760, 11, 3, 83),
(1761, 11, 4, 83),
(1762, 11, 5, 83),
(1763, 11, 1, 84),
(1764, 11, 2, 84),
(1765, 11, 3, 84),
(1766, 11, 4, 84),
(1767, 11, 5, 84),
(1768, 11, 1, 85),
(1769, 11, 2, 85),
(1770, 11, 3, 85),
(1771, 11, 4, 85),
(1772, 11, 5, 85),
(1773, 11, 1, 86),
(1774, 11, 2, 86),
(1775, 11, 3, 86),
(1776, 11, 4, 86),
(1777, 11, 5, 86),
(1778, 11, 1, 87),
(1779, 11, 2, 87),
(1780, 11, 3, 87),
(1781, 11, 4, 87),
(1782, 11, 5, 87),
(1783, 11, 1, 88),
(1784, 11, 2, 88),
(1785, 11, 3, 88),
(1786, 11, 4, 88),
(1787, 11, 5, 88),
(1788, 11, 1, 89),
(1789, 11, 2, 89),
(1790, 11, 3, 89),
(1791, 11, 4, 89),
(1792, 11, 5, 89),
(1793, 11, 1, 90),
(1794, 11, 2, 90),
(1795, 11, 3, 90),
(1796, 11, 4, 90),
(1797, 11, 5, 90),
(1798, 11, 1, 92),
(1799, 11, 2, 92),
(1800, 11, 3, 92),
(1801, 11, 4, 92),
(1802, 11, 5, 92),
(1803, 11, 1, 93),
(1804, 11, 2, 93),
(1805, 11, 3, 93),
(1806, 11, 4, 93),
(1807, 11, 5, 93),
(1808, 11, 1, 94),
(1809, 11, 2, 94),
(1810, 11, 3, 94),
(1811, 11, 4, 94),
(1812, 11, 5, 94),
(1813, 11, 1, 96),
(1814, 11, 2, 96),
(1815, 11, 3, 96),
(1816, 11, 4, 96),
(1817, 11, 5, 96),
(1818, 11, 1, 98),
(1819, 11, 2, 98),
(1820, 11, 3, 98),
(1821, 11, 4, 98),
(1822, 11, 5, 98),
(1823, 11, 1, 101),
(1824, 11, 2, 101),
(1825, 11, 3, 101),
(1826, 11, 4, 101),
(1827, 11, 5, 101),
(1828, 11, 1, 102),
(1829, 11, 2, 102),
(1830, 11, 3, 102),
(1831, 11, 4, 102),
(1832, 11, 5, 102),
(1833, 11, 1, 103),
(1834, 11, 2, 103),
(1835, 11, 3, 103),
(1836, 11, 4, 103),
(1837, 11, 5, 103),
(1838, 11, 1, 104),
(1839, 11, 2, 104),
(1840, 11, 3, 104),
(1841, 11, 4, 104),
(1842, 11, 5, 104),
(1843, 11, 1, 105),
(1844, 11, 2, 105),
(1845, 11, 3, 105),
(1846, 11, 4, 105),
(1847, 11, 5, 105),
(1848, 11, 1, 106),
(1849, 11, 2, 106),
(1850, 11, 3, 106),
(1851, 11, 4, 106),
(1852, 11, 5, 106),
(1853, 11, 1, 111),
(1854, 11, 2, 111),
(1855, 11, 3, 111),
(1856, 11, 4, 111),
(1857, 11, 5, 111),
(1858, 11, 1, 114),
(1859, 11, 2, 114),
(1860, 11, 3, 114),
(1861, 11, 4, 114),
(1862, 11, 5, 114),
(1863, 11, 1, 115),
(1864, 11, 2, 115),
(1865, 11, 3, 115),
(1866, 11, 4, 115),
(1867, 11, 5, 115),
(1868, 11, 1, 118),
(1869, 11, 2, 118),
(1870, 11, 3, 118),
(1871, 11, 4, 118),
(1872, 11, 5, 118),
(1873, 11, 1, 119),
(1874, 11, 2, 119),
(1875, 11, 3, 119),
(1876, 11, 4, 119),
(1877, 11, 5, 119),
(1878, 11, 1, 120),
(1879, 11, 2, 120),
(1880, 11, 3, 120),
(1881, 11, 4, 120),
(1882, 11, 5, 120),
(1883, 11, 1, 127),
(1884, 11, 2, 127),
(1885, 11, 3, 127),
(1886, 11, 4, 127),
(1887, 11, 5, 127),
(1888, 11, 1, 128),
(1889, 11, 2, 128),
(1890, 11, 3, 128),
(1891, 11, 4, 128),
(1892, 11, 5, 128),
(13664, 1, 1, 1),
(13665, 1, 2, 1),
(13666, 1, 3, 1),
(13667, 1, 4, 1),
(13668, 1, 5, 1),
(13669, 1, 1, 4),
(13670, 1, 2, 4),
(13671, 1, 3, 4),
(13672, 1, 4, 4),
(13673, 1, 5, 4),
(13674, 1, 1, 5),
(13675, 1, 2, 5),
(13676, 1, 3, 5),
(13677, 1, 4, 5),
(13678, 1, 5, 5),
(13679, 1, 1, 6),
(13680, 1, 2, 6),
(13681, 1, 3, 6),
(13682, 1, 4, 6),
(13683, 1, 5, 6),
(13684, 1, 1, 7),
(13685, 1, 2, 7),
(13686, 1, 3, 7),
(13687, 1, 4, 7),
(13688, 1, 5, 7),
(13689, 1, 1, 8),
(13690, 1, 2, 8),
(13691, 1, 3, 8),
(13692, 1, 4, 8),
(13693, 1, 5, 8),
(13694, 1, 1, 9),
(13695, 1, 2, 9),
(13696, 1, 3, 9),
(13697, 1, 4, 9),
(13698, 1, 5, 9),
(13699, 1, 1, 10),
(13700, 1, 2, 10),
(13701, 1, 3, 10),
(13702, 1, 4, 10),
(13703, 1, 5, 10),
(13704, 1, 1, 11),
(13705, 1, 2, 11),
(13706, 1, 3, 11),
(13707, 1, 4, 11),
(13708, 1, 5, 11),
(13709, 1, 1, 15),
(13710, 1, 2, 15),
(13711, 1, 3, 15),
(13712, 1, 4, 15),
(13713, 1, 5, 15),
(13714, 1, 1, 16),
(13715, 1, 2, 16),
(13716, 1, 3, 16),
(13717, 1, 4, 16),
(13718, 1, 5, 16),
(13719, 1, 1, 17),
(13720, 1, 2, 17),
(13721, 1, 3, 17),
(13722, 1, 4, 17),
(13723, 1, 5, 17),
(13724, 1, 1, 20),
(13725, 1, 2, 20),
(13726, 1, 3, 20),
(13727, 1, 4, 20),
(13728, 1, 5, 20),
(13729, 1, 1, 21),
(13730, 1, 2, 21),
(13731, 1, 3, 21),
(13732, 1, 4, 21),
(13733, 1, 5, 21),
(13734, 1, 1, 30),
(13735, 1, 2, 30),
(13736, 1, 3, 30),
(13737, 1, 4, 30),
(13738, 1, 5, 30),
(13739, 1, 1, 31),
(13740, 1, 2, 31),
(13741, 1, 3, 31),
(13742, 1, 4, 31),
(13743, 1, 5, 31),
(13744, 1, 1, 32),
(13745, 1, 2, 32),
(13746, 1, 3, 32),
(13747, 1, 4, 32),
(13748, 1, 5, 32),
(13749, 1, 1, 33),
(13750, 1, 2, 33),
(13751, 1, 3, 33),
(13752, 1, 4, 33),
(13753, 1, 5, 33),
(13754, 1, 1, 41),
(13755, 1, 2, 41),
(13756, 1, 3, 41),
(13757, 1, 4, 41),
(13758, 1, 5, 41),
(13759, 1, 1, 42),
(13760, 1, 2, 42),
(13761, 1, 3, 42),
(13762, 1, 4, 42),
(13763, 1, 5, 42),
(13764, 1, 1, 43),
(13765, 1, 2, 43),
(13766, 1, 3, 43),
(13767, 1, 4, 43),
(13768, 1, 5, 43),
(13769, 1, 1, 45),
(13770, 1, 2, 45),
(13771, 1, 3, 45),
(13772, 1, 4, 45),
(13773, 1, 5, 45),
(13774, 1, 1, 52),
(13775, 1, 2, 52),
(13776, 1, 1, 70),
(13777, 1, 2, 70),
(13778, 1, 3, 70),
(13779, 1, 4, 70),
(13780, 1, 5, 70),
(13781, 1, 1, 71),
(13782, 1, 2, 71),
(13783, 1, 3, 71),
(13784, 1, 4, 71),
(13785, 1, 5, 71),
(13786, 1, 1, 72),
(13787, 1, 2, 72),
(13788, 1, 3, 72),
(13789, 1, 4, 72),
(13790, 1, 5, 72),
(13791, 1, 1, 74),
(13792, 1, 2, 74),
(13793, 1, 3, 74),
(13794, 1, 4, 74),
(13795, 1, 5, 74),
(13796, 1, 1, 75),
(13797, 1, 2, 75),
(13798, 1, 3, 75),
(13799, 1, 4, 75),
(13800, 1, 5, 75),
(13801, 1, 1, 76),
(13802, 1, 2, 76),
(13803, 1, 3, 76),
(13804, 1, 4, 76),
(13805, 1, 5, 76),
(13806, 1, 1, 77),
(13807, 1, 2, 77),
(13808, 1, 3, 77),
(13809, 1, 4, 77),
(13810, 1, 5, 77),
(13811, 1, 1, 78),
(13812, 1, 2, 78),
(13813, 1, 3, 78),
(13814, 1, 4, 78),
(13815, 1, 5, 78),
(13816, 1, 1, 79),
(13817, 1, 2, 79),
(13818, 1, 3, 79),
(13819, 1, 4, 79),
(13820, 1, 5, 79),
(13821, 1, 1, 80),
(13822, 1, 2, 80),
(13823, 1, 3, 80),
(13824, 1, 4, 80),
(13825, 1, 5, 80),
(13826, 1, 1, 81),
(13827, 1, 2, 81),
(13828, 1, 3, 81),
(13829, 1, 4, 81),
(13830, 1, 5, 81),
(13831, 1, 1, 82),
(13832, 1, 2, 82),
(13833, 1, 3, 82),
(13834, 1, 4, 82),
(13835, 1, 5, 82),
(13836, 1, 1, 83),
(13837, 1, 2, 83),
(13838, 1, 3, 83),
(13839, 1, 4, 83),
(13840, 1, 5, 83),
(13841, 1, 1, 84),
(13842, 1, 2, 84),
(13843, 1, 3, 84),
(13844, 1, 4, 84),
(13845, 1, 5, 84),
(13846, 1, 1, 85),
(13847, 1, 2, 85),
(13848, 1, 3, 85),
(13849, 1, 4, 85),
(13850, 1, 5, 85),
(13851, 1, 1, 86),
(13852, 1, 2, 86),
(13853, 1, 3, 86),
(13854, 1, 4, 86),
(13855, 1, 5, 86),
(13856, 1, 1, 87),
(13857, 1, 2, 87),
(13858, 1, 3, 87),
(13859, 1, 4, 87),
(13860, 1, 5, 87),
(13861, 1, 1, 88),
(13862, 1, 2, 88),
(13863, 1, 3, 88),
(13864, 1, 4, 88),
(13865, 1, 5, 88),
(13866, 1, 1, 89),
(13867, 1, 2, 89),
(13868, 1, 3, 89),
(13869, 1, 4, 89),
(13870, 1, 5, 89),
(13871, 1, 1, 90),
(13872, 1, 2, 90),
(13873, 1, 3, 90),
(13874, 1, 4, 90),
(13875, 1, 5, 90),
(13876, 1, 1, 91),
(13877, 1, 2, 91),
(13878, 1, 3, 91),
(13879, 1, 4, 91),
(13880, 1, 5, 91),
(13881, 1, 1, 92),
(13882, 1, 2, 92),
(13883, 1, 3, 92),
(13884, 1, 4, 92),
(13885, 1, 5, 92),
(13886, 1, 1, 93),
(13887, 1, 2, 93),
(13888, 1, 3, 93),
(13889, 1, 4, 93),
(13890, 1, 5, 93),
(13891, 1, 1, 94),
(13892, 1, 2, 94),
(13893, 1, 3, 94),
(13894, 1, 4, 94),
(13895, 1, 5, 94),
(13896, 1, 1, 95),
(13897, 1, 2, 95),
(13898, 1, 3, 95),
(13899, 1, 4, 95),
(13900, 1, 5, 95),
(13901, 1, 1, 96),
(13902, 1, 2, 96),
(13903, 1, 3, 96),
(13904, 1, 4, 96),
(13905, 1, 5, 96),
(13906, 1, 1, 97),
(13907, 1, 2, 97),
(13908, 1, 3, 97),
(13909, 1, 4, 97),
(13910, 1, 5, 97),
(13911, 1, 1, 98),
(13912, 1, 2, 98),
(13913, 1, 3, 98),
(13914, 1, 4, 98),
(13915, 1, 5, 98),
(13916, 1, 1, 99),
(13917, 1, 2, 99),
(13918, 1, 3, 99),
(13919, 1, 4, 99),
(13920, 1, 5, 99),
(13921, 1, 1, 100),
(13922, 1, 2, 100),
(13923, 1, 3, 100),
(13924, 1, 4, 100),
(13925, 1, 5, 100),
(13926, 1, 1, 101),
(13927, 1, 2, 101),
(13928, 1, 3, 101),
(13929, 1, 4, 101),
(13930, 1, 5, 101),
(13931, 1, 1, 102),
(13932, 1, 2, 102),
(13933, 1, 3, 102),
(13934, 1, 4, 102),
(13935, 1, 5, 102),
(13936, 1, 1, 103),
(13937, 1, 2, 103),
(13938, 1, 3, 103),
(13939, 1, 4, 103),
(13940, 1, 5, 103),
(13941, 1, 1, 104),
(13942, 1, 2, 104),
(13943, 1, 3, 104),
(13944, 1, 4, 104),
(13945, 1, 5, 104),
(13946, 1, 1, 105),
(13947, 1, 2, 105),
(13948, 1, 3, 105),
(13949, 1, 4, 105),
(13950, 1, 5, 105),
(13951, 1, 1, 106),
(13952, 1, 2, 106),
(13953, 1, 3, 106),
(13954, 1, 4, 106),
(13955, 1, 5, 106),
(13956, 1, 1, 107),
(13957, 1, 2, 107),
(13958, 1, 3, 107),
(13959, 1, 4, 107),
(13960, 1, 5, 107),
(13961, 1, 1, 108),
(13962, 1, 2, 108),
(13963, 1, 3, 108),
(13964, 1, 4, 108),
(13965, 1, 5, 108),
(13966, 1, 1, 109),
(13967, 1, 2, 109),
(13968, 1, 3, 109),
(13969, 1, 4, 109),
(13970, 1, 5, 109),
(13971, 1, 1, 110),
(13972, 1, 2, 110),
(13973, 1, 3, 110),
(13974, 1, 4, 110),
(13975, 1, 5, 110),
(13976, 1, 1, 111),
(13977, 1, 2, 111),
(13978, 1, 3, 111),
(13979, 1, 4, 111),
(13980, 1, 5, 111),
(13981, 1, 1, 112),
(13982, 1, 2, 112),
(13983, 1, 3, 112),
(13984, 1, 4, 112),
(13985, 1, 5, 112),
(13986, 1, 1, 113),
(13987, 1, 2, 113),
(13988, 1, 3, 113),
(13989, 1, 4, 113),
(13990, 1, 5, 113),
(13991, 1, 1, 114),
(13992, 1, 1, 115),
(13993, 1, 2, 115),
(13994, 1, 3, 115),
(13995, 1, 4, 115),
(13996, 1, 5, 115),
(13997, 1, 1, 116),
(13998, 1, 2, 116),
(13999, 1, 3, 116),
(14000, 1, 4, 116),
(14001, 1, 5, 116),
(14002, 1, 1, 118),
(14003, 1, 2, 118),
(14004, 1, 3, 118),
(14005, 1, 4, 118),
(14006, 1, 5, 118),
(14007, 1, 1, 120),
(14008, 1, 2, 120),
(14009, 1, 3, 120),
(14010, 1, 4, 120),
(14011, 1, 5, 120),
(14012, 1, 1, 121),
(14013, 1, 2, 121),
(14014, 1, 3, 121),
(14015, 1, 4, 121),
(14016, 1, 5, 121),
(14017, 1, 1, 122),
(14018, 1, 2, 122),
(14019, 1, 3, 122),
(14020, 1, 4, 122),
(14021, 1, 5, 122),
(14022, 1, 1, 123),
(14023, 1, 2, 123),
(14024, 1, 3, 123),
(14025, 1, 4, 123),
(14026, 1, 5, 123),
(14027, 1, 1, 124),
(14028, 1, 2, 124),
(14029, 1, 3, 124),
(14030, 1, 4, 124),
(14031, 1, 5, 124),
(14032, 1, 1, 125),
(14033, 1, 2, 125),
(14034, 1, 3, 125),
(14035, 1, 4, 125),
(14036, 1, 5, 125),
(14037, 1, 1, 126),
(14038, 1, 2, 126),
(14039, 1, 3, 126),
(14040, 1, 4, 126),
(14041, 1, 5, 126),
(14042, 1, 1, 127),
(14043, 1, 2, 127),
(14044, 1, 3, 127),
(14045, 1, 4, 127),
(14046, 1, 5, 127),
(14047, 1, 1, 128),
(14048, 1, 2, 128),
(14049, 1, 3, 128),
(14050, 1, 4, 128),
(14051, 1, 5, 128);

-- --------------------------------------------------------

--
-- Table structure for table `sham_users`
--

DROP TABLE IF EXISTS `sham_users`;
CREATE TABLE IF NOT EXISTS `sham_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `ShamUserProfileId` int(11) DEFAULT NULL,
  `email_address` varchar(512) DEFAULT NULL,
  `cell_number` varchar(20) DEFAULT NULL,
  `email_notify` tinyint(1) NOT NULL DEFAULT '1',
  `sms_notify` tinyint(1) NOT NULL DEFAULT '1',
  `push_notify` tinyint(1) NOT NULL DEFAULT '1',
  `silence_start` time(6) DEFAULT NULL,
  `silence_end` time(6) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IX_ShamUsers` (`username`),
  KEY `FK_ShamUsers_ShamUserProfiles` (`ShamUserProfileId`),
  KEY `FK_ShamUsers_Employees` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sham_user_profiles`
--

DROP TABLE IF EXISTS `sham_user_profiles`;
CREATE TABLE IF NOT EXISTS `sham_user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sham_user_profiles`
--

INSERT INTO `sham_user_profiles` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Administrator', 'Super User profile', 1, '2018-11-16 11:38:43', '2018-11-16 11:38:43', NULL),
(2, 'HR-User', 'Human resource personel profile', 1, '2018-11-16 11:38:43', '2018-11-16 11:38:43', NULL),
(3, 'Employee', 'Employee profile', 1, '2018-11-16 11:38:43', '2018-11-16 11:38:43', NULL),
(4, 'QA-Admin', 'QA-Admin', 1, '2018-11-16 11:38:43', '2018-11-16 11:38:43', NULL),
(5, 'QA-Teamlead', 'QA-Teamlead', 1, '2018-11-16 11:38:43', '2018-11-16 11:38:43', NULL),
(6, 'HR-AdminUser', 'HR-AdminUser', 1, '2018-11-16 11:38:43', '2018-11-16 11:38:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `Level` smallint(6) DEFAULT '1',
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suggestioncomments`
--

DROP TABLE IF EXISTS `suggestioncomments`;
CREATE TABLE IF NOT EXISTS `suggestioncomments` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `SuggestionId` int(11) NOT NULL,
  `Comment` varchar(512) NOT NULL,
  `Date` datetime(6) NOT NULL,
  `MadeByShamUserId` int(11) NOT NULL,
  `Approved` tinyint(1) NOT NULL DEFAULT '0',
  `ApprovedByShamUserId` int(11) DEFAULT NULL,
  `ApprovedDate` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_SuggestionComments_ShamUsers` (`MadeByShamUserId`),
  KEY `FK_SuggestionComments_ShamUsers1` (`ApprovedByShamUserId`),
  KEY `FK_SuggestionComments_Suggestions` (`SuggestionId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suggestions`
--

DROP TABLE IF EXISTS `suggestions`;
CREATE TABLE IF NOT EXISTS `suggestions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(50) NOT NULL,
  `Description` varchar(512) NOT NULL,
  `Private` tinyint(1) NOT NULL DEFAULT '0',
  `AuthorShamUserId` int(11) NOT NULL,
  `SuggestionStatusId` int(11) NOT NULL,
  `ReviewerShamUserId` int(11) DEFAULT NULL,
  `Date` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Suggestions_ShamUsers` (`AuthorShamUserId`),
  KEY `FK_Suggestions_ShamUsers1` (`ReviewerShamUserId`),
  KEY `FK_Suggestions_SuggestionStatuses` (`SuggestionStatusId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suggestionstatuses`
--

DROP TABLE IF EXISTS `suggestionstatuses`;
CREATE TABLE IF NOT EXISTS `suggestionstatuses` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

DROP TABLE IF EXISTS `surveys`;
CREATE TABLE IF NOT EXISTS `surveys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `notification_recurrence_id` int(11) DEFAULT NULL,
  `notification_group_id` int(11) DEFAULT NULL,
  `form_id` int(11) DEFAULT NULL,
  `final` tinyint(1) NOT NULL DEFAULT '0',
  `author_sham_user_id` int(11) NOT NULL,
  `survey_status_id` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Surveys_Forms` (`form_id`),
  KEY `FK_Surveys_NotificationGroups` (`notification_group_id`),
  KEY `FK_Surveys_NotificationRecurrences` (`notification_recurrence_id`),
  KEY `FK_Surveys_ShamUsers` (`author_sham_user_id`),
  KEY `FK_Surveys_SurveyStatuses` (`survey_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_responses`
--

DROP TABLE IF EXISTS `survey_responses`;
CREATE TABLE IF NOT EXISTS `survey_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sham_user_id` int(11) NOT NULL,
  `response` longtext NOT NULL,
  `date_occurred` datetime(6) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_SurveyResponses_ShamUsers` (`sham_user_id`),
  KEY `FK_SurveyResponses_Surveys` (`survey_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_statuses`
--

DROP TABLE IF EXISTS `survey_statuses`;
CREATE TABLE IF NOT EXISTS `survey_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `system_modules`
--

DROP TABLE IF EXISTS `system_modules`;
CREATE TABLE IF NOT EXISTS `system_modules` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `IX_SYSTEMMODULES_ACTIVE` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_modules`
--

INSERT INTO `system_modules` (`Id`, `description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Central HR', 1, '2018-11-16 11:39:04', '2018-11-16 11:39:04', NULL),
(2, 'Employee Portal', 1, '2018-11-16 11:39:04', '2018-11-16 11:39:04', NULL),
(3, 'Quality Assurance', 1, '2018-11-16 11:39:04', '2018-11-16 11:39:04', NULL),
(4, 'Recruitment', 0, '2018-11-16 11:39:04', '2018-11-16 11:39:04', '2018-11-29 11:11:38'),
(5, 'Training', 1, '2018-11-16 11:39:04', '2018-11-16 11:39:04', NULL),
(6, 'Time & attendance', 0, '2018-11-16 11:39:04', '2018-11-16 11:39:04', '2018-11-29 11:11:38'),
(7, 'Salary & benefits', 0, '2018-11-16 11:39:04', '2018-11-16 11:39:04', '2018-11-29 11:11:38'),
(8, 'Performance', 0, '2018-11-16 11:39:04', '2018-11-16 11:39:04', NULL),
(9, 'Talent & Succession', 0, '2018-11-16 11:39:04', '2018-11-16 11:39:04', '2018-11-29 11:11:38'),
(10, 'Productivity Management', 0, '2018-11-16 11:39:04', '2018-11-16 11:39:04', '2018-11-29 11:11:38'),
(11, 'Dashboard', 1, '2018-11-16 11:39:04', '2018-11-16 11:39:04', NULL),
(12, 'Configuration Parameters', 1, '2018-11-16 11:39:04', '2018-11-16 11:39:04', NULL),
(13, 'Todo list', 0, '2018-11-16 11:39:04', '2018-11-16 11:39:04', '2018-11-29 11:11:38');

-- --------------------------------------------------------

--
-- Table structure for table `system_sub_modules`
--

DROP TABLE IF EXISTS `system_sub_modules`;
CREATE TABLE IF NOT EXISTS `system_sub_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `system_module_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_SystemSubModules_SystemModules` (`system_module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_sub_modules`
--

INSERT INTO `system_sub_modules` (`id`, `description`, `system_module_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Employees', 1, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(2, 'Workflows', 1, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(3, 'Custom reports', 1, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(4, 'Notifications', 1, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(5, 'Announcements', 1, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(6, 'Assets Allocation', 1, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(7, 'Organisation structure', 1, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(8, 'Lifecycle management', 1, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(9, 'Suggestions', 1, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(10, 'Surveys', 1, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(11, 'Compliance', 1, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(12, 'Travel management', 1, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(13, 'Temporary jobs', 1, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(14, 'Company documents', 1, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(15, 'Calendar events', 1, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(16, 'My Portal', 2, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(17, 'My Details', 2, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(18, 'My travel requests', 2, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(19, 'My suggestions', 2, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(20, 'My Courses', 2, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(21, 'My Surveys', 2, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(22, 'My disciplinary records', 2, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(23, 'Vacancies', 2, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(24, 'My assessments', 2, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(25, 'My Claims', 2, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(26, 'My Leaves', 2, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(27, 'My Timesheet', 2, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(28, 'My Appraisal', 2, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(29, 'Newsletter', 2, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(30, 'Assessments', 3, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(31, 'Assessment Categories', 3, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(32, 'Category Questions', 3, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(33, 'Evaluations', 3, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(34, 'Assess', 3, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(35, 'Reports', 3, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(36, 'Recruitment requests', 4, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(37, 'Vacancies/offers', 4, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(38, 'Applicant tracking', 4, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(39, 'On-boarding', 4, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(40, 'Reports', 4, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(41, 'Courses', 5, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(42, 'Modules', 5, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(43, 'Module Assessment', 5, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(44, 'Training Venue Management', 5, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(45, 'Training Session Management', 5, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(46, 'Training Reports', 5, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(47, 'Policies & rules', 6, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(48, 'Vacation/leave tracking', 6, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(49, 'Global absence calendar', 6, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(50, 'Attendance management', 6, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(51, 'Accruals & balances/Absence plans', 6, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(52, 'Time-sheets', 6, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(53, 'Time Attendance Reports', 6, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(54, 'Payroll management', 7, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(55, 'Performance appraisal', 7, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(56, 'Analyse budget', 7, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(57, 'Benefits management', 7, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(58, 'Compensation management', 7, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(59, '360-degrees feedback', 8, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(60, 'Questions', 8, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(61, 'Performance Workflow', 8, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(62, 'Goals', 8, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(63, 'Performance analysis', 8, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(64, 'Warnings', 8, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(65, 'Identify Talents', 9, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(66, 'Career development planning', 9, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(67, 'Talent pools', 9, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(68, 'Succession planing', 9, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(69, 'KPI imports', 10, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(70, 'Dashboard ', 11, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(71, 'Reports', 11, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(72, 'Advance Methods', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(73, 'Announcement Status', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(74, 'Assessment Type', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(75, 'Asset Condition', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(76, 'Bank Account Type', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(77, 'Branch', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(78, 'Category Question Type', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(79, 'Company', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(80, 'Country', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(81, 'Currency', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(82, 'Department', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(83, 'Division', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(84, 'Document Category', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(85, 'Document Type', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(86, 'Employee Status', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(87, 'Employment Status', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(88, 'Ethnic Group', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(89, 'Gender', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(90, 'Immigration Status', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(91, 'Import', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(92, 'Job Title', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(93, 'Language', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(94, 'Law Category', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(95, 'Learning Material Type', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(96, 'Marital Status', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(97, 'Notification Groups', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(98, 'Policy Category', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(99, 'Recruitment Request Reasons', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(100, 'Recurrence', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(101, 'Skills', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(102, 'System Configuration', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(103, 'Tax Status', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(104, 'Team', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(105, 'Time Group', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(106, 'Title', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(107, 'Training Delivery Method', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(108, 'Travel Expense Claim Statuses', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(109, 'Travel Request Statuses', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(110, 'Triggers (events)', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(111, 'Violation', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(112, 'Calendar events', 1, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(113, 'Employee Attachment Types', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(114, 'Instances', 3, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(115, 'Product Categories', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(116, 'Public Holidays', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(117, 'LeaveTypes', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(118, 'Products', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(119, 'Report Templates', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(120, 'Topics', 5, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(121, 'Todo List Instances', 13, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(122, 'My documents', 2, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(123, 'My To-Do List', 2, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(124, 'Events', 13, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(125, 'Link Types', 12, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(126, 'Todo Items', 13, 0, '2018-11-16 11:39:40', '2018-11-16 11:39:40', '2018-11-29 11:11:38'),
(127, 'Time Period', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(128, 'Disciplinary Decision', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(129, 'Disabilities', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL),
(130, 'Disability Category', 12, 1, '2018-11-16 11:39:40', '2018-11-16 11:39:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sys_config_values`
--

DROP TABLE IF EXISTS `sys_config_values`;
CREATE TABLE IF NOT EXISTS `sys_config_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL,
  `value` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_SYS_CONFIG_VALUES_KEY` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `taskcategories`
--

DROP TABLE IF EXISTS `taskcategories`;
CREATE TABLE IF NOT EXISTS `taskcategories` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `duration` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `system_task` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Tasks_Departments` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tax_statuses`
--

DROP TABLE IF EXISTS `tax_statuses`;
CREATE TABLE IF NOT EXISTS `tax_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `time_group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Teams_TimeGroups` (`time_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `telephone_numbers`
--

DROP TABLE IF EXISTS `telephone_numbers`;
CREATE TABLE IF NOT EXISTS `telephone_numbers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `tel_number` varchar(20) NOT NULL,
  `telephone_number_type_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_TelephoneNumbers_Employees` (`employee_id`),
  KEY `FK_TelephoneNumbers_TelephoneNumberTypes` (`telephone_number_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `telephone_number_types`
--

DROP TABLE IF EXISTS `telephone_number_types`;
CREATE TABLE IF NOT EXISTS `telephone_number_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_system_predefined` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_TELEPHONE_NUMBER_TYPES_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temporaryjobs`
--

DROP TABLE IF EXISTS `temporaryjobs`;
CREATE TABLE IF NOT EXISTS `temporaryjobs` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `JobTitleId` int(11) NOT NULL,
  `JobDescription` longtext NOT NULL,
  `StartDate` datetime(6) NOT NULL,
  `EndDate` datetime(6) NOT NULL,
  `RatePerHour` decimal(19,4) NOT NULL,
  `EmployeeStatusId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_TemporaryJobs_EmployeeStatuses` (`EmployeeStatusId`),
  KEY `FK_TemporaryJobs_JobTitles` (`JobTitleId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `thread_statuses`
--

DROP TABLE IF EXISTS `thread_statuses`;
CREATE TABLE IF NOT EXISTS `thread_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(300) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `created_by` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_THREAD_STATUSES_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `timelines`
--

DROP TABLE IF EXISTS `timelines`;
CREATE TABLE IF NOT EXISTS `timelines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `timeline_event_type_id` int(11) NOT NULL,
  `event_id` char(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `event_date` date NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Timelines_Employees` (`employee_id`),
  KEY `FK_Timelines_TimelineEventTypes` (`timeline_event_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `timeline_event_types`
--

DROP TABLE IF EXISTS `timeline_event_types`;
CREATE TABLE IF NOT EXISTS `timeline_event_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `time_groups`
--

DROP TABLE IF EXISTS `time_groups`;
CREATE TABLE IF NOT EXISTS `time_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `start` time DEFAULT NULL,
  `end` time DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `time_periods`
--

DROP TABLE IF EXISTS `time_periods`;
CREATE TABLE IF NOT EXISTS `time_periods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `time_period_type` enum('1','2') NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

DROP TABLE IF EXISTS `titles`;
CREATE TABLE IF NOT EXISTS `titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_IS_SYSTEM_PREDEFINED` (`is_system_predefined`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(300) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `data` longtext,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_id_is_active` (`id`,`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `topic_attachments`
--

DROP TABLE IF EXISTS `topic_attachments`;
CREATE TABLE IF NOT EXISTS `topic_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `learning_material_type_id` int(11) NOT NULL,
  `content` longtext,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `comment` varchar(100) DEFAULT NULL,
  `original_file_name` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_TopicAttachments_LearningMaterialTypes` (`learning_material_type_id`),
  KEY `FK_TopicAttachments_Topics` (`topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trainingvenuebookings`
--

DROP TABLE IF EXISTS `trainingvenuebookings`;
CREATE TABLE IF NOT EXISTS `trainingvenuebookings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TrainingSessionId` int(11) NOT NULL,
  `TrainingVenueId` int(11) NOT NULL,
  `From` datetime(6) NOT NULL,
  `To` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_TrainingVenueBookings_TrainingSessions` (`TrainingSessionId`),
  KEY `FK_TrainingVenueBookings_TrainingVenues` (`TrainingVenueId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trainingvenues`
--

DROP TABLE IF EXISTS `trainingvenues`;
CREATE TABLE IF NOT EXISTS `trainingvenues` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `RoomNumber` varchar(10) NOT NULL,
  `Floor` int(11) NOT NULL,
  `BuildingId` int(11) NOT NULL,
  `Capacity` int(11) NOT NULL,
  `AvailableFrom` datetime(6) NOT NULL,
  `AvaiableTo` datetime(6) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  KEY `FK_TrainingVenues_Buildings` (`BuildingId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_delivery_methods`
--

DROP TABLE IF EXISTS `training_delivery_methods`;
CREATE TABLE IF NOT EXISTS `training_delivery_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_system_predefined` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_sessions`
--

DROP TABLE IF EXISTS `training_sessions`;
CREATE TABLE IF NOT EXISTS `training_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `course_id` int(11) NOT NULL,
  `training_delivery_method_id` int(11) DEFAULT NULL,
  `is_final` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_TrainingSessions_Courses1` (`course_id`),
  KEY `FK_TrainingSessions_TrainingDeliveryMethods` (`training_delivery_method_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `travelexpenseclaims`
--

DROP TABLE IF EXISTS `travelexpenseclaims`;
CREATE TABLE IF NOT EXISTS `travelexpenseclaims` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TravelRequestId` int(11) NOT NULL,
  `CountryId` int(11) NOT NULL,
  `CustomerId` int(11) DEFAULT NULL,
  `TravelRequestAttachmentId` int(11) DEFAULT NULL,
  `Date` datetime(6) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `Amount` decimal(19,4) NOT NULL,
  `CurrencieId` int(11) NOT NULL,
  `TravelExpenseClaimStatusId` int(11) NOT NULL,
  `ReviewerEmployeeId` int(11) DEFAULT NULL,
  `ReviewerComments` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_TravelExpenseClaims_Countries` (`CountryId`),
  KEY `FK_TravelExpenseClaims_Currencies` (`CurrencieId`),
  KEY `FK_TravelExpenseClaims_Customers` (`CustomerId`),
  KEY `FK_TravelExpenseClaims_Employees` (`ReviewerEmployeeId`),
  KEY `FK_TravelExpenseClaims_TravelExpenseClaimStatuses` (`TravelExpenseClaimStatusId`),
  KEY `FK_TravelExpenseClaims_TravelRequestAttachments` (`TravelRequestAttachmentId`),
  KEY `FK_TravelExpenseClaims_TravelRequests` (`TravelRequestId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `travelexpenseclaimstatuses`
--

DROP TABLE IF EXISTS `travelexpenseclaimstatuses`;
CREATE TABLE IF NOT EXISTS `travelexpenseclaimstatuses` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Active` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `travelrequestattachments`
--

DROP TABLE IF EXISTS `travelrequestattachments`;
CREATE TABLE IF NOT EXISTS `travelrequestattachments` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TravelRequestId` int(11) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `OriginalFileName` varchar(1024) NOT NULL,
  `Content` longtext NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_TravelRequestAttachments_TravelRequests` (`TravelRequestId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `travelrequests`
--

DROP TABLE IF EXISTS `travelrequests`;
CREATE TABLE IF NOT EXISTS `travelrequests` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `DestinationCountries` varchar(100) DEFAULT NULL,
  `Customers` varchar(100) DEFAULT NULL,
  `StartDate` datetime(6) NOT NULL,
  `EndDate` datetime(6) NOT NULL,
  `Motivation` varchar(256) DEFAULT NULL,
  `PlannedActivities` varchar(256) DEFAULT NULL,
  `TransportationBudget` decimal(19,4) DEFAULT NULL,
  `TransportationCurrencyId` int(11) DEFAULT NULL,
  `TransportationRequestAdvance` tinyint(1) DEFAULT NULL,
  `AccomodationBudget` decimal(19,4) DEFAULT NULL,
  `AccomodationCurrencyId` int(11) DEFAULT NULL,
  `AccomodationRequestAdvance` tinyint(1) DEFAULT NULL,
  `PerDiemBudget` decimal(19,4) DEFAULT NULL,
  `PerDiemCurrencyId` int(11) DEFAULT NULL,
  `PerDiemRequestAdvance` tinyint(1) DEFAULT NULL,
  `OtherFeesBudget` decimal(19,4) DEFAULT NULL,
  `OtherFeesCurrencyId` int(11) DEFAULT NULL,
  `OtherFeesRequestAdvance` tinyint(1) DEFAULT NULL,
  `OtherFeesDescription` varchar(100) DEFAULT NULL,
  `PreferredAdvanceMethodId` int(11) DEFAULT NULL,
  `EmergencyContact` varchar(100) DEFAULT NULL,
  `EmergencyContactNumber` varchar(20) DEFAULT NULL,
  `RequestedByEmployeeId` int(11) NOT NULL,
  `RequestDate` datetime(6) NOT NULL,
  `TravelRequestStatusId` int(11) NOT NULL,
  `ReviewedByEmployeeId` int(11) DEFAULT NULL,
  `ReviewDate` datetime(6) DEFAULT NULL,
  `ReviewComment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_TravelRequests_AdvanceMethods` (`PreferredAdvanceMethodId`),
  KEY `FK_TravelRequests_Currencies` (`TransportationCurrencyId`),
  KEY `FK_TravelRequests_Currencies1` (`AccomodationCurrencyId`),
  KEY `FK_TravelRequests_Currencies2` (`PerDiemCurrencyId`),
  KEY `FK_TravelRequests_Currencies3` (`OtherFeesCurrencyId`),
  KEY `FK_TravelRequests_Employees` (`RequestedByEmployeeId`),
  KEY `FK_TravelRequests_Employees1` (`ReviewedByEmployeeId`),
  KEY `FK_TravelRequests_TravelRequestStatuses` (`TravelRequestStatusId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `travelrequeststatuses`
--

DROP TABLE IF EXISTS `travelrequeststatuses`;
CREATE TABLE IF NOT EXISTS `travelrequeststatuses` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `triggers`
--

DROP TABLE IF EXISTS `triggers`;
CREATE TABLE IF NOT EXISTS `triggers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `EntityName` varchar(50) DEFAULT NULL,
  `PropertyName` varchar(100) DEFAULT NULL,
  `ParserExpressionId` int(11) DEFAULT NULL,
  `PropertyClrType` varchar(100) DEFAULT NULL,
  `PropertySqlType` varchar(100) DEFAULT NULL,
  `TriggerTypeId` int(11) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Triggers_ParserExpressions` (`ParserExpressionId`),
  KEY `FK_Triggers_TriggerTypes` (`TriggerTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `triggertypes`
--

DROP TABLE IF EXISTS `triggertypes`;
CREATE TABLE IF NOT EXISTS `triggertypes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(512) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `sham_user_profile_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
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
  KEY `IX_users_deleted_at` (`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `username`, `sham_user_profile_id`, `employee_id`, `created_at`, `updated_at`, `deleted_at`, `cell_number`, `email_notify`, `sms_notify`, `push_notify`, `silence_start`, `silence_end`, `is_active`, `remember_token`) VALUES
(1, 'demouser@smartz.com', '$2y$10$5D0jUor6KXRMSCbQm6kDPuwLx9Dp7qjKvYSOoVqC5Hu1373xoAmGK', 'demo user', 1, 20, '2018-11-16 07:43:50', '2018-11-16 06:01:16', NULL, NULL, 1, 1, 1, NULL, NULL, 1, 'xuc4DFDpGQByc20ASkrPqVVBXcBH4MdIsIhVSZ4OFPZxrjCtKi6xnxJbga2z');

-- --------------------------------------------------------

--
-- Table structure for table `vacancies`
--

DROP TABLE IF EXISTS `vacancies`;
CREATE TABLE IF NOT EXISTS `vacancies` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `RecruitmentRequestId` int(11) NOT NULL,
  `CompanyId` int(11) DEFAULT NULL,
  `DivisionId` int(11) DEFAULT NULL,
  `BranchId` int(11) DEFAULT NULL,
  `DepartmentId` int(11) DEFAULT NULL,
  `Position` varchar(100) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `PositionDescription` longtext,
  `Salary` decimal(19,4) DEFAULT NULL,
  `IssueDate` datetime(6) DEFAULT NULL,
  `ClosingDate` datetime(6) DEFAULT NULL,
  `StartDate` datetime(6) DEFAULT NULL,
  `EndDate` datetime(6) DEFAULT NULL,
  `Probationary` tinyint(1) DEFAULT NULL,
  `BackgroundCheck` tinyint(1) DEFAULT NULL,
  `DriversLicence` tinyint(1) DEFAULT NULL,
  `CertificateRequirement` varchar(1024) DEFAULT NULL,
  `OtherRequirements` varchar(1024) DEFAULT NULL,
  `AdvertisingRequirements` varchar(1024) DEFAULT NULL,
  `Open` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Vacancies_Branches` (`BranchId`),
  KEY `FK_Vacancies_Companies` (`CompanyId`),
  KEY `FK_Vacancies_Departments` (`DepartmentId`),
  KEY `FK_Vacancies_Divisions` (`DivisionId`),
  KEY `FK_Vacancies_RecruitmentRequests` (`RecruitmentRequestId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `viewedcomments`
--

DROP TABLE IF EXISTS `viewedcomments`;
CREATE TABLE IF NOT EXISTS `viewedcomments` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CommentDetailId` int(11) NOT NULL,
  `EmployeeId` int(11) NOT NULL,
  `Read` tinyint(1) NOT NULL DEFAULT '0',
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  KEY `FK_ViewedComments_CommentDetails` (`CommentDetailId`),
  KEY `FK_ViewedComments_Employees` (`EmployeeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

DROP TABLE IF EXISTS `violations`;
CREATE TABLE IF NOT EXISTS `violations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `workflowinstanceroles`
--

DROP TABLE IF EXISTS `workflowinstanceroles`;
CREATE TABLE IF NOT EXISTS `workflowinstanceroles` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `WorkflowInstanceId` int(11) NOT NULL,
  `ShamUserId` int(11) DEFAULT NULL,
  `RoleId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_WorkflowInstanceRoles_Roles` (`RoleId`),
  KEY `FK_WorkflowInstanceRoles_ShamUsers` (`ShamUserId`),
  KEY `FK_WorkflowInstanceRoles_WorkflowInstances` (`WorkflowInstanceId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `workflowinstances`
--

DROP TABLE IF EXISTS `workflowinstances`;
CREATE TABLE IF NOT EXISTS `workflowinstances` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Entity` varchar(50) DEFAULT NULL,
  `EntityId` int(11) DEFAULT NULL,
  `TargetEndDate` datetime(6) DEFAULT NULL,
  `ReminderSent` tinyint(1) DEFAULT NULL,
  `StartDate` datetime(6) DEFAULT NULL,
  `EndDate` datetime(6) DEFAULT NULL,
  `Completed` tinyint(1) NOT NULL DEFAULT '0',
  `PercentageCompleted` tinyint(3) UNSIGNED DEFAULT NULL,
  `Diagram` longtext,
  `WorkflowId` int(11) NOT NULL,
  `CurrentWorkflowInstanceStepId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_WorkflowInstances_WorkflowInstanceSteps` (`CurrentWorkflowInstanceStepId`),
  KEY `FK_WorkflowInstances_Workflows` (`WorkflowId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `workflowinstancesteps`
--

DROP TABLE IF EXISTS `workflowinstancesteps`;
CREATE TABLE IF NOT EXISTS `workflowinstancesteps` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `WorkflowStepTypeId` int(11) NOT NULL,
  `WorkflowInstanceId` int(11) NOT NULL,
  `WorkflowStepId` int(11) NOT NULL,
  `TargetEndDate` datetime(6) DEFAULT NULL,
  `StartDate` datetime(6) NOT NULL,
  `EndDate` datetime(6) DEFAULT NULL,
  `ReminderSent` tinyint(1) NOT NULL DEFAULT '0',
  `Completed` tinyint(1) NOT NULL DEFAULT '0',
  `Result` varchar(100) DEFAULT NULL,
  `WorkflowStepStateId` int(11) NOT NULL,
  `Param1` varchar(50) DEFAULT NULL,
  `Param2` varchar(50) DEFAULT NULL,
  `Param3` varchar(50) DEFAULT NULL,
  `Param4` varchar(50) DEFAULT NULL,
  `Param5` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_WorkflowInstanceSteps_WorkflowInstances` (`WorkflowInstanceId`),
  KEY `FK_WorkflowInstanceSteps_WorkflowSteps` (`WorkflowStepId`),
  KEY `FK_WorkflowInstanceSteps_WorkflowStepStates` (`WorkflowStepStateId`),
  KEY `FK_WorkflowInstanceSteps_WorkflowStepTypes` (`WorkflowStepTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `workflowinstancetransitions`
--

DROP TABLE IF EXISTS `workflowinstancetransitions`;
CREATE TABLE IF NOT EXISTS `workflowinstancetransitions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `Value` varchar(100) NOT NULL,
  `SourceWorkflowInstanceStepId` int(11) NOT NULL,
  `TargetWorkflowInstanceStepId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_WorkflowInstanceTransitions_WorkflowInstanceSteps1` (`SourceWorkflowInstanceStepId`),
  KEY `FK_WorkflowInstanceTransitions_WorkflowInstanceSteps2` (`TargetWorkflowInstanceStepId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `workflownotifications`
--

DROP TABLE IF EXISTS `workflownotifications`;
CREATE TABLE IF NOT EXISTS `workflownotifications` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ShamUserId` int(11) NOT NULL,
  `InteractUri` varchar(1024) NOT NULL,
  `DateCreated` datetime(6) NOT NULL,
  `Sent` tinyint(1) NOT NULL DEFAULT '0',
  `DateSent` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_WorkflowNotifications_ShamUsers` (`ShamUserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `workflows`
--

DROP TABLE IF EXISTS `workflows`;
CREATE TABLE IF NOT EXISTS `workflows` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `TriggerId` int(11) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `TargetDate` date DEFAULT NULL,
  `RecurrenceId` int(11) DEFAULT NULL,
  `MaxDuration` int(11) NOT NULL,
  `Diagram` longtext NOT NULL,
  `SystemSubModuleId` int(11) NOT NULL,
  `ShamUserId` int(11) NOT NULL,
  `Active` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Workflows_Recurrences` (`RecurrenceId`),
  KEY `FK_Workflows_ShamUsers` (`ShamUserId`),
  KEY `FK_Workflows_SystemSubModules` (`SystemSubModuleId`),
  KEY `FK_Workflows_Triggers` (`TriggerId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `workflowsteps`
--

DROP TABLE IF EXISTS `workflowsteps`;
CREATE TABLE IF NOT EXISTS `workflowsteps` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `WorkflowId` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `WorkflowStepTypeId` int(11) NOT NULL,
  `WorkflowStepStateId` int(11) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `MaxDurationDays` int(11) NOT NULL,
  `Param1` varchar(50) NOT NULL,
  `Param2` varchar(50) NOT NULL,
  `Param3` varchar(50) NOT NULL,
  `Param4` varchar(50) NOT NULL,
  `Param5` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_WorkflowSteps_Workflows` (`WorkflowId`),
  KEY `FK_WorkflowSteps_WorkflowStepStates` (`WorkflowStepStateId`),
  KEY `FK_WorkflowSteps_WorkflowStepTypes` (`WorkflowStepTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `workflowstepstates`
--

DROP TABLE IF EXISTS `workflowstepstates`;
CREATE TABLE IF NOT EXISTS `workflowstepstates` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(50) NOT NULL,
  `Active` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `workflowsteptypes`
--

DROP TABLE IF EXISTS `workflowsteptypes`;
CREATE TABLE IF NOT EXISTS `workflowsteptypes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(50) NOT NULL,
  `Active` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `workflowtransitions`
--

DROP TABLE IF EXISTS `workflowtransitions`;
CREATE TABLE IF NOT EXISTS `workflowtransitions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `WorkflowId` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `SourceWorkflowStepId` int(11) NOT NULL,
  `TargetWorkflowStepId` int(11) DEFAULT NULL,
  `Value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_WorkflowTransitions_Workflows` (`WorkflowId`),
  KEY `FK_WorkflowTransitions_WorkflowSteps` (`SourceWorkflowStepId`),
  KEY `FK_WorkflowTransitions_WorkflowSteps1` (`TargetWorkflowStepId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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


INSERT INTO `sys_config_values` (`key`, `value`) VALUES ('LATEST_SFE_CODE', 'SG0001');

-- --------------------------------------------------------

--
-- Structure for view `assetdata_view`
--
DROP TABLE IF EXISTS `assetdata_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `assetdata_view`  AS  select `ag`.`name` AS `name`,count(`ag`.`id`) AS `total` from (`asset_groups` `ag` join `assets` `a` on((`ag`.`id` = `a`.`asset_group_id`))) where ((`a`.`is_available` = 1) and isnull(`ag`.`deleted_at`) and isnull(`a`.`deleted_at`)) group by `ag`.`name` ;

-- --------------------------------------------------------

--
-- Structure for view `headcountbydepartment_view`
--
DROP TABLE IF EXISTS `headcountbydepartment_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `headcountbydepartment_view`  AS  select `e`.`id` AS `Id`,ifnull(`d`.`description`,'Unspecified') AS `Department` from (`employees` `e` left join `departments` `d` on((`d`.`id` = `e`.`department_id`))) where ((`e`.`is_active` = 1) and isnull(`e`.`date_terminated`)) ;

-- --------------------------------------------------------

--
-- Structure for view `headcountbygender_view`
--
DROP TABLE IF EXISTS `headcountbygender_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `headcountbygender_view`  AS  select `e`.`id` AS `Id`,ifnull(`g`.`description`,'Unspecified') AS `Sex`,ifnull(`eg`.`description`,'Unspecified') AS `Ethnicity`,`e`.`date_terminated` AS `TerminationDate`,`e`.`date_joined` AS `JoinedDate`,(case when (`e`.`date_joined` is not null) then timestampdiff(YEAR,`e`.`date_joined`,curdate()) else 0 end) AS `YearsService`,1 AS `Size` from ((`employees` `e` left join `genders` `g` on((`g`.`id` = `e`.`gender_id`))) left join `ethnic_groups` `eg` on((`eg`.`id` = `e`.`ethnic_group_id`))) where ((`e`.`is_active` = 1) and isnull(`e`.`date_terminated`)) ;

-- --------------------------------------------------------

--
-- Structure for view `newhires_view`
--
DROP TABLE IF EXISTS `newhires_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `newhires_view`  AS  select year(`employees`.`date_joined`) AS `Year`,count(`employees`.`id`) AS `Count`,0 AS `Type`,'Hired' AS `Name` from `employees` where ((`employees`.`date_joined` is not null) and (`employees`.`date_joined` >= (now() - interval 5 year))) group by year(`employees`.`date_joined`) union select year(`employees`.`date_terminated`) AS `Year`,count(`employees`.`id`) AS `Count`,1 AS `Type`,'Terminated' AS `Name` from `employees` where ((`employees`.`date_terminated` is not null) and (`employees`.`date_terminated` >= (now() - interval 5 year))) group by year(`employees`.`date_terminated`) ;

-- --------------------------------------------------------

--
-- Structure for view `qaevaluationscoresview`
--
DROP TABLE IF EXISTS `qaevaluationscoresview`;

-- Error reading structure for table shamdev.qaevaluationscoresview: #1046 - No database selected
CREATE OR REPLACE VIEW `qaevaluationscoresview`
as
select data.evaluation_id AS EvaluationId,data.assessment_id AS AssessmentId,data.assessor_employee_id AS AssessorEmployeeId,data.feedback_date AS Feedbackdate,data.points AS Points,round(cast(data.points as decimal(10,3))/cast(at.total_threshold as decimal(10,3))) as Percentage
from
(
select evaluation_id,assessor_employee_id,sum(points) as Points,er.assessment_id,e.feedback_date from evaluation_results er
inner join evaluations e on e.id = er.evaluation_id
where er.is_active = 1 and e.feedback_date between DATE_ADD(current_timestamp,Interval -370 DAY) and current_timestamp
group by evaluation_id,assessor_employee_id,er.assessment_id,e.feedback_date

) data
inner join
(
select t.assessment_id,sum(t.threshold) as total_threshold from
(
select aac.assessment_id, aac.assessment_category_id, ac.threshold from assessments_assessment_category aac
inner join assessment_categories ac on ac.id = aac.assessment_category_id
where aac.is_active = 1 and aac.assessment_id in (

select distinct(er.assessment_id) from evaluation_results er
inner join evaluations e on e.id = er.evaluation_id
where er.is_active = 1 and e.feedback_date between DATE_ADD(current_timestamp,Interval -370 DAY) and current_timestamp
group by evaluation_id,assessor_employee_id,er.assessment_id,e.feedback_date

)
group by aac.assessment_id,aac.assessment_category_id,ac.threshold
) t
group by t.assessment_id
) at
on data.assessment_id = at.assessment_id;

-- --------------------------------------------------------

--
-- Structure for view `qaevaluationsview`
--
DROP TABLE IF EXISTS `qaevaluationsview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qaevaluationsview`  AS  select `ev`.`assessment_id` AS `assessment_id`,sum(`er`.`points`) AS `TotalPoints`,`ev`.`feedback_date` AS `Feedbackdate`,`t`.`total_threshold` AS `TotalThreshold`,`pc`.`description` AS `description` from (((`evaluations` `ev` join `evaluation_results` `er` on(((`ev`.`id` = `er`.`evaluation_id`) and (`ev`.`createdby_employee_id` = `er`.`assessor_employee_id`)))) join (select `aac`.`assessment_id` AS `assessmentid`,sum(`ac`.`threshold`) AS `total_threshold` from (`assessments_assessment_category` `aac` join `assessment_categories` `ac` on((`aac`.`assessment_category_id` = `ac`.`id`))) where (`aac`.`is_active` = 1) group by `aac`.`assessment_id`) `t` on((`t`.`assessmentid` = `ev`.`assessment_id`))) join `product_categories` `pc` on((`ev`.`productcategory_id` = `pc`.`id`))) where ((`ev`.`is_active` = 1) and (`er`.`is_active` = 1)) group by `ev`.`id`,`ev`.`assessment_id`,`ev`.`feedback_date`,`t`.`total_threshold`,`pc`.`description` ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `FK_Addresses_Countries` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Addresses_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `announcement_department`
--
ALTER TABLE `announcement_department`
  ADD CONSTRAINT `FK_AnnouncementsDepartments_Announcements` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_AnnouncementsDepartments_Departments` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `FK_Applicants_Genders` FOREIGN KEY (`GenderId`) REFERENCES `genders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Applicants_Languages` FOREIGN KEY (`LanguageId`) REFERENCES `languages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Applicants_Titles` FOREIGN KEY (`TitleId`) REFERENCES `titles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `FK_Applications_Applicants` FOREIGN KEY (`ApplicantId`) REFERENCES `applicants` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Applications_Vacancies` FOREIGN KEY (`VacancyId`) REFERENCES `vacancies` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `applicationtests`
--
ALTER TABLE `applicationtests`
  ADD CONSTRAINT `FK_ApplicationTests_Applicants` FOREIGN KEY (`ApplicantId`) REFERENCES `applicants` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ApplicationTests_ApplicationTestTypes` FOREIGN KEY (`ApplicationTestTypeId`) REFERENCES `applicationtesttypes` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `assessments_assessment_category`
--
ALTER TABLE `assessments_assessment_category`
  ADD CONSTRAINT `FK_AssessmentsAssessmentCategories_AssessmentCategories` FOREIGN KEY (`assessment_category_id`) REFERENCES `assessment_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_AssessmentsAssessmentCategories_Assessments` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `assessment_category_category_question`
--
ALTER TABLE `assessment_category_category_question`
  ADD CONSTRAINT `FK_AssessmentCategoriesCategoryQuestions_AssessmentCategories` FOREIGN KEY (`assessment_category_id`) REFERENCES `assessment_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_AssessmentCategoriesCategoryQuestions_CategoryQuestions` FOREIGN KEY (`category_question_id`) REFERENCES `category_questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `FK_Assets_AssetConditions` FOREIGN KEY (`asset_condition_id`) REFERENCES `asset_conditions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Assets_AssetGroups` FOREIGN KEY (`asset_group_id`) REFERENCES `asset_groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Assets_Suppliers` FOREIGN KEY (`asset_supplier_id`) REFERENCES `asset_suppliers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `asset_employee`
--
ALTER TABLE `asset_employee`
  ADD CONSTRAINT `FK_AssetAllocations_Assets` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_AssetAllocations_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `bankingdetails`
--
ALTER TABLE `bankingdetails`
  ADD CONSTRAINT `FK_BankingDetails_BankAccountTypes` FOREIGN KEY (`BankAccountTypeId`) REFERENCES `bankaccounttypes` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_BankingDetails_Employees` FOREIGN KEY (`EmployeeId`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `FK_Branches_Companies1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `calendarevents`
--
ALTER TABLE `calendarevents`
  ADD CONSTRAINT `FK_CalendarEvents_CalendarParentEvents` FOREIGN KEY (`CalendarParentEventsId`) REFERENCES `calendarparentevents` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `category_question_choices`
--
ALTER TABLE `category_question_choices`
  ADD CONSTRAINT `FK_CategoryQuestionChoices_CategoryQuestions2` FOREIGN KEY (`category_question_id`) REFERENCES `category_questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `commentdetails`
--
ALTER TABLE `commentdetails`
  ADD CONSTRAINT `FK_CommentDetails_CourseDiscussions` FOREIGN KEY (`course_discussion_iId`) REFERENCES `course_discussions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CommentDetails_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CommentDetails_ThreadStatuses` FOREIGN KEY (`thread_status_id`) REFERENCES `thread_statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `companydocuments`
--
ALTER TABLE `companydocuments`
  ADD CONSTRAINT `FK_CompanyDocuments_DocumentCategories` FOREIGN KEY (`DocumentCategoryId`) REFERENCES `document_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CompanyDocuments_DocumentTypes` FOREIGN KEY (`DocumentTypeId`) REFERENCES `document_types` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CompanyDocuments_ShamUsers` FOREIGN KEY (`UploadedByShamUserId`) REFERENCES `sham_users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `courseprerequisites`
--
ALTER TABLE `courseprerequisites`
  ADD CONSTRAINT `FK_CoursePrerquisites_Course` FOREIGN KEY (`CourseId`) REFERENCES `courses` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CoursePrerquisites_Course1` FOREIGN KEY (`PrerequisiteCourseId`) REFERENCES `courses` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `course_discussions`
--
ALTER TABLE `course_discussions`
  ADD CONSTRAINT `FK_CourseDiscussions_Courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CourseDiscussions_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CourseDiscussions_ThreadStatuses` FOREIGN KEY (`thread_status_id`) REFERENCES `thread_statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `course_employee`
--
ALTER TABLE `course_employee`
  ADD CONSTRAINT `FK_CourseParticipants_CourseParticipantStatuses` FOREIGN KEY (`courseparticipantstatus_id`) REFERENCES `courseparticipantstatuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CourseParticipants_Courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CourseParticipants_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `course_module`
--
ALTER TABLE `course_module`
  ADD CONSTRAINT `FK_CourseModules_Course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CourseModules_Module` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `course_progress`
--
ALTER TABLE `course_progress`
  ADD CONSTRAINT `FK_CourseProgress_Courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CourseProgress_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CourseProgress_Modules` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CourseProgress_Topics` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `day_time_group_time_period`
--
ALTER TABLE `day_time_group_time_period`
  ADD CONSTRAINT `FK_TimeGroupDays_Days` FOREIGN KEY (`day_id`) REFERENCES `days` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TimeGroupDays_TimeGroups` FOREIGN KEY (`time_group_id`) REFERENCES `time_groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TimeGroupDays_TimePeriods` FOREIGN KEY (`time_period_id`) REFERENCES `time_periods` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `disciplinary_actions`
--
ALTER TABLE `disciplinary_actions`
  ADD CONSTRAINT `FK_DisciplinaryActions_Decisions` FOREIGN KEY (`disciplinary_decision_id`) REFERENCES `disciplinary_decisions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_DisciplinaryActions_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_DisciplinaryActions_Violations` FOREIGN KEY (`violation_id`) REFERENCES `violations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `email_addresses`
--
ALTER TABLE `email_addresses`
  ADD CONSTRAINT `FK_EmailAddresses_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `FK_Employees_Branches` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Employees_Countries` FOREIGN KEY (`passport_country_id`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Employees_Departments` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Employees_Divisions` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Employees_EmployeeStatuses` FOREIGN KEY (`employee_status_id`) REFERENCES `employee_statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Employees_EthnicGroups` FOREIGN KEY (`ethnic_group_id`) REFERENCES `ethnic_groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Employees_Genders` FOREIGN KEY (`gender_id`) REFERENCES `genders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Employees_ImmigrationStatuses` FOREIGN KEY (`immigration_status_id`) REFERENCES `immigration_statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Employees_JobTitles` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Employees_Languages` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Employees_MaritalStatuses` FOREIGN KEY (`marital_status_id`) REFERENCES `maritalstatuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Employees_TaxStatuses` FOREIGN KEY (`tax_status_id`) REFERENCES `tax_statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Employees_Teams` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Employees_Titles` FOREIGN KEY (`title_id`) REFERENCES `titles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employeesleaveschedules`
--
ALTER TABLE `employeesleaveschedules`
  ADD CONSTRAINT `FK_EmployeesLeaveSchedules_Employees` FOREIGN KEY (`EmployeeId`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_EmployeesLeaveSchedules_LeaveSchedules` FOREIGN KEY (`LeaveScheduleId`) REFERENCES `leaveschedules` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employee_attachments`
--
ALTER TABLE `employee_attachments`
  ADD CONSTRAINT `FK_EmployeeAttachments_EmployeeAttachmentTypes` FOREIGN KEY (`employee_attachment_type_id`) REFERENCES `employee_attachment_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_EmployeeAttachments_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employee_attendance_records`
--
ALTER TABLE `employee_attendance_records`
  ADD CONSTRAINT `FK_EmployeeAttendanceRecords_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employee_evaluation`
--
ALTER TABLE `employee_evaluation`
  ADD CONSTRAINT `FK_EvaluationAssessors_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_EvaluationAssessors_Evaluations` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employee_skill`
--
ALTER TABLE `employee_skill`
  ADD CONSTRAINT `FK_EmployeeSkills_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_EmployeeSkills_Skills` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employee_training_session`
--
ALTER TABLE `employee_training_session`
  ADD CONSTRAINT `FK_TrainingSessionParticipants_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TrainingSessionParticipants_TrainingSessions` FOREIGN KEY (`training_session_id`) REFERENCES `training_sessions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `FK_Evaluations_Assessments` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Evaluations_Departments` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Evaluations_Employees` FOREIGN KEY (`user_employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Evaluations_Employees1` FOREIGN KEY (`createdby_employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Evaluations_Languages` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Evaluations_ProductCategories` FOREIGN KEY (`productcategory_id`) REFERENCES `product_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `evaluation_results`
--
ALTER TABLE `evaluation_results`
  ADD CONSTRAINT `FK_EvaluationResults_AssessmentCategories` FOREIGN KEY (`assessment_category_id`) REFERENCES `assessment_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_EvaluationResults_Assessments` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_EvaluationResults_CategoryQuestions` FOREIGN KEY (`category_question_id`) REFERENCES `category_questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_EvaluationResults_Employees` FOREIGN KEY (`assessor_employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_EvaluationResults_Evaluations` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `event_task`
--
ALTER TABLE `event_task`
  ADD CONSTRAINT `FK__EventTask__Event__729BEF18` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK__EventTask__TaskI__73901351` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `event_task_instances`
--
ALTER TABLE `event_task_instances`
  ADD CONSTRAINT `FK__EventTask__Emplo__7948ECA7` FOREIGN KEY (`employee_created_Id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK__EventTask__Emplo__7C255952` FOREIGN KEY (`employee_allocated_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK__EventTask__Event__7854C86E` FOREIGN KEY (`event_task_id`) REFERENCES `event_task` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK__EventTask__LinkT__7A3D10E0` FOREIGN KEY (`link_type_id`) REFERENCES `link_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK__EventTask__Targe__7B313519` FOREIGN KEY (`target_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `history_departments`
--
ALTER TABLE `history_departments`
  ADD CONSTRAINT `FK_HistoryDepartments_Departments` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_HistoryDepartments_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `history_disciplinary_actions`
--
ALTER TABLE `history_disciplinary_actions`
  ADD CONSTRAINT `FK_HistoryDisciplinaryActions_DisciplinaryActions` FOREIGN KEY (`disciplinary_action_id`) REFERENCES `disciplinary_actions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_HistoryDisciplinaryActions_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `history_job_titles`
--
ALTER TABLE `history_job_titles`
  ADD CONSTRAINT `FK_HistoryJobTitles_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_HistoryJobTitles_JobTitles` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `history_join_terminations`
--
ALTER TABLE `history_join_terminations`
  ADD CONSTRAINT `FK_HistoryJoinsTerminations_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `history_rewards`
--
ALTER TABLE `history_rewards`
  ADD CONSTRAINT `FK_HistoryRewards_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_HistoryRewards_Rewards` FOREIGN KEY (`reward_id`) REFERENCES `rewards` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `interviewforms`
--
ALTER TABLE `interviewforms`
  ADD CONSTRAINT `FK_InterviewForms_Vacancies` FOREIGN KEY (`VacancyId`) REFERENCES `vacancies` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `interviews`
--
ALTER TABLE `interviews`
  ADD CONSTRAINT `FK_Interviews_Applicants` FOREIGN KEY (`ApplicantId`) REFERENCES `applicants` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jobadverts`
--
ALTER TABLE `jobadverts`
  ADD CONSTRAINT `FK_JobAdverts_Vacancies` FOREIGN KEY (`VacancyId`) REFERENCES `vacancies` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `laws`
--
ALTER TABLE `laws`
  ADD CONSTRAINT `FK_Laws_Countries` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Laws_LawCategories` FOREIGN KEY (`law_category_id`) REFERENCES `law_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `law_documents`
--
ALTER TABLE `law_documents`
  ADD CONSTRAINT `FK_LawDocuments_Laws` FOREIGN KEY (`LawId`) REFERENCES `laws` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_law_documents_law_id` FOREIGN KEY (`LawId`) REFERENCES `laws` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `learning_materials`
--
ALTER TABLE `learning_materials`
  ADD CONSTRAINT `FK_LearningMaterials_LearningMaterialTypes` FOREIGN KEY (`learning_material_type_id`) REFERENCES `learning_material_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_LearningMaterials_Modules` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `leaveapplicationforms`
--
ALTER TABLE `leaveapplicationforms`
  ADD CONSTRAINT `FK_LeaveApplicationForms_Employees` FOREIGN KEY (`EmployeeId`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_LeaveApplicationForms_LeaveTypes` FOREIGN KEY (`LeaveTypeId`) REFERENCES `leavetypes` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `leavedays`
--
ALTER TABLE `leavedays`
  ADD CONSTRAINT `FK_LeaveDays_LeaveApplications` FOREIGN KEY (`LeaveApplicationId`) REFERENCES `leaveapplications` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_LeaveDays_LeaveTypes` FOREIGN KEY (`LeaveTypeId`) REFERENCES `leavetypes` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `leavescheduleitems`
--
ALTER TABLE `leavescheduleitems`
  ADD CONSTRAINT `FK_LeaveScheduleItems_LeaveSchedules` FOREIGN KEY (`LeaveScheduleId`) REFERENCES `leaveschedules` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_LeaveScheduleItems_LeaveTypes` FOREIGN KEY (`LeaveTypeId`) REFERENCES `leavetypes` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `moduleprerequisites`
--
ALTER TABLE `moduleprerequisites`
  ADD CONSTRAINT `FK_ModulePrerequisites_Module` FOREIGN KEY (`ModuleId`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ModulePrerequisites_Module1` FOREIGN KEY (`PrerequisiteModuleId`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `module_assessments`
--
ALTER TABLE `module_assessments`
  ADD CONSTRAINT `FK_ModuleAssessments_AssessmentTypes` FOREIGN KEY (`assessment_type_id`) REFERENCES `assessment_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ModuleAssessments_Employees` FOREIGN KEY (`trainer_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ModuleAssessments_Module` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `module_assessment_questions`
--
ALTER TABLE `module_assessment_questions`
  ADD CONSTRAINT `FK_ModuleAssessmentQuestions_ModuleAssessments` FOREIGN KEY (`module_assessment_id`) REFERENCES `module_assessments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ModuleAssessmentQuestions_ModuleQuestions` FOREIGN KEY (`module_question_id`) REFERENCES `module_questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `module_assessment_responses`
--
ALTER TABLE `module_assessment_responses`
  ADD CONSTRAINT `FK_ModuleAssessmentResponses_Courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ModuleAssessmentResponses_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ModuleAssessmentResponses_ModuleAssessments` FOREIGN KEY (`module_assessment_id`) REFERENCES `module_assessments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ModuleAssessmentResponses_Modules` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `module_assessment_response_details`
--
ALTER TABLE `module_assessment_response_details`
  ADD CONSTRAINT `FK_ModuleAssessmentResponseDetails_ModuleAssessmentResponses` FOREIGN KEY (`module_assessment_response_id`) REFERENCES `module_assessment_responses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ModuleAssessmentResponseDetails_ModuleAssessments` FOREIGN KEY (`module_assessment_id`) REFERENCES `module_assessments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ModuleAssessmentResponseDetails_ModuleQuestions` FOREIGN KEY (`module_question_id`) REFERENCES `module_questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ModuleAssessmentResponseDetails_Modules` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `module_questions`
--
ALTER TABLE `module_questions`
  ADD CONSTRAINT `FK_ModuleQuestions_ModuleQuestionTypes` FOREIGN KEY (`module_question_type_id`) REFERENCES `module_question_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `module_question_choices`
--
ALTER TABLE `module_question_choices`
  ADD CONSTRAINT `FK_ModuleQuestionChoices_ModuleQuestions` FOREIGN KEY (`module_question_id`) REFERENCES `module_questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `module_topic`
--
ALTER TABLE `module_topic`
  ADD CONSTRAINT `FK_ModuleTopics_Modules` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ModuleTopics_Topics` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `notificationgroupsshamusers`
--
ALTER TABLE `notificationgroupsshamusers`
  ADD CONSTRAINT `FK_NotificationGroupsShamUsers_NotificationGroups` FOREIGN KEY (`NotificationGroupId`) REFERENCES `notification_groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_NotificationGroupsShamUsers_ShamUsers` FOREIGN KEY (`ShamUserId`) REFERENCES `sham_users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `notificationparticipants`
--
ALTER TABLE `notificationparticipants`
  ADD CONSTRAINT `FK_NotificationParticipants_ShamUsers` FOREIGN KEY (`ShamUserId`) REFERENCES `sham_users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_NotificationParticipants_WorkflowSteps` FOREIGN KEY (`WorkflowStepId`) REFERENCES `workflowsteps` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_NotificationParticipants_WorkflowSteps1` FOREIGN KEY (`WorkflowStepId`) REFERENCES `workflowsteps` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `FK_Notifications_NotificationGroups` FOREIGN KEY (`NotificationGroupId`) REFERENCES `notification_groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Notifications_NotificationRecurrences` FOREIGN KEY (`NotificationRecurrenceId`) REFERENCES `notification_recurrences` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Notifications_NotificationStatuses` FOREIGN KEY (`NotificationStatusId`) REFERENCES `notificationstatuses` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Notifications_NotificationTimes` FOREIGN KEY (`NotificationTimesId`) REFERENCES `notificationtimes` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Notifications_NotificationTypes` FOREIGN KEY (`NotificationTypeId`) REFERENCES `notificationtypes` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Notifications_Triggers` FOREIGN KEY (`TriggerId`) REFERENCES `triggers` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `FK_Offers_Applications` FOREIGN KEY (`ApplicationId`) REFERENCES `applications` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Offers_OfferResponses` FOREIGN KEY (`OfferResponseId`) REFERENCES `offerresponses` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `parserexpressions`
--
ALTER TABLE `parserexpressions`
  ADD CONSTRAINT `FK_ParserExpressions_ShamUsers` FOREIGN KEY (`ShamUserId`) REFERENCES `sham_users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `policies`
--
ALTER TABLE `policies`
  ADD CONSTRAINT `FK_Policies_PolicyCategories` FOREIGN KEY (`policy_category_id`) REFERENCES `policy_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `policy_documents`
--
ALTER TABLE `policy_documents`
  ADD CONSTRAINT `FK_PolicyDocuments_Policies` FOREIGN KEY (`policy_id`) REFERENCES `policies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_team`
--
ALTER TABLE `product_team`
  ADD CONSTRAINT `FK_TeamsProducts_Products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TeamsProducts_Teams` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD CONSTRAINT `FK_Qualifications_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `recruitmentrequests`
--
ALTER TABLE `recruitmentrequests`
  ADD CONSTRAINT `FK_RecruitmentRequests_Branches` FOREIGN KEY (`BranchId`) REFERENCES `branches` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_RecruitmentRequests_Departments` FOREIGN KEY (`DepartmentId`) REFERENCES `departments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_RecruitmentRequests_Divisions` FOREIGN KEY (`DivisionId`) REFERENCES `divisions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_RecruitmentRequests_Employees` FOREIGN KEY (`HiringManagerEmployeeId`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_RecruitmentRequests_RecruitmentRequestReasons` FOREIGN KEY (`RecruitmentRequestReasonId`) REFERENCES `recruitmentrequestreasons` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_RecruitmentRequests_TimeGroups` FOREIGN KEY (`TimeGroupId`) REFERENCES `time_groups` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `report_templates`
--
ALTER TABLE `report_templates`
  ADD CONSTRAINT `FK_ReportTemplates_SystemModules` FOREIGN KEY (`system_module_id`) REFERENCES `system_modules` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rewards`
--
ALTER TABLE `rewards`
  ADD CONSTRAINT `FK_Rewards_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `FK_Roles_ShamUsers` FOREIGN KEY (`ShamUserId`) REFERENCES `sham_users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Roles_Workflows` FOREIGN KEY (`WorkflowId`) REFERENCES `workflows` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `shamsessions`
--
ALTER TABLE `shamsessions`
  ADD CONSTRAINT `FK_ShamSessions_ShamUsers` FOREIGN KEY (`ShamUserId`) REFERENCES `sham_users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sham_users`
--
ALTER TABLE `sham_users`
  ADD CONSTRAINT `FK_ShamUsers_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ShamUsers_ShamUserProfiles` FOREIGN KEY (`ShamUserProfileId`) REFERENCES `sham_user_profiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `suggestioncomments`
--
ALTER TABLE `suggestioncomments`
  ADD CONSTRAINT `FK_SuggestionComments_ShamUsers` FOREIGN KEY (`MadeByShamUserId`) REFERENCES `sham_users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_SuggestionComments_ShamUsers1` FOREIGN KEY (`ApprovedByShamUserId`) REFERENCES `sham_users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_SuggestionComments_Suggestions` FOREIGN KEY (`SuggestionId`) REFERENCES `suggestions` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `suggestions`
--
ALTER TABLE `suggestions`
  ADD CONSTRAINT `FK_Suggestions_ShamUsers` FOREIGN KEY (`AuthorShamUserId`) REFERENCES `sham_users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Suggestions_ShamUsers1` FOREIGN KEY (`ReviewerShamUserId`) REFERENCES `sham_users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Suggestions_SuggestionStatuses` FOREIGN KEY (`SuggestionStatusId`) REFERENCES `suggestionstatuses` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `surveys`
--
ALTER TABLE `surveys`
  ADD CONSTRAINT `FK_Surveys_Forms` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Surveys_NotificationGroups` FOREIGN KEY (`notification_group_id`) REFERENCES `notification_groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Surveys_NotificationRecurrences` FOREIGN KEY (`notification_recurrence_id`) REFERENCES `notification_recurrences` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Surveys_SurveyStatuses` FOREIGN KEY (`survey_status_id`) REFERENCES `survey_statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `survey_responses`
--
ALTER TABLE `survey_responses`
  ADD CONSTRAINT `FK_SurveyResponses_ShamUsers` FOREIGN KEY (`sham_user_id`) REFERENCES `sham_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_SurveyResponses_Surveys` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `system_sub_modules`
--
ALTER TABLE `system_sub_modules`
  ADD CONSTRAINT `FK_SystemSubModules_SystemModules` FOREIGN KEY (`system_module_id`) REFERENCES `system_modules` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `FK_Tasks_Departments` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `FK_Teams_TimeGroups` FOREIGN KEY (`time_group_id`) REFERENCES `time_groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `telephone_numbers`
--
ALTER TABLE `telephone_numbers`
  ADD CONSTRAINT `FK_TelephoneNumbers_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `temporaryjobs`
--
ALTER TABLE `temporaryjobs`
  ADD CONSTRAINT `FK_TemporaryJobs_EmployeeStatuses` FOREIGN KEY (`EmployeeStatusId`) REFERENCES `employee_statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TemporaryJobs_JobTitles` FOREIGN KEY (`JobTitleId`) REFERENCES `job_titles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `timelines`
--
ALTER TABLE `timelines`
  ADD CONSTRAINT `FK_Timelines_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Timelines_TimelineEventTypes` FOREIGN KEY (`timeline_event_type_id`) REFERENCES `timeline_event_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `topic_attachments`
--
ALTER TABLE `topic_attachments`
  ADD CONSTRAINT `FK_TopicAttachments_LearningMaterialTypes` FOREIGN KEY (`learning_material_type_id`) REFERENCES `learning_material_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TopicAttachments_Topics` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `trainingvenuebookings`
--
ALTER TABLE `trainingvenuebookings`
  ADD CONSTRAINT `FK_TrainingVenueBookings_TrainingSessions` FOREIGN KEY (`TrainingSessionId`) REFERENCES `training_sessions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TrainingVenueBookings_TrainingVenues` FOREIGN KEY (`TrainingVenueId`) REFERENCES `trainingvenues` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `trainingvenues`
--
ALTER TABLE `trainingvenues`
  ADD CONSTRAINT `FK_TrainingVenues_Buildings` FOREIGN KEY (`BuildingId`) REFERENCES `buildings` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `training_sessions`
--
ALTER TABLE `training_sessions`
  ADD CONSTRAINT `FK_TrainingSessions_Courses1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TrainingSessions_TrainingDeliveryMethods` FOREIGN KEY (`training_delivery_method_id`) REFERENCES `training_delivery_methods` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `travelexpenseclaims`
--
ALTER TABLE `travelexpenseclaims`
  ADD CONSTRAINT `FK_TravelExpenseClaims_Countries` FOREIGN KEY (`CountryId`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TravelExpenseClaims_Currencies` FOREIGN KEY (`CurrencieId`) REFERENCES `currencies` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TravelExpenseClaims_Customers` FOREIGN KEY (`CustomerId`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TravelExpenseClaims_Employees` FOREIGN KEY (`ReviewerEmployeeId`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TravelExpenseClaims_TravelExpenseClaimStatuses` FOREIGN KEY (`TravelExpenseClaimStatusId`) REFERENCES `travelexpenseclaimstatuses` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TravelExpenseClaims_TravelRequestAttachments` FOREIGN KEY (`TravelRequestAttachmentId`) REFERENCES `travelrequestattachments` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TravelExpenseClaims_TravelRequests` FOREIGN KEY (`TravelRequestId`) REFERENCES `travelrequests` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `travelrequestattachments`
--
ALTER TABLE `travelrequestattachments`
  ADD CONSTRAINT `FK_TravelRequestAttachments_TravelRequests` FOREIGN KEY (`TravelRequestId`) REFERENCES `travelrequests` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `travelrequests`
--
ALTER TABLE `travelrequests`
  ADD CONSTRAINT `FK_TravelRequests_AdvanceMethods` FOREIGN KEY (`PreferredAdvanceMethodId`) REFERENCES `advancemethods` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TravelRequests_Currencies` FOREIGN KEY (`TransportationCurrencyId`) REFERENCES `currencies` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TravelRequests_Currencies1` FOREIGN KEY (`AccomodationCurrencyId`) REFERENCES `currencies` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TravelRequests_Currencies2` FOREIGN KEY (`PerDiemCurrencyId`) REFERENCES `currencies` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TravelRequests_Currencies3` FOREIGN KEY (`OtherFeesCurrencyId`) REFERENCES `currencies` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TravelRequests_Employees` FOREIGN KEY (`RequestedByEmployeeId`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TravelRequests_Employees1` FOREIGN KEY (`ReviewedByEmployeeId`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_TravelRequests_TravelRequestStatuses` FOREIGN KEY (`TravelRequestStatusId`) REFERENCES `travelrequeststatuses` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `triggers`
--
ALTER TABLE `triggers`
  ADD CONSTRAINT `FK_Triggers_ParserExpressions` FOREIGN KEY (`ParserExpressionId`) REFERENCES `parserexpressions` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Triggers_TriggerTypes` FOREIGN KEY (`TriggerTypeId`) REFERENCES `triggertypes` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_sham_user_profile_id` FOREIGN KEY (`sham_user_profile_id`) REFERENCES `sham_user_profiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `vacancies`
--
ALTER TABLE `vacancies`
  ADD CONSTRAINT `FK_Vacancies_ApplicationTestForms` FOREIGN KEY (`Id`) REFERENCES `applicationtestforms` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Vacancies_Branches` FOREIGN KEY (`BranchId`) REFERENCES `branches` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Vacancies_Companies` FOREIGN KEY (`CompanyId`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Vacancies_Departments` FOREIGN KEY (`DepartmentId`) REFERENCES `departments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Vacancies_Divisions` FOREIGN KEY (`DivisionId`) REFERENCES `divisions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Vacancies_RecruitmentRequests` FOREIGN KEY (`RecruitmentRequestId`) REFERENCES `recruitmentrequests` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `viewedcomments`
--
ALTER TABLE `viewedcomments`
  ADD CONSTRAINT `FK_ViewedComments_CommentDetails` FOREIGN KEY (`CommentDetailId`) REFERENCES `commentdetails` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ViewedComments_Employees` FOREIGN KEY (`EmployeeId`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `workflowinstanceroles`
--
ALTER TABLE `workflowinstanceroles`
  ADD CONSTRAINT `FK_WorkflowInstanceRoles_Roles` FOREIGN KEY (`RoleId`) REFERENCES `roles` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_WorkflowInstanceRoles_ShamUsers` FOREIGN KEY (`ShamUserId`) REFERENCES `sham_users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_WorkflowInstanceRoles_WorkflowInstances` FOREIGN KEY (`WorkflowInstanceId`) REFERENCES `workflowinstances` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `workflowinstances`
--
ALTER TABLE `workflowinstances`
  ADD CONSTRAINT `FK_WorkflowInstances_WorkflowInstanceSteps` FOREIGN KEY (`CurrentWorkflowInstanceStepId`) REFERENCES `workflowinstancesteps` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_WorkflowInstances_Workflows` FOREIGN KEY (`WorkflowId`) REFERENCES `workflows` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `workflowinstancesteps`
--
ALTER TABLE `workflowinstancesteps`
  ADD CONSTRAINT `FK_WorkflowInstanceSteps_WorkflowInstances` FOREIGN KEY (`WorkflowInstanceId`) REFERENCES `workflowinstances` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_WorkflowInstanceSteps_WorkflowStepStates` FOREIGN KEY (`WorkflowStepStateId`) REFERENCES `workflowstepstates` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_WorkflowInstanceSteps_WorkflowStepTypes` FOREIGN KEY (`WorkflowStepTypeId`) REFERENCES `workflowsteptypes` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_WorkflowInstanceSteps_WorkflowSteps` FOREIGN KEY (`WorkflowStepId`) REFERENCES `workflowsteps` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `workflowinstancetransitions`
--
ALTER TABLE `workflowinstancetransitions`
  ADD CONSTRAINT `FK_WorkflowInstanceTransitions_WorkflowInstanceSteps` FOREIGN KEY (`SourceWorkflowInstanceStepId`) REFERENCES `workflowinstancesteps` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_WorkflowInstanceTransitions_WorkflowInstanceSteps1` FOREIGN KEY (`SourceWorkflowInstanceStepId`) REFERENCES `workflowinstancesteps` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_WorkflowInstanceTransitions_WorkflowInstanceSteps2` FOREIGN KEY (`TargetWorkflowInstanceStepId`) REFERENCES `workflowinstancesteps` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `workflownotifications`
--
ALTER TABLE `workflownotifications`
  ADD CONSTRAINT `FK_WorkflowNotifications_ShamUsers` FOREIGN KEY (`ShamUserId`) REFERENCES `sham_users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `workflows`
--
ALTER TABLE `workflows`
  ADD CONSTRAINT `FK_Workflows_Recurrences` FOREIGN KEY (`RecurrenceId`) REFERENCES `recurrences` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Workflows_ShamUsers` FOREIGN KEY (`ShamUserId`) REFERENCES `sham_users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Workflows_SystemSubModules` FOREIGN KEY (`SystemSubModuleId`) REFERENCES `system_sub_modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Workflows_Triggers` FOREIGN KEY (`TriggerId`) REFERENCES `triggers` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `workflowsteps`
--
ALTER TABLE `workflowsteps`
  ADD CONSTRAINT `FK_WorkflowSteps_WorkflowStepStates` FOREIGN KEY (`WorkflowStepStateId`) REFERENCES `workflowstepstates` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_WorkflowSteps_WorkflowStepTypes` FOREIGN KEY (`WorkflowStepTypeId`) REFERENCES `workflowsteptypes` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_WorkflowSteps_Workflows` FOREIGN KEY (`WorkflowId`) REFERENCES `workflows` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `workflowtransitions`
--
ALTER TABLE `workflowtransitions`
  ADD CONSTRAINT `FK_WorkflowTransitions_WorkflowSteps` FOREIGN KEY (`SourceWorkflowStepId`) REFERENCES `workflowsteps` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_WorkflowTransitions_WorkflowSteps1` FOREIGN KEY (`TargetWorkflowStepId`) REFERENCES `workflowsteps` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_WorkflowTransitions_Workflows` FOREIGN KEY (`WorkflowId`) REFERENCES `workflows` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

#--12/12/18
ALTER TABLE `timelines` DROP FOREIGN KEY `FK_Timelines_TimelineEventTypes`;
ALTER TABLE `timelines` DROP INDEX `FK_Timelines_TimelineEventTypes`;

ALTER TABLE `day_time_group_time_period` DROP FOREIGN KEY `FK_TimeGroupDays_Days`;
ALTER TABLE `day_time_group_time_period` DROP INDEX `FK_TimeGroupDays_Days`;

ALTER TABLE `course_employee` DROP FOREIGN KEY `FK_CourseParticipants_CourseParticipantStatuses`;
ALTER TABLE `course_employee` DROP INDEX `FK_CourseParticipants_CourseParticipantStatuses` ;

ALTER TABLE `module_questions` DROP FOREIGN KEY `FK_ModuleQuestions_ModuleQuestionTypes`;
ALTER TABLE `module_questions` DROP INDEX `FK_ModuleQuestions_ModuleQuestionTypes` ;

ALTER TABLE `surveys` DROP FOREIGN KEY `FK_Surveys_SurveyStatuses`;
ALTER TABLE `surveys` DROP INDEX `FK_Surveys_SurveyStatuses` ;

ALTER TABLE `survey_responses` DROP FOREIGN KEY `FK_SurveyResponses_ShamUsers`;
ALTER TABLE `survey_responses`DROP INDEX `FK_SurveyResponses_ShamUsers` ;

ALTER TABLE `disabilities` CHANGE `is_system_predefined` `is_system_predefined` TINYINT(1) NULL DEFAULT '0';
ALTER TABLE `disability_categories` CHANGE `is_system_predefined` `is_system_predefined` TINYINT(1) NULL DEFAULT '0';

--
-- Constraints for table `disability_employee`
--
ALTER TABLE `disability_employee` DROP INDEX IX_EMPLOYEE_DISABILITY;
ALTER TABLE `disability_employee`
  ADD CONSTRAINT `FK_DisabilityEmployee_Employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_DisabilityEmployee_Disabilities` FOREIGN KEY (`disability_id`) REFERENCES `disabilities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

UPDATE `system_sub_modules` SET `description` = 'Employees' WHERE (`id` = '1');
UPDATE `system_sub_modules` SET `description` = 'Assets Allocation' WHERE (`id` = '6');
UPDATE `system_sub_modules` SET `description` = 'Organisation Charts' WHERE (`id` = '7');
UPDATE `system_sub_modules` SET `description` = 'Compliance' WHERE (`id` = '11');
UPDATE `system_sub_modules` SET `deleted_at` = '2018-11-29 11:11:38' WHERE (`id` = '15');
UPDATE `system_sub_modules` SET `description` = 'My Portal' WHERE (`id` = '16');
UPDATE `system_sub_modules` SET `description` = 'My Details' WHERE (`id` = '17');
UPDATE `system_sub_modules` SET `description` = 'My E-learning' WHERE (`id` = '20');
UPDATE `system_sub_modules` SET `description` = 'My Surveys' WHERE (`id` = '21');
UPDATE `system_sub_modules` SET `is_active` = '0' WHERE (`id` = '87');
UPDATE `system_sub_modules` SET `is_active` = '0' WHERE (`id` = '9');
UPDATE `system_sub_modules` SET `deleted_at` = '2018-11-29 11:11:38' WHERE (`id` = '87');

ALTER TABLE `contract_recruitment`
	ADD COLUMN `master_copy` MEDIUMBLOB NULL DEFAULT NULL AFTER `contract_id`;

ALTER TABLE `offer_recruitment`
	ADD COLUMN `master_copy` MEDIUMBLOB NULL DEFAULT NULL AFTER `offer_id`;

ALTER TABLE `offer_recruitment`
	ADD COLUMN `starting_on` DATE NULL AFTER `master_copy`,
	CHANGE COLUMN `signed_on` `signed_on` DATE NULL DEFAULT NULL AFTER `starting_on`;

ALTER TABLE `contract_recruitment`
	CHANGE COLUMN `signed_on` `signed_on` DATE NULL DEFAULT NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
SET GLOBAL FOREIGN_KEY_CHECKS = 1;

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
