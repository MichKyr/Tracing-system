-- MySQL dump 10.13  Distrib 5.6.20, for Win32 (x86)
--
-- Host: localhost    Database: olitrace
-- ------------------------------------------------------
-- Server version	5.6.20

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
-- Table structure for table `bottlingsite`
--

DROP TABLE IF EXISTS `bottlingsite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bottlingsite` (
  `BottlingSiteID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) DEFAULT NULL,
  `OwnerName` varchar(64) DEFAULT NULL,
  `City` varchar(32) DEFAULT NULL,
  `Address` varchar(64) DEFAULT NULL,
  `Coordinates` varchar(128) DEFAULT NULL,
  `Phonenumber` varchar(16) DEFAULT NULL,
  `Photo` varchar(64) DEFAULT NULL,
  `OwnerPhoto` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`BottlingSiteID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bottlingsite`
--

LOCK TABLES `bottlingsite` WRITE;
/*!40000 ALTER TABLE `bottlingsite` DISABLE KEYS */;
INSERT INTO `bottlingsite` VALUES (1,'MUAC','Messinia Union of Agricultural Cooperatives','Thouria','Ethniki Odos Tripoleos Kalamatas','22.051117,37.076691,0.000000','2721011111','./photos/bp-1-botsite3.jpg','./photos/bop-1-botowner.jpg');
/*!40000 ALTER TABLE `bottlingsite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crop`
--

DROP TABLE IF EXISTS `crop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crop` (
  `CropID` int(11) NOT NULL AUTO_INCREMENT,
  `FieldID` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Weight` int(11) DEFAULT NULL,
  PRIMARY KEY (`CropID`),
  KEY `FieldID` (`FieldID`),
  CONSTRAINT `crop_ibfk_1` FOREIGN KEY (`FieldID`) REFERENCES `field` (`FieldID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crop`
--

LOCK TABLES `crop` WRITE;
/*!40000 ALTER TABLE `crop` DISABLE KEYS */;
INSERT INTO `crop` VALUES (1,1,'2014-01-01',100),(2,2,'2014-01-02',110),(3,1,'2014-01-03',130);
/*!40000 ALTER TABLE `crop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extractionsite`
--

DROP TABLE IF EXISTS `extractionsite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extractionsite` (
  `ExtractionSiteID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) DEFAULT NULL,
  `OwnerName` varchar(64) DEFAULT NULL,
  `City` varchar(32) DEFAULT NULL,
  `Address` varchar(64) DEFAULT NULL,
  `Coordinates` varchar(128) DEFAULT NULL,
  `Phonenumber` varchar(16) DEFAULT NULL,
  `Photo` varchar(64) DEFAULT NULL,
  `OwnerPhoto` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`ExtractionSiteID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extractionsite`
--

LOCK TABLES `extractionsite` WRITE;
/*!40000 ALTER TABLE `extractionsite` DISABLE KEYS */;
INSERT INTO `extractionsite` VALUES (1,'02-001','K.Nikolaidis','Sperchogia','Kapou 24','22.058825,37.072956,0.000000','2721000000','./photos/ep-1-extrsite2.jpg','./photos/eop-1-extrowner2.jpeg');
/*!40000 ALTER TABLE `extractionsite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `field`
--

DROP TABLE IF EXISTS `field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `field` (
  `FieldID` int(11) NOT NULL AUTO_INCREMENT,
  `OwnerName` varchar(64) DEFAULT NULL,
  `OwnerEmail` varchar(64) DEFAULT NULL,
  `OwnerPhoto` varchar(64) DEFAULT NULL,
  `Variety` varchar(64) DEFAULT NULL,
  `YearOfEst` int(11) DEFAULT NULL,
  `Coordinates` varchar(600) DEFAULT NULL,
  `Photo` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`FieldID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field`
--

LOCK TABLES `field` WRITE;
/*!40000 ALTER TABLE `field` DISABLE KEYS */;
INSERT INTO `field` VALUES (1,'C.Papazisis','C.Papazisis@oliveo.gr','./photos/fop-1-fieldowner.jpg','Koroneiki',1990,'22.032597,37.227802,0.000000 22.031122,37.228073,0.000000 22.031090,37.227207,0.000000 22.031240,37.227085,0.000000 22.031963,37.226887,0.000000 22.032576,37.226742,0.000000 22.032875,37.226780,0.000000 22.033375,37.226646,0.000000 22.033810,37.226799,0.000000 22.033627,37.227371,0.000000 22.033594,37.227940,0.000000 22.033005,37.227879,0.000000 22.032597,37.227802,0.000000','./photos/fp-1-field.jpg'),(2,'K.Papazissis','K.Papazissis@oliveo.gr','./photos/fop-2-fieldowner2.jpg','Koroneiki',1930,'22.060987,37.075520,0.000000','./photos/fp-2-field2.jpg');
/*!40000 ALTER TABLE `field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fromcrop`
--

DROP TABLE IF EXISTS `fromcrop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fromcrop` (
  `CropID` int(11) NOT NULL DEFAULT '0',
  `LotID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CropID`,`LotID`),
  KEY `LotID` (`LotID`),
  CONSTRAINT `fromcrop_ibfk_1` FOREIGN KEY (`CropID`) REFERENCES `crop` (`CropID`) ON DELETE CASCADE,
  CONSTRAINT `fromcrop_ibfk_2` FOREIGN KEY (`LotID`) REFERENCES `lot` (`LotID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fromcrop`
--

LOCK TABLES `fromcrop` WRITE;
/*!40000 ALTER TABLE `fromcrop` DISABLE KEYS */;
INSERT INTO `fromcrop` VALUES (1,1),(2,2),(3,2);
/*!40000 ALTER TABLE `fromcrop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fromlot`
--

DROP TABLE IF EXISTS `fromlot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fromlot` (
  `PalleteID` int(11) NOT NULL DEFAULT '0',
  `LotID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`PalleteID`,`LotID`),
  KEY `LotID` (`LotID`),
  CONSTRAINT `fromlot_ibfk_1` FOREIGN KEY (`PalleteID`) REFERENCES `pallete` (`PalleteID`) ON DELETE CASCADE,
  CONSTRAINT `fromlot_ibfk_2` FOREIGN KEY (`LotID`) REFERENCES `lot` (`LotID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fromlot`
--

LOCK TABLES `fromlot` WRITE;
/*!40000 ALTER TABLE `fromlot` DISABLE KEYS */;
INSERT INTO `fromlot` VALUES (1,1),(2,2);
/*!40000 ALTER TABLE `fromlot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lot`
--

DROP TABLE IF EXISTS `lot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lot` (
  `LotID` int(11) NOT NULL AUTO_INCREMENT,
  `ExtractionSiteID` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Quality` varchar(32) DEFAULT NULL,
  `Acidity` varchar(32) DEFAULT NULL,
  `Weight` int(11) DEFAULT NULL,
  PRIMARY KEY (`LotID`),
  KEY `ExtractionSiteID` (`ExtractionSiteID`),
  CONSTRAINT `lot_ibfk_1` FOREIGN KEY (`ExtractionSiteID`) REFERENCES `extractionsite` (`ExtractionSiteID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lot`
--

LOCK TABLES `lot` WRITE;
/*!40000 ALTER TABLE `lot` DISABLE KEYS */;
INSERT INTO `lot` VALUES (1,1,'2014-01-02','A','low',80),(2,1,'2014-01-04','A','low',200);
/*!40000 ALTER TABLE `lot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oliveopartner`
--

DROP TABLE IF EXISTS `oliveopartner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oliveopartner` (
  `PartnerID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) DEFAULT NULL,
  `Coordinates` varchar(128) DEFAULT NULL,
  `Country` varchar(32) DEFAULT NULL,
  `City` varchar(32) DEFAULT NULL,
  `Photo` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`PartnerID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oliveopartner`
--

LOCK TABLES `oliveopartner` WRITE;
/*!40000 ALTER TABLE `oliveopartner` DISABLE KEYS */;
INSERT INTO `oliveopartner` VALUES (1,'Mike','22.112461,37.026196,0.000000','Greece','Kalamata','./photos/op-1-person.jpg'),(2,'Naveen Bigdeli','39.134674,21.663172,0.000000','Saudi Arabia','Jeddah','./photos/op-2-oliveopartner2.JPG');
/*!40000 ALTER TABLE `oliveopartner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pallete`
--

DROP TABLE IF EXISTS `pallete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pallete` (
  `PalleteID` int(11) NOT NULL AUTO_INCREMENT,
  `BottlingSiteID` int(11) DEFAULT NULL,
  `PartnerID` int(11) DEFAULT NULL,
  `DateShipped` date DEFAULT NULL,
  `DateBottled` date DEFAULT NULL,
  `QRcode` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`PalleteID`),
  KEY `BottlingSiteID` (`BottlingSiteID`),
  KEY `PartnerID` (`PartnerID`),
  CONSTRAINT `pallete_ibfk_1` FOREIGN KEY (`BottlingSiteID`) REFERENCES `bottlingsite` (`BottlingSiteID`) ON DELETE CASCADE,
  CONSTRAINT `pallete_ibfk_2` FOREIGN KEY (`PartnerID`) REFERENCES `oliveopartner` (`PartnerID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pallete`
--

LOCK TABLES `pallete` WRITE;
/*!40000 ALTER TABLE `pallete` DISABLE KEYS */;
INSERT INTO `pallete` VALUES (1,1,1,'2014-01-09','2014-01-06',NULL),(2,1,2,'2014-01-12','2014-01-10',NULL);
/*!40000 ALTER TABLE `pallete` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-08-31 23:03:02
