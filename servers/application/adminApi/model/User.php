<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2019/1/9
 * Time: 20:25
 */

namespace app\adminApi\model;


class User extends BaseModel
{
    public function getUserList()
    {
        return self::hasMany('User');
    }
    public static function getSummaryByPage($page=1, $size=40){
        $pagingData = self::order('u_id desc')->paginate($size, true, ['page' => $page]);
        return $pagingData ;
    }

}