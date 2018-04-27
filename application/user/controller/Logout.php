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
 * | createTime :2018/4/22 002222:53
 * +----------------------------------------------------------------------
 */

namespace app\user\controller;


use app\common\controller\UserController;
use think\facade\Session;


class Logout extends UserController
{

    public function index(){
        if(!Session::has('status')){
            $this->redirect('/user/login');
        }
        session("status", null);
        session("userId", null);
        session("username", null);
        session("email", null);
        session("user", null);
        cookie('sys_key', null);
        return json(array('code' => 200, 'msg' => '退出成功'));
    }
}