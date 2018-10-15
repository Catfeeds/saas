<?php
/**
 * Created by PhpStorm.
 * User: 付钟超 <fuzhongchao@itsports.club>
 * Date: 2018/5/6 0006
 * Time: 17:19
 */

namespace common\models\relations;

use common\models\Organization;

trait AdvertisingStatisticsRelations
{
    /**
     * @desc: 业务后台 - 广告访问记录 - 关联组织表获取场馆
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return mixed
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(),['id'=>'venue_id']);
    }
}