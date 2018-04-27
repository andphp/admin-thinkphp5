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
 * | createTime :2018/3/22 002221:31
 * +----------------------------------------------------------------------
 */

namespace app\user\controller;


use app\common\controller\UserController;
use app\common\model\ForumComment as ForumCommentModel;

class Comment extends UserController
{

    public function index(){
        if (!session('userId') || !session('username')) {
            $this->error('亲！请登录', url('user/login/index'));
        } else {
            $comment =new ForumCommentModel();
            $uid = session('userId');
            $data = $comment->with('userPid')->where('user_id',$uid)->order('create_time desc')->paginate(5,false,[
                'type'      => 'Layui',
                'var_page'  => 'page',
                'list_rows' => 10,
                'newstyle'  => true,
            ]);
            $this->assign('data', $data);
            $this->assign('uid', $uid);
        }
        return $this->fetch();
    }
}