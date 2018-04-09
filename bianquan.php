<?php 



header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With,X-token, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT,DELETE"); 
header("Content-Type: multipart/form-data; charset=utf-8");
header( 'P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"' );
	

header('Content-type:text/html;charset=utf-8');
$host = 'localhost';
$user = 'root';
$pwd = '';
$db_name = 'bianquan';


//创建数据库连接
$conn = new mysqli($host,$user,$pwd);

//检测连接
if ($conn->connect_error) {
	//die('连接数据库失败：'.$conn->connect_error.'<br>');
}
//echo '连接数据库成功<br>';

$connect=mysqli_select_db($conn,$db_name);
if($connect===false) {

	//创建数据库
	$sql = "CREATE DATABASE $db_name";

	if (mysqli_query($conn, $sql)) {
		//echo '数据库创建成功<br>';
	}else {
		//echo '数据库创建失败:'.mysqli_error($conn).'<br>';
	}
}

// mysqli_query($conn,"set names utf8");
mysqli_set_charset($conn,"utf8");
//use $db_name
$conn->select_db($db_name);

require 'vendor/autoload.php';
require 'vendor/sendMail/smtp.php';
use \Firebase\JWT\JWT;
define('KEY', 'f1e6585wefweda'); //密钥


$PAGE_SIZE=6;//首页文章列表数量


  $params = file_get_contents('php://input');//接受整个请求主体
  $params=json_decode($params,true);//反序列化
  //获取欲取参数
  //
  //
  // var_dump($params);

 if(isset($params)){ 
  	$act = isset($params['act'])?$params['act']:'';//客户端操作动作类别
  	$imgs = isset($params['imgs'])?$params['imgs']:'';//前端传递图片base64编码
  	$imgs_name = isset($params['imgs_name'])?$params['imgs_name']:'';//前端传递图片名称
  	$name = isset($params['name']) ? trim($params['name']) : '';//用户名  
	$email = isset($params['email']) ? trim($params['email']) : '';//用户邮箱 
	$password = isset($params['pwd']) ? trim($params['pwd']) : '';  //用户密码
	$pwd = md5($password.$email.'blog-bian-quan');
	$title = isset($params['title']) ? $params['title'] : '';//文章标题
	$content = isset($params['content']) ? $params['content'] : '';//文章内容
	$tag = isset($params['tag']) ? $params['tag'] : '';//文章标签
	$article_background = isset($params['article_background']) ? $params['article_background'] : '';//文章封面
	$time = isset($params['time']) ? $params['time'] : '';//文章创建时间
	$page = isset($params['page']) ? $params['page'] : '';//获取的文章列表索引
	$id = isset($params['id']) ? $params['id'] : '';//获取的文章ID/被评论的文章id
	$commenter = isset($params['commenter']) ? $params['commenter'] : '';//评论者
	$commenterEmail = isset($params['commenterEmail']) ? $params['commenterEmail'] : '';//评论者邮箱
	$commentText = isset($params['commentText']) ? $params['commentText'] : '';//评论内容
	$oldComment = isset($params['oldComment']) ? $params['oldComment'] : '';//被评论的人
	$type = isset($params['type']) ? $params['type'] : '';//评论的类别
	$index = isset($params['index']) ? $params['index'] : '';//评论第几楼
	$publish = isset($params['publish']) ? $params['publish'] : '';//文章发布或下降状态
	$url = isset($params['url']) ? $params['url'] : '';//链接

  } 


