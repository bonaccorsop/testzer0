# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.11)
# Database: testZer0
# Generation Time: 2017-06-15 17:32:17 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `content` text,
  `emotion` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;

INSERT INTO `posts` (`id`, `user_id`, `created_at`, `updated_at`, `deleted_at`, `content`, `emotion`)
VALUES
  (1,NULL,NULL,NULL,NULL,'Lorem Ipsum Ok!','Happy'),
  (2,NULL,NULL,NULL,NULL,'Prova 2 delle valchirie','Angry'),
  (3,NULL,NULL,NULL,NULL,'Prova 2 delle valchirie','Angry'),
  (4,NULL,NULL,NULL,NULL,'Prova 2 delle valchirie','Angry'),
  (5,NULL,NULL,NULL,NULL,'Prova 2 delle valchirie','Angry'),
  (6,NULL,NULL,NULL,NULL,'Prova 2 delle valchirie','Angry'),
  (7,NULL,NULL,NULL,NULL,'Prova 2 delle valchirie','Angry'),
  (8,NULL,NULL,NULL,NULL,'Prova 2 delle valchirie','Angry'),
  (9,NULL,NULL,NULL,NULL,'Prova 2 delle valchirie','Angry'),
  (10,NULL,NULL,NULL,NULL,'Prova 2 delle valchirie','Angry'),
  (11,NULL,NULL,NULL,NULL,'Prova 2 delle valchirie','Angry'),
  (12,NULL,NULL,NULL,NULL,'Prova 2 delle valchirie','Angry'),
  (13,NULL,NULL,NULL,NULL,'Prova 2 delle valchirie','Angry'),
  (14,NULL,NULL,NULL,NULL,'Prova 2 delle valchirie','Angry'),
  (15,NULL,NULL,NULL,NULL,'Prova 2 delle valchirie','Angry');

/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `jwt_token` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `created_at`, `updated_at`, `deleted_at`, `email`, `password`, `jwt_token`)
VALUES
  (1,'2017-06-15 16:30:21','2017-06-15 16:30:21',NULL,'pietro.b@mosaicoon.com','5b3b8bf8b36b9816de7880ce56567eb17aaf9c80',NULL);

UNLOCK TABLES;
