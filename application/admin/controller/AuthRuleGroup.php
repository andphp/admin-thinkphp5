<?php
/**
 * | AndPHP [ PHP and I ]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2017-2022 http://www.wyz.ltd All rights reserved
 * +----------------------------------------------------------------------
 * | AndPHP承诺基础框架永久免费开源，您可用于学习和商用，但必须保留软件版权信息。
 * +----------------------------------------------------------------------
 * | Author : BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | CreateTime : 2018/4/27 002715:36
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;


use app\common\controller\AdminController;
use app\common\model\AuthRuleGroup as AuthRuleGroupModel;

/**
 * 后台菜单分组控制器类
 * +----------------------------------------------------------------------
 * Class AuthRuleGroup
 * @package app\admin\controller
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-04-27 20:27
 */
class AuthRuleGroup extends AdminController
{
    /**
     * 输出权限组/后台顶部菜单列表
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 19:56
     */
    public function _list(){

        //$title='',$href="",$group=false,$class='',$icon="",$icon_value="",$extra_data=
        $this->addButtonA('编辑',null,null,true,'layui-btn-xs','','',['lay-event'=>'edit']);
        $this->addButtonA('修改状态',null,null,true,'layui-btn-xs','','',['lay-event'=>'usable']);
        $this->addButtonA('删除',null,null,true,'layui-btn-xs','','',['lay-event'=>'delete']);
        $this->addButtonBar('tableBar');



        $this->addButtonA('添加',null,"buttonAdd",false,'layui-btn-normal addAction_btn');
        $this->addButtonA('删除',url('user/usable'),"buttonDelete",false,'layui-btn-danger layui-btn-normal delAll_btn');

//        $field,$title,$minWidth=60,$fixed=null,$width=null,$templet=null,$type=null,$align='left',$toolbar=null,$LAY_CHECKED=false,$sort=false,$unresize=false
        $this->addTableColumn(null,null,20,'left','20',null,'checkbox');
        $this->addTableColumn('id','ID',100,'center');
        $this->addTableColumn('title','标题',100,'center');
        $this->addTableColumn('status','状态',100,'center',null,'function(d){
            return d.status == "0" ? "禁止" : "显示";
        }','radio');
        $this->addTableColumn(null,'操作',null,'center',200,'"#tableBar"',null,'right');
        $this->addTable('eeedd',url('AuthRuleGroup/select'),['lay-skin'=>'row','lay-siz'=>'sm']);

        return $this->fetch('public/_list');
    }

    /**
     * 列表获取查询数据
     * @return \think\response\Json
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 19:57
     */
    public function select(){
        $data = (new AuthRuleGroupModel())->select();

        $return=[
            "code"=> 0,
            "msg"=>  "",
            "count"=> 3,
            "data"=> $data
        ];
        return json($return);
    }

    /**
     * 渲染输出添加、编辑 FORM表单
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 19:57
     */
    public function add(){
        //$name,$value=null,$type='text',$title=null,$id=null,$class=null,$extra_data=array()
        $this->addInput('id',0,'hidden');
        $this->addFormItem();

        $this->addInput('title');
        $this->addFormItem('标题');

        $this->addInput('status','1','radio','显示',null,null,null,1);
        $this->addInput('status','0','radio','禁止',null,null);
        $this->addFormItem('状态');

        //$title='',$href="",$id=null,$group=false,$class='',$icon="",$icon_value="",$extra_data=array
        $this->addButtonB('提交',null,null,true,'layui-btn-sm','','',['lay-submit'=>'','lay-filter'=>'add']);
        $this->addButtonB('重置',null,null,true,'layui-btn-sm','','',['type'=>'reset']);
        $this->addButtonForm();

        return $this->fetch('public/add');
    }

    /**
     * 更新表单提交数据
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 19:58
     */
    public function save(){
        //新增操作
        if($this->request->isPost()) {
            $post = $this->request->post();
            $model = new AuthRuleGroupModel();
            if(!isset($post['id']) or $post['id']==0){
                if(false == $model->allowField(true)->save($post)) {
                    $this->error('添加失败');
                } else {
                    //记录日志
                    $this->success('添加成功');
                }
            }else{
                if(false == $model->allowField(true)->save($post,['id'=>$post['id']])) {
                    $this->error('修改失败');
                } else {
                    //记录日志
                    $this->success('修改成功');
                }
            }

        }else{
            $this->error('失败:非法提交！');
        }
    }

    /**
     * 修改状态更新
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 19:59
     */
    public function usable(){
        $data = request()->param();
        $model = new AuthRuleGroupModel();
        if($data['status'] == 0){
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }
        if($model->update($data)){
            $this->success('修改成功');
        }
        $this->error('修改失败');
    }

    /**
     * 删除操作
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 19:59
     */
    public function delete(){
        $data = request()->param();
        $model = new AuthRuleGroupModel();
        if($model->where('id',$data['id'])->delete()){
            $this->success('删除成功');
        }
        $this->error('删除失败');
    }

}