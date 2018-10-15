<?php
namespace backend\models;

use common\models\base\ChargeClass;
use common\models\base\Employee;
use common\models\base\MemberCourseOrderDetails;
use common\models\base\MemberCourseOrder;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\MemberDetails;
use common\models\Excel;
use yii\base\Model;

class PrivateExcel extends Model
{
    const  ANOTHER_PARAMETER =["memberNumber","memberName","mobile","privateTeach","privateClass","classNum","surplusNum","giveNum","giveSurplusNum","originalPrice","salePrice","totalPrice"];
    const INFO = [0=>'memberNumber',1=>'memberName',2=>'mobile',3=>'privateTeach',4=>'privateClass',5=>'classNum',6=>'aClass',7=>'surplusNum',8=>'giveNum',9=>'giveSurplusNum',10=>'originalPrice',11=>'salePrice',12=>'totalPrice'];
    public $memberNumber;       //会员卡号(07000030993710101098)
    public $memberName;         //会员名字(王保通)
    public $mobile;             //手机号
    public $privateTeach;       //私人教练
    public $privateClass;      //私教课程
    public $classNum;          //购买课程节数
    public $surplusNum;        //剩余节数
    public $giveNum;            //赠送节数
    public $giveSurplusNum;    //赠送剩余节数
    public $originalPrice;     //单价
    public $salePrice;         //实际单价
    public $totalPrice;       //总价
    public $aClass;
    public $courseName;
    // 所有的备用
    public $describe;           //备用(json字段)

    public $venueType;         // 场馆名称
    public $venueNameTwo;     // 场馆第二个细分名称
    //使用的属性
    public $organId;  //公司ID
    public $venueId;  //场馆ID
    public $departId;  //部门ID
    public $employeeId; //销售人员id
    public $privateId;  //私教人员id
    public $memberId;   //会员id
    public $cardCategoryTypeId;  //卡种类型id
    public $cardCategoryId;     //卡种id
    public $memberCardId;  //会员卡号id
    public $productId;      // 产品id
    public $memCourseOrderId;  //会员课程订单表id
    public $totalNum;
    public $price;
    //场馆数据
    public $venueName; //组织名称
    public $venuePid;
    public $venueStyle;
    public $venueCode;
    //会员信息
    public $memberMobile;       //会员手机号
    public $registerTime;       //会员注册时间
    public $idCard;             //会员身份证号
    public $familyAddress;      //会员家庭住址
    public $chargePersonId;       //收费人员id
    //会员卡转让记录
    public $transferTime;      //转让时间
    public $memberCardNum;     //会员卡号
    public $memberSex;         //会员性别
    public $registerPerson;    //登记人
    public $firstName;         //原会员名
    public $firstSex;          //会员性别
    public $firstMobile;       //会员手机号
    public $cashierNumber;     //收银单号
    public $transferPrice;     //手续费（转让金额）
    public $cashPayment;       //现金支付
    public $bankCardPayment;   //银行卡支付
    public $memberCardPayment; //会员卡支付
    public $discount;           //折扣
    public $transfer;           //转账
    public $other;              //其他
    public $integral;           //积分
    public $spare;              //备用
    public $productName;
    public $type;
    public $endTime;
    public $chargeClassId;     // 私教产品id
    public $courseId;           // 课程id
    public $courseDetailId;    // 课程详情ID
    public $memberOrderId;
    public $pic;
    public $desc;
    public $startTime;
    public function autoLoadData($data){
        $data = array_values($data);
        $dataS = self::ANOTHER_PARAMETER;
        foreach($data as $keys=>$value){
            $key        = $dataS[$keys];
            $this->$key = $value;
        }
    }
    
