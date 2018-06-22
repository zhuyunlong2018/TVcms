<?php
namespace app\index\model;
use think\Model;

class Webdata extends Model
{
	public function get_webdata() {
		$list = $this
				->select();
		return $list;
	}
	public function updateOne($witch) {
		$result = $this->where('total_id',1)
						->setInc($witch);
		return $result;
	}

}
