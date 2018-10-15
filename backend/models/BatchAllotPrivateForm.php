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
class BatchAllotPrivateForm extends Model
{

    public $memberId;//会员数组id
    public $coachId; //私教id
    public $courseId;//课程id

    public function rules()
    {
        return [
            [['memberId','coachId', 'courseId'], 'safe'],
        ];
    }

    public function allotPrivate()
    {
        $chargeClass  = ChargeClass::findOne(['id' => $this->courseId]);
        $courseDetail = CoursePackageDetail::findOne(['charge_class_id' => $chargeClass['id']]);
        $course       = Course::findOne(['id' => $courseDetail['course_id']]);

            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach (($this->memberId) as $k=>$v){
                  $member     = \common\models\base\Member::findOne(['id'=>$v]);
                  $memberCard = MemberCard::find()->where(['member_id'=>$v])->orderBy('id DESC')->asArray()->one();
                    $member ->private_id = $this->coachId;
                    if($member->save()!=true){
                        return  $member->errors;
                    }

                    $giftRecord                     = new \common\models\base\GiftRecord();
                    $giftRecord->member_id          = $v;
                    $giftRecord->member_card_id     = $memberCard['id'];
                    $giftRecord->service_pay_id     = $this->courseId;
                    $giftRecord->num                = 2;
                    $giftRecord->status             = 1;
                    $giftRecord->name               = $chargeClass['name'];
                    $giftRecord->create_at          = time();
                    $giftRecord->get_day            = time();
                    $giftRecord->class_type         = 'hs';
                    $giftRecord->note               = '批量分配私教';
                    $giftRecord->type               = 1;
                    $giftRecord = $giftRecord->save() ? $giftRecord : $giftRecord->errors;
                    if(!isset($giftRecord->id)){
                        throw new \Exception('操作失败');
                    }


                    $courseOrder                         = new MemberCourseOrder();
                    $courseOrder->course_amount          = 2;
                    $courseOrder->create_at              = time();
                    $courseOrder->money_amount           = 0;
                    $courseOrder->overage_section        = 2;
                    $courseOrder->product_id             = $this->courseId;
                    $courseOrder->product_type           = 1;
                    $courseOrder->private_type           = '赠送私教';
                    $courseOrder->private_id             = $this->coachId;
                    $courseOrder->seller_id              = $this->coachId;
                    $courseOrder->present_course_number  = 2;
                    $courseOrder->surplus_course_number  = 2;
                    $courseOrder->service_pay_id         = $this->courseId;
                    $courseOrder->member_card_id         = $memberCard['id'];
                    $courseOrder->member_id              = $v;
                    $courseOrder->business_remarks       = '批量分配私教';
                    $courseOrder->product_name           = $chargeClass['name'];
                    $courseOrder->type                   = 2;
                    $courseOrder->activeTime             = time();
                    $courseOrder->set_number             = 2;
                    $courseOrder->course_type            = 2;
                    $courseOrder->type                   = 2;
                    $courseOrder->activeTime             = time();                         //有效期开始时间
                    $courseOrder->deadline_time          = $memberCard['invalid_time'];    //有效期截止时间，与会员卡有效期同步

                    $courseOrder = $courseOrder->save() ? $courseOrder : $courseOrder->errors;
                    if(!isset($courseOrder->id)){
                        throw new \Exception('操作失败');
                    }

                    $orderDetails                    = new MemberCourseOrderDetails();
                    $orderDetails->course_order_id   = $courseOrder->id;
                    $orderDetails->course_id         = $course['id'];
                    $orderDetails->course_num        = 2;
                    $orderDetails->course_length     = $chargeClass['valid_time'];
                    $orderDetails->original_price    = $courseDetail['original_price'];
                    $orderDetails->type              = 1;
                    $orderDetails->category          = $chargeClass['type'];
                    $orderDetails->product_name      = $chargeClass['name'];
                    $orderDetails->course_name       = $course['name'];
                    $orderDetails->class_length      = $courseDetail['course_length'];
                    $orderDetails->pic               = $chargeClass['pic'];
                    $orderDetails->desc              = $chargeClass['describe'];
                    $orderDetails = $orderDetails->save() ? $orderDetails : $orderDetails->errors;
                    if(!isset($orderDetails->id)){
                        throw new \Exception('操作失败');
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