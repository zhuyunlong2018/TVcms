<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/12
 * Time: 20:07
 */

namespace app\adminApi\service;
use app\lib\exception\TokenException;
use Firebase\JWT\JWT;
use RuntimeException;
use think\Exception;

class Token
{
    // 生成令牌
    public static function generateToken($userID,$userEmail,$userName)
    {
        $nowTime = time();
        $tokenMsg = [
            'iss' => config('token.iss'), //签发者
            'aud' => config('token.aud'), //jwt所面向的用户
            'iat' => config('token.iat'), //签发时间
            'nbf' => $nowTime + config('token.nbf'), //在什么时间之后该jwt才可用
            'exp' => $nowTime + config('token.exp'), //过期时间-100min
            'data' => [
                'userID' => $userID,
                'userEmail' => $userEmail,
                'userName' => $userName
            ]
        ];
        $token = JWT::encode($tokenMsg, config('token.key'));
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
                throw new TokenException(['msg'=>'登录已失效，请重新登录']);
            } else {
                return true;
            }
        } catch(RuntimeException $e) {
            throw new TokenException(['msg'=>$e->getMessage()]);
        }
    }

    public static function checkAuth($adminID,$path) {
        //配置不要鉴权的方法白名单
        return true;

        //通过$adminID获取对于的权限rules
        $rules = [];

        return in_array($path, $rules);

    }





}