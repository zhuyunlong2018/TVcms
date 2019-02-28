<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/22
 * Time: 22:28
 */

namespace app\admin\service;


use app\admin\model\Api;
use app\lib\exception\AuthException;
use app\lib\Redis;
use think\Exception;

class Auth
{
    //系统全部已收录的api
    private static $allKey = null;

    //未注册的api
    private static $unRegisterKey = null;

    //允许不校验权限的api
    private static $allowedNoAuthKey = null;

    //需要校验权限的api
    private static $allowedAuthKey = null;

    //访问api
    private static $api = null;

    private static $method = null;

    /**
     * 初始化
     * @param $api
     */
    public static function init($api,$method) {

        if(!self::$allKey) {
            self::$allKey = myConfig('redisKey.apisType','all');
            self::getApiByType('all',self::$allKey);
        }
        if(!self::$unRegisterKey) {
            self::$unRegisterKey = myConfig('redisKey.apisType',0);
            self::getApiByType(0,self::$unRegisterKey);
        }
        if(!self::$allowedNoAuthKey) {
            self::$allowedNoAuthKey = myConfig('redisKey.apisType',2);
            self::getApiByType(2,self::$allowedNoAuthKey);
        }
        if(!self::$allowedAuthKey) {
            self::$allowedAuthKey = myConfig('redisKey.apisType',3);
            self::getApiByType(3,self::$allowedAuthKey);
        }
        if(!self::$api) {
            self::$api = $api;
        }
        if(!self::$method) {
            self::$method = $method;
        }
        self::check();
    }

    /**
     *权限判断
     */
    protected static function check() {
        if(self::ifInAll()) {
            //访问api在权限列表中
            if(self::ifInAllowedNo() || self::ifInAllowed()) {
                //访问api在需要登录权限列表中
                Token::checkToken();
                if(self::ifInAllowed()) {
                    //访问api在需要特定权限表中
                    if(!self::ifBoundToAdmin()) {
                        throw new AuthException(['msg'=>'访问越权，请查看用户权限']);
                    }
                }
            } elseif (self::ifInUnRegister()) {
                //访问api在被收录但未注册的列表中
                throw new AuthException(['msg'=>'权限错误：访问API未注册']);
            }
        }
    }

    /**
     * 检索api是否绑定到当前用户权限中
     * @return bool
     */
    public static function ifBoundToAdmin() {
        $user = User::init();
        //获取user对应admin的role权限
        $auth = false;
        $admin = Admin::getAdmin($user['user_id']);
        foreach ($admin['roles'] as $role) {
            if($role['write_auth']==0 && self::$method=='POST') {
                //如果本角色只有只读权限，而请求为写入，则跳过本角色验证
                continue;
            }
            $roleApi = Role::getRoleApi($role['role_id']);
            if(in_array(self::$api,$roleApi)) {
                $auth = true;
                break;
            }
        }
        return $auth;

    }


    /**
     *是否在收录的列表中
     */
    protected static function ifInAll() {
        return Redis::sIsMember(self::$allKey,self::$api);
    }

    /**
     *是否在不需要权限的列表中
     */
    protected static function ifInAllowedNo() {
        return Redis::sIsMember(self::$allowedNoAuthKey,self::$api);
    }

    /**
     *是否在权限校验要求列表中
     */
    protected static function ifInAllowed() {
        return Redis::sIsMember(self::$allowedAuthKey,self::$api);
    }

    /**
     *是否在未注册列表中
     */
    protected static function ifInUnRegister() {
        return Redis::sIsMember(self::$unRegisterKey,self::$api);
    }

    /**
     * 根据api权限类型获取对应api的列表
     * @param $type
     * @return array|mixed
     */
    protected static function getApiByType($type,$key) {
        $api = Redis::init()->smembers($key);
        if(!$api) {
            $api = [];
            $items = Api::getByType($type);
            foreach ($items as $item) {
                $api[] = $item['api_path'];
            }
            Redis::sAdd($key,$api);
        }
    }


}