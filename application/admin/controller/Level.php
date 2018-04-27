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
 * | createTime :2018/4/25 002518:04
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;


use app\common\controller\AdminController;
use app\common\model\UserLevel;

/**
 * 用户VIP会员等级控制器类
 * +----------------------------------------------------------------------
 * Class Level
 * @package app\admin\controller
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-04-27 20:29
 */
class Level extends AdminController
{
    /**
     * 前台VIP会员等级信息配置
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:03
     */
    public function config(){
        //$title='',$href="",$group=false,$class='',$icon="",$icon_value="",$extra_data=
        $this->addButtonA('编辑',null,null,true,'layui-btn-xs','','',['lay-event'=>'edit']);
        $this->addButtonA('修改状态',null,null,true,'layui-btn-xs','','',['lay-event'=>'usable']);
        $this->addButtonA('删除',null,null,true,'layui-btn-xs','','',['lay-event'=>'delete']);
        $this->addButtonBar('tableBar');

        $this->addButtonA('添加',null,"buttonAdd",false,'layui-btn-normal addAction_btn');
        //$this->addButtonA('删除',url('user/usable'),"buttonDelete",false,'layui-btn-danger layui-btn-normal delAll_btn');

       // $field,$title,$minWidth=60,$fixed=null,$width=null,$templet=null,$type=null,$align='left',$toolbar=null,$LAY_CHECKED=false,$sort=false,$unresize=false
        $this->addTableColumn(null,null,20,'left','20',null,'checkbox');
        $this->addTableColumn('id','ID',100,'center');
        $this->addTableColumn('name','名称',100,'center');
        $this->addTableColumn('discount','折扣率（%）',100,'center');
        $this->addTableColumn('intro','徽章图标',100,'center',null,'function(d){
            return d.badge == false ? "没有徽章" : "<i class=\'fa "+d.badge+"\' aria-hidden=\'true\'></i>";
        }');
        $this->addTableColumn('expire','有效期',100,'center');
        $this->addTableColumn('status','状态',100,'center',null,'function(d){
            return d.status == "0" ? "禁止" : "启用";
        }','radio');
        $this->addTableColumn('create_time','创建时间',100,'center');
        $this->addTableColumn(null,'操作',null,'center',200,'"#tableBar"',null,'right');
        $this->addTable('eeedd',url('select'),['lay-skin'=>'row','lay-siz'=>'sm']);

        return $this->fetch('public/_list');
    }

    /**
     * FORM表单获取列表数据
     * @return \think\response\Json
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:04
     */
    public function select(){
        $data = request()->param();
        $count = (new UserLevel())->count();
        $data = (new UserLevel())->limit(($data['page']-1)*$data['limit'],$data['limit'])->select();

        $return=[
            "code"=> 0,
            "msg"=>  "",
            "count"=> $count,
            "data"=> $data
        ];
        return json($return);
    }

    /**
     * 渲染输出新增、修改FORM表单
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:04
     */
    public function add(){
        //$name,$value=null,$type='text',$title=null,$id=null,$class=null,$extra_data=array()
        $this->addInput('id',0,'hidden');
        $this->addFormItem();

        $this->addInput('name');
        $this->addFormItem('名称');

        $this->addInput('discount');
        $this->addFormItem('折扣率（%）');

        $this->addInput('intro');
        $this->addFormItem('徽章图标');

        $this->addInput('expire');
        $this->addFormItem('有效期');

        $this->addInput('status','1','radio','启用',null,null,null,1);
        $this->addInput('status','0','radio','禁止',null,null);
        $this->addFormItem('状态');

        //$title='',$href="",$id=null,$group=false,$class='',$icon="",$icon_value="",$extra_data=array
        $this->addButtonB('提交',null,null,true,'layui-btn-sm','','',['lay-filter'=>'add']);
        $this->addButtonB('重置',null,null,true,'layui-btn-sm','','',['type'=>'reset']);
        $this->addButtonForm('save');

        return $this->fetch('public/add');
    }

    /**
     * 更新FORM表单提交数据
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:05
     */
    public function save(){
        //新增操作
        if($this->request->isPost()) {
            $post = $this->request->post();
            $model = new UserLevel();
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
                    $this->success('修改成功',"1");
                }
            }

        }else{
            $this->error('失败:非法提交！');
        }
    }

    /**
     * 删除操作
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:06
     */
    public function delete(){
        $data = request()->param();
        $model = new UserLevel();
        if($model->where('id',$data['id'])->delete()){
            $this->success('删除成功');
        }
        $this->error('删除失败');
    }

    /**
     * 更新状态
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-27 20:06
     */
    public function usable(){
        $data = request()->param();
        $model = new UserLevel();
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
}