-- MySQL dump 10.13  Distrib 8.0.46, for Win64 (x86_64)
--
-- Host: localhost    Database: student_admission_db
-- ------------------------------------------------------
-- Server version	8.0.46

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admission_staff`
--

DROP TABLE IF EXISTS `admission_staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admission_staff` (
  `staff_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admission_staff`
--

LOCK TABLES `admission_staff` WRITE;
/*!40000 ALTER TABLE `admission_staff` DISABLE KEYS */;
INSERT INTO `admission_staff` VALUES (1,'Dixit Chaudhary','dixitchaudhary@college.com','$2y$10$vvNkcYnqOez7rzt3TzKEgeLkLZldxaxpnIS6PHSWzlfeiNN.QbZ1.'),(2,'Vandanaben Patel','vandanabenpatel@college.com','$2y$10$zK4RvdA0pnta2bn7ce/bbuiNErtZPquAfiM66b033GxvWIDDW15ti');
/*!40000 ALTER TABLE `admission_staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `course_id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_seats` int NOT NULL DEFAULT '60',
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'B.Sc. Computer Science','Science & IT','Semester I',60),(2,'Bachelor of Computer Applications (BCA)','Science & IT','Semester I',80),(3,'B.Com. (General)','Commerce','Semester I',120),(4,'B.A. English Literature','Arts & Humanities','Semester I',60),(5,'B.Sc. Information Technology (B.Sc. IT)','Science & IT','Semester I',60);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documents` (
  `document_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marksheet10` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marksheet12` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leaving_certificate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhaar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`document_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (6,6,'photo_ADM2026006_1782469426.jpeg','marksheet10_ADM2026006_1782469426.pdf','marksheet12_ADM2026006_1782469426.pdf','leaving_certificate_ADM2026006_1782469426.pdf','aadhaar_ADM2026006_1782469426.pdf'),(7,9,'photo_ADM2026007_1782557010.jpeg','marksheet10_ADM2026007_1782557010.pdf','marksheet12_ADM2026007_1782557010.pdf','leaving_certificate_ADM2026007_1782557010.pdf','aadhaar_ADM2026007_1782557010.pdf'),(9,11,'photo_ADM2026009_1784006038.jpeg','marksheet10_ADM2026009_1784006038.pdf','marksheet12_ADM2026009_1784006038.pdf','leaving_certificate_ADM2026009_1784006038.pdf','aadhaar_ADM2026009_1784006038.pdf'),(10,12,'photo_ADM2026010_1784382393.jpeg','marksheet10_ADM2026010_1784382393.pdf','marksheet12_ADM2026010_1784382393.pdf','leaving_certificate_ADM2026010_1784382393.pdf','aadhaar_ADM2026010_1784382393.pdf');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_history`
--

