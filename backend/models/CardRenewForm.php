<?php
namespace backend\models;

use common\models\relations\MemberCardRelations;
use common\models\base\MemberCard;
use common\models\base\Member;
use common\models\base\ConsumptionHistory;
use common\models\base\MemberDetails;
use common\models\base\Employee;
use common\models\base\Order;
use common\models\base\LimitCardNumber;
use common\models\base\VenueLimitTimes;
use yii\base\Model;
use common\models\Func;
use common\models\base\MemberDeposit;
use common\models\base\MemberDealRecord;
use common\models\base\Deal;
use common\models\base\DealType;
use Yii;
class CardRenewForm extends Model
{
    use MemberCardRelations;
    public $memberCardId;         //会员卡id
    public $renewDate;           //续费日期  会员卡到期日期 旧会员卡到期时间
    public $renewPrice;          //续费金额   使用订金计算后的金额
    public $endTime;             //到期日   会员卡加卡种有效期的到期时间
    public $seller;             //销售员
    public $cardCategoryId;     //卡种id
    public $cardNumber;        //卡号
    public $usage_mode;    //使用方式  1自用2送人
    public $renewalWay;    //续费方式 1普通续费2有效期续费
    public $note;    //备注
    public $depositArrId;   //使用定金的id数组
    public $payType;        //付款类型1.全款,2押金
    public $totalAmount;    //卡的总金额
    /**
     * 云运动 - 会员管理 - 表单规则验证
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/5/23
     * @return array
     */
    public function rules()
    {
        return [
            [['memberCardId','cardCategoryId','cardNumber','usage_mode','renewalWay','note','payType','depositArrId','totalAmount'], 'safe'],

            ['cardCategoryId', 'trim'],
            ['cardCategoryId', 'required', 'message' => '卡种id不能为空'],

            ['renewDate', 'trim'],
            ['renewDate', 'required', 'message' => '缴费日期不能为空'],

            ['renewPrice', 'trim'],
            ['renewPrice', 'required', 'message' => '缴费金额不能为空'],

            ['endTime', 'trim'],
            ['endTime', 'required', 'message' => '合同结束日不能为空'],

            ['seller', 'required', 'message' => '请选择销售员'],
        ];
    }

