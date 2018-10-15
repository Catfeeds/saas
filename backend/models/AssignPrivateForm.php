<?php
namespace backend\models;

use common\models\base\ChargeClass;
use common\models\base\Course;
use common\models\base\CoursePackageDetail;
use common\models\base\MemberCard;
use common\models\base\MemberCourseOrder;
use common\models\base\MemberCourseOrderDetails;
use yii\base\Model;
use Yii;
use common\models\base\MemberDealRecord;
use common\models\base\Deal;
use common\models\base\DealType;

class AssignPrivateForm extends Model
{
    public $courseType;
    public $memberCardId;   //会员卡id
    public $coachId;        //私教id
    public $courseNum;      //课程节数
    public $courseId;      //课程id

    public function rules()
    {
        return [
            [['courseType','memberCardId', 'coachId', 'courseNum','courseId'], 'safe'],
        ];
    }

    public function assignPrivate()
    {
        $memberCard   = MemberCard::findOne(['id' => $this->memberCardId]);
        $chargeClass  = ChargeClass::findOne(['id' => $this->courseId]);
        $courseDetail = CoursePackageDetail::findOne(['charge_class_id' => $chargeClass['id']]);
        $course       = Course::findOne(['id' => $courseDetail['course_id']]);
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
                $courseOrder->deadline_time          = time() + $chargeClass['valid_time']*(24*60*60);
                $courseOrder->product_id             = $this->courseId;
                $courseOrder->product_type           = 1;
                $courseOrder->private_type           = '赠送私教';
                $courseOrder->private_id             = $this->coachId;
                $courseOrder->seller_id              = $this->coachId;
                $courseOrder->present_course_number  = $this->courseNum;
                $courseOrder->surplus_course_number  = $this->courseNum;
                $courseOrder->service_pay_id         = $this->courseId;
                $courseOrder->member_card_id         = $this->memberCardId;
                $courseOrder->member_id              = $memberCard['member_id'];
                $courseOrder->business_remarks       = '分配私教';
                $courseOrder->product_name           = $chargeClass['name'];
                $courseOrder->type                   = 2;
                $courseOrder->activeTime             = time();
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

                $memberData    = Member::findOne(['id'=>$memberCard['member_id']]);
                $dealId        = Deal::find()->where(['and',['type'=>2],['id'=>$chargeClass['deal_id']]])->asArray()->one();
                if(!empty($dealId)){
                    $dealDetailsId = DealType::findOne(['id'=>$dealId['deal_type_id']]);
                    $dealRecord    = MemberDealRecord::findOne(['type' => 2,'type_id' => $orderDetails['id'],'member_id' => $memberData['id']]);
                    if(empty($dealRecord)){
                        $dealRecord = new MemberDealRecord();
                    }
                    $dealRecord->type             = 2;
                    $dealRecord->type_id          = $orderDetails['id'];
                    $dealRecord->member_id        = $memberData['id'];
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
}