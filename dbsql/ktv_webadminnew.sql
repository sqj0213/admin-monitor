# SQL-Front 4.1  (Build 1.93)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


# Host: 123.125.120.102    Database: ktv_webadmin
# ------------------------------------------------------
# Server version 5.1.46

DROP DATABASE IF EXISTS `webadmin`;
CREATE DATABASE `webadmin` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `webadmin`;

#
# Table structure for table influence
#

CREATE TABLE `influence` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '',
  `keyValueID` tinyint(4) NOT NULL DEFAULT '0',
  `regTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nodeLevel` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;


#
# Dumping data for table influence
#
LOCK TABLES `influence` WRITE;
/*!40000 ALTER TABLE `influence` DISABLE KEYS */;

INSERT INTO `influence` VALUES (48,'è¶…çº§ç®¡ç†å‘˜',33,'2008-02-15 17:27:09',0);
INSERT INTO `influence` VALUES (51,'æ™®é€šç”¨æˆ·',33,'2008-11-20 16:36:13',0);
INSERT INTO `influence` VALUES (73,'asdsd',33,'2008-12-04 14:24:45',0);
INSERT INTO `influence` VALUES (74,'23sdsdsd',33,'2008-12-04 14:26:15',0);
INSERT INTO `influence` VALUES (75,'ads2sd',33,'2008-12-04 14:26:56',0);
INSERT INTO `influence` VALUES (78,'asdfdasf',33,'2008-12-04 15:40:00',0);
INSERT INTO `influence` VALUES (79,'asdf23sd',33,'2008-12-04 15:42:14',0);
/*!40000 ALTER TABLE `influence` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table keyValue
#

CREATE TABLE `keyValue` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `keyName` varchar(20) NOT NULL DEFAULT '',
  `typeFlag` tinyint(4) NOT NULL DEFAULT '0',
  `value` int(11) NOT NULL DEFAULT '0',
  `delFlag` tinyint(4) NOT NULL DEFAULT '0',
  `note` varchar(20) NOT NULL DEFAULT '',
  `pid` bigint(20) NOT NULL DEFAULT '0',
  `regtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;


#
# Dumping data for table keyValue
#
LOCK TABLES `keyValue` WRITE;
/*!40000 ALTER TABLE `keyValue` DISABLE KEYS */;

INSERT INTO `keyValue` VALUES (6,'ç¦ç”¨è§’è‰²',1,1,0,'è§’è‰²ç®¡ç†ç”¨',0,'2007-12-27 12:54:35');
INSERT INTO `keyValue` VALUES (20,'å±±è¥¿çœ',4,1,0,'çœå¸‚åç§°',0,'2008-01-02 13:07:22');
INSERT INTO `keyValue` VALUES (21,'å†…è’™å¤',4,2,0,'çœå¸‚åç§°',0,'2008-01-02 13:09:24');
INSERT INTO `keyValue` VALUES (22,'åŒ—äº¬å¸‚',4,3,0,'çœå¸‚åç§°',0,'2008-01-02 13:09:50');
INSERT INTO `keyValue` VALUES (23,'æ²³åŒ—çœ',4,4,0,'çœå¸‚åç§°',0,'2008-01-02 13:10:02');
INSERT INTO `keyValue` VALUES (24,'é™•è¥¿çœ',4,5,0,'çœå¸‚åç§°',0,'2008-01-02 13:10:20');
INSERT INTO `keyValue` VALUES (25,'è¾½å®çœ',4,6,0,'çœå¸‚åç§°',0,'2008-01-02 13:10:34');
INSERT INTO `keyValue` VALUES (26,'é»‘é¾™æ±Ÿ',4,7,0,'çœå¸‚åç§°',0,'2008-01-02 13:10:54');
INSERT INTO `keyValue` VALUES (27,'æ–°ç–†',4,8,0,'çœå¸‚åç§°',0,'2008-01-02 13:11:14');
INSERT INTO `keyValue` VALUES (28,'å››å·',4,9,0,'çœå¸‚åç§°',0,'2008-01-02 13:11:48');
INSERT INTO `keyValue` VALUES (29,'äº‘å—',4,10,0,'çœå¸‚åç§°',0,'2008-01-02 13:12:11');
INSERT INTO `keyValue` VALUES (30,'æ²³å—çœ',4,11,0,'çœå¸‚åç§°',0,'2008-01-02 13:12:59');
INSERT INTO `keyValue` VALUES (33,'æ­£å¸¸è§’è‰²',1,2,0,'ç”¨æˆ·è§’è‰²ç®¡ç†',0,'2008-01-03 11:01:26');
INSERT INTO `keyValue` VALUES (43,'asdasf',2,10,0,'2spersonadminssd',29,'2008-02-18 17:56:28');
INSERT INTO `keyValue` VALUES (47,'ä¸œåŸŽåŒº',5,2232,0,'22323',20,'2008-02-18 17:59:47');
INSERT INTO `keyValue` VALUES (48,'asdsfssaf',22,22,0,'33232',0,'2008-02-29 08:03:13');
/*!40000 ALTER TABLE `keyValue` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table optlog
#

CREATE TABLE `optlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `text` longtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `userID` bigint(20) NOT NULL DEFAULT '0',
  `clubID` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `regTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;


#
# Dumping data for table optlog
#
LOCK TABLES `optlog` WRITE;
/*!40000 ALTER TABLE `optlog` DISABLE KEYS */;

