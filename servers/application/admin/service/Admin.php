<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/13
 * Time: 10:46
 */

namespace app\admin\service;

use app\admin\model\Admin as AdminModel;
use app\admin\model\AdminRole;
use app\lib\exception\LoginException;
use app\lib\Redis;

class Admin
{
    protected static $adminKey=null;

    public static function init($userID=0) {
        if(!self::$adminKey) {
            self::$adminKey = myConfig('redisKey.adminInfo',$userID);
        }
    }

    public static function adminLogin($username,$password) {
        $user = User::loginByName($username,$password);
        $admin = self::checkAdmin($user);
        $token = Token::generateToken($user);
        $adminData = [
            'name'=>$admin['admin_name'],
            'token'=>$token,
            'user' => $user
        ];
        return $adminData;
    }
    public static function checkAdmin($user) {
        $userID = $user['user_id'];
        $admin = self::getAdmin($userID);
        if (!$admin) {
            throw new LoginException(['msg' => '用户不是管理员', 'errorCode' => 10005]);
        } elseif (!$admin['admin_status']) {
            throw new LoginException(['msg' => '管理员状态为禁用', 'errorCode' => 10005]);
        } else {
            return $admin;
        }
    }

    public static function updateAdminRoles($admin_id,$roles) {
        $adminRoles = AdminRole::all(['admin_id'=>$admin_id]);
        $postRoles = [];
        $hasRoles = [];
        $insertRoles = [];
        $deleteRoles = [];
        foreach ($roles as $role) {
            $postRoles[] = $role['role_id'];
        }
        foreach ($adminRoles as $adminRole) {
            if(!in_array($adminRole['role_id'],$postRoles)) {
                $deleteRoles[] = $adminRole['admin_role_id'];
            }
            $hasRoles[] = $adminRole['role_id'];
        }
        foreach ($postRoles as $postRole) {
            if(!in_array($postRole,$hasRoles)) {
                $insertRoles[] = [
                    'admin_id' => $admin_id,
                    'role_id'=> $postRole
                ];
            }
        }
        if(!empty($deleteRoles)) {
            AdminRole::destroy($deleteRoles,true);
        }
        if(!empty($insertRoles)) {
            (new AdminRole())->saveAll($insertRoles);
        }
        return true;
    }

    public static function createAdminRoles($adminID,$roles) {
        $postRoles = [];
        $insertRoles = [];
        foreach ($roles as $role) {
            $postRoles[] = $role['role_id'];
        }
        foreach ($postRoles as $postRole) {
            $insertRoles[] =  [
                'admin_id' => $adminID,
                'role_id' => $postRole
            ];
        }
        if(!empty($insertRoles)) {
            (new AdminRole())->saveAll($insertRoles);
        }
        return true;
    }

    public static function deleteAdminRoles($admin_id) {
        $adminRoles = AdminRole::all(['admin_id'=>$admin_id]);
        $deleteRoles = [];
        foreach ($adminRoles as $adminRole) {
            $deleteRoles[] = $adminRole['admin_role_id'];
        }
        if(!empty($deleteRoles)) {
            AdminRole::destroy($deleteRoles,true);
        }
        return true;
    }

    public static function getAdmin($userID) {
        self::init($userID);
        $admin = Redis::hGetAll(self::$adminKey);
        if(!$admin) {
            $admin = AdminModel::getByUserID($userID);
            $admin['roles'] = serialize($admin['roles']);
            //设置管理员信息哈希缓存
            Redis::hSet(self::$adminKey,$admin);
            Redis::expire(self::$adminKey,14400);
        }
        $admin['roles'] = unserialize($admin['roles']);
        return $admin;
    }

    public static function removeAdmin($userID) {
        self::init($userID);
        Redis::del(self::$adminKey);
    }


}