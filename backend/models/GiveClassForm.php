<?php
namespace backend\models;

use common\models\base\ChargeClass;
use common\models\base\Course;
use common\models\base\CoursePackageDetail;
use common\models\base\Employee;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\MemberCourseOrder;
use common\models\base\MemberCourseOrderDetails;
use common\models\base\Order;
use yii\base\Model;
use Yii;
use common\models\Func;
use common\models\base\MemberDealRecord;
use common\models\base\Deal;
use common\models\base\DealType;

class GiveClassForm extends Model
{
    public $courseType;      //赠送类别
    public $memberCardId;   //会员卡id
    public $coachId;        //私教id
    public $chargeId;        //购买课程ID
    public $courseNum;      //课程节数
    public $courseId;       //课程id
    public $validityStart;  //有效期开始时间
    public $validity;       //有效期结束时间
    public $type;           //私课类型：1多课程，2单课程
    public $memberId;       //会员id

    public function rules()
    {
        return [
            [['courseType','memberCardId', 'coachId','chargeId', 'courseNum','courseId','validityStart','validity','type','memberId'], 'safe'],
        ];
    }

    public function giveClass($className)
    {
        $memberCard   = MemberCard::findOne(['id' => $this->memberCardId]);
        $chargeClass  = ChargeClass::findOne(['id' => $this->courseId]);
        $courseDetail = CoursePackageDetail::findOne(['charge_class_id' => $chargeClass['id']]);
        $course       = Course::findOne(['id' => $courseDetail['course_id']]);
        if($this->courseType == 4){
            return  $this->sendNewChargeClass($className,$chargeClass,$courseDetail,$course);
        }
        $order        = NULL;
        if(!empty($order)){
            return '该会员卡已有私课教练，不需要分配';
        }else{
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $courseOrder                         = new MemberCourseOrder();
                $courseOrder->course_amount          = $this->courseNum;
                $courseOrder->create_at              = time();
                $courseOrder->money_amount           = 0;
                $courseOrder->overage_section        = $this->courseNum;
                $courseOrder->deadline_time          = strtotime($this->validity);
                $courseOrder->product_id             = $this->courseId;
                $courseOrder->product_type           = 1;
                $courseOrder->private_type           = '赠送课程';
                $courseOrder->private_id             = $this->coachId;
                $courseOrder->seller_id              = $this->coachId;
                $courseOrder->present_course_number  = $this->courseNum;
                $courseOrder->surplus_course_number  = $this->courseNum;
                $courseOrder->service_pay_id         = $this->courseId;
                $courseOrder->member_card_id         = $this->memberCardId;
                $courseOrder->member_id              = $memberCard['member_id'];
                $courseOrder->business_remarks       = '分配私教';
                $courseOrder->product_name           = $chargeClass['name'];
                $courseOrder->type                   = 1;
                $courseOrder->activeTime             = strtotime($this->validityStart);
                $courseOrder->set_number             = $this->courseNum;
                $courseOrder->course_type            = $this->courseType;
                $courseOrder = $courseOrder->save() ? $courseOrder : $courseOrder->errors;
                if(!isset($courseOrder->id)){
                    throw new \Exception('操作失败');
                }

                $orderDetails                    = new MemberCourseOrderDetails();
                $orderDetails->course_order_id   = $courseOrder->id;
                $orderDetails->course_id         = $course['id'];
                $orderDetails->course_num        = $this->courseNum;
                $orderDetails->course_length     = $chargeClass['valid_time'];
                $orderDetails->original_price    = $courseDetail['original_price'];
                $orderDetails->type              = 1;
                $orderDetails->category          = $chargeClass['type'];
                $orderDetails->product_name      = $chargeClass['name'];
                $orderDetails->course_name       = $course['name'];
                $orderDetails->class_length      = $courseDetail['course_length'];
                $orderDetails->pic               = $chargeClass['pic'];
                $orderDetails->desc              = $chargeClass['describe'];
                if(!$orderDetails->save()){
                    throw new \Exception('操作失败');
                }
                $memberData    = Member::findOne(['id'=>$this->memberId]);
                $dealId        = Deal::find()->where(['and',['type'=>2],['id'=>$chargeClass['deal_id']]])->asArray()->one();
                if(!empty($dealId)){
                    $dealDetailsId = DealType::findOne(['id'=>$dealId['deal_type_id']]);
                    $dealRecord    = MemberDealRecord::findOne(['type' => 2,'type_id' => $orderDetails['id'],'member_id' => $this->memberId]);
                    if(empty($dealRecord)){
                        $dealRecord = new MemberDealRecord();
                    }
                    $dealRecord->type             = 2;
                    $dealRecord->type_id          = $orderDetails['id'];
                    $dealRecord->member_id        = $this->memberId;
                    $dealRecord->deal_number      = 'sp'.time().mt_rand(10000,99999);
                    $dealRecord->type_name        = $dealDetailsId['type_name'];
                    $dealRecord->intro            = $dealId['intro'];
                    $dealRecord->company_id       = $memberData['company_id'];
                    $dealRecord->venue_id         = $memberData['venue_id'];
                    $dealRecord->create_at        = time();
                    $dealRecord->name             = $dealId['name'];
                    if(!$dealRecord->save()){
                        return $dealRecord->errors;
                    }
                    $order = MemberCourseOrderDetails::findOne(['id'=>$orderDetails['id']]);
                    $order ->deal_id = $dealRecord['id'];
                    if(!$order->save()){
                        return $order->errors;
                    }
                }
                if ($transaction->commit() === null) {
                    return true;
                } else {
                    return false;
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                return $e->getMessage();
            }
        }
    }

