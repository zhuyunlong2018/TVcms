<?php
namespace app\index\controller;
use think\Controller;


class Article extends Controller
{
	public $PAGE_SIZE = 6;//定义首展示文章数量
	public function _initialize() {

	}
    /*获取所有文章列表*/
	public function get($publish=null) {
		 $result = model('Article')->getArticleList($publish);
		 if($result) {
		 	return $result;
		 }
	}
	/*获取第n页已发布文章列表*/
	public function getPage() {
		$page = input('page');
		$tag = input('tag');
		$pagesize = $this->PAGE_SIZE;
		 $result = model('Article')->getArticlePage($page,$tag,$pagesize);
		 if($result) {
		 	return $result;
		 }
	}
	/*获取主页文章页数*/
	public function getPageCount() {
		$tag = input('tag');
		 $result = model('Article')->getPageCount($tag);
		 if($result) {
		 	$pagesize = $this->PAGE_SIZE;
		 	if($result>$pagesize && $result%$pagesize == 0) {
				$result = floor($result/$pagesize);
			} else {
				$result = ceil($result/$pagesize);
			}
		 	return $result;
		 }
	}
	/*根据文章id获取对应文章内容*/
	public function getOne($status) {
		$id = input('id');
		 $result = model('Article')->getOne($id,$status);
		 if($result) {
		 	return $result;
		 }
	}
	/*通过id更新文章内容*/
	public function update() {
			$data1=[];
			$data1['a_title'] = input('title');
			$data1['a_content'] = input('content');
			$data1['a_tag'] = input('tag');
			$data1['a_img'] = input('article_background');
			$id = input('id');
		 $result = model('Article')->updatearticle($id,$data1);
		 if($result) {
		 	return $result;
		 }
	}
	/*新增文章*/
	public function add($status) {
			$data1=[];
			$data1['a_published'] = 0;
			$data1['a_title'] = input('title');
			$data1['a_author'] = input('name');
			$data1['a_content'] = input('content');
			$data1['a_tag'] = input('tag');
			$data1['a_time'] = input('time');
			$data1['a_img'] = input('article_background');
			$data1['a_comment'] = 0;
			$data1['a_praise'] = 0;
			if($status) $data1['a_published'] = 1;
		 $result = model('Article')->add($data1);
		 model('Webdata')->updateOne('total_article');
		 if($result) {
		 	return $result;
		 }
	}
	/*删除文章*/
	public function delarticle() {
		$id = input('id');
		 $result = model('Article')->delarticle($id);
		 if($result) {
		 	return $result;
		 }
	}
	/*发布或下架文章*/
	public function toggleOne() {
		$id = input('id');
		$publish = input('publish');
		 $result = model('Article')->toggleOne($id,$publish);
		 if($result) {
		 	return $result;
		 }
	}
	/*搜索文章*/
	public function searchfor() {
		$key = input('key');
		 $result = model('Article')->searchfor($key);
		 if($result) {
		 	return $result;
		 }
	}




}
