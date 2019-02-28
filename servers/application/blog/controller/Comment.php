<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/9
 * Time: 18:59
 */

namespace app\blog\controller;

use app\admin\model\WebData as WebDataModel;
use app\blog\model\Article;
use app\common\controller\BaseController;
use app\blog\model\Comment as CommentModel;
use app\lib\Response;

class Comment extends BaseController
{
    public function getByArticleID($id) {
        $list = CommentModel::getList($id);

        return new Response(['data'=>$list]);
    }

    public function add($articleID,$content,$user,$oldComment) {
        $result = CommentModel::create([
            'article_id' => $articleID,
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'content' => $content,
            'father_id' => $oldComment['fatherID'],
            'target_id' => $oldComment['targetID']
        ]);

        //添加统计数据
        if($articleID !=0) {
            $article = Article::get($articleID);
            $article->setInc('comment_num');
        }
        $data = WebDataModel::get(1);
        $data->setInc('comment_num');

        //邮件通知回复人

        return new Response(['data'=>$result]);
    }

}