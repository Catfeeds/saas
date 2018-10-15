<?php
namespace backend\modules\v3\models;

use backend\models\Course;
use backend\models\CoursePackageDetail;
use backend\models\MemberCourseOrderDetails;
use common\models\base\Cabinet;
use common\models\base\ChargeClassNumber;
use common\models\base\MemberCabinet;
use common\models\base\MemberCabinetRentHistory;
use common\models\MemberCourseOrder;
use yii\base\Model;
use common\models\Func;
use common\models\base\Order;
use common\models\base\Employee;
use common\models\base\MemberCard;
use common\models\base\ChargeClass;
use common\models\base\CardCategory;
use common\models\base\LimitCardNumber;
use common\models\base\VenueLimitTimes;
use common\models\base\ConsumptionHistory;

class PaymentForm extends Model
{
    public $memberId;               //姓名
    public $cardCateGoryId;        //卡种
    public $paymentType;           //付款方式
    public $payTimes;              //分期月数
    public $firstPayMonths;       //首付月数
    public $firstPayPrice;        //首付金额
    public $monthPrice;           //每月还款金额
    public $amountMoney;          //总金额
    public $payMethod;            //付款方式
    public $typeId;
    public $type;
    public $cardName;
    public $name;
    public $saleMan;
    public $mobile;
    public $num;
    public $coachId;               // 教练id
    public $sign;                  //用户签名图片

    const CODE   = 'code';
    const NOTICE = '操作失败';

    /**
     * 云运动 - 售卡系统 - 售卡表单规则验证
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/5/13
     * @return array
     */
    public function rules()
    {
        return [
            ['memberId', 'required', 'message' => '请选择会员'],
            ['sign', 'validScenario'],
            [['payTimes', 'firstPayMonths','num', 'typeId','type','firstPayPrice', 'monthPrice', 'amountMoney','idCard','payMethod',"coachId"], 'safe'],
        ];
    }

    /**
     * 运运动-微信售卖系统-自定义验证
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/3/7
     * @param $attribute
     */
    public function validScenario($attribute)
    {
        if($this->type == 'charge' || $this->type == 'card'){
            if(!$this->sign){
                $this->addError($attribute, '请上传签名');
            }
        }
    }
    /**
     * @云运动 - 售卡系统 - 判断卡种售卖张数
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/22
     * @inheritdoc
     */
    public function setSellNum($cardCateGoryId){
        if($cardCateGoryId){
            $limitCardNum = LimitCardNumber::findOne(['card_category_id' => $cardCateGoryId]);
            if($limitCardNum['limit'] == -1){
                return true;
            }else{
                $num = $limitCardNum['surplus'];
                if($num <= 0){
                    return '此卡种已售卖完，请选择其他卡种';
                }else{
                    return true;
                }
            }
        }
    }

    /**
     * 云运动 - 微信售卡系统 - 销售会员卡
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @create 2018/2/7
     * @return array
     */
    public function paymentCard()
    {
        if($this->type == 'charge'){
            $data = ChargeClass::findOne(['id' => $this->typeId]);           //查出所选私教的信息
        }elseif($this->type == 'cabinet' || $this->type == 'charge'){
            $data = MemberCard::findOne(['member_id' => $this->memberId]);   //查出会员卡种的信息
        }else{
            $data = CardCategory::findOne(['id' => $this->typeId]);          //查出所选卡种的信息
        }
        $member   = \common\models\base\Member::findOne(['id' => $this->memberId]);   //查询所填手机号的会员信息
        if(empty($member)){
            return ['data'=>'会员不存在'];
        }
        $companyId = $member->company_id;
        $venueId   = $member->venue_id;
        $order     = $this->savePreOrder($member,$data,$companyId,$venueId);
        if(isset($order->id)){
            $this->mobile = $member->mobile;
            return $order;
        }
        return false;
    }

