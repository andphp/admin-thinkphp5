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
 * | createTime :2018/3/3 000316:23
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;


use app\common\controller\AppController;
use app\common\model\AdminUser as AdminUserModel;
use think\facade\Session;
use app\admin\validate\AdminUser as AdminUserValidate;

/**
 * 后台管理员登录控制器类
 * +----------------------------------------------------------------------
 * Class Login
 * @package app\admin\controller
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-04-27 20:30
 */
class Login extends AppController
{
	/**
	 * 渲染登录页面
	 * @return mixed
	 * @company    :WuYuZhong Co. Ltd
	 * @author     :BabySeeME <417170808@qq.com>
	 * @createTime :2018-03-05 19:11
	 */
	public function index(){
		if(Session::has('adminUser') == true) {
			$this->redirect('admin/index/index');
		}
		$login['title']="AndPHP";
		$login['www']="www.andphp.com";
		$login['copy']="ANDPHP";
		$this->assign('login',$login);
		return $this->fetch();
	}

	/**
	 * 登录操作
	 * @company    :WuYuZhong Co. Ltd
	 * @author     :BabySeeME <417170808@qq.com>
	 * @createTime :2018-03-05 19:11
	 */
	public function login(){
		$model = new AdminUserModel();
		if (!$this->request->isAjax()) {
			return ajax_json('error','不是一个正确的请求方式');
		}
		$post = $this->request->post();
		//验证部分数据合法性
		(new AdminUserValidate())->goCheck($post);
		if (!captcha_check(input('post.captcha'))) {
			return ajax_json('error','亲！验证码错误了哦');
		}

		$userStr = $post['username'];
		//用户名、邮箱、手机号均可登陆
		if (preg_match("/^1[34578]\d{9}$/", $userStr)) {
			$map['phone'] = $userStr;
		} else {
			$map['username|email'] = $userStr;
		}

		$name = $model->where('status','gt',0)->where($map)->where('is_delete',0)->find();
		if(empty($name)) {
			//不存在该用户名
			return ajax_json('error','账户不存在或已被禁用');
		} else {
			//验证密码
			$post['password'] = passwordMD5($post['password'],$name['salt']);
			if($name['password'] != $post['password']) {
				return ajax_json('error','密码错误');
			} elseif ($name['status'] != 1) {
				return ajax_json('error','当前用户已禁用');
			}else{
				$login_ip =  $this->request->ip();
				$login_time = time();
				$logLogin['user_id']=$name['id'];
				$logLogin['username']=$name['username'];
				$url='http://ip.taobao.com/service/getIpInfo.php?ip='.$login_ip;
				$result = file_get_contents($url);
				$result = json_decode($result,true);
				$logLogin['city']=$result['data']['city'];
				$logLogin['login_ip']=$login_ip;
				$logLogin['login_time']=$login_time;
				Session::set("adminUser",$name); //保存新的,最长为2小时
				//记录登录时间和ip
				$model->where('id',$name['id'])->update(['last_login_ip' => $login_ip,'last_login_time' => $login_time]);
				//$this->add_log($name['id'],$name['username'],'登录于'.date('Y-m-d H:i:s',$login_time));
				return ajax_json('success','登录成功,正在跳转...','/admin/Index/index');
			}
		}

	}

	/**
	 * 退出登录
	 * @return string
	 * @company    :WuYuZhong Co. Ltd
	 * @author     :BabySeeME <417170808@qq.com>
	 * @createTime :2018-03-05 20:37
	 */
	public function logout(){
		Session::delete('adminUser');
		if(empty(Session::get('adminUser'))) {
			return ajax_json('success','注销成功！正在跳转...','/admin/login/index');
		}
		return ajax_json('error','注销失败！');
	}
}