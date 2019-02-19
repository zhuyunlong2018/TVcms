<?php
/**
 * Created by bianquan
 * CommonUser: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/19
 * Time: 20:40
 */

namespace app\blogApi\service;
use app\blogApi\model\Article as ArticleModel;
use app\lib\Response;

class Article
{
    public static function getList($tagID,$userID,$page,$limit) {
        $condition = [
        ];
        $order = ['a_id'=>'desc'];
        if(!empty($userID)) {
            $condition['user_id'] = $userID;
        }
        if(!empty($tagID)) {
            $condition['tag_id'] = $tagID;
        }
        $list = ArticleModel::getListByPage($condition,$order,$page,$limit);
        return new Response(['msg'=>'获取数据成功','data'=>$list]);
    }



}