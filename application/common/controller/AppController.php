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
 * | createTime :2018/4/19 001915:28
 * +----------------------------------------------------------------------
 */

namespace app\common\controller;


use org\Auth;
use think\Controller;
use think\facade\Config;
use think\facade\Session;
use app\common\model\SystemConfig as SystemConfigModel;
class AppController extends Controller
{
    public $VarsReturned = false;
    public $js = array();
    public $css = array();
    public $defer_js = array();

    public $buttonA = array();
    public $buttonB = array();
    public $cols = array();
    public $formItem = array();
    public $inputData = array();

    public $config;

    protected $uid;

    /**
     * 自动加载类，初始化
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 18:33
     */
    protected function initialize()
    {
        //初始化配置数据
        $this->config_init();
    }
    /**
     * 获取配置信息并保存为andConfig对象
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 18:34
     */
    protected function config_init(){
        $config_all=(new SystemConfigModel())->cache(true)->select();
        $config_arr=array();
        foreach($config_all as $key=>$value){
            $config_arr[$value->vari]=$value->value;
        }
        $config_arr['and']='《AndPHP站点应用管理系统》';
        $this->config=$config_arr;
    }
    /**
     * 权限检查
     * @return bool
     */
    protected function checkAuth( $user='',$url='/')
    {



        $module     = $this->request->module();
        $controller = $this->request->controller();
        $action     = $this->request->action();

        // 排除权限
        $not_check = Config::get('auth.not_check');

        if (!in_array($module . '/' . $controller . '/' . $action, $not_check)) {
            if(!Session::has($user)){
                $this->redirect($url);
            }
            $userInfo=Session::get($user);
            $auth = new Auth();
            if ($userInfo['id'] != 1 and $auth->check($module . '/' . $controller . '/' . $action, $userInfo['id']) != true) {
                //return json(array('code' => 0, 'msg' => '没有权限'));
                $this->error('没有访问权限');
            }
            if(strtolower($controller)!='log'){

                $data['uid']=$userInfo['id'];
                $data['add_time']=time();
                $data['controller']=$module . '/' . $controller . '/' . $action;
                $data['username']=$userInfo['username'];
//            Db::name('log')->insert($data);
            }
        }


        if(in_array(strtolower($action), array('add','edit'))){
            $token=md5(rand().time());
            Session::set('datatoken',$token);

            $this->assign('token',$token);

        }else{
            $this->assign('token',0);
        }
        if(in_array(strtolower($action), array('save','update'))){

            $token=Session::get('datatoken');

            if($token!=0&&$token!=request()->param('token')){
                $this->error($token.'=='.request()->param('token'));
            }

        }

    }

    /**
     * 是否登录
     * @return bool
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-23 14:49
     */
    public function isLogin(){
        if(!Session::has('User') && !Session::has('userId') ){
            return false;
        }
        $this->uid = session('userId');
        return true;
    }
    //=========================模板输出==================================
    /**
     * 加载js
     * @param $path
     * @param bool|false $defer
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-14 10:19
     */
    public function addJs($path, $defer = false)
    {
        if ($defer) {
            if (!is_array($path)) {
                array_push($this->defer_js, $path);
            } else {
                $this->defer_js = array_merge($this->defer_js, $path);
            }
            $this->assign('defer_js' , array_unique($this->defer_js));
        } else {
            if (!is_array($path)) {
                array_push($this->js, $path);
            } else {
                $this->js = array_merge($this->js, $path);
            }
            $this->assign('js' , array_unique($this->js));
        }

    }

    public function removeJs($path, $defer = false)
    {
        if ($defer) {
            if (!is_array($path)) {
                $this->assign('defer_js' , array_diff($this->defer_js, [$path]));
            } else {
                $this->assign('defer_js' , array_diff($this->defer_js, $path));
            }

        } else {
            $this->assign('js' , array_diff($this->js, [$path]));
        }
    }

    /**
     * 加载css
     * @param $path
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-04-14 10:19
     */
    public function addCss($path)
    {
        if (!is_array($path)) {
            array_push($this->css, $path);
        } else {
            $this->css = array_merge($this->css, $path);
        }
        $this->assign('css' , array_unique($this->css));
    }

    public function removeCss($path)
    {
        if (!is_array($path)) {
            $this->css = array_diff($this->css, [$path]);
        } else {
            $this->css = array_diff($this->css, $path);
        }
        $this->assign('css' , array_unique($this->css));
    }

