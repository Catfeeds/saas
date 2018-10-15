<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/5/19
 * Time: 11:50
 */

namespace backend\models;


use common\models\base\ChargeClass;
use common\models\base\ChargeClassService;
use common\models\base\ClassSaleVenue;
use common\models\base\ConsumptionHistory;
use common\models\base\Course;
use common\models\base\CoursePackageDetail;
use common\models\base\Employee;
use common\models\base\Member;
use common\models\base\MemberCourseOrder;
use common\models\base\MemberCourseOrderDetails;
use common\models\base\MemberCoursePackage;
use common\models\base\MemberCourseSaleVenue;
use common\models\base\MemberCourseService;
use common\models\base\MemberDetails;
use common\models\base\MemberDeposit;
use common\models\base\Order;
use common\models\base\Organization;
use common\models\base\DealChangeRecord;
use common\models\base\MemberDealRecord;
use common\models\base\Deal;
use common\models\base\DealType;
use common\models\Func;
use yii\base\Model;

class MemberOrderChargeForm extends Model
{
    public $memberId;           //会员ID
    public $chargeId;           //私教课程ID
    public $chargeType;         //私课类型
    public $coachId;            //私教销售ID
    public $nodeNumber;         //课程节数（套餐数量）
    public $saleType;           //销售渠道  (存到了业务备注字段中)
    public $renewTime;          //缴费日期
    public $payMethod;          //付款途径
    public $totalPrice;         //买课总价（新加）
    public $price;              //计算的课程总价
    public $giftStatus;
    public $offer;              //优惠折扣
    public $carryPrice;         //续费金额
    public $unitPrice = 0;      //自定义变量，购买课程单价金额
    public $totalNum = 0;       //课程总量
    public $overTime;           //延长时间
    public $endTime;            //自定义变量，课程有效期
    public $memberCardId;       //自定义变量，会员卡ID
    public $venueId;            //自定义变量，场馆ID（消费地方）
    public $memberOrderId;
    public $note;               //备注
    public $buyNote;            //私课购买备注
    public $category;
    public $productName;        //产品名称
    public $desc;               //产品介绍
    public $pic;                //产品图片
    public $type;               //类型
    public $productType;        //产品类型:1常规pt,2特色课,3游泳课
    public $activatedTime;      //激活期限
    public $transferNum;        //转让次数
    public $transferPrice;      //转让金额
    public $dealId;             //合同id
    public $courseLength;       //时长
    public $courseName;         //课种名称
    public $companyId;
    public $memberName;        //自定义会员姓名
    public $deposit;        //定金
    public $cashCoupon;     //代金券
    public $netPrice;       //实收价格
    public $payType;        //收款方式
    public $depositArrId;      //使用定金的id数组

    public function __construct(array $config,$scenario = 'add',$companyId,$venueId)
    {
        $this->companyId = $companyId;
        $this->venueId   = $venueId;
        $this->scenario = $scenario;
        parent::__construct($config);
    }

    /**
     * @私课购买续费 场景
     * @author huangpengju <huangpengju@itsports.club>
     * @create_at 2017/5/25
     * @return array
     */
    public function scenarios()
    {
        return [
            'add'=>['memberId','chargeId','giftStatus','coachId','endTime','nodeNumber','saleType','renewTime','payMethod','chargeType','totalPrice','netPrice','cashCoupon','deposit','endTime','buyNote','payType','depositArrId'],
            'carry'=>['nodeNumber','offer','memberId','chargeId','coachId','note','scenario','overTime'],
        ];
    }

    /**
     * @私课购买续费 场景 规则
     * @author huangpengju <huangpengju@itsports.club>
     * @create_at 2017/5/25
     * @return array
     */
    public function rules()
    {
        return [
            [['memberId','chargeId','coachId','nodeNumber','saleType','renewTime','payMethod','chargeType'],'trim','on'=>['add','carry']],
            [['memberId','chargeId','coachId','nodeNumber'],'required','on'=>['add','carry']],
            [['overTime'],'required','on'=>['carry']],
            [['memberId','chargeId','coachId'],'integer','on'=>['add','carry']],
            [['renewTime','chargeType'],'string','on'=>['add','carry']],
            [['saleType','renewTime','payMethod','endTime','offer','giftStatus','note','scenario','totalPrice','netPrice','cashCoupon','deposit','endTime','buyNote','payType','depositArrId'],'safe','on'=>['add','carry']]
        ];
    }

