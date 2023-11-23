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
  `invoiceID` varchar(255) DEFAULT NULL,
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
INSERT INTO `activities` VALUES (1,5,'Roanoke POS','XKC12T2AX5KM8',10.00,'2023-10-26','clover','EX2K100AS0KF6','2023-10-25 23:53:47','2023-10-25 23:53:47'),(2,5,'Roanoke POS','99FB0R45NDQTT',10.00,'2023-11-08','clover','EX2K100AS0KF6','2023-11-07 23:54:03','2023-11-07 23:54:03'),(3,5,'Roanoke POS','QQQ05PH558CDT',10.00,'2023-11-09','clover','EX2K100AS0KF6','2023-11-08 23:54:03','2023-11-08 23:54:03'),(4,5,'Lessons','Test order',10.00,'2023-10-26','admin','EX2K100AS0KF6','2023-11-08 23:54:03','2023-11-08 23:54:03');
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
  `orderID` varchar(255) NOT NULL COMMENT 'detail in activities table',
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
INSERT INTO `activity_items` VALUES (1,'XKC12T2AX5KM8','Item 1',10.00,'2023-11-17 23:55:13','2023-11-17 23:55:13'),(2,'99FB0R45NDQTT','Item 1',10.00,'2023-11-17 23:55:13','2023-11-17 23:55:13'),(3,'QQQ05PH558CDT','Item 1',10.00,'2023-11-17 23:55:13','2023-11-17 23:55:13');
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
INSERT INTO `categories` VALUES (1,'Food & Beverage','2023-11-09 02:07:59','2023-11-09 02:07:59'),(2,'Lessons','2023-11-09 02:08:08','2023-11-09 02:08:08'),(3,'Court Usage','2023-11-09 02:08:18','2023-11-09 02:08:18'),(4,'Rentals','2023-11-09 02:08:23','2023-11-09 02:08:23'),(5,'Merchandise','2023-11-09 02:08:29','2023-11-09 02:08:29');
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
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoiceID` varchar(255) NOT NULL,
  `member_id` bigint(20) NOT NULL,
  `period` varchar(255) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT 0,
  `plan_name` varchar(255) NOT NULL,
  `plan_price` decimal(8,2) NOT NULL,
  `card_type` varchar(11) DEFAULT NULL,
  `card_last4` varchar(4) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoiceid_unique` (`invoiceID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,'EX2K100AS0KF6',5,'October 2023',159.00,1,'Elite Team Membership',119.00,'visa','4242','2023-11-01 00:00:14',NULL,'2023-10-31 23:00:14','2023-10-31 23:00:14');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kitchen_bars`
--

DROP TABLE IF EXISTS `kitchen_bars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kitchen_bars` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `itemID` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `category` varchar(255) NOT NULL,
  `sortOrder` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kitchen_bars`
--

LOCK TABLES `kitchen_bars` WRITE;
/*!40000 ALTER TABLE `kitchen_bars` DISABLE KEYS */;
INSERT INTO `kitchen_bars` VALUES (4,'674HS418672GG','Argiano, Rosso Toscano NC Non Confunditur',9.00,'Wine',9,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(5,'8FV58JC9H7PRC','Charles Woodson, Intercept Red Blend',9.00,'Wine',9,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(6,'MS0NDXV0ATRCJ','FONTE DEI BORGHI CHIANTI (TUSCANY)',8.00,'Wine',9,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(7,'ZKY2T2D1HX2VR','BIXIO CABERNET (MOLISE)',9.00,'Wine',9,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(8,'MD7DYZ8XJXE80','Josh Cellars, Craftman\'s Collection Cabernet Sauvignon',7.00,'Wine',9,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(9,'PZP6ZEKMB7VX8','TORRE ORIENTALE PINOT NOIR (FRIULI)',8.00,'Wine',9,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(10,'15CMV352K2T9A','TORRE ORIENTALE SAUVIGNON (FRIULI)',8.00,'Wine',9,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(11,'BXENRYK1MX8SY','Whitehaven Wines, Sauvigon Blanc Winemaker\'s Selection',7.00,'Wine',9,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(12,'EFQVHY4NP7Q40','SOTTORIVA ANTICA PINOT GRIGIO (MOLISE)',7.00,'Wine',9,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(13,'YZGHPNT84S86P','Josh Cellars, Craftman\'s Collection Chardonnay',7.00,'Wine',9,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(14,'ZCKACC2QBXESC','FRASSINELLI PROSECCO (VENETO)',8.00,'Wine',9,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(15,'CW709RM3RMW10','William Wycliff, Brut',6.00,'Wine',9,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(16,'HJNKYM1C9CAMR','Gold Peak Ice Tea (Bottle)',3.95,'Drinks',2,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(17,'ZRGWDK8BXSGZY','Bottle Water',2.95,'Drinks',2,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(18,'XBT36PEZSFVS4','Bottle Soft Drink',2.95,'Drinks',2,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(19,'E2J8Y5MRVH24J','Fountain Soft Drink',1.95,'Drinks',2,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(20,'AF0M81HNJ4V0P','12 Wings',13.95,'Wings',8,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(21,'W7ZJTP327QQ6G','6 Wings',7.95,'Wings',8,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(22,'NW5HC4KMAA52E','Veggie Supreme White',9.95,'Flatbreads',7,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(23,'KXGNG54A0S5J2','Pepperoni',9.95,'Flatbreads',7,'2023-11-19 20:38:37','2023-11-20 21:40:40'),(24,'MQT42JAV40FME','The Dad Joke \"Cheesy\"',9.95,'Flatbreads',7,'2023-11-19 20:38:37','2023-11-20 21:40:41'),(25,'5Q262RSSGF3MT','Garden Veggie Wrap',7.95,'Sandwiches/Wraps',6,'2023-11-19 20:38:37','2023-11-20 21:40:41'),(26,'ZDFVP7K8184YA','Grilled Chicken Caesar Wrap',9.95,'Sandwiches/Wraps',6,'2023-11-19 20:38:37','2023-11-20 21:40:41'),(27,'FF4NGZM7CR6PM','Grilled Cheese Panini',7.95,'Sandwiches/Wraps',6,'2023-11-19 20:38:37','2023-11-20 21:40:41'),(28,'JBAMB72F2CSJ0','Grilled Chicken Avocado Panini',10.95,'Sandwiches/Wraps',6,'2023-11-19 20:38:37','2023-11-20 21:40:41'),(29,'SA93S8YTJ76ZY','The Bert or Ernie Panini',9.95,'Sandwiches/Wraps',6,'2023-11-19 20:38:37','2023-11-20 21:40:41'),(30,'QVQDZE9EWPQJ8','Caesar Salad',7.95,'Salads',5,'2023-11-19 20:38:37','2023-11-20 21:40:41'),(31,'W0M1V45XAACNP','Mediterranean Salad',7.95,'Salads',5,'2023-11-19 20:38:37','2023-11-20 21:40:41'),(32,'JJ5FY9D1C77TG','Garden Salad',9.95,'Salads',5,'2023-11-19 20:38:37','2023-11-20 21:40:41'),(33,'1RMECT7WKV4X2','Pickle RVA',2.95,'Appetizers',4,'2023-11-19 20:38:37','2023-11-20 21:40:41'),(34,'J1CAECVGFFFB4','Performance Popcorn/Pub Mix',2.95,'Appetizers',4,'2023-11-19 20:38:37','2023-11-20 21:40:41'),(35,'5HKDJNQKR24CA','Charcuterie & Cheese Board',14.95,'Appetizers',4,'2023-11-19 20:38:37','2023-11-20 21:40:41'),(36,'SC7BFQK6YJFGA','Stackin\' Sliders',9.95,'Appetizers',4,'2023-11-19 20:38:37','2023-11-20 21:40:41'),(37,'3YVGFEBZWWNHJ','Giant German Pretzel',9.95,'Appetizers',4,'2023-11-19 20:38:37','2023-11-20 21:40:41'),(38,'8BVM69DPJMSCE','Dink & Dip Trio',10.95,'Appetizers',4,'2023-11-19 20:38:37','2023-11-20 21:40:41');
/*!40000 ALTER TABLE `kitchen_bars` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'Henrico','8641 Quioccasin Rd, Henrico, VA 23229, USA','37.602426','-77.5665023','8045551234','info@ppbrva.com','https://www.ppbrva.com','uploads/locations/t50rbzUfJGmsc0icFVXy9MW7moGxDrOCaH4G9rHH.jpg','2023-10-19 13:31:41','2023-11-09 02:12:54');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_friend`
--

DROP TABLE IF EXISTS `member_friend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member_friend` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `member1_id` bigint(20) NOT NULL,
  `member1_email` tinyint(1) NOT NULL DEFAULT 0,
  `member1_phone` tinyint(1) NOT NULL DEFAULT 0,
  `member2_id` bigint(20) NOT NULL,
  `member2_email` tinyint(1) NOT NULL DEFAULT 0,
  `member2_phone` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('','pending','accepted') NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_friend`
--

LOCK TABLES `member_friend` WRITE;
/*!40000 ALTER TABLE `member_friend` DISABLE KEYS */;
INSERT INTO `member_friend` VALUES (1,1,1,1,2,0,0,'pending','2023-11-19 15:01:36','2023-11-19 15:01:36');
/*!40000 ALTER TABLE `member_friend` ENABLE KEYS */;
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
  `dupr_id` varchar(255) DEFAULT NULL,
  `age` tinyint(4) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `rating` varchar(5) DEFAULT NULL,
  `matches` int(11) DEFAULT NULL,
  `wins` int(11) DEFAULT NULL,
  `losses` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_profiles`
--

LOCK TABLES `member_profiles` WRITE;
/*!40000 ALTER TABLE `member_profiles` DISABLE KEYS */;
INSERT INTO `member_profiles` VALUES (1,1,'5534183476',17,'MALE','3.8',NULL,NULL,NULL,'2023-11-09 14:51:22','2023-11-19 15:06:26'),(2,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-09 14:52:03','2023-11-09 14:52:03'),(3,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-09 14:52:35','2023-11-09 14:52:35'),(4,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-09 14:53:05','2023-11-09 14:53:05'),(5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-17 22:10:50','2023-11-17 22:10:50');
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
  `customerID` varchar(255) NOT NULL,
  `card_last4` varchar(4) DEFAULT NULL,
  `card_type` enum('visa','mc','amex','discover','diners_club','jcb','unknown') NOT NULL DEFAULT 'unknown',
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `members_memberid_unique` (`memberID`),
  UNIQUE KEY `members_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'PPB0001','James Doyle','jim@divstrong.com','$2y$10$UUUB/M92ecT6pCjEITxqgO5ipHC/MU2YOf3hUgzndHy9IF3GaW4ky',NULL,'8043159609',1,3,'uploads/avatars/B9o756bcULG48RQ5ftTTEqD9qB9aHzdcr1BU0vjj.png','9ZK6H70NFTAGY','4242','visa',1,'2023-11-09 14:51:22','2023-11-09 14:56:51',NULL),(2,'PPB0002','Jon Laaser','laaser2@yahoo.com','$2y$10$z0p1sdLkatHgw8XuacYiMenr3IWs3ShRur53c3eAJk00/XL2OaJea','S6RCaQ9a','8045551234',1,1,NULL,'3XFVW34X3F2MA',NULL,'unknown',1,'2023-11-09 14:52:03','2023-11-09 14:52:03',NULL),(3,'PPB0003','Steve Feher','sfeher@ridgefieldgroup.com','$2y$10$eKkxMEzSxZE57lo/wXQpxOl5IFmDqF041BCbatulrWn.p/7v0fGaS',NULL,'8045551234',1,2,NULL,'PNAY26R78P1TE',NULL,'unknown',1,'2023-11-09 14:52:35','2023-11-21 03:20:51',NULL),(4,'PPB0004','Jacob Hollingsworth','jacobhollingsworth@journeybizsolutions.com','$2y$10$Hqp2fYd0aI6dbwCgip7Us.dEHN/dqmiYZM0OkPB3OhCRuI/RCUf0.',NULL,'8045551234',1,4,NULL,'J8018S1JA5VW4',NULL,'unknown',1,'2023-11-09 14:53:05','2023-11-09 15:40:19',NULL),(5,'PPB0005','Rose','rosecontee@outlook.com','$2y$10$yz3NFfEpAxkdstUKxS/7KeWiz86lHx.DoCc5aGEobmXDp7p7ANguO',NULL,NULL,1,5,NULL,'S8BPR1Y3X4WTW','4242','visa',1,'2023-11-17 22:10:50','2023-11-18 00:24:02',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_10_13_140506_create_locations_table',1),(6,'2023_10_14_091114_create_members_table',1),(7,'2023_10_14_094721_create_plans_table',1),(8,'2023_10_15_040236_create_roles_table',1),(9,'2023_10_17_002702_create_member_profiles_table',1),(10,'2023_10_19_123019_create_member_password_reset_codes_table',1),(11,'2023_10_31_213424_create_categories_table',2),(12,'2023_10_31_223522_create_appicons_table',2),(13,'2023_11_05_211615_create_activities_table',2),(14,'2023_11_07_113259_create_activity_items_table',2),(15,'2023_11_07_114003_create_invoices_table',2),(16,'2023_11_13_032616_create_kitchen_bars_table',3),(17,'2023_11_13_043048_create_member_friend_table',3),(18,'2023_11_22_230757_create_settings_table',4);
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\Member',3,'QC_Reference_Phone-billing@divstrong.com','5ce51b7a46c6ef644a6f1573b0e7df3e66762fafacc79d17073f1aa6325752ad','[\"*\"]','2023-10-20 01:08:39',NULL,'2023-10-20 01:07:32','2023-10-20 01:08:39'),(2,'App\\Models\\Member',3,'iPhone11,2-billing@divstrong.com','3737e93435e551bf1f87c0655bfbe8d2b7bede13380ba23c6ad1fd8ac49501f2','[\"*\"]','2023-10-24 15:05:58',NULL,'2023-10-23 16:36:13','2023-10-24 15:05:58'),(4,'App\\Models\\Member',5,'iPhone14,5-Jacobhollingsworth@journeybizsolutions.com','6c5a26a15bc9d6aed4457d2f57de73f28e6578f7ad2fcfbdc5b7b790c573e5d2','[\"*\"]','2023-10-24 18:00:37',NULL,'2023-10-24 18:00:17','2023-10-24 18:00:37'),(5,'App\\Models\\Member',4,'iPhone16,1-Laaser2@yahoo.com','aca5eb1698894a8d4ac4dad11a385243778c1f857555c48a2ce5e46badc895c7','[\"*\"]','2023-11-18 12:24:54',NULL,'2023-10-25 19:27:55','2023-11-18 12:24:54'),(7,'App\\Models\\Member',6,'taro-Sfeher@ridgefieldgroup.com','936926fdc8ee0ad6cf402d2d5677b5d01c5b6c4bc6b44472bb5f1c91d3462bb5','[\"*\"]',NULL,NULL,'2023-11-02 12:07:35','2023-11-02 12:07:35'),(8,'App\\Models\\Member',1,'iPhone15,4-jim@divstrong.com','416d5db93b6e3a4c21c36a92ca9940d6036b31967520ff69af37057f9c2bf695','[\"*\"]','2023-11-20 18:03:36',NULL,'2023-11-09 14:54:02','2023-11-20 18:03:36'),(9,'App\\Models\\Member',3,'taro-Sfeher@ridgefieldgroup.com','d87af3a94702155b71df09a246dcf1e9321f4153ac8734a794f6e207cc270d6d','[\"*\"]','2023-11-10 13:23:44',NULL,'2023-11-09 16:32:37','2023-11-10 13:23:44'),(12,'App\\Models\\Member',5,'iPhone15,3-Rosecontee@outlook.com','8e4271c2855cb05ecc0ba771a14aa63be21f612e51e37b81e9d06d53b68bfbfe','[\"*\"]','2023-11-17 23:28:10',NULL,'2023-11-17 22:25:35','2023-11-17 23:28:10'),(13,'App\\Models\\Member',5,'sm6150-Rosecontee@outlook.com','1cc5b23213e1d48eb0471385bdab79e14c9530860f19321095285cf98b5c5bd1','[\"*\"]','2023-11-17 23:28:58',NULL,'2023-11-17 22:38:30','2023-11-17 23:28:58'),(14,'App\\Models\\Member',5,'sm6150-Rosecontee@outlook.com','096eb591a682873bf6e36f71eb6eb9ba7f8a841d7bf3fe65b5f31118635f174b','[\"*\"]','2023-11-20 23:42:31',NULL,'2023-11-18 00:20:14','2023-11-20 23:42:31'),(15,'App\\Models\\Member',3,'taro-Sfeher@ridgefieldgroup.com','5f9558f53755ab74f07793b7f64122352006950c9cefe10cc03ed772f66f46aa','[\"*\"]','2023-11-21 03:23:15',NULL,'2023-11-21 03:21:08','2023-11-21 03:23:15'),(16,'App\\Models\\Member',5,'sm6150-Rosecontee@outlook.com','475785d17d266ba61d5e4ccdd30560c3faf6a9a149147c883b6e1cbc9f42788b','[\"*\"]','2023-11-22 22:56:41',NULL,'2023-11-22 21:23:20','2023-11-22 22:56:41'),(17,'App\\Models\\Member',5,'sm6150-Rosecontee@outlook.com','ea59b5f9d748be32dde2d2b709d9e99aac69ead1d68d5ae40f7e1f1059a48039','[\"*\"]','2023-11-23 00:01:28',NULL,'2023-11-22 23:56:48','2023-11-23 00:01:28');
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
INSERT INTO `plans` VALUES (1,'Elite Team Membership',119.00,'monthly','2023-10-19 14:47:29','2023-10-19 14:47:29'),(2,'Performance Team Membership',49.00,'monthly','2023-10-19 14:47:48','2023-10-19 14:47:48'),(3,'Corporate Membership',99.00,'monthly','2023-10-19 14:48:03','2023-10-19 14:48:03'),(4,'Morning Crew PBJ Membership',49.00,'monthly','2023-10-19 14:48:18','2023-10-19 14:48:18'),(5,'Student Membership',39.00,'monthly','2023-10-19 14:48:33','2023-10-19 14:48:33');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','1,2,3,4,5,6,7','2023-10-18 22:54:54','2023-10-18 22:54:54');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'play_link','https://app.pingpod.com/','2023-11-22 23:53:44','2023-11-22 23:53:44'),(2,'improve_link','https://app.pingpod.com/','2023-11-22 23:53:44','2023-11-22 23:53:44'),(3,'rent_link','https://app.pingpod.com/','2023-11-22 23:53:44','2023-11-22 23:53:44'),(4,'shop_link','https://ppbrva.com/shop/','2023-11-22 23:53:44','2023-11-22 23:53:44'),(5,'dupr_link','https://ppbrva.com/dupr','2023-11-22 22:37:22','2023-11-22 22:37:22');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Jim Doyle','jim@divstrong.com','2023-10-18 22:54:54','$2y$10$ApVug.AwnhLz6r2TmdoeT.w9f5wOdtvaNKrpeP853FqsG2zf7LIeG','8043159609','2023-11-20 18:19:00',1,1,'edzeUsGsRGnBra8hDV1zqVozXB1kGRSKFwWLHEK3sTEEMnRfHUv0Kxepwbvh','2023-10-18 22:54:54','2023-11-20 18:19:00'),(2,'Jon Laaser','jon@ppbrva.com',NULL,'$2y$10$e5fJihXELdtPw1.XLXchTucNfRMJxVvuSzziM4ubu8FyTE3pJ8Bta','8045551234','2023-10-19 21:18:17',1,1,'YQBalxDpYT1LvJ2XqAP8RlMhG9Q8QwKSQnDcYnkyQYld4kvUI3a6LS4wYyCo','2023-10-19 16:12:56','2023-10-19 21:18:17'),(3,'Dev','support@divstrong.com',NULL,'$2y$10$sQ2M0Q67unZV37CMS.gmqes/4qHBHvUdVfy0pdUFqoyu33OerKTAO',NULL,'2023-11-22 23:45:06',1,1,NULL,'2023-11-09 02:09:35','2023-11-22 23:45:06'),(4,'snipe','snipe1205@hotmail.com',NULL,'$2y$10$vkIVSJi.hDC8E9FWyToesu6Y/dBWH7ZgxaOzNfIl/la4tuDZSaIsO',NULL,NULL,1,1,NULL,'2023-11-09 02:09:57','2023-11-09 02:09:57');
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

-- Dump completed on 2023-11-23  1:54:39
