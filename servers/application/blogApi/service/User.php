<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/16
 * Time: 20:26
 */

namespace app\blogApi\service;
use app\adminApi\service\Token;
use app\adminApi\service\User as AdminServiceUser;
use app\lib\exception\LoginException;
use app\common\model\User as ModelUser;

class User
{
    public static function login($useremail,$password) {
        $user = ModelUser::getByEmail($useremail);
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
                'introduction' => '一只管理员'
            ];
            return $userData;
        }
    }
}