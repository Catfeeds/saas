<?php
namespace backend\models;

use yii\base\Model;
use common\models\Excel;
use common\models\base\MemberCard;

class TimeExcel extends Model
{
    const  ANOTHER_PARAMETER = ['memberCardId','name'];
    const               INFO = [0=>'memberCardId',1=>'name'];

    public $memberId;
    public $memberName;

    public function autoLoadData($data){
        $data = array_values($data);
        $dataS = self::ANOTHER_PARAMETER;
        foreach($data as $keys=>$value){
            $key        = $dataS[$keys];
            $this->$key = $value;
        }
    }
    
    public function loadFile($file)
    {
        $model = new Excel();
        $data  = $model->loadTimeFile($file);           //excel表数据
        $num = 0;
        foreach($data as $k=>$v){
            $memberCard = MemberCard::find()->where(['card_number'=>$v[0]])->asArray()->one();
            $theCard = MemberCard::findOne(['card_number'=>$v[0]]);
            $theCard->active_time  = 1329148800;
            $theCard->create_at    = 1329148800;
            $theCard->invalid_time = 253392422400;
            $theCard->save();
            $num++;
            echo $num;
        }
        
    }
    
    
}
