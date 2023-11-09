-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: ppbrva
-- ------------------------------------------------------
-- Server version	10.4.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) NOT NULL,
  `category` varchar(255) NOT NULL COMMENT '[location] + POS from clover / Category from admin',
  `detail` varchar(255) NOT NULL COMMENT 'order ID from clover / Detail from admin',
  `price` decimal(8,2) NOT NULL,
  `date` date NOT NULL,
  `from` enum('clover','admin') NOT NULL DEFAULT 'clover',
  `invoice_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
INSERT INTO `activities` VALUES (1,1,'Roanoke POS','XKC12T2AX5KM8',10.00,'2023-10-26','clover',NULL,'2023-11-07 22:42:01','2023-11-07 22:42:01'),(2,1,'Roanoke POS','99FB0R45NDQTT',10.00,'2023-10-26','clover',NULL,'2023-11-07 22:42:01','2023-11-07 22:42:01'),(3,1,'Roanoke POS','QQQ05PH558CDT',10.00,'2023-10-26','clover',NULL,'2023-11-07 22:42:02','2023-11-07 22:42:02'),(4,1,'Lessons','Test order',10.00,'2023-10-26','admin',NULL,'2023-11-08 20:12:58','2023-11-08 22:42:21');
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_items`
--

DROP TABLE IF EXISTS `activity_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) NOT NULL COMMENT 'detail in activities table',
  `name` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_items`
--

