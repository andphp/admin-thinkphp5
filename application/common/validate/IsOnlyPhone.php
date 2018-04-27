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
 * | createTime :2018/3/20 002019:20
 * +----------------------------------------------------------------------
 */

namespace app\common\validate;


class IsOnlyPhone extends ValidateBase
{
    protected $rule = [
        'phone' => 'require|isMobile|unique:user',
    ];


    protected $message=[
        'phone.require' => '手机号不能为空',
        'phone.isMobile' => '手机号格式不正确',
        'phone.unique' => '手机号已注册',
    ];
}