    /**
     * 云运动 - 购买私课 -  获取课程数据  //第一步通过私教课程ID（计算价格）（alone是买的单节课程）（many买的是多节课程）,计算价格和查询有效期
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/20
     * @param $chargeId     //购买课程id
     * @param $type         //购买课程类型
     */
    public function getClassInfo($chargeId,$type)
    {
        $validTime          = new \backend\models\ChargeClass();
        $times              = $validTime->getClassValidTime($chargeId);
        $dealId             = DealChangeRecord::find()->where(['and',['type'=>2],['deal_id'=>$times['deal_id']]])->orderBy("id DESC")->asArray()->one();
        if(empty($type)){
            if($times['type'] == 1){
                $type = 'many';
                $this->chargeType = 'many';
                $this->endTime    = $times['valid_time'];
            }else{
                $type = 'alone';
                $this->chargeType = 'alone';
                $this->endTime    = intval($this->endTime)*30;
            }
        }else{
            if($type == 'many'){
                $this->endTime    = $times['valid_time'];
            }else{
                $this->endTime    = intval($this->endTime);
            }
        }
        //获取课程有效期
        $this->productName  = $times['name'];                                                                            //产品名称
        $this->desc         = $times['describe'];                                                                        //产品描述
        $this->pic          = $times['pic'];                                                                             //产品图片
        $this->type         = $times['private_class_type'] ? $times['private_class_type'] : 1;//收银类型：PT
        $this->productType   = $times['product_type'];
        $this->activatedTime = $times['activated_time'];
        $this->transferNum   = $times['transfer_num'];
        $this->transferPrice = $times['transfer_price'];
        $this->dealId        = $dealId['id'];
        if($type == "alone" && $type != "many"){                                                                        //购买的是单节课程
            $model          = new ChargeClassPrice();
            $data           = $model->getAlonePrice($chargeId,$this->nodeNumber);                                       //查询私课价格（是不是在区间内）
            if(empty($data))
            {
                $data = $model->getAloneEndPrice($chargeId,$this->nodeNumber);                                       //最高区间的数据
            }
            if(!empty($data))
            {
                $model = new \backend\models\ChargeClass();
                $memberCard = $model->getMemberCard($this->memberId);       //获取会员卡信息
                if(($memberCard['create_at'] + 86400) > time())             //24小时内办卡的
                {
                    if(!empty($data['posPrice']))                   //pos价不为空
                    {
                        $this->unitPrice = $data['posPrice'];            //用pos价
                    }else{
                        $this->unitPrice= $data['unitPrice'];            //用优惠单价
                    }
                }else{
                    $this->unitPrice= $data['unitPrice'];                                                                   //课程单价
                }

                $this->totalNum = $this->nodeNumber;                                                                    //总节数
            }else{
                $data            = CoursePackageDetail::find()->where(['charge_class_id'=>$chargeId])->asArray()->one();           //课程信息
                $this->unitPrice = $data['original_price'];                                                             //课程单节原价
                $this->totalNum  = $this->nodeNumber;                                                                   //总节数
            }
            $this->price     = $this->totalNum * $this->unitPrice;       //总价
        }else{
           $this->setChargePriceNum($chargeId,$times);                           //处理套餐价格
        }
    }

    /**
     * 云运动 - 购买私课 -  获取课程数据  //第一步通过私教课程ID（计算价格）（alone是买的单节课程）（many买的是多节课程）,计算价格和查询有效期
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/7
     * @param $chargeId     //购买课程id
     * @param $times
     */
    public function setChargePriceNum($chargeId,$times)
    {
        //1.处理价格
        if(empty($times['total_amount']))                         //售价为空，用原价
        {
            $this->price = $times['original_price']* $this->nodeNumber;                //用原价
        }else{
            $this->price = $times['total_amount']* $this->nodeNumber;                  //用售价
        }
        $model = new \backend\models\ChargeClass();
        $memberCard = $model->getMemberCard($this->memberId);       //获取会员卡信息
        if(($memberCard['create_at'] + 86400) > time())             //24小时内办卡的
        {
            if(!empty($times['total_pos_price']))                   //pos价不为空
            {
                $this->price = $times['total_pos_price']* $this->nodeNumber;            //用pos价
            }
        }
        //2.处理数量
        $model = new \backend\models\CoursePackageDetail();
        $data  = $model->getClassPrice($chargeId);                                                                  //查询私课价格表//购买的是套餐课程
        foreach($data as $v)
        {
            $this->totalNum  += $v['course_num'];                                                                   //计算总数量（一套课程总数量）
        }
        $this->totalNum  = $this->nodeNumber * $this->totalNum;                                                     //购买的总节数（多套）

    }
    /**
     * 云运动 - 购买私课 -  获取会员卡id
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/20
     * @param $memberId     //会员id
     */
    public function getMemberCardId($memberId)
    {
        $model               = new MemberCard();
        $data                = $model->getMemberCardId($memberId);    //获取会员卡id
        $this->memberCardId  = $data['id'];
    }

