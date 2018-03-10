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
 * | createTime :2018/3/2 000219:12
 * +----------------------------------------------------------------------
 */

namespace app\common\model;


class AuthRule extends ModelBase
{

    /**
     * 拼接菜单节点列表
     * @param $menu
     * @param int $id
     * @param int $level
     * @return array
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-03 13:43
     */
    public function menuList($menu,$id=0,$level=0){
        static $menus = array();
        foreach ($menu as $value) {
            if ($value['pid']==$id) {
                $value['level'] = $level+1;
                if($level == 0)
                {
                    $value['str'] = str_repeat('<i class="fa fa-angle-double-right"></i> ',$value['level']);
                }
                elseif($level == 2)
                {
                    $value['str'] = '&emsp;&emsp;&emsp;&emsp;'.'└ ';
                }
                else
                {
                    $value['str'] = '&emsp;&emsp;'.'└ ';
                }
                $menus[] = $value;
                $this->menulist($menu,$value['id'],$value['level']);
            }
        }
        return $menus;
    }
}