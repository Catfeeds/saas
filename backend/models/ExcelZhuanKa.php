<?php
namespace backend\models;

use common\models\base\CardCategory;
use common\models\base\ConsumptionHistory;
use common\models\base\LimitCardNumber;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\MemberDetails;
use common\models\base\TransferRecord;
use common\models\Excel;
use yii\base\Model;

class ExcelZhuanKa extends Model
{

    public function LoadFile($file)
    {
        $model = new Excel();
        $data = $model->loadZhuanKaFile($file);
        $num = 0;
        foreach ($data as $k => $v) {
//            var_dump($v);die;
            //1、找到被转的会员卡
            $memberCard = MemberCard::findOne(['card_number'=>$v[4]]);
            echo "$v[4]".'<br/>';
            //2、找到原卡持有者
            if(isset($memberCard) && !empty($memberCard)){
                $memberId  =  $memberCard->member_id;
                var_dump('$memberId'.$memberId.'<br/>');
                $member1   =  Member::findOne(['id'=>$memberId]);
//                print_r($member1);exit();
                //白冰会籍改为瑜伽馆
                if(isset($member1) && !empty($member1) &&$member1->venue_id !== 11){
                    $member1->venue_id = 11;
                    if(!$member1->save()){
                        return $member1->errors;
                    }
                }

                //卡种改为瑜伽馆的
                $cardCategoryId = $memberCard->card_category_id;
                $cardCategory = CardCategory::findOne(['id'=>$cardCategoryId]);
                $cardCategory->venue_id = 11;
                if(!$cardCategory->save()){
                    return $cardCategory->errors;
                }
                $venueId   = (isset($member1) && !empty($member1))?$member1->venue_id : 11;
                $companyId =  (isset($member1) && !empty($member1))?$member1->company_id : 1;
                //3、找到被转卡的人，如果不是会员就新建
                $member2  = Member::findOne(['username'=>$v[8],'mobile'=>$v[11]]);
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
                    $member2->username = $v[8];
                    $member2->password = $password;
                    $member2->mobile   = (string)intval($v[11]);
                    $member2->register_time = time();
                    $member2->status   = 1;
                    $counselorId = $this->getCounselorId($v[12],$venueId);
                    $member2->counselor_id = $counselorId;
                    $member2->member_type = 1;
                    $member2->venue_id = $venueId;
                    $member2->company_id = $companyId;
                    if(!$member2->save()){
                        return $member2->errors;
                    }
                    $member2details = new MemberDetails();
                    $member2details->member_id = $member2->id;
                    $member2details->name       = $v[8];
                    $member2details->sex        = ($v[10] == '男')?1:2;
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
                $transferRecord->transfer_price = $v[20];
//                $registerPersonId = $this->getCounselorId($v[12],$venueId);
//                $transferRecord->register_person = $registerPersonId;
                $transferRecord->cashier_number  = $v[18];
                //手续费是否为0
                if($v[20] !== 0){
                   if (isset($v[21]) && !empty($v[21])){
                       $transferRecord->cash_payment = $v[21];
                   }elseif (isset($v[22]) && !empty($v[22])){
                       $transferRecord->bank_card_payment = $v[22];
                   }elseif (isset($v[23]) && !empty($v[23])){
                       $transferRecord->member_card = $v[23];
                   }elseif (isset($v[24]) && !empty($v[24])){
                       $transferRecord->coupon = $v[24];
                   }elseif (isset($v[25]) && !empty($v[25])){
                       $transferRecord->transfer = $v[25];
                   }elseif (isset($v[26]) && !empty($v[26])){
                       $transferRecord->other = $v[26];
                   }elseif (isset($v[27]) && !empty($v[27])){
                       $transferRecord->discount = $v[27];
                   }elseif (isset($v[28]) && !empty($v[28])){
                       $transferRecord->network_payment = $v[28];
                   }elseif (isset($v[29]) && !empty($v[29])){
                       $transferRecord->integral = $v[29];
                   }
                    if(!$transferRecord->save()){
                        return $transferRecord->errors;
                    }
                }
                //5、添加消费记录
                $consumption = new ConsumptionHistory();
                $consumption->member_id = $member2->id;
                $consumption->consumption_type = 'transfer card';
                $consumption->consumption_type_id = $memberCard->id;  //会员卡id
                $consumption->type = 1;
                $consumption->consumption_date = $v[1];
                $consumption->consumption_times = 1;
                $consumption->due_date          = $memberCard->invalid_time;
                $consumption->cashier_order     = $v[18];
                $consumption->consumption_amount = $v[20];
                $consumption->venue_id = $venueId;
                $consumption->company_id = $companyId;
                $consumption->remarks             = $v[16];
//                $consumption->consume_describe    = $v[16];
                $consumption->category = '转卡';
                if($v[20] !== 0){
                    if (isset($v[21]) && !empty($v[21])){
                        $consumption->cash_payment = $v[21];
                    }elseif (isset($v[22]) && !empty($v[22])){
                        $consumption->bank_card_payment = $v[22];
                    }elseif (isset($v[23]) && !empty($v[23])){
                        $consumption->mem_card_payment = $v[23];
                    }elseif (isset($v[24]) && !empty($v[24])){
                        $consumption->coupon_payment = $v[24];
                    }elseif (isset($v[25]) && !empty($v[25])){
                        $consumption->transfer_accounts = $v[25];
                    }elseif (isset($v[26]) && !empty($v[26])){
                        $consumption->other_payment = $v[26];
                    }elseif (isset($v[27]) && !empty($v[27])){
                        $consumption->discount_payment = $v[27];
                    }elseif (isset($v[28]) && !empty($v[28])){
                        $consumption->network_payment = $v[28];
                    }elseif (isset($v[29]) && !empty($v[29])){
                        $consumption->integration_payment = $v[29];
                    }
                    if(!$consumption->save()){
                        return $consumption->errors;
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

}