    //导入会员私课数据（2017-5-17剩余课时查询.xls）
    public function loadFile($file,$type = 'private',$name = '艾搏')
    {
        $model = new Excel();
        $data = $model->loadPrivateExpireFile($file, $type);           //excel表数据
        $check = new ExcelCharge();
        $check->companyName = '艾搏';
        $check->venueType = '艾搏';
        $check->venueName = $name;
        $this->venueNameTwo = '艾搏尊爵汇';
        $check->getVenueId();                                           //获取场馆id
        $check->getCourseId();                                           //获取场馆id
        $check->cardCategoryId();
        $this->courseId   = $check->classKey;
        $this->courseName = $check->courseName;
        $this->organId    = $check->organId;
        $this->venueId    = $check->venueId;
        $this->departId   = $check->departId;
        foreach ($data as $k=>$v) {
            unset($v[6]);
            if (!$check->departId) {
                echo "venue>>" . '场馆不存在' . "<br /><br />";         //数据导入前 数据检查
            }
            $return = $this->getTransferInfo($v);                             //调用数据存放方法
            if($return !== true){
                return $return;
            }
        }
    }

    public function getTransferInfo($v)
    {
        if(isset($v) && !empty($v) && is_array($v))
        {
            $spare      = [];
            foreach($v as $k=>$val) {
                if ($k <= 12) {
                    $params = self::INFO;
                    $key = $params[$k];
                    $this->$key = $val;
                } else {
                    $params = self::INFO;
                    $key = $params[13];
                    array_push($spare, $val);           //把备用放到数组中
                    $this->$key = $spare;
                }
            }
            $transaction = \Yii::$app->db->beginTransaction();
            try{
                $v[4] = '0元'.$v[4];
                $this->privateClass = $v[4];
                $charge = $this->getChargeExist($v[4]);
                if(!$charge && empty($charge)){
                    $chargeClass = $this->setChargeInfo();
                    if(!isset($chargeClass->id)){
                        return $chargeClass;
                    }
                    $this->chargeClassId = $chargeClass->id;
                    $course = $this->saveCourse($chargeClass);
                    if($course !== true){
                        return $course;
                    }
                }else{
                    $this->chargeClassId = $charge['id'];
                    $course = $this->saveCourse($charge);
                    if($course !== true){
                        return $course;
                    }
                }
                $arrName = ['唐成','王亚明','刘天爱','孟海英'];
                if(!in_array($this->privateTeach,$arrName)){
                    $this->privateTeach = '邹学文';
                }
                $employeeModel = Employee::findOne(['name'=>$this->privateTeach,'venue_id'=>$this->venueId]);
                if(empty($employeeModel)){
                    $employee = new Employee();
                    $employee->name            = $this->privateTeach;
                    $employee->organization_id = $this->departId;
                    $employee->company_id      = $this->organId;
                    $employee->venue_id        = $this->venueId;
                    $employee->create_id       = 2;
                    if (!$employee->save()) {
                        $error = $employee->errors;
                        echo "employee>>" . $this->memberNumber . "<br /><br />";
                        return $error;
                    }
                    $this->employeeId = $employee->id;
                }else{
                    $this->employeeId = $employeeModel->id;
                }
                //查询会员是否存在
                $member = $this->getMemberExist($v[1],$v[2]);
                if(!$member && empty($member)) {
                    $member = $this->setMemberInfo();                                         //主要用生成的会员id
                    if(!isset($member->id)){
                        return $member;
                    }
                    $this->memberId = $member->id;
                }else{
                    $this->memberId = $member['id'];
                    $details = $this->getMemberDetailsExist($this->memberId);                  //查询会员详情是否存在
                    if(!$details && empty($details)){
                        $this->setMemberDetails();                           //生成会员详情
                    }
                }
                $memberCardModel = MemberCard::findOne(['and',['member_id'=>$this->memberId],['>=','invalid_time',time()]]);
                if(empty($memberCardModel)){
                    if(empty($v[0])){
                        $v[0] = $v[2];
                    }
                    $memberModel = MemberCard::findOne(['member_id'=>$this->memberId]);
                    //查询会员卡是否存在
                    if(empty($memberModel)){
                        $memberCard = $this->getMemberCardExist($v[0]);                                 //查询会员卡存不存在
                        if (!$memberCard && empty($memberCard)) {
                            $this->setMemberCardInfo($this->memberId,$v[0]);              //用会员卡id(返回的id)
                        } else {
                            //用会员卡id $memberCard['id']
                            $this->memberCardId = $memberCard['id'];                                     //会员卡id
                        }
                    }else{
                        $this->memberCardId = $memberModel->id;
                    }
                }else{
                    $this->memberCardId = $memberCardModel->id;
                }


                //会员课程订单表数据录入
                $memCourseResult = $this->memCourseOrder($this->memberId,$this->memberCardId);
                if(!$memCourseResult['id']){
                    return $memCourseResult;
                }
                //会员课程订单详情表数据录入
                $memCourseOrderDetail = $this->memCourseOrderDetail($memCourseResult['id']);
                if($memCourseOrderDetail!==true){
                    return $memCourseOrderDetail;
                }
                if($transaction->commit() !== null)                                                               //事务提交
                {
                    return false;
                }else{
                    return true;
                }
            } catch (\Exception $e) {
                $transaction->rollBack();       //回滚
                return $e->getMessage();
            }
        }
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
        $charge->name         = $this->privateClass;
        $charge->amount       = $this->classNum;
        $charge->created_at   = time();
        $charge->category     = 1;
        $charge->venue_id     = $this->venueId;
        $charge->total_amount = 0;
        $charge->status       = 1;
        $charge->type         = 2;
        $charge->sale_start_time = time();
        $charge->sale_end_time   = time() + 365*24*60*60;
        $charge->total_sale_num  = 999;
        $charge->valid_time	     = 365;
        $charge->company_id = $this->organId;
        if ($charge->save()) {
            return $charge;
        } else {
            return $charge->errors;
        }
    }

