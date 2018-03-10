<?php
/**
 * | AndPHP框架[基于ThinkPHP5开发]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2017-2019 http://www.andphp.com
 * +----------------------------------------------------------------------
 * | AndPHP承诺基础框架永久免费开源，您可用于学习和商用，但必须保留软件版权信息。
 * +----------------------------------------------------------------------
 * | author    :DaXiong <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018/2/8 000816:39
 * +----------------------------------------------------------------------
 */

namespace app\error\controller;



use think\Controller;
use think\facade\Request;



class Error extends Controller
{

    /**
     * 路由访问空控制器跳转
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 22:33
     */
    public function _empty()
    {
        if(request()->isGet()){
            $this->error('你访问了一个错误的地址：'.Request::instance()->url().'<br/> 正在为你跳转。。。','home/index/index');
        }
        return json_error('你访问了一个错误的地址：'.Request::instance()->url());

    }


}