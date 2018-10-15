<?php

namespace backend\models;
use common\models\base\AboutClass;
use common\models\base\MemberCard;
use common\models\base\MemberCourseOrder;
use common\models\base\MemberCourseOrderDetails;
use common\models\base\Order;
use common\models\base\Employee;
use yii\base\Model;
use common\models\Func;
use common\models\base\MessageCode;
use Yii;

class MemberTransferClassForm extends Model
{
    public $memberId;               //会员id
    public $memberNumber;           //会员编号
    public $transferPrice;          //转让金额
    public $transferNum;            //转让节数
    public $chargeId;               //转让课程id
    public $venueId;
    public $companyId;
    public $code;             //填写的验证码

    public function __construct(array $config,$companyId,$venueId)
    {
        $this->companyId = $companyId;
        $this->venueId   = $venueId;
        parent::__construct($config);
    }
    /**
     * @云运动 - 后台 - 场景表单定义
     * @create 2017/4/25
     * @return array
     */
    public function  scenarios(){
        return [
            'privateLessons'=>["memberId",'memberNumber','transferPrice',"transferNum","chargeId","code"]
        ];

    }
    /**
     * @私课转让 规则
     * @author huangpengju <huangpengju@itsports.club>
     * @create_at 2017/5/25
     * @return array
     */
    public function  rules()
    {
        return[
            [['memberNumber','transferPrice','transferNum','code'],'trim','on'=>'privateLessons'],
            [['memberId','memberNumber','transferPrice','transferNum','chargeId','code'],'required','on'=>'privateLessons'],
            [['memberId','chargeId','transferNum'],'integer','on'=>'privateLessons'],
            [['memberNumber'],'string','on'=>'privateLessons'],
        ];
    }

//    /**
//     * @云运动 - 转课 - 验证码
//     * @author huanghua <huanghua@itsports.club>
//     * @create 2017/11/9
//     * @inheritdoc
//     */
//    public function loadCode()
//    {
//        if (Yii::$app->session->has('sms')) {
//            $temp = Yii::$app->session->get('sms');
//            $this->newCode = $temp['code'];
//        }
//    }


//    /**
//     * @云运动 - 转课 - 验证码时间
//     * @author huanghua <huanghua@itsports.club>
//     * @create 2017/11/9
//     * @inheritdoc
//     */
//    public function newCodeTime($attribute)
//    {
//        $temp = Yii::$app->session->get('sms');
//        $time = $temp['time'];
//        $num = time() - $time;
//        if ($num > 300) {
//            $this->addError($attribute, '验证码已失效');
//        }
//    }

//    /**
//     * @云运动 - 转课 - 验证码手机号
//     * @author huanghua <huanghua@itsports.club>
//     * @create 2017/11/9
//     * @inheritdoc
//     */
//    public function setMobile($attribute)
//    {
//        $temp = Yii::$app->session->get('sms');
//        $mobile = $temp['mobile'];
//        if ($this->mobile != $mobile) {
//            $this->addError($attribute, '手机号错误，请填写接收验证码的手机号');
//        }
//    }
    
