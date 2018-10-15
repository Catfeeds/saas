<?php
namespace backend\models;

use common\models\relations\ExtensionRecordRelations;
class ExtensionRecord extends \common\models\base\ExtensionRecord
{
    use ExtensionRecordRelations;
    /**
     *后台会员管理 - 私课延期 -  私课延期记录查询
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/10/13
     * @return bool|string
     */
    public function ExtensionRecordData($memberId)
    {
        $model = ExtensionRecord::find()
            ->alias('er')
            ->joinWith(['employee employee'])
            ->where(['er.member_id' => $memberId])
            ->orderBy('er.id desc')
            ->asArray()
            ->all();
        return $model;
    }

    /**
     * @desc: 业务后台 - 会员私教课 - 私教延期记录
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/03/14
     * @param $memberId
     * @param $course_order_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function courseDelayRecord($memberId,$course_order_id)
    {
        $data = ExtensionRecord::find()
            ->alias('er')
            ->joinWith(['employee employee'],false)
            ->orderBy('er.id desc')
            ->where([
                'and',
                ['course_order_id'=>$course_order_id],
                ['member_id'=>$memberId]
            ])
            ->select("er.*,employee.name")
            ->asArray()->all();
        return $data;
    }
}