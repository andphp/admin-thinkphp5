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
 * | createTime :2018/3/5 00059:20
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;


use app\admin\validate\AdminUser as AdminUserValidate;
use app\common\controller\AdminController;
use app\common\model\AdminUser as AdminUserModel;
use app\common\model\AuthGroup as AuthGroupModel;

/**
 * 后台管理员控制器类
 * +----------------------------------------------------------------------
 * Class AdminUser
 * @package app\admin\controller
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-04-27 20:26
 */
class AdminUser extends AdminController
{

    /**
     * 渲染输出管理员列表
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 13:19
     */
    public function _list(){
        //实例化管理员模型
        $model =new AdminUserModel();
        $user_list = $model->where('is_delete',0)->with('roles')->paginate(20);
        foreach($user_list as $user_info) {
            $title_group=array();
            foreach($user_info['roles'] as $role) {
                $title_group[]=$role['title'];
            }
            $user_info['title']=implode('|',$title_group);
        }
        $this->assign('user_list',$user_list);
        return $this->fetch('_list');
    }

    /**
     * 修改密码
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 21:10
     */
    public function edit_password(){
        //获取管理员登录id
        $adminUser = $this->userSession;
        $id=$adminUser['id'];
        //修改操作
        $this->assign('id',$id);
        return $this->fetch();
    }

    /**
     * 提交更新密码
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 19:53
     */
    public function update_password(){
        $adminUser = $this->userSession;
        $id=$adminUser['id'];
        if($this->request->isPost()) {
            //是提交操作
            $post = $this->request->post();
            //验证部分数据合法性
            $is_Check=(new AdminUserValidate())->goCheck($post);
            if($is_Check !==true){
                $this->error('提交失败：' . $is_Check);
            }
            //实例化管理员模型
            $model =new AdminUserModel();
            //验证密码
            $user = $model->where('id',$post['id'])->find();
            if($user['password'] != passwordMD5($post['password_old'],$user['salt'])) {
                $this->error('密码错误');
            }
            $log['user_id']=$id;
            $log['is_admin']=1;
            $log['field']='password';
            $log['value']=$post['password_old'];
//            if( empty((new LogEditModel())->save($log))){
//                $this->error('修改失败,系统错误');
//            }
            $data['password']=passwordMD5($post['password_new'],$user['salt']);
            if(false == $model->allowField(true)->save($data,['id'=>$id])) {
                $this->error('修改失败');
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'将原密码'.$post['password_old'].'修改了');
            $this->success('修改管理员信息成功','admin/index/welcome');
        }
        $this->error('修改失败:非法提交！');
    }

    /**
     * 根据昵称获取加盐值 保证昵称数据唯一性
     * @param $nickname
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 16:14
     */
    public function set_saltByNick($nickname){
        $return['salt']=getRandStr(6);
        $return['nickname']=$nickname.'_'.$return['salt'];
        //实例化管理员模型
        $model =new AdminUserModel();
        //验证昵称是否存在
        $nickname = $model->where('nickname',$return['nickname'])->select();
        if(!$nickname->isEmpty()) {
            $this->set_saltByNick($nickname);
        }
        return $return;
    }

    /**
     * 添加新用户
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 22:32
     */
    public function add(){
        return $this->fetch();
    }

