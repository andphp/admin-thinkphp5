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
 * | createTime :2018/3/4 000416:32
 * +----------------------------------------------------------------------
 */

namespace app\admin\validate;


class SystemConfig extends AdminValidate
{
    /**
     * 校验规则
     * @var array
     */
    protected $rule = [
        'group'  => 'require|alphaDash',
        'vari'  => 'require|alphaDash',
        'value'  => 'require',
        'type'  => 'require',
    ];

    /**
     * 校验NG返回错误信息
     * @var array
     */
    protected $message= [
        'group.require' => '分组名称不能为空',
        'group.alphaDash' => '分组名称必选为字母和数字，下划线_及破折号-',
        'value.require' => '数据值不能为空',
        'vari.require' => '变量名称不能为空',
        'vari.alphaDash' => '变量名称必选为字母和数字，下划线_及破折号-',
        'type.require' => '类型不能为空',
    ];
}