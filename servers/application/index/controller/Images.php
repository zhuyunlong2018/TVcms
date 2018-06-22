<?php
namespace app\index\controller;
use think\Controller;


class Images extends Controller
{

	public function _initialize() {
	}
 
	/*上传图片*/
	public function updata_imgs($imgs,$imgs_name) {
		$request = request();
		$post = $request->post();
		$imgs = $post['imgs'];
		$imgs_name = $post['imgs_name'];
       	$i = 0;//记录图片数量
       	$images=[];//用于存储图片在数据库的地址
        foreach($imgs as $v){
        	$name = iconv('utf-8','gb2312',$imgs_name[$i]);
        	//移除编码前面可能存在的逗号
            $base64_img =ltrim(trim($v), ",") ;
            //var_dump($base64_img);
			//匹配出图片的格式
			if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)) {

			$new_file = ROOT_PATH ."../static/imgs/".date('Ymd',time())."/";
				if(!file_exists($new_file)) {
				//检查是否有该文件夹，如果没有就创建，并给予最高权限
				mkdir($new_file, 0700);
				}
				$new_file = $new_file.$name;
				if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)))){
					//返回图片的地址
					$images[$i] = iconv('gb2312','utf-8',ltrim($new_file,'C:\wamp\www\bianquan\servers'));
					$result = model('Images')->add_imgs($images[$i]);
					$i++;
					$data['result'] = 'success';
				}else{
				$data['message'] = '新文件保存失败';
				$data['result'] = 'false';
				}
			}
		}
		$data['images'] = $images;
		return $data;
	}

	/*获取所有图片地址*/
	public function get_all_imgs() {
		 $result = model('Images')->get_all_imgs();
		 if($result) {
		 	return $result;
		 }
	}
	/*删除图片*/
	public function del_img() {
		$result = false;
		$url = input('url.i_src');
		$new_url = iconv('utf-8','gb2312',$url);
		// $new_url = str_replace("../..","all_images",$new_url);
		$new_url = ROOT_PATH .$new_url;
		if(file_exists($new_url)) {
			$del = unlink($new_url);
			if($del) {
				$result = model('Images')->del_img($url);
			}
		}
		 if($result) {
		 	return $result;
		 }
	}










}

