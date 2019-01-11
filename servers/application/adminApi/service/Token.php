<?php


namespace app\adminApi\service;
use app\lib\exception\TokenException;
use think\Exception;
use \Firebase\JWT\JWT;
use think\Request;

vendor('firebase.php-jwt.src.JWT');
class Token
{
    // 生成令牌
    public static function generateToken($userID,$userEmail,$userName)
    {
        $nowTime = time();
        $token = [
            'iss' => vendor('token.iss'), //签发者
            'aud' => vendor('token.aud'), //jwt所面向的用户
            'iat' => vendor('token.iat'), //签发时间
            'nbf' => $nowTime + vendor('token.nbf'), //在什么时间之后该jwt才可用
            'exp' => $nowTime + vendor('token.exp'), //过期时间-100min
            'data' => [
                'userID' => $userID,
                'userEmail' => $userEmail,
                'userName' => $userName
            ]
        ];
        $jwt = JWT::encode($token, vendor('token.key'));
        return $jwt;
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
            JWT::$leeway = vendor('token.leeway');
            $decoded = JWT::decode($jwt, vendor('token.key'), array('HS256'));
            $arr = (array)$decoded;
            if ($arr['exp'] < time()) {
                throw new TokenException(['msg'=>'登录已失效，请重新登录']);
            } else {
                return $arr['admin'];
            }
        } catch(Exception $e) {
            throw new TokenException(['msg'=>'Token验证失败,请重新登录']);
        }
    }

    public static function checkAuth($adminID,$path) {
        //配置不要鉴权的方法白名单
        

        //通过$adminID获取对于的权限rules
        $rules = [];

        return in_array($path, $rules);

    }





}