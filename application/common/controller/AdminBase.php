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
 * | createTime :2018/3/1 000121:11
 * +----------------------------------------------------------------------
 */

namespace app\common\controller;
use org\Auth;
use think\facade\Cookie;
use think\facade\Session;


/**
 * 后台公用基础控制器
 * +----------------------------------------------------------------------
 * Class AdminBase
 * @package app\common\controller
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-03-01 21:12
 */
class AdminBase extends AppBase
{
    public $userSession;

    protected function initialize()
    {
        parent::initialize();
        if(Session::has('adminUser') == false) {
            $this->redirect('admin/login/index');
        }
        $this->userSession=Session::get('adminUser');
        $this->checkAuth('adminUser');
        $this->assign('skin_name', Cookie::get('skin_name'));
    }

    /**
     * 拼接菜单节点列表
     * @param $menu
     * @return array
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-02 19:23
     */
    protected function menuList($menu){
        $menus = array();
        //先找出顶级菜单

       $userInfo= $this->userSession;
        foreach ($menu as $k => $val) {
            if($val['pid'] == 0  and (new Auth())->check($val['name'],$userInfo['id'])) {
                $menus[$k] = $val;
            }
        }

        //通过顶级菜单找到下属的子菜单
        foreach ($menus as $k => $val) {
            foreach ($menu as $key => $value) {
//                if($value['pid'] == $val['id']) {
                if($value['pid'] == $val['id'] and (new Auth())->check($value['name'],$userInfo['id'])==true) {
                    $menus[$k]['list'][] = $value;
                }
            }
        }
        return $menus;
    }

}