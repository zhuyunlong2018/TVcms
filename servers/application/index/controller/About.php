<?php
namespace app\index\controller;
use think\Controller;


class About extends Controller
{

	public function _initialize() {
	}
	/*获取about内容*/
	public function get_about() {
		 $result = model('About')->get_about();
		 if($result) {
		 	return $result;
		 }
	}
	/*更新about内容*/
	public function update_about() {
		$about = input('content');
		 $result = model('About')->update_about($about);
		 if($result) {
		 	return $result;
		 }
	}

}

