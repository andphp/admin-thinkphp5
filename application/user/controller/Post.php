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
 * | createTime :2018/3/22 002218:59
 * +----------------------------------------------------------------------
 */

namespace app\user\controller;


use app\common\controller\UserController;
use app\common\model\Collect as CollectModel;
use app\common\model\Forum as FormModel;

class Post extends UserController
{

    public function index()
    {
        if (!session('userId') || !session('username')) {
            $this->error('亲！请登录', url('user/login/index'));
        }
        $forum = new FormModel();
        $uid = session('userId');
        $count = $forum->where("user_id = {$uid}")->count();

        $this->assign('uid', $uid);
        $this->assign('count', $count);

        //收藏的帖子
        $collect =new CollectModel();
        $count_collect = $collect->where("user_id = {$uid} and type = 1")->count();
        $this->assign('count_collect', $count_collect);
        return $this->fetch();

    }

    public function getMyForum(){
        $data = $this->request->param();
        $limit = $data['limit'];
        $pre = ($data['page'] - 1) * $limit;
        $forum =  new FormModel();
        $uid = session('userId');
        $count = $forum->where("user_id = {$uid}")->count();
        $data = $forum->where("user_id = {$uid}")->order('id DESC')->limit($pre, $limit)->select();
        foreach($data as $k=>$v){
            $data[$k]['title']= strip_tags($v['title']);
        }

        return json(array('code' => 0, 'msg' => '', 'count' => $count, 'data' => $data));
    }
    public function getMyCollect(){
        $data = $this->request->param();
        $type = $data['ctype'];
        $limit = $data['limit'];
        $pre = ($data['page'] - 1) * $limit;
        $uid = session('userId');
        $collect =new CollectModel();
        $count = $collect->where("user_id = {$uid}")->count();
        $data = $collect->alias('c')->join('forum f', 'c.sid=f.id', 'LEFT')->field('c.*,f.id as fid,f.title')->where("c.user_id = {$uid} and c.type = {$type}")->order('id DESC')->limit($pre, $limit)->select();
        foreach($data as $k=>$v){
            $data[$k]['title']= strip_tags($v['title']);
        }
        return json(array('code' => 0, 'msg' => '', 'count' => $count, 'data' => $data));

    }
}