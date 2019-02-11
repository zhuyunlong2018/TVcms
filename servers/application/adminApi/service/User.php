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
    public static function loginByName($username,$password) {
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

    public static function loginByEmail($email,$password) {
        $user = UserModel::getByEmail($email);
        if (!$user){
            throw new LoginException(['msg' => '用户不存在', 'errorCode' => 10005]);
        }elseif(!self::checkPassword($user,$password)) {
            throw new LoginException(['msg'=>'用户密码错误','errorCode'=>10002]);
        } else {
            $token = Token::generateToken($user['user_id'],$user['user_email'],$user['user_name']);
            $userData = [
                'user'=>$user,
                'token'=>$token,
            ];
            return $userData;
        }
    }

    public static function register($name,$email,$password) {
        $checkEmail = UserModel::getByEmail($email);
        if ($checkEmail) throw new LoginException(['msg'=>'邮箱已被注册']);
        $checkName = UserModel::getByName($name);
        if ($checkName) throw new LoginException(['msg'=>'用户名已被使用']);
        $tokenKey = getRandChar(32);
        $passwordSalt = getRandChar(32);
        $password = self::generatePassword($password,$passwordSalt);
        $result = UserModel::registerByEmail($name,$email,$password,$passwordSalt,$tokenKey);
        return $result;
    }


}