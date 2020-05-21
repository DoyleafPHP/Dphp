-- MySQL dump 10.13  Distrib 5.5.53, for Win32 (AMD64)
--
-- Host: localhost    Database: dphp
-- ------------------------------------------------------
-- Server version	5.5.53

/*!40101 set @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 set @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 set @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 set names utf8 */;
/*!40103 set @OLD_TIME_ZONE = @@TIME_ZONE */;
/*!40103 set TIME_ZONE = '+00:00' */;
/*!40014 set @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0 */;
/*!40014 set @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 set @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 set @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;

--
-- Table structure for table `d_foo`
--

drop table if exists `d_foo`;
/*!40101 set @saved_cs_client = @@character_set_client */;
/*!40101 set character_set_client = utf8 */;
create table `d_foo` (
    `id`      int(11)      not null,
    `title`   varchar(200) not null,
    `content` text         not null
)
    engine = InnoDB
    default charset = utf8mb4;
/*!40101 set character_set_client = @saved_cs_client */;

--
-- Dumping data for table `d_foo`
--

lock tables `d_foo` write;
/*!40000 alter table `d_foo`
    disable keys */;
insert into `d_foo`
values (
    1, '我是标题', '<h3>我是内容呀~~</h3><p>我真的是内容，不信算了，哼~ O(∩_∩)O</p>'
),(
    2, '我是标题', '<h3>我是内容呀~~</h3><p>我真的是内容，不信算了，哼~ O(∩_∩)O</p>'
);
/*!40000 alter table `d_foo`
    enable keys */;
unlock tables;
/*!40103 set TIME_ZONE = @OLD_TIME_ZONE */;

/*!40101 set SQL_MODE = @OLD_SQL_MODE */;
/*!40014 set FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40014 set UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS */;
/*!40101 set CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 set CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 set COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
/*!40111 set SQL_NOTES = @OLD_SQL_NOTES */;

-- Dump completed on 2018-05-28 18:07:17
