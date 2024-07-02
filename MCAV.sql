-- MySQL dump 10.13  Distrib 8.3.0, for macos14.2 (arm64)
--
-- Host: localhost    Database: mcav
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Action_Logs`
--

LOCK TABLES `Action_Logs` WRITE;
/*!40000 ALTER TABLE `Action_Logs` DISABLE KEYS */;
INSERT INTO `Action_Logs` VALUES (1,1,1,'Create','Employee_Info',1,'2023-01-01 08:00:00'),(2,2,2,'Update','Products',2,'2023-01-02 09:15:00'),(3,3,3,'Delete','Orders',3,'2023-01-03 10:30:00'),(4,4,4,'Remove','Customers',4,'2023-01-04 11:45:00'),(5,5,5,'ManageUser','Payment_Plan',5,'2023-01-05 13:00:00'),(6,6,6,'Create','Employee_Info',6,'2023-01-06 14:15:00'),(7,7,7,'Update','Products',7,'2023-01-07 15:30:00'),(8,8,8,'Delete','Orders',8,'2023-01-08 16:45:00'),(9,9,9,'Remove','Customers',9,'2023-01-09 18:00:00'),(10,10,10,'ManageUser','Payment_Plan',10,'2023-01-10 19:15:00'),(11,11,11,'Create','Employee_Info',11,'2023-01-11 20:30:00'),(12,12,12,'Update','Products',12,'2023-01-12 21:45:00'),(13,13,13,'Delete','Orders',13,'2023-01-13 22:00:00'),(14,14,14,'Remove','Customers',14,'2023-01-14 23:15:00'),(15,15,15,'ManageUser','Payment_Plan',15,'2023-01-15 00:30:00'),(16,16,16,'Create','Employee_Info',16,'2023-01-16 01:45:00'),(17,17,17,'Update','Products',17,'2023-01-17 02:00:00'),(18,18,18,'Delete','Orders',18,'2023-01-18 03:15:00'),(19,19,19,'Remove','Customers',19,'2023-01-19 04:30:00'),(20,20,20,'ManageUser','Payment_Plan',20,'2023-01-20 05:45:00'),(21,21,21,'Create','Employee_Info',21,'2023-01-21 06:00:00'),(22,22,22,'Update','Products',22,'2023-01-22 07:15:00'),(23,23,23,'Delete','Orders',23,'2023-01-23 08:30:00'),(24,24,24,'Remove','Customers',24,'2023-01-24 09:45:00'),(25,25,25,'ManageUser','Payment_Plan',25,'2023-01-25 11:00:00'),(26,26,26,'Create','Employee_Info',26,'2023-01-26 12:15:00'),(27,27,27,'Update','Products',27,'2023-01-27 13:30:00'),(28,28,28,'Delete','Orders',28,'2023-01-28 14:45:00'),(29,29,29,'Remove','Customers',29,'2023-01-29 16:00:00'),(30,30,30,'ManageUser','Payment_Plan',30,'2023-01-30 17:15:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'John','Doe','john.doe@example.com','1234567890'),(2,'Jane','Smith','jane.smith@example.com','0987654321'),(3,'Alice','Johnson','alice.johnson@example.com','1122334455'),(4,'Bob','Brown','bob.brown@example.com','2233445566'),(5,'Charlie','Davis','charlie.davis@example.com','3344556677'),(6,'Diana','Evans','diana.evans@example.com','4455667788'),(7,'Ethan','Garcia','ethan.garcia@example.com','5566778899'),(8,'Fiona','Harris','fiona.harris@example.com','6677889900'),(9,'George','Iglesias','george.iglesias@example.com','7788990011'),(10,'Hannah','Jones','hannah.jones@example.com','8899001122'),(11,'Isaac','King','isaac.king@example.com','9900112233'),(12,'Julia','Lee','julia.lee@example.com','0011223344'),(13,'Kevin','Martinez','kevin.martinez@example.com','1122334456'),(14,'Laura','Nelson','laura.nelson@example.com','2233445567'),(15,'Michael','Owen','michael.owen@example.com','3344556678'),(16,'Nancy','Perez','nancy.perez@example.com','4455667789'),(17,'Oliver','Quinn','oliver.quinn@example.com','5566778890'),(18,'Paula','Robinson','paula.robinson@example.com','6677889901'),(19,'Quincy','Scott','quincy.scott@example.com','7788990012'),(20,'Rachel','Taylor','rachel.taylor@example.com','8899001123'),(21,'Steve','Underwood','steve.underwood@example.com','9900112234'),(22,'Tina','Vargas','tina.vargas@example.com','0011223345'),(23,'Umar','White','umar.white@example.com','1122334457'),(24,'Vera','Xavier','vera.xavier@example.com','2233445568'),(25,'Will','Young','will.young@example.com','3344556679'),(26,'Xena','Zimmerman','xena.zimmerman@example.com','4455667780'),(27,'Yusuf','Adams','yusuf.adams@example.com','5566778891'),(28,'Zara','Baker','zara.baker@example.com','6677889902'),(29,'Alex','Carter','alex.carter@example.com','7788990013'),(30,'Brittany','Diaz','brittany.diaz@example.com','8899001124');
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_credentials`
--

