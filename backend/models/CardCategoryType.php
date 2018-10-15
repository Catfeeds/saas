<?php
namespace backend\models;

class CardCategoryType extends \common\models\base\CardCategoryType
{
    /**
     * 云运动 - 卡种 - 获取卡种类别
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/24
     */
    public function getCardType()
    {
        $type = CardCategoryType::find()
            ->alias('cc')
            ->select('cc.id,cc.type_name')
            ->asArray()
            ->all();
        return $type;
    }
}