$check_data = check_login();
//var_dump($check_data['check_success']);
if ($check_data['check_success']) {
	if($check_data['check_status'] == 'admin') {
		$published = 1;
		switch($act) {
		 case 'del'://删除选中文章
		 	$data = del($id);
			break;
		 case 'publish'://发布或下架文章
		 	$data = publish($id,$publish);
		 	break;
		 case 'add_neighbors'://添加友情链接
		 	$data = add_neighbors($name,$url,$imgs,$time,$publish);
		 	break;
		case 'close_neighbors'://关闭或重启友情链接
		 	$data = close_neighbors($id,$publish);
		 	break;
		case 'del_neighbors'://删除友情链接
		 	$data = del_neighbors($name);
		 	break;
		case 'add_tags'://增加标签
		 	$data = add_tags($name);
		 	break;
		case 'del_tags'://删除标签
		 	$data = del_tags($name);
		 	break;
		case 'add_production'://增加作品
		 	$data = add_production($name,$url,$content,$imgs,$time,$publish);
		 	break;
		case 'edit_production'://编辑项目
		 	$data = edit_production($id,$name,$url,$content,$imgs);
		 	break;
		case 'close_production'://关闭或重启作品
		 	$data = close_production($id,$publish);
		 	break;
		 case 'close_comment'://屏蔽或解封评论
		 	$data = close_comment($id,$publish);
		 	break;
		 case 'get_all_comment'://获取所有评论
		 	$data = get_all_comment();
		 	break;
		 case 'show_all_user'://获取所有用户列表
		 	$data = show_all_user();
		 	break;
		 case 'update_about'://更新about页面
		 	$data = update_about($content);
		 	break;
		 case 'del_img'://删除图片
		 	$data = del_img($url);
		 	break;
		 case 'update'://通过ID更新文章的内容
		 	$data = update($title,$content,$tag,$id,$article_background);
		 	break;
		}
	} else {
			$published = 0;
		 	$data['result'] = 'false';
		 	$data['error'] = 'Permission denied';

		}

	switch($act) {
		 case 'add'://增加文章
		 	$data = add($name,$title,$content,$tag,$time,$article_background,$published);
		   	break;
		 case 'get'://获取所有文章列表
		 	$data = get();
		 	break;

		 case 'updata_imgs'://添加一张或多张图片
		 	$data = updata_imgs($imgs,$imgs_name,$time);
		 	break;
		 case 'get_all_imgs'://获取所有图片地址
		 	$data = get_all_imgs();
		 	break;

		}

}
if ($check_data['check_msg'] == '登录已失效，请重新登录') {
	$data['login'] = 'false';
	}
if(isset($act)) {
	switch($act) {
		 case 'getPage'://获取第n页文章列表
		 	$data = getPage($page,$PAGE_SIZE,$tag);
		 	break;
		 case 'getPageCount'://获取主页页数
		 	$data = getPageCount($PAGE_SIZE,$tag);
			break;
		 case 'getOne'://通过文章ID获取一篇文章数据
		 	$data = getOne($id);
		 	break;	
		 case 'getComment'://根据文章ID获取对应的评论列表
			$data = getComment($id);
			break;
			//添加文章评论
		case 'addComment':
			$data = addComment($commenter,$commenterEmail,$id,$commentText,$time,$type,$oldComment,$index);
			break;
		 case 'login'://登录验证
			$data = login($email,$pwd,$check_data);
			break;
		 case 'register'://注册账号
			$data = register($email,$name,$pwd,$time);
			break;
		 case 'check_login'://验证账号是否登录
		 	$data = $check_data;
			break;
		 case 'get_webdata'://获取网站统计数据
		 	$data = get_webdata();
			break;
		case 'add_praise'://网站点赞
			$data = add_praise($id);
			break;
		case 'get_tags'://获取所有标签
			$data = get_tags();
			break;
		case 'get_neighbors'://获取所有友情链接
			$data = get_neighbors();
			break;
		case 'get_about'://获取about
			$data = get_about();
			break;
		case 'get_all_article'://获取about
			$data = get(1);
			break;
		case 'get_bing'://获取bing图片
			$data = get_bing();
			break;
		case 'get_production'://获取项目内容
			$data = get_production();
			break;
	}
}
//输出数据
if(isset($data)) {
	echo json_encode($data,JSON_UNESCAPED_UNICODE);
}


