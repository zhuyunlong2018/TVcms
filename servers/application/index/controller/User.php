<?php
namespace app\index\controller;
use think\Controller;
use \Firebase\JWT\JWT;
vendor('firebase.php-jwt.src.JWT');
define('KEY', 'f1e6585wefweda');
class User extends Controller
{

	public function _initialize() {
	}
	/*用户登录*/
	public function login() {
		$email = input('email');
		$pwd = input('pwd');
		 $result = model('User')->login($email,$pwd);
		 if($result) {
		 		$nowtime = time();
	            $token = [
                'iss' => 'www.bianquan', //签发者
                'aud' => 'www.user', //jwt所面向的用户
                'iat' => $nowtime, //签发时间
                'nbf' => $nowtime + 10, //在什么时间之后该jwt才可用
                'exp' => $nowtime + 6000, //过期时间-100min
                'data' => [
                    'userid' => $result['u_id'],
                    'useremail' => $result['u_email'],
                    'username' => $result['u_name'],
                    'userstatus' => $result['u_status']
                	]
	            ];
	            $jwt = JWT::encode($token, KEY);
	            $res = [];
	            $res['result'] = true;
	            $res['jwt'] = $jwt;
	            $res['name'] = $result['u_name'];
	            $res['email'] = $result['u_email'];
	            $res['userstatus'] = $result['u_status'];
	            $res['message'] = '登录成功！';
	            return $res;
		 }else {
		 	return false;
		 }
	}
	/*用户登录状态检查*/
	public function check_login(){
	    $jwt = isset($_SERVER['HTTP_X_TOKEN']) ? $_SERVER['HTTP_X_TOKEN'] : '';
	    $check = [];
	    $check['check_success'] = false;
	    if (empty($jwt) || !$jwt) {
	        $check['check_msg'] = 'You do not have permission to access.';
	        return $check ;
	    }

	    try {
	        JWT::$leeway = 60;
	        $decoded = JWT::decode($jwt, KEY, array('HS256'));
	        $arr = (array)$decoded;
	        if ($arr['exp'] < time()) {
	            $check['check_msg'] = '登录已失效，请重新登录';
	        } else {
	            $check['check_success'] = true;
	            $array = $arr['data'];
	            $check['check_status'] = $array->userstatus;
	            $check['check_msg'] = '状态为已登录';
	        }
	    } catch(Exception $e) {
	        $check['check_msg'] = 'Token验证失败,请重新登录';
	    }
	     return $check;
	}

	/*注册用户*/
	public function register() {
			$email = input('email');
			$name = input('name');
			$pwd = input('pwd');
			$time = input('time');
		 $result = model('User')->register($email,$name,$pwd,$time);
		 if(!$result[0]) {
		 	return ['result'=>false,'msg'=>$result[1]];
		 }else {
		 	return ['result'=>true,'msg'=>'注册成功啦，快去登陆！'];
		 }
	}



	/*显示所有用户*/
	public function show_all_user($status) {
		$result = model('User')->show_all_user($status);
		 if($result) {
		 	return $result;
		 }
	}

}
