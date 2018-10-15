<?php
/**
 * 卡种折扣类
 * User: lihuien
 * Date: 2017/9/16
 * Time: 11:13
 */
namespace backend\models;

class CardDiscount extends \common\models\base\CardDiscount
{
    /**
     * 业务后台 - 卡种 - 折扣
     * @param $limitId
     * @return array|null|\yii\db\ActiveRecord
     */
      public function getCardDiscount($limitId)
      {
          return  CardDiscount::find()->where(['limit_card_id'=>$limitId])->asArray()->all();
      }
}