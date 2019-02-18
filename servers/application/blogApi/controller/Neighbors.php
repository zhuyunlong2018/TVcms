<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/18
 * Time: 19:58
 */

namespace app\blogApi\controller;

use app\blogApi\model\Neighbors as NeighborsModel;
use app\common\controller\BaseController;
use app\lib\Response;

class Neighbors extends BaseController
{
    public function getList($userID=1) {
        $neighbors = NeighborsModel::all(['user_id'=>$userID]);
        return new Response(['data'=>$neighbors]);
    }
}