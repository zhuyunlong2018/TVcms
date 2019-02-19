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

    public function user() {
        return $this->belongsTo('user','user_id','user_id');
    }
    public function tag() {
        return $this->belongsTo('tags','tag_id','tag_id');
    }
    public static function getListByPage($condition,$order,$page, $limit){
        $pagingData = self::with(['tag','user'=>function($query) {
            $query->field('user_id,user_name');
            }])
            ->where($condition)->order($order)->paginate($limit, false, ['page' => $page]);
        return $pagingData ;
    }

    public static function getOne($condition) {
        return self::with(['tag','user'=>function($query) {
            $query->field('user_id,user_name');
        }])
            ->where($condition)->find();
    }

    public static function getTitleList($condition,$field) {
        return self::where($condition)->field($field)->order('a_id desc')->select();
    }
}