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
 * | createTime :2018/3/20 002018:58
 * +----------------------------------------------------------------------
 */

namespace app\user\controller;


use app\common\controller\UserController;
use app\common\validate\IsOnlyPhone;
use lib\AliSms;
use think\facade\Cache;

class Sms extends UserController
{

    public function send_validate(){
        if (request()->isPost()) {
            $data = $this->request->post();
            (new IsOnlyPhone())->goCheck($data['phone']);
            $cacheData=Cache::get('SmsCode'.$data['phone']);
            if($cacheData){
                return json(array('code' => 0, 'msg' => '请勿在'.config('ali.valid_time').'秒内重复提交申请'));
            }
            if(config('app_debug')){
                $code=rand(1000,9000);
            }else{
                $code= AliSms::sendSms($data['phone']);
            }
            $addData['channel']='sms';
            $addData['account']=$data['phone'];
            $addData['code']=$code;
            $addData['valid_time']=time()+intval(config('ali.valid_time'));
            Cache::set('SmsCode'.$data['phone'], $addData,config('ali.valid_time'));
            return json(array('code' => 1, 'msg' => '发送成功,请注意查收"[那么优]"标示验证码！'));
        }
        return json(array('code' => 0, 'msg' => '非法请求'));
    }

}