<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/1/19
 * Time: 21:50
 */

namespace app\blog\model;


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

    public function imagesSource() {
        return $this->hasMany('ImagesSource','table_id','a_id')
            ->where('table_name','article');
    }


    public static function getListByPage($condition,$order,$page, $limit){
        return self::with(['tag','user'=>function($query) {
                    $query->field('user_id,user_name');
                }])
                ->field('a_content',true)
                ->where($condition)->order($order)->paginate($limit, false, ['page' => $page]);
    }

    public static function getTitleListByPage($condition,$page,$limit,$order) {
        return self::alias('a')
            ->join('user u','a.user_id=u.user_id')
            ->join('tags t','a.tag_id=t.tag_id')
            ->where($condition)
            ->order($order)
            ->field('a_id,a_title,a.create_time,status,user_name,tag_name')
//            ->fetchSql()
            ->paginate($limit,false,['page'=>$page]);
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