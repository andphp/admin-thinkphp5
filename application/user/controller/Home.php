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
 * | createTime :2018/3/16 001615:54
 * +----------------------------------------------------------------------
 */

namespace app\user\controller;


use app\common\controller\UserController;
use app\common\model\User as UserModel;

class Home extends UserController
{

    public function index($id=0){
        if($id==0){
            $this->redirect('index');
        }
        $id=request()->param('id');
        if($id !=true){
            $this->redirect('index');
        }

        $userInfo=(new UserModel())->where('id',$id)->find();

        $this->assign('userInfo',$userInfo);

        return $this->fetch();
    }
}