//操作数据库函数封装
	function get_sql($type,$table,$data=null,$where=null,$condition=null) {
		global $conn;
		$data = $data==null?'*':$data;
		$where = $where==null?'':' WHERE '.$where;
		$condition = $condition==null?'':' ORDER BY '.$condition;
		switch($type) {
			case 'select':
				$sql = "SELECT $data FROM $table $where $condition";
				break;
			case 'insert' :
				$set = $data['set'];
				$val = $data['val'];
				$sql = "INSERT INTO $table $set VALUES $val";
				break;
			case 'update':
				$sql = "UPDATE $table SET $data $where";
				break;
			case 'delete':
				$sql = "DELETE FROM $table $where";
				break;
		}
		$result = $conn->query($sql);
		if($result) {
			//var_dump($sql);
			return $result;
		} else {
			//var_dump($sql);
			echo "Error: " . $sql . "<br>" . $conn->error;
			$result = false;
			return $result;
		}
		
	}

	function get_bing() {
		$str = file_get_contents('http://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1');
	    $array = json_decode($str);
	    $imgurl = $array->{"images"}[0]->{"url"};
	    $imgurl = '//cn.bing.com'.$imgurl;
	    $data['bing'] = $imgurl;
	    return $data;
	}






	/*删除图片*/
	function del_img($url) {
		//echo $url;
		$new_url = iconv('utf-8','gb2312',$url);
		$new_url = str_replace("../..","./bianquan",$new_url);
		//echo $new_url;
		if(file_exists($new_url)) {
			$del = unlink($new_url);
			if($del) {
				$where = 'i_src="'.$url.'"';
				$result = get_sql('delete','images','',$where);
				if(!$result) {
					$data['message'] = '数据库操作失败';
					$data['result'] = 'false';
				} else {
					$data['result'] = 'success';
				}
			} else {
				$data['message'] = '图片删除失败';
				$data['result'] = 'false';
			}
		} else {
			$data['message'] = '图片不存在';
			$data['result'] = 'false';
		}
		 return $data;
	}

		/*获取about页数据*/
	function get_about() {
		$result = get_sql('select','about');
		if(!$result) {
			$data['result'] = 'false';
			return $data;
		}
		$data = array();
		$data['result'] = 'success';
		while($row=mysqli_fetch_array($result))
		{
			$data['data'] = $row[0];
		}
		
		return $data;
	}



	/*更新about页面内容*/
	function update_about($content) {
		$data = 'about="'.$content.'"';
		$result = get_sql('update','about',$data);
		if(!$result) {
			return;
		}
		$data = array();
		$data['result'] = 'success';
		return $data;
	}

	/*编辑作品*/
	function edit_production($id,$name,$url,$content,$imgs) {
		$data = 'pr_name="'.$name .'",pr_content="'.$content.'",pr_src="'.$url.'",pr_img="'.$imgs.'"' ;
		$where = 'pr_id='.$id;
		$result = get_sql('update','production',$data,$where);
		if(!$result) {
			return;
		}
		$data = array();
		$data['result'] = 'success';
		return $data;
	}

	/*发布或下架作品*/
	function close_production($id,$publish) {
		$data = 'pr_published='.$publish;
		$where = 'pr_id='.$id;
		$result = get_sql('update','production',$data,$where);
		if(!$result) {
			return;
		}
		$data = array();
		$data['result'] = 'success';
		$data['publish'] = $publish;
		$data['id'] = $id;
		return $data;
	}



	/*增加作品*/
	function add_production($name,$url,$content,$imgs,$time,$publish) {
		$data = array();
		$data['set'] = '(pr_id,pr_name,pr_src,pr_content,pr_img,pr_time,pr_published)';
		$data['val'] = '(0, "' . $name .'","'. $url .'","'. $content .'","'.$imgs.'","'. $time .'","'. $publish. '")';
		$result = get_sql('insert','production',$data);
		if(!$result) {
			return;
		}
		$data['result'] = 'success';
		return $data;
	}

	/*获取所有项目内容*/
	function get_production() {
		$result = get_sql('select','production');
		if(!$result) {
			$data['result'] = 'false';
			return $data;
		}
		$data = array();
		$_production = array();
		$i=0;
		while($row=mysqli_fetch_array($result))
		{
			$arr=array();
			$arr['id'] = $row[0];
			$arr['name'] = $row[1];
			$arr['content'] = $row[2];
			$arr['src'] = $row[3];
			$arr['img'] = $row[4];
			$arr['time'] = $row[5];
			$arr['published'] = $row[6];
			$_production[$i] = $arr;
			$i++;
		}
		$data['result'] = 'success';
		$data['data'] = $_production;
		return $data;
	}








		/*获取所有友情链接*/
	function get_neighbors() {
		$result = get_sql('select','neighbors');
		if(!$result) {
			$data['result'] = 'false';
			return $data;
		}
		$data = array();
		$_neighbors = array();
		$i=0;
		while($row=mysqli_fetch_array($result))
		{
			$arr=array();
			$arr['id'] = $row[0];
			$arr['name'] = $row[1];
			$arr['url'] = $row[2];
			$arr['icon'] = $row[3];
			$arr['time'] = $row[4];
			$arr['published'] = $row[5];
			$_neighbors[$i] = $arr;
			$i++;
		}
		$data['result'] = 'success';
		$data['data'] = $_neighbors;
		return $data;
	}



	/*删除友情链接*/
	function del_neighbors($name) {
		$where = 'nb_name="'.$name .'"';
		$result = get_sql('delete','neighbors','',$where);
		if(!$result) {
			$data['result'] = 'false';
		} else {
			$data['result'] = 'success';
		}
		return $data;
	}


	/*发布或下架友情链接*/
	function close_neighbors($id,$publish) {
		$data = 'nb_published='.$publish;
		$where = 'nb_id='.$id;
		$result = get_sql('update','neighbors',$data,$where);
		if(!$result) {
			return;
		}
		$data = array();
		$data['result'] = 'success';
		$data['publish'] = $publish;
		$data['id'] = $id;
		return $data;
	}


	/*增加友情链接*/
	function add_neighbors($name,$url,$icon,$time,$publish) {
		$data = array();
		$data['set'] = '(nb_id,nb_name,nb_url,nb_icon,nb_time,nb_published)';
		$data['val'] = '(0, "' . $name .'","'. $url .'","'. $icon .'","'. $time .'","'. $publish. '")';
		$result = get_sql('insert','neighbors',$data);
		if(!$result) {
			$data['result'] = 'false';
		} else {
			$data['result'] = 'success';
		}
		return $data;
	}

	/*获取标签*/
	function get_tags() {
		$result = get_sql('select','tags');
		if(!$result) {
			return;
		}
		$data = array();
		$_tags = array();
		$i=0;
		while($row=mysqli_fetch_array($result))
		{
			$arr=array();
			//$arr['id'] = $row[0];
			$arr['tag'] = $row[1];
			$_tags[$i] = $arr;
			$i++;
		}
		$data['result'] = 'success';
		$data['data'] = $_tags;
		return $data;
	}

	/*删除标签*/
	function del_tags($name) {
		$where = 'tag_name="'.$name. '"' ;
		$result = get_sql('delete','tags','',$where);
		if(!$result) {
			return;
		}
		$data['result'] = 'success';
		return $data;
	}


	/*增加标签*/
	function add_tags($name) {
		$check_where = 'tag_name="'.$name. '"';
		$check = get_sql('select','tags','*',$check_where);
		if($check) {
			if(mysqli_num_rows($check)) {
				$data['result'] = 'false';
				
			} else {
				$data = array();
				$data['set'] = '(tag_id,tag_name)';
				$data['val'] = '(0, "' . $name . '")';
				$result = get_sql('insert','tags',$data);
				if(!$result) {
					$data['result'] = 'false';
					
				}
				$data['result'] = 'success';
			}
		} else {
			$data['result'] = 'false';
		}
		return $data;
	}

	/*获取网站统计数据*/
	function get_webdata() {
		$result = get_sql('select','webdata');
		if(!$result) {
			return;
		}
		$data = array();
		$data['result'] = 'success';
		while($row=mysqli_fetch_array($result))
		{
			$arr=array();
			$arr['article'] = $row[0];
			$arr['user'] = $row[1];
			$arr['comment'] = $row[2];
			$arr['praise'] = $row[3];
			$arr['tags'] = $row[4];
			$arr['viewers'] = $row[5];
		}
		$data['data'] = $arr;
		return $data;
	}

	/*添加点赞*/
	function add_praise($id) {
		$data_total = 'total_praise = total_praise +1';
		$result_total = get_sql('update','webdata',$data_total);
		if($id) {
			$data_article = 'a_praise = a_praise +1';
			$where_article = 'a_id='.$id;
			$result_article = get_sql('update','article',$data_article,$where_article);
		}
	}



	/*发布或下架文章*/
	function publish($id,$publish) {
		$data = 'a_published='.$publish;
		$where = 'a_id='.$id;
		$result = get_sql('update','article',$data,$where);
		if(!$result) {
			return;
		}
		$data = array();
		$data['result'] = 'success';
		$data['publish'] = $publish;
		$data['id'] = $id;
		return $data;
	}

	/*获取所有图片地址*/
	function get_all_imgs() {
		 $result = get_sql('select','images');
		 if(!$result) {
		 	return;
		 }
		 $images=array();
		while($row=mysqli_fetch_array($result))
		{	
			array_push($images,$row['i_src']);
		}
		$data['result'] = 'success';
		$data['data'] = $images;
		return $data;
	}


	/*添加一张或多张图片*/
	function updata_imgs($imgs,$imgs_name) {
        if($imgs){
        	$i = 0;//记录图片数量
            foreach($imgs as $v){
            	$name = iconv('utf-8','gb2312',$imgs_name[$i]);
            	//移除编码前面可能存在的逗号
                $base64_img =ltrim(trim($v), ",") ;
                //var_dump($base64_img);
				//匹配出图片的格式
				if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)) {
				//var_dump($result[1]);
				//$type = $result[2];//取出图片后缀
				//var_dump($type);
				$new_file = "./bianquan/static/imgs/".date('Ymd',time())."/";
					if(!file_exists($new_file)) {
					//检查是否有该文件夹，如果没有就创建，并给予最高权限
					mkdir($new_file, 0700);
					}
					$new_file = $new_file.$name;
					if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)))){
						//返回图片的地址
						$new_url = rtrim($new_file,$name);
						$images[$i] = "../../" . ltrim($new_url, "./bianquan") . $imgs_name[$i];
						$where = "i_src = '" . $images[$i] . "'";
						$result = get_sql('select','images','*',$where);
						if($result) {
							if(mysqli_num_rows($result)) {
								//$data[$i.'message'] = "图片已存在";
							} else {
								$data = array();
								$data['set'] = '(i_id,i_src)';
						 		$data['val'] = '(0, "' . $images[$i] . '")';
						 		$result = get_sql('insert','images',$data);
							}

						}
						//$images[$i] = $new_file;
						$i++;
						$data['result'] = 'success';
					}else{
					$data['message'] = '新文件保存失败';
					$data['result'] = 'false';
					}
				}
			}
			//var_dump($images);
			$data['images'] = $images;
			return $data;
		}
	}




	/*增加文章*/
	function add($name,$title,$content,$tag,$time,$article_background,$published) {
		 $data = array();
		 $data['set'] = '(a_id,a_author,a_title,a_content,a_tag,a_time,a_img,a_published)';
		 $data['val'] = '(0,"'. $name.'","'.$title.'","'.$content.'","'.$tag.'","'.$time. '","' .$article_background.'","'.$published.'")';
		 $result = get_sql('insert','article',$data);
		 if(!$result){
		 	return;
		 }
		 $data_total = 'total_article = total_article +1';
		$result_total = get_sql('update','webdata',$data_total);
		 $data['result'] = 'success';
		 return $data;
	}
	/*获取所有文章列表*/
	function get($publish=null) {
		if($publish) {
			$where = 'a_published='.$publish;
		} else {
			$where = null;
		}
		$condition = 'a_id DESC  ';
		 $result = get_sql('select','article','a_id,a_author,a_title,a_tag,a_time,a_published',$where,$condition);
		 if(!$result) {
		 	return;
		 }
		 $aResult=array();
		 $i = 0;
		while($row=mysqli_fetch_array($result))
		{
			$arr=array();
			$arr['id'] = $row[0];
			$arr['author'] = $row[1];
			$arr['title'] = $row[2];
			$arr['tag'] = $row[3];
			$arr['time'] = $row[4];
			$arr['published'] = $row[5];
			$aResult[$i] = $arr;
			$i++;

		}
		if(count($aResult)>0) {
			$data['data'] = $aResult;
		}
		$data['result'] = 'success';
		return $data;
	}
	/*通过ID更新文章的内容*/
	function update($title,$content,$tag,$id,$article_background) {
		$data = 'a_title="'.$title.'",a_content="'.$content.'",a_tag="'.$tag.'",a_img="'.$article_background .'"';
		$where = 'a_id='.$id;
		$result = get_sql('update','article',$data,$where);
		if(!$result) {
			return;
		}
		$data = array();
		$data['result'] = 'success';
		return $data;

	}
	/*删除选中文章*/
	function del($id) {
		$where = 'a_id='.$id;
		$result = get_sql('delete','article','',$where);
		if(!$result) {
			return;
		}
		$data_total = 'total_article = total_article -1';
		$result_total = get_sql('update','webdata',$data_total);
		$data['result'] = 'success';
		return $data;
	}


	//发送邮件函数
	function send_mail($mailto,$title,$content) {
		//使用163邮箱服务器
		$smtpserver = "smtp.163.com";
		//163邮箱服务器端口 
		$smtpserverport = 25;
		//你的163服务器邮箱账号
		$smtpusermail = "xxxx@163.com";
		//收件人邮箱
		$smtpemailto = $mailto;

		//你的邮箱账号(去掉@163.com)
		$smtpuser = "xxxx";//你的163邮箱去掉后面的163.com
		//你的邮箱密码
		$smtppass = "xxxxxxxxx"; //你的163邮箱SMTP的授权码，千万不要填密码！！！

		//邮件主题 
		$mailsubject = $title;
		//邮件内容 
		$mailbody = $content;
		//邮件格式（HTML/TXT）,TXT为文本邮件 
		$mailtype = "HTML";
		//这里面的一个true是表示使用身份验证,否则不使用身份验证. 
		$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
		//是否显示发送的调试信息 
		$smtp->debug = FALSE;
		//发送邮件
		$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype); 

	}
	//unescpae解码
	function unescape($str) { 
		    $ret = ''; 
		    $len = strlen($str); 
		    for ($i = 0; $i < $len; $i ++) 
		    { 
		        if ($str[$i] == '%' && $str[$i + 1] == 'u') 
		        { 
		            $val = hexdec(substr($str, $i + 2, 4)); 
		            if ($val < 0x7f) 
		                $ret .= chr($val); 
		            else  
		                if ($val < 0x800) 
		                    $ret .= chr(0xc0 | ($val >> 6)) . 
		                     chr(0x80 | ($val & 0x3f)); 
		                else 
		                    $ret .= chr(0xe0 | ($val >> 12)) . 
		                     chr(0x80 | (($val >> 6) & 0x3f)) . 
		                     chr(0x80 | ($val & 0x3f)); 
		            $i += 5; 
		        } else  
		            if ($str[$i] == '%') 
		            { 
		                $ret .= urldecode(substr($str, $i, 3)); 
		                $i += 2; 
		            } else 
		                $ret .= $str[$i]; 
		    } 
		    return $ret; 
		}





	/*添加文章评论*/
	function addComment($commenter,$commenterEmail,$id,$commentText,$time,$type,$oldComment,$index) {
		$where_check = "u_name = '".$commenter."' and u_mail = '".$commenterEmail."'";
		$result_check = get_sql('select','user','*',$where_check);
		if(!$result_check) {
			return;
		}
		if(!$row=mysqli_fetch_array($result_check)){
			$data_user['set'] = '(u_id,u_name,u_mail,u_status,u_time)';
		 	$data_user['val'] = "(0,'".$commenter."','".$commenterEmail."','visitor','".$time."')";
		 	$result_user = get_sql('insert','user',$data_user);
		 }
		 $publish = 1;
		$data['set'] = '(c_id,c_article_id,c_user,c_content,c_time,c_type,c_old_comment,c_index,c_published)';
		$data['val'] = '(0,'.$id.',"'.$commenter.'","'.$commentText.'","'.$time.'","'.$type.'","'.$oldComment.'",'.$index.','.$publish.')';
		$result = get_sql('insert','comment',$data);
		if($result) {

			if($oldComment && $commenter != $oldComment ) {
				$old_where = 'u_name="' . $oldComment . '"';
				$old_result = get_sql('select','user','*',$old_where);
				if(!$old_result) { return;}
				while($row = mysqli_fetch_array($old_result)) {
					$mailto = $row['u_mail'];
					$member = $row['u_status'];
				}
				if($id == 0) {
					$href = 'localhost:8080/#/msgborder';
				} else {
					$href = 'localhost:8080/#/articleList/article/' .$id;
				}
				
				$c_content = unescape($commentText);
				$title = '您在[边泉小栈]的留言有了回复';
				$content = $oldComment.',您好！<br>'.$commenter.'回复了您在[边泉小栈]的留言:<br>'. $c_content .'<br>详细信息请<a href="'.$href.'" style="color:CornflowerBlue;cursor: pointer;" >查看详情</a>' ;
				if($member != 'admin') {
					send_mail($mailto,$title,$content);
				}
				
			}

			if($id>0) {
				$data_article = 'a_comment = a_comment +1';
				$where_article = 'a_id='.$id;
				$result_article = get_sql('update','article',$data_article,$where_article);
			}
			$data_total = 'total_comment = total_comment +1';
			$result_total = get_sql('update','webdata',$data_total);
			$data['result'] = 'success';
		}
		return $data;
	}
	/*获取第n页文章列表*/
	function getPage($page,$PAGE_SIZE,$tag) {
		$s=($page)*$PAGE_SIZE;
		if($tag) {
			$where = 'a_published = 1 and a_tag = "' .$tag .'"' ;
		} else {
			$where = 'a_published = 1';
		}
		$condition = 'a_id DESC LIMIT ' . $s.',' .$PAGE_SIZE;
		$result = get_sql('select','article','*',$where,$condition);
		//$data['data'] = $result;
		if(!$result) {
			return;
		}
		$aResult=array();
		$i = 0;
		while($row=mysqli_fetch_array($result))
		{
			$arr=array();
			$arr['id'] = $row[0];
			$arr['author'] = $row[1];
			$arr['title'] = $row[2];
			$arr['content'] = $row[3];
			$arr['tag'] = $row[4];
			$arr['time'] = $row[5];
			$arr['img'] = $row[6];
			$arr['comment'] = $row[8];
			$arr['praise'] = $row[9];
			$aResult[$i] = $arr;
			$i++;
		}
		if(count($aResult)>0) {
			$data['data'] = $aResult;
		}

		$data['result'] = 'success';
		return $data;
	}

	/*获取主页页数*/
	function getPageCount($PAGE_SIZE,$tag) {
		// $data = 'COUNT(*)/'.$PAGE_SIZE.'+1';
		 $data = 'COUNT(*)';
		 if($tag) {
			$where = 'a_published = 1 and a_tag = "' .$tag .'"' ;
		} else {
			$where = 'a_published = 1';
		}
		$result = get_sql('select','article',$data,$where);
		if(!$result) {
			return;
		}
		$row=mysqli_fetch_array($result);
		$data = array();
		$count = (int)$row[0];
		if($count>$PAGE_SIZE && $count%$PAGE_SIZE == 0) {
			$count = floor($count/$PAGE_SIZE);
		} else {
			$count = ceil($count/$PAGE_SIZE);
		}
		$data['count'] = $count;
		$data['result'] = 'success';
		return $data;
	}

	/*通过文章ID获取一篇文章数据*/
	function getOne($id){
		$where = 'a_id='.$id;
		$result = get_sql('select','article','*',$where);
		if(!$result) {
			$data['result'] = 'false';
			return $data;
		}
	 	while($row=mysqli_fetch_array($result))
		{
			$arr=array();
			$arr['id'] = $row[0];
			$arr['author'] = $row[1];
			$arr['title'] = $row[2];
			$arr['content'] = $row[3];
			$arr['tag'] = $row[4];
			$arr['time'] = $row[5];
			$arr['img'] = $row[6];
			$arr['comment'] = $row[8];
			$arr['praise'] = $row[9];
			if( $row[7] == 0 ) {
				$data['result'] = 'false';
				$data['publish'] = 'false';
			} else {
				$data['data'] = $arr;		
				$data['result'] = 'success';
			}
		}
		return $data;
	}




	/*屏蔽或解封评论*/
	function close_comment($id,$publish) {
		$data = 'c_published='.$publish;
		$where = 'c_id='.$id;
		$result = get_sql('update','comment',$data,$where);
		if(!$result) {
			return;
		}
		$data = array();
		$data['result'] = 'success';
		$data['publish'] = $publish;
		$data['id'] = $id;
		return $data;
	}
	/*获取所有评论列表*/
	function get_all_comment(){
		$result = get_sql('select','comment');
		 $aResult=array();
		 if($result) {
		 	$i = 0;
		 	while($row=mysqli_fetch_array($result)){
		 	$arr = array();
		 	$arr['id'] = $row[0];
			$arr['articleId'] = $row[1];
			$arr['user'] = $row[2];
			$arr['content'] = $row[3];
			$arr['time'] = $row[4];
			$arr['type'] = $row[5];
			$arr['oldComment'] = $row[6];
			$arr['index'] = $row[7];
			$arr['published'] = $row[8];
			$aResult[$i] = $arr;
			$i++;
			}
			$data['data'] = $aResult;		
		 	$data['result'] = 'success';	
		 } else {
		 	$data['result'] = 'false';
		 }
		 return $data;
	}


	/*根据文章ID获取对应的评论列表*/
	function getComment($id){
		$where = "c_article_id=".$id;
		$result = get_sql('select','comment','*',$where);
		 $aResult=array();
		 if($result) {
		 	$i = 0;
		 	while($row=mysqli_fetch_array($result)){
			 	$arr = array();
			 	$arr['id'] = $row[0];
				$arr['articleId'] = $row[1];
				$arr['user'] = $row[2];
				$arr['time'] = $row[4];
				$arr['type'] = $row[5];
				$arr['oldComment'] = $row[6];
				$arr['index'] = $row[7];
			 	if($row[8] == 1) {
			 		$arr['content'] = $row[3];
			 	} else {
			 		$arr['content'] = '该评论已被屏蔽';
			 	}
			 	$aResult[$i] = $arr;
				$i++;
			}
			$data['data'] = $aResult;		
		 	$data['result'] = 'success';	
		 } else {
		 	$data['result'] = 'false';
		 }
		 return $data;
	}

	/*用户登录状态检查*/
	function check_login(){ 
		$data['check_success'] = false;
	    $jwt = isset($_SERVER['HTTP_X_TOKEN']) ? $_SERVER['HTTP_X_TOKEN'] : '';
	    if (empty($jwt)) {
	        $data['check_msg'] = 'You do not have permission to access.';
	        return $data;
	    }
	    try {
	        JWT::$leeway = 60;
	        $decoded = JWT::decode($jwt, KEY, array('HS256'));
	        $arr = (array)$decoded;
	        if ($arr['exp'] < time()) {
	            $data['check_msg'] = '登录已失效，请重新登录';
	        } else {
	            $data['check_success'] = true;
	            $array = $arr['data'];
	            $data['check_status'] = $array->userstatus;
	            $data['check_msg'] = '状态为已登录';
	        }
	    } catch(Exception $e) {
	        $data['check_msg'] = 'Token验证失败,请重新登录';
	    }
	     return $data;
	}

	/*用户登录*/
	function login($email, $pwd,$check_data) {
		//$data['check_data'] = $check_data;
		$result = get_sql('select','user');
		if(!$result) {
			return $data['message'] = '数据库操作失败';
		}
		$success = false;
		while($row = mysqli_fetch_array($result)) {
			if($email == $row['u_mail'] && $pwd == $row['u_pwd']) {
				$success = true;
				$nowtime = time();
	            $token = [
	                'iss' => 'www.bianquan', //签发者
	                'aud' => 'www.user', //jwt所面向的用户
	                'iat' => $nowtime, //签发时间
	                'nbf' => $nowtime + 10, //在什么时间之后该jwt才可用
	                'exp' => $nowtime + 6000, //过期时间-100min
	                'data' => [
	                    'userid' => $row['u_id'],
	                    'useremail' => $row['u_mail'],
	                    'username' => $row['u_name'],
	                    'userstatus' => $row['u_status']
	                ]
	            ];
	            $jwt = JWT::encode($token, KEY);
	            $data['result'] = 'success';
	            $data['jwt'] = $jwt;
	            $data['name'] = $row['u_name'];
	            $data['email'] = $row['u_mail'];
	            $data['userstatus'] = $row['u_status'];
	            $data['message'] = '登录成功！';
			}
		}
		if(!$success) {
			$data['result'] = 'false';
			$data['message'] = '邮箱或密码错误,请重新登录';
		}
		return $data;
	}
	
	 /*用户注册*/
	function register($email,$name, $pwd,$time) {
		//数据库查询
		$where_email = 'u_mail = "'.$email.'"';
		$where_name = 'u_name = "'.$name.'"';
		$result_email = get_sql('select','user','*',$where_email);
		$result_name = get_sql('select','user','*',$where_name);
		if(!$result_email || !$result_name) {
			$data['message'] = '数据库操作失败';
			return $data;
		}
		$check_email = $row=mysqli_fetch_array($result_email);
		$check_name = $row=mysqli_fetch_array($result_name);
	 	if ($check_email || $check_name) {
	 		if($check_email){
	 			$data['message'] = "邮箱已被注册";
	 			return $data;
		 	}
		 	if($check_name){
		 		$data['message'] = "用户名已被注册";
		 		return $data;
		 	}
		 } else {
		 	$data['set'] = '(u_id,u_name,u_mail,u_pwd,u_status,u_time)';
		 	$data['val'] = "(0,'".$name."','".$email."','".$pwd."','member','".$time."')";
		 	$result = get_sql('insert','user',$data);
		 	$data_total = 'total_user = total_user +1';
			$result_total = get_sql('update','webdata',$data_total);
		 	$data['message'] = "注册成功，请登录！";
		 	$data['result'] = 'success';
		 	return $data;
			}     
		
	}
			
	
	//显示所有用户
	function show_all_user() {
		$result = get_sql('select','user');
		if(!$result) {
			return;
		}
		$i = 0;
		while($row=mysqli_fetch_array($result)){
		 	$arr = array();
		 	$arr['id'] = $row[0];
			$arr['name'] = $row[1];
			$arr['email'] = $row[3];
			$arr['status'] = $row[4];
			$arr['time'] = $row[6];
		 	$aResult[$i] = $arr;
			$i++;
		}
		$data['data'] = $aResult;		
		$data['result'] = 'success';
		return $data;
	}