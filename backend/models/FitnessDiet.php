<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/25 0025
 * Time: 上午 9:46
 */
namespace backend\models;
class FitnessDiet extends \common\models\base\FitnessDiet
{
    /**
     * 云运动 - 会员维护 - 获取健身目标、饮食计划数据列表
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/25
     * @return array
     */
    public function getFitnessData($type,$nowType,$nowId)
    {
        if(isset($type)){
            $data = FitnessDiet::find()->alias('fd')->where(['fd.type' => intval($type)])->asArray();
        }else{
            $data = FitnessDiet::find()->alias('fd')->asArray();
        }
        if($nowType && $nowType == 'company'){
            $data->andFilterWhere(['fd.company_id' => $nowId]);
        }
        if($nowType && $nowType == 'venue'){
            $data->andFilterWhere(['fd.venue_id' => $nowId]);
        }
        return $data->all();
    }

    /**
     * 云运动 - 会员维护 - 获取某一个健身目标、饮食计划数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/27
     * @return array
     */
    public function getFitnessOne($fitDietId)
    {
        return FitnessDiet::find()->where(['id' => $fitDietId])->asArray()->one();
    }
}