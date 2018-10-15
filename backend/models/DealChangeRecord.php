<?php
namespace backend\models;
use Yii;

class DealChangeRecord extends \common\models\DealChangeRecord
{
    /**
     * 后台 - 合同管理 - 单个合同详情
     * @author huanghua <huanghua@itsports.club>
     * @create 2018/5/15
     * @param $id
     * @return array //查询结构
     */
    public static function getDealOne($id)
    {
        return DealChangeRecord::find()
            ->joinWith(['dealType dealType'])
            ->where(['cloud_deal_change_record.id'=>$id])->asArray()->one();
    }

    /**
     * 后台 - 合同管理 - 单个合同变更记录
     * @author huanghua <huanghua@itsports.club>
     * @create 2018/5/15
     * @param $dealId
     * @return array //查询结构
     */
    public static function getChangeDealAll($dealId)
    {
        return DealChangeRecord::find()
            ->alias('dcr')
            ->joinWith(['dealType dealType'])
            ->where(['dcr.deal_id'=>$dealId])->orderBy("id DESC")->asArray()->all();
    }
}