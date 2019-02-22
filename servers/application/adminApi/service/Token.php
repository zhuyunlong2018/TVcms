<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/12
 * Time: 20:07
 */

namespace app\adminApi\service;
use app\adminApi\model\Admin as AdminModel;
use app\lib\exception\RepeatException;
use app\lib\exception\TokenException;
use Firebase\JWT\JWT;
use RuntimeException;
use think\Cache;
use think\Request;

class Token
{
    // 生成令牌
    public static function generateToken($user)
    {
        $nowTime = time();
        $tokenMsg = [
            'iss' => config('token.iss'), //签发者
            'aud' => config('token.aud'), //jwt所面向的用户
            'iat' => config('token.iat'), //签发时间
            'nbf' => $nowTime + config('token.nbf'), //在什么时间之后该jwt才可用
            'exp' => $nowTime + config('token.exp'), //过期时间
            'data' => [
                'userID' => $user->user_id,
                'userEmail' => $user->user_email,
                'userName' => $user->user_name
            ]
        ];
        $token = JWT::encode($tokenMsg, config('token.key'));
        Cache::set($token,$user,config('token.exp'));
        return $token;
    }


    /**验证token是否合法或者是否过期
     * @param $jwt
     * @return bool
     * @throws TokenException
     */
    public static function checkToken($jwt)
    {
        if(empty($jwt)) {
            throw new TokenException(['msg'=>'Token不存在，请登录']);
        }
        try {
            JWT::$leeway = config('token.leeway');
            $decoded = JWT::decode($jwt, config('token.key'), array('HS256'));
            $arr = (array)$decoded;
            if ($arr['exp'] < time()) {
                self::removeToken($jwt);
                throw new TokenException(['msg'=>'登录已失效，请重新登录']);
            } else {
                return $arr['data'];
            }
        } catch(RuntimeException $e) {
            self::removeToken($jwt);
            throw new TokenException(['msg'=>$e->getMessage()]);
        }
    }

    public static function checkAuth($userID,$api) {
        //获取user对应admin的role权限
        $auth = false;
        $admin = Admin::getAdmin($userID);
        foreach ($admin['roles'] as $role) {
            $roleApi = Role::getRoleApi($role['role_id']);
            if(in_array($api,$roleApi)) {
                $auth = true;
                break;
            }
        }
//        throw new RepeatException(['msg'=>[$roleApi,$api]]);
        return $auth;

    }

    public static function getUser() {
        $request = Request::instance();
        $token = $request->header('X-Api-Token');
        $user = Cache::get($token);
        if(!$user) {
           throw new TokenException();
        }
        return $user;
    }

    public static function removeToken() {
        $request = Request::instance();
        $token = $request->header('X-Api-Token');
        $user = Cache::get($token);
        if($user) {
            Cache::rm($token);
            Admin::removeAdmin($user['user_id']);
        }
    }





}