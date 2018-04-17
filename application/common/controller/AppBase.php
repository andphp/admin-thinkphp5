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
 * | createTime :2018/3/1 000121:10
 * +----------------------------------------------------------------------
 */

namespace app\common\controller;


use app\common\model\Log as LogModel;
use app\common\model\SystemConfig as SystemConfigModel;
use app\common\model\Attachment;
use app\common\utility\Hash;
use org\Auth;
use think\Controller;
use think\facade\Config;
use think\facade\Session;

/**
 * App应用基础控制器
 * +----------------------------------------------------------------------
 * Class App
 * @package app\common\controller
 * +----------------------------------------------------------------------
 * | author     :BabySeeME <417170808@qq.com>
 * +----------------------------------------------------------------------
 * | createTime :2018-03-01 21:10
 */
class AppBase extends Controller
{
    public $andConfig;

    public $VarsReturned = false;
    public $js = array();
    public $css = array();
    public $defer_js = array();

    public $buttonA = array();
    public $buttonB = array();
    public $cols = array();
    public $formItem = array();
    public $inputData = array();


    public $assign;
    public $local;
    public $params;
    public $args;
    public $paginate;
    public $helper = [
//        'Auth' => [
//            'userModel' => 'User',
//            'contain' => ['UserGroup', 'Member']
//        ],
        'Form',
        'Html'
    ];
    /**
     * 自动加载类，初始化
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 18:33
     */
    protected function initialize()
    {
        $GLOBALS['controller'] = $this;
        ##加载助手类
        if (!empty($this->helper)) {
            $this->helper = Hash::normalize($this->helper);
            foreach ($this->helper as $h => $h_option) {
                $helper_name = 'app\\common\\helper\\' . $h;
                $this->$h = new $helper_name();
                if (!empty($h_option)) {
                    foreach ($h_option as $pro_name => $pro) {
                        $this->$h->$pro_name = $pro;
                    }
                }
            }
        }

        ##加载公共方法
//        loader();

        $this->systemConfig();
        $module = request()->module();
        $controller = request()->controller();
        $action = request()->action();
        //网站标题
        $this->assign('title',getTitle($module,$controller,$action).$this->andConfig['and']);
    }

    /**
     * 获取配置信息并保存为andConfig对象
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 18:34
     */
    protected function systemConfig(){
        if(empty($this->andConfig)){
            $config_all=(new SystemConfigModel())->select();
            $config_arr=array();
            foreach($config_all as $key=>$value){
                $config_arr[$value->vari]=$value->value;
            }
            $config_arr['and']='《AndPHP站点应用管理系统》';
            $this->andConfig=$config_arr;
        }
    }

    /**
     * 单 图片、文件上传
     * @param string $module
     * @param string $use
     * @return \think\response\Json
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 18:35
     */
    public function upload($module='admin',$use='admin_thumb')
    {
        // 获取表单上传文件
        $file= request()->file('file');
        if(empty($file)){
            $res['code']=1;
            $res['msg']='没有上传文件';
            return json($res);
        }
        // 移动到框架应用根目录/uploads/ 目录下
        $module = $this->request->has('module') ? $this->request->param('module') : $module;//模块
        $web_config = $this->andConfig;
        $size=(int)$web_config['file_size']*1024*1024;// M
        $ext=$web_config['file_type'];
        $path='uploads'. "/" . $module . "/" . $use;
//        $path='uploads'.DIRECTORY_SEPARATOR. $module . DIRECTORY_SEPARATOR . $use.DIRECTORY_SEPARATOR;
        $info = $file->validate(['size'=>$size,'ext'=>$ext])->rule('date')->move($path);
        if($info==false){
            // 上传失败获取错误信息
            $res['code']=1;
            $res['msg']='上传文件失败：'.$file->getError();
            return json($res);
        }
        //写入到附件表
        $data = [];
        $data['module'] = $module;
        $data['filename'] = $info->getFilename();//文件名
        $data['filepath'] = $path. $info->getSaveName();//文件路径
        $data['fileext'] = $info->getExtension();//文件后缀
        $data['filesize'] = $info->getSize();//文件大小
        $data['create_time'] = time();//时间
        $data['uploadip'] = $this->request->ip();//IP
        $data['user_id'] = Session::has('adminUser.id') ? Session::get('adminUser.id') : 0;
        if($data['module'] == 'admin') {
            //通过后台上传的文件直接审核通过
            $data['status'] = 1;
            $data['admin_id'] = $data['user_id'];
            $data['audit_time'] = time();
        }
        $data['use'] = $this->request->has('use') ? $this->request->param('use') : $use;//用处
        $res['id'] = (new Attachment())->insertGetId($data);
        $res['src'] = input('server.REQUEST_SCHEME') . '://' . input('server.SERVER_NAME').'/'.$path . $info->getSaveName();
        $res['code'] = 2;
        //addlog($res['id']);//记录日志
        return json($res);
    }
    /**
     * 权限检查
     * @return bool
     */
    protected function checkAuth( $user='')
    {
        if(Session::has($user) == false) {
            $this->redirect('admin/login/index');
        }
        $userInfo=Session::get($user);

        $module     = $this->request->module();
        $controller = $this->request->controller();
        $action     = $this->request->action();

        // 排除权限
        $not_check = Config::get('auth.not_check');

        if (!in_array($module . '/' . $controller . '/' . $action, $not_check)) {
            $auth = new Auth();
            if ($userInfo['id'] != 1 and $auth->check($module . '/' . $controller . '/' . $action, $userInfo['id']) != true) {
                //return json(array('code' => 0, 'msg' => '没有权限'));
                $this->error('没有访问权限');
            }
        }
        if(strtolower($controller)!='log'){

            $data['uid']=$userInfo['id'];
            $data['add_time']=time();
            $data['controller']=$module . '/' . $controller . '/' . $action;
            $data['username']=$userInfo['username'];
//            Db::name('log')->insert($data);
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

    public function add_log($uid,$username,$info=''){
        $logDate['module']=request()->module();
        $logDate['controller']=request()->controller();
        $logDate['action']=request()->action();
        $logDate['describe']=$info;
        $logDate['user_id']=$uid;
        $logDate['username']=$username;
        $logDate['add_ip']=request()->ip();
        $url='http://ip.taobao.com/service/getIpInfo.php?ip='.request()->ip();
        $result = file_get_contents($url);
        $result = json_decode($result,true);
        $logDate['city']=$result['data']['city'];
        $model=new LogModel();
        if($model->save($logDate)){
            return true;
        }
        return false;
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
}