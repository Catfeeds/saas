<?php
namespace backend\models;

use common\models\base\ConsumptionHistory;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\MemberDetails;
use common\models\base\TransferRecord;
use common\models\base\MemberCardTime;
use common\models\base\CardTime;
use common\models\Excel;
use yii\base\Model;

class ExcelZhuanRang extends Model
{

    public function LoadFile($file)
    {
        $model = new Excel();
        $data = $model->loadZhuanRangFile($file);
        $num = 0;
        foreach ($data as $k => $v) {
            //1、找到被转的会员卡
            $memberCard = MemberCard::findOne(['card_number'=>$v[1]]);
            //2、找到原卡持有者
            if($memberCard){
                $cardCategory = \common\models\base\CardCategory::findOne(['id'=>$memberCard->card_category_id]);
                $memberCard->active_time = $v[10];
                $memberCard->invalid_time = $v[11];
                $memberCard->leave_days_times = $cardCategory->leave_long_limit;
                $memberCard->leave_total_days = $cardCategory->leave_total_days;
                $memberCard->leave_least_days = $cardCategory->leave_least_Days;
                if(!$memberCard->save()){
                    return $memberCard->errors;
                }
                $memberId  =  $memberCard->member_id;
                $member1   =  Member::findOne(['id'=>$memberId]);
                $venueId   =  $member1->venue_id;
                $companyId =  $member1->company_id;
                //3、找到被转卡的人，如果不是会员就新建
                $member2  = Member::findOne(['username'=>$v[2],'mobile'=>$v[4]]);
                if($member2){
                    //是现存会员
                    $memberCard->member_id = $member2->id;
                    //1、会员卡转到此人名下
                    if(!$memberCard->save()){
                        return $memberCard->errors;
                    }
                    //2、有可能是潜在会员，改成正式会员
                    $member2->status = 1;
                    $member2->member_type = 1;
                    $member2->venue_id = $venueId;
                    $member2->company_id = $companyId;
                    if(!$member2->save()){
                        return $member2->errors;
                    }
                }else{
                    //不是现存会员就新建
                    $member2 = new Member();
                    $password = '123456';
                    $password = \Yii::$app->security->generatePasswordHash($password);
                    $member2->username = $v[2];
                    $member2->password = $password;
                    $member2->mobile   = $v[4];
                    $member2->register_time = time();
                    $member2->status   = 1;
                    $counselorId = $this->getCounselorId($v[5],$venueId);
                    $member2->counselor_id = $counselorId;
                    $member2->member_type = 1;
                    $member2->venue_id = $venueId;
                    $member2->company_id = $companyId;
                    if(!$member2->save()){
                        return $member2->errors;
                    }
                    $member2details = new MemberDetails();
                    $member2details->member_id = $member2->id;
                    $member2details->name       = $v[2];
                    $member2details->id_card = $v[3];
                    $member2details->created_at = time();
                    if(!$member2details->save()){
                        return $member2details->errors;
                    }
                    //会员卡转到此人名下
                    $memberCard->member_id = $member2->id;
                    if(!$memberCard->save()){
                        return $memberCard->errors;
                    }
                }
                //4、添加转卡记录
                $transferRecord = new TransferRecord();
                $transferRecord->member_card_id = $memberCard->id;
                $transferRecord->to_member_id   = $member2->id;
                $transferRecord->from_member_id = $memberId;
                $transferRecord->transfer_time  = $v[1];
                $transferRecord->times           = 0;
                $transferRecord->path            = json_encode($memberId.','.$member2->id);
                $transferRecord->transfer_price = $v[8];
                $transferRecord->cashier_number  = $v[8];
                $transferRecord->cash_payment = $v[8];
                if(!$transferRecord->save()){
                    return $transferRecord->errors;
                }
                //5、添加消费记录
                $consumption = new ConsumptionHistory();
                $consumption->member_id = $member2->id;
                $consumption->consumption_type = 'transfer card';
                $consumption->consumption_type_id = $memberCard->id;  //会员卡id
                $consumption->type = 1;
                $consumption->consumption_date = $v[7];
                $consumption->consumption_times = 1;
                $consumption->consumption_amount = $v[8];
                $consumption->venue_id = $venueId;
                $consumption->company_id = $companyId;
                $consumption->category = '转卡';
                $consumption->cash_payment = $v[8];
                $consumption->remarks = $v[12];
                $sellerId = $this->getSellerId($v[5], $venueId);
                $consumption->seller_id = $sellerId;
                if(!$consumption->save()){
                    return $consumption->errors;
                }
                //6、添加会员卡时段
                $time = CardTime::findOne(['card_category_id' => $memberCard->card_category_id]);
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
            $num++;
            echo $num.'->';
        }
    }

    public function getCounselorId($name,$venueId)
    {
        $counselor = Employee::findOne(['name'=>$name,'venue_id'=>$venueId]);
        if($counselor){
            return $counselor->id;
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

    public function getOrganizationId($venueId)
    {
        $organization = Organization::findOne(['name'=>'销售部','pid'=>$venueId]);
        if($organization){
            return $organization->id;
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

}