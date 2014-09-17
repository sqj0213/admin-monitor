-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost:3306
-- 生成日期: 2007 年 04 月 22 日 16:27
-- 服务器版本: 4.1.14
-- PHP 版本: 5.0.3
-- 
-- 数据库: `personadmin`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `systemuser`
-- 

CREATE TABLE `systemuser` (
  `id` bigint(20) NOT NULL auto_increment,
  `loginame` varchar(20) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `password` varchar(20) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `name` varchar(20) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `number` smallint(4) NOT NULL default '0',
  `sex` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `tel` varchar(20) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `email` varchar(50) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `department` varchar(50) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `influenceId` bigint(20) NOT NULL default '0',
  `lastLoginTime` datetime NOT NULL default '0000-00-00 00:00:00',
  `regTime` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- 导出表中的数据 `systemuser`
-- 

INSERT INTO `systemuser` VALUES (4, 'quanjun', 'asdfasdf', '孙全军', 0, '', '', '', '', 0, '0000-00-00 00:00:00', '2007-01-17 16:45:34');
INSERT INTO `systemuser` VALUES (5, 'quanjun1', 'asdfasdf', '孙全军', 0, '', '', '', '', 0, '0000-00-00 00:00:00', '2007-01-17 16:57:42');
INSERT INTO `systemuser` VALUES (6, 'quanjun1', 'asdfasdf', '孙全军', 0, '', '', '', '', 0, '0000-00-00 00:00:00', '2007-01-17 16:57:47');
