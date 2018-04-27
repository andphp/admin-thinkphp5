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
 * | createTime :2018/3/13 001315:37
 * +----------------------------------------------------------------------
 */

namespace app\user\validate;


use app\common\validate\ValidateBase;

class JoinValidate extends ValidateBase
{
    /**
     * 校验规则
     * @var array
     */
    protected $rule = [
        'nickname'  => 'require|chsDash|max:10',
        'password'  => 'require|alphaDash|confirm|length:32',
        'email'=>'email|unique:user',
        'phone'=>'mobile|unique:user'
    ];

    /**
     * 校验NG返回错误信息
     * @var array
     */
    protected $message= [
        'nickname.require'  => '昵称不能为空',
        'nickname.chsDash'  => '昵称只能是汉字、字母、数字和下划线_及中横线-',
        'nickname.max'       => '昵称最大长度为10',
        'password.require' => '密码不能为空',
        'password.alphaDash' => '密码只能是字母和数字，下划线_及破折号-',
        'password.length' => '密码只能是32位加密字符串哦',
        'password.confirm' => '两次密码不一致哦',
    ];

}