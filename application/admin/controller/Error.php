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
 * | createTime :2018/4/22 002210:26
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;

use app\common\controller\AdminController;

/**
 * 后台空控制器类
 * +----------------------------------------------------------------------
 * Class Error
 * @package app\admin\controller
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-04-27 20:28
 */
class Error extends AdminController
{
    /**
     * 空方法判断输出
     * @param $name
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:00
     */
    public function _empty($name)
    {
        $controllerName = request()->controller();
        $actionName = $name;
        $path=APP_PATH.strtolower($controllerName).DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.$controllerName.'.php';
        if(file_exists($path)){
            require_once($path);
            return (new $controllerName())->$actionName();
        }
        $this->error('你访问了一个错误的地址：'.request()->url().'<br/> 正在为你跳转。。。','admin/index/welcome');
    }
}