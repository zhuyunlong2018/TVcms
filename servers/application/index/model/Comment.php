<?php
namespace app\index\model;
use think\Model;

class Comment extends Model
{
	public function getComment($id) {
		$list = $this
				->where('c_article_id',$id)
				->field('*,if(c_published=1,c_content,0) as c_content')
				->select();
		return $list;
	}
	public function get_all_comment($status) {
		$where = 'c_published=1';
		if($status) $where = '';
		$list = $this
				->join('article a','a.a_id=c_article_id','left')
				->where($where)
				->select();
		return $list;
	}
	public function addComment($data) {
		$result = $this
				->insert($data);
		return $result;
	}
	public function toggle_comment($id,$publish) {
		$result = $this
				->where('c_id',$id)
				->update(['c_published'=>$publish]);
		return $result;
	}
}
