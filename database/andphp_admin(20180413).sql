-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-04-13 14:25:43
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
-- Database: `andphp_admin`
--

-- --------------------------------------------------------

--
-- 表的结构 `and_addons`
--

CREATE TABLE `and_addons` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '主键',
  `name` varchar(40) NOT NULL COMMENT '插件名或标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text COMMENT '插件描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `config` text COMMENT '配置',
  `author` varchar(40) DEFAULT '' COMMENT '作者',
  `version` varchar(20) DEFAULT '' COMMENT '版本号',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '安装时间',
  `has_adminlist` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否有后台列表'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='插件表';

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
(1, 'admin', '大雄的_4MzHJo', '417170808@qq.com', '18580008000', '4c5ff6b4ab3d6cb2179f255e443f8729', 1, 0, '0', '127.0.0.1', 1523617329, 1, 0, 1520314868, '4MzHJo'),
(2, 'test', 'ceshi_AnIK1Z', 'ceshi@andphp.com', '18888888888', 'b0b85d3b1b9a687dfdbd666ea567726e', 2, 0, '0', '127.0.0.1', 1520337730, 0, 0, 1520326035, 'AnIK1Z'),
(3, 'ceshi', 'ceshi', 'ceshi@andphp.cn', '18854554564', 'a3fe48588e0c18592460a8e08135831b', 2, 0, '0', '0', 0, 1, 1, 1520326830, '9NrrLF');

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
(3, 'admin', '123.png', 'fea3fbba5f988961b3f2dbe6f99db1ba.png', 'uploads/admin/admin_thumb/20180306/fea3fbba5f988961b3f2dbe6f99db1ba.png', 27183, 'png', 'image/png', '', 'f49196becef9db1e6d320596eb66dada', '287e9757e4c3c77d3427c0de88a7d4324100e50f', 0, 1, '127.0.0.1', 1, 1520315810, 1, 1520315810, 'admin_thumb', 0),
(4, 'admin', '71e422f0ccd9473bb042c1406247d694.jpg', '8f7fa9fb7b49dad6e9541e841310e2f8.jpg', 'uploads/admin/admin_thumb/20180320/8f7fa9fb7b49dad6e9541e841310e2f8.jpg', 13100, 'jpg', 'image/jpeg', '', 'fc42732cf6b74b4201284382764c5a0f', '42156e79c2afadc4b9213ec82cff75454405400b', 0, 0, '127.0.0.1', 1, 1521550262, 0, 1521550262, 'admin_thumb', 0),
(5, 'admin', '1.png', 'b71ad13dbefcdafb1f541a8e09f4d283.png', 'uploads/admin/admin_thumb/20180324/b71ad13dbefcdafb1f541a8e09f4d283.png', 75466, 'png', 'image/png', '', '2e40ea794a1876447a314e2d2dd36a27', '644badf95603aea8a3a67947a91bd22814138f92', 0, 1, '127.0.0.1', 1, 1521861621, 1, 1521861621, 'admin_thumb', 0),
(6, 'admin', '{8319C9C1-378F-7A9C-C51A-C1266F29CFD.png', '6c815024314b1d1005648dde92aef7f1.png', 'uploads/admin/admin_thumb/20180326/6c815024314b1d1005648dde92aef7f1.png', 30478, 'png', 'image/png', '', '9352275b8478b11e0db39c8bf0f379cf', 'c2859ecd28a4b4d21eb0e2f1bbef38465e0b448a', 0, 0, '127.0.0.1', 1, 1522031209, 0, 1522031209, 'admin_thumb', 0),
(7, 'admin', 'aca96460196739.5a416110dd3fa.jpg', 'b0ba93a5909bbc72fb457e105c5ff113.jpg', 'uploads/admin/admin_thumb/20180326/b0ba93a5909bbc72fb457e105c5ff113.jpg', 331792, 'jpg', 'image/jpeg', '', '3a8435e0428be709b8c45b79a6c45dfb', 'd1896a407b1ec9e3007f7a1919850304c05979e0', 0, 0, '127.0.0.1', 1, 1522031492, 0, 1522031492, 'admin_thumb', 0),
(8, 'admin', 'andphp_null_bg.png', 'cb1c05393b31bd72bc90b6d6af56db95.png', 'uploads/admin/admin_thumb/20180326/cb1c05393b31bd72bc90b6d6af56db95.png', 42513, 'png', 'image/png', '', '46ec29445e5322abe7a5681e056b4b01', 'dc35f1a30d828b53863e7f5fe714af018ce60c09', 0, 0, '127.0.0.1', 1, 1522031525, 0, 1522031525, 'admin_thumb', 0),
(9, 'admin', 'c5722e60196739.5a416110dcf46.jpg', '20f60ae59e23c3e8e3e984ceaf76d37d.jpg', 'uploads/admin/admin_thumb/20180326/20f60ae59e23c3e8e3e984ceaf76d37d.jpg', 639735, 'jpg', 'image/jpeg', '', '0673e65ae5bef63d8101e8e1bad73cfc', '2d8db1e58b54b0ec9e3dcd1e3f7d08583d7da069', 0, 0, '127.0.0.1', 1, 1522031617, 0, 1522031617, 'admin_thumb', 0),
(10, 'admin', 'timg.jpg', 'a28b062b496be9b1d0b1272a79428012.jpg', 'uploads/admin/admin_thumb/20180326/a28b062b496be9b1d0b1272a79428012.jpg', 45622, 'jpg', 'image/jpeg', '', 'b819adb9cf8cd71083cbc5781ad651b8', 'ab19b7b43b8aa20eda98d6f8257568f0ddb25c2f', 0, 0, '127.0.0.1', 1, 1522032079, 0, 1522032079, 'admin_thumb', 0),
(11, 'admin', 'CgqKkViljduALjzzAABSC3o8uuw060.jpg', '271b34846e1620cce3446d733f334acd.jpg', 'uploads/admin/admin_thumb/20180326/271b34846e1620cce3446d733f334acd.jpg', 8287, 'jpg', 'image/jpeg', '', 'def6883837998233622d348ac7edb9ac', 'a18fe52102adac34a0cb3ac1f060828b84094aee', 0, 0, '127.0.0.1', 1, 1522032310, 0, 1522032310, 'admin_thumb', 0),
(12, 'admin', 'timgnu.jpg', '6325239f1e81ec188c22700c3d94ff99.jpg', 'uploads/admin/admin_thumb/20180326/6325239f1e81ec188c22700c3d94ff99.jpg', 48992, 'jpg', 'image/jpeg', '', '907216da8db5fb957cf5c90a90e73265', '9f159c9cafd5d54f24205f0411029d6b242bd6bc', 0, 0, '127.0.0.1', 1, 1522032396, 0, 1522032396, 'admin_thumb', 0),
(13, 'admin', 'TIM图片20180311112846.png', '94e409820ee6963fa89aafb0d45878ce.png', 'uploads/admin/admin_thumb/20180326/94e409820ee6963fa89aafb0d45878ce.png', 8794, 'png', 'image/png', '', '77a67758bebc644dbb2830311ed2a48a', 'a028727624d62cc30234e4c2718b76cdb7dbc365', 0, 0, '127.0.0.1', 1, 1522033180, 0, 1522033180, 'admin_thumb', 0),
(14, 'admin', 'u=221570527,3176719618&fm=27&gp=0.jpg', '71ff2e7434ba3d38e6330251bb1747c3.jpg', 'uploads/admin/admin_thumb/20180326/71ff2e7434ba3d38e6330251bb1747c3.jpg', 22189, 'jpg', 'image/jpeg', '', '06bb5291f600a592cddc769a82689c3c', 'ff27fa221c16370658ae6a6d1b60b3fa34b92927', 0, 0, '127.0.0.1', 1, 1522033290, 0, 1522033290, 'admin_thumb', 0),
(15, 'admin', 'veer-136233807.jpg', '5c30049a0109506a54d6e49ca96d37f6.jpg', 'uploads/admin/admin_thumb/20180326/5c30049a0109506a54d6e49ca96d37f6.jpg', 67750, 'jpg', 'image/jpeg', '', '27dd1c6e8395659481024863e284d6f2', '0ea5bc98a1318726cc9f6a0842441a93f05fc32f', 0, 0, '127.0.0.1', 1, 1522033311, 0, 1522033311, 'admin_thumb', 0),
(16, 'admin', 'u=1963661104,1554223221&fm=27&gp=0.jpg.gif', '58fa5645424ca0594519b46d330b7b71.gif', 'uploads/admin/admin_thumb/20180326/58fa5645424ca0594519b46d330b7b71.gif', 3165, 'gif', 'image/gif', '', 'da138fb03d728d5501b09d6150defa1c', '8ffeb1a12e001f49e9e96d12cdb28020dd601a78', 0, 0, '127.0.0.1', 1, 1522033377, 0, 1522033377, 'admin_thumb', 0),
(17, 'admin', 'u=1476338015,3280733362&fm=27&gp=0.jpg', '480237bd0a3b7e515333379e8254a31e.jpg', 'uploads/admin/admin_thumb/20180326/480237bd0a3b7e515333379e8254a31e.jpg', 7665, 'jpg', 'image/jpeg', '', 'd698c5e4be8147b4c7691d7c8263ddbf', '92f1af3ff7a543d3e757c53cc9430bba7b0c3297', 0, 0, '127.0.0.1', 1, 1522033406, 0, 1522033406, 'admin_thumb', 0),
(18, 'admin', 'TIM图片20180209180249.png', 'd3dd12d3cf9eeeb865f2e61e9daef6a2.png', 'uploads/admin/admin_thumb/20180326/d3dd12d3cf9eeeb865f2e61e9daef6a2.png', 8674, 'png', 'image/png', '', '9c013fa9cf2c6dfd8d30e7af0d06a1da', '569fabf7a377da09ff0a1c8ad754ed62584c00bc', 0, 0, '127.0.0.1', 1, 1522033606, 0, 1522033606, 'admin_thumb', 0),
(19, 'admin', '8188925006_1129953838.png', '7226631f12dafaa399e8a12214266f5d.png', 'uploads/admin/admin_thumb/20180330/7226631f12dafaa399e8a12214266f5d.png', 32666, 'png', 'image/png', '', '06a151b52ece24ec51bfd1f0dcf688dc', 'b5ce0200f07be891758c6c1a7cd08e0c6f98cab5', 0, 0, '127.0.0.1', 1, 1522390100, 0, 1522390100, 'admin_thumb', 0),
(20, 'admin', 'bluesky.jpg', '13b11f5f28c6847571082a2a5b98cc8c.jpg', 'uploads/admin/admin_thumb/20180330/13b11f5f28c6847571082a2a5b98cc8c.jpg', 863211, 'jpg', 'image/jpeg', '', 'f87fa30e9c1e32ee2bb38111d9cec571', '53e34fc39063cb3816689d0697f163d50d990aad', 0, 0, '127.0.0.1', 1, 1522390120, 0, 1522390120, 'admin_thumb', 0),
(21, 'admin', 'TIM图片20180329215054.png', '4ea78cc49b1753b96a27354a0e696ef7.png', 'uploads/admin/admin_thumb/20180330/4ea78cc49b1753b96a27354a0e696ef7.png', 79115, 'png', 'image/png', '', 'f7bfe3eb655a73a59db9a8b8f644b3fd', 'a5ec6e2487d06c2305b401e23a4e2821c0bd89ad', 0, 0, '127.0.0.1', 1, 1522390131, 0, 1522390131, 'admin_thumb', 0),
(22, 'admin', 'IMG_7504.JPG', '742ed02b0dcc0f1923144340fb966d91.JPG', 'uploads/admin/admin_thumb/20180330/742ed02b0dcc0f1923144340fb966d91.JPG', 83646, 'JPG', 'image/jpeg', '', '567a7b475a19a053d744ccc4d01f41e4', 'c8bd5171f8268febb631840a8b5d701e12b6f9cf', 0, 0, '127.0.0.1', 1, 1522390963, 0, 1522390963, 'admin_thumb', 0),
(23, 'admin', 'TIM图片20180329195942.png', '98a2b33a8e9ed59f2f37c8c0cc7b7b57.png', 'uploads/admin/admin_thumb/20180330/98a2b33a8e9ed59f2f37c8c0cc7b7b57.png', 288817, 'png', 'image/png', '', '50e54e5fff17aa8282c68d9c844d8a5f', 'a218b2b8c2f75f6e8851109aa42bf6566772d17e', 0, 0, '127.0.0.1', 1, 1522390972, 0, 1522390972, 'admin_thumb', 0),
(24, 'admin', '6.png', '8639d2e4dafd7934accbc713adf4ee84.png', 'uploads/admin/admin_thumb/20180330/8639d2e4dafd7934accbc713adf4ee84.png', 217444, 'png', 'image/png', '', '6ada02b051276b458b4815341bce7508', '4cf36f6f41d6bd3a3da256e68e0ec9283dcf1496', 0, 0, '127.0.0.1', 1, 1522391007, 0, 1522391007, 'admin_thumb', 0);

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
(1, '超级管理员', '超级管理员', 1, '74,85,86,87,88,75,76,9,24,23,64,65,66,80,84,79,78,67,81,82,83,68,69,70,8,21,22,20,7,17,19,18,6,16,5,15,4,14,71,73,72,77,3,13,60,61,53,28,31,30,29,12,58,59,52,25,26,27,2,11,10,55,54,44,45,46,47,48,49,50,51,1,43,56,57,35,36,37,38,39,40,41,42,34,33,32'),
(2, '测试管理员', '测试管理员', 1, '7,17,3,13,61,60,53,31,30,29,28,12,59,1,43');

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
(3, 2),
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
  `group_id` int(10) NOT NULL DEFAULT '1' COMMENT '分类ID',
  `icon` varchar(20) DEFAULT '' COMMENT '图标',
  `orders` int(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `condition` char(100) DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='规则表';

--
-- 转存表中的数据 `and_auth_rule`
--

INSERT INTO `and_auth_rule` (`id`, `name`, `title`, `description`, `type`, `status`, `pid`, `group_id`, `icon`, `orders`, `condition`) VALUES
(1, 'admin/SystemConfig/index', '系统管理', '', 2, 1, 0, 1, 'fa-gears', 99, ''),
(2, 'admin/AdminUser/index', '团队管理', '', 2, 1, 0, 3, 'fa-users', 98, ''),
(3, 'admin/Auth/index', '权限管理', '', 2, 1, 0, 1, 'fa-sitemap 	', 0, ''),
(4, 'admin/Theme/index', '主题管理', '', 2, 1, 0, 2, 'fa-desktop', 0, ''),
(5, 'admin/Module/index', '模块管理', '', 2, 1, 0, 1, 'fa-cubes', 95, ''),
(6, 'admin/Plugins/index', '插件管理', '', 2, 2, 0, 1, 'fa-sliders', 94, ''),
(7, 'admin/Log/index', '记录管理', '', 2, 1, 0, 1, 'fa-book', 93, ''),
(8, 'admin/Databackup/index', '数据管理', '', 2, 1, 0, 1, 'fa-pie-chart', 92, ''),
(9, 'admin/Expand/index', '扩展管理', '', 2, 1, 0, 1, 'fa-wrench', 0, ''),
(10, 'admin/AdminUser/_list', '团队成员', '', 1, 1, 2, 3, '', 0, ''),
(11, 'admin/User/list', '前台会员', '', 1, 1, 2, 1, '', 0, ''),
(12, 'admin/AuthRule/_list', '权限列表', '', 1, 1, 3, 1, '', 0, ''),
(13, 'admin/AuthGroup/_list', '角色列表', '', 1, 1, 3, 1, '', 0, ''),
(14, 'admin/Theme/_list', '主题列表', '', 1, 1, 4, 1, '', 0, ''),
(15, 'admin/Module/_list', '模块列表', '', 1, 1, 5, 1, '', 0, ''),
(16, 'admin/Plugins/_list', '插件列表', '', 1, 1, 6, 1, '', 0, ''),
(17, 'admin/Log/login', '登录日志', '', 1, 1, 7, 1, '', 0, ''),
(18, 'admin/Log/admin', '管理员操作', '', 1, 1, 7, 1, '', 0, ''),
(19, 'admin/Log/user', '会员操作', '', 1, 1, 7, 1, '', 0, ''),
(20, 'admin/File/_list', '资源文件', '', 1, 1, 8, 1, '', 0, ''),
(21, 'admin/Database/_list', '数据库', '', 1, 1, 8, 1, '', 0, ''),
(22, 'admin/Backup/_list', '备份管理', '', 1, 1, 8, 1, '', 0, ''),
(23, 'admin/Doc/_list', '文档说明', '', 1, 1, 9, 1, '', 0, ''),
(24, 'admin/FriendlyLink/_list', '友链申请', '', 1, 1, 9, 1, '', 0, ''),
(25, 'admin/AuthRule/add', '添加权限节点', '', 1, 2, 12, 1, '', 0, ''),
(26, 'admin/AuthRule/edit', '修改权限节点', '', 1, 1, 12, 1, '', 0, ''),
(27, 'admin/AuthRule/delete', '删除权限节点', '', 1, 1, 12, 1, '', 0, ''),
(28, 'admin/AuthGroup/add', '添加角色类', '', 1, 2, 13, 1, '', 0, ''),
(29, 'admin/AuthGroup/edit', '修改角色类', '', 1, 2, 13, 1, '', 0, ''),
(30, 'admin/AuthGroup/delete', '删除角色类', '', 1, 2, 13, 1, '', 0, ''),
(31, 'admin/AuthGroup/edit_rule', '角色授权', '', 1, 2, 13, 1, '', 0, ''),
(32, 'admin/AdminUser/edit_password', '修改密码', '', 1, 1, 1, 1, '', 0, ''),
(33, 'admin/SystemConfig/_list', '全局设置', '', 1, 1, 1, 1, '', 0, ''),
(34, 'admin/SystemConfig/site', '网站信息', '', 1, 1, 1, 1, '', 0, ''),
(35, 'admin/SystemConfig/email', '邮箱配置', '', 1, 1, 1, 1, '', 0, ''),
(36, 'admin/SystemConfig/sms', '短信配置', '', 1, 1, 1, 1, '', 0, ''),
(37, 'admin/SystemConfig/images', '图片设置', '', 1, 1, 1, 1, '', 0, ''),
(38, 'admin/SystemConfig/system', '系统配置', '', 1, 1, 1, 1, '', 0, ''),
(39, 'admin/SystemConfig/add', '添加配置项', '', 1, 2, 1, 1, '', 0, ''),
(40, 'admin/SystemConfig/delete', '删除配置项', '', 1, 2, 1, 1, '', 0, ''),
(41, 'admin/SystemConfig/edit', '修改配置项', '', 1, 2, 1, 1, '', 0, ''),
(42, 'admin/SyetemConfig/orders', '更新配置项排序', '', 1, 2, 1, 1, '', 0, ''),
(43, 'admin/SystemConfig/update_value', '单点更新配置项数值', '列表数值实时修改', 1, 2, 1, 1, '', 0, ''),
(44, 'admin/AdminUser/add', '添加管理员', '', 1, 2, 10, 3, '', 0, ''),
(45, 'admin/AdminUser/edit', '修改管理员账户', '', 1, 2, 10, 1, '', 0, ''),
(46, 'admin/AdminUser/delete', '删除管理员账户', '', 1, 2, 10, 1, '', 0, ''),
(47, 'admin/AdminUser/update_status', '单点更新管理员状态值', '列表数值实时修改', 1, 2, 10, 3, '', 0, ''),
(48, 'admin/AdminUser/enable', '批量启用管理员账户', '批量更新 启用账户', 1, 2, 10, 1, '', 0, ''),
(49, 'admin/AdminUser/prohibit', '批量禁用管理员账户', '批量更新 禁用账户', 1, 2, 10, 1, '', 0, ''),
(50, 'admin/AdminUser/delete_all', '批量删除管理员账户', '批量更新 删除账户', 1, 1, 10, 1, '', 0, ''),
(51, 'admin/AdminUser/reset_password', '批量重置管理员账户密码 ', '', 1, 2, 10, 1, '', 0, ''),
(52, 'admin/AuthRule/orders', '更新权限规则排序', '', 1, 2, 12, 1, '', 0, ''),
(53, 'admin/AuthGroup/update_rule', '更新角色状态', '更新角色类状态 开启|禁止', 1, 1, 13, 1, '', 0, ''),
(54, 'admin/AdminUser/save', '提交添加管理员', '', 1, 2, 10, 1, '', 0, ''),
(55, 'admin/AdminUser/update', '提交修改管理员', '', 1, 2, 10, 1, '', 0, ''),
(56, 'admin/SystemConfig/save', '提交添加配置项', '', 2, 2, 1, 1, 'fa-gears', 0, ''),
(57, 'admin/SystemConfig/update', '提交修改配置项', '', 2, 2, 1, 1, 'fa-gears', 0, ''),
(58, 'admin/AuthRule/save', '提交添加权限', '', 1, 2, 12, 1, '', 0, ''),
(59, 'admin/AuthRule/update', '提交修改权限', '', 1, 2, 12, 1, '', 0, ''),
(60, 'admin/AuthGroup/save', '提交添加角色', '', 1, 2, 13, 1, '', 0, ''),
(61, 'admin/AuthGroup/update', '提交修改角色', '', 1, 1, 13, 1, '', 0, ''),
(73, 'admin/nav/forum', '论坛导航', '', 1, 1, 71, 1, 'fa-forumbee', 0, ''),
(72, 'admin/nav/home', '门户导航', '', 1, 1, 71, 1, 'fa-link', 0, ''),
(71, 'admin/nav/index', '导航管理', '', 1, 1, 0, 2, 'fa-link', 0, ''),
(64, 'admin/User/index', '会员管理', '', 1, 1, 0, 3, 'fa-address-card ', 0, ''),
(65, 'admin/User/_list', '会员列表', '', 1, 1, 64, 1, 'fa-address-book', 0, ''),
(66, 'admin/User/config', '相关配置', '', 1, 1, 64, 1, 'fa-address-card ', 0, ''),
(67, 'admin/User/star', '会员职称', '', 1, 1, 64, 1, ' fa-graduation-cap', 0, ''),
(68, 'admin/User/policy', '积分策略', '', 1, 1, 64, 1, '', 0, ''),
(69, 'admin/User/audit', '资料审核', '', 1, 1, 64, 1, ' fa-clipboard', 0, ''),
(70, 'admin/User/send', '发送消息', '', 1, 1, 64, 1, 'fa-paper-plane', 0, ''),
(74, 'admin/forum/index', '论坛管理', '', 1, 1, 0, 1, 'fa-comments', 0, ''),
(75, 'admin/home/index', '门面管理', '', 1, 1, 0, 4, 'fa-home', 0, ''),
(76, 'admin/mall/index', '商城管理', '', 1, 1, 0, 6, 'fa-shopping-cart', 0, ''),
(77, 'admin/nav/user', '会员导航', '', 1, 1, 71, 1, 'fa-user', 0, ''),
(78, 'admin/User/config_register', '注册配置', '', 1, 1, 66, 1, 'fa-address-card ', 0, ''),
(79, 'admin/User/config_score', '积分配置', '', 1, 1, 66, 1, 'fa-address-card ', 0, ''),
(80, 'admin/User/config_policy', '策略配置', '', 1, 1, 66, 1, 'fa-address-card ', 0, ''),
(81, 'admin/User/star_grade', '积分荣耀等级', '', 1, 1, 67, 1, ' fa-graduation-cap', 0, ''),
(82, 'admin/User/star_role', '用户角色分组', '', 1, 1, 67, 1, ' fa-graduation-cap', 0, ''),
(83, 'admin/User/star_level', '合约会员等级', '', 1, 1, 67, 1, ' fa-graduation-cap', 0, ''),
(84, 'admin/User/config_base', '基础配置', '', 1, 1, 66, 1, 'fa-address-card ', 0, ''),
(85, 'admin/forum/config', '相关配置', '', 1, 1, 74, 1, 'fa-config', 0, ''),
(86, 'admin/forum/category_list', '栏目板块', '', 1, 1, 74, 1, 'fa-code-fork ', 0, ''),
(87, 'admin/forum/post_list', '帖子管理', '', 1, 1, 74, 1, 'fa-clipboard', 0, ''),
(88, 'admin/forum/audit_list', '帖子审核', '', 1, 1, 74, 1, 'fa-comments', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `and_auth_rule_group`
--

CREATE TABLE `and_auth_rule_group` (
  `id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL DEFAULT '导航标题' COMMENT '导航标题',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态:0不显示，1显示',
  `orders` int(10) NOT NULL DEFAULT '0' COMMENT '排序'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `and_auth_rule_group`
--

INSERT INTO `and_auth_rule_group` (`id`, `title`, `status`, `orders`) VALUES
(1, '系统', 1, 0),
(2, '站点', 1, 0),
(3, '用户', 1, 0),
(4, '门户', 1, 0),
(5, '论坛', 1, 0),
(6, '商城', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `and_hooks`
--

CREATE TABLE `and_hooks` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '主键',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` text NOT NULL COMMENT '描述',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '类型',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `addons` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子挂载的插件 ''，''分割'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `city` varchar(20) NOT NULL DEFAULT '' COMMENT '城市',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '操作时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `and_log`
--

INSERT INTO `and_log` (`id`, `module`, `controller`, `action`, `describe`, `user_id`, `username`, `add_ip`, `city`, `is_delete`, `create_time`) VALUES
(16, 'admin', 'Login', 'login_username', '登录于2018-03-09 14:38:06', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520577491),
(17, 'admin', 'Login', 'login_username', '登录于2018-03-09 20:50:26', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520599826),
(18, 'admin', 'AuthGroup', 'update', '修改角色ID:2角色信息', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520601799),
(19, 'admin', 'AdminUser', 'update_status', '更新ID:1账户状态', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520601817),
(20, 'admin', 'AdminUser', 'update_status', '更新ID:1账户状态', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520601821),
(21, 'admin', 'AdminUser', 'update', '修改了基本账户信息', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520601853),
(22, 'admin', 'AdminUser', 'edit_roles', '更新了ceshi的角色', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520601860),
(23, 'admin', 'Login', 'login_username', '登录于2018-03-10 09:11:21', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520644282),
(24, 'admin', 'SystemConfig', 'update_value', '更新配置项：Home主题开关值=》1', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520650968),
(25, 'admin', 'Theme', 'update_status', '开启home的主题：bule', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520650991),
(26, 'admin', 'Theme', 'update_status', '关闭home的主题：bule', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520651001),
(27, 'admin', 'SystemConfig', 'update_value', '更新配置项：Home主题开关值=》0', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520651020),
(28, 'admin', 'SystemConfig', 'save', '新增：home_logo配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520737193),
(29, 'admin', 'Login', 'login_username', '登录于2018-03-12 15:34:01', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520840042),
(30, 'admin', 'Login', 'login_username', '登录于2018-03-13 14:30:18', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520922619),
(31, 'admin', 'AuthRule', 'save', '添加权限规则：admin/SystemConfig/user', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520922706),
(32, 'admin', 'AuthGroup', 'update_rule', '修改角色ID:1规则', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520922839),
(33, 'admin', 'SystemConfig', 'save', '新增：user_join_on配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520923026),
(34, 'admin', 'SystemConfig', 'save', '新增：user_banned_title配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520925379),
(35, 'admin', 'AdminUser', 'delete_all', '批量删除ID账户【3】', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520942644),
(36, 'admin', 'AuthRule', 'update', '修改权限规则ID:2', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520942707),
(37, 'admin', 'AuthRule', 'update', '修改权限规则ID:2', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520942734),
(38, 'admin', 'AuthRule', 'update', '修改权限规则ID:10', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520942773),
(39, 'admin', 'AuthRule', 'update', '修改权限规则ID:2', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520942923),
(40, 'admin', 'AuthRule', 'save', '添加权限规则：admin/User/index', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520942961),
(41, 'admin', 'AuthGroup', 'update_rule', '修改角色ID:1规则', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520942969),
(42, 'admin', 'AuthRule', 'save', '添加权限规则：admin/User/_list', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520943264),
(43, 'admin', 'AuthRule', 'save', '添加权限规则：admin/User/config', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520943534),
(44, 'admin', 'AuthRule', 'save', '添加权限规则：admin/User/level', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520943804),
(45, 'admin', 'AuthRule', 'save', '添加权限规则：admin/User/rule', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520943848),
(46, 'admin', 'AuthRule', 'save', '添加权限规则：admin/User/audit', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520944376),
(47, 'admin', 'AuthRule', 'save', '添加权限规则：admin/User/send', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520944456),
(48, 'admin', 'AuthGroup', 'update_rule', '修改角色ID:1规则', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520944462),
(49, 'admin', 'AuthGroup', 'update_rule', '修改角色ID:1规则', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520944467),
(50, 'admin', 'AuthRule', 'delete', '删除权限规则ID:62', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520946918),
(51, 'admin', 'AuthRule', 'delete', '删除权限规则ID:63', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520946927),
(52, 'admin', 'SystemConfig', 'update_value', '更新配置项：保留关键字值=》about,account,activate,add,admin,adm', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520947223),
(53, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520950535),
(54, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520950590),
(55, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520950999),
(56, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520951211),
(57, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520951226),
(58, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520951290),
(59, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520951303),
(60, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520951362),
(61, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520951383),
(62, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520951465),
(63, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520951478),
(64, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520951518),
(65, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520951528),
(66, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520951540),
(67, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520951648),
(68, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520952045),
(69, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520952053),
(70, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520952427),
(71, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520952460),
(72, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520952468),
(73, 'admin', 'User', 'config_update', '更新了user配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520952477),
(74, 'admin', 'User', 'config_update', '更新了user配置项user_join_on为0', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520954116),
(75, 'admin', 'User', 'config_update', '更新了user配置项user_join_on为1', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520954261),
(76, 'admin', 'User', 'config_update', '更新了user配置项user_join_on为0', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520954436),
(77, 'admin', 'User', 'config_update', '更新了user配置项user_join_on为1', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520954444),
(78, 'admin', 'User', 'config_update', '更新了user配置项user_banned_title为about,account,activate', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520954466),
(79, 'admin', 'User', 'config_update', '更新了user配置项user_banned_title为about,account,activate', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520954472),
(80, 'admin', 'Login', 'login_username', '登录于2018-03-14 11:30:32', 1, 'admin', '127.0.0.1', '内网IP', 0, 1520998233),
(81, 'admin', 'SystemConfig', 'save', '新增：extcredits1配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521015736),
(82, 'admin', 'SystemConfig', 'update_value', '更新配置项：积分一属性值=》经验,点,,10', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521015795),
(83, 'admin', 'SystemConfig', 'save', '新增：extcredits2配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521015876),
(84, 'admin', 'SystemConfig', 'save', '新增：extcredits3配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521015918),
(85, 'admin', 'SystemConfig', 'save', '新增：extcredits4配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521015973),
(86, 'admin', 'SystemConfig', 'save', '新增：extcredits5配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521016031),
(87, 'admin', 'SystemConfig', 'save', '新增：extcredits6配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521016061),
(88, 'admin', 'SystemConfig', 'save', '新增：extcredits7配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521016092),
(89, 'admin', 'SystemConfig', 'save', '新增：extcredits8配置项', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521016124),
(90, 'admin', 'User', 'config_update', '更新了user配置项extcredits2为金币,枚,,20', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521020288),
(91, 'admin', 'User', 'config_update', '更新了user配置项extcredits2为金币,枚,fa-home,20', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521020304),
(92, 'admin', 'User', 'config_update', '更新了user配置项extcredits1为经验,点,,50', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521020320),
(93, 'admin', 'User', 'config_update', '更新了user配置项extcredits3为积分,分,,30', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521020321),
(94, 'admin', 'User', 'config_update', '更新了user配置项user_join_on为0', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521020481),
(95, 'admin', 'User', 'config_update', '更新了user配置项user_join_on为1', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521020606),
(96, 'admin', 'User', 'config_update', '更新了user配置项user_join_on为0', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521020610),
(97, 'admin', 'User', 'config_update', '更新了user配置项user_join_on为1', 1, 'admin', '127.0.0.1', '内网IP', 0, 1521020630),
(98, 'admin', 'Login', 'login_username', '登录于2018-03-14 19:41:04', 1, 'admin', '127.0.0.1', '', 0, 1521027665),
(99, 'user', 'Join', 'add', '注册于2018-03-14 19:42:07', 1, 'and_Mmfmoq', '127.0.0.1', 'XX内网IP,127', 0, 1521027728),
(100, 'user', 'Join', 'add', 'ADMIN&U2kp3Y注册于2018-03-14 19:47:39', 0, 'and_U2kp3Y', '127.0.0.1', '', 0, 1521028059),
(101, 'user', 'Join', 'add', 'ceshi&fRZXbC注册于2018-03-14 19:55:28', 0, 'and_fRZXbC', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521028529),
(102, 'user', 'Join', 'add', 'ceshi&i7NHTx注册于2018-03-14 19:57:06', 0, 'and_i7NHTx', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521028627),
(103, 'user', 'Join', 'add', 'ceshidfsdfsdfsdfsdfsdfsdfsd&EnkTF3注册于2018-03-14 20', 0, 'and_EnkTF3', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521028806),
(104, 'user', 'Join', 'add', 'ceshidfsdfsdfsdfsdfsdfsdfsd&0idS91注册于2018-03-14 20', 0, 'and_0idS91', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521029231),
(105, 'user', 'Join', 'add', 'ceshidfsdfsdfsdfsdfsdfsdfsd&LZ7ttT注册于2018-03-14 20', 0, 'and_LZ7ttT', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521029388),
(106, 'user', 'Join', 'add', 'ceshi厅&e1V4CJ注册于2018-03-14 20:13:09', 0, 'and_e1V4CJ', '127.0.0.1', '', 0, 1521029590),
(107, 'admin', 'AuthRule', 'update', '修改权限规则ID:19', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521030773),
(108, 'user', 'Join', 'add', 'ceshi&kndJE5注册于2018-03-14 20:45:11', 0, 'and_kndJE553291', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521031511),
(109, 'user', 'Join', 'add', '测试c&dXDlPy注册于2018-03-14 21:52:41', 0, 'and_dXDlPy39598', '127.0.0.1', '', 0, 1521035561),
(110, 'user', 'Login', 'into', '测试c&dXDlPy登录于2018-03-14 22:08:32', 14, 'and_dXDlPy39598', '127.0.0.1', '', 0, 1521036512),
(111, 'user', 'Login', 'into', '测试c&dXDlPy登录于2018-03-14 22:10:03', 14, 'and_dXDlPy39598', '127.0.0.1', '', 0, 1521036603),
(112, 'user', 'Login', 'into', '测试c&dXDlPy登录于2018-03-14 22:13:40', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521036820),
(113, 'user', 'Login', 'into', '测试c&dXDlPy登录于2018-03-14 22:14:49', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521036889),
(114, 'user', 'Login', 'into', '测试c&dXDlPy登录于2018-03-15 08:22:06', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521073326),
(115, 'admin', 'Login', 'login_username', '登录于2018-03-15 08:58:31', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521075511),
(116, 'admin', 'AuthRule', 'save', '添加权限规则：admin/nav/index', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521080390),
(117, 'admin', 'AuthRule', 'update', '修改权限规则ID:71', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521080442),
(118, 'admin', 'AuthGroup', 'update_rule', '修改角色ID:1规则', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521080503),
(119, 'admin', 'AuthRule', 'save', '添加权限规则：admin/nav/home', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521080548),
(120, 'admin', 'AuthRule', 'save', '添加权限规则：admin/nav/sns', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521080565),
(121, 'admin', 'AuthGroup', 'update_rule', '修改角色ID:1规则', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521080578),
(122, 'admin', 'Nav', 'update_status', '更新导航ID：3状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521083608),
(123, 'admin', 'Nav', 'update_status', '更新导航ID：3状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521083624),
(124, 'admin', 'Nav', 'update_status', '更新导航ID：3状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521083684),
(125, 'admin', 'Nav', 'update_status', '更新导航ID：2状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521083700),
(126, 'admin', 'AuthRule', 'save', '添加权限规则：admin/sns/index', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521084244),
(127, 'admin', 'AuthRule', 'save', '添加权限规则：admin/home/index', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521084286),
(128, 'admin', 'AuthRule', 'save', '添加权限规则：admin/mall/index', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521084373),
(129, 'admin', 'AuthGroup', 'update_rule', '修改角色ID:1规则', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521084381),
(130, 'admin', 'Nav', 'save', '添加新导航：jdsj', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521087530),
(131, 'admin', 'Nav', 'save', '添加新导航：dfgdfg', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521088187),
(132, 'admin', 'Nav', 'save', '添加新导航：ghfg', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521088466),
(133, 'admin', 'Nav', 'save', '添加新导航：fghf', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521088538),
(134, 'admin', 'Nav', 'save', '添加新导航：fdg', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521088594),
(135, 'admin', 'Nav', 'save', '添加新导航：vbnv', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521088699),
(136, 'admin', 'Nav', 'save', '添加新导航：vbnvvbn', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521088706),
(137, 'admin', 'Nav', 'save', '添加新导航：fgds', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521088776),
(138, 'admin', 'Nav', 'save', '添加新导航：fgds4', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521088786),
(139, 'admin', 'Nav', 'save', '添加新导航：gfhgfhf', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521088811),
(140, 'admin', 'Nav', 'save', '添加新导航：gfhgfhf99', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521088915),
(141, 'admin', 'Nav', 'save', '添加新导航：hgjgjhgg', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521088944),
(142, 'admin', 'Nav', 'save', '添加新导航：ddfgdfg', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521088963),
(143, 'admin', 'Nav', 'save', '添加新导航：cees', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521089178),
(144, 'admin', 'Nav', 'save', '添加新导航：dfg', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521089509),
(145, 'admin', 'Nav', 'delete', '删除导航ID:19', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521089699),
(146, 'admin', 'Nav', 'save', '添加新导航：水电费', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521094677),
(147, 'admin', 'AuthRule', 'save', '添加权限规则：admin/nav/user', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521095105),
(148, 'admin', 'AuthGroup', 'update_rule', '修改角色ID:1规则', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521095113),
(149, 'admin', 'Nav', 'save', '添加新导航：测试', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521095398),
(150, 'admin', 'AuthRule', 'update', '修改权限规则ID:67', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521096821),
(151, 'user', 'Login', 'into', '测试c&dXDlPy登录于2018-03-15 16:39:09', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521103150),
(152, 'user', 'Login', 'into', '测试c&dXDlPy登录于2018-03-15 16:58:30', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521104310),
(153, 'admin', 'Login', 'login_username', '登录于2018-03-16 10:37:41', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521167862),
(154, 'user', 'Login', 'into', '测试c&dXDlPy登录于2018-03-16 10:49:17', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521168557),
(155, 'user', 'Login', 'into', '测试c&dXDlPy登录于2018-03-16 10:50:23', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521168623),
(156, 'admin', 'Login', 'login_username', '登录于2018-03-16 22:27:54', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521210474),
(157, 'admin', 'AuthRule', 'update', '修改权限规则ID:68', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521211872),
(158, 'admin', 'AuthRule', 'update', '修改权限规则ID:68', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521211920),
(159, 'admin', 'Login', 'login_username', '登录于2018-03-17 09:07:58', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521248878),
(160, 'admin', 'AuthRule', 'update', '修改权限规则ID:67', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521250531),
(161, 'admin', 'AuthRule', 'save', '添加权限规则：admin/User/config_register', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521255907),
(162, 'admin', 'AuthRule', 'save', '添加权限规则：admin/User/config_score', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521255937),
(163, 'admin', 'AuthRule', 'save', '添加权限规则：admin/User/config_policy', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521255961),
(164, 'admin', 'SystemConfig', 'save', '新增：policy_action配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521256650),
(165, 'admin', 'SystemConfig', 'update', '修改：user_policy_action配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521256763),
(166, 'admin', 'SystemConfig', 'update_value', '更新配置项：策略配置值=》user/sign/sign:签到', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521257291),
(167, 'admin', 'SystemConfig', 'update', '修改：user_policy_action配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521257389),
(168, 'admin', 'Login', 'login_username', '登录于2018-03-17 12:42:07', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521261728),
(169, 'admin', 'AuthRule', 'update', '修改权限规则ID:67', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521267742),
(170, 'admin', 'AuthRule', 'update', '修改权限规则ID:67', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521267929),
(171, 'admin', 'AuthRule', 'update', '修改权限规则ID:67', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521267978),
(172, 'admin', 'AuthRule', 'save', '添加权限规则：admin/User/grade', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521268031),
(173, 'admin', 'AuthRule', 'save', '添加权限规则：admin/User/role', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521268068),
(174, 'admin', 'AuthRule', 'save', '添加权限规则：admin/User/level', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521268141),
(175, 'admin', 'AuthGroup', 'update_rule', '修改角色ID:1规则', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521268150),
(176, 'admin', 'AuthRule', 'update', '修改权限规则ID:81', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521268572),
(177, 'admin', 'AuthRule', 'update', '修改权限规则ID:82', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521268584),
(178, 'admin', 'AuthRule', 'update', '修改权限规则ID:83', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521268594),
(179, 'admin', 'Login', 'login_username', '登录于2018-03-17 15:52:13', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521273134),
(180, 'admin', 'Login', 'login_username', '登录于2018-03-18 13:08:00', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521349681),
(181, 'user', 'Login', 'into', '测试c&dXDlPy登录于2018-03-18 13:10:05', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521349805),
(182, 'user', 'Login', 'into', '测试c&dXDlPy登录于2018-03-18 15:38:21', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521358701),
(183, 'admin', 'Login', 'login_username', '登录于2018-03-18 15:39:12', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521358752),
(184, 'admin', 'SystemConfig', 'update_value', '更新配置项：策略配置值=》user/sign/sign:签到:1,usll/sf/sdf:sdf:2', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521359649),
(185, 'admin', 'SystemConfig', 'update_value', '更新配置项：策略配置值=》user/sign/sign:签到:1,usll/sf/sdf:sdf:2', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521361829),
(186, 'admin', 'AuthRule', 'save', '添加权限规则：admin/User/base', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521370646),
(187, 'admin', 'AuthGroup', 'update_rule', '修改角色ID:1规则', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521370652),
(188, 'admin', 'AuthRule', 'update', '修改权限规则ID:84', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521370765),
(189, 'admin', 'SystemConfig', 'save', '新增：user_is_sign配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521370929),
(190, 'admin', 'SystemConfig', 'update', '修改：user_is_sign配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521370975),
(191, 'admin', 'SystemConfig', 'update_value', '更新配置项：积分一属性值=》金币,枚,,50', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521377703),
(192, 'admin', 'SystemConfig', 'update_value', '更新配置项：积分一属性值=》金币,枚,50', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521377709),
(193, 'admin', 'Login', 'login_username', '登录于2018-03-18 21:46:01', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521380761),
(194, 'admin', 'SystemConfig', 'update_value', '更新配置项：积分一属性值=》金币,枚,,50', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521381034),
(195, 'user', 'Login', 'into', '测试c&dXDlPy登录于2018-03-18 22:17:57', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521382677),
(196, 'admin', 'Login', 'login_username', '登录于2018-03-19 08:42:16', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521420136),
(197, 'user', 'Login', 'into', '测试c&dXDlPy登录于2018-03-19 08:46:42', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521420402),
(198, 'admin', 'SystemConfig', 'save', '新增：email_username配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521440540),
(199, 'admin', 'SystemConfig', 'save', '新增：email_host_password配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521440633),
(200, 'admin', 'SystemConfig', 'update', '修改：email_template_validate配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521440753),
(201, 'admin', 'SystemConfig', 'update', '修改：email_host_username配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521440923),
(202, 'admin', 'SystemConfig', 'update', '修改：email_host_password配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521440989),
(203, 'admin', 'SystemConfig', 'update', '修改：email_template_resetpwd配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521441159),
(204, 'admin', 'SystemConfig', 'update_value', '更新配置项：邮箱激活邮件模板值=》                                 ', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521441184),
(205, 'admin', 'SystemConfig', 'update_value', '更新配置项：找回密码邮件模板值=》                                 ', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521441211),
(206, 'admin', 'SystemConfig', 'update_value', '更新配置项：邮箱激活邮件模板值=》                                 ', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521441220),
(207, 'admin', 'SystemConfig', 'update', '修改：email_host_port配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521441281),
(208, 'admin', 'SystemConfig', 'update', '修改：email_template_resetPassword配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521441527),
(209, 'admin', 'SystemConfig', 'update_value', '更新配置项：找回密码邮件模板值=》                                 ', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521441618),
(210, 'admin', 'SystemConfig', 'update_value', '更新配置项：邮箱激活邮件模板值=》                                 ', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521441628),
(211, 'admin', 'Login', 'login_username', '登录于2018-03-20 08:51:49', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521507110),
(212, 'user', 'Login', 'into', '测试c&dXDlPy登录于2018-03-20 09:03:17', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521507797),
(213, 'admin', 'SystemConfig', 'update_value', '更新配置项：服务器地址值=》smtpdm.aliyun.com', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521508434),
(214, 'admin', 'SystemConfig', 'update_value', '更新配置项：SMTP服务器的端口号值=》465', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521508453),
(215, 'admin', 'SystemConfig', 'update_value', '更新配置项：SMTP服务器密码值=》AndPHP1234', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521508468),
(216, 'admin', 'SystemConfig', 'update_value', '更新配置项：SMTP服务器用户名值=》auto@andphp.com', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521508480),
(217, 'admin', 'SystemConfig', 'save', '新增：email_host_SMTPSecure配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521509526),
(218, 'admin', 'SystemConfig', 'update_value', '更新配置项：网站名称值=》AndPHP', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521509664),
(219, 'admin', 'SystemConfig', 'update_value', '更新配置项：邮箱激活邮件模板值=》Hi，{username}：  欢迎加入 {site_title}', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521516014),
(220, 'admin', 'SystemConfig', 'update_value', '更新配置项：邮箱激活邮件模板值=》  Hi，{username}：  欢迎加入 {site_titl', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521516177),
(221, 'admin', 'SystemConfig', 'update_value', '更新配置项：邮箱激活邮件模板值=》<p>Hi，<b>{username}</b>：</p><p>欢迎', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521516206),
(222, 'admin', 'SystemConfig', 'update_value', '更新配置项：找回密码邮件模板值=》<p>您好，<b>{username}</b> ：</p><p>您', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521516237),
(223, 'admin', 'Login', 'login_username', '登录于2018-03-20 16:05:47', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521533148),
(224, 'user', 'Login', 'into', '测试c&dXDlPy登录于2018-03-20 16:06:50', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521533210),
(225, 'user', 'Join', 'add', 'dfd&rdaSLB注册于2018-03-20 17:00:12', 0, 'and_rdaSLB17504', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521536412),
(226, 'user', 'Login', 'into', '打个电话RDG&dXDlPy登录于2018-03-20 17:05:32', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521536732),
(227, 'admin', 'Login', 'login_username', '登录于2018-03-20 22:52:26', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521557547),
(228, 'user', 'Login', 'into', '打个电话RDe433&dXDlPy登录于2018-03-21 09:00:06', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521594006),
(229, 'admin', 'Login', 'login_username', '登录于2018-03-21 09:09:30', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521594571),
(230, 'user', 'Login', 'into', '打个电话RDe433&dXDlPy登录于2018-03-21 19:21:07', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521631267),
(231, 'admin', 'Login', 'login_username', '登录于2018-03-22 10:49:56', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521686997),
(232, 'user', 'Login', 'into', '打个电话RDe433&dXDlPy登录于2018-03-22 10:50:42', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521687042),
(233, 'admin', 'User', 'config_update', '更新了user配置项extcredits1为经验,点,,50', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521687843),
(234, 'admin', 'SystemConfig', 'update_value', '更新配置项：策略配置值=》user/sign/sign:签到:extcredits2', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521714110),
(235, 'admin', 'SystemConfig', 'update_value', '更新配置项：策略配置值=》user/sign/sign:签到:extcredits1', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521714586),
(236, 'admin', 'Login', 'login_username', '登录于2018-03-23 10:07:56', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521770877),
(237, 'user', 'Login', 'into', '打个电话RDe433&dXDlPy登录于2018-03-23 10:36:09', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521772569),
(238, 'admin', 'Nav', 'update_status', '更新导航ID：21状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521772627),
(239, 'admin', 'Nav', 'update_status', '更新导航ID：21状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521772637),
(240, 'admin', 'Nav', 'update', '修改user导航ID:21为Forum', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521773257),
(241, 'admin', 'AuthRule', 'update', '修改权限规则ID:73', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521773434),
(242, 'admin', 'AuthRule', 'update', '修改权限规则ID:73', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521773556),
(243, 'admin', 'Nav', 'save', '添加新导航：Forum', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521773746),
(244, 'user', 'Login', 'into', '打个电话RDe433&dXDlPy登录于2018-03-23 19:27:13', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521804433),
(245, 'admin', 'Nav', 'save', '添加新导航：Mall', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521809375),
(246, 'admin', 'Nav', 'update', '修改forum导航ID:23为Mall', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521809420),
(247, 'user', 'Login', 'into', '打个电话RDe433&dXDlPy登录于2018-03-23 20:57:07', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521809827),
(248, 'user', 'Login', 'into', '打个电话RDe433&dXDlPy登录于2018-03-24 08:22:03', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521850923),
(249, 'admin', 'Login', 'login_username', '登录于2018-03-24 08:24:57', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521851097),
(250, 'admin', 'AuthRule', 'update', '修改权限规则ID:74', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521851141),
(251, 'admin', 'AuthRule', 'update', '修改权限规则ID:66', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521852029),
(252, 'admin', 'AuthRule', 'save', '添加权限规则：admin/forum/config', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521852080),
(253, 'admin', 'AuthGroup', 'update_rule', '修改角色ID:1规则', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521852099),
(254, 'admin', 'SystemConfig', 'save', '新增：forum_label配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521852955),
(255, 'admin', 'AuthRule', 'save', '添加权限规则：admin/forum/category', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521853693),
(256, 'admin', 'AuthRule', 'save', '添加权限规则：admin/forum/post', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521853779),
(257, 'admin', 'AuthGroup', 'update_rule', '修改角色ID:1规则', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521853793),
(258, 'admin', 'SystemConfig', 'save', '新增：comment_banned_title配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521856267),
(259, 'admin', 'SystemConfig', 'save', '新增：forum_is_comment配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521856381),
(260, 'admin', 'SystemConfig', 'update', '修改：comment_banned_title配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521858745),
(261, 'admin', 'Forum', 'update_categoryshow', '更新Forum板块ID：1状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521860135),
(262, 'admin', 'Forum', 'update_categorycomme', '更新Forum板块ID：2状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521860187),
(263, 'admin', 'Forum', 'categorysave', '添加新板块：出生地', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521861815),
(264, 'admin', 'Forum', 'category_update', '修改Forum板块ID:3为出生地', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521862669),
(265, 'admin', 'Forum', 'category_update', '修改Forum板块ID:3为出生地', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521862726),
(266, 'admin', 'Forum', 'category_delete', '删除板块ID:3', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521862765),
(267, 'admin', 'AdminUser', 'prohibit', '批量禁用ID账户【2】', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521862831),
(268, 'admin', 'AdminUser', 'update_status', '更新ID:0账户状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521862839),
(269, 'admin', 'AuthRule', 'update', '修改权限规则ID:86', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521863292),
(270, 'admin', 'AuthRule', 'update', '修改权限规则ID:87', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521863307),
(271, 'admin', 'AuthRule', 'save', '添加权限规则：admin/forum/audit_list', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521866628),
(272, 'admin', 'AuthGroup', 'update_rule', '修改角色ID:1规则', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521866877),
(273, 'admin', 'Forum', 'post_update_comment', '更新帖子ID：1评论状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883494),
(274, 'admin', 'Forum', 'post_update_comment', '更新帖子ID：1评论状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883496),
(275, 'admin', 'Forum', 'post_update_choice', '更新帖子ID：0精贴状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883497),
(276, 'admin', 'Forum', 'post_update_top', '更新帖子ID：0置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883498),
(277, 'admin', 'Forum', 'post_update_memo', '更新帖子ID：0结贴状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883499),
(278, 'admin', 'Forum', 'post_update_status', '更新帖子ID：0禁用状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883501),
(279, 'admin', 'Forum', 'post_update_choice', '更新帖子ID：0精贴状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883557),
(280, 'admin', 'Forum', 'post_update_choice', '更新帖子ID：0精贴状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883559),
(281, 'admin', 'Forum', 'post_update_choice', '更新帖子ID：0精贴状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883567),
(282, 'admin', 'Forum', 'post_update_choice', '更新帖子ID：0精贴状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883609),
(283, 'admin', 'Forum', 'post_update_comment', '更新帖子ID：1评论状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883675),
(284, 'admin', 'Forum', 'post_update_comment', '更新帖子ID：1评论状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883686),
(285, 'admin', 'Forum', 'post_update_choice', '更新帖子ID：0精贴状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883690),
(286, 'admin', 'Forum', 'post_update_choice', '更新帖子ID：0精贴状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883711),
(287, 'admin', 'Forum', 'post_update_choice', '更新帖子ID：0精贴状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883713),
(288, 'admin', 'Forum', 'post_update_choice', '更新帖子ID：1精贴状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883953),
(289, 'admin', 'Forum', 'post_update_top', '更新帖子ID：1置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521883962),
(290, 'admin', 'Forum', 'all_audit_on', '批量审核通过帖子ID【3,4】', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521886474),
(291, 'admin', 'Forum', 'all_comment_off', '批量关闭评论ID【2,3,4】', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521886642),
(292, 'admin', 'Forum', 'all_comment_off', '批量关闭评论ID【3,4】', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521886955),
(293, 'admin', 'Forum', 'all_comment_off', '批量关闭评论ID【3,4】', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521887143),
(294, 'admin', 'Forum', 'all_comment_on', '批量开启评论ID【3,4】', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521887148),
(295, 'user', 'Login', 'into', '打个电话RDe433&dXDlPy登录于2018-03-24 19:15:25', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521890125),
(296, 'user', 'Login', 'into', '打个电话RDe433&dXDlPy登录于2018-03-24 19:17:18', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521890238),
(297, 'admin', 'Nav', 'update', '修改home导航ID:18为Forum', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521890469),
(298, 'admin', 'Nav', 'save', '添加新导航：商城', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521890672),
(299, 'admin', 'Nav', 'update', '修改home导航ID:18为论坛', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521890684),
(300, 'admin', 'Nav', 'save', '添加新导航：文档', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521890817),
(301, 'forum', 'Post', 'add', '添加新帖子：测试', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521903295),
(302, 'forum', 'Post', 'add', '添加新帖子：再测试一下', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521904275),
(303, 'forum', 'Post', 'add', '添加新帖子：的风格大方', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521904505),
(304, 'admin', 'Login', 'login_username', '登录于2018-03-25 10:32:37', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521945157),
(305, 'user', 'Login', 'into', '打个电话RDe433&dXDlPy登录于2018-03-25 10:32:59', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521945179),
(306, 'admin', 'Forum', 'category_update', '修改Forum板块ID:1为板块一', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521947741),
(307, 'admin', 'SystemConfig', 'update', '修改：forum_title配置项', 1, 'admin', '127.0.0.1', '', 0, 1521953360),
(308, 'admin', 'SystemConfig', 'update', '修改：forum_title配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521953376),
(309, 'admin', 'SystemConfig', 'save', '新增：forum_resume配置项', 1, 'admin', '127.0.0.1', '', 0, 1521953508),
(310, 'admin', 'Forum', 'category_save', '添加新板块：灰标签发', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521974965),
(311, 'forum', 'Post', 'add', '添加新帖子：割发代首', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521974991),
(312, 'admin', 'Forum', 'all_audit_on', '批量审核通过帖子ID【5,6,7,8】', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521975028),
(313, 'admin', 'Forum', 'all_top_on', '批量帖子置顶ID【7,8】', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521975159),
(314, 'forum', 'Post', 'add', '添加新帖子：发给对方奋斗过的', 14, 'and_dXDlPy39598', '127.0.0.1', '', 0, 1521976821),
(315, 'forum', 'Post', 'add', '添加新帖子：第三方', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521981549),
(316, 'admin', 'Forum', 'all_audit_on', '批量审核通过帖子ID【4,9,10】', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521981582),
(317, 'admin', 'Forum', 'post_update_choice', '更新帖子ID：10精贴状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521981593),
(318, 'admin', 'Forum', 'post_update_top', '更新帖子ID：10置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521981597),
(319, 'forum', 'Post', 'add', '添加新帖子：的说法都是', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521982842),
(320, 'admin', 'Forum', 'all_audit_on', '批量审核通过帖子ID【11】', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521982852),
(321, 'admin', 'Forum', 'post_update_top', '更新帖子ID：11置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521982866),
(322, 'forum', 'Post', 'add', '添加新帖子：返回给发个很反感好', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521982917),
(323, 'admin', 'Forum', 'all_audit_on', '批量审核通过帖子ID【12】', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521982924),
(324, 'admin', 'Forum', 'post_update_top', '更新帖子ID：12置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521982952),
(325, 'admin', 'SystemConfig', 'save', '新增：forum_audit配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521983534),
(326, 'admin', 'SystemConfig', 'update', '修改：forum_post_audit配置项', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521983555),
(327, 'forum', 'Post', 'add', '添加新帖子：爱,***,**,打第三方的三大师傅是否士大夫', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521985763),
(328, 'forum', 'Post', 'add', '添加新帖子：范德萨的胜多负少大是大非', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521986039),
(329, 'forum', 'Post', 'add', '添加新帖子：梵蒂冈对方个的规定发给1111', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521986065),
(330, 'admin', 'SystemConfig', 'update_value', '更新配置项：是否开启评论值=》0', 1, 'admin', '127.0.0.1', '', 0, 1521986265),
(331, 'admin', 'Forum', 'all_audit_on', '批量审核通过帖子ID【15】', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521986291),
(332, 'admin', 'Forum', 'post_update_top', '更新帖子ID：15置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521986307),
(333, 'forum', 'Post', 'add', '添加新帖子：梵蒂冈电风扇个电饭锅2222', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521986383),
(334, 'forum', 'Post', 'add', '添加新帖子：递四方速递', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1521986425),
(335, 'user', 'Login', 'into', '打个电话RDe433登录于2018-03-26 10:26:34', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522031194),
(336, 'admin', 'Login', 'login_username', '登录于2018-03-26 10:54:27', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522032867),
(337, 'admin', 'SystemConfig', 'update_value', '更新配置项：储存位置值=》0', 1, 'admin', '127.0.0.1', '', 0, 1522032885),
(338, 'admin', 'Forum', 'all_top_off', '批量帖子取消置顶ID【1,2,3,4,5,6,7,8,9,10,11,12,15】', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522051559),
(339, 'forum', 'Post', 'add', '添加新帖子：测试11111', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522060683),
(340, 'admin', 'SystemConfig', 'update_value', '更新配置项：是否开启帖子审核值=》0', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522061205),
(341, 'admin', 'Forum', 'all_audit_on', '批量审核通过帖子ID【13,14,16,17,18】', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522061234),
(342, 'forum', 'Post', 'add', '添加新帖子：再测试一下订单4555', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522061706),
(343, 'admin', 'Forum', 'post_update_top', '更新帖子ID：19置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522061821),
(344, 'forum', 'Post', 'add', '添加新帖子：再测试一下订都是对的', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522061895),
(345, 'admin', 'Forum', 'post_update_top', '更新帖子ID：20置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522061920),
(346, 'admin', 'Forum', 'post_update_top', '更新帖子ID：18置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522062003),
(347, 'admin', 'Forum', 'post_update_top', '更新帖子ID：17置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522062004),
(348, 'admin', 'Forum', 'post_update_top', '更新帖子ID：16置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522062004),
(349, 'admin', 'Forum', 'post_update_top', '更新帖子ID：15置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522062005),
(350, 'admin', 'Forum', 'post_update_top', '更新帖子ID：14置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522062005),
(351, 'admin', 'Forum', 'post_update_top', '更新帖子ID：13置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522062006),
(352, 'admin', 'Forum', 'post_update_top', '更新帖子ID：12置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522062006),
(353, 'admin', 'Forum', 'post_update_top', '更新帖子ID：10置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522062007),
(354, 'admin', 'Forum', 'post_update_top', '更新帖子ID：11置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522062008),
(355, 'admin', 'Forum', 'post_update_top', '更新帖子ID：9置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522062009),
(356, 'admin', 'Forum', 'post_update_top', '更新帖子ID：8置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522062010),
(357, 'admin', 'Forum', 'post_update_top', '更新帖子ID：7置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522062011),
(358, 'admin', 'Forum', 'post_update_top', '更新帖子ID：6置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522062011),
(359, 'admin', 'Forum', 'post_update_top', '更新帖子ID：5置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522062013),
(360, 'admin', 'Forum', 'post_update_choice', '更新帖子ID：19精贴状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522076865),
(361, 'user', 'Login', 'into', '打个电话RDe433登录于2018-03-27 16:07:38', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522138058),
(362, 'admin', 'Login', 'login_username', '登录于2018-03-27 18:12:23', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522145543),
(363, 'admin', 'Forum', 'post_update_top', '更新帖子ID：21置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522159807),
(364, 'admin', 'Forum', 'all_top_off', '批量帖子取消置顶ID【5,6,7,8,9,10,11,12,13,14,15,16,17,18,19', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522159843),
(365, 'admin', 'Forum', 'post_update_top', '更新帖子ID：22置顶状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522166021),
(366, 'admin', 'Forum', 'post_update_choice', '更新帖子ID：22精贴状态', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522166029),
(367, 'user', 'Login', 'into', '打个电话RDe433登录于2018-03-28 08:58:42', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522198722),
(368, 'admin', 'Login', 'login_username', '登录于2018-03-28 11:28:19', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522207700),
(369, 'admin', 'Forum', 'category_save', '添加新板块：季卡开发', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522220534),
(370, 'admin', 'Login', 'login_username', '登录于2018-03-29 10:47:49', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522291670),
(371, 'user', 'Login', 'into', '打个电话RDe433登录于2018-03-29 14:41:40', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522305700),
(372, 'user', 'Login', 'into', '打个电话RDe433登录于2018-03-30 14:08:01', 14, 'and_dXDlPy39598', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522390082),
(373, 'admin', 'Nav', 'update', '修改home导航ID:25为文档', 1, 'admin', '127.0.0.1', 'XX内网IP,127.0.0.1', 0, 1522480410),
(374, 'admin', 'Login', 'login_username', '登录于2018-04-13 19:02:09', 1, 'admin', '127.0.0.1', '内网IP', 0, 1523617329),
(375, 'admin', 'AuthRule', 'update', '修改权限规则ID:47', 1, 'admin', '127.0.0.1', '内网IP', 0, 1523621406),
(376, 'admin', 'AuthRule', 'update', '修改权限规则ID:44', 1, 'admin', '127.0.0.1', '内网IP', 0, 1523621418),
(377, 'admin', 'AuthRule', 'update', '修改权限规则ID:3', 1, 'admin', '127.0.0.1', '内网IP', 0, 1523621814),
(378, 'admin', 'AuthRule', 'update', '修改权限规则ID:3', 1, 'admin', '127.0.0.1', '内网IP', 0, 1523621898),
(379, 'admin', 'AuthRule', 'update', '修改权限规则ID:11', 1, 'admin', '127.0.0.1', '内网IP', 0, 1523621971),
(380, 'admin', 'AuthRule', 'update', '修改权限规则ID:11', 1, 'admin', '127.0.0.1', '内网IP', 0, 1523622024),
(381, 'admin', 'AuthRule', 'update', '修改权限规则ID:64', 1, 'admin', '127.0.0.1', '内网IP', 0, 1523622084),
(382, 'admin', 'AuthRule', 'update', '修改权限规则ID:71', 1, 'admin', '127.0.0.1', '内网IP', 0, 1523622112),
(383, 'admin', 'AuthRule', 'update', '修改权限规则ID:4', 1, 'admin', '127.0.0.1', '内网IP', 0, 1523622134),
(384, 'admin', 'AuthRule', 'update', '修改权限规则ID:76', 1, 'admin', '127.0.0.1', '内网IP', 0, 1523622190),
(385, 'admin', 'AuthRule', 'update', '修改权限规则ID:75', 1, 'admin', '127.0.0.1', '内网IP', 0, 1523622202);

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
(7, 'user', 0, '系统模块', '', '1.0.0', 'AndPHP_author', 0, 0, 1, 1520573886),
(8, 'portal', 0, '系统模块', '', '1.0.0', 'AndPHP_author', 0, 0, 1, 1521108325),
(9, 'bolg', 0, '系统模块', '', '1.0.0', 'AndPHP_author', 0, 0, 1, 1521108597),
(10, 'forum', 0, '系统模块', '', '1.0.0', 'AndPHP_author', 0, 0, 1, 1521727093);

-- --------------------------------------------------------

--
-- 表的结构 `and_nav`
--

CREATE TABLE `and_nav` (
  `id` int(10) UNSIGNED NOT NULL,
  `module` varchar(20) NOT NULL DEFAULT 'home' COMMENT '模块名',
  `is_link` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否外链，0:否，1:是',
  `name` varchar(20) NOT NULL COMMENT '导航名称',
  `alias` varchar(20) DEFAULT '' COMMENT '导航别称',
  `value` varchar(255) DEFAULT '' COMMENT '导航链接',
  `icon` varchar(255) DEFAULT '' COMMENT '导航图标',
  `target` varchar(10) DEFAULT '' COMMENT '打开方式',
  `pid` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父级ID',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态  0 隐藏  1 显示',
  `level_id` varchar(200) NOT NULL DEFAULT '0' COMMENT '可查看等级',
  `orders` int(11) NOT NULL DEFAULT '0' COMMENT '排序'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='导航表';

--
-- 转存表中的数据 `and_nav`
--

INSERT INTO `and_nav` (`id`, `module`, `is_link`, `name`, `alias`, `value`, `icon`, `target`, `pid`, `status`, `level_id`, `orders`) VALUES
(21, 'user', 0, 'Forum', '论坛', '/forum', '&#xe63a;', '', 0, 1, '0', 0),
(20, 'sns', 0, '水电费', '盛世嫡妃', 'dsfssfd', 'fa-home', '', 0, 1, '0', 0),
(18, 'home', 0, '论坛', 'Forum', '/Forum', '', '', 0, 1, '0', 0),
(17, 'sns', 0, 'cees', 'sdf', 'sdf', '', '', 0, 1, '0', 0),
(22, 'forum', 0, 'Forum', '论坛', '/forum', '&#xe63a;', '', 0, 1, '0', 0),
(23, 'forum', 0, 'Mall', '商城', 'javascript:;\" onclick=\"layer.msg(\'敬请期待！\')', '&#xe698;', '', 0, 1, '0', 0),
(24, 'home', 0, '商城', 'mall', 'javascript:;\" onclick=\"layer.msg(\'敬请期待！\')', '', '', 0, 1, '0', 0),
(25, 'home', 0, '文档', 'doc', 'http://kancloud.andphp.com', '', '', 0, 1, '0', 0);

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
  `type` enum('text','image','textarea','file','checkbox','radio','select','checker','array','keyvalue','password','color') NOT NULL,
  `options` text NOT NULL,
  `info` text NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `and_system_config`
--

INSERT INTO `and_system_config` (`id`, `title`, `group`, `vari`, `value`, `type`, `options`, `info`, `orders`) VALUES
(1, '网站名称', 'site', 'site_title', 'AndPHP', 'text', '', '', 0),
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
(36, '服务器地址', 'email', 'email_host', 'smtpdm.aliyun.com', 'text', '', '', 0),
(37, 'SMTP服务器用户名', 'email', 'email_host_username', 'auto@andphp.com', 'text', '', '', 0),
(38, 'SMTP服务器密码', 'email', 'email_host_password', 'AndPHP1234', 'password', '', '', 0),
(39, 'SMTP服务器的端口号', 'email', 'email_host_port', '465', 'text', '', '', 0),
(40, 'accessKeyId', 'sms', 'sms_keyid', '', 'text', '', '填写阿里大于短信接口accessKeyId', 0),
(41, 'accessKeySecret', 'sms', 'sms_keysecret', '', 'text', '', '填写阿里大于短信接口accessKeySecret', 0),
(42, 'appid', 'keyword', 'yt_appid', '', 'text', '', 'http://open.youtu.qq.com/申请', 0),
(43, 'secretId', 'keyword', 'yt_secretid', '', 'text', '', '', 0),
(44, 'secretKey', 'keyword', 'yt_secretkey', '', 'text', '', '', 0),
(47, '储存位置', 'system', 'location', '0', 'text', '{\"0\":\"本地\"，\"1\":\"七牛云\"}', '文件、图片上传储存位置', 0),
(46, '文件上传类型', 'syetem', 'file_type', 'jpg,png,gif,mp4,zip,jpeg', 'text', '', '文件上传类型', 0),
(45, '文件上传大小', 'syetem', 'file_size', '20', 'text', '', '单位：M', 0),
(52, '网络logo', 'home', 'home_logo', '0', 'image', '', '', 0),
(50, '默认账户密码', 'system', 'default_password', '111111', 'text', '', '设置初始值、重置密码', 0),
(51, 'Home主题开关', 'home', 'home_theme_status', '0', 'checker', '{\"0\":\"关闭主题\",\"1\":\"开启主题\"}', '', 0),
(53, '是否开启注册', 'user', 'user_join_on', '1', 'checker', '{\"0\":\"关闭注册\",\"1\":\"开启注册\"}', '', 0),
(54, '保留关键字', 'user', 'user_banned_title', 'about,account,activate,add,admin,administrator,api,app,apps,archive,archives,auth,better,blog,cache,cancel,careers,cart,changelog,checkout,codereview,compare,config,configuration,connect,contact,create,delete,direct_messages,documentation,download,downloads,edit,email,employment,enterprise,facebook,faq,favorites,feed,feedback,feeds,fleet,fleets,follow,followers,following,friend,friends,gist,group,groups,help,home,hosting,hostmaster,idea,ideas,index,info,invitations,invite,is,it,job,jobs,json,language,languages,lists,login,logout,logs,mail,map,maps,mine,mis,news,oauth,oauth_clients,offers,openid,order,orders,organizations,plans,popular,post,postmaster,privacy,projects,put,recruitment,register,remove,replies,root,rss,sales,save,search,security,sessions,settings,shop,signup,sitemap,ssl,ssladmin,ssladministrator,sslwebmaster,status,stories,styleguide,subscribe,subscriptions,support,sysadmin,sysadministrator,terms,tour,translations,trends,twitter,twittr,unfollow,unsubscribe,update,url,user,weather,webmaster,widget,widgets,wiki,ww,www,wwww,xfn,xml,xmpp,yaml,yml,*administrator,*admin,*manage,*管理,*超级版主,*分版版主,*版主,*斑竹,*吧主,*霸主,*超版,*站长,*社区,*元老,*官方,*赚零花钱*赚钱*零花钱,*zlhq,*51zlhq*zhuanlinghuaqianzuanlinghuaqian*<,*>,*@,*php,*asp,*html*javac  *www,*com,*cn,*cc,*net,*org,*cc,*tk,*公司,*gov.cn,*top,*name,*info,*biz,*tm ,*mn,*in,*pro,*net.cn ,*travel ,*ag,*cm ,*com.hk ,*org.cn,*sh ,*ws,*vc,*co,*com.tw,*黑社会,*黑客,*网*成人,*政治,*文学,*作家,*文章,*作品,*昵称,*名字,*名称,*人名,*建行,*农行,*工行,*招行,*邮政,*银行,*关注,*访问,*进入,*打开,*点击,*自定义,*头衔,*关键字,*关键词,*统配符,*网页,*电脑,*资料,*文件,*文档,*浏览器,*保留*存档开始结束*重启,*windows,*win,*主席,*首席,*公司,*总经理,*董事,*老板,*CEO,*投资商,*股东,*游戏,*刷机,*刷级,*攻击,*安全,*卫士,*杀毒,*软件,*网页,*聊天,*浏览,*大全,*系列,*导航,*定位,*模式,*盈利,*赢利,*电话,*手机,*app,*病毒,*木马,*站,*贷款,*利息,*套现,*启示,*招聘,*代办,*代考,*证件,*传销,*商标,*注册,*转让,*查询,*求购,*策划,*托管,*评估,*质押,*检测,*驳回,*续展,*保护,*复审,*近似,*委托,*交易,*平台,*服务,*代理,*机构*logo图标标志安卓苹果设计*iphone,*android,*旺旺,*球球,*歪歪,*千牛,*匿名,*倪明,*佚名,*未知,*康盛,*客服,*咨询,*免费,*意见,*建议,*投诉,*人气,*最新,*推荐,*置顶,*排名,*搜索,*友情,*链接,*连接,*禁止,*严重,*yy,*Discuz,*Comsenz,*中国,*共产党,*中央,*中华,*人民,*百姓,*河北,*山西,*辽宁,*吉林,*黑龙江,*江苏,*浙江,*安徽,*福建,*江西,*山东,*河南,*湖北,*湖南,*广东,*海南,*四川,*贵州,*云南,*陕西,*甘肃,*青海,*台湾,*成都,*德阳,*内蒙古,*广西,*西藏,*宁夏,*新疆,*北京,*天津,*上海,*重庆,*香港,*澳门*特别*行政区*组织你好,*党中央,*法轮功,*藏独,*习近平,*彭丽媛,*奥巴马,*普京,*安倍,*安培,*韩国,*美国,*英国*日本*公安,*派出所,*招待所,*KTV,*迪厅,*迪吧,*酒吧,*夜店,*舞女,*做鸭,*黄,*迷药,*骗子,*欺诈,*fuck,*操,*艹,*靠,*日,*kao,*cao,*流氓,*se,*色,*性爱,*肏,*尼玛,*你妈,*逼,*穴,*屌,*骚,*baidu,*百度,*xiaomi,*小米,*taobao,*淘宝,*jingdong,*京东,*tmall,*天猫,*sina,*新浪,*weibo,*微博,*weixin,*微信,*gongzhong,*公众,*tengxun,*腾讯,*扣扣,*163,*网易,*sohu,*搜狐,*xunlei,*讯雷,*gougou,*狗狗,*iask,*爱问,*youku,*优酷,*56,*我乐,*hao123,*好123,*58同城,*借贷宝,*广发,*聚财猫,*温商贷,*理财,*电信,*移动,*联通,*中国平安', 'textarea', '', '', 0),
(64, '策略配置', 'user', 'user_policy_action', 'user/sign/sign:签到:extcredits1', 'textarea', '', '英文半角逗号分隔多个规则,冒号分隔规则名称', 0),
(56, '积分一属性', 'user', 'extcredits1', '经验,点,,50', 'text', '', '', 0),
(57, '积分二属性', 'user', 'extcredits2', '金币,枚,fa-home,20', 'text', '', '', 0),
(58, '积分三属性', 'user', 'extcredits3', '积分,分,,30', 'text', '', '', 0),
(59, '积分四属性', 'user', 'extcredits4', '默认,无,,0', 'text', '', '', 0),
(60, '积分五属性', 'user', 'extcredits5', '默认,无,,0', 'text', '', '', 0),
(61, '积分六属性', 'user', 'extcredits6', '默认,无,,0', 'text', '', '', 0),
(62, '积分七属性', 'user', 'extcredits7', '默认,无,,0', 'text', '', '', 0),
(63, '积分八属性', 'user', 'extcredits8', '默认,无,,0', 'text', '', '', 0),
(69, '论坛标题', 'forum', 'forum_title', '哈哈', 'text', '', '', 0),
(65, '是否开启签到', 'user', 'user_is_sign', '1', 'checker', '', '1开启，0关闭', 0),
(72, '论坛简介', 'forum', 'forum_resume', '本社区不是 AndPHP 的 Demo 演示，所以不要发布无意义的内容，在你提问前，请务必要阅读《提问的智慧》', 'textarea', '', '', 0),
(66, '找回密码邮件模板', 'email', 'email_template_resetPassword', '<p>您好，<b>{username}</b> ：</p><p>您正在找回<b> {site_title}</b> 网站登录密码！如果是你本人进行的操作，请点击下面的链接来认证您的邮箱。否则，请忽略该邮件。</p><p>{url}</p><p>如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中认证。</p><p><br></p>', 'textarea', '', '', 0),
(67, '邮箱激活邮件模板', 'email', 'email_template_validate', '<p>Hi，<b>{username}</b>：</p><p>欢迎加入 <b>{site_title}</b>！请点击下面的链接来认证您的邮箱。</p><p>{url}</p><p>如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中认证。</p><p><br></p>', 'textarea', '', '', 0),
(70, '和谐评论', 'comment', 'comment_banned_title', '爱爱,性行为,性交,打炮,约炮,性虐,肛交,口交,群交,群P,群p,3P,3p,三P,三p,强奸,猥亵,轮奸,诱奸,迷奸,强暴,鸡巴,阴茎,睾丸,生殖器,大保健,一夜情,换妻,卖淫,嫖娼,打飞机,兽交,鸡奸,毒品,冰毒,摇头丸,海洛因,大麻,K粉,k粉,枪,中共,共产党,习近平,李克强,张德江,俞正声,刘云山,王岐山,张高丽,江泽民,朱镕基,邓小平,李鹏,胡景涛,温家宝,文革 阿扁推翻,阿宾,阿賓,挨了一炮,爱液横流,安街逆,安局办公楼,安局豪华,安门事,安眠藥,案的准确,八九民,八九学,八九政治,把病人整,把邓小平,把学生整,罢工门,白黄牙签,败培训,办本科,办理本科,办理各种,办理票据,办理文凭,办理真实,办理证书,办理资格,办文凭,办怔,办证,半刺刀,辦毕业,辦證,谤罪获刑,磅解码器,磅遥控器,宝在甘肃修,保过答案,报复执法,爆发骚,北省委门,被打死,被指抄袭,被中共,本公司担,本无码,毕业證,变牌绝,辩词与梦,冰毒,冰火毒,冰火佳,冰火九重,冰火漫,冰淫传,冰在火上,波推龙,博彩娱,博会暂停,博园区伪,不查都,不查全,不思四化,布卖淫女,部忙组阁,部是这样,才知道只生,财众科技,采花堂,踩踏事,苍山兰,苍蝇水,藏春阁,藏獨,操了嫂,操嫂子,策没有不,插屁屁,察象蚂,拆迁灭,车牌隐,成人电,成人卡通,成人聊,成人片,成人视,成人图,成人文,成人小,城管灭,惩公安,惩贪难,充气娃,冲凉死,抽着大中,抽着芙蓉,出成绩付,出售发票,出售军,穿透仪器,春水横溢,纯度白,纯度黄,次通过考,催眠水,催情粉,催情药,催情藥,挫仑,达毕业证,答案包,答案提供,打飞机专,打死经过,打死人,打砸办公,大鸡巴,大雞巴,大纪元,大揭露,大奶子,大批贪官,大肉棒,大嘴歌,代办发票,代办各,代办文,代办学,代办制,代辦,代表烦,代理发票,代理票据,代您考,代您考,代写毕,代写论,代孕,贷办,贷借款,贷开,戴海静,当代七整,当官要精,当官在于,党的官,党后萎,党前干劲,刀架保安,导的情人,导叫失,导人的最,导人最,导小商,到花心,得财兼,的同修,灯草和,等级證,等屁民,等人老百,等人是老,等人手术,邓爷爷转,邓玉娇,地产之歌,地下先烈,地震哥,帝国之梦,递纸死,点数优惠,电狗,电话监,电鸡,甸果敢,蝶舞按,丁香社,丁子霖,顶花心,东北独立,东复活,东京热,東京熱,洞小口紧,都当警,都当小姐,都进中央,毒蛇钻,独立台湾,赌球网,短信截,对日强硬,多美康,躲猫猫,俄羅斯,恶势力操,恶势力插,恩氟烷,儿园惨,儿园砍,儿园杀,儿园凶,二奶大,发牌绝,发票出,发票代,发票销,發票,法车仑,法伦功,法轮,法轮佛,法维权,法一轮,法院给废,法正乾,反测速雷,反雷达测,反屏蔽,范燕琼,方迷香,防电子眼,防身药水,房贷给废,仿真枪,仿真证,诽谤罪,费私服,封锁消,佛同修,夫妻交换,福尔马林,福娃的預,福娃頭上,福香巴,府包庇,府集中领,妇销魂,附送枪,复印件生,复印件制,富民穷,富婆给废,改号软件,感扑克,冈本真,肛交,肛门是邻,岡本真,钢针狗,钢珠枪,港澳博球,港馬會,港鑫華,高就在政,高考黑,高莺莺,搞媛交,告长期,告洋状,格证考试,各类考试,各类文凭,跟踪器,工程吞得,工力人,公安错打,公安网监,公开小姐,攻官小姐,共狗,共王储,狗粮,狗屁专家,鼓动一些,乖乖粉,官商勾,官也不容,官因发帖,光学真题,跪真相,滚圆大乳,国际投注,国家妓,国家软弱,国家吞得,国库折,国一九五七,國內美,哈药直销,海访民,豪圈钱,号屏蔽器,和狗交,和狗性,和狗做,黑火药的,红色恐怖,红外透视,紅色恐,胡江内斗,胡紧套,胡錦濤,胡适眼,胡耀邦,湖淫娘,虎头猎,华国锋,华门开,化学扫盲,划老公,还会吹萧,还看锦涛,环球证件,换妻,皇冠投注,黄冰,浑圆豪乳,活不起,火车也疯,机定位器,机号定,机号卫,机卡密,机屏蔽器,基本靠吼,绩过后付,激情电,激情短,激情妹,激情炮,级办理,级答案,急需嫖,集体打砸,集体腐,挤乳汁,擠乳汁,佳静安定,家一样饱,家属被打,甲虫跳,甲流了,奸成瘾,兼职上门,监听器,监听王,简易炸,江胡内斗,江太上,江系人,江贼民,疆獨,蒋彦永,叫自慰,揭贪难,姐包夜,姐服务,姐兼职,姐上门,金扎金,金钟气,津大地震,津地震,进来的罪,京地震,京要地震,经典谎言,精子射在,警察被,警察的幌,警察殴打,警察说保,警车雷达,警方包庇,警用品,径步枪,敬请忍,究生答案,九龙论坛,九评共,酒象喝汤,酒像喝汤,就爱插,就要色,举国体,巨乳,据说全民,绝食声,军长发威,军刺,军品特,军用手,开邓选,开锁工具,開碼,開票,砍杀幼,砍伤儿,康没有不,康跳楼,考答案,考后付款,考机构,考考邓,考联盟,考前答,考前答案,考前付,考设备,考试包过,考试保,考试答案,考试机构,考试联盟,考试枪,考研考中,考中答案,磕彰,克分析,克千术,克透视,空和雅典,孔摄像,控诉世博,控制媒,口手枪,骷髅死,快速办,矿难不公,拉登说,拉开水晶,来福猎,拦截器,狼全部跪,浪穴,老虎机,雷人女官,类准确答,黎阳平,李洪志,李咏曰,理各种证,理是影帝,理证件,理做帐报,力骗中央,力月西,丽媛离,利他林,连发手,聯繫電,炼大法,两岸才子,两会代,两会又三,聊视频,聊斋艳,了件渔袍,猎好帮手,猎枪销,猎槍,獵槍,领土拿,流血事,六合彩,六死,六四事,六月联盟,龙湾事件,隆手指,陆封锁,陆同修,氯胺酮,乱奸,乱伦类,乱伦小,亂倫,伦理大,伦理电影,伦理毛,伦理片,轮功,轮手枪,论文代,罗斯小姐,裸聊网,裸舞视,落霞缀,麻古,麻果配,麻果丸,麻将透,麻醉狗,麻醉枪,麻醉槍,麻醉藥,蟆叫专家,卖地财政,卖发票,卖银行卡,卖自考,漫步丝,忙爱国,猫眼工具,毛一鲜,媒体封锁,每周一死,美艳少妇,妹按摩,妹上门,门按摩,门保健,門服務,氓培训,蒙汗药,迷幻型,迷幻药,迷幻藥,迷昏口,迷昏药,迷昏藥,迷魂香,迷魂药,迷魂藥,迷奸药,迷情水,迷情药,迷藥,谜奸药,蜜穴,灭绝罪,民储害,民九亿商,民抗议,明慧网,铭记印尼,摩小姐,母乳家,木齐针,幕没有不,幕前戲,内射,南充针,嫩穴,嫩阴,泥马之歌,你的西域,拟涛哥,娘两腿之间,妞上门,浓精,怒的志愿,女被人家搞,女激情,女技师,女人和狗,女任职名,女上门,女優,鸥之歌,拍肩神药,拍肩型,牌分析,牌技网,炮的小蜜,陪考枪,配有消,喷尿,嫖俄罗,嫖鸡,平惨案,平叫到床,仆不怕饮,普通嘌,期货配,奇迹的黄,奇淫散,骑单车出,气狗,气枪,汽狗,汽枪,氣槍,铅弹,钱三字经,枪出售,枪的参,枪的分,枪的结,枪的制,枪货到,枪决女犯,枪决现场,枪模,枪手队,枪手网,枪销售,枪械制,枪子弹,强权政府,强硬发言,抢其火炬,切听器,窃听器,禽流感了,勤捞致,氢弹手,清除负面,清純壆,情聊天室,情妹妹,情视频,情自拍,氰化钾,氰化钠,请集会,请示威,请愿,琼花问,区的雷人,娶韩国,全真证,群奸暴,群起抗暴,群体性事,绕过封锁,惹的国,人权律,人体艺,人游行,人在云上,人真钱,认牌绝,任于斯国,柔胸粉,肉洞,肉棍,如厕死,乳交,软弱的国,赛后骚,三挫,三级片,三秒倒,三网友,三唑,骚妇,骚浪,骚穴,骚嘴,扫了爷爷,色电影,色妹妹,色视频,色小说,杀指南,山涉黑,煽动不明,煽动群众,上门激,烧公安局,烧瓶的,韶关斗,韶关玩,韶关旭,射网枪,涉嫌抄袭,深喉冰,神七假,神韵艺术,生被砍,生踩踏,生肖中特,圣战不息,盛行在舞,尸博,失身水,失意药,狮子旗,十八等,十大谎,十大禁,十个预言,十类人不,十七大幕,实毕业证,实体娃,实学历文,士康事件,式粉推,视解密,是躲猫,手变牌,手答案,手狗,手机跟,手机监,手机窃,手机追,手拉鸡,手木仓,手槍,守所死法,兽交,售步枪,售纯度,售单管,售弹簧刀,售防身,售狗子,售虎头,售火药,售假币,售健卫,售军用,售猎枪,售氯胺,售麻醉,售冒名,售枪支,售热武,售三棱,售手枪,售五四,售信用,售一元硬,售子弹,售左轮,书办理,熟妇,术牌具,双管立,双管平,水阎王,丝护士,丝情侣,丝袜保,丝袜恋,丝袜美,丝袜妹,丝袜网,丝足按,司长期有,司法黑,私房写真,死法分布,死要见毛,四博会,四大扯个,四小码,苏家屯集,诉讼集团,素女心,速代办,速取证,酸羟亚胺,蹋纳税,太王四神,泰兴幼,泰兴镇中,泰州幼,贪官也辛,探测狗,涛共产,涛一样胡,特工资,特码,特上门,体透视镜,替考,替人体,天朝特,天鹅之旅,天推广歌,田罢工,田田桑,田停工,庭保养,庭审直播,通钢总经,偷電器,偷肃贪,偷听器,偷偷贪,头双管,透视功能,透视镜,透视扑,透视器,透视眼镜,透视药,透视仪,秃鹰汽,突破封锁,突破网路,推油按,脱衣艳,瓦斯手,袜按摩,外透视镜,外围赌球,湾版假,万能钥匙,万人骚动,王立军,王益案,网民案,网民获刑,网民诬,微型摄像,围攻警,围攻上海,维汉员,维权基,维权人,维权谈,委坐船,谓的和谐,温家堡,温切斯特,温影帝,溫家寶,瘟加饱,瘟假饱,文凭证,文强,纹了毛,闻被控制,闻封锁,瓮安,我的西域,我搞台独,乌蝇水,无耻语录,无码专,五套功,五月天,午夜电,午夜极,武警暴,武警殴,武警已增,务员答案,务员考试,雾型迷,西藏限,西服进去,希脏,习进平,习晋平,席复活,席临终前,席指着护,洗澡死,喜贪赃,先烈纷纷,现大地震,现金投注,线透视镜,限制言,陷害案,陷害罪,相自首,香港论坛,香港马会,香港一类,香港总彩,硝化甘,小穴,校骚乱,协晃悠,写两会,泄漏的内,新建户,新疆叛,新疆限,新金瓶,新唐人,信访专班,信接收器,兴中心幼,星上门,行长王益,形透视镜,型手枪,姓忽悠,幸运码,性爱日,性福情,性感少,性推广歌,胸主席,徐玉元,学骚乱,学位證,學生妹,丫与王益,烟感器,严晓玲,言被劳教,言论罪,盐酸曲,颜射,恙虫病,姚明进去,要人权,要射精了,要射了,要泄了,夜激情,液体炸,一小撮别,遗情书,蚁力神,益关注组,益受贿,阴间来电,陰唇,陰道,陰戶,淫魔舞,淫情女,淫肉,淫騷妹,淫兽,淫兽学,淫水,淫穴,隐形耳,隐形喷剂,应子弹,婴儿命,咏妓,用手枪,幽谷三,游精佑,有奶不一,右转是政,幼齿类,娱乐透视,愚民同,愚民政,与狗性,玉蒲团,育部女官,冤民大,鸳鸯洗,园惨案,园发生砍,园砍杀,园凶杀,园血案,原一九五七,原装弹,袁腾飞,晕倒型,韵徐娘,遭便衣,遭到警,遭警察,遭武警,择油录,曾道人,炸弹教,炸弹遥控,炸广州,炸立交,炸药的制,炸药配,炸药制,张春桥,找枪手,找援交,找政法委副,赵紫阳,针刺案,针刺伤,针刺事,针刺死,侦探设备,真钱斗地,真钱投注,真善忍,真实文凭,真实资格,震惊一个民,震其国土,证到付款,证件办,证件集团,证生成器,证书办,证一次性,政府操,政论区,證件,植物冰,殖器护,指纹考勤,指纹膜,指纹套,至国家高,志不愿跟,制服诱,制手枪,制证定金,制作证件,中的班禅,中共黑,中国不强,种公务员,种学历证,众像羔,州惨案,州大批贪,州三箭,宙最高法,昼将近,主席忏,住英国房,助考,助考网,专业办理,专业代,专业代写,专业助,转是政府,赚钱资料,装弹甲,装枪套,装消音,着护士的胸,着涛哥,姿不对死,资格證,资料泄,梓健特药,字牌汽,自己找枪,自慰用,自由圣,自由亚,总会美女,足球玩法,最牛公安,醉钢枪,醉迷药,醉乙醚,尊爵粉,左转是政,作弊器,作各种证,作硝化甘,唑仑,做爱小,做原子弹,做证件', 'textarea', '', '评论相关禁止关键字', 0),
(71, '是否开启评论', 'forum', 'forum_is_comment', '0', 'checker', '', '1开启，0关闭', 0),
(68, '设置安全验证方式', 'email', 'email_host_SMTPSecure', 'ssl', 'text', '', '默认为ssl', 0),
(73, '是否开启帖子审核', 'forum', 'forum_post_audit', '0', 'checker', '', '1开启，0关闭', 0);

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `and_addons`
--
ALTER TABLE `and_addons`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `and_auth_rule_group`
--
ALTER TABLE `and_auth_rule_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `and_hooks`
--
ALTER TABLE `and_hooks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

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
-- Indexes for table `and_nav`
--
ALTER TABLE `and_nav`
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
-- 使用表AUTO_INCREMENT `and_addons`
--
ALTER TABLE `and_addons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键';

--
-- 使用表AUTO_INCREMENT `and_admin_user`
--
ALTER TABLE `and_admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `and_attachment`
--
ALTER TABLE `and_attachment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- 使用表AUTO_INCREMENT `and_auth_group`
--
ALTER TABLE `and_auth_group`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `and_auth_rule`
--
ALTER TABLE `and_auth_rule`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- 使用表AUTO_INCREMENT `and_auth_rule_group`
--
ALTER TABLE `and_auth_rule_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `and_hooks`
--
ALTER TABLE `and_hooks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键';

--
-- 使用表AUTO_INCREMENT `and_log`
--
ALTER TABLE `and_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=386;

--
-- 使用表AUTO_INCREMENT `and_module`
--
ALTER TABLE `and_module`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主题ID', AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `and_nav`
--
ALTER TABLE `and_nav`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- 使用表AUTO_INCREMENT `and_system_config`
--
ALTER TABLE `and_system_config`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- 使用表AUTO_INCREMENT `and_theme`
--
ALTER TABLE `and_theme`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主题ID', AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
