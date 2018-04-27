SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `and_admin_user`;
CREATE TABLE IF NOT EXISTS `and_admin_user` (
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
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除状态:0正常,1已删除',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `salt` char(6) NOT NULL DEFAULT '0' COMMENT '密码加盐处理'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS `and_attachment`;
CREATE TABLE IF NOT EXISTS `and_attachment` (
  `id` int(10)  NOT NULL,
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



DROP TABLE IF EXISTS `and_auth_group`;
CREATE TABLE IF NOT EXISTS `and_auth_group` (
  `id` int(11)  NOT NULL,
  `title` char(100) NOT NULL DEFAULT '',
  `intro` varchar(30) NOT NULL DEFAULT '' COMMENT '角色介绍',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1正常，0禁用',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `rules` text NOT NULL COMMENT '权限规则ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组表';


INSERT INTO `and_auth_group` (`id`, `title`, `intro`, `status`, `is_admin`, `rules`) VALUES
(1, '超级管理员', '超级管理员', 1, 1, '71,72,73,77,64,65,69,70,78,94,83,103,107,35,36,74,85,86,87,88,75,76,91,93,95,96,97,98,99,100,101,102,92,79,104,81,105,106,89,90,2,10,50,51,54,55,44,45,46,47,48,49,3,12,52,58,59,26,25,27,13,61,53,60,28,30,29,31,4,14,9,23,24,8,20,21,22,7,17,18,19,6,16,5,15,1,56,57,40,41,42,43,39,38,32,33,34,37'),
(2, '测试管理员', '测试管理员', 1, 1, '7,17,3,13,61,60,53,31,30,29,28,12,59,1,43'),
(3, '普通会员', '普通会员', 1, 0, '91,95,93,96,97,99,100,101,102,98,108,92'),
(4, '论坛版主', '论坛版主', 1, 0, '');



DROP TABLE IF EXISTS `and_auth_group_access`;
CREATE TABLE IF NOT EXISTS `and_auth_group_access` (
  `admin_user_id` mediumint(8) UNSIGNED NOT NULL,
  `auth_group_id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '会员ID',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：0关闭，1开启'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组规则表';



INSERT INTO `and_auth_group_access` (`admin_user_id`, `auth_group_id`, `user_id`, `status`) VALUES
(1, 3, 0, 1),
(3, 2, 0, 1),
(2, 2, 0, 1),
(0, 4, 16, 0),
(0, 3, 16, 1),
(1, 1, 0, 1),
(0, 2, 16, 0),
(0, 3, 22, 1),
(0, 3, 21, 1),
(0, 3, 23, 1),
(0, 3, 25, 1),
(0, 4, 25, 0);



DROP TABLE IF EXISTS `and_auth_rule`;
CREATE TABLE IF NOT EXISTS `and_auth_rule` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '规则名称',
  `title` varchar(20) NOT NULL,
  `description` varchar(50) NOT NULL DEFAULT '' COMMENT '描述',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT ' 	1权限+菜单2只作为菜单 ',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1显示；2隐藏 ',
  `pid` smallint(5) UNSIGNED NOT NULL COMMENT '父级ID',
  `group_id` int(10) NOT NULL DEFAULT '1' COMMENT '分类ID',
  `icon` varchar(20) DEFAULT '' COMMENT '图标',
  `orders` int(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `condition` char(100) DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='规则表';



INSERT INTO `and_auth_rule` (`id`, `name`, `title`, `description`, `type`, `status`, `pid`, `group_id`, `icon`, `orders`, `condition`) VALUES
(1, 'admin/SystemConfig/index', '系统配置', '', 1, 1, 0, 1, 'fa-gears', 0, ''),
(2, 'admin/SystemConfig/_list', '全局配置', '', 1, 1, 1, 1, '', 0, ''),
(3, 'admin/SystemConfig/add', '添加配置项', '', 1, 1, 2, 1, '', 0, ''),
(4, 'admin/SystemConfig/edit', '修改配置项', '', 1, 1, 2, 1, '', 0, ''),
(5, 'admin/SystemConfig/delete', '删除配置项', '', 1, 1, 2, 1, '', 0, ''),
(6, 'admin/SystemConfig/update_value', '单点更新配置项数值', '', 1, 1, 2, 1, '', 0, ''),
(7, 'admin/SystemConfig/save', '提交添加配置项', '', 1, 1, 2, 1, '', 0, ''),
(8, 'admin/SystemConfig/update', '提交修改配置项', '', 1, 1, 2, 1, '', 0, ''),
(9, 'admin/Auth/index', '权限管理', '', 1, 1, 0, 1, 'fa-sitemap', 0, ''),
(10, 'admin/AuthRule/_list', '权限列表', '', 1, 1, 9, 1, '', 0, ''),
(11, 'admin/AuthRule/add', '添加权限节点', '', 1, 1, 10, 1, '', 0, ''),
(12, 'admin/AuthRule/edit', '修改权限节点', '', 1, 1, 10, 1, '', 0, ''),
(13, 'admin/AuthRule/delete', '删除权限节点', '', 1, 1, 10, 1, '', 0, ''),
(14, 'admin/AuthRule/orders', '更新权限规则排序', '', 1, 1, 10, 1, '', 0, ''),
(15, 'admin/AuthRule/save', '提交添加权限', '', 1, 1, 10, 1, '', 0, ''),
(16, 'admin/AuthRule/update', '提交修改权限', '', 1, 1, 10, 1, '', 0, ''),
(17, 'admin/AuthGroup/_list', '角色列表', '', 1, 1, 9, 1, '', 0, ''),
(18, 'admin/AuthGroup/add', '添加角色类', '', 1, 1, 17, 1, '', 0, ''),
(19, 'admin/AuthGroup/edit', '修改角色类', '', 1, 1, 17, 1, '', 0, ''),
(20, 'admin/AuthGroup/delete', '删除角色类', '', 1, 1, 17, 1, '', 0, ''),
(21, 'admin/AuthGroup/edit_rule', '角色授权', '', 1, 1, 17, 1, '', 0, ''),
(22, 'admin/AuthGroup/update_rule', '更新角色状态', '更新角色类状态 开启|禁止', 1, 1, 17, 1, '', 0, ''),
(23, 'admin/AuthGroup/save', '提交添加角色', '', 1, 1, 17, 1, '', 0, ''),
(24, 'admin/AuthGroup/update', '提交修改角色', '', 1, 1, 17, 1, '', 0, ''),
(25, 'admin/AuthRuleGroup/index', '后台导航', '', 1, 1, 0, 1, 'fa-map-signs', 0, ''),
(26, 'admin/AuthRuleGroup/_list', '导航列表', '', 1, 1, 25, 1, '', 0, ''),
(27, 'admin/Site/index', '网站配置', '', 1, 1, 0, 2, 'fa-cog', 0, ''),
(28, 'admin/Site/config_email', '邮箱配置', '', 1, 1, 27, 2, 'fa-envelope', 0, ''),
(29, 'admin/Site/config_sms', '短信配置', '', 1, 1, 27, 2, 'fa-commenting', 0, ''),
(30, 'admin/Site/config_add', '提交修改', '', 1, 2, 27, 2, '', 0, ''),
(31, 'admin/Nav/index', '导航管理', '', 1, 1, 0, 2, 'fa-link', 0, ''),
(32, 'admin/Nav/home', '首页导航', '', 1, 1, 31, 2, '', 0, ''),
(33, 'admin/Nav/portal', '门户导航', '', 1, 1, 31, 2, 'fa-link', 0, ''),
(34, 'admin/Nav/user', '用户中心导航', '', 1, 1, 31, 2, '', 0, ''),
(35, 'admin/Nav/forum', '论坛导航', '', 1, 1, 31, 2, 'fa-forumbee', 0, ''),
(36, 'admin/Nav/mall', '购物中心导航', '', 1, 1, 31, 2, '', 0, ''),
(37, 'admin/Theme/index', '主题管理', '', 1, 1, 0, 2, 'fa-desktop', 0, ''),
(38, 'admin/Theme/_list', '主题列表', '', 1, 1, 37, 2, '', 0, ''),
(39, 'admin/Theme/add', '添加主题', '', 1, 1, 38, 2, '', 0, ''),
(40, 'admin/Theme/save', '提交添加', '', 1, 1, 38, 2, '', 0, ''),
(41, 'admin/Theme/delete', '删除主题', '', 1, 1, 38, 2, '', 0, ''),
(42, 'admin/Theme/update_status', '更新状态', '', 1, 1, 38, 2, '', 0, ''),
(43, 'admin/AdminUser/index', '后台管理员', '', 1, 1, 0, 3, 'fa-users', 0, ''),
(44, 'admin/AdminUser/_list', '管理成员', '', 1, 1, 43, 3, '', 0, ''),
(45, 'admin/AdminUser/add', '添加管理员', '', 1, 1, 44, 3, '', 0, ''),
(46, 'admin/AdminUser/edit', '修改管理员', '', 1, 1, 44, 3, '', 0, ''),
(47, 'admin/AdminUser/delete', '删除管理员', '', 1, 1, 44, 3, '', 0, ''),
(48, 'admin/AdminUser/update_status', '单点更新管理员状态值', '', 1, 1, 44, 3, '', 0, ''),
(49, 'admin/AdminUser/enable', '批量启用管理员账户', '', 1, 1, 44, 3, '', 0, ''),
(50, 'admin/AdminUser/prohibit', '批量禁用管理员账户', '', 1, 1, 44, 3, '', 0, ''),
(51, 'admin/AdminUser/delete_all', '批量删除管理员账户', '', 1, 1, 44, 3, '', 0, ''),
(52, 'admin/AdminUser/reset_password', '批量重置管理员账户密码 ', '', 1, 1, 44, 3, '', 0, ''),
(53, 'admin/AdminUser/save', '提交添加管理员', '', 1, 1, 44, 3, '', 0, ''),
(54, 'admin/AdminUser/update', '提交修改管理员', '', 1, 1, 44, 3, '', 0, ''),
(55, 'admin/User/index', '会员管理', '', 1, 1, 0, 3, 'fa-address-card ', 0, ''),
(56, 'admin/User/_list', '会员列表', '', 1, 1, 55, 3, 'fa-address-book', 0, ''),
(57, 'admin/User/select', '获取会员信息', '', 1, 1, 56, 3, '', 0, ''),
(58, 'admin/User/update_status', '更新会员状态', '', 1, 1, 56, 3, '', 0, ''),
(59, 'admin/User/add', '添加会员', '', 1, 1, 56, 3, '', 0, ''),
(60, 'admin/User/save', '提交添加会员', '', 1, 1, 56, 3, '', 0, ''),
(61, 'admin/User/edit', '编辑会员', '', 1, 1, 56, 3, '', 0, ''),
(62, 'admin/User/update', '更新会员', '', 1, 1, 56, 3, '', 0, ''),
(63, 'admin/User/delete', '删除会员', '', 1, 1, 56, 3, '', 0, ''),
(64, 'admin/User/config_register', '注册配置', '', 1, 1, 55, 3, '', 0, ''),
(65, 'admin/User/sign', '会员签到', '', 1, 1, 55, 3, '', 0, '');


DROP TABLE IF EXISTS `and_auth_rule_group`;
CREATE TABLE IF NOT EXISTS `and_auth_rule_group` (
  `id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL DEFAULT '导航标题' COMMENT '导航标题',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态:0不显示，1显示',
  `orders` int(10) NOT NULL DEFAULT '0' COMMENT '排序'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `and_auth_rule_group` (`id`, `title`, `status`, `orders`) VALUES
(1, '系统', 1, 0),
(2, '站点', 1, 0),
(3, '用户', 1, 0),
(4, '门户', 1, 0),
(5, '论坛', 1, 0),
(6, '商城', 1, 0),
(7, '小程序', 1, 0);


DROP TABLE IF EXISTS `and_nav`;
CREATE TABLE IF NOT EXISTS `and_nav` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) NOT NULL DEFAULT '1' COMMENT '分组ID',
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



DROP TABLE IF EXISTS `and_nav_group`;
CREATE TABLE IF NOT EXISTS `and_nav_group` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '标识',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `and_nav_group` (`id`, `name`, `title`) VALUES
(1, 'home', '默认首页'),
(2, 'forum', '论坛');



DROP TABLE IF EXISTS `and_system_config`;
CREATE TABLE IF NOT EXISTS `and_system_config` (
  `id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `group` varchar(15) NOT NULL DEFAULT '' COMMENT '组类',
  `vari` varchar(32) NOT NULL,
  `value` text NOT NULL,
  `type` enum('text','image','textarea','file','checkbox','radio','select','checker','array','keyvalue','password','color') NOT NULL,
  `options` text NOT NULL,
  `info` text NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


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
(11, '注册邮箱认证', 'system', 'is_email_verify', '0', 'checker', '', '如果勾选，注册的时候必须通过邮箱认证', 0),
(12, '服务器地址', 'email', 'email_host', 'smtpdm.aliyun.com', 'text', '', '', 0),
(13, 'SMTP服务器用户名', 'email', 'email_host_username', 'auto@andphp.com', 'text', '', '', 0),
(14, 'SMTP服务器密码', 'email', 'email_host_password', 'AndPHP1234', 'password', '', '', 0),
(15, 'SMTP服务器的端口号', 'email', 'email_host_port', '465', 'text', '', '', 0),
(16, 'accessKeyId', 'sms', 'sms_keyid', '', 'text', '', '填写阿里大于短信接口accessKeyId', 0),
(17, 'accessKeySecret', 'sms', 'sms_keysecret', '', 'text', '', '填写阿里大于短信接口accessKeySecret', 0),
(18, '储存位置', 'system', 'location', '0', 'text', '{\"0\":\"本地\"，\"1\":\"七牛云\"}', '文件、图片上传储存位置', 0),
(19, '文件上传类型', 'syetem', 'file_type', 'jpg,png,gif,mp4,zip,jpeg', 'text', '', '文件上传类型', 0),
(20, '文件上传大小', 'syetem', 'file_size', '20', 'text', '', '单位：M', 0),
(21, '默认账户密码', 'system', 'default_password', '111111', 'text', '', '设置初始值、重置密码', 0),
(22, '是否开启注册', 'user', 'user_join_on', '1', 'checker', '{\"0\":\"关闭注册\",\"1\":\"开启注册\"}', '', 0),
(23, '保留关键字', 'user', 'user_banned_title', 'account,activate,add,admin,administrator,api,app,apps,archive,archives,auth,better,blog,cache,cancel,careers,cart,changelog,checkout,codereview,compare,config,configuration,connect,contact,create,delete,direct_messages,documentation,download,downloads,edit,email,employment,enterprise,facebook,faq,favorites,feed,feedback,feeds,fleet,fleets,follow,followers,following,friend,friends,gist,group,groups,help,home,hosting,hostmaster,idea,ideas,index,info,invitations,invite,is,it,job,jobs,json,language,languages,lists,login,logout,logs,mail,map,maps,mine,mis,news,oauth,oauth_clients,offers,openid,order,orders,organizations,plans,popular,post,postmaster,privacy,projects,put,recruitment,register,remove,replies,root,rss,sales,save,search,security,sessions,settings,shop,signup,sitemap,ssl,ssladmin,ssladministrator,sslwebmaster,status,stories,styleguide,subscribe,subscriptions,support,sysadmin,sysadministrator,terms,tour,translations,trends,twitter,twittr,unfollow,unsubscribe,update,url,user,weather,webmaster,widget,widgets,wiki,ww,www,wwww,xfn,xml,xmpp,yaml,yml,*administrator,*admin,*manage,*管理,*超级版主,*分版版主,*版主,*斑竹,*吧主,*霸主,*超版,*站长,*社区,*元老,*官方,*赚零花钱*赚钱*零花钱,*zlhq,*51zlhq*zhuanlinghuaqianzuanlinghuaqian*<,*>,*@,*php,*asp,*html*javac  *www,*com,*cn,*cc,*net,*org,*cc,*tk,*公司,*gov.cn,*top,*name,*info,*biz,*tm ,*mn,*in,*pro,*net.cn ,*travel ,*ag,*cm ,*com.hk ,*org.cn,*sh ,*ws,*vc,*co,*com.tw,*黑社会,*黑客,*网*成人,*政治,*文学,*作家,*文章,*作品,*昵称,*名字,*名称,*人名,*建行,*农行,*工行,*招行,*邮政,*银行,*关注,*访问,*进入,*打开,*点击,*自定义,*头衔,*关键字,*关键词,*统配符,*网页,*电脑,*资料,*文件,*文档,*浏览器,*保留*存档开始结束*重启,*windows,*win,*主席,*首席,*公司,*总经理,*董事,*老板,*CEO,*投资商,*股东,*游戏,*刷机,*刷级,*攻击,*安全,*卫士,*杀毒,*软件,*网页,*聊天,*浏览,*大全,*系列,*导航,*定位,*模式,*盈利,*赢利,*电话,*手机,*app,*病毒,*木马,*站,*贷款,*利息,*套现,*启示,*招聘,*代办,*代考,*证件,*传销,*商标,*注册,*转让,*查询,*求购,*策划,*托管,*评估,*质押,*检测,*驳回,*续展,*保护,*复审,*近似,*委托,*交易,*平台,*服务,*代理,*机构*logo图标标志安卓苹果设计*iphone,*android,*旺旺,*球球,*歪歪,*千牛,*匿名,*倪明,*佚名,*未知,*康盛,*客服,*咨询,*免费,*意见,*建议,*投诉,*人气,*最新,*推荐,*置顶,*排名,*搜索,*友情,*链接,*连接,*禁止,*严重,*yy,*Discuz,*Comsenz,*中国,*共产党,*中央,*中华,*人民,*百姓,*河北,*山西,*辽宁,*吉林,*黑龙江,*江苏,*浙江,*安徽,*福建,*江西,*山东,*河南,*湖北,*湖南,*广东,*海南,*四川,*贵州,*云南,*陕西,*甘肃,*青海,*台湾,*成都,*德阳,*内蒙古,*广西,*西藏,*宁夏,*新疆,*北京,*天津,*上海,*重庆,*香港,*澳门*特别*行政区*组织你好,*党中央,*法轮功,*藏独,*习近平,*彭丽媛,*奥巴马,*普京,*安倍,*安培,*韩国,*美国,*英国*日本*公安,*派出所,*招待所,*KTV,*迪厅,*迪吧,*酒吧,*夜店,*舞女,*做鸭,*黄,*迷药,*骗子,*欺诈,*fuck,*操,*艹,*靠,*日,*kao,*cao,*流氓,*se,*色,*性爱,*肏,*尼玛,*你妈,*逼,*穴,*屌,*骚,*baidu,*百度,*xiaomi,*小米,*taobao,*淘宝,*jingdong,*京东,*tmall,*天猫,*sina,*新浪,*weibo,*微博,*weixin,*微信,*gongzhong,*公众,*tengxun,*腾讯,*扣扣,*163,*网易,*sohu,*搜狐,*xunlei,*讯雷,*gougou,*狗狗,*iask,*爱问,*youku,*优酷,*56,*我乐,*hao123,*好123,*58同城,*借贷宝,*广发,*聚财猫,*温商贷,*理财,*电信,*移动,*联通,*中国平安', 'textarea', '', '', 0),
(24, '奖励积分规则', 'user', 'user_sign_policy', '0<7&10,7<14&20,14<30&30,30<90&40,90<180&50', 'textarea', '', '英文半角逗号分隔多个规则,冒号分隔规则名称', 0),
(25, '积分', 'user', 'point', '积分,点,fa-star-half-o,50', 'text', '', '', 0),
(26, '财富', 'user', 'money', '金币,枚,fa-home,20', 'text', '', '财富', 0),
(27, '是否开启签到', 'user', 'user_is_sign', '1', 'checker', '', '1开启，0关闭', 0),
(28, '找回密码邮件模板', 'email', 'email_template_resetPassword', '<p>您好，<b>{username}</b> ：</p><p>您正在找回<b> {site_title}</b> 网站登录密码！如果是你本人进行的操作，请点击下面的链接来认证您的邮箱。否则，请忽略该邮件。</p><p>{url}</p><p>如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中认证。</p><p><br></p>', 'textarea', '', '', 0),
(29, '邮箱激活邮件模板', 'email', 'email_template_validate', '<p>Hi，<b>{username}</b>：</p><p>欢迎加入 <b>{site_title}</b>！请点击下面的链接来认证您的邮箱。</p><p>{url}</p><p>如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中认证。</p><p><br></p>', 'textarea', '', '', 0),
(30, '和谐评论', 'comment', 'comment_banned_title', '爱爱,性行为,性交,打炮,约炮,性虐,肛交,口交,群交,群P,群p,3P,3p,三P,三p,强奸,猥亵,轮奸,诱奸,迷奸,强暴,鸡巴,阴茎,睾丸,生殖器,大保健,一夜情,换妻,卖淫,嫖娼,打飞机,兽交,鸡奸,毒品,冰毒,摇头丸,海洛因,大麻,K粉,k粉,枪,中共,共产党,习近平,李克强,张德江,俞正声,刘云山,王岐山,张高丽,江泽民,朱镕基,邓小平,李鹏,胡景涛,温家宝,文革 阿扁推翻,阿宾,阿賓,挨了一炮,爱液横流,安街逆,安局办公楼,安局豪华,安门事,安眠藥,案的准确,八九民,八九学,八九政治,把病人整,把邓小平,把学生整,罢工门,白黄牙签,败培训,办本科,办理本科,办理各种,办理票据,办理文凭,办理真实,办理证书,办理资格,办文凭,办怔,办证,半刺刀,辦毕业,辦證,谤罪获刑,磅解码器,磅遥控器,宝在甘肃修,保过答案,报复执法,爆发骚,北省委门,被打死,被指抄袭,被中共,本公司担,本无码,毕业證,变牌绝,辩词与梦,冰毒,冰火毒,冰火佳,冰火九重,冰火漫,冰淫传,冰在火上,波推龙,博彩娱,博会暂停,博园区伪,不查都,不查全,不思四化,布卖淫女,部忙组阁,部是这样,才知道只生,财众科技,采花堂,踩踏事,苍山兰,苍蝇水,藏春阁,藏獨,操了嫂,操嫂子,策没有不,插屁屁,察象蚂,拆迁灭,车牌隐,成人电,成人卡通,成人聊,成人片,成人视,成人图,成人文,成人小,城管灭,惩公安,惩贪难,充气娃,冲凉死,抽着大中,抽着芙蓉,出成绩付,出售发票,出售军,穿透仪器,春水横溢,纯度白,纯度黄,次通过考,催眠水,催情粉,催情药,催情藥,挫仑,达毕业证,答案包,答案提供,打飞机专,打死经过,打死人,打砸办公,大鸡巴,大雞巴,大纪元,大揭露,大奶子,大批贪官,大肉棒,大嘴歌,代办发票,代办各,代办文,代办学,代办制,代辦,代表烦,代理发票,代理票据,代您考,代您考,代写毕,代写论,代孕,贷办,贷借款,贷开,戴海静,当代七整,当官要精,当官在于,党的官,党后萎,党前干劲,刀架保安,导的情人,导叫失,导人的最,导人最,导小商,到花心,得财兼,的同修,灯草和,等级證,等屁民,等人老百,等人是老,等人手术,邓爷爷转,邓玉娇,地产之歌,地下先烈,地震哥,帝国之梦,递纸死,点数优惠,电狗,电话监,电鸡,甸果敢,蝶舞按,丁香社,丁子霖,顶花心,东北独立,东复活,东京热,東京熱,洞小口紧,都当警,都当小姐,都进中央,毒蛇钻,独立台湾,赌球网,短信截,对日强硬,多美康,躲猫猫,俄羅斯,恶势力操,恶势力插,恩氟烷,儿园惨,儿园砍,儿园杀,儿园凶,二奶大,发牌绝,发票出,发票代,发票销,發票,法车仑,法伦功,法轮,法轮佛,法维权,法一轮,法院给废,法正乾,反测速雷,反雷达测,反屏蔽,范燕琼,方迷香,防电子眼,防身药水,房贷给废,仿真枪,仿真证,诽谤罪,费私服,封锁消,佛同修,夫妻交换,福尔马林,福娃的預,福娃頭上,福香巴,府包庇,府集中领,妇销魂,附送枪,复印件生,复印件制,富民穷,富婆给废,改号软件,感扑克,冈本真,肛交,肛门是邻,岡本真,钢针狗,钢珠枪,港澳博球,港馬會,港鑫華,高就在政,高考黑,高莺莺,搞媛交,告长期,告洋状,格证考试,各类考试,各类文凭,跟踪器,工程吞得,工力人,公安错打,公安网监,公开小姐,攻官小姐,共狗,共王储,狗粮,狗屁专家,鼓动一些,乖乖粉,官商勾,官也不容,官因发帖,光学真题,跪真相,滚圆大乳,国际投注,国家妓,国家软弱,国家吞得,国库折,国一九五七,國內美,哈药直销,海访民,豪圈钱,号屏蔽器,和狗交,和狗性,和狗做,黑火药的,红色恐怖,红外透视,紅色恐,胡江内斗,胡紧套,胡錦濤,胡适眼,胡耀邦,湖淫娘,虎头猎,华国锋,华门开,化学扫盲,划老公,还会吹萧,还看锦涛,环球证件,换妻,皇冠投注,黄冰,浑圆豪乳,活不起,火车也疯,机定位器,机号定,机号卫,机卡密,机屏蔽器,基本靠吼,绩过后付,激情电,激情短,激情妹,激情炮,级办理,级答案,急需嫖,集体打砸,集体腐,挤乳汁,擠乳汁,佳静安定,家一样饱,家属被打,甲虫跳,甲流了,奸成瘾,兼职上门,监听器,监听王,简易炸,江胡内斗,江太上,江系人,江贼民,疆獨,蒋彦永,叫自慰,揭贪难,姐包夜,姐服务,姐兼职,姐上门,金扎金,金钟气,津大地震,津地震,进来的罪,京地震,京要地震,经典谎言,精子射在,警察被,警察的幌,警察殴打,警察说保,警车雷达,警方包庇,警用品,径步枪,敬请忍,究生答案,九龙论坛,九评共,酒象喝汤,酒像喝汤,就爱插,就要色,举国体,巨乳,据说全民,绝食声,军长发威,军刺,军品特,军用手,开邓选,开锁工具,開碼,開票,砍杀幼,砍伤儿,康没有不,康跳楼,考答案,考后付款,考机构,考考邓,考联盟,考前答,考前答案,考前付,考设备,考试包过,考试保,考试答案,考试机构,考试联盟,考试枪,考研考中,考中答案,磕彰,克分析,克千术,克透视,空和雅典,孔摄像,控诉世博,控制媒,口手枪,骷髅死,快速办,矿难不公,拉登说,拉开水晶,来福猎,拦截器,狼全部跪,浪穴,老虎机,雷人女官,类准确答,黎阳平,李洪志,李咏曰,理各种证,理是影帝,理证件,理做帐报,力骗中央,力月西,丽媛离,利他林,连发手,聯繫電,炼大法,两岸才子,两会代,两会又三,聊视频,聊斋艳,了件渔袍,猎好帮手,猎枪销,猎槍,獵槍,领土拿,流血事,六合彩,六死,六四事,六月联盟,龙湾事件,隆手指,陆封锁,陆同修,氯胺酮,乱奸,乱伦类,乱伦小,亂倫,伦理大,伦理电影,伦理毛,伦理片,轮功,轮手枪,论文代,罗斯小姐,裸聊网,裸舞视,落霞缀,麻古,麻果配,麻果丸,麻将透,麻醉狗,麻醉枪,麻醉槍,麻醉藥,蟆叫专家,卖地财政,卖发票,卖银行卡,卖自考,漫步丝,忙爱国,猫眼工具,毛一鲜,媒体封锁,每周一死,美艳少妇,妹按摩,妹上门,门按摩,门保健,門服務,氓培训,蒙汗药,迷幻型,迷幻药,迷幻藥,迷昏口,迷昏药,迷昏藥,迷魂香,迷魂药,迷魂藥,迷奸药,迷情水,迷情药,迷藥,谜奸药,蜜穴,灭绝罪,民储害,民九亿商,民抗议,明慧网,铭记印尼,摩小姐,母乳家,木齐针,幕没有不,幕前戲,内射,南充针,嫩穴,嫩阴,泥马之歌,你的西域,拟涛哥,娘两腿之间,妞上门,浓精,怒的志愿,女被人家搞,女激情,女技师,女人和狗,女任职名,女上门,女優,鸥之歌,拍肩神药,拍肩型,牌分析,牌技网,炮的小蜜,陪考枪,配有消,喷尿,嫖俄罗,嫖鸡,平惨案,平叫到床,仆不怕饮,普通嘌,期货配,奇迹的黄,奇淫散,骑单车出,气狗,气枪,汽狗,汽枪,氣槍,铅弹,钱三字经,枪出售,枪的参,枪的分,枪的结,枪的制,枪货到,枪决女犯,枪决现场,枪模,枪手队,枪手网,枪销售,枪械制,枪子弹,强权政府,强硬发言,抢其火炬,切听器,窃听器,禽流感了,勤捞致,氢弹手,清除负面,清純壆,情聊天室,情妹妹,情视频,情自拍,氰化钾,氰化钠,请集会,请示威,请愿,琼花问,区的雷人,娶韩国,全真证,群奸暴,群起抗暴,群体性事,绕过封锁,惹的国,人权律,人体艺,人游行,人在云上,人真钱,认牌绝,任于斯国,柔胸粉,肉洞,肉棍,如厕死,乳交,软弱的国,赛后骚,三挫,三级片,三秒倒,三网友,三唑,骚妇,骚浪,骚穴,骚嘴,扫了爷爷,色电影,色妹妹,色视频,色小说,杀指南,山涉黑,煽动不明,煽动群众,上门激,烧公安局,烧瓶的,韶关斗,韶关玩,韶关旭,射网枪,涉嫌抄袭,深喉冰,神七假,神韵艺术,生被砍,生踩踏,生肖中特,圣战不息,盛行在舞,尸博,失身水,失意药,狮子旗,十八等,十大谎,十大禁,十个预言,十类人不,十七大幕,实毕业证,实体娃,实学历文,士康事件,式粉推,视解密,是躲猫,手变牌,手答案,手狗,手机跟,手机监,手机窃,手机追,手拉鸡,手木仓,手槍,守所死法,兽交,售步枪,售纯度,售单管,售弹簧刀,售防身,售狗子,售虎头,售火药,售假币,售健卫,售军用,售猎枪,售氯胺,售麻醉,售冒名,售枪支,售热武,售三棱,售手枪,售五四,售信用,售一元硬,售子弹,售左轮,书办理,熟妇,术牌具,双管立,双管平,水阎王,丝护士,丝情侣,丝袜保,丝袜恋,丝袜美,丝袜妹,丝袜网,丝足按,司长期有,司法黑,私房写真,死法分布,死要见毛,四博会,四大扯个,四小码,苏家屯集,诉讼集团,素女心,速代办,速取证,酸羟亚胺,蹋纳税,太王四神,泰兴幼,泰兴镇中,泰州幼,贪官也辛,探测狗,涛共产,涛一样胡,特工资,特码,特上门,体透视镜,替考,替人体,天朝特,天鹅之旅,天推广歌,田罢工,田田桑,田停工,庭保养,庭审直播,通钢总经,偷電器,偷肃贪,偷听器,偷偷贪,头双管,透视功能,透视镜,透视扑,透视器,透视眼镜,透视药,透视仪,秃鹰汽,突破封锁,突破网路,推油按,脱衣艳,瓦斯手,袜按摩,外透视镜,外围赌球,湾版假,万能钥匙,万人骚动,王立军,王益案,网民案,网民获刑,网民诬,微型摄像,围攻警,围攻上海,维汉员,维权基,维权人,维权谈,委坐船,谓的和谐,温家堡,温切斯特,温影帝,溫家寶,瘟加饱,瘟假饱,文凭证,文强,纹了毛,闻被控制,闻封锁,瓮安,我的西域,我搞台独,乌蝇水,无耻语录,无码专,五套功,五月天,午夜电,午夜极,武警暴,武警殴,武警已增,务员答案,务员考试,雾型迷,西藏限,西服进去,希脏,习进平,习晋平,席复活,席临终前,席指着护,洗澡死,喜贪赃,先烈纷纷,现大地震,现金投注,线透视镜,限制言,陷害案,陷害罪,相自首,香港论坛,香港马会,香港一类,香港总彩,硝化甘,小穴,校骚乱,协晃悠,写两会,泄漏的内,新建户,新疆叛,新疆限,新金瓶,新唐人,信访专班,信接收器,兴中心幼,星上门,行长王益,形透视镜,型手枪,姓忽悠,幸运码,性爱日,性福情,性感少,性推广歌,胸主席,徐玉元,学骚乱,学位證,學生妹,丫与王益,烟感器,严晓玲,言被劳教,言论罪,盐酸曲,颜射,恙虫病,姚明进去,要人权,要射精了,要射了,要泄了,夜激情,液体炸,一小撮别,遗情书,蚁力神,益关注组,益受贿,阴间来电,陰唇,陰道,陰戶,淫魔舞,淫情女,淫肉,淫騷妹,淫兽,淫兽学,淫水,淫穴,隐形耳,隐形喷剂,应子弹,婴儿命,咏妓,用手枪,幽谷三,游精佑,有奶不一,右转是政,幼齿类,娱乐透视,愚民同,愚民政,与狗性,玉蒲团,育部女官,冤民大,鸳鸯洗,园惨案,园发生砍,园砍杀,园凶杀,园血案,原一九五七,原装弹,袁腾飞,晕倒型,韵徐娘,遭便衣,遭到警,遭警察,遭武警,择油录,曾道人,炸弹教,炸弹遥控,炸广州,炸立交,炸药的制,炸药配,炸药制,张春桥,找枪手,找援交,找政法委副,赵紫阳,针刺案,针刺伤,针刺事,针刺死,侦探设备,真钱斗地,真钱投注,真善忍,真实文凭,真实资格,震惊一个民,震其国土,证到付款,证件办,证件集团,证生成器,证书办,证一次性,政府操,政论区,證件,植物冰,殖器护,指纹考勤,指纹膜,指纹套,至国家高,志不愿跟,制服诱,制手枪,制证定金,制作证件,中的班禅,中共黑,中国不强,种公务员,种学历证,众像羔,州惨案,州大批贪,州三箭,宙最高法,昼将近,主席忏,住英国房,助考,助考网,专业办理,专业代,专业代写,专业助,转是政府,赚钱资料,装弹甲,装枪套,装消音,着护士的胸,着涛哥,姿不对死,资格證,资料泄,梓健特药,字牌汽,自己找枪,自慰用,自由圣,自由亚,总会美女,足球玩法,最牛公安,醉钢枪,醉迷药,醉乙醚,尊爵粉,左转是政,作弊器,作各种证,作硝化甘,唑仑,做爱小,做原子弹,做证件', 'textarea', '', '评论相关禁止关键字', 0),
(31, '是否开启评论', 'forum', 'forum_is_comment', '0', 'checker', '', '1开启，0关闭', 0),
(32, '设置安全验证方式', 'email', 'email_host_SMTPSecure', 'ssl', 'text', '', '默认为ssl', 0),
(33, '签到积分奖励日期', 'user', 'user_sign_date', '2018-04-24&99&新年快', 'textarea', '', '', 0),
(34, '默认会员角色', 'user', 'user_role_default', '3', 'text', '', '', 0),
(35, '是否开启邮箱验证', 'email', 'email_is_verify', '0', 'checker', '', '0关闭，1开启', 0),
(36, '是否开启短信验证', 'sms', 'sms_is_verify', '0', 'checker', '', '0关闭，1开启', 0);

DROP TABLE IF EXISTS `and_user`;
CREATE TABLE IF NOT EXISTS `and_user` (
  `id` int(11) NOT NULL,
  `create_ip` varchar(32) NOT NULL DEFAULT '' COMMENT 'IP',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `nickname` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `thumb_url` varchar(100) DEFAULT '/static/common/images/default_head_img.png' COMMENT '头像',
  `email` varchar(50) DEFAULT '' COMMENT '邮箱',
  `phone` varchar(11) DEFAULT '' COMMENT '手机',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `user_level_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '消费等级',
  `user_role_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '角色ID',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '验证1表示正常2邮箱验证3手机认证5手机邮箱全部认证',
  `address` varchar(32) DEFAULT '' COMMENT '地址',
  `description` varchar(200) DEFAULT NULL COMMENT '描述',
  `last_login_time` int(10) DEFAULT '0' COMMENT '最后登陆时间',
  `last_login_ip` varchar(20) DEFAULT '0' COMMENT '最后登录IP',
  `salt` varchar(20) DEFAULT NULL COMMENT 'salt',
  `developer` tinyint(1) DEFAULT '0' COMMENT '开发者',
  `collect` int(11) DEFAULT '0' COMMENT '被关注数',
  `zan` int(11) DEFAULT '0' COMMENT '被赞数',
  `tips` int(11) DEFAULT '0' COMMENT '被打赏次数',
  `is_comment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否禁言',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户表';


DROP TABLE IF EXISTS `and_user_count`;
CREATE TABLE IF NOT EXISTS `and_user_count` (
  `id` int(10) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `point` int(10) NOT NULL DEFAULT '0' COMMENT '积分',
  `money` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '财富',
  `friends` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '朋友数',
  `digestposts` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '精华帖数',
  `blogs` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '博客数',
  `albums` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '专辑数',
  `sharings` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分享数',
  `views` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '意见数',
  `feeds` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '打赏数',
  `follower` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '粉丝数',
  `collect` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '偶像数',
  `blacklist` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '黑名单'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `and_user_grade`;
CREATE TABLE IF NOT EXISTS `and_user_grade` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户ID，0为系统属性',
  `name` varchar(32) NOT NULL COMMENT '名称',
  `score` int(11) NOT NULL COMMENT '等级所需积分',
  `badge` varchar(20) NOT NULL DEFAULT '' COMMENT '徽章',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1启用，0禁用'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员等级表';




INSERT INTO `and_user_grade` (`id`, `user_id`, `name`, `score`, `badge`, `status`) VALUES
(1, 0, '托儿所', 0, '0', 1),
(2, 0, '幼儿园', 100, '0', 1),
(3, 0, '学前班', 500, '0', 1),
(4, 0, '一年级', 1000, '0', 1),
(5, 0, '二年级', 2000, '0', 1),
(6, 0, '三年级', 4000, '0', 1),
(7, 0, '四年级', 7200, '0', 1),
(8, 0, '五年级', 11000, '0', 1),
(9, 0, '六年级', 16000, '0', 1),
(10, 0, '初一年级', 26000, 'fa-star-half-o', 1),
(11, 0, '初二年级', 46000, '0', 1),
(12, 0, '初三年级', 76000, '0', 1),
(13, 0, '高一年级', 176000, '0', 1),
(14, 0, '高二年级', 376000, '0', 1),
(15, 0, '高三年级', 676000, '0', 1),
(16, 0, '大一', 1000000, '0', 1),
(17, 0, '大二', 2000000, '0', 1),
(18, 0, '大三', 4000000, '0', 1),
(19, 0, '大四', 7000000, '0', 1),
(20, 0, '研一', 10000000, '0', 1),
(21, 0, '研二', 30000000, '0', 1),
(22, 0, '研三', 60000000, '0', 1),
(23, 0, '博士生', 100000000, '0', 1);


DROP TABLE IF EXISTS `and_user_level`;
CREATE TABLE IF NOT EXISTS `and_user_level` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL COMMENT '等级名称',
  `discount` int(2) UNSIGNED NOT NULL DEFAULT '100' COMMENT '折扣率(%)',
  `intro` varchar(255) NOT NULL COMMENT '等级简介',
  `expire` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '会员有效期(天)',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0启用，1禁用',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='合约用户（等级）';



INSERT INTO `and_user_level` (`id`, `name`, `discount`, `intro`, `expire`, `status`, `create_time`) VALUES
(1, 'VIP(精铁)', 95, 'VIP1', 30, 1, 1521708744),
(2, 'VIP(黄铜)', 90, 'VIP2', 90, 1, 1521708804),
(3, 'VIP(白银)', 85, 'VIP3', 180, 0, 1521708879),
(4, 'VIP(白金)', 80, 'VIP4', 365, 0, 1521708913),
(5, 'VIP(钻石)', 75, 'VIP5', 1095, 0, 1521709041),
(6, '超级VIP', 70, 'VIP6', 0, 0, 1521709098);


DROP TABLE IF EXISTS `and_user_message`;
CREATE TABLE IF NOT EXISTS `and_user_message` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '所属会员',
  `to_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '发送对象',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1系统消息2帖子动态',
  `content` text NOT NULL COMMENT '内容',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态 1 显示  2 隐藏'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息表';



DROP TABLE IF EXISTS `and_user_message_read`;
CREATE TABLE IF NOT EXISTS `and_user_message_read` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '会员ID',
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT '消息对象',
  `status` tinyint(1) DEFAULT '0' COMMENT '消息状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息表';


DROP TABLE IF EXISTS `and_user_sign`;
CREATE TABLE IF NOT EXISTS `and_user_sign` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户id',
  `days` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '连续签到的天数',
  `is_sign` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否签到过',
  `sign_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '签到的时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户签到表';




ALTER TABLE `and_admin_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`,`phone`);


ALTER TABLE `and_attachment`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `and_auth_group`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `and_auth_group_access`
  ADD KEY `admin_user_id` (`admin_user_id`),
  ADD KEY `auth_group_id` (`auth_group_id`);


ALTER TABLE `and_auth_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE;



ALTER TABLE `and_auth_rule_group`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `and_nav`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `and_nav_group`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `and_system_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vari` (`vari`),
  ADD KEY `keyword` (`group`) USING BTREE;

ALTER TABLE `and_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE,
  ADD KEY `phone` (`phone`),
  ADD KEY `email` (`email`);

ALTER TABLE `and_user_count`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `and_user_grade`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `and_user_level`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `and_user_message`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `and_user_message_read`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `and_user_sign`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `and_admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `and_attachment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;


ALTER TABLE `and_auth_group`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `and_auth_rule`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;



ALTER TABLE `and_auth_rule_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `and_nav`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `and_nav_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `and_system_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

ALTER TABLE `and_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用表AUTO_INCREMENT `and_user_count`
--
ALTER TABLE `and_user_count`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用表AUTO_INCREMENT `and_user_grade`
--
ALTER TABLE `and_user_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用表AUTO_INCREMENT `and_user_level`
--
ALTER TABLE `and_user_level`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `and_user_message`
--
ALTER TABLE `and_user_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用表AUTO_INCREMENT `and_user_message_read`
--
ALTER TABLE `and_user_message_read`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `and_user_sign`
--
ALTER TABLE `and_user_sign`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;