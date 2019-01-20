<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/13
 * Time: 10:10
 */

namespace app\adminApi\service;

use app\lib\exception\LoginException;
use app\adminApi\model\User as UserModel;
class User
{
    public static function login($username,$password) {
        $user = UserModel::getByName($username);
        if (!$user){
            throw new LoginException(['msg' => '用户不存在', 'errorCode' => 10005]);
        }elseif(!self::checkPassword($user,$password)) {
            throw new LoginException(['msg'=>'用户密码错误','errorCode'=>10002]);
        } else {
            return $user;
        }
    }

    public static function checkPassword($user,$password) {
        $result = $user['user_pwd'] == md5($password.$user['user_pwd_salt']);
        return $result;
    }

    public static function generatePassword($password,$passwordSalt) {
        return md5($password.$passwordSalt);
    }

}