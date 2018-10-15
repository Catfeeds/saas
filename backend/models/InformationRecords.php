<?php
namespace backend\models;
use common\models\relations\InformationRecordsRelations;
use common\models\Func;
use Yii;
class InformationRecords extends \common\models\InformationRecords
{
    use InformationRecordsRelations;
    /**
     * 后台会员管理 - 会员信息查询 - 多表查询
     * @author Huang hua <huanghua@itsports.club>
     * @param $id
     * @create 2017/8/5
     * @return \yii\db\ActiveQuery
     */
    public function getMemberInfo($id)
    {
        $model = InformationRecords::find()
            ->alias('ir')
            ->joinWith(['member member'],false)
            ->joinWith(['memberCard memberCard'],false)
            ->select(
                "     ir.id,
                      ir.member_id,
                      ir.member_card_id,
                      ir.behavior,
                      ir.note,
                      ir.create_at,
                      member.id as memberId,
                      memberCard.id as memberCardId
                      "
            )
            ->where(['ir.member_id' => $id])
            ->orderBy('ir.id desc')
            ->asArray();
        $dataProvider              =  Func::getDataProvider($model,8);
        return $dataProvider;

    }

    /**
     * 潜在会员 - 赠卡信息记录 - 信息记录里的行为记录
     * @author Huang hua <huanghua@itsports.club>
     * @param $id
     * @create 2018/3/16
     * @return  array
     */
    public function getInformationData($id)
    {
        $model = InformationRecords::find()
            ->alias('ir')
            ->joinWith(['memberCard memberCard'],false)
            ->joinWith(['employee employee'],false)
            ->select(
                "     
                      ir.id,
                      ir.member_id,
                      ir.member_card_id,
                      ir.behavior,
                      ir.note,
                      ir.create_at,
                      ir.create_id,
                      ir.old_time,
                      ir.new_time,
                      memberCard.card_number,
                      employee.name,
                      "
            )
            ->where(['and',['ir.member_id' => $id],['ir.behavior' => [4,5]]])
            ->orderBy('ir.id desc')
            ->asArray()
            ->all();
        return $model;

    }
}