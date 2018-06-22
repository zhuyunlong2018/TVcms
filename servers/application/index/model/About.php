<?php
namespace app\index\model;
use think\Model;

class About extends Model
{
	public function get_about() {
		$result = $this
				->find();
		return $result;
	}
	public function update_about($about) {
		$result = $this
				->where('about_id',0)
				->update(['about_content'=>$about]);
		return $result;
	}

}
