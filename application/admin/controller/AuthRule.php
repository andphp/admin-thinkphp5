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
 * | createTime :2018/3/2 000219:02
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;


use app\admin\validate\AuthRule as AuthRuleValidate;
use app\common\controller\AdminBase;
use app\common\model\AuthRule as AuthRuleModel;

/**
 *权限控制器（包括后台菜单控制）
 * +----------------------------------------------------------------------
 * Class AuthRule
 * @package app\admin\controller
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-03-02 19:02
 */
class AuthRule extends AdminBase
{

    /**
     * 输出权限/菜单列表
     * @return mixed
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-02 19:49
     */
    public function _list(){
        $model = new AuthRuleModel();
        $menu = $model->order('id asc,orders asc')->select();
        $menus = $model->menuList($menu);
        $this->assign('menus',$menus);
        return $this->fetch();
    }

    /**
     * 添加权限节点
     * @return mixed
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-03 13:39
     */
    public function add($pid=0){
        //非提交操作
        $pid = $this->request->has('pid') ? $this->request->param('pid', null, 'intval') : $pid;
        $model = new AuthRuleModel();
       if($pid>0){
           $menu = $model->where('id',$pid)->find();
           if(empty($menu)) {
               $this->error('pid不正确');
           }
           $rule_name=explode("/",$menu['name']);
           $menu['title']='';
           $menu['id']='';
           $menu['pid']='';
           $menu['module']=$rule_name[0];
           $menu['controller']=$rule_name[1];
           $this->assign('menu',$menu);
           $this->assign('pid',$pid);
       }
        $menu = $model->select();
        $menus = $model->menuList($menu);
        $this->assign('menus',$menus);
        return $this->fetch();
    }

    public function save(){
        //新增操作
        if($this->request->isPost()) {
            $model = new AuthRuleModel();
            //是提交操作
            $post = $this->request->post();

            //验证部分数据合法性
            $is_Check=(new AuthRuleValidate())->goCheck($post);
            if($is_Check !==true){
                $this->error('提交失败：' . $is_Check);
            }
            $post['name']=$post['module'].'/'.$post['controller'].'/'.$post['function'];
            //验证菜单是否存在
            $menu = $model->where(['name'=>$post['name']])->find();
            if(!empty($menu)) {
                $this->error('该规则已经存在');
            }

            if(false == $model->allowField(true)->save($post)) {
                $this->error('添加权限失败');
            } else {
                //记录日志
                $this->add_log($this->userSession['id'],$this->userSession['username'],'添加权限规则：'.$post['name']);
                $this->success('添加权限成功','admin/auth_rule/_list');
            }
        }else{
            $this->error('添加权限失败:非法提交！');
        }
    }

    /**
     * 修改权限节点
     * @param int $id
     * @return mixed
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-03 13:40
     */
    public function edit($id=0){
        //获取菜单id
        $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') :$id;
        if($id == 0) {
            $this->error('id不正能为空');
        }
        $model = new AuthRuleModel();
        //非提交操作
        $menu = $model->where('id',$id)->find();
        if(empty($menu)) {
            $this->error('id不正确');
        }
        $menus = $model->select();
        $menus_all = $model->menuList($menus);
        $this->assign('menus',$menus_all);

        $rule_name=explode("/",$menu['name']);
        $menu['module']=$rule_name[0];
        $menu['controller']=$rule_name[1];
        $menu['function']=$rule_name[2];
        $this->assign('menu',$menu);
        return $this->fetch();
    }

    public function update(){
        //是修改操作
        if($this->request->isPost()) {
            $model = new AuthRuleModel();
            //是提交操作
            $post = $this->request->post();

            //验证部分数据合法性
            $is_Check=(new AuthRuleValidate())->goCheck($post);
            if($is_Check !==true){
                $this->error('提交失败：' . $is_Check);
            }
            $post['name']=$post['module'].'/'.$post['controller'].'/'.$post['function'];
            //验证菜单是否存在
            $menu = $model->where(['title'=>$post['title'],['id','neq',$post['id']]])->find();
            if(!empty($menu)) {
                $this->error('该规则标题已经存在');
            }
            $menu = $model->where(['name'=>$post['name'],['id','neq',$post['id']]])->find();
            if(!empty($menu)) {
                $this->error('该规则方法已经存在');
            }
            if(false == $model->allowField(true)->save($post,['id'=>$post['id']])) {
                $this->error('修改失败');
            } else {
                //记录日志
                $this->add_log($this->userSession['id'],$this->userSession['username'],'修改权限规则ID:'.$post['id']);
                $this->success('修改权限信息成功','admin/auth_rule/_list');
            }
        }else{
            $this->error('修改失败:非法提交！');
        }
    }

    /**
     * 删除权限节点
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-03 13:40
     */
    public function delete()
    {
        if($this->request->isAjax()) {
            $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;
            $where['pid']=$id;
            if((new AuthRuleModel())->where($where)->select()->isEmpty()) {
                if(false ==(new AuthRuleModel())->where('id',$id)->delete()) {
                    $this->error('删除失败');
                } else {
                    //记录日志
                    $this->add_log($this->userSession['id'],$this->userSession['username'],'删除权限规则ID:'.$id);
                    $this->success('删除成功','admin/auth_rule/_list');
                }
            } else {

                $this->error('该菜单下还有子菜单，不能删除');
            }
        }
    }

    /**
     * 更新排序
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-03 13:40
     */
    public function orders()
    {
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $order = (new AuthRuleModel())->where('id',$val)->value('orders');
                if($order != $post['orders'][$k]) {
                    if(false == (new AuthRuleModel())->where('id',$val)->update(['orders'=>$post['orders'][$k]])) {
                        $this->error('更新失败');
                    } else {
                        $i++;
                    }
                }
            }
            $this->success('成功更新'.$i.'个数据','admin/auth_rule/_list');
        }
    }

}