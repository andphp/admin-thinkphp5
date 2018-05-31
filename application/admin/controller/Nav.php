<?php
/**
 * | AndPHP [ PHP and all,wo AndPHP ]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2017-2022 http://www.wyz.ltd All rights reserved
 * +----------------------------------------------------------------------
 * | AndPHP承诺基础框架永久免费开源，您可用于学习和商用，但必须保留软件版权信息。
 * +----------------------------------------------------------------------
 * | Author : BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | CreateTime : 2018/4/27 002715:53
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;


use app\common\controller\AdminController;
use app\common\model\NavGroup;
use app\common\model\Nav as NavModel;

/**
 * 综合导航控制器类
 * +----------------------------------------------------------------------
 * Class Nav
 * @package app\admin\controller
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-04-27 20:30
 */
class Nav extends AdminController
{
    /**
     * 空方法
     * @param $name
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:07
     */
    public function _empty($name)
    {
        $model = (new NavGroup());
        $navArray = $model->where('name',$name)->find();
        if(empty($navArray)){
            $this->error($name.'方法不存在！');
        }
        $model = new NavModel();
        $menu = $model->where(['group_id'=>$navArray['id']])->order('id asc,orders desc')->select();
        $menus = $this->menuList($menu);
        $this->assign('navList',$menus);
        $this->assign('group_id',$navArray['id']);
        return $this->fetch('_list');
    }

    /**
     * 格式化列表输出
     * @param $menu
     * @param int $id
     * @param int $level
     * @return array
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:08
     */
    public function menuList($menu,$id=0,$level=0){
        static $menus = array();
        foreach ($menu as $value) {
            if ($value['pid']==$id) {
                $value['level'] = $level+1;
                if($level == 0)
                {
                    $value['str'] = str_repeat('<i class="fa fa-angle-double-right"></i> ',$value['level']);
                }
                elseif($level == 2)
                {
                    $value['str'] = '&emsp;&emsp;&emsp;&emsp;'.'└ ';
                }
                else
                {
                    $value['str'] = '&emsp;&emsp;'.'└ ';
                }
                $menus[] = $value;
                $this->menulist($menu,$value['id'],$value['level']);
            }
        }
        return $menus;
    }

    /**
     * 更新状态
     * @return \think\response\Json
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:09
     */
    public function update_status(){
        if ($this->request->isGet()) {
            $get = $this->request->get();
            $model = new NavModel();
            if ($model->where('id', $get['id'])->update(['status' =>$get['status']]) !== false) {
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'更新导航ID：'.$get['id'].'状态');
                return json(array('code' => 200, 'msg' => '更新成功'));
            }
        }
        // $this->error('更新失败');
        return json(array('code' => 0, 'msg' => '更新失败'));
    }

    /**
     * 更新排序
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:09
     */
    public function orders()
    {
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $order = (new NavModel())->where('id',$val)->value('orders');
                if($order != $post['orders'][$k]) {
                    if(false == (new NavModel())->where('id',$val)->update(['orders'=>$post['orders'][$k]])) {
                        $this->error('更新失败');
                    } else {
                        $i++;
                    }
                }
            }
            $this->success('成功更新'.$i.'个数据');
        }
    }

    /**
     * 渲染输出添加FORM表单
     * @param int $pid
     * @param string $group_id
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:10
     */
    public function add($pid=0,$group_id=''){
        $pid = $this->request->has('pid') ? $this->request->param('pid', null, 'intval') : $pid;
        $module = $this->request->has('group_id') ? $this->request->param('group_id') : $group_id;
        $model = new NavModel();
        if($pid>0){
            $menu = $model->where('id',$pid)->find();
            if(empty($menu)) {
                $this->error('pid不正确');
            }
            $menu['title']='';
            $menu['id']='';
            $menu['pid']='';
            $menu['name']='';
            $menu['alias']='';
            $this->assign('menu',$menu);
            $this->assign('pid',$pid);
        }
        $menu = $model->where(['group_id'=>$group_id])->select();
        $menus = $this->menuList($menu);
        $this->assign('menus',$menus);
        $this->assign('group_id',$module);
        return $this->fetch();
    }

    /**
     * 提交新增
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:11
     */
    public function save(){
        //新增操作
        if($this->request->isPost()) {
            $model = new NavModel();
            //是提交操作
            $post = $this->request->post();

            //验证菜单是否存在
            $menu = $model->where(['name'=>$post['name'],'group_id'=>$post['group_id']])->find();
            if(!empty($menu)) {
                $this->error('该导航名称已经存在');
            }

            if(false == $model->allowField(true)->save($post)) {
                $this->error('添加新导航失败');
            } else {
                //记录日志
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'添加新导航：'.$post['name']);
                $this->success('添加新导航成功','admin/nav/'.$post[' group_id']);
            }
        }else{
            $this->error('添加新导航失败:非法提交！');
        }
    }

    /**
     * 渲染输出修改FORM表单
     * @param int $id
     * @param string $group_id
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:12
     */
    public function edit($id=0,$group_id=''){
        //获取菜单id
        $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') :$id;
        $module = $this->request->has('group_id') ? $this->request->param('group_id') : $group_id;
        if($id == 0) {
            $this->error('id不正能为空');
        }
        if($module == '') {
            $this->error('group_id不正能为空');
        }
        $model = new NavModel();
        //非提交操作
        $menu = $model->where('id',$id)->find();
        if(empty($menu)) {
            $this->error('id不正确');
        }
        $menus = $model->where(['group_id'=>$group_id])->select();
        $menus_all = $this->menuList($menus);
        $this->assign('menus',$menus_all);
        $this->assign('group_id',$group_id);
        $this->assign('menu',$menu);
        return $this->fetch();
    }

    /**
     * 提交更新操作
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:12
     */
    public function update(){
        //是修改操作
        if($this->request->isPost()) {
            $model = new NavModel();
            //是提交操作
            $post = $this->request->post();

            if(false == $model->allowField(true)->save($post,['id'=>$post['id']])) {
                $this->error('修改失败');
            } else {
                //记录日志
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'修改'.$post['module'].'导航ID:'.$post['id'].'为'.$post['name']);
                $this->success('修改'.$post['name'].'导航信息成功');
            }
        }else{
            $this->error('修改失败:非法提交！');
        }
    }

    /**
     * 删除操作
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:12
     */
    public function delete()
    {
        if($this->request->isAjax()) {
            $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;
            $where['pid']=$id;
            if((new NavModel())->where($where)->select()->isEmpty()) {
                if(false ==(new NavModel())->where('id',$id)->delete()) {
                    $this->error('删除失败');
                } else {
                    //记录日志
                    //$this->add_log($this->userSession['id'],$this->userSession['username'],'删除导航ID:'.$id);
                    $this->success('删除成功');
                }
            } else {

                $this->error('该导航下还有子导航，不能删除');
            }
        }
    }

}