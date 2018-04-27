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
 * | CreateTime : 2018/4/26 002619:49
 * +----------------------------------------------------------------------
 */

namespace app\install\controller;


use think\Controller;
use think\facade\Cache;

class Index extends Controller
{

    //安装首页
    public function index(){
        define('AndPHP_INSTALL', 1);
        if(config('app.app_debug')==false){
            $this->error('你可能是迷路了！');
        }
        if (file_exists('./install/install.lock')) {
            $this->error('您已经安装过本软件,如果需要重新安装，请删除 ./public/install/install.lock 文件！');
        }
        return $this->fetch();
    }
    //安装完成
    public function complete(){
        $step = session('step');

        if(!$step){
            $this->redirect('index');
        } elseif($step != 3) {
            $this->redirect("Install/step{$step}");
        }

        // 写入安装锁定文件
        file_put_contents('./install/install.lock', 'lock');
        if(!session('update')){
            //创建配置文件
            $this->assign('info',session('config_file'));
        }
        session('step', null);
        cache('error', null);
        session('update',null);
        return $this->fetch();
    }
}