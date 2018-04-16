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
 * | createTime :2018/4/14 001411:33
 * +----------------------------------------------------------------------
 */

namespace app\common\helper;


class Lists
{

    public function button($Button){
        if (!$Button) {
            return false;
        }
        settype($Button, 'array');
        $return='';
        foreach($Button as $key=> $item){


            $class =$item['class'];
            $icon = $item['icon'];
            $icon_value = $item['icon_value'];
            $title = $item['title'];
            $extra_data_name='';
            $data_href='';
            $id='';
            if(!empty($item['extra_data'])){
                foreach($item['extra_data'] as $k =>$v){
                    $extra_data_name .=$k.'="'.$v.'"';
                }
            }
            if(!empty($item['id'])){
               $id=" id='".$item['id']."'";
            }
            if(!empty($item['href'])){
                $data_href=" href='".$item['href']."'";
            }

            $return .= "<a $id $extra_data_name class=\"layui-btn and_btn_".$key." ".$class."\" $data_href><i class=\"fa ".$icon."\" aria-hidden=\"true\">".$icon_value."</i>".$title."</a>\r\n";
        }
        return $return;
    }
    public function buttonGroup($Button){
        if (!$Button) {
            return false;
        }
        settype($Button, 'array');
        $return='<div class="layui-btn-group '.$Button['class'].'" id="'.$Button['id'].'">'."\r\n";
        foreach($Button['button'] as $key=> $item){

            $class =$item['class'];
            $icon = $item['icon'];
            $icon_value = $item['icon_value'];
            $title = $item['title'];
            $extra_data_name='';
            if(!empty($item['extra_data'])){
                foreach($item['extra_data'] as $k =>$v){
                    $extra_data_name .=$k.'="'.$v.'"';
                }
            }
            $data_href='';
            if(!empty($item['href'])){
                $data_href=" href='".$item['href']."'";
            }

            $return .= "<a $extra_data_name class=\"layui-btn layui-btn-primary ".$Button['id']."_".$key." ".$class."\" $data_href><i class=\"fa ".$icon."\" aria-hidden=\"true\">".$icon_value."</i>".$title."</a>\r\n";
        }
        $return .="\r\n</div>\r\n";
        return $return;
    }
    public function table($table){
        if (!$table) {
            return false;
        }
        settype($table, 'array');
        $extra_data_name='';
        if(!empty($table['extra_data'])){
            foreach($table['extra_data'] as $k =>$v){
                $extra_data_name .=$k.'="'.$v.'" ';
            }
        }
        $return = "<table $extra_data_name id=\"".$table['id']."\" lay-filter=\"".$table['id']."\"></table>\r\n";
        return $return;
    }

}