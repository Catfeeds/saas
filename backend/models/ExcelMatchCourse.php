<?php
namespace backend\models;
use common\models\base\CardCategory;
use common\models\base\ChargeClass;
use common\models\base\ConsumptionHistory;
use common\models\base\Course;
use common\models\base\CoursePackageDetail;
use common\models\base\Employee;
use common\models\base\Member;
use common\models\base\MemberCourseOrder;
use common\models\base\MemberCourseOrderDetails;
use common\models\base\MemberDetails;
use common\models\base\Organization;
use common\models\base\VenueLimitTimes;
use yii\base\Model;
use common\models\Excel;
use common\models\base\MemberCard;
use Yii;

class ExcelMatchCourse extends Model
{

    public function loadFile($file)
    {
        $model = new Excel();
        $data = $model->loadMatchCourseFile($file);
        $num = 0;
        foreach ($data as $k => $v) {
            //获得会员卡
            $memberCard = MemberCard::findOne(['card_number'=>$v[1]]);
            if($memberCard){
                $memberId = $memberCard->member_id;
                $member   = Member::findOne(['id'=>$memberId]);
                $member->member_type = 1;
                if(!$member->save()){
                    return $member->errors;
                }
                $venueId  = $member->venue_id;
                //会员编号+购课节数+购课时间+截止时间 ==> 锁定私教课
                $mco = MemberCourseOrder::findOne(['member_id'=>$memberCard->member_id,'activeTime'=>$v[3],'deadline_time'=>$v[4],'product_name'=>$v[5]]);
                if($mco){
                    if($v[24] == '回款'){
                        //加上回款金额
                        $mco->money_amount += $v[14];
                        if(!$mco->save()){
                            return $mco->errors;
                        }
                        //消费记录
                        $consumption = new ConsumptionHistory();
                        $consumption->member_id = $memberCard->member_id;
                        $consumption->consumption_type = 'charge';
                        $consumption->consumption_type_id = $mco->id;
                        $consumption->type = 1;
                        $consumption->consumption_date = $v[11];
                        $consumption->consumption_times = 1;
                        $consumption->cashier_order = $v[12];
                        $consumption->cash_payment = $v[15];
                        $consumption->bank_card_payment = $v[16];
                        $consumption->mem_card_payment = $v[17];
                        $consumption->coupon_payment = $v[18];
                        $consumption->transfer_accounts = $v[19];
                        $consumption->other_payment = $v[20];
                        $consumption->network_payment = $v[22];
                        $consumption->integration_payment = $v[23];
                        $consumption->discount_payment = $v[21];
                        $consumption->venue_id = $venueId;
                        $sellerId = $this->getSellerId($v[6]);
                        $consumption->seller_id = $sellerId;
                        $consumption->category = $v[24];
                        $consumption->company_id = 1;
                        $consumption->consumption_amount = $v[14];
                        $consumption->remarks = $v[13];
                        if(!$consumption->save()){
                            return $consumption->errors;
                        }
                    }
                }else{
                    if($v[5] == '健身私教'){
                        $name = 'PT常规课（增肌、减脂、塑性）';
                    }elseif ($v[5] == '搏击课'){
                        $name = 'PT MFT格斗健身';
                    }elseif ($v[5] == '网球私教'){
                        $name = 'PT 网球课程';
                    }elseif ($v[5] == '游泳私教'){
                        $name = 'PT 游泳课';
                    }elseif ($v[5] == '孕产私教'){
                        $name = 'PT 孕产课程';
                    }else{
                        $name = $v[5];
                    }
                    $chargeClass1 = ChargeClass::findOne(['name'=>$name,'venue_id'=>$venueId]);
                    if($chargeClass1){
                        $cpd1 = CoursePackageDetail::findOne(['charge_class_id'=>$chargeClass1->id]);
                        if($cpd1){
                            $course1 = Course::findOne(['id'=>$cpd1->course_id]);
                            if($course1){
                                //没有私教课就新建:memberCourseOrder,memberCourseOrderDetails,consumptionHistory
                                $newmco = new MemberCourseOrder();
                                $newmco->course_amount = $v[7];
                                $newmco->create_at     = $v[11];
                                $newmco->money_amount  = $v[14];
                                $newmco->overage_section = $v[8];
                                $newmco->deadline_time = $v[4];
                                $newmco->product_id    = $chargeClass1->id;
                                $newmco->product_type = 1;
                                $newmco->private_type = $v[5];
                                $newmco->charge_mode  = 1;
                                $sellerId = $this->getSellerId($v[6]);
                                $newmco->private_id   = $sellerId;
                                $newmco->surplus_course_number = $v[8];
                                $newmco->cashier_type = 1;
                                $newmco->member_card_id = $memberCard->id;
                                $newmco->seller_id = $sellerId;
                                $newmco->cashierOrder = $v[12];
                                $newmco->member_id = $memberCard->member_id;
                                $newmco->product_name = $v[5];
                                $newmco->type = ($v[0] == 'PT')? 1:2;
                                $newmco->activeTime = $v[3];
                                $chargerId = $this->getChargerId();
                                $newmco->chargePersonId = $chargerId;
                                $newmco->note = $v[10];
                                if(!$newmco->save()){
                                    return $newmco->errors;
                                }
                                $newmcod = new MemberCourseOrderDetails();
                                $newmcod->course_order_id = $newmco->id;
                                $newmcod->course_id = $course1->id;
                                $newmcod->course_num = $v[7];
                                $newmcod->course_length = ceil(($v[4]-$v[3])/60*60*24);
                                $newmcod->original_price = $cpd1->original_price;
                                $newmcod->pos_price = $cpd1->pos_price;
                                $newmcod->type = 1;
                                $newmcod->category = 2;
                                $newmcod->product_name = $v[5];
                                $newmcod->course_name = $course1->name;
                                $newmcod->class_length = $cpd1->course_length;
                                if(!$newmcod->save()){
                                    return $newmcod->errors;
                                }
                                //消费记录
                                $consumption = new ConsumptionHistory();
                                $consumption->member_id = $memberCard->member_id;
                                $consumption->consumption_type = 'charge';
                                $consumption->consumption_type_id = $newmco->id;
                                $consumption->type = 1;
                                $consumption->consumption_date = $v[11];
                                $consumption->consumption_times = 1;
                                $consumption->cashier_order = $v[12];
                                $consumption->cash_payment = $v[15];
                                $consumption->bank_card_payment = $v[16];
                                $consumption->mem_card_payment = $v[17];
                                $consumption->coupon_payment = $v[18];
                                $consumption->transfer_accounts = $v[19];
                                $consumption->other_payment = $v[20];
                                $consumption->network_payment = $v[22];
                                $consumption->integration_payment = $v[23];
                                $consumption->discount_payment = $v[21];
                                $consumption->venue_id = $venueId;
                                $consumption->seller_id = $sellerId;
                                $consumption->category = $v[24];
                                $consumption->company_id = 1;
                                $consumption->consumption_amount = $v[14];
                                $consumption->remarks = $v[13];
                                if(!$consumption->save()){
                                    return $consumption->errors;
                                }
                            }
                        }
                    }
                }
            }
            $num++;
            echo $num.'->';
        }
    }

    public function getSellerId($name)
    {
        $seller = Employee::findOne(['name'=>$name,'venue_id'=>15]);
        if($seller){
            return $seller->id;
        }
    }

    public function getChargerId()
    {
        $charger = Employee::findOne(['name'=>'系统管理员','venue_id'=>15]);
        if($charger){
            return $charger->id;
        }
    }

}