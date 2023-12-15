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
) ENGINE=InnoDB AUTO_INCREMENT=277 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kitchen_bars`
--

LOCK TABLES `kitchen_bars` WRITE;
/*!40000 ALTER TABLE `kitchen_bars` DISABLE KEYS */;
INSERT INTO `kitchen_bars` VALUES (39,'QB79BHRPFNMMM','Coffee 16 oz',3.00,'',0,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(40,'584NDBVGD9SZ0','Coffee 12 oz',2.50,'',0,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(41,'CGB1TD67X9EH2','Ben Johns Perseus CFS 16x',249.95,'',0,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(42,'9YY3YWCVQAG5E','Cans',0.00,'Beer',2,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(43,'SNW0M978C42CR','Draft',0.00,'Beer',2,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(44,'64AEE864NYBR2','Women\'s Tank Tops Royal Blue/White XXL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(45,'WWNS1JZQHW104','Women\'s Tank Tops Navy Blue/White XXL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(46,'48YTMTKTKMHWY','Women\'s Tank Tops Solid Navy Blue XXL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(47,'2F0MK2400GVA4','Women\'s Tank Tops Royal Blue/White XL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(48,'DS9DYTERC3WHW','Women\'s Tank Tops Navy Blue/White XL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(49,'HT6JWBC483XPM','Women\'s Tank Tops Solid Navy Blue XL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(50,'G9WQ86P4Q2YVG','Women\'s Tank Tops Royal Blue/White Large',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(51,'3ETRKXEYSGB0M','Women\'s Tank Tops Navy Blue/White Large',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(52,'QKDA1XDTWHGH2','Women\'s Tank Tops Solid Navy Blue Large',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(53,'M6AHZB22HH936','Women\'s Tank Tops Royal Blue/White Medium',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(54,'487ZXASK23FPR','Women\'s Tank Tops Navy Blue/White Medium',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(55,'N4YBSC5NH7K7Y','Women\'s Tank Tops Solid Navy Blue Medium',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(56,'5STFA9EM2XKVR','Women\'s Tank Tops Royal Blue/White Small',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(57,'42BCDGCSRS2HA','Women\'s Tank Tops Navy Blue/White Small',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(58,'WPQQESQ5M74W2','Women\'s Tank Tops Solid Navy Blue Small',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(59,'TTDEQ856ZD3ME','Women\'s Tank Tops Royal Blue/White XSM',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(60,'2JKGP0CTN147T','Women\'s Tank Tops Navy Blue/White XSM',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(61,'98QYPABS0CN0C','Women\'s Tank Tops Solid Navy Blue XSM',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(62,'X3YDYR7EA2YNA','Skorts White XXL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(63,'BJFXEVF67MKMA','Skorts White XL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(64,'37WFV6R06W4VG','Skorts White Large',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(65,'JJDDY7AYH9DDP','Skorts White Medium',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(66,'7ABVVYBVDGKVW','Skorts White Small',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(67,'ZSHT7V0MMGM8R','Skorts White XSM',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(68,'3FKXAZ3NK48TE','Skorts Royal Blue XXL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(69,'60V2Y5WTATZTJ','Skorts Royal Blue XL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(70,'VNRG0MKGKNWST','Skorts Royal Blue Large',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(71,'7F2GEQP5EDY98','Skorts Royal Blue Medium',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(72,'JYJP8758V8BNT','Skorts Royal Blue Small',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(73,'KN08QFS0E3SST','Skorts Royal Blue XSM',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(74,'6RHJ05GW7PCNE','Skorts Navy Blue XXL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(75,'GDX06JKZAZJPG','Skorts Navy Blue XL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(76,'Q9PH5XXK957RE','Skorts Navy Blue Large',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(77,'XS75Y3XSW0M4J','Skorts Navy Blue Medium',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(78,'A10D3EEZ5JME0','Skorts Navy Blue Small',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(79,'HQA6CMG5V2AJP','Skorts Navy Blue XSM',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(80,'1WSYQXET04V0R','Vulcan V930 Emerald',229.99,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(81,'BFFZXEDBYCJX0','Vulcan Water Bottle White',39.99,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(82,'BVP6Y4X0S1M3A','Halo Power XL',139.99,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(83,'031QT7EX928TE','Bloody Mary',9.00,'Alcohol',0,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(84,'14ABXQ8ECZYQ6','Mimosa',8.00,'Alcohol',0,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(85,'3GD2VZCFQT2NG','Tour Elite Pickleball Duffle Bag Black/Light Blue',109.95,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(86,'GYANN1C65KABW','Tour Elite Pro Pickleball Duffle Bag Black/Light Blue',139.95,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(87,'J8YXM0JYTG3ZC','Ben Johns Perseus CFS 16',249.95,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(88,'9SB8S77DXSY0A','Joola Water Bottle  Lavendar 40 oz',39.95,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(89,'AWX7VETN0HK1R','Performance Navy Qt Zip  XXXL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(90,'NQF9PXWZZ9S0C','Performance Navy Qt Zip  XXL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(91,'ASQ7VDNJAXGYT','Performance Navy Qt Zip  XL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(92,'KAQ9GYQPQD1NP','Performance Navy Qt Zip  Large',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(93,'BBAF8RPTTZ98W','Performance Navy Qt Zip  Medium',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(94,'XJ1QS7WXNSH08','Performance Navy Qt Zip  SM',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(95,'C98WC9YTB0S26','Performance Navy Qt Zip  XS',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(96,'AHZT0618968FT','Performance White Qt Zip XXXL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(97,'QD45FQ29KG0EW','Performance White Qt Zip XXL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(98,'FY6TTBPM35THG','Performance White Qt Zip XL',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(99,'71MPPVY0PYBCE','Performance White Qt Zip Large',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(100,'N0KDG2K2F6XZ4','Performance White Qt Zip Medium',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(101,'20C1WT18DYXKC','Performance White Qt Zip Small',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(102,'1HAFAGKPMJJ8Y','Performance Sweatpants XXL Dark Blue',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(103,'Y4VKYY5JB0ZS4','Performance Sweatpants XL Dark Blue',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(104,'YMN0TC1TSA31C','Performance Sweatpants Large Dark Blue',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(105,'AA1XFVVEVDBG8','Performance Sweatpants Medium Dark Blue',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(106,'P8YP13XE2AKE0','Performance Sweatpants Small Dark Blue',0.00,'Merchandise',7,'2023-12-07 20:50:36','2023-12-07 20:50:36'),(107,'D3GXGQDY4PTPC','Performance Sweatpants XS Dark Blue',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(108,'PAKJTSKNG2JC6','Performance Sweatpants XXL Gray',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(109,'D059H440MFRSY','Performance Sweatpants XL Gray',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(110,'ZR58C9MNE58C8','Performance Sweatpants Large Gray',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(111,'MRKT0N38HTPQE','Performance Sweatpants Medium Gray',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(112,'434R580C04NJW','Performance Sweatpants Small Gray',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(113,'7V1MQ0YAJZSVR','Performance Sweatpants XS Gray',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(114,'2X0SMNKR4CWP4','New Era Blue Hoddie XXXL Dark Blue',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(115,'SGM2BTQXTNJM8','New Era Blue Hoddie XXL Dark Blue',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(116,'BA3FB0V77MPEM','New Era Blue Hoddie XL Dark Blue',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(117,'HJ04HRTAZWZSM','New Era Blue Hoddie Large Dark Blue',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(118,'HMTCGWJ1TJM6M','New Era Blue Hoddie Medium Dark Blue',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(119,'JZJ124WEA4APP','New Era Blue Hoddie SM Dark Blue',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(120,'4TEDWWC4PGSEY','New Era Blue Hoddie XS Dark Blue',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(121,'ZC8879S3SK8DW','New Era Blue Hoddie XXXL Light Blue',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(122,'B7TSTT79EB4CG','New Era Blue Hoddie XXL Light Blue',0.00,'',0,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(123,'95Q4P8SGD2Q00','New Era Blue Hoddie XL Light Blue',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(124,'8GBZ4VYNYQYCG','New Era Blue Hoddie Large Light Blue',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(125,'A1N0B83SNW5WG','New Era Blue Hoddie Medium Light Blue',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(126,'9PQ727BJMH2W0','New Era Blue Hoddie SM Light Blue',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(127,'4HQD5NQS1QE98','New Era Blue Hoddie XS Light Blue',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(128,'EA0DZ43665QNJ','CRBN¹ Control Series 16mm',179.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(129,'GVAV2HJHXGZ0C','CRBN¹ Control Series 14mm',179.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(130,'FX2R96A7EAGNA','CRBN 2X Power Series 16mm',229.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(131,'ZM7C3FKXHE2A2','CRBN 2X Power Series 14mm',229.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(132,'F483S9QEH94Y2','Atlas TITAN Pro',149.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(133,'GDJPJMYZDTWHJ','V940',229.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(134,'QRCE0CN894DBW','V740HT MAX',249.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(135,'2XA57Q7B9GSGA','V730HT MAX',249.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(136,'0RGSSNMTG9Z3E','V720HT MAX',249.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(137,'FG834VBXXGHSY','V710HT MAX',249.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(138,'RAR9SRD2A6W5A','V570 FRP Blackout',149.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(139,'PG7E0XN5M59GY','V570 FRP Whiteout',149.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(140,'53JQ4F50KMMHT','V540 Hybrid',119.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(141,'J1918E498WKKG','V530 Power Black Lazer',99.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(142,'95BYWTAGWT2KA','V530 Power Rainbow Lazer',99.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(143,'XB78H8WSPMY5P','V520 Control Americana',89.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(144,'S5172D5XXJD3C','V520 Control Fire & Ice',89.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(145,'TKV8WXMVJV2WR','V510 Hybrid Cotton Candy',79.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(146,'V2R8BE2PDQZMC','V510 Hybrid Pink Geo',79.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(147,'XQQN7PX7TH0D2','V330 Vulcan Hybrid Paddle Purple Lazer',59.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(148,'X6GB95KXRES2P','V330 Vulcan Hybrid Paddle Lime Lazer',59.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(149,'RHPJJ7RSNHCS4','V310 Rouge Red Youth (2-pack)',27.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(150,'47ATVX5R76RPR','V300 Youth Paddle Fire Stick',49.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(151,'ZN49KB7AJ4B0M','V300 Youth Paddle Glow Stick',49.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(152,'W1A1P0ZMNAZPE','CRBN 3X Power Series 16mm',229.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(153,'Y1MS79Y4VPNZM','CRBN 3X Power Series 14mm',229.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(154,'85Q5K226PBQ9T','CRBN 1X Power Series 16mm',229.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(155,'JEZ1JBZGZ8TDJ','CRBN 1X Power Series 14mm',229.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(156,'SGGVCZB98CTD0','PXVI - Control Freak',169.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(157,'3TQMKR3XR2NNW','PXVamos',179.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(158,'1WHEJZ826CQ1C','PXIV - Spin Doctor',169.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(159,'XEWZWRR4ZMMSE','PXIII 3K Carbon Fiber',159.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(160,'HQKGW1P6JPGEA','PXII - Check Mate',139.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(161,'NXW67Y1JVTAGE','PELLO PXI - The OG',99.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(162,'X0AJ7EQMFEM3T','Collin Johns Scorpeus CFS 16',249.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(163,'F9BT94761F666','Anna Bright Scorpeus CFS 14',249.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(164,'JGQ794H8CWSHW','Ben Johns Perseus CFS 14',249.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(165,'V9E97D0M22VDM','Ben Johns Hyperion CAS 16',199.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(166,'4DMCR67Q6H1N2','Ben Johns Hyperion CAS 13.5',199.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(167,'ZZG1YN3CKQ878','Ben Johns Hyperion CFS 16',219.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(168,'0ZD0NHT20WHN8','Ben Johns Hyperion CFS 14',219.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(169,'1VD258FF2RPZ2','Essentials Performance Paddle Blue',59.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(170,'2NFVM6PB4H44G','Essentials Performance Paddle Black',59.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(171,'8TAD6QMKA1D84','Megaladon Junior Paddle',49.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(172,'P84371SN8D2S2','Ben John’s Junior Paddle',49.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(173,'J132VY784KTBC','SELKIRK Core Line Day Backpack Purple',39.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(174,'S8985ZZS3QCG8','SELKIRK Core Line Day Backpack Blue',39.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(175,'0JFZEJ0C8SZY8','SELKIRK - Core Line Team Backpack Green',79.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(176,'RYW77AED5HAD0','SELKIRK - Core Line Team Backpack Blue',79.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(177,'FJSV0570QM8BM','SELKIRK - Core Line Team Backpack Red',79.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(178,'JCX7VHVSXY6GM','SELKIRK - Core Line Team Backpack Purple',79.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(179,'QNV44P5Z4ZJ3Y','SELKIRK - Core Line Tour Backpack Black',129.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(180,'H8VH48K0MRQMR','SELKIRK - Core Line Tour Backpack Red',129.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(181,'A0A1QKKGYK9FP','SELKIRK Pro Line Team Bag Black',149.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(182,'CZS7S7P95RGVA','SELKIRK Pro Line Team Bag White',149.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(183,'DBJ0EKNF41GHT','SELKIRK Pro Line Team Bag',149.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(184,'WVQ0KAVGPQ84E','CRBN Pro Team Backpack',109.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(185,'JF25PB6WF20B8','CRBN Pro Team Tour Bag',139.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(186,'ESBYC611Y4P4W','Vulcan Club Tote White (not shown)',39.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(187,'0GNPW5RWXN7XG','Vulcan Club Tote Green',39.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(188,'9P10REYSJFBSM','Vulcan Club Tote',0.00,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(189,'SFSZ7SDW3668R','Vulcan Club Backpack Black',59.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(190,'AK8PCJMVMBP3E','Vulcan VPRO Backpack White/Pink',129.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(191,'N88DX8ARGFCM0','Vulcan VPRO Backpack Blue',129.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(192,'Z1RJV7NW9HRRY','Vulcan VPRO Backpack Black',129.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(193,'YWMZ4SX5H1GMA','Vulcan Tour Backpack White/Pink',129.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(194,'YVNYP4ZWX9PSP','Vulcan Tour Backpack Black',79.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(195,'NJADS23M8F5E4','Vulcan Tour Backpack Blue',79.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(196,'HA3WKDZV0S6YY','Pello Pro Pickleball Bag',99.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(197,'TE30YCV2NT1Y8',' Vision II Deluxe Backpack Black',59.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(198,'1MG42ACYX7CP4','Tour Elite Pickleball Duffle Bag Turquoise/Teal',139.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(199,'9QC2DVG812W3T','Tour Elite Pickleball Duffle Bag Hot Pink/Blue',139.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(200,'SRAQD33KYQ076','Tour Elite Pickleball Duffle Bag Black/Yellow',139.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(201,'3HEGHH586ZS9Y','Tour Elite Pickleball Duffle Bag Blue/Yellow',139.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(202,'24J0JGWGCB3RC','Tour Elite Pickleball Duffle Bag Navy/Yellow',114.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(203,'1Y9GF7VYEQ71W','Tour Elite Pro Pickleball Duffle Bag Turquoise/Teal',139.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(204,'TFGRWSVGSKSP4','Tour Elite Pro Pickleball Duffle Bag Hot Pink/Blue',139.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(205,'WHQFYGH02JGD0','Tour Elite Pro Pickleball Duffle Bag Black/Yellow',139.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(206,'FZMEPMKETPTFG','Tour Elite Pro Pickleball Duffle Bag Blue/Yellow',139.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(207,'HCWSN4QGM5HJR','Tour Elite Pro Pickleball Duffle Bag Navy/Yellow',139.95,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(208,'ZG05HWPK1DN0P','Amped EPIC Midweight Purple',149.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(209,'A36AG77232KCT','Amped EPIC Midweight Red',149.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(210,'DB1ZAXNSBZ0MT','Amped EPIC Midweight Blue',149.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(211,'6TJX6RTMCSPF2','Amped EPIC Midweight Midweight',149.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(212,'9M72JWCZ91YX0','Amped EPIC Midweight Lightweight',149.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(213,'6ZZQ5QNZYHB1E','Amped Invikta X',149.99,'',0,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(214,'Y2ENKDXMB3R8T','Amped Invikta Midweight',149.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(215,'Y02MGVCZXV0DC','Amped Invikta Lightweight',149.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(216,'0XZZ1M8V4R4J2','Amped Invikta',249.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(217,'S0GV7817QCX5R','Vanguard Power Air Legends',249.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(218,'5D50VN6S176JW','Vanguard Power Air Invikta',249.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(219,'TH4ADNAXTVXEP','Vanguard Power Air S2',249.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(220,'BWVH7EZE7PVV6','Vanguard Power Air Invikta - Catherine Parenteau',249.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(221,'07FVEHW44T12A','LUXX Control Air S2',249.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(222,'W1B3B6GC1J00E','LUXX Control Air Epic Blue',249.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(223,'Q9HWNA50PHBE4','LUXX Control Air Epic Red',249.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(224,'1NHQ2SYF56P7M','LUXX Control Air Invikta Blue',249.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(225,'T7EBSHX6VHW86','LUXX Control Air Invikta Red',249.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(226,'QJW9MCQ4QZGCJ','CRBN² Control Series 16mm',179.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(227,'1P5CSEHWYD4H6','CRBN² Control Series 14mm',179.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(228,'7ZD1GHW8V56MY','Halo Power Max',139.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(229,'ED2794AB60V8G','Holderness Family Max',99.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(230,'SF7BYYRFS60JY','Holderness Family XL',99.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(231,'TBHKQAKQ978M4','Holderness Family Bundle',109.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(232,'28B0V5TDESMCT','Vanguard Power Air Epic',249.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(233,'PTMRK7S98KFD2','Argiano, Rosso Toscano NC Non Confunditur',9.00,'Wine',10,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(234,'5BPAET76YQ0RW','Charles Woodson, Intercept Red Blend',9.00,'Wine',10,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(235,'7SM3ZCGC8S0HC','FONTE DEI BORGHI CHIANTI (TUSCANY)',8.00,'Wine',10,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(236,'2X78SNXWZ324A','BIXIO CABERNET (MOLISE)',9.00,'Wine',10,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(237,'JX75PSA5RB0XC','Josh Cellars, Craftman\'s Collection Cabernet Sauvignon',7.00,'Wine',10,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(238,'QCK1QN2GQV92R','TORRE ORIENTALE PINOT NOIR (FRIULI)',8.00,'Wine',10,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(239,'2PFTMB5CRFDQY','TORRE ORIENTALE SAUVIGNON (FRIULI)',8.00,'Wine',10,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(240,'8KKGCNNHG8THE','Whitehaven Wines, Sauvigon Blanc Winemaker\'s Selection',7.00,'Wine',10,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(241,'8BYZ7DDR0PE9W','SOTTORIVA ANTICA PINOT GRIGIO (MOLISE)',7.00,'Wine',10,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(242,'AZC6S6DTQMW4A','Josh Cellars, Craftman\'s Collection Chardonnay',7.00,'Wine',10,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(243,'3S46F5WA34GVE','FRASSINELLI PROSECCO (VENETO)',8.00,'Wine',10,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(244,'10WTZAJJKQG3R','William Wycliff, Brut',6.00,'Wine',10,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(245,'NW5BSR6AHX8XG','Gold Peak Ice Tea (Bottle)',3.95,'Drinks',4,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(246,'2QD7AEPQHTC78','Bottle Water',2.95,'Drinks',4,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(247,'3T2W7ZDF7GHF0','Bottle Soft Drink',2.95,'Drinks',4,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(248,'X66JF4P0804CT','Fountain Soft Drink',1.95,'Drinks',4,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(249,'K0ZPASPM4D4GC','12 Wings',13.95,'Wings',11,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(250,'Y6T6W40K5FRS0','6 Wings',7.95,'Wings',11,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(251,'QZXYQAB5JR09J','Veggie Supreme White',9.95,'Flatbreads',5,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(252,'B9ZE9QXJVNAJW','Pepperoni',9.95,'Flatbreads',5,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(253,'CNVF5JK841XQG','The Dad Joke \"Cheesy\"',9.95,'Flatbreads',5,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(254,'8CWGVPVCCWE56','Garden Veggie Wrap',7.95,'Sandwiches/Wraps',9,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(255,'VK9AWY5G5ZVHG','Grilled Chicken Caesar Wrap',9.95,'Sandwiches/Wraps',9,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(256,'FNEDRFZTQWZ60','Grilled Cheese Panini',7.95,'Sandwiches/Wraps',9,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(257,'V3Q2ZFAEBA8HT','Grilled Chicken Avocado Panini',10.95,'Sandwiches/Wraps',9,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(258,'C6YV88RE1Z91E','The Bert or Ernie Panini',9.95,'Sandwiches/Wraps',9,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(259,'H8RJ750GXYK8P','Caesar Salad',7.95,'Salads',8,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(260,'3SWQPNGM4RQPE','Mediterranean Salad',7.95,'Salads',8,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(261,'YB65G8HT658G2','Garden Salad',9.95,'Salads',8,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(262,'FXV360WPYDDZ4','Pickle RVA',2.95,'Appetizers',1,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(263,'EGWZR5RN4VFR6','Performance Popcorn/Pub Mix',2.95,'Appetizers',1,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(264,'KTV7CMT18DK6P','Charcuterie & Cheese Board',14.95,'Appetizers',1,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(265,'M02VJDQPEM7PR','Stackin\' Sliders',9.95,'Appetizers',1,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(266,'FGVP12R8D4K58','Giant German Pretzel',9.95,'Appetizers',1,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(267,'0MTFP9FPAE0FW','Dink & Dip Trio',10.95,'Appetizers',1,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(268,'RK68DFR5WNC5C','Roanoke Ruckus Performance T 4XL',29.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(269,'YEGR3EA6ZF39G','Roanoke Ruckus Performance T 3XL',29.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(270,'F4H2TT1V3YQJT','Roanoke Ruckus Performance T 2XL',29.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(271,'M4BATHME2D2H8','Roanoke Ruckus Performance T XL',29.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(272,'4SWNHQ5K5884W','Roanoke Ruckus Performance T L',29.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(273,'5K6RVPR1N02YT','Roanoke Ruckus Performance T M',29.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(274,'QRMV01JZV8K7M','Roanoke Ruckus Performance T S',29.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(275,'DQ4RQGYPSMW0E','Roanoke Ruckus Performance T XS',29.99,'Merchandise',7,'2023-12-07 20:50:37','2023-12-07 20:50:37'),(276,'D0QTD5PR30KZ2','Gift card',0.00,'',0,'2023-12-07 20:50:37','2023-12-07 20:50:37');
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
INSERT INTO `member_friend` VALUES (1,2,1,1,5,0,0,'pending','2023-11-19 15:01:36','2023-11-19 15:01:36');
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_profiles`
--

