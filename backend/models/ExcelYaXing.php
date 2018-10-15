<?php
namespace backend\models;

use common\models\base\CardTime;
use common\models\base\CardCategory;
use common\models\base\ConsumptionHistory;
use common\models\base\Employee;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\MemberDetails;
use common\models\base\Organization;
use common\models\base\VenueLimitTimes;
use common\models\base\MemberAccount;
use common\models\base\MemberCardTime;
use common\models\Excel;
use yii\base\Model;

class ExcelYaXing extends Model
{

    public function LoadFile($file)
    {
        $model = new Excel();
        $data = $model->loadYaXingFile($file);
        $num = 0;
        foreach ($data as $k => $v) {
            //添加的记录：1、member\memberDetails\memberCard\cardCategory\limitCardNumber\venueLimitTimes\consumptionHistory
            $venueId = $this->getVenueId();
            //1、先判断有无送人卡记录
            $memberCard = MemberCard::findOne(['card_number'=>$v[1]]);
            //2、有就录入回款
            if($memberCard){
                $memberId = $memberCard->member_id;
                $member   = Member::findOne(['id'=>$memberId]);
                if($member){
                    if($v[0] == '会员卡（回款）'){
                        $memberCard = MemberCard::findOne(['card_number' => $v[1]]);
                        $memberCard->amount_money += $v[9];
                        $memberCard->create_at = $v[8];
                        if (!$memberCard->save()) {
                            return $memberCard->errors;
                        }
                        $member->username = $v[2];
                        $member->mobile   = $v[5];
                        if(!$member->save()){
                            return $member->errors;
                        }
                        $memberDetails = MemberDetails::findOne(['member_id'=>$memberId]);
                        $memberDetails->name = $v[2];
                        $memberDetails->id_card = $v[3];
                        $memberDetails->score = $v[14];
                        if(!$memberDetails->save()){
                            return $memberDetails->errors;
                        }
                        $consumption = new ConsumptionHistory();
                        $consumption->member_id = $member->id;
                        $consumption->consumption_type = 'card';
                        $consumption->consumption_type_id = $memberCard->id;
                        $consumption->type = 1;
                        $consumption->consumption_date = $v[8];
                        $consumption->consumption_time = $v[8];
                        $consumption->consumption_times = 1;
                        $consumption->bank_card_payment = $v[9];
                        $consumption->venue_id = $venueId;
                        $sellerId = $this->getSellerId($v[6], $venueId);
                        $consumption->seller_id = $sellerId;
                        $consumption->category = '回款';
                        $consumption->company_id = 1;
                        $consumption->consumption_amount = $v[9];
                        $consumption->describe = json_encode($v[13]);
                        $consumption->remarks = $v[13];
                        $consumption->due_date = $v[12];
                        if (!$consumption->save()) {
                            return $consumption->errors;
                        }
                    }
                }
            }else{
            $member = Member::findOne(['username'=>$v[2],'mobile'=>$v[5],'venue_id'=>$venueId]);
            if(!$member){
                    $account = new MemberAccount();
                    $account->username = $v[2];
                    $account->password = \Yii::$app->security->generatePasswordHash('123456');
                    $account->mobile   = $v[5] == NULL ? '0': $v[5];
                    $account->last_time = time();
                    $account->company_id = 1;
                    $account->create_at  = time();
                    if(!$account->save()){
                        return $account->errors;
                    }
                    //1、会员资料
                    $member = new Member();
                    $member->username = $v[2];
                    $password = '123456';
                    $password = \Yii::$app->security->generatePasswordHash($password);
                    $member->password = $password;
                    $member->mobile = $v[5] == NULL ? '0': $v[5];
                    $member->register_time = $v[8];
                    $member->status = 1;
                    $counselorId = $this->getSellerId($v[6],$venueId);
                    $member->counselor_id = $counselorId;
                    $member->member_type = 1;
                    $member->venue_id = $venueId;
                    $member->company_id = 1;
                    $member->member_account_id = $account->id;
                    if(!$member->save()){
                        return $member->errors;
                    }
                    //2、会员详情
                    $memberDetails = new MemberDetails();
                    $memberDetails->member_id = $member->id;
                    $memberDetails->name = $v[2];
                    $memberDetails->id_card = $v[3] == NULL ? '0': $v[3];
                    if(isset($v[3])){
                        $birth = strlen($v[3])==15 ? ('19' . substr($v[3], 6, 6)) : substr($v[3], 6, 8);
                        $memberDetails->birth_date = substr($birth,0,4) . '-' . substr($birth,4,2) . '-' . substr($birth,6);
                        $memberDetails->sex = intval(substr($v[3], (strlen($v[3])==15 ? -1 : -2), 1)) % 2 ? 1 : 2;
                    }
                    $memberDetails->created_at = $v[8];
                    $memberDetails->score = $v[14];
                    if(!$memberDetails->save()){
                        return $memberDetails->errors;
                    }
                }
                //3、获取卡种
                if($v[7] == 'DXSCT3M' || $v[7] == 'DHT24MD'){
                    if($v[7] == 'DXSCT3M'){
                        $card = 'DXSCT3MD';
                    }else{
                        $card = 'DHT24MD';
                    }
                    $cardCategory = CardCategory::findOne(['card_name' => $card]);
                }else{
                    if ($v[7] == 'PT24MD' || $v[7] == '瑜伽两年卡') {
                        $card = 'YT24MD';
                    } elseif ($v[7] == 'PT60MD' || $v[7] == '单店白金') {
                        $card = '单店白金卡';
                    } elseif ($v[7] == 'FT12MD' || $v[7] == '健身游泳卡') {
                        $card = 'FT12M';
                    } elseif ($v[7] == 'PT12MD') {
                        $card = '瑜伽一年卡';
                    } elseif ($v[7] == '尊爵黑卡' || $v[7] == 'BC60' || $v[7] == '尊爵卡' || $v[7] == '国庆纪念卡') {
                        $card = 'BC60MD';
                    } elseif ($v[7] == '游泳健身两年卡') {
                        $card = 'FT24M';
                    } elseif ($v[7] == 'T60MD') {
                        $card = 'YT60MD';
                    } elseif ($v[7] == 'PT12MD' || $v[7] == '瑜伽卡' || $v[7] == '瑜伽年卡') {
                        $card = 'YT12MD';
                    } elseif ($v[7] == '瑜伽月卡' || $v[7] == '12MMD'){
                        $card = 'Y12MMD';
                    }else{
                        $card = $v[7];
                    }
                    $cardCategory = CardCategory::findOne(['card_name' => $card, 'venue_id' => $venueId]);
                }
                if ($cardCategory) {
                    //4、添加会员卡
                    $memberCard = MemberCard::findOne(['card_number'=>$v[1]]);
                    if(!$memberCard){
                        $memberCard = new MemberCard();
                        $memberCard->card_number = $v[1];
                        if ($v[0] == '会员卡（定金）' || $v[0] == '会员卡（发卡）' || $v[0] == '会员卡（升级）' || $v[0] == '会员卡（补卡）') {
                            $memberCard->create_at = $v[8];
                        }
                        $memberCard->amount_money = $v[9];
                        $memberCard->status = 1;
                        $memberCard->active_time = $v[11];
                        $memberCard->payment_type = 1;
                        $memberCard->is_complete_pay = 1;
                        $memberCard->invalid_time = $v[12];
                        $memberCard->level = 1;
                        $memberCard->card_category_id = $cardCategory->id;
                        $memberCard->member_id = $member->id;
                        $memberCard->payment_time = $v[8];
                        if ($v[0] == '会员卡（定金）') {
                            $memberCard->consume_status = 1;
                        } elseif ($v[0] == '会员卡（发卡）') {
                            $memberCard->consume_status = 2;
                        } elseif ($v[0] == '会员卡（续费）') {
                            $memberCard->consume_status = 3;
                        } elseif ($v[0] == '会员卡（回款）') {
                            $memberCard->consume_status = 4;
                        }else {
                            $memberCard->consume_status = 5;
                        }
                        $memberCard->describe = $v[13];
                        $memberCard->card_name = $v[7];
                        $memberCard->card_type = 1;
                        $memberCard->leave_days_times = $cardCategory->leave_long_limit;
                        $memberCard->leave_total_days = $cardCategory->leave_total_days;
                        $memberCard->leave_least_days = $cardCategory->leave_least_Days;
                        $memberCard->transfer_num = $cardCategory->transfer_number;
                        $memberCard->transfer_price = $cardCategory->transfer_price;
                        $memberCard->surplus = $cardCategory->transfer_number;
                        $memberCard->bring = $cardCategory->bring;
                        $memberCard->company_id = 1;
                        $memberCard->venue_id = $venueId;
                        $memberCard->single   = $v[15];
                        if(strpos($v[2],'送人')){
                            $memberCard->usage_mode = 2;
                        }else{
                            $memberCard->usage_mode = 1;
                        }
                        if (!$memberCard->save()) {
                            return $memberCard->errors;
                        }
                        //5、添加通店信息
                        $limitCardNumber = LimitCardNumber::find()->where(['card_category_id' => $cardCategory->id])->asArray()->all();
                        if ($limitCardNumber) {
                            foreach ($limitCardNumber as $key => $val) {
                                $venueLimitTimes = new VenueLimitTimes();
                                $venueLimitTimes->member_card_id = $memberCard->id;
                                $venueLimitTimes->venue_id = $val['venue_id'];
                                $venueLimitTimes->total_times = $val['times'];
                                if (!empty($val['times'])) {
                                    $venueLimitTimes->overplus_times = $val['times'];
                                } else {
                                    $venueLimitTimes->overplus_times = $val['week_times'];
                                }
                                $venueLimitTimes->week_times = $val['week_times'];
                                $venueLimitTimes->level = $val['level'];
                                $venueLimitTimes->save();
                            }
                        }
                        //6、消费记录
                        $consumption = new ConsumptionHistory();
                        $consumption->member_id = $member->id;
                        $consumption->consumption_type = 'card';
                        $consumption->consumption_type_id = $memberCard->id;
                        $consumption->type = 1;
                        $consumption->consumption_date = $v[8];
                        $consumption->consumption_time = $v[8];
                        $consumption->consumption_times = 1;
                        $consumption->bank_card_payment = $v[9];
                        $consumption->venue_id = $venueId;
                        $sellerId = $this->getSellerId($v[6], $venueId);
                        $consumption->seller_id = $sellerId;
                        if ($v[0] == '会员卡（定金）') {
                            $consumption->category = '定金';
                        } elseif ($v[0] == '会员卡（回款）') {
                            $consumption->category = '回款';
                        } elseif ($v[0] == '会员卡（发卡）') {
                            $consumption->category = '发卡';
                        } elseif ($v[0] == '会员卡（升级）') {
                            $consumption->category = '升级';
                        } else {
                            $consumption->category = '补卡';
                        }
                        $consumption->company_id = 1;
                        $consumption->consumption_amount = $v[9];
                        $consumption->describe = json_encode($v[13]);
                        $consumption->remarks = $v[13];
                        $consumption->due_date = $v[12];
                        if (!$consumption->save()) {
                            return $consumption->errors;
                        }
                        //7、添加会员卡时段
                        $time = CardTime::findOne(['card_category_id' => $cardCategory->id]);
                        if(!empty($time)) {
                            $cardTime = new MemberCardTime();
                            $cardTime->member_card_id = $memberCard->id;
                            $cardTime->start = $time->start;
                            $cardTime->end = $time->end;
                            $cardTime->create_at = time();
                            $cardTime->day = $time->day;
                            $cardTime->week = $time->week;
                            $cardTime->month = $time->month;
                            $cardTime->quarter = $time->quarter;
                            $cardTime->year = $time->year;
                            if (!$cardTime->save()) {
                                return $cardTime->errors;
                            }
                        }
                    }
                    //6、消费记录
                    if ($v[0] == '会员卡（回款）') {
                        $memberCard = MemberCard::findOne(['card_number' => $v[1]]);
                        $memberCard->amount_money += $v[9];
                        if (!$memberCard->save()) {
                            return $memberCard->errors;
                        }
                        $consumption = new ConsumptionHistory();
                        $consumption->member_id = $member->id;
                        $consumption->consumption_type = 'card';
                        $consumption->consumption_type_id = $memberCard->id;
                        $consumption->type = 1;
                        $consumption->consumption_date = $v[8];
                        $consumption->consumption_time = $v[8];
                        $consumption->consumption_times = 1;
                        $consumption->bank_card_payment = $v[9];
                        $consumption->venue_id = $venueId;
                        $sellerId = $this->getSellerId($v[6], $venueId);
                        $consumption->seller_id = $sellerId;
                        $consumption->category = '回款';
                        $consumption->company_id = 1;
                        $consumption->consumption_amount = $v[9];
                        $consumption->describe = json_encode($v[13]);
                        $consumption->remarks = $v[13];
                        $consumption->due_date = $v[12];
                        if (!$consumption->save()) {
                            return $consumption->errors;
                        }
                    }
                }
            }
            $num++;
            echo $num.'->';
        }
    }

