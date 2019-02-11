<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/9
 * Time: 18:59
 */

namespace app\blogApi\controller;


use app\common\controller\BaseController;
use app\blogApi\model\Comment as CommentModel;
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
        return new Response(['data'=>$result]);
    }

}