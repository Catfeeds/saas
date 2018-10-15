<?php
namespace backend\models;

use common\models\base\ConsumptionHistory;
use common\models\base\MemberCard;
use yii\base\Model;
use common\models\Excel;

class ExcelCorrectTime extends Model
{
    public function loadFile($file)
    {
        $model = new Excel();
        $data = $model->loadCorrectTimeFile($file);
        $num = 0;
        foreach ($data as $k => $v) {
            $memberCard = MemberCard::findOne(['card_number'=>$v[0]]);
            if($memberCard){
                //需要改动的地方：1、会员卡  2、消费记录
                $memberCard->create_at = $v[3];
                $memberCard->active_time = $v[5];
                if(!$memberCard->save()){
                    return $memberCard->errors;
                }
                $consumption = ConsumptionHistory::findOne(['consumption_type_id'=>$memberCard->id,'category'=>'购卡']);
                if($consumption){
                    $consumption->consumption_date = $v[3];
                    if(!$consumption->save()){
                        return $consumption->errors;
                    }
                }
            }
            $num++;
            echo $num.'->';
        }
    }
}