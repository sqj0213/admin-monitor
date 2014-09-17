-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 10 月 30 日 15:15
-- 服务器版本: 5.5.28
-- PHP 版本: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

SET AUTOCOMMIT=0;
START TRANSACTION;

--
-- 数据库: `webtask`
--

-- --------------------------------------------------------

--
-- 表的结构 `cmd`
--

CREATE TABLE IF NOT EXISTS `cmd` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cmdSN` bigint(20) NOT NULL DEFAULT '0',
  `cmdKeyID` int(11) NOT NULL,
  `cmdTargetID` int(11) NOT NULL DEFAULT '0',
  `cmdType` enum('0','1') NOT NULL DEFAULT '0',
  `cmdPara` char(50) NOT NULL DEFAULT '''''',
  `cmdStr` char(50) NOT NULL DEFAULT '''''',
  `sendTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `completeTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sendStatus` enum('-1','0','1') NOT NULL DEFAULT '0',
  `runStatus` enum('-2','-1','0','1','2') NOT NULL DEFAULT '0',
  `regTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `completeTime` (`completeTime`),
  KEY `cmdKey` (`cmdKeyID`),
  KEY `cmdSN` (`cmdSN`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `cmd`
--

INSERT INTO `cmd` (`id`, `cmdSN`, `cmdKeyID`, `cmdTargetID`, `cmdType`, `cmdPara`, `cmdStr`, `sendTime`, `completeTime`, `sendStatus`, `runStatus`, `regTime`) VALUES
(1, 1350569695, 41, 42, '0', '/tmp/aa.txt', '''''', '2012-10-19 02:06:03', '0000-00-00 00:00:00', '1', '0', '2012-10-18 07:15:01'),
(2, 1351249022, 41, 42, '0', '/tmp/aa.txt\r\n/tmp/bb.txt\r\n/tmp/cc.txt', '''''', '2012-10-30 03:27:22', '0000-00-00 00:00:00', '1', '0', '2012-10-26 03:57:07');

-- --------------------------------------------------------

--
-- 表的结构 `CMDDetail`
--

CREATE TABLE IF NOT EXISTS `CMDDetail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cmdSN` bigint(20) NOT NULL,
  `cmdStr` char(255) NOT NULL,
  `ip` char(15) NOT NULL,
  `sendStatus` enum('0','1') NOT NULL,
  `sendTime` datetime NOT NULL,
  `runTime` datetime NOT NULL,
  `retCode` enum('-1','0','1') NOT NULL DEFAULT '0',
  `retMsg` char(100) NOT NULL,
  `retData` varchar(1024) NOT NULL DEFAULT '''''',
  `regTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Triggers `CMDDetail`
--
DROP TRIGGER IF EXISTS `webtask`.`taskReport`;
DELIMITER //
CREATE TRIGGER `webtask`.`taskReport` AFTER UPDATE ON `webtask`.`CMDDetail`
 FOR EACH ROW BEGIN
if not exists(select retCode from CMDDetail where cmdSN = NEW.cmdSN and ip=NEW.ip and retCode<>0 and retCode<>-1) then
	update cmd set runStatus='2' where cmdSN=NEW.cmdSN;
END IF;
if exists(select retCode from CMDDetail where cmdSN = NEW.cmdSN and ip=NEW.ip and ( retCode=0 or retCode=-1) ) then
	update cmd set runStatus='1' where cmdSN=NEW.cmdSN;
END IF;

end
//
DELIMITER ;

--
-- 导出表中的数据 `CMDDetail`
--

