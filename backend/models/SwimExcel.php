<?php
namespace backend\models;

use common\models\base\ChargeClass;
use common\models\base\Employee;
use common\models\base\MemberCourseOrderDetails;
use common\models\base\MemberCourseOrder;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\MemberDetails;
use common\models\base\VenueLimitTimes;
use common\models\Excel;
use common\models\Func;
use yii\base\Model;
class SwimExcel extends Model
{
    const INFO = [0=>'memberNumber',1=>'privateClass',2=>'memberName',3=>'mobile',4=>'privateTeach',5=>'totalPrice',6=>'classNum',7=>'payData',8=>'startData',9=>'endData'];
    public $memberNumber;      //会员卡号(07000030993710101098)
    public $privateClass;      //私教课程
    public $memberName;        //会员名字(王保通)
    public $mobile;             //手机号
    public $privateTeach;      //会籍顾问
    public $totalPrice;        //总价
    public $classNum;          //购买课程节数
    public $payData;           //缴费日期
    public $startData;         //开始日期
    public $endData;           //结束日期

    // 所有的备用
    public $venueType;         // 场馆名称
    public $venueNameTwo;     // 场馆第二个细分名称
    public $chargeClassId;
    public $memberId;
    public $memberCardId;
    public $venueId;
    public $organId;
    public $departId;      //部门ID
    public $adminId;
    public $employeeId;
    public function loadData($v)
    {
        foreach ($v as $k=>$val) {
            $params = self::INFO;
            $key    = $params[$k];
            $this->$key = $val;
        }
    }
    //导入会员私课数据（2017-5-17剩余课时查询.xls）
    public function loadFile($file,$type = '艾博',$name = '艾博健身馆')
    {
        $model = new Excel();
        $data  = $model->loadSwimExpireFile($file,'private');               //excel表数据
        $this->venueType    = $type;
        $this->venueNameTwo = $name;
        $this->getAdminIdOne();
        $this->getVenueId();

        foreach ($data as $k=>$v) {
            $this->loadData($v);
            $save = $this->getTransferInfo($v);
            if($save !== true){
                return $save;
            }
        }
        return true;
    }

    public function getTransferInfo($v)
    {
        $charge = $this->getChargeExist($v[1]);
        if(!$charge && empty($charge)){
            $chargeClass = $this->setChargeInfo();
            $this->chargeClassId = $chargeClass->id;
        }else{
            $this->chargeClassId = $charge['id'];
        }
        $employeeModel = Employee::findOne(['name'=>$this->privateTeach,'venue_id'=>$this->venueId]);
        if(empty($employeeModel)){
            $employee = new Employee();
            $employee->name            = $this->privateTeach;
            $employee->organization_id = $this->departId;
            $employee->company_id      = $this->organId;
            $employee->venue_id        = $this->venueId;
            $employee->create_id       = $this->adminId;
            if (!$employee->save()) {
                $error = $employee->errors;
                echo "employee>>" . $this->memberNumber . "<br /><br />";
                return $error;
            }
            $this->employeeId = $employee->id;
        }else{
            $this->employeeId = $employeeModel->id;
        }
        $member = $this->getMemberExist($v[2],$v[3]);                                 //查询会员是否存在
        if(!$member && empty($member)) {
            $member = $this->setMemberInfo();                                                   //主要用生成的会员id
        }else{
            $this->memberId = $member['id'];
            $details = $this->getMemberDetailsExist($this->memberId);               //查询会员详情是否存在
            if(!$details && empty($details)){
                $memberDetails = $this->setMemberDetails();                                          //生成会员详情
            }
        }
        $memberCard = $this->getMemberCardExist($v[0]);                              //查询会员卡是否存在
        if (!$memberCard && empty($memberCard)) {
            $card = $this->setMemberCardInfo($this->memberId,$v[0]);                        //用会员卡id(返回的id)
            $this->memberCardId = isset($card->id)?$card->id:null;
        } else {
            $this->memberCardId = $memberCard['id'];                                     //会员卡id
        }
        $isVenueLimit = VenueLimitTimes::find()->where(['member_card_id'=>$this->memberCardId])->andWhere(['venue_id'=>$this->venueId])->asArray()->one();
        if(empty($isVenueLimit)){
            $venueLimit    = new VenueLimitTimes();
            $venueLimit->member_card_id = $this->memberCardId;
            $venueLimit->venue_id       = $this->venueId;
            $venueLimit->total_times    = -1;
            $venueLimit->overplus_times = -1;
            if(!$venueLimit->save()){
                return $venueLimit->errors;
            }
        }

        //会员课程订单表数据录入
        $memCourseResult = $this->memCourseOrder($this->memberId,$this->memberCardId);
        if(!isset($memCourseResult['id'])){
            return $memCourseResult;
        }
        //会员课程订单详情表数据录入
        $memCourseOrderDetail = $this->memCourseOrderDetail($memCourseResult['id']);
        if($memCourseOrderDetail !== true){
            return $memCourseOrderDetail;
        }
        $this->setHistory();
        return true;
    }

