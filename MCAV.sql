-- MySQL dump 10.13  Distrib 8.3.0, for macos14.2 (arm64)
--
-- Host: localhost    Database: MCAV
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `action_logs`
--

DROP TABLE IF EXISTS `action_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `action_logs` (
  `logID` int NOT NULL AUTO_INCREMENT,
  `EmployeeWebID` int NOT NULL,
  `UserAction` enum('Create','Delete','Update','Remove','ManageUser','Login','Logout') DEFAULT NULL,
  `AffectedEntityType` enum('Employee_Info','Payment_Plan','Payment_Receipts','Products','Orders','Customers') NOT NULL,
  `AffectedEntityID` int NOT NULL,
  `LogTimestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`logID`),
  KEY `EmployeeWebID` (`EmployeeWebID`),
  CONSTRAINT `action_logs_ibfk_1` FOREIGN KEY (`EmployeeWebID`) REFERENCES `employee_credentials` (`EmployeeWebID`),
  CONSTRAINT `action_logs_chk_1` CHECK ((`UserAction` in (_utf8mb4'Create',_utf8mb4'Delete',_utf8mb4'Update',_utf8mb4'Remove',_utf8mb4'ManageUser'))),
  CONSTRAINT `action_logs_chk_2` CHECK ((`AffectedEntityType` in (_utf8mb4'Employee_Info',_utf8mb4'Payment_Plan',_utf8mb4'Payment_Receipts',_utf8mb4'Products',_utf8mb4'Orders',_utf8mb4'Customers')))
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_logs`
--

LOCK TABLES `action_logs` WRITE;
/*!40000 ALTER TABLE `action_logs` DISABLE KEYS */;
INSERT INTO `action_logs` VALUES (1,12,'Create','Products',38,'2024-07-15 00:52:07'),(2,11,'Create','Orders',19,'2024-07-15 00:55:04'),(3,11,'Create','Orders',20,'2024-07-15 00:55:20'),(4,11,'Create','Orders',21,'2024-07-15 00:55:34'),(5,11,'Create','Payment_Plan',19,'2024-07-15 00:55:34'),(6,11,'Create','Orders',22,'2024-07-15 01:00:14'),(7,11,'Create','Payment_Plan',20,'2024-07-15 01:00:14'),(8,12,'Create','Products',39,'2024-07-15 01:00:14'),(9,12,'Remove','Products',40,'2024-07-15 09:16:24'),(10,12,'Remove','Products',40,'2024-07-15 09:17:16'),(11,12,'Remove','Products',40,'2024-07-15 09:17:19'),(12,12,'Remove','Products',40,'2024-07-15 09:23:12'),(13,13,'Remove','Products',39,'2024-07-15 09:26:32'),(14,13,'Remove','Products',39,'2024-07-15 09:26:35'),(15,12,'Remove','Products',46,'2024-07-15 09:31:44'),(16,12,'Remove','Products',46,'2024-07-15 09:31:47'),(17,11,'Create','Orders',23,'2024-07-15 09:50:08'),(18,11,'Create','Payment_Plan',21,'2024-07-15 09:50:08'),(19,11,'Create','Orders',24,'2024-07-15 09:50:59'),(20,11,'Create','Payment_Plan',22,'2024-07-15 09:50:59'),(21,11,'Create','Orders',25,'2024-07-15 09:52:32'),(22,11,'Create','Payment_Plan',23,'2024-07-15 09:52:32'),(23,12,'Create','Products',47,'2024-07-15 09:52:32'),(24,11,'Create','Orders',26,'2024-07-15 09:52:50'),(25,11,'Create','Payment_Plan',24,'2024-07-15 09:52:50'),(26,12,'Create','Products',48,'2024-07-15 09:52:50'),(27,11,'Create','Orders',27,'2024-07-15 09:52:52'),(28,11,'Create','Payment_Plan',25,'2024-07-15 09:52:52'),(29,12,'Create','Products',49,'2024-07-15 09:52:52'),(30,11,'Create','Orders',28,'2024-07-15 09:53:37'),(31,11,'Create','Payment_Plan',26,'2024-07-15 09:53:37'),(32,11,'Create','Orders',29,'2024-07-15 09:54:05'),(33,11,'Create','Payment_Plan',27,'2024-07-15 09:54:05');
/*!40000 ALTER TABLE `action_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_info_archive`
--

DROP TABLE IF EXISTS `customer_info_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_info_archive` (
  `customerArchiveID` int NOT NULL AUTO_INCREMENT,
  `CustomerID` int NOT NULL,
  `CustomerFname` varchar(32) NOT NULL DEFAULT '',
  `CustomerLname` varchar(32) NOT NULL DEFAULT '',
  `CustomerEmail` varchar(32) NOT NULL DEFAULT '',
  `CustomerPhone` varchar(11) NOT NULL DEFAULT '',
  `ArchiveTimestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`customerArchiveID`),
  KEY `CustomerID` (`CustomerID`),
  CONSTRAINT `customer_info_archive_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_info_archive`
