<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/17
 * Time: 14:24
 */

namespace app\blog\controller;


use app\common\model\BaseModel;
use app\blog\model\About as AboutModel;
use app\lib\exception\ResourcesException;
use app\lib\Response;

class About extends BaseModel
{
    public function getOne($user_id) {
        $about = AboutModel::get(['user_id'=>$user_id]);
        if(empty($about)) {
            throw new ResourcesException();
        }
        return new Response(['data'=>$about]);
    }
}