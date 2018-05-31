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
 * | createTime :2018/3/25 002520:10
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;


use app\common\controller\AdminController;
use app\common\model\Upload as UploadModel;

class Upload extends AdminController
{
    public function upload_image()
    {
        if(!$this->isLogin()){
            $return['code']=1;
            $return['msg']='未检测到登录状态！';
        }
        $model =new UploadModel();
        $data=$model->upImage('images');
        return json($data);
    }
}