    /**
     * 云运动 - 微信售卡系统 - 存储订单表
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @create 2018/2/7
     * @return array
     */
    public function savePreOrder($member,$data,$companyId,$venueId)
    {
        $saleName = Employee::findOne(['id' => $this->saleMan]);
        if(isset(\Yii::$app->user->identity->id) && empty($this->isNotMachinePay)){
            $adminModel = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        }else{
            $adminModel = [];
        }
        $order                         = new Order();
        $order->venue_id               = !empty($venueId)?$venueId:0;                                              //场馆id
        $order->company_id             = !empty($companyId)?$companyId:0;                                           //公司id
        $order->member_id              = $member->id;   //会员id
        $order->consumption_type       = $this->type;   //消费类型修正;
        if($this->type == 'card'){
            $order->consumption_type_id = $this->typeId;
        }
        if($this->type == 'charge'){
            $memberCard = MemberCard::findOne(['member_id' => $this->memberId]);
            $order->card_category_id   = $memberCard->id;    //会员卡id
            $order->note               = "购买私课";
            $order->purchase_num       = $this->num;
            $order->many_pay_mode      = json_encode(['type' => 2,'price' => $this->amountMoney]);
            if(!empty($this->coachId)){
                $order->new_note       = (string)$this->coachId;
            }
        }else{
            if($this->type == 'cabinet'){
                $order->card_category_id   = $data->id;
                $order->note               = "租柜";
                $order->consumption_type   = "cabinet";
            }else{
                $order->card_category_id   = $data->id;
                $order->note               = "办卡";
            }
            $order->purchase_num       = 1;
        }
        $order->net_price              = $this->amountMoney;
        $order->all_price              = $this->amountMoney;
        $order->total_price            = $this->amountMoney;                                    //总价
        $order->order_time             = time();                                                //订单创建时间
        $order->pay_money_time         = time();                                                //付款时间
        $order->pay_money_mode         = 3; //付款方式：微信付款
        $order->sell_people_id         = intval($this->saleMan);                                //售卖人id
        $order->create_id              = isset($adminModel->id)?intval($adminModel->id):0;      //操作人id
        $order->status                 = 1;                                                     //订单状态：2已付款
        $number                        = Func::setOrderNumber();
        $order->order_number           = "{$number}";                                           //订单编号
        if($this->type == 'cabinet'){
            $order->card_name          = "租柜";
        }else{
            $order->card_name          = isset($data->card_name)?$data->card_name:$data->name;  //卡名称
        }
        $order->sell_people_name       = isset($saleName['name'])?$saleName['name']:null;       //售卖人姓名
        $order->member_name            = $member->username;                                     //购买人姓名
        $order->pay_people_name        = $member->username;                                     //付款人姓名
        $order->is_receipt             = 0;
        $order->sign                   = $this->sign;
        $order = $order->save() ? $order : $order->errors;
        if ($order) {
            return $order;
        }else{
            return $order->errors;
        }
    }

