-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017-06-22 08:58:34
-- 服务器版本: 5.5.55-0ubuntu0.14.04.1
-- PHP 版本: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `weixin`
--

-- --------------------------------------------------------

--
-- 表的结构 `keyword`
--

CREATE TABLE IF NOT EXISTS `keyword` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `keyword` varchar(20) NOT NULL COMMENT '关键字',
  `reply` varchar(20) NOT NULL COMMENT '关键字回复信息',
  `isuse` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否还在使用此关键词，1代表使用，0代表不使用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `keyword`
--

INSERT INTO `keyword` (`id`, `keyword`, `reply`, `isuse`) VALUES
(1, '北京', '北京欢迎您', 1),
(2, '上海', '上海欢迎您', 1),
(3, '广州', '广州欢迎您', 0),
(4, '山东', '山东欢迎您', 1),
(5, '临沂', '临沂欢迎您', 1),
(6, '北京我来了', 'www.baidu.com', 1);

-- --------------------------------------------------------

--
-- 表的结构 `wx_users`
--

CREATE TABLE IF NOT EXISTS `wx_users` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `name` varchar(40) NOT NULL COMMENT '用户名',
  `ip` varchar(15) NOT NULL COMMENT '获取IP',
  `date` varchar(40) NOT NULL COMMENT '登陆时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `wx_users`
--

INSERT INTO `wx_users` (`id`, `name`, `ip`, `date`) VALUES
(5, 'oRIHct3j3boN9KNnDK0_Fb0tr6M0', '182.254.86.151', '2017-06-21 15:00:55');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
