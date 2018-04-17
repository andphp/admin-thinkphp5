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
 * | createTime :2018/4/13 001320:40
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;


use app\common\controller\AdminBase;
use app\common\model\AuthRuleGroup as AuthRuleGroupModel;

class AuthRuleGroup extends AdminBase
{
    public function _list(){

        //$title='',$href="",$group=false,$class='',$icon="",$icon_value="",$extra_data=
        $this->addButtonA('编辑',null,null,true,'layui-btn-xs','','',['lay-event'=>'edit']);
        $this->addButtonA('已启用',null,null,true,'layui-btn-xs','','',['lay-event'=>'usable']);
        $this->addButtonA('删除',null,null,true,'layui-btn-xs','','',['lay-event'=>'delete']);
        $this->addButtonBar('tableBar');

          $this->addButtonA('搜索',url('user/usable'),"buttonSearch",false,'search_btn','','',['data-type'=>'reload']);
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

}