    //判断私课产品是否存在
    public function getChargeExist($chargeName)
    {
        return ChargeClass::find()->where(['name'=>$chargeName])->asArray()->one();
    }
    //生成私课表
    public function setChargeInfo()
    {
        $charge = new ChargeClass();
        $charge->name = $this->privateClass;
        $charge->amount = intval($this->classNum);
        $charge->created_at = time();
        $charge->category = 1;
        $charge->venue_id = $this->venueId;
        $charge->total_amount = intval($this->totalPrice);
        $charge->status = 1;
        $charge->type = 2;
        $charge->company_id = $this->organId;
        if ($charge->save()) {
            return $charge;
        } else {
            return $charge->errors;
        }
    }

    /**
     * 数据 - 业务后台 - 会员私课 - 查询会员是否存在
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/4
     * @param $name         //会员姓名
     * @param $mobile       //会员手机号
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getMemberExist($name,$mobile)
    {
        return Member::find()->where(['username'=>$name])->andFilterWhere(['mobile'=>$mobile])->asArray()->one();
    }

    /**
     * 数据 - 业务后台 - 会员私课 - 添加会员基本信息
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/4
     * @return array|bool|Member|string
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function setMemberInfo()
    {
        $password = '123456';     //会员临时密码
        $password = \Yii::$app->security->generatePasswordHash($password);
        $privateId = Employee::findOne(['name' => $this->privateTeach]);
        $member = new Member();
        $member->username      = $this->memberName;                           //用户名
        $member->mobile        = !empty($this->mobile)?"$this->mobile":'0';    //手机号
        $member->password      = $password;                                //密码
        $member->register_time = time();                                   //注册时间
        $member->update_at      = time();
        $member->status         = 1;
        $member->counselor_id  = $privateId['id'];
        $member->member_type   = 1;
        $member->venue_id      = $this->venueId;                          //场馆id
        $member->company_id    = $this->organId;                          //公司id
        $member = $member->save()?$member:$member->errors;
        if ($member->id) {
            $this->memberId = $member->id;                  //现会员
        }else {
            return $member;
        }
        $detail = $this->setMemberDetails();        //添加会员详细信息
        if($detail !== true)
        {
            return $detail;
        }
    }

    /**
     * 数据 - 业务后台 - 会员私课 - 查询会员详情是否存在
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/4
     * @param $memberId
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getMemberDetailsExist($memberId)
    {
        return MemberDetails::find()->where(['member_id'=>$memberId])->asArray()->one();
    }

    /**
     * 数据 - 业务后台 - 会员私课 - 添加会员详细信息
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/4
     * @return array|bool
     */
    public function setMemberDetails()
    {
        $detail             = new MemberDetails();
        $detail->member_id = $this->memberId;             //会员id
        $detail->name       = $this->memberName;          //会员名
        $detail->sex        = (empty($this->memberSex))?0:(($this->memberSex == '男')?1:2);//现会员性别
        $detail->created_at = $this->payData;                      //创建时间
        $detail->updated_at = time();                               //修改时间
        if ($detail->save()) {
            return true;
        } else {
            return $detail->errors;
        }
    }