    /**
     * 云运动 - 微信售卡系统 - 执行销售操作
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/2/7
     */
    public function saveTheOrder($param)
    {
        $order = Order::findOne(['order_number'=>$param['order_number']]);
        if($order){
            if($order->note == '办卡'){   //购卡逻辑
                $member       = Member::findOne(['id' => $order['member_id']]);
                $companyId    = $member->company_id;
                $venueId      = $member->venue_id;
                $cardCategory = CardCategory::findOne(['id' => $order['card_category_id']]);
                if(!empty($cardCategory)){
                    $time     = json_decode($cardCategory->duration,true);
                    $leave    = json_decode($cardCategory->leave_long_limit,true);
                }
                $transaction  = \Yii::$app->db->beginTransaction();
                try{
                    //1、潜在会员转为正式会员
                    $member->member_type = 1;
                    if(!$member->save()){
                        throw new \Exception(self::NOTICE);
                    }
                    //2、订单状态转为已支付
                    $order->status = 2;
                    if(!$order->save()){
                        throw new \Exception(self::NOTICE);
                    }
                    //3、存储会员卡
                    $memberCard = $this->saveMemberCard($member,$time,$cardCategory,$leave,$companyId,$venueId);
                    if(!isset($memberCard->id)){
                        throw new \Exception(self::NOTICE);
                    }
                    //4、修改卡种剩余张数
                    $LimitCard = $this->saveLimit($cardCategory);
                    if(!isset($LimitCard->id)){
                        throw new \Exception(self::NOTICE);
                    }
                    //5、通店数据
                    $data = $this->saveVenueLimit($memberCard,$cardCategory);
                    if(!$data){
                        throw new \Exception(self::NOTICE);
                    }
                    //6、消费记录
                    $venueLimit = $this->saveConsumption($member,$memberCard,$companyId,$venueId);
                    if(!isset($venueLimit->id)){
                        throw new \Exception(self::NOTICE);
                    }
                    if ($transaction->commit() === null) {
                        return 'SUCCESS';
                    } else {
                        return false;
                    }
                } catch (\Exception $e) {
                    //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
                    $transaction->rollBack();
                    return $e->getMessage();
                }
            }elseif($order->note == '租柜'){        //租柜逻辑

                $transaction = \Yii::$app->db->beginTransaction();
                try{
                    //1、生成一条 member_cabinet 记录
                    $memberCabinet = $this->saveMemberCabinet($param,$order);
                    if(!isset($memberCabinet->id)){
                        throw new \Exception(self::NOTICE);
                    }
                    //2、生成一条 member_cabinet_rent_history 记录
                    $rentHistory   = $this->saveRentHistory($param,$order);
                    if(!isset($rentHistory->id)){
                        throw new \Exception(self::NOTICE);
                    }
                    //3、更新柜子状态：未租->已租
                    $cabinet         = Cabinet::findOne(['id'=>$param['cabinet_id']]);
                    $cabinet->status = 2;
                    if(!$cabinet->save()){
                        throw new \Exception(self::NOTICE);
                    }

                    //4、更新订单 order
                    $order->status              = 2;
                    $order->consumption_type_id = $memberCabinet->id;
                    if(!$order->save()){
                        throw new \Exception(self::NOTICE);
                    }

                    //5、生成一条 consumption_history 记录
                    $consumption = $this->saveCabinetConsumption($rentHistory,$param,$order);
                    if(!isset($consumption->id)){
                        throw new \Exception(self::NOTICE);
                    }

                    if($transaction->commit() === null){
                        return 'SUCCESS';
                    }else{
                        return false;
                    }
                } catch (\Exception $e) {
                    $transaction->rollback();
                    return $e->getMessage();
                }
            }else{    //买课逻辑
                $charge = ChargeClass::findOne(['id'=>$param['charge_id']]);
                $transaction = \Yii::$app->db->beginTransaction();
                try{
                    //1、生成一条 member_course_order 记录
                    $courserOrder = $this->saveMemberCourseOrder($param,$charge,$order);
                    if(!isset($courserOrder->id)){
                        throw new \Exception(self::NOTICE);
                    }
                    //2、生成 member_course_order_details 记录 : 不止一条
                    $courserOrderDetail = $this->saveMemberCourseOrderDetail($param,$charge,$courserOrder);
                    if(!isset($courserOrderDetail)){
                        throw new \Exception(self::NOTICE);
                    }
                    //3、更新 order 记录 : status、consumption_type_id,这里的 consumption_type:charge
                    $order->status              = 2;
                    $consumptionType = $charge->group == 1 ? 'charge' : 'chargeGroup';
                    $order->consumption_type    = $consumptionType;
                    $order->consumption_type_id = $courserOrder->id;
                    if(!$order->save()){
                        throw new \Exception(self::NOTICE);
                    }
                    //4、生成消费记录
                    $consumption = $this->saveCourseConsumption($courserOrder,$param,$order,$charge);
                    if(!isset($consumption->id)){
                        throw new \Exception(self::NOTICE);
                    }
                    //5、如果是小团体课，需要更新剩余售卖课量
                    if($charge->group == 2){
                        $chargeClassNumber = $this->updateClassNumber($param);
                        if(!$chargeClassNumber){
                            throw new \Exception(self::NOTICE);
                        }
                    }
                    if($transaction->commit() === null){
                        return 'SUCCESS';
                    }else{
                        return false;
                    }
                }catch(\Exception $e){
                    $transaction->rollBack();
                    return $e->getMessage();
                }

            }
        }else{
            return false;
        }
    }

