<?php
namespace backend\models;

use common\models\base\CardCategory;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\MemberDetails;
use common\models\base\MemberCardTime;
use common\models\base\CardTime;
use common\models\Excel;
use yii\base\Model;


class ExcelBuKa extends Model
{

    public function LoadFile($file)
    {
        $model = new Excel();
        $data = $model->loadBuKaFile($file);
        $num = 0;
        foreach ($data as $k => $v) {
            $venueId = $this->getVenueId();
            $memberCard = MemberCard::findOne(['card_number'=>$v[15]]);
            if($memberCard){
                $cardCategory = CardCategory::findOne(['id'=>$memberCard->card_category_id]);
                $memberCard->card_number  = $v[1];
                $memberCard->invalid_time = $v[12];
                $memberCard->leave_days_times = $cardCategory->leave_long_limit;
                $memberCard->leave_total_days = $cardCategory->leave_total_days;
                $memberCard->leave_least_days = $cardCategory->leave_least_Days;
                if(!$memberCard->save()){
                    return $memberCard->errors;
                }
                $memberId = $memberCard->member_id;
                $member = Member::findOne(['id'=>$memberId]);
                if($member){
                    $member->username = $v[2];
                    $member->mobile = $v[5];
                    if(!$member->save()){
                        return $member->errors;
                    }
                    $memberDetails = MemberDetails::findOne(['member_id'=>$memberId]);
                    if($memberDetails){
                        $memberDetails->name = $v[2];
                        $memberDetails->id_card = $v[3];
                        if(isset($v[3])){
                            $birth = strlen($v[3])==15 ? ('19' . substr($v[3], 6, 6)) : substr($v[3], 6, 8);
                            $memberDetails->birth_date = substr($birth,0,4) . '-' . substr($birth,4,2) . '-' . substr($birth,6);
                            $memberDetails->sex = intval(substr($v[3], (strlen($v[3])==15 ? -1 : -2), 1)) % 2 ? 1 : 2;
                        }
                        if(!$memberDetails->save()){
                            return $memberDetails->errors;
                        }
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
                    $consumption->category = '补卡';
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