<?php
namespace backend\models;
use common\models\base\Employee;
use common\models\base\MemberCard;
use common\models\base\Member;
use common\models\base\Order;
use common\models\base\TransferRecord;
use yii\base\Model;
use common\models\base\ConsumptionHistory;
use Yii;
use common\models\Func;
class ExcelTransferCardForm extends Model
{
    public $memberCardId;       //会员卡id
    public $name;               //被转让会员姓名
    public $mobile;            //被转让会员手机号
    public $transferPrice;    //转让金额

    /**
     * 云运动 - 会员管理 - 会员转卡表单规则验证
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/5/24
     * @return array
     */
    public function rules()
    {
        return [
            ['memberCardId', 'safe'],

//            ['name', 'trim'],
//            ['name', 'required', 'message' => '请填写姓名'],

            ['mobile', 'trim'],
            ['mobile', 'required', 'message' => '请填写手机号'],

            ['transferPrice', 'trim'],
            ['transferPrice', 'required', 'message' => '请填写转让金额'],
        ];
    }

    /**
     * @云运动 - 会员管理 - 会员转卡
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/24
     * @inheritdoc
     */
    public function saveTransferCard($companyId,$venueId)
    {
        $memberCard     = MemberCard::findOne(['id' => $this->memberCardId]);//转让的会员卡id
        $member         = Member::findOne(['id' => $memberCard['member_id']]);//转让的会员
        $cardObj        = new CardCategory();
        $memberVenueId  = !empty($cardObj->getVenueIdByRole()) ? $cardObj->getVenueIdByRole() : $venueId;
        $mobile         = Member::findOne(['mobile' => $this->mobile,'venue_id'=>$memberVenueId]);//被转让的会员
        if ($memberCard['surplus'] == 0) {
            return '此卡转让次数已用完或没有转让权限';
        } else {
            if (!isset($mobile->id)) {
                return '手机号不存在';
            } else {
//                $details = MemberDetails::findOne(['member_id' => $mobile->id]);
//                if ($details['name'] != $this->name) {
//                    return '姓名与手机号不匹配';
//                } else {
                    if ($memberCard['member_id'] == $mobile->id) {
                        return '此卡已属于该会员，不需要转卡';
                    } else {
                        $transaction = Yii::$app->db->beginTransaction();
                        try {
                            $memberCard1 = MemberCard::find()->where(['member_id'=>$member['id']])
                                ->asArray();
                            $count = $memberCard1->count();
//                            $memberCourseOrder = MemberCourseOrder::findOne(['member_id'=>$member['id']]);
//                            if(!empty($memberCard1)&&$count==1&&!empty($memberCourseOrder)){
//                                return '转卡前请先把私教课转走';
//                            }
                            if(!empty($memberCard1)&&$count==1){
                                $member->member_type = 2;
                                $member->save();
                            }
                            $mobile->status = 1;
                            $mobile->member_type = 1;
                            $mobile->save();
                            $memberCard->member_id    = $mobile->id;                          //被转让会员id
                            if($memberCard->surplus - 1 <= 0){
                                $memberCard->surplus = 0;
                            }else{
                                $memberCard->surplus = $memberCard->surplus - 1;
                            }
                            $memberCard = $memberCard->save() ? $memberCard : $memberCard->errors;
                            if (!isset($memberCard->id)) {
                                throw new \Exception('操作失败');
                            } else {
                                $transfer = new TransferRecord();                              //生成转让记录表
                                $transfer->member_card_id = $this->memberCardId;             //转让的会员卡id
                                $transfer->from_member_id = $member->id;                      //转让会员id
                                $transfer->to_member_id   = $mobile->id;                      //被转让会员id
                                $transfer->transfer_price = $this->transferPrice;            //转让手续费
                                $transfer->transfer_time = time();                            //转让时间
                                if ($memberCard->surplus <= 0) {
                                    $transfer->times = 0;
                                } else {
                                    $transfer->times = $memberCard->surplus;                  //转让剩余次数
                                }
                                $transfer->path = json_encode($member->id.','.$mobile->id);    //转让路径
                                $transfer = $transfer->save() ? $transfer : $transfer->errors;
                                if (!isset($transfer->id)) {
                                    throw new \Exception('操作失败');
                                }
                            }
                            $orderRenew = $this->setOrderRenew($companyId,$venueId);                                                     //生成订单
                            if ($orderRenew !== true) {
                                return $orderRenew;
                            }
                            $history = $this->addConsumptionHistory($companyId,$venueId);                                                     //生成消费记录
                            if ($history != true) {
                                return false;
                            }
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
//                }
            }
        }
    }
    /**
     * 云运动 - 会员卡转卡 - 生成订单
     * @author huanghua <huangpengju@itsports.club>
     * @create 2017/8/7
     * @param $companyId
     * @param $venueId
     * @return array|bool
     */
    public function setOrderRenew($companyId,$venueId)
    {
        $memberCard = MemberCard::findOne(['id' => $this->memberCardId]);
        $member     = Member::findOne(['id' => $memberCard['member_id']]);
        $saleName                  = Employee::findOne(['id' => $memberCard['employee_id']]);
        $adminModel                = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $order                     = new Order();
        $order->venue_id           = $venueId;              //场馆id
        $order->member_id          = $member['id'];             //会员id
        $order->card_category_id   = $memberCard['id'];         //会员卡id
        $order->total_price        = $this->transferPrice;                //总价
        $order->order_time         = time();                      //订单创建时间
        $order->pay_money_time     = time();                      //付款时间
        $order->pay_money_mode     =  1;
//        if($this->payMethod == "现金")
//        {
//            $order->pay_money_mode = 1;
//        }else if($this->payMethod == "支付宝")
//        {
//            $order->pay_money_mode = 2;
//        }else if($this->payMethod == "微信")
//        {
//            $order->pay_money_mode = 3;
//        }else if($this->payMethod == "pos机")
//        {
//            $order->pay_money_mode = 4;
//        }
        $order->sell_people_id      = $memberCard['employee_id'];                 //售卖人id
        $order->payee_id            = \Yii::$app->user->identity->id; //收款人id
        $order->create_id           = $adminModel['id'];              //操作人id
        $order->status              = 2;                              //订单状态：1未付款；2已付款；3其他状态；
        $order->note                = '会员卡转卡';
        $number                     = Func::setOrderNumber();
        $order->order_number        = "{$number}";                    //订单编号
        $order->sell_people_name    = $saleName['name'];               //售卖人姓名
        $order->payee_name          = $adminModel['name'];             //收款人姓名
        $memberName                 = MemberDetails::findOne(['member_id' => $member['id']]);
        $order->member_name         = $memberName->name;             //购买人姓名
        $order->pay_people_name     = $memberName->name;             //付款人姓名
        $order->company_id          = $companyId;              //公司id
        $order->consumption_type_id = $memberCard['id'];          //会员卡id
        $order->consumption_type    = 'card';                    //消费类型
        $order->card_name           = $memberCard['card_name'];

//        $order->deposit             = $this->deposit;                                        //定金
//        $order->cash_coupon         = $this->cashCoupon;                                     //代金券
//        $order->net_price           = $this->netPrice;                                       //实收价格
//        $order->all_price           = $this->price;                                    //商品总价格
//        if(!empty($this->netPrice)){
//            $order->total_price         = $this->deposit + $this->netPrice;                  //总价
//        }else{
//            $order->total_price         = $this->price;                               //总价
//        }
        if($order->save())
        {
            return true;
        }else{
            return $order->errors;
        }
    }
    /**
     * 云运动 - 会员转卡 - 消费记录
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/5/20
     * @param $companyId
     * @param $venueId
     * @return boolean
     */
    public function addConsumptionHistory($companyId,$venueId)
    {
        $memberCard = MemberCard::findOne(['id' => $this->memberCardId]);
        $member     = Member::findOne(['id' => $memberCard['member_id']]);
        $history = new ConsumptionHistory();
        $history->member_id           = $member['id'];                //会员id
        $history->consumption_type    = 'card';                       //消费类型
        $history->consumption_type_id = $this->memberCardId;           //消费项目id
        $history->type                = 1;                         //消费方式
        $history->consumption_date    = time();    //消费日期
        $history->consumption_amount  = $this->transferPrice;
//        if($this->offer)
//        {
//            $history->consumption_amount  = ($this->price)*($this->offer/10);              //消费金额
//        }else{
//            $history->consumption_amount  = $this->price;
//        }
        $history->consumption_time    = time();                         //消费时间
        $history->consumption_times   = 1;                              //消费次数
        $history->category            = '转卡';                //消费类型状态
        $history->cash_payment        = $this->transferPrice;
//        if($this->payMethod == "现金"){
//            if($this->offer)
//            {
//                $history->cash_payment        = ($this->price)*($this->offer/10);              //现金付款
//            }else{
//                $history->cash_payment        = $this->price;              //现金付款
//            }
//        }else{
//            if($this->offer)
//            {
//                $history->network_payment     = ($this->price)*($this->offer/10);              //网络付款
//            }else{
//                $history->network_payment     = $this->price;              //网络付款
//            }
//        }
        $history->seller_id           = $memberCard['employee_id'];                 //销售私教id
        $history->company_id          = $companyId;
        $history->venue_id            = $venueId;
        $history->due_date            = $memberCard['invalid_time'];              //到期日期
        if($history->save()){
            return true;
        }else{
            return $history->errors;
        }
    }
}