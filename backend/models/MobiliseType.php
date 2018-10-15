<?php
namespace backend\models;

class MobiliseType extends \common\models\base\MobiliseType
{
    /**
     * 后台仓库管理 - 调拨列表 - 是否批准状态修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/1
     * @param $id
     * @return bool
     */
    public static function getUpdateMobiliseType($id)
    {
        $status  =  MobiliseType::findOne($id);
        if($status->type == 1){
            $status->type = 2;
            $status->update_at = time();
        }
        if($status->save()){
            return true;
        }else{
            return $status->errors;
        }
    }
}