--

LOCK TABLES `customer_info_archive` WRITE;
/*!40000 ALTER TABLE `customer_info_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_info_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `CustomerID` int NOT NULL AUTO_INCREMENT,
  `CustomerFname` varchar(32) NOT NULL DEFAULT '',
  `CustomerLname` varchar(32) NOT NULL DEFAULT '',
  `CustomerEmail` varchar(32) NOT NULL DEFAULT '',
  `CustomerPhone` varchar(11) NOT NULL DEFAULT '',
  PRIMARY KEY (`CustomerID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'John','Doe','john.doe@example.com','1234567890'),(2,'Jane','Smith','jane.smith@example.com','9876543210'),(3,'Michael','Johnson','michael.johnson@example.com','4567890123'),(4,'Emily','Brown','emily.brown@example.com','8901234567'),(5,'David','Martinez','david.martinez@example.com','5678901234'),(6,'Sarah','Garcia','sarah.garcia@example.com','2345678901'),(7,'Kevin','Robinson','kevin.robinson@example.com','6789012345'),(8,'Lisa','Clark','lisa.clark@example.com','3456789012'),(9,'Matthew','Lewis','matthew.lewis@example.com','9012345678'),(10,'Amandars','Walkersa','amanda.walker@example.com','4567890123'),(11,'Johnald','Biden','das@Gmail.com','12312312'),(12,'Massa','Colonels','Gmail@gmail.com','12312'),(13,'heyo','wassupo','gmail@gmail','091783'),(14,'Heyeas','adsf','gmai@gmai.com','231231'),(15,'sd','asd','gmail@gmail.com','1231'),(16,'adfdsf','asdfas','gmail@gmail.com','34123412342'),(17,'fasdfsa','dsfsd','sdfsf@gmail.com','fasdfs');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_credentials`
--

DROP TABLE IF EXISTS `employee_credentials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_credentials` (
  `EmployeeWebID` int NOT NULL AUTO_INCREMENT,
  `EmployeeID` int NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `employee_Password` varchar(255) NOT NULL,
  `UserLevel` int NOT NULL DEFAULT '0',
  `accountStatus` enum('Activated','Deactivated') DEFAULT NULL,
  PRIMARY KEY (`EmployeeWebID`),
  KEY `EmployeeID` (`EmployeeID`),
  CONSTRAINT `employee_credentials_ibfk_2` FOREIGN KEY (`EmployeeID`) REFERENCES `employee_info` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_credentials`
--

LOCK TABLES `employee_credentials` WRITE;
/*!40000 ALTER TABLE `employee_credentials` DISABLE KEYS */;
INSERT INTO `employee_credentials` VALUES (1,1,'john.smith','password1',2,'Activated'),(2,2,'emily.johnson','password2',1,'Activated'),(3,3,'michael.williams','password3',1,'Activated'),(4,4,'sarah.anderson','password4',1,'Activated'),(5,5,'david.martinez','password5',1,'Activated'),(6,6,'lisa.garcia','password6',1,'Activated'),(7,7,'kevin.brown','password7',1,'Activated'),(8,8,'amanda.taylor','password8',1,'Activated'),(9,9,'matthew.moore','password9',0,'Activated'),(10,10,'jessica.walker','password10',0,'Activated'),(11,1,'hello','$2y$10$qYH7d4A1p/VYlJsutpfWieI59BxQEJ6sxc7.P2dyI9IOMKwtMLOHq',0,'Activated'),(12,11,'Gerlo','$2y$10$W8kwHQ5aJe8eEVWD1hH17unYy60MkSl2ZPVtdzzjWQipOgJjLIE0C',0,'Activated'),(13,13,'Suzuki','$2y$10$w8vkT4h84BSVPftM0olfj.ldhihLnD70RCyqoko06gNIo1oGFs.mu',0,'Activated'),(14,14,'TestAdmin','$2y$10$JrVMeW/awDKRBgtJn5g9TeSGQ4V1FCVDuegAWkXzbHXQlx/nqzSz6',0,'Activated'),(15,15,'Test User','$2y$10$CUNex.3NWgyRKoXX/zx7u.5L2fhWXcSeAlsZljyIom2Y9F9.6WgUW',0,'Activated'),(16,16,'tes','$2y$10$ION5kk7Ju3hkkkk6nIxCPuj1O14tHocnO8LcuUtNIBeZ4b4t8zkbm',1,'Activated');
/*!40000 ALTER TABLE `employee_credentials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_info`
--

DROP TABLE IF EXISTS `employee_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_info` (
  `EmployeeID` int NOT NULL AUTO_INCREMENT,
  `ProfilePicturePath` varchar(255) DEFAULT '',
  `EmployeeFirstname` varchar(32) NOT NULL,
  `EmployeeLastname` varchar(32) NOT NULL,
  `EmployeeHireDate` varchar(32) NOT NULL,
  `Gender` enum('M','F') NOT NULL,
  `Position` varchar(32) NOT NULL,
  `WebUserLevel` int NOT NULL,
  `IsRemoved` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`EmployeeID`),
  CONSTRAINT `employee_info_chk_1` CHECK ((`Gender` in (_utf8mb4'M',_utf8mb4'F')))
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_info`
--

LOCK TABLES `employee_info` WRITE;
/*!40000 ALTER TABLE `employee_info` DISABLE KEYS */;
INSERT INTO `employee_info` VALUES (1,'/path/to/picture1.jpg','John','Smith','2023-01-15','M','Manager',3,0),(2,'/path/to/picture2.jpg','Emily','Johnson','2022-08-20','F','Assistant Manager',2,0),(3,'/path/to/picture3.jpg','Michael','Williams','2023-03-10','M','Supervisor',2,0),(4,'/path/to/picture4.jpg','Sarah','Anderson','2022-05-05','F','Team Lead',1,0),(5,'/path/to/picture5.jpg','David','Martinez','2023-02-01','M','Employee',1,0),(6,'/path/to/picture6.jpg','Lisa','Garcia','2022-10-12','F','Employee',1,0),(7,'/path/to/picture7.jpg','Kevin','Brown','2022-07-25','M','Employee',1,0),(8,'/path/to/picture8.jpg','Amanda','Taylor','2023-04-18','F','Employee',1,0),(9,'/path/to/picture9.jpg','Matthew','Moore','2022-11-30','M','Intern',0,0),(10,'/path/to/picture10.jpg','Jessica','Walker','2023-06-08','F','Intern',0,0),(11,'assets/Screenshot 2024-06-21 at 8.43.28 PM.png','he','he','2024-07-10','F','he',0,0),(12,'assets/Screenshot 2024-06-20 at 2.48.04 PM.png','Shion','Suzuki','2024-07-04','F','Developer',0,0),(13,'assets/Screenshot 2024-06-20 at 2.48.04 PM.png','Shion','Suzuki','2024-07-04','F','Developer',0,0),(14,'assets/Screenshot 2024-06-20 at 2.44.34 PM.png','Test','Test','2024-07-14','F','Admin',0,0),(15,'assets/Screenshot 2024-06-20 at 2.45.05 PM.png','312','231','2024-07-12','F','312',0,0),(16,'assets/Screenshot 2024-06-20 at 2.48.04 PM.png','test','test','2024-07-14','F','tes',1,0);
/*!40000 ALTER TABLE `employee_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_info_archive`
--

DROP TABLE IF EXISTS `employee_info_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_info_archive` (
  `employeeArchiveID` int NOT NULL AUTO_INCREMENT,
  `EmployeeID` int NOT NULL,
  `ProfilePicturePath` varchar(255) DEFAULT '',
  `EmployeeFirstname` varchar(32) NOT NULL,
  `EmployeeLastname` varchar(32) NOT NULL,
  `EmployeeHireDate` varchar(32) NOT NULL,
  `Gender` enum('M','F') NOT NULL,
  `Position` varchar(32) NOT NULL,
  `WebUserLevel` int NOT NULL,
  `ArchiveTimestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`employeeArchiveID`),
  KEY `EmployeeID` (`EmployeeID`),
  CONSTRAINT `employee_info_archive_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `Employee_Info` (`EmployeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_info_archive`
--

LOCK TABLES `employee_info_archive` WRITE;
/*!40000 ALTER TABLE `employee_info_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_info_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_archive`
--

DROP TABLE IF EXISTS `order_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_archive` (
  `orderArchiveID` int NOT NULL AUTO_INCREMENT,
  `OrderID` int NOT NULL,
  `EmployeeID` int NOT NULL,
  `CustomerID` int NOT NULL,
  `OrderStartDate` date NOT NULL,
  `OrderDeadline` date DEFAULT NULL,
  `OrderStatusCode` int NOT NULL,
  `ArchiveTimestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`orderArchiveID`),
  KEY `OrderID` (`OrderID`),
  CONSTRAINT `order_archive_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_archive`
--

LOCK TABLES `order_archive` WRITE;
/*!40000 ALTER TABLE `order_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `OrderID` int NOT NULL AUTO_INCREMENT,
  `EmployeeID` int DEFAULT '0',
  `CustomerID` int NOT NULL,
  `OrderStartDate` date DEFAULT NULL,
  `OrderDeadline` date DEFAULT NULL,
  `OrderStatusCode` int DEFAULT '0',
  `IsRemoved` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`OrderID`),
  KEY `EmployeeID` (`EmployeeID`),
  KEY `CustomerID` (`CustomerID`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee_info` (`EmployeeID`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,1,'2024-07-09','2024-08-01',1,0),(2,2,2,'2024-07-01','2024-07-27',1,0),(3,3,3,'2024-07-11','2024-08-06',1,0),(4,4,4,'2024-07-14','2024-07-27',1,0),(5,5,5,'2024-07-06','2024-07-06',1,0),(6,6,6,'2024-07-05','2024-07-17',1,0),(7,7,7,'2024-07-10','2024-07-23',1,0),(8,8,8,'2024-06-19','2024-07-16',1,0),(9,9,9,'2024-07-13','2024-07-29',1,0),(10,10,10,'2024-06-28','2024-06-30',4,0),(11,1,11,'2024-07-14','2024-07-21',2,0),(12,1,12,'2024-07-14','2024-07-21',3,0),(13,11,13,'2024-07-14','2024-07-21',2,0),(14,11,14,'2024-07-15','2024-07-22',0,0),(15,11,15,'2024-07-15','2024-07-22',0,0),(16,11,15,'2024-07-15','2024-07-22',0,0),(17,11,15,'2024-07-15','2024-07-22',0,0),(18,11,15,'2024-07-15','2024-07-22',0,0),(19,11,15,'2024-07-15','2024-07-22',0,0),(20,11,15,'2024-07-15','2024-07-22',0,0),(21,11,15,'2024-07-15','2024-07-22',0,0),(22,11,16,'2024-07-15','2024-07-22',2,0),(23,11,17,'2024-07-15','2024-07-22',0,0),(24,11,17,'2024-07-15','2024-07-22',0,0),(25,11,17,'2024-07-15','2024-07-22',0,0),(26,11,17,'2024-07-15','2024-07-22',0,0),(27,11,17,'2024-07-15','2024-07-22',0,0),(28,11,17,'2024-07-15','2024-07-22',0,0),(29,11,17,'2024-07-15','2024-07-22',4,0);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `set_order_deadline` BEFORE INSERT ON `orders` FOR EACH ROW BEGIN
    IF NEW.OrderDeadline IS NULL THEN
        SET NEW.OrderDeadline = DATE_ADD(NEW.OrderStartDate, INTERVAL 7 DAY);
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `payment_plans`
--

DROP TABLE IF EXISTS `payment_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_plans` (
  `PlanID` int NOT NULL AUTO_INCREMENT,
  `OrderID` int NOT NULL,
  `DueDate` date DEFAULT NULL,
  `PaymentStatus` int DEFAULT '0',
  `PaymentMethod` varchar(32) DEFAULT NULL,
  `PaymentProcessor` varchar(32) DEFAULT NULL,
  `TotalAmount` float DEFAULT '0',
  `AmountPaid` float DEFAULT '0',
  `Balance` float DEFAULT '0',
  `IsRemoved` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`PlanID`),
  KEY `OrderID` (`OrderID`),
  CONSTRAINT `payment_plans_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `Orders` (`OrderID`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_plans`
--

LOCK TABLES `payment_plans` WRITE;
/*!40000 ALTER TABLE `payment_plans` DISABLE KEYS */;
INSERT INTO `payment_plans` VALUES (1,1,'2023-01-31',0,'Credit Card','Visa',500,23,477,0),(2,2,'2023-02-15',1,'PayPal','PayPal',3750,750,3000,0),(3,3,'2023-03-10',0,'Bank Transfer','Bank of America',5000,0,5000,0),(4,4,'2023-04-05',1,'Cash','N/A',1200,1200,0,0),(5,5,'2023-05-20',0,'Debit Card','MasterCard',800,0,800,0),(6,6,'2023-06-15',1,'Credit Card','American Express',950,950,0,0),(7,7,'2023-07-30',0,'PayPal','PayPal',600,0,600,0),(8,8,'2023-08-10',1,'Bank Transfer','Chase Bank',300,300,0,0),(9,9,'2023-09-25',0,'Cash','N/A',1100,0,1100,0),(10,10,'2023-10-24',1,'Debit','Visa',850,7910,-7060,0),(11,11,'2024-07-31',0,'','',NULL,0,NULL,0),(12,12,'2024-07-15',0,'','',4956,100,4856,0),(13,13,'2024-07-02',0,'','',2772,0,2772,0),(14,14,'2024-07-23',0,'','',0,0,0,0),(15,15,'2024-07-23',0,'','',0,0,0,0),(16,16,'2024-07-23',0,'','',15129,0,0,0),(17,19,'2024-07-23',0,'','',0,0,0,0),(18,20,'2024-07-23',0,'','',0,0,0,0),(19,21,'2024-07-23',0,'','',0,0,0,0),(20,22,'2024-07-24',0,'','',200,200,0,0),(21,23,'2024-07-02',0,'','',0,0,0,0),(22,24,'2024-07-02',0,'','',0,0,0,0),(23,25,'2024-07-02',0,'','',2772,0,0,0),(24,26,'2024-07-02',0,'','',1200,0,0,0),(25,27,'2024-07-02',0,'','',0,0,0,0),(26,28,'2024-07-02',0,'','',0,0,0,0),(27,29,'2024-07-02',0,'','',NULL,0,NULL,0);
/*!40000 ALTER TABLE `payment_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_plans_Archive`
--

DROP TABLE IF EXISTS `payment_plans_Archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_plans_Archive` (
  `planArchiveID` int NOT NULL AUTO_INCREMENT,
  `PlanID` int NOT NULL,
  `OrderID` int NOT NULL,
  `DueDate` date DEFAULT NULL,
  `PaymentStatus` int DEFAULT '0',
  `PaymentMethod` varchar(32) DEFAULT NULL,
  `PaymentProcessor` varchar(32) DEFAULT NULL,
  `TotalAmount` float DEFAULT '0',
  `AmountPaid` float DEFAULT '0',
  `Balance` float DEFAULT '0',
  PRIMARY KEY (`planArchiveID`),
  KEY `PlanID` (`PlanID`),
  CONSTRAINT `payment_plans_archive_ibfk_1` FOREIGN KEY (`PlanID`) REFERENCES `payment_plans` (`PlanID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_plans_Archive`
--

LOCK TABLES `payment_plans_Archive` WRITE;
/*!40000 ALTER TABLE `payment_plans_Archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_plans_Archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Payment_Receipt_Archive`
--

DROP TABLE IF EXISTS `Payment_Receipt_Archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Payment_Receipt_Archive` (
  `ReceiptArchiveID` int NOT NULL AUTO_INCREMENT,
  `ReceiptID` int NOT NULL,
  `PlanID` int NOT NULL,
  `ReceiptImagePath` varchar(255) DEFAULT NULL,
  `HasPicture` tinyint(1) DEFAULT '0',
  `ReceiptAmountPaid` float DEFAULT '0',
  `PaymentDate` date DEFAULT NULL,
  `PaymentProcessor` varchar(32) DEFAULT NULL,
  `PaymentProcessorReferenceNumber` float DEFAULT '0',
  PRIMARY KEY (`ReceiptArchiveID`),
  KEY `ReceiptID` (`ReceiptID`),
  CONSTRAINT `payment_receipt_archive_ibfk_1` FOREIGN KEY (`ReceiptID`) REFERENCES `Payment_Receipts` (`ReceiptID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payment_Receipt_Archive`
--

LOCK TABLES `Payment_Receipt_Archive` WRITE;
/*!40000 ALTER TABLE `Payment_Receipt_Archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `Payment_Receipt_Archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_receipts`
--

DROP TABLE IF EXISTS `payment_receipts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_receipts` (
  `ReceiptID` int NOT NULL AUTO_INCREMENT,
  `PlanID` int NOT NULL,
  `ReceiptImagePath` varchar(255) DEFAULT '',
  `HasPicture` tinyint(1) DEFAULT '0',
  `ReceiptAmountPaid` float DEFAULT '0',
  `PaymentDate` date DEFAULT NULL,
  `PaymentProcessor` varchar(32) DEFAULT 'None',
  `PaymentProcessorReferenceNumber` float DEFAULT '0',
  `IsRemoved` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ReceiptID`),
  KEY `PlanID` (`PlanID`),
  CONSTRAINT `payment_receipts_ibfk_1` FOREIGN KEY (`PlanID`) REFERENCES `payment_Plans` (`PlanID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_receipts`
--

LOCK TABLES `payment_receipts` WRITE;
/*!40000 ALTER TABLE `payment_receipts` DISABLE KEYS */;
INSERT INTO `payment_receipts` VALUES (1,1,'/path/to/receipt1.jpg',1,500,'2023-01-31','Visa',123457000,0),(2,2,'/path/to/receipt2.jpg',1,750,'2023-02-15','PayPal',987654000,0),(3,3,'/path/to/receipt3.jpg',1,400,'2023-03-10','Bank of America',246814000,0),(4,4,'/path/to/receipt4.jpg',1,1200,'2023-04-05','N/A',135792000,0),(5,5,'/path/to/receipt5.jpg',1,800,'2023-05-20','MasterCard',864210000,0),(6,6,'/path/to/receipt6.jpg',1,950,'2023-06-15','American Express',975311000,0),(7,7,'/path/to/receipt7.jpg',1,600,'2023-07-30','PayPal',531086000,0),(8,8,'/path/to/receipt8.jpg',1,300,'2023-08-10','Chase Bank',642858000,1),(9,9,'/path/to/receipt9.jpg',1,1100,'2023-09-25','N/A',718293000,0),(10,10,'/path/to/receipt10.jpg',1,850,'2023-10-15','Visa',920375000,0),(11,1,'',0,23,'2024-07-22','None',123,0),(12,10,'',0,6060,'2024-07-22','None',2312,0),(13,10,'',0,1000,'2024-07-14','None',0,1),(14,12,'',0,100,'2024-07-07','None',0,0),(15,20,'',0,100,'2024-07-21','None',0,0),(16,20,'',0,100,'2024-07-15','None',0,0);
/*!40000 ALTER TABLE `payment_receipts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_archive`
--

DROP TABLE IF EXISTS `product_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_archive` (
  `productArchiveID` int NOT NULL AUTO_INCREMENT,
  `productID` int NOT NULL,
  `OrderID` int NOT NULL,
  `productDescription` varchar(255) DEFAULT '',
  `productFilePath` varchar(255) DEFAULT '',
  `productDimensions` varchar(32) DEFAULT '',
  `ProductQuantity` int DEFAULT '0',
  `ProductStatusCode` int DEFAULT '0',
  `ProductPrice` float DEFAULT '0',
  `productRemarks` varchar(255) DEFAULT '',
  PRIMARY KEY (`productArchiveID`),
  KEY `productID` (`productID`),
  CONSTRAINT `product_archive_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_archive`
--

LOCK TABLES `product_archive` WRITE;
/*!40000 ALTER TABLE `product_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `productID` int NOT NULL AUTO_INCREMENT,
  `OrderID` int NOT NULL,
  `productDescription` varchar(255) DEFAULT '',
  `productFilePath` varchar(255) DEFAULT '',
  `productDimensions` varchar(32) DEFAULT '',
  `ProductQuantity` int DEFAULT '0',
  `ProductStatusCode` int DEFAULT '0',
  `ProductPrice` float DEFAULT '0',
  `productRemarks` varchar(255) DEFAULT '',
  `Isremoved` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`productID`),
  KEY `OrderID` (`OrderID`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Product A','/path/to/productA.jpg','10x10',100,1,50,'Good condition',0),(2,2,'Product B','/path/to/productB.jpg','8x12',50,2,75,'Slight scratch',0),(3,3,'Product C','/path/to/productC.jpg','5x5',200,1,25,'Brand new',0),(4,4,'Product D','/path/to/productD.jpg','15x20',75,3,100,'Limited stock',0),(5,5,'Product E','/path/to/productE.jpg','12x12',150,2,60,'Clearance sale',0),(6,6,'Product F','/path/to/productF.jpg','6x8',80,1,40,'Last few pieces',0),(7,7,'Product G','/path/to/productG.jpg','8x10',90,3,80,'High demand',0),(8,8,'Product H','/path/to/productH.jpg','18x24',25,1,150,'Special edition',0),(9,9,'Product I','/path/to/productI.jpg','10x15',120,2,70,'Popular choice',0),(10,10,'Product J','/path/to/productJ.jpg','6x6',60,3,45,'Bestseller',0),(11,11,'Test','','12',112,0,12,'12',1),(12,12,'My Product','','Racism',3,0,6800,'Can pick fast',1),(13,12,'Hello','','',231,0,312,'23',NULL),(14,12,'Helo','','',12,0,231231,'31231',NULL),(15,12,'Helo','','',12,0,231231,'31231',NULL),(16,12,'Helo','','',12,0,231231,'31231',NULL),(17,12,'Newest item','','',1231,0,4124,'412',1),(18,12,'Newest item','','',1231,0,4124,'412',1),(19,12,'newer','','',12,0,13,'12',1),(20,12,'newer','','',12,0,13,'12',1),(21,12,'newer','','',12,0,13,'12',0),(22,12,'Hello','','',4,0,1200,'',0),(23,12,'Hello','','',4,0,1200,'',1),(24,12,'Helowp','','',312,0,23,'',1),(25,12,'Helowp','','',312,0,23,'',1),(26,12,'Helowp','','',312,0,23,'',1),(27,12,'reloadtest','','',123,0,1,'',1),(28,12,'reloadtest','','',123,0,1,'',1),(29,12,'reloadtest','','',123,0,1,'',1),(30,13,'Slave','','very',1,0,120,'123',1),(31,13,'Hello','','',231,0,12,'',1),(32,13,'Hello','','',231,0,12,'',0),(33,13,'Hello','','',231,0,12,'',1),(34,11,'asda','','',231,0,123,'',1),(35,11,'asda','','',231,0,123,'',1),(36,14,'titesd','','daf',21,0,31,'3',0),(37,15,'3123','','123',123,0,123,'',0),(38,16,'3123','','123',123,0,123,'',0),(39,22,'231','','213',123,0,123,'',1),(40,22,'hello','','',10,0,10,'12',1),(41,22,'hello','','',12,0,231,'asd',1),(42,22,'hello','','',12,0,231,'asd',1),(43,22,'Test','','',12,0,100,'',1),(44,22,'Test','','',12,0,100,'',1),(45,22,'Anime Sticker','','',10,0,20,'',0),(46,22,'Anime Sticker','','',10,0,20,'',1),(47,25,'asdf','','dfas',12,0,231,'sadf',0),(48,26,'Anime Stickers','','1x2 inch',12,0,100,'use double ply',0),(49,27,'','','',0,0,0,'',0);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-15 10:01:12
