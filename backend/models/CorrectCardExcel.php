<?php
namespace backend\models;

use yii\base\Model;
use common\models\Excel;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\ConsumptionHistory;
use common\models\base\Order;

class CorrectCardExcel extends Model
{
    const  ANOTHER_PARAMETER = ['cardNumber','memberName'];
    const               INFO = [0=>'cardNumber',1=>'memberName'];

    public $cardNumber;
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
        $data  = $model->loadCorrectCardFile($file);           //excel表数据
        $num = 0;
        foreach($data as $k=>$v){
            $memberCard = MemberCard::findOne(['member_id'=>62225]);
            $memberCard->card_category_id = 660;
            $memberCard->amount_money     = 12000;
            $memberCard->card_name        = 'BlackCard60尊爵';
            $memberCard->save();
            $consumption = ConsumptionHistory::findOne(['member_id'=>62225]);
            $consumption->cash_payment        = 12000;
            $consumption->consumption_amount  = 12000;
            $consumption->save();
            $order = Order::findOne(['member_id'=>62225]);
            $order->total_price = 12000;
            $order->card_name   = 'BlackCard60尊爵';
            $order->net_price   = 12000;
            $order->all_price   = 12000;
            $order->save();
            $num++;
            echo $num;
        }
        
    }
    
    
}