    /**
     * 云运动 - 售卡系统 - 存储会员卡
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @create 2018/2/9
     * @return array
     */
    public function saveMemberCard($member,$time,$cardCategory,$leave,$companyId,$venueId)
    {
        $memberCard                     = new MemberCard();
        $memberCard->member_id          = $member->id;                             //会员ID
        $memberCard->card_category_id   = $cardCategory->id;                       //卡种
        $memberCard->payment_type       = 1;                                       //付款方式
        $memberCard->create_at          = time();                                  //售卡时间
        $memberCard->level              = 1;                                       //等级
        $memberCard->card_number        = (string)'0'.mt_rand(0,10).time();        //卡号
        $memberCard->is_complete_pay    = 1;                                       //完成付款
        $memberCard->invalid_time       = time()+($time['day']*24*60*60);          //失效时间
        $memberCard->amount_money       = $this->amountMoney;
        if($cardCategory->category_type_id == 3 || $cardCategory->category_type_id == 4){
            $memberCard->balance        = $cardCategory->recharge_price + $cardCategory->recharge_give_price;   //余额
        }else{
            $memberCard->balance        = 0;
        }
        $memberCard->status             = 4;
        $memberCard->usage_mode         = 1;
        $memberCard->total_times        = $cardCategory->times;                 //总次数(次卡)
        $memberCard->consumption_times  = 0;                                    //消费次数
        $memberCard->card_name          = $cardCategory->card_name;             //卡名
        $memberCard->another_name       = $cardCategory->another_name;          //另一个卡名
        $memberCard->card_type          = $cardCategory->category_type_id;      //卡类别
        $memberCard->count_method       = $cardCategory->count_method;          //计次方式
        $memberCard->attributes         = $cardCategory->attributes;            //属性
        $memberCard->active_limit_time  = $cardCategory->active_time;           //激活期限
        $memberCard->transfer_num       = $cardCategory->transfer_number;       //转让次数
        $memberCard->surplus            = $cardCategory->transfer_number;       //剩余转让次数
        $memberCard->transfer_price     = $cardCategory->transfer_price;        //转让金额
        $memberCard->recharge_price     = $cardCategory->recharge_price;        //充值卡充值金额
        $memberCard->present_money      = $cardCategory->recharge_give_price;   //买赠金额
        $memberCard->renew_price        = $cardCategory->renew_price;           //续费价
        $memberCard->renew_best_price   = $cardCategory->offer_price;           //续费优惠价
        $memberCard->renew_unit         = $cardCategory->renew_unit;            //续费多长时间/天
        $memberCard->leave_total_days   = $cardCategory->leave_total_days;      //请假总天数
        $memberCard->leave_least_days   = $cardCategory->leave_least_Days;      //每次请假最少天数
        $memberCard->leave_days_times   = json_encode($leave);                  //每次请假天数、请假次数
        $memberCard->deal_id            = $cardCategory->deal_id;               //合同id
        $memberCard->duration           = $time['day'];                         //有效期
        $memberCard->venue_id           = $venueId;                             //场馆id
        $memberCard->company_id         = $companyId;                           //公司id
        $memberCard = $memberCard->save() ? $memberCard : $memberCard->errors;
        if (isset($memberCard->id)) {
//            $this->cardName      = $cardCategory->card_name;
//            $this->memberCardId  = $memberCard->id;
            return $memberCard;
        }else{
            return $memberCard->errors;
        }
    }

    /**
     * 云运动 - 售卡系统 - 存储消费记录表
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/6/6
     * @return array
     */
    public function saveConsumption($member,$memberCard,$companyId,$venueId)
    {
        $consumption                      = new ConsumptionHistory();
        $consumption->member_id           = $member->id;                //会员id
        $consumption->consumption_type    = 'card';                     //消费类型
        $consumption->type                = 1;                          //消费方式
        $consumption->consumption_type_id = $memberCard->id;            //消费项目id
        $consumption->consumption_date    = time();                     //消费日期
        $consumption->consumption_time    = time();                     //消费时间
        $consumption->venue_id            = $venueId;                   //场馆id
        $consumption->describe            = json_encode('办会员卡');     //消费描述
        $consumption->category            = '售卡';
        $consumption->due_date            = $memberCard->invalid_time;  // 新增消费时间
        $consumption->company_id          = $companyId;                 //公司id
        $consumption->consumption_amount  = isset($memberCard->amount_money) ? $memberCard->amount_money : 0 ;
        $consumption->seller_id           = isset($member->counselor_id) ? $member->counselor_id : 0 ;
        $consumption = $consumption->save() ? $consumption : $consumption->errors;
        if ($consumption) {
            return $consumption;
        }else{
            return $consumption->errors;
        }
    }

