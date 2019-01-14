<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/14
 * Time: 22:20
 */

namespace app\adminApi\model;


class Article extends BaseModel
{
    protected $hidden = ['delete_time'];
    public static function getListByPage($condition,$order,$page, $limit){
        $pagingData = self::where($condition)->order($order)->paginate($limit, false, ['page' => $page]);
        return $pagingData ;
    }
}