<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/8/18
 * Time: 10:21
 */

namespace backend\models;


use common\models\relations\SendRecordRelations;

class SendRecord  extends \common\models\base\SendRecord
{
   use SendRecordRelations;

    /**
     *后台会员管理 - 会员详情 - 信息记录里的行为记录
     * @author lihuien <lihuien@itsports.club>
     * @param $memberId
     * @create 2017/3/30
     * @return bool|string
     */
    public function getMemberSendRecord($memberId)
    {
        return self::find()->alias('sr')
            ->joinWith(['coverMember cm'=>function($query) {
                $query->joinWith(['memberDetails md']);
            }],false)
            ->joinWith(['memberCard mc'],false)
            ->select('
                sr.id,
                sr.member_id,
                sr.member_card_id,
                sr.cover_member_id,
                mc.card_number,
                mc.card_name,
                sr.send_time,
                md.name,
                cm.username
            ')
            ->where(['sr.member_id'=>$memberId])
            ->asArray()
            ->all();
    }
}