    /**
     * 云运动 - 售卡系统 - 存储卡种剩余张数
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/5/23
     * @return array
     */
    public function saveLimit($cardCategory)
    {
        $limitCardNum = LimitCardNumber::findOne(['card_category_id' => $cardCategory->id]);
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
        $limit = LimitCardNumber::find()->where(['card_category_id' => $cardCategory->id,'status'=>[1,3]])->asArray()->all();
        if(isset($limit)){
            foreach($limit as $k=>$v){
                $limitVenue = new VenueLimitTimes();
                $limitVenue->member_card_id = $memberCard->id;
                $limitVenue->venue_id       = $v['venue_id'];
                $limitVenue->total_times    = $v['times'];
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

    /**
     * 云运动 - 微信公众号、微信小程序 - 存储会员柜表
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @create 2018/2/28
     * @param $param
     * @param $order
     * @return array
     */
    public function saveMemberCabinet($param,$order)
    {
        $model = New MemberCabinet();
        $model->member_id  = $order->member_id;
        $model->price      = $order->total_price;
        $model->start_rent = $param['start_rent'];
        $model->end_rent   = $param['end_rent'];
        $model->status     = 1;
        $model->creater_id = 0;
        $model->create_at  = time();
        $model->cabinet_id = $param['cabinet_id'];
        $model->rent_type  = '新租';
        $memberCabinet     = $model->save() ? $model : $model->errors;
        return $memberCabinet;
    }

    /**
     * 云运动 - 微信公众号、微信小程序 - 存储会员租柜记录
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @create 2018/2/28
     * @param $param
     * @param $order
     * @return object
     */
    public function saveRentHistory($param,$order)
    {
        $model = new MemberCabinetRentHistory();
        $model->member_id  = $order->member_id;
        $model->price      = $order->total_price;
        $model->start_rent = $param['start_rent'];
        $model->end_rent   = $param['end_rent'];
        $model->create_at  = time();
        $model->cabinet_id = $param['cabinet_id'];
        $model->rent_type  = '新租';
        $model->give_month = $param['give_month'];
        $rentHistory       = $model->save() ? $model : $model->errors;
        return $rentHistory;
    }

    /**
     * 云运动 - 微信公众号、微信小程序 - 存储会员租柜消费记录
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @create 2018/2/28
     * @param $rentHistory
     * @param $param
     * @param $order
     * @return object
     */
    public function saveCabinetConsumption($rentHistory,$param,$order)
    {
        $model = new ConsumptionHistory();
        $model->member_id           = $order->member_id;
        $model->consumption_type    = 'cabinet';
        $model->consumption_type_id = $rentHistory->id;
        $model->type                = 1;
        $model->consumption_date    = time();
        $model->consumption_time    = time();
        $model->consumption_times   = 1;
        $model->network_payment     = $order->total_price;
        $model->venue_id            = $order->venue_id;
        $model->describe            = json_encode("cabinet");
        $model->category            = '新租柜子';
        $model->company_id          = $order->company_id;
        $model->consumption_amount  = $order->total_price;
        $model->consume_describe    = json_encode(['押金'=> $param['deposit'], '新租柜子'=> $param['total_price']]) ;
        $model->due_date            = $param['end_rent'];
        $consumption = $model->save() ? $model : $model->errors;
        return $consumption;
    }

    /**
     * 云运动 - 微信公众号、微信小程序 - 存储会员课程订单表
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @create 2018/2/28
     * @param $param
     * @param $charge
     * @param $order
     * @return object
     */
    public function saveMemberCourseOrder($param,$charge,$order)
    {
        $memberCard = MemberCard::findOne(['member_id' => $order->member_id]);
        $model = new MemberCourseOrder();
        $model->course_amount         = $param['charge_num'];
        $model->create_at             = time();
        $model->money_amount          = $param['total_price'];
        $model->overage_section       = $param['charge_num'];
        if($charge->valid_time == 0 || $charge->valid_time == null){
            $model->deadline_time     = time()+ceil($param['charge_num']/$charge->month_up_num)*30*86400;
        }else{
            $model->deadline_time     = time()+$charge->valid_time*86400;
        }
        $model->product_id            = $charge->id;
        $model->product_type          = 1;
        $model->private_type          = '健身私教';
        $model->private_id            = 0;
        $model->surplus_course_number = $param['charge_num'];
        $model->cashier_type          = 1;
        $model->service_pay_id        = $charge->id;
        $model->member_card_id        = $memberCard->id;
        $model->seller_id             = 0;
        $model->member_id             = $order->member_id;
        $model->business_remarks      = '微信';
        $model->product_name          = $charge->name;
        $model->type                  = 1;
//        $model->activeTime            = ;
        $model->set_number            = $param['charge_num'];
        $model->course_type           = 1;
        $model->pay_status            = 1;
        $courseOrder = $model->save() ? $model : $model->errors;
        return $courseOrder;
    }

    /**
     * 云运动 - 微信公众号、微信小程序 - 存储会员课程订单表
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @create 2018/3/3
     * @param $param
     * @param $charge
     * @param $courserOrder
     * @return object
     */
    public function saveMemberCourseOrderDetail($param,$charge,$courserOrder)
    {
        $coursePackageDetail = CoursePackageDetail::find()->where(['charge_class_id'=>$charge->id])->asArray()->all();
        foreach($coursePackageDetail as $k=>$v){
            $course = Course::findOne(['id'=>$v['course_id']]);
            $model = new MemberCourseOrderDetails();
            $model->course_order_id = $courserOrder->id;
            $model->course_id       = $v['course_id'];
            $model->course_num      = $param['charge_num'];
            if($charge->valid_time == 0 || $charge->valid_time == null){
                $model->course_length = ceil($param['charge_num']/$charge->month_up_num);
            }else{
                $model->course_length = $charge->valid_time;
            }
            $model->original_price  = $v['app_original'];
            $model->type            = 1;
            $model->category        = $charge->type;
            $model->product_name    = $charge->name;
            $model->course_name     = $course->name;
            $model->class_length    = $v['course_length'];
            $model->pic             = $charge->pic;
            $model->desc            = $charge->describe;
            $model->product_type    = $charge->product_type;
            $model->activated_time  = $charge->activated_time;
            $model->transfer_num    = $charge->transfer_num;
            $model->transfer_price  = $charge->transfer_price;
            $model->deal_id         = $charge->deal_id;
            $courserOrderDetail = $model->save() ? $model : $model->errors;
        }
        return $courserOrderDetail;
    }

    /**
     * 云运动 - 微信公众号、微信小程序 - 存储会员课程订单表
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @create 2018/3/3
     * @param $courserOrder
     * @param $param
     * @param $order
     * @param $charge
     * @return object
     */
    public function saveCourseConsumption($courserOrder,$param,$order,$charge)
    {
        $model = new ConsumptionHistory();
        $model->member_id           = $order->member_id;
        $type = $charge->group == 1 ? 'charge' : 'chargeGroup';
        $model->consumption_type    = $type;
        $model->consumption_type_id = $courserOrder->id;
        $model->type                = 1;
        $model->consumption_date    = time();
        $model->consumption_time    = time();
        $model->consumption_times   = 1;
        $model->network_payment     = $param['total_price'];
        $model->venue_id            = $order->venue_id;
        $model->seller_id           = 0;
//        $model->describe            = 0;
        $category = $charge->group == 1 ? '购买私课' : '购买私教小团体课程';
        $model->category            = $category;
        $model->company_id          = $order->company_id;
        $model->consumption_amount  = $param['total_price'];
        $model->remarks             = '微信购买';
        $courseConsumption = $model->save() ? $model : $model->errors;
        return $courseConsumption;
    }

    /**
     * 云运动 - 微信公众号、微信小程序 - 更新小团体课剩余销售课量
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @create 2018/3/5
     * @param $param
     * @return object
     */
    public function updateClassNumber($param)
    {
        $data   = substr(date("ymdHis"), 2, 8) . mt_rand(100000, 999999);
        $number = ChargeClassNumber::findOne(['id' => $param['charge_class_number_id']]);
        if ($number->surplus - 1 == 0) {
            if ($number->surplus_sale_num != 0) {
                $model = new ChargeClassNumber();
                $model->charge_class_id  = $number->charge_class_id;
                $model->class_people_id  = $number->class_people_id;
                $model->class_number     = $data;
                $model->sell_number      = $number->sell_number;
                $model->surplus          = $number->sell_number;
                $model->total_class_num  = $number->total_class_num;
                $model->attend_class_num = $number->total_class_num;
                $model->venue_id         = $number->venue_id;
                $model->company_id       = $number->company_id;
                $model->valid_start_time = $number->valid_start_time;
                $model->valid_time       = $number->valid_time;
                $model->sale_num         = $number->sale_num;
                $model->surplus_sale_num = $number->surplus_sale_num - 1;
                $model->save();
            }
        }
        $number->surplus = $number->surplus-1;
        $chargeClassNumber = $number->save() ? $number : $number->errors;
        return $chargeClassNumber;
    }

}