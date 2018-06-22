<?php
namespace app\index\controller;
use think\Controller;


class Tags extends Controller
{

	public function _initialize() {
	}

	/*添加标签*/
	public function add_tags() {
		$name = input('name');
		 $result = model('Tags')->add_tags($name);
		 if($result) {
		 	return $result;
		 }
	}
	/*删除标签*/
	public function del_tags($name) {
		$name = input('name');
		 $result = model('Tags')->del_tags($name);
		 if($result) {
		 	return $result;
		 }
	}
	/*获取所有标签*/
	public function get_tags() {
		 $result = model('Tags')->get_tags();
		 if($result) {
		 	return $result;
		 }
	}





}

