/*
SQLyog Ultimate v12.4.0 (64 bit)
MySQL - 10.1.25-MariaDB : Database - club-db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`club-db` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `club-db`;

/*Table structure for table `apps` */

DROP TABLE IF EXISTS `apps`;

CREATE TABLE `apps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `bundle_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `fcm_key` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `layout` enum('grid','list') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'grid',
  `logo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `background` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `apps_bundle_id_unique` (`bundle_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `apps` */

insert  into `apps`(`id`,`title`,`bundle_id`,`fcm_key`,`layout`,`logo`,`background`,`user_id`,`deleted_at`,`created_at`,`updated_at`) values 
(3,'test','test1','','list',NULL,'253,253,253,1',1,'2017-08-11 15:39:30',NULL,'2017-08-11 15:39:30'),
(4,'second','2kdjof23','','grid','','253,253,253,1',1,'2017-08-11 15:39:33',NULL,'2017-08-11 15:39:33'),
(5,'ff','ff','','list','','255,255,255,1',1,'2017-08-11 15:39:34',NULL,'2017-08-11 15:39:34'),
(6,'fewf','wefs','','list','logos/instagram1502373373.PNG','255,255,255,1',1,'2017-08-11 15:39:34',NULL,'2017-08-11 15:39:34'),
(8,'fwef','wefqwefasdfwef','','grid','logos/instagram1502373536.PNG','0,255,255,1',1,'2017-08-11 15:39:35',NULL,'2017-08-11 15:39:35'),
(17,'wefqwef','asdfwef','','list','logos/185958-social-media-icons1502466643.png','255,146,0,1',1,'2017-08-11 15:50:54',NULL,'2017-08-11 15:50:54'),
(18,'asdf','qqqqq','','list','logos/youtube1502466862.PNG','255,255,255,1',1,'2017-08-11 15:54:33',NULL,'2017-08-11 15:54:33'),
(19,'asdf','2412rqewr','','list','logos/facebook1502466951.PNG','255,255,255,1',1,'2017-08-11 15:55:56',NULL,'2017-08-11 15:55:56'),
(20,'asdfqwe','142135234','','list','logos/youtube1502467013.PNG','255,255,255,1',1,'2017-08-11 15:58:08',NULL,'2017-08-11 15:58:08'),
(21,'test1','aaabbbccc','asfwef','grid','logos/185958-social-media-icons1502532795.png','255,255,255,1',1,NULL,NULL,'2017-08-15 18:24:26'),
(22,'asdfwef','qwefwqef','','grid','logos/googleplus1502799314.PNG','56,199,128,1',1,'2017-08-15 12:16:51',NULL,'2017-08-15 12:16:51'),
(24,'asdf','wef','','grid','logos/facebook1502800091.PNG','24,158,91,1',1,'2017-08-15 12:28:47',NULL,'2017-08-15 12:28:47'),
(25,'asdf','wefewf','fwefwf','grid','logos/youtube1502818760.PNG','46,146,96,1',1,'2017-08-15 18:11:21',NULL,'2017-08-15 18:11:21'),
(27,'vvvv','vasdf','avsdfef','list','logos/twitter1502821012.PNG','110,187,148,1',1,'2017-08-15 18:17:00',NULL,'2017-08-15 18:17:00'),
(28,'asdffwefwef','wefwef','asdfwef','list','logos/youtube1502822195.PNG','255,255,255,1',1,'2017-08-15 18:37:21',NULL,'2017-08-15 18:37:21'),
(29,'CLUB','com.YRH.App.Club','1234567890','list','logos/nexgolf-logo-lg1502835925.png','167,212,189,1',1,NULL,NULL,NULL);

/*Table structure for table `device_options` */

DROP TABLE IF EXISTS `device_options`;

CREATE TABLE `device_options` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` varchar(255) DEFAULT NULL,
  `bundle_id` varchar(255) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `on` tinyint(2) DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `device_options` */

insert  into `device_options`(`_id`,`device_id`,`bundle_id`,`id`,`on`,`deleted_at`,`updated_at`,`created_at`) values 
(1,'device udid','com.YRH.App.Club',1,0,NULL,'2017-08-15 21:37:21','2017-08-16 05:36:43'),
(2,'device udid','com.YRH.App.Club',2,1,NULL,NULL,'2017-08-16 05:37:21');

/*Table structure for table `device_tokens` */

DROP TABLE IF EXISTS `device_tokens`;

CREATE TABLE `device_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bundle_id` varchar(255) DEFAULT NULL,
  `device_id` varchar(255) DEFAULT NULL,
  `device_token` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `device_tokens` */

insert  into `device_tokens`(`id`,`bundle_id`,`device_id`,`device_token`,`updated_at`,`created_at`,`deleted_at`) values 
(1,'aaabbbccc','123123123','dsafqwefqwef',NULL,NULL,NULL),
(2,'asdefwef','asdfe','ffff','2017-08-15 21:16:52',NULL,NULL);

/*Table structure for table `feed_details` */

DROP TABLE IF EXISTS `feed_details`;

CREATE TABLE `feed_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `team_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `app_bundle_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `feed_id` int(10) unsigned NOT NULL,
  `order` int(11) DEFAULT NULL,
  `customed_title` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customed_logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feed_details_app_bundle_id_foreign` (`app_bundle_id`),
  KEY `feed_details_feed_id_foreign` (`feed_id`),
  CONSTRAINT `feed_details_app_bundle_id_foreign` FOREIGN KEY (`app_bundle_id`) REFERENCES `apps` (`bundle_id`) ON DELETE CASCADE,
  CONSTRAINT `feed_details_feed_id_foreign` FOREIGN KEY (`feed_id`) REFERENCES `feeds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `feed_details` */

