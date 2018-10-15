<?php
namespace backend\models;

use common\models\base\CardTime;
use common\models\base\GiftRecord;
use common\models\base\MemberCardTime;
use common\models\base\MemberDeposit;
use common\models\base\Order;
use common\models\base\Employee;
use common\models\base\VenueLimitTimes;
use common\models\Func;
use common\models\base\ConsumptionHistory;
use common\models\base\ConsultantChangeRecord;
use Yii;
use yii\base\Model;
use common\models\base\Member;
use common\models\base\MemberDetails;
use common\models\base\MemberCard;
use common\models\base\CardCategory;
use common\models\base\LimitCardNumber;
use common\models\base\CardDiscount;
use common\models\base\BindPack;
use common\models\base\BindMemberCard;
use common\models\base\MemberDealRecord;
use common\models\base\Deal;
use common\models\base\DealType;
use common\models\base\MemberAccount;
use yii\helpers\VarDumper;

class SellCardForm extends Model
{
    public $name;               //姓名
    public $idCard;            //身份证号
    public $sex;               //性别
    public $mobile;            //手机号
    public $code;             //填写的验证码
    public $newCode;          //生成的验证码
    public $cardCateGoryId; //卡种
    public $paymentType;    //付款方式 1全款 2定金
    public $payTimes;        //分期月数
    public $firstPayMonths; //首付月数
    public $firstPayPrice;  //首付金额
    public $deposit;        //定金
    public $netPrice;       //实收价格
    public $allPrice;       //商品总价格
    public $monthPrice;     //每月还款金额
    public $amountMoney;    //总金额
    public $saleMan;        //销售
    public $payMethod;      //付款方式
    public $keywords;       //搜索条件
    public $sorts;          //排序
    public $cardNumber;     //卡号
    public $cardName;
    public $url;            //协议url
    public $giftStatus;
    public $usageMode;
    public $giveDay;     //赠送天数
    public $giftDayId;     //赠送id
    public $venueId;
    public $note; //备注
    public $belongVenue;//所属场馆id
    public $documentType;	               //证件类型
    public $birthDay;                     //生日
    public $depositArrId;      //使用定金的id数组
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
            ['name', 'trim'],
            ['name', 'required', 'message' => '姓名不能为空'],

            ['idCard', 'trim'],
            ['idCard', 'required', 'message' => '身份证号不能为空'],

            ['sex', 'required', 'message' => '请选择性别'],

            ['mobile', 'trim'],
            ['mobile', 'required', 'message' => '请填写手机号'],
//            ['mobile', 'setMobile'],

