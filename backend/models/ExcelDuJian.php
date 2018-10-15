<?php
namespace backend\models;
use common\models\base\CardCategory;
use common\models\base\ConsumptionHistory;
use common\models\base\Employee;
use common\models\base\Member;
use common\models\base\Organization;
use yii\base\Model;
use common\models\Excel;
use common\models\base\MemberCard;
use Yii;

class ExcelDuJian extends Model
{
    public function loadFile($file)
    {
        $model = new Excel();
        $data = $model->loadDuJianFile($file);
        $num = 0;
        foreach ($data as $k => $v) {
            $member  = Member::findOne(['mobile' => $v[2]]);
            $venueId = $member->venue_id;
            if($member){
                $memberId = $member->id;
                if($v[5] == '发卡'){
                    $memberCard = MemberCard::findOne(['card_number'=>$v[0]]);
                    if(!$memberCard){
                        //1、给杜剑发两年卡：大学路舞蹈馆
                        $memberCard = new MemberCard();
                        $memberCard->card_number = $v[0];
                        $memberCard->create_at    = $v[8];
                        $memberCard->amount_money = $v[6];
                        $memberCard->status = 2;
                        $memberCard->active_time = $v[9];
                        $memberCard->payment_type = 1;
                        $memberCard->is_complete_pay = 1;
                        $memberCard->invalid_time = $v[10];
                        $memberCard->level = 1;
                        $cardCategoryId = $this->getCardCategoryId($v[4],$venueId);
                        $memberCard->card_category_id = $cardCategoryId;
                        $memberCard->member_id = $memberId;
                        $memberCard->payment_time = $v[8];
                        $memberCard->consume_status = 2;
                        $employeeId = $this->getEmployeeId($v[7],$venueId);
                        $memberCard->employee_id = $employeeId;
                        $memberCard->card_name = '两年卡';
                        $memberCard->card_type = 1;
                        $memberCard->company_id = 1;
                        $memberCard->venue_id = $venueId;
                        $memberCard->recent_freeze_reason = 2;
                        if(!$memberCard->save()){
                            return $memberCard->errors;
                        }
                        //2、购卡消费记录
                        $consumption = new ConsumptionHistory();
                        $consumption->member_id = $memberId;
                        $consumption->consumption_type = 'card';
                        $consumption->consumption_type_id = $memberCard->id;
                        $consumption->type = 1;
                        $consumption->consumption_date = $v[8];
                        $consumption->consumption_time = $v[8];
                        $consumption->consumption_times = 1;
                        $consumption->bank_card_payment = $v[6];
                        $consumption->venue_id = $venueId;
                        $employeeId = $this->getEmployeeId($v[7],$venueId);
                        $consumption->seller_id = $employeeId;
                        $consumption->category = '发卡';
                        $consumption->company_id = 1;
                        $consumption->consumption_amount = $v[6];
                        $consumption->due_date = $v[10];
                        if(!$consumption->save()){
                            return $consumption->errors;
                        }
                    }
                }elseif($v[5] == '续费'){
                    $memberCard = MemberCard::findOne(['card_number'=>$v[0]]);
                    $memberCard->invalid_time = $v[10];
                    if(!$memberCard->save()){
                        return $memberCard->errors;
                    }
                    //2、续费消费记录
                    $consumption = new ConsumptionHistory();
                    $consumption->member_id = $memberId;
                    $consumption->consumption_type = 'card';
                    $consumption->consumption_type_id = $memberCard->id;
                    $consumption->type = 1;
                    $consumption->consumption_date = $v[8];
                    $consumption->consumption_time = $v[8];
                    $consumption->consumption_times = 1;
                    $consumption->bank_card_payment = $v[6];
                    $consumption->venue_id = $venueId;
                    $employeeId = $this->getEmployeeId($v[7],$venueId);
                    $consumption->seller_id = $employeeId;
                    $consumption->category = '续费';
                    $consumption->company_id = 1;
                    $consumption->consumption_amount = $v[6];
                    $consumption->due_date = $v[10];
                    if(!$consumption->save()){
                        return $consumption->errors;
                    }
                }elseif($v[5] == '升级' && $v[0] == '06101902'){
                    $memberCard   = MemberCard::findOne(['card_number'=>$v[0]]);
                    $cardCategory = CardCategory::findOne(['card_name'=>$v[4],'venue_id'=>$venueId]);
                    if($cardCategory){
                        //1、升级卡
                        $memberCard->amount_money = $v[6];
                        $memberCard->invalid_time = $v[10];
                        $memberCard->card_category_id = $cardCategory->id;
                        $memberCard->payment_time = $v[8];
                        $memberCard->card_name = $cardCategory->card_name;
                        $employeeId = $this->getEmployeeId($v[7],$venueId);
                        $memberCard->employee_id = $employeeId;
                        if(!$memberCard->save()){
                            return $memberCard->errors;
                        }
                        //2、消费记录
                        $consumption = new ConsumptionHistory();
                        $consumption->member_id = $memberId;
                        $consumption->consumption_type = 'card';
                        $consumption->consumption_type_id = $memberCard->id;
                        $consumption->type = 1;
                        $consumption->consumption_date = $v[8];
                        $consumption->consumption_time = $v[8];
                        $consumption->consumption_times = 1;
                        $consumption->bank_card_payment = $v[6];
                        $consumption->venue_id = $venueId;
                        $employeeId = $this->getEmployeeId($v[7],$venueId);
                        $consumption->seller_id = $employeeId;
                        $consumption->category = '升级';
                        $consumption->company_id = 1;
                        $consumption->consumption_amount = $v[6];
                        $consumption->due_date = $v[10];
                        if(!$consumption->save()){
                            return $consumption->errors;
                        }
                    }
                }elseif($v[0] == '10100556' && $v[5] == '升级'){
                    //修改10100556会员卡的名字
                    $memberCard = MemberCard::findOne(['card_number'=>10100556]);
                    $memberCard->create_at = $v[8];
                    $memberCard->active_time = $v[9];
                    $memberCard->invalid_time = $v[10];
                    $memberCard->amount_money = $v[6];
                    $memberCard->card_name = 'BC36';
                    if(!$memberCard->save()){
                        return $memberCard->errors;
                    }
                    $consumption = ConsumptionHistory::findOne(['consumption_type_id'=>$memberCard->id]);
                    if($consumption){
                        $consumption->consumption_amount = $v[6];
                        $consumption->due_date = $v[10];
                        if(!$consumption->save()){
                            return $consumption->errors;
                        }
                    }
                }
            }

            $num++;
            echo $num.'->';
        }
    }

