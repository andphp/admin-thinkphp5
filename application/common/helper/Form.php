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
                if($v['name']!=null){
                    $name=$v['name'];
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
                if($v['value']!==null){
                    $value=" value=\"".$v['value']."\"";
                }

                if(!empty($v['extra_data'])){
                    foreach($v['extra_data'] as $kk =>$vv){
                        $extra_data .=$kk.'="'.$vv.'"';
                    }
                }
                $checked='';
                if($v['type']!=null){
                    $type=$v['type'];
                    if($v['type']=='text'){
                        $class=" class=\"layui-input ".$class."\"";
                    }elseif($v['type']=='radio'){
                        if($v['pre']==1){
                            $checked=" checked";
                        }
                    }elseif($v['type']=='textarea'){
                        $class=" class=\"layui-textarea ".$class.$k."\"";
                        $return .= "<textarea id=\"".$id."\" ".$extra_data.' '.$class." type=\"".$type."\" name=\"".$name."\" title=\"".$title."\" >".$v['value']."</textarea>\r\n";
                        continue;
                    }elseif($v['type'] == 'select'){
                        $class=" class=\" ".$class.$k."\"";
                        $return .= "<select id=\"" .$id."\" ".$extra_data.' '.$class." type=\"".$type."\" name=\"".$name."\" title=\"".$title."\">"
                            . "\r\n<option value=\"\">请选择</option>"
                            .$this->foreach_option($v['pre'],$v['value'])
                            ."\r\n</select>\r\n";
                        continue;
                    }
                }
                $return .= "<input id=\"".$id."\" ".$extra_data.' '.$class.' '.$value." type=\"".$type."\" name=\"".$name."\" title=\"".$title."\" ".$checked.">\r\n";

            }
            $return .="</div>\r\n</div>\r\n";

         }

        return $return;
    }

    protected function foreach_option($pre,$value=null){
        $return = '';
        foreach($pre as $vo){
            if($value == $vo['id']){
                $return .= "\r\n<option value=\"".$vo['id']."\" selected>".$vo['title']."</option>";
            }else{
                $return .= "\r\n<option value=\"".$vo['id']."\" >".$vo['title']."</option>";
            }
       }
        return $return;
    }
    public function formBtn($btn){
        if(!$btn){
            return false;
        }
        settype($btn, 'array');
        $return="";
        $extra_data='';
        if(!empty($btn['extra_data'])){
            foreach($btn['extra_data'] as $kk =>$vv){
                $extra_data .=$kk.'="'.$vv.'"';
            }
        }
        if($btn['id']!=null){
            $return .= "<div class=\"layui-form-item\" id=\"".$btn['id']."\" ".$extra_data."><div class=\"layui-input-block\">";
        }elseif($btn['class']!=null){
            $return .= "<div class=\"layui-form-item ".$btn['class']."\" ".$extra_data."><div class=\"layui-input-block\">";
        }else{
            $return .= "<div class=\"layui-form-item\"".$extra_data."><div class=\"layui-input-block\">";
        }
        foreach($btn['button'] as $key=> $item){

            $class =$item['class'];
            $icon = $item['icon'];
            $icon_value = $item['icon_value'];
            $title = $item['title'];
            $extra_data_name='';
            if(!empty($item['extra_data'])){
                foreach($item['extra_data'] as $k =>$v){
                    $extra_data_name .=' '.$k.'="'.$v.'"';
                }
            }
            $data_href='';
            if(!empty($item['href'])){
                $data_href=" href='".$item['href']."'";
            }

            $return .= "\r\n<button lay-submit $extra_data_name class=\"layui-btn ".$btn['id']."_".$key." ".$class."\" $data_href><i class=\"fa ".$icon."\" aria-hidden=\"true\">".$icon_value."</i>".$title."</button>";
        }
        $return .="\r\n</div>\r\n</div>\r\n";
        return $return;
    }
}
