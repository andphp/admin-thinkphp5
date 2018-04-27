<?php
namespace app\user\controller;
use app\common\controller\UserController;
use app\common\model\Upload as UploadModel;

class Upload extends UserController
{
    public function up_image()
    {
        $model =new UploadModel();
        $info=$model->upFile('images');
        $return['code']=200;
        $return['msg']=$info['msg'];
        $return['id']=$info['id'];
        $return['headpath']=$info['headpath'];
        if($this->config['location']==0){
            $return['path']=str_replace(request()->domain(),'',$info['path']);
        }
    	 return json($return);
    }
    public function up_file()
    {
        return json((new UploadModel())->upFile('files'));
    }
    public function up_attach()
    {
        return json((new UploadModel())->upFile('files','file','attach'));
    }

}