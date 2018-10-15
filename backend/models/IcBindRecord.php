<?php
namespace backend\models;

use common\models\base\IcBindingRecord;

class IcBindRecord extends \common\models\IcBindRecord
{

    /**
     * 正式会员 - 会员详情 - 信息记录里的ic卡绑定记录
     * @author Huang hua <huanghua@itsports.club>
     * @param $id
     * @create 2018/4/23
     * @return  array
     */
    public function icBindRecordInfo($id)
    {
        $model = IcBindRecord::find()
            ->alias('ibr')
            ->joinWith(['employee employee'],false)
            ->select(
                "
                      ibr.*,
                      employee.name,
                "
            )
            ->where(['ibr.member_id' => $id])
            ->orderBy('ibr.id desc')
            ->asArray()
            ->all();
        return $model;

    }

    /**
     * 后台会员管理 - IC卡 - 解除绑定
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/3/23
     * @param $memberId  //会员id
     * @return bool
     */
    public function delIcData($memberId)
    {
        $icBind = IcBindingRecord::findOne(['member_id' => $memberId,'status'=>1]);
        if(!empty($icBind)){
            $icBind->status = 2;
            $icBind->unbundling = time();
        }else{
            return "该会员没有绑定IC卡,无需解绑!";
        }
        if($icBind->save()){
            return true;
        }else{
            return $icBind->errors;
        }
    }
}