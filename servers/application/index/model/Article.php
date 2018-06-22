<?php
namespace app\index\model;
use think\Model;

class Article extends Model
{
	public function getArticleList($publish) {
		$where = [];
		if($publish) $where = ['a_published'=>1];
		$list = $this
					->where($where)
					->order('a_id desc')
					->field('a_content',true)
					->select();
		return $list;
	}
	public function getArticlePage($page,$tag,$pagesize) {
		$where = [];
		if($tag) $where['a_tag'] = $tag;
		$list = $this
					->where($where)
					->where('a_published',1)
					->order('a_id desc')
					->page($page,$pagesize)
					->select();
		return $list;
	}
	public function getPageCount($tag) {
		$where = [];
		if($tag) $where['a_tag'] = $tag;
		$count = $this
					->where($where)
					->where('a_published',1)
					->count();
		return $count;
	}
	public function getOne($id,$status) {
		$where = ['a_published'=>1];
		if($status) $where = [];
		$result = $this
					->where('a_id',$id)
					->where($where)
					->find();
		return $result;
	}
	public function updatearticle($id,$data) {
		$result = $this
					->where('a_id',$id)
					->update($data);
		return $result;
	}
	public function add($data) {
		$result = $this
					->insert($data);
		return $result;
	}
	public function delarticle($id) {
		$result = $this
					->where('a_id',$id)
					->delete();
		return $result;
	}
	public function updateOne($id,$witch) {
		$result = $this
					->where('a_id',$id)
					->setInc($witch);
		return $result;
	}
	public function toggleOne($id,$publish) {
		$result = $this
					->where('a_id',$id)
					->update(['a_published'=>$publish]);
		return $result;
	}
	public function searchfor($key) {
		$result = $this
					->where('a_published',1)
					->where('a_title','like','%'.$key.'%')
					->select();
		return $result;
	}
}
