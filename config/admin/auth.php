<?php

/**
 * | AndPHP框架[基于ThinkPHP5开发]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2017-2019 http://www.andphp.com
 * +----------------------------------------------------------------------
 * | AndPHP承诺基础框架永久免费开源，您可用于学习和商用，但必须保留软件版权信息。
 * +----------------------------------------------------------------------
 * | author    :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018/3/6 000614:22
 * +----------------------------------------------------------------------
 */

return[
    // auth配置
    'auth_on'           => 1, // 权限开关
    'auth_type'         => 1, // 认证方式，1为实时认证；2为登录认证。
    'auth_group'        => 'auth_group', // 用户组数据表名
    'auth_group_access' => 'auth_group_access', // 用户-用户组关系表
    'auth_rule'         => 'auth_rule', // 权限规则表
    'auth_user'         => 'admin_user', // 用户信息表
    'not_check'         =>[
        'admin/Index/index',
        'admin/Index/welcome',
        'admin/Tool/set_skin',
        'admin/Tool/lock_screen',
        'admin/Tool/relieve_screen',
        'admin/Login/logout',
        'admin/System/clear',
        'admin/Upload/update_image',
        'admin/Upload/upfile',
        'admin/Upload/umeditor_upimage',
        'admin/Upload/layedit_upimage'
    ],
];