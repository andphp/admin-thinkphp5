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
 * | createTime :2018/3/9 00099:57
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;


use app\common\controller\AdminBase;
use app\common\model\Log as LogModel;

class Log extends AdminBase
{
    public function login(){
        $model=new LogModel();
        $logLogin=$model->where(['controller'=>'login','is_delete'=>0])->paginate(20,false,[
            'type'      => 'Layui',
            'var_page'  => 'page',
            'list_rows' => 15,
            'newstyle'  => true,
        ]);
        $this->assign('logLogin',$logLogin);
        return $this->fetch();
    }

    public function admin(){
        $model=new LogModel();
        $logAdmin=$model->where(['module'=>'admin','is_delete'=>0])->paginate(20,false,[
            'type'      => 'Layui',
            'var_page'  => 'page',
            'list_rows' => 15,
            'newstyle'  => true,
        ]);
        $this->assign('logAdmin',$logAdmin);
        return $this->fetch();
    }

    public function delete(){
        if($this->request->isAjax()) {
            $post = $this->request->param();
            $is_delete = (new LogModel())->where('id',$post['id'])->value('is_delete');
            if($is_delete == 0) {
                if(true == (new LogModel())->where('id',$post['id'])->update(['is_delete'=>1])) {
                    $this->success('删除成功');
                }
            }
            $this->error('删除失败');
        }
    }

}