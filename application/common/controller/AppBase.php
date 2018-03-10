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

    /**
     * 自动加载类，初始化
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 18:33
     */
    protected function initialize()
    {
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
}