    /**
     * @云运动 - 会员管理 - 会员卡续费
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/23
     * @inheritdoc
     */
    public function saveCardRenew($companyId,$venueId)
    {
        $cardCategory = CardCategory::findOne(['id' => $this->cardCategoryId]);
//        if(!empty($cardCategory['renew_price']) && ($this->renewPrice)< $cardCategory['renew_price']){
//            return '续费金额不能低于卡种定义金额';
//        }
        $time        = json_decode($cardCategory->duration,true);                  //卡种有效期
        $leave       = json_decode($cardCategory->leave_long_limit,true);         //卡种每次请假天数、请假次数
        $memberCard  = MemberCard::findOne(['id' => $this->memberCardId]);
        if($memberCard->status == 6){//对到期卡续费，新卡状态为正常
            $memberCardStatus = 1;
        }else{
            $memberCardStatus = $memberCard->status;
        }

//        $memberCard ->status = "2";
//        $memberCard ->save();
        $member      = Member::findOne(['id' => isset($memberCard->member_id) ? $memberCard->member_id : $memberCard['member_id']]);
        $memberNum = MemberCard::findOne(['card_number'=>$this->cardNumber]);
        if(!empty($memberNum)){
            return "会员卡号已存在!";
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $consultantChange = new ConsultantChangeRecord();
            $consultantChange->member_id      = $member['id'];
            $consultantChange->create_id      = $this->getCreate();
            $consultantChange->created_at     = time();
            $consultantChange->consultant_id  = $this->seller;
            $consultantChange->venue_id       = $member['venue_id'];
            $consultantChange->company_id     = $member['company_id'];
            $consultantChange->behavior       = 4;
            if(!$consultantChange->save()){
                \Yii::trace($consultantChange->errors);
                throw new \Exception('会籍记录新增失败');
            }

            if($this->renewalWay == 1){
                $memberCard                      =  new MemberCard();
                $memberCard->member_id           = $member->id;                       //会员ID
                $memberCard->card_category_id    = $this->cardCategoryId;            //卡种
                $memberCard->amount_money        = $this->totalAmount;                 //总金额
                $memberCard->employee_id         = $this->seller;                      //销售
                $memberCard->create_at           = $this->renewDate;                               //售卡时间
                $memberCard->active_time         = $this->renewDate;
                $memberCard->level               = 1;                                    //等级
                $memberCard->payment_type        = 1;
                $memberCard->card_number         = !empty($this->cardNumber)?"$this->cardNumber":(string)'0'.mt_rand(0,10).time();    //卡号
                $memberCard->is_complete_pay     = 1;                                     //完成付款

                $memberCard->invalid_time        = $this->endTime;          //失效时间
                if($cardCategory->category_type_id == 3 || $cardCategory->category_type_id == 4){
                    $memberCard->balance         = $cardCategory->recharge_price + $cardCategory->recharge_give_price;
                }else{
                    $memberCard->balance         = 0;                                      //余额
                }
                $memberCard->total_times        = $cardCategory->times;                   //总次数(次卡)
                $memberCard->consumption_times  = 0;                                      //消费次数
                $memberCard->card_name          = $cardCategory->card_name;              //卡名
                $memberCard->another_name       = $cardCategory->another_name;          //另一个卡名
                $memberCard->card_type          = $cardCategory->category_type_id;      //卡类别
                $memberCard->count_method       = $cardCategory->count_method;          //计次方式
                $memberCard->attributes         = $cardCategory->attributes;             //属性
//                $active                         = intval($this->renewDate - time())/3600;
//                $memberCard->active_limit_time  = intval($active);            //激活期限
                $memberCard->active_limit_time = $cardCategory->active_time;
                $memberCard->transfer_num       = $cardCategory->transfer_number;       //转让次数
                $memberCard->surplus            = $cardCategory->transfer_number;       //剩余转让次数
                $memberCard->transfer_price     = $cardCategory->transfer_price;        //转让金额
                $memberCard->recharge_price     = $cardCategory->recharge_price;        //充值卡充值金额
                $memberCard->present_money      = $cardCategory->recharge_give_price;  //买赠金额
                $memberCard->renew_price        = $cardCategory->renew_price;           //续费价
                $memberCard->renew_best_price   = $cardCategory->offer_price;          //续费优惠价
                $memberCard->renew_unit         = $cardCategory->renew_unit;            //续费多长时间/天
                $memberCard->leave_total_days   = $cardCategory->leave_total_days;     //请假总天数
                $memberCard->leave_least_days   = $cardCategory->leave_least_Days;     //每次请假最少天数
                $memberCard->leave_days_times   = json_encode($leave);                   //每次请假天数、请假次数
                $memberCard->status             =  $memberCardStatus;
                $memberCard->deal_id            = $cardCategory->deal_id;               //合同id
                $memberCard->duration           = $time['day'];                         //有效期
                $memberCard->venue_id           = $venueId;                              //场馆id
                $memberCard->company_id         = $companyId;                            //公司id
                $memberCard->usage_mode         = !empty($this->usage_mode)?$this->usage_mode:1;
                $memberCard->note               = $this->note;                            //公司id
                $memberCard->bring               = $cardCategory->bring;//是否带人
                $memberCard->validity_renewal    = $cardCategory['validity_renewal'];//有效期续费
                //场馆id
                $memberCard = $memberCard->save() ? $memberCard : false;
            }else{
                $memberCard->note                = $this->note;
                $memberCard->invalid_time        = $this->endTime;          //失效时间
                $memberCard->amount_money        = $memberCard['amount_money'] + $this->totalAmount;
                
                if($this->endTime <= time()){
                    $memberCard->status              = 6;
                }else{
                    $memberCard->status              = 1;
                }

                $memberCard = $memberCard->save() ? $memberCard : false;
            }

//            if(!isset($memberCard->id)){
//                throw new \Exception('操作失败');
            if($memberCard == false){
                throw new \Exception('操作失败');
            }else{
                $consumption                        = new ConsumptionHistory();
                $consumption->member_id            = $member['id'];                  //会员id
                if($this->renewalWay == 1 && $this->payType == 1){
                    $consumption->consumption_type    = 'card';                      //消费类型
                    $consumption->consumption_amount  = $this->totalAmount;            //消费金额
                }else{
                    $consumption->consumption_type    = 'cardRenew';                 //消费类型
                    $consumption->consumption_amount  = $this->renewPrice;            //消费金额
                }
                $consumption->type                 = 1;                             //消费方式
                $consumption->consumption_type_id = $memberCard['id'];             //消费项目id
                $consumption->consumption_date    = time();                        //消费日期
                $consumption->consumption_time    = time();                        //消费时间
                $consumption->consumption_times   = 1;                             //消费次数
                $consumption->cash_payment        = $this->renewPrice;             //现金付款
                $consumption->venue_id             = $venueId;                     //场馆id
                $consumption->seller_id            = $this->seller;                //销售员id
                $consumption->describe             = json_encode('会员卡续费');    //消费描述
                $consumption->category             = '续费';
                $consumption->company_id           = $companyId;                    //公司id
                $consumption->due_date             = $memberCard['invalid_time'];              //到期日期
                if($this->totalAmount == $this->renewPrice){
                    $consumption->remarks              = $this->note;
                }else{
                    $consumption->remarks              = '定金'.($this->totalAmount-$this->renewPrice).'元'.' '.'回款'.$this->renewPrice.'元';
                }
                $consumption = $consumption->save() ? $consumption : $consumption->errors;
                if(!isset($consumption->id)){
                    throw new \Exception('操作失败');
                }

                $order = $this->saveOrder($member,$memberCard,$companyId,$venueId);
                if(!isset($order->id)){
                    throw new \Exception('操作失败');
                }
            }

            $limit = $this->saveLimit($venueId);
            if(!isset($limit->id)){
                throw new \Exception('操作失败');
            }
            if ($this->renewalWay == 1) {
                $limit = $this->saveVenueLimit($memberCard,$cardCategory);
                if($limit !== true){
                    throw new \Exception('操作失败');
                }
            }
            if($this->renewalWay == 1){
                $bindMemberCard = $this->saveBindCard($memberCard);
                if($bindMemberCard !== true){
                    return $bindMemberCard;
                }
            }
            if($this->renewalWay == 1){
                $dealRecord = $this->saveDealRecord($cardCategory,$memberCard);
                if($dealRecord !== true){
                    return $dealRecord;
                }
            }

            //存在定金时执行的操作
            if(($this->payType)==2 && !empty($this->depositArrId)){
                MemberDeposit::updateAll(['is_use'=>'2'],['id'=>$this->depositArrId]);
            }

            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return  $e->getMessage();
        }
    }

