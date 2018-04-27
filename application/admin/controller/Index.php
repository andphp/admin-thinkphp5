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
 * | createTime :2018/4/19 001915:31
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;


use app\common\controller\AdminController;
use app\common\model\AuthRuleGroup;
use think\Db;
use think\facade\Session;

/**
 * 后台首页控制器类
 * +----------------------------------------------------------------------
 * Class Index
 * @package app\admin\controller
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-04-27 20:29
 */
class Index extends AdminController
{
    /**
     * 后台首页渲染输出
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:02
     */
    public function index(){
        $menu =  Db::name('AuthRule')->where(['status'=>1])->order('orders desc')->select();
        $RuleGroup = (new AuthRuleGroup())->where(['status'=>1])->order('orders desc')->select();
        //添加url
        foreach ($menu as $key => $value) {

            $menu[$key]['url'] =  url($value['name']);
        }

        $menus = $this->menuList($menu);

        $this->assign('menus',$menus);
        $this->assign('menusGroup',$RuleGroup);

        //环境
        $this->assign('dev',$this->getSysInfo());
        //检查是否锁屏状态
        $is_lock_screen = cookie('is_lock_screen') ? true : false;
        $this->assign('is_lock_screen',$is_lock_screen);
        //统计会员数
        $countUser = Db::table('and_user')->count();
        $this->assign('countUser',$countUser);
        //登录信息
        $this->assign('login',Session::get('adminUser'));
        return $this->fetch();
    }
    /**
     * 默认欢迎页面
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 21:01
     */
    public function welcome(){
        $this->addCss('admin/css/index');
        $this->addCss('admin/css/animate.css');
        //统计会员数
        $countUser = Db::table('and_user')->count();
        $this->assign('countUser',$countUser);
        //登录信息
        $this->assign('login',Session::get('adminUser'));
        return $this->fetch();
    }
    /**
     * 系统环境检测
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-06 20:38
     */
    public function getSysInfo(){
        //环境cms_version
        $dev['php_version'] = PHP_VERSION;
        $dev['cms_version'] = '2.0';
        if (@ini_get('file_uploads')) {
            $dev['upload_max_filesize'] = ini_get('upload_max_filesize');
        } else {
            $dev['upload_max_filesize'] = '禁止上传';
        }
        $dev['php_os'] = PHP_OS;
        $softArr = explode('/',$_SERVER["SERVER_SOFTWARE"]) ;
        $dev['server_software'] = array_shift($softArr);
        $dev['server_name'] = gethostbyname($_SERVER['SERVER_NAME']);
        $rslt = db()->query('SELECT VERSION() AS `version`');
        $dev['mysql_version'] = $rslt[0]['version'];
        if (extension_loaded('curl')) {
            $dev['curl_extension'] = 'YES';
        } else {
            $dev['curl_extension'] = 'NO';
        }
        $dev['max_execution_time'] = ini_get('max_execution_time') . 'S';
        return $dev;
    }

}