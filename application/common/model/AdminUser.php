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
 * | createTime :2018/4/19 001915:52
 * +----------------------------------------------------------------------
 */

namespace app\common\model;





class AdminUser extends ModelBase
{
    /**
     * 关联角色模型 多对多
     * @return \think\model\relation\BelongsToMany
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 10:00
     */
    public function roles()
    {
        return $this->belongsToMany('AuthGroup','\app\common\model\AuthGroupAccess');
    }

    /**
     * 昵称读取器 （去盐值）
     * @param $value
     * @return mixed
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 14:59
     */
    public function getNicknameAttr($value){
        $return = explode('_',$value);
        return $return[0];
    }

    /**
     * 批量更新用户-角色 中间表
     * @param $id
     * @param $roles
     * @return array|false
     * @company    :WuYuZhong Co. Ltd
     * @author     :BabySeeME <417170808@qq.com>
     * @createTime :2018-03-05 22:30
     */
    public function saveRolesByID($id,$roles){
        (new AuthGroupAccess())->where(['admin_user_id'=>$id])->field('auth_group_id')->delete();
        $user = $this::get($id);
        return $user->roles()->saveAll($roles);
    }

}