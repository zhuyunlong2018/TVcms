<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/12
 * Time: 20:07
 */

namespace app\common\model;


class CommonUser extends BaseModel
{
    public function getUserList()
    {
        return self::hasMany('CommonUser');
    }
    public static function getListByPage($condition,$order,$page, $limit){
        $pagingData = self::where($condition)->order($order)->paginate($limit, false, ['page' => $page]);
        return $pagingData ;
    }
    public static function getByName($name){
        $user = self::where('user_name', '=', $name)->find();
        return $user;
    }
    public static function getByEmail($email){
        $user = self::where('user_email', '=', $email)->find();
        return $user;
    }
    public static function registerByEmail($name,$email,$password,$passwordSalt,$tokenKey) {
        return self::create([
            'user_name'=>$name,
            'user_email'=>$email,
            'user_pwd'=>$password,
            'user_pwd_salt'=>$passwordSalt,
            'user_token_key'=>$tokenKey,
            'create_time'=>time()
        ]);
    }

}