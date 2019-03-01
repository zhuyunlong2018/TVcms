<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/18
 * Time: 20:21
 */

namespace app\admin\controller;
use app\admin\model\WebData as WebDataModel;
use app\lib\Response;

class WebData extends  BaseController
{
    /**
     * @Api(获取网站统计信息,1,GET)
     */
    public function getData() {
        $data = WebDataModel::get(1);
        return new Response(['data'=>$data]);
    }

}