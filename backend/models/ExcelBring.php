<?php
namespace backend\models;

use common\models\base\CardCategory;
use common\models\base\MemberCard;
use common\models\Excel;
use yii\base\Model;


class ExcelBring extends Model
{

    public function LoadFile($file)
    {
        $model = new Excel();
        $data = $model->loadBringFile($file);
        $num = 0;
        foreach ($data as $k => $v) {
           $memberCard = MemberCard::findOne(['card_number'=>$v[0]]);
            if($memberCard){
                $memberCard->bring = 3;
                $memberCard->save();
            }
            $num++;
            echo $num.'->';
        }
    }

}