    /**
     * 云运动 - 会员管理 - 查询会员卡信息
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/5/23
     * @return array
     */
    public function getMemberCard($id)
    {
        $memberCard = \backend\models\MemberCard::find()
            ->alias('mc')
            ->joinWith(['order order' => function($query){
                $query->where(['order.status' => 5,'order.consumption_type' => 'card']);
            }],false)
            ->joinWith(['cardCategory cardCategory' =>function($query){
                $query->joinWith(['cardCategoryType cardCategoryType']);
            }])
            ->where(['mc.id' => $id])
            ->select('mc.*,order.id as orderId,order.status as orderStatus')
            ->asArray()->one();
        if($memberCard !== null){
            return $memberCard;
        }else{  
            return \backend\models\MemberCard::find()->joinWith(['cardCategory cardCategory' =>function($query){
                $query->joinWith(['cardCategoryType cardCategoryType']);
            }])->where(['cloud_member_card.id' => $id])->asArray()->one();

        }
        //$memberCard = MemberAboutClass::filterData($memberCard);
    }

    /**
     * 云运动 - 售卡系统 - 存储订单表
     * @author 黄华<huanghua@itsports.club>
     * @create 2017/7/19
     * @param  $member
     * @param  $memberCardData
     * @param $companyId
     * @param $venueId
     * @return array
     */
    public function saveOrder($member,$memberCardData,$companyId,$venueId)
    {
        $saleName   = Employee::findOne(['id' =>$memberCardData['employee_id']]);
        $adminModel = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $memberName = MemberDetails::findOne(['member_id' => $member['id']]);
        $order                     = new Order();
        $order->venue_id           = $venueId;                                              //场馆id
        $order->company_id         = $companyId;                                            //公司id
        $order->member_id          = $memberCardData['member_id'];                          //会员id
        $order->card_category_id   = $memberCardData['id'];                                 //会员卡id
        $order->total_price        = $this->renewPrice;                                     //总价
        $order->order_time         = time();                                                //订单创建时间
        $order->pay_money_time     = time();                                                //付款时间
//        $order->pay_money_mode     = $this->payMethod;                                    //付款方式
        $order->sell_people_id     = intval($memberCardData['employee_id']);                //售卖人id
        $order->create_id          = isset($adminModel->id)?intval($adminModel->id):0;     //操作人id
        $order->payee_id           = isset($adminModel->id)?intval($adminModel->id):0;     //收款人id
        $order->payee_name         = $adminModel['name'];
        $order->status             = 2;                                                    //订单状态：2已付款
        $order->note               = '续费';                                               //备注
        $number                    = Func::setOrderNumber();
        $order->order_number       = "{$number}";                                          //订单编号
        $order->card_name          = $memberCardData['card_name'];                         //卡名称
        $order->sell_people_name   = $saleName['name'];                                   //售卖人姓名
        $order->member_name        = $memberName['name'];                                  //购买人姓名
        $order->pay_people_name    = $memberName['name'];                                  //付款人姓名
        $order->consumption_type_id  = $memberCardData['id'];                              //多态id
        $order->new_note            = $memberCardData['note'];
        if($this->renewalWay == 1){
            $order->consumption_type     = 'card';                                        //多态类型
        }else{
            $order->consumption_type     = 'cardRenew';                                   //多态类型
        }

        $order = $order->save() ? $order : $order->errors;
        if ($order) {
            return $order;
        }else{
            return $order->errors;
        }
    }
/**
 * 云运动 - 续费 - 存储卡种剩余张数
 * @author huanghua<huanghua@itsports.club>
 * @create 2017/10/30
 * @return array
 */
public function saveLimit($venueId)
{
    $limitCardNum = LimitCardNumber::find()
        ->where(['and',
            ['card_category_id' => $this->cardCategoryId],
            ['venue_id'=>$venueId],
            ['is not','limit',NULL]
        ])
        ->select('id,limit,surplus')
        ->asArray()->one();
    if(isset($limitCardNum)){
        $limitCardNum = LimitCardNumber::findOne(['id' => $limitCardNum['id']]);
    }
    if($limitCardNum['limit'] == -1){
        $limitCardNum->surplus = -1;
    }else{
        if($limitCardNum['surplus'] <= 0){
            $limitCardNum->surplus = 0;
        }else{
            $limitCardNum->surplus = $limitCardNum['surplus'] - 1;
        }
    }
    $limitCardNum = $limitCardNum->save() ? $limitCardNum : $limitCardNum->errors;
    if ($limitCardNum) {
        return $limitCardNum;
    }else{
        return $limitCardNum->errors;
    }
}

/**
 * 云运动 - 售卡系统 - 存储进场次数核算表
 * @author 黄华<huanghua@itsports.club>
 * @create 2017/8/11
 * @param $memberCard
 * @param $cardCategory
 * @return array
 */
public function saveVenueLimit($memberCard,$cardCategory)
{
    $limit = LimitCardNumber::find()->where(['card_category_id' => $this->cardCategoryId,'status'=>[1,3]])->asArray()->all();
    if(isset($limit)){
        foreach($limit as $k=>$v){
            $limitVenue = new VenueLimitTimes();
            $limitVenue->member_card_id = $memberCard->id;
            $limitVenue->venue_id       = $v['venue_id'];
            $limitVenue->total_times    = $v['times'];
            $limitVenue->level          = $v['level'];
            if(!empty($v['times'])){
                $limitVenue->overplus_times = $v['times'];
            }else{
                $limitVenue->overplus_times = $v['week_times'];
            }
            $limitVenue->week_times     = $v['week_times'];
            $limitVenue->venue_ids      = $v['venue_ids'];
            $limitVenue->company_id     = $cardCategory->company_id;
            if(!$limitVenue->save()){
                return $limitVenue->errors;
            }
        }
        return true;
    }
    return true;
}

