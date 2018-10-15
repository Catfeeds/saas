<?php
namespace backend\models;

use common\models\base\CardCategory;
use common\models\base\ConsumptionHistory;
use common\models\base\Employee;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\MemberDetails;
use common\models\base\Organization;
use common\models\base\VenueLimitTimes;
use common\models\Excel;
use yii\base\Model;

class ExcelXiaoFei extends Model
{

    public function LoadFile($file)
    {
        $model = new Excel();
        $data = $model->loadXiaoFei($file);
        $num = 0;
        foreach ($data as $k => $v) {
            $card = MemberCard::findOne(['card_number'=>$v[1]]);
            if($card){
                $consum = ConsumptionHistory::findOne(['member_id'=>$card->member_id,'consumption_type_id'=>$card->id]);
                if(!$consum){
                    //1、添加消费记录
                    $consumption = new ConsumptionHistory();
                    $consumption->member_id = $card->member_id;
                    $consumption->consumption_type = 'card';
                    $consumption->consumption_type_id = $card->id;
                    $consumption->type = 1;
                    $consumption->consumption_date = $v[6];
                    $consumption->consumption_time = $v[6];
                    $consumption->consumption_times = 1;
                    $consumption->bank_card_payment = $v[7];
                    $consumption->venue_id = 59;
                    $sellerId = $this->getSellerId($v[8], 59);
                    $consumption->seller_id = $sellerId;
                    if ($v[0] == '会员卡（定金）') {
                        $consumption->category = '定金';
                    } elseif ($v[0] == '会员卡（回款）') {
                        $consumption->category = '回款';
                    } elseif ($v[0] == '会员卡（发卡）') {
                        $consumption->category = '发卡';
                    } elseif ($v[0] == '会员卡（升级）') {
                        $consumption->category = '升级';
                    }
                    $consumption->company_id = 1;
                    $consumption->consumption_amount = $v[7];
                    $consumption->describe = json_encode($v[12]);
                    $consumption->remarks = $v[12];
                    $consumption->due_date = $v[10];
                    if (!$consumption->save()) {
                        return $consumption->errors;
                    }
                }
            }
            $num++;
            echo $num.'->';
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