    //存储课种
    public function saveCourse($chargeClass)
    {
        $courseDetail                   = new CoursePackageDetail();
        $courseDetail->charge_class_id  = $this->chargeClassId;                      //收费课程表id
        $courseDetail->course_id        = $this->courseId;                      //课种id
        $courseDetail->course_length    = 60;                     //时长
        $courseDetail->original_price   = 240;                      //单节原价
        $courseDetail->course_num       = 1;                                    //单节课（课量存1）
        $courseDetail->type             = 1;                                    //1表示私课
        $courseDetail->create_at        = time();                               //创建时间
        $courseDetail->category         = 2;                                    //2表示单节课程
        $courseDetail = $courseDetail->save() ? $courseDetail : $courseDetail->errors;
        if (isset($courseDetail->id)) {
            return true;
        }else{
            return $courseDetail->errors;
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
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $member = new Member();
            $member->username      = $this->memberName;                           //用户名
            $member->mobile        = !empty($this->mobile)?$this->mobile:'0';    //手机号
            $member->password      = $password;                                //密码
            $member->register_time = time();                                   //注册时间(暂存转让时间)
            $member->update_at     = time();                                   //修改时间(当前时间)
            $member->venue_id      = $this->venueId;                          //场馆id
            $member->company_id    = $this->organId;                          //公司id
            $member = $member->save()?$member:$member->errors;
            if (isset($member->id)) {
                $this->memberId = $member->id;                  //现会员
             }else {
                return $member;
            }
            $detail = $this->setMemberDetails();        //添加会员详细信息
            if($detail !== true)
            {
                return $detail;
            }
            if($transaction->commit() !== null)                                                               //事务提交
            {
                return false;
            }else{
                return $member;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();       //回滚
            return $e->getMessage();
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
        $detail->created_at = time();                      //创建时间(暂存转让时间)
        $detail->updated_at = time();                     //修改时间(当前时间)
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
        $memberCard->card_number      = $cardNumber;             //会员卡号
        $memberCard->create_at        = time();      //开卡时间(暂存转让时间)
        $memberCard->amount_money     = 0;                       //金额
        $memberCard->status           = 1;                        //状态
        $memberCard->active_time      = time();      //激活时间(暂存转让时
        $memberCard->payment_type     = 1;                        //付款类型
        $memberCard->is_complete_pay  = 1;                        //是否完成付款
        $memberCard->invalid_time     = time();      //失效时间(暂存转让时
        $memberCard->level             = 0;                        //等级
        $memberCard->card_category_id =0;                        //卡种id
        $memberCard->member_id         = $memberId;               //会员id
        $memberCard->company_id        = $this->organId;          //公司id
        $memberCard->venue_id          = $this->venueId;          //场馆id
        $memberCard = $memberCard->save()?$memberCard:$memberCard->errors;
        if (!isset($memberCard->id)) {
            return $memberCard->errors;
        } else {
            $this->memberCardId = $memberCard->id;
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
        $memCourseOrder->money_amount           = intval($this->surplusNum * 240);             //总金额
        $memCourseOrder->overage_section        = $this->surplusNum;             //剩余节数
        $memCourseOrder->product_type           = 1;                             //产品类型:1私课2团课
        $memCourseOrder->private_id             = $this->employeeId;             //私教id
        $memCourseOrder->present_course_number  = $this->giveNum;              //赠课总次数
        $memCourseOrder->surplus_course_number  = $this->giveSurplusNum;      //剩余总课数
        $memCourseOrder->cashier_type           = 1;                           //收银类型（1.全款 2.转让 3.回款）
        $memCourseOrder->member_card_id         = $memberCardId;               //会员卡ID
        $memCourseOrder->member_id              = $memberId;                    //会员ID
        $memCourseOrder->product_name           = $this->privateClass;         //产品名称
        $memCourseOrder->deadline_time          = time() + 9999*24*60*60;
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
            $model->course_id        = $this->courseId;
            $model->course_name      = $this->courseName;
            $model->course_num       = $this->surplusNum;
            $model->class_length     = 60;
            $model->original_price   = 240;
            $model->sale_price       = 240;
            $model->type             = 1;
            $model->category         = 2;
            $model->product_name    = $this->privateClass;
            if(!$model->save()){
                return $model->errors;
            }
            return true;
        }
    }
    //导入会员私课数据（2017-5-17剩余课时查询.xls）
    public function loadAiBoFile($file,$type = 'private',$name = '艾搏')
    {
        $model = new Excel();
        $data = $model->loadPrivateNewExpireFile($file, $type);           //excel表数据
        $check = new ExcelCharge();
        $check->companyName = '艾搏';
        $check->venueType = '艾搏';
        $check->venueName = $name;
        $this->venueNameTwo = '艾搏尊爵汇';
        $check->getVenueId();                                           //获取场馆id
        $check->getCourseId();                                           //获取场馆id
        $check->cardCategoryId();
        $this->courseId   = $check->classKey;
        $this->courseName = $check->courseName;
        $this->organId    = $check->organId;
        $this->venueId    = $check->venueId;
        $this->departId   = $check->departId;
        foreach ($data as $k=>$v) {
//            unset($v[7],$v[8]);
            if (!$check->departId) {
                echo "venue>>" . '场馆不存在' . "<br /><br />";         //数据导入前 数据检查
            }
            $return = $this->saveCharge($v);                             //调用数据存放方法
            if($return !== true){
                return $return;
            }
        }
        return true;
    }
    /**
     * 云运动 - 会员买课 - 保存购买私教记录
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/5/19
     * @return boolean
     */
    public function saveCharge($v)
    {
//        var_dump($v);die();
        $memberCard = MemberCard::findOne(['card_number'=>$v[0]]);
        if(!empty($memberCard)){
            $this->memberId     = $memberCard->member_id;
            $this->memberCardId = $memberCard->id;
        }else{
            return true;
        }
//        if($v[9] == '定金'){
//            return true;
//        }
        //事务
//        $transaction = \Yii::$app->db->beginTransaction();
//        try {
            if($v[2] == '健身私教'){
                $v[2] = 'PT常规课';
            }
            if($v[2] == '游泳私教'){
                $v[2] = 'PT游泳课';
            }
            if($v[2] == 'MFT'){
                $v[2] = 'MFT格斗健身课程';
            }
            $this->totalNum = $v[4];
            $this->price    = $v[5];
            $this->endTime    = $v[8];
//        var_dump($this->endTime);die();
            $this->startTime  = $v[7];
            $employeeModel = Employee::findOne(['name'=>$v[3],'venue_id'=>$this->venueId]);
            if(empty($employeeModel)){
                $employee = new Employee();
                $employee->name            = $v[3];
                $employee->organization_id = $this->departId;
                $employee->company_id      = $this->organId;
                $employee->venue_id        = $this->venueId;
                $employee->create_id       = 2;
                if (!$employee->save()) {
                    $error = $employee->errors;
                    echo "employee>>" . $this->memberNumber . "<br /><br />";
                    return $error;
                }
                $this->employeeId = $employee->id;
            }else{
                $this->employeeId = $employeeModel->id;
            }
            $charge = ChargeClass::findOne(['name'=>$v[2]]);
             if(empty($charge)){
                 return true;
             }else{
                 $this->chargeClassId = $charge->id;
                 $this->productName   = $charge->name;
//                 $this->endTime       = $charge->valid_time;
                 $this->type          = $charge->private_class_type;
                 $this->pic           = $charge->pic;
                 $this->desc          = $charge->describe;
             }
            //会员第一次购买私课
            $memberOrder =  $this->setBuyClass();                                                 //保存购买私课订单
            if($memberOrder !== true)
            {
                return $memberOrder;                                                                    //购买失败
            }
            $details = $this->addCourseOrderDetails($this->memberOrderId,$this->chargeClassId);        //生成订单详情
            if($details == false){
                return false;                                                                    //订单详情生成失败
            }
            $history  = $this->addConsumptionHistory();
            if($history !== true){
                return $history;                                                                        //生成消费记录失败
            }
//            if($transaction->commit()){
//                return false;
//            }else{
                return true;                                                                         //提交
//            }
//        } catch (\Exception $e) {
//            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
//            $transaction->rollBack();
//            return  $e->getMessage();
//        }
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
        $member->service_pay_id        = $this->chargeClassId;                              //收费项目id(必填)买的课程id
        $member->seller_id             = $this->employeeId;                                 //销售私教ID(必填)
        $member->course_amount         = $this->totalNum;                                  //课程总节数
        $member->create_at             = intval($this->startTime);                                            //买课时间
        $member->money_amount          = intval($this->price) ;                                     //总金额
        $member->overage_section       = $this->totalNum;                                  //课程剩余节数
        $member->private_type          = '健身私教';                                        //私教类别
        $member->product_id            = $this->chargeClassId;                                   //产品id
        $member->product_type          = 1;                                                 //私课
        $member->deadline_time         = intval($this->endTime);              //课程截止时间

        $member->private_id            = $this->employeeId;                                    //私教id

        $member->present_course_number = 0;                                                  //赠送总次数
        $member->surplus_course_number = $this->totalNum;                                    //剩余总课数
        $member->business_remarks      = '销售渠道是：线下';                     //销售渠道
        $member->product_name          = $this->productName;                                 //产品名称
        $member->type                  = $this->type;                                        //类型：1 PT
        $member->set_number            = $this->totalNum;                                  //购买数量（套数或者单节）
        $memberSave = $member->save() ? $member : $member->errors;
        if (!isset($memberSave->id)) {
            return $memberSave->errors;
        }else{
            $this->memberOrderId = $memberSave->id;                                                //获取订单id
            return true;
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
         $history->consumption_amount  = intval($this->price);              //消费金额
        $history->consumption_time    = time();                         //消费时间
        $history->consumption_times   = 1;                              //消费次数
        $history->describe            = json_encode(['note'=>'']);
        $history->category            = '购买';                //消费类型状态
        $history->cash_payment        = intval($this->price);              //现金付款
        $history->network_payment     = intval($this->price);              //网络付款
        $history->seller_id           = $this->employeeId;                 //销售私教id
        $history->company_id          = $this->organId;
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
        $model = new CoursePackageDetail();
        $data  = $model->getClassPrice($chargeId);
        foreach($data as $k=>$v)
        {
            $details = new MemberCourseOrderDetails();
            $details->course_order_id = $orderId;               //订单id
            $details->course_id       = $v['course_id'];        //课种id
            $details->course_num      = $this->totalNum;       //课量
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
            if(!$details->save()){
                return false;
                break;
            }
        }
        return true;
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
}