<?php
namespace app\index\controller;
use think\Controller;


class Webdata extends Controller
{

	public function _initialize() {
	}
	/*增加点赞*/
	public function add_praise() {
		$id = input('id');
		// $ip = request()->ip();
		 $result = model('Webdata')->updateOne('total_praise');
		 if($id) {
			model('Article')->updateOne($id,'a_praise');
		}
		 if($result) {
		 	return $result;
		 }
	}
	/*获取网站统计数据*/
	public function get_webdata() {
		 $result = model('Webdata')->get_webdata();
		 if($result) {
		 	return $result;
		 }
	}











}
