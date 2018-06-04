-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-06-04 08:52:17
-- 服务器版本： 5.7.20
-- PHP Version: 7.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `v-extravagant`
--

-- --------------------------------------------------------

--
-- 表的结构 `administrator`
--

CREATE TABLE `administrator` (
  `uid` int(8) NOT NULL COMMENT '用户ID,主键',
  `uuid` char(36) CHARACTER SET utf8 NOT NULL COMMENT 'UUID',
  `mobile` char(11) CHARACTER SET utf8 NOT NULL COMMENT '手机号码(可用作登录)',
  `email` char(60) CHARACTER SET utf8 DEFAULT '' COMMENT '邮箱(可用作登录)',
  `password` char(32) CHARACTER SET utf8 DEFAULT '' COMMENT '登录密码',
  `encrypt` char(10) CHARACTER SET utf8 DEFAULT '' COMMENT '密码加密因子',
  `name` varchar(60) CHARACTER SET utf8 DEFAULT '' COMMENT '用户名字',
  `avatar` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '用户头像',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:可用,2:禁用(不可登录)',
  `token` char(36) CHARACTER SET utf8 DEFAULT '' COMMENT '登录token',
  `expiration_date_token` int(11) NOT NULL DEFAULT '0' COMMENT 'token过期时间',
  `create_at` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_at` int(11) DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='用户表' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `administrator`
--

INSERT INTO `administrator` (`uid`, `uuid`, `mobile`, `email`, `password`, `encrypt`, `name`, `avatar`, `status`, `token`, `expiration_date_token`, `create_at`, `update_at`) VALUES
(1, '9688625C-B422-B283-9F8D-0487C507B2AF', '13123144888', 'yangchenpeng@qq.com', '16c91ca76866363e6e8ec73bf82cd86f', 'uZb6ZG', '杨陈鹏', '', 1, 'ff623ae5-2dfd-bf38-fac2-451b9b33478f', 1528962205, 0, 1528098205),
(2, '4F5EE4FE-9A9A-FA64-3203-05292EABAF28', '13123144889', 'peter@qq.com', '3d322ac8af791c2dd95d7c7d10d5e63f', 'KIDqq5', 'Peter', '', 1, '', 1512634999, 0, 1527575590);

-- --------------------------------------------------------

--
-- 表的结构 `attribute`
--

CREATE TABLE `attribute` (
  `id` int(11) NOT NULL COMMENT '属性ID',
  `name` char(255) COLLATE utf8mb4_bin NOT NULL COMMENT '属性名称',
  `pinyin` char(255) COLLATE utf8mb4_bin NOT NULL COMMENT '属性拼音',
  `create_at` int(11) NOT NULL COMMENT '创建时间',
  `update_at` int(11) NOT NULL COMMENT '编辑时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='商品属性表';

--
-- 转存表中的数据 `attribute`
--

INSERT INTO `attribute` (`id`, `name`, `pinyin`, `create_at`, `update_at`) VALUES
(9, '颜色', 'yanse', 1528083712, 1528083712),
(10, '尺寸', 'chicun', 1528091165, 1528091165);

-- --------------------------------------------------------

--
-- 表的结构 `attribute_attach`
--

CREATE TABLE `attribute_attach` (
  `id` int(11) NOT NULL COMMENT '商品属性值ID',
  `attribute_id` int(11) NOT NULL COMMENT '属性ID',
  `name` char(255) COLLATE utf8mb4_bin NOT NULL COMMENT '属性值名称',
  `pinyin` char(255) COLLATE utf8mb4_bin NOT NULL COMMENT '属性值名称拼音',
  `create_at` int(11) NOT NULL COMMENT '创建时间',
  `update_at` int(11) NOT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='商品属性附表';

--
-- 转存表中的数据 `attribute_attach`
--

INSERT INTO `attribute_attach` (`id`, `attribute_id`, `name`, `pinyin`, `create_at`, `update_at`) VALUES
(2, 9, 'aaa', 'aaa', 1528090640, 1528090640),
(3, 9, 'bbb', 'bbb', 1528090644, 1528090644),
(4, 9, 'ccc', 'ccc', 1528090647, 1528090647),
(5, 9, 'aaaa', 'aaaa', 1528090911, 1528090911),
(6, 9, 'ddd', 'ddd', 1528090921, 1528090921),
(7, 9, 'aaaa', 'aaaa', 1528090923, 1528090923),
(8, 9, 'aaa', 'aaa', 1528090926, 1528090926),
(16, 10, 'dsg', 'dsg', 1528091883, 1528091883),
(17, 10, 'sdfg', 'sdfg', 1528091888, 1528091888),
(18, 10, 'sdfg', 'sdfg', 1528091891, 1528091891),
(19, 10, 'ss', 'ss', 1528091894, 1528091894),
(20, 10, 'aaa', 'aaa', 1528092385, 1528092385),
(21, 10, 'aa', 'aa', 1528092390, 1528092390),
(22, 9, 'aaa', 'aaa', 1528092400, 1528092400),
(23, 10, 'aaa', 'aaa', 1528092431, 1528092431),
(24, 10, 'aaaa', 'aaaa', 1528092435, 1528092435),
(25, 10, 'aaa', 'aaa', 1528092439, 1528092439),
(26, 10, 'asdfasdf', 'asdfasdf', 1528092442, 1528092442),
(27, 10, 'ggf', 'ggf', 1528092958, 1528092958);

-- --------------------------------------------------------

--
-- 表的结构 `authorization`
--

CREATE TABLE `authorization` (
  `uid` int(8) NOT NULL COMMENT '用户组ID,主键',
  `groups` char(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '用户组ID，可多个,使用半角","分割',
  `rules` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `create_at` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_at` int(11) DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='用户授权' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `authorization`
--

INSERT INTO `authorization` (`uid`, `groups`, `rules`, `create_at`, `update_at`) VALUES
(1, '1', '', 1511333224, 1511670028),
(2, '9', '', 1511336316, 1511764790),
(3, '', '', 1511336784, 1511670070),
(4, '', '', 1511336789, 1511670074),
(7, '', '', 1511336795, 1511670080);

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL COMMENT '分类ID',
  `name` char(255) COLLATE utf8mb4_bin NOT NULL COMMENT '分类名称',
  `thumb` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT '分类缩略图地址',
  `pinyin` char(255) COLLATE utf8mb4_bin NOT NULL COMMENT '分类名pinyin',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `create_at` int(11) NOT NULL COMMENT '创建时间',
  `update_at` int(11) NOT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='商品分类表' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `name`, `thumb`, `pinyin`, `pid`, `create_at`, `update_at`) VALUES
