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
 * | createTime :2018/3/3 000318:37
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;


use app\common\controller\AdminController;
use app\common\model\SystemConfig as SystemConfigModel;
use app\admin\validate\SystemConfig as SystemConfigValidate;
use think\facade\Cache;

/**
 * 系统配置控制器
 * +----------------------------------------------------------------------
 * Class SystemConfig
 * @package app\admin\controller
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-03-04 14:08
 */
class SystemConfig extends AdminController
{
    /**
     * 渲染输出全局配置项列表
     * @return mixed
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-04 14:08
     */
    public function _list(){
        $model = new SystemConfigModel();
        $configList = $model->order('id asc,orders asc')->paginate(20,false,[
            'type'      => 'Layui',
            'var_page'  => 'page',
            'list_rows' => 15,
            'newstyle'  => true,
        ]);
        $this->assign('config_list',$configList);
        $this->assign('show',true);
        return $this->fetch('_list');
    }

    /**
     * 更新配置项排序
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-04 14:09
     */
    public function orders()
    {
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $order = (new SystemConfigModel())->where('id',$val)->value('orders');
                if($order != $post['orders'][$k]) {
                    if(false == (new SystemConfigModel())->where('id',$val)->update(['orders'=>$post['orders'][$k]])) {
                        $this->error('更新失败');
                    } else {
                        $i++;
                    }
                }
            }
            $this->success('成功更新'.$i.'个数据','admin/system_config/_list');
        }
    }

    /**
     * 更新配置项数值 value
     * @return \think\response\Json
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-04 14:10
     */
    public function update_value(){
        $get = request()->param();
        $model = new SystemConfigModel();
        if($get['type']=='checkbox'){
            $config=$model->find($get['id']);
            if($config['value'] == true) {
                if(strpos($config['value'],',') !==false) {
                    $arr = explode(',', $config['value']);
                    if (in_array($get['value'], $arr)) {
                        array_splice($arr,array_search($get['value'],$arr),1);
                    } else {
                        $arr[] = $get['value'];
                    }
                }elseif($config['value']==$get['value']){
                    $arr=[];
                    $get['value']='';
                }else{
                    $arr[]=$config['value'];
                    $arr[] = $get['value'];
                }
                if(count($arr)>=2){
                    $get['value'] = implode(',', $arr);
                }elseif(count($arr)==1){
                    $get['value'] = $arr[0];
                };
            }
        }
        if ($model->where('id', $get['id'])->update(['value' =>$get['value']]) !== false) {

            //  清空缓存
            Cache::clear();
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'更新配置项：'.$model->where('id', $get['id'])->value('title').'值=》'.$get['value']);
            return json(array('code' => 200, 'msg' => '更新成功'));
        }
        // $this->error('更新失败');
        return json(array('code' => 0, 'msg' => '更新失败'));
    }

    /**
     * 新增配置项
     * @return mixed
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-04 17:30
     */
    public function add(){
        return $this->fetch();
    }

    /**
     * 提交新增
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:21
     */
    public function save(){
        //新增操作
        if($this->request->isPost()) {
            $model = new SystemConfigModel();
            //是提交操作
            $post = $this->request->post();
            //验证部分数据合法性
            $is_Check=(new SystemConfigValidate())->goCheck($post);
            if($is_Check !==true){
                $this->error('提交失败：' . $is_Check);
            }
            //验证变量名称是否存在
            $nickname = $model->where('vari',$post['vari'])->select();
            if(!$nickname->isEmpty()) {
                $this->error('提交失败：该变量名称已被占用');
            }

            if(false == $model->allowField(true)->save($post)) {
                $this->error('添加配置失败');
            } else {
                //  清空缓存
                Cache::clear();
                //记录日志
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'新增：'.$post['vari'].'配置项');
                $this->success('添加配置成功','/admin/system_config/_list');
            }
        }else{
            $this->error('添加配置失败:非法提交！');
        }
    }

    /**
     * 修改配置项
     * @param int $id
     * @return mixed
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-04 19:48
     */
    public function edit($id=0){
        //获取配置项id
        $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : $id;
        if($id == 0) {
            $this->error('id不正能为空');
        }
        $model = new SystemConfigModel();
        //非提交操作
        $config_data = $model->where('id',$id)->find();
        $this->assign('config_data',$config_data);
        return $this->fetch();
    }

    /**
     * 提交更新
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:22
     */
    public function update(){
        //修改操作
        if($this->request->isPost()) {
            $model = new SystemConfigModel();
            //是提交操作
            $post = $this->request->post();
            //验证部分数据合法性
            $is_Check=(new SystemConfigValidate())->goCheck($post);
            if($is_Check !==true){
                $this->error('提交失败：' . $is_Check);
            }
            //验证变量名是否存在
            $name = $model->where(['vari'=>$post['vari']])->where('id','neq',$post['id'])->find();
            if(!empty($name)) {
                $this->error('提交失败：该变量名已经存在！');
            }
            if(false == $model->allowField(true)->save($post,['id'=>$post['id']])) {
                $this->error('修改失败');
            } else {
                //  清空缓存
                Cache::clear();
                //记录日志
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'修改：'.$post['vari'].'配置项');
                $this->success('修改管理员信息成功','admin/system_config/_list');
            }
        }else{
            $this->error('修改失败:非法操作！');
        }
    }

    /**
     * 更新数据
     * @param $group
     * @param $data
     * @return int
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:24
     */
    public function common_update($group,$data){
        //修改操作
        $model = new SystemConfigModel();
        $ok = 0;
        foreach ($data as $key => $value) {
            if($model->where(['vari'=>$key])->update(['value'=>$value])){
                $ok=$ok+1;
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'更新了'.$group.'配置项'.$key.'为'.$value);
            }
        }
        return $ok;
    }

    /**
     * 删除配置项
     * @param int $id
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-04 19:51
     */
    public function delete($id=0){
        if($this->request->isAjax()) {
            $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : $id;
            if($id==0){
                $this->error('删除失败:未获取配置项ID');
            }
            $qr=(new SystemConfigModel())->where(['id'=>$id])->find();
            if(!empty($qr)) {
                if(false ==(new SystemConfigModel())->where('id',$id)->delete()) {
                    $this->error('删除失败');
                } else {
                    $this->success('删除成功','admin/system_config/_list');
                }
            }
        }
    }


    /**
     * 渲染输出站点相关配置
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 9:02
     */
    public function site(){
        $config_lists=(new SystemConfigModel())->where('group','site')->paginate(20);
        $this->assign('config_list',$config_lists);
        return $this->fetch('_list');
    }

    /**
     * 渲染输出邮箱相关配置
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :date
     */
    public function email(){
        $config_email=(new SystemConfigModel())->where('group','email')->column('vari,value');
        $this->assign('config_email',$config_email);
        return $this->fetch();
    }

    /**
     * 渲染输出短信相关配置
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 9:17
     */
    public function sms(){
        $config_lists=(new SystemConfigModel())->where('group','sms')->paginate(20);
        $this->assign('config_list',$config_lists);
        return $this->fetch('_list');
    }

    /**
     * 渲染输出图片相关配置
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 9:18
     */
    public function images(){
        $config_lists=(new SystemConfigModel())->where('group','images')->paginate(20);
        $this->assign('config_list',$config_lists);
        return $this->fetch('_list');
    }

    /**
     * 渲染输出Home相关配置
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-07 9:35
     */
    public function home(){
        $config_lists=(new SystemConfigModel())->where('group','home')->paginate(20);
        $this->assign('config_list',$config_lists);
        return $this->fetch('_list');
    }

    /**
     * 渲染输出User相关配置
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-13 14:37
     */
    public function user(){
        $config_lists=(new SystemConfigModel())->where('group','user')->paginate(20);
        $this->assign('config_list',$config_lists);
        return $this->fetch('_list');
    }
}