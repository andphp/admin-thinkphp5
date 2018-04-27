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
 * | createTime :2018/3/19 001913:34
 * +----------------------------------------------------------------------
 */

namespace app\user\controller;


use app\common\controller\UserController;
use app\common\model\User as UserModel;
use lib\Email as EmailLib;
class Email extends UserController
{

    public function send_validate(){
        $mail = $this->request->param();
        if($mail['email']==''){
            return json(array('code' => 0, 'msg' => '没有发送对象的邮箱号码'));
        }
        $uid = session('userId');
        $userModel=(new UserModel());
        $user = $userModel->where(array('id' => $uid))->find();
        $emailList = $userModel->column('email');
        if (in_array($mail['email'], $emailList) && $user['email'] != $mail['email']) {
            return json(array('code' => 0, 'msg' => '该邮箱已经被其他账号注册'));
        } else {
            $n['email'] = $mail['email'];
            $userModel->where(array('id' => $uid))->update($n);
            $str = md5($user['salt'] . $uid . $mail['email']);
            $url = 'http://'.$_SERVER['HTTP_HOST'].url('user/Email/confirm') . '?id=' . $str;
            //
            $data['host'] = $this->andConfig['email_host'];
            $data['host_username'] = $this->andConfig['email_host_username'];
            $data['host_password'] = $this->andConfig['email_host_password'];
            $data['host_port'] = $this->andConfig['email_host_port'];
            $data['host_SMTPSecure'] = $this->andConfig['email_host_SMTPSecure'];
            $data['email'] = $mail['email'];
            $data['name'] = $this->andConfig['site_title'];
            $data['title'] = '【'.$this->andConfig['site_title'].'】验证邮件';
            //邮件模板替换
            $data['body'] = htmlspecialchars_decode(str_replace(['{username}', '{site_title}', '{url}'], [$user['username'],$this->andConfig['site_title'], $url], $this->andConfig['email_template_validate']));
            if((new EmailLib())->sendEmail($data)){
                return json(array('code' => 1, 'msg' => '发送成功'));
            }

        }
        return json(array('code' => 0, 'msg' => '发送失败'));
    }

}