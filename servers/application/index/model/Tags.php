<?php
namespace app\index\model;
use think\Model;

class Tags extends Model
{
	public function get_tags() {
		$list = $this
				->field('tag_name as tag')
				->select();
		return $list;
	}
	public function add_tags($name) {
		$result = $this
				->insert(['tag_name'=>$name]);
		return $result;
	}
	public function del_tags($name) {
		$result = $this
				->where('tag_name',$name)
				->delete();
		return $result;
	}

}
