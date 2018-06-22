<?php
namespace app\index\controller;
use think\Controller;


class Comment extends Controller
{

	public function _initialize() {
	}
	/*获取所有评论*/
	public function get_all_comment($status) {
		 $result = model('Comment')->get_all_comment($status);
		 if($result) {
		 	return $result;
		 }
	}
	/*根据文章id获取对应评论*/
	public function getComment() {
		$id = input('id');
		 $result = model('Comment')->getComment($id);
		 if($result) {
		 	return $result;
		 }
	}
	/*添加评论*/
	public function addComment() {
		$checkname = model('User')->insert_visitor();
		if(!$checkname) {
			return ['msg'=>'用户名或邮箱已被占用，且两个值与当前所填不一致。'];
		}
		$id = input('id');
		$data1 = [];
		$data1['c_article_id'] = $id;
		$data1['c_user'] = input('commenter');
		$data1['c_content'] = input('commentText');
		$data1['c_time'] = input('time');
		$data1['c_type'] = input('type');
		$data1['c_old_comment'] = input('oldComment');
		$data1['c_index'] = input('index');
		$data1['c_published'] = 1;
		 $result = model('Comment')->addComment($data1);
		 model('Webdata')->updateOne('total_comment');
		 if($id) {
		 	model('Article')->updateOne($id,'a_comment');
		 }

		 //邮件提醒被回复人
		 if($id == 0) {
			 $href = 'localhost:8080/msgborder';
		 } else {
			 $href = 'localhost:8080/articleList/article/' .$id;
		 }
		 if(input('oldComment') && input('commenter') != input('oldComment') ) {
			 $mailto = model('User')->getUserEmail(input('oldComment'));
			 $title = '您在[边泉小栈]的留言有了回复';
			$content = input('oldComment').',您好！<br><br>&nbsp;&nbsp;&nbsp;&nbsp;[<span style="color: blue;" >'.input('commenter').'</span>]在文章评论区[<span style="color: blue;">第'.input('index').'楼</span>]回复了您在[<span style="color: blue;" >边泉小栈</span>]的留言，内容如下:<br><br>&nbsp;&nbsp;&nbsp;&nbsp; “'. input('commentText') .'”<br><br>详细信息请<a href="'.$href.'" style="color:CornflowerBlue;cursor: pointer;" >点击查看</a><br>若点击无反应，请复制下方地址打开：<br><span style="color: #aaa; fontSize: 12px;" >'.$href.'</span>' ;
			 send_mail($mailto,$title,$content);
			 }

		 if($result) {
		 	return $result;
		 }
	}
	/*屏蔽或开放评论*/
	public function toggle_comment() {
		$id = input('id');
		$publish = input('publish');
		 $result = model('Comment')->toggle_comment($id,$publish);
		 if($result) {
		 	return $result;
		 }
	}






}
