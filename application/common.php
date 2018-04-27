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
function encryptMD5($password,$salt = '')
{
    if($salt === null){
        return md5(md5($password) . md5(getRandStr()));
    }
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
function getRandStr($len = 6) {
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
function showFormBtn($formBtn){
    return (new \app\common\helper\Form())->formBtn($formBtn);
}
function getRoleNameByID($id){
    return (new \app\common\model\AuthGroup())->where('id',$id)->value('title');
}
function getLevelNameByID($id){
    return (new \app\common\model\UserLevel())->where('id',$id)->value('name');
}
function getGradeNameByPoint($score){
    return (new \app\common\model\UserGrade())->where('user_id',0)->where('score','elt',$score)->value('name');
}
/**
 * 友好的时间显示
 *
 * @param int    $sTime 待显示的时间
 * @param string $type  类型. normal | mohu | full | ymd | other
 * @return string
 */
function friendlyDate($timeInt=null,$format='Y-m-d H:i:s'){
    if(empty($timeInt)||!is_numeric($timeInt)||!$timeInt){
        return '';
    }
    $d=time()-$timeInt;
    if($d<0){
        return '';
    }else{
        if($d<60){
            return $d.'秒前';
        }else{
            if($d<3600){
                return floor($d/60).'分钟前';
            }else{
                if($d<86400){
                    return floor($d/3600).'小时前';
                }else{
                    if($d<259200){//3天内
                        return floor($d/86400).'天前';
                    }else{
                        return date($format,$timeInt);
                    }
                }
            }
        }
    }
}
function hidePhone($phone){
    if($phone){
        return substr($phone,0,3)."****".substr($phone,7,4);
    }
    return null;
}
function hideEmail($email){
    if($email){
        $email=explode('@',$email);
        $len=strlen($email[0]);
        $str=null;
        for($i=1;$i<$len-2;$i++){
            $str=$str.'*';
        }
        return substr($email[0],0,1).$str.substr($email[0],$len-2,2).$email[1];
    }
    return null;
}
function httpUrl($head)
{
    if (preg_match("/^(http:\/\/|https:\/\/).*$/", $head)) {
        return $head;
    } else {
        return 'http://' . $_SERVER['HTTP_HOST'] . getBaseUrl() . $head;
    }
}
function getBaseUrl()
{
    $baseUrl = str_replace('\\', '', dirname($_SERVER['SCRIPT_NAME']));
    $baseUrl = empty($baseUrl) ? '/' : '/' . trim($baseUrl, '/') .'/';
    return $baseUrl;
}

function remove_xss($html)
{
    $html = htmlspecialchars_decode($html);
    preg_match_all("/\<([^\<]+)\>/is", $html, $ms);

    $searchs[] = '<';
    $replaces[] = '&lt;';
    $searchs[] = '>';
    $replaces[] = '&gt;';

    if ($ms[1]) {
        $allowtags = 'video|attach|img|a|font|div|table|tbody|caption|tr|td|th|br|p|b|strong|i|u|em|span|ol|ul|li|blockquote|strike|pre|code|embed';
        $ms[1] = array_unique($ms[1]);
        foreach ($ms[1] as $value) {
            $searchs[] = "&lt;" . $value . "&gt;";

            $value = str_replace('&amp;', '_uch_tmp_str_', $value);
            $value = string_htmlspecialchars($value);
            $value = str_replace('_uch_tmp_str_', '&amp;', $value);

            $value = str_replace(array('\\', '/*'), array('.', '/.'), $value);
            $skipkeys = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate',
                'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange',
                'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick',
                'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate',
                'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete',
                'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel',
                'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart',
                'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop',
                'onsubmit', 'onunload', 'javascript', 'script', 'eval', 'behaviour', 'expression');
            $skipstr = implode('|', $skipkeys);
            $value = preg_replace(array("/($skipstr)/i"), '.', $value);
            if (!preg_match("/^[\/|\s]?($allowtags)(\s+|$)/is", $value)) {
                $value = '';
            }
            $replaces[] = empty($value) ? '' : "<" . str_replace('&quot;', '"', $value) . ">";
        }
    }
    $html = str_replace($searchs, $replaces, $html);
    $html = htmlspecialchars($html);
    return $html;
}
function string_htmlspecialchars($string, $flags = null)
{
    if (is_array($string)) {
        foreach ($string as $key => $val) {
            $string[$key] = string_htmlspecialchars($val, $flags);
        }
    } else {
        if ($flags === null) {
            $string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
            if (strpos($string, '&amp;#') !== false) {
                $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);
            }
        } else {
            if (PHP_VERSION < '5.4.0') {
                $string = htmlspecialchars($string, $flags);
            } else {
                if (!defined('CHARSET') || (strtolower(CHARSET) == 'utf-8')) {
                    $charset = 'UTF-8';
                } else {
                    $charset = 'ISO-8859-1';
                }
                $string = htmlspecialchars($string, $flags, $charset);
            }
        }
    }

    return $string;
}
/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function get_client_ip($type = 0, $adv = false)
{
    $type = $type ? 1 : 0;
    //static $ip  =   NULL;
    // if ($ip !== NULL) return $ip[$type];
    if ($adv) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) unset($arr[$pos]);
            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($ip == '127.0.0.1') {
            $ip = get_client_ip(0, true);
        }
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}
function getip(){
    if(isset ($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $onlineip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }elseif(isset ($_SERVER['HTTP_CLIENT_IP'])){
        $onlineip = $_SERVER['HTTP_CLIENT_IP'];
    }else{
        $onlineip = $_SERVER['REMOTE_ADDR'];
    }
    $onlineip = preg_match('/[\d\.]{7,15}/', addslashes($onlineip), $onlineipmatches);
    return $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
}