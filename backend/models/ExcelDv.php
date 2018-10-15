<?php
namespace backend\models;
use common\models\base\CardCategory;
use common\models\base\ConsumptionHistory;
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

class ExcelDv extends Model
{

    public function loadFile($file)
    {
        $model = new Excel();
        $data = $model->loadDvFile($file);
        $num = 0;
        foreach ($data as $k => $v) {
            //根据卡号找到会员
            $memberCard = MemberCard::findOne(['card_number'=>$v[0]]);
            if($memberCard){
                $oldMemberCardId = $memberCard->id;
                $memberId     = $memberCard->member_id;
                $member       = Member::findOne(['id'=>$memberId]);
                if($member){
                    //1、如果有这个会员，就把他的会籍改为大卫城
                    $member->mobile = $v[11];
                    $member->status = 1;
                    $counselorId = $this->getCounselorId($v[9]);
                    $member->counselor_id = $counselorId;
                    $member->member_type = 1;
                    $member->venue_id    = 14;
                    $member->company_id  = 1;
                    if(!$member->save()){
                        return $member->errors;
                    }
                    $memberDetails = MemberDetails::findOne(['member_id'=>$memberId]);
                    $memberDetails->sex = ($v[2] == '男')? 1:2;
                    if(!$memberDetails->save()){
                        return $memberDetails->errors;
                    }
                }
                //2、删除这张卡的通店信息
                VenueLimitTimes::deleteAll(['member_card_id'=>$oldMemberCardId]);
                //3、删除这张卡
                MemberCard::deleteAll(['id'=>$oldMemberCardId]);
                //4、给会员新建会员卡
                $cardCategory = CardCategory::find()->where(['card_name' => $v[4], 'venue_id' => 14])->orderBy('id DESC')->one();
                if ($cardCategory) {
                    $memberCard = new MemberCard();
                    $memberCard->card_number = $v[0];
                    $memberCard->create_at   = $v[3];
                    $memberCard->amount_money = $v[7];
                    $memberCard->status       = 1;
                    $memberCard->active_time = $v[5];
                    $memberCard->payment_type = 1;
                    $memberCard->is_complete_pay = 1;
                    $memberCard->invalid_time = $v[6];
                    $memberCard->level        = 2;
                    $memberCard->card_category_id = $cardCategory->id;
                    $memberCard->member_id    = $memberId;
                    $memberCard->payment_time = $v[3];
                    $memberCard->consume_status = 2;
                    $memberCard->describe      = $v[12];
                    $memberCard->card_name = $v[4];
                    $memberCard->company_id = 1;
                    $memberCard->venue_id   = 14;
                    $memberCard->bring = 3;
                    $memberCard->leave_total_days = $cardCategory->leave_total_days;
                    $memberCard->leave_least_days = $cardCategory->leave_least_Days;
                    $memberCard->leave_days_times = $cardCategory->leave_long_limit;
                    $memberCard->transfer_num     = $cardCategory->transfer_number;
                    $memberCard->surplus           = $cardCategory->transfer_number;
                    $memberCard->transfer_price   = $cardCategory->transfer_price;
                    if(!$memberCard->save()){
                        return $memberCard->errors;
                    }
                    //5、获取新卡种的通用场馆参数
                    $limitCardNumber = LimitCardNumber::find()->where(['card_category_id' => $cardCategory->id])->asArray()->all();
                    //6、添加新卡种的通店场馆参数
                    if($limitCardNumber){
                        foreach($limitCardNumber as $key=>$val){
                            if($val['status'] == 1 || $val['status'] == 3){
                                $venueLimitTimes = new VenueLimitTimes();
                                $venueLimitTimes->member_card_id = $memberCard->id;
                                $venueLimitTimes->venue_id       = $val['venue_id'];
                                $venueLimitTimes->total_times    = $val['times'];
                                if(!empty($val['times'])){
                                    $venueLimitTimes->overplus_times = $val['times'];
                                }else{
                                    $venueLimitTimes->overplus_times = $val['week_times'];
                                }
                                $venueLimitTimes->week_times     = $val['week_times'];
                                $venueLimitTimes->level          = $val['level'];
                                if(!$venueLimitTimes->save()){
                                    return $venueLimitTimes->errors;
                                }
                            }
                        }
                    }
                    //7、添加消费信息
                    $consumption = new ConsumptionHistory();
                    $consumption->member_id = $memberId;
                    $consumption->consumption_type = 'card';
                    $consumption->consumption_amount = $v[7];
                    $consumption->consumption_type_id = $memberCard->id;
                    $consumption->type = 1;
                    $consumption->consumption_date = $v[3];
                    $consumption->consumption_time = $v[3];
                    $consumption->consumption_times = 1;
                    $consumption->cash_payment = $v[7];
                    $consumption->venue_id = 14;
                    $sellerId = $this->getCounselorId($v[9]);
                    $consumption->seller_id = $sellerId;
                    $consumption->category = '发卡';
                    $consumption->company_id = 1;
                    $consumption->due_date = $v[6];
                    if(!$consumption->save()){
                        return $consumption->errors;
                    }
                }
            }
            $num++;
            echo $num.'->';
        }
    }

    public function getCounselorId($name)
    {
        $counselor = Employee::find()->where(['name'=>$name,'venue_id'=>14])->orderBy('id DESC')->one();
        if($counselor){
            return $counselor->id;
        }
    }


}