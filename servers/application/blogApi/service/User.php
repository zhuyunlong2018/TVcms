<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/16
 * Time: 20:26
 */

namespace app\blogApi\service;
use app\adminApi\service\Token;
use app\adminApi\service\User as AdminServiceUser;
use app\lib\exception\LoginException;
use app\blogApi\model\User as UserModel;
use app\lib\Response;

class User
{
    public static function login($email,$password) {
        $user = UserModel::getByEmail($email);
        if (!$user){
            throw new LoginException(['msg' => '用户不存在', 'errorCode' => 10005]);
        }elseif(!AdminServiceUser::checkPassword($user,$password)) {
            throw new LoginException(['msg'=>'用户密码错误','errorCode'=>10002]);
        } else {
            $token = Token::generateToken($user['user_id'],$user['user_email'],$user['user_name']);
            $userData = [
                'name'=>$user['user_name'],
                'token'=>$token,
                'roles' => ['user'],
                'avatar' => $user['user_avatar'],
                'introduction' => '一只管普通用户'
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
        $password = AdminServiceUser::generatePassword($password,$passwordSalt);
        $result = UserModel::registerByEmail($name,$email,$password,$passwordSalt,$tokenKey);
        return new Response(['msg'=>'注册成功，用户ID为'.$result->user_id]);
    }
}