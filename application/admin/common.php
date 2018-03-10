<?php
/**
 * | AndPHP框架[基于ThinkPHP5开发]
 * +----------------------------------------------------------------------
 * | Copyright (c) 2017-2019 http://www.andphp.com
 * +----------------------------------------------------------------------
 * | AndPHP承诺基础框架永久免费开源，您可用于学习和商用，但必须保留软件版权信息。
 * +----------------------------------------------------------------------
 * | author    :DaXiong <417170808@qq.com>
 * +----------------------------------------------------------------------
 * |createTime :2018/2/6 000619:27
 * +----------------------------------------------------------------------
 */

/**
 * 返回成功json格式数据
 * @param $msg
 * @param null $url
 * @param int $wait
 * @return string
 * @author     :BabySeeME <417170808@qq.com>
 * @createTime :2018-03-02 15:35
 */
function json_success($msg, $url = null,$wait=3)
{
    return json_encode(array(
        'result' => 'success',
        'code' => 1,
        'msg' => $msg,
        'url' => $url,
        'wait' => $wait
    ));
}

/**
 * 返回失败json格式数据
 * @param $msg
 * @param null $data
 * @param int $wait
 * @return string
 * @author     :BabySeeME <417170808@qq.com>
 * @createTime :2018-03-02 15:35
 */
function json_error($msg, $data = null,$wait=3)
{
    return json_encode(array(
        'result' => 'error',
        'code' => 0,
        'msg' => $msg,
        'data' => $data,
        'wait' => $wait
    ));
}
/**
 * 构建层级（树状）数组
 * @param array  $array          要进行处理的一维数组，经过该函数处理后，该数组自动转为树状数组
 * @param string $pid_name       父级ID的字段名
 * @param string $child_key_name 子元素键名
 * @return array|bool
 * @author     :BabySeeME <417170808@qq.com>
 * @createTime :2018-03-02 15:38
 */
function array2tree(&$array, $pid_name = 'pid', $child_key_name = 'children')
{
    $counter = array_children_count($array, $pid_name);
    if (!isset($counter[0]) || $counter[0] == 0) {
        return $array;
    }
    $tree = [];
    while (isset($counter[0]) && $counter[0] > 0) {
        $temp = array_shift($array);
        if (isset($counter[$temp['id']]) && $counter[$temp['id']] > 0) {
            array_push($array, $temp);
        } else {
            if ($temp[$pid_name] == 0) {
                $tree[] = $temp;
            } else {
                $array = array_child_append($array, $temp[$pid_name], $temp, $child_key_name);
            }
        }
        $counter = array_children_count($array, $pid_name);
    }

    return $tree;
}
/**
 * 子元素计数器
 * @param array $array
 * @param int   $pid
 * @return array
 * @author     :BabySeeME <417170808@qq.com>
 * @createTime :2018-03-02 15:38
 */
function array_children_count($array, $pid)
{
    $counter = [];
    foreach ($array as $item) {
        $count = isset($counter[$item[$pid]]) ? $counter[$item[$pid]] : 0;
        $count++;
        $counter[$item[$pid]] = $count;
    }

    return $counter;
}
/**
 * 把元素插入到对应的父元素$child_key_name字段
 * @param        $parent
 * @param        $pid
 * @param        $child
 * @param string $child_key_name 子元素键名
 * @return mixed
 * @author     :BabySeeME <417170808@qq.com>
 * @createTime :2018-03-02 15:38
 */
function array_child_append($parent, $pid, $child, $child_key_name)
{
    foreach ($parent as &$item) {
        if ($item['id'] == $pid) {
            if (!isset($item[$child_key_name])) {
                $item[$child_key_name] = [];
            }

            $item[$child_key_name][] = $child;
        }
    }

    return $parent;
}

function get_theme_thumb_image($module,$name){
    return WEB_URL.'/template/'.$module.'/'.$name.'/thumb_image.png';
}