LOCK TABLES `activity_items` WRITE;
/*!40000 ALTER TABLE `activity_items` DISABLE KEYS */;
INSERT INTO `activity_items` VALUES (1,'XKC12T2AX5KM8','Item 1',10.00,'2023-11-07 22:42:01','2023-11-07 22:42:01'),(2,'99FB0R45NDQTT','Item 1',10.00,'2023-11-07 22:42:01','2023-11-07 22:42:01'),(3,'QQQ05PH558CDT','Item 1',10.00,'2023-11-07 22:42:02','2023-11-07 22:42:02');
/*!40000 ALTER TABLE `activity_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appicons`
--

DROP TABLE IF EXISTS `appicons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appicons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appicons`
--

LOCK TABLES `appicons` WRITE;
/*!40000 ALTER TABLE `appicons` DISABLE KEYS */;
/*!40000 ALTER TABLE `appicons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Food & Beverage','2023-10-31 22:02:03','2023-10-31 22:02:03'),(2,'Lessons','2023-10-31 22:02:03','2023-10-31 22:02:03'),(3,'Court Usage','2023-10-31 22:02:03','2023-10-31 22:02:03'),(4,'Rentals','2023-10-31 22:02:03','2023-10-31 22:02:03'),(5,'Merchandise','2023-10-31 22:02:03','2023-10-31 22:02:03');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` varchar(255) NOT NULL,
  `member_id` bigint(20) NOT NULL,
  `period` varchar(255) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT 0,
  `plan_name` varchar(255) DEFAULT NULL,
  `plan_price` decimal(8,2) DEFAULT NULL,
  `card_type` varchar(11) DEFAULT NULL,
  `card_last4` varchar(4) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'Roanoke','Roanoke St, Woodbridge, VA 22191, USA','38.6480167','-77.2689913','(804) 555-1234','admin@admin.com','https://www.ppbrva.com/website','uploads/locations/ZnAfQfAe6TqC5zO8aPw4lH9IEp18jfCfMS1qsdFJ.jpg','2023-10-17 09:02:00','2023-11-01 22:41:55'),(2,'Richmond','8641 Quioccasin Rd, Henrico, VA 23229, USA','37.602605','-77.5661845','(804) 555-1234','crafter58@gmail.com','https://www.ppbrva.com/website','uploads/locations/SM528UZxWgZe3jhs8vInBQradYPfiL9yrOhSzSfi.jpg','2023-10-17 09:02:24','2023-11-01 22:42:16');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_password_reset_codes`
--

DROP TABLE IF EXISTS `member_password_reset_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member_password_reset_codes` (
  `email` varchar(255) NOT NULL,
  `code` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_password_reset_codes`
--

LOCK TABLES `member_password_reset_codes` WRITE;
/*!40000 ALTER TABLE `member_password_reset_codes` DISABLE KEYS */;
INSERT INTO `member_password_reset_codes` VALUES ('rosecontee@outlook.com','482888','2023-10-25 18:23:36');
/*!40000 ALTER TABLE `member_password_reset_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_profiles`
--

DROP TABLE IF EXISTS `member_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member_profiles` (
  `member_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `share_age_gender` tinyint(1) NOT NULL DEFAULT 1,
  `age` tinyint(4) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `rating` varchar(5) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_profiles`
--

LOCK TABLES `member_profiles` WRITE;
/*!40000 ALTER TABLE `member_profiles` DISABLE KEYS */;
INSERT INTO `member_profiles` VALUES (1,1,NULL,NULL,NULL,NULL,NULL,'2023-10-17 09:33:06','2023-11-08 15:16:02');
/*!40000 ALTER TABLE `member_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `memberID` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `original_pass` varchar(8) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `location_id` bigint(20) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) NOT NULL,
  `card_last4` varchar(4) DEFAULT NULL,
  `card_type` enum('visa','mc','amex','discover','diners_club','jcb','unknown') NOT NULL DEFAULT 'unknown',
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `members_memberid_unique` (`memberID`),
  UNIQUE KEY `members_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'PPB0001','Rose Contee','rosecontee@outlook.com','$2y$10$xpdCnkp3/4xC21DFev7uUOwBipTE.EgJtCbWQU3ju8gNsQ663AnyG','QwOCZQ0H','(804) 555-1234',2,1,'uploads/avatars/mzuG0KQbuyFYr0hSC3IObJszG1q5DIDAZ0L56u8H.jpg','6QN4Z3REB9RP0','4242','visa',1,'2023-11-08 16:25:14','2023-11-08 16:26:30',NULL);
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_10_13_140506_create_locations_table',1),(6,'2023_10_14_091114_create_members_table',1),(7,'2023_10_14_094721_create_plans_table',1),(8,'2023_10_15_040236_create_roles_table',1),(9,'2023_10_17_002702_create_member_profiles_table',1),(10,'2023_10_19_123019_create_member_password_reset_codes_table',1),(11,'2023_10_31_213424_create_categories_table',2),(12,'2023_10_31_223522_create_appicons_table',2),(13,'2023_11_05_211615_create_activities_table',2),(14,'2023_11_07_113259_create_activity_items_table',2),(15,'2023_11_07_114003_create_invoices_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES ('dianaali0608@outlook.com','$2y$10$74JmQni/BqQtunVOuAWIX.nVzvOXt1qAxkM6CIUK7nc.aF2Hfs63O','2023-10-17 10:09:40'),('rosecontee@outlook.com','$2y$10$9lYXd6NWZWFy29wAo/FTWuqJErgtph9gp9neNmJEKC3NxcbDtwCVa','2023-10-19 19:55:48');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\Member',1,'universal8895-rosecontee@outlook.com','eaa7353eaad9baa4edbe7b1263b1c015cc06edce198e1d2e4a532b105dc7f6bd','[\"*\"]',NULL,NULL,'2023-10-24 16:18:27','2023-10-24 16:18:27'),(7,'App\\Models\\Member',1,'universal8895-rosecontee@outlook.com','6f8d7bd2c585075e06864bcdb0ed181ceddf14e2646ad2245976ab370951723e','[\"*\"]','2023-10-25 14:46:06',NULL,'2023-10-24 20:59:31','2023-10-25 14:46:06'),(13,'App\\Models\\Member',1,'universal8895-rosecontee@outlook.com','bd094c0ff5812ec44d4fdb196f52b663310aac380020fb9ce17a7f104c36ec74','[\"*\"]','2023-10-26 14:10:50',NULL,'2023-10-26 00:51:53','2023-10-26 14:10:50'),(17,'App\\Models\\Member',1,'universal8895-rosecontee@outlook.com','e5b1a3564b893240a0ab17e9908d5d289a27011449c8485938262d1e9eaf1084','[\"*\"]','2023-11-02 18:52:47',NULL,'2023-10-30 12:45:33','2023-11-02 18:52:47'),(18,'App\\Models\\Member',1,'test','f4f2849fd1fc70212045ea7332bbae1a25b3897d7be7103905274f8f44b4948a','[\"*\"]','2023-11-08 16:46:38',NULL,'2023-10-31 00:39:35','2023-11-08 16:46:38');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `period` varchar(255) NOT NULL DEFAULT 'monthly',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES (1,'Elite Team Membership',119.00,'monthly','2023-10-17 09:02:51','2023-10-17 09:02:51'),(2,'Performance Team Membership',49.00,'monthly','2023-10-17 09:03:04','2023-10-17 09:03:04'),(3,'Corporate Membership',99.00,'monthly','2023-10-17 09:03:15','2023-10-17 09:03:15'),(4,'Morning Crew PBJ Membership',49.00,'monthly','2023-10-17 09:03:25','2023-10-17 09:03:25'),(5,'Student Membership',39.00,'monthly','2023-10-17 09:03:39','2023-10-17 09:03:39');
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `permissions` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','1,2,3,4,5,6,7','2023-10-17 08:56:55','2023-10-17 08:56:55'),(2,'Manager','3,4,5','2023-10-17 09:03:59','2023-10-17 09:03:59'),(3,'Staff','3','2023-10-17 09:04:11','2023-10-17 09:04:11');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `active` tinyint(1) DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Jim Doyle','rosecontee@outlook.com','2023-10-17 08:56:55','$2y$10$5DHr0bvyunMmf5xplmKDXeDoCAiN/OCaMco082GoZNnY5IODt9.ae',NULL,'2023-11-08 10:50:38',1,1,'5VLZwkT6lCpvY7biNS5VNLP9kvvT9jX2HWFJ8fJpgt477cdMRtI0H2QhT7ZG','2023-10-17 08:56:55','2023-11-08 10:50:38');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-09  2:35:38