    /**
     * 业务后台 - 会员管理  - 赠送会员课程v1.0.1
     * @return array|bool|string
     * @throws \yii\db\Exception
     */
    public function sendChargeClass()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $mco = MemberCourseOrder::findOne(['id'=>$this->chargeId]);
            if(!empty($mco)){
//                if($mco->category == 1){
//                    return ['多课程无法完成赠送'];
//                }
                $mco->course_amount   =  $mco->course_amount + $this->courseNum;
                $mco->overage_section =  $mco->overage_section + $this->courseNum;
                if(!$mco->save()){
                    return $mco->errors;
                }
                $mcod = MemberCourseOrderDetails::findOne(['course_order_id'=>$mco->id]);
                if(!empty($mcod)){
                    $mcod->course_num = $mcod->course_num + $this->courseNum;
                    if(!$mco->save()){
                        return $mco->errors;
                    }
                }
            }
            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $e->getMessage();
        }
    }
    /**
     * 业务后台 - 会员管理  - 赠送会员课程v1.0.2
     * @return array|bool|string
     * @throws \yii\db\Exception
     */
    public function sendNewChargeClass($className,$chargeClass,$courseDetail,$course)
    {
        $mco = MemberCourseOrder::find()->where(['member_id' => $this->memberId])->andWhere(['!=','money_amount','0'])->asArray()->all();
        if(empty($mco)){
            return '此会员还未购买私教课，不能赠送';
        }
//        $mcod = MemberCourseOrderDetails::findOne(['course_order_id'=>$mco->id]);
        $card = MemberCard::find()->where(['member_id'=>$this->memberId])->select('id')->asArray()->one();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $courseOrder                         = new MemberCourseOrder();
            $courseOrder->course_amount          = $this->courseNum;
            $courseOrder->create_at              = time();
            $courseOrder->money_amount           = 0;
            $courseOrder->overage_section        = $this->courseNum;
            if(!empty($chargeClass['month_up_num'])){
                if($this->courseNum <= $chargeClass['month_up_num']){
                    $courseOrder->deadline_time  = time() + 30*24*60*60;
                }else{
                    $num = ceil($this->courseNum/$chargeClass['month_up_num']);
                    $courseOrder->deadline_time  = time() + $num*30*24*60*60;
                }
            }else{
                $courseOrder->deadline_time      = time() + $chargeClass['valid_time']*24*60*60;
            }
            $courseOrder->product_id             = $this->courseId;
            $courseOrder->product_type           = 1;
            $courseOrder->private_type           = '赠送课程';
            $courseOrder->private_id             = $this->coachId;
            $courseOrder->seller_id              = $this->coachId;
            $courseOrder->present_course_number  = $this->courseNum;
            $courseOrder->surplus_course_number  = $this->courseNum;
            $courseOrder->service_pay_id         = $this->coachId;
            $courseOrder->member_card_id         = $card['id'];
            $courseOrder->member_id              = $this->memberId;
            $courseOrder->business_remarks       = '购课赠课';
            $courseOrder->note                   = '购课赠送'.$this->courseNum.'节课程';
            $courseOrder->product_name           = $chargeClass['name'];
            $courseOrder->type                   = 4;//4:私教购课赠送
            $courseOrder->activeTime             = time();
            $courseOrder->set_number             = $this->courseNum;
            $courseOrder->course_type            = 4;//4:私教购课赠送
            $courseOrder = $courseOrder->save() ? $courseOrder : $courseOrder->errors;
            if(!isset($courseOrder->id)){
                return $courseOrder;
            }

            $orderDetails                    = new MemberCourseOrderDetails();
            $orderDetails->course_order_id   = $courseOrder->id;
            $orderDetails->course_id         = $course['id'];
            $orderDetails->course_num        = $this->courseNum;
            $orderDetails->course_length     = $chargeClass['valid_time'];
            $orderDetails->original_price    = $courseDetail['original_price'];
            $orderDetails->type              = 1;
            $orderDetails->category          = $chargeClass['type'];
            $orderDetails->product_name      = $chargeClass['name'];
            $orderDetails->course_name       = $course['name'];
            $orderDetails->class_length      = $courseDetail['course_length'];
            $orderDetails->pic               = $chargeClass['pic'];
            $orderDetails->desc              = '购课赠送'.$this->courseNum.'节课程';
            $orderDetails = $orderDetails->save() ? $orderDetails : $orderDetails->errors;
            if(!isset($orderDetails->id)){
                return $orderDetails;
            }
//            if(!$orderDetails->save()){
//                throw new \Exception('操作失败');
//            }
            $memberData    = Member::findOne(['id'=>$this->memberId]);
            $dealId        = Deal::find()->where(['and',['type'=>2],['id'=>$orderDetails['deal_id']]])->asArray()->one();
            if(!empty($dealId)){
                $dealDetailsId = DealType::findOne(['id'=>$dealId['deal_type_id']]);
                $dealRecord    = MemberDealRecord::findOne(['type' => 2,'type_id' => $orderDetails['id'],'member_id' => $this->memberId]);
                if(empty($dealRecord)){
                    $dealRecord = new MemberDealRecord();
                }
                $dealRecord->type             = 2;
                $dealRecord->type_id          = $orderDetails['id'];
                $dealRecord->member_id        = $this->memberId;
                $dealRecord->deal_number      = 'sp'.time().mt_rand(10000,99999);
                $dealRecord->type_name        = $dealDetailsId['type_name'];
                $dealRecord->intro            = $dealId['intro'];
                $dealRecord->company_id       = $memberData['company_id'];
                $dealRecord->venue_id         = $memberData['venue_id'];
                $dealRecord->create_at        = time();
                $dealRecord->name             = $dealId['name'];
                if(!$dealRecord->save()){
                    return $dealRecord->errors;
                }
                $order = MemberCourseOrderDetails::findOne(['id'=>$orderDetails['id']]);
                $order ->deal_id = $dealRecord['id'];
                if(!$order->save()){
                    return $order->errors;
                }
            }
            $order = new Order();
            $member     = Member::findOne(['id'=> $this->memberId]);
            $order->venue_id  = $member->venue_id;
            $order->member_id = $this->memberId;
            $order->card_category_id = $card['id'];
            $order->total_price = 0;
            $order->order_time  = time();
            $order->pay_money_time = time();
            $order->sell_people_id = $this->coachId;
            $order->payee_id        =  \Yii::$app->user->identity->id;
            $order->create_id        = \Yii::$app->user->identity->id;
            $order->status               = 2;
            $order->note                 = '私课赠课';
            $number                       = Func::setOrderNumber();
            $order->order_number         = "{$number}";                    //订单编号
            $order->card_name            = $className;     
            $seller = Employee::findOne(['id'=>$this->coachId]);
            $order->sell_people_name    = $seller->name;      //收售卖人姓名
            $payeeName = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
            $order->payee_name           = $payeeName->name;               //收款人姓名
            $order->member_name          = $member->username;
            $order->pay_people_name      = $member->username;
            $order->company_id            = $member->company_id;
            $order->consumption_type_id  = $courseOrder->id;
            $order->consumption_type     = 'charge';
            $order->deposit               = 0;
            $order->cash_coupon           = 0;
            $order->net_price             = 0;
            $order->all_price             = 0;
            $order->is_receipt            = 0;
            if(!$order->save()){
                throw new \Exception('操作失败');
            }

            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $e->getMessage();
        }
    }
}