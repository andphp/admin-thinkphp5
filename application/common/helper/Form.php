<?php
namespace app\common\helper;

class Form
{

    public function formItem($formItems){
        if (!$formItems) {
            return false;
        }

        settype($formItems, 'array');
        $return='';
        foreach($formItems as $key=> $item){
            $class='';
            $title='';
            $id='';
            if(!empty($item['class'])){
                $class=$item['class'];
            }
            if($item['id']!=null){
                $id=$item['id'];
            }
            if($item['title']!=null){
                $title=$item['title'];
                $return .="<div id=\"".$id."\" class=\"layui-form-item ".$class."\">\r\n<label class=\"layui-form-label\">".$title."</label>\r\n<div class=\"layui-input-block\">\r\n";
            }else{
                $return .="<div id=\"".$id."\" class=\"layui-form-item ".$class."\">\r\n<div class=\"layui-input-block\">\r\n";
            }

            foreach($item['inputData'] as $k=> $v){
                $name='';
                $type='';
                $title='';
                $id='';
                $value='';
                $class='';
                $extra_data='';
                if($v['id']!=null){
                    $id=$v['id'];
                }
                if($v['title']!=null){
                    $title=$v['title'];
                }
                if($v['class']!=null){
                    $class=$v['class'];
                }
                if($v['id']!=null){
                    $id=$v['id'];
                }
                if($v['value']!=null){
                    $value=$v['value'];
                }

                if(!empty($v['extra_data'])){
                    foreach($v['extra_data'] as $kk =>$vv){
                        $extra_data .=$kk.'="'.$vv.'"';
                    }
                }

                if($v['type']=='selected'){
                    $id=$v['id'];
                }else{
                    $return .= "<input id=\"".$id."\" ".$extra_data." class=\"layui-input ".$class."\" type=\"".$type."\" name=\"".$name."\" value=\"".$value."\" title=\"".$title."\">\r\n";
                }

            }
            $return .="</div>\r\n</div>";

         }

        return $return;
    }
}
