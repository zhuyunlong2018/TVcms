<?php
namespace app\index\controller;
use think\Controller;


class Neighbors extends Controller
{

	public function _initialize() {
	}
	/*添加友情链接*/
	public function add_neighbors() {
			$data1 = [];
			$data1['nb_name'] = input('nb_name');
			$data1['nb_icon'] = input('nb_icon');
			$data1['nb_url'] = input('nb_url');
			$data1['nb_time'] = input('nb_time');
			$data1['nb_published'] = input('nb_published');
		 $result = model('Neighbors')->add_neighbors($data1);
		 if($result) {
		 	return $result;
		 }
	}
	/*删除友情链接*/
	public function del_neighbors() {
			$name = input('name');
		 $result = model('Neighbors')->del_neighbors($name);
		 if($result) {
		 	return $result;
		 }
	}
	/*获取友情链接*/
	public function get_neighbors() {
		 $result = model('Neighbors')->get_neighbors();
		 if($result) {
		 	return $result;
		 }
	}












}

