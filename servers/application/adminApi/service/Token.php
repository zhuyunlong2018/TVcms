<?php


namespace app\adminApi\service;
use think\Exception;
use think\Request;
use \Firebase\JWT\JWT;
vendor('firebase.php-jwt.src.JWT');
class Token
{
    private static $key = 'f1e6585wefweda';
    // 生成令牌
    public static function generateToken()
    {
        $nowtime = time();
        $token = [
            'iss' => 'www.bianquan', //签发者
            'aud' => 'www.user', //jwt所面向的用户
            'iat' => $nowtime, //签发时间
            'nbf' => $nowtime + 10, //在什么时间之后该jwt才可用
            'exp' => $nowtime + 6000, //过期时间-100min
            'data' => [
                'userid' => '11',
                'useremail' => '920.com',
                'username' => '333',
                'userstatus' => 'fadf'
            ]
        ];
        $jwt = JWT::encode($token, self::$key);
        return $jwt;
    }


    //验证token是否合法或者是否过期
    //验证器验证只是token验证的一种方式
    //另外一种方式是使用行为拦截token，根本不让非法token
    //进入控制器
    public static function needPrimaryScope($jwt)
    {
        try {
            JWT::$leeway = 60;
            $decoded = JWT::decode($jwt, self::$key, array('HS256'));
            $arr = (array)$decoded;
            if ($arr['exp'] < time()) {
                $check['check_msg'] = '登录已失效，请重新登录';
            } else {
                return ture;
            }
        } catch(Exception $e) {
            $check['check_msg'] = 'Token验证失败,请重新登录';
        }



    }





}