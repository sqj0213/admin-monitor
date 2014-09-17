-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 01, 2012 at 11:06 AM
-- Server version: 5.5.28
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `webadmin`
--

-- --------------------------------------------------------

--
-- Table structure for table `influence`
--

CREATE TABLE IF NOT EXISTS `influence` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '',
  `keyValueID` tinyint(4) NOT NULL DEFAULT '0',
  `regTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nodeLevel` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `influence`
--

INSERT INTO `influence` (`id`, `name`, `keyValueID`, `regTime`, `nodeLevel`) VALUES
(48, '超级管理员', 33, '2008-02-15 01:27:09', 0),
(51, '客服人员', 33, '2008-11-20 00:36:13', 0),
(56, 'oem管理员', 33, '2011-10-07 07:44:35', 0),
(57, '审计人员', 33, '2011-12-28 22:56:13', 0);

-- --------------------------------------------------------

--
-- Table structure for table `keyValue`
--

CREATE TABLE IF NOT EXISTS `keyValue` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `keyName` varchar(20) NOT NULL DEFAULT '',
  `typeFlag` tinyint(4) NOT NULL DEFAULT '0',
  `value` char(50) NOT NULL DEFAULT '0',
  `delFlag` enum('0','1') NOT NULL DEFAULT '0',
  `note` varchar(20) NOT NULL DEFAULT '',
  `pid` bigint(20) NOT NULL DEFAULT '0',
  `regtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `keyValue`
--

INSERT INTO `keyValue` (`id`, `keyName`, `typeFlag`, `value`, `delFlag`, `note`, `pid`, `regtime`) VALUES
(6, '停用用户', 1, '1', '0', '用户状态', 0, '2007-12-26 20:54:35'),
(33, '正常用户', 1, '2', '0', '用户状态', 0, '2008-01-02 19:01:26'),
(34, '2332', 0, '3232', '0', '323232', 0, '2011-12-29 23:52:12'),
(37, '3232', 0, '3232', '0', '233232', 0, '2011-12-30 00:19:12'),
(41, 'clear-web-cache', 3, '/bin/rm -f', '0', '清除web前端cache', 0, '2012-10-18 05:57:19'),
(42, 'web前端', 4, '1', '0', 'web前端', 0, '2012-10-18 06:08:30');

-- --------------------------------------------------------

--
-- Table structure for table `keyValue1`
--

CREATE TABLE IF NOT EXISTS `keyValue1` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `keyName` varchar(20) NOT NULL DEFAULT '',
  `typeFlag` tinyint(4) NOT NULL DEFAULT '0',
  `value` char(50) NOT NULL DEFAULT '0',
  `delFlag` tinyint(4) NOT NULL DEFAULT '0',
  `note` char(20) NOT NULL,
  `pid` bigint(20) NOT NULL DEFAULT '0',
  `regtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `keyValue1`
--

