<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/13
 * Time: 10:09
 */

namespace app\adminApi\model;


use app\common\model\CommonAdmin;

class Admin extends CommonAdmin
{

    public function role() {
        return $this->belongsToMany('Role', 'admin_role', 'role_id', 'admin_id');
    }
    public function user() {
        return $this->belongsTo('User');
    }


    public static function getByUserID($id){
        $user = self::where('user_id', '=', $id)->find();
        return $user;
    }

    public static function getList() {
        return self::with(['user','role'])->select();
    }

    /**
     * 获取管理员权限列表
     */
    public static function getAuth() {
        return self::with('role.menu.api')->find();
    }
}