-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: workers
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
-- Table structure for table `errors`
--

DROP TABLE IF EXISTS `errors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `site_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `errors`
--

LOCK TABLES `errors` WRITE;
/*!40000 ALTER TABLE `errors` DISABLE KEYS */;
INSERT INTO `errors` VALUES (1,'2017-06-05 16:16:18',2),(2,'2017-06-05 16:02:11',2),(3,'2017-06-05 13:08:00',2),(4,'2017-06-05 13:08:12',2),(5,'2017-06-05 13:08:18',2),(6,'2017-06-05 13:08:29',2),(7,'2017-06-05 13:08:40',2),(8,'2017-06-05 13:08:46',2),(9,'2017-06-05 13:08:58',2),(10,'2017-06-05 13:09:10',2),(11,'2017-05-05 13:09:21',2),(12,'2017-06-05 13:09:27',17),(13,'2017-06-05 13:09:39',17),(14,'2017-06-05 13:09:50',17),(15,'2017-06-05 13:09:56',17),(16,'2017-06-05 13:10:08',17),(17,'2017-06-05 13:59:27',17),(18,'2017-05-05 16:16:28',1),(66,'2017-06-05 16:24:46',1),(96,'2017-06-05 16:30:22',1),(97,'2017-06-05 16:30:22',1),(98,'2017-06-05 16:30:34',1),(99,'2017-06-05 16:30:44',1),(100,'2017-06-05 16:37:25',1),(101,'2017-06-05 16:37:26',1),(102,'2017-06-05 17:37:47',4),(103,'2017-06-05 17:37:48',5),(104,'2017-06-05 17:38:18',5),(105,'2017-06-05 17:38:21',5),(106,'2017-06-05 18:54:37',6);
/*!40000 ALTER TABLE `errors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inside_url`
--

DROP TABLE IF EXISTS `inside_url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inside_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_link_id` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `url` text NOT NULL,
  `next_date_check` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `inside_url_url_linking_id_fk` (`site_link_id`),
  CONSTRAINT `inside_url_url_linking_id_fk` FOREIGN KEY (`site_link_id`) REFERENCES `url_linking` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inside_url`
--

LOCK TABLES `inside_url` WRITE;
/*!40000 ALTER TABLE `inside_url` DISABLE KEYS */;
INSERT INTO `inside_url` VALUES (1,17,404,'dasdasdas','2017-06-06 01:37:26'),(2,26,404,'http://google.com/sasd','2017-06-06 01:02:11'),(3,26,301,'http://infokolomna.ru/news','2017-06-06 01:02:11'),(4,27,404,'http://some.com/some','2017-06-06 02:37:47'),(5,27,200,'http://some.again.com/somenew','2017-06-06 02:38:21'),(6,28,404,'http://ds.di/dsad','2017-06-06 03:54:37');
/*!40000 ALTER TABLE `inside_url` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `url_linking`
--

DROP TABLE IF EXISTS `url_linking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `url_linking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_url_old` char(255) NOT NULL,
  `site_url_linked_to` char(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `url_linking`
--

LOCK TABLES `url_linking` WRITE;
/*!40000 ALTER TABLE `url_linking` DISABLE KEYS */;
INSERT INTO `url_linking` VALUES (17,'http://sadad.com','http://dsadas.com'),(26,'http://google.com','http://google2.com'),(27,'http://some.com','http://another.com'),(28,'http://so.com','http://das.com');
/*!40000 ALTER TABLE `url_linking` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-05 19:24:55