    public function getVenueId()
    {
        $venue = Organization::findOne(['name'=>'亚星游泳健身馆','style'=>2]);
        if($venue){
            return $venue->id;
        }
    }

    public function getSellerId($name,$venueId)
    {
        $seller = Employee::findOne(['name'=>$name,'venue_id'=>$venueId]);
        if($seller){
            return $seller->id;
        }else{
            $seller = new Employee();
            $seller->name = $name;
            $organizationId = $this->getOrganizationId($venueId);
            $seller->organization_id = $organizationId;
            $seller->position = '销售';
            $seller->status = 1;
            $createId = $this->getCreateId($venueId);
            $seller->create_id = $createId;
            $seller->created_at = time();
            $seller->class_hour = 0;
            $seller->is_check = 0;
            $seller->is_pass = 1;
            $seller->company_id = 1;
            $seller->venue_id = $venueId;
            if(!$seller->save()){
                return $seller->errors;
            }
            return $seller->id;
        }
    }

    public function getCreateId($venueId)
    {
        $create = Employee::findOne(['name'=>'系统管理员','venue_id'=>$venueId]);
        if($create){
            return $create->id;
        }else{
            $create = new Employee();
            $create->name = '系统管理员';
            $create->sex = 1;
            $organizationId = $this->getOrganizationId($venueId);
            $create->organization_id = $organizationId;
            $create->status = 2;
            $create->create_id = 0;
            $create->salary = 0;
            $create->created_at = time();
            $create->company_id = 1;
            $create->venue_id = $venueId;
            if(!$create->save()){
                return $create->errors;
            }
            return $create->id;
        }
    }

    public function getOrganizationId($venueId)
    {
        $organization = Organization::findOne(['name'=>'销售部','pid'=>$venueId]);
        if($organization){
            return $organization->id;
        }
    }

}