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
 * | createTime :2018/3/7 000712:29
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;


use app\common\controller\AdminBase;
use app\common\model\Theme as ThemeModel;
use think\facade\Cache;

class Theme extends AdminBase
{
    public function _list()
    {
        $themeModel=new ThemeModel();
        $themeSelect=$themeModel->select();

        $moduleDir=getNextDir(ROOT_PATH.'template');

        $themeDir=[];
        //判断数据库安装主题是否存在本地
        foreach($themeSelect as $kk=> $find){
            $find['dir']=0;
            $find['install']=1;
            foreach($moduleDir as $key=> $dir){
                if($find['module']==$dir['dir']){
                    $themeName=getNextDir(ROOT_PATH.'template/'.$dir['dir']);
                    foreach($themeName as $dirTheme){
                        if($dirTheme['dir']==$find['name']){
                            $find['dir']=1;
                            $find['install']=1;
                        }
                    }
                }
            }
            $themeDir[$kk]=$find;
        }
        //判断本地是否有为安装的主题
        foreach($moduleDir as $key=> $dir){
            $themeName=getNextDir(ROOT_PATH.'template/'.$dir['dir']);
            foreach($themeName as $dirTheme) {
                $fileName=ROOT_PATH.'template/'.$dir['dir'].'/'.$dirTheme['dir'].'/info.php';
                if( file_exists($fileName) ){
                    $require = require  $fileName;
                    $findTrue=$themeModel->where(['module'=>$dir['dir'],'name'=>$dirTheme['dir']])->find();

                    if($findTrue==false){
                        $require['status']=0;
                        $require['dir']=1;
                        $require['install']=0;
                        $themeDir[]=$require;
                    }
                }
            }
        }

        $this->assign('theme',$themeDir);

        return $this->fetch();
    }

    /**
     * 切换应用主题
     * @return \think\response\Json
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-09 12:52
     */
    public function update_status(){
        if ($this->request->isGet()) {
            $get = $this->request->get();
            $model = new ThemeModel();
            if($get['status']==1){
                if ($model->where('module', $get['module'])->update(['status' =>0]) !== false and $model->where('id', $get['id'])->update(['status' =>$get['status']]) !== false) {
                    //  清空缓存
                    Cache::clear();
                    //记录日志
                    $this->add_log($this->userSession['id'],$this->userSession['username'],'开启'.$get['module'].'的主题：'.$model->where('id', $get['id'])->value('name'));
                    //  $this->success('更新成功');
                    return json(array('code' => 200, 'msg' => '启用成功'));
                }

            }elseif ($model->where('id', $get['id'])->update(['status' =>$get['status']]) !== false) {
                //  清空缓存
                Cache::clear();
                //记录日志
                $this->add_log($this->userSession['id'],$this->userSession['username'],'关闭'.$get['module'].'的主题：'.$model->where('id', $get['id'])->value('name'));
                //  $this->success('更新成功');
                return json(array('code' => 200, 'msg' => '关闭成功'));
            }
        }
        // $this->error('更新失败');
        return json(array('code' => 0, 'msg' => '提交失败'));
    }

    public function update_install(){
        if ($this->request->isGet()) {
            $get = $this->request->get();
            $model = new ThemeModel();
            if($get['status']==0){
               if($model->where(['id'=>$get['id']])->delete() !=0){
                   //记录日志
                   $this->add_log($this->userSession['id'],$this->userSession['username'],'卸载主题ID:'.$get['id']);
                   return json(array('code' => 200, 'msg' => '卸载成功'));
               };
            }elseif($get['status']==1){
               $dd=require ROOT_PATH.'template/'.$get['module'].'/'.$get['name'].'/info.php';
                if ($model->allowField(true)->save($dd) !== false ) {
                    //记录日志
                    $this->add_log($this->userSession['id'],$this->userSession['username'],'安装主题ID:'.$get['id']);
                    //  $this->success('更新成功');
                    return json(array('code' => 200, 'msg' => '安装成功'));
                }
            }
        }
        // $this->error('更新失败');
        return json(array('code' => 0, 'msg' => '提交失败'));
    }
    public function delete_theme(){
        if ($this->request->isAjax()) {
            $post = $this->request->param();
            $fileName = explode('&', $post['id']);
            if(removeDir(ROOT_PATH.'template/'.$fileName[0].'/'.$fileName[1])){
                //记录日志
                $this->add_log($this->userSession['id'],$this->userSession['username'],'删除主题ID:'.$post['id']);
                $this->success('删除成功');
            }
        }
        $this->error('删除失败');
    }

}