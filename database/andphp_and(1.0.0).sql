-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-03-09 07:04:34
-- 服务器版本： 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `andphp_and`
--

-- --------------------------------------------------------

--
-- 表的结构 `and_admin_user`
--

CREATE TABLE `and_admin_user` (
  `id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL DEFAULT '' COMMENT '用户名，登陆使用',
  `nickname` varchar(15) NOT NULL DEFAULT '' COMMENT '管理员昵称',
  `email` varchar(32) NOT NULL DEFAULT '' COMMENT '电子邮箱，登陆使用',
  `phone` char(11) NOT NULL DEFAULT '0' COMMENT '手机号码，登陆使用',
  `password` varchar(32) NOT NULL DEFAULT 'e10adc3949ba59abbe56e057f20f883e' COMMENT '用户密码',
  `thumb` int(10) NOT NULL DEFAULT '0' COMMENT '管理员头像',
  `login_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '登陆状态,0:pc,1:app',
  `login_code` varchar(32) NOT NULL DEFAULT '0' COMMENT '排他性登陆标识,token',
  `last_login_ip` varchar(16) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1启用，0禁用',
  `is_delete` tinyint(1) NOT NULL DEFAULT '1' COMMENT '删除状态:1正常,0已删除',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `salt` char(6) NOT NULL DEFAULT '0' COMMENT '密码加盐处理'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `and_admin_user`
--

INSERT INTO `and_admin_user` (`id`, `username`, `nickname`, `email`, `phone`, `password`, `thumb`, `login_status`, `login_code`, `last_login_ip`, `last_login_time`, `status`, `is_delete`, `create_time`, `salt`) VALUES
(1, 'admin', '大雄的_4MzHJo', '417170808@qq.com', '18580008000', '4c5ff6b4ab3d6cb2179f255e443f8729', 1, 0, '0', '127.0.0.1', 1520562471, 1, 0, 1520314868, '4MzHJo'),
(2, 'test', 'ceshi_AnIK1Z', 'ceshi@andphp.com', '18888888888', 'b0b85d3b1b9a687dfdbd666ea567726e', 2, 0, '0', '127.0.0.1', 1520337730, 1, 0, 1520326035, 'AnIK1Z'),
(3, 'ceshi', 'ceshi_9NrrLF', 'ceshi@andphp.cn', '18854554564', 'a3fe48588e0c18592460a8e08135831b', 2, 0, '0', '0', 0, 1, 0, 1520326830, '9NrrLF');

-- --------------------------------------------------------

--
-- 表的结构 `and_attachment`
--

CREATE TABLE `and_attachment` (
  `id` int(10) UNSIGNED NOT NULL,
  `module` char(15) NOT NULL DEFAULT '' COMMENT '所属模块',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `savename` varchar(255) NOT NULL DEFAULT '' COMMENT '保存文件名',
  `savepath` varchar(255) NOT NULL DEFAULT '' COMMENT '保存文件路径',
  `size` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文件大小',
  `ext` char(6) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mime` char(40) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `resolution` varchar(11) NOT NULL DEFAULT '' COMMENT '分辨率',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `location` int(1) NOT NULL DEFAULT '0' COMMENT '储存位置:0本地，1七牛云',
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '会员ID',
  `uploadip` char(15) NOT NULL DEFAULT '' COMMENT '上传IP',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未审核1已审核7不通过',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '上传时间',
  `admin_id` int(11) NOT NULL COMMENT '审核者id',
  `audit_time` int(11) NOT NULL COMMENT '审核时间',
  `use` varchar(200) DEFAULT '' COMMENT '用处',
  `download` int(11) NOT NULL DEFAULT '0' COMMENT '下载量'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='附件表' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `and_attachment`
--

INSERT INTO `and_attachment` (`id`, `module`, `name`, `savename`, `savepath`, `size`, `ext`, `mime`, `resolution`, `md5`, `sha1`, `location`, `user_id`, `uploadip`, `status`, `create_time`, `admin_id`, `audit_time`, `use`, `download`) VALUES
(1, 'admin', '{8319C9C1-378F-7A9C-C51A-C1266F29CFD4}.png', 'ecbd2f8dd06090b2336645d3b9f7720c.png', 'uploads/admin/admin_thumb/20180306/ecbd2f8dd06090b2336645d3b9f7720c.png', 36129, 'png', 'image/png', '', 'f2ab7eb781b316fc4560ea5922dbb7a9', '2d8a650806887569363249edd28228a9b3b1799e', 0, 1, '127.0.0.1', 1, 1520314866, 1, 1520314866, 'admin_thumb', 0),
(2, 'admin', '0cb9769c7bac400a8adc6412c8cd2451.jpg', '2663da766cf2163b9f4254542ccc142e.jpg', 'uploads/admin/admin_thumb/20180306/2663da766cf2163b9f4254542ccc142e.jpg', 11481, 'jpg', 'image/jpeg', '', '9eb296aac50b30b688776f1b8070ba09', 'bccd8755de266dcb5139bbc96034bbda1f2be6de', 0, 1, '127.0.0.1', 1, 1520315030, 1, 1520315030, 'admin_thumb', 0),
(3, 'admin', '123.png', 'fea3fbba5f988961b3f2dbe6f99db1ba.png', 'uploads/admin/admin_thumb/20180306/fea3fbba5f988961b3f2dbe6f99db1ba.png', 27183, 'png', 'image/png', '', 'f49196becef9db1e6d320596eb66dada', '287e9757e4c3c77d3427c0de88a7d4324100e50f', 0, 1, '127.0.0.1', 1, 1520315810, 1, 1520315810, 'admin_thumb', 0);

-- --------------------------------------------------------

--
-- 表的结构 `and_auth_group`
--

CREATE TABLE `and_auth_group` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `title` char(100) NOT NULL DEFAULT '',
  `intro` varchar(30) NOT NULL DEFAULT '' COMMENT '角色介绍',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1正常，0禁用',
  `rules` text NOT NULL COMMENT '权限规则ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组表';

--
-- 转存表中的数据 `and_auth_group`
--

INSERT INTO `and_auth_group` (`id`, `title`, `intro`, `status`, `rules`) VALUES
(1, '超级管理员', '超级管理员', 1, '9,24,23,8,22,21,20,7,17,19,18,6,16,5,15,4,14,3,13,61,60,53,31,30,29,28,12,59,58,52,27,26,25,2,11,10,45,44,46,47,48,55,54,51,50,49,1,62,43,42,41,40,39,38,37,36,35,34,33,57,56,32'),
(2, '内容管理员', '内容管理员', 1, '7,17,3,13,61,60,53,31,30,29,28,12,59,1,43');

-- --------------------------------------------------------

--
-- 表的结构 `and_auth_group_access`
--

CREATE TABLE `and_auth_group_access` (
  `admin_user_id` mediumint(8) UNSIGNED NOT NULL,
  `auth_group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组规则表';

--
-- 转存表中的数据 `and_auth_group_access`
--

INSERT INTO `and_auth_group_access` (`admin_user_id`, `auth_group_id`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- 表的结构 `and_auth_rule`
--

CREATE TABLE `and_auth_rule` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '规则名称',
  `title` varchar(20) NOT NULL,
  `description` varchar(50) NOT NULL DEFAULT '' COMMENT '描述',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT ' 	1权限+菜单2只作为菜单 ',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1显示；0隐藏 ',
  `pid` smallint(5) UNSIGNED NOT NULL COMMENT '父级ID',
  `icon` varchar(20) DEFAULT '' COMMENT '图标',
  `orders` int(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `condition` char(100) DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='规则表';

--
-- 转存表中的数据 `and_auth_rule`
--

INSERT INTO `and_auth_rule` (`id`, `name`, `title`, `description`, `type`, `status`, `pid`, `icon`, `orders`, `condition`) VALUES
(1, 'admin/SystemConfig/index', '系统管理', '', 2, 1, 0, 'fa-gears', 0, ''),
(2, 'admin/User/index', '会员管理', '', 2, 1, 0, 'fa-users', 0, ''),
(3, 'admin/Auth/index', '权限管理', '', 2, 1, 0, 'fa-sitemap 	', 0, ''),
(4, 'admin/Theme/index', '主题管理', '', 2, 1, 0, 'fa-desktop', 0, ''),
(5, 'admin/Module/index', '模块管理', '', 2, 1, 0, 'fa-cubes', 0, ''),
(6, 'admin/Plugins/index', '插件管理', '', 2, 2, 0, 'fa-sliders', 0, ''),
(7, 'admin/Log/index', '记录管理', '', 2, 1, 0, 'fa-book', 0, ''),
(8, 'admin/Databackup/index', '数据管理', '', 2, 1, 0, 'fa-pie-chart', 0, ''),
(9, 'admin/Expand/index', '扩展管理', '', 2, 1, 0, 'fa-wrench', 0, ''),
(10, 'admin/AdminUser/_list', '后台管理员', '', 1, 1, 2, '', 0, ''),
(11, 'admin/User/list', '前台会员', '', 1, 2, 2, '', 0, ''),
(12, 'admin/AuthRule/_list', '权限列表', '', 1, 1, 3, '', 0, ''),
(13, 'admin/AuthGroup/_list', '角色列表', '', 1, 1, 3, '', 0, ''),
(14, 'admin/Theme/_list', '主题列表', '', 1, 1, 4, '', 0, ''),
(15, 'admin/Module/_list', '模块列表', '', 1, 1, 5, '', 0, ''),
(16, 'admin/Plugins/_list', '插件列表', '', 1, 1, 6, '', 0, ''),
(17, 'admin/Log/login', '登录日志', '', 1, 1, 7, '', 0, ''),
(18, 'admin/Log/admin', '管理员操作', '', 1, 1, 7, '', 0, ''),
(19, 'admin/Log/user', '会员操作', '', 1, 2, 7, '', 0, ''),
(20, 'admin/File/_list', '资源文件', '', 1, 1, 8, '', 0, ''),
(21, 'admin/Database/_list', '数据库', '', 1, 1, 8, '', 0, ''),
(22, 'admin/Backup/_list', '备份管理', '', 1, 1, 8, '', 0, ''),
(23, 'admin/Doc/_list', '文档说明', '', 1, 1, 9, '', 0, ''),
(24, 'admin/FriendlyLink/_list', '友链申请', '', 1, 1, 9, '', 0, ''),
(25, 'admin/AuthRule/add', '添加权限节点', '', 1, 2, 12, '', 0, ''),
(26, 'admin/AuthRule/edit', '修改权限节点', '', 1, 1, 12, '', 0, ''),
(27, 'admin/AuthRule/delete', '删除权限节点', '', 1, 1, 12, '', 0, ''),
(28, 'admin/AuthGroup/add', '添加角色类', '', 1, 2, 13, '', 0, ''),
(29, 'admin/AuthGroup/edit', '修改角色类', '', 1, 2, 13, '', 0, ''),
(30, 'admin/AuthGroup/delete', '删除角色类', '', 1, 2, 13, '', 0, ''),
(31, 'admin/AuthGroup/edit_rule', '角色授权', '', 1, 2, 13, '', 0, ''),
(32, 'admin/AdminUser/edit_password', '修改密码', '', 1, 1, 1, '', 0, ''),
(33, 'admin/SystemConfig/_list', '全局设置', '', 1, 1, 1, '', 0, ''),
(34, 'admin/SystemConfig/site', '网站信息', '', 1, 1, 1, '', 0, ''),
(35, 'admin/SystemConfig/email', '邮箱配置', '', 1, 1, 1, '', 0, ''),
(36, 'admin/SystemConfig/sms', '短信配置', '', 1, 1, 1, '', 0, ''),
(37, 'admin/SystemConfig/images', '图片设置', '', 1, 1, 1, '', 0, ''),
(38, 'admin/SystemConfig/system', '系统配置', '', 1, 1, 1, '', 0, ''),
(39, 'admin/SystemConfig/add', '添加配置项', '', 1, 2, 1, '', 0, ''),
(40, 'admin/SystemConfig/delete', '删除配置项', '', 1, 2, 1, '', 0, ''),
(41, 'admin/SystemConfig/edit', '修改配置项', '', 1, 2, 1, '', 0, ''),
(42, 'admin/SyetemConfig/orders', '更新配置项排序', '', 1, 2, 1, '', 0, ''),
(43, 'admin/SystemConfig/update_value', '单点更新配置项数值', '列表数值实时修改', 1, 2, 1, '', 0, ''),
(44, 'admin/AdminUser/add', '添加管理员', '', 1, 2, 10, '', 0, ''),
(45, 'admin/AdminUser/edit', '修改管理员账户', '', 1, 2, 10, '', 0, ''),
(46, 'admin/AdminUser/delete', '删除管理员账户', '', 1, 2, 10, '', 0, ''),
(47, 'admin/AdminUser/update_status', '单点更新管理员状态值', '列表数值实时修改', 1, 2, 10, '', 0, ''),
(48, 'admin/AdminUser/enable', '批量启用管理员账户', '批量更新 启用账户', 1, 2, 10, '', 0, ''),
(49, 'admin/AdminUser/prohibit', '批量禁用管理员账户', '批量更新 禁用账户', 1, 2, 10, '', 0, ''),
(50, 'admin/AdminUser/delete_all', '批量删除管理员账户', '批量更新 删除账户', 1, 1, 10, '', 0, ''),
(51, 'admin/AdminUser/reset_password', '批量重置管理员账户密码 ', '', 1, 2, 10, '', 0, ''),
(52, 'admin/AuthRule/orders', '更新权限规则排序', '', 1, 2, 12, '', 0, ''),
(53, 'admin/AuthGroup/update_rule', '更新角色状态', '更新角色类状态 开启|禁止', 1, 1, 13, '', 0, ''),
(54, 'admin/AdminUser/save', '提交添加管理员', '', 1, 2, 10, '', 0, ''),
(55, 'admin/AdminUser/update', '提交修改管理员', '', 1, 2, 10, '', 0, ''),
(56, 'admin/SystemConfig/save', '提交添加配置项', '', 2, 2, 1, 'fa-gears', 0, ''),
(57, 'admin/SystemConfig/update', '提交修改配置项', '', 2, 2, 1, 'fa-gears', 0, ''),
(58, 'admin/AuthRule/save', '提交添加权限', '', 1, 2, 12, '', 0, ''),
(59, 'admin/AuthRule/update', '提交修改权限', '', 1, 2, 12, '', 0, ''),
(60, 'admin/AuthGroup/save', '提交添加角色', '', 1, 2, 13, '', 0, ''),
(61, 'admin/AuthGroup/update', '提交修改角色', '', 1, 1, 13, '', 0, ''),
(62, 'admin/SystemConfig/home', 'Home配置', '', 2, 1, 1, 'fa-gears', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `and_log`
--

CREATE TABLE `and_log` (
  `id` int(10) NOT NULL,
  `module` varchar(20) NOT NULL DEFAULT '' COMMENT '模块',
  `controller` varchar(20) NOT NULL DEFAULT '' COMMENT '控制器',
  `action` varchar(20) NOT NULL DEFAULT '' COMMENT '方法',
  `describe` varchar(50) NOT NULL DEFAULT '' COMMENT '更新描述',
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `username` varchar(25) NOT NULL DEFAULT '' COMMENT '账号名称',
  `add_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '操作IP',
  `city` varchar(10) NOT NULL DEFAULT '' COMMENT '城市',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '操作时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `and_module`
--

CREATE TABLE `and_module` (
  `id` int(10) NOT NULL COMMENT '主题ID',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '模块',
  `is_system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否系统模块',
  `title` varchar(20) NOT NULL DEFAULT '系统模块' COMMENT '模块名',
  `intro` varchar(100) NOT NULL DEFAULT '' COMMENT '功能介绍',
  `version` varchar(20) NOT NULL DEFAULT '1.0.0' COMMENT '版本',
  `author` varchar(20) NOT NULL DEFAULT 'AndPHP_author' COMMENT '作者',
  `money` int(11) NOT NULL DEFAULT '0' COMMENT '价格，0：免费',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否默认路由：0否，1是',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态，1：启用，0：未启用',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `and_module`
--

INSERT INTO `and_module` (`id`, `name`, `is_system`, `title`, `intro`, `version`, `author`, `money`, `is_default`, `status`, `create_time`) VALUES
(1, 'admin', 1, '系统模块', '', '1.0.0', 'AndPHP_author', 0, 0, 0, 1520516142),
(2, 'common', 1, '系统模块', '', '1.0.0', 'AndPHP_author', 0, 0, 0, 1520516142),
(3, 'error', 1, '系统模块', '', '1.0.0', 'AndPHP_author', 0, 0, 0, 1520516142),
(4, 'home', 0, '默认门户', '', '1.0.0', 'AndPHP_author', 0, 1, 1, 1520516142),
(5, 'sns', 0, '社区模块', '社区互动', '1.0.0', 'AndPHP_author', 0, 0, 1, 1520516142),
(6, 'shop', 0, '商城模块', '网络购物', '1.0.0', 'AndPHP_author', 0, 0, 1, 1520516262),
(7, 'user', 0, '系统模块', '', '1.0.0', 'AndPHP_author', 0, 0, 1, 1520573886);

-- --------------------------------------------------------

--
-- 表的结构 `and_system_config`
--

CREATE TABLE `and_system_config` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(32) NOT NULL,
  `group` varchar(15) NOT NULL DEFAULT '' COMMENT '组类',
  `vari` varchar(32) NOT NULL,
  `value` text NOT NULL,
  `type` enum('text','textarea','file','checkbox','radio','select','checker','array','keyvalue','password','color') NOT NULL,
  `options` text NOT NULL,
  `info` text NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `and_system_config`
--

INSERT INTO `and_system_config` (`id`, `title`, `group`, `vari`, `value`, `type`, `options`, `info`, `orders`) VALUES
(1, '网站名称', 'site', 'site_title', 'AndPHPd1', 'text', '', '', 0),
(2, '网站关键字', 'site', 'site_keywords', '中国21', 'text', '', '', 0),
(3, '网站描述', 'site', 'site_description', 'dsf', 'textarea', '', '', 0),
(4, '版权描述', 'site', 'site_copyright', '', 'text', '', '', 0),
(5, '统计代码', 'site', 'site_code', 'fasdd001', 'textarea', '', '', 0),
(6, '公司名称', 'site', 'corp_title', 'wuyuzhong1', 'text', '', '', 0),
(7, '公司电话', 'site', 'tel', '公司电话', 'text', '', '', 0),
(8, '公司邮箱', 'site', 'email', '公司邮箱', 'text', '', '', 0),
(9, '公司地址', 'site', 'address', '公司地址', 'text', '', '', 0),
(10, 'ICP备案', 'site', 'icp', '蜀ICP备xxxxxx号', 'text', '', '', 0),
(11, '公众号二维码', 'site', 'public_qrcode', '', 'file', '', '', 0),
(12, '开启审核', 'system', 'is_verify', '1', 'checker', '', '如果开启，前台数据必须审核通过以后才能显示', 0),
(13, '审核默认值', 'system', 'default_verify', '1', 'radio', '{\"1\":\"默认审核\",\"0\":\"默认不审核\"}', '', 0),
(14, '注册邮箱认证', 'system', 'is_email_verify', '0', 'checker', '', '如果勾选，注册的时候必须通过邮箱认证', 0),
(15, '全局分页条数', 'system', 'list_count', '15', 'text', '', '', 0),
(16, '后台分页条数', 'system', 'admin_list_count', '15', 'text', '', '', 0),
(17, '后台列表缓存', 'system', 'is_admin_cache', '0', 'checker', '', '', 0),
(18, '留言是否显示列表', 'system', 'is_feedback_list', '1', 'checker', '', '', 0),
(19, '开启栏目广告位', 'system', 'is_menu_position', '1', 'checker', '', '开启以后不同栏目可以单独创建对应栏目广告位', 0),
(20, '是否开启Trace', 'system', 'is_trace', '1', 'checker', '', '建议程序员操作', 0),
(21, '是否开启Debug', 'system', 'is_debug', '1', 'checker', '', '网站上线后不建议开启；建议程序员操作', 0),
(22, '图片关联模型', 'images', 'use_picture_model', '', 'checkbox', '{\"Album\":\"图集\",\"Product\":\"产品\",\"Article\":\"文章\"}', '', 0),
(23, '全局缩略图类型', 'images', 'thumb_method', '1', 'radio', '{\"1\":\"系统默认\",\"2\":\"等比例缩放\",\"3\":\"缩放后填充\",\"4\":\"居中裁剪\",\"5\":\"左上角裁剪\",\"6\":\"右下角裁剪\",\"7\":\"固定尺寸缩放\"}', '', 0),
(24, '全局缩略图宽度', 'images', 'thumb_width', '400', 'text', '', '请填写整数，单位：像素', 0),
(25, '全局缩略图高度', 'images', 'thumb_height', '300', 'text', '', '请填写整数，单位：像素', 0),
(26, '全局默认图片', 'images', 'default_image', '', 'file', '', '适用于列表页必须图片时，而又没有上传图片的数据', 0),
(27, '开启图片水印', 'images', 'is_water', '0', 'checker', '', '', 0),
(28, '水印模型', 'images', 'water_model', '', 'checkbox', '{\"Article\":\"文章\",\"Product\":\"产品\",\"Album\":\"图集\",\"AlbumPicture\":\"图集图片\",\"Ad\":\"广告\",\"Download\":\"下载\",\"Page\":\"单页\"}', '', 0),
(29, '水印类型', 'images', 'water_type', 'image', 'radio', '{\"text\":\"文字水印\",\"image\":\"图片水印\"}', '', 0),
(30, '水印位置', 'images', 'water_location', '9', 'radio', '{\"1\":\"左上\",\"2\":\"上居中\",\"3\":\"右上\",\"4\":\"左中\",\"5\":\"居中\",\"6\":\"右中\",\"7\":\"左下\",\"8\":\"下居中\",\"9\":\"右下\"}', '', 0),
(31, '水印图片', 'images', 'water_image', '', 'file', '', '', 0),
(32, '水印图片透明度', 'images', 'water_image_opacity', '100', 'text', '', '填写数值，范围1~100，100表示不透明', 0),
(33, '水印文字', 'images', 'water_text', '', 'text', '', '', 0),
(34, '水印文字大小', 'images', 'water_text_size', '20', 'text', '', '', 0),
(35, '水印文字颜色', 'images', 'water_text_color', '#ffffff', 'color', '', '', 0),
(36, '服务器地址', 'email', 'email_host', 'smtp.163.com', 'text', '', '', 0),
(37, '发件邮箱账号', 'email', 'email_from', '', 'text', '', '应该和服务器地址对用类型', 0),
(38, '发件账号密码', 'email', 'email_password', '', 'password', '', '', 0),
(39, '发件人名称', 'email', 'email_fromname', 'AndPHP', 'text', '', '', 0),
(40, 'accessKeyId', 'sms', 'sms_keyid', '', 'text', '', '填写阿里大于短信接口accessKeyId', 0),
(41, 'accessKeySecret', 'sms', 'sms_keysecret', '', 'text', '', '填写阿里大于短信接口accessKeySecret', 0),
(42, 'appid', 'keyword', 'yt_appid', '', 'text', '', 'http://open.youtu.qq.com/申请', 0),
(43, 'secretId', 'keyword', 'yt_secretid', '', 'text', '', '', 0),
(44, 'secretKey', 'keyword', 'yt_secretkey', '', 'text', '', '', 0),
(47, '储存位置', 'system', 'location', '0是个', 'text', '{\"0\":\"本地\"，\"1\":\"七牛云\"}', '文件、图片上传储存位置', 0),
(46, '文件上传类型', 'syetem', 'file_type', 'jpg,png,gif,mp4,zip,jpeg', 'text', '', '文件上传类型', 0),
(45, '文件上传大小', 'syetem', 'file_size', '20', 'text', '', '单位：M', 0),
(50, '默认账户密码', 'system', 'default_password', '111111', 'text', '', '设置初始值、重置密码', 0),
(51, 'Home主题开关', 'home', 'home_theme_status', '0', 'checker', '{\"0\":\"关闭主题\",\"1\":\"开启主题\"}', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `and_theme`
--

CREATE TABLE `and_theme` (
  `id` int(10) NOT NULL COMMENT '主题ID',
  `module` varchar(20) NOT NULL DEFAULT '' COMMENT '所属模块',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '主题名（英文，唯一）',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '主题名，别名',
  `version` varchar(20) NOT NULL DEFAULT '1.0.0' COMMENT '版本',
  `author` varchar(20) NOT NULL DEFAULT '' COMMENT '作者',
  `money` int(11) NOT NULL DEFAULT '0' COMMENT '价格，0：免费',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态，1：启用，0：未启用',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `and_theme`
--

INSERT INTO `and_theme` (`id`, `module`, `name`, `title`, `version`, `author`, `money`, `status`, `create_time`) VALUES
(1, 'home', 'default', '默认主题', '1.0.0', '静香', 0, 0, NULL),
(2, 'sms', 'blue', '', '1.0.0', '', 50, 1, NULL),
(11, 'home', 'bule', '蓝色妖姬', '1.0.1', '蓝色妖姬', 15, 0, 1520425765);

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `and_admin_user`
--
ALTER TABLE `and_admin_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`,`phone`);

--
-- Indexes for table `and_attachment`
--
ALTER TABLE `and_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `and_auth_group`
--
ALTER TABLE `and_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `and_auth_group_access`
--
ALTER TABLE `and_auth_group_access`
  ADD KEY `admin_user_id` (`admin_user_id`),
  ADD KEY `auth_group_id` (`auth_group_id`);

--
-- Indexes for table `and_auth_rule`
--
ALTER TABLE `and_auth_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE;

--
-- Indexes for table `and_log`
--
ALTER TABLE `and_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `and_module`
--
ALTER TABLE `and_module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `and_system_config`
--
ALTER TABLE `and_system_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vari` (`vari`),
  ADD KEY `keyword` (`group`) USING BTREE;

--
-- Indexes for table `and_theme`
--
ALTER TABLE `and_theme`
  ADD PRIMARY KEY (`id`);


--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `and_admin_user`
--
ALTER TABLE `and_admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `and_attachment`
--
ALTER TABLE `and_attachment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `and_auth_group`
--
ALTER TABLE `and_auth_group`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `and_auth_rule`
--
ALTER TABLE `and_auth_rule`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- 使用表AUTO_INCREMENT `and_log`
--
ALTER TABLE `and_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用表AUTO_INCREMENT `and_module`
--
ALTER TABLE `and_module`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主题ID', AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `and_system_config`
--
ALTER TABLE `and_system_config`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- 使用表AUTO_INCREMENT `and_theme`
--
ALTER TABLE `and_theme`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主题ID', AUTO_INCREMENT=12;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
