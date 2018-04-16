<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 模板设置
// +----------------------------------------------------------------------
function get_theme(){
    $theme_true=(new \app\common\model\SystemConfig())->cache(true)->where(['vari'=>'home_theme_status'])->field('value')->find();
    if($theme_true== false or $theme_true['value']==0){
        $return[1]='';
        $return[2]='/';
        return $return;
    }
    $theme_default=(new \app\common\model\Theme())->cache(true)->where(['status'=>1,'module'=>'home'])->field('name')->find();
    if($theme_default== false or $theme_default['name']=='default'){
        $return[1]= './template/'.config('app.default_module').'/default/';
        $return[2]= '/template/'.config('app.default_module').'/default/';
        return $return;
    }
    $return[1]='./template/'.config('app.default_module').'/'.$theme_default['name'].'/';
    $return[2]='/template/'.config('app.default_module').'/'.$theme_default['name'].'/';
    return $return;
}
return [
    // 模板引擎类型 支持 php think 支持扩展
    'type'         => 'Think',
    // 模板路径
    'view_path'    => get_theme()[1],
    '_view_path'    => get_theme()[2],
    // 模板后缀
    'view_suffix'  => 'html',
    // 模板文件名分隔符
    'view_depr'    => DIRECTORY_SEPARATOR,
    // 模板引擎普通标签开始标记
    'tpl_begin'    => '{',
    // 模板引擎普通标签结束标记
    'tpl_end'      => '}',
    // 标签库标签开始标记
    'taglib_begin' => '{',
    // 标签库标签结束标记
    'taglib_end'   => '}',
    //模板输出替换 ##替换规则严格区分大小写
    'tpl_replace_string'  =>  [
        '__ROOT__'           => WEB_URL,
        '__INDEX__'           => 'index.php',
        '__UPLOADS__'        => WEB_URL.'/uploads',
        '__PUBLIC__'         => WEB_URL.'/static/public',
        '__COMMON__'         => WEB_URL.'/static/common',
        '__'.strtoupper(config('app.default_module')).'__'          =>  WEB_URL .get_theme()[2].'static/'.config('app.default_module')
    ],
    //分页配置
    'paginate'      => [
        'type'      => 'Layui',
        'var_page'  => 'page',
        'list_rows' => 15,
        'newstyle'  => true,
    ],
];
