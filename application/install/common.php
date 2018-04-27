<?php

/**
 * | AndPHP [ PHP and I ]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2017-2022 http://www.wyz.ltd All rights reserved
 * +----------------------------------------------------------------------
 * | AndPHP承诺基础框架永久免费开源，您可用于学习和商用，但必须保留软件版权信息。
 * +----------------------------------------------------------------------
 * | Author : BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | CreateTime : 2018/4/26 002620:42
 * +----------------------------------------------------------------------
 */

/**
 * 系统环境检测
 * @return array 系统环境数据
 */
function check_env()
{
    $items = array(
        'os' => array('操作系统', '不限制', '类Unix', PHP_OS, 'success'),
        'php' => array('PHP版本', '5.6', '5.6+', PHP_VERSION, 'success'),
        //'mysql'   => array('MYSQL版本', '5.0', '5.0+', '未知', 'success'), //PHP5.5不支持mysql版本检测
        'upload' => array('附件上传', '不限制', '2M+', '未知', 'success'),
        'gd' => array('GD库', '2.0', '2.0+', '未知', 'success'),
        'curl' => array('Curl扩展', '开启', '不限制', '未知', 'success'),
        'disk' => array('磁盘空间', '5M', '不限制', '未知', 'success'),
    );

    //PHP环境检测
    if ($items['php'][3] < $items['php'][1]) {
        $items['php'][4] = 'remove';
        cache('error', true);
    }

    //数据库检测
    // if(function_exists('mysql_get_server_info')){
    // 	$items['mysql'][3] = mysql_get_server_info();
    // 	if($items['mysql'][3] < $items['mysql'][1]){
    // 		$items['mysql'][4] = 'error';
    // 		cache('error', true);
    // 	}
    // }

    //附件上传检测
    if (@ini_get('file_uploads'))
        $items['upload'][3] = ini_get('upload_max_filesize');

    //GD库检测
    $tmp = function_exists('gd_info') ? gd_info() : array();
    if (empty($tmp['GD Version'])) {
        $items['gd'][3] = '未安装';
        $items['gd'][4] = 'remove';
        cache('error', true);
    } else {
        $items['gd'][3] = $tmp['GD Version'];
    }
    unset($tmp);

    $tmp = function_exists('curl_init') ? curl_version() : array();
    if (empty($tmp['version'])) {
        $items['curl'][3] = '未安装';
        $items['curl'][4] = 'remove';
        session('curl', true);
    } else {
        $items['curl'][3] = $tmp['version'];
    }
    unset($tmp);
    //磁盘空间检测
    if (function_exists('disk_free_space')) {
        $items['disk'][3] = floor(disk_free_space(INSTALL_APP_PATH) / (1024 * 1024)) . 'M';
    }

    return $items;
}

/**
 * 目录，文件读写检测
 * @return array 检测数据
 */
function check_dirfile()
{
    $items = array(
        array('dir', '可写', 'ok', './'),
        array('dir', '可写', 'ok', './install'),
        array('dir', '可写', 'ok', './uploads'),
        array('dir', '可写', 'ok', './../runtime'),
        array('file', '可写', 'ok', './../config/database.php'),
    );

    foreach ($items as &$val) {
        if ('dir' == $val[0]) {
            if (!is_writable(INSTALL_APP_PATH . $val[3])) {
                if (is_dir($val[1])) {
                    $val[1] = '可读';
                    $val[2] = 'remove';
                    cache('error', true);
                } else {
                    $val[1] = '不存在或者不可写';
                    $val[2] = 'remove';
                    cache('error', true);
                }
            }
        } else {
            if (file_exists(INSTALL_APP_PATH . $val[3])) {
                if (!is_writable(INSTALL_APP_PATH . $val[3])) {
                    $val[1] = '文件存在但不可写';
                    $val[2] = 'remove';
                    cache('error', true);
                }
            } else {
                if (!is_writable(dirname(INSTALL_APP_PATH . $val[3]))) {
                    $val[1] = '不存在或者不可写';
                    $val[2] = 'remove';
                    cache('error', true);
                }
            }
        }
    }

    return $items;
}