INSERT INTO `keyValue1` (`id`, `keyName`, `typeFlag`, `value`, `delFlag`, `note`, `pid`, `regtime`) VALUES
(6, 'Ã§Â¦ÂÃ§Â”Â¨Ã¨Â§Â’Ã¨', 1, '1', 0, 'Ã¨Â§Â’Ã¨Â‰Â²Ã§Â®Â¡Ã§', 0, '2007-12-26 20:54:35'),
(20, 'Ã¥Â±Â±Ã¨Â¥Â¿Ã§ÂœÂ', 4, '1', 0, 'Ã§ÂœÂÃ¥Â¸Â‚Ã¥ÂÂÃ§', 0, '2008-01-01 21:07:22'),
(21, 'Ã¥Â†Â…Ã¨Â’Â™Ã¥ÂÂ¤', 4, '2', 0, 'Ã§ÂœÂÃ¥Â¸Â‚Ã¥ÂÂÃ§', 0, '2008-01-01 21:09:24'),
(22, 'Ã¥ÂŒÂ—Ã¤ÂºÂ¬Ã¥Â¸Â‚', 4, '3', 0, 'Ã§ÂœÂÃ¥Â¸Â‚Ã¥ÂÂÃ§', 0, '2008-01-01 21:09:50'),
(23, 'Ã¦Â²Â³Ã¥ÂŒÂ—Ã§ÂœÂ', 4, '4', 0, 'Ã§ÂœÂÃ¥Â¸Â‚Ã¥ÂÂÃ§', 0, '2008-01-01 21:10:02'),
(24, 'Ã©Â™Â•Ã¨Â¥Â¿Ã§ÂœÂ', 4, '5', 0, 'Ã§ÂœÂÃ¥Â¸Â‚Ã¥ÂÂÃ§', 0, '2008-01-01 21:10:20'),
(25, 'Ã¨Â¾Â½Ã¥Â®ÂÃ§ÂœÂ', 4, '6', 0, 'Ã§ÂœÂÃ¥Â¸Â‚Ã¥ÂÂÃ§', 0, '2008-01-01 21:10:34'),
(26, 'Ã©Â»Â‘Ã©Â¾Â™Ã¦Â±ÂŸ', 4, '7', 0, 'Ã§ÂœÂÃ¥Â¸Â‚Ã¥ÂÂÃ§', 0, '2008-01-01 21:10:54'),
(27, 'Ã¦Â–Â°Ã§Â–Â†', 4, '8', 0, 'Ã§ÂœÂÃ¥Â¸Â‚Ã¥ÂÂÃ§', 0, '2008-01-01 21:11:14'),
(28, 'Ã¥Â›Â›Ã¥Â·Â', 4, '9', 0, 'Ã§ÂœÂÃ¥Â¸Â‚Ã¥ÂÂÃ§', 0, '2008-01-01 21:11:48'),
(29, 'Ã¤ÂºÂ‘Ã¥ÂÂ—', 4, '10', 0, 'Ã§ÂœÂÃ¥Â¸Â‚Ã¥ÂÂÃ§', 0, '2008-01-01 21:12:11'),
(30, 'Ã¦Â²Â³Ã¥ÂÂ—Ã§ÂœÂ', 4, '11', 0, 'Ã§ÂœÂÃ¥Â¸Â‚Ã¥ÂÂÃ§', 0, '2008-01-01 21:12:59'),
(33, 'Ã¦Â­Â£Ã¥Â¸Â¸Ã¨Â§Â’Ã¨', 1, '2', 0, 'Ã§Â”Â¨Ã¦ÂˆÂ·Ã¨Â§Â’Ã¨', 0, '2008-01-02 19:01:26'),
(43, 'asdasf', 2, '10', 0, '2spersonadminssd', 29, '2008-02-18 01:56:28'),
(47, 'Ã¤Â¸ÂœÃ¥ÂŸÂŽÃ¥ÂŒÂº', 5, '2232', 0, '22323', 20, '2008-02-18 01:59:47'),
(48, 'asdsfssaf', 22, '22', 0, '33232', 0, '2008-02-28 16:03:13');

-- --------------------------------------------------------

--
-- Table structure for table `optlog`
--

CREATE TABLE IF NOT EXISTS `optlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `userID` bigint(20) NOT NULL DEFAULT '0',
  `clubID` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `regTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1413 ;

--
-- Dumping data for table `optlog`
--

