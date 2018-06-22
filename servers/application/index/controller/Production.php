<?php
namespace app\index\controller;
use think\Controller;


class Production extends Controller
{

	public function _initialize() {
	}
	/*添加作品*/
	public function add_production() {
			$data1 = [];
			$data1['pr_name'] = input('name');
			$data1['pr_content'] = input('content');
			$data1['pr_img'] = input('imgs');
			$data1['pr_published'] = input('publish');
			$data1['pr_src'] = input('url');
			$data1['pr_time'] = input('time');
		 $result = model('Production')->add_production($data1);
		 if($result) {
		 	return $result;
		 }
	}
	/*开启或关闭作品*/
	public function toggle_production() {
			$id = input('id');
			$publish = input('publish');
		 $result = model('Production')->toggle_production($id,$publish);
		 if($result) {
		 	return $result;
		 }
	}

	/*编辑作品*/
	public function edit_production() {
			$id = input('id');
			$data1 = [];
			$data1['pr_name'] = input('name');
			$data1['pr_content'] = input('content');
			$data1['pr_img'] = input('imgs');
			$data1['pr_published'] = input('publish');
			$data1['pr_src'] = input('url');
			$data1['pr_time'] = input('time');
		 $result = model('Production')->edit_production($id,$data1);
		 if($result) {
		 	return $result;
		 }
	}
	/*获取项目内容*/
	public function get_production() {
		 $result = model('Production')->get_production();
		 if($result) {
		 	return $result;
		 }
	}









}

