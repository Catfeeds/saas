<?php

namespace common\models;

class Deal extends \common\models\base\Deal
{
    /**
     * 运运动-关联场馆
     * @author 杨慧磊<yanghuilei@itsport.club>
     * @createAt 2018/3/22
     * @return \yii\db\ActiveQuery
     */
    public function getVenues()
    {
        return $this->hasOne(Organization::className(), ['id' => 'venue_id']);
    }
}