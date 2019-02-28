<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/9
 * Time: 19:06
 */

namespace app\blog\model;


use app\common\model\BaseModel;

class Comment extends BaseModel
{

    public function reply() {
        return $this->hasMany('Comment','father_id','id');
    }

    public function target() {
        return $this->belongsTo('Comment','target_id','id');
    }

    public static function getList($articleID) {
        return self::with(['reply.target'])->where(['article_id'=>$articleID,'father_id'=>0])->select();
    }

}