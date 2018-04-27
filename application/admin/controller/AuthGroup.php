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
 * | createTime :2018/3/3 000313:39
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;

use app\common\controller\AdminController;
use app\common\model\AuthGroup as AuthGroupModel;
use app\admin\validate\AuthGroup as AuthGroupValidate;
use app\common\model\AuthRule as AuthRuleModel;

/**
 * 权限组（角色）控制器
 * +----------------------------------------------------------------------
 * Class AuthGroup
 * @package app\admin\controller
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-03-05 9:21
 */
class AuthGroup extends AdminController
{
    /**
     * 渲染输入角色类列表
     * @return mixed
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-03 18:14
     */
    public function _list(){
        //实例化管理员模型
        $model = new AuthGroupModel();
        $role_list = $model->paginate(20);
        $this->assign('role_list',$role_list);
        return $this->fetch('_list');
    }

    /**
     * 添加角色类信息
     * @return mixed
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-03 18:14
     */
    public function add(){
        return $this->fetch();
    }

    public function save(){
        if($this->request->isPost()) {
            $model = new AuthGroupModel();
            //是提交操作
            $post = $this->request->post();
            //验证部分数据合法性
            $is_Check=(new AuthGroupValidate())->goCheck($post);
            if($is_Check !==true){
                $this->error('提交失败：' . $is_Check);
            }
            if(false == $model->allowField(true)->save($post)) {
                $this->error('添加角色失败');
            } else {
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'添加角色：'.$post['title']);
                $this->success('添加角色成功','admin/auth_group/_list');
            }
        }else{
            $this->error('添加角色失败:非法提交！');
        }
    }

    /**
     * 编辑角色类信息
     * @param int $id
     * @return mixed
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-03 18:14
     */
    public function edit($id=0){
        //获取菜单id
        $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') :$id;
        if($id == 0) {
            $this->error('id不能为空');
        }
        $model = new AuthGroupModel();
        //非提交操作
        $role = $model->where('id',$id)->find();
        if(empty($role)) {
            $this->error('id不正确');
        }
        $this->assign('role',$role);
        return $this->fetch();
    }

    public function update(){
        //是修改操作
        if($this->request->isPost()) {
            $model = new AuthGroupModel();
            //是提交操作
            $post = $this->request->post();

            //验证部分数据合法性
            $is_Check=(new AuthGroupValidate())->goCheck($post);
            if($is_Check !==true){
                $this->error('提交失败：' . $is_Check);
            }

            //验证菜单是否存在
            $role = $model->where(['title'=>$post['title'],['id','neq',$post['id']]])->find();
            if(!empty($role)) {
                $this->error('该角色标题已经存在');
            }
            if(false == $model->allowField(true)->save($post,['id'=>$post['id']])) {
                $this->error('修改失败');
            } else {
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'修改角色ID:'.$post['id'].'角色信息');
                $this->success('修改权限信息成功','admin/auth_group/_list');
            }
        }else {
            $this->error('修改失败:非法提交！');
        }
    }

    /**
     * 编辑角色类授权规则
     * @param int $id
     * @return mixed
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-03 18:13
     */
    public function edit_rule($id=0){
        //获取角色id
        $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') :$id;
        $model = new AuthGroupModel();
        //是修改操作
        if($id == 0) {
            $this->error('id不能为空');
        }
        //非提交操作
        $role = $model->find(['id'=>$id]);
        $role['rules']=explode(",", $role['rules']);
        $model = new AuthRuleModel();
        $menu = $model->order('orders asc')->select();
        $menus = $model->menuList($menu);
        $this->assign('menus',$menus);
        $this->assign('role',$role);
        return $this->fetch();
    }

    /**
     * 提交更新操作
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 19:54
     */
    public function update_rule(){
        //是修改操作
        if($this->request->isPost()) {
            $model = new AuthGroupModel();
            //是提交操作
            $post = $this->request->post();
            $save['rules'] = implode(",", $post['rules']);
            if (false == $model->allowField(true)->save($save, ['id' => $post['id']])) {
                $this->error('修改规则失败');
            } else {
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'修改角色ID:'.$post['id'].'规则');
                $this->success('修改规则信息成功','admin/auth_group/_list');
            }
        }else{
            $this->error('修改规则失败:非法提交！');
        }
    }

    /**
     * 更新角色类状态 开启|禁止
     * @return \think\response\Json
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-03 18:12
     */
    public function update_status(){
        if ($this->request->isGet()) {
            $get = $this->request->get();
            $model = new AuthGroupModel();
            if ($model->where('id', $get['id'])->update(['status' =>$get['status']]) !== false) {
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'更新角色ID：'.$get['id'].'状态');
                //  $this->success('更新成功');
                return json(array('code' => 200, 'msg' => '更新成功'));
            }
        }
        // $this->error('更新失败');
        return json(array('code' => 0, 'msg' => '更新失败'));
    }

}