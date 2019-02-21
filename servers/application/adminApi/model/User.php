<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/19
 * Time: 21:15
 */

namespace app\adminApi\model;


use app\common\model\BaseModel;

class User extends BaseModel
{
    protected $hidden = ['create_time','delete_time','update_time','pivot','user_pwd','user_pwd_salt','user_token_key'];

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
    public static function registerByEmail($name,$email,$password,$passwordSalt) {
        return self::create([
            'user_name'=>$name,
            'user_email'=>$email,
            'user_pwd'=>$password,
            'user_pwd_salt'=>$passwordSalt,
            'create_time'=>time()
        ]);
    }
}