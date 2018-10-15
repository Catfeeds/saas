<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/4/19
 * Time: 16:52
 */
namespace backend\models;

class ServicePay extends \common\models\base\ServicePay
{
    /**
     * 云运动 - 卡种管理  - 获取商品 赠品
     * @author lihuien<lihuien@itsports.club>
     * @param $bool
     * @param $venueId
     * @return array|\yii\db\ActiveRecord[]
     */
     public function getServicePayData($bool,$venueId)
     {
         if($bool){
             $pay = Goods::find()->where(['venue_id'=>$venueId])->asArray()->all();
         }else{
             $pay = Goods::find()->where(['venue_id'=>$venueId])->asArray()->all();
         }
         return $pay;
     }
}