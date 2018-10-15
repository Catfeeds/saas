<?php
namespace backend\models;

use common\models\Func;
use common\models\relations\MatchingRecordRelations;

class MatchingRecord extends \common\models\base\MatchingRecord
{
    use MatchingRecordRelations;


    /**
     * 公共管理 - 匹配记录 - 匹配记录列表数据
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/2/2
     * @param $cardId
     * @return \yii\db\ActiveQuery
     */
    public function matchingRecordInfo($cardId)
    {
        $query = MatchingRecord::find()
            ->alias('mr')
            ->joinWith(['oldCardCategory oldCardCategory'],false)
            ->joinWith(['cardCategory cardCategory'],false)
            ->joinWith(['employee employee'],false)
            ->where(['oldCardCategory.id'=>$cardId])
            ->select("
            mr.id,
            mr.create_at,
            mr.note,
            mr.create_id,
            mr.status,
            mr.member_id,
            mr.attribute_matching,
            oldCardCategory.card_name as memberCardName,
            cardCategory.card_name,
            employee.name
            ")
            ->groupBy(["mr.id"])
            ->orderBy("mr.id DESC")
            ->asArray();
        $dataProvider          =  Func::getDataProvider($query,8);
        return  $dataProvider;
    }
    
}