    public function getCourseOrderArr($data)
    {
        $orderIdArr = MemberCourseOrderDetails::find()->where(['course_order_id'=>$data['id']])->select('id')->asArray()->all();
        $num = 0;                   //上了几节课
        foreach ($orderIdArr as $k=>$v)
        {
            $num += AboutClass::find()->where(['class_id'=>$v['id']])->andWhere(['<>','status',2])->count();
        }
        return $num;
    }
    /**
     * @私课转让 保存
     * @author huangpengju <huangpengju@itsports.club>
     * @create_at 2017/5/25
     * @return array|bool|string
     */
    public function saveTransferInfo()
    {
        $data = $this->getMemberInfo($this->memberId,$this->chargeId);  //查询会员订单

        $charge = ChargeClass::findOne(['id'=>$data['product_id']]);//收费课程数据
        $chargeMoney = ChargeClassPrice::findOne(['charge_class_id'=>$charge['id']]);//私课产品价格表(单课程)
        if(empty($data)){
            return 'no class';         //该会员没有课程
        }else{
            //1.获取订单的详情id
            $class = \backend\models\MemberCourseOrder::findOne($data['id']);
            //2.获取上课中的课程
            $num = $this->getClassBeginNum($data);
            //3.判断剩余节数是否大于转让节数
            if (intval($class->overage_section) - intval($num) < intval($this->transferNum)) {
                return 'num';
            }
            if(intval($this->transferNum) < 0){
                return 'num';           //剩余数量小于填写的转让数量
            }
            //获取转让人的名字
            $oldMember = MemberDetails::findOne(['member_id'=>$data['member_id']]);
            $member = $this->getMemberIdInfo($this->memberNumber);      //检测被转让人是否存在
            if(empty($member['id'])){
                return 'no member';       //被转让人 不存在
            }else{
                $transaction = \Yii::$app->db->beginTransaction();                                                               //开启事务
                try {
                    $employee = Employee::find()->where(['admin_user_id'=>\Yii::$app->user->identity->id])->asArray()->one();
                    //1.先把原订单中的信息拿出来
                    //2.把拿出来的数据，过滤给 $member中的id
                    $memberClass = new MemberCourseOrder();
                    $memberClass->member_id             = $member['id'];                         //会员id（必填）
                    $memberClass->member_card_id        =  $data['member_card_id'];                               //会员卡id(必填)
                    $memberClass->service_pay_id        = $data['service_pay_id'];                              //收费项目id(必填)买的课程id
                    $memberClass->seller_id             = $data['seller_id'];                                //销售私教ID(必填)
                    $memberClass->course_amount         = $data['course_amount'];                                 //课程总节数
                    $memberClass->create_at             = time();                                            //买课时间
//                    $memberClass->money_amount          = $this->transferPrice;                            //总金额
                    if($charge['type']==2){
                        $memberClass->money_amount          = $data['money_amount'];      //总金额
                    }else{
                        $memberClass->money_amount          = $this->transferPrice;
                    }
                    $memberClass->overage_section       = $this->transferNum;                                 //课程剩余节数
                    $memberClass->private_type          = '健身私教';                                        //私教类别
                    $memberClass->product_id            = $data['product_id'];                                   //产品id
                    $memberClass->product_type          = 1;                                                 //私课
                    $memberClass->deadline_time         = $data['deadline_time'];              //课程截止时间
                    $memberClass->private_id            = $data['private_id'];                                    //私教id
                    $memberClass->product_name          = $data['product_name'];
                    $memberClass->present_course_number = 0;                                                  //赠送总次数
                    $memberClass->surplus_course_number = $this->transferNum;                                    //剩余总课数
                    $memberClass->chargePersonId        = isset($employee['id'])?$employee['id']:0;
                    $memberClass->business_remarks      = '转让';                     //销售渠道
                    $memberClass->type                  = $data['type'];
                    $memberClass->course_type           = $data['course_type'];
                    $memberClass->note                  = '由会员编号为'.$data['member_id'].'的会员'.$oldMember->name.'转让';
                    $memberSave = $memberClass->save() ? $memberClass : $memberClass->errors;
                    if (!isset($memberSave->id)) {
                        return $member->errors;
                    }
                    if (intval($class->overage_section) - intval($num) == intval($this->transferNum)) {
                        //修改延期记录
                        $re = $this->getDelayData($data['id'],$this->memberId,$memberSave->id);
                        if ($re != true) {
                            return '延期记录转移失败';
                        }
                    }
                    $details = $this->addCourseOrderDetails($memberSave->id, $this->chargeId);                      //生成订单详情
                    if ($details != true) {
                        return $details;
                    }
                    if ($data['overage_section'] == $this->transferNum)                          //把剩余课量全部转让，
                    {
                        $del = $this->delOrder($this->memberId, $this->chargeId);                //删除原会员订单
                        if ($del != true) {
                            return $del;
                        }
                    } else {
                        $del = $this->updateOrder($this->memberId, $this->chargeId, $this->transferNum);  //修改订单
                        if ($del !== true) {
                            return $del;
                        }
                    }
                    $orderRenew = $this->setOrderRenew($memberClass);
                    //生成订单
                    if ($orderRenew !== true) {
                        return $orderRenew;
                    }
                  if($transaction->commit() == NULL)
                  {
                      return true;
                  }else{
                      return false;
                  }
                }catch (\Exception $e)
                {
                    $transaction->rollBack();
                    return  $e->getMessage();                                                                                       //抛出错误
                }
            }
        }
    }
    /**
     *  数据业务 - 查询会员是否有课
     * @param $memberId
     * @param $chargeId
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getMemberInfo($memberId,$chargeId)
    {
        return MemberCourseOrder::find()
              ->where(['id'=>$chargeId])
//            ->where(['member_id'=>$memberId])
//            ->andWhere(['service_pay_id'=>$chargeId])
            ->asArray()
            ->one();
    }
    /**
     *  数据业务 - 查询被转让人是否存在 （根据会员卡号，查询会员id(课转给哪位会员)）
     * @param $memberNumber
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getMemberIdInfo($memberNumber)
    {
        $member = Member::find()
            ->where(['id'=>$memberNumber])
            ->select('id')
            ->asArray()
            ->one();
//        $member['memberCard'] = MemberCard::find()->select('id')->where(['member_id'=>$memberNumber])
//            ->andWhere(['status'=>1])->asArray()->one();
        return $member;
    }
    /**
     * 云运动 - 会员买课 - 订单详情
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/23
     * @param $orderId     //产品订单id
     * @param $chargeId     //产品id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function addCourseOrderDetails($orderId,$chargeId)
    {
        $data  = MemberCourseOrderDetails::find()->where(['course_order_id'=>$chargeId])->asArray()->all();
        $num = 0;
        foreach($data as $k=>$v)
        {
            $about = AboutClass::find()->where(['class_id'=>$v['id']])->andWhere(['<>','status',2])->count();
            if($about < $v['course_num']){
                $v['course_num'] = $v['course_num'] - $about;
                if($v['course_num'] === 0){
                    continue;
                }
                $num += $v['course_num'];
                if($num > $this->transferNum){
                    $v['course_num'] =  $this->transferNum - ($num - $v['course_num']);
                    $details = new MemberCourseOrderDetails();
                    $details->course_order_id = $orderId;             //订单id
                    $details->course_id       = $v['course_id'];      //课种id
                    $details->course_num      = $v['course_num'];     //课量
                    $details->course_length   = $v['course_length'];  //课时长
                    $details->class_length    = $v['class_length'];
                    $details->original_price  = $v['original_price']; //单节原价
                    $details->sale_price      = $v['sale_price'];     //单节售价
                    $details->pos_price       = $v['pos_price'];      //pos售价
                    $details->type            = 1;                    //订单类型
                    $details->product_name    = $v['product_name'];
                    $details->course_name     = $v['course_name'];
                    $details->category        = $v['category'];       //类型:1多课程，2单课程
                    if(!$details->save()){
                        return $details->errors;
                        break;
                    }
                    break;
                }else{
                    $details = new MemberCourseOrderDetails();
                    $details->course_order_id = $orderId;             //订单id
                    $details->course_id       = $v['course_id'];      //课种id
                    $details->course_num      = $v['course_num'];     //课量
                    $details->course_length   = $v['course_length'];  //课时长
                    $details->class_length    = $v['class_length'];
                    $details->original_price  = $v['original_price']; //单节原价
                    $details->sale_price      = $v['sale_price'];     //单节售价
                    $details->pos_price       = $v['pos_price'];      //pos售价
                    $details->type            = 1;                    //订单类型
                    $details->product_name    = $v['product_name'];
                    $details->course_name     = $v['course_name'];
                    $details->category        = $v['category'];       //类型:1多课程，2单课程
                    if(!$details->save()){
                        return $details->errors;
                        break;
                    }
                }
            }
        }
        return true;
    }

    /**
     * 云运动 - 会员私课订单 - 删除
     * @param $memberId     //会员id
     * @param $chargeId     //课程id
     * @create_at 2017/5/27
     * @return bool
     * @throws \Exception
     */
    public function delOrder($memberId,$chargeId)
    {
        $data = $this->getMemberInfo($memberId,$chargeId);
        $order = MemberCourseOrder::findOne($data['id']);
        if($order->delete())
        {
            return true;
        }else{
            return $order->errors;
        }
    }
    /**
     * 云运动 - 会员私课订单 - 修改
     * @create_at 2017/5/27
     * @param $memberId
     * @param $chargeId
     * @param $transferNum
     * @return array|bool
     */
    public function updateOrder($memberId,$chargeId,$transferNum)
    {
        $data                         = $this->getMemberInfo($memberId,$chargeId);
        $order                        = MemberCourseOrder::findOne($data['id']);
        if(($data['overage_section'] - $transferNum) < 0){
            return 'num';
        }
//        $order->course_amount         = $data['course_amount'] - $transferNum;
        $order->overage_section       = $data['overage_section'] - $transferNum;
        $order->surplus_course_number = $data['overage_section'] - $transferNum;
        if($order->save())
        {
            $this->updateDetailOrder($chargeId,$transferNum);
            return true;
        }else{
            return $order->errors;
        }
    }
    /**
     * 云运动 - 会员私课订单 - 修改
     * @create_at 2017/5/27
     * @param $chargeId
     * @param $transferNum
     * @return array|bool
     */
    public function updateDetailOrder($chargeId,$transferNum)
    {
        $order      = MemberCourseOrderDetails::find()->where(['course_order_id'=>$chargeId])->asArray()->all();
        $num = 0;
        foreach ($order as $k=>$v){
            $num += $v['course_num'];
            $detail = MemberCourseOrderDetails::findOne(['id'=>$v['id']]);
            if($num > $transferNum){
                if($num !== 0){
                    $transferNum = $num - $transferNum;
                }
                $detail->course_num = $transferNum;
                $return = $detail->save();
                if(!$return) {
                    return $detail->errors;
                }
                break;
            }else{
                $detail->delete();
                continue;
            }

        }
    }

