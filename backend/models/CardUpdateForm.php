<?php
namespace backend\models;

use common\models\base\MemberCard;
use common\models\base\Member;
use common\models\base\MemberDetails;
use common\models\base\CardCategory;
use common\models\base\ConsumptionHistory;
use common\models\base\Order;
use common\models\base\Employee;
use yii\base\Model;
use common\models\Func;
use Yii;
class CardUpdateForm extends Model
{
    public $cardId;       //旧会员卡id
    public $sellPrice;    //售价
    public $discount;     //折扣
    public $seller;       //销售员
    public $newCardId;    //新卡种id
    public $card_number;    //设置卡号
    public $giftStatus;    //领取状态
    /**
     * 云运动 - 会员管理 - 会员卡升级 表单规则验证
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/5/24
     * @return array
     */
    public function rules()
    {
        return [
            [['cardId','giftStatus','card_number'],'safe'],

            ['sellPrice','trim'],

            ['sellPrice','required','message' => '请填写售价'],

            ['card_number', 'unique', 'targetClass' => '\common\models\base\MemberCard', 'message' => '会员卡号已存在！'],

            ['discount','trim'],

            ['seller','required','message' => '请选择销售员'],

            ['newCardId','required','message' => '请选择卡种'],
        ];
    }

    /**
     * @云运动 - 会员管理 - 会员卡升级
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @params $cardId 新卡id
     * @create 2017/5/25
     * @inheritdoc
     */
    public function saveCardUpdate($companyId,$venueId)
    {
        $oldCard      = MemberCard::findOne(['id' => $this->cardId]);//旧卡数据
        $member       = Member::findOne(['id' => $oldCard['member_id']]);//旧卡关联的会员数据
        $cardCategory = CardCategory::findOne(['id' => $this->newCardId]);//新卡种id
        $time         = json_decode($cardCategory['duration'],true);//有效期
        $leave        = json_decode($cardCategory['leave_long_limit'],true);//最长请假天数

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $member->counselor_id         = $this->seller;
            $member = $member->save() ? $member : $member->errors;
            if(!isset($member->id)){
                throw new \Exception('操作失败');
            }

            $oldCard ->status = "2";
            $oldCard = $oldCard->save() ? $oldCard : $oldCard->errors;
            if(!isset($oldCard->id)){
                throw new \Exception('操作失败');
            }

            $memberCard                     = new MemberCard();
            $memberCard->member_id         = $member['id'];                               //会员ID
            $memberCard->card_category_id = $this->newCardId;                           //卡种
//            $memberCard->card_number       = (string)'0'.mt_rand(0,10).time();            //卡号
//            $memberCard->card_number       = $this->cardNumber;              //设置的新卡号
            $memberCard->card_number         = !empty($this->card_number)?"$this->card_number":(string)'0'.mt_rand(0,10).time();
            $memberCard->create_at         = time();                                      //时间
            if($this->discount != null){
                $memberCard->amount_money = ($this->sellPrice) * ($this->discount/10);  //金额
            }else{
                $memberCard->amount_money = $this->sellPrice;                           //金额
            }
            $memberCard->status              = 1;                                        //状态
            $memberCard->payment_type       = 1;                                        //付款方式
            $memberCard->is_complete_pay    = 1;                                       //完成付款
            $memberCard->total_times        = $cardCategory['times'];                  //总次数(次卡)
            $memberCard->consumption_times = 0;                                        //消费次数
            $memberCard->invalid_time       = time()+($time['day']*24*60*60);          //失效时间
            $memberCard->level               = 1;                                       //等级
            $memberCard->employee_id        = $this->seller;                          //销售
            $memberCard->card_name          = $cardCategory['card_name'];              //卡名
            $memberCard->another_name       = $cardCategory['another_name'];          //另一个卡名
            $memberCard->card_type          = $cardCategory['category_type_id'];      //卡类别
            $memberCard->count_method       = $cardCategory['count_method'];          //计次方式
            $memberCard->attributes         = $cardCategory['attributes'];             //属性
            $memberCard->active_limit_time = $cardCategory['active_time'];            //激活期限
            $memberCard->transfer_num       = $cardCategory['transfer_number'];       //转让次数
            $memberCard->surplus            = $cardCategory['transfer_number'];       //剩余转让次数
            $memberCard->transfer_price     = $cardCategory['transfer_price'];        //转让金额
            $memberCard->recharge_price     = $cardCategory['recharge_price'];        //充值卡充值金额
            $memberCard->present_money      = $cardCategory['recharge_give_price'];  //买赠金额
            $memberCard->renew_price        = $cardCategory['renew_price'];           //续费价
            $memberCard->renew_best_price   = $cardCategory['offer_price'];          //续费优惠价
            $memberCard->renew_unit         = $cardCategory['renew_unit'];            //续费多长时间/天
            $memberCard->leave_total_days   = $cardCategory['leave_total_days'];     //请假总天数
            $memberCard->leave_least_days   = $cardCategory['leave_least_Days'];     //每次请假最少天数
            $memberCard->leave_days_times   = json_encode($leave);                   //每次请假天数、请假次数
            $memberCard->deal_id             = $cardCategory['deal_id'];               //合同id
            $memberCard->active_time         = time();
            $memberCard->duration            = $time['day'];                         //有效期
            $memberCard->company_id          = $companyId;                            //公司id
            $memberCard->venue_id            = $venueId;                              //场馆id
            $memberCard->usage_mode          = $oldCard['usage_mode'];
            $memberCard = $memberCard->save() ? $memberCard : $memberCard->errors;
            if(!isset($memberCard->id)){
                throw new \Exception('操作失败');
            }else{
//                $oldCard = MemberCard::findOne(['id' => $this->cardId]);
//                $oldCard->delete();

                $consumption                        = new ConsumptionHistory();
                $consumption->member_id            = $member['id'];                                     //会员id
                $consumption->consumption_type    = 'card';                                            //消费类型
                $consumption->type                 = 1;                                                  //消费方式
                $consumption->consumption_type_id = $memberCard->id;                                   //消费项目id
                $consumption->consumption_date    = time();                                            //消费日期
                if($this->discount != null){
                    $consumption->consumption_amount = ($this->sellPrice) * ($this->discount/10);     //消费金额
                    $consumption->cash_payment        = ($this->sellPrice) * ($this->discount/10);     //现金付款
                }else{
                    $consumption->consumption_amount = $this->sellPrice;                              //消费金额
                    $consumption->cash_payment        = $this->sellPrice;                              //现金付款
                }
                $consumption->consumption_time = time();                                               //消费时间
                $consumption->consumption_times = 1;                                                   //消费次数
                $consumption->venue_id          = $venueId;                                             //场馆id
                $consumption->seller_id         = $this->seller;                                       //销售员id
                $consumption->describe          = json_encode('由'.$oldCard->card_name.'升级为'.$cardCategory->card_name);    //消费描述
                $consumption->category          = '升级';
                $consumption->company_id        = $companyId;
                $consumption->due_date          = $memberCard['invalid_time'];              //到期日期
                $consumption = $consumption->save() ? $consumption : $consumption->errors;
                if(!isset($consumption->id)){
                    throw new \Exception('操作失败');
                }
            }
            $gift = $this->saveRecord($memberCard);
            if($gift !== true){
                throw new \Exception('操作失败');
            }

            $order = $this->saveOrder($member,$memberCard,$cardCategory,$companyId,$venueId);
            if(!isset($order->id)){
                throw new \Exception('操作失败');
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
     * 云运动 - 售卡系统 - 存储进场次数核算表
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/6/23
     * @return array
     */
    public function saveRecord($memberCard)
    {
        $limit = \common\models\base\BindPack::find()->where(['card_category_id' => $this->newCardId,'polymorphic_type'=>'gift'])->asArray()->all();
        if(isset($limit)){
            foreach($limit as $k=>$v){
                $goods      = Goods::find()->where(['id'=>$v['polymorphic_id']])->asArray()->one();
                $gift    = new \common\models\base\GiftRecord();
                $gift->member_card_id = $memberCard->id;
                $gift->member_id      = $memberCard->member_id;
                $gift->num            = $v['number'];
                $gift->name           = $goods['goods_name'];
                $gift->create_at      = time();
                $gift->service_pay_id = $goods['id'];
                $gift->status         = $this->giftStatus;
                if($this->giftStatus == 1){
                    $gift->get_day = null;
                }else{
                    $gift->get_day = time();
                }
                if(!$gift->save()){
                    return $gift->errors;
                }
            }
            return true;
        }
        return true;
    }

    /**
     * @云运动 - 会员管理 - 会员卡升级 查询新卡信息
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/25
     * @inheritdoc
     */
    public function getNewCard($id)
    {
        $card = CardCategory::find()->where(['id' => $id])->asArray()->one();
        return $card;
    }

    /**
     * 云运动 - 售卡系统 - 存储订单表
     * @author 黄华<huanghua@itsports.club>
     * @create 2017/8/11
     * @param $member
     * @param $memberCard
     * @param $cardCategory
     * @param $companyId
     * @param $venueId
     * @return array
     */
    public function saveOrder($member,$memberCard,$cardCategory,$companyId,$venueId)
    {
        $saleName   = Employee::findOne(['id' => $this->seller]);
        $adminModel = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $memberDetails = MemberDetails::findOne(['member_id'=>$member['id']]);
        $order      = Order::findOne(['member_id' => $member['id'],'status' => 1]);
        if(isset($order) && !empty($order)){
            $order  = Order::findOne(['member_id' => $member['id'],'status' => 1]);
        }else{
            $order                  = new Order();
        }
        $order->venue_id           = $venueId;                                              //场馆id
        $order->company_id         = $companyId;                                           //公司id
        $order->member_id          = $member->id;                                          //会员id
        $order->card_category_id   = $memberCard->id;                                     //会员卡id
        $order->order_time         = time();                                               //订单创建时间
        $order->pay_money_time     = time();                                               //付款时间
        $order->pay_money_mode       = 1;                                    //付款方式
        $order->sell_people_id       = $saleName['id'];                                      //售卖人id
        $order->create_id            = isset($adminModel->id)?intval($adminModel->id):0;    //操作人id
        $order->payee_id            = isset($adminModel->id)?intval($adminModel->id):0;    //操作人id
        $order->status               = 2;                                                     //订单状态：2已付款
        $order->note                 = '升级';                                                //备注
        $number                      = Func::setOrderNumber();
        $order->order_number        = "{$number}";                                           //订单编号
        $order->all_price           = $memberCard['amount_money'];                                    //商品总价格
        $order->total_price         = $memberCard['amount_money'];                  //总价
        $order->card_name           = $cardCategory->card_name;                              //卡名称
        $order->sell_people_name    = $saleName['name'];                                     //售卖人姓名
        $order->payee_name          = $adminModel['name'];                                     //收款人姓名
        $order->member_name         = $memberDetails['name'];                                           //购买人姓名
        $order->pay_people_name     = $memberDetails['name'];                                           //付款人姓名
        $order->consumption_type    = 'card';
        $order->consumption_type_id = $memberCard->id;
        $order = $order->save() ? $order : $order->errors;
        if ($order) {
            return $order;
        }else{
            return $order->errors;
        }
    }
}