LOCK TABLES `member_profiles` WRITE;
/*!40000 ALTER TABLE `member_profiles` DISABLE KEYS */;
INSERT INTO `member_profiles` VALUES (1,1,'5534183476',17,'MALE','3.8',NULL,NULL,NULL,'2023-11-09 14:51:22','2023-11-19 15:06:26'),(2,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-09 14:52:03','2023-11-09 14:52:03'),(3,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-09 14:52:35','2023-11-09 14:52:35'),(4,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-09 14:53:05','2023-11-09 14:53:05'),(5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-17 22:10:50','2023-11-17 22:10:50'),(6,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-29 18:06:43','2023-11-29 18:06:43'),(7,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-30 16:53:15','2023-11-30 16:53:15'),(8,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-30 18:23:41','2023-11-30 18:23:41'),(9,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-30 20:12:41','2023-11-30 20:12:41'),(10,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-12-13 03:20:00','2023-12-13 03:20:00'),(11,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-12-13 03:59:04','2023-12-13 03:59:04');
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
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `original_pass` varchar(8) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `gender` enum('male','female','prefer_not_to_say','') NOT NULL DEFAULT 'prefer_not_to_say',
  `dob` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `location_id` bigint(20) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `membership_card_id` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `customerID` varchar(255) NOT NULL,
  `card_last4` varchar(4) DEFAULT NULL,
  `card_type` enum('visa','mc','amex','discover','diners_club','jcb','unknown') NOT NULL DEFAULT 'unknown',
  `status` enum('active','inactive','paused','pending') NOT NULL DEFAULT 'active',
  `pause_from` date DEFAULT NULL,
  `pause_to` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `members_memberid_unique` (`memberID`),
  UNIQUE KEY `members_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'PPB0001','James','Doyle','jim@divstrong.com','$2y$10$UUUB/M92ecT6pCjEITxqgO5ipHC/MU2YOf3hUgzndHy9IF3GaW4ky',NULL,'8043159609','prefer_not_to_say',NULL,NULL,NULL,NULL,NULL,1,3,NULL,'uploads/avatars/B9o756bcULG48RQ5ftTTEqD9qB9aHzdcr1BU0vjj.png','9ZK6H70NFTAGY','4242','visa','active',NULL,NULL,'2023-11-09 14:51:22','2023-12-13 01:21:34',NULL),(2,'PPB0002','Jon','Laaser','laaser2@yahoo.com','$2y$10$z0p1sdLkatHgw8XuacYiMenr3IWs3ShRur53c3eAJk00/XL2OaJea','S6RCaQ9a','8045551234','prefer_not_to_say',NULL,NULL,NULL,NULL,NULL,1,1,NULL,NULL,'3XFVW34X3F2MA',NULL,'unknown','active',NULL,NULL,'2023-11-09 14:52:03','2023-11-09 14:52:03',NULL),(3,'PPB0003','Steve','Feher','sfeher@ridgefieldgroup.com','$2y$10$eKkxMEzSxZE57lo/wXQpxOl5IFmDqF041BCbatulrWn.p/7v0fGaS',NULL,'8045551234','prefer_not_to_say',NULL,NULL,NULL,NULL,NULL,1,2,NULL,NULL,'PNAY26R78P1TE',NULL,'unknown','active',NULL,NULL,'2023-11-09 14:52:35','2023-11-30 20:11:23','2023-11-30 20:11:23'),(4,'PPB0004','Jacob','Hollingsworth','jacobhollingsworth@journeybizsolutions.com','$2y$10$Hqp2fYd0aI6dbwCgip7Us.dEHN/dqmiYZM0OkPB3OhCRuI/RCUf0.',NULL,'8045551234','prefer_not_to_say',NULL,NULL,NULL,NULL,NULL,1,4,NULL,NULL,'J8018S1JA5VW4',NULL,'unknown','active',NULL,NULL,'2023-11-09 14:53:05','2023-11-09 15:40:19',NULL),(5,'PPB0005','Rose','Rose','rose@divstrong.com','$2y$10$yz3NFfEpAxkdstUKxS/7KeWiz86lHx.DoCc5aGEobmXDp7p7ANguO',NULL,'(804) 555-1234','prefer_not_to_say','1989-06-08','123 Any Street Roanoke','Atlanta','GA','30314',1,5,NULL,NULL,'S8BPR1Y3X4WTW','4242','visa','active',NULL,NULL,'2023-11-17 22:10:50','2023-12-14 16:25:48',NULL),(6,'PPB0006','Ilya','Rivkin','ilya@pingpod.com','$2y$10$oa6AGHucY9yhTZya01Lzc.q./NYBO5u5D0JuXOfS0VoKVmtl2YOnC',NULL,'8005551234','prefer_not_to_say',NULL,NULL,NULL,NULL,NULL,1,3,NULL,NULL,'VSEH7N9RP1TFP',NULL,'unknown','active',NULL,NULL,'2023-11-29 18:06:43','2023-11-29 21:12:13',NULL),(7,'PPB0007','Dev','Test','support@divstrong.com','$2y$10$k4/ws1Z0po2zjqhsIHw8Ne9lwCfAtICdp3unH7qtM05alJKAAka.a','iBrinLyd','8045551234','prefer_not_to_say',NULL,NULL,NULL,NULL,NULL,1,1,NULL,'uploads/avatars/T2DQ2sRP0MQjHg6YlHqIHQKCmAyTJauUGNmvzfki.png','Q09QF8FCEABS2',NULL,'unknown','active',NULL,NULL,'2023-11-30 16:53:15','2023-11-30 16:53:15',NULL),(8,'PPB0008','Google','Test','billing@divstrong.com','$2y$10$A8ZbkcKs/Le5SXuNoS.I.Oeh2M5gPRBl4ghCshHHFZHFeA/.Nvqhy','Sv5cVmCl','8043155555','prefer_not_to_say',NULL,NULL,NULL,NULL,NULL,1,1,NULL,'uploads/avatars/SFMtCMWPSkcEBsUp9iT7S4mAsiQdAqdQZDXe2es7.png','CAN963YMXXPEY',NULL,'unknown','active',NULL,NULL,'2023-11-30 18:23:41','2023-11-30 18:23:41',NULL),(9,'PPB0009','Steve','Feher','sfeherrfg@gmail.com','$2y$10$6R5si2vsvqlv2RKnPi575uaPo7YoU/02HP6NjfuczWOfwq8wk0lRK','Ukrqf6t4','804-464-3693','prefer_not_to_say',NULL,NULL,NULL,NULL,NULL,1,2,NULL,NULL,'CZYJ2WG868N00',NULL,'unknown','active',NULL,NULL,'2023-11-30 20:12:41','2023-11-30 20:50:30',NULL),(10,'PPB0010','Test','Text','info@divstrong.com','$2y$10$fZAkSTm0eojS4MfepEGF1OGCCjsVQfzL8vuqw.gzmKIUV9ewIaYoS','VHcae4GV','8045551234','male','2023-11-30','716 Main St','Henrico','VA','23236',1,2,NULL,NULL,'WFR5288NRWQJ0',NULL,'unknown','active',NULL,NULL,'2023-12-13 03:20:00','2023-12-13 03:22:48',NULL),(11,'PPB0011','Joey','Checks','admin@divstrong.com','$2y$10$6ziIaxfhdOYaEeilLHwWIe7XinLVj3Kp3TbFAyGw0O7mplYZDm1H6','06F0V1CZ','8043158846','male','2023-12-04','123 Any Street','Richmond','KY','146841',1,1,NULL,NULL,'ZKRNBWACG4R4P',NULL,'unknown','active',NULL,NULL,'2023-12-13 03:59:04','2023-12-13 03:59:40',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\Member',5,'test','0cc200bce6a2685e332b4cd4b76af4a644abf0acb27605a169fe6bb2e9f0684f','[\"*\"]','2023-12-14 16:57:42',NULL,'2023-12-14 14:08:29','2023-12-14 16:57:42');
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
  `status` enum('public','private') NOT NULL DEFAULT 'public',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES (1,'Elite Team Membership',119.00,'monthly','public','2023-10-19 14:47:29','2023-12-08 22:49:12'),(2,'Performance Team Membership',49.00,'monthly','public','2023-10-19 14:47:48','2023-10-19 14:47:48'),(3,'Corporate Membership',99.00,'monthly','public','2023-10-19 14:48:03','2023-12-13 03:57:35'),(4,'Morning Crew PBJ Membership',49.00,'monthly','private','2023-10-19 14:48:18','2023-10-19 14:48:18'),(5,'Student Membership',39.00,'monthly','public','2023-10-19 14:48:33','2023-12-13 03:57:43'),(6,'Elite Team Membership (DISCOUNTED)',99.00,'monthly','private','2023-12-14 13:57:18','2023-12-14 13:57:18'),(7,'Performance Team Membership (DISCOUNTED)',39.00,'monthly','private','2023-12-14 13:57:18','2023-12-14 13:57:18');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'contact_email','info@divstrong.com','2023-12-14 13:56:14','2023-12-14 13:56:14'),(2,'play_link','https://app.pingpod.com/','2023-11-22 23:53:44','2023-11-23 01:00:50'),(3,'improve_link','https://app.pingpod.com/','2023-11-22 23:53:44','2023-11-22 23:53:44'),(4,'rent_link','https://app.pingpod.com/','2023-11-22 23:53:44','2023-11-22 23:53:44'),(5,'shop_link','https://ppbrva.com/shop/','2023-11-22 23:53:44','2023-11-22 23:53:44'),(6,'dupr_link','https://ppbrva.com/dupr','2023-11-22 22:37:22','2023-11-22 22:37:22');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Jim Doyle','jim@divstrong.com','2023-10-18 22:54:54','$2y$10$ApVug.AwnhLz6r2TmdoeT.w9f5wOdtvaNKrpeP853FqsG2zf7LIeG','8043159609','2023-12-13 03:21:14',1,1,'edzeUsGsRGnBra8hDV1zqVozXB1kGRSKFwWLHEK3sTEEMnRfHUv0Kxepwbvh','2023-10-18 22:54:54','2023-12-13 03:21:14'),(2,'Jon Laaser','jon@ppbrva.com',NULL,'$2y$10$e5fJihXELdtPw1.XLXchTucNfRMJxVvuSzziM4ubu8FyTE3pJ8Bta','8045551234','2023-10-19 21:18:17',1,1,'YQBalxDpYT1LvJ2XqAP8RlMhG9Q8QwKSQnDcYnkyQYld4kvUI3a6LS4wYyCo','2023-10-19 16:12:56','2023-10-19 21:18:17'),(3,'Dev','support@divstrong.com',NULL,'$2y$10$sQ2M0Q67unZV37CMS.gmqes/4qHBHvUdVfy0pdUFqoyu33OerKTAO',NULL,'2023-12-13 08:34:43',1,1,NULL,'2023-11-09 02:09:35','2023-12-13 08:34:43'),(4,'test','developer@divstrong.com',NULL,'$2y$10$oI0cI7zmrHTHUnK5I0ur5Ox8HmTisxtVaSiXWUQakMdPAH4uviOmq',NULL,NULL,1,1,NULL,'2023-11-09 02:09:57','2023-11-29 21:25:58'),(5,'Steve','sfeher@ridgefieldgroup.com',NULL,'$2y$10$kxn8HyOWR8O2FrnEwwFSgeyVAQqnIyMenWc6UKd.QxmiPodG89mNa','8005551234','2023-12-07 15:45:05',1,1,'afcsH7qFPzZNahTYsyRhvmFymtprIdvBPsjhHkNSqPnXicVMPFw8vkcUm98p','2023-11-30 20:14:58','2023-12-07 15:45:05');
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

-- Dump completed on 2023-12-14 18:59:04
