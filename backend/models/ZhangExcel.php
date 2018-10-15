<?php
namespace backend\models;

use common\models\base\ConsumptionHistory;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\Excel;
use yii\base\Model;


class ZhangExcel extends Model
{
    const ANOTHER_PARAMETER = ['memberId','name'];
    const INFO              = [0=>'memberId',1=>'name'];

    public $memberId;
    public $name;

    public function autoLoadData($data){
        $data  = array_values($data);
        $dataS = self::ANOTHER_PARAMETER;
        foreach($data as $keys=>$value){
            $key        = $dataS[$keys];
            $this->$key = $value;
        }
    }
    
    public function LoadFile($file)
    {
        $model = new Excel();
        $data  = $model->loadZhangFile($file);           //excel表数据
        $num = 0;
        foreach($data as $k=>$v){
            //1、修复id=13523的张莹的会员信息：公司、场馆
            $member = Member::findOne(['id'=>13523]);
            if($member){
                $member->company_id = 1;
                $member->venue_id   = 2;
                $member->save();
            }
            $card1 = MemberCard::findOne(['id'=>653]);
            if($card1){
                $card1->member_id = 13523;
                $card1->save();
            }
            $card2 = MemberCard::findOne(['id'=>24148]);
            if($card2){
                $card2->member_id = 13523;
                $card2->create_at = 1392480000;
                $card2->invalid_time = 1489766400;
                $card2->payment_time = 1385568000;
                $card2->save();
            }
            $consumption = ConsumptionHistory::findOne(['id'=>55200]);
            if($consumption){
                $consumption->member_id = 13523;
                $consumption->consumption_type_id = 24148;
                $consumption->consumption_date = 1385568000;
                $consumption->bank_card_payment = 2098;
                $consumption->consumption_amount = 2098;
                $consumption->save();
            }
            $num++;
            echo $num;
        }
    }
    
    
}