    public function setMetaTitle($title){
        $this->assign('title',$title);
    }
    public function addButtonA($title='',$href="",$id=null,$group=false,$class='',$icon="",$icon_value="",$extra_data=array()){

        $Button=$this->buttonA;

        $Button[]=[
            "href"=>$href,
            "class"=>$class,
            "id"=>$id,
            "icon"=>$icon,
            "icon_value"=>$icon_value,
            "title"=>$title,
            "extra_data"=>$extra_data,
        ];

        if($group==true){
            $this->buttonA = $Button;
        }else{
            if($id!=null){
                $this->assign($id , $Button);
            }else{
                $this->assign('button' , $Button);
            }

        }
    }
    public function addButtonB($title='',$href="",$id=null,$group=false,$class='',$icon="",$icon_value="",$extra_data=array()){

        $Button=$this->buttonB;

        $Button[]=[
            "href"=>$href,
            "class"=>$class,
            "id"=>$id,
            "icon"=>$icon,
            "icon_value"=>$icon_value,
            "title"=>$title,
            "extra_data"=>$extra_data,
        ];

        if($group==true){
            $this->buttonB = $Button;
        }else{
            if($id!=null){
                $this->assign($id , $Button);
            }else{
                $this->assign('button' , $Button);
            }

        }
    }
    public function addTopButton($id,$class='',$extra_data=array()){
        $Button=$this->buttonA;
        $buttonGroup=[
            'id'=>$id,
            'button'=>$Button,
            'class'=>$class,
            'extra_data'=>$extra_data
        ];
        $this->assign('buttonGroup' , $buttonGroup);
        $this->buttonA = null;
    }
    public function addButtonBar($id,$class='',$extra_data=array()){
        $Button=$this->buttonA;
        $buttonGroup=[
            'id'=>$id,
            'button'=>$Button,
            'class'=>$class,
            'extra_data'=>$extra_data
        ];
        $this->assign('buttonBar' , $buttonGroup);
        $this->buttonA = null;
    }
    public function addButtonForm($id=null,$class=null,$extra_data=array()){
        $Button=$this->buttonB;
        $buttonGroup=[
            'id'=>$id,
            'button'=>$Button,
            'class'=>$class,
            'extra_data'=>$extra_data
        ];
        $this->assign('buttonForm' , $buttonGroup);
        $this->buttonB = null;
    }
    public function addTableColumn($field,$title,$minWidth=60,$align=null,$width=null,$templet=null,$type=null,$fixed='left',$toolbar=null,$LAY_CHECKED=false,$sort=false,$unresize=false,$event=null,$style=null,$colspan=1,$rowspan=1,$edit='text'){
        $cols=$this->cols;
        $cols[]=[
            'field'=>$field,
            'title'=>$title,
            'type'=>$type,
            'minWidth'=>$minWidth,
            'width'=>$width,
            'align'=>$align,
            'templet'=>$templet,
            'toolbar'=>$toolbar,
            'LAY_CHECKED'=>$LAY_CHECKED,
            'fixed'=>$fixed,
            'sort'=>$sort,
            'unresize'=>$unresize,
            'event'=>$event,
            'style'=>$style,
            'colspan'=>$colspan,
            'rowspan'=>$rowspan,
            'edit'=>$edit,
        ];
        $this->cols=$cols;
    }
    public function addTable($id,$url=null,$extra_data=array(),$cellMinWidth=95,$page=false,$height='',$width='',$limits=[10,15,20,25],$limit=20,$cols=array(),$done='',$data=array(),$loading=true,$text='',$initSort='',$skin=''){
        $Table=[
            'url'=>$url,
            'extra_data'=>$extra_data,
            'id'=>$id,
            'cellMinWidth'=>$cellMinWidth,
            'page'=>$page,
            'height'=>$height,
            'width'=>$width,
            'limits'=>$limits,
            'limit'=>$limit,
            'cols'=>$this->cols,
            'done'=>$done,
            'data'=>$data,
            'loading'=>$loading,
            'text'=>$text,
            'initSort'=>$initSort,
            'skin'=>$skin,
        ];
        $this->cols=null;
        $this->assign('table' , $Table);
    }
    public function addInput($name,$value=null,$type='text',$title=null,$id=false,$class=null,$extra_data=array(),$pre=null){
        $inputData=$this->inputData;
        if($id===false){
            $id=$name;
        }
        $inputData[]=[
            'name'=>$name,
            'value'=>$value,
            'type'=>$type,
            'title'=>$title,
            'id'=>$id,
            'class'=>$class,
            'extra_data'=>$extra_data,
            'pre'=>$pre,
        ];
        $this->inputData=$inputData;
    }

    public function addFormItem($title=null,$id=null,$class=null){
        $FormItem=$this->formItem;
        $FormItem[]=[
            'title'=>$title,
            'id'=>$id,
            'class'=>$class,
            'inputData'=>$this->inputData,
        ];
        $this->formItem=$FormItem;
        $this->assign('formItem' , $FormItem);
        $this->inputData=null;
    }
    //===========================================================

    /* 利用淘宝的ip地址库获获取ip + 地址*/

    public function get_ip_address(){

        $opts = array(

            'http'=>array(

                'method'=>"GET",

                'timeout'=>5,)

        );

        $context = stream_context_create($opts);

        $ipmac=$this->_get_ip();

        if(strpos($ipmac,"127.0.0.") === true)return '内外ip';

        $url_ip='http://ip.taobao.com/service/getIpInfo.php?ip='.$ipmac;

        $str = @file_get_contents($url_ip, false, $context);

        if(!$str) return "";

        $json=json_decode($str,true);

        if($json['code']==0){

            $ipcity= $json['data']['region'].$json['data']['city'];

            $ip= $ipcity.','.$ipmac;

        }else{

            $ip="";

        }

        return $ip;

    }
    /*获取客户端ip*/

    public function _get_ip(){

        if (isset($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], "unknown"))

            $ip = $_SERVER['HTTP_CLIENT_IP'];

        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], "unknown"))

            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

        else if (isset($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))

            $ip = $_SERVER['REMOTE_ADDR'];

        else if (isset($_SERVER['REMOTE_ADDR']) && isset($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))

            $ip = $_SERVER['REMOTE_ADDR'];

        else $ip = "";

        return ($ip);

    }
}