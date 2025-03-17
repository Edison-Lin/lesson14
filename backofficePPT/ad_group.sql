-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-11-27 09:27:19
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
-- 資料表結構 `ad_group`
--

CREATE TABLE IF NOT EXISTS `ad_group` (
  `groupid` int(3) UNSIGNED NOT NULL COMMENT '管理者群组id',
  `gpname` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '群组名称',
  `gpename` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '管理群組英文名',
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否启动',
  `remark` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '备注',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '建立日期',
  `update_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '修改日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `ad_group`
--

INSERT INTO `ad_group` (`groupid`, `gpname`, `gpename`, `active`, `remark`, `create_date`, `update_date`) VALUES
(1, '系統管理人員', 'Admin', 1, NULL, '2018-11-29 00:04:56', '2022-10-27 05:36:55'),
(2, '一般管理人員', 'Operation System', 1, NULL, '2018-11-29 00:04:56', '2022-10-27 05:36:42'),
(3, '進階管理人員', 'Advanced Manager', 1, NULL, '2018-11-29 00:05:10', '2022-12-22 02:52:35'),
(4, '高階管理人員', 'Senior Manager', 0, NULL, '2018-12-04 21:30:12', '2023-07-17 03:26:40'),
(5, '客服管理人員', 'Customer Service Manager1', 1, 'null', '2018-12-04 21:30:33', '2023-07-17 09:50:54');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `ad_group`
--
ALTER TABLE `ad_group`
  ADD PRIMARY KEY (`groupid`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `ad_group`
--
ALTER TABLE `ad_group`
  MODIFY `groupid` int(3) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '管理者群组id', AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
