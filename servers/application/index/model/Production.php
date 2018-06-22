<?php
namespace app\index\model;
use think\Model;

class Production extends Model
{
	public function get_production() {
		$list = $this
				->select();
		return $list;
	}
	public function add_production($data) {
		$result = $this
				->insert($data);
		return $result;
	}
	public function toggle_production($id,$publish) {
		$result = $this
				->where('pr_id',$id)
				->update(['pr_published'=>$publish]);
		return $result;
	}
	public function edit_production($id,$data1) {
		$result = $this
				->where('pr_id',$id)
				->update($data1);
		return $result;
	}



}
