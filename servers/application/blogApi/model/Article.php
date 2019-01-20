<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/19
 * Time: 21:50
 */

namespace app\blogApi\model;


use app\common\model\CommonArticle;

class Article extends CommonArticle
{
    public static function getOne($condition) {
        return self::where($condition)->find();
    }
}