            ['cardCateGoryId', 'required', 'message' => '请选择卡种'],
            ['paymentType', 'required', 'message' => '请选择付款方式'],

//            [self::CODE, 'trim'],
//            [self::CODE, 'required', 'message' => '验证码不能为空！'],
//            [self::CODE, 'newCodeTime'],
            [['payTimes','giftStatus', 'firstPayMonths','cardNumber','deposit','usageMode','firstPayPrice','allPrice','netPrice', 'monthPrice', 'amountMoney','idCard','payMethod','url','giveDay','giftDayId','note','belongVenue','documentType','birthDay','depositArrId','mobile'], 'safe'],
            ['saleMan', 'required'],
        ];
    }

    /**
     * @云运动 - 售卡系统 - 验证码
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/15
     * @inheritdoc
     */
    public function loadCode()
    {
        if (Yii::$app->session->has('sms')) {
            $temp = Yii::$app->session->get('sms');
            $this->newCode = $temp['code'];
        }
    }

    /**
     * @云运动 - 售卡系统 - 验证码时间
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/15
     * @inheritdoc
     */
    public function newCodeTime($attribute)
    {
        $temp = Yii::$app->session->get('sms');
        $time = $temp['time'];
        $num = time() - $time;
        if ($num > 300) {
            $this->addError($attribute, '验证码已失效');
        }
    }

    /**
     * @云运动 - 售卡系统 - 验证码手机号
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/15
     * @inheritdoc
     */
    public function setMobile($attribute)
    {
        $temp = Yii::$app->session->get('sms');
        $mobile = $temp['mobile'];
        if ($this->mobile != $mobile) {
            $this->addError($attribute, '手机号错误，请填写接收验证码的手机号');
        }
    }

    /**
     * @云运动 - 售卡系统 - 验证码手机号、身份证号、姓名是否匹配
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/20
     * @inheritdoc
     */
    public function setIdCard($mobile,$idCard,$name)
    {
        if($mobile) {
            $member = Member::findOne(['mobile' => $mobile]);
            if(isset($member['id'])){
                $memberDetails = MemberDetails::findOne(['member_id' => $member['id']]);
                if($idCard != $memberDetails['id_card'])
                {
                    return '手机号与身份证号不匹配';
                }else{
                    if($name != $memberDetails['name']){
                        return '身份证号与姓名不匹配';
                    }else{
                        return true;
                    }
                }
            }else{
                return true;
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
     * @云运动 - 售卡系统 - 存储数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/15
     * @inheritdoc
     */
    public function setSellCard($companyId,$venueId)
    {
        $this->venueId = $venueId;
        $cardCategory  = CardCategory::findOne(['id' => $this->cardCateGoryId]);    //查出所选卡种的信息
        $time          = json_decode($cardCategory->duration,true);                  //卡种有效期
        $leave         = json_decode($cardCategory->leave_long_limit,true);         //卡种每次请假天数、请假次数
        $studentLeave  = json_decode($cardCategory->student_leave_limit,true); //学生暑寒假请假天数
        $renew         = json_decode($cardCategory->validity_renewal,true);         //卡种有效期续费
        //查询所填手机号的会员信息
        $member        =  Member::find()
                             ->where(['and',['mobile' => $this->mobile],['venue_id'=>$this->belongVenue]])
                             ->one();
        $memberNum = MemberCard::findOne(['card_number'=>$this->cardNumber]);
        if(!empty($memberNum)){
            return "会员卡号已存在!";
        }
        $giftDayData   = GiftDay::findOne(['id'=>$this->giftDayId]);
        if(isset($member)){
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if(!empty($giftDayData)){
                    if($this->giveDay!='' && $this->giftDayId!='') {
                        if (!empty($giftDayData['surplus'])) {
                            $giftDayData->surplus = $giftDayData['surplus'] - 1;
                            $giftDayData = $giftDayData->save() ? $giftDayData : $giftDayData->errors;
                            if (!isset($giftDayData->id)) {
                                throw new \Exception(self::NOTICE);
                            }
                        }
                    }
               }
                if($this->usageMode == 1){
                    $member->member_type           = 1;
                }
                $member->status                    = 1;
                $member->venue_id                  = $this->belongVenue;
                $member->counselor_id              = $this->saleMan;
                $member = $member->save() ? $member : $member->errors;
                if(!isset($member->id)){
                    throw new \Exception(self::NOTICE);
                }

                $consultantChange = new ConsultantChangeRecord();
                $consultantChange->member_id      = $member['id'];
                $consultantChange->create_id      = $this->getCreate();
                $consultantChange->created_at     = time();
                $consultantChange->consultant_id  = $this->saleMan;
                $consultantChange->venue_id       = $member['venue_id'];
                $consultantChange->company_id     = $member['company_id'];
                $consultantChange->behavior       = 2;
                if(!$consultantChange->save()){
                    \Yii::trace($consultantChange->errors);
                    throw new \Exception('会籍记录新增失败');
                }

                $memberDetails = MemberDetails::findOne(['member_id' => $member['id']]);
                if(isset($memberDetails)){
                    $memberDetails->member_id             = $member->id;
                    $memberDetails->name                  = $this->name;
                    $memberDetails->id_card               = $this->idCard;
                    $memberDetails->sex                   = $this->sex;
                    $memberDetails->document_type         = $this->documentType;
                    $memberDetails->recommend_member_id = 0;
                    $memberDetails->updated_at           = time();
                    $memberDetails->birth_date           = $this->birthDay;
                    $memberDetails = $memberDetails->save() ? $memberDetails : $memberDetails->errors;
                    if(!isset($memberDetails->id)){
                        throw new \Exception(self::NOTICE);
                    }
                }else{
                    $memberDetails = $this->saveMemberDetails($member);
                    if(!isset($memberDetails->id)){
                        throw new \Exception(self::NOTICE);
                    }
                }

                $memberCard = $this->saveMemberCard($member,$time,$cardCategory,$leave,$studentLeave,$renew,$companyId,$venueId);
                if(!isset($memberCard->id)){
                    throw new \Exception(self::NOTICE);
                }

                $consumption = $this->saveConsumption($member,$memberCard,$companyId,$venueId);
                if(!isset($consumption->id)){
                    throw new \Exception(self::NOTICE);
                }

                $order = $this->saveOrder($member,$memberCard,$cardCategory,$companyId,$venueId);
                if(!isset($order->id)){
                    throw new \Exception(self::NOTICE);
                }
                $limit = $this->saveLimit();
                if(!isset($limit->id)){
                    throw new \Exception(self::NOTICE);
                }

                $limit = $this->saveVenueLimit($memberCard,$cardCategory);
                if($limit !== true){
                    throw new \Exception(self::NOTICE);
                }
                $gift = $this->saveRecord($memberCard);
                if($gift !== true){
                    throw new \Exception(self::NOTICE);
                }
                if(isset($this->giveDay) && !empty($this->giveDay)){
                    $giftDay = $this->saveGiftDay($memberCard);
                    if($giftDay !== true){
                        throw new \Exception(self::NOTICE);
                    }
                }
                $cardTime = $this->saveCardTime($memberCard);
                if($cardTime !== true){
                    throw new \Exception(self::NOTICE);
                }
                $bindMemberCard = $this->saveBindCard($memberCard);
                if($bindMemberCard !== true){
                    return $bindMemberCard;
                }
                $dealRecord = $this->saveDealRecord($cardCategory,$memberCard);
                if($dealRecord !== true){
                    return $dealRecord;
                }
//                $memberDeposit = MemberDeposit::findOne(['member_id' => $member['id']]);     //查询会员对应的详细信息
//                if(!empty($memberDeposit) && ($this->paymentType)==2){
//                    $memberDeposit->delete();
//                    $resultDel          =   MemberDeposit::deleteAll(['id'=>$depositId]);
//                }
                if(($this->paymentType)==2 && !empty($this->depositArrId)){
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
        }else{
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $memberAccount = MemberAccount::findOne(['mobile'=>$this->mobile,'company_id'=>$companyId]);
                $password = '123456';     //会员临时密码
                $password = \Yii::$app->security->generatePasswordHash($password);
                if(empty($memberAccount)){
                    $ma                    = new MemberAccount();
                    $ma->mobile            = $this->mobile;
                    $ma->username          = $this->name;
                    $ma->password          = $password;
                    $ma->create_at         = time();
                    $ma->company_id        = $companyId;
                    $ma->save();
                    if (!isset($ma->id)) {
                        throw new \Exception(self::NOTICE);
                    }
                }

                $member                  = new Member();
                $member->username       = $this->mobile;
                $member->mobile         = $this->mobile;
                $password                = '123456';
                $password                = Yii::$app->security->generatePasswordHash($password);
                $member->password       = $password;
                $member->register_time = time();
                $member->status         = 1;
                $member->counselor_id   = $this->saleMan;
                if($this->usageMode == 2){
                    $member->member_type    = 2;
                }else{
                    $member->member_type    = 1;
                }
                $member->venue_id       = $this->belongVenue;
                $member->company_id     = $companyId;
                if(!empty($memberAccount)){
                    $member->member_account_id          = $memberAccount['id'];
                }else{
                    $member->member_account_id          = $ma->id;
                }
                $member = $member->save() ? $member : $member->errors;

                if(!isset($member->id)){
                    throw new \Exception(self::NOTICE);
                }

                $consultantChange = new ConsultantChangeRecord();
                $consultantChange->member_id      = $member['id'];
                $consultantChange->create_id      = $this->getCreate();
                $consultantChange->created_at     = time();
                $consultantChange->consultant_id  = $this->saleMan;
                $consultantChange->venue_id       = $member['venue_id'];
                $consultantChange->company_id     = $member['company_id'];
                $consultantChange->behavior       = 2;
                if(!$consultantChange->save()){
                    \Yii::trace($consultantChange->errors);
                    throw new \Exception('会籍记录新增失败');
                }

                if($this->giveDay!='' && $this->giftDayId!='') {
                    if (!empty($giftDayData['surplus'])) {
                        $giftDayData->surplus = $giftDayData['surplus'] - 1;
                        $giftDayData = $giftDayData->save() ? $giftDayData : $giftDayData->errors;
                        if (!isset($giftDayData->id)) {
                            throw new \Exception(self::NOTICE);
                        }
                    }else{

                    }
                }

                $memberDetails = $this->saveMemberDetails($member);
                if(!isset($memberDetails->id)){
                    throw new \Exception(self::NOTICE);
                }
                $memberCard = $this->saveMemberCard($member,$time,$cardCategory,$leave,$studentLeave,$renew,$companyId,$venueId);
                if(!isset($memberCard->id)){
                    throw new \Exception(self::NOTICE);
                }
                $consumption = $this->saveConsumption($member,$memberCard,$companyId,$venueId);
                if(!isset($consumption->id)){
                    throw new \Exception(self::NOTICE);
                }

                $order = $this->saveOrder($member,$memberCard,$cardCategory,$companyId,$venueId);
                if(!isset($order->id)){
                    throw new \Exception(self::NOTICE);
                }

                $limit = $this->saveLimit();
                if(!isset($limit->id)){
                    throw new \Exception(self::NOTICE);
                }

                $limit = $this->saveVenueLimit($memberCard,$cardCategory);
                if($limit !== true){
                    throw new \Exception(self::NOTICE);
                }
                $gift = $this->saveRecord($memberCard);
                if($gift !== true){
                    throw new \Exception(self::NOTICE);
                }
                if(isset($this->giveDay) && !empty($this->giveDay)){
                    $giftDay = $this->saveGiftDay($memberCard);
                    if($giftDay !== true){
                        throw new \Exception(self::NOTICE);
                    }
                }
                $cardTime = $this->saveCardTime($memberCard);
                if($cardTime !== true){
                    throw new \Exception(self::NOTICE);
                }
                $bindMemberCard = $this->saveBindCard($memberCard);
                if($bindMemberCard !== true){
                    return $bindMemberCard;
                }
                $dealRecord = $this->saveDealRecord($cardCategory,$memberCard);
                if($dealRecord !== true){
                    return $dealRecord;
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
    }

    /**
     * 云运动 - 售卡系统 - 存储会员详情表
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/5/19
     * @return array
     */
    public function saveMemberDetails($member)
    {
        $memberDetails                        = new MemberDetails();
        $memberDetails->member_id            = $member->id;
        $memberDetails->name                  = $this->name;
        $memberDetails->id_card              = $this->idCard;
        $memberDetails->sex                   = $this->sex;
        $memberDetails->recommend_member_id = 0;
        $memberDetails->created_at           = time();
        $memberDetails->document_type         = $this->documentType;
        $memberDetails->birth_date           = $this->birthDay;
        $memberDetails = $memberDetails->save() ? $memberDetails : $memberDetails->errors;
        if ($memberDetails) {
            return $memberDetails;
        }else{
            return $memberDetails->errors;
        }
    }

    /**
     * 云运动 - 售卡系统 - 存储会员卡
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/5/19
     * @return array
     */
    public function saveMemberCard($member,$time,$cardCategory,$leave,$studentLeave,$renew,$companyId,$venueId)
    {
        $memberCard                       = new MemberCard();
        $memberCard->member_id           = $member->id;                       //会员ID
        $memberCard->card_category_id   = $this->cardCateGoryId;            //卡种
        $memberCard->payment_type       = $this->paymentType;                //付款方式
        $memberCard->pay_times          = $this->payTimes;                   //分期月数
        $memberCard->paid_months        = $this->firstPayMonths;             //已付月数
        $memberCard->first_pay_price   = $this->firstPayPrice;              //首付金额
        $memberCard->month_price       = $this->monthPrice;                  //每月还款金额
        $memberCard->amount_money      = $this->amountMoney;                 //总金额
        $memberCard->employee_id       = $this->saleMan;                      //销售
        $memberCard->create_at         = time();                               //售卡时间
        $memberCard->level              = 1;                                    //等级
        $memberCard->note              = $this->note;

        $memberCard->card_number       = !empty($this->cardNumber)?$this->cardNumber:(string)'0'.mt_rand(0,10).time();    //卡号
        if($this->paymentType == 1 || $this->paymentType == 2){
            $memberCard->is_complete_pay  = 1;                                     //完成付款
        }else{
            $memberCard->is_complete_pay  = 0;                                     //未完成付款
        }
        if(!empty($this->giveDay)){
            $memberCard->invalid_time       = time()+($time['day']*24*60*60)+($this->giveDay*24*60*60);          //失效时间
        }else{
            $memberCard->invalid_time       = time()+($time['day']*24*60*60);//失效时间
        }
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
        $memberCard->active_limit_time = $cardCategory->active_time;            //激活期限
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
        $memberCard->student_leave_limit= json_encode($studentLeave);            //学生寒暑假请假天数 次数默认1

        $memberCard->deal_id             = 0;               //合同id
        if(!empty($this->giveDay)){
            $memberCard->duration            = $time['day']+$this->giveDay;                         //有效期
        }else{
            $memberCard->duration            = $time['day'];//有效期
        }
        $memberCard->venue_id            = $this->belongVenue;                              //场馆id
        $memberCard->company_id          = $companyId;                            //公司id
        $memberCard->usage_mode          = !empty($this->usageMode)?$this->usageMode:1;
        $memberCard->bring               = $cardCategory->bring;
        $memberCard->ordinary_renewal    = $cardCategory->ordinary_renewal;
        $memberCard->validity_renewal    = json_encode($renew);
        $memberCard->pic                 = $cardCategory->pic;
//        $memberCard->card_attribute      = $cardCategory['attributes'];
        $memberCard->type                = $cardCategory->card_type;
        $memberCard = $memberCard->save() ? $memberCard : $memberCard->errors;
        if ($memberCard) {
            $this->cardName              = $cardCategory->card_name;
            return $memberCard;
        }else{
            return $memberCard->errors;
        }
    }

    /**
     * 云运动 - 售卡系统 - 存储消费记录表
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/5/23
     * @return array
     */
    public function saveConsumption($member,$memberCard,$companyId,$venueId)
    {
        $consumption                      = new ConsumptionHistory();
        $consumption->member_id           = $member->id;               //会员id
        $consumption->consumption_type    = 'card';                    //消费类型
        $consumption->type                = 1;                          //消费方式
        $consumption->consumption_type_id = $memberCard->id;           //消费项目id
        $consumption->consumption_date    = time();                    //消费日期
        $consumption->consumption_time    = time();                    //消费时间
        $consumption->consumption_times   = 1;                         //消费次数
        $consumption->venue_id            = $this->belongVenue;                 //场馆id
        $consumption->seller_id           = $this->saleMan;          //销售员id
        $consumption->describe            = json_encode('办会员卡'); //消费描述
        if($this->paymentType == 1){
            $consumption->category            = '办卡';
            $consumption->consumption_amount  = $this->amountMoney;       //消费金额
            $consumption->remarks             = $this->note;
            $consumption->cash_payment        = $this->amountMoney;       //现金付款
        }else{
            $consumption->category            = '回款';
            $consumption->consumption_amount  = $this->netPrice;       //消费金额
            $consumption->remarks             = '定金'.$this->deposit.'元'.' '.'回款'.$this->netPrice.'元';
            $consumption->cash_payment        = $this->netPrice;       //现金付款
        }
        $consumption->company_id           = $companyId;              //公司id
        $consumption->due_date             = $memberCard['invalid_time'];              //到期日期
        $consumption->payment_name         = $memberCard['card_name']; //会员卡名
        $consumption = $consumption->save() ? $consumption : $consumption->errors;
        if ($consumption) {
            return $consumption;
        }else{
            return $consumption->errors;
        }
    }

    /**
     * 云运动 - 售卡系统 - 存储订单表
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/6/14
     * @return array
     */
    public function saveOrder($member,$memberCard,$cardCategory,$companyId,$venueId)
    {
        $saleName   = Employee::findOne(['id' => $this->saleMan]);
        $adminModel = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $memberId   = MemberDetails::findOne(['id_card' => $this->idCard]);
        $order      = Order::findOne(['member_id' => $memberId['member_id'],'status' => 1]);
        if(isset($order) && !empty($order)){
            $order  = Order::findOne(['member_id' => $memberId['member_id'],'status' => 1]);
        }else{
            $order                  = new Order();
        }
        $order->venue_id           = $venueId;                                              //场馆id
        $order->company_id         = $companyId;                                           //公司id
        $order->member_id          = $member->id;                                          //会员id
        $order->card_category_id   = $memberCard->id;                                     //会员卡id
        $order->order_time         = time();                                               //订单创建时间
        $order->pay_money_time     = time();                                               //付款时间
//        $order->pay_money_mode       = $this->payMethod;                                    //付款方式
        $order->many_pay_mode        = json_encode($this->payMethod);
        $order->sell_people_id       = $saleName['id'];                           //售卖人id
        $order->create_id            = isset($adminModel->id)?intval($adminModel->id):0;    //操作人id
        $order->payee_id             = isset($adminModel->id)?intval($adminModel->id):0;    //操作人id
        $order->status               = 2;                                                     //订单状态：2已付款
        if($this->paymentType == 1){
            $order->note                 = '办卡';                                                //备注
        }else{
            $order->note                 = '回款';                                                //备注
        }
        $number                      = Func::setOrderNumber();
        $order->order_number        = "{$number}";                                           //订单编号
        $order->deposit             = $this->deposit;                                        //定金
        $order->net_price           = $this->netPrice;                                       //实收价格
        $order->all_price           = $this->amountMoney;                                    //商品总价格
        if(!empty($this->netPrice)){
            $order->total_price         = $this->netPrice;                                  //总价
        }else{
            $order->total_price         = $this->amountMoney;                               //总价
        }
        $order->card_name           = $cardCategory->card_name;                              //卡名称
        $order->sell_people_name    = $saleName['name'];                                     //售卖人姓名
        $order->payee_name          = $adminModel['name'];                                     //收款人姓名
        $order->member_name         = $this->name;                                           //购买人姓名
        $order->pay_people_name     = $this->name;                                           //付款人姓名
        $order->consumption_type    = 'card';
        $order->consumption_type_id = $memberCard->id;
        $order->new_note = $memberCard['note'];
        $order = $order->save() ? $order : $order->errors;
        if ($order) {
            return $order;
        }else{
            return $order->errors;
        }
    }

    /**
     * 云运动 - 售卡系统 - 存储卡种剩余张数
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/5/23
     * @return array
     */
    public function saveLimit()
    {
        $limitCardNum = LimitCardNumber::find()
            ->where(['and',
                ['card_category_id' => $this->cardCateGoryId],
                ['venue_id'=>$this->belongVenue],
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
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/6/23
     * @return array
     */
    public function saveVenueLimit($memberCard,$cardCategory)
    {
        $limit = LimitCardNumber::find()->where(['card_category_id' => $this->cardCateGoryId,'status'=>[1,3]])->asArray()->all();
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
                $limitVenue->level          = $v['level'];
                $limitVenue->apply_start    = $v['apply_start'];
                $limitVenue->apply_end      = $v['apply_end'];
                $limitVenue->about_limit    = $v['about_limit'];
                if(!$limitVenue->save()){
                    return $limitVenue->errors;
                }
            }
            return true;
        }
        return true;
    }

    /**
     * 云运动 - 售卡系统 - 存储会员卡绑定套餐表
     * @author huanghua<huanghua@itsports.club>
     * @param $memberCard
     * @create 2017/2/10
     * @return array
     */
    public function saveBindCard($memberCard)
    {
        $bindData = BindPack::find()->where(['card_category_id' => $this->cardCateGoryId])->asArray()->all();
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
     * 云运动 - 售卡系统 - 存储进场次数核算表
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/6/23
     * @return array
     */
    public function saveRecord($memberCard)
    {
        $limit = \common\models\base\BindPack::find()->where(['card_category_id' => $this->cardCateGoryId,'polymorphic_type'=>'gift'])->asArray()->all();
        if(isset($limit)){
            foreach($limit as $k=>$v){
                $goods      = Goods::find()->where(['id'=>$v['polymorphic_id']])->asArray()->one();
                $gift    = new GiftRecord();
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
     * 云运动 - 售卡系统 - 存储赠送天数
     * @author zhumengke<zhumengke@itsports.club>
     * @create 2018/1/31
     * @return array
     */
    public function saveGiftDay($memberCard)
    {
        $giftDay = new GiftRecord();
        $giftDay->member_id      = $memberCard->member_id;
        $giftDay->member_card_id = $memberCard->id;
        $giftDay->service_pay_id = $this->giftDayId;
        $giftDay->num            = $this->giveDay;
        $giftDay->status         = 2;
        $giftDay->name           = '购卡赠送天数';
        $giftDay->create_at      = time();
        $giftDay->get_day        = time();
        $giftDay->class_type     = 'day';
        $giftDay->note           = '购卡赠送天数';
        if ($giftDay->save() == true) {
            return true;
        } else {
            return $giftDay->errors;
        }
    }

    /**
     * 云运动 - 购卡 - 存储会员卡时间表
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/12/14
     * @return array
     */
    public function saveCardTime($memberCard)
    {
        $time = CardTime::findOne(['card_category_id' => $this->cardCateGoryId]);
        if(!empty($time)) {
            $cardTime = new MemberCardTime();
            $cardTime->member_card_id = $memberCard->id;
            $cardTime->start = $time->start;
            $cardTime->end = $time->end;
            $cardTime->create_at = time();
            $cardTime->day = $time->day;
            $cardTime->week = $time->week;
            $cardTime->month = $time->month;
            $cardTime->quarter = $time->quarter;
            $cardTime->year = $time->year;
            if ($cardTime->save()) {
                return true;
            } else {
                return $cardTime->errors;
            }
        }else{
            return true;
        }
    }

    /**
     * 云运动 - 售卡系统 - 获取大上海售卖的卡种
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/5/15
     * @param  $venueId
     * @return array
     */
    public static function getCardCategory($venueId)
    {
        $limit = LimitCardNumber::find()->filterWhere(['venue_id' => !empty($venueId) ? $venueId : null])->andWhere(['>', 'sell_end_time', time()])->andWhere(['<>','surplus',0])->asArray()->all();
        $array = [];
        foreach ($limit as $arr) {
            $cardCategory = CardCategory::find()->where(['id' => $arr['card_category_id'], 'status' => 1])->asArray()->one();
            if($cardCategory){
                $array[] = $cardCategory;
            }
        }
        return $array;
    }
    /**
     * 云运动 - 会员卡升级 - 获取比老卡金额高的新卡种
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/9/14
     * @param  $venueId
     * @param $oldCardCategory
     * @param $type
     * @return array
     */
    public static function getNewCardCategory($venueId,$oldCardCategory,$type)
    {
        $limit = LimitCardNumber::find()->filterWhere(['venue_id' => !empty($venueId) ? $venueId : null])->andWhere(['>', 'sell_end_time', time()])->andWhere(['<>','surplus',0])->asArray()->all();
        $array = [];
        foreach ($limit as $arr) {
            $oldCardCategoryArr = MemberCard::findOne(['id' =>$oldCardCategory]);
            $cardCategory = CardCategory::find()->where(['id' => $arr['card_category_id'],'status' => 1])->andWhere(['or',['>','sell_price',$oldCardCategoryArr['amount_money']],['>','max_price',$oldCardCategoryArr['amount_money']]])->andWhere(['category_type_id'=>$type])->asArray()->one();
            if($cardCategory){
                $array[] = $cardCategory;
            }
        }
        return $array;
    }
    /**
     * 云运动 - 会员卡升级 - 获取比老卡金额高的新卡种
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/9/14
     * @param  $venueId
     * @param $oldCardCategory
     * @return array
     */
    public static function getAllCardCategory($venueId,$oldCardCategory)
    {
        $limit = LimitCardNumber::find()->filterWhere(['venue_id' => !empty($venueId) ? $venueId : null])->andWhere(['>', 'sell_end_time', time()])->andWhere(['<>','surplus',0])->asArray()->all();
        $array = [];
        foreach ($limit as $arr) {
            $oldCardCategoryArr = MemberCard::findOne(['id' =>$oldCardCategory]);
            $cardCategory = CardCategory::find()->where(['id' => $arr['card_category_id'],'status' => 1])->andWhere(['or',['>','sell_price',$oldCardCategoryArr['amount_money']],['>','max_price',$oldCardCategoryArr['amount_money']]])->asArray()->one();
            if($cardCategory){
                $array[] = $cardCategory;
            }
        }
        return $array;
    }

    /**
     * 云运动 - 会员卡升级 - 获取折扣
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/9/15
     * @param  $venueId
     * @param $newCardCategory
     * @return array
     */
    public static function getNewDiscount($venueId,$newCardCategory)
    {
        $limit          = LimitCardNumber::find()->filterWhere(['venue_id' => !empty($venueId) ? $venueId : null])->where(['card_category_id'=>$newCardCategory])->andWhere(['>', 'sell_end_time', time()])->andWhere(['<>','surplus',0])->asArray()->one();
        $discountCard   = CardDiscount::find()->where(['limit_card_id'=>$limit['id']])->andWhere(['<>','surplus',0])->asArray()->all();
        return $discountCard;
    }
    /**
     * 云运动 - 售卡管理 - 售卡成功发送短信
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/5
     * @return array
     */
    public function sendMessage()
    {
        $data     = $this->mobile;
        $cardName = $this->cardName;
        $url      = $this->url;
        $info     = '尊敬的会员，您已成功办理我店会员卡';
//        Func::sendSellCardInfo($data,$info);
        Func::sellAliCardSendCode($data,$cardName,$url);
        return ['status'=>'success','data'=>$info];
    }

    /**
     * 云运动 - 售卡管理 - 根据名称查询卡种
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/6
     * @return array
     */
    public function getAllCard($id,$type)
    {
        $data         = CardCategory::find()->alias("cc")->select('id,name')->orderBy($this->sorts)->asArray();
        $query        = $this->setWhereSearch($data,$id,$type);
        return $query;
    }

    /**
     * @云运动 - 售卡管理 - 卡种 处理搜索条件
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/6
     * @param $query
     * @return mixed
     */
    public function setWhereSearch($query,$id,$type)
    {
        $query->andFilterWhere([
            'like','cc.name',$this->keywords,
        ]);
        if($type && $type == 'company'){
            $query->andFilterWhere(['cc.company_id'=>$id]);
        }
        if($type && ($type == 'venue' || $type == 'department')){
            $query->andFilterWhere(['cc.venue_id'=>$id]);
        }
        return $query;
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
     * 云运动 - 售卡系统 - 存储绑定合同记录表
     * @author huanghua<huanghua@itsports.club>
     * @param $cardCategory
     * @param $memberCard
     * @create 2018/5/3
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