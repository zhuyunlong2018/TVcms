<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/13
 * Time: 10:46
 */

namespace app\adminApi\service;

use app\adminApi\model\Admin as AdminModel;
use app\lib\exception\LoginException;

class Admin
{
    public static function adminLogin($username,$password) {
        $user = User::login($username,$password);
        $admin = self::checkAdmin($user);
        $token = Token::generateToken($user['user_id'],$user['user_email'],$user['user_name']);
        $adminData = [
            'name'=>$admin['admin_name'],
            'token'=>$token,
            'roles' => ['admin'],
            'avatar' => $admin['admin_avatar'],
            'introduction' => '一只管理员'
        ];
        return $adminData;
    }
    public static function checkAdmin($user) {
        $admin = AdminModel::getByUserID($user['user_id']);
        if (!$admin) {
            throw new LoginException(['msg' => '用户不是管理员', 'errorCode' => 10005]);
        } elseif (!$admin['admin_status']) {
            throw new LoginException(['msg' => '管理员状态为禁用', 'errorCode' => 10005]);
        } else {
            return $admin;
        }
    }
}