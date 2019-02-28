<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/18
 * Time: 19:58
 */

namespace app\blog\controller;

use app\blog\model\Neighbors as NeighborsModel;
use app\common\controller\BaseController;
use app\lib\exception\ResourcesException;
use app\lib\Response;

class Neighbors extends BaseController
{
    public function getList($userID=1) {
        $neighbors = NeighborsModel::all(['user_id'=>$userID]);
        return new Response(['data'=>$neighbors]);
    }

    public function getAll() {
        $neighbors = NeighborsModel::all();
        return new Response(['data'=>$neighbors]);
    }

    public function add($nb_name,$nb_url,$nb_icon,$nb_published,$user_id) {
        $result = NeighborsModel::create([
            'nb_name' =>$nb_name,
            'nb_url' => $nb_url,
            'nb_icon' => $nb_icon,
            'nb_published' => $nb_published,
            'user_id' => $user_id
        ]);
        return new Response(['data'=>$result]);
    }

    public function update($nb_id,$nb_name,$nb_url,$nb_icon,$nb_published,$user_id) {
        $neighbor = NeighborsModel::get($nb_id);
        if (empty($neighbor)) {
            throw new ResourcesException();
        }
        $neighbor->nb_name = $nb_name;
        $neighbor->nb_url = $nb_url;
        $neighbor->nb_icon = $nb_icon;
        $neighbor->nb_published = $nb_published;
        $neighbor->user_id = $user_id;
        $neighbor->save();
        return new Response(['data'=>$neighbor]);
    }

    public function del($id) {
        $neighbor = NeighborsModel::get($id);
        if (empty($neighbor)) {
            throw new ResourcesException();
        }
        $neighbor->delete();
        return new Response();
    }
}