insert  into `feed_details`(`id`,`link`,`team_name`,`app_bundle_id`,`feed_id`,`order`,`customed_title`,`customed_logo`,`created_at`,`updated_at`,`deleted_at`) values 
(2,'ttt','t','test1',4,0,NULL,NULL,NULL,'2017-08-11 15:55:34','2017-08-11 15:55:34'),
(3,'www.dropbox.com','golf','2kdjof23',3,0,'dropboxsss',NULL,NULL,'2017-08-11 15:47:40','2017-08-11 15:47:40'),
(4,'ggg','gg','ff',4,0,NULL,NULL,NULL,'2017-08-11 15:38:32','2017-08-11 15:38:32'),
(13,'asfd','wef','asdfwef',4,0,'','',NULL,'2017-08-11 15:55:32','2017-08-11 15:55:32'),
(14,'asdf','wefwef','qqqqq',4,0,'','',NULL,'2017-08-11 15:55:33','2017-08-11 15:55:33'),
(15,'qwef','asdf','2412rqewr',4,0,'','',NULL,'2017-08-11 15:56:27','2017-08-11 15:56:27'),
(16,'qwef','asdf','142135234',6,0,'','',NULL,'2017-08-11 15:58:08','2017-08-11 15:58:08'),
(17,'fff','wfewf','aaabbbccc',4,0,'','',NULL,'2017-08-15 18:24:10','2017-08-15 18:24:10'),
(18,'asdf','wef','aaabbbccc',5,1,'','',NULL,'2017-08-15 18:24:10','2017-08-15 18:24:10'),
(19,'asdf','wef','qwefwqef',4,0,'','',NULL,'2017-08-15 12:15:32','2017-08-15 12:15:32'),
(20,'asdf','wef','wef',4,0,'','',NULL,'2017-08-15 12:28:17','2017-08-15 12:28:17'),
(21,'wef','asf','wefewf',4,0,'','',NULL,'2017-08-15 18:11:21','2017-08-15 18:11:21'),
(22,'asfwe','fsfxzvcxv','vasdf',6,0,'','',NULL,'2017-08-15 18:17:00','2017-08-15 18:17:00'),
(23,'fff','wfewf','aaabbbccc',4,0,'','',NULL,'2017-08-15 18:24:26','2017-08-15 18:24:26'),
(24,'asdf','wef','aaabbbccc',5,1,'','',NULL,'2017-08-15 18:24:26','2017-08-15 18:24:26'),
(25,'fff','wfewf','aaabbbccc',4,0,'','',NULL,NULL,NULL),
(26,'asdf','wef','aaabbbccc',5,1,'','',NULL,NULL,NULL),
(27,'asdf','wef','aaabbbccc',6,2,'','',NULL,NULL,NULL),
(28,'asdfsdfs','fesfsef','wefwef',4,0,'','',NULL,'2017-08-15 18:36:38','2017-08-15 18:36:38'),
(29,'http://www.uefa.com/rssfeed/news/rss.xml','UEFA','com.YRH.App.Club',5,0,'','logos/facebook_icon1502835767.png',NULL,NULL,NULL),
(30,'http://www.uspgagolf.com/pgagolftour.xml','GOLF','com.YRH.App.Club',4,1,'','logos/twitter-3-xxl1502835747.png',NULL,NULL,NULL);

/*Table structure for table `feeds` */

DROP TABLE IF EXISTS `feeds`;

CREATE TABLE `feeds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `feeds` */

insert  into `feeds`(`id`,`title`,`logo`,`deleted_at`,`created_at`,`updated_at`) values 
(3,'dropbox','logos/dropbox1502308354.PNG','2017-08-11 15:47:40','2017-08-09 19:52:53','2017-08-11 15:47:40'),
(4,'Twitters','logos/twitter1502308466.PNG',NULL,'2017-08-09 19:54:44','2017-08-11 16:00:51'),
(5,'FaceBook','logos/facebook1502431847.PNG',NULL,'2017-08-09 19:55:41','2017-08-11 06:10:51'),
(6,'Youtube','logos/youtube1502423750.PNG',NULL,'2017-08-11 03:56:12','2017-08-11 03:56:12');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2017_07_25_070053_create_apps_table',1),
(4,'2017_08_07_042250_create_feeds_table',1),
(5,'2017_08_07_043001_create_feed_details_table',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,'CLUB','admin@club.com','$2y$10$vsZ6rJtq8kfPE8y/QQurFOiNUwPsiR/.cEOwdxS2kSwd8p/bA9PNq','mryxTmHrkIcTE1p2vrtoIdWiOEN5AuKSI1qAqC0RK3i3G2tZkwEuRmRi0II0',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
