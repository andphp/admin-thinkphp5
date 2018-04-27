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
 * | createTime :2018/4/24 002423:56
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;


use app\common\controller\AdminController;
use app\common\model\SystemConfig as SystemConfigModel;

/**
 * 站点配置控制器类
 * +----------------------------------------------------------------------
 * Class Site
 * @package app\admin\controller
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-04-27 20:31
 */
class Site extends AdminController
{

    /**
     * 站点配置信息提交更新
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:19
     */
    public function config_add(){
        //新增操作
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
     * 邮箱相关配置渲染输出
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:20
     */
    public function config_email(){
        if($this->config['email_is_verify']==1){
            $this->addInput('email_is_verify','1','radio','开启',null,null,null,1);
            $this->addInput('email_is_verify','0','radio','关闭',null,null);
        }else{
            $this->addInput('email_is_verify','1','radio','开启',null,null,null,0);
            $this->addInput('email_is_verify','0','radio','关闭',null,null,null,1);
        }
        $this->addFormItem('是否开启邮箱验证');

        $this->addButtonB('提交',null,null,true,'layui-btn-sm','','',['lay-filter'=>'add']);
        $this->addButtonB('重置',null,null,true,'layui-btn-sm','','',['type'=>'reset']);
        $this->addButtonForm('config_add');
        return $this->fetch('public/add');
    }

    /**
     * 短信相关配置渲染输出
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:20
     */
    public function config_sms(){
        if($this->config['sms_is_verify']==1){
            $this->addInput('sms_is_verify','1','radio','开启',null,null,null,1);
            $this->addInput('sms_is_verify','0','radio','关闭',null,null);
        }else{
            $this->addInput('sms_is_verify','1','radio','开启',null,null,null,0);
            $this->addInput('sms_is_verify','0','radio','关闭',null,null,null,1);
        }
        $this->addFormItem('是否开启短信验证');
        $this->addButtonB('提交',null,null,true,'layui-btn-sm','','',['lay-filter'=>'add']);
        $this->addButtonB('重置',null,null,true,'layui-btn-sm','','',['type'=>'reset']);
        $this->addButtonForm('config_add');

        return $this->fetch('public/add');
    }

}