DROP TABLE IF EXISTS `status_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status_history` (
  `history_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `status` enum('Pending','Approved','Rejected') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`history_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `status_history_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_history`
--

LOCK TABLES `status_history` WRITE;
/*!40000 ALTER TABLE `status_history` DISABLE KEYS */;
INSERT INTO `status_history` VALUES (13,6,'Pending','Application submitted by student.','2026-06-26 10:25:07'),(14,6,'Approved','Verified and approved by staff member: John Staff','2026-06-26 10:27:23'),(15,9,'Pending','Application submitted by student.','2026-06-27 10:43:59'),(16,9,'Approved','Verified and approved by staff member: John Staff','2026-06-27 11:04:57'),(21,11,'Pending','Application submitted by student.','2026-07-14 05:14:24'),(22,11,'Approved','qwkne','2026-07-14 05:15:29'),(23,12,'Pending','Application submitted by student.','2026-07-18 13:50:13'),(24,12,'Approved','Your ?Application Submitted Successfully.\r\nAdmission Confirm ✔.\r\n\r\nThank You,\r\nConfirm By Faculty of : B.Sc. Information Technology (B.Sc. IT)\r\nFaculty Name - Vandanaben Patel','2026-07-18 14:23:29'),(25,14,'Approved','Status updated to Approved by administrator.','2026-08-18 15:40:57'),(26,14,'Pending','Status updated to Pending by administrator.','2026-08-18 15:41:15');
/*!40000 ALTER TABLE `status_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `student_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `admission_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('Male','Female','Other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenth_percentage` decimal(5,2) NOT NULL,
  `twelfth_percentage` decimal(5,2) NOT NULL,
  `school_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passing_year` int NOT NULL,
  `course_id` int DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `is_submitted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_status` enum('Unpaid','Paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unpaid',
  `transaction_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `admission_no` (`admission_no`),
  UNIQUE KEY `mobile` (`mobile`),
  UNIQUE KEY `email` (`email`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `students_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (6,7,'ADM2026006','Parmar anilbhai mukulbhai','mukulbhai','aaratiben','Male','2006-10-29','ST','9033120744','parmaranilbhai@gmail.com','Kantheriya Hanuman Mandir Road','Palanpur','Gujarat','385001',60.50,70.54,'dsflfewoifefoiwjoi',2025,2,'Approved',1,'2026-06-26 10:22:56','Paid','8989482984924'),(9,8,'ADM2026007','Sharma Aayush SureshBhai','SureshBhai','Shilpaben','Male','2006-12-29','General','4090902930','SharmaAayush123@gmail.com','5CHR+JR6','Palanpur','Gujarat','385001',70.65,80.54,'fkefwejfoiwejfoiwejfoi',2025,1,'Approved',1,'2026-06-27 10:32:12','Paid','490238948303'),(11,10,'ADM2026009','Patel Rahul Rameshbhai','Rameshbhai','Sitaben','Male','2007-02-01','General','8423874084','patelrahul@gmail.com','Kantheriya Hanuman Mandir Road','Palanpur','Gujarat','385001',70.54,68.54,'dflndlfnefnwelfwelkfn',2026,1,'Approved',1,'2026-07-14 05:13:22','Paid','2389329472374'),(12,11,'ADM2026010','Solanki Laksh Hiteshbhai','Hiteshbhai','Ranjanben','Male','2006-12-29','SC','9033320744','lakshsolanki848@gmail.com','Kantheriya Hanuman Mandir Road','Palanpur','Gujarat','385001',80.33,81.43,'Swastik School Palanpur',2025,5,'Approved',1,'2026-07-18 13:45:59','Paid','8989482984924'),(14,13,'ADM2026011','Modi Harsh PareshBhai','Modi Paresh Bhai','Pinky Ben','Male','2005-05-02','OBC','09033220744','modiharsh@gmail.com','Kantheriya Hanuman Mandir Road','Palanpur','Gujarat','385001',60.54,70.43,'Swastik High School',2023,3,'Pending',0,'2026-07-31 04:44:36','Unpaid',NULL);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','student') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Default Admin','admin@college.com','$2y$10$rSNB6RwmyfsrTTiOiw846esSVblz.vyVdf1lpGocM4WrOWkGTvc2O','admin'),(7,'parmar anilbhai mukulbhai','parmaranilbhai@gmail.com','$2y$10$87e..mrfBL6.0TVwwNGOZ.tW7EcJYROK7zolL5Ze1sPHCImDwoCae','student'),(8,'Sharma Aayush SureshBhai','SharmaAayush123@gmail.com','$2y$10$bA4cuGHgepW/qUdK7TeNmOCUZbtCTvOKi3O//650SQe2UD0Wklo/K','student'),(10,'Patel Rahul Rameshbhai','patelrahul@gmail.com','$2y$10$s0tEv6.u.xU9ykPeQ3RO2e9teRDb8Vqwy6brMNUzRh4IfThp/htKW','student'),(11,'Solanki Laksh Hiteshbhai','lakshsolanki848@gmail.com','$2y$10$d7bWThy1t2s3hWsf0DD8HOEUz3urDFdCFsUFTaqev0V712aub2772','student'),(13,'Modi Harsh PareshBhai','modiharsh@gmail.com','$2y$10$WPxciEdmVaPc5iU1RcrQW.i3PLwIl5.1iq2HiyBRyqf8V2.vG1CHy','student');
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

-- Dump completed on 2026-08-22 23:10:54
