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
 * | createTime :2018/3/3 000311:18
 * +----------------------------------------------------------------------
 */

namespace app\common\validate;


use think\Validate;

/**
 * 基础验证类
 * +----------------------------------------------------------------------
 * Class ValidateBase
 * @package app\admin\validate
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-03-03 11:31
 */
class ValidateBase extends Validate
{
    /**
     * 重构验证方法
     * @param $params
     * @return array|bool
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :date
     */
    public function goCheck($params)
    {
        if($this->check($params)){
            return true;
        }
        return $this->error;
    }


    protected function isNoChinese($str){
        if (preg_match("/[\x7f-\xff]/", $str)) {
            return false;
        }else{
            return true;
        }
    }
    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}