    /**
     * 云运动 - 购买私课 - 获取销售所在场馆
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/20
     * @param $coachId          //私教id
     */
    public function getVenueId($coachId)
    {
        $model = new \backend\models\Employee();
        $data  = $model->getEmployeeModel($coachId);            //查询该私教是哪个场馆的
//        $this->venueId = $data['pid'];
    }

    /**
     * 云运动 - 会员买课 - 保存购买私教记录
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/5/19
     * @return boolean
     */
    public function saveCharge()
    {
//        $this->getVenueId($this->coachId);                                                          //获取场馆Id
        $this->getMemberCardId($this->memberId);                                                    //获取会员卡id
        if(empty($this->memberCardId)){
            return 'No MemberCardId';
        }
        $this->getClassInfo($this->chargeId,$this->chargeType);                                     //计算课程价格(获取有效期)
        if( $this->price != $this->totalPrice)
        {
            $this->price = $this->totalPrice;                                                                        //前台后台计算总价不一样
        }

        //事务
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $privateClassOrder= MemberCourseOrder::find()
                ->where(['and',['member_id'=>$this->memberId],['service_pay_id'=>$this->chargeId]])
                ->andWhere(['and',['<>','overage_section',0],['>','deadline_time',time()]])
                ->orderBy('id desc')
                ->asArray()->one();
            if(!empty($privateClassOrder)){
                $memberOrder =  $this->setTwoBuyClass($privateClassOrder);                                                 //保存购买私课订单
                if($memberOrder !== true)
                {
                    return $memberOrder;                                                                    //购买失败
                }
            }else{
                //会员第一次购买私课
                $memberOrder =  $this->setBuyClass();                                                 //保存购买私课订单
                if($memberOrder !== true)
                {
                    return $memberOrder;                                                                    //购买失败
                }
            }
                $details = $this->addCourseOrderDetails($this->memberOrderId,$this->chargeId);        //生成订单详情
                if($details == false){
                    return false;                                                                    //订单详情生成失败
                }
            $course = $this->addCoursePackage($this->memberOrderId,$this->chargeId);
            if($course != true){
                return $course;
            }
            $venue = $this->addSaleVenue($this->memberOrderId,$this->chargeId);
            if($venue != true){
                return $venue;
            }
            $server = $this->addGiftServer($this->memberOrderId,$this->chargeId);
            if($server != true){
                return $server;
            }
            $history  = $this->addConsumptionHistory();
            if($history !== true){
                return $history;                                                                        //生成消费记录失败
            }
            $order = $this->setOrder();
            if($order !== true)
            {
                return $order;
            }
            $gift = $this->saveRecord($this->memberId,$this->memberCardId);
            if($gift !== true){
                return $gift;
            }
            $dealRecord = $this->saveDealRecord($details);
            if($dealRecord !== true){
                return $dealRecord;
            }
            if(($this->payType)==2 && !empty($this->depositArrId)){
                MemberDeposit::updateAll(['is_use'=>'2'],['id'=>$this->depositArrId]);
            }
             if($transaction->commit()){
                 return false;
             }else{
                 return true;                                                                         //提交
             }
        } catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return  $e->getMessage();
        }
    }

    /**
     * 云运动 - 会员买课 - 保存购买私课记录
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/3
     * @return array|bool|MemberCourseOrder
     */
    public function setBuyClass()
    {
        $member                        = new MemberCourseOrder();
        $member->member_id             = $this->memberId;                                   //会员id（必填）
        $member->member_card_id        = $this->memberCardId;                               //会员卡id(必填)
        $member->service_pay_id        = $this->chargeId;                                   //收费项目id(必填)买的课程id
        $member->seller_id             = $this->coachId;                                    //销售私教ID(必填)
        $member->course_amount         = $this->totalNum;                                  //课程总节数
        $member->create_at             = time();                                            //买课时间
        $member->money_amount          = $this->totalPrice;                                   //总金额
        $member->overage_section       = $this->totalNum;                                  //课程剩余节数
        $member->private_type          = '健身私教';                                        //私教类别
        $member->product_id            = $this->chargeId;                                   //产品id
        $member->product_type          = 1;                                                 //私课
        if($this->chargeType == 'alone'){
            $month = date('m',time());
            $year  = date('Y',time());
            $day   = date('d',time());
            if($month + $this->endTime > 12){
                $totalMonth = ($month + $this->endTime)%12;
                $month      = floor(($month + $this->endTime)/12);
                $time = strtotime(($year+$month).'-'.$totalMonth.'-'.$day);
            }else{
                $time = strtotime($year.'-'.($month + $this->endTime).'-'.$day);
            }
            $member->deadline_time     = $time;              //课程截止时间
        }else{
            $member->deadline_time     = time() + (int)$this->endTime * 86400;     //课程截止时间
        }
        $member->private_id            = $this->coachId;                                    //私教id
        $member->note                  = $this->buyNote;
        $member->present_course_number = 0;                                                  //赠送总次数
        $member->surplus_course_number = $this->totalNum;                                    //剩余总课数
        $member->business_remarks      = $this->saleType;                                    //销售渠道
        $member->product_name          = $this->productName;                                 //产品名称
        $member->type                  = $this->type;                                        //类型：1 PT
        $member->set_number            = $this->nodeNumber;                                  //购买数量（套数或者单节）
        $member->course_type           = 1;
        $memberSave = $member->save() ? $member : $member->errors;
        if (!isset($memberSave->id)) {
            return $memberSave->errors;
        }else{
            $this->category      = '购买私课';
            $this->memberOrderId = $memberSave->id;                                                //获取订单id
            return true;
        }
    }
    /**
     * 云运动 - 会员第二次买课 - 保存购买私课记录
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/11/29
     * @param $privateClassOrder
     * @return array|bool|MemberCourseOrder
     */
    public function setTwoBuyClass($privateClassOrder)
    {
        $member                        = new MemberCourseOrder();
        $member->member_id             = $this->memberId;                                   //会员id（必填）
        $member->member_card_id        = $this->memberCardId;                               //会员卡id(必填)
        $member->service_pay_id        = $this->chargeId;                                   //收费项目id(必填)买的课程id
        $member->seller_id             = $this->coachId;                                    //销售私教ID(必填)
        $member->course_amount         = $this->totalNum;                                  //课程总节数
        $member->create_at             = time();              //创建时间                                 //买课时间
        $member->money_amount          = $this->totalPrice;                                  //总金额
        $member->overage_section       = $this->totalNum;                                  //课程剩余节数
        $member->private_type          = '健身私教';                                        //私教类别
        $member->product_id            = $this->chargeId;                                   //产品id
        $member->product_type          = 1;                                                 //私课
//        if($this->chargeType == 'alone'){
//            $member->deadline_time         = $privateClassOrder['deadline_time']+(int)$this->endTime*86400*30;              //课程截止时间
//        }else{
//            $member->deadline_time         = $privateClassOrder['deadline_time'] + (int)$this->endTime*86400*30;
//        }
        if($this->chargeType == 'alone'){
            $month = date('m',$privateClassOrder['deadline_time']);
            $year  = date('Y',$privateClassOrder['deadline_time']);
            $day   = date('d',$privateClassOrder['deadline_time']);
            if($month + $this->endTime > 12){
                $totalMonth = ($month + $this->endTime)%12;
                $month      = floor(($month + $this->endTime)/12);
                $time = strtotime(($year+$month).'-'.$totalMonth.'-'.$day);
            }else{
                $time = strtotime($year.'-'.($month + $this->endTime).'-'.$day);
            }
            $member->deadline_time     = $time;              //课程截止时间
        }else{
            $member->deadline_time     = $privateClassOrder['deadline_time'] + (int)$this->endTime * 86400;     //课程截止时间
        }
        $member->private_id            = $this->coachId;                                    //私教id
        $member->note                  = $this->buyNote;                                    //购买备注
        $member->present_course_number = 0;                                                  //赠送总次数
        $member->surplus_course_number = $this->totalNum;                                    //剩余总课数
        $member->business_remarks      = $this->saleType;                                    //销售渠道
        $member->product_name          = $this->productName;                                 //产品名称
        $member->type                  = $this->type;                                        //类型：1 PT
        $member->set_number            = $this->nodeNumber;                                  //购买数量（套数或者单节）
        $member->course_type           = 1;
        $memberSave = $member->save() ? $member : $member->errors;
        if (!isset($memberSave->id)) {
            return $memberSave->errors;
        }else{
            $this->category      = '购买私课';
            $this->memberOrderId = $memberSave->id;                                                //获取订单id
            return true;
        }
    }

    /**
     * 云运动 - 会员续费私教课 - 私课订单详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/1
     * @return boolean
     */
    public function orderDetails($data)
    {
        $charge                   = ChargeClass::findOne(['id' => $data['product_id']]);
        $chargeDetail             = CoursePackageDetail::findOne(['charge_class_id' => $charge['id']]);
        $details                  = new MemberCourseOrderDetails();
        $details->course_order_id = $this->memberOrderId;
        $details->course_id       = $chargeDetail['course_id'];
        $details->course_num      = $this->nodeNumber;
        $details->course_length   = $charge['valid_time'];
        $details->original_price  = $chargeDetail['original_price'];
        $details->sale_price      = $chargeDetail['sale_price'];
        $details->type            = 1;
        $details->category        = $charge['type'];
        $details->product_name    = $charge['name'];
        $details->course_name     = $charge['name'];
        $details->class_length    = $chargeDetail['course_length'];
        $details->pic             = $charge['pic'];
        $details->desc            = $charge['describe'];
        if($details->save()){
            return true;
        }else{
            return $details->errors;
        }
    }
    /**
     * 云运动 - 会员买课 - 消费记录
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/5/20
     * @return boolean
     */
    public function addConsumptionHistory()
    {
        $history = new ConsumptionHistory();
        $history->member_id           = $this->memberId;                //会员id
        $history->consumption_type    = 'charge';                       //消费类型
        $history->consumption_type_id = $this->memberOrderId;           //消费项目id
        $history->type                = (int)1;                         //消费方式
        $history->consumption_date    = time();    //消费日期
        $history->consumption_amount  = $this->netPrice;
        $history->consumption_time    = time();                         //消费时间
        $history->consumption_times   = 1;                              //消费次数
        $history->describe            = json_encode(['note'=>$this->note]);
        $history->category            = $this->category;                //消费类型状态
        $history->remarks             = $this->buyNote;                //购买私课备注
        if($this->offer){
            $history->cash_payment    = ($this->price)*($this->offer/10);              //现金付款
        }else{
            $history->cash_payment    = $this->netPrice;              //现金付款
        }
        if($this->offer){
            $history->network_payment  = ($this->price)*($this->offer/10);              //网络付款
        }else{
            $history->network_payment  = $this->netPrice;              //网络付款
        }
        $history->seller_id           = $this->coachId;                 //销售私教id
        $history->company_id          = $this->companyId;
        $history->venue_id            = $this->venueId;
        if($history->save()){
            return true;
        }else{
            return $history->errors;
        }
    }

    /**
     * 云运动 - 会员买课 - 生成订单详情
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/23
     * @param $orderId     //产品订单id
     * @param $chargeId     //产品id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function addCourseOrderDetails($orderId,$chargeId)
    {
        $model = new \backend\models\CoursePackageDetail();
        $data  = $model->getClassPrice($chargeId);
        foreach($data as $k=>$v)
        {
            $details = new MemberCourseOrderDetails();
            $details->course_order_id = $orderId;               //订单id
            $details->course_id       = $v['course_id'];        //课种id
            if($this->chargeType == 'alone'){
                $details->course_num      = $this->nodeNumber;       //课量
            }else{
                $details->course_num      = $v['course_num']*$this->nodeNumber;       //课量
            }
            $details->course_length   = $this->endTime;         //有效期
            $details->original_price  = $v['original_price'];   //单节原价
            $details->sale_price      = $v['sale_price'];       //单节售价
            $details->pos_price       = $v['pos_price'];        //pos售价
            $details->type            = 1;                      //订单类型
            $details->category        = $v['category'];         //类型:1多课程，2单课程

            $details->product_name    = $this->productName;   //产品名称
            $name                     = $this->getClassName($v['course_id']);
            $details->course_name     = $name['name'];          //课种名称
            $details->class_length    = $v['course_length'];    //单节课时长
            $details->pic             = $this->pic;             //产品图片
            $details->desc            = $this->desc;            //产品描述
            $details->product_type    = $this->productType;     //产品类型:1常规pt,2特色课,3游泳课
            $details->activated_time  = $this->activatedTime;   //激活期限
            $details->transfer_num    = $this->transferNum;     //转让次数
            $details->transfer_price  = $this->transferPrice;   //转让金额
            $details->deal_id         = $this->dealId;          //合同id
            if(!$details->save()){
                return false;
                break;
            }
        }
        return $details;
    }

    /**
     * 云运动 - 会员买课 - 生成会员课程套餐详情表
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/12/28
     * @param $orderId     //产品订单id
     * @param $chargeId    //产品id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function addCoursePackage($orderId,$chargeId)
    {
        $course = CoursePackageDetail::find()->where(['charge_class_id' => $chargeId])->asArray()->all();
        if(!empty($course)){
            foreach ($course as $key => $value) {
                $memberCourse = new MemberCoursePackage();
                $memberCourse->course_order_id = $orderId;
                $memberCourse->course_id       = $value['course_id'];
                $memberCourse->course_num      = $value['course_num'];
                $memberCourse->course_length   = $value['course_length'];
                $memberCourse->original_price  = $value['original_price'];
                $memberCourse->sale_price      = $value['sale_price'];
                $memberCourse->pos_price       = $value['pos_price'];
                $memberCourse->type            = $value['type'];
                $memberCourse->create_at       = time();
                $memberCourse->category        = $value['category'];
                $memberCourse->app_original    = $value['app_original'];
                if(!$memberCourse->save()){
                    return $memberCourse->errors;
                }
            }
            return true;
        }
        return true;
    }

    /**
     * 云运动 - 会员买课 - 生成会员课种售卖场馆表
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/12/28
     * @param $orderId     //产品订单id
     * @param $chargeId    //产品id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function addSaleVenue($orderId,$chargeId)
    {
        $venue = ClassSaleVenue::find()->where(['charge_class_id' => $chargeId])->asArray()->all();
        if(!empty($venue)){
            foreach ($venue as $key => $value) {
                $saleVenue = new MemberCourseSaleVenue();
                $saleVenue->course_order_id = $orderId;
                $saleVenue->venue_id        = $value['venue_id'];
                $saleVenue->sale_num        = $value['sale_num'];
                $saleVenue->sale_start_time = $value['sale_start_time'];
                $saleVenue->sale_end_time   = $value['sale_end_time'];
                $saleVenue->status          = $value['status'];
                if(!$saleVenue->save()){
                    return $saleVenue->errors;
                }
            }
            return true;
        }
        return true;
    }

    /**
     * 云运动 - 会员买课 - 生成会员私课服务赠品表
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/12/28
     * @param $orderId     //产品订单id
     * @param $chargeId    //产品id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function addGiftServer($orderId,$chargeId)
    {
        $server = ChargeClassService::find()->where(['charge_class_id' => $chargeId])->asArray()->all();
        if(!empty($server)){
            foreach ($server as $key => $value) {
                $giftServer = new MemberCourseService();
                $giftServer->course_order_id = $orderId;
                $giftServer->service_id      = $value['service_id'];
                $giftServer->gift_id         = $value['gift_id'];
                $giftServer->type            = $value['type'];
                $giftServer->category        = $value['category'];
                $giftServer->create_time     = time();
                $giftServer->service_num     = $value['service_num'];
                $giftServer->gift_num        = $value['gift_num'];
                if(!$giftServer->save()){
                    return $giftServer->errors;
                }
            }
            return true;
        }
        return true;
    }

    /**
     * 云运动 - 会员买课 - 订单详情
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/25
     * @param $memberId
     * @param $service_pay_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getChargeClass($memberId,$service_pay_id)
    {
        return MemberCourseOrder::find()
            ->where(['service_pay_id'=>$service_pay_id])
            ->andWhere(['member_id'=>$memberId])
            ->asArray()
            ->one();
    }
    /**
     * 云运动 - 售卡系统 - 存储进场次数核算表
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/6/23
     * @return array
     */
    public function saveRecord($memberId,$memberCardId)
    {
        $limit = \common\models\base\ChargeClassService::find()->where(['charge_class_id' => $this->chargeId])->andWhere(['type'=>2])->asArray()->all();
        if(isset($limit) && !empty($limit)){
            foreach($limit as $k=>$v){
                $goods      = Goods::find()->where(['id'=>$v['gift_id']])->asArray()->one();
                $gift    = new \common\models\base\GiftRecord();
                $gift->member_card_id = $memberCardId;
                $gift->member_id      = $memberId;
                $gift->num            = $v['gift_num'];
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
     * 云运动 - 会员课程续费 - 保存续费私课记录
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/3
     * @return array|bool|string
     * @throws \yii\db\Exception
     */
    public function updateCharge()
    {
        $data = MemberCourseOrder::find()->where(['id'=>$this->chargeId])->asArray()->one();                            //用订单id,获取私课产品id
        $this->chargeId = $data['product_id'];
        $data = $this->getChargeClass($this->memberId,$this->chargeId);                                                 //判断会员的续费私课是否存在
        if(empty($data))
        {
            return false;                                                                                              //私课不存在，续费失败
        }
        $this->getClassInfo($this->chargeId,$this->chargeType);                                                         //续费价格和数量处理
        $transaction                 = \Yii::$app->db->beginTransaction();
        try {
            $data                    = $this->getChargeClass($this->memberId,$this->chargeId);
            $orderOld                = MemberCourseOrder::findOne($data['id']);
            $time                    = $orderOld->deadline_time;

            $order                   = new MemberCourseOrder();
            $order->course_amount    = $this->totalNum;
            $order->create_at        = time();
            if($this->offer) {
                $order->money_amount = ($this->price)*($this->offer/10);     //总金额（续费默认购买一套）
            }else{
                $order->money_amount = $this->price;                         //总金额（续费默认购买一套）
            }
            $order->overage_section  = $this->totalNum;
            $order->deadline_time    = (int)$this->overTime * 86400 + $time;
            $order->product_id       = $data['product_id'];
            $order->product_type     = 1;
            $order->private_type     = '健身私教';
            $order->private_id       = $this->coachId;
            $order->present_course_number = 0;
            $order->surplus_course_number = $this->totalNum;
            $order->service_pay_id        = $data['service_pay_id'];
            $order->member_card_id        = $data['member_card_id'];
            $order->seller_id             = $this->coachId;
            $order->member_id             = $this->memberId;
            $order->business_remarks      = $this->note;
            $order->product_name          = $data['product_name'];
            $order->type                  = $data['type'];
            $order->activeTime            = time();
            $order->chargePersonId        =
            $order->set_number            = $this->nodeNumber;
            $order->course_type           = 1;
//            $data                         = $this->getChargeClass($this->memberId,$this->chargeId);
//            $order                        = MemberCourseOrder::findOne($data['id']);
//            $time                         = $order->deadline_time;
//            $order->seller_id             = $this->coachId;
//            $order->course_amount         = (int)$this->totalNum + (int)$data['course_amount'];                         //课程总节数
//            $order->overage_section       = (int)$this->totalNum + (int)$data['overage_section'];
//            $order->surplus_course_number = (int)$this->totalNum + (int)$data['surplus_course_number'];                 //剩余总课数
////            $order->deadline_time         = time() + (int)$this->endTime * 86400;                                       //课程截止时间
//            $order->deadline_time         = (int)$this->overTime * 86400 + $time;
//            $order->create_at             = time();
//            if($this->offer)
//            {
//                $order->money_amount          = (int)$data['money_amount'] + (($this->price)*($this->offer/10));                     //总金额（续费默认购买一套）
//            }else{
//                $order->money_amount          = (int)$data['money_amount'] + ($this->price);                     //总金额（续费默认购买一套）
//            }
//            $order->business_remarks      = $this->note;                                                                //备注
            if(!$order->save()) {
                return false;
            }
            $this->category      = '续费';
            $this->memberOrderId = $order->id;                                                //获取订单id

            $orderDetails = $this->orderDetails($data);                                                     //生成私课订单详情
            if ($orderDetails !== true) {
                return $orderDetails;
            }
            $history = $this->addConsumptionHistory();                                                     //生成消费记录
            if ($history != true) {
                return false;
            }
            $orderRenew = $this->setOrderRenew($data);                                                     //生成订单
            if ($orderRenew !== true) {
                return $orderRenew;
            }
            if($transaction->commit()){
                return false;
            }else{
                return true;
            }
        }catch (\Exception $e){
            $transaction->rollBack();
            return  $e->getMessage();
        }
    }

    /**
     * 云运动 - 会员课程 - 课种名称获取
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/28
     * @param $classId
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getClassName($classId)
    {
        return Course::find()->where(['id'=>$classId])->andWhere(['class_type'=>1])->select('name')->one();
    }

    /**
     * 云运动 - 会员课程 - 生成订单
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/7/14
     * @return array|bool   
     */
    public function setOrder()
    {
        $saleName                  = Employee::findOne(['id' => $this->coachId]);
        $adminModel                = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        if(empty($adminModel) && \Yii::$app->user->identity->username == 'admin'){
            return '系统管理员不能私自购买私课';
        }
        $order                   = new Order();
        $order->venue_id         = $this->venueId;              //场馆id
        $order->member_id        = $this->memberId;             //会员id
        $order->card_category_id = $this->memberCardId;         //会员卡id
//        $order->total_price      = $this->price;                //总价
        $order->order_time       = time();                      //订单创建时间
        $order->pay_money_time   = time();                      //付款时间
        $order->many_pay_mode   = json_encode($this->payMethod);                      //付款方式
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
//        }else if($this->payMethod == "建设分期")
//        {
//            $order->pay_money_mode = 5;
//        }else if($this->payMethod == "广发分期")
//        {
//            $order->pay_money_mode = 6;
//        }else if($this->payMethod == "招行分期")
//        {
//            $order->pay_money_mode = 7;
//        }
        $order->sell_people_id     = $this->coachId;                 //售卖人id
        $order->payee_id           = \Yii::$app->user->identity->id; //收款人id
        $order->create_id          = \Yii::$app->user->identity->id; //操作人id
        $order->status             = 2;                              //订单状态：1未付款；2已付款；3其他状态；
        $order->note               = '私教产品';
        $number                    = Func::setOrderNumber();
        $order->order_number       = "{$number}";                    //订单编号
        $order->sell_people_name   = $saleName->name;               //售卖人姓名
        $order->payee_name         = $adminModel->name;             //收款人姓名
        $memberName                = MemberDetails::findOne(['member_id' => $this->memberId]);
        $this->memberName          = $memberName->name;
        $order->member_name        = $memberName->name;             //购买人姓名
        $order->pay_people_name    = $memberName->name;             //付款人姓名
        $order->company_id         = $this->companyId;              //公司id
        $order->consumption_type_id = $this->memberOrderId;           //订单id
        $order->consumption_type    = 'charge';                    //消费类型
        $order->card_name          = $this->productName;

        $order->deposit             = $this->deposit;                                        //定金
        $order->cash_coupon         = $this->cashCoupon;                                     //代金券
        $order->net_price           = $this->netPrice;                                       //实收价格
        $order->all_price           = $this->price;                                    //商品总价格
        $order->new_note             = $this->buyNote;
        if(isset($this->payType) && $this->payType == '2'){
            $order->total_price     = $this->netPrice;
        }else{
            $order->total_price     = $this->price;
        }
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
     * 云运动 - 私课续费 - 生成订单
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/7/14
     * @return array|bool
     */
    public function setOrderRenew($data)
    {
        $saleName                  = Employee::findOne(['id' => $this->coachId]);
        $adminModel                = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $order                     = new Order();
        $order->venue_id           = $this->venueId;              //场馆id
        $order->member_id          = $this->memberId;             //会员id
        $order->card_category_id   = $data['member_card_id'];         //会员卡id
        if($this->offer) {
            $order->total_price    = ($this->price)*($this->offer/10);     //总金额（续费默认购买一套）
        }else{
            $order->total_price    = $this->price;                         //总金额（续费默认购买一套）
        }
        $order->order_time         = time();                      //订单创建时间
        $order->pay_money_time     = time();                      //付款时间
        $order->pay_money_mode = 1;
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
        $order->sell_people_id      = $this->coachId;                 //售卖人id
        $order->payee_id            = \Yii::$app->user->identity->id; //收款人id
        $order->create_id           = \Yii::$app->user->identity->id; //操作人id
        $order->status              = 2;                              //订单状态：1未付款；2已付款；3其他状态；
        $order->note                = '私课续费';
        $number                     = Func::setOrderNumber();
        $order->order_number        = "{$number}";                    //订单编号
        $order->sell_people_name    = $saleName->name;               //售卖人姓名
        $order->payee_name          = $adminModel->name;             //收款人姓名
        $memberName                 = MemberDetails::findOne(['member_id' => $this->memberId]);
        $this->memberName           = $memberName->name;
        $order->member_name         = $memberName->name;             //购买人姓名
        $order->pay_people_name     = $memberName->name;             //付款人姓名
        $order->company_id          = $this->companyId;              //公司id
        $order->consumption_type_id = $this->memberOrderId;          //订单id
        $order->consumption_type    = 'charge';                    //消费类型
        $order->card_name           = $data['product_name'];

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
     * 云运动 - 会员购买私课 - 发送短信
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/7/21
     */
    public function sendMessage()
    {
        $member = Member::findOne(['id' => $this->memberId]);
//        $venue  = Organization::findOne(['id' => $this->venueId]);
//        if($this->chargeType == 'many'){
//            $number = $this->totalNum;
//        }else{
//            $number = $this->nodeNumber;
//        }
//        Func::memberCharge($member['mobile'],$venue['name'],$this->memberName,$this->productName,$number);
        Func::memberCharge($member['mobile']);
        return ['status'=>'success'];
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
        $chargeClass = ChargeClass::findOne(['id'=>$this->chargeId]);
        $dealId      = Deal::find()->where(['and',['type'=>2],['id'=>$chargeClass['deal_id']]])->asArray()->one();
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
            $dealRecord->company_id       = $this->companyId;
            $dealRecord->venue_id         = $this->venueId;
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