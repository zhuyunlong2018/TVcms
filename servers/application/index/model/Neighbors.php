<?php
namespace app\index\model;
use think\Model;

class Neighbors extends Model
{
	public function get_neighbors() {
		$list = $this
				->select();
		return $list;
	}
	public function add_neighbors($data) {
		$list = $this
				->insert($data);
		return $list;
	}
	public function del_neighbors($name) {
		$list = $this
				->where('nb_name',$name)
				->delete();
		return $list;
	}

}