INSERT INTO `CMDDetail` (`id`, `cmdSN`, `cmdStr`, `ip`, `sendStatus`, `sendTime`, `runTime`, `retCode`, `retMsg`, `retData`, `regTime`) VALUES
(1, 1350569695, '', '172.16.1.155', '0', '2012-10-19 00:44:54', '0000-00-00 00:00:00', '', '', '''''', '2012-10-19 00:44:54'),
(2, 1350569695, '', '172.16.1.155', '0', '2012-10-19 00:47:55', '0000-00-00 00:00:00', '', '', '''''', '2012-10-19 00:47:55'),
(3, 1350569695, '', '172.16.1.155', '0', '2012-10-19 00:48:24', '0000-00-00 00:00:00', '', '', '''''', '2012-10-19 00:48:24'),
(4, 1350569695, '', '172.16.1.155', '0', '2012-10-19 00:51:57', '0000-00-00 00:00:00', '', '', '''''', '2012-10-19 00:51:57'),
(5, 1350569695, '', '172.16.1.155', '0', '2012-10-19 00:55:41', '0000-00-00 00:00:00', '', '', '''''', '2012-10-19 00:55:41'),
(6, 1350569695, '', '172.16.1.155', '0', '2012-10-19 00:56:10', '0000-00-00 00:00:00', '', '', '''''', '2012-10-19 00:56:10'),
(7, 1350569695, '{"cmdSN":"1350569695","cmdStr":"/bin/rm -f Array"}', '172.16.1.155', '0', '2012-10-19 01:41:41', '0000-00-00 00:00:00', '', '', '''''', '2012-10-19 01:41:41'),
(8, 1350569695, '{"cmdSN":"1350569695","cmdStr":"/bin/rm -f Array"}', '172.16.1.155', '0', '2012-10-19 01:41:44', '0000-00-00 00:00:00', '', '', '''''', '2012-10-19 01:41:44'),
(9, 1350569695, '1350569695 /bin/rm -f ["/tmp/aa.txt"]', '172.16.1.155', '0', '2012-10-19 01:44:04', '0000-00-00 00:00:00', '', '', '''''', '2012-10-19 01:44:04'),
(10, 1350569695, '1350569695 /bin/rm -f ["/tmp/aa.txt"]', '172.16.1.155', '0', '2012-10-19 02:04:38', '0000-00-00 00:00:00', '', '', '''''', '2012-10-19 02:04:38'),
(11, 1350569695, '1350569695 /bin/rm -f ["/tmp/aa.txt"]', '172.16.1.155', '1', '2012-10-19 02:06:03', '0000-00-00 00:00:00', '', '', '''''', '2012-10-19 02:06:03'),
(12, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r\n/tmp/bb.txt\r\n/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-26 03:58:54', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-26 03:58:54'),
(13, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":null}', '172.16.1.155', '1', '2012-10-26 03:59:55', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-26 03:59:55'),
(14, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":null}', '172.16.1.155', '1', '2012-10-26 04:00:38', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-26 04:00:38'),
(15, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":null}', '172.16.1.155', '1', '2012-10-26 04:04:01', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-26 04:04:01'),
(16, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-26 04:10:07', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-26 04:10:07'),
(17, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 00:30:13', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 00:30:13'),
(18, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 00:30:30', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 00:30:30'),
(19, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 00:30:38', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 00:30:38'),
(20, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 00:35:12', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 00:35:12'),
(21, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 00:55:30', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 00:55:30'),
(22, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 02:08:13', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 02:08:13'),
(23, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 02:24:56', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 02:24:56'),
(24, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 02:26:54', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 02:26:54'),
(25, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 02:26:57', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 02:26:57'),
(26, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 02:26:59', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 02:26:59'),
(27, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:29:41', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:29:41'),
(28, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:30:10', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:30:10'),
(29, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:33:16', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:33:16'),
(30, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:33:58', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:33:58'),
(31, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:36:49', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:36:49'),
(32, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:39:05', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:39:05'),
(33, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:47:36', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:47:36'),
(34, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:48:02', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:48:02'),
(35, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:48:53', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:48:53'),
(36, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:49:46', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:49:46'),
(37, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:54:26', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:54:26'),
(38, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:55:31', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:55:31'),
(39, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:56:05', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:56:05'),
(40, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:56:36', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:56:36'),
(41, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:58:18', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:58:18'),
(42, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 19:59:00', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 19:59:00'),
(43, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 20:05:32', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 20:05:32'),
(44, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 20:06:47', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 20:06:47'),
(45, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 20:07:37', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 20:07:37'),
(46, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 20:08:05', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 20:08:05'),
(47, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 20:57:48', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 20:57:48'),
(48, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 21:16:06', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 21:16:06'),
(49, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 22:44:59', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 22:44:59'),
(50, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-29 22:45:30', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-29 22:45:30'),
(51, 1351249022, '{"cmdSN":"1351249022","cmdStr":"/bin/rm -f","para":["/tmp/aa.txt\r","/tmp/bb.txt\r","/tmp/cc.txt"]}', '172.16.1.155', '1', '2012-10-30 03:27:24', '0000-00-00 00:00:00', '0', 'success', '', '2012-10-30 03:27:24');

-- --------------------------------------------------------

--
-- 表的结构 `serverList`
--

CREATE TABLE IF NOT EXISTS `serverList` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ip` char(15) NOT NULL,
  `typeID` int(10) unsigned NOT NULL DEFAULT '1',
  `regTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `serverList`
--

INSERT INTO `serverList` (`id`, `ip`, `typeID`, `regTime`) VALUES
(1, '172.16.1.155', 42, '2012-10-18 06:44:47');

-- --------------------------------------------------------

--
-- 表的结构 `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` char(10) NOT NULL,
  `passwd` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `test`
--


COMMIT;
