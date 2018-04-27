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
 * | createTime :2018/3/9 000913:34
 * +----------------------------------------------------------------------
 */

namespace app\user\controller;


use app\common\controller\UserController;
use app\common\model\AuthGroupAccess;
use app\common\model\User as UserModel;

class Index extends UserController
{
    public function index(){
        $this->assign('user_is_sign',$this->config['user_is_sign']);
        $this->assign('email_is_verify',$this->config['email_is_verify']);

        if(!$this->isLogin()){
            $this->error('亲！请登录', url('user/login/index'));
        }

        $userModel = new UserModel();
        $userData = $userModel->with('count')->where(['id'=>$this->uid])->find();
        $this->assign('user',$userData);

        $rolesModel = new AuthGroupAccess();
        $userRoles = $rolesModel->where(['user_id'=>$this->uid])->select();
        $this->assign('userRoles',$userRoles);

        $score=explode(',',$this->config['point']);
        $this->assign('score',$score);

        return $this->fetch();
    }


}