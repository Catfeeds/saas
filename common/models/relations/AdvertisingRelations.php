<?php
/**
 * Created by PhpStorm.
 * User: 付钟超 <fuzhongchao@itsports.club>
 * Date: 2018/5/6 0006
 * Time: 10:24
 */

namespace common\models\relations;

use common\models\AdvertisingSetting;
use common\models\AdvertisingStatistics;

trait AdvertisingRelations
{
    /**
     * @desc: 业务后台 - 广告详情表 - 关联广告设置表
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return mixed
     */
    public function getAdvertisingSetting()
    {
        return $this->hasOne(AdvertisingSetting::className(), ['id' => 'setting_id']);
    }

    public function getAdvertisingStatistics()
    {
        return $this->hasMany(AdvertisingStatistics::className(), ['ad_id'=>'id']);
    }
}