    public function save(){
        //是新增操作
        if($this->request->isPost()) {
            //实例化管理员模型
            $model =new AdminUserModel();
            //是提交操作
            $post = $this->request->post();
            //验证部分数据合法性
            $is_Check=(new AdminUserValidate())->goCheck($post);
            if($is_Check !==true){
                $this->error('提交失败：' . $is_Check);
            }
            //验证用户名是否存在
            $name = $model->where('username',$post['username'])->select();
            if(!$name->isEmpty()) {
                $this->error('提交失败：该用户名已被注册');
            }
            $set_nickAndSalt=$this->set_saltByNick($post['nickname']);
            $post['salt']=$set_nickAndSalt['salt'];
            $post['nickname']=$set_nickAndSalt['nickname'];
            //验证邮箱是否存在
            $email = $model->where(['email'=>$post['email']])->select();
            if(!$email->isEmpty()) {
                $this->error('提交失败：该邮箱已被占用');
            }
            //验证电话是否存在
            $phone = $model->where(['phone'=>$post['phone']])->select();
            if(!$phone->isEmpty()) {
                $this->error('提交失败：该电话已被占用');
            }
            //密码处理
            $post['password'] = passwordMD5($post['password'],$post['salt']);
            if(false == $model->allowField(true)->save($post)) {

                $this->error('添加管理员失败');
            } else {
                //记录日志
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'添加用户:'.$post['username']);
                $this->success('添加管理员成功','admin/admin_user/_list');
            }
        }else{
            $this->error('添加管理员失败:非法提交！');
        }
    }

    /**
     * 编辑管理员账户基本信息  //非提交操作
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 22:31
     */
    public function edit($id=0){
        //获取用户id
        $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : $id;
        if($id == 0) {
            $this->error('id不正能为空');
        }
        //实例化管理员模型
        $model = new AdminUserModel();
        $user_info = $model->where('id',$id)->find();
        $this->assign('user_info',$user_info);
        return $this->fetch();
    }

    public function update(){
        //是修改操作
        if ($this->request->isPost()) {
            //实例化管理员模型
            $model = new AdminUserModel();
            //是提交操作
            $post = $this->request->post();
            //验证部分数据合法性
            $is_Check=(new AdminUserValidate())->goCheck($post);
            if($is_Check !==true){
                $this->error('提交失败：' . $is_Check);
            }
            if (false == $model->allowField(true)->save($post, ['id' => $post['id']])) {
                $this->error('修改失败');
            } else {
                //记录日志
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'修改了基本账户信息');
                $this->success('修改账户信息成功', 'admin/admin_user/_list');
            }
        }else{
            $this->error('修改失败:非法提交！');
        }
    }

    /**
     * 删除用户账户（屏蔽）
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 17:56
     */
    public function delete(){
        if($this->request->isAjax()) {
            $post = $this->request->param();
            $is_delete = (new AdminUserModel())->where('id',$post['id'])->value('is_delete');
            if($is_delete == 0) {
                if(true == (new AdminUserModel())->where('id',$post['id'])->update(['is_delete'=>1])) {
                    //记录日志
                    //$this->add_log($this->userSession['id'],$this->userSession['username'],'删除ID:'.$post['id'].'账户');
                    $this->success('删除成功','admin/admin_user/_list');
                }
            }
            $this->error('删除失败');
        }
    }
    /**
     * 更新用户状态 启用/禁止
     * @return \think\response\Json
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 15:33
     */
    public function update_status(){
        if ($this->request->isGet()==false) {
            return json(array('code' => 0, 'msg' => '更新失败'));
        }
        $get = $this->request->get();
        $model = new AdminUserModel();
        if ($model->where('id', $get['id'])->update(['status' =>$get['status']]) !== false) {
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'更新ID:'.$get['id'].'账户状态');
            //  $this->success('更新成功');
            return json(array('code' => 200, 'msg' => '更新成功'));
        }
        // $this->error('更新失败');
        return json(array('code' => 0, 'msg' => '更新失败'));
    }

    /**
     * 批量更新 启用账户
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 15:55
     */
    public function enable(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['user_id'] as $k => $val) {
                $status = (new AdminUserModel())->where('id',$val)->value('status');
                if($status == 0) {
                    if(false == (new AdminUserModel())->where('id',$val)->update(['status'=>1])) {
                        $this->error('更新失败');
                    } else {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量启用ID账户【'.implode(',',$post['user_id']).'】');
            $this->success('更新成功，启用'.$i.'个账户','admin/admin_user/_list');
        }
    }

    /**
     * 批量更新 禁用账户
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 16:00
     */
    public function prohibit(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['user_id'] as $k => $val) {
                $status = (new AdminUserModel())->where('id',$val)->value('status');
                if($status == 1) {
                    if(false == (new AdminUserModel())->where('id',$val)->update(['status'=>0])) {
                        $this->error('更新失败');
                    } else {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量禁用ID账户【'.implode(',',$post['user_id']).'】');
            $this->success('更新成功，禁用'.$i.'个账户','admin/admin_user/_list');
        }
    }

    /**
     * 批量更新 删除账户
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 16:06
     */
    public function delete_all(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['user_id'] as $k => $val) {
                $is_delete = (new AdminUserModel())->where('id',$val)->value('is_delete');
                if($is_delete == 0) {
                    if(false == (new AdminUserModel())->where('id',$val)->update(['is_delete'=>1])) {
                        $this->error('更新失败');
                    } else {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量删除ID账户【'.implode(',',$post['user_id']).'】');
            $this->success('更新成功，删除'.$i.'个账户','admin/admin_user/_list');
        }
    }

    /**
     * 批量更新 重置账户密码 123456
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 16:29
     */
    public function reset_password(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            $model = new AdminUserModel();
            foreach ($post['user_id'] as $k => $val) {
                $userInfo = $model->where('id',$val)->find();
                $saveInfo = $this->set_saltByNick($userInfo['nickname']);
                //密码处理
                $saveInfo['password'] = passwordMD5($this->config['default_password'],$saveInfo['salt']);
                if(false == $model->allowField(true)->save($saveInfo,['id'=>$val])) {
                    $this->error('更新失败');
                } else {
                    $i++;
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量重置密码【'.$this->config['default_password'].'】ID账户：'.implode(',',$post['user_id']));
            $this->success('更新成功，重置'.$i.'个账户密码:'.$this->config['default_password'],'admin/admin_user/_list');
        }
    }

    /**
     * 更新用户角色组
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 22:30
     */
    public function edit_roles(){
        //获取角色id
        $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') :0;
        $model = new AdminUserModel();
        //是修改操作
        if($this->request->isPost()) {
            //是提交操作
            $post = $this->request->post();
            if (false == $model->saveRolesByID($id,$post['roles'])) {
                $this->error('修改规则失败');
            } else {
                //记录日志
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'更新了'.$model->where(['id'=>$id])->value('username').'的角色');
                $this->success('修改规则信息成功','admin/admin_user/_list');
            }
        }else {
            if($id == 0) {
                $this->error('id不能为空');
            }
            //非提交操作

            // 获取用户的所有角色
            $roles = $model->with('roles')->find(['id'=>$id]);
            $user_roles=array();
            foreach ($roles['roles'] as $key=>$role) {
                // 输出用户的角色名
                $user_roles[]= $role->id;
            }
            $this->assign('user_roles',$user_roles);
            $model = new AuthGroupModel();
            $role_group = $model->where(['status'=>1])->select();
            $this->assign('role_group',$role_group);
            $this->assign('username',$roles);
        }
        return $this->fetch();
    }
}