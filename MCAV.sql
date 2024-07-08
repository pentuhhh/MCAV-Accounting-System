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
-- Table structure for table `Action_Logs`
--

DROP TABLE IF EXISTS `Action_Logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Action_Logs` (
  `logID` int NOT NULL AUTO_INCREMENT,
  `EmployeeWebID` int NOT NULL,
  `PermissionsID` int NOT NULL,
  `UserAction` enum('Create','Delete','Update','Remove','ManageUser') NOT NULL,
  `AffectedEntityType` enum('Employee_Info','Payment_Plan','Payment_Receipts','Products','Orders','Customers') DEFAULT NULL,
  `AffectedEntityID` int NOT NULL,
  `LogTimestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`logID`),
  KEY `EmployeeWebID` (`EmployeeWebID`),
  KEY `PermissionsID` (`PermissionsID`),
  CONSTRAINT `action_logs_ibfk_1` FOREIGN KEY (`EmployeeWebID`) REFERENCES `employee_credentials` (`EmployeeWebID`),
  CONSTRAINT `action_logs_ibfk_2` FOREIGN KEY (`PermissionsID`) REFERENCES `permissions` (`PermissionsID`),
  CONSTRAINT `action_logs_chk_1` CHECK ((`UserAction` in (_utf8mb4'Create',_utf8mb4'Delete',_utf8mb4'Update',_utf8mb4'Remove',_utf8mb4'ManageUser'))),
  CONSTRAINT `action_logs_chk_2` CHECK ((`AffectedEntityType` in (_utf8mb4'Employee_Info',_utf8mb4'Payment_Plan',_utf8mb4'Payment_Receipts',_utf8mb4'Products',_utf8mb4'Orders',_utf8mb4'Customers')))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Action_Logs`
--

LOCK TABLES `Action_Logs` WRITE;
/*!40000 ALTER TABLE `Action_Logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `Action_Logs` ENABLE KEYS */;
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
  `CustomerFname` varchar(32) NOT NULL,
  `CustomerLname` varchar(32) NOT NULL,
  `CustomerEmail` varchar(32) NOT NULL,
  `CustomerPhone` varchar(11) NOT NULL,
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
  `CustomerFname` varchar(32) NOT NULL,
  `CustomerLname` varchar(32) NOT NULL,
  `CustomerEmail` varchar(32) NOT NULL,
  `CustomerPhone` varchar(11) NOT NULL,
  PRIMARY KEY (`CustomerID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'John','Doe','john.doe@example.com','1234567890'),(2,'Jane','Smith','jane.smith@example.com','1234567891'),(3,'Alice','Johnson','alice.johnson@example.com','1234567892'),(4,'Bob','Williams','bob.williams@example.com','1234567893'),(5,'Carol','Brown','carol.brown@example.com','1234567894'),(6,'David','Jones','david.jones@example.com','1234567895'),(7,'Eve','Garcia','eve.garcia@example.com','1234567896'),(8,'Frank','Martinez','frank.martinez@example.com','1234567897'),(9,'Grace','Lee','grace.lee@example.com','1234567898'),(10,'Hank','Perez','hank.perez@example.com','1234567899'),(11,'Ivy','Clark','ivy.clark@example.com','1234567800'),(12,'Jack','Lewis','jack.lewis@example.com','1234567801'),(13,'Kara','Robinson','kara.robinson@example.com','1234567802'),(14,'Leo','Walker','leo.walker@example.com','1234567803'),(15,'Mia','Young','mia.young@example.com','1234567804'),(16,'Noah','Harris','noah.harris@example.com','1234567805'),(17,'Olivia','King','olivia.king@example.com','1234567806'),(18,'Paul','Scott','paul.scott@example.com','1234567807'),(19,'Quinn','Green','quinn.green@example.com','1234567808'),(20,'Ruth','Adams','ruth.adams@example.com','1234567809');
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
  `PermissionsID` int NOT NULL,
  `EmployeeID` int NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `employee_Password` binary(60) DEFAULT NULL,
  `UserLevel` int NOT NULL DEFAULT '0',
  `accountStatus` enum('Activated','Deactivated') DEFAULT NULL,
  PRIMARY KEY (`EmployeeWebID`),
  KEY `PermissionsID` (`PermissionsID`),
  KEY `EmployeeID` (`EmployeeID`),
  CONSTRAINT `employee_credentials_ibfk_1` FOREIGN KEY (`PermissionsID`) REFERENCES `Permissions` (`PermissionsID`),
  CONSTRAINT `employee_credentials_ibfk_2` FOREIGN KEY (`EmployeeID`) REFERENCES `employee_info` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_credentials`
--

LOCK TABLES `employee_credentials` WRITE;
/*!40000 ALTER TABLE `employee_credentials` DISABLE KEYS */;
INSERT INTO `employee_credentials` VALUES (1,1,1,'jdoe',_binary 'password1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',1,'Activated'),(2,2,2,'jsmith',_binary 'password2\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',2,'Activated'),(3,3,3,'ajohnson',_binary 'password3\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',1,'Deactivated'),(4,4,4,'bwilliams',_binary 'password4\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',3,'Activated'),(5,5,5,'cbrown',_binary 'password5\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',1,'Activated'),(6,6,6,'djones',_binary 'password6\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',2,'Deactivated'),(7,7,7,'egarcia',_binary 'password7\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',1,'Activated'),(8,8,8,'fmartinez',_binary 'password8\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',3,'Activated'),(9,9,9,'glee',_binary 'password9\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',2,'Deactivated'),(10,10,10,'hperez',_binary 'password10\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',1,'Activated'),(11,11,11,'iclark',_binary 'password11\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',3,'Activated'),(12,12,12,'jlewis',_binary 'password12\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',1,'Deactivated'),(13,13,13,'krobinson',_binary 'password13\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',2,'Activated'),(14,14,14,'lwalker',_binary 'password14\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',1,'Activated'),(15,15,15,'myoung',_binary 'password15\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',3,'Deactivated'),(16,16,16,'nharris',_binary 'password16\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',2,'Activated'),(17,17,17,'oking',_binary 'password17\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',1,'Activated'),(18,18,18,'pscott',_binary 'password18\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',3,'Deactivated'),(19,19,19,'qgreen',_binary 'password19\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',2,'Activated'),(20,20,20,'radams',_binary 'password20\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',1,'Activated');
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
  `ProfilePicturePath` varchar(255) NOT NULL,
  `EmployeeFirstname` varchar(32) NOT NULL,
  `EmployeeLastname` varchar(32) NOT NULL,
  `EmployeeHireDate` varchar(32) NOT NULL,
  `Gender` enum('M','F') NOT NULL,
  `Position` varchar(32) NOT NULL,
  `WebUserLevel` int NOT NULL,
  `IsRemoved` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`EmployeeID`),
  CONSTRAINT `employee_info_chk_1` CHECK ((`Gender` in (_utf8mb4'M',_utf8mb4'F')))
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_info`
--

LOCK TABLES `employee_info` WRITE;
/*!40000 ALTER TABLE `employee_info` DISABLE KEYS */;
INSERT INTO `employee_info` VALUES (1,'path1.jpg','John','Doe','2020-01-01','M','Manager',1,0),(2,'path2.jpg','Jane','Smith','2020-02-01','F','Developer',2,0),(3,'path3.jpg','Alice','Johnson','2020-03-01','F','Designer',1,0),(4,'path4.jpg','Bob','Williams','2020-04-01','M','Tester',3,0),(5,'path5.jpg','Carol','Brown','2020-05-01','F','Support',1,0),(6,'path6.jpg','David','Jones','2020-06-01','M','Manager',2,0),(7,'path7.jpg','Eve','Garcia','2020-07-01','F','Developer',1,0),(8,'path8.jpg','Frank','Martinez','2020-08-01','M','Designer',3,0),(9,'path9.jpg','Grace','Lee','2020-09-01','F','Tester',2,0),(10,'path10.jpg','Hank','Perez','2020-10-01','M','Support',1,0),(11,'path11.jpg','Ivy','Clark','2020-11-01','F','Manager',3,0),(12,'path12.jpg','Jack','Lewis','2020-12-01','M','Developer',1,0),(13,'path13.jpg','Kara','Robinson','2021-01-01','F','Designer',2,0),(14,'path14.jpg','Leo','Walker','2021-02-01','M','Tester',1,0),(15,'path15.jpg','Mia','Young','2021-03-01','F','Support',3,0),(16,'path16.jpg','Noah','Harris','2021-04-01','M','Manager',2,0),(17,'path17.jpg','Olivia','King','2021-05-01','F','Developer',1,0),(18,'path18.jpg','Paul','Scott','2021-06-01','M','Designer',3,0),(19,'path19.jpg','Quinn','Green','2021-07-01','F','Tester',2,0),(20,'path20.jpg','Ruth','Adams','2021-08-01','F','Support',1,0);
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
  `employeeID` int NOT NULL,
  `ProfilePicturePath` varchar(255) NOT NULL,
  `EmployeeFirstname` varchar(32) NOT NULL,
  `EmployeeLastname` varchar(32) NOT NULL,
  `EmployeeHireDate` varchar(32) NOT NULL,
  `Gender` enum('M','F') NOT NULL,
  `Position` varchar(32) NOT NULL,
  `WebUserLevel` int NOT NULL,
  `ArchiveTimestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`employeeArchiveID`),
  KEY `employeeID` (`employeeID`),
  CONSTRAINT `employee_info_archive_ibfk_1` FOREIGN KEY (`employeeID`) REFERENCES `Employee_Info` (`EmployeeID`)
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
  `EmployeeID` int NOT NULL,
  `CustomerID` int NOT NULL,
  `OrderStartDate` date NOT NULL,
  `OrderDeadline` date DEFAULT NULL,
  `OrderStatusCode` int NOT NULL,
  `IsRemoved` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `EmployeeID` (`EmployeeID`),
  KEY `CustomerID` (`CustomerID`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee_info` (`EmployeeID`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,1,'2023-01-01','2023-02-01',1,0),(2,2,2,'2023-01-02','2023-02-02',2,0),(3,3,3,'2023-01-03','2023-02-03',1,0),(4,4,4,'2023-01-04','2023-02-04',3,0),(5,5,5,'2023-01-05','2023-02-05',1,0),(6,6,6,'2023-01-06','2023-02-06',2,0),(7,7,7,'2023-01-07','2023-02-07',1,0),(8,8,8,'2023-01-08','2023-02-08',3,0),(9,9,9,'2023-01-09','2023-02-09',2,0),(10,10,10,'2023-01-10','2023-02-10',1,0),(11,11,11,'2023-01-11','2023-02-11',3,0),(12,12,12,'2023-01-12','2023-02-12',1,0),(13,13,13,'2023-01-13','2023-02-13',2,0),(14,14,14,'2023-01-14','2023-02-14',1,0),(15,15,15,'2023-01-15','2023-02-15',3,0),(16,16,16,'2023-01-16','2023-02-16',2,0),(17,17,17,'2023-01-17','2023-02-17',1,0),(18,18,18,'2023-01-18','2023-02-18',3,0),(19,19,19,'2023-01-19','2023-02-19',2,0),(20,20,20,'2023-01-20','2023-02-20',1,0);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

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
  `PaymentStatus` int NOT NULL DEFAULT '0',
  `PaymentMethod` varchar(32) DEFAULT NULL,
  `PaymentProcessor` varchar(32) DEFAULT NULL,
  `AmountPaid` float DEFAULT '0',
  `IsRemoved` tinyint(1) DEFAULT NULL,
  `balance` float DEFAULT '0',
  `totalamount` float DEFAULT '0',
  PRIMARY KEY (`PlanID`),
  KEY `OrderID` (`OrderID`),
  CONSTRAINT `payment_plans_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `Orders` (`OrderID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_plans`
--

LOCK TABLES `payment_plans` WRITE;
/*!40000 ALTER TABLE `payment_plans` DISABLE KEYS */;
INSERT INTO `payment_plans` VALUES (1,1,'2023-02-01',1,'Credit Card','Processor 1',100,0,0,0),(2,2,'2023-02-02',2,'PayPal','Processor 2',200,0,0,0),(3,3,'2023-02-03',1,'Bank Transfer','Processor 3',300,0,0,0),(4,4,'2023-02-04',3,'Credit Card','Processor 4',400,0,0,0),(5,5,'2023-02-05',1,'PayPal','Processor 1',500,0,0,0),(6,6,'2023-02-06',2,'Bank Transfer','Processor 2',600,0,0,0),(7,7,'2023-02-07',1,'Credit Card','Processor 3',700,0,0,0),(8,8,'2023-02-08',3,'PayPal','Processor 4',800,0,0,0),(9,9,'2023-02-09',2,'Bank Transfer','Processor 1',900,0,0,0),(10,10,'2023-02-10',1,'Credit Card','Processor 2',1000,0,0,0),(11,11,'2023-02-11',3,'PayPal','Processor 3',1100,0,0,0),(12,12,'2023-02-12',1,'Bank Transfer','Processor 4',1200,0,0,0),(13,13,'2023-02-13',2,'Credit Card','Processor 1',1300,0,0,0),(14,14,'2023-02-14',1,'PayPal','Processor 2',1400,0,0,0),(15,15,'2023-02-15',3,'Bank Transfer','Processor 3',1500,0,0,0),(16,16,'2023-02-16',2,'Credit Card','Processor 4',1600,0,0,0),(17,17,'2023-02-17',1,'PayPal','Processor 1',1700,0,0,0),(18,18,'2023-02-18',3,'Bank Transfer','Processor 2',1800,0,0,0),(19,19,'2023-02-19',2,'Credit Card','Processor 3',1900,0,0,0),(20,20,'2023-02-20',1,'PayPal','Processor 4',2000,0,0,0);
/*!40000 ALTER TABLE `payment_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_plans_archive`
--

DROP TABLE IF EXISTS `payment_plans_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_plans_archive` (
  `planArchiveID` int NOT NULL AUTO_INCREMENT,
  `PlanID` int NOT NULL,
  `OrderID` int NOT NULL,
  `DueDate` date DEFAULT NULL,
  `PaymentStatus` int NOT NULL DEFAULT '0',
  `PaymentMethod` varchar(32) DEFAULT NULL,
  `PaymentProcessor` varchar(32) DEFAULT NULL,
  `AmountPaid` float DEFAULT '0',
  `balance` float DEFAULT '0',
  `totalamount` float DEFAULT '0',
  PRIMARY KEY (`planArchiveID`),
  KEY `PlanID` (`PlanID`),
  CONSTRAINT `payment_plans_archive_ibfk_1` FOREIGN KEY (`PlanID`) REFERENCES `payment_plans` (`PlanID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_plans_archive`
--

LOCK TABLES `payment_plans_archive` WRITE;
/*!40000 ALTER TABLE `payment_plans_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_plans_archive` ENABLE KEYS */;
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
-- Table structure for table `Payment_Receipts`
--

DROP TABLE IF EXISTS `Payment_Receipts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Payment_Receipts` (
  `ReceiptID` int NOT NULL AUTO_INCREMENT,
  `PlanID` int NOT NULL,
  `ReceiptImagePath` varchar(255) DEFAULT NULL,
  `HasPicture` tinyint(1) DEFAULT '0',
  `ReceiptAmountPaid` float DEFAULT '0',
  `PaymentDate` date DEFAULT NULL,
  `PaymentProcessor` varchar(32) DEFAULT NULL,
  `PaymentProcessorReferenceNumber` float DEFAULT '0',
  `IsRemoved` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ReceiptID`),
  KEY `PlanID` (`PlanID`),
  CONSTRAINT `payment_receipts_ibfk_1` FOREIGN KEY (`PlanID`) REFERENCES `payment_Plans` (`PlanID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payment_Receipts`
--

LOCK TABLES `Payment_Receipts` WRITE;
/*!40000 ALTER TABLE `Payment_Receipts` DISABLE KEYS */;
INSERT INTO `Payment_Receipts` VALUES (1,1,'receipt1.jpg',1,100,'2023-02-01','Processor 1',123456,0),(2,2,'receipt2.jpg',1,200,'2023-02-02','Processor 2',234567,0),(3,3,'receipt3.jpg',0,300,'2023-02-03','Processor 3',345678,0),(4,4,'receipt4.jpg',1,400,'2023-02-04','Processor 4',456789,0),(5,5,'receipt5.jpg',1,500,'2023-02-05','Processor 1',567890,0),(6,6,'receipt6.jpg',0,600,'2023-02-06','Processor 2',678901,0),(7,7,'receipt7.jpg',1,700,'2023-02-07','Processor 3',789012,0),(8,8,'receipt8.jpg',1,800,'2023-02-08','Processor 4',890123,0),(9,9,'receipt9.jpg',0,900,'2023-02-09','Processor 1',901234,0),(10,10,'receipt10.jpg',1,1000,'2023-02-10','Processor 2',123456,0),(11,11,'receipt11.jpg',1,1100,'2023-02-11','Processor 3',234567,0),(12,12,'receipt12.jpg',0,1200,'2023-02-12','Processor 4',345678,0),(13,13,'receipt13.jpg',1,1300,'2023-02-13','Processor 1',456789,0),(14,14,'receipt14.jpg',1,1400,'2023-02-14','Processor 2',567890,0),(15,15,'receipt15.jpg',0,1500,'2023-02-15','Processor 3',678901,0),(16,16,'receipt16.jpg',1,1600,'2023-02-16','Processor 4',789012,0),(17,17,'receipt17.jpg',1,1700,'2023-02-17','Processor 1',890123,0),(18,18,'receipt18.jpg',0,1800,'2023-02-18','Processor 2',901234,0),(19,19,'receipt19.jpg',1,1900,'2023-02-19','Processor 3',123456,0),(20,20,'receipt20.jpg',1,2000,'2023-02-20','Processor 4',234567,0),(21,1,'sadsdas',1,100,'2024-07-04','processor1',23131,0);
/*!40000 ALTER TABLE `Payment_Receipts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Permissions`
--

DROP TABLE IF EXISTS `Permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Permissions` (
  `PermissionsID` int NOT NULL AUTO_INCREMENT,
  `PermissionCreate` tinyint(1) DEFAULT '0',
  `PermissionDelete` tinyint(1) DEFAULT '0',
  `PermissionUpdate` tinyint(1) DEFAULT '0',
  `PermissionRemove` tinyint(1) DEFAULT '0',
  `PermissionViewLogs` int DEFAULT '0',
  `PermissionsManageUser` int DEFAULT '0',
  PRIMARY KEY (`PermissionsID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Permissions`
--

LOCK TABLES `Permissions` WRITE;
/*!40000 ALTER TABLE `Permissions` DISABLE KEYS */;
INSERT INTO `Permissions` VALUES (1,1,1,1,1,1,1),(2,0,1,0,1,0,0),(3,1,0,1,0,1,0),(4,0,0,0,0,0,0),(5,1,1,0,0,1,1),(6,1,0,0,1,0,0),(7,0,1,1,0,1,0),(8,1,1,1,0,1,1),(9,0,0,1,1,0,0),(10,1,0,1,1,1,0),(11,0,1,0,1,0,1),(12,1,1,0,0,1,0),(13,1,0,1,1,0,0),(14,0,1,1,1,1,0),(15,1,0,0,0,0,1),(16,0,1,0,0,1,0),(17,1,0,1,1,0,1),(18,0,0,1,0,0,0),(19,1,1,1,0,1,0),(20,0,0,0,1,0,1);
/*!40000 ALTER TABLE `Permissions` ENABLE KEYS */;
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
  `productDescription` varchar(255) DEFAULT NULL,
  `productFilePath` varchar(255) DEFAULT NULL,
  `productDimenstions` varchar(32) DEFAULT NULL,
  `ProductQuantity` int DEFAULT NULL,
  `ProductStatusCode` int DEFAULT NULL,
  `ProductPrice` float DEFAULT '0',
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
  `productDescription` varchar(255) DEFAULT NULL,
  `productFilePath` varchar(255) DEFAULT NULL,
  `productDimensions` varchar(32) DEFAULT NULL,
  `ProductQuantity` int DEFAULT NULL,
  `ProductStatusCode` int DEFAULT NULL,
  `IsRemoved` tinyint(1) DEFAULT NULL,
  `ProductPrice` float DEFAULT '0',
  PRIMARY KEY (`productID`),
  KEY `OrderID` (`OrderID`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `Orders` (`OrderID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Product 1','path1.jpg','10x10x10',10,1,0,0),(2,2,'Product 2','path2.jpg','20x20x20',20,2,0,0),(3,3,'Product 3','path3.jpg','30x30x30',30,1,0,0),(4,4,'Product 4','path4.jpg','40x40x40',40,3,0,0),(5,5,'Product 5','path5.jpg','50x50x50',50,1,0,0),(6,6,'Product 6','path6.jpg','60x60x60',60,2,0,0),(7,7,'Product 7','path7.jpg','70x70x70',70,1,0,0),(8,8,'Product 8','path8.jpg','80x80x80',80,3,0,0),(9,9,'Product 9','path9.jpg','90x90x90',90,2,0,0),(10,10,'Product 10','path10.jpg','100x100x100',100,1,0,0),(11,11,'Product 11','path11.jpg','110x110x110',110,3,0,0),(12,12,'Product 12','path12.jpg','120x120x120',120,1,0,0),(13,13,'Product 13','path13.jpg','130x130x130',130,2,0,0),(14,14,'Product 14','path14.jpg','140x140x140',140,1,0,0),(15,15,'Product 15','path15.jpg','150x150x150',150,3,0,0),(16,16,'Product 16','path16.jpg','160x160x160',160,2,0,0),(17,17,'Product 17','path17.jpg','170x170x170',170,1,0,0),(18,18,'Product 18','path18.jpg','180x180x180',180,3,0,0),(19,19,'Product 19','path19.jpg','190x190x190',190,2,0,0),(20,20,'Product 20','path20.jpg','200x200x200',200,1,0,0);
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

-- Dump completed on 2024-07-08  9:49:03
