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
 * | createTime :2018/3/8 000811:06
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;


use app\common\controller\AdminBase;
use app\common\model\Module as ModuleModel;
use think\File;

class Module extends AdminBase
{

    public function _list(){
//        $file = new File(dirname(APP_PATH).'/config/app.php');
//        halt($file->current());
        $moduleDir=getNextDir(APP_PATH);
        $moduleModel=new ModuleModel();
        foreach($moduleDir as $item){
            $moduleID=$moduleModel->where(['name'=>$item['dir']])->find();
            if($moduleID == false) {
                $fileName = APP_PATH . $item['dir'] . '/info.php';
                if (file_exists($fileName)) {
                    $require = require $fileName;
                    (new ModuleModel())->allowField(true)->save($require);
                }elseif($item['dir']=='home'){
                    (new ModuleModel())->allowField(true)->save(['name'=>$item['dir'],'title'=>'默认门户','is_default'=>1]);
                }else{
                    (new ModuleModel())->allowField(true)->save(['name'=>$item['dir'],'is_system'=>1]);
                }
            }
        }
        $moduleList=$moduleModel->select();
        $this->assign('moduleList',$moduleList);
        return $this->fetch();
    }

    /**
     * 更新主入口 默认域名访问模块
     * @return \think\response\Json
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-09 12:31
     */
    public function update_default(){
        if ($this->request->isGet()) {
            $get = $this->request->get();
            $model = new ModuleModel();
            if($get['status']==1 and $model->where(['name'=>$get['name']])->value('status')==1){
                if($this->update_appConfig($get )==false){
                    return json(array('code' => 200, 'msg' => '启用失败，服务器没有file_get_contents权限'));
                }
                if ($model->where(['is_default'=>1])->update(['is_default' =>0]) !== false and $model->where('id', $get['id'])->update(['is_default' =>$get['status']]) !== false) {
                    //记录日志
                    $this->add_log($this->userSession['id'],$this->userSession['username'],'开启默认模块：'.$get['name']);
                    //  $this->success('更新成功');
                    return json(array('code' => 200, 'msg' => '启用成功'));
                }
            }
            if($model->where('id', $get['id'])->value('name')=='home'){
                return json(array('code' => 200, 'msg' => '关闭失败：直接开启其他模块来关闭默认模块'));
            }
            if($get['status']==0){
                if($this->update_appConfig($get)==false){
                    return json(array('code' => 200, 'msg' => '关闭失败，服务器没有file_get_contents权限'));
                }
                if ($model->where('id', $get['id'])->update(['is_default' =>$get['status']]) !== false and $model->where(['name'=>'home'])->update(['is_default'=>1]) !== false) {
                    //记录日志
                    $this->add_log($this->userSession['id'],$this->userSession['username'],'开启默认模块：home');
                    return json(array('code' => 200, 'msg' => '关闭成功'));
                }
            }
            return json(array('code' => 200, 'msg' => '开启失败，先启用模块吧！'));
        }
        // $this->error('更新失败');
        return json(array('code' => 0, 'msg' => '提交失败'));
    }

    protected function update_appConfig($data){
        $model = new ModuleModel();
        $nameBefore=$model->where(['is_default'=>1])->value('name');
        if($data['status']==1){
            $path=dirname(APP_PATH).'/config/app.php';
            $file = file_get_contents($path);
            $update_str = str_replace("'default_module'=>'".$nameBefore."'", "'default_module'=>'".$data['name']."'", $file);
            return file_put_contents($path, $update_str);
        }
        $path=dirname(APP_PATH).'/config/app.php';
        $file = file_get_contents($path);
        $update_str = str_replace("'default_module'=>'".$data['name']."'","'default_module'=>'home'", $file);
        return file_put_contents($path, $update_str);
    }

    public function update_status(){
        if ($this->request->isGet()) {
            $get = $this->request->get();
            $model = new ModuleModel();
            if($get['status']==1){
                if ( $model->where('id', $get['id'])->update(['status' =>$get['status']]) !== false) {
                    //记录日志
                    $this->add_log($this->userSession['id'],$this->userSession['username'],'启用模块：'.$model->where('id', $get['id'])->value('name'));
                    //  $this->success('更新成功');
                    return json(array('code' => 200, 'msg' => '启用成功'));
                }

            }elseif ($model->where('id', $get['id'])->update(['status' =>$get['status']]) !== false) {
                //记录日志
                $this->add_log($this->userSession['id'],$this->userSession['username'],'禁用模块：'.$model->where('id', $get['id'])->value('name'));
                //  $this->success('更新成功');
                return json(array('code' => 200, 'msg' => '关闭成功'));
            }
        }
        // $this->error('更新失败');
        return json(array('code' => 0, 'msg' => '提交失败'));
    }
}