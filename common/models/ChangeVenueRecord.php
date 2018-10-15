<?php
/**
 * Created by PhpStorm.
 * User: 付钟超 <fuzhongchao@itsports.club>
 * Date: 2018/5/25 0025
 * Time: 11:19
 * 调店记录模型(会员修改所属场馆)
 */


namespace common\models;

use common\models\relations\ChangeVenueRecordRelations;

class ChangeVenueRecord extends \common\models\base\ChangeVenueRecord
{
    use ChangeVenueRecordRelations;

    /**
     * @desc: 业务后台 - 获取修改场馆数据
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/26
     * @param $memberId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function changeVenueData($memberId)
    {
        $data = ChangeVenueRecord::find()
            ->alias('cvr')
            ->joinWith(['oldOrganization old'],false)
            ->joinWith(['newOrganization new'],false)
            ->joinWith(['employee employee'],false)
            ->where(['public_id'=>$memberId,'type'=>1])
            ->orderBy('cvr.id desc')
            ->select(['cvr.id',
                'cvr.public_id',
                'cvr.type',
                'cvr.old_venue_id',
                'cvr.new_venue_id',
                'cvr.create_id',
                'cvr.note',
                'FROM_UNIXTIME(cvr.create_at,\'%Y-%m-%d\') AS create_date',
                'old.name as oldVenue',
                'new.name as newVenue',
                'employee.name as employeeName'])
            ->asArray()->all();
        return $data;
    }

}