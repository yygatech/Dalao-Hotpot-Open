# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: eys.red (MySQL 5.6.39)
# Database: restaurant
# Generation Time: 2018-04-25 03:07:04 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table cart
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `dish_id` int(11) unsigned DEFAULT NULL,
  `dish_qty` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`dish_id`),
  KEY `dish_id` (`dish_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `dish` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;

INSERT INTO `cart` (`id`, `user_id`, `dish_id`, `dish_qty`)
VALUES
	(1263,25,1,2),
	(1272,22,3,1),
	(1297,27,11,1),
	(1314,22,1,1);

/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dish
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dish`;

CREATE TABLE `dish` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(300) DEFAULT '',
  `price` float(10,2) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `calorie` int(11) NOT NULL,
  `vegetarian` tinyint(1) NOT NULL,
  `photo` varchar(100) NOT NULL DEFAULT 'assets/img/course/default.jpg',
  `inventory` int(11) NOT NULL,
  `availability` tinyint(1) NOT NULL COMMENT 'available=1, non-available=0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `dish` WRITE;
/*!40000 ALTER TABLE `dish` DISABLE KEYS */;

INSERT INTO `dish` (`id`, `name`, `description`, `price`, `category`, `calorie`, `vegetarian`, `photo`, `inventory`, `availability`)
VALUES
	(1,'Dating Spring Combo','It is a very delicious combo.',16.99,'Combo',1600,0,'assets/img/course/1.png',38,1),
	(2,'Family Combo','Hejiahuan Combo',64.99,'Combo',6400,0,'assets/img/course/2.jpeg',61,1),
	(3,'Happy Party Combo','Huanlepaidui Combo',29.99,'Combo',2900,0,'assets/img/course/3.jpeg',71,1),
	(4,'Prairie Mutton Combo','This mutton is from the wetern Mongolia prairie',31.99,'Combo',3100,0,'assets/img/course/4.jpeg',100,1),
	(5,'Ace Family Combo','Gold Family Combo',44.99,'Combo',4400,0,'assets/img/course/5.jpeg',96,1),
	(6,'Tomato Beef Combo','Tomato Feiniu Combo',13.99,'Combo',1300,0,'assets/img/course/6.jpeg',100,1),
	(7,'Pork Belly','Five Flower Pork',5.49,'Meat',500,0,'assets/img/course/7.png',99,1),
	(8,'Golden Pine Meat','Hjsbrou',5.49,'Meat',500,0,'assets/img/course/8.jpeg',99,1),
	(9,'Fish Roll','Xwyj',3.49,'Seafood',300,0,'assets/img/course/9.png',98,1),
	(10,'Basha Fish Roll','Bsy',3.49,'Seafood',300,0,'assets/img/course/10.png',100,1),
	(11,'Chinese Cabbage','Very fresh Chinese Cabbage! Come and enjoy',1.99,'Vegetable',250,1,'assets/img/course/11.png',298,1),
	(12,'Oiled Wheat Dish','Ymc',1.99,'Vegetable',100,1,'assets/img/course/12.png',100,1),
	(13,'White Radish','Blb',1.99,'Vegetable',100,0,'assets/img/course/13.png',0,0),
	(14,'Yam','Sy',1.99,'Vegetable',100,1,'assets/img/course/14.png',100,1),
	(15,'Bean Skin','Dp',1.99,'Soy',100,1,'assets/img/course/15.png',100,1),
	(16,'Frozen Tofu','Ddf',1.99,'Soy',100,1,'assets/img/course/16.png',100,1),
	(17,'Oil Gluten','Mj',1.99,'Soy',100,1,'assets/img/course/17.png',100,1),
	(18,'Enokitake','Jzg',1.99,'Mushroom',100,1,'assets/img/course/18.png',100,0),
	(19,'Crab Flavor Mushroom','Xwg',1.99,'Mushroom',100,1,'assets/img/course/19.png',100,1),
	(20,'Fritters','Yt',1.99,'Wheat',100,1,'assets/img/course/20.png',100,1),
	(21,'Mahjong Cookies','Mjsb',1.99,'Wheat',100,1,'assets/img/course/21.jpeg',99,1),
	(22,'Ramen','lm',1.99,'Wheat',100,1,'assets/img/course/22.png',100,1),
	(23,'Pickle Base','Pcgd',3.49,'Base',300,1,'assets/img/course/23.png',99,1),
	(24,'Super Spicy Base','Qyml',3.49,'Base',300,1,'assets/img/course/24.jpeg',100,1),
	(25,'Matsutake Base','Srjt',3.49,'Base',300,1,'assets/img/course/25.jpeg',100,1),
	(26,'Curry Base','Curry',3.49,'Base',300,1,'assets/img/course/26.jpeg',100,1),
	(27,'Original Sauce','Jdyx',1.49,'Sauce',100,1,'assets/img/course/27.jpeg',99,1),
	(28,'Sa teh Sauce','Twsc',1.49,'Sauce',100,1,'assets/img/course/28.png',96,1),
	(29,'Fresh Sauce','Xwz',1.49,'Sauce',100,1,'assets/img/course/29.png',99,1),
	(30,'Coca Cola','(Can)',1.49,'Drink',100,1,'assets/img/course/30.jpeg',1198,1),
	(31,'Yanjing Beer','(Can)',1.49,'Drink',100,1,'assets/img/course/31.png',99,1),
	(35,'Our Project','?	Abstract - Dalao Hotpot is a website that implements functions of making orders online. Users are allowed to search their favorite dishes in our website with various filters in the left side. Once a user has decided what dishes to buy, they could click on the dishes they want in order to add them ',999.00,'Other',0,1,'assets/img/course/???.jpg',1,1);

/*!40000 ALTER TABLE `dish` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `built_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_message` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `tip` float(11,2) NOT NULL,
  `processed_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'processed: 1; unprocessed: 0',
  `delivery_fee` float(11,2) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;

INSERT INTO `order` (`order_id`, `user_id`, `built_time`, `user_message`, `tip`, `processed_status`, `delivery_fee`)
VALUES
	(1,22,'2018-04-18 13:49:47','No spicy, I really really don\'t want spicy.',2.50,0,5.00),
	(2,22,'2018-04-14 19:27:12','No tip pay for you hahahaha',1.20,0,0.00),
	(3,22,'2018-04-18 13:49:47','Please give me more sauce, thank you.',30.44,1,5.00),
	(4,21,'2018-04-14 19:25:26','No spicy, no damn spicy!!!',99.88,1,5.00),
	(5,21,'2018-04-14 19:25:23','Please send me a beautiful lady',180.60,0,5.00),
	(6,21,'2018-04-14 19:25:16','Please give me some chopsticks!',8.99,1,44.00),
	(7,21,'2018-04-15 15:36:11','no thing',3.00,0,4.25),
	(8,21,'2018-04-17 13:44:43',NULL,0.00,0,0.00),
	(9,21,'2018-04-17 13:53:53',NULL,2.00,0,0.00),
	(10,21,'2018-04-17 13:57:06','',2.00,0,0.00),
	(11,21,'2018-04-17 14:03:36','',2.00,0,0.00),
	(12,21,'2018-04-17 14:23:34',NULL,2.00,0,5.00),
	(13,21,'2018-04-17 14:26:24',NULL,2.00,0,5.00),
	(14,21,'2018-04-17 14:29:59','msg',2.00,0,5.00),
	(15,21,'2018-04-17 14:30:47','some comment',2.00,0,5.00),
	(16,21,'2018-04-17 17:02:59','',2.00,0,5.00),
	(17,21,'2018-04-17 17:06:17','',2.00,0,5.00),
	(18,21,'2018-04-17 17:06:34','',2.00,0,5.00),
	(19,21,'2018-04-17 17:52:18','',2.00,0,5.00),
	(20,21,'2018-04-17 17:56:06','',3.00,0,5.00),
	(21,21,'2018-04-17 17:56:45','',3.00,0,5.00),
	(22,21,'2018-04-17 18:05:27','',3.00,0,0.00),
	(23,21,'2018-04-17 18:07:48','No No Spicy',2.00,0,0.00),
	(24,21,'2018-04-17 18:19:37','',2.00,0,0.00),
	(25,21,'2018-04-17 18:38:12','',2.00,0,0.00),
	(26,21,'2018-04-17 18:43:43','',2.00,0,5.00),
	(27,21,'2018-04-17 18:44:55','',2.00,0,5.00),
	(28,21,'2018-04-17 18:46:33','',2.00,0,5.00),
	(29,21,'2018-04-17 18:49:56','',3.00,0,5.00),
	(30,25,'2018-04-18 14:19:45','',2.00,0,0.00),
	(31,22,'2018-04-18 14:21:50','Meat meat meat meat',3.00,0,5.00),
	(32,22,'2018-04-18 14:23:23','',2.00,0,0.00),
	(33,21,'2018-04-18 23:32:30','',2.00,0,0.00),
	(34,21,'2018-04-18 23:35:36','',2.00,0,0.00),
	(35,24,'2018-04-18 23:54:44','',2.00,0,5.00),
	(36,24,'2018-04-19 00:01:19','',2.00,0,5.00),
	(37,22,'2018-04-19 00:21:06','Hello web programming language',2.00,0,0.00),
	(38,27,'2018-04-19 01:57:19','',2.00,0,5.00),
	(39,27,'2018-04-19 01:58:27','',2.00,0,0.00),
	(40,27,'2018-04-19 02:02:36','',2.00,0,5.00),
	(41,27,'2018-04-19 02:07:50','some comment',2.00,0,0.00),
	(42,27,'2018-04-19 02:10:48','It\'s my first order!',2.00,0,5.00),
	(43,27,'2018-04-19 02:12:58','',90.00,0,0.00),
	(44,27,'2018-04-19 02:13:36','《》《》&lt;&gt;&lt;&gt;///\'\'\'&quot;&quot;&quot;',2.00,0,0.00),
	(45,21,'2018-04-19 04:39:15','',2.00,0,0.00),
	(46,21,'2018-04-19 05:06:13','',3.00,0,0.00),
	(47,21,'2018-04-19 05:06:46','some sauces!',2.00,0,5.00),
	(48,21,'2018-04-20 20:27:02','msg',2.00,0,0.00),
	(49,28,'2018-04-22 21:22:20','',1.00,0,5.00),
	(50,21,'2018-04-23 18:43:47','Please no spicy.',3.00,0,0.00);

/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ordered_dish_qty
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ordered_dish_qty`;

CREATE TABLE `ordered_dish_qty` (
  `order_id` int(11) unsigned NOT NULL,
  `dish_id` int(11) unsigned NOT NULL,
  `dish_quantity` int(11) NOT NULL,
  `dish_price_that_time` float(10,2) NOT NULL,
  PRIMARY KEY (`order_id`,`dish_id`) USING BTREE,
  KEY `d_id` (`dish_id`),
  CONSTRAINT `d_id` FOREIGN KEY (`dish_id`) REFERENCES `dish` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `ordered_dish_qty` WRITE;
/*!40000 ALTER TABLE `ordered_dish_qty` DISABLE KEYS */;

INSERT INTO `ordered_dish_qty` (`order_id`, `dish_id`, `dish_quantity`, `dish_price_that_time`)
VALUES
	(1,9,5,1.23),
	(1,10,12,4.56),
	(2,20,101,0.89),
	(2,21,10,120.01),
	(2,22,1,208.90),
	(3,3,15,10.00),
	(4,1,2,0.00),
	(4,12,9,0.00),
	(4,13,8,0.00),
	(5,20,20,0.00),
	(5,21,30,0.00),
	(6,5,8,0.00),
	(19,1,3,17.00),
	(20,1,2,16.99),
	(21,1,1,16.99),
	(21,2,2,64.99),
	(22,1,1,16.99),
	(22,2,2,64.99),
	(22,30,1,1.49),
	(23,1,1,16.99),
	(23,2,2,64.99),
	(23,30,1,1.49),
	(24,1,1,16.99),
	(24,2,2,64.99),
	(24,30,1,1.49),
	(25,1,1,16.99),
	(25,2,2,64.99),
	(25,30,1,1.49),
	(26,1,1,16.99),
	(27,1,1,16.99),
	(28,5,1,44.99),
	(29,30,5,1.49),
	(30,1,9,16.99),
	(30,2,20,64.99),
	(30,3,1,29.99),
	(31,30,1,1.49),
	(32,1,10,16.99),
	(32,2,2,64.99),
	(33,1,3,16.99),
	(33,2,1,64.99),
	(34,2,1,64.99),
	(34,3,1,29.99),
	(35,1,1,16.99),
	(35,3,1,29.99),
	(36,3,1,29.99),
	(36,30,1,1.49),
	(37,2,1,64.99),
	(38,5,1,44.99),
	(38,21,1,1.99),
	(39,5,1,44.99),
	(39,9,1,3.49),
	(39,11,1,1.99),
	(39,30,1,1.49),
	(40,27,1,1.49),
	(40,31,1,1.49),
	(41,2,1,64.99),
	(42,28,1,1.49),
	(43,3,20,29.99),
	(44,11,98,1.99),
	(45,3,3,29.99),
	(46,2,1,64.99),
	(46,3,1,29.99),
	(46,11,1,1.99),
	(46,23,1,3.49),
	(47,28,1,1.49),
	(47,29,1,1.49),
	(48,2,1,64.99),
	(49,3,1,29.99),
	(50,2,1,64.99),
	(50,7,1,5.49),
	(50,8,1,5.49),
	(50,11,1,1.99);

/*!40000 ALTER TABLE `ordered_dish_qty` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL DEFAULT '',
  `pwd` varchar(64) NOT NULL DEFAULT '' COMMENT 'SHA256',
  `sign_up_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0: Disabled / 1: Normal',
  `role` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '0: User / 1: Admin',
  `mobile` char(10) NOT NULL DEFAULT '',
  `email` varchar(40) NOT NULL DEFAULT '',
  `first_name` varchar(30) NOT NULL DEFAULT '',
  `last_name` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `mobile` (`mobile`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`user_id`, `username`, `pwd`, `sign_up_timestamp`, `status`, `role`, `mobile`, `email`, `first_name`, `last_name`)
VALUES
	(21,'henry','e147f1449509fed54425821e9843de7aeaf819382d2c1d36d7bc6aed7ed4a32f','2018-03-15 14:25:19',1,1,'4699747431','eysure@gmail.com','Xinyang','Zhu'),
	(22,'laurence','fb1f4423452af270e30212dbc81a51aa39588ee5f742b177d4834f4c2dfd0531','2018-03-15 14:42:09',1,1,'8888888888','laurence@gmail.com','Laurence','Lo'),
	(24,'eysure','e147f1449509fed54425821e9843de7aeaf819382d2c1d36d7bc6aed7ed4a32f','2018-03-16 11:09:29',1,0,'8898988989','eysure@icloud.com','Xinyang','Zhu'),
	(25,'yygatech','35ee474e7086146ec0a647e6d9df4ef6cd941243db8feec92e951603b4596d11','2018-04-14 13:34:14',1,1,'4048258090','yxy175230@utdallas.edu','Ye','Yao'),
	(26,'testuser','ae5deb822e0d71992900471a7199d0d95b8e7c9d05c40a8245a281fd2c1d6684','2018-04-18 18:49:03',1,0,'1234567899','1@gmail.com','test','user'),
	(27,'tester','854ddc006369eb7bac38bb6690e7f9b05d0d68659be1f96564df407d653e0df2','2018-04-19 01:54:29',1,0,'1231231231','tester123@tt.com','Tester','Zhu'),
	(28,'imctr','40424f8df89a8b7ea3620584ef53e8624eedab2a1600a82e7873c3ac38830baa','2018-04-22 21:21:44',1,0,'4445556363','txc@ctr.com','Tianrou','Chang');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
