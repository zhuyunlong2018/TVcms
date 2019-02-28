<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/18
 * Time: 21:07
 */

namespace app\blog\controller;

use app\admin\model\WebData as WebDataModel;
use app\common\controller\BaseController;
use app\lib\exception\RepeatException;
use app\lib\Response;
use app\blog\model\Article;
use think\Cache;
use think\Request;

class WebData extends BaseController
{
    public function addPraise($id) {
        $request = Request::instance();
        $ip = $request->ip();
        $key = $ip.'_'.$id;
        $check = Cache::get($key);
        if($check) {
            throw new RepeatException('同一篇文章，一天只能点赞一次哦');
        }
        Cache::set($key,60*60*24);
        if($id !=0) {
            $article = Article::get($id);
            $article->setInc('praise_num');
        }
        $data = WebDataModel::get(1);
        $data->setInc('praise_num');
        return new Response();
    }
}