    /**
     * 数据 - 业务后台 - 会员私课 - 查询会员卡是否存在
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/4
     * @param $cardNumber         //会员卡 卡号
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getMemberCardExist($cardNumber)
    {
        return MemberCard::find()->where(['card_number'=>$cardNumber])->asArray()->one();   //查询会员卡是否存在
    }
    public function setHistory()
    {
        $model = new ConsumptionHistory();
        $model->member_id             = $this->memberId;     ;        //?从对方获取插入的会员id
        $model->consumption_type      = "card";
        $model->consumption_type_id   = $this->memberCardId;        //?从对方拿取  （对方插入会员卡表时的id）
        $model->type                  = 1;        //消费方式暂定1（现金）；
        $model->consumption_date      = intval($this->payData);   //消费日期
        $model->consumption_amount    = abs(intval($this->totalPrice));            //?消费金额 遍历数据拿出来
        $model->consumption_times     = 1;                        //消费次数
        $number = Func::setOrderNumber();
        $model->cashier_order         = "$number";    //收银单号
        $model->cash_payment          = abs(intval($this->totalPrice));             //现金付款
        $model->seller_id              = $this->employeeId;          //销售人员id
        $model->category               = '购买私教';
        $modelResult = $model->save() ? true :false ;
        if($modelResult === false){
            return $model->errors;
        }
    }
    /**
     * 数据 - 业务后台 - 会员私课 - 会员卡信息生成
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/4
     * @param $memberId   //会员id
     * @param $cardNumber //会员卡号
     * @return array|bool
     */
    public function setMemberCardInfo($memberId,$cardNumber)
    {
        $memberCard                    = new MemberCard();
        if($cardNumber == null || empty($cardNumber)){
            $memberCard->card_number  = (string)'0'.mt_rand(0,10).time();
        }else{
            $memberCard->card_number  = $cardNumber;             //会员卡号
        }
        $memberCard->create_at        = intval($this->payData);         //开卡时间
        $memberCard->amount_money     = 0;                       //金额
        $memberCard->status           = 1;                        //状态
        $memberCard->active_time      = intval($this->startData);        //激活时间
        $memberCard->invalid_time     = intval($this->endData);          //失效时间
        $memberCard->payment_type     = 1;                        //付款类型
        $memberCard->is_complete_pay  = 1;                        //是否完成付款
        $memberCard->level             = 0;                        //等级
        $memberCard->card_category_id = 0;                        //卡种id
        $memberCard->member_id         = $memberId;               //会员id
        $memberCard->card_name         = $this->privateClass;    //卡名
        $memberCard->company_id        = $this->organId;          //公司id
        $memberCard->venue_id          = $this->venueId;          //场馆id
        if (!$memberCard->save()) {
            return $memberCard->errors;
        } else {
            return $memberCard;
        }
    }

    /**
     * 数据 - 业务后台 - 会员私课 - 会员课程订单表生成
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/4
     * @param $memberId   //会员id
     * @param $memberCardId //会员卡id
     * @return array|bool
     */
    public  function memCourseOrder($memberId,$memberCardId)
    {
        $memCourseOrder = new MemberCourseOrder();
        $memCourseOrder->course_amount          = $this->classNum;               //总节数
        $memCourseOrder->create_at              = intval($this->payData);
        $memCourseOrder->money_amount          = $this->totalPrice;             //总金额
        $memCourseOrder->activeTime            = intval($this->startData);
        $memCourseOrder->deadline_time         = intval($this->endData);
        $memCourseOrder->product_id            = $this->chargeClassId;
        $memCourseOrder->product_type           = 1;                             //产品类型:1私课2团课
        $memCourseOrder->private_id             = $this->employeeId;             //私教id
        $memCourseOrder->service_pay_id         = $this->chargeClassId;
        $memCourseOrder->cashier_type           = 1;                           //收银类型（1.全款 2.转让 3.回款）
        $memCourseOrder->member_card_id         = $memberCardId;               //会员卡ID
        $memCourseOrder->member_id              = $memberId;                    //会员ID
        $memCourseOrder->seller_id              = $this->employeeId;
        $memCourseOrder->product_name           = $this->privateClass;         //产品名称
        $memCourseOrder->type = 1;                                               //类型：(1：PT，2:HS)
        if(!$memCourseOrder->save()){
            return $memCourseOrder->errors;
        }
        return $memCourseOrder;
    }

