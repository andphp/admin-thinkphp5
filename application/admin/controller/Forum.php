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
 * | createTime :2018/3/24 00248:45
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;

use app\common\controller\AdminController;
use app\common\model\Attachment;
use app\common\model\ForumCategory as ForumCategoryModel;
use app\common\model\Forum as ForumModel;

class Forum extends AdminController
{

    public function config(){
        $config_title=$this->config['forum_title'];
        $config_resume=$this->config['forum_resume'];
        $this->assign('config_title',$config_title);
        $this->assign('config_resume',$config_resume);
        return $this->fetch();
    }
//============================================================================================================================
    public function category_list(){
        $model=(new ForumCategoryModel());
        $menu = $model->order('id asc,orders asc')->select();
        $menus = $model->menuList($menu);
        $this->assign('category',$menus);
        return $this->fetch();

    }
    public function category_add(){
        return $this->fetch();
    }
    public function category_save(){
        //新增操作
        if($this->request->isPost()) {
            $model = new ForumCategoryModel();
            //是提交操作
            $post = $this->request->post();

            //验证菜单是否存在
            $menu = $model->where(['name'=>$post['name']])->find();
            if(!empty($menu)) {
                $this->error('该板块名称已经存在');
            }

            if(false == $model->allowField(true)->save($post)) {
                $this->error('添加新板块失败');
            } else {
                //记录日志
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'添加新板块：'.$post['name']);
                $this->success('添加新板块成功','admin/forum/category_list');
            }
        }else{
            $this->error('添加新板块失败:非法提交！');
        }
    }
    public function category_edit($id=0){
        //获取菜单id
        $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') :$id;
        if($id == 0) {
            $this->error('id不正能为空');
        }
        $model = new ForumCategoryModel();
        //非提交操作
        $category = $model->where('id',$id)->find();
        if(empty($category)) {
            $this->error('id不正确');
        }
        $this->assign('category',$category);
        return $this->fetch();
    }
    public function category_update(){
        //是修改操作
        if($this->request->isPost()) {
            $model = new ForumCategoryModel();
            //是提交操作
            $post = $this->request->post();

            if(false == $model->allowField(true)->save($post,['id'=>$post['id']])) {
                $this->error('修改失败');
            } else {
                //记录日志
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'修改Forum板块ID:'.$post['id'].'为'.$post['name']);
                $this->success('修改'.$post['name'].'板块信息成功','admin/forum/category_list');
            }
        }else{
            $this->error('修改失败:非法提交！');
        }
    }
    public function category_updateShow(){
        if ($this->request->isGet()) {
            $get = $this->request->get();
            $model = new ForumCategoryModel();
            if ($model->where('id', $get['id'])->update(['is_show' =>$get['status']]) !== false) {
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'更新Forum板块ID：'.$get['id'].'状态');
                return json(array('code' => 200, 'msg' => '更新成功'));
            }
        }
        return json(array('code' => 0, 'msg' => '更新失败'));
    }
    public function category_updateComment(){
        if ($this->request->isGet()) {
            $get = $this->request->get();
            $model = new ForumCategoryModel();
            if ($model->where('id', $get['id'])->update(['is_comment' =>$get['status']]) !== false) {
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'更新Forum板块ID：'.$get['id'].'状态');
                return json(array('code' => 200, 'msg' => '更新成功'));
            }
        }
        return json(array('code' => 0, 'msg' => '更新失败'));
    }
    public function category_orders()
    {
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $order = (new ForumCategoryModel())->where('id',$val)->value('orders');
                if($order != $post['orders'][$k]) {
                    if(false == (new ForumCategoryModel())->where('id',$val)->update(['orders'=>$post['orders'][$k]])) {
                        $this->error('更新失败');
                    } else {
                        $i++;
                    }
                }
            }
            $this->success('成功更新'.$i.'个数据');
        }
    }
    public function category_delete(){
        if($this->request->isAjax()) {
            $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;
            $where['forum_category_id']=$id;
            if((new ForumModel())->where($where)->select()->isEmpty()) {
                if(false ==(new ForumCategoryModel())->where('id',$id)->delete()) {
                    $this->error('删除失败');
                } else {
                    //记录日志
                    //$this->add_log($this->userSession['id'],$this->userSession['username'],'删除板块ID:'.$id);
                    $this->success('删除成功');
                }
            } else {
                $this->error('该板块下还有帖子，不能删除');
            }
        }
    }
    //============================================================================================================================
    public function post_list(){
        $post=(new ForumModel())->where('is_delete',0)->order(['id'=>'decs'])->paginate(20,false,[
            'type'      => 'Layui',
            'var_page'  => 'page',
            'list_rows' => 15,
            'newstyle'  => true,
        ]);
        $this->assign('post',$post);
        $this->assign('type','audit1');
        return $this->fetch();
    }
    public function audit_list(){
        $post=(new ForumModel())->where('is_delete',0)->where('is_audit',0)->paginate(20);
        $this->assign('post',$post);
        $this->assign('type','audit0');
        return $this->fetch('post_list');
    }
    public function auditNg_list(){
        $post=(new ForumModel())->where('is_delete',0)->where('is_audit',2)->paginate(20);
        $this->assign('post',$post);
        return $this->fetch('post_list');
    }
    public function post_delete(){
        if($this->request->isAjax()) {
            $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;
            if(false ==(new ForumModel())->where('id',$id)->setField('is_delete',1)) {
                $this->error('删除失败');
            } else {
                //记录日志
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'删除板块ID:'.$id);
                $this->success('删除成功');
            }
        }
    }
    public function post_update_status(){
        if ($this->request->isGet()) {
            $get = $this->request->get();
            $model = new ForumModel();
            if ($model->where('id', $get['id'])->update(['status' =>$get['status']]) !== 0) {
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'更新帖子ID：'.$get['id'].'禁用状态');
                //  $this->success('更新成功');
                return json(array('code' => 200, 'msg' => '更新成功'));
            }
        }
        // $this->error('更新失败');
        return json(array('code' => 0, 'msg' => '更新失败'));
    }
    public function post_update_comment(){
        if ($this->request->isGet()) {
            $get = $this->request->get();
            $model = new ForumModel();
            if ($model->where('id', $get['id'])->setField(['is_comment' =>$get['status']]) !== 0) {
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'更新帖子ID：'.$get['id'].'评论状态');
                //  $this->success('更新成功');
                return json(array('code' => 200, 'msg' => '更新成功'));
            }
        }
        // $this->error('更新失败');
        return json(array('code' => 0, 'msg' => '更新失败'));
    }
    public function post_update_choice(){
        if ($this->request->isGet()) {
            $get = $this->request->get();
            $model = new ForumModel();
            if ($model->where('id', $get['id'])->setField(['is_choice' =>$get['status']]) !== 0) {
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'更新帖子ID：'.$get['id'].'精贴状态');
                //  $this->success('更新成功');
                return json(array('code' => 200, 'msg' => '更新成功'));
            }
        }
        // $this->error('更新失败');
        return json(array('code' => 0, 'msg' => '更新失败'));
    }
    public function post_update_top(){
        if ($this->request->isGet()) {
            $get = $this->request->get();
            $model = new ForumModel();
            if ($model->where('id', $get['id'])->update(['is_top' =>$get['status']]) !== 0) {
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'更新帖子ID：'.$get['id'].'置顶状态');
                //  $this->success('更新成功');
                return json(array('code' => 200, 'msg' => '更新成功'));
            }
        }
        // $this->error('更新失败');
        return json(array('code' => 0, 'msg' => '更新失败'));
    }
    public function post_update_memo(){
        if ($this->request->isGet()) {
            $get = $this->request->get();
            $model = new ForumModel();
            if ($model->where('id', $get['id'])->update(['is_memo' =>$get['status']]) !== 0) {
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'更新帖子ID：'.$get['id'].'结贴状态');
                //  $this->success('更新成功');
                return json(array('code' => 200, 'msg' => '更新成功'));
            }
        }
        // $this->error('更新失败');
        return json(array('code' => 0, 'msg' => '更新失败'));
    }
    public function all_audit_on(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $status = (new ForumModel())->where('id',$val)->value('is_audit');
                if($status == 0) {
                    if(0 !== (new ForumModel())->where('id',$val)->update(['is_audit'=>1])) {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量审核通过帖子ID【'.implode(',',$post['id']).'】');
            $this->success('更新成功，审核'.$i.'个帖子通过');
        }
    }
    public function all_audit_off(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $status = (new ForumModel())->where('id',$val)->value('is_audit');
                if($status == 0) {
                    if(0 !== (new ForumModel())->where('id',$val)->update(['is_audit'=>2])) {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量审核未通过帖子ID【'.implode(',',$post['id']).'】');
            $this->success('更新成功，审核'.$i.'个帖子未通过');
        }
    }
    public function all_comment_on(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $status = (new ForumModel())->where('id',$val)->value('is_comment');
                if($status == 0) {
                    if(0 !== (new ForumModel())->where('id',$val)->update(['is_comment'=>1])) {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量开启评论ID【'.implode(',',$post['id']).'】');
            $this->success('更新成功，开启'.$i.'个帖子评论');
        }
    }
    public function all_comment_off(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $status = (new ForumModel())->where('id',$val)->value('is_comment');
                if($status == 1) {
                    if(0 !== (new ForumModel())->where('id',$val)->update(['is_comment'=>0])) {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量关闭评论ID【'.implode(',',$post['id']).'】');
            $this->success('更新成功，关闭'.$i.'个帖子评论');
        }
    }
    public function all_choice_on(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $status = (new ForumModel())->where('id',$val)->value('is_choice');
                if($status == 0) {
                    if(0 !== (new ForumModel())->where('id',$val)->update(['is_choice'=>1])) {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量帖子加精ID【'.implode(',',$post['id']).'】');
            $this->success('更新成功，批量'.$i.'个帖子加精');
        }
    }
    public function all_choice_off(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $status = (new ForumModel())->where('id',$val)->value('is_choice');
                if($status == 1) {
                    if(0 !== (new ForumModel())->where('id',$val)->update(['is_choice'=>0])) {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量帖子取消加精ID【'.implode(',',$post['id']).'】');
            $this->success('更新成功，批量'.$i.'个帖子取消加精');
        }
    }
    public function all_top_on(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $status = (new ForumModel())->where('id',$val)->value('is_top');
                if($status == 0) {
                    if(0 !== (new ForumModel())->where('id',$val)->update(['is_top'=>1])) {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量帖子置顶ID【'.implode(',',$post['id']).'】');
            $this->success('更新成功，批量'.$i.'个帖子置顶');
        }
    }
    public function all_top_off(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $status = (new ForumModel())->where('id',$val)->value('is_top');
                if($status == 1) {
                    if(0 !== (new ForumModel())->where('id',$val)->update(['is_top'=>0])) {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量帖子取消置顶ID【'.implode(',',$post['id']).'】');
            $this->success('更新成功，批量'.$i.'个帖子取消置顶');
        }
    }
    public function all_memo_on(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $status = (new ForumModel())->where('id',$val)->value('is_memo');
                if($status == 0) {
                    if(0 !== (new ForumModel())->where('id',$val)->update(['is_memo'=>1])) {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量帖子结贴ID【'.implode(',',$post['id']).'】');
            $this->success('更新成功，批量'.$i.'个帖子结贴');
        }
    }
    public function all_memo_off(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $status = (new ForumModel())->where('id',$val)->value('is_memo');
                if($status == 1) {
                    if(0 !== (new ForumModel())->where('id',$val)->update(['is_memo'=>0])) {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量帖子取消结贴ID【'.implode(',',$post['id']).'】');
            $this->success('更新成功，批量'.$i.'个帖子取消结贴');
        }
    }
    public function all_status_on(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $status = (new ForumModel())->where('id',$val)->value('status');
                if($status == 0) {
                    if(0 !== (new ForumModel())->where('id',$val)->update(['status'=>1])) {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量帖子封禁ID【'.implode(',',$post['id']).'】');
            $this->success('更新成功，批量'.$i.'个帖子封禁');
        }
    }
    public function all_status_off(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $status = (new ForumModel())->where('id',$val)->value('status');
                if($status == 1) {
                    if(0 !== (new ForumModel())->where('id',$val)->update(['status'=>0])) {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量帖子解禁ID【'.implode(',',$post['id']).'】');
            $this->success('更新成功，批量'.$i.'个帖子解禁');
        }
    }
    public function delete_all(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $status = (new ForumModel())->where('id',$val)->value('is_delete');
                if($status == 0) {
                    if(0 !== (new ForumModel())->where('id',$val)->update(['is_delete'=>1])) {
                        $i++;
                    }
                }
            }
            //记录日志
            //$this->add_log($this->userSession['id'],$this->userSession['username'],'批量帖子删除ID【'.implode(',',$post['id']).'】');
            $this->success('更新成功，批量'.$i.'个帖子删除');
        }
    }

    public function post_add(){
        $model=(new ForumCategoryModel());
        $menu = $model->order('id asc,orders asc')->select();
        $menus = $model->menuList($menu);
        $this->assign('category',$menus);
        return $this->fetch();
    }

    public function post_save(){
        //新增操作
        if($this->request->isPost()) {
            $post = $this->request->post();
            $video_id = 0;
            if(request()->param('video_src')){
                $dataA['savepath'] = $post['video_src'];
                $extend = explode ( "." , $post['video_src'] );
                $va = count ( $extend )-1;
                $dataA['ext'] = $extend [ $va ];
                $dataA['location'] = 2;
                $dataA['user_id'] = 1;
                $dataA['module'] = 'admin';
                $explode= explode('/',$extend [ $va - 1]);
                $vb = count($explode) - 1;
                $dataA['name'] =  $explode[$vb];
                $dataA['savename'] = $explode[$vb];
                $video_id = (new Attachment())->insertGetId($dataA);
            }
            $model = new ForumModel();
            //是提交操作
            $post['user_id'] = 1;
            $post['video_id'] = $video_id;
            $post['is_audit'] = 1;
            if(false == $model->allowField(true)->save($post)) {
                $this->error('添加失败');
            } else {
                //记录日志
                //$this->add_log($this->userSession['id'],$this->userSession['username'],'添加新板块：'.$post['name']);
                $this->success('添加成功','admin/forum/post_list');
            }
        }else{
            $this->error('添加失败:非法提交！');
        }
    }
}