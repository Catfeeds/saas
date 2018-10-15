<?php
namespace backend\models;
use common\models\base\MemberCard;
use common\models\base\Member;
use common\models\base\Order;
use yii\base\Model;
use common\models\base\ConsumptionHistory;
use common\models\base\MemberCourseOrder;
class NewTransferCardForm extends Model
{
    public $memberCardId;       //会员卡id
    public $newMemberId;        //会员id

    /**
     * 云运动 - 会员管理 - 会员卡转移表单规则验证
     * @author huanghua<huanghua@itsports.club>
     * @create 2018/3/15
     * @return array
     */
    public function rules()
    {
        return [
            [['memberCardId','newMemberId'], 'safe'],
        ];
    }

    /**
     * @云运动 - 会员管理 - 会员卡转移
     * @author huanghua <huanghua@itsports.club>
     * @create 2018/3/15
     * @inheritdoc
     */
    public function saveTransferCard()
    {
        $memberCard     = MemberCard::findOne(['id' => $this->memberCardId]);       //转让的会员卡信息
        $oldMember      = Member::findOne(['id' => $memberCard['member_id']]);      //转让的会员
        $newMember      = Member::findOne(['id'=>$this->newMemberId]);              //被转让的会员

        if ($memberCard['member_id'] == $this->newMemberId) {
            return '此卡已属于该会员，不需要转移';
        }
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            //1.判断转让会员名下是否有其他会员卡
            $countCard = MemberCard::find()->where(['member_id'=>$memberCard['member_id']])->asArray()->count();
            //2.查询当前会员卡办卡赠送课的记录
            $gift = GiftRecord::find()->select('id,service_pay_id')->where(['and',['member_id'=>$memberCard['member_id']],['member_card_id'=>$this->memberCardId]])->asArray()->all();
            if (!empty($gift)){
                foreach ($gift as $value) {
                    //修改购卡赠课记录
                    $giftRecord = GiftRecord::findOne($value['id']);
                    $giftRecord->member_id = $this->newMemberId;
                    $giftRecord->save();
                    //修改赠送课程
                    $course = MemberCourseOrder::findOne($value['service_pay_id']);
                    if (isset($course['overage_section']) && (int)($course['overage_section'])>0) {
                        $course->member_id = $this->newMemberId;
                        $course->note = "办卡赠送私教课随卡{$memberCard['card_number']}转让";
                        $course->save();
                    }
                }
            }

            //修改请假记录
            \common\models\base\LeaveRecord::updateAll(['leave_employee_id' => $this->newMemberId],['and',['leave_employee_id' => $memberCard['member_id'],'member_card_id' => $this->memberCardId]]);

            //3.修改转让会员的信息
            if ((int)$countCard < 2) {
                $oldMember->member_type = 3;
                $oldMember->update_at = time();
                $oldMember->save();
            }
            //4.修改被转让的会员信息
            $newMember->status = 1;
            $newMember->member_type = 1;
            $newMember->update_at = time();
            $newMember->save();

            //7.修改订单
            $orderRenew = $this->setOrderRenew();                                                     //生成订单
            if ($orderRenew !== true) {
                return $orderRenew;
            }

            //8.修改转卡消费记录
            $history = $this->addConsumptionHistory();                                                     //生成消费记录
            if ($history != true) {
                return false;
            }

            //5.修改被会员卡的会员id
            $memberCard->member_id = $this->newMemberId;
            $memberCard = $memberCard->save() ? $memberCard : $memberCard->errors;
            if (!isset($memberCard->id)) {
                throw new \Exception('操作失败');
            }

            //9.执行
            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();
        }
    }
    /**
     * 云运动 - 会员卡转卡 - 生成订单
     * @author huanghua <huangpengju@itsports.club>
     * @create 2017/8/7
     * @return array|bool
     */
    public function setOrderRenew()
    {
        $memberCard     = MemberCard::findOne(['id' => $this->memberCardId]);       //转让的会员卡信息
        $newMember      = Member::findOne(['id'=>$this->newMemberId]);              //被转让的会员
        $order          = Order::findOne(['member_id'=>$memberCard['member_id'],'card_category_id'=>$this->memberCardId]);
        if(!empty($order)){
            $order->venue_id           = $newMember['venue_id'];                    //场馆id
            $order->member_id          = $this->newMemberId;          //会员id
            $order->company_id         = $newMember['company_id'];    //公司id
            if($order->save())
            {
                return true;
            }else{
                return $order->errors;
            }
        }else{
            return true;
        }
    }
    /**
     * 云运动 - 会员转卡 - 消费记录
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/5/20
     * @return array|bool
     */
    public function addConsumptionHistory()
    {
        $memberCard     = MemberCard::findOne(['id' => $this->memberCardId]);       //转让的会员卡信息
        $newMember      = Member::findOne(['id'=>$this->newMemberId]);              //被转让的会员
        $memberHistory  = ConsumptionHistory::find()->where(['member_id'=>$memberCard['member_id']])
            ->andWhere(['and',['consumption_type'=>'card'],['consumption_type_id'=>$this->memberCardId]])
            ->asArray()
            ->one();
        if(!empty($memberHistory)){
            $history = ConsumptionHistory::findOne(['id'=>$memberHistory['id']]);
            $history->member_id           = $this->newMemberId;
            $history->company_id          = $newMember['company_id'];
            $history->venue_id            = $newMember['venue_id'];
            if($history->save()){
                return true;
            }else{
                return $history->errors;
            }
        }else{
            return true;
        }
    }
}