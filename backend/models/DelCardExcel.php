<?php
namespace backend\models;

use yii\base\Model;
use common\models\Excel;
use common\models\base\Member;
use common\models\base\MemberDetails;
use common\models\base\MemberCard;
use common\models\base\MemberCourseOrder;
use common\models\base\ConsumptionHistory;

class DelCardExcel extends Model
{
    const  ANOTHER_PARAMETER = ['memberId','memberName'];
    const               INFO = [0=>'memberId',1=>'memberName'];

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
        $data  = $model->loadDelCardFile($file);           //excel表数据
        $num = 0;
        foreach($data as $k=>$v){
            //1、删除会员卡
            $memberCard = MemberCard::findOne(['card_number'=>20700680]);
            if($memberCard){
                $memberCard->delete();
            }
            //2、删除消费记录
            $consumptionHistory = ConsumptionHistory::findOne(['member_id'=>48624,'consumption_amount'=>5098]);
            if($consumptionHistory){
                $consumptionHistory->delete();
            }
            $num++;
            echo $num;
        }
    }
}