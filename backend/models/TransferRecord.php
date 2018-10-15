<?php
namespace backend\models;
use common\models\relations\TransferRecordRelations;

class TransferRecord extends \common\models\base\TransferRecord
{
    use TransferRecordRelations;


    /**
     *后台会员管理 - 会员详情 -  转卡记录列表
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/3/9
     * @param $id
     * @return bool|string
     */
    public function turnCardRecord($id)
    {
        $model = TransferRecord::find()
            ->alias('tr')
            ->joinWith(['member toMember'=>function($model){
                $model->joinWith(['memberDetails toMemberDetails']);
            }],false)
            ->joinWith(['memberS fromMember'=>function($model){
                $model->joinWith(['memberDetails fromMemberDetails']);
            }],false)
            ->joinWith(['memberCard memberCard'],false)
            ->joinWith(['employee employee'],false)
            ->select(
                "
                      tr.id,
                      tr.member_card_id,
                      tr.to_member_id,
                      tr.from_member_id,
                      tr.register_person,
                      toMemberDetails.name as toName,
                      fromMemberDetails.name as fromName,
                      toMember.mobile as toMobile,
                      fromMember.mobile as fromMobile,
                      memberCard.card_number,
                      tr.transfer_price,
                      tr.register_person,
                      employee.name,
                      tr.transfer_time,
               "
            )
            ->where(['or',['tr.to_member_id' => $id],['tr.from_member_id'=> $id]])
            ->orderBy('tr.id desc')
            ->asArray()
            ->all();
        return $model;
    }

}