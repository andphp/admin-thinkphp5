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
 * | createTime :2018/4/22 002210:06
 * +----------------------------------------------------------------------
 */


use app\common\controller\AdminController;
use app\common\model\SystemConfig as SystemConfigModel;
use app\common\model\User as UserModel;
use app\common\model\AuthGroup as AuthGroupModel;
use app\user\validate\User as UserValidate;

/**
 * USER后台配置控制器类
 * +----------------------------------------------------------------------
 * Class User
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-04-27 20:32
 */
class User extends AdminController
{

    /**
     * 注册配置信息渲染输出
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:33
     */
    public function config_register(){

        if($this->config['user_join_on']==1){
            $this->addInput('user_join_on','1','radio','开启',null,null,null,1);
            $this->addInput('user_join_on','0','radio','禁止',null,null);
        }else{
            $this->addInput('user_join_on','1','radio','开启',null,null,null,0);
            $this->addInput('user_join_on','0','radio','禁止',null,null,null,1);
        }
        $this->addFormItem('是否开启注册');
        $user_roles = (new \app\common\model\AuthGroup())->where(['is_admin'=>0])->select();
        //$name,$value=null,$type='text',$title=null,$id=false,$class=null,$extra_data=array(),$pre=null
        $this->addInput('user_role_default',$this->config['user_role_default'],'select','会员默认角色',null,null,null,$user_roles);
        $this->addFormItem('会员默认角色');
         $this->addInput('user_banned_title',$this->config['user_banned_title'],'textarea','过滤注册',null,'textareaKey',null,0);
        $this->addFormItem('禁止注册字段');
        //$title='',$href="",$id=null,$group=false,$class='',$icon="",$icon_value="",$extra_data=array
        $this->addButtonB('提交',null,null,true,'layui-btn-sm','','',['lay-filter'=>'add']);
        $this->addButtonB('重置',null,null,true,'layui-btn-sm','','',['type'=>'reset']);
        $this->addButtonForm('config_add');

        return $this->fetch('public/add');
    }

    /**
     * 配置信息提交更新
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:33
     */
    public function config_add(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $model = new SystemConfigModel();
            if($model->_update_all($post)>0){
                \think\facade\Cache::clear ();
                    $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }else{
            $this->error('失败:非法提交！');
        }
    }


    /**
     * 会员签到配置信息渲染输出
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:34
     */
    public function sign(){
        if($this->config['user_is_sign']==1){
            $this->addInput('user_is_sign','1','radio','开启',null,null,null,1);
            $this->addInput('user_is_sign','0','radio','禁止',null,null);
        }else{
            $this->addInput('user_is_sign','1','radio','开启',null,null,null,0);
            $this->addInput('user_is_sign','0','radio','禁止',null,null,null,1);
        }
        $this->addFormItem('是否开启签到');
        $this->addInput('user_sign_policy',$this->config['user_sign_policy'],'textarea','奖励积分规则',null,'textareaKey',null,0);
        $this->addFormItem('奖励积分规则');
        $this->addInput('user_sign_date',$this->config['user_sign_date'],'textarea','奖励积分规则',null,'textareaKey',null,0);
        $this->addFormItem('指定日期积分');
        //$title='',$href="",$id=null,$group=false,$class='',$icon="",$icon_value="",$extra_data=array
        $this->addButtonB('提交',null,null,true,'layui-btn-sm','','',['lay-filter'=>'add']);
        $this->addButtonB('重置',null,null,true,'layui-btn-sm','','',['type'=>'reset']);
        $this->addButtonForm('config_add');

        return $this->fetch('public/add');
    }

    /**
     * 用户列表渲染输出
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:34
     */
    public function _list(){
        $model =new UserModel();
        $user_list = $model->where('is_delete',0)->with('roles')->paginate(20,false,[
            'type'      => 'Layui',
            'var_page'  => 'page',
            'list_rows' => 15,
            'newstyle'  => true,
        ]);
        foreach($user_list as $user_info) {
            $title_group=array();
            foreach($user_info['roles'] as $role) {
                $title_group[]=$role['title'];
            }
            $user_info['title']=implode('|',$title_group);
        }
        $this->assign('user_list',$user_list);
        return $this->fetchA();

    }

    /**
     * 用户列表信息获取数据
     * @return \think\response\Json
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:35
     */
    public function select(){
        $data = (new UserModel())->select();
        $return=[
            "code"=> 0,
            "msg"=>  "",
            "count"=> 3,
            "data"=> $data
        ];
        return json($return);
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
        $model = new UserModel();
        //是修改操作
        if($this->request->isPost()) {
            //是提交操作
            $post = $this->request->post();
            if (false == $model->saveRolesByID($id,$post['roles'])) {
                $this->error('修改规则失败');
            } else {
                //记录日志
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'更新了'.$model->where(['id'=>$id])->value('username').'的角色');
                $this->success('修改规则信息成功','admin/user/_list');
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
        return $this->fetchA();
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
        $model = new UserModel();
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
     * 添加新用户
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 22:32
     */
    public function add(){
        return $this->fetchA();
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
        $model =new UserModel();
        //验证昵称是否存在
        $nickname = $model->where('nickname',$return['nickname'])->select();
        if(!$nickname->isEmpty()) {
            $this->set_saltByNick($nickname);
        }
        return $return;
    }

    /**
     * 提交新增
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:35
     */
    public function save(){
        //是新增操作
        if($this->request->isPost()) {
            //实例化管理员模型
            $model =new UserModel();
            //是提交操作
            $post = $this->request->post();
            //验证部分数据合法性
            $is_Check=(new UserValidate())->goCheck($post);
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
               // $this->add_log($this->userSession['id'],$this->userSession['username'],'添加用户:'.$post['username']);
                $this->success('添加用户成功','admin/user/_list');
            }
        }else{
            $this->error('添加用户失败:非法提交！');
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
        $model = new UserModel();
        $user_info = $model->where('id',$id)->find();
        $this->assign('user_info',$user_info);
        return $this->fetch();
    }

    /**
     * 提交更新
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:36
     */
    public function update(){
        //是修改操作
        if ($this->request->isPost()) {
            //实例化管理员模型
            $model = new UserModel();
            //是提交操作
            $post = $this->request->post();
            //验证部分数据合法性
            $is_Check=(new UserValidate())->goCheck($post);
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
            $is_delete = (new UserModel())->where('id',$post['id'])->value('is_delete');
            if($is_delete == 0) {
                if(true == (new UserModel())->where('id',$post['id'])->update(['is_delete'=>1])) {
                    //记录日志
                    //$this->add_log($this->userSession['id'],$this->userSession['username'],'删除ID:'.$post['id'].'账户');
                    $this->success('删除成功','admin/admin_user/_list');
                }
            }
            $this->error('删除失败');
        }
    }

 
}