/**
 * 函数检测
 * @return array 检测数据
 */
function check_func()
{
    $items = array(
        array('file_get_contents', '支持', 'ok'),
        array('mb_strlen', '支持', 'ok'),
        array('curl_init', '支持', 'ok'),
    );

    foreach ($items as &$val) {
        if (!function_exists($val[0])) {
            $val[1] = '不支持';
            $val[2] = 'remove';
            $val[3] = '开启';
            cache('error', true);
        }
    }

    return $items;
}



/**
 * 创建数据表
 * @param  resource $db 数据库连接资源
 */
function create_tables($db, $prefix = '')
{
    //读取SQL文件
    $sql = file_get_contents(WEB_PATH . 'install/install.sql');
    $sql = str_replace("\r", "\n", $sql);
    $sql = explode(";\n", $sql);

    //替换表前缀
    $orginal = config('database.prefix');
    $sql = str_replace(" `{$orginal}", " `{$prefix}", $sql);


    //开始安装
    show_msg('开始安装数据库...');
    foreach ($sql as $value) {
        $value = trim($value);
        if (empty($value)) continue;
        if (substr($value, 0, 12) == 'CREATE TABLE') {
            $name = preg_replace("/^CREATE TABLE IF NOT EXISTS `(\w+)` .*/s", "\\1", $value);
            $msg = "创建数据表{$name}";
            if (false !== $db->execute($value)) {
                show_msg($msg . '...成功');
            } else {
                show_msg($msg . '...失败！', 'error');
                cache('error', true);
            }
        } else {
            $db->execute($value);
        }
    }

}

function register_administrator($db, $prefix, $admin)
{
    show_msg('开始注册创始人帐号...');

    //添加管理员
    $time = time();


    $passwordinfo = get_password($admin['password']);
    $password = $passwordinfo['password'];
    $encrypt = $passwordinfo['encrypt'];

    /*插入用户*/
    $sql = <<<sql
REPLACE INTO `[PREFIX]admin_user` (`username`,`nickname`, `password`, `email`, `salt`, `last_login_time`, `last_login_ip`, `create_time`, `status`) VALUES
('[NAME]','[NICK]', '[PASS]','[EMAIL]', '[SALT]', '[TIME]', '[IP]',  '[TIME]', 1);
sql;

    /*  "REPLACE INTO `[PREFIX]ucenter_member` VALUES " .
         "('1', '[NAME]', '[PASS]', '[EMAIL]', '', '[TIME]', '[IP]', 0, 0, '[TIME]', '1',1,'finish')";*/

    $sql = str_replace(
        array('[PREFIX]', '[NAME]','[NICK]', '[PASS]', '[EMAIL]','[SALT]', '[TIME]', '[IP]'),
        array($prefix, $admin['username'],$admin['username'].'_'.$encrypt, $password, $admin['email'], $encrypt, $time, get_client_ip(1)),
        $sql);
    //执行sql
    $db->execute($sql);



    show_msg('创始人帐号注册完成！');
}

/**
 * 对用户的密码进行加密
 * @param $password
 * @param $encrypt //传入加密串，在修改密码时做认证
 * @return array/password
 */
function get_password($password, $encrypt='') {
    $pwd = array();
    $pwd['encrypt'] =  $encrypt ? $encrypt : getRandStr();
    $pwd['password'] = md5(md5($password) . md5($pwd['encrypt']));
    return $encrypt ? $pwd['password'] : $pwd;
}
/**
 * 及时显示提示信息
 * @param  string $msg 提示信息
 */
function show_msg($msg, $class = '')
{
    echo "<script type=\"text/javascript\">showmsg(\"{$msg}\", \"{$class}\")</script>";
    ob_flush();
    flush();

}