    public function getCreate()
    {
        if(isset(\Yii::$app->user->identity) && !empty(\Yii::$app->user->identity)){
            $create = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
            $create = isset($create->id)?intval($create->id):0;
            return $create;
        }
        return 0;
    }

    /**
     * 云运动 - 会员普通续费 - 存储会员卡绑定套餐表
     * @author huanghua<huanghua@itsports.club>
     * @param $memberCard
     * @create 2018/4/22
     * @return array
     */
    public function saveBindCard($memberCard)
    {
        $bindData = BindPack::find()->where(['card_category_id' => $this->cardCategoryId])->asArray()->all();
        if(isset($bindData)){
            foreach($bindData as $k=>$v){
                $memberBindCard = new BindMemberCard();
                $memberBindCard->member_card_id    = $memberCard->id;
                $memberBindCard->venue_id          = $v['venue_id'];
                $memberBindCard->company_id        = $v['company_id'];
                $memberBindCard->polymorphic_id    = $v['polymorphic_id'];
                $memberBindCard->polymorphic_type  = $v['polymorphic_type'];
                $memberBindCard->number            = $v['number'];
                $memberBindCard->status            = $v['status'];
                $memberBindCard->polymorphic_ids   = $v['polymorphic_ids'];
                if(!$memberBindCard->save()){
                    return $memberBindCard->errors;
                }
            }
            return true;
        }
        return true;
    }