    public function getCardCategoryId($cardName,$venueId)
    {
        $card = CardCategory::findOne(['card_name'=>$cardName,'venue_id'=>$venueId]);
        if($card){
            return $card->id;
        }else{
            $card = new CardCategory();
            $card->category_type_id = 1;
            $card->card_name = $cardName;
            $card->create_at = time();
            $card->count_method = 0;
            $card->attributes = 1;
            $card->total_store_times = 0;
            $card->venue_id = $venueId;
            $card->payment_months = 0;
            $card->sex = -1;
            $card->age = -1;
            $card->transfer_number = 0;
            $createId = $this->getCreateId($venueId);
            $card->create_id = $createId;
            $card->sales_mode = 1;
            $card->missed_times = -1;
            $card->limit_times = -1;
            $card->status = 3;
            $card->deal_id = 0;
            $card->company_id = 1;
            $card->is_app_show = 2;
            if(!$card->save()){
                return $card->errors;
            }else{
                return $card->id;
            }
        }
    }

    public function getCreateId($venueId)
    {
        $createId = Employee::findOne(['name' => '系统管理员', 'venue_id'=> $venueId]);
        if($createId){
            return $createId->id;
        }
    }

    public function getEmployeeId($name,$venueId)
    {
        $employee = Employee::findOne(['name'=>$name,'venue_id'=>$venueId]);
        if($employee){
            return $employee->id;
        }
    }

    
}