LOCK TABLES `employee_credentials` WRITE;
/*!40000 ALTER TABLE `employee_credentials` DISABLE KEYS */;
INSERT INTO `employee_credentials` VALUES (1,1,1,'jdoe',_binary '$2b$12$Q9//aJr.f8Z5G4EzgThY2O2KJ0dF4k9L4UKZ/0S21i0gOKUJiyCXS',5,'Activated'),(2,2,2,'jsmith',_binary '$2b$12$7zJ/C9mQG0khloX4V6zQMeYaF3Tw/W6T1Hh.e5RW59zEFoRmgUjNe',3,'Activated'),(3,3,3,'ajohnson',_binary '$2b$12$z67yg3tUxe5/GQoJ0f8Ae.jGQ6FTYGRrcU3YJZOTQ.6F4bkQKUISe',4,'Activated'),(4,4,4,'bbrown',_binary '$2b$12$V5w.1YrBaKnVLEk5qVnGmeFQsTE8yEGOdSxl/jw3J.6CRjei9.xKy',2,'Activated'),(5,5,5,'cdavis',_binary '$2b$12$GphTAfF9NZTtF/7IdYy6qeF5St6U6zYI4D8vF.HseTJp.Kt4O0LiG',1,'Activated'),(6,6,6,'devans',_binary '$2b$12$xAWz1Y2Js/W7L3dj5aKfOeQ1w/wtyAVk4LBkLs8TjkN13Q0UGFNQe',5,'Activated'),(7,7,7,'egarcia',_binary '$2b$12$QixOgLK5e6y6/p5bykWJeODCjEp/J4L5vW7eNGw6J2wG4B1vYTP9S',3,'Activated'),(8,8,8,'fharris',_binary '$2b$12$g1FhFBNtZBb9J7Vt5fd05er.gwT.e1bwkBoD3wT4LHRAXeZQFOZjG',4,'Activated'),(9,9,9,'giglesias',_binary '$2b$12$QqT1hf.GZ1dJ8/SQzXRAbeZ9tvB9e2JpPDtM5fIB8zN2B.1JpU8/i',5,'Activated'),(10,10,10,'hjones',_binary '$2b$12$UytkFxzW/FHfR.Lp.L1q0uoyk6f/NyXkKr3Fh19BN0VJQzO5EIHle',1,'Activated'),(11,11,11,'iking',_binary '$2b$12$pWhc/SHntvGg.yT3nGmsyu0CkPeYO/nV3EgeZ.O3XZsN.2XkI1gK2',4,'Activated'),(12,12,12,'jlee',_binary '$2b$12$1F9JjViwv3mZp.Nm/G2Yxu5O8C4nfsw7rQn3Mfiqk2yN3OfpD8KlG',3,'Activated'),(13,13,13,'kmartinez',_binary '$2b$12$Za8/v9BtH.cFsZroMyW69erK/yfZG/JIdrGhTXR7rVxtpF3Gc1v0G',2,'Activated'),(14,14,14,'lnelson',_binary '$2b$12$hU8wsUtQSmJ5M8gUJasI.u1gF6GyT8qKXvwbYGp7n1fPr7.y2Zo6O',2,'Activated'),(15,15,15,'mowen',_binary '$2b$12$Ge.D3PTbbUAKDyEmO9HISOn4rN5N9yZr/j.lHRqQkdfBoJ/oxr1e2',3,'Activated'),(16,16,16,'nperez',_binary '$2b$12$EqvOa5dD7GMyg6vTTdFF7u4S7c3X63ewNLm8HR/Zo8G9I6GvqRpeO',5,'Activated'),(17,17,17,'oquinn',_binary '$2b$12$3Ofw8/1oJlo0PKS5yXQDsOgW4X77.mU5MmXrUymdphPLSRAuCmP32',5,'Activated'),(18,18,18,'probinson',_binary '$2b$12$YvY2f5TQ5s8yCevv08pDqOe/A1y1e7/peQQQ9tB1JRuIiy/N8JBe6',4,'Activated'),(19,19,19,'qscott',_binary '$2b$12$PLR1oy4TxwUgV84aB1ACw.fHnN4F5e3CilbP8jzgS8No9t23D1uQa',1,'Activated'),(20,20,20,'rtaylor',_binary '$2b$12$UxUxsmyGz1xX9DPjM7LXmeFMKn5lZ1PaY0/LpY5G4QMbMoN0t11N2',3,'Activated'),(21,21,21,'sunderwood',_binary '$2b$12$D4wK5zL5OSKxEKDr8f9ZVuOgS1O3OWi0Iu39WAp2q5F5uM8qmeX3C',4,'Activated'),(22,22,22,'tvargas',_binary '$2b$12$TnQL98REhtzFqQvS54u0k.2n7GZY6B4uHPG.fOeGcEJ0XX7X8r1X2',2,'Activated'),(23,23,23,'uwhite',_binary '$2b$12$osAKr5z8kWIo.E4SyP9b9e97F.CyFRmCVDqLB.jXqu1/jCN/XgeDm',2,'Activated'),(24,24,24,'vxavier',_binary '$2b$12$dzRy.g2Yy3u7UnI4LOHbOeX1b9W9FNuHv3zvEad1/Q1QMcVvYb6W6',5,'Activated'),(25,25,25,'wyoung',_binary '$2b$12$7H4q5VO5zYqFlXntBUgbb.GNwzh1N8jQ.7xL5EXg3m5H4Tbr1dWtG',5,'Activated'),(26,26,26,'xzimmerman',_binary '$2b$12$EDv4Eh8tD7NQ9D1kCfe0UO.zU7hJWnMLzj7PRfg6mLLFYJz.RuWuG',1,'Activated'),(27,27,27,'yadams',_binary '$2b$12$wnE6QfClHcGLQ1dQmXjoNO3POfn9UQ58SL9qR8OyxWv0Xcl.zrU0W',3,'Activated'),(28,28,28,'zbaker',_binary '$2b$12$GUPD9CJ1QkGrf/6Z6xlfa.kLRBRQhszNP5BRTrTjB3s5K4s12yde6',2,'Activated'),(29,29,29,'acarter',_binary '$2b$12$1MZrNYpKfjTXtF9b6jJg6OtRho3PdcMNz5AX8Pd8DZPkp7O.ytrPC',4,'Activated'),(30,30,30,'bdiaz',_binary '$2b$12$8VV.a1bPR2Q.3GkeNHdDiubZeugX8I02YHzZzEbSt9RyxTHmrW2y6',4,'Activated');
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_info`
--

LOCK TABLES `employee_info` WRITE;
/*!40000 ALTER TABLE `employee_info` DISABLE KEYS */;
INSERT INTO `employee_info` VALUES (1,'/images/employees/jdoe.jpg','John','Doe','2021-01-15','M','Manager',5,0),(2,'/images/employees/jsmith.jpg','Jane','Smith','2020-03-22','F','Sales',3,0),(3,'/images/employees/ajohnson.jpg','Alice','Johnson','2019-07-10','F','Engineer',4,0),(4,'/images/employees/bbrown.jpg','Bob','Brown','2018-12-05','M','Technician',2,0),(5,'/images/employees/cdavis.jpg','Charlie','Davis','2022-05-18','M','Support',1,0),(6,'/images/employees/devans.jpg','Diana','Evans','2023-09-29','F','HR',5,0),(7,'/images/employees/egarcia.jpg','Ethan','Garcia','2021-04-13','M','Marketing',3,0),(8,'/images/employees/fharris.jpg','Fiona','Harris','2020-08-19','F','Design',4,0),(9,'/images/employees/giglesias.jpg','George','Iglesias','2019-02-25','M','Finance',5,0),(10,'/images/employees/hjones.jpg','Hannah','Jones','2018-11-03','F','Admin',1,0),(11,'/images/employees/iking.jpg','Isaac','King','2022-06-30','M','Engineer',4,0),(12,'/images/employees/jlee.jpg','Julia','Lee','2023-10-12','F','Sales',3,0),(13,'/images/employees/kmartinez.jpg','Kevin','Martinez','2021-01-28','M','Support',2,0),(14,'/images/employees/lnelson.jpg','Laura','Nelson','2020-03-17','F','Technician',2,0),(15,'/images/employees/mowen.jpg','Michael','Owen','2019-07-05','M','Marketing',3,0),(16,'/images/employees/nperez.jpg','Nancy','Perez','2018-12-19','F','HR',5,0),(17,'/images/employees/oquinn.jpg','Oliver','Quinn','2022-05-02','M','Finance',5,0),(18,'/images/employees/probinson.jpg','Paula','Robinson','2023-09-08','F','Design',4,0),(19,'/images/employees/qscott.jpg','Quincy','Scott','2021-04-22','M','Admin',1,0),(20,'/images/employees/rtaylor.jpg','Rachel','Taylor','2020-08-29','F','Sales',3,0),(21,'/images/employees/sunderwood.jpg','Steve','Underwood','2019-02-14','M','Engineer',4,0),(22,'/images/employees/tvargas.jpg','Tina','Vargas','2018-11-25','F','Support',2,0),(23,'/images/employees/uwhite.jpg','Umar','White','2022-07-15','M','Technician',2,0),(24,'/images/employees/vxavier.jpg','Vera','Xavier','2023-11-20','F','HR',5,0),(25,'/images/employees/wyoung.jpg','Will','Young','2021-02-06','M','Finance',5,0),(26,'/images/employees/xzimmerman.jpg','Xena','Zimmerman','2020-04-11','F','Admin',1,0),(27,'/images/employees/yadams.jpg','Yusuf','Adams','2019-08-24','M','Marketing',3,0),(28,'/images/employees/zbaker.jpg','Zara','Baker','2018-12-09','F','Support',2,0),(29,'/images/employees/acarter.jpg','Alex','Carter','2022-06-05','M','Engineer',4,0),(30,'/images/employees/bdiaz.jpg','Brittany','Diaz','2023-10-21','F','Design',4,0);
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
  `ProductID` int NOT NULL,
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
  `ProductID` int NOT NULL,
  `OrderStartDate` date NOT NULL,
  `OrderDeadline` date DEFAULT NULL,
  `OrderStatusCode` int NOT NULL,
  `IsRemoved` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `EmployeeID` (`EmployeeID`),
  KEY `CustomerID` (`CustomerID`),
  KEY `ProductID` (`ProductID`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee_info` (`EmployeeID`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`),
  CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`ProductID`) REFERENCES `products` (`productID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,1,1,'2023-01-10','2023-01-20',1,0),(2,2,2,2,'2023-01-15','2023-01-25',1,0),(3,3,3,3,'2023-01-20','2023-01-30',1,0),(4,4,4,4,'2023-01-25','2023-02-04',1,0),(5,5,5,5,'2023-02-01','2023-02-11',1,0),(6,6,6,6,'2023-02-05','2023-02-15',1,0),(7,7,7,7,'2023-02-10','2023-02-20',1,0),(8,8,8,8,'2023-02-15','2023-02-25',1,0),(9,9,9,9,'2023-02-20','2023-03-02',1,0),(10,10,10,10,'2023-02-25','2023-03-07',1,0),(11,11,11,11,'2023-03-01','2023-03-11',1,0),(12,12,12,12,'2023-03-05','2023-03-15',1,0),(13,13,13,13,'2023-03-10','2023-03-20',1,0),(14,14,14,14,'2023-03-15','2023-03-25',1,0),(15,15,15,15,'2023-03-20','2023-03-30',1,0),(16,16,16,16,'2023-03-25','2023-04-04',1,0),(17,17,17,17,'2023-04-01','2023-04-11',1,0),(18,18,18,18,'2023-04-05','2023-04-15',1,0),(19,19,19,19,'2023-04-10','2023-04-20',1,0),(20,20,20,20,'2023-04-15','2023-04-25',1,0),(21,21,21,21,'2023-04-20','2023-04-30',1,0),(22,22,22,22,'2023-04-25','2023-05-05',1,0),(23,23,23,23,'2023-05-01','2023-05-11',1,0),(24,24,24,24,'2023-05-05','2023-05-15',1,0),(25,25,25,25,'2023-05-10','2023-05-20',1,0),(26,26,26,26,'2023-05-15','2023-05-25',1,0),(27,27,27,27,'2023-05-20','2023-05-30',1,0),(28,28,28,28,'2023-05-25','2023-06-04',1,0),(29,29,29,29,'2023-06-01','2023-06-11',1,0),(30,30,30,30,'2023-06-05','2023-06-15',1,0);
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
  PRIMARY KEY (`PlanID`),
  KEY `OrderID` (`OrderID`),
  CONSTRAINT `payment_plans_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `Orders` (`OrderID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_plans`
--

LOCK TABLES `payment_plans` WRITE;
/*!40000 ALTER TABLE `payment_plans` DISABLE KEYS */;
INSERT INTO `payment_plans` VALUES (1,1,'2023-01-20',0,'Credit Card','Visa',50,0),(2,2,'2023-01-25',0,'PayPal','PayPal',75,0),(3,3,'2023-01-30',0,'Bank Transfer','Bank of America',100,0),(4,4,'2023-02-04',0,'Credit Card','MasterCard',125,0),(5,5,'2023-02-11',0,'PayPal','PayPal',150,0),(6,6,'2023-02-15',0,'Bank Transfer','Chase Bank',175,0),(7,7,'2023-02-20',0,'Credit Card','American Express',200,0),(8,8,'2023-02-25',0,'PayPal','PayPal',225,0),(9,9,'2023-03-02',0,'Bank Transfer','Wells Fargo',250,0),(10,10,'2023-03-07',0,'Credit Card','Visa',275,0),(11,11,'2023-03-11',0,'PayPal','PayPal',300,0),(12,12,'2023-03-15',0,'Bank Transfer','Bank of America',325,0),(13,13,'2023-03-20',0,'Credit Card','MasterCard',350,0),(14,14,'2023-03-25',0,'PayPal','PayPal',375,0),(15,15,'2023-03-30',0,'Bank Transfer','Chase Bank',400,0),(16,16,'2023-04-04',0,'Credit Card','American Express',425,0),(17,17,'2023-04-11',0,'PayPal','PayPal',450,0),(18,18,'2023-04-15',0,'Bank Transfer','Wells Fargo',475,0),(19,19,'2023-04-20',0,'Credit Card','Visa',500,0),(20,20,'2023-04-25',0,'PayPal','PayPal',525,0),(21,21,'2023-04-30',0,'Bank Transfer','Bank of America',550,0),(22,22,'2023-05-05',0,'Credit Card','MasterCard',575,0),(23,23,'2023-05-11',0,'PayPal','PayPal',600,0),(24,24,'2023-05-15',0,'Bank Transfer','Chase Bank',625,0),(25,25,'2023-05-20',0,'Credit Card','American Express',650,0),(26,26,'2023-05-25',0,'PayPal','PayPal',675,0),(27,27,'2023-05-30',0,'Bank Transfer','Wells Fargo',700,0),(28,28,'2023-06-04',0,'Credit Card','Visa',725,0),(29,29,'2023-06-11',0,'PayPal','PayPal',750,0),(30,30,'2023-06-15',0,'Bank Transfer','Bank of America',775,0);
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
  `PaymentStatus` int NOT NULL DEFAULT '0',
  `PaymentMethod` varchar(32) DEFAULT NULL,
  `PaymentProcessor` varchar(32) DEFAULT NULL,
  `AmountPaid` float DEFAULT '0',
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
  `PaymentProcessor` varchar(32) DEFAULT NULL,
  `PaymentProcessorReferenceNumber` float DEFAULT '0',
  `IsRemoved` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ReceiptID`),
  KEY `PlanID` (`PlanID`),
  CONSTRAINT `payment_receipts_ibfk_1` FOREIGN KEY (`PlanID`) REFERENCES `payment_Plans` (`PlanID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payment_Receipts`
--

LOCK TABLES `Payment_Receipts` WRITE;
/*!40000 ALTER TABLE `Payment_Receipts` DISABLE KEYS */;
INSERT INTO `Payment_Receipts` VALUES (1,1,'/receipts/receipt1.jpg',1,50,'Visa',123457000,0),(2,2,'/receipts/receipt2.jpg',1,75,'PayPal',987654000,0),(3,3,'/receipts/receipt3.jpg',1,100,'Bank of America',246814000,0),(4,4,'/receipts/receipt4.jpg',1,125,'MasterCard',135792000,0),(5,5,'/receipts/receipt5.jpg',1,150,'PayPal',864210000,0),(6,6,'/receipts/receipt6.jpg',1,175,'Chase Bank',579319000,0),(7,7,'/receipts/receipt7.jpg',1,200,'American Express',792468000,0),(8,8,'/receipts/receipt8.jpg',1,225,'PayPal',480937000,0),(9,9,'/receipts/receipt9.jpg',1,250,'Wells Fargo',937262000,0),(10,10,'/receipts/receipt10.jpg',1,275,'Visa',261481000,0),(11,11,'/receipts/receipt11.jpg',1,300,'PayPal',618725000,0),(12,12,'/receipts/receipt12.jpg',1,325,'Bank of America',724936000,0),(13,13,'/receipts/receipt13.jpg',1,350,'MasterCard',935619000,0),(14,14,'/receipts/receipt14.jpg',1,375,'PayPal',509373000,0),(15,15,'/receipts/receipt15.jpg',1,400,'Chase Bank',846210000,0),(16,16,'/receipts/receipt16.jpg',1,425,'American Express',209754000,0),(17,17,'/receipts/receipt17.jpg',1,450,'PayPal',753846000,0),(18,18,'/receipts/receipt18.jpg',1,475,'Wells Fargo',468136000,0),(19,19,'/receipts/receipt19.jpg',1,500,'Visa',135792000,0),(20,20,'/receipts/receipt20.jpg',1,525,'PayPal',246814000,0),(21,21,'/receipts/receipt21.jpg',1,550,'Bank of America',935725000,0),(22,22,'/receipts/receipt22.jpg',1,575,'MasterCard',724619000,0),(23,23,'/receipts/receipt23.jpg',1,600,'PayPal',618936000,0),(24,24,'/receipts/receipt24.jpg',1,625,'Chase Bank',935725000,0),(25,25,'/receipts/receipt25.jpg',1,650,'American Express',724619000,0),(26,26,'/receipts/receipt26.jpg',1,675,'PayPal',246814000,0),(27,27,'/receipts/receipt27.jpg',1,700,'Wells Fargo',135792000,0),(28,28,'/receipts/receipt28.jpg',1,725,'Visa',480937000,0),(29,29,'/receipts/receipt29.jpg',1,750,'PayPal',937262000,0),(30,30,'/receipts/receipt30.jpg',1,775,'Bank of America',261481000,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Permissions`
--

LOCK TABLES `Permissions` WRITE;
/*!40000 ALTER TABLE `Permissions` DISABLE KEYS */;
INSERT INTO `Permissions` VALUES (1,1,0,1,0,1,1),(2,0,1,0,1,0,1),(3,1,1,1,0,1,0),(4,0,0,1,1,0,0),(5,1,0,0,1,1,1),(6,0,1,1,0,1,0),(7,1,1,0,0,0,1),(8,0,0,1,1,1,0),(9,1,0,0,0,1,0),(10,0,1,1,0,0,1),(11,1,0,1,1,1,0),(12,0,1,0,1,0,0),(13,1,1,1,0,1,1),(14,0,0,0,1,1,0),(15,1,0,1,0,0,1),(16,0,1,1,1,0,1),(17,1,1,0,0,1,0),(18,0,0,1,0,1,0),(19,1,0,0,1,0,1),(20,0,1,1,1,1,0),(21,1,1,0,0,0,0),(22,0,0,1,1,1,1),(23,1,0,1,0,0,0),(24,0,1,0,1,1,0),(25,1,1,1,0,0,1),(26,0,0,0,1,1,1),(27,1,0,1,1,0,0),(28,0,1,0,0,1,1),(29,1,1,1,1,0,0),(30,0,0,0,0,1,1);
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
  `productDescription` varchar(255) DEFAULT NULL,
  `productFilePath` varchar(255) DEFAULT NULL,
  `productDimenstions` varchar(32) DEFAULT NULL,
  `ProductQuantity` int DEFAULT NULL,
  `ProductStatusCode` int DEFAULT NULL,
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
  `productDescription` varchar(255) DEFAULT NULL,
  `productFilePath` varchar(255) DEFAULT NULL,
  `productDimenstions` varchar(32) DEFAULT NULL,
  `ProductQuantity` int DEFAULT NULL,
  `ProductStatusCode` int DEFAULT NULL,
  `IsRemoved` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`productID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Wireless Mouse','/products/mouse.jpg','4x2x1 inches',100,1,0),(2,'Mechanical Keyboard','/products/keyboard.jpg','18x6x2 inches',50,1,0),(3,'27\" Monitor','/products/monitor.jpg','24x18x8 inches',30,1,0),(4,'Gaming Chair','/products/chair.jpg','30x30x50 inches',20,1,0),(5,'Laptop Stand','/products/laptop_stand.jpg','10x8x4 inches',150,1,0),(6,'USB-C Hub','/products/usb_hub.jpg','3x2x1 inches',200,1,0),(7,'External Hard Drive','/products/hard_drive.jpg','5x3x1 inches',80,1,0),(8,'Noise Cancelling Headphones','/products/headphones.jpg','8x6x4 inches',60,1,0),(9,'Webcam','/products/webcam.jpg','3x3x3 inches',100,1,0),(10,'Desk Lamp','/products/desk_lamp.jpg','12x6x6 inches',70,1,0),(11,'Office Desk','/products/desk.jpg','60x30x30 inches',15,1,0),(12,'Ergonomic Mouse Pad','/products/mouse_pad.jpg','10x8x1 inches',120,1,0),(13,'Smartphone Stand','/products/phone_stand.jpg','6x4x2 inches',200,1,0),(14,'Portable Charger','/products/portable_charger.jpg','4x2x1 inches',100,1,0),(15,'Bluetooth Speaker','/products/speaker.jpg','6x4x4 inches',75,1,0),(16,'Graphic Tablet','/products/tablet.jpg','12x8x0.5 inches',40,1,0),(17,'Laptop Backpack','/products/backpack.jpg','18x12x6 inches',50,1,0),(18,'Smartwatch','/products/smartwatch.jpg','2x2x1 inches',90,1,0),(19,'Fitness Tracker','/products/fitness_tracker.jpg','2x1x0.5 inches',110,1,0),(20,'VR Headset','/products/vr_headset.jpg','10x8x6 inches',20,1,0),(21,'Drone','/products/drone.jpg','12x12x4 inches',30,1,0),(22,'Action Camera','/products/action_camera.jpg','4x3x2 inches',60,1,0),(23,'Wireless Charger','/products/wireless_charger.jpg','5x5x1 inches',80,1,0),(24,'Smart Light Bulb','/products/smart_bulb.jpg','5x3x3 inches',150,1,0),(25,'Electric Scooter','/products/scooter.jpg','36x12x40 inches',10,1,0),(26,'Robot Vacuum','/products/vacuum.jpg','14x14x3 inches',25,1,0),(27,'Air Purifier','/products/air_purifier.jpg','20x12x10 inches',35,1,0),(28,'Smart Thermostat','/products/thermostat.jpg','4x4x1 inches',45,1,0),(29,'Home Security Camera','/products/security_camera.jpg','6x4x4 inches',70,1,0),(30,'Wireless Earbuds','/products/earbuds.jpg','2x2x1 inches',200,1,0);
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

-- Dump completed on 2024-06-27 15:03:04