    /**
     * 云运动 - 续费系统 - 存储绑定合同记录表
     * @author huanghua<huanghua@itsports.club>
     * @param $cardCategory
     * @param $memberCard
     * @create 2018/5/4
     * @return array
     */
    public function saveDealRecord($cardCategory,$memberCard)
    {
        $dealId        = Deal::find()->where(['and',['type'=>1],['id'=>$cardCategory['deal_id']]])->asArray()->one();
        if (!empty($dealId)){
            $dealDetailsId = DealType::findOne(['id'=>$dealId['deal_type_id']]);
            $dealRecord    = MemberDealRecord::findOne(['type' => 1,'type_id' => $memberCard['id'],'member_id' => $memberCard['member_id']]);
            if(empty($dealRecord)){
                $dealRecord = new MemberDealRecord();
            }
            $dealRecord->type             = 1;
            $dealRecord->type_id          = $memberCard['id'];
            $dealRecord->member_id        = $memberCard['member_id'];
            $dealRecord->deal_number      = 'sp'.time().mt_rand(10000,99999);
            $dealRecord->type_name        = $dealDetailsId['type_name'];
            $dealRecord->intro            = $dealId['intro'];
            $dealRecord->company_id       = $memberCard['company_id'];
            $dealRecord->venue_id         = $memberCard['venue_id'];
            $dealRecord->create_at        = time();
            $dealRecord->name             = $dealId['name'];
            if(!$dealRecord->save()){
                return $dealRecord->errors;
            }
            $card = MemberCard::findOne(['id'=>$memberCard['id']]);
            $card ->deal_id = $dealRecord['id'];
            if(!$card->save()){
                return $card->errors;
            }
            return true;
        }else{
            return true;
        }

    }
}