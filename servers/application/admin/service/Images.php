<?php
/**
 * Created by bianquan
 * User: ZhuYunlong
 * Email: 920200256@qq.com
 * Date: 2019/2/23
 * Time: 17:57
 */

namespace app\admin\service;
use app\admin\model\Images as ImagesModel;
use app\admin\model\ImagesSource;

class Images
{
    public static function addImages($images,$tableID,$tableName) {
        if(empty($images)) {
            return false;
        }
        $data = [];
        $user = User::init();
        $path = myConfig('path.'.$tableName,$user['user_id']);
        foreach ($images as $img) {
            $data[] = [
                'image' => $img,
                'path' => $path,
                'user_id' => $user['user_id'],
                'used' =>1
            ];
        }
        $imagesModel = new ImagesModel();
        $saveImages = $imagesModel->saveAll($data);

        $data = [];
        foreach ($saveImages as $key=>$saveImage) {
            $data[] = [
                'image_id' => $saveImage->id,
                'table_id' => $tableID,
                'table_name' => $tableName
            ];
        }
        return (new ImagesSource())->saveAll($data);
    }

}