    /**
     * 数据 - 业务后台 - 会员私课 - 会员购买私课订单详情表生成
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/4
     * @return array|bool
     */
    public function memCourseOrderDetail($courseOrderId){
        $memCourseOrderDetail = MemberCourseOrderDetails::findOne(["course_order_id"=>$courseOrderId]);
        if(empty($memCourseOrderDetail)){
            $model = new MemberCourseOrderDetails();
            $model->course_order_id = !empty($courseOrderId)?$courseOrderId:0;
            $model->course_id        = 0;
            $model->course_num       = $this->classNum;
            $model->course_length    = ($this->endData - $this->startData)/24/60/60;
            $model->type             = 1;
            $model->category        = 2;
            $model->product_name    = $this->privateClass;
            if(!$model->save()){
                return $model->errors;
            }
            return true;
        }
    }
    public function getVenueId()
    {
        $organ      =  Organization::find()->where(['like','name','艾搏'])->andWhere(['style'=>1])->asArray()->one();
        if(empty($organ)){
            $this->venueName  = '郑州市艾搏艾博健身服务有限公司';
            $this->venueCode  = NULL;
            $this->venuePid   = 0;
            $this->venueStyle = 1;
            $this->path       = 0;
            $venues = $this->addVenue();
            if(isset($venues->id)){
                $this->organId = $venues->id;
            }
        }else{
            $this->organId = $organ['id'];
        }

        if($this->organId){
            $venue      =  Organization::find()->where(['pid'=>$this->organId])->andWhere(['like','name',$this->venueType])->asArray()->one();
            if(empty($venue)){
                $this->venueName  = $this->venueNameTwo;
                $this->venueCode  = NULL;
                $this->venuePid   = $this->organId;
                $this->venueStyle = 2;
                $this->path       = '0,'.$this->organId;
                $venues = $this->addVenue();
                if(isset($venues->id)){
                    $this->venueId = $venues->id;
                }
            }else{
                $this->venueId = $venue['id'];
            }
            if(isset($this->venueId)){
                $department =  Organization::find()->where(['like','name','销售部'])->andWhere(['pid'=>$this->venueId])->andWhere(['style'=>3])->asArray()->one();
                if(empty($department)){
                    $this->venueName  = '销售部';
                    $this->venueCode  = 'xiaoshou';
                    $this->venuePid   = $this->venueId;
                    $this->venueStyle = 3;
                    $this->path       = '0,'.$this->organId.','.$this->venueId;
                    $venues = $this->addVenue();
                    if(isset($venues->id)){
                        $this->departId = $venues->id;
                    }
                }else{
                    $this->departId = $department['id'];
                }

            }
        }

    }
    public function addVenue()
    {
        $venue = new Organization();
        $venue->name = $this->venueName;
        $venue->pid = $this->venuePid;
        $venue->created_at = time();
        $venue->create_id  = $this->adminId;
        $venue->style = $this->venueStyle;
        $venue->code = $this->venueCode;
        $venue->path = json_encode($this->path);
        if ($venue->save()) {
            return $venue;
        }else{
            return $venue->errors;
        }
    }
    public function getAdminIdOne()
    {
        $admin = Admin::find()->where(['username'=>'admin'])->asArray()->one();
        $this->adminId =  isset($admin['id'])?$admin['id']:0;
    }
}