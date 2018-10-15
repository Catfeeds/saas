<?php
namespace backend\models;

use common\models\base\CardCategory;
use common\models\base\ConsumptionHistory;
use common\models\base\Employee;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\MemberDetails;
use common\models\base\Organization;
use common\models\base\VenueLimitTimes;
use common\models\Excel;
use yii\base\Model;

class ExcelDayOff extends Model
{

    public function LoadFile($file)
    {
        $model = new Excel();
        $data = $model->loadXiaoFei($file);
        $num = 0;
        foreach ($data as $k => $v) {
            $card = MemberCard::findOne(['card_number'=>$v[1]]);
            if($card){
                $cardCategory = CardCategory::findOne(['id'=>$card->card_category_id]);
                if($cardCategory){
                    $card->leave_days_times = $cardCategory->leave_long_limit;
                    if(!$card->save()){
                        return $card->errors;
                    }
                }
            }
            $num++;
            echo $num.'->';
        }
    }
}