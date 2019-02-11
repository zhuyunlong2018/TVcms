<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/19
 * Time: 21:50
 */

namespace app\blogApi\model;


use app\common\model\BaseModel;

class Article extends BaseModel
{
    protected $hidden = ['delete_time'];

    public static function getListByPage($condition,$order,$page, $limit){
        $pagingData = self::where($condition)->order($order)->paginate($limit, false, ['page' => $page]);
        return $pagingData ;
    }

    public static function getOne($condition) {
        return self::where($condition)->find();
    }
}