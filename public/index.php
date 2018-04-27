<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;

define('WEB_PATH',__DIR__ . '/');

define('ROOT_PATH',__DIR__ . '/../');

define('APP_PATH',__DIR__ . '/../application/');

// 定义URL
if (!defined('WEB_URL')) {
    $url = rtrim(dirname(rtrim($_SERVER['SCRIPT_NAME'], '/')), '/');
    define('WEB_URL', (('/' == $url || '\\' == $url) ? '' : $url));
}

// 加载基础文件
require __DIR__ . '/../thinkphp/base.php';

// 支持事先使用静态方法设置Request对象和Config对象

// 执行应用并响应
Container::get('app')->run()->send();
