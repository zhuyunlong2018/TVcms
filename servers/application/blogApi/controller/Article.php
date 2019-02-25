<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/19
 * Time: 20:29
 */

namespace app\blogApi\controller;
use app\adminApi\service\Images;
use app\adminApi\service\User;
use app\adminApi\model\ImagesSource;
use app\blogApi\service\Article as ArticleService;
use app\common\controller\BaseController;
use app\common\validate\PagingParameter;
use app\blogApi\model\Article as ArticleModel;
use app\lib\exception\AuthException;
use app\lib\exception\ResourcesException;
use app\lib\Response;

class Article extends BaseController
{
    public function getList($tagID,$userID,$page,$limit)
    {
        (new PagingParameter())->goCheck();
        $list = ArticleService::getList($tagID,$userID,$page,$limit);
        return new Response(['data'=>$list]);
    }

    public function getOne($ID) {
        $article = ArticleModel::getOne(['a_id'=>$ID]);
        if($article) {
            $articleImages = ImagesSource::all(['table_name'=>'article','table_id'=>$ID],'image');
            $images = [];
            foreach ($articleImages as $articleImage) {
                $images[] = $articleImage['image'];
            }
            $article->images = $images;
            return new Response(['data'=>$article]);
        } else {
            throw new ResourcesException(['msg'=>'找不到对应文章']);
        }
    }

    public function getAllPublished() {
        $articles = ArticleModel::all(['published'=>1,'status'=>1]);
        if(empty($articles)) {
            throw new ResourcesException();
        }
        return new Response(['data'=>$articles]);
    }

    public function getTitleList() {
        $user = User::init();
        $condition = [
            'user_id' => $user['user_id'],
            'status' => 1
        ];
        $field = 'a_id,a_title,published,create_time';
        $list = ArticleModel::getTitleList($condition,$field);
        return new Response(['data'=>$list]);
    }

    public function getTitleListByPage($title,$author,$tag,$page,$limit,$sort='create_time',$order='desc') {
        $list = ArticleService::getTitleList($title,$author,$tag,$page,$limit,$sort,$order);
        return new Response(['data'=>$list]);
    }

    public function changeStatus($id,$status) {
        $article = ArticleModel::get($id);
        if(empty($article)) {
            throw new ResourcesException();
        }
        $article->status = $status;
        $article->save();
        return new Response();
    }

    public function changePublish($id) {
        $article = ArticleModel::get($id);
        if(empty($article)) {
            throw new ResourcesException();
        }
        $user = User::init();
        if($article->user_id != $user['user_id']) {
            throw new AuthException();
        }
        if($article->published) {
            $article->published = 0;
        } else {
            $article->published = 1;
        }
        $article->save();
        return new Response(['data'=>$article->published]);
    }

    public function del($id) {
        $article = ArticleModel::get($id);
        if(empty($article)) {
            throw new ResourcesException();
        }
        $user = User::init();
        if($article->user_id != $user['user_id']) {
            throw new AuthException();
        }
        $article->delete();
        return new Response();
    }

    public function add($a_title,$outline='',$a_content,$a_img=0,$tag_id,$imgs=[]) {
        $user = User::init();
        $article = ArticleModel::create([
            'a_title' =>$a_title,
            'a_content' =>$a_content,
            'outline' => $outline,
            'a_img' => $a_img,
            'tag_id' => $tag_id,
            'user_id' =>$user['user_id']
        ]);
        if(!$article) {
            throw new ResourcesException();
        }
        Images::addImages($imgs,$article->a_id,'article');
        return new Response();
    }

    public function update($a_id,$a_title,$outline='',$a_img=0,$a_content,$tag_id,$imgs=[]) {
        $article = ArticleModel::get($a_id);
        if(empty($article)) {
            throw new ResourcesException();
        }
        $user = User::init();
        if($article->user_id != $user['user_id']) {
            throw new AuthException();
        }
        $article->a_title = $a_title;
        $article->a_content = $a_content;
        $article->outline = $outline;
        $article->a_img = $a_img;
        $article->tag_id = $tag_id;
        $article->save();
        Images::addImages($imgs,$article->a_id,'article');
        return new Response();
    }

    public function getBing() {
        $str = file_get_contents('http://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1');
        $array = json_decode($str);
        $imgUrl = $array->{"images"}[0]->{"url"};
        $imgUrl = 'https://cn.bing.com'.$imgUrl;
        return new Response(['data'=>$imgUrl]);
    }

}