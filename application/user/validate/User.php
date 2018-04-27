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
 * | createTime :2018/3/5 000513:26
 * +----------------------------------------------------------------------
 */

namespace app\user\validate;


use app\common\validate\ValidateBase;

class User extends ValidateBase
{
    /**
     * 校验规则
     * @var array
     */
    protected $rule = [
        'id'         =>'number',
        'username'  => 'alphaDash|max:25',
        'nickname'  => 'chsAlphaNum|max:25',
        'password'  => 'alphaNum|confirm',
        'email'=>'email',
        'phone'=>'mobile'
    ];

    /**
     * 校验NG返回错误信息
     * @var array
     */
    protected $message= [

    ];
}