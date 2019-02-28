<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/12
 * Time: 20:07
 */

namespace app\admin\service;
use app\admin\model\Admin as AdminModel;
use app\lib\exception\RepeatException;
use app\lib\exception\TokenException;
use Firebase\JWT\JWT;
use RuntimeException;
use think\Cache;
use think\Request;

class Token
{
    private static $token = null;

    private static $tokenKey = null;

    /**
     *token初始化
     */
    public static function init() {
        if(!self::$token) {
            self::$token = Request::instance()->header('X-Api-Token');
            self::$tokenKey = 'token:'.md5(self::$token);
        }
        return self::$tokenKey;
    }



    /**
     * 生成令牌
     * @param $user
     * @return null|string
     */
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
        self::$token = JWT::encode($tokenMsg, config('token.key'));
        self::$tokenKey = 'token:'.md5(self::$token);
        Cache::set(self::$tokenKey,$user,config('token.exp'));
        return self::$token;
    }


    /**
     * 验证token是否合法或者是否过期
     * @return bool
     * @throws TokenException
     */
    public static function checkToken()
    {
        self::init();
        if(empty(self::$token)) {
            throw new TokenException(['msg'=>'Token不存在，请登录']);
        }
        try {
            JWT::$leeway = config('token.leeway');
            $decoded = JWT::decode(self::$token, config('token.key'), array('HS256'));
            $arr = (array)$decoded;
            if ($arr['exp'] < time()) {
                self::removeToken();
                throw new TokenException(['msg'=>'登录已失效，请重新登录']);
            } else {
                return $arr['data'];
            }
        } catch(RuntimeException $e) {
            self::removeToken();
            throw new TokenException(['msg'=>$e->getMessage()]);
        }
    }

    /**
     *移除缓存中的token关联的用户、管理员信息
     */
    public static function removeToken() {
        self::init();
        $user = Cache::get(self::$tokenKey);
        if($user) {
            Cache::rm(self::$tokenKey);
            Admin::removeAdmin($user['user_id']);
        }
    }





}