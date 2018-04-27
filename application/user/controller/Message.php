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
 * | createTime :2018/3/22 002221:41
 * +----------------------------------------------------------------------
 */

namespace app\user\controller;


use app\common\controller\UserController;
use app\common\model\UserMessage as MessageModel;
use app\common\model\UserMessageRead as MessageReadModel;

class Message extends UserController
{

    public function index(){
        if (!session('userId') || !session('username')) {
            $this->error('亲！请登录', url('user/login/index'));
        }
        $uid = session('userId');
        $messageModel=new MessageModel();

        $data =$messageModel->where(['to_user_id'=>$uid,'status'=>1])->order('create_time desc')->paginate(5,false,[
            'type'      => 'Layui',
            'var_page'  => 'page',
            'list_rows' => 10,
            'newstyle'  => true,
        ]);

        $this->assign('data', $data);
        $this->assign('uid', $uid);
        return $this->fetch();
    }
    public function delete($id){
        $messageModel=new MessageModel();
        if ($messageModel->where('id',$id)->update(['status'=>0])) {
            //$this->success('删除成功');
            return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
            // $this->error('删除失败');
            return json(array('code' => 0, 'msg' => '删除失败'));
        }
    }
    public function delete_all(){
        $messageModel=new MessageModel();
        if ($messageModel->where('to_user_id',session('userId'))->update(['status'=>0])) {
            //$this->success('删除成功');
            return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
            // $this->error('删除失败');
            return json(array('code' => 0, 'msg' => '删除失败'));
        }
    }
}