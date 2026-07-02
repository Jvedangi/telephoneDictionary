# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 172.18.157.233 (MySQL 5.5.5-10.11.7-MariaDB-1:10.11.7+maria~ubu2204-log)
# Database: telephone_dictionary
# Generation Time: 2026-07-02 08:58:05 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table activity_logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `activity_logs`;

CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) unsigned DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  KEY `activity_logs_action_index` (`action`),
  KEY `activity_logs_model_type_model_id_index` (`model_type`,`model_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table cache
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;

INSERT INTO `cache` (`key`, `value`, `expiration`)
VALUES
	('laravel-cache-admin@email.com|127.0.0.1','i:1;',1782887979),
	('laravel-cache-admin@email.com|127.0.0.1:timer','i:1782887979;',1782887979);

/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cache_locks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table contact_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contact_groups`;

CREATE TABLE `contact_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_groups_user_id_foreign` (`user_id`),
  CONSTRAINT `contact_groups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `contact_groups` WRITE;
/*!40000 ALTER TABLE `contact_groups` DISABLE KEYS */;

INSERT INTO `contact_groups` (`id`, `user_id`, `group_name`, `description`, `created_at`, `updated_at`)
VALUES
	(1,1,'Default','Automatically created for imports','2026-03-10 10:26:15','2026-03-10 10:26:15');

/*!40000 ALTER TABLE `contact_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `group_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `alternate_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `favorite` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contacts_user_id_foreign` (`user_id`),
  KEY `contacts_group_id_foreign` (`group_id`),
  CONSTRAINT `contacts_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `contact_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;

INSERT INTO `contacts` (`id`, `user_id`, `group_id`, `name`, `phone_number`, `alternate_number`, `email`, `company`, `address`, `notes`, `favorite`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'harshalij','9087654321','9876755549','harshalij@softcell.com',NULL,NULL,NULL,1,'2026-03-10 10:26:40','2026-03-12 06:36:23'),
	(2,1,1,'Nikita Thamme','9876543216',NULL,'nikkit@gmail.com',NULL,'Sion. Mumbai',NULL,0,'2026-03-12 11:37:09','2026-03-12 11:37:09');

/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table departments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_name_unique` (`name`),
  UNIQUE KEY `departments_code_unique` (`code`),
  KEY `departments_name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table employees
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `department_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_email_unique` (`email`),
  KEY `employees_name_index` (`name`),
  KEY `employees_email_index` (`email`),
  KEY `employees_department_id_index` (`department_id`),
  CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table job_batches
# ------------------------------------------------------------

DROP TABLE IF EXISTS `job_batches`;

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'0001_01_01_000000_create_users_table',1),
	(4,'2026_03_10_090444_create_contact_groups_table',1),
	(5,'2026_03_10_090446_create_contacts_table',1),
	(6,'2026_03_17_060756_create_test_case_results_table',2),
	(13,'0001_01_01_000001_create_cache_table',3),
	(14,'0001_01_01_000002_create_jobs_table',3),
	(15,'2026_04_08_115148_create_roles_table',3),
	(16,'2026_04_08_115149_add_role_id_to_users_table',3),
	(17,'2026_04_08_115802_create_departments_table',3),
	(18,'2026_04_08_115802_create_employees_table',3),
	(19,'2026_04_08_115802_create_visitors_table',3),
	(20,'2026_04_08_115802_create_visits_table',3),
	(21,'2026_04_08_121741_add_is_blacklisted_to_visitors_table',3),
	(22,'2026_04_08_121825_create_activity_logs_table',4),
	(23,'2026_04_08_121936_make_check_in_nullable_in_visits_table',5);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_reset_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`)
VALUES
	('36UneZyUCMIkLm0wPs8OHP8ex4fnQhTjlKVN7zuY',1,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:152.0) Gecko/20100101 Firefox/152.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoid1ViWXBCTGh0MmNGRXpWYkdzODZrRkZwdmFRZWlLYlVCVDdmYVpOciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1782888081),
	('ptGYJhABjYAuhHarghx6BpKGdSGBHgrNv1Yinm3J',1,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.7.27 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOTlNM29hZ29oWFU3TXB3TXY0YkVBZFdoTGhYMG5Qa2J5NFF2VTZKaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1782887900);

/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table test_case_results
# ------------------------------------------------------------

DROP TABLE IF EXISTS `test_case_results`;

CREATE TABLE `test_case_results` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `test_case_id` varchar(255) NOT NULL,
  `test_name` varchar(255) NOT NULL,
  `expected_result` text NOT NULL,
  `actual_result` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `executed_by` varchar(255) NOT NULL,
  `executed_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,NULL,'Vedangi Jadhav','vedangij@softcell.com',NULL,'$2y$12$Y4.0LRexFYv9W8CkEkiNK.ODJTQE51SVZKrq/JvNHIeye3pQ5fteq','HeVls8ggVAPSYnvPs6BOJ4nUr53lRyhhMvz4WOxlJWWSM8UJlmW6vDY7BaMg','2026-03-10 09:38:16','2026-07-01 06:34:47'),
	(2,NULL,'Test User','test@example.com','2026-04-08 11:53:54','$2y$12$IBZdlrRtU9yo00Gg7wD9JOc91hRkUIp6xtNNMQ85fFGx8uJuW4mie','bavw7wEYnf','2026-04-08 11:53:54','2026-04-08 11:53:54');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table visitors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `visitors`;

CREATE TABLE `visitors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `id_proof` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `is_blacklisted` tinyint(1) NOT NULL DEFAULT 0,
  `blacklist_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `visitors_email_unique` (`email`),
  KEY `visitors_name_index` (`name`),
  KEY `visitors_email_index` (`email`),
  KEY `visitors_mobile_index` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table visits
# ------------------------------------------------------------

DROP TABLE IF EXISTS `visits`;

CREATE TABLE `visits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `visitor_id` bigint(20) unsigned NOT NULL,
  `employee_id` bigint(20) unsigned NOT NULL,
  `purpose` text NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pre_registered',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visits_visitor_id_index` (`visitor_id`),
  KEY `visits_employee_id_index` (`employee_id`),
  KEY `visits_check_in_index` (`check_in`),
  KEY `visits_status_index` (`status`),
  CONSTRAINT `visits_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `visits_visitor_id_foreign` FOREIGN KEY (`visitor_id`) REFERENCES `visitors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
