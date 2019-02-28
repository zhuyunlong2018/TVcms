<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/19
 * Time: 21:15
 */

namespace app\admin\model;


use app\common\model\BaseModel;
use app\lib\File;

class User extends BaseModel
{
    protected $hidden = ['create_time','delete_time','update_time','pivot','user_pwd','user_pwd_salt','user_token_key'];

    public function getUserAvatarAttr($value) {
        if(empty($value)) {
            return File::getHttpPath(config('path.default'));
        }
        return $value;
    }
    public function getUserList()
    {
        return self::hasMany('CommonUser');
    }
    public static function getListByPage($condition,$order,$page, $limit){
        $pagingData = self::where($condition)->order($order)->paginate($limit, false, ['page' => $page]);
        return $pagingData ;
    }
    public static function getByName($name){
        $user = self::get(['user_name'=>$name]);
        return $user;
    }
    public static function getByEmail($email){
        $user = self::get(['user_email'=>$email]);
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