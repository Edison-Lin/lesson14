-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-11-27 02:34:52
-- 伺服器版本： 10.4.24-MariaDB
-- PHP 版本： 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `pharmacy`
--

-- --------------------------------------------------------

--
-- 資料表結構 `ad_user`
--

CREATE TABLE IF NOT EXISTS `ad_user` (
  `adid` int(5) UNSIGNED NOT NULL COMMENT '管理者id',
  `adlogin` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理者登入帐号',
  `adname` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理者姓名',
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否启动',
  `adlevel` tinyint(1) NOT NULL DEFAULT 1 COMMENT '管理者层级',
  `groupid` int(3) UNSIGNED NOT NULL COMMENT '管理者群组',
  `adpasswd` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理者密码',
  `ademail` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理者email',
  `avatar` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '管理者頭像',
  `allowip` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '允许存取IP',
  `lastlogin` datetime DEFAULT NULL COMMENT '管理者最后登入时间',
  `sip` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '管理者最后登入ip',
  `sbrower` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理者最后登入brower',
  `splatform` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理者最后登入OS',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '建立日期',
  `update_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '修改日期',
  `remark` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `ad_user`
--

INSERT INTO `ad_user` (`adid`, `adlogin`, `adname`, `active`, `adlevel`, `groupid`, `adpasswd`, `ademail`, `avatar`, `allowip`, `lastlogin`, `sip`, `sbrower`, `splatform`, `create_date`, `update_date`, `remark`) VALUES
(1, 'system', '系統執行帳號', 0, 9, 5, 'e10adc3949ba59abbe56e057f20f883e', 'sysop@gmail.com', '20230503170318148.jpg', '0.0.0.0/32;', '2022-07-31 03:56:49', '127.0.0.1', 'Chrome', 'Windows 10', '2018-11-29 00:10:21', '2023-10-23 12:41:02', 'null'),
(2, 'test01', '林小强4', 0, 2, 2, 'dc483e80a7a0bd9ef71d8cf973673924', 'phil02@gmail.com', NULL, '192.168.50.1,192.168.60.1,192.168.70.2,\r\n192.168.80.1,192.168.90.11', '2019-01-11 00:00:00', NULL, '', '', '2019-01-10 18:58:01', '2019-03-10 23:23:30', NULL),
(3, 'a1a1', 'aaaa', 1, 1, 1, 'dc483e80a7a0bd9ef71d8cf973673924', 'a1a1@gmail.com', 'pic03.svg', '192.168.50.1,192.168.60.1,\r\n192.168.70,1', '2019-03-11 08:46:03', '127.0.0.1', 'Chrome', 'Windows 7', '2019-01-10 19:24:23', '2022-10-27 05:28:22', NULL),
(4, 'a1a2', 'aaaa', 1, 1, 1, 'e10adc3949ba59abbe56e057f20f883e', 'a1a1@gmail.com', NULL, '192.168.50.1', NULL, NULL, '', '', '2019-01-10 19:35:14', '2023-04-12 12:28:33', NULL),
(7, 'a1a4', 'aaaa', 1, 1, 1, 'e10adc3949ba59abbe56e057f20f883e', 'a1a1@gmail.com', NULL, '', NULL, NULL, '', '', '2019-01-15 23:57:36', '2019-01-15 23:57:36', NULL),
(9, 'a1a56', 'aaaa', 1, 1, 3, 'dc483e80a7a0bd9ef71d8cf973673924', 'phil56@gmail.com', NULL, '192.168.50.60', NULL, NULL, '', '', '2019-01-17 17:42:14', '2019-01-17 17:42:14', NULL),
(10, 'test', '林小强2', 1, 99, 1, 'e10adc3949ba59abbe56e057f20f883e', 'test@gmail.com', 'pic02.svg', '210.61.157.0/24;210.61.157.237/32;192.168.2.0/26;', '2022-07-31 03:56:49', '127.0.0.1', 'Chrome', 'Windows 10', '2018-11-29 00:10:21', '2023-04-27 11:05:59', NULL),
(11, 'test01', '測試帳號', 1, 1, 1, 'e10adc3949ba59abbe56e057f20f883e', 'test@gmail.com', 'pic02.svg', '0.0.0.0/32;', NULL, NULL, '', '', '2023-05-01 11:31:54', '2023-05-01 11:31:54', NULL),
(12, 'test11', 'phil', 1, 1, 1, 'e10adc3949ba59abbe56e057f20f883e', 'phil@gmail.com', '20230501194311370.jpg', '254.254.254.254/32;', NULL, NULL, '', '', '2023-05-01 11:56:24', '2023-05-18 07:29:51', 'ddsadsdsa'),
(17, 'te', 'te ', 1, 1, 2, 'e10adc3949ba59abbe56e057f20f883e', 'te@gmail.com', 'pic03.svg', '0.0.0.0/32;', NULL, NULL, '', '', '2023-05-30 12:10:12', '2023-05-30 12:10:12', '');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `ad_user`
--
ALTER TABLE `ad_user`
  ADD PRIMARY KEY (`adid`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `ad_user`
--
ALTER TABLE `ad_user`
  MODIFY `adid` int(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '管理者id', AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
