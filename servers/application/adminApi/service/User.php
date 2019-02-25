<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/13
 * Time: 10:10
 */

namespace app\adminApi\service;

use app\adminApi\model\WebData;
use app\lib\exception\LoginException;
use app\adminApi\model\User as UserModel;
use app\lib\exception\TokenException;
use think\Cache;

class User
{
    protected static $user = null;

    public static function init() {
        if(!self::$user) {
            $tokenKey = Token::init();
            self::$user = Cache::get($tokenKey);
            if(!self::$user) {
                throw new TokenException();
            }
        }
        return self::$user;
    }

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
            $token = Token::generateToken($user);
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
        $passwordSalt = getRandChar(32);
        $password = self::generatePassword($password,$passwordSalt);
        $result = UserModel::registerByEmail($name,$email,$password,$passwordSalt);
        WebData::get(1)->setInc('user_num');
        return $result;
    }


}