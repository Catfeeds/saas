<?php
namespace backend\models;

use common\models\base\ChargeClass;
use common\models\base\Course;
use common\models\base\CoursePackageDetail;
use common\models\base\MemberCard;
use common\models\base\MemberCourseOrder;
use common\models\base\MemberCourseOrderDetails;
use common\models\base\GiftRecord;
use yii\base\Model;
use Yii;
use common\models\base\MemberDealRecord;
use common\models\base\Deal;
use common\models\base\DealType;
class AllotPrivateForm extends Model
{
    public $courseType;      //赠送类型1收费2免费3生日 pt hs birth
    public $memberCardId;   //会员卡id
    public $coachId;        //私教id
    public $courseId;      //课程id
    public $memberBirthday;//会员生日 月份 09
    public $cardCategoryId;//卡种id
    public $courseNum;//课程数量
    public $memberId;//会员id

    public function rules()
    {
        return [
            [['courseType','memberCardId', 'coachId','courseId','memberBirthday','cardCategoryId','courseNum','memberId'], 'safe'],
        ];
    }

    public function allotPrivate()
    {
        $memberCard   = MemberCard::findOne(['id' => $this->memberCardId]);
        $chargeClass  = ChargeClass::findOne(['id' => $this->courseId]);
        $courseDetail = CoursePackageDetail::findOne(['charge_class_id' => $chargeClass['id']]);
        $course       = Course::findOne(['id' => $courseDetail['course_id']]);
        $member       = \common\models\base\Member::findOne(['id'=>$memberCard['member_id']]);
        $gift = GiftRecord::find()->where(['member_card_id' => $this->memberCardId])->andWhere(['member_id' => $this->memberId])->andWhere(['class_type' => $this->courseType])->asArray()->one();
        $data = date('m',time());
        if($this->courseType == 'birth' && $this->memberBirthday != $data){
            return '该会员生日课与当前月份不匹配';
        }
        if(!empty($gift)){
            return '该会员卡已分配过该类型的课程';
        }else{
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $member ->private_id = $this->coachId;
                if($member->save()!=true){
                    return  $member->errors;
                }
                $courseOrder                         = new MemberCourseOrder();
                $courseOrder->course_amount          = $this->courseNum;
                $courseOrder->create_at              = time();
                $courseOrder->money_amount           = 0;
                $courseOrder->overage_section        = $this->courseNum;
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
                if($this->courseType == 'hs'){
                    $courseOrder->type            = 2;
                }elseif ($this->courseType == 'pt'){
                    $courseOrder->type            = 1;
                }else{
                    $courseOrder->type            = 2;
                }
                $courseOrder->activeTime             = time();
                $courseOrder->set_number             = $this->courseNum;
                if($this->courseType == 'hs'){
                    $courseOrder->course_type            = 2;
                    $courseOrder->type                   = 2;
                    $courseOrder->activeTime             = time();                         //有效期开始时间
                    $courseOrder->deadline_time          = $memberCard['invalid_time'];    //有效期截止时间，与会员卡有效期同步
                }elseif ($this->courseType == 'pt'){
                    $courseOrder->course_type            = 1;
                    $courseOrder->type                   = 1;
                    $courseOrder->activeTime             = time();                         //有效期开始时间
                    $courseOrder->deadline_time          = $memberCard['invalid_time'];    //有效期截止时间，与会员卡有效期同步
                }else{
                    $courseOrder->course_type            = 3;
                    $courseOrder->type                   = 3;
                    $courseOrder->activeTime             = mktime(0, 0, 0, date('m'),1);        //有效期开始时间，生日当月第一天
                    $courseOrder->deadline_time          = mktime(0, 0, 0, date('m')+1,1)-1;    //有效期截止时间，生日当月最后一天
                }
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
                $orderDetails = $orderDetails->save() ? $orderDetails : $orderDetails->errors;
                if(!isset($orderDetails->id)){
                    throw new \Exception('操作失败');
                }
                $dealRecord = $this->saveDealRecord($orderDetails);
                if($dealRecord !== true){
                    return $dealRecord;
                }
                $gift = $this->saveGift($courseOrder);
                if(!isset($gift->id)){
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

    /**
     * 云运动 - 分配私教 - 存储赠品表
     * @author 黄华<huanghua@itsports.club>
     * @create 2017/9/30
     * @param $courseOrder
     * @return array
     */
    public function saveGift($courseOrder)
    {

        $giftRecord                     = new GiftRecord();
        $giftRecord->member_id          = $this->memberId;
        $giftRecord->member_card_id     = $this->memberCardId;
        $giftRecord->service_pay_id     = $courseOrder['id'];
        $giftRecord->num                = $this->courseNum;
        $giftRecord->status             = 2;
        $giftRecord->name               = $courseOrder['product_name'];
        $giftRecord->create_at          = time();
        $giftRecord->get_day            = time();
        $giftRecord->class_type         = $this->courseType;

        $giftRecord = $giftRecord->save() ? $giftRecord : $giftRecord->errors;
        if ($giftRecord) {
            return $giftRecord;
        }else{
            return $giftRecord->errors;
        }
    }

    /**
     * 云运动 - 卖课系统 - 存储绑定合同记录表
     * @author huanghua<huanghua@itsports.club>
     * @param $details
     * @create 2018/5/3
     * @return array
     */
    public function saveDealRecord($details)
    {
        $chargeClass = ChargeClass::findOne(['id'=>$this->courseId]);
        $memberData    = Member::findOne(['id'=>$this->memberId]);
        $dealId        = Deal::find()->where(['and',['type'=>2],['id'=>$chargeClass['deal_id']]])->asArray()->one();
        if(!empty($dealId)){
            $dealDetailsId = DealType::findOne(['id'=>$dealId['deal_type_id']]);
            $dealRecord    = MemberDealRecord::findOne(['type' => 2,'type_id' => $details['id'],'member_id' => $this->memberId]);
            if(empty($dealRecord)){
                $dealRecord = new MemberDealRecord();
            }
            $dealRecord->type             = 2;
            $dealRecord->type_id          = $details['id'];
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
            $order = MemberCourseOrderDetails::findOne(['id'=>$details['id']]);
            $order ->deal_id = $dealRecord['id'];
            if(!$order->save()){
                return $order->errors;
            }
            return true;
        }else{
            return true;
        }
    }
}