<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/18
 * Time: 19:27
 */

namespace app\blog\controller;


use app\common\controller\BaseController;
use app\blog\model\Tags as TagsModel;
use app\lib\Response;

class Tags extends BaseController
{
    public function getList() {
        $tags = TagsModel::all();
        return new Response(['data'=>$tags]);
    }

}