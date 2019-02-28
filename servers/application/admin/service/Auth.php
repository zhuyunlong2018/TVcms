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
use think\Cache;

class Auth
{
    //系统全部已收录的api
    private static $allApi = null;

    //未注册的api
    private static $unRegisterApi = null;

    //允许不校验权限的api
    private static $allowedNoAuth = null;

    //需要校验权限的api
    private static $allowedAuth = null;

    //访问api
    private static $api = null;

    /**
     * 初始化
     * @param $api
     */
    public static function init($api) {
        if(!self::$allApi) {
            self::$allApi = self::getApiByType('');
        }
        if(!self::$unRegisterApi) {
            self::$unRegisterApi = self::getApiByType(0);
        }
        if(!self::$allowedNoAuth) {
            self::$allowedNoAuth = self::getApiByType(2);
        }
        if(!self::$allowedAuth) {
            self::$allowedAuth = self::getApiByType(3);
        }
        if(!self::$api) {
            self::$api = $api;
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
        return in_array(self::$api,self::$allApi);
    }

    /**
     *是否在不需要权限的列表中
     */
    protected static function ifInAllowedNo() {
        return in_array(self::$api,self::$allowedNoAuth);
    }

    /**
     *是否在权限校验要求列表中
     */
    protected static function ifInAllowed() {
        return in_array(self::$api,self::$allowedAuth);
    }

    /**
     *是否在未注册列表中
     */
    protected static function ifInUnRegister() {
        return in_array(self::$api,self::$unRegisterApi);
    }

    /**
     * 根据api权限类型获取对应api的列表
     * @param $type
     * @return array|mixed
     */
    protected static function getApiByType($type) {
        $api = Cache::get('api'.$type);
        if(!$api) {
            $api = [];
            $items = Api::getByType($type);
            foreach ($items as $item) {
                $api[] = $item['api_path'];
            }
            Cache::set('api'.$type,$api);
        }
        return $api;
    }


}