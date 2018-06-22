<?php
namespace app\index\model;
use think\Model;

class Images extends Model
{
	public function get_all_imgs() {
		$list = $this
				->select();
		return $list;
	}
	public function add_imgs($src) {
		$check = $this->where('i_src',$src)->find();
		if($check) return;
		$result = $this->insert(['i_src'=>$src]);
		return $result;
	}
	public function del_img($url) {
		$result = $this->where('i_src',$url)->delete();
		return $result;
	}
}
