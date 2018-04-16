<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 根据附件表的id返回url地址
 * param  [type] $id [description]
 * return [type]     [description]
 */
function get_url($id)
{
    $domain = \think\facade\Request::instance()->domain();
    if ($id) {
        $getAttachment = (new \app\common\model\Attachment())->where(['id' => $id])->find();
        if(empty($getAttachment)) {
            //无资源
            return $domain.'/static/common/images/andphp_bg_null.png';
        }
        if($getAttachment['status'] === 0) {
            //待审核
            return $domain.'/static/common/images/andphp_bg_shenhe.png';
        }elseif($getAttachment['status'] === 1) {
            //审核通过
            if($getAttachment['location']==0){

                return $domain.'/'.$getAttachment['savepath'];
            }
            return $getAttachment['savepath'];
        }else {
            //不通过
            return $domain.'/static/common/images/andphp_bg_jujue.png';
        }
    }
    return false;
}

/**
 * 密码加密方式
 * @param $password
 * @return string
 * @company    :WuYuZhong Co. Ltd
 * @author     :BabySeeME <417170808@qq.com>
 * @createTime :2018-03-05 14:07
 */
function passwordMD5($password,$salt)
{
    return md5(md5($password) . md5($salt));
}

/**
 * 获取a-z,A-Z,0-9的随机字符串
 * @param $len
 * @return string
 * @company    :WuYuZhong Co. Ltd
 * @author     :BabySeeME <417170808@qq.com>
 * @createTime :2018-03-05 14:22
 */
function getRandStr($len) {
    $chars = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');
    $charsLen = count($chars) - 1;
    shuffle($chars);
    $output = '';
    for ($i = 0; $i < $len; $i++) {
        $output .= $chars[mt_rand(0, $charsLen)];
    }
    return $output;
}

/**
 * 根据路由模型/控制器/方法 获取系统配置标题及描述
 * @param $module
 * @param $controller
 * @param $function
 * @return null|string
 * @company    :WuYuZhong Co. Ltd
 * @author     :BabySeeME <417170808@qq.com>
 * @createTime :2018-03-05 16:47
 */
function getTitle($module,$controller,$function)
{
    $info = (new \app\common\model\AuthRule())->where(['name'=>$module.'/'.$controller.'/'.$function])->find();
    if(empty($info)){
        return null;
    }
    return  $info['title'].'-'.$info['description'];
}

/**
 * 根据目录名查询该目录下的所有文件夹名
 * @param $dir
 * @return array|bool
 * @company    :WuYuZhong Co. Ltd
 * @author     :BabySeeME <417170808@qq.com>
 * @createTime :2018-03-07 12:32
 */
function getNextDir($dir){
    $reInfo=[];
    if (is_dir($dir)){//如果是文件夹，遍历文件
        $arr = scandir($dir);
        foreach ($arr as $k=>$v){
            if ($v != '.' && $v != '..'){
                if (is_dir($dir."\\".$v)){
                    $reInfo[$k-1]['dir']=$v;
                }
            }
        }
        return $reInfo;
    }else{
        return false;
    }
}

/**
 * 删除目录下所有文件
 * @param $dirName
 * @return bool
 * @company    :WuYuZhong Co. Ltd
 * @author     :BabySeeME <417170808@qq.com>
 * @createTime :2018-03-07 20:05
 */
function removeDir($dirName)
{
    if(! is_dir($dirName))
    {
        return false;
    }
    $handle = @opendir($dirName);
    while(($file = @readdir($handle)) !== false)
    {
        if($file != '.' && $file != '..')
        {
            $dir = $dirName . '/' . $file;
            is_dir($dir) ? removeDir($dir) : @unlink($dir);
        }
    }
    closedir($handle);

    return rmdir($dirName) ;
}
/**
 * 模板加载css
 * @param $css
 * @param bool|false $abs
 * @return string
 * @company    :WuYuZhong Co. Ltd
 * @author     :BabySeeME <417170808@qq.com>
 * @createTime :2018-04-12 21:55
 */
function displayCss($css,$abs = false){
    return (new \app\common\helper\Html())->css($css, $abs = false);
}

/**
 * 模板加载js
 * @param $js
 * @param bool|false $abs
 * @return string
 * @company    :WuYuZhong Co. Ltd
 * @author     :BabySeeME <417170808@qq.com>
 * @createTime :2018-04-12 21:55
 */
function displayScript($js,$abs = false){
    return (new \app\common\helper\Html())->script($js, $abs = false);
}
function showButtonGroup($Button){
    return (new \app\common\helper\Lists())->buttonGroup($Button);
}
function showButton($Button){
    return (new \app\common\helper\Lists())->button($Button);
}
function showTable($table){
    return (new \app\common\helper\Lists())->table($table);
}
function showFormItem($formItem){
    return (new \app\common\helper\Form())->formItem($formItem);
}