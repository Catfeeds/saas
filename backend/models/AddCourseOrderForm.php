<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\Member;
use common\models\base\MemberCourseOrder;
use common\models\base\ConsumptionHistory;
use common\models\base\MemberCourseOrderDetails;
use common\models\base\CoursePackageDetail;
use common\models\base\ChargeClass;
use common\models\base\MemberDealRecord;
use common\models\base\Deal;
use common\models\base\DealType;
class AddCourseOrderForm extends Model
{
    public $classId;         //课程id
    public $totalNum;        //总节数
    public $overageNum;      //剩余节数
    public $totalMoney;      //总金额
    public $privateId;       //教练id
    public $createTime;      //办理日期
    public $deadlineTime;    //课程截止时间
    public $privateStartTime;//开课时间
    public $courseType;      //1.PT2.HS3.生日课
    public $memberId;          //会员Id



    /**
     * @云运动 - 后台 - 新增消费记录验证规则
     * @create 2017/12/6
     * @return array
     */
    public function rules()
    {
        return [
            [['classId','totalNum', 'overageNum','totalMoney','privateId','createTime','deadlineTime','privateStartTime','courseType','memberId'], 'safe'],
        ];
    }

    /**
     * @后台会员管理 - 私课新增
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/12/8
     * @param $companyId
     * @param $venueId
     * @return bool|string
     */
    public function chargeAdd($companyId,$venueId)
    {
        $member      = Member::findOne(['id'=>$this->memberId]);
        $chargeClass = ChargeClass::findOne(['id'=>$this->classId]);
        $transaction =  \Yii::$app->db->beginTransaction();       //开启事务
        try{
            $courseOrder = new MemberCourseOrder();
            $courseOrder->course_amount   = (int)$this->totalNum;                   //总节数
            $courseOrder->create_at       = strtotime($this->createTime);      //课程办理日期
            $courseOrder->money_amount    = $this->totalMoney;                 //总金额
            $courseOrder->overage_section = $this->overageNum;                 //剩余节数
            $courseOrder->deadline_time   = strtotime($this->deadlineTime);    //课程截止时间
            $courseOrder->product_id     = $this->classId;                     //产品id
            $courseOrder->product_type  =  1;                                //产品类型1私课
            $courseOrder->private_type  =  '健身私教';                                //私教类别
            $courseOrder->private_id      = $this->privateId;                  //教练
            $courseOrder->present_course_number  =  0;                                //增课总次数
            $courseOrder->surplus_course_number  =  $this->overageNum;                                //剩余总课数
            $courseOrder->service_pay_id  =  $this->classId;                                //收费项目id
            $courseOrder->member_card_id  =  0;                                //会员卡id
            $courseOrder->seller_id    = $member['counselor_id'];                         //销售人员id
            $courseOrder->member_id    = $this->memberId;                         //销售人员id
            $courseOrder->product_name    = $chargeClass['name'];                    //课程名称
            $courseOrder->business_remarks = '场开';                             //业务备注
            if($this->courseType != 3){
                $courseOrder->type            = $this->courseType;                   //类型1PT2HS
            }
            $courseOrder->activeTime = $this->privateStartTime;            //生效时间
            $courseOrder->course_type =  $this->courseType;                //课程类型3生日课
            $courseOrder->activeTime      = strtotime($this->privateStartTime);//课程开始时间
            $courseOrder->set_number      = $this->totalNum;//总数量
           if($courseOrder->save() != true){
            return $courseOrder->errors;
             }


            $orderDetail = $this->saveOrderDetail($courseOrder);
            if($orderDetail!= true){
                throw new \Exception('操作失败');
            }

            $dealRecord = $this->saveDealRecord($orderDetail);
            if($dealRecord !== true){
                return $dealRecord;
            }

            $consumption = $this->saveConsumption($courseOrder,$companyId,$venueId);
            if($consumption!= true){
                throw new \Exception('操作失败');
            }

            if($transaction->commit() == null){
                return true;
            }else{
                return false;
            }
        }catch(\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();  //获取抛出的错误
        }
    }
    /**
     * 云运动 - 会员买课 - 生成订单详情
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/12/8
     * @param $courseOrder     //产品订单id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function saveOrderDetail($courseOrder)
    {
        $model = new \backend\models\CoursePackageDetail();
        $data  = $model->getClassPrice($this->classId);
        foreach($data as $k=>$v)
        {
            $details = new MemberCourseOrderDetails();
            $details->course_order_id = $courseOrder['id'];     //订单id
            $details->course_id       = $v['course_id'];        //课种id
            $details->course_num      = $this->totalNum;       //课量
            $details->course_length   = 1;                     //有效期
            $details->original_price  = $v['original_price'];   //单节原价
            $details->sale_price      = $v['sale_price'];       //单节售价
            $details->pos_price       = $v['pos_price'];        //pos售价
            $details->type            = 1;                      //订单类型
            $details->category        = $v['category'];         //类型:1多课程，2单课程
            $details->product_name    = $courseOrder['product_name'];   //产品名称
            $name                     = $this->getClassName($v['course_id']);
            $details->course_name     = $name['name'];          //课种名称
            $details->class_length    = $v['course_length'];    //单节课时长
            if($details->save() != true){
                return $details->errors;
            }
        }
        return $details;
    }
    /**
     * 云运动 - 后台- 新增私课信息录入
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/12/8
     * @param $courseOrder
     * @param $companyId
     * @param $venueId
     * @return boolean/object
     */
    public function saveConsumption($courseOrder,$companyId,$venueId)
    {
        $member      = Member::findOne(['id'=>$this->memberId]);
        $history = new ConsumptionHistory();
        $history->member_id           = $this->memberId;                //会员id
        $history->consumption_type    = 'charge';                       //消费类型
        $history->consumption_type_id = $courseOrder['id'];             //消费项目id
        $history->type                = (int)1;                         //消费方式
        $history->consumption_date    = strtotime($this->createTime);   //消费日期
        $history->consumption_time    = strtotime($this->createTime);   //消费时间
        $history->consumption_times   = 1;                              //消费次数
        $history->cash_payment        =  $this->totalMoney;              //现金付款
        $history->consumption_amount  = $this->totalMoney;              //消费金额
        $history->describe            = json_encode(['note'=>'购买私课']); //描述
        $history->category            = '购买私课';                     //消费类型状态
        $history->due_date            = strtotime($this->deadlineTime); //截止时间
        $history->seller_id           = $member['counselor_id'];       //销售私教id
        $history->company_id          = $companyId;                    //公司id
        $history->venue_id            = $venueId;                     //场馆id
        if($history->save()){
            return true;
        }else{
            return $history->errors;
        }
    }
    /**
     * 云运动 - 购买私课 -  获取课程详细信息
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/12/8
     * @param $classId
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getClassPrice($classId)
    {
        return CoursePackageDetail::find()->where(['charge_class_id'=>$classId])->asArray()->all();
    }
    /**
     * 云运动 - 会员课程 - 课种名称获取
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/12/8
     * @param $classId
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getClassName($classId)
    {
        return Course::find()->where(['id'=>$classId])->andWhere(['class_type'=>1])->select('name')->one();
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
        $memberData    = Member::findOne(['id'=>$this->memberId]);
        $chargeClass   = ChargeClass::findOne(['id'=>$this->classId]);
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