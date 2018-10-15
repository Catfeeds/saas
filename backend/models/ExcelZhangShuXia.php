<?php
namespace backend\models;

use common\models\base\CardCategory;
use common\models\base\ConsumptionHistory;
use common\models\base\Employee;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\MemberDetails;
use common\models\base\Organization;
use common\models\base\TransferRecord;
use common\models\base\VenueLimitTimes;
use common\models\Excel;
use yii\base\Model;

class ExcelZhangShuXia extends Model
{

    public function LoadFile($file)
    {
        $model = new Excel();
        $data = $model->loadZhangShuXiaFile($file);
        $num = 0;
        foreach ($data as $k => $v) {
            $memberCard = MemberCard::findOne(['card_number'=>$v[2]]);
            if($memberCard){
                $memberId = $memberCard->member_id;
                $member   = Member::findOne(['id'=>$memberId]);
                if($v[1] == '会员卡(发卡)'){
                    if($member){
                        //1、会籍改为瑜伽馆
                        $venueId = $this->getVenueId();
                        $member->venue_id = $venueId;
                        if(!$member->save()){
                            return $member->errors;
                        }
                    }
                    //2、删除之前存在的会员卡和购卡消费记录
                    ConsumptionHistory::deleteAll(['consumption_type_id'=>$memberCard->id]);
                    MemberCard::deleteAll(['card_number'=>$v[2]]);
                    //3、添加新会员卡、通店数据、消费记录
                    $memCard = new MemberCard();
                    $memCard->card_number = $v[2];
                    $memCard->create_at = $v[13];
                    $memCard->amount_money = $v[7];
                    $memCard->status = 1;
                    $memCard->active_time = $v[10];
                    $memCard->payment_type = 1;
                    $memCard->is_complete_pay = 1;
                    $memCard->invalid_time = $v[11];
                    $memCard->level = 1;
                    $venueId = $this->getVenueId();
                    $cardCategory = CardCategory::findOne(['card_name'=>$v[6],'venue_id'=>$venueId]);
                    $memCard->card_category_id = $cardCategory->id;
                    $memCard->member_id = $member->id;
                    $memCard->payment_time = $v[13];
                    $memCard->present_private_lesson = $v[9];
                    $memCard->describe = $v[12];
                    $employeeId = $this->getEmployeeId($v[5],$venueId);
                    $memCard->employee_id = $employeeId;
                    $memCard->card_name = $v[6];
                    $memCard->card_type = 1;
                    $memCard->company_id = 1;
                    $memCard->venue_id = $venueId;
                    if(!$memCard->save()){
                        return $memCard->errors;
                    }
                    //4、获取新卡种的通用场馆参数
                    $limitCardNumber = LimitCardNumber::find()->where(['card_category_id' => $cardCategory->id])->asArray()->all();
                    //5、添加新卡种的通店场馆参数
                    if($limitCardNumber){
                        foreach($limitCardNumber as $key=>$val){
                            $venueLimitTimes = new VenueLimitTimes();
                            $venueLimitTimes->member_card_id = $memCard->id;
                            $venueLimitTimes->venue_id       = $val['venue_id'];
                            $venueLimitTimes->total_times    = $val['times'];
                            if(!empty($val['times'])){
                                $venueLimitTimes->overplus_times = $val['times'];
                            }else{
                                $venueLimitTimes->overplus_times = $val['week_times'];
                            }
                            $venueLimitTimes->week_times     = $val['week_times'];
                            $venueLimitTimes->level          = $val['level'];
                            $venueLimitTimes->save();
                        }
                    }
                    //6、添加消费记录
                    $consumption = new ConsumptionHistory();
                    $consumption->member_id = $member->id;
                    $consumption->consumption_type = 'card';
                    $consumption->consumption_type_id = $memCard->id;
                    $consumption->type = 1;
                    $consumption->consumption_date = $v[13];
                    $consumption->consumption_time = $v[13];
                    $consumption->consumption_times = 1;
                    $consumption->cashier_order = $v[14];
                    $consumption->bank_card_payment = $v[7];
                    $consumption->venue_id = $venueId;
                    $sellerId = $this->getEmployeeId($v[5],$venueId);
                    $consumption->seller_id = $sellerId;
                    $consumption->category = '发卡';
                    $consumption->company_id = 1;
                    $consumption->consumption_amount = $v[7];
                    $consumption->due_date = $v[11];
                    if(!$consumption->save()){
                        return $consumption->errors;
                    }
                }elseif($v[1] == '会员卡(续费)'){
                    $venueId = $this->getVenueId();
                    $memberCard = MemberCard::findOne(['card_number'=>$v[2]]);
                    if($memberCard){
                        $consumption = new ConsumptionHistory();
                        $consumption->member_id = $member->id;
                        $consumption->consumption_type = 'card';
                        $consumption->consumption_type_id = $memberCard->id;
                        $consumption->type = 1;
                        $consumption->consumption_date = $v[13];
                        $consumption->consumption_time = $v[13];
                        $consumption->consumption_times = 1;
                        $consumption->cashier_order = $v[14];
                        $consumption->bank_card_payment = $v[7];
                        $consumption->venue_id = $venueId;
                        $sellerId = $this->getEmployeeId($v[5],$venueId);
                        $consumption->seller_id = $sellerId;
                        $consumption->category = '续费';
                        $consumption->company_id = 1;
                        $consumption->consumption_amount = $v[7];
                        $consumption->due_date = $v[11];
                        if(!$consumption->save()){
                            return $consumption->errors;
                        }
                    }
                }else{
                    $venueId = $this->getVenueId();
                    $memberCard = MemberCard::findOne(['card_number'=>$v[2]]);
                    if($memberCard){
                        //1、更新会员卡信息
                        $memberCard->create_at = $v[13];
                        $memberCard->amount_money = $v[7];
                        $memberCard->status = 1;
                        $memberCard->active_time = $v[10];
                        $memberCard->payment_type = 1;
                        $memberCard->is_complete_pay = 1;
                        $memberCard->invalid_time = $v[11];
                        $memberCard->level = 1;
                        $memberCard->payment_time = $v[13];
                        $memberCard->present_private_lesson = $v[9];
                        $memberCard->describe = $v[12];
                        $employeeId = $this->getEmployeeId($v[5],$venueId);
                        $memberCard->employee_id = $employeeId;
                        $memberCard->card_type = 1;
                        if(!$memberCard->save()){
                            return $memberCard->errors;
                        }
                        //2、添加消费信息
                        $consumption = new ConsumptionHistory();
                        $consumption->member_id = $member->id;
                        $consumption->consumption_type = 'card';
                        $consumption->consumption_type_id = $memberCard->id;
                        $consumption->type = 1;
                        $consumption->consumption_date = $v[13];
                        $consumption->consumption_time = $v[13];
                        $consumption->consumption_times = 1;
                        $consumption->cashier_order = $v[14];
                        $consumption->bank_card_payment = $v[7];
                        $consumption->venue_id = $venueId;
                        $sellerId = $this->getEmployeeId($v[5],$venueId);
                        $consumption->seller_id = $sellerId;
                        $consumption->category = '升级';
                        $consumption->company_id = 1;
                        $consumption->consumption_amount = $v[7];
                        $consumption->due_date = $v[11];
                        if(!$consumption->save()){
                            return $consumption->errors;
                        }
                    }
                }
            }
            $num++;
            echo $num;
        }
    }

    public function getVenueId()
    {
        $venue = Organization::findOne(['name'=>'大学路瑜伽馆','style'=>2]);
        if($venue){
            return $venue->id;
        }
    }

    public function getCardCategoryId($name,$venueId)
    {
        $cardCategory = CardCategory::findOne(['card_name'=>$name,'venue_id'=>$venueId]);
        if($cardCategory){
            return $cardCategory->id;
        }
    }

    public function getEmployeeId($name,$venueId)
    {
        $employee = Employee::findOne(['name'=>$name,'venue_id'=>$venueId]);
        if($employee){
            return $employee->id;
        }else{
            $employee = new Employee();
            $employee->name = $name;
            $employee->organization_id = 101;
            $employee->status = 1;
            $employee->create_id = 2;
            $employee->company_id = 1;
            $employee->venue_id = $venueId;
            if(!$employee->save()){
                return $employee->errors;
            }
            return $employee->id;
        }
    }



}