(7, '男装', '/image/20180603/ce606caf0628147c9310749974d833e3.jpg', 'nanzhuang', 0, 1528010781, 1528014035),
(9, '上衣', '/image/20180603/f3cb89cdc57b72e0c1888bf8237a3e6b.jpg', 'shangyi', 7, 1528011867, 1528014255);

-- --------------------------------------------------------

--
-- 表的结构 `goods`
--

CREATE TABLE `goods` (
  `id` int(11) NOT NULL COMMENT '商品ID',
  `name` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT '商品名称',
  `thumb` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT '商品缩略图',
  `pinyin` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT '商品名称拼音',
  `price` int(11) NOT NULL DEFAULT '0' COMMENT '商品价格表(分)',
  `stock` int(6) NOT NULL COMMENT '商品库存',
  `create_at` int(11) NOT NULL COMMENT '创建时间',
  `update_at` int(11) NOT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='商品主表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `goods_attach`
--

CREATE TABLE `goods_attach` (
  `id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `article` text COLLATE utf8mb4_bin COMMENT '商品图文详情',
  `views` int(11) NOT NULL DEFAULT '0' COMMENT '商品浏览次数',
  `comments` int(11) NOT NULL DEFAULT '0' COMMENT '商品评论次数',
  `collection` int(11) NOT NULL COMMENT '商品被收藏次数',
  `shares` int(11) DEFAULT '0' COMMENT '商品分享次数',
  `create_at` int(11) NOT NULL COMMENT '创建时间',
  `update_at` int(11) NOT NULL COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='商品附表';

-- --------------------------------------------------------

--
-- 表的结构 `goods_attribute`
--

CREATE TABLE `goods_attribute` (
  `id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `number` bigint(16) NOT NULL COMMENT '商品编号,根据商品ID以及商品属性计算',
  `price` int(11) NOT NULL COMMENT '当前属性的商品价格',
  `thumb` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '当前属性的商品缩略图',
  `create_at` int(11) NOT NULL COMMENT '创建时间',
  `update_at` int(11) NOT NULL COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='商品属性表,用于储存同一个商品不同的属性数据' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `goods_attribute_attach`
--

CREATE TABLE `goods_attribute_attach` (
  `id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `attribute_name` char(100) COLLATE utf8mb4_bin NOT NULL COMMENT '属性名称',
  `attribute_id` int(11) NOT NULL COMMENT '属性ID',
  `attribute_attach` text COLLATE utf8mb4_bin COMMENT '属性值json格式'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='商品所关联的所有属性';

-- --------------------------------------------------------

--
-- 表的结构 `goods_thumb`
--

CREATE TABLE `goods_thumb` (
  `id` int(11) NOT NULL COMMENT '缩略图ID',
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `thumb` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT '缩略图地址',
  `create_at` int(11) NOT NULL COMMENT '创建时间',
  `update_at` int(11) NOT NULL COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='商品缩略图表';

-- --------------------------------------------------------

--
-- 表的结构 `group`
--

CREATE TABLE `group` (
  `id` int(8) NOT NULL COMMENT 'ID,主键',
  `name` char(30) CHARACTER SET utf8 NOT NULL COMMENT '管理组名称',
  `rules` text CHARACTER SET utf8 COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `descriptions` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '描述',
  `create_at` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_at` int(11) DEFAULT '0' COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='管理组/角色' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `group`
--

INSERT INTO `group` (`id`, `name`, `rules`, `descriptions`, `create_at`, `update_at`) VALUES
(1, '超级管理员', '1,3,12,13,15,16,17,5,14,18,19,7,20,21,22,23,24,26,25,27,28,29,34,35,36,37,38,39,40,41,42,43,44,45', '超级管理员', 0, 1528091872);

-- --------------------------------------------------------

--
-- 表的结构 `login_log`
--

CREATE TABLE `login_log` (
  `id` int(8) NOT NULL COMMENT 'ID,主键',
  `uid` int(8) NOT NULL COMMENT '用户ID',
  `ip` char(20) CHARACTER SET utf8 DEFAULT '' COMMENT '登录时IP',
  `location` text CHARACTER SET utf8 COMMENT '地址信息',
  `create_at` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_at` int(11) DEFAULT '0' COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='第三方登录授权' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `operation_log`
--

CREATE TABLE `operation_log` (
  `id` int(8) NOT NULL COMMENT 'ID,主键',
  `uid` int(8) NOT NULL COMMENT 'ID',
  `username` char(30) CHARACTER SET utf8 NOT NULL COMMENT '当前用户名字/手机号码',
  `group_id` int(8) NOT NULL COMMENT '当前用户所属用户组id',
  `group_name` char(30) CHARACTER SET utf8 NOT NULL COMMENT '当前用户所属用户组名称',
  `rule_id` int(8) NOT NULL COMMENT '当前用户操作的规则ID',
  `rule_name` char(30) CHARACTER SET utf8 NOT NULL COMMENT '当前用户操作的规则名称',
  `description` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '描述',
  `sql` text CHARACTER SET utf8 COMMENT '当前用户执行的sql语句',
  `create_at` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_at` int(11) DEFAULT '0' COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='系统操作日志表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `recycle_bin`
--

CREATE TABLE `recycle_bin` (
  `id` int(11) NOT NULL,
  `content` text CHARACTER SET utf8mb4 COMMENT '删除时的内容(json格式)',
  `create_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_at` int(11) DEFAULT '0' COMMENT '修改时间',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `from_table` char(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '来至于哪张表'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='回收站' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `recycle_bin`
--

INSERT INTO `recycle_bin` (`id`, `content`, `create_at`, `update_at`, `uid`, `from_table`) VALUES
(1, '{\"id\":2,\"pid\":1,\"name\":\"\\u7ba1\\u7406\\u5458\",\"identification\":\"permission.administrator\",\"icon_class\":\"\",\"icon_family\":\"an-mall-icon\",\"type\":1,\"address\":\"\",\"create_at\":1510892014,\"update_at\":1510892014}', 1510898511, 1510898511, 1, 'rule'),
(2, '{\"id\":11,\"name\":\"\\u6d4b\\u8bd51\",\"rules\":\"\",\"descriptions\":\"\",\"create_at\":\"2017-11-20 12:48:04\",\"update_at\":\"2017-11-20 12:48:04\"}', 1511153659, 1511153659, 1, 'group'),
(3, '{\"id\":10,\"name\":\"\\u6d4b\\u8bd5\",\"rules\":\"\",\"descriptions\":\"\\u6d4b\\u8bd5\",\"create_at\":\"2017-11-20 12:45:25\",\"update_at\":\"2017-11-20 12:45:25\"}', 1511153665, 1511153665, 1, 'group'),
(4, '{\"id\":2,\"name\":\"\\u4fee\\u6539\\u4e4b\\u540e\\u7684\\u8349\\u9e21\\u7ba1\\u7406\\u54582\",\"rules\":\"\",\"descriptions\":\"\\u8349\\u9e21\\u7ba1\\u7406\\u54582\\u8349\\u9e21\\u7ba1\\u7406\\u54582\\u8349\\u9e21\\u7ba1\\u7406\\u54582\\u8349\\u9e21\\u7ba1\\u7406\\u54582\\u8349\\u9e21\\u7ba1\\u7406\\u54582\",\"create_at\":\"1970-01-01 08:00:00\",\"update_at\":\"2017-11-20 12:34:47\"}', 1511153721, 1511153721, 1, 'group'),
(5, '{\"id\":12,\"pid\":4,\"name\":\"\\u6d4b\\u8bd5\",\"identification\":\"test\",\"icon_class\":\"\",\"icon_family\":\"an-mall-icon\",\"type\":3,\"address\":\"\",\"create_at\":\"2017-11-21 14:46:21\",\"update_at\":\"2017-11-21 14:46:21\",\"sort\":1}', 1511263395, 1511263395, 1, 'rule'),
(6, '{\"id\":9,\"name\":\"\\u8349\\u9e21\\u7ba1\\u7406\\u54589\",\"rules\":\"1,5,6,7,8,10,11\",\"descriptions\":\"\\u8349\\u9e21\\u7ba1\\u7406\\u54589\\u8349\\u9e21\\u7ba1\\u7406\\u54589\\u8349\\u9e21\\u7ba1\\u7406\\u54589\\u8349\\u9e21\\u7ba1\\u7406\\u54589\\u8349\\u9e21\\u7ba1\\u7406\\u54589\\u8349\\u9e21\\u7ba1\\u7406\\u54589\",\"create_at\":\"1970-01-01 08:00:00\",\"update_at\":\"2017-11-21 23:58:34\"}', 1511282727, 1511282727, 1, 'group'),
(7, '{\"id\":12,\"name\":\"a\",\"rules\":\"1,5,6,7,8,10,11\",\"descriptions\":\"\\u6d4b\\u8bd5\",\"create_at\":\"2017-11-21 19:21:19\",\"update_at\":\"2017-11-22 00:41:57\"}', 1511282742, 1511282742, 1, 'group'),
(8, '{\"id\":4,\"pid\":3,\"name\":\"\\u5217\\u8868\",\"identification\":\"permission.administrator.list\",\"icon_class\":\"\",\"icon_family\":\"an-mall-icon\",\"type\":1,\"address\":\"\",\"create_at\":\"2017-11-17 14:36:05\",\"update_at\":\"2017-11-18 15:56:43\",\"sort\":1}', 1511670349, 1511670349, 1, 'rule'),
(9, '{\"id\":6,\"pid\":5,\"name\":\"\\u5217\\u8868\",\"identification\":\"permission.rule.list\",\"icon_class\":\"\",\"icon_family\":\"an-mall-icon\",\"type\":1,\"address\":\"\",\"create_at\":\"2017-11-17 14:37:00\",\"update_at\":\"2017-11-21 17:18:19\",\"sort\":1}', 1511670379, 1511670379, 1, 'rule'),
(10, '{\"id\":8,\"pid\":7,\"name\":\"\\u5217\\u8868\",\"identification\":\"permission.group.list\",\"icon_class\":\"\",\"icon_family\":\"an-mall-icon\",\"type\":1,\"address\":\"\",\"create_at\":\"2017-11-17 16:15:39\",\"update_at\":\"2017-11-17 16:15:39\",\"sort\":1}', 1511670398, 1511670398, 1, 'rule'),
(11, '{\"id\":8,\"name\":\"\\u8349\\u9e21\\u7ba1\\u7406\\u54588\",\"rules\":\"1,5,6,10\",\"descriptions\":\"\\u8349\\u9e21\\u7ba1\\u7406\\u54588\\u8349\\u9e21\\u7ba1\\u7406\\u54588\\u8349\\u9e21\\u7ba1\\u7406\\u54588\\u8349\\u9e21\\u7ba1\\u7406\\u54588\\u8349\\u9e21\\u7ba1\\u7406\\u54588\\u8349\\u9e21\\u7ba1\\u7406\\u54588\",\"create_at\":\"1970-01-01 08:00:00\",\"update_at\":\"2017-11-21 23:21:21\"}', 1511671598, 1511671598, 1, 'group'),
(12, '{\"id\":7,\"name\":\"\\u8349\\u9e21\\u7ba1\\u7406\\u54587\",\"rules\":\"1,5,6,7,8,10,11\",\"descriptions\":\"\\u8349\\u9e21\\u7ba1\\u7406\\u5458\",\"create_at\":\"1970-01-01 08:00:00\",\"update_at\":\"2017-11-22 00:20:53\"}', 1511671602, 1511671602, 1, 'group'),
(13, '{\"id\":6,\"name\":\"\\u8349\\u9e21\\u7ba1\\u7406\\u54586\",\"rules\":\"1,7,8,11\",\"descriptions\":\"\\u8349\\u9e21\\u7ba1\\u7406\\u54586\\u8349\\u9e21\\u7ba1\\u7406\\u54586\\u8349\\u9e21\\u7ba1\\u7406\\u54586\\u8349\\u9e21\\u7ba1\\u7406\\u54586\\u8349\\u9e21\\u7ba1\\u7406\\u54586\",\"create_at\":\"1970-01-01 08:00:00\",\"update_at\":\"2017-11-21 23:20:40\"}', 1511671607, 1511671607, 1, 'group'),
(14, '{\"id\":5,\"name\":\"\\u8349\\u9e21\\u7ba1\\u7406\\u54585\",\"rules\":\"\",\"descriptions\":\"\\u8349\\u9e21\\u7ba1\\u7406\\u54585\\u8349\\u9e21\\u7ba1\\u7406\\u54585\\u8349\\u9e21\\u7ba1\\u7406\\u54585\\u8349\\u9e21\\u7ba1\\u7406\\u54585\",\"create_at\":\"1970-01-01 08:00:00\",\"update_at\":\"1970-01-01 08:00:00\"}', 1511671610, 1511671610, 1, 'group'),
(15, '{\"id\":4,\"name\":\"\\u8349\\u9e21\\u7ba1\\u7406\\u54584\",\"rules\":\"1,3,4,7,8,9,11\",\"descriptions\":\"\\u8349\\u9e21\\u7ba1\\u7406\\u54584\\u8349\\u9e21\\u7ba1\\u7406\\u54584\\u8349\\u9e21\\u7ba1\\u7406\\u54584\\u8349\\u9e21\\u7ba1\\u7406\\u54584\\u8349\\u9e21\\u7ba1\\u7406\\u54584\",\"create_at\":\"1970-01-01 08:00:00\",\"update_at\":\"2017-11-22 10:42:19\"}', 1511671612, 1511671612, 1, 'group'),
(16, '{\"id\":3,\"name\":\"\\u8349\\u9e21\\u7ba1\\u7406\\u54583\",\"rules\":\"1,3,4,9\",\"descriptions\":\"\\u8349\\u9e21\\u7ba1\\u7406\\u54583\\u8349\\u9e21\\u7ba1\\u7406\\u54583\\u8349\\u9e21\\u7ba1\\u7406\\u54583\\u8349\\u9e21\\u7ba1\\u7406\\u54583\\u8349\\u9e21\\u7ba1\\u7406\\u54583\",\"create_at\":\"1970-01-01 08:00:00\",\"update_at\":\"2017-11-22 10:42:08\"}', 1511671615, 1511671615, 1, 'group'),
(17, '{\"uid\":7,\"uuid\":\"A377B5E8-2BF7-B864-8B0C-C026BA2CCEBD\",\"mobile\":\"13123144881\",\"email\":\"Peter-_-Yang@qq.com\",\"password\":\"085607778b6d2d5d14a6b59dcb609434\",\"encrypt\":\"R3XQrS\",\"name\":\"PeterYang\",\"avatar\":\"\",\"status\":2,\"token\":\"\",\"expiration_date_token\":1511666506,\"create_at\":\"1970-01-01 08:00:00\",\"update_at\":\"2017-11-22 15:46:42\"}', 1511763746, 1511763746, 1, 'user'),
(18, '{\"uid\":4,\"uuid\":\"43875425-B012-5E4E-CE7E-72982CD8F47A\",\"mobile\":\"13123144778\",\"email\":\"yangchenpeng@qq.cn\",\"password\":\"8f5cb365b37b74dc02429b246320d432\",\"encrypt\":\"3jxqu3\",\"name\":\"\\u6768\\u9648\\u9e4f\",\"avatar\":\"\",\"status\":2,\"token\":\"\",\"expiration_date_token\":0,\"create_at\":\"1970-01-01 08:00:00\",\"update_at\":\"2017-11-22 15:46:43\"}', 1511763749, 1511763749, 1, 'user'),
(19, '{\"uid\":3,\"uuid\":\"8F7DFD06-E06D-49DB-B559-8AA11BB50FF5\",\"mobile\":\"13123144887\",\"email\":\"PeterYang@qq.com\",\"password\":\"5c1f1aca18e061c04a4d64cd26441cec\",\"encrypt\":\"WGKZGV\",\"name\":\"\\u6768\\u9648\\u9e4f\",\"avatar\":\"\",\"status\":2,\"token\":\"\",\"expiration_date_token\":0,\"create_at\":\"1970-01-01 08:00:00\",\"update_at\":\"2017-11-22 15:46:46\"}', 1511763752, 1511763752, 1, 'user'),
(20, '{\"id\":13,\"name\":\"\\u6d4b\\u8bd5\",\"rules\":\"1,3,12,13,15,16,17,5,14,18,19,7,20,21,22,23,24,26,25,27,28,29\",\"descriptions\":\"\\u6d4b\\u8bd5\",\"create_at\":\"\",\"update_at\":\"\"}', 1527574756, 1527574756, 1, 'group'),
(21, '{\"id\":12,\"name\":\"\\u6d4b\\u8bd5\",\"rules\":\"1,3,12,13,15,16,17,5,14,18,19,7,20,21,22,23,24,26,25,27,28,29\",\"descriptions\":\"\\u6d4b\\u8bd5\",\"create_at\":\"\",\"update_at\":\"\"}', 1527574759, 1527574759, 1, 'group'),
(22, '{\"id\":11,\"name\":\"\\u6d4b\\u8bd5\",\"rules\":\"1,3,12,13,15,16,17,5,14,18,19,7,20,21,22,23,24,26,25,27,28,29\",\"descriptions\":\"\\u6d4b\\u8bd5\",\"create_at\":\"\",\"update_at\":\"\"}', 1527574761, 1527574761, 1, 'group'),
(23, '{\"id\":10,\"name\":\"\\u6d4b\\u8bd5\",\"rules\":\"1,3,12,13,15,16,17,5,14,18,19,7,20,21,22,23,24,26,25,27,28,29\",\"descriptions\":\"\\u6d4b\\u8bd5\",\"create_at\":\"\",\"update_at\":\"\"}', 1527574764, 1527574764, 1, 'group'),
(24, '{\"id\":9,\"name\":\"\\u7f16\\u8f91\",\"rules\":\"1,3,5,14,15,16,17,18,19\",\"descriptions\":\"\\u7f16\\u8f91\",\"create_at\":\"\",\"update_at\":\"\"}', 1527574769, 1527574769, 1, 'group'),
(25, '{\"id\":33,\"pid\":0,\"name\":\"\\u8ba2\\u5355\\u7ba1\\u7406\",\"identification\":\"order\",\"icon_class\":\"icon-order\",\"icon_family\":\"v-font\",\"type\":1,\"address\":\"\",\"create_at\":\"\",\"update_at\":\"\",\"sort\":1}', 1527909522, 1527909522, 1, 'rule'),
(26, '{\"id\":32,\"pid\":0,\"name\":\"\\u4ee3\\u7406\\u5546\",\"identification\":\"agent\",\"icon_class\":\"icon-agent\",\"icon_family\":\"v-font\",\"type\":1,\"address\":\"\",\"create_at\":\"\",\"update_at\":\"\",\"sort\":1}', 1527909525, 1527909525, 1, 'rule'),
(27, '{\"id\":31,\"pid\":0,\"name\":\"\\u4f1a\\u5458\\u7ba1\\u7406\",\"identification\":\"member\",\"icon_class\":\"icon-users\",\"icon_family\":\"v-font\",\"type\":1,\"address\":\"\",\"create_at\":\"\",\"update_at\":\"\",\"sort\":1}', 1527909527, 1527909527, 1, 'rule'),
(28, '{\"id\":30,\"pid\":0,\"name\":\"\\u5546\\u54c1\\u7ba1\\u7406\",\"identification\":\"goods\",\"icon_class\":\"icon-goods\",\"icon_family\":\"v-font\",\"type\":1,\"address\":\"\",\"create_at\":\"\",\"update_at\":\"\",\"sort\":1}', 1527909531, 1527909531, 1, 'rule'),
(29, '{\"id\":13,\"attribute_id\":9,\"name\":\"asdf\",\"pinyin\":\"asdf\",\"create_at\":\"\",\"update_at\":\"\"}', 1528091290, 1528091290, 1, 'attribute_attach'),
(30, '{\"id\":12,\"attribute_id\":9,\"name\":\"asdf\",\"pinyin\":\"asdf\",\"create_at\":\"\",\"update_at\":\"\"}', 1528091293, 1528091293, 1, 'attribute_attach'),
(31, '{\"id\":11,\"attribute_id\":9,\"name\":\"asdf\",\"pinyin\":\"asdf\",\"create_at\":\"\",\"update_at\":\"\"}', 1528091297, 1528091297, 1, 'attribute_attach'),
(32, '{\"id\":10,\"attribute_id\":9,\"name\":\"vvva\",\"pinyin\":\"vvva\",\"create_at\":\"\",\"update_at\":\"\"}', 1528091302, 1528091302, 1, 'attribute_attach'),
(33, '{\"id\":9,\"attribute_id\":9,\"name\":\"asdd\",\"pinyin\":\"asdd\",\"create_at\":\"\",\"update_at\":\"\"}', 1528091305, 1528091305, 1, 'attribute_attach'),
(34, '{\"id\":15,\"attribute_id\":10,\"name\":\"M\",\"pinyin\":\"M\",\"create_at\":\"\",\"update_at\":\"\"}', 1528091848, 1528091848, 1, 'attribute_attach'),
(35, '{\"id\":14,\"attribute_id\":10,\"name\":\"S\",\"pinyin\":\"S\",\"create_at\":\"\",\"update_at\":\"\"}', 1528091853, 1528091853, 1, 'attribute_attach');

-- --------------------------------------------------------

--
-- 表的结构 `rule`
--

CREATE TABLE `rule` (
  `id` int(8) NOT NULL COMMENT 'ID, 主键',
  `pid` int(8) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `name` char(30) CHARACTER SET utf8 NOT NULL COMMENT '规则名称',
  `identification` char(255) CHARACTER SET utf8 NOT NULL COMMENT '规则唯一标识',
  `icon_class` char(60) CHARACTER SET utf8 DEFAULT '' COMMENT '规则字体图标',
  `icon_family` char(60) CHARACTER SET utf8 DEFAULT 'an-mall-icon' COMMENT '字体图标font-family class',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型(1:菜单,2:路由类的功能性按钮,3:非路由类的功能性按钮,4: 展示类权限)',
  `address` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '路由地址,因为前段使用name字段进行路由,所以该字段暂时不会被使用',
  `create_at` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_at` int(11) DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '1' COMMENT '排序字段,主要用于菜单排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='权限规则表' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `rule`
--

INSERT INTO `rule` (`id`, `pid`, `name`, `identification`, `icon_class`, `icon_family`, `type`, `address`, `create_at`, `update_at`, `sort`) VALUES
(1, 0, '权限管理', 'permission', 'icon-quanxianguanli1', 'an-mall-icon', 1, '', 1510823097, 1511581910, 1),
(3, 1, '管理员', 'permission.administrator.list', 'icon-guanliyuan', 'an-mall-icon', 1, '', 1510900497, 1511670357, 1),
(5, 1, '权限', 'permission.rule.list', 'icon-permission', 'an-mall-icon', 1, '', 1510900597, 1511670388, 1),
(7, 1, '管理组', 'permission.group.list', 'icon-guanlifenzu', 'an-mall-icon', 1, '', 1510906482, 1511670405, 1),
(12, 3, '添加', 'permission.administrator.create', '', 'an-mall-icon', 2, '', 1511672044, 1511672044, 1),
(13, 3, '编辑', 'permission.administrator.update', '', 'an-mall-icon', 2, '', 1511672093, 1511672093, 1),
(14, 5, '添加', 'permission.rule.create', '', 'an-mall-icon', 2, '', 1511679168, 1511679168, 1),
(15, 3, '授权', 'permission.administrator.authorization', '', 'an-mall-icon', 3, '', 1511679269, 1511679324, 1),
(16, 3, '删除', 'permission.administrator.delete', '', 'an-mall-icon', 3, '', 1511679312, 1511679312, 1),
(17, 3, '禁封/解禁', 'permission.administrator.disable_or_enable', '', 'an-mall-icon', 3, '', 1511679401, 1511679401, 1),
(18, 5, '编辑', 'permission.rule.update', '', 'an-mall-icon', 2, '', 1511679446, 1511679446, 1),
(19, 5, '删除', 'permission.rule.delete', '', 'an-mall-icon', 3, '', 1511679472, 1511679472, 1),
(20, 7, '添加', 'permission.group.create', '', 'an-mall-icon', 2, '', 1511679509, 1511679509, 1),
(21, 7, '编辑', 'permission.group.update', '', 'an-mall-icon', 2, '', 1511679561, 1511679561, 1),
(22, 7, '删除', 'permission.group.delete', '', 'an-mall-icon', 3, '', 1511679592, 1511679592, 1),
(23, 7, '分配权限', 'permission.group.authorization', '', 'an-mall-icon', 3, '', 1511679643, 1511679643, 1),
(24, 0, '系统设置', 'setting', 'icon-setting', 'an-mall-icon', 1, '', 1511924145, 1511924402, 1),
(25, 26, '白名单', 'setting.rules.white_list', '', 'an-mall-icon', 1, '', 1511925793, 1511926639, 1),
(26, 24, '权限相关', 'setting.rules', 'icon-permission', 'an-mall-icon', 1, '', 1511926097, 1511926595, 1),
(27, 25, '添加', 'setting.rules.white_list.create', '', 'an-mall-icon', 3, '', 1511938031, 1511938031, 1),
(28, 25, '编辑', 'setting.rules.white_list.update', '', 'an-mall-icon', 3, '', 1511938054, 1511938054, 1),
(29, 25, '删除', 'setting.rules.white_list.delete', '', 'an-mall-icon', 3, '', 1511938088, 1511938088, 1),
(34, 0, '基础数据', 'basic', 'icon-basic-data', 'v-font', 1, '', 1527909562, 1527909562, 1),
(35, 34, '分类管理', 'basic.category', 'icon-category', 'v-font', 1, '', 1527909650, 1527909650, 1),
(36, 35, '分类列表', 'basic.category.items', '', '', 1, '', 1527909705, 1527909705, 1),
(37, 35, '修改分类', 'basic.category.edit', '', '', 2, '', 1527909781, 1527909781, 1),
(38, 35, '删除分类', 'basic.category.delete', '', '', 3, '', 1527909814, 1527909814, 1),
(39, 35, '创建分类', 'basic.category.create', '', '', 2, '', 1527910389, 1527910389, 1),
(40, 34, '属性管理', 'basic.attribute', 'icon-attribute', 'v-font', 1, '', 1528015168, 1528015168, 1),
(41, 40, '属性列表', 'basic.attribute.items', '', '', 1, '', 1528015202, 1528015202, 1),
(42, 40, '添加属性', 'basic.attribute.create', '', '', 3, '', 1528015287, 1528015383, 1),
(43, 40, '删除属性', 'basic.attribute.delete', '', '', 3, '', 1528091359, 1528091359, 1),
(44, 40, '添加属性值', 'basic.attribute.create.attach', '', '', 3, '', 1528091411, 1528091556, 1),
(45, 40, '删除属性值', 'basic.attribute.delete.attach', '', '', 3, '', 1528091458, 1528091574, 1);

-- --------------------------------------------------------

--
-- 表的结构 `setting`
--

CREATE TABLE `setting` (
  `key` char(255) CHARACTER SET utf8mb4 NOT NULL,
  `value` text CHARACTER SET utf8mb4 NOT NULL,
  `description` char(255) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '配置描述',
  `create_at` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_at` int(11) DEFAULT '0' COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='系统设置表' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `setting`
--

INSERT INTO `setting` (`key`, `value`, `description`, `create_at`, `update_at`) VALUES
('rule_white_list', '[{\"name\":\"\\u63a7\\u5236\\u53f0\",\"identification\":\"dashboard\"}]', '总后台路由白名单', 1511942531, 1512006533);

-- --------------------------------------------------------

--
-- 表的结构 `third_authorization`
--

CREATE TABLE `third_authorization` (
  `id` int(8) NOT NULL COMMENT 'ID,主键',
  `uid` int(8) NOT NULL COMMENT '用户ID',
  `third_type` char(15) CHARACTER SET utf8 DEFAULT '' COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `create_at` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_at` int(11) DEFAULT '0' COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='第三方登录授权' ROW_FORMAT=COMPACT;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `uid` (`uid`,`uuid`,`mobile`,`token`,`email`) USING BTREE;

--
-- Indexes for table `attribute`
--
ALTER TABLE `attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_attach`
--
ALTER TABLE `attribute_attach`
  ADD PRIMARY KEY (`id`,`attribute_id`);

--
-- Indexes for table `authorization`
--
ALTER TABLE `authorization`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goods_attach`
--
ALTER TABLE `goods_attach`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goods_attribute`
--
ALTER TABLE `goods_attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goods_attribute_attach`
--
ALTER TABLE `goods_attribute_attach`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_log`
--
ALTER TABLE `login_log`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`uid`);

--
-- Indexes for table `operation_log`
--
ALTER TABLE `operation_log`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`uid`);

--
-- Indexes for table `recycle_bin`
--
ALTER TABLE `recycle_bin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rule`
--
ALTER TABLE `rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`identification`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `third_authorization`
--
ALTER TABLE `third_authorization`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`uid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `administrator`
--
ALTER TABLE `administrator`
  MODIFY `uid` int(8) NOT NULL AUTO_INCREMENT COMMENT '用户ID,主键', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `attribute`
--
ALTER TABLE `attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '属性ID', AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `attribute_attach`
--
ALTER TABLE `attribute_attach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品属性值ID', AUTO_INCREMENT=28;

--
-- 使用表AUTO_INCREMENT `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类ID', AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品ID';

--
-- 使用表AUTO_INCREMENT `goods_attach`
--
ALTER TABLE `goods_attach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `goods_attribute`
--
ALTER TABLE `goods_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `goods_attribute_attach`
--
ALTER TABLE `goods_attribute_attach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `group`
--
ALTER TABLE `group`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'ID,主键', AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `login_log`
--
ALTER TABLE `login_log`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'ID,主键';

--
-- 使用表AUTO_INCREMENT `operation_log`
--
ALTER TABLE `operation_log`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'ID,主键';

--
-- 使用表AUTO_INCREMENT `recycle_bin`
--
ALTER TABLE `recycle_bin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- 使用表AUTO_INCREMENT `rule`
--
ALTER TABLE `rule`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'ID, 主键', AUTO_INCREMENT=46;

--
-- 使用表AUTO_INCREMENT `third_authorization`
--
ALTER TABLE `third_authorization`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'ID,主键';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