INSERT INTO `optlog` VALUES (1,'',x'2CC3A5C5BDC5B8C3A5C2AFE280A0C3A7C2A0C2815B617364665D2CC3A7E284A2C2BBC3A5C2BDE280A2C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D2CC3A7C2A1C2AEC3A8C2AEC2A4C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D',18,0,'127.0.0.1','2010-06-22 11:21:47');
INSERT INTO `optlog` VALUES (2,'',x'2CC3A5C5BDC5B8C3A5C2AFE280A0C3A7C2A0C2815B617364665D2CC3A7E284A2C2BBC3A5C2BDE280A2C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D2CC3A7C2A1C2AEC3A8C2AEC2A4C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D',18,0,'127.0.0.1','2010-06-22 11:21:53');
INSERT INTO `optlog` VALUES (3,'',x'2CC3A5C5BDC5B8C3A5C2AFE280A0C3A7C2A0C2815B617364665D2CC3A7E284A2C2BBC3A5C2BDE280A2C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D2CC3A7C2A1C2AEC3A8C2AEC2A4C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D',18,0,'127.0.0.1','2010-06-22 11:23:35');
INSERT INTO `optlog` VALUES (4,'',x'2CC3A5C5BDC5B8C3A5C2AFE280A0C3A7C2A0C2815B617364665D2CC3A7E284A2C2BBC3A5C2BDE280A2C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D2CC3A7C2A1C2AEC3A8C2AEC2A4C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D',18,0,'127.0.0.1','2010-06-22 11:23:50');
INSERT INTO `optlog` VALUES (5,'',x'2CC3A5C5BDC5B8C3A5C2AFE280A0C3A7C2A0C2815B617364665D2CC3A7E284A2C2BBC3A5C2BDE280A2C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D2CC3A7C2A1C2AEC3A8C2AEC2A4C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D',18,0,'127.0.0.1','2010-06-22 11:24:17');
INSERT INTO `optlog` VALUES (6,'',x'2CC3A5C5BDC5B8C3A5C2AFE280A0C3A7C2A0C2815B617364665D2CC3A7E284A2C2BBC3A5C2BDE280A2C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D2CC3A7C2A1C2AEC3A8C2AEC2A4C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D',18,0,'127.0.0.1','2010-06-22 11:24:34');
INSERT INTO `optlog` VALUES (7,'',x'2CC3A5C5BDC5B8C3A5C2AFE280A0C3A7C2A0C2815B415344465D2CC3A7E284A2C2BBC3A5C2BDE280A2C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D2CC3A7C2A1C2AEC3A8C2AEC2A4C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D',18,0,'127.0.0.1','2010-06-22 11:25:12');
INSERT INTO `optlog` VALUES (8,'',x'2CC3A5C5BDC5B8C3A5C2AFE280A0C3A7C2A0C2815B415344465D2CC3A7E284A2C2BBC3A5C2BDE280A2C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D2CC3A7C2A1C2AEC3A8C2AEC2A4C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D',18,0,'127.0.0.1','2010-06-22 11:26:02');
INSERT INTO `optlog` VALUES (9,'莽录鈥撁锯€樏甭幻ヅ锯€\0',x'2CC3A5C5BDC5B8C3A5C2AFE280A0C3A7C2A0C2815B415344465D2CC3A7E284A2C2BBC3A5C2BDE280A2C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D2CC3A7C2A1C2AEC3A8C2AEC2A4C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D',18,0,'127.0.0.1','2010-06-22 11:27:08');
INSERT INTO `optlog` VALUES (10,'莽录鈥撁锯€樏甭幻ヅ锯€\0',x'2CC3A5C5BDC5B8C3A5C2AFE280A0C3A7C2A0C2815B617364665D2CC3A7E284A2C2BBC3A5C2BDE280A2C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D2CC3A7C2A1C2AEC3A8C2AEC2A4C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D',18,0,'127.0.0.1','2010-06-22 11:27:26');
INSERT INTO `optlog` VALUES (11,'氓炉鈥犆犅伱ぢ柯︹€澛姑ヂぢ泵绰?氓赂聬氓聫路[quanjun@staff.sina.com.cn],氓沤鸥氓炉鈥犆犅伱锯€溍モ€βッ┾€濃劉猫炉炉',x'',18,0,'127.0.0.1','2010-06-22 11:48:19');
INSERT INTO `optlog` VALUES (12,'氓炉鈥犆犅伱ぢ柯︹€澛姑ヂぢ泵绰?氓赂聬氓聫路[quanjun@staff.sina.com.cn],氓沤鸥氓炉鈥犆犅伱锯€溍モ€βッ┾€濃劉猫炉炉',x'',18,0,'127.0.0.1','2010-06-22 11:48:27');
INSERT INTO `optlog` VALUES (13,'氓炉鈥犆犅伱ぢ柯︹€澛姑ヂぢ泵绰?氓赂聬氓聫路[quanjun@staff.sina.com.cn],氓沤鸥氓炉鈥犆犅伱锯€溍モ€βッ┾€濃劉猫炉炉',x'',18,0,'127.0.0.1','2010-06-22 11:48:48');
INSERT INTO `optlog` VALUES (14,'氓炉鈥犆犅伱ぢ柯︹€澛姑λ喡惷ヅ犈?氓赂聬氓聫路[quanjun@staff.sina.com.cn]',x'',18,0,'127.0.0.1','2010-06-22 11:49:26');
INSERT INTO `optlog` VALUES (15,'氓炉鈥犆犅伱ぢ柯︹€澛姑λ喡惷ヅ犈?氓赂聬氓聫路[quanjun@staff.sina.com.cn]',x'',18,0,'127.0.0.1','2010-06-22 11:49:33');
INSERT INTO `optlog` VALUES (16,'updatePassword',x'C3A5C2AFE280A0C3A7C2A0C281C3A4C2BFC2AEC3A6E2809DC2B9C3A6CB86C290C3A5C5A0C5B82CC3A5C2B8C290C3A5C28FC2B75B7175616E6A756E4073746166662E73696E612E636F6D2E636E5D',18,0,'127.0.0.1','2010-06-22 11:50:56');
INSERT INTO `optlog` VALUES (17,'氓隆芦氓艩聽猫搂鈥櫭ㄢ€奥\0',x'2CC3A8C2A7E28099C3A8E280B0C2B2C3A5C290C28DC3A7C2A7C2B05B534432534144465D2CC3A8C2A7E28099C3A8E280B0C2B2C3A7C5A0C2B6C3A6E282ACC2815B33335D',18,0,'127.0.0.1','2010-06-22 14:10:25');
INSERT INTO `optlog` VALUES (18,'莽录鈥撁锯€樏р€櫭ㄢ€奥\0',x'2CC3A8C2A7E28099C3A8E280B0C2B2C3A5C290C28DC3A7C2A7C2B05B534432534144465D2CC3A8C2A7E28099C3A8E280B0C2B2C3A7C5A0C2B6C3A6E282ACC2815B33335D',18,0,'127.0.0.1','2010-06-22 14:22:40');
INSERT INTO `optlog` VALUES (19,'莽录鈥撁锯€樏р€櫭ㄢ€奥\0',x'2CC3A8C2A7E28099C3A8E280B0C2B2C3A5C290C28DC3A7C2A7C2B05B534432534144465D2CC3A8C2A7E28099C3A8E280B0C2B2C3A7C5A0C2B6C3A6E282ACC2815B33335D',18,0,'127.0.0.1','2010-06-22 14:23:24');
INSERT INTO `optlog` VALUES (20,'猫搂鈥櫭ㄢ€奥裁ニ嗏€斆÷\0',x'2CC3A8C2A7E28099C3A8E280B0C2B2C3A5C290C28DC3A7C2A7C2B05B53443253414446335D2CC3A8C2A7E28099C3A8E280B0C2B2C3A7C5A0C2B6C3A6E282ACC2815B33335D',18,0,'127.0.0.1','2010-06-22 14:23:28');
INSERT INTO `optlog` VALUES (21,'莽录鈥撁锯€樏р€櫭ㄢ€奥\0',x'2CC3A8C2A7E28099C3A8E280B0C2B2C3A5C290C28DC3A7C2A7C2B05B53443253414446335D2CC3A8C2A7E28099C3A8E280B0C2B2C3A7C5A0C2B6C3A6E282ACC2815B33335D',18,0,'127.0.0.1','2010-06-22 14:23:30');
INSERT INTO `optlog` VALUES (22,'猫搂鈥櫭ㄢ€奥裁ニ嗏€斆÷\0',x'2CC3A8C2A7E28099C3A8E280B0C2B2C3A5C290C28DC3A7C2A7C2B05B5344325341444633345D2CC3A8C2A7E28099C3A8E280B0C2B2C3A7C5A0C2B6C3A6E282ACC2815B33335D',18,0,'127.0.0.1','2010-06-22 14:23:35');
INSERT INTO `optlog` VALUES (23,'莽录鈥撁锯€樏р€櫭ㄢ€奥\0',x'2CC3A8C2A7E28099C3A8E280B0C2B2C3A5C290C28DC3A7C2A7C2B05B5344325341444633345D2CC3A8C2A7E28099C3A8E280B0C2B2C3A7C5A0C2B6C3A6E282ACC2815B33335D',18,0,'127.0.0.1','2010-06-22 14:23:52');
INSERT INTO `optlog` VALUES (24,'猫搂鈥櫭ㄢ€奥裁ニ嗏€斆÷\0',x'2CC3A8C2A7E28099C3A8E280B0C2B2C3A5C290C28DC3A7C2A7C2B05B5344325341444633345D2CC3A8C2A7E28099C3A8E280B0C2B2C3A7C5A0C2B6C3A6E282ACC2815B33335D',18,0,'127.0.0.1','2010-06-22 14:24:09');
INSERT INTO `optlog` VALUES (25,'莽录鈥撁锯€樏р€櫭ㄢ€奥\0',x'2CC3A8C2A7E28099C3A8E280B0C2B2C3A5C290C28DC3A7C2A7C2B05B5344325341444633345D2CC3A8C2A7E28099C3A8E280B0C2B2C3A7C5A0C2B6C3A6E282ACC2815B33335D',18,0,'127.0.0.1','2010-06-22 14:24:11');
INSERT INTO `optlog` VALUES (26,'猫搂鈥櫭ㄢ€奥裁ニ嗏€斆÷\0',x'2CC3A8C2A7E28099C3A8E280B0C2B2C3A5C290C28DC3A7C2A7C2B05B5344325341444633345D2CC3A8C2A7E28099C3A8E280B0C2B2C3A7C5A0C2B6C3A6E282ACC2815B33335D',18,0,'127.0.0.1','2010-06-22 14:34:46');
INSERT INTO `optlog` VALUES (27,'氓藛聽茅鈩⒙っλ喡惷ヅ犈该寂捗ニ喡犆┾劉陇氓藛鈥斆÷ヂ︹€毭ぢ糕€?<br><br>猫搂鈥櫭ㄢ€奥裁ぢ嘎?SD2SADF34<br><br>猫搂鈥櫭ㄢ€奥裁ぢ嘎?SD2ASDFA<br><br>',x'',18,0,'127.0.0.1','2010-06-22 14:46:12');
INSERT INTO `optlog` VALUES (28,'氓藛聽茅鈩⒙っλ喡惷ヅ犈该寂捗ニ喡犆┾劉陇氓藛鈥斆÷ヂ︹€毭ぢ糕€?<br><br>猫搂鈥櫭ㄢ€奥裁ぢ嘎?322sdd<br><br>猫搂鈥櫭ㄢ€奥裁ぢ嘎?sddssd<br><br>',x'',18,0,'127.0.0.1','2010-06-22 14:46:19');
INSERT INTO `optlog` VALUES (29,'氓藛聽茅鈩⒙っλ喡惷ヅ犈该寂捗ニ喡犆┾劉陇氓藛鈥斆÷ヂ︹€毭ぢ糕€?<br><br>猫搂鈥櫭ㄢ€奥裁ぢ嘎?ASDF<br><br>',x'',18,0,'127.0.0.1','2010-06-22 14:50:51');
INSERT INTO `optlog` VALUES (30,'氓藛聽茅鈩⒙っλ喡惷ヅ犈该寂捗ニ喡犆┾劉陇氓藛鈥斆÷ヂ︹€毭ぢ糕€?<br><br>猫搂鈥櫭ㄢ€奥裁ぢ嘎?asdf2<br><br>猫搂鈥櫭ㄢ€奥裁ぢ嘎?32SDSD23<br><br>',x'',18,0,'127.0.0.1','2010-06-22 14:51:08');
INSERT INTO `optlog` VALUES (31,'',x'2CC3A7C2BCE28093C3A5C28FC2B75B41727261795D',18,0,'127.0.0.1','2010-06-22 14:54:31');
INSERT INTO `optlog` VALUES (32,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B34385D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'127.0.0.1','2010-06-22 14:56:36');
INSERT INTO `optlog` VALUES (33,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 20:24:24');
INSERT INTO `optlog` VALUES (34,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 20:25:04');
INSERT INTO `optlog` VALUES (35,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 20:25:17');
INSERT INTO `optlog` VALUES (36,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 20:25:37');
INSERT INTO `optlog` VALUES (37,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 20:26:17');
INSERT INTO `optlog` VALUES (38,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 20:32:18');
INSERT INTO `optlog` VALUES (39,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 20:32:28');
INSERT INTO `optlog` VALUES (40,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 20:32:54');
INSERT INTO `optlog` VALUES (41,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 20:33:31');
INSERT INTO `optlog` VALUES (42,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 20:35:53');
INSERT INTO `optlog` VALUES (43,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 20:46:40');
INSERT INTO `optlog` VALUES (44,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 20:46:56');
INSERT INTO `optlog` VALUES (45,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 20:52:05');
INSERT INTO `optlog` VALUES (46,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 20:52:26');
INSERT INTO `optlog` VALUES (47,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 20:52:36');
INSERT INTO `optlog` VALUES (48,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',18,0,'60.247.30.1','2010-12-12 21:12:16');
INSERT INTO `optlog` VALUES (49,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 21:17:22');
INSERT INTO `optlog` VALUES (50,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 21:17:31');
INSERT INTO `optlog` VALUES (51,'updatePassword',x'C3A5C2AFE280A0C3A7C2A0C281C3A4C2BFC2AEC3A6E2809DC2B9C3A5C2A4C2B1C3A8C2B4C2A52CC3A5C2B8C290C3A5C28FC2B75B7175616E6A756E4073746166662E73696E612E636F6D2E636E5D2CC3A5C5BDC5B8C3A5C2AFE280A0C3A7C2A0C281C3A8C2BEE2809CC3A5E280A6C2A5C3A9E2809DE284A2C3A8C2AFC2AF',18,0,'60.247.30.1','2010-12-12 21:19:06');
INSERT INTO `optlog` VALUES (52,'updatePassword',x'C3A5C2AFE280A0C3A7C2A0C281C3A4C2BFC2AEC3A6E2809DC2B9C3A5C2A4C2B1C3A8C2B4C2A52CC3A5C2B8C290C3A5C28FC2B75B7175616E6A756E4073746166662E73696E612E636F6D2E636E5D2CC3A5C5BDC5B8C3A5C2AFE280A0C3A7C2A0C281C3A8C2BEE2809CC3A5E280A6C2A5C3A9E2809DE284A2C3A8C2AFC2AF',18,0,'60.247.30.1','2010-12-12 21:19:20');
INSERT INTO `optlog` VALUES (53,'updatePassword',x'C3A5C2AFE280A0C3A7C2A0C281C3A4C2BFC2AEC3A6E2809DC2B9C3A5C2A4C2B1C3A8C2B4C2A52CC3A5C2B8C290C3A5C28FC2B75B7175616E6A756E4073746166662E73696E612E636F6D2E636E5D2CC3A5C5BDC5B8C3A5C2AFE280A0C3A7C2A0C281C3A8C2BEE2809CC3A5E280A6C2A5C3A9E2809DE284A2C3A8C2AFC2AF',18,0,'60.247.30.1','2010-12-12 21:19:51');
INSERT INTO `optlog` VALUES (54,'updatePassword',x'C3A5C2AFE280A0C3A7C2A0C281C3A4C2BFC2AEC3A6E2809DC2B9C3A5C2A4C2B1C3A8C2B4C2A52CC3A5C2B8C290C3A5C28FC2B75B7175616E6A756E4073746166662E73696E612E636F6D2E636E5D2CC3A5C5BDC5B8C3A5C2AFE280A0C3A7C2A0C281C3A8C2BEE2809CC3A5E280A6C2A5C3A9E2809DE284A2C3A8C2AFC2AF',18,0,'60.247.30.1','2010-12-12 21:20:41');
INSERT INTO `optlog` VALUES (55,'updatePassword',x'C3A5C2AFE280A0C3A7C2A0C281C3A4C2BFC2AEC3A6E2809DC2B9C3A6CB86C290C3A5C5A0C5B82CC3A5C2B8C290C3A5C28FC2B75B7175616E6A756E4073746166662E73696E612E636F6D2E636E5D',18,0,'60.247.30.1','2010-12-12 21:21:25');
INSERT INTO `optlog` VALUES (56,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 21:24:58');
INSERT INTO `optlog` VALUES (57,'氓隆芦氓艩聽莽鲁禄莽禄鸥莽鈥澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B35315D2CC3A7E2809DC2A8C3A6CB86C2B7C3A9E2809AC2AEC3A7C2AEC2B15B65777765774032323332332E636F6D5D2CC3A7E284A2C2BBC3A5C2BDE280A2C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D2CC3A5C2A7E2809CC3A5C290C28D5B723233723233725D',18,0,'60.247.30.1','2010-12-12 21:26:27');
INSERT INTO `optlog` VALUES (58,'莽录鈥撁锯€樏甭幻ヅ锯€\0',x'2CC3A7C2B1C2BBC3A5C5BEE280B9C3A5C290C28DC3A7C2A7C2B05BC3A6C2ADC2A3C3A5C2B8C2B8C3A8C2A7E28099C3A8E280B0C2B25D2CC3A7C2B1C2BBC3A5C5BEE280B9C3A6C2A0E280A1C3A8C2AFE280A05B315D2CC3A7C2B1C2BBC3A5C5BEE280B9C3A6C2A0E280A1C3A8C2AFE280A0C3A5E282ACC2BC5B325D2CC3A7C2B1C2BBC3A5C5BEE280B9C3A8C2AFC2B4C3A6CB9CC5BDC3A5E280B0C28D3136C3A4C2BDC28DC3A5C2ADE28094C3A7C2ACC2A65BC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B2C3A7C2AEC2A1C3A75D',18,0,'60.247.30.1','2010-12-12 21:27:44');
INSERT INTO `optlog` VALUES (59,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B37395D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 21:34:19');
INSERT INTO `optlog` VALUES (60,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B35315D2CC3A5C2A7E2809CC3A5C290C28D5BC3A5C2ADE284A2C3A5E280A6C2A8C3A5E280A0E280BA5D',18,0,'60.247.30.1','2010-12-12 21:34:35');
INSERT INTO `optlog` VALUES (61,'莽录鈥撁锯€樏陈幻慌该р€澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B35315D2CC3A5C2A7E2809CC3A5C290C28D5B723233723233725D',18,0,'60.247.30.1','2010-12-12 21:35:02');
INSERT INTO `optlog` VALUES (62,'氓隆芦氓艩聽莽鲁禄莽禄鸥莽鈥澛λ喡\0',x'2CC3A7E2809DC2A8C3A6CB86C2B7C3A8C2A7E28099C3A8E280B0C2B25B34385D2CC3A7E2809DC2A8C3A6CB86C2B7C3A9E2809AC2AEC3A7C2AEC2B1C3A5E280B0C28D3136C3A4C2BDC28DC3A5C2ADE28094C3A7C2ACC2A65B7A68616E676D696E736F6E67406B75365D2CC3A7E284A2C2BBC3A5C2BDE280A2C3A5C2AFE280A0C3A7C2A0C2815B2A2A2A2A5D2CC3A5C2A7E2809CC3A5C290C28D5B7A68616E675D',18,0,'60.247.30.3','2010-12-22 01:42:07');
INSERT INTO `optlog` VALUES (63,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',18,0,'60.247.30.3','2010-12-22 01:42:17');
INSERT INTO `optlog` VALUES (64,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',65,0,'60.247.30.3','2010-12-22 01:42:48');
INSERT INTO `optlog` VALUES (65,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',18,0,'60.247.30.3','2010-12-22 01:46:06');
INSERT INTO `optlog` VALUES (66,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',65,0,'60.247.30.1','2011-01-18 14:38:23');
INSERT INTO `optlog` VALUES (67,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',65,0,'60.247.30.1','2011-01-18 14:40:14');
INSERT INTO `optlog` VALUES (68,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',18,0,'60.247.30.1','2011-01-18 14:42:32');
INSERT INTO `optlog` VALUES (69,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',65,0,'60.247.30.1','2011-01-18 16:03:57');
INSERT INTO `optlog` VALUES (70,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',18,0,'60.247.30.1','2011-01-18 17:36:53');
INSERT INTO `optlog` VALUES (71,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',65,0,'60.247.30.3','2011-01-23 20:19:14');
INSERT INTO `optlog` VALUES (72,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',18,0,'60.247.30.3','2011-01-23 20:20:57');
INSERT INTO `optlog` VALUES (73,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',65,0,'60.247.30.1','2011-01-24 10:17:58');
INSERT INTO `optlog` VALUES (74,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',18,0,'60.247.30.1','2011-01-24 10:41:29');
INSERT INTO `optlog` VALUES (75,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',65,0,'60.247.30.1','2011-01-24 10:41:58');
INSERT INTO `optlog` VALUES (76,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',65,0,'60.247.30.1','2011-01-25 14:45:06');
INSERT INTO `optlog` VALUES (77,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',65,0,'60.247.30.1','2011-01-25 15:42:58');
INSERT INTO `optlog` VALUES (78,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',18,0,'60.247.30.1','2011-01-25 17:30:37');
INSERT INTO `optlog` VALUES (79,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',65,0,'60.247.30.1','2011-01-25 17:31:07');
INSERT INTO `optlog` VALUES (80,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',65,0,'60.247.30.1','2011-01-26 09:50:07');
INSERT INTO `optlog` VALUES (81,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',65,0,'60.247.30.1','2011-02-09 10:01:50');
INSERT INTO `optlog` VALUES (82,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',18,0,'60.247.30.1','2011-02-09 10:04:58');
INSERT INTO `optlog` VALUES (83,'',x'C3A6CB86C290C3A5C5A0C5B8C3A9E282ACE282ACC3A5E280A1C2BAC3A7C2B3C2BBC3A7C2BBC5B821',18,0,'211.151.188.19','2011-02-09 10:16:56');
/*!40000 ALTER TABLE `optlog` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table test
#

CREATE TABLE `test` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


#
# Dumping data for table test
#
LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;

INSERT INTO `test` VALUES (1,'????');
INSERT INTO `test` VALUES (2,'??????');
INSERT INTO `test` VALUES (3,'????');
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table treemenu
#

CREATE TABLE `treemenu` (
  `MenuId` int(11) NOT NULL AUTO_INCREMENT,
  `MenuName` varchar(50) NOT NULL DEFAULT 'test',
  `MenuPId` tinyint(4) NOT NULL DEFAULT '0',
  `MenuLink` varchar(255) NOT NULL DEFAULT '../blank.php?flag=1',
  `MenuLevel` smallint(6) NOT NULL DEFAULT '0',
  `MenuEndFlag` enum('0','1') NOT NULL DEFAULT '1',
  `InfluenceItemList` varchar(1024) NOT NULL DEFAULT '??:style=popUp:addFlag=1|??:style=mulSele:delFlag=1|??:style=singleSele:editFlag=1|??:style=null:readFlag=1|??:style=null:listFlag=1|????:style=null:menuFlag=1|???:style=selfDef:customInfluenceList=1',
  `SortValue` int(11) NOT NULL DEFAULT '1',
  `regTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`MenuId`)
) ENGINE=MyISAM AUTO_INCREMENT=143 DEFAULT CHARSET=utf8;


#
# Dumping data for table treemenu
#
LOCK TABLES `treemenu` WRITE;
/*!40000 ALTER TABLE `treemenu` DISABLE KEYS */;

INSERT INTO `treemenu` VALUES (0,'ä¼šå‘˜ç®¡ç†',125,'http://adminapi.ktv.ku6.com/adminui/user.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2010-12-21 17:12:16');
INSERT INTO `treemenu` VALUES (1,'æ³¨å†Œç”¨æˆ·',0,'../usermanager/showtmpl.php?flag=1&opt=listFlag',0,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',96,'2007-09-03 17:09:44');
INSERT INTO `treemenu` VALUES (2,'è§’è‰²ç®¡ç†',0,'../acl/showtmpl.php?flag=1&opt=listFlag',0,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',97,'2007-12-17 17:12:27');
INSERT INTO `treemenu` VALUES (3,'ç±»åž‹ç®¡ç†',0,'../typedata/showtmpl.php?flag=1&opt=listFlag',0,'0','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',80,'2007-12-17 17:12:50');
INSERT INTO `treemenu` VALUES (16,'ä¿®æ”¹å¯†ç ',0,'../updpassword/showtmpl.php?flag=1&opt=editFlag',0,'1','å¡«ï¿½ï¿½ :style=location:addFlag=1|ï¿½ï¿½ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',99,'2007-12-20 18:12:52');
INSERT INTO `treemenu` VALUES (24,'ç”¨æˆ·ä¿¡æ¯',0,'../mainFrame/blank.php?flag=1&opt=listFlag',0,'1','å¡«ï¿½ï¿½ :style=location:addFlag=1|ï¿½ï¿½ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',95,'2007-12-29 11:12:16');
INSERT INTO `treemenu` VALUES (26,'å†…å®¹ç®¡ç†',0,'http://adminapi.ktv.ku6.com/adminui/note.html?',0,'0','å¡«ï¿½ï¿½ :style=location:addFlag=1|ï¿½ï¿½ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',4,'2008-01-02 12:01:13');
INSERT INTO `treemenu` VALUES (28,'è§’è‰²çŠ¶æ€',3,'../keyValue/showtmpl.php?flag=1&opt=listFlag&typeFlag=1',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',0,'2007-12-17 17:12:50');
INSERT INTO `treemenu` VALUES (36,'æ“ä½œæ—¥å¿—',0,'../optlog/showtmpl.php?flag=1&opt=listFlag',0,'1','å¡«ï¿½ï¿½ :style=location:addFlag=1|ï¿½ï¿½ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',82,'2008-01-02 16:01:07');
INSERT INTO `treemenu` VALUES (38,'æ“ä½œè®°å½•',0,'../optlog/showtmpl.php?flag=2&opt=listFlag',0,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',4,'2008-10-27 10:41:13');
INSERT INTO `treemenu` VALUES (40,'ç”¨æˆ·ç¼–è¾‘',0,'../usermanager/showtmpl.php?flag=1&opt=editFlag&editFlag=menu',0,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',96,'2008-01-16 08:01:23');
INSERT INTO `treemenu` VALUES (41,'å®‰å…¨é€€å‡º',0,'../mainFrame/logout.php?flag=1&opt=logout',0,'1','èœå•æ˜¾ç¤º:style=null:menuFlag=1',100,'2008-01-16 20:01:10');
INSERT INTO `treemenu` VALUES (61,'ç³»ç»Ÿæ¦‚è¦',0,'/www.xzrftx.com/src/cgi/backend/menu/../webglobal/showtmpl.php?flag=1&opt=editFlag',-1,'0','å¡«ï¿½ï¿½ :style=location:addFlag=1|ï¿½ï¿½ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',17,'2008-10-27 10:44:26');
INSERT INTO `treemenu` VALUES (98,'è´¦åŠ¡ç®¡ç†',0,'/www.xzrftx.com/src/cgi/backend/menu/../frame/blank.php?flag=1&opt=listFlag',0,'0','å¡«ï¿½ï¿½ :style=location:addFlag=1|ï¿½ï¿½ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2008-08-28 08:08:49');
INSERT INTO `treemenu` VALUES (104,'ç³»ç»Ÿç»Ÿè®¡',61,'http://adminapi.ktv.ku6.com/adminui/count.html?',-2,'1','å¡«ï¿½ï¿½ :style=location:addFlag=1|ï¿½ï¿½ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2008-10-27 10:44:26');
INSERT INTO `treemenu` VALUES (107,'å…¬å¸è´¦æˆ·',98,'http://adminapi.ktv.ku6.com/adminui/company.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2008-08-28 08:08:49');
INSERT INTO `treemenu` VALUES (108,'ç”¨æˆ·ç§¯åˆ†è´¦æˆ·',98,'http://adminapi.ktv.ku6.com/adminui/money_income_user.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2008-08-28 08:08:49');
INSERT INTO `treemenu` VALUES (109,'å¯å…‘æ¢æ”¶å…¥è´¦æˆ·',98,'http://adminapi.ktv.ku6.com/adminui/money_inome_own.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2008-08-28 08:08:49');
INSERT INTO `treemenu` VALUES (111,'ç”¨æˆ·é…·å¸è´¦æˆ·',98,'http://adminapi.ktv.ku6.com/adminui/money_ku_user.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2008-08-28 08:08:49');
INSERT INTO `treemenu` VALUES (112,'åˆ’è´¦ä¸šåŠ¡',98,'http://adminapi.ktv.ku6.com/adminui/moneycall.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2008-08-28 08:08:49');
INSERT INTO `treemenu` VALUES (113,'äººæ°‘å¸å®¡æ ¸',98,'http://adminapi.ktv.ku6.com/adminui/rmb.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2008-08-28 08:08:49');
INSERT INTO `treemenu` VALUES (114,'ä»·æ ¼é…ç½®',0,'/modules/mainFrame/blank.php?flag=1&opt=listFlag',0,'0','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2010-12-21 17:12:26');
INSERT INTO `treemenu` VALUES (115,'ç¤¼ç‰©ä»·æ ¼',114,'http://adminapi.ktv.ku6.com/adminui/price_gift.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2010-12-21 17:12:26');
INSERT INTO `treemenu` VALUES (116,'ä¼šå‘˜ä»·æ ¼',114,'http://adminapi.ktv.ku6.com/adminui/price_vip.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2010-12-21 17:12:26');
INSERT INTO `treemenu` VALUES (117,'æˆ¿é—´ä»·æ ¼',114,'http://adminapi.ktv.ku6.com/adminui/price_rooms.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2010-12-21 17:12:26');
INSERT INTO `treemenu` VALUES (118,'å†…å®¹åˆ—è¡¨',26,'http://adminapi.ktv.ku6.com/adminui/note.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2008-01-02 12:01:13');
INSERT INTO `treemenu` VALUES (119,'æ·»åŠ å†…å®¹',26,'http://adminapi.ktv.ku6.com/adminui/note_info_add.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2008-01-02 12:01:13');
INSERT INTO `treemenu` VALUES (120,'æ·»åŠ å¹¿å‘Š',26,'http://adminapi.ktv.ku6.com/adminui/note_adv_add.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2008-01-02 12:01:13');
INSERT INTO `treemenu` VALUES (121,'æˆ¿é—´ç®¡ç†',0,'/modules/mainFrame/blank.php?flag=1&opt=listFlag',0,'0','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2010-12-21 17:12:01');
INSERT INTO `treemenu` VALUES (122,'æˆ¿é—´ç®¡ç†',121,'http://adminapi.ktv.ku6.com/adminui/rooms.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2010-12-21 17:12:01');
INSERT INTO `treemenu` VALUES (123,'ç³»ç»Ÿé…ç½®',0,'/modules/mainFrame/blank.php?flag=1&opt=listFlag',0,'0','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2010-12-21 17:12:34');
INSERT INTO `treemenu` VALUES (124,'ç³»ç»Ÿé…ç½®',123,'http://adminapi.ktv.ku6.com/adminui/conf.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2010-12-21 17:12:34');
INSERT INTO `treemenu` VALUES (125,'ä¼šå‘˜ç®¡ç†',0,'/modules/mainFrame/blank.php?flag=1&opt=listFlag',0,'0','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2010-12-21 17:12:16');
INSERT INTO `treemenu` VALUES (126,'è‰ºäººå®¡æ ¸',125,'http://adminapi.ktv.ku6.com/adminui/actor.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2010-12-21 17:12:16');
INSERT INTO `treemenu` VALUES (127,'å®¶æ—ç®¡ç†',121,'http://adminapi.ktv.ku6.com/adminui/family.html?',1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2011-01-24 10:22:44');
INSERT INTO `treemenu` VALUES (138,'å®¶æ—å®¡æ ¸',121,'http://adminapi.ktv.ku6.com/adminui/family_verify.html?',-1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2010-12-21 17:12:01');
INSERT INTO `treemenu` VALUES (141,'å‘é€å¹¿æ’­',26,'http://adminapi.ktv.ku6.com/adminui/send.html?',-1,'1','å¡«åŠ :style=location:addFlag=1|åˆ é™¤:style=delSele:delFlag=1|ä¿®æ”¹:style=singleSele:editFlag=1|åªè¯»:style=null:readFlag=1|åˆ—è¡¨:style=null:listFlag=1|èœå•æ˜¾ç¤º:style=null:menuFlag=1|æƒé™åˆ†é…:style=singleSele:editPower=1|è‡ªå®šä¹‰:style=selfDef:customInfluenceList=1',1,'2008-01-02 12:01:13');
/*!40000 ALTER TABLE `treemenu` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table user
#

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `passwd` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `userName` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `sex` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `cityID` int(11) NOT NULL DEFAULT '0',
  `hometown` char(255) COLLATE utf8_bin DEFAULT NULL,
  `birthday` date DEFAULT '1978-02-13',
  `address` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `qq` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `msn` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `homepage` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `company` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `job` char(64) COLLATE utf8_bin DEFAULT '0',
  `note` text COLLATE utf8_bin,
  `influenceID` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `lastLoginTime` datetime DEFAULT '0000-00-00 00:00:00',
  `regTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


#
# Dumping data for table user
#
LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` VALUES (18,'quanjun@staff.sina.com.cn','asdfasdf','氓颅鈩⒚モ€βモ€犫€?cn','1',25,'asdfasd','1978-02-13','asdfasdfasf','414301929','quanjun@staff.sina.com.cn','13520410732','asdfasdf','asdfasdf','asdfasdf',x'',79,0,'2011-02-10 15:25:38','2009-01-20 11:09:55');
INSERT INTO `user` VALUES (29,'administrator','asdfasdf1','猫露鈥γ郝∶愨€犆モ€標\0','0',0,'','1978-02-13','','','','','','','0',x'',51,0,'2008-12-03 18:41:37','2008-12-03 18:41:22');
INSERT INTO `user` VALUES (30,'03510001','asdfasdf','testagent','0',47,'','1978-02-13','asdfasf','23232323','asdf@asdf.com','13232233233','232323','23232323','6',x'6173646661736466',74,0,'2008-10-23 16:27:21','2008-09-30 22:16:46');
INSERT INTO `user` VALUES (61,'songyuexing2@staff.sina.com.cn','asdfasdf','氓颅鈩⒚モ€βモ€犫€篴.com.cn','0',47,'','1978-03-13','氓艗鈥斆ぢ郝ヂ糕€毭β德访β封偓氓艗潞氓艗鈥斆モ€衡€好铰ヂ棵仿?8氓聫路','414301929','t8225511@hotmail.com','13910212452','http://www.sina.com.cn','asdf','33',x'C3A5C592E28094C3A4C2BAC2ACC3A5C2B8E2809AC3A6C2B5C2B7C3A6C2B7E282ACC3A5C592C2BAC3A5C592E28094C3A5E280BAE280BA',51,0,'0000-00-00 00:00:00','2008-11-20 17:54:18');
INSERT INTO `user` VALUES (63,'asd@asd.com','asdfasdf','asdfasdf','0',51,'','1978-02-13',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,79,0,'0000-00-00 00:00:00','2008-12-04 15:45:47');
INSERT INTO `user` VALUES (64,'ewwew@22323.com','123456711','r23r23r','0',0,'','1978-02-13',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,51,0,'0000-00-00 00:00:00','2010-12-12 21:26:27');
INSERT INTO `user` VALUES (65,'myth','123456','zhang','0',0,NULL,'1978-02-13',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,48,0,'2011-02-15 17:02:27','2010-12-22 01:42:07');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table userpower
#

CREATE TABLE `userpower` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `treemenuID` int(11) NOT NULL DEFAULT '0',
  `influenceID` int(11) NOT NULL DEFAULT '0',
  `readFlag` enum('0','1') NOT NULL DEFAULT '0',
  `editFlag` enum('0','1') NOT NULL DEFAULT '0',
  `delFlag` enum('0','1') NOT NULL DEFAULT '0',
  `addFlag` enum('0','1') NOT NULL DEFAULT '0',
  `listFlag` enum('0','1') NOT NULL DEFAULT '0',
  `menuFlag` enum('0','1') NOT NULL DEFAULT '0',
  `editPower` enum('0','1') NOT NULL DEFAULT '0',
  `customInfluenceList` varchar(1024) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '''''',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9530 DEFAULT CHARSET=utf8;


#
# Dumping data for table userpower
#
LOCK TABLES `userpower` WRITE;
/*!40000 ALTER TABLE `userpower` DISABLE KEYS */;

INSERT INTO `userpower` VALUES (9211,35,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9212,98,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9213,26,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9214,38,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9215,61,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9216,104,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9217,3,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9218,27,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9219,28,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9220,31,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9221,45,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9222,46,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9223,36,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9224,57,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9225,59,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9226,24,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9227,1,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9228,84,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9229,93,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9230,40,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9231,99,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9232,100,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9233,101,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9234,102,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9235,103,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9236,2,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9237,16,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9238,41,78,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9267,35,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9268,98,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9269,26,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9270,38,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9271,61,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9272,104,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9273,3,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9274,27,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9275,28,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9276,31,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9277,45,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9278,46,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9279,36,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9280,57,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9281,59,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9282,24,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9283,1,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9284,84,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9285,93,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9286,40,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9287,99,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9288,100,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9289,101,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9290,102,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9291,103,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9292,2,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9293,16,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9294,41,73,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9295,35,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9296,98,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9297,26,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9298,38,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9299,61,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9300,104,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9301,3,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9302,27,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9303,28,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9304,31,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9305,45,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9306,46,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9307,36,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9308,57,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9309,59,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9310,24,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9311,1,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9312,84,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9313,93,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9314,40,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9315,99,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9316,100,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9317,101,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9318,102,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9319,103,51,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9320,2,51,'1','1','1','1','1','1','0',x'C3A7C2BCE28093C3A8C2BEE28098C3A6C29DC692C3A9E284A2C2903A7374796C653D6E756C6C3A65646974506F7765723D317CC3A6CB86E28098C3A7C5A1E2809EC3A5E280A6C2ACC3A6E28093E280A1C3A5C592E280A63A7374796C653D6C6F636174696F6E3A6D79446F63756D656E743D31');
INSERT INTO `userpower` VALUES (9321,16,51,'0','1','0','0','0','1','0',x'');
INSERT INTO `userpower` VALUES (9322,41,51,'0','0','0','0','0','1','0',x'');
INSERT INTO `userpower` VALUES (9323,35,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9324,98,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9325,26,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9326,38,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9327,61,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9328,104,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9329,3,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9330,27,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9331,28,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9332,31,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9333,45,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9334,46,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9335,36,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9336,57,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9337,59,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9338,24,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9339,1,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9340,84,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9341,93,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9342,40,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9343,99,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9344,100,82,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9345,101,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9346,102,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9347,103,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9348,2,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9349,16,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9350,41,82,'0','0','0','0','0','0','0',x'');
INSERT INTO `userpower` VALUES (9494,98,48,'0','0','0','0','0','1','0',x'');
INSERT INTO `userpower` VALUES (9495,108,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9496,107,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9497,109,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9498,111,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9499,112,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9500,113,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9501,114,48,'0','0','0','0','0','1','0',x'');
INSERT INTO `userpower` VALUES (9502,115,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9503,116,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9504,117,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9505,121,48,'0','0','0','0','0','1','0',x'');
INSERT INTO `userpower` VALUES (9506,122,48,'1','1','1','1','1','1','1',x'');
INSERT INTO `userpower` VALUES (9507,127,48,'1','1','1','1','1','1','1',x'');
INSERT INTO `userpower` VALUES (9508,138,48,'1','1','1','1','0','1','1',x'');
INSERT INTO `userpower` VALUES (9509,123,48,'0','0','0','0','0','1','0',x'');
INSERT INTO `userpower` VALUES (9510,124,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9511,125,48,'0','0','0','0','0','1','0',x'');
INSERT INTO `userpower` VALUES (9512,126,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9513,0,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9514,26,48,'0','0','0','0','0','1','0',x'');
INSERT INTO `userpower` VALUES (9515,118,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9516,119,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9517,120,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9518,38,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9519,61,48,'0','0','0','0','0','1','0',x'');
INSERT INTO `userpower` VALUES (9520,104,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9521,3,48,'0','0','0','0','0','1','0',x'');
INSERT INTO `userpower` VALUES (9522,28,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9523,36,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9524,24,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9525,1,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9526,40,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9527,2,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9528,16,48,'1','1','1','1','1','1','0',x'');
INSERT INTO `userpower` VALUES (9529,41,48,'0','0','0','0','0','1','0',x'');
/*!40000 ALTER TABLE `userpower` ENABLE KEYS */;
UNLOCK TABLES;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