INSERT INTO `optlog` (`id`, `title`, `text`, `userID`, `clubID`, `ip`, `regTime`) VALUES
(1331, '密码修改成功,帐号[quanjun@staff.sina.com.cn]', '', 0, 0, '', '2012-10-18 03:39:50'),
(1332, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-18 04:40:02'),
(1333, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 04:40:53'),
(1334, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 04:41:49'),
(1335, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-18 05:50:40'),
(1336, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 05:50:54'),
(1337, '���ϵͳ�û�', 0xe994aee5908d5b636c6561722d7765622d63616368655d2ce994aee5908de58886e7b1bb5b335d2ce994aee580bc5b2f62696e2f726d202d66205d2ce994aee8afb4e6988e5be6b885e999a4776562e5898de7abaf63616368655d, 18, 0, '172.16.1.69', '2012-10-18 05:57:19'),
(1338, '�༭ϵͳ�û�', 0xe7b1bbe59e8be5908de7a7b05b636c6561722d7765622d63616368655d2ce7b1bbe59e8be6a087e8af865b335d2ce7b1bbe59e8be6a087e8af86e580bc5b2f62696e2f726d202d66205d2ce7b1bbe59e8be8afb4e6988e5be6b885e999a4776562e5898de7abaf63616368655d, 18, 0, '172.16.1.69', '2012-10-18 05:58:30'),
(1339, '�༭ϵͳ�û�', 0xe7b1bbe59e8be5908de7a7b05b636c6561722d7765622d63616368655d2ce7b1bbe59e8be6a087e8af865b335d2ce7b1bbe59e8be6a087e8af86e580bc5b2f62696e2f726d202d665d2ce7b1bbe59e8be8afb4e6988e5be6b885e999a4776562e5898de7abaf63616368655d, 18, 0, '172.16.1.69', '2012-10-18 05:58:36'),
(1340, '�༭ϵͳ�û�', 0xe7b1bbe59e8be5908de7a7b05b636c6561722d7765622d63616368655d2ce7b1bbe59e8be6a087e8af865b335d2ce7b1bbe59e8be6a087e8af86e580bc5b2f62696e2f726d202d665d2ce7b1bbe59e8be8afb4e6988e5be6b885e999a4776562e5898de7abaf63616368655d, 18, 0, '172.16.1.69', '2012-10-18 05:58:40'),
(1341, '�༭ϵͳ�û�', 0xe7b1bbe59e8be5908de7a7b05b636c6561722d7765622d63616368655d2ce7b1bbe59e8be6a087e8af865b335d2ce7b1bbe59e8be6a087e8af86e580bc5b2f62696e2f726d202d665d2ce7b1bbe59e8be8afb4e6988e5be6b885e999a4776562e5898de7abaf63616368655d, 18, 0, '172.16.1.69', '2012-10-18 05:58:42'),
(1342, '�༭ϵͳ�û�', 0xe7b1bbe59e8be5908de7a7b05b636c6561722d7765622d63616368655d2ce7b1bbe59e8be6a087e8af865b335d2ce7b1bbe59e8be6a087e8af86e580bc5b2f62696e2f726d202d665d2ce7b1bbe59e8be8afb4e6988e5be6b885e999a4776562e5898de7abaf63616368655d, 18, 0, '172.16.1.69', '2012-10-18 05:58:42'),
(1343, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-18 06:02:47'),
(1344, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 06:02:59'),
(1345, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-18 06:04:01'),
(1346, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 06:04:11'),
(1347, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-18 06:04:44'),
(1348, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 06:05:03'),
(1349, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-18 06:05:31'),
(1350, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 06:05:42'),
(1351, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 06:07:35'),
(1352, '���ϵͳ�û�', 0xe994aee5908d5b776562e5898de7abaf5d2ce994aee5908de58886e7b1bb5b345d2ce994aee580bc5b315d2ce994aee8afb4e6988e5b776562e5898de7abaf5d, 18, 0, '172.16.1.69', '2012-10-18 06:08:30'),
(1353, '添加服务器成功', 0x6970e59cb0e59d805b3137322e31362e312e3235345d2ce68980e5b19ee99b86e7bea45b34315d, 18, 0, '172.16.1.69', '2012-10-18 06:44:47'),
(1354, '修改服务器成功', 0x6970e59cb0e59d805b3137322e31362e312e3235345d2ce68980e5b19ee99b86e7bea45b34315d, 18, 0, '172.16.1.69', '2012-10-18 06:55:58'),
(1355, '修改服务器成功', 0x6970e59cb0e59d805b3137322e31362e312e3235355d2ce68980e5b19ee99b86e7bea45b34315d, 18, 0, '172.16.1.69', '2012-10-18 06:56:05'),
(1356, '添加任务成功', 0xe68c87e4bba4736e5b313335303536393639355d2ce68c87e4bba4e99b865b34315d2ce68c87e4bba4e99b86e7bea45b34325d2ce68c87e4bba4e58f82e695b05b2f746d702f61612e7478745d, 18, 0, '172.16.1.69', '2012-10-18 07:15:01'),
(1357, '', 0xe7bc96e58fb75b34305d, 18, 0, '172.16.1.69', '2012-10-18 07:28:40'),
(1358, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-18 07:28:46'),
(1359, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 07:29:00'),
(1360, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-18 07:40:27'),
(1361, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 07:40:35'),
(1362, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-18 07:42:52'),
(1363, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 07:43:00'),
(1364, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-18 07:45:01'),
(1365, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 07:45:10'),
(1366, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-18 07:52:39'),
(1367, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 07:52:47'),
(1368, '���ϵͳ�û�', 0xe794a8e688b7e8a792e889b25b34385d2ce794a8e688b7e982aee7aeb15b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d2ce5a793e5908d5be5ad99e585a8e5869b5d, 18, 0, '172.16.1.69', '2012-10-18 07:55:02'),
(1369, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-18 07:55:09'),
(1370, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 28, 0, '172.16.1.69', '2012-10-18 07:55:16'),
(1371, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 28, 0, '172.16.1.69', '2012-10-18 07:55:29'),
(1372, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 28, 0, '172.16.1.69', '2012-10-18 07:55:40'),
(1373, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 28, 0, '172.16.1.69', '2012-10-18 07:57:03'),
(1374, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 07:57:11'),
(1375, '', 0xe7bc96e58fb75b32385d, 18, 0, '172.16.1.69', '2012-10-18 07:57:32'),
(1376, '�༭ϵͳ�û�', 0xe5a793e5908d5be5ad99e585a8e5869b5d, 18, 0, '172.16.1.69', '2012-10-18 07:57:46'),
(1377, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-18 07:57:48'),
(1378, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 31, 0, '172.16.1.69', '2012-10-18 07:57:54'),
(1379, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 31, 0, '172.16.1.69', '2012-10-18 07:58:23'),
(1380, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 07:58:38'),
(1381, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-18 08:02:18'),
(1382, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 31, 0, '172.16.1.69', '2012-10-18 08:03:08'),
(1383, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 21:59:38'),
(1384, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-18 21:59:38'),
(1385, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-18 21:59:52'),
(1386, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 31, 0, '172.16.1.69', '2012-10-18 22:00:01'),
(1387, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 31, 0, '172.16.1.69', '2012-10-19 01:31:33'),
(1388, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-19 01:31:48'),
(1389, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-19 01:38:57'),
(1390, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-19 01:39:11'),
(1391, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-19 01:39:24'),
(1392, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 31, 0, '172.16.1.69', '2012-10-19 01:39:35'),
(1393, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 31, 0, '172.16.1.69', '2012-10-19 01:57:49'),
(1394, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-19 01:57:58'),
(1395, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-19 02:04:08'),
(1396, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 31, 0, '172.16.1.69', '2012-10-19 02:04:18'),
(1397, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 31, 0, '172.16.1.69', '2012-10-19 02:04:18'),
(1398, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-26 03:46:49'),
(1399, '添加任务成功', 0xe68c87e4bba4736e5b313335313234393032325d2ce68c87e4bba4e99b865b34315d2ce68c87e4bba4e99b86e7bea45b34325d2ce68c87e4bba4e58f82e695b05b2f746d702f61612e7478740d0a2f746d702f62622e7478740d0a2f746d702f63632e7478745d, 18, 0, '172.16.1.69', '2012-10-26 03:57:08'),
(1400, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 18, 0, '172.16.1.69', '2012-10-26 03:57:18'),
(1401, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 31, 0, '172.16.1.69', '2012-10-26 03:57:27'),
(1402, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.155', '2012-10-29 00:29:27'),
(1403, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 31, 0, '172.16.1.69', '2012-10-29 00:30:06'),
(1404, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 31, 0, '172.16.1.69', '2012-10-29 01:06:21'),
(1405, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 31, 0, '172.16.1.69', '2012-10-29 19:29:32'),
(1406, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 31, 0, '172.16.1.69', '2012-10-30 03:27:10'),
(1407, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 31, 0, '172.16.1.69', '2012-10-30 03:49:33'),
(1408, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b7175616e6a756e4073746166662e73696e612e636f6d2e636e5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 18, 0, '172.16.1.69', '2012-10-30 03:49:42'),
(1409, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 31, 0, '172.16.1.69', '2012-10-30 07:54:09'),
(1410, '删除成功，删除列表如下:<br><br>角色为:test<br><br>', '', 0, 0, '', '2012-10-30 07:54:41'),
(1411, '退出登录', 0xe68890e58a9fe98080e587bae7b3bbe7bb9f21, 31, 0, '172.16.1.69', '2012-10-30 07:56:59'),
(1412, '登录成功!', 0xe799bbe5bd95e5908de7a7b05b74657374403136332e636f6d5d2ce799bbe5bd95e5af86e7a0815b2a2a2a2a5d, 31, 0, '172.16.1.69', '2012-10-30 07:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`Id`, `name`) VALUES
(1, '????'),
(2, '??????'),
(3, '????');

-- --------------------------------------------------------

--
-- Table structure for table `treemenu`
--

CREATE TABLE IF NOT EXISTS `treemenu` (
  `MenuId` int(11) NOT NULL AUTO_INCREMENT,
  `MenuName` varchar(50) NOT NULL DEFAULT 'test',
  `MenuPId` int(4) DEFAULT NULL,
  `MenuLink` varchar(255) NOT NULL DEFAULT '../blank.php?flag=1',
  `MenuLevel` smallint(6) NOT NULL DEFAULT '0',
  `MenuEndFlag` enum('0','1') NOT NULL DEFAULT '1',
  `InfluenceItemList` varchar(1024) NOT NULL DEFAULT '??:style=popUp:addFlag=1|??:style=mulSele:delFlag=1|??:style=singleSele:editFlag=1|??:style=null:readFlag=1|??:style=null:listFlag=1|????:style=null:menuFlag=1|???:style=selfDef:customInfluenceList=1',
  `customInfluenceItemList` varchar(1024) NOT NULL DEFAULT '''''',
  `SortValue` int(11) NOT NULL DEFAULT '1',
  `regTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`MenuId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=198 ;

--
-- Dumping data for table `treemenu`
--

INSERT INTO `treemenu` (`MenuId`, `MenuName`, `MenuPId`, `MenuLink`, `MenuLevel`, `MenuEndFlag`, `InfluenceItemList`, `customInfluenceItemList`, `SortValue`, `regTime`) VALUES
(1, '帐号管理', 0, '/kernel.php?module=usermanager&app=showtmpl&flag=1&opt=listFlag', 0, '1', '填加:style=location:addFlag=1|删除:style=delSele:delFlag=1|修改:style=singleSele:editFlag=1|只读:style=null:readFlag=1|列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1', '', 96, '2011-12-27 20:25:03'),
(2, '角色管理', 0, '/kernel.php?module=acl&app=showtmpl&flag=1&opt=listFlag', 0, '1', '填加:style=location:addFlag=1|删除:style=delSele:delFlag=1|修改:style=singleSele:editFlag=1|列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1|权限分配:style=singleSele:editPower=1', '权限修改保存:style=null:editpowersave=1', 97, '2011-12-27 20:25:03'),
(3, '类型管理', 0, '/kernel.php?module=typedata&app=showtmpl&flag=1&opt=listFlag', 0, '0', '填加:style=location:addFlag=1|删除:style=delSele:delFlag=1|修改:style=singleSele:editFlag=1|列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1', '', 80, '2011-12-27 20:25:03'),
(16, '修改密码', 0, '/kernel.php?module=updpassword&app=showtmpl&flag=1&opt=editFlag', 0, '1', '修改:style=singleSele:editFlag=1|菜单显示:style=null:menuFlag=1', '密码保存:style=null:editFlagSave=1', 99, '2011-12-27 20:25:03'),
(24, '用户信息', 0, '/kernel.php?module=mainFrame&app=blank&flag=1&opt=readFlag', 0, '1', '只读:style=null:readFlag=1|列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1', '', 95, '2011-12-27 20:25:03'),
(28, '系统用户类型', 3, '/kernel.php?module=keyValue&app=showtmpl&flag=1&opt=listFlag&typeFlag=1', 1, '1', '填加:style=location:addFlag=1|删除:style=delSele:delFlag=1|修改:style=singleSele:editFlag=1|列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1', '', 0, '2011-12-27 20:28:42'),
(36, '操作日志', 0, '/kernel.php?module=optlog&app=showtmpl&flag=1&opt=listFlag', 0, '1', '列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1', '', 82, '2011-12-27 20:25:03'),
(40, '用户编辑', 0, '/kernel.php?module=usermanager&app=showtmpl&flag=1&opt=editFlag', 0, '1', '修改:style=singleSele:editFlag=1|菜单显示:style=null:menuFlag=1', '', 96, '2011-12-27 20:25:03'),
(41, '退出系统', 0, '/kernel.php?module=mainFrame&app=logout&flag=1&opt=logout', 0, '1', '菜单显示:style=null:menuFlag=1', '', 100, '2011-12-27 20:25:03'),
(186, '任务管理', 0, 'modules/mainFrame/blank.php?flag=1&opt=listFlag', 0, '0', '添加:style=location:addFlag=1|删除:style=delSele:delFlag=1|修改:style=singleSele:editFlag=1|只读:style=null:readFlag=1|列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1|权限分配:style=singleSele:editPower=1', '__CUSTOMINFLUENCEITEMLIST__', 1, '2012-10-18 09:10:29'),
(187, '新建任务', 186, 'taskManage.php?flag=1&opt=addFlag', 1, '1', '添加:style=location:addFlag=1|删除:style=delSele:delFlag=1|修改:style=singleSele:editFlag=1|只读:style=null:readFlag=1|列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1|权限分配:style=singleSele:editPower=1', '__CUSTOMINFLUENCEITEMLIST__', 1, '2012-10-18 09:10:29'),
(188, '任务查询', 186, 'taskManage.php?flag=1&opt=listFlag', 1, '1', '添加:style=location:addFlag=1|删除:style=delSele:delFlag=1|修改:style=singleSele:editFlag=1|只读:style=null:readFlag=1|列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1|权限分配:style=singleSele:editPower=1', '发送指令:style=singleSele:sendFlag=1', 1, '2012-10-18 09:10:29'),
(192, '服务器管理', 0, 'serverManager.php?flag=1&opt=listFlag', 0, '0', '添加:style=location:addFlag=1|删除:style=delSele:delFlag=1|修改:style=singleSele:editFlag=1|只读:style=null:readFlag=1|列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1|权限分配:style=singleSele:editPower=1', '__CUSTOMINFLUENCEITEMLIST__', 1, '2012-10-18 12:10:47'),
(193, '填加服务器', 192, 'serverList.php?flag=1&opt=addFlag', 1, '1', '添加:style=location:addFlag=1|删除:style=delSele:delFlag=1|修改:style=singleSele:editFlag=1|只读:style=null:readFlag=1|列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1|权限分配:style=singleSele:editPower=1', '__CUSTOMINFLUENCEITEMLIST__', 1, '2012-10-18 12:10:47'),
(194, '服务器列表', 192, 'serverList.php?flag=1&opt=listFlag', 1, '1', '添加:style=location:addFlag=1|删除:style=delSele:delFlag=1|修改:style=singleSele:editFlag=1|只读:style=null:readFlag=1|列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1|权限分配:style=singleSele:editPower=1', '__CUSTOMINFLUENCEITEMLIST__', 1, '2012-10-18 12:10:47'),
(195, '指令键', 3, '/kernel.php?module=keyValue&app=showtmpl&opt=listFlag&typeFlag=3', 1, '1', '添加:style=location:addFlag=1|删除:style=delSele:delFlag=1|修改:style=singleSele:editFlag=1|只读:style=null:readFlag=1|列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1|权限分配:style=singleSele:editPower=1', '__CUSTOMINFLUENCEITEMLIST__', 1, '2011-12-27 20:25:03'),
(196, '集群类型', 3, '/kernel.php?module=keyValue&app=showtmpl&opt=listFlag&typeFlag=4', 1, '1', '添加:style=location:addFlag=1|删除:style=delSele:delFlag=1|修改:style=singleSele:editFlag=1|只读:style=null:readFlag=1|列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1|权限分配:style=singleSele:editPower=1', '__CUSTOMINFLUENCEITEMLIST__', 1, '2011-12-27 20:25:03'),
(197, '任务明细', 186, '/taskDetail.php?flag=1&opt=listFlag', 1, '1', '添加:style=location:addFlag=1|删除:style=delSele:delFlag=1|修改:style=singleSele:editFlag=1|只读:style=null:readFlag=1|列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1|权限分配:style=singleSele:editPower=1', '__CUSTOMINFLUENCEITEMLIST__', 1, '2012-10-18 09:10:29');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
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
  `siteID` bigint(20) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `lastLoginTime` datetime DEFAULT '0000-00-00 00:00:00',
  `regTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=32 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `uid`, `passwd`, `userName`, `sex`, `cityID`, `hometown`, `birthday`, `address`, `qq`, `msn`, `mobile`, `homepage`, `company`, `job`, `note`, `influenceID`, `siteID`, `status`, `lastLoginTime`, `regTime`) VALUES
(18, 'quanjun@staff.sina.com.cn', 'asdfasdf1', '孙全军33', '1', 25, 'asdfasd', '1978-02-13', 'asdfasdfasf', '414301929', 'quanjun@staff.sina.com.cn', '13520410732', 'asdfasdf', 'asdfasdf', 'asdfasdf', '', -1, 0, 0, '2012-10-30 03:49:42', '2012-01-11 07:36:41'),
(19, 'test02@163.com', 'asdfasdf1', '客服测试33', '0', 0, NULL, '1978-02-13', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 51, 0, 0, '2011-12-29 18:51:51', '2011-10-06 05:51:21'),
(23, 'adsfsdaf@asdf32.com', 'asdfasdf', 'asdf332', '0', 0, NULL, '1978-02-13', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 57, 0, 0, '0000-00-00 00:00:00', '2011-12-29 23:31:30'),
(26, 'asdf@asdf.com', 'ASDFASDF', 'DSAASDFADF', '0', 0, NULL, '1978-02-13', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 56, 1, 0, '0000-00-00 00:00:00', '2011-12-31 01:16:38'),
(27, 'sqj0213@163.com', 'asdfasdf', '管理员', '0', 0, NULL, '1978-02-13', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 48, 8, 0, '2012-01-10 00:29:52', '2011-12-31 02:05:37'),
(29, 'hp@163.com', 'asdfasdf', 'hpoem', '0', 0, NULL, '1978-02-13', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 56, 2, 0, '2012-01-05 16:01:28', '2012-01-05 00:01:14'),
(30, 'lenovo@abc.com', '12345678', 'lenovo', '0', 0, NULL, '1978-02-13', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 56, 12, 0, '2012-01-10 00:46:46', '2012-01-06 05:16:52'),
(31, 'test@163.com', 'asdfasdf', '孙全军', '0', 0, NULL, '1978-02-13', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 48, 0, 0, '2012-10-30 07:59:00', '2012-10-18 07:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `userpower`
--

CREATE TABLE IF NOT EXISTS `userpower` (
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
  `customInfluenceItemList` varchar(1024) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '''''',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12631 ;

--
-- Dumping data for table `userpower`
--

INSERT INTO `userpower` (`id`, `treemenuID`, `influenceID`, `readFlag`, `editFlag`, `delFlag`, `addFlag`, `listFlag`, `menuFlag`, `editPower`, `customInfluenceItemList`) VALUES
(12613, 186, 48, '0', '0', '0', '0', '0', '1', '0', '__CUSTOMINFLUENCEITEMLIST__'),
(12614, 187, 48, '1', '1', '1', '1', '1', '1', '1', '__CUSTOMINFLUENCEITEMLIST__'),
(12615, 188, 48, '1', '1', '1', '1', '1', '1', '1', '发送指令:style=singleSele:sendFlag=1'),
(12616, 197, 48, '1', '1', '1', '1', '1', '1', '1', '__CUSTOMINFLUENCEITEMLIST__'),
(12617, 192, 48, '0', '0', '0', '0', '0', '1', '0', '__CUSTOMINFLUENCEITEMLIST__'),
(12618, 193, 48, '1', '1', '1', '1', '1', '1', '1', '__CUSTOMINFLUENCEITEMLIST__'),
(12619, 194, 48, '1', '1', '1', '1', '1', '1', '1', '__CUSTOMINFLUENCEITEMLIST__'),
(12620, 3, 48, '0', '0', '0', '0', '0', '1', '0', ''),
(12621, 28, 48, '0', '1', '1', '1', '1', '1', '0', ''),
(12622, 195, 48, '1', '1', '1', '1', '1', '1', '1', '__CUSTOMINFLUENCEITEMLIST__'),
(12623, 196, 48, '1', '1', '1', '1', '1', '1', '1', '__CUSTOMINFLUENCEITEMLIST__'),
(12624, 36, 48, '0', '0', '0', '0', '1', '1', '0', ''),
(12625, 24, 48, '1', '0', '0', '0', '1', '1', '0', ''),
(12626, 1, 48, '1', '1', '1', '1', '1', '1', '0', ''),
(12627, 40, 48, '0', '1', '0', '0', '0', '1', '0', ''),
(12628, 2, 48, '0', '1', '1', '1', '1', '1', '1', '权限修改保存:style=null:editpowersave=1'),
(12629, 16, 48, '0', '1', '0', '0', '0', '1', '0', '密码保存:style=null:editFlagSave=1'),
(12630, 41, 48, '0', '0', '0', '0', '0', '1', '0', '');

grant insert,select,update,delete on webtask.* to webtask@'localhost' identified by 'webtask123qwe';
grant insert,select,update,delete on webadmin.* to webtask@'localhost' identified by 'webtask123qwe';
flush privileges;
