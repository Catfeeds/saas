<?php
namespace backend\models;

use common\models\relations\BindPackRelations;

class BindPack extends \common\models\base\BindPack
{
    use BindPackRelations;
    /**
     * 云运动 - 会员管理 - 获取私课
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/9/28
     * @param  $param
     * @return array
     */
    public function getCourseTypeData($param)
    {
        return  BindPack::find()
            ->alias('bp')
            ->joinWith(['chargeClass chargeClass'],false)
            ->select("bp.*,ChargeClass.id as ChargeClassId,ChargeClass.name")
            ->where(['polymorphic_type'=>$param['courseType']])
            ->andWhere(['card_category_id'=>$param['cardCategoryId']])
            ->asArray()
            ->one();
    }
}