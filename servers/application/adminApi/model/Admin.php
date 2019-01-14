<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/13
 * Time: 10:09
 */

namespace app\adminApi\model;


class Admin extends BaseModel
{
    public static function getByUserID($id){
        $user = self::where('user_id', '=', $id)->find();
        return $user;
    }
}