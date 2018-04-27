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
 * | createTime :2018/3/19 001910:34
 * +----------------------------------------------------------------------
 */

namespace app\user\controller;


use app\common\controller\UserController;
use app\common\model\User as UserModel;
use app\user\validate\SetValidate;
use think\facade\Cache;

class Set extends UserController
{

    protected function initialize()
    {
        parent::initialize();
        if(!$this->isLogin()){
            $this->error('亲！请登录', url('user/login/index'));
        }
    }
    public function index()
    {
        if (!session('userId') || !session('username')) {
            $this->error('亲！请登录', url('user/login/index'));
        } else {
            $userModel = new UserModel();
            $uid = session('userId');
            $member = $userModel->where(array('id' => $uid))->find();
            $userInfo=0;
            $member['nickname']=explode('&',$member['nickname'])[0];
            $member['phone_hide']=hidePhone($member['phone']);
            $this->assign('member', $member);
            $this->assign('userInfo', $userInfo);
            $this->assign('uid', $uid);
        }
        $this->assign('email_is_verify',$this->config['email_is_verify']);
        $this->assign('sms_is_verify',$this->config['sms_is_verify']);
        return $this->fetch();
    }

    public function update_info(){
        $userModel = new UserModel();
        $uid = $this->uid;
        $member = $userModel->where(array('id' => $uid))->find();
        if (request()->isPost()) {
            $data = $this->request->post();
            $data['id'] = $uid;
            $sms_is_verify = $this->config['sms_is_verify'];
            if($sms_is_verify == 1){
                if(Cache::has('SmsCode'.$data['phone'])==false){
                    $data['phone']=$member['phone'];
                    $data['status']=$member['status'];
                }elseif ($member['status'] == 1) {
                    $codeData=cache('SmsCode'. $data['phone']);
                    if($codeData['code']!= $data['phone_confirm']){
                        return json(array('code' => 0, 'msg' => '短信验证码错误'));
                    }
                    $data['status']=3;
                } else {
                    $codeData=cache('SmsCode'. $data['phone']);
                    if($codeData['code']!= $data['phone_confirm']){
                        return json(array('code' => 0, 'msg' => '短信验证码错误'));
                    }
                    $data['status']=5;
                }
            }else{
                $data['status']=$member['status'];
            }

            //验证部分数据合法性
            $validate=(new SetValidate())->goCheck($data);
            if($validate!==true){
                return json(array('code' => 0, 'msg' => $validate));
            }
            $data['address'] = remove_xss($data['address']);
            $data['description'] = remove_xss($data['description']);
            $data['nickname']= $data['nickname'].'&'.$member['salt'];
            if($data['nickname']!=$member['nickname']){
                session('nickname',explode('&',$data['nickname'])[0]);
            }
            $data['username']=$member['username'];
            if ($userModel->allowField(true)->save($data, ['id' => $uid])) {
                return json(array('code' => 200, 'msg' => '修改成功'));
            } else {
                return json(array('code' => 0, 'msg' => '修改失败'));
            }

        }

        return json(array('code' => 0, 'msg' => '修改失败'));
    }

    public function update_head(){
        if (!session('userId') || !session('username')) {
            $this->error('亲！请登录', url('user/login/index'));
        }
        if (request()->isPost()) {
            $data = $this->request->post();
            $userModel = new UserModel();
            if ($userModel->allowField(true)->save($data, ['id' => session('userId')])) {
                session('thumb_url', $userModel['thumb_url']);
                return json(array('code' => 200, 'msg' => '修改成功'));
            } else {
                return json(array('code' => 0, 'msg' => '修改失败,系统错误！'));
            }
        }
        return json(array('code' => 0, 'msg' => '修改失败'));
    }
    public function update_password(){
        if (!session('userId') || !session('username')) {
            $this->error('亲！请登录', url('user/login/index'));
        }
        $userModel = new UserModel();
        $uid = session('userId');
        $member = $userModel->find($uid);
        if (request()->isPost()) {
            $data = $this->request->post();
            //验证部分数据合法性
            $validate=(new SetValidate())->goCheck($data);
            if($validate!==true){
                return json(array('code' => 0, 'msg' => $validate));
            }
            if ($data['password'] == $data['nowPass']) {
                return json(array('code' => 0, 'msg' => '密码未修改'));

            }
            if ($member['password'] != passwordMD5($data['nowPass'],$member['salt'])) {
                return json(array('code' => 0, 'msg' => '原始密码错误'));
            }
            $reData['password'] = passwordMD5($data['password'],$member['salt']);
            if ($member->save($reData, ['id' => $uid])) {
                return json(array('code' => 200, 'msg' => '修改成功'));
            }
        }
        return json(array('code' => 0, 'msg' => '修改失败'));
    }
}