<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
	private $check = [];//存储用户登录状态及身份
	public function _initialize() {
		$this->check = action('User/check_login');
	}
    public function index()
    {
    	$data = [];//存储返回客户端的数据
    	$status = false;//用于后台判断访客身份权限
    	if(isset($this->check['check_status'])) {
    		$status = $this->check['check_status']=='admin'?true:false;
    		$data['login'] = $this->check['check_success'];
    	}
    	$data['result'] = false;
    	$data['data'] = false;
        $act = input();
        if(empty($act['act'])) $act['act']='';
    switch($act['act']) {
    	//文章操作
			case 'getPage'://获取地n页已发布文章列表
			 	$data['data'] = action('Article/getPage');
			   	break;
			case 'get_all_article'://获取所有已发布文章列表
			 	$data['data'] = action('Article/get' ,['publish' => 1]);
			 	break;
			case 'getPageCount'://获取主页页数
			 	$data['data'] = action('Article/getPageCount');
			 	break;
			case 'get'://获取所有文章列表
			 	$data['data'] = action('Article/get');
			 	break;
			case 'update'://通过ID更新文章的内容
				$data['data'] = $status?action('Article/update'):false;
			 	break;
			case 'add'://新增文章
			 	$data['data'] = action('Article/add',$status);
			 	break;
			case 'del'://根据id删除文章
			 	$data['data'] = $status?action('Article/delarticle'):false;
			 	break;
			case 'getOne'://通过文章ID获取一篇文章数据
				$data['data'] = action('Article/getOne',$status);
				break;
			case 'publish'://发布或下架文章
				$data['data'] = $status?action('Article/toggleOne'):false;
				break;
		//标签操作
			case 'get_tags'://获取所有标签
			 	$data['data'] = action('Tags/get_tags');
			 	break;
			case 'add_tags'://添加标签
				$data['data'] = $status?action('Tags/add_tags'):false;
				break;
			case 'del_tags'://删除标签
				$data['data'] = $status?action('Tags/del_tags'):false;
				break;
		//网站统计操作
			case 'get_webdata'://获取网站统计数据
			 	$data['data'] = action('Webdata/get_webdata');
			 	break;
			case 'add_praise'://网站点赞
				$data['data'] = action('Webdata/add_praise');
				break;
		//友情链接操作
			case 'get_neighbors'://获取所有友情链接
				$data['data'] = action('Neighbors/get_neighbors');
				break;
			case 'add_neighbors'://添加友情链接
				$data['data'] = $status?action('Neighbors/add_neighbors'):false;
				break;
			case 'del_neighbors'://删除友情链接
				$data['data'] = $status?action('Neighbors/del_neighbors'):false;
				break;
		//评论操作
			case 'getComment'://根据文章ID获取对应的评论列表
				$data['data'] = action('Comment/getComment');
				break;
			case 'addComment'://增加评论
				$data['data'] = action('Comment/addComment');
				break;
			case 'get_all_comment'://获取所有评论
			 	$data['data'] = action('Comment/get_all_comment',$status);
			 	break;
			case 'toggle_comment'://屏蔽或解封评论
			 	$data['data'] = $status?action('Comment/toggle_comment'):false;
			 	break;
		//实验室项目操作
			case 'get_production'://获取项目内容
				$data['data'] = action('Production/get_production');
				break;
			case 'add_production'://增加作品
				$data['data'] = $status?action('Production/add_production'):false;
				break;
			case 'toggle_production'://开启或关闭作品
				$data['data'] = $status?action('Production/toggle_production'):false;
				break;
			case 'edit_production'://编辑作品
				$data['data'] = $status?action('Production/edit_production'):false;
				break;
		//about操作
			case 'get_about'://获取about
				$data['data'] = action('About/get_about');
				break;
			case 'update_about'://更新about内容
				$data['data'] = $status?action('About/update_about'):false;
				break;
		//user操作
			case 'check_login'://检查用户登录情况
				break;
			case 'register'://注册账号
				$data['data'] = action('User/register');
				break;
			case 'login'://登录验证
				$data['data'] = action('User/login');
				break;
			case 'show_all_user'://获取所有用户
			 	$data['data'] = action('User/show_all_user',$status);
			 	break;
		//图片操作
			case 'get_all_imgs'://获取所有图片地址
				$data['data'] = action('Images/get_all_imgs');
				break;
			case 'updata_imgs'://添加一张或多张图片
			 	$data['data'] = action('Images/updata_imgs');
			 	break;
			case 'del_img'://删除图片
			 	$data['data'] = $status?action('Images/del_img'):false;
			 	break;
		//搜索
			case 'get_bing'://获取bing图片
				$data['data'] = $this->get_bing();
				break;
			case 'searchfor'://通过key搜索文章
				$data['data'] = action('Article/searchfor');
				break;
		}
		if(isset($data['data'])){
			if($data['data']) $data['result'] = true;
		}
		if(!$status && !$data['data']) {
			$data['error'] = 1;//错误代码1：权限不足
		}
		return $data;
    }

	public function get_bing() {
		$str = file_get_contents('http://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1');
	    $array = json_decode($str);
	    $imgurl = $array->{"images"}[0]->{"url"};
	    $imgurl = '//cn.bing.com'.$imgurl;
	    return $imgurl;
	}
}