    /**
     * 云运动 - 私课续费 - 生成订单
     * @author huanghua <huangpengju@itsports.club>
     * @create 2017/8/7
     * @param $memberClass
     * @return array|bool
     */
    public function setOrderRenew($memberClass)
    {
        if(!empty($memberClass['seller_id'])){
            $saleName                  = Employee::findOne(['id' => $memberClass['seller_id']]);
        }
        if(empty($saleName)){
            $saleName                  = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        }
        $adminModel                = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $order                     = new Order();
        $order->venue_id           = $this->venueId;              //场馆id
        $order->member_id          = $this->memberId;             //会员id
        $order->card_category_id   = $memberClass['member_card_id'];         //会员卡id
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
        $order->sell_people_id      = $memberClass['seller_id'];                 //售卖人id
        $sms = new SmsRecordForm();
        $employee_id = $sms->getCreate();

        $order->create_id           = $employee_id; //操作人id
        $order->payee_id            = $employee_id; //收款人id
        $order->status              = 2;                              //订单状态：1未付款；2已付款；3其他状态；
        $order->note                = '私课转课';
        $number                     = Func::setOrderNumber();
        $order->order_number        = "{$number}";                    //订单编号
        $order->sell_people_name    = $saleName->name;               //售卖人姓名
        $order->payee_name          = $adminModel->name;             //收款人姓名
        $memberName                 = MemberDetails::findOne(['member_id' => $this->memberId]);
        $order->member_name         = $memberName->name;             //购买人姓名
        $order->pay_people_name     = $memberName->name;             //付款人姓名
        $order->company_id          = $this->companyId;              //公司id
        $order->consumption_type_id = $order->id;                    //订单id
        $order->consumption_type    = 'charge';                    //消费类型
        $order->card_name           = $memberClass['product_name'];

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
     * @desc: 私课转让,查看上课中的节数
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/01
     * @param $data
     * @return int|string
     */
    public function getClassBeginNum($data)
    {
        $orderId = MemberCourseOrderDetails::find()->where(['course_order_id'=>$data['id']])->select('id')->asArray()->one();
        if (isset($orderId['id'])) {
            $num = \backend\models\AboutClass::find()
                ->where(['and',
                    ['class_id'=>$orderId['id']],
                    ['status'=>3],
                    ['member_id'=>$this->memberId]
                ])->count();
            return $num;
        }
            return 0;
    }

    /**
     * @desc: 业务后台 - 转私教课 - 课程延期
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/04/02
     * @param $memberCourseId
     * @param $memberId
     * @param $newOrderId
     * @return bool
     */
    public function getDelayData($memberCourseId,$memberId,$newOrderId)
    {
       $data = \common\models\base\ExtensionRecord::find()->where(['and',['member_id'=>$memberId],['course_order_id'=>$memberCourseId]])->asArray()->all();
       if (isset($data) && !empty($data)) {
           foreach ($data as $v) {
               $record = ExtensionRecord::findOne($v['id']);
               $record->member_id       = $this->memberNumber;
               $record->course_order_id = $newOrderId;
               $re = $record->save();
               if (!$re) {
                   return false;
               }
           }
       }
       return true;
    }
}