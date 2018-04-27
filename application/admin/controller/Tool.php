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
 * | createTime :2018/3/2 000213:08
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;


use app\common\controller\AdminController;
use app\common\model\AdminUser as AdminUserModel;
use think\facade\Cache;
use think\facade\Session;

/**
 * 工具类控制器
 * +----------------------------------------------------------------------
 * Class Tool
 * @package app\admin\controller
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-03-05 9:21
 */
class Tool extends AdminController
{

    /**
     * 设置后台界面风格 颜色
     * @return string
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 22:35
     */
    public function set_skin()
    {
        if (!$this->request->isAjax()) {
            $this->error('不是一个正确的请求方式');
        }
        $data = $this->request->post();
        $skin = trim($data['skin']);
        cookie('skin_name', $skin, 2592000);
        return ajax_json('success','皮肤切换成功');
    }

    /**
     * 锁屏操作
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:24
     */
    public function lock_screen()
    {
        if (!$this->request->isAjax()) {
            $this->error('不是一个正确的请求方式');
        }
        cookie('is_lock_screen', 1, 86400);
        $this->success('锁屏成功');
    }

    /**
     * 解锁操作
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:25
     */
    public function relieve_screen()
    {
        if (!$this->request->isAjax()) {
            $this->error('不是一个正确的请求方式');
        }
        $user_id=Session::get('adminUser.id');
        $userModel=new AdminUserModel();
        $userInfo=$userModel->find($user_id);
        $data = $this->request->post();
        if (trim($data['pwd'])) {
            $lock_pwd = passwordMD5($data['pwd'],$userInfo['salt']);
            if ($lock_pwd == $userInfo['password']) {
                cookie('is_lock_screen', null);
                $this->success( '解屏成功');
            } else {
                $this->error('密码输入不一致');
            }
            $this->success('解屏成功');
        } else {
            $this->error('请输入密码');
        }
    }

    /**
     * 清空缓存
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:25
     */
    public function clear_cache()
    {
        if (!$this->request->isAjax()) {
          $this->error('不是一个正确的请求方式');
        }
        Cache::clear();
        $this->success('缓存清除成功！');
    }
}