USE `atnew`;

DROP TABLE IF EXISTS `atsupportwhitelist`;

CREATE TABLE `atsupportwhitelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oemName` varchar(50) DEFAULT NULL,
  `atVersion` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

insert  into `atsupportwhitelist`(`id`,`oemName`,`atVersion`) values (7,'Hewlett-Packard','3.0'),(8,'Compaq','3.0'),(9,'Lenovo','3.0'),(10,'Acer','3.0');




alter table atregister add 'bindCard' int(1) DEFAULT '0';
alter table atregister add 'sex' varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL;
alter table atregister add 'authorizeCode' varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL;
alter table atregister add 'authorizeTime' bigint(20) DEFAULT NULL;
alter table attagbind add 'oemId' int(11) NOT NULL DEFAULT '8';
alter table atuserdevice drop 'authorizeCode';
alter table atuserdevice drop 'authorizeTime';




USE `sales`;

DROP TABLE IF EXISTS `salesPhysicalCodeType`;

CREATE TABLE `salesPhysicalCodeType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `physicalType` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `typePic` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

insert  into `salesPhysicalCodeType`(`id`,`physicalType`,`typePic`,`createTime`) values (1,'Ô¿³×±êÇ©','/userfiles/physicalType/201203/23/13324939433971.jpg','2012-03-22 04:23:05'),(6,'ÊÖ»ú','/userfiles/physicalType/201204/03/13333839739334.jpg','2012-04-01 09:09:06');




alter table salesPhysicalActivitionCode add 'useTime' bigint(20) DEFAULT NULL;
alter table salesPhysicalCode add 'physicalCodeType' int(11) NOT NULL DEFAULT '0';



