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
 * | CreateTime : 2018/4/26 002620:39
 * +----------------------------------------------------------------------
 */

namespace app\install\controller;


use think\Controller;
use think\Db;
use think\facade\Cache;
use think\facade\Session;

class Install extends Controller
{
    protected function initialize(){
        if(Cache::has( 'install.lock')){
            $this->error('已经成功安装，请不要重复安装!');
        }
        define('INSTALL_APP_PATH', realpath('./') . '/');
    }

    //安装第一步，检测运行所需的环境设置
    public function step1(){
        cache('error', false);

        //环境检测
        $env = check_env();

        //目录文件读写检测
        $dirfile = check_dirfile();
        $this->assign('dirfile', $dirfile);

        //函数检测
        $func = check_func();

        session('step', 1);

        $this->assign('env', $env);
        $this->assign('func', $func);
        return $this->fetch();
    }
    //安装第二步，创建数据库
    public function step2($db = null, $admin = null){
        if(request()->isPost()){

            //检测管理员信息
            if(!is_array($admin) || empty($admin[0]) || empty($admin[1]) || empty($admin[3])){
                $this->error('请填写完整管理员信息');
            } else if($admin[1] != $admin[2]){
                $this->error('确认密码和密码不一致');
            } else {
                $info = array();
                list($info['username'], $info['password'], $info['repassword'], $info['email'])
                    = $admin;
                //缓存管理员信息
                cache('admin_info', $info);
            }

            //检测数据库配置
            if(!is_array($db) || empty($db[0]) ||  empty($db[1]) || empty($db[2]) || empty($db[3])){
                $this->error('请填写完整的数据库配置');
            } else {
                $DB = array();
                list($DB['type'], $DB['hostname'], $DB['database'], $DB['username'], $DB['password'],
                    $DB['hostport'], $DB['prefix']) = $db;
                //缓存数据库配置
                cookie('db_config',$DB);

                //创建数据库
                $dbname = $DB['database'];
                unset($DB['database']);

                $db  = Db::connect($DB);

                $sql = "CREATE DATABASE IF NOT EXISTS `{$dbname}` DEFAULT CHARACTER SET utf8";

                try{
                    $db->execute($sql);
                }catch (\Think\Exception $e){
                    if(strpos($e->getMessage(),'getaddrinfo failed')!==false){
                        $this->error( '数据库服务器（数据库服务器IP） 填写错误。','很遗憾，创建数据库失败，失败原因');// 提示信息
                    }
                    if(strpos($e->getMessage(),'Access denied for user')!==false){
                        $this->error('数据库用户名或密码 填写错误。','很遗憾，创建数据库失败，失败原因');// 提示信息
                    }else{
                        $this->error( $e->getMessage());// 提示信息
                    }
                }
                session('step',2);
                // $this->error($db->getError());exit;
            }

            //跳转到数据库安装页面
            $this->redirect('step3');
        } else {
            if(cache('error')){
                $this->error('环境检测没有通过，请调整环境后重试！');
            }

            $step = session('step');
            if($step != 1 && $step != 2){
                $this->redirect('step1');
            }

            session('step', 2);

        }
        return $this->fetch();
    }
    //安装第三步，安装数据表，创建配置文件
    public function step3(){
         if(session('step') != 2){
             $this->redirect('step2');
         }else{
             session('step',3);
         }

        echo $this->fetch();

        //连接数据库
        $dbconfig = cookie('db_config');
        $db = Db::connect($dbconfig);
        //创建数据表

        create_tables($db, $dbconfig['prefix']);
        //注册创始人帐号

        $admin = cache('admin_info');

        register_administrator($db, $dbconfig['prefix'], $admin);

        /* 修改配置文件 */
        //定义数组
        $db_config = [
            'type' => $dbconfig['type'],
            'hostname' => $dbconfig['hostname'],
            'username' => $dbconfig['username'],
            'password' => $dbconfig['password'],
            'database' => $dbconfig['database'],
            'prefix' => $dbconfig['prefix'],
            'dsn'            => '',
            'charset'        => 'utf8',
            'fields_strict'  => false,
        ];


        $path = ROOT_PATH.'config/database.php';
        $dbStr="<?php return " . var_export($db_config,true) . ";?>";
        file_put_contents(ROOT_PATH.'config/database.php',$dbStr);//写文件

        $myfile = fopen($path, "r") or die("Unable to open file!");
        $read = fread($myfile,filesize($path));
        fclose($myfile);

        if ($read == $dbStr) {
            chmod($path, 0777);
            show_msg('配置文件写入成功');
        } else {
            show_msg('配置文件写入失败！', 'error');
            cache('error', true);
        }
        if(cache('error')){
            show_msg('安装失败！请联系技术人员！', 'error');
        }else{
            echo "<script type=\"text/javascript\">setTimeout(function(){location.href='".url('Index/complete')."'},5000)</script>";
            ob_flush();
            flush();
            $this->redirect('Index/complete');
        }

    }


}