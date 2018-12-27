-- MySQL dump 10.13  Distrib 5.5.55, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: andrewLaravel
-- ------------------------------------------------------
-- Server version	5.5.55-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activations`
--

DROP TABLE IF EXISTS `activations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activations_user_id_index` (`user_id`),
  CONSTRAINT `activations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activations`
--

LOCK TABLES `activations` WRITE;
/*!40000 ALTER TABLE `activations` DISABLE KEYS */;
INSERT INTO `activations` VALUES (2,58,'roSWdYI4WcF4Yl8dEQFpZXb7BRukuvHZQiHmAkn9ctLhoLccMMqa06NSmX8sL6gM','194.187.249.29','2017-07-07 23:28:47','2017-07-07 23:28:47'),(10,66,'eDkM4tonbNFYFQ24cHfsVnYXRQ638SAaYCn0585BKisuyfq8xOeaU7G2lHIp62HY','185.93.183.215','2017-08-05 15:05:51','2017-08-05 15:05:51'),(11,103,'Zqwa7aeuMfGGf1QcKEFuhV6drnE7cEPvVBSflRRCE3gAvjB7eUt4fBFTngQFtsl7','173.234.100.233','2018-03-10 01:52:14','2018-03-10 01:52:14'),(12,104,'7yU097TlKSGeLRuhZBbDGvYP1HhTsld78dUFOwN0vVFn3EmkeUdmIRlpZOSVjmeO','192.3.183.40','2018-03-16 01:35:41','2018-03-16 01:35:41'),(19,111,'cUze7dBdNzXK3yqz9zrgUtjgRQ9AmdJL5RV8wZszO7sA3sCLqEIqXIpLwIRo6Ms3','104.172.20.141','2018-03-27 15:55:28','2018-03-27 15:55:28'),(20,111,'PnreXJHptBaHrfd5Wq7Lhz1WgeqWwgQv0vIpTtpmApLeJftvEs7CYVKlHtT0EZF4','104.172.20.141','2018-03-27 15:56:18','2018-03-27 15:56:18');
/*!40000 ALTER TABLE `activations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `industries`
--

DROP TABLE IF EXISTS `industries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `industries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `industries`
--

LOCK TABLES `industries` WRITE;
/*!40000 ALTER TABLE `industries` DISABLE KEYS */;
INSERT INTO `industries` VALUES (1,'RealEstate',1),(2,'E-Commerce',2);
/*!40000 ALTER TABLE `industries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `landingPages`
--

DROP TABLE IF EXISTS `landingPages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `landingPages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondaryTitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` text COLLATE utf8mb4_unicode_ci,
  `background` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '/home/eliot/work/andrew/public/uploads/placeholderBG.jpg',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `countdown` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '03/21/2018 00:00 +0700',
  `coupon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `productImg` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disclaimer` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titleColor` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disclaimerColor` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `backgroundColor` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buttonColor` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preCountdownText` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `storeUrl` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `landingpages_user_id_index` (`user_id`),
  CONSTRAINT `landingpages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `landingPages`
--

LOCK TABLES `landingPages` WRITE;
/*!40000 ALTER TABLE `landingPages` DISABLE KEYS */;
INSERT INTO `landingPages` VALUES (10,48,'Main title','secondary title',NULL,'/home/eliot/work/andrew/public//uploads/users/id/48/background.JPG','2017-05-12 23:27:01',NULL,'',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(11,49,NULL,NULL,NULL,NULL,'2017-05-13 00:44:36',NULL,'',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(12,50,'Test','Test 2',NULL,'recoverleads.com//uploads/users/id/50/background.jpg','2017-05-16 19:38:32',NULL,'',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(13,54,NULL,NULL,NULL,'/var/www/recoverleads.com/public_html/andrew/public//uploads/users/id/54/background.jpg','2017-05-28 20:28:24',NULL,'',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(16,56,'Primary Title','Secondary Title',NULL,'/var/www/recoverleads.com/public_html/andrew/public//uploads/users/id/56/background.jpg','2017-06-09 20:57:31',NULL,'',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(20,82,'What\'s my home worth?','Fill out the address form to find out.',NULL,'/var/www/recoverleads.com/public_html/andrew/public//uploads/users/id/82/backgroundLP1.jpg','2017-10-24 00:47:16',NULL,'Home Valuation',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(21,82,'The best way to find your home','With over 700,000 active listings, We have the largest inventory of apartments in the United States',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2017-10-24 00:47:16',NULL,'Property Details',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(22,82,'Maximize your time by advertising your open houses','This is the secondary title of the third landing page, this should probably be changed before going live, check activateController',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2017-10-24 00:47:16',NULL,'Open Houses',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(26,87,'What\'s my home worth?','Fill out the address form to find out.',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2017-10-24 21:40:47',NULL,'Home Valuation',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(27,87,'The best way to find your home','With over 700,000 active listings, Realtyspace has the largest inventory of apartments in the United States',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2017-10-24 21:40:47',NULL,'Property Details',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(28,87,'Maximize your time by advertising your open houses','This is the secondary title of the third landing page, this should probably be changed before going live, check activateController',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2017-10-24 21:40:47',NULL,'Open Houses',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(35,57,'What\'s my home worth?','Fill out the address form to find out.',NULL,'/var/www/recoverleads.com/public_html/andrew/public//uploads/users/id/57/backgroundLP1.jpg','2017-11-18 00:48:40',NULL,'Home Valuation',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(36,57,'The best way to find your home','With over 700,000 active listings, Realtyspace has the largest inventory of apartments in the United States',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2017-11-18 00:48:40',NULL,'Property Details',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(37,57,'Maximize your time by advertising your open houses','This is the secondary title of the third landing page, this should probably be changed before going live, check activateController',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2017-11-18 00:48:40',NULL,'Open Houses',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(38,90,'What\'s my home worth?','Fill out the address form to find out.',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2017-12-13 19:55:44',NULL,'Home Valuation',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(39,90,'The best way to find your home','With over 700,000 active listings, Realtyspace has the largest inventory of apartments in the United States',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2017-12-13 19:55:44',NULL,'Property Details',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(40,90,'Maximize your time by advertising your open houses','This is the secondary title of the third landing page, this should probably be changed before going live, check activateController',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2017-12-13 19:55:44',NULL,'Open Houses',NULL,'',0,NULL,NULL,NULL,NULL,NULL,'','',NULL),(54,105,'Sign up to be alerted when our new product is available!','Our new product will launch in',NULL,'/var/www/recoverleads.com/public_html/andrew/public//uploads/users/id/105/backgroundLP4.jpg','2018-03-19 00:56:34',NULL,'New Product Countdown','04/03/2018 06:17 -0800',NULL,81,'/uploads/users/id/105/uploadProductCountdownImg.png','You will be notified when our product is available for presale. Subscribing to our list provides you with up to the minute announcements and product information.','FFFFFF','FF0000',NULL,'474747','New watches coming soon!',NULL),(55,105,'Receive 15% off our Shirts!','We have limited stock and are making room for new inventory! Click below to receive a coupon for our new shirt good for 15% off! Limited time only! Sizes Small through Extra Large',NULL,'/var/www/recoverleads.com/public_html/andrew/public//uploads/users/id/105/backgroundLP5.jpg','2018-03-19 00:56:34',NULL,'New Product Coupon',NULL,'123',83,'/uploads/users/id/105/uploadProductCouponImg.png','Limit one coupon per customer. Use wisely!','000000','000000',NULL,'BA2525','','www.amazon.com/Fitbit-Surge-Fitness-Superwatch-Version/dp/B00N2BWHWS/ref=sr_1_1_a_it?ie=UTF8&qid=1522064979&sr=8-1&keywords=fitbit+surge&dpID=41pXbnxiiJL&preST=_SY300_QL70_&dpSrc=srch'),(65,112,'What\'s my home worth?','Fill out the address form to find out.',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2018-03-27 15:59:21',NULL,'Home Valuation','03/21/2018 00:00 +0700',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(66,112,'The best way to find your home','With over 700,000 active listings, Realtyspace has the largest inventory of apartments in the United States',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2018-03-27 15:59:21',NULL,'Property Details','03/21/2018 00:00 +0700',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(67,112,'Maximize your time by advertising your open houses','This is the secondary title of the third landing page, this should probably be changed before going live, check activateController',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2018-03-27 15:59:21',NULL,'Open Houses','03/21/2018 00:00 +0700',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(68,113,'What\'s my home worth?','Fill out the address form to find out.',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2018-04-15 08:05:35',NULL,'Home Valuation','03/21/2018 00:00 +0700',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(69,113,'The best way to find your home','With over 700,000 active listings, Realtyspace has the largest inventory of apartments in the United States',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2018-04-15 08:05:35',NULL,'Property Details','03/21/2018 00:00 +0700',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(70,113,'Maximize your time by advertising your open houses','This is the secondary title of the third landing page, this should probably be changed before going live, check activateController',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2018-04-15 08:05:35',NULL,'Open Houses','03/21/2018 00:00 +0700',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(80,102,'What\'s my home worth?','Fill out the address form to find out.',NULL,'/var/www/recoverleads.com/public_html/andrew/public//uploads/users/id/102/backgroundLP1.jpg','2018-04-15 09:13:12',NULL,'Home Valuation','03/21/2018 00:00 +0700',NULL,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(81,102,'The best way to find your home','With over 700,000 active listings, Realtyspace has the largest inventory of apartments in the United States',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2018-04-15 09:13:12',NULL,'Property Details','03/21/2018 00:00 +0700',NULL,34,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(82,102,'Maximize your time by advertising your open houses','This is the secondary title of the third landing page, this should probably be changed before going live, check activateController',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2018-04-15 09:13:12',NULL,'Open Houses','03/21/2018 00:00 +0700',NULL,34,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(83,102,'Product Launch Countdown','Our new product will launch in',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2018-04-15 09:13:23',NULL,'New Product Countdown','03/21/2018 00:00 +0700',NULL,40,NULL,'testt','78FF42','3BFF99',NULL,'99FFAD','test',NULL),(84,102,'New Product Coupon','Use this coupon to get a deal on our new product',NULL,'/home/eliot/work/andrew/public/uploads/placeholderBG.jpg','2018-04-15 09:13:23',NULL,'New Product Coupon','03/21/2018 00:00 +0700',NULL,34,NULL,NULL,'9FFF17','A4FF6B','8DFF8C','304EFF',NULL,NULL),(85,102,'New Product For Sale','Secondary Title',NULL,'/var/www/recoverleads.com/public_html/andrew/public//uploads/users/id/102/backgroundLP6.jpg','2018-04-15 11:59:38',NULL,'Single Item Shopping Cart','03/21/2018 00:00 +0700',NULL,6,'/uploads/users/id/102/uploadProductCouponImg.png','disclaim','EEFF2B','FF3838','FFFD0A','828BFF',NULL,NULL);
/*!40000 ALTER TABLE `landingPages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leads`
--

DROP TABLE IF EXISTS `leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(11) NOT NULL,
  `linkCode` varchar(100) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `cell` varchar(20) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leads`
--

LOCK TABLES `leads` WRITE;
/*!40000 ALTER TABLE `leads` DISABLE KEYS */;
INSERT INTO `leads` VALUES (22,'65','ELUjHmeWqwwigRQkELT23e','2017-07-22 19:44:56','John Doe','jdoey@gmail.com','29329232023','Home Valuation'),(23,'65','ELUjHmeWqwwigRQkELT23e','2017-07-22 22:20:22','test','test@test.com','2345678910','Home Valuation'),(24,'65','ELUjHmeWqwwigRQkELT23e','2017-07-23 21:37:42','JOhn Doe','jdoey@gmail.com','2923932293','Property Details'),(25,'65','ELUjHmeWqwwigRQkELT23e','2017-07-23 21:37:42','JOhn Doe','jdoey@gmail.com','2923932293','Property Details'),(26,'65','ELUjHmeWqwwigRQkELT23e','2017-07-24 00:10:16','test','testtt@test.co','3233456789','Property Details'),(27,'65','ELUjHmeWqwwigRQkELT23e','2017-09-08 06:54:14','jc','jc@jc.com','123446789987','Home Valuation'),(28,'65','ELUjHmeWqwwigRQkELT23e','2017-09-29 20:12:43','test','test@twsff.com','785764564','Home Valuation'),(29,'65','ELUjHmeWqwwigRQkELT23e','2017-09-29 20:13:18','test','andrewpour@gmail.com','2345667864','Home Valuation'),(30,'65','ELUjHmeWqwwigRQkELT23e','2017-10-12 00:32:00','andrew','test@testttt.com','24543243323','Home Valuation'),(31,'65','ELUjHmeWqwwigRQkELT23e','2017-10-12 00:54:26','testy mc testalot','testymctestalot@gmail.com','392392923239','Home Valuation'),(32,'65','ELUjHmeWqwwigRQkELT23e','2017-10-12 01:02:49','testy mc testalot','testymctestalot@gmail.com','392392923239','Home Valuation'),(33,'65','ELUjHmeWqwwigRQkELT23e','2017-10-12 01:09:06','Testy McTest alot','elliotr@gmail.com','2316755925','Home Valuation'),(34,'65','ELUjHmeWqwwigRQkELT23e','2017-10-12 01:10:46','Testy McTest alot','elliotr@gmail.com','2316755925','Home Valuation'),(35,'65','ELUjHmeWqwwigRQkELT23e','2017-10-12 01:18:04','Elliot Test','elliotr@gmail.com','9203323209320','Home Valuation'),(36,'65','ELUjHmeWqwwigRQkELT23e','2017-10-12 01:25:26','Elliot Test','elliotr@gmail.com','9203323209320','Home Valuation'),(37,'65','ELUjHmeWqwwigRQkELT23e','2017-10-12 05:37:48','andrew','email@emailllll.com','3938940343','Home Valuation'),(38,'65','ELUjHmeWqwwigRQkELT23e','2017-10-12 05:45:19','rsgdfbsdv','wsfsdf@dthgfdd.com','35467875665','Home Valuation'),(39,'65','ELUjHmeWqwwigRQkELT23e','2017-11-02 00:00:12','testttttt','adfad@adsg.com','9023209238','Home Valuation'),(40,'82','knolRHxTkoL7iwOGR6hRbs','2017-11-14 20:02:26','test','test@test.com','2345667864','Home Valuation'),(41,'57','1HjL2W5IdSA7lZjdTnRkjo','2017-11-18 00:53:11','Chopper The DOg','jc@startupstud.com','7022834725','Home Valuation'),(42,'65','ELUjHmeWqwwigRQkELT23e','2017-11-26 06:17:28','testtttt','testfsfs@gmail.com','3282398249832','Home Valuation'),(43,'65','ELUjHmeWqwwigRQkELT23e','2017-11-26 06:28:57','testtttt','testfsfs@gmail.com','3282398249832','Home Valuation'),(44,'65','ELUjHmeWqwwigRQkELT23e','2017-11-26 07:02:14','Elliot Test','dlfaksjdl','dlsakfjalkjfssa','Home Valuation'),(45,'82','knolRHxTkoL7iwOGR6hRbs','2017-12-01 21:54:25','tom','TOM@TOM.COM','45346546','Home Valuation'),(46,'82','knolRHxTkoL7iwOGR6hRbs','2017-12-08 19:40:19','tony','tonyd805@gmail.com','2313216549','Home Valuation'),(47,'65','ELUjHmeWqwwigRQkELT23e','2017-12-25 01:41:37','Zac','zac@email.com','824598273','Home Valuation'),(48,'82','knolRHxTkoL7iwOGR6hRbs','2018-03-05 13:45:56','test','test1','2323223232','Home Valuation'),(49,'102',NULL,'2018-03-07 12:40:43',NULL,'elliotr@gmail.com',NULL,'New Product Coupon'),(50,'102',NULL,'2018-03-15 06:09:48',NULL,'test@gmail.com',NULL,'New Product Coupon'),(51,'102',NULL,'2018-03-15 06:09:49',NULL,'test@gmail.com',NULL,'New Product Coupon'),(52,'102',NULL,'2018-03-15 06:11:15',NULL,'ttttt@gmail.com',NULL,'New Product Countdown'),(53,'102',NULL,'2018-03-15 06:16:14',NULL,'tttestt@gamcil.com',NULL,'New Product Countdown'),(54,'105',NULL,'2018-03-20 09:34:06',NULL,'andrewpour@gmail.com',NULL,'New Product Coupon'),(55,'105',NULL,'2018-03-26 00:07:31',NULL,'andrewpour@gmail.com',NULL,'New Product Countdown'),(56,'105',NULL,'2018-03-26 00:07:56',NULL,'andrewpour@gmail.com',NULL,'New Product Coupon'),(57,'102',NULL,'2018-03-26 08:47:30',NULL,'test@gmail.com',NULL,'New Product Countdown'),(58,'102',NULL,'2018-03-26 08:58:19',NULL,'testtt@gmail.com',NULL,'New Product Countdown'),(59,'102',NULL,'2018-03-26 09:04:43',NULL,'tetsss@gmail.com',NULL,'New Product Coupon'),(60,'102',NULL,'2018-03-26 09:13:11',NULL,'test@gmail.com',NULL,'New Product Coupon'),(61,'102',NULL,'2018-03-26 09:14:10',NULL,'qwe@gmailc.om',NULL,'New Product Coupon'),(62,'102',NULL,'2018-03-26 09:14:57',NULL,'testet@fdafdss/.com',NULL,'New Product Coupon'),(63,'102',NULL,'2018-03-26 09:15:32',NULL,'test@gmail.com',NULL,'New Product Coupon'),(64,'105',NULL,'2018-03-26 11:44:41',NULL,'test@test.com',NULL,'New Product Countdown'),(65,'105',NULL,'2018-03-26 11:45:05',NULL,'test@testttt.com',NULL,'New Product Coupon'),(66,'105',NULL,'2018-03-26 11:46:19',NULL,'testtt@test.co',NULL,'New Product Coupon'),(67,'105',NULL,'2018-03-26 11:46:50',NULL,'zdfgf@dfgfd.com',NULL,'New Product Coupon'),(68,'105',NULL,'2018-03-27 16:23:51',NULL,'tony@zurixx.com',NULL,'New Product Coupon'),(69,'105',NULL,'2018-03-27 16:23:51',NULL,'hynt@mediabandit.com',NULL,'New Product Coupon'),(70,'102','UiArYb40ZNzOXZDFTxb0Cy','2018-04-20 22:57:01','test','test@test.com','235357465663','Home Valuation'),(71,'102','UiArYb40ZNzOXZDFTxb0Cy','2018-04-20 22:57:32','dgrgf','sgsdf@gmail.com','1324567','Home Valuation'),(72,'105',NULL,'2018-04-20 23:04:31',NULL,'testttt@mediabandit.com',NULL,'New Product Coupon');
/*!40000 ALTER TABLE `leads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2016_01_15_105324_create_roles_table',1),(4,'2016_01_15_114412_create_role_user_table',1),(5,'2016_01_26_115212_create_permissions_table',1),(6,'2016_01_26_115523_create_permission_role_table',1),(7,'2016_02_09_132439_create_permission_user_table',1),(8,'2017_03_09_082449_create_social_logins_table',1),(9,'2017_03_09_082526_create_activations_table',1),(10,'2017_03_20_213554_create_themes_table',1),(11,'2017_03_21_042918_create_profiles_table',1),(12,'2017_05_05_200438_add_cachier_modifications',2),(13,'2017_05_05_210346_add_company_to_users',3),(14,'2017_05_05_214347_add_phone_to_users',4),(15,'2017_05_05_233354_random_user_link',5),(16,'2017_05_06_000236_add_landingpage_table',6),(17,'2017_05_08_204741_create_sessions_table',7),(18,'2015_12_23_092140_add_cashier_columns',8),(21,'2017_05_10_200916_create_products_table',9),(22,'2017_05_10_200953_create_cart_table',9),(23,'2017_05_10_215920_subscriptions_table',10),(24,'2017_05_10_224911_add_stripe_columns_toUsers_table',11);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `openHouseBackgrounds`
--

DROP TABLE IF EXISTS `openHouseBackgrounds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `openHouseBackgrounds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(700) NOT NULL,
  `propertyId` int(11) DEFAULT NULL,
  `tempRandomString` varchar(300) DEFAULT NULL,
  `upload_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `openHouseBackgrounds`
--

LOCK TABLES `openHouseBackgrounds` WRITE;
/*!40000 ALTER TABLE `openHouseBackgrounds` DISABLE KEYS */;
INSERT INTO `openHouseBackgrounds` VALUES (22,'/uploads/users/id/65/backgroundLP30f51a0b40cdeada6d701bad96f203538.jpg',14,'81474b2f95918b06dbd6b911fc3caf06','2017-10-26 02:22:31'),(23,'/uploads/users/id/65/backgroundLP3c00f8a3063ff87bd1566d361d44ef879.jpg',21,'5d09b81b1a32f90c85e79c66427c3d1d','2017-10-27 02:50:05'),(24,'/uploads/users/id/65/backgroundLP3ba6ef3548637624912f92d20b3240faa.jpg',27,'6322227f914ce6e5991311beb4b2e226','2017-11-01 02:27:40'),(25,'/uploads/users/id/65/backgroundLP3df13b848182a7d57fa6d38a3d7e495fc.jpg',28,'747a49b06071b998643371d39640af8b','2017-11-01 02:34:24'),(27,'/uploads/users/id/65/backgroundLP3b3021ae465d35845d2e5debfca730ad2.jpg',29,'81e6b28a655fa271439ec2e045f9501b','2017-11-01 03:15:34'),(30,'/uploads/users/id/65/backgroundLP358d517cbf86bfd53569155cecff03fc1.jpg',48,NULL,'2017-11-03 01:16:12'),(31,'/uploads/users/id/82/backgroundLP3cc3c3be68c28c1f1c53e262791a39d82.jpg',53,NULL,'2017-11-07 20:25:12'),(32,'/uploads/users/id/82/backgroundLP3685ed6f84c6058c76b8cb9a7f51947f8.jpg',54,NULL,'2017-11-07 22:15:44'),(33,'/uploads/users/id/65/backgroundLP30e0f9ce8d41a7b7e8d7c30c42b55445f.jpg',83,'14f40aad4aa1b0768f46146b8ce040c2','2017-11-13 02:30:09'),(34,'/uploads/users/id/87/backgroundLP388f11a810a5784f50282688d8fe383c7.jpg',84,NULL,'2018-04-20 23:01:34');
/*!40000 ALTER TABLE `openHouseBackgrounds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `openHouseLeads`
--

DROP TABLE IF EXISTS `openHouseLeads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `openHouseLeads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `message` varchar(700) DEFAULT NULL,
  `firstDate` varchar(50) DEFAULT NULL,
  `secondDate` varchar(50) DEFAULT NULL,
  `propertyId` int(2) DEFAULT NULL,
  `hitType` varchar(20) NOT NULL,
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=238 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `openHouseLeads`
--

LOCK TABLES `openHouseLeads` WRITE;
/*!40000 ALTER TABLE `openHouseLeads` DISABLE KEYS */;
INSERT INTO `openHouseLeads` VALUES (13,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-06 02:09:19'),(14,'test','test','322343','dddd','2017/11/08 22:26',NULL,48,'message','2017-11-06 02:27:00'),(15,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-06 02:35:14'),(16,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-06 03:10:21'),(17,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-06 21:09:22'),(18,'John and Jill DOe','jjdoe@gmail.com','32932292','message message message    me  ssa gemessage message message    me  ssa gemessage message message    me  ssa gemessage message message    me  ssa gemessage message message    me  ssa gemessage message message    me  ssa gemessage message message    me  ssa gemessage message message    me  ssa ge','2017/11/07 20:30','2017/11/08 18:45',48,'message','2017-11-06 21:10:32'),(19,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-06 21:23:14'),(20,NULL,NULL,NULL,NULL,NULL,NULL,51,'visit','2017-11-07 04:28:41'),(21,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 04:30:41'),(22,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 04:30:47'),(23,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-07 20:21:24'),(24,NULL,NULL,NULL,NULL,NULL,NULL,21,'visit','2017-11-07 20:21:47'),(25,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-07 20:22:34'),(26,NULL,NULL,NULL,NULL,NULL,NULL,21,'visit','2017-11-07 20:22:39'),(27,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 20:25:19'),(28,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 20:28:06'),(29,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 20:28:56'),(30,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 20:35:27'),(31,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 20:35:31'),(32,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-07 20:35:41'),(33,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 20:35:51'),(34,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 20:37:06'),(35,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-07 20:37:22'),(36,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 20:37:27'),(37,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 20:37:43'),(38,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-07 20:37:54'),(39,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-07 21:16:26'),(40,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 21:16:44'),(41,NULL,NULL,NULL,NULL,NULL,NULL,21,'visit','2017-11-07 21:20:26'),(42,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-07 21:20:39'),(43,NULL,NULL,NULL,NULL,NULL,NULL,21,'visit','2017-11-07 21:20:46'),(44,NULL,NULL,NULL,NULL,NULL,NULL,21,'visit','2017-11-07 22:01:03'),(45,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-07 22:11:27'),(46,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 22:11:34'),(47,NULL,NULL,NULL,NULL,NULL,NULL,21,'visit','2017-11-07 22:12:26'),(48,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-07 22:15:08'),(49,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 22:15:13'),(50,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-07 22:15:49'),(51,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 22:15:55'),(52,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 22:16:03'),(53,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-07 22:16:35'),(54,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 22:17:41'),(55,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 22:21:27'),(56,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-07 22:21:31'),(57,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-07 22:21:38'),(58,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 22:21:59'),(59,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-07 22:25:27'),(60,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-07 22:25:33'),(61,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-07 22:35:27'),(62,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-08 22:35:13'),(63,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-10 23:12:22'),(64,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-10 23:12:32'),(65,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-10 23:35:32'),(66,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-11 18:38:44'),(67,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-11 18:39:54'),(68,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-11 18:40:35'),(69,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-11 18:41:49'),(70,NULL,NULL,NULL,NULL,NULL,NULL,21,'visit','2017-11-11 18:44:16'),(71,NULL,NULL,NULL,NULL,NULL,NULL,55,'visit','2017-11-13 01:52:51'),(72,NULL,NULL,NULL,NULL,NULL,NULL,82,'visit','2017-11-13 02:27:16'),(73,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 02:30:17'),(74,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 02:34:49'),(75,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 02:35:08'),(76,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 02:35:42'),(77,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 02:41:24'),(78,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 02:41:52'),(79,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 02:43:17'),(80,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 02:46:15'),(81,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 02:46:29'),(82,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 02:47:47'),(83,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 02:49:03'),(84,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 02:53:36'),(85,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 02:54:00'),(86,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:03:23'),(87,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:03:56'),(88,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:04:01'),(89,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:04:32'),(90,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:05:13'),(91,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:08:08'),(92,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:08:12'),(93,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:09:06'),(94,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:11:07'),(95,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:13:07'),(96,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:17:37'),(97,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:19:26'),(98,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:21:01'),(99,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:22:12'),(100,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:22:18'),(101,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:24:11'),(102,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:26:14'),(103,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:27:52'),(104,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:28:11'),(105,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:29:32'),(106,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:29:34'),(107,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:29:35'),(108,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:32:02'),(109,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:32:53'),(110,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:33:47'),(111,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:35:18'),(112,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:39:51'),(113,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:42:51'),(114,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:43:39'),(115,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:45:10'),(116,'Testname','Testemail@mgail.com','38292832','test','2017/11/13 23:45','2017/11/14 23:15',83,'message','2017-11-13 03:45:57'),(117,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 03:53:25'),(118,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 19:47:34'),(119,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-13 19:56:41'),(120,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-13 19:57:58'),(121,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 19:58:03'),(122,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-13 19:59:30'),(123,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-13 19:59:37'),(124,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-13 20:01:31'),(125,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-13 20:11:42'),(126,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-13 20:12:17'),(127,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-14 00:55:34'),(128,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-14 00:57:30'),(129,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-14 03:29:47'),(130,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-14 03:32:00'),(131,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-14 03:32:08'),(132,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-14 03:38:23'),(133,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-14 03:42:24'),(134,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-14 03:44:01'),(135,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-14 03:45:55'),(136,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-14 03:47:05'),(137,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-14 03:49:23'),(138,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-14 04:00:50'),(139,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-14 04:00:51'),(140,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2017-11-14 04:06:05'),(141,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-14 19:54:15'),(142,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-14 19:54:41'),(143,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-14 19:57:29'),(144,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-14 19:57:50'),(145,NULL,NULL,NULL,NULL,NULL,NULL,50,'visit','2017-11-14 20:03:29'),(146,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-14 20:23:31'),(147,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-16 20:05:28'),(148,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-16 20:05:38'),(149,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-16 20:05:50'),(150,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-18 00:40:09'),(151,'Test','jcoltonlv@gmail.com','7022834725','Sup! How about those tables????','2017/11/17 17:15','2017/11/17 17:44',53,'message','2017-11-18 00:44:28'),(152,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-21 03:28:11'),(153,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-25 22:15:53'),(154,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-25 22:17:59'),(155,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-25 22:18:15'),(156,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-25 22:18:29'),(157,NULL,NULL,NULL,NULL,NULL,NULL,49,'visit','2017-11-25 22:46:16'),(158,NULL,NULL,NULL,NULL,NULL,NULL,84,'visit','2017-11-25 22:46:57'),(159,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-11-25 23:20:54'),(160,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:04:22'),(161,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:11:15'),(162,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:11:30'),(163,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:12:06'),(164,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:23:41'),(165,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:25:05'),(166,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:27:33'),(167,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:28:27'),(168,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:28:47'),(169,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:37:34'),(170,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:40:47'),(171,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:42:54'),(172,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:44:28'),(173,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:45:19'),(174,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:47:09'),(175,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:47:21'),(176,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:48:16'),(177,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:49:46'),(178,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:50:34'),(179,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:51:54'),(180,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:58:23'),(181,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 07:59:21'),(182,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 08:02:59'),(183,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 08:07:08'),(184,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 08:09:23'),(185,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 08:29:59'),(186,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 08:35:53'),(187,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 08:36:44'),(188,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 08:36:46'),(189,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 08:38:04'),(190,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 08:38:45'),(191,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 08:45:08'),(192,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 08:46:42'),(193,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 08:48:49'),(194,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 08:51:42'),(195,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 08:53:49'),(196,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 08:58:27'),(197,NULL,NULL,NULL,NULL,NULL,NULL,83,'visit','2017-11-26 09:08:43'),(198,NULL,NULL,NULL,NULL,NULL,NULL,84,'visit','2017-11-27 20:51:21'),(199,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-27 20:51:48'),(200,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-11-27 20:52:24'),(201,NULL,NULL,NULL,NULL,NULL,NULL,85,'visit','2017-11-30 02:47:43'),(202,NULL,NULL,NULL,NULL,NULL,NULL,85,'visit','2017-11-30 09:58:55'),(203,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-12-01 21:57:01'),(204,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-12-01 22:03:26'),(205,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-12-08 19:44:32'),(206,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-12-08 19:45:13'),(207,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-12-08 19:45:21'),(208,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-12-08 19:45:56'),(209,NULL,NULL,NULL,NULL,NULL,NULL,53,'visit','2017-12-25 01:44:08'),(210,NULL,NULL,NULL,NULL,NULL,NULL,54,'visit','2017-12-25 01:45:34'),(211,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2018-02-14 04:39:14'),(212,NULL,NULL,NULL,NULL,NULL,NULL,48,'visit','2018-02-14 07:08:32'),(213,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-02-24 13:26:43'),(214,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-02-24 13:28:22'),(215,NULL,NULL,NULL,NULL,NULL,NULL,84,'visit','2018-04-02 08:53:09'),(216,NULL,NULL,NULL,NULL,NULL,NULL,84,'visit','2018-04-02 08:53:15'),(217,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 07:39:03'),(218,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 07:41:15'),(219,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 07:43:34'),(220,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 07:43:59'),(221,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 07:49:15'),(222,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 07:49:36'),(223,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 07:50:15'),(224,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 07:51:37'),(225,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 07:52:51'),(226,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 07:53:25'),(227,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 07:54:08'),(228,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 07:54:59'),(229,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 07:57:38'),(230,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 07:58:40'),(231,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 08:06:19'),(232,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-13 08:11:03'),(233,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-20 22:59:44'),(234,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-20 23:00:15'),(235,NULL,NULL,NULL,NULL,NULL,NULL,86,'visit','2018-04-20 23:00:29'),(236,NULL,NULL,NULL,NULL,NULL,NULL,84,'visit','2018-04-20 23:01:02'),(237,NULL,NULL,NULL,NULL,NULL,NULL,84,'visit','2018-04-20 23:01:59');
/*!40000 ALTER TABLE `openHouseLeads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (1,1,1,'2017-05-04 01:08:55','2017-05-04 01:08:55'),(2,2,1,'2017-05-04 01:08:55','2017-05-04 01:08:55'),(3,3,1,'2017-05-04 01:08:55','2017-05-04 01:08:55'),(4,4,1,'2017-05-04 01:08:55','2017-05-04 01:08:55');
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_user`
--

DROP TABLE IF EXISTS `permission_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_user_permission_id_index` (`permission_id`),
  KEY `permission_user_user_id_index` (`user_id`),
  CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_user`
--

LOCK TABLES `permission_user` WRITE;
/*!40000 ALTER TABLE `permission_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'Can View Users','view.users','Can view users','Permission','2017-05-04 01:08:54','2017-05-04 01:08:54'),(2,'Can Create Users','create.users','Can create new users','Permission','2017-05-04 01:08:54','2017-05-04 01:08:54'),(3,'Can Edit Users','edit.users','Can edit users','Permission','2017-05-04 01:08:55','2017-05-04 01:08:55'),(4,'Can Delete Users','delete.users','Can delete users','Permission','2017-05-04 01:08:55','2017-05-04 01:08:55');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (2,'test',324,102);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `theme_id` int(10) unsigned NOT NULL DEFAULT '1',
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `twitter_username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github_username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profiles_theme_id_foreign` (`theme_id`),
  KEY `profiles_user_id_index` (`user_id`),
  CONSTRAINT `profiles_theme_id_foreign` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`),
  CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (20,48,1,NULL,NULL,NULL,NULL,NULL,0,'2017-05-13 03:27:01','2017-05-13 03:27:01'),(21,49,1,NULL,NULL,NULL,NULL,NULL,0,'2017-05-13 04:44:36','2017-05-13 04:44:36'),(22,50,1,NULL,NULL,NULL,NULL,'/images/profile/50/avatar/avatar.jpg',1,'2017-05-16 23:38:32','2017-06-03 00:31:14'),(23,54,1,NULL,NULL,NULL,NULL,NULL,1,'2017-05-28 20:28:24','2017-05-28 22:00:21'),(26,56,1,NULL,NULL,NULL,NULL,NULL,0,'2017-06-09 20:57:31','2017-06-09 20:57:31'),(28,82,1,NULL,NULL,NULL,NULL,'/uploads/users/id/82/avatar/avatar.png',1,'2017-10-24 00:47:16','2017-11-07 22:11:20'),(30,87,1,NULL,NULL,NULL,NULL,NULL,0,'2017-10-24 21:40:47','2017-10-24 21:40:47'),(33,57,1,NULL,NULL,NULL,NULL,NULL,0,'2017-11-18 00:48:40','2017-11-18 00:48:40'),(34,90,1,NULL,NULL,NULL,NULL,NULL,0,'2017-12-13 19:55:44','2017-12-13 19:55:44'),(39,102,0,NULL,NULL,NULL,NULL,'/uploads/users/id/102/avatar/avatar.png',1,'2018-02-21 13:50:48','2018-04-11 11:12:03'),(40,105,1,NULL,NULL,NULL,NULL,'/uploads/users/id/105/avatar/avatar.png',1,'2018-03-19 00:56:34','2018-03-20 09:14:00'),(45,112,1,NULL,NULL,NULL,NULL,NULL,0,'2018-03-27 15:59:21','2018-03-27 15:59:21'),(46,113,1,NULL,NULL,NULL,NULL,NULL,0,'2018-04-15 08:05:35','2018-04-15 08:05:35'),(47,114,1,NULL,NULL,NULL,NULL,NULL,0,'2018-04-15 08:29:07','2018-04-15 08:29:07');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `properties`
--

DROP TABLE IF EXISTS `properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `price` varchar(20) DEFAULT NULL,
  `propertyDescription` varchar(3000) DEFAULT NULL,
  `topBullets` varchar(500) DEFAULT NULL,
  `bulletsInterior` varchar(500) DEFAULT NULL,
  `bulletsExterior` varchar(500) DEFAULT NULL,
  `bulletsDimentions` varchar(500) DEFAULT NULL,
  `backgroundName` varchar(300) DEFAULT NULL,
  `geolocation` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `properties`
--

LOCK TABLES `properties` WRITE;
/*!40000 ALTER TABLE `properties` DISABLE KEYS */;
INSERT INTO `properties` VALUES (48,65,'1610 Westminster Place, Ann Arbor, MI, United States','12342','uyf fiuyf fu fkkufyugf kykf gyjgjhghjg hj jkkjjvj vf hjf jkykf jkfhjf fjfdhdjgnf kyfuif itd ityd iut fiufiufuuyf fiuyf fu fkkufyugf kykf gyjgjhghjg hj jkkjjvj vf hjf jkykf jkfhjf fjfdhdjgnf kyfuif itd ityd iut fiufiufu uyf fiuyf fu fkkufyugf kykf gyjgjhghjg hj jkkjjvj vf hjf jkykf jkfhjf fjfdhdjgnf kyfuif itd ityd iut fiufiufu uyf fiuyf fu fkkufyugf kykf gyjgjhghjg hj jkkjjvj vf hjf jkykf jkfhjf fjfdhdjgnf kyfuif itd ityd iut fiufiufu uyf fiuyf fu fkkufyugf kykf gyjgjhghjg hj jkkjjvj vf hjf jkykf jkfhjf fjfdhdjgnf kyfuif itd ityd iut fiufiufu uyf fiuyf fu fkkufyugf kykf gyjgjhghjg hj jkkjjvj vf hjf jkykf jkfhjf fjfdhdjgnf kyfuif itd ityd iut fiufiufu','[\"Large Backyard\",\"Garden Terece\"]','[\"Full Kitchen\",\"10 bathrooms\"]','[\"Large Backyard\",\"pool\",\"spa\"]','[\"Living room: 12x10\",\"dining room: 12x10\"]',NULL,'[\"42.262229\",\"-83.735324\"]'),(53,82,'8814 Rosewood Avenue, Los Angeles, CA, United States','1995000','Live in one of the most desirable areas in all of Los Angeles. This stunning contemporary Spanish home includes 2 bed/2 baths, designer kitchen with marble counters & professional appliances. Property has been upgraded throughout: hardwood floors, recessed lighting, french-doors in dining room opens to intimate garden patio. Custom built-in closets in bedrooms. Surround sound throughout home and exterior. Four camera hardwired security system with custom designed Crestron Control home automation system. French door exits from both bedrooms leading out to entertainers backyard with saltwater pool, surrounded by lit dining area and entertaining space with custom built fire pit. Professionally designed drought tolerant landscaping on auto-drip system. LED exterior lighting surrounds property.','[\"2 Bedroom\",\"2 Bathroom\"]','[\"Recessed lighting\",\"Dishwashwer\"]','[\"Pool\",\"Bonus Room\"]','[\"10x12\",\"12x14\"]',NULL,NULL),(54,82,'3658 Twin Lake Ridge, Westlake Village, CA, United States','1995995',NULL,'[\"4 Bedroom\",\"4 Bathroom\",\"Pool & Spa\"]','[]','[]','[]',NULL,'[\"34.138128\",\"-118.828439\"]'),(83,65,'147 Kalamazoo Avenue, Petoskey, MI, United States','1,995,000','Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero. Its words and letters have been changed by addition or removal, so to deliberately render its content nonsensical; it\'s not genuine, correct, or comprehensible Latin anymore. While lorem ipsum\'s still resembles classical Latin, it actually has no meaning whatsoever. As Cicero\'s text doesn\'t contain the letters K, W, or Z, alien to latin, these, and others are often inserted randomly to mimic the typographic appearence of European languages, as are digraphs not to be found in the original.','[\"2 bathrooms\"]','[\"Interior: 20 squre feet\",\"test 1\"]','[\"test111\",\"test222\"]','[\"room dem1\",\"room dem2\"]',NULL,'[45.3687365,-84.9453407]'),(84,87,'3687 Mission Street, San Francisco, CA, United States','123456','srgrg rsgsg sgsrgsgsgsdg','[\"3 bedrooms\",\"4 bathrooms\",\"pool\"]','[]','[]','[]',NULL,'[37.7376374,-122.4239147]'),(85,57,'2464 Tennyson Parkway, Plano, TX, United States','3,455,675',NULL,'[]','[]','[]','[]',NULL,'[33.0652825,-96.7931154]'),(86,102,'test street address','123,123','description','[\"2 baths\"]','[\"Interior 333ftsq\",\"Tiled Bathroom\"]','[]','[]',NULL,NULL);
/*!40000 ALTER TABLE `properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propertyImages`
--

DROP TABLE IF EXISTS `propertyImages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `propertyImages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `imageName` varchar(300) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `propertyId` int(11) DEFAULT NULL,
  `tempRandomString` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propertyImages`
--

LOCK TABLES `propertyImages` WRITE;
/*!40000 ALTER TABLE `propertyImages` DISABLE KEYS */;
INSERT INTO `propertyImages` VALUES (122,65,'/uploads/users/id/65/propertyImages/propertyImage65e1351431e039abeff0fb0e92f6bd4c.jpg','2017-11-03 01:03:33',48,NULL),(123,65,'/uploads/users/id/65/propertyImages/propertyImage931d87d1a55bf1f155e84198cdbf9ff9.jpg','2017-11-03 01:03:33',48,NULL),(124,65,'/uploads/users/id/65/propertyImages/propertyImage5660575f64ec6a5f5b049f9b262bf357.jpg','2017-11-03 01:04:49',48,NULL),(125,65,'/uploads/users/id/65/propertyImages/propertyImage169a80826c77810c878eddaca93731e1.jpg','2017-11-03 01:18:49',48,NULL),(127,82,'/uploads/users/id/82/propertyImages/propertyImaged8b4c44eb8e78ba80c1953e9bbdf45b4.jpg','2017-11-07 20:27:24',53,NULL),(128,82,'/uploads/users/id/82/propertyImages/propertyImaged698edbb8af9916032ebdd5da9d26200.jpg','2017-11-07 20:27:26',53,NULL),(129,82,'/uploads/users/id/82/propertyImages/propertyImagea68043705fbd1eb2f48b50c3d9fbf822.jpg','2017-11-07 20:27:26',53,NULL),(132,82,'/uploads/users/id/82/propertyImages/propertyImage13442d7e28fe17c301c21f7a454e99d4.jpg','2017-11-07 20:27:28',53,NULL),(133,82,'/uploads/users/id/82/propertyImages/propertyImagedc1a927b3c222092a89c458c245f4918.jpg','2017-11-07 20:27:29',53,NULL),(134,82,'/uploads/users/id/82/propertyImages/propertyImagee9cb67a7f0d38327a164fdb58dc46e24.jpg','2017-11-07 20:27:30',53,NULL),(135,82,'/uploads/users/id/82/propertyImages/propertyImage26c9668587e6c1b8c52457f50be1c3d4.jpg','2017-11-07 20:27:31',53,NULL),(137,82,'/uploads/users/id/82/propertyImages/propertyImage14c62c41bec1060828513e02b83b53a9.jpg','2017-11-07 20:27:33',53,NULL),(139,82,'/uploads/users/id/82/propertyImages/propertyImagec2f56fdc4c8313190e19d37fe12cc2dd.jpg','2017-11-07 20:27:34',53,NULL),(145,82,'/uploads/users/id/82/propertyImages/propertyImagea8d520e25f46e391c361cad252ad55b8.jpg','2017-11-07 20:27:41',53,NULL),(146,82,'/uploads/users/id/82/propertyImages/propertyImage40000f03b66c83b747e52024c3b4e70c.jpg','2017-11-07 20:27:44',53,NULL),(147,82,'/uploads/users/id/82/propertyImages/propertyImage1bd46a6be9b2a6da7793ad7d76fcd718.jpg','2017-11-07 20:27:44',53,NULL),(149,82,'/uploads/users/id/82/propertyImages/propertyImage3ce880686e9a28a8bcb6526bf2e810e9.jpg','2017-11-07 20:27:48',53,NULL),(154,82,'/uploads/users/id/82/propertyImages/propertyImage6362d25870bbddc0ce10b9030f1409d6.jpg','2017-11-07 22:16:24',54,NULL),(155,82,'/uploads/users/id/82/propertyImages/propertyImage8e61bb77147ae576dc320d44b83fcde2.jpg','2017-11-07 22:16:24',54,NULL),(156,82,'/uploads/users/id/82/propertyImages/propertyImageabfe270735f68eaf8ca60e1c6d809b8a.jpg','2017-11-07 22:16:25',54,NULL),(157,82,'/uploads/users/id/82/propertyImages/propertyImage46ddc82de3f90ac6e5cedd3c68a0e2b0.jpg','2017-11-07 22:16:25',54,NULL),(158,82,'/uploads/users/id/82/propertyImages/propertyImage97b919642b491115aa11cd37edf9058f.jpg','2017-11-07 22:16:26',54,NULL),(159,82,'/uploads/users/id/82/propertyImages/propertyImage0d705213efbca9148fcac0d39390478c.jpg','2017-11-07 22:16:27',54,NULL),(160,82,'/uploads/users/id/82/propertyImages/propertyImage0a5ad15b250439c89a41e8747a9b292a.jpg','2017-11-07 22:16:28',54,NULL),(161,82,'/uploads/users/id/82/propertyImages/propertyImage408ee531deeaa54c2fe59273fbd750b5.jpg','2017-11-07 22:16:28',54,NULL),(162,65,'/uploads/users/id/65/propertyImages/propertyImage007356952ce4dc04beb29bce565eed35.jpg','2017-11-13 02:30:02',83,'14f40aad4aa1b0768f46146b8ce040c2'),(163,65,'/uploads/users/id/65/propertyImages/propertyImagea43e4a584ee600e7aed451875ac5811e.jpg','2017-11-13 02:43:05',83,NULL),(164,65,'/uploads/users/id/65/propertyImages/propertyImage82512ce46c655b86ac6b921be61d0e77.jpg','2017-11-13 02:43:05',83,NULL),(165,65,'/uploads/users/id/65/propertyImages/propertyImageaad9c2f80ba11a580b8df55415f20870.jpg','2017-11-13 02:43:12',83,NULL),(166,65,'/uploads/users/id/65/propertyImages/propertyImage9f922e86143a1a3c79617842c16dde53.jpg','2017-11-13 02:47:11',83,NULL),(167,65,'/uploads/users/id/65/propertyImages/propertyImageb520035d5cb44b4a703f5c96890cd19d.jpg','2017-11-13 02:47:13',83,NULL),(168,65,'/uploads/users/id/65/propertyImages/propertyImage3d3ff328aa43f77cb9c521866848e298.jpg','2017-11-13 02:47:25',83,NULL),(169,65,'/uploads/users/id/65/propertyImages/propertyImage7367aa57839dd995020ce066d828a642.jpg','2017-11-13 02:47:26',83,NULL),(170,65,'/uploads/users/id/65/propertyImages/propertyImaged0bb39b423739e42fc83b7e00370efca.jpg','2017-11-13 02:47:38',83,NULL),(171,65,'/uploads/users/id/65/propertyImages/propertyImagec61c8e16d2a81492c662049fde8e7d93.jpg','2017-11-13 02:47:43',83,NULL),(172,65,'/uploads/users/id/65/propertyImages/propertyImage1f1710a3c7df6f023876dce510e3413c.jpg','2017-11-13 02:49:42',83,NULL),(173,65,'/uploads/users/id/65/propertyImages/propertyImaged96fcb8627d5b51a632104259e67a7aa.jpg','2017-11-13 02:49:47',83,NULL),(174,65,'/uploads/users/id/65/propertyImages/propertyImagef9e8e8ef2f3e6274292d885412576035.jpg','2017-11-13 02:49:57',83,NULL),(175,65,'/uploads/users/id/65/propertyImages/propertyImaged86439627d164067f66880070b2c8518.jpg','2017-11-13 02:50:00',83,NULL),(176,65,'/uploads/users/id/65/propertyImages/propertyImagec4fabd00c607bca2ef05d8e5bbaf64c7.jpg','2017-11-13 02:50:04',83,NULL),(177,65,'/uploads/users/id/65/propertyImages/propertyImage9c089f57c7dde29449dc08b11344b07c.jpg','2017-11-13 02:50:09',83,NULL),(178,82,'/uploads/users/id/82/propertyImages/propertyImage4b0c14c1494073d29ea0eb862bd48596.jpg','2017-11-13 20:11:29',53,NULL),(179,82,'/uploads/users/id/82/propertyImages/propertyImage8134276c9efe23f19c91042d4e3f15cf.jpg','2017-11-13 20:11:29',53,NULL),(180,82,'/uploads/users/id/82/propertyImages/propertyImage1996f5c344e1057c77994714437a5880.jpg','2017-11-13 20:11:30',53,NULL),(181,82,'/uploads/users/id/82/propertyImages/propertyImagec1d6b5121a8c9a635ec2048a02657f4f.jpg','2017-11-13 20:11:31',53,NULL),(182,82,'/uploads/users/id/82/propertyImages/propertyImage4fbb83f9bafbedcdf41453d8f58a1781.jpg','2017-11-13 20:11:32',53,NULL),(183,82,'/uploads/users/id/82/propertyImages/propertyImage91d55bc5ee5ca9abbd1f974518f2ab3c.jpg','2017-11-13 20:11:33',53,NULL),(184,82,'/uploads/users/id/82/propertyImages/propertyImaged2ed4fe5fbcc5d86c4d6a3e66be626b4.jpg','2017-11-13 20:11:33',53,NULL),(185,102,'/uploads/users/id/102/propertyImages/propertyImagef4374805341c6c09828d726b1f8876b3.jpg','2018-02-24 13:23:06',86,'a86229190b983b755df91e2259e53b21'),(186,87,'/uploads/users/id/87/propertyImages/propertyImage2bb0dafd71b688d6cfb138c42dd41409.jpg','2018-04-20 23:01:34',84,NULL);
/*!40000 ALTER TABLE `propertyImages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_role_id_index` (`role_id`),
  KEY `role_user_user_id_index` (`user_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (41,1,48,'2017-05-13 03:27:00','2017-05-13 03:27:00'),(43,2,49,'2017-05-13 04:44:36','2017-05-13 04:44:36'),(45,1,50,'2017-05-16 23:38:32','2017-05-16 23:38:32'),(50,2,54,'2017-05-28 20:28:24','2017-05-28 20:28:24'),(55,2,56,'2017-06-09 20:57:31','2017-06-09 20:57:31'),(57,3,58,'2017-07-07 23:28:47','2017-07-07 23:28:47'),(66,3,66,'2017-08-05 15:05:51','2017-08-05 15:05:51'),(83,1,82,'2017-10-24 00:47:16','2017-10-24 00:47:16'),(90,2,87,'2017-10-24 21:40:47','2017-10-24 21:40:47'),(96,2,57,'2017-11-18 00:48:40','2017-11-18 00:48:40'),(98,2,90,'2017-12-13 19:55:44','2017-12-13 19:55:44'),(115,1,102,'2018-02-21 13:50:48','2018-02-21 13:50:48'),(116,3,103,'2018-03-10 01:52:14','2018-03-10 01:52:14'),(117,3,104,'2018-03-16 01:35:41','2018-03-16 01:35:41'),(119,2,105,'2018-03-19 00:56:34','2018-03-19 00:56:34'),(129,3,111,'2018-03-27 15:55:28','2018-03-27 15:55:28'),(131,2,112,'2018-03-27 15:59:21','2018-03-27 15:59:21'),(133,2,113,'2018-04-15 08:05:35','2018-04-15 08:05:35'),(135,2,114,'2018-04-15 08:29:07','2018-04-15 08:29:07');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','admin','Admin Role',5,'2017-05-04 01:08:55','2017-05-04 01:08:55'),(2,'User','user','User Role',1,'2017-05-04 01:08:55','2017-05-04 01:08:55'),(3,'Unverified','unverified','Unverified Role',0,'2017-05-04 01:08:55','2017-05-04 01:08:55');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shippingPlans`
--

DROP TABLE IF EXISTS `shippingPlans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shippingPlans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `shippingPlansJson` varchar(2000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shippingPlans`
--

LOCK TABLES `shippingPlans` WRITE;
/*!40000 ALTER TABLE `shippingPlans` DISABLE KEYS */;
INSERT INTO `shippingPlans` VALUES (2,102,'[[\"3 to 5 Days\",\"8.99\"],[\"2 Days\",\"19.99\"],[\"1 Day\",\"39.99\"]]');
/*!40000 ALTER TABLE `shippingPlans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_logins`
--

DROP TABLE IF EXISTS `social_logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_logins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `provider` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `social_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `social_logins_user_id_index` (`user_id`),
  CONSTRAINT `social_logins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_logins`
--

LOCK TABLES `social_logins` WRITE;
/*!40000 ALTER TABLE `social_logins` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_logins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscriptions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
INSERT INTO `subscriptions` VALUES (17,44,'main','sub_Ae2GhfcemPSl5M','monthlyPremium',1,NULL,NULL,'2017-05-13 00:16:59','2017-05-13 00:16:59'),(18,45,'main','sub_Ae2eZkEbhDkupY','monthlyPremium',1,NULL,NULL,'2017-05-13 00:40:23','2017-05-13 00:40:23'),(19,48,'main','sub_Ae5ddp2YJvJeXq','monthlyPremium',1,NULL,'2017-06-13 03:45:54','2017-05-13 03:45:54','2017-05-13 03:46:58'),(20,49,'main','sub_Ae6ckxnR5IZ3e5','monthlyPremium',1,NULL,NULL,'2017-05-13 04:46:38','2017-05-13 04:46:38'),(21,50,'main','sub_Aly85y0UdItEjx','monthlyPremium',1,NULL,'2017-07-03 00:32:21','2017-06-03 00:32:22','2017-06-03 00:40:02'),(22,65,'main','sub_B3x0PAwRVvyFdk','monthlyPremium',1,NULL,'2017-10-16 00:34:50','2017-07-21 00:34:50','2017-10-26 20:03:49'),(23,65,'main','sub_Bebw6ZN6c4hVlR','monthlyPremium',1,NULL,'2017-10-17 21:16:26','2017-10-26 21:16:27','2017-10-26 21:30:43'),(24,65,'main','sub_Bee46WVFFLZcNo','monthlyPremium',1,NULL,'2017-10-09 23:28:37','2017-10-26 23:28:38','2017-11-26 06:11:44'),(25,102,'main','sub_CRADCbIcUH9lCu','monthlyPremium',1,NULL,'2018-11-15 00:00:00','2018-03-05 11:54:13','2018-03-05 11:54:13');
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `themes`
--

DROP TABLE IF EXISTS `themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `themes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `taggable_id` int(10) unsigned NOT NULL,
  `taggable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `themes_name_unique` (`name`),
  UNIQUE KEY `themes_link_unique` (`link`),
  KEY `themes_taggable_id_taggable_type_index` (`taggable_id`,`taggable_type`),
  KEY `themes_id_index` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `themes`
--

LOCK TABLES `themes` WRITE;
/*!40000 ALTER TABLE `themes` DISABLE KEYS */;
INSERT INTO `themes` VALUES (1,'Default','null',NULL,1,1,'theme','2017-05-04 01:08:55','2017-05-04 01:08:56',NULL),(2,'Darkly','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/darkly/bootstrap.min.css',NULL,1,2,'theme','2017-05-04 01:08:55','2017-05-04 01:08:56',NULL),(3,'Cyborg','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cyborg/bootstrap.min.css',NULL,1,3,'theme','2017-05-04 01:08:55','2017-05-04 01:08:56',NULL),(4,'Cosmo','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cosmo/bootstrap.min.css',NULL,1,4,'theme','2017-05-04 01:08:55','2017-05-04 01:08:56',NULL),(5,'Cerulean','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cerulean/bootstrap.min.css',NULL,1,5,'theme','2017-05-04 01:08:55','2017-05-04 01:08:56',NULL),(6,'Flatly','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css',NULL,1,6,'theme','2017-05-04 01:08:55','2017-05-04 01:08:56',NULL),(7,'Journal','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/journal/bootstrap.min.css',NULL,1,7,'theme','2017-05-04 01:08:55','2017-05-04 01:08:56',NULL),(8,'Lumen','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/lumen/bootstrap.min.css',NULL,1,8,'theme','2017-05-04 01:08:56','2017-05-04 01:08:56',NULL),(9,'Paper','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/paper/bootstrap.min.css',NULL,1,9,'theme','2017-05-04 01:08:56','2017-05-04 01:08:56',NULL),(10,'Readable','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/readable/bootstrap.min.css',NULL,1,10,'theme','2017-05-04 01:08:56','2017-05-04 01:08:56',NULL),(11,'Sandstone','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/sandstone/bootstrap.min.css',NULL,1,11,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(12,'Simplex','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/simplex/bootstrap.min.css',NULL,1,12,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(13,'Slate','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/slate/bootstrap.min.css',NULL,1,13,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(14,'Spacelab','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/spacelab/bootstrap.min.css',NULL,1,14,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(15,'Superhero','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/superhero/bootstrap.min.css',NULL,1,15,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(16,'United','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/united/bootstrap.min.css',NULL,1,16,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(17,'Yeti','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/yeti/bootstrap.min.css',NULL,1,17,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(18,'Bootstrap 4.0.0 Alpha','https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css',NULL,1,18,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(19,'Materialize','https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css',NULL,1,19,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(20,'Bootstrap Material Design 0.3.0','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/material-fullpalette.min.css',NULL,1,20,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(21,'Bootstrap Material Design 0.5.10','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/bootstrap-material-design.min.css',NULL,1,21,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(22,'Bootstrap Material Design 4.0.0','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/4.0.0/bootstrap-material-design.min.css',NULL,1,22,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(23,'Bootstrap Material Design 4.0.2','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/4.0.2/bootstrap-material-design.min.css',NULL,1,23,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(24,'mdbootstrap','https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.3.1/css/mdb.min.css',NULL,1,24,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(25,'bootflat','https://cdnjs.cloudflare.com/ajax/libs/bootflat/2.0.4/css/bootflat.min.css',NULL,1,25,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(26,'flat-ui','https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/flat-ui.min.css',NULL,1,26,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL),(27,'m8tro-bootstrap','https://cdnjs.cloudflare.com/ajax/libs/m8tro-bootstrap/3.3.7/m8tro.min.css',NULL,1,27,'theme','2017-05-04 01:08:56','2017-05-04 01:08:57',NULL);
/*!40000 ALTER TABLE `themes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userAssignedIndustries`
--

DROP TABLE IF EXISTS `userAssignedIndustries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userAssignedIndustries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `industryNumber` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userAssignedIndustries`
--

LOCK TABLES `userAssignedIndustries` WRITE;
/*!40000 ALTER TABLE `userAssignedIndustries` DISABLE KEYS */;
INSERT INTO `userAssignedIndustries` VALUES (11,105,1),(12,105,2),(25,102,1),(28,102,2);
/*!40000 ALTER TABLE `userAssignedIndustries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `signup_ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signup_confirmation_ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signup_sm_ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `companyUrl` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userAvatar` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `industry` int(1) NOT NULL DEFAULT '1',
  `randomUserLink` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `leads` int(11) NOT NULL DEFAULT '0',
  `stripe_active` tinyint(4) NOT NULL DEFAULT '0',
  `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_subscription` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_plan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_four` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `subscription_ends_at` timestamp NULL DEFAULT NULL,
  `card_brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripeKey` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_name_unique` (`name`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (48,'elliotrtesting','elron','hubbard','elliotrtesting@outlook.com','$2y$10$VE69pD5VHvNozCfzQKpix.YIBqW5QmP9WL13bLAmWqzRjnH1fvoA6','OLbRQSosdQIMmQm36bRuuzMoakZG2a5XStmaJ7jzh8EjrAnm6ApmR84B0U7E',1,'VexhTewsc2qFmPn2kCDHvASKAjFbpBNtJPjybN8BUgogBmtoSK9xvliUOc6XVpT2','0.0.0.0','0.0.0.0',NULL,NULL,NULL,'172.14.184.167','2017-05-13 03:26:50','2017-05-26 20:15:15','2017-05-26 20:15:15','test',NULL,'393293239829',NULL,1,'KVnvOdnGnOuRM8HkDTegrw',3,2,0,'cus_Ae5dLveMLpa8F4',NULL,NULL,NULL,NULL,NULL,'Visa','4242',''),(49,'adfdadf','adfdadftesttt','adfdadf','eerxdr@gmail.com','$2y$10$iw.cranpH5YIS7sjlCpOv.QI.eQsUD8tJSLPL6il..QhoFTejdh/e',NULL,1,'4S7R6bF26ZS9eeH1IkHqMbftxHuVMsds8LWvEopBzqiar3Ijn8xwuWWwQyWeoq5F','0.0.0.0','0.0.0.0',NULL,NULL,NULL,'172.14.184.167','2017-05-13 04:43:15','2017-05-26 20:15:19','2017-05-26 20:15:19','adfdadf',NULL,'2432432432423',NULL,1,'yjKcj9sAmdvJJjX60lVucI',0,0,0,'cus_Ae6cmKRPwa2hsK',NULL,NULL,NULL,NULL,NULL,'Visa','4242',''),(50,'Elliot Roberts22','Elliot','Roberts','elliotrold@gmail.com','$2y$10$t/Tsx3mpqvb7CFprkJwOsOiSm4eW3zXgvUnC4DibwiS/iN08chQw.','wMrJDsEeguJ3qCnLB0NjXwsrjfzEnSR5De92Fc34LiUXg4gUlilvJAgu17sU',1,'UtnoqGFPqxRcHWJIQAzlSWGJHc7IxmtCQxUap0Gdf9bOjDHauCaCVl2giVyNtg6U','0.0.0.0','0.0.0.0',NULL,NULL,'172.14.184.167',NULL,'2017-05-16 23:37:14','2017-06-03 00:32:21',NULL,'test','1111','2316755925',NULL,1,'rbyrwT90eMm5r8oB3MCmZP',0,1,0,'cus_Aly7a9uq5srzmK',NULL,NULL,NULL,NULL,NULL,'Visa','4242',''),(54,'Doug the bug','doug','bug','asdf@gmail.com','$2y$10$Md/lmlDs6KbvhsyHGrwmy.rd8cAyvGaFhF1EaPDIOLW.vZ6srjBxm',NULL,1,'lnSMvgb8tvOKlG61DA2lBz8VbhVBEReWYcF83loVsUSmhhxOoZagJpbb4eSgHk7n','172.14.184.167','172.14.184.167',NULL,NULL,'172.14.184.167',NULL,'2017-05-28 20:28:12','2017-05-28 21:37:08',NULL,'bug inc',NULL,'382932928432929',NULL,1,'bI3Q2RVv6tEfHOs9iYLuPr',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,''),(56,'testElliot','elliottest','elliotroberttest','THISISMAINADMIN@gmail.com','$2y$10$Tv9oO.POMWcuYhlOQiSXvOFhEp6SM6BcoEpcSbJTjJH79aju.zakW','MCYYuCyRvi43pE7dcHqj41oaiExcJXDkCEENnFSjefHOTqeboKmoYSyHCGkI',1,'aZuIsfOECdKarJvESbtLRC3OhL9UKDt2wgkxzMwGdN1rQx8Ilg8onoOuPOtY9c9e','107.77.109.119','107.77.109.119',NULL,NULL,NULL,NULL,'2017-06-09 20:57:16','2017-06-09 20:57:31',NULL,'none',NULL,'39383498349',NULL,1,'Orbm8g8RYvQT4U64IGdcZ7',0,6,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,''),(57,'Jackcolton','Jack','Colton','jcoltonlv@gmail.com','$2y$10$Ur.l5GpbirgP4JpUqGH2buJFwbo5TiHpU0rOBntcf97K0QJoXkrPq','Ok0zZX9lO5ySjvPhLgUxVcQpmxOCyx8bHasFQE8ZKbfjus4VkNhbFhezracU',1,'caiIrYJsrsEF2wHjz2k7SSSZ9lT8LZBHITeNnUxZateJA4BDWYEoq1h4KfeVzhzn','24.234.246.104','68.108.73.47',NULL,NULL,'68.108.73.47',NULL,'2017-06-19 21:19:19','2017-11-18 00:48:40',NULL,'Company',NULL,'7022834725',NULL,1,'1HjL2W5IdSA7lZjdTnRkjo',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,''),(58,'JamesHom','JamesHomOA','JamesHomOA','springstillmp3@mail.ru','$2y$10$nxwfnuG3z21f2Pp5i2OeBuzWaZVu3gbBRadmgDRDcz4rwRm68nhhW',NULL,0,'oV7aGTgZ3eu0PoTAV81jCjREUquYLyFSEGlAM1YQuRctWqgiet6DQQmsxYtPYn92','194.187.249.29',NULL,NULL,NULL,NULL,NULL,'2017-07-07 23:28:47','2017-07-07 23:28:47',NULL,'google',NULL,'81799552767',NULL,1,'H7sty8Tq9jyWPgKBSORCVm',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,''),(66,'JohnnieTycle','JohnnieTycleEB','JohnnieTycleEB','robercarlos22@mail.ru','$2y$10$/XV/078lgZSZrIWYz8ecou6rqOYweG61ny4oPdFt7PAVAuBii30Dy',NULL,0,'NQsGPOzkh0jVYFwtDTgXbUDrN7UkQQFdV3ViUeZ4kpbn2nT062DnpSNFa6cKTvHc','185.93.183.215',NULL,NULL,NULL,NULL,NULL,'2017-08-05 15:05:51','2017-08-05 15:05:51',NULL,'google',NULL,'87146373941',NULL,1,'vAGgnUo5hcYX4odHpP3gM5',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,''),(82,'Andrew Pour','Andrew','Pour','andrewpour@gmail.com','$2y$10$2tMRpBlj81/fZPRDxrsg7eNzbrtx2hbT4noPbtPVNyft/Mz.ROJAq','IKGWEK2hhSx1ZAEWKOPOFptbrr8yoV4LNSGCuvqQkX8eb05z8cupNX23xGQZ',1,'rhT2NHtpDwz58yMyl6fG1CIKbdkZIbk7KPxkDgRgLhYH8SCZjMuqrLdSFUKqxOWd','162.205.132.114','162.205.132.114',NULL,NULL,'108.185.173.119',NULL,'2017-10-24 00:46:28','2017-11-07 22:11:20',NULL,'Real Estate Co',NULL,'8055732481',NULL,1,'knolRHxTkoL7iwOGR6hRbs',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,''),(87,'Testaccount','Test','Account','testttt@mediabandit.com','$2y$10$4WSvRtNbAbdXW8/bNmzaHuQUAVkLW3nO39n7nLyfo.bgAslqeLYka','EBv6w87TANHNSwsGERl79IFTAIxhxzpEcG2GdocoV1UWVa5snAZgxPC9Sjxd',1,'gLNlt6MDg1iZIih62ce5NjA4wOwaeCzoRGqwNJrjl88t9wg74aqqjNV34Zkp3q1L','216.31.244.18','216.31.244.18',NULL,NULL,NULL,NULL,'2017-10-24 21:31:41','2017-10-24 21:40:47',NULL,'Testtttt',NULL,'8374738283',NULL,1,'DX91OSRbqZQpgJPr7TSoPD',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,''),(90,'larrywfox','Larry','Fox','larrywfox@aol.com','$2y$10$BOVgIubQa0otDp4AkcMBrOPJda534/OE2kpHXtEN8Q5z81NvBRvFa','HAQjxWrBjp9vGbhLvTAZVU7iPrERFlMt45gZubOsucjRqPJ9cPnX4kXftlzo',1,'rNj6TpVxY5A5WxHGYo6DSTNtDhmnVkq76mM6t1QToCwoH4sybX34R421C91ZWfFq','73.99.125.212','73.99.125.212',NULL,NULL,NULL,NULL,'2017-12-13 19:54:48','2017-12-13 19:55:44',NULL,'Long Term Health',NULL,'540-830-0195',NULL,1,'3yJFMAKmsquoRaUKfv9EGX',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,''),(102,'elliot robert','Elliot','Robert','elliotr@gmail.com','$2y$10$muIVtYR3Tq7NZ8yAT7hLX.PEObGgUolJeWrHy8pGTWwG6DvU6J4ci','AolQX6c7oS2WXm8uVwdVfJfYCv3AxXKACCP9DU7FFOdxfBNYib2Eb8SnAJHN',1,'Xy3qTLu7qJUlaKp2sFb0mDiWzupNgKOsHNUuz3gntYtTf47LtdPPRHcgQBLrlV29','14.191.127.68','14.191.127.68',NULL,NULL,'14.175.255.194',NULL,'2018-02-21 13:47:37','2018-04-11 05:26:40',NULL,'Fake Ecommerce Company','11111111111','11133322343---242','/uploads/users/id/102/avatar/userImg.png',2,'UiArYb40ZNzOXZDFTxb0Cy',0,0,0,'cus_CRADoeTYutfAGB',NULL,NULL,NULL,NULL,NULL,'Visa','4242',NULL),(103,'deidreheney','Deidre','Heney','klarrisa@a.get-bitcoins.club','$2y$10$s603QyfO8mK3z0hfHu4DveBt.ye3gljCsxOX8ElN1fHnq7k1KQ5P.',NULL,0,'0uhorTk1KlgOmZ9XBLKEVvqHKgAv1V8Hjomyv42rB3ycTHCOX1yJ1BVfvMm0ebtR','173.234.100.233',NULL,NULL,NULL,NULL,NULL,'2018-03-10 01:52:14','2018-03-10 01:52:14',NULL,'Legg LLC',NULL,'041 920 12 31',NULL,1,'nyHfaEYi96rGrD9UbSrjmy',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,''),(104,'agneshildebrand','Agnes','Hildebrand','aubrey@f.bali-traveller.com','$2y$10$e5QvUJ.aTK.kU4U4TLyKQetV79w8JLDuO/JOXWBU3cmSLC.2AngRy',NULL,0,'NTfMke7bHDfNJfXq5AS3V8SXUV14vIgp5jWQYVQmvqdtqPhXn1HDUTh56ZZtdvos','192.3.183.40',NULL,NULL,NULL,NULL,NULL,'2018-03-16 01:35:41','2018-03-16 01:35:41',NULL,'Hubbs AG',NULL,'(02) 4944 6305',NULL,1,'eG9Nx97MHw2B0o3ggA2Qoa',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,''),(105,'test','test','test','newpages@mediabandit.com','$2y$10$fGsnnEd8rN66mF9s/uDIBuUJRuYBAlMhLr5vLJGeQ033DDgQFDs7C','CZFpixx6HDdmMpdYUv601CA8CDjEdNBEVBc8sBEWatYBDxl1XS1S9rSNnXVS',1,'B4DNujL5VjUxLvtoEj7RvDPh5KL7q8WRyRRdLYQyvUcdhiaZnfTTf0LfkNuVKXLQ','104.172.20.141','104.172.20.141',NULL,NULL,'104.172.20.141',NULL,'2018-03-19 00:54:38','2018-03-27 16:03:12',NULL,'test',NULL,'34546765434',NULL,2,'sKOeQk7Ob1NJZnIsbzgDEn',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,''),(111,'test123','test','test','test123@test.com','$2y$10$.IVbb7uIrf6Q9S8QmI1av.vm9MVwJYET9U94jaGyXm0ApuduXzkdG',NULL,0,'jnrf5PxXYaB1Axyy3c2fGgFjjOIgt0AxJKWNczmZVokzOhLCFnLQbBn2UFk4FJwa','104.172.20.141',NULL,NULL,NULL,NULL,NULL,'2018-03-27 15:55:28','2018-03-27 15:55:28',NULL,'test',NULL,'8055732481',NULL,2,'YxULO6nmVCUn5kOG5xKOFm',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,''),(112,'TonyDIxon','Tony','Dixon','tonydjsf@mediabandit.com','$2y$10$iRWtUE3CEB/iRDqD8gjEIODpzlO/SfJO6yTD.4An9CI8VhFy0wisG','oJ4Gei30GdOllUoShFkCARnid0xv4S8dYjHeYaEdNkzPoDhBtzTUWPDvOOgx',1,'tG7ecL8drrpsHffYLIovuiOXHdY7hvE9rwBRkPjt7RLgSQuZFqHdWDAtzZU90xsR','104.172.20.141','104.172.20.141',NULL,NULL,NULL,NULL,'2018-03-27 15:58:16','2018-03-27 15:59:21',NULL,'Zurixx',NULL,'8055732481',NULL,1,'7wbHhPu6ffFhbyaAEJzsmK',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,''),(113,'test user','testeliot','testrobert','testold.com','$2y$10$emob3ZtLEsfChhsryZ4mNeFk2Xl7u6AUHOzMzZxW/s3deTN/KTiDm',NULL,0,'rZdD97GIascrTDpX8oSoh3MasKSM3eqJRIJtO7NRmCscdcCwxEUDESrsR0tZ3fs6','14.175.255.194','14.175.255.194',NULL,NULL,NULL,NULL,'2018-04-15 08:05:21','2018-04-15 08:05:35',NULL,'comanyfake',NULL,'1234556677',NULL,1,'sZVn1lofBmHC0aPHxyuXmS',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,''),(114,'TTTTT','TTTT','TTTT','elliotOLDr@gmail.com','$2y$10$sdXpa/Mw9WVJt9KlirOeHOnZ5yOuEeKb1vq4pdH5VVCBpYoiKl41y','4xnPMJeRLFjnUr6hmWRWIkjIk6Jh2AOsaTYdCVQvzlnMCcoFgvpVqyn4pASP',1,'D9e1zCStX1duj2SIQX4VZ2tDeycF98w4auj94PaniVEStfbDNdh40XQ9Xuo8WCKi','14.175.255.194','14.175.255.194',NULL,NULL,NULL,NULL,'2018-04-15 08:10:50','2018-04-15 08:29:07',NULL,'ttttt',NULL,'1111111111',NULL,1,'oVqwZ5g4BzzD12SECOJXj5',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'');
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

-- Dump completed on 2018-04-21  9:02:25
