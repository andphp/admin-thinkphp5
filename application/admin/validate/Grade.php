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
 * | createTime :2018/4/25 002510:26
 * +----------------------------------------------------------------------
 */

namespace app\admin\validate;



class Grade  extends AdminValidate
{
    /**
     * 校验规则
     * @var array
     */
    protected $rule = [
        'scoreName'  => 'require|max:6',
        'scoreUnit'  => 'require',
        'scoreIcon'  => 'isNoChinese',
        'scoreValue'  => 'number',
    ];

    /**
     * 校验NG返回错误信息
     * @var array
     */
    protected $message= [
        'scoreName.require' => '积分名称不能为空',
        'scoreName.max' => '积分名称过长',
        'scoreIcon.isNoChinese' => '积分图片怎么能为中文呢',
        'scoreValue.number' => '积分值必须为数字啊',
    ];
}