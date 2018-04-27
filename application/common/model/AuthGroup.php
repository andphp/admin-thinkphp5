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
 * | createTime :2018/3/3 000313:43
 * +----------------------------------------------------------------------
 */

namespace app\common\model;


class AuthGroup extends ModelBase
{

    /**
     * 关联管理员用户表 多对多
     * @return \think\model\relation\BelongsToMany
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 10:02
     */
    public function adminUser()
    {
        return $this->belongsToMany('AdminUser','\app\common\model\AuthGroupAccess');
    }
    /**
     * 关联管理员用户表 多对多
     * @return \think\model\relation\BelongsToMany
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 10:02
     */
    public function user()
    {
        return $this->belongsToMany('User','\app\common\model\AuthGroupAccess');
    }
}