<?php
namespace backend\models;
use common\models\base\CardCategory;
use common\models\base\ConsumptionHistory;
use common\models\base\Employee;
use common\models\base\LimitCardNumber;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\MemberDetails;
use common\models\base\Organization;
use common\models\base\VenueLimitTimes;
use common\models\Func;
use Yii;
use common\models\Excel;
use yii\base\Model;

class ExcelAiBoMember extends Model
{
    const  PARAMS_ONE = ['memberNumber','memberName','memberMobile','memberStatus','cardName','store','status','chargeDate','dateStart','remainingDate','dateEnd'];
    const  PARAMS_NEW = ['memberNumber','cardName','memberName','memberSex','memberMobile','memberIdCard','memberConsultant','price','chargeDate','dateStart','dateEnd','giveMonth','givePrivate','note'];
    const  PARAMS_NEWS= ['type','memberNumber','memberName','memberConsultant','cardName','note','chargeDate','price','dateStart','dateEnd'];
    const  PARAMS_TWO = ['memberNumber','cardName','memberName','memberSex','memberMobile','memberIdCard','memberConsultant','price','deposit','payment','chargeDate','dateStart','dateEnd'];
    const  PARAMS_THR = ['store','memberName','orderNumber','orderType','dateStart','dateEnd','cardName','receivable','discount','transaction','price','owe','priceType','memberConsultant','seller','chargeDate','note'];
    const  PARAMS_YX  = ['type','memberNumber','memberName','memberIdCard','birth','memberMobile','memberConsultant','cardName','chargeDate','price','dateStart','dateEnd','note','score'];
    const  PRICE_TYPE = [1=>'定金',2=>'发卡',3=>'续费',4=>'回款',5=>'升级',6=>'续定',7=>'续回'];
    const  EMPLOYEE_DATA = ['company','store','employeeName','employeeAlias','employeeSex','employeeMobile','position','employeeStatus','employeeWorkTime'];
    const  INCUMBENCY    = ['在职'=>1,'离职'=>2,'调岗'=>3,'全职'=>4,'兼职'=>5,'停薪留职'=>6,'辞退'=>7];
    public $memberNumber;      //会员卡 卡号
    public $memberName;        //会员姓名
    public $memberMobile;      //会员手机号
    public $memberSex;         //会员性别
    public $memberStatus;        //会员类型
    public $status;
    public $store;               //门店
    public $orderNumber;        //订单号
    public $orderType;        //订单号
    public $memberIdCard;      //会员身份证号
    public $coach;            //私教教练
    public $giveMonth;
    public $birth;
    public $privateCoach;     //私教课程
    public $classNum;         //课量
    public $attendNum;         //已上课量
    public $surplusNum;        //剩余课量
    public $giveNum;           //赠送课量
    public $surplusGiveNum;    //剩余赠送课量
    public $price;             // 单价
    public $totalPrice;        // 总价
    public $memberConsultant; //会员顾问
    public $seller;
    public $cardName;          //会员卡名称
    public $businessAmount;    //业务金额
    public $giveAmount;        //买增金额
    public $givePrivate;       //赠送私教
    public $dateStart;         //开始日期
    public $dateEnd;           //结束日期
    public $chargeDate;        //收费日期
    public $giveCharge;
    public $note;              //备注
    public $score;             //积分
    public $deposit;           //定金
    public $payment;            //回款
    public $memberCard;        //会员卡
    public $membershipType;    //会籍类型
    public $remainingDate;    //剩余
    public $sellerId;            //销售员
    public $venueId;            //场馆ID
    //场馆数据
    public $venueName;
    public $venuePid;
    public $venueStyle;
    public $venueCode;
    public $organId;       //组织ID
    public $departId;      //部门ID
    public $employeeId;      //员工ID
    public $memberId;      //会员ID
    public $memberCardId;   //会员卡ID
    public $cardId;        //卡种ID
    public $priceStatus;   //消费状态
    public $receivable;    //应收金额
    public $discount;       //优惠额
    public $transaction;    //成交价
    public $owe;            //欠款
    public $priceType;
    public $totalTimes;
    public $overTimes;
    public $venueNameTwo;
    public $venueType;
    public $cardType;

    public $allTimes;
    public $paramType;
    public $adminId;
    public $error = array();
    public $type;
    public $cardStatus;
    //   start  Employee
    public $company;         //公司
    public $employeeName;    //员工姓名
    public $employeeAlias;   //员工别名
    public $employeeSex;     //员工性别
    public $employeeMobile;  //员工手机号
    public $position;       //职位
    public $employeeStatus; //
    public $employeeWorkTime;//
    public $path;
    //    end   Employee
    public function loadData($val)
    {
        if(isset($val) && !empty($val) && is_array($val)){
            foreach ($val as $k=>$v){
                if($this->paramType == 'one'){
                    if($k == 13){
                        continue;
                    }
                    $params = self::PARAMS_TWO;
                    $key  = $params[$k];
                    if(in_array($k,[10,11,12])){
                        $arr = explode('.',$v);
                        $v   = implode('-',$arr);
                        $this->$key = strtotime($v);
                        continue;
                    }
                    $this->$key = $v;
                }else if($this->paramType == 'two'){
                    $params = self::PARAMS_NEW;
                    $key    = $params[$k];
                    $this->$key = $v;
                }else{
                    $params = self::PARAMS_NEWS;
                    $key    = $params[$k];
                    $this->$key = $v;
                }
            }
        }
    }
    public function loadFile($path,$venue = '大上海',$name,$type='one'){
        $model = new Excel();
        $this->venueType    = $venue;
        $this->venueNameTwo = $name;
        $this->paramType    = $type;
        if($type == 'two'){
            $data = $model->loadFileAiBoNewMember($path);
        }elseif($type == 'three'){
            $data = $model->loadFileAiBoNewMember($path,'K');
        }else{
            $data = $model->loadFileAiBoNewMember($path);
        }

        $this->getAdminIdOne();
        $this->getVenueId();
        //插入到数据库
        $num = 0;
        foreach($data as $key=>$val){
            $this->loadData($val);
//            var_dump($this->memberConsultant);die();
            $member        = new Member();
            $cardCategory  = new CardCategory();
            $memberCard    = new MemberCard();
            $memberDetail  = new MemberDetails();

            if(!$this->memberNumber || !$this->cardName){
                continue;
            }
            if(!$this->memberNumber || !$this->cardName){
                $this->error[] = $key;
            }
            if($this->paramType == 'two' || $this->paramType == 'three'){
                if($this->note == '定金'){
                    continue;
                }
            }
            //插入会员卡表
            //判断会员卡号是否存在
            $memberCardModel = MemberCard::findOne(["card_number"=>(string)$this->memberNumber]);
            if(!empty($memberCardModel)){
                continue;
            }
            if($this->cardName == '升级游泳提高班'){
                continue;
            }
            $transaction  = Yii::$app->db->beginTransaction();     //事务开始
            try{
                //插入员工表（会籍顾问）
                //判断员工是否存在，如果存在直接取id，否则直接插入
                if($this->memberConsultant) {
                    $employeeModel = Employee::findOne(['name' => $this->memberConsultant,'organization_id'=>$this->departId]);
                    if (empty($employeeModel)) {
                        $employee = new Employee();
                        $employee->name = $this->memberConsultant;
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
                    } else {
                        $this->employeeId = $employeeModel->id;
                    }
                }
                $typeAttr = 'two';
                if($this->cardName == '白金瑜伽一年卡'){
                    $this->cardName = '一年白金瑜伽卡';
                    $typeAttr       = 'one';
                }
                if($this->cardName == '白金瑜伽两年卡'){
                    $this->cardName = '两年白金瑜伽卡';
                    $typeAttr       = 'one';
                }
                if($this->cardName == '游泳初级班12次课'){
                    $this->cardName = '游泳初级班';
                    $typeAttr       = 'one';
                }
                if($this->cardName == 'ETQS亲水班'){
                    $this->cardName = '游泳亲水班';
                    $typeAttr       = 'one';
                }
                if($this->cardName == '游泳提高班12次课'){
                    $this->cardName = '游泳提高班';
                    $typeAttr       = 'one';
                }
                if($this->cardName == '月卡'){
                    $this->cardName = '999元月卡';
                    $typeAttr       = 'one';
                }
                if($this->cardName == '26个月白金瑜伽卡'){
                    $typeAttr       = 'one';
                }
                if($this->cardName == '单人4年金爵卡'){
                    $typeAttr       = 'one';
                }
                if($this->cardName == 'WDT24MD'){
                    $this->cardName = 'WD T24MD';
                    $this->note     = '升级';
                    $typeAttr       = 'one';
                }
                if($this->cardName == 'T36MD'){
                    $this->cardName = 'T36MD';
                    $this->note     = '升级';
                    $typeAttr       = 'one';
                }
                if($this->cardName == '60次次卡'){
                    $this->totalTimes = 56;
                    $this->allTimes   = 60;
                    $this->overTimes  = 4;
                }
                if($this->cardName == '*WDCK1001-1*60*次卡'){
                    $this->totalTimes = 16;
                    $this->allTimes   = 16;
                    $this->overTimes  = 0;
                }
                //插入卡种表
                //判断卡种是否存在
                $cardCategoryModel = CardCategory::findOne(["card_name"=>"$this->cardName",'venue_id'=>$this->venueId]);
                if(empty($cardCategoryModel)){
                    if(strpos($this->cardName,'次')){
                        $num = 2;
                    }else{
                        $num = 1;
                    }
                    $cardCategory->card_name        = "$this->cardName";
                    $cardCategory->category_type_id = (int)$num;
                    $cardCategory->venue_id         = $this->venueId;
                    $cardCategory->company_id       = $this->organId;
                    $cardCategory->create_id        = 2;
                    $cardCategory->deal_id          = 0;
                    $cardCategory->times            = $this->allTimes;
                    if(!$cardCategory->save()){
                        $error = $cardCategory->errors;
                        echo "cardCategory>>".$this->memberNumber."<br /><br />";
                        return $error;
                    }
                    $this->cardId = $cardCategory->id;
                }else{
                    $this->cardId = $cardCategoryModel->id;
                }
                //插入会员表
                //判断会员是否存在(根据手机号码)
//                "username"=>$this->memberName,
                $memberModel = Member::find()->where(['mobile'=>$this->memberMobile,'venue_id'=>intval($this->venueId)])->orderBy('id DESC')->one();

                if(empty($memberModel)){
                    $password = '123456';
                    $password = Yii::$app->security->generatePasswordHash($password);
                    $member->username      = isset($this->memberName)?$this->memberName:'暂无';
                    $member->mobile        = $this->memberMobile?"$this->memberMobile":'0';     //会员手机号
                    $member->password      = $password;
                    $member->register_time = time();
                    $member->counselor_id  = $this->employeeId;
                    $member->status        = 1;
                    $member->venue_id      = $this->venueId;
                    $member->company_id    = $this->organId;
                    if(!$member->save()){
                        $error = $member->errors;
                        echo "member>>".$this->memberNumber."<br /><br />";
                        return $error;
                    }
                    $this->memberId = $member->id;
                }else{
                    if(empty($memberModel['venue_id'])){
                        $memberModel->venue_id = $this->venueId;
                        $memberModel->company_id    = $this->organId;
                        if(!$memberModel->save()){
                            return $memberModel->errors;
                        }
                        $this->memberId = isset($memberModel->id)?$memberModel->id:$memberModel['id'];
                    }else{
                        $this->memberId = isset($memberModel->id)?$memberModel->id:$memberModel['id'];
                    }
                }
                //插入会员详情表
                $memberDetailModel = MemberDetails::find()->where(["member_id"=>$this->memberId])->asArray()->one();
                if(empty($memberDetailModel)){
                    $memberDetail->member_id = $this->memberId;
                    $memberDetail->name      = $this->memberName;
                    $memberDetail->id_card   = $this->memberIdCard;
                    $memberDetail->sex       = $this->memberSex == '男' ? 1 : 2;
                    $memberDetail->created_at = time();
                    $memberDetail->recommend_member_id = 0;
                    if(!$memberDetail->save()){
                        $error = $member->errors;
                        echo "memberDetail>>".$this->memberNumber."<br /><br />";
                        return $error;
                    }
                }
                //插入会员卡表
                //判断会员卡号是否存在
                $memberCardModel = MemberCard::findOne(["card_number"=>(string)$this->memberNumber]);
                if(empty($memberCardModel)){
                    $memberCard->card_number      = (string)$this->memberNumber;
                    $memberCard->create_at        = abs((int)$this->chargeDate);
                    $memberCard->active_time      = abs((int)$this->dateStart);
                    $memberCard->member_id        = $this->memberId;
                    $memberCard->card_category_id = $this->cardId;
                    $memberCard->payment_type     = 1;
                    $memberCard->payment_time     = 1;
                    $memberCard->is_complete_pay  = 1;
                    $memberCard->level            = 1;
                    $memberCard->status           = 1;
                    $memberCard->total_times       = $this->allTimes;
                    $memberCard->consumption_times = $this->overTimes;
                    $memberCard->card_name        = "$this->cardName";
                    $memberCard->invalid_time     = abs((int)$this->dateEnd);
                    $memberCard->payment_time     = abs((int)$this->chargeDate);
                    $memberCard->amount_money     = intval($this->price);
                    $memberCard->present_private_lesson = intval($this->givePrivate);
                    $memberCard->describe         = "$this->note";
                    /**/
                    if($typeAttr == 'one'){
                        $memberCard->another_name       = $cardCategoryModel->another_name;          //另一个卡名
                        $memberCard->card_type          = $cardCategoryModel->category_type_id;      //卡类别
                        $memberCard->count_method       = $cardCategoryModel->count_method;          //计次方式
                        $memberCard->attributes         = $cardCategoryModel->attributes;             //属性
                        $memberCard->active_limit_time =  $cardCategoryModel->active_time;            //激活期限
                        $memberCard->transfer_num       = $cardCategoryModel->transfer_number;       //转让次数
                        $memberCard->surplus            = $cardCategoryModel->transfer_number;       //剩余转让次数
                        $memberCard->transfer_price     = $cardCategoryModel->transfer_price;        //转让金额
                        $memberCard->recharge_price     = $cardCategoryModel->recharge_price;        //充值卡充值金额
                        $memberCard->present_money      = $cardCategoryModel->recharge_give_price;  //买赠金额
                        $memberCard->renew_price        = $cardCategoryModel->renew_price;           //续费价
                        $memberCard->renew_best_price   = $cardCategoryModel->offer_price;          //续费优惠价
                        $memberCard->renew_unit         = $cardCategoryModel->renew_unit;            //续费多长时间/天
                        $memberCard->leave_total_days   = $cardCategoryModel->leave_total_days;     //请假总天数
                        $memberCard->leave_least_days   = $cardCategoryModel->leave_least_Days;     //每次请假最少天数
                        $time          = json_decode($cardCategoryModel->duration,true);                  //卡种有效期
                        $leave         = json_decode($cardCategoryModel->leave_long_limit,true);         //卡种每次请假天数、请假次数
                        $memberCard->leave_days_times   = json_encode($leave);                   //每次请假天数、请假次数
                        $memberCard->deal_id             = $cardCategoryModel->deal_id;               //合同id
                        $memberCard->duration            = $time['day'];                         //有效期
                    }else{
                        $memberCard->card_type        = 1;
                    }
                    $memberCard->employee_id      = $this->employeeId;
                    $memberCard->company_id       = $this->organId;
                    $memberCard->venue_id         = $this->venueId;
                    if(!$memberCard->save()){
                        $error = $memberCard->errors;
                        echo "memberCard>>".$this->memberNumber."<br /><br />";
                        return $error;
                    }
                    $this->memberCardId = $memberCard->id;
                }else{
                    $this->memberCardId = isset($memberCardModel->id)?$memberCardModel->id:$memberCardModel['id'];
//                    $memberCardModelTwo = MemberCard::findOne(["member_id"=>$this->memberId,'invalid_time'=>intval($this->dateEnd)]);
//                    if(empty($memberCardModelTwo)){
//                        if($memberCardModel['invalid_time'] < intval($this->dateEnd)){
//                            $memberCardModel->card_number      = (string)$this->memberNumber;
//                            if((isset($memberCardModel->create_at) && empty($memberCardModel->create_at)) || (isset($memberCardModel['create_at'])&& empty($memberCardModel['create_at']))){
//                                $memberCardModel->create_at      = abs((int)$this->dateStart);
//                            }
//                            if((isset($memberCardModel->active_time) && empty($memberCardModel->active_time)) || (isset($memberCardModel['active_time'])&& empty($memberCardModel['active_time']))){
//                                $memberCardModel->active_time      = abs((int)$this->dateStart);
//                            }
//                            $memberCardModel->member_id        = $this->memberId;
//                            $memberCardModel->card_category_id = $this->cardId;
//                            $memberCardModel->payment_type     = 1;
//                            $memberCardModel->payment_time     = 1;
//                            $memberCardModel->is_complete_pay  = 1;
//                            $memberCardModel->level            = 1;
//                            $memberCardModel->status           = 1;
//                            /**/
//                            if($typeAttr == 'one'){
//                                $memberCardModel->another_name       = $cardCategoryModel->another_name;          //另一个卡名
//                                $memberCardModel->card_type          = $cardCategoryModel->category_type_id;      //卡类别
//                                $memberCardModel->count_method       = $cardCategoryModel->count_method;          //计次方式
//                                $memberCardModel->attributes         = $cardCategoryModel->attributes;             //属性
//                                $memberCardModel->active_limit_time = $cardCategoryModel->active_time;            //激活期限
//                                $memberCardModel->transfer_num       = $cardCategoryModel->transfer_number;       //转让次数
//                                $memberCardModel->surplus            = $cardCategoryModel->transfer_number;       //剩余转让次数
//                                $memberCardModel->transfer_price     = $cardCategoryModel->transfer_price;        //转让金额
//                                $memberCardModel->recharge_price     = $cardCategoryModel->recharge_price;        //充值卡充值金额
//                                $memberCardModel->present_money      = $cardCategoryModel->recharge_give_price;  //买赠金额
//                                $memberCardModel->renew_price        = $cardCategoryModel->renew_price;           //续费价
//                                $memberCardModel->renew_best_price   = $cardCategoryModel->offer_price;          //续费优惠价
//                                $memberCardModel->renew_unit         = $cardCategoryModel->renew_unit;            //续费多长时间/天
//                                $memberCardModel->leave_total_days   = $cardCategoryModel->leave_total_days;     //请假总天数
//                                $memberCardModel->leave_least_days   = $cardCategoryModel->leave_least_Days;     //每次请假最少天数
//                                $time          = json_decode($cardCategoryModel->duration,true);                  //卡种有效期
//                                $leave         = json_decode($cardCategoryModel->leave_long_limit,true);         //卡种每次请假天数、请假次数
//                                $memberCardModel->leave_days_times   = json_encode($leave);                   //每次请假天数、请假次数
//                                $memberCardModel->deal_id             = $cardCategoryModel->deal_id;               //合同id
//                                $memberCardModel->duration            = $time['day'];                         //有效期
//                            }else{
//                                $memberCardModel->card_type        = 1;
//                            }
//                            $memberCardModel->total_times       = $this->totalTimes;
//                            $memberCardModel->consumption_times = $this->overTimes;
//                            $memberCardModel->card_name        = $this->cardName;
//                            $memberCardModel->invalid_time     = abs((int)$this->dateEnd);
//                            $memberCardModel->payment_time     = abs((int)$this->chargeDate);
//                            $memberCardModel->present_money    = $this->giveAmount;
//                            $memberCardModel->amount_money     = $this->businessAmount;
//                            $memberCardModel->present_private_lesson = intval($this->givePrivate);
//                            $memberCardModel->describe         = "$this->note";
//                            $memberCardModel->employee_id      = $this->employeeId;
//                            $memberCardModel->company_id       = $this->organId;
//                            $memberCardModel->venue_id         = $this->venueId;
//                            if(!$memberCardModel->save()){
//                                $error = $memberCardModel->errors;
//                                echo "memberCard>>".$this->memberNumber."<br /><br />";
//                                return $error;
//                            }
//                            $this->memberCardId = isset($memberCardModel->id)?$memberCardModel->id:$memberCardModel['id'];
//                        }else{
//                            $this->memberCardId = isset($memberCardModel->id)?$memberCardModel->id:$memberCardModel['id'];
//                        }
//                    }else{
//                        $this->memberCardId = isset($memberCardModelTwo->id)?$memberCardModelTwo->id:$memberCardModelTwo['id'];
//                    }
                }
                $limitArr = LimitCardNumber::find()->where(['card_category_id'=>$this->cardId])->asArray()->all();
                if(is_array($limitArr) && !empty($limitArr)){
                    foreach ($limitArr as $v){
                        $isVenueLimit = VenueLimitTimes::find()->where(['member_card_id'=>$this->memberCardId])->andWhere(['venue_id'=>$v['venue_id']])->asArray()->one();
                        if(!empty($isVenueLimit)){
                            continue;
                        }
                        $venueLimit    = new VenueLimitTimes();
                        $venueLimit->member_card_id = $this->memberCardId;
                        $venueLimit->venue_id       = $v['venue_id'];
                        $venueLimit->total_times    = intval($v['times']);
                        $venueLimit->overplus_times = intval($v['times']);
                        if(!$venueLimit->save()){
                            return $venueLimit->errors;
                        }
                    }
                }else{
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
                }
                $errors = $this->loadConsumptionData();
                if($errors !== true){
                    return  $errors;
                }
                if($transaction->commit() !== null){
                    return false;
                }
            }catch(\Exception $ex){
                $transaction->rollBack();
                return  $ex->getMessage();
            }
            $num++;
            echo $num.'->';
        }
        if(empty($this->error)){
            return true;
        }else{
            return $this->error;
        }

    }
    public function getVenueId()
    {
        $organ      =  Organization::find()->where(['like','name','郑州市艾搏健身服务有限公司'])->andWhere(['style'=>1])->asArray()->one();
        if(empty($organ)){
            $this->venueName  = '郑州市艾搏健身服务有限公司';
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
    /**
     * 后台 - 消费记录表 - 数据遍历
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/10
     * @param  //所有数据录入
     * @return object   //消费记录表数据录入结果
     */
    public function loadConsumptionData()
    {
        $transaction = \Yii::$app->db->beginTransaction();                //开启事务
        try {
            //消费表数据保存
            $model = new ConsumptionHistory();
            $model->member_id             = $this->memberId;     ;        //?从对方获取插入的会员id
            $model->consumption_type      = "card";
            $model->consumption_type_id   = $this->memberCardId;        //?从对方拿取  （对方插入会员卡表时的id）
            $model->type                  = 1;        //消费方式暂定1（现金）；
            $model->consumption_date      = intval($this->chargeDate);   //消费日期
            $model->consumption_amount    = intval($this->price);            //?消费金额 遍历数据拿出来
            $model->consumption_times     = 1;                        //消费次数
            $number = Func::setOrderNumber();
            $model->cashier_order         = "$number";    //收银单号
            $model->cash_payment          = intval($this->price);             //现金付款
            $model->seller_id              = $this->employeeId;          //销售人员id
            $model->category               = !empty($this->note)?(string)$this->note:'购卡';
            $model->due_date               = abs((int)$this->dateEnd);
            $modelResult = $model->save() ? true :false ;
            if($modelResult === false){
                return $model->errors;
                throw new \Exception('导入失败');
            }
            $transaction->commit();
            return true;
        }catch(\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return  $error = $e->getMessage();  //获取抛出的错误
        }
    }
    public function loadDataMember($val)
    {
        if(isset($val) && !empty($val) && is_array($val)){
            foreach ($val as $k=>$v){
                $params = self::PARAMS_ONE;
                $key    = $params[$k];
                if(in_array($k,[7,8,10])){
                    $this->$key = strtotime($v);
                    continue;
                }
                $this->$key = $v;
            }
        }
    }
    public function loadMember($path,$venue,$name,$type)
    {
        $model = new Excel();
        $this->venueType    = $venue;
        $this->venueNameTwo = $name;
        $this->paramType    = $type;
        if($type == 'two'){
            $data = $model->loadFileAiBoMember($path);
        }elseif($type == 'three'){
            $data = $model->loadFileAiBoMember($path);
        }else{
            $data = $model->loadFileAiBoMember($path);
        }
        $this->getAdminIdOne();
        $this->getVenueId();
        $this->venueId = 76;
        $this->organId = 75;
        foreach ($data as $key=>$value){
           $this->loadDataMember($value);

           $memberModel = Member::find()->where(['username'=>$this->memberName,'venue_id'=>$this->venueId])->one();
            $password = '123456';     //会员临时密码
            $password = \Yii::$app->security->generatePasswordHash($password);
           if(empty($memberModel)){
               $model                = new Member();
               $model->username      = $this->memberName;       //用户名
               $model->password      = $password;               //密码
               $model->mobile        = $this->memberMobile?"$this->memberMobile":'0';     //会员手机号
               $model->register_time = time();//会员注册时间
               $model->venue_id      = intval($this->venueId);        //场馆id
               $model->company_id    = intval($this->organId);        //场馆id
               if (!$model->save()) {
                   $error = $model->errors;
                   var_dump($error);die();
                   echo "member>>" . $this->memberName . "<br /><br />";
                   return $error;
               }
               $this->memberId = $model->id;
           }else{
               if(empty($memberModel->mobile)){
                   $memberModel->mobile = $this->memberMobile;
                   if(!$memberModel->save()){
                       $error = $model->errors;
                       var_dump($error);die();
                       echo "member>>" . $this->memberName . "<br /><br />";
                       return $error;
                   }
                   $this->memberId = $memberModel->id;
               }else if($memberModel->mobile != $this->memberMobile){
                   $model                = new Member();
                   $model->username      = $this->memberName;       //用户名
                   $model->password      = $password;               //密码
                   $model->mobile        = $this->memberMobile?"$this->memberMobile":'0';     //会员手机号
                   $model->register_time = time();//会员注册时间
                   $model->venue_id      = intval($this->venueId);        //场馆id
                   $model->company_id    = intval($this->organId);        //场馆id
                   if (!$model->save()) {
                       $error = $model->errors;
                       var_dump($error);die();
                       echo "member>>" . $this->memberName . "<br /><br />";
                       return $error;
                   }
                   $this->memberId = $model->id;
               }else{
                   $this->memberId = $memberModel->id;
               }
           }
            if(empty(!$this->memberNumber)){
                $number             = time().mt_rand(100,999);
                $this->memberNumber = "$number";
                $this->cardStatus   = 1;
            }
            //插入卡种表
            //判断卡种是否存在
            $cardCategoryModel = CardCategory::find()->where(["card_name"=>"$this->cardName",'venue_id'=>$this->venueId])->asArray()->one();
            if(empty($cardCategoryModel)){
                if(strpos($this->cardName,'次')){
                    $num = 2;
                }else{
                    $num = 1;
                }
                $cardCategory                   = new CardCategory();
                $cardCategory->card_name        = "$this->cardName";
                $cardCategory->category_type_id = (int)$num;
                $cardCategory->venue_id         = $this->venueId;
                $cardCategory->company_id       = $this->organId;
                $cardCategory->create_id        = 2;
                $cardCategory->deal_id          = 0;
                $cardCategory->times            = intval($this->remainingDate);
                if(!$cardCategory->save()){
                    $error = $cardCategory->errors;
                    echo "cardCategory>>".$this->memberNumber."<br /><br />";
                    return $error;
                }
                $this->cardId = $cardCategory->id;
            }else{
                $this->cardId = $cardCategoryModel['id'];
            }
            if(strpos($this->cardName,'金爵') || strpos($this->cardName,'尊爵')){
                $venue      =  Organization::find()->where(['pid'=>$this->organId])->asArray()->all();
                if(!empty($venue)){
                    foreach ($venue as $v){
                        $isLimit = LimitCardNumber::find()->where(['card_category_id'=>$this->cardId])->andWhere(['venue_id'=>$v['id']])->asArray()->one();
                        if(!empty($isLimit)){
                            continue;
                        }
                        $limit         = new LimitCardNumber();
                        if(strpos($this->cardName,'尊爵') && !strpos($v['name'],'大卫城') && $this->venueNameTwo == '大卫城'){
                            continue;
                        }
                        if(strpos($v['name'],'大卫城') && $this->venueNameTwo != '大卫城'){
                            $num = 6;
                        }else{
                            $num = -1;
                        }
                        $limit->card_category_id = $this->cardId;
                        $limit->venue_id         = $v['id'];
                        $limit->times            = $num;
                        $limit->level            = 1;
                        $limit->surplus          = -1;
                        if(!$limit->save()){
                            return $limit->errors;
                        }
                    }
                }
            }else{
                $isLimit = LimitCardNumber::find()->where(['card_category_id'=>$this->cardId])->andWhere(['venue_id'=>$this->venueId])->asArray()->one();
                if(empty($isLimit)){
                    $limit         = new LimitCardNumber();
                    $limit->card_category_id = $this->cardId;
                    $limit->venue_id         = $this->venueId;
                    $limit->times            = -1;
                    $limit->surplus          = -1;
                    if(!$limit->save()){
                        return $limit->errors;
                    }
                }
            }

            //插入会员详情表
            $memberDetail_model = MemberDetails::find()->where(["member_id"=>$this->memberId])->asArray()->one();
            if(empty($memberDetail_model)){
                $memberDetail            = new MemberDetails();
                $memberDetail->member_id = $this->memberId;
                $memberDetail->name      = $this->memberName;
                $memberDetail->sex       = 0;
                $memberDetail->created_at = time();
                $memberDetail->recommend_member_id = 0;
                if(!$memberDetail->save()){
                    echo "memberDetail>>".$this->memberNumber."<br /><br />";
                    return $memberDetail->error;
                }
            }
            //插入会员卡表
            //判断会员卡号是否存在
            $memberCardModel = MemberCard::findOne(["card_number"=>(string)$this->memberNumber]);
            if(empty($memberCardModel)){
                $memberCardModelTwo = MemberCard::findOne(["card_number"=>(string)$this->memberMobile]);
                if(empty($memberCardModelTwo)){
                    $memberCard                  = new MemberCard();
                    $memberCard->card_number      = (empty($this->memberNumber))?$this->memberMobile:(string)$this->memberNumber;
                    $memberCard->create_at        = abs((int)$this->dateStart);
                    $memberCard->active_time      = abs((int)$this->dateStart);
                    $memberCard->member_id        = $this->memberId;
                    $memberCard->card_category_id = $this->cardId;
                    $memberCard->payment_type     = 1;
                    $memberCard->payment_time     = 1;
                    $memberCard->is_complete_pay  = 1;
                    $memberCard->level            = 1;
                    $memberCard->status           = !empty($this->cardStatus)?$this->cardStatus:1;;
                    $memberCard->card_type        = 1;
                    $memberCard->total_times       = (strpos($this->remainingDate,'次'))? intval($this->remainingDate) : 0 ;
                    $memberCard->consumption_times = 0 ;
                    $memberCard->card_name        = "$this->cardName";
                    $memberCard->invalid_time     = abs((int)$this->dateEnd);
                    $memberCard->payment_time     = abs((int)$this->chargeDate);
                    $memberCard->present_money    = $this->giveAmount;
                    $memberCard->amount_money     = $this->businessAmount;
                    $memberCard->present_private_lesson = intval($this->givePrivate);
                    $memberCard->describe         = "$this->note";
                    $memberCard->employee_id      = $this->sellerId;
                    $memberCard->company_id       = $this->organId;
                    $memberCard->venue_id         = $this->venueId;
                    if(!$memberCard->save()){
                        $error = $memberCard->errors;
                        echo "memberCard>>".$this->memberNumber."<br /><br />";
                        return $error;
                    }
                    $this->memberCardId = $memberCard->id;
                }else{
                    $this->memberCardId = $memberCardModelTwo->id;
                }
            }else{
                $memberCardModelTwo = MemberCard::findOne(["member_id"=>$this->memberId,'invalid_time'=>intval($this->dateEnd)]);
                if(empty($memberCardModelTwo)){
                    if($memberCardModel['invalid_time'] < intval($this->dateEnd)){
                        $memberCardModel->card_number      = (string)$this->memberNumber;
                        if((isset($memberCardModel->create_at) && empty($memberCardModel->create_at)) || (isset($memberCardModel['create_at'])&& empty($memberCardModel['create_at']))){
                            $memberCardModel->create_at      = abs((int)$this->dateStart);
                        }
                        if((isset($memberCardModel->active_time) && empty($memberCardModel->active_time)) || (isset($memberCardModel['active_time'])&& empty($memberCardModel['active_time']))){
                            $memberCardModel->active_time      = abs((int)$this->dateStart);
                        }
                        $memberCardModel->member_id        = $this->memberId;
                        $memberCardModel->card_category_id = $this->cardId;
                        $memberCardModel->payment_type     = 1;
                        $memberCardModel->payment_time     = 1;
                        $memberCardModel->is_complete_pay  = 1;
                        $memberCardModel->level            = 1;
                        $memberCardModel->status           = 1;
                        $memberCardModel->card_type        = 1;
                        $memberCardModel->total_times       = (strpos($this->remainingDate,'次'))? intval($this->remainingDate) : 0 ;
                        $memberCardModel->consumption_times = 0 ;
                        $memberCardModel->card_name        = $this->cardName;
                        $memberCardModel->invalid_time     = abs((int)$this->dateEnd);
                        $memberCardModel->payment_time     = abs((int)$this->chargeDate);
                        $memberCardModel->present_money    = $this->giveAmount;
                        $memberCardModel->amount_money     = $this->businessAmount;
                        $memberCardModel->present_private_lesson = intval($this->givePrivate);
                        $memberCardModel->describe         = "$this->note";
                        $memberCardModel->employee_id      = $this->sellerId;
                        $memberCardModel->company_id       = $this->organId;
                        $memberCardModel->venue_id         = $this->venueId;
                        if(!$memberCardModel->save()){
                            $error = $memberCardModel->errors;
                            echo "memberCard>>".$this->memberNumber."<br /><br />";
                            return $error;
                        }
                        $this->memberCardId = isset($memberCardModel->id)?$memberCardModel->id:$memberCardModel['id'];
                    }else{
                        $this->memberCardId = isset($memberCardModel->id)?$memberCardModel->id:$memberCardModel['id'];
                    }
                }else{
                    $this->memberCardId = isset($memberCardModelTwo->id)?$memberCardModelTwo->id:$memberCardModelTwo['id'];
                }
            }
            $limitArr = LimitCardNumber::find()->where(['card_category_id'=>$this->cardId])->asArray()->all();
            if(is_array($limitArr) && !empty($limitArr)){
                foreach ($limitArr as $v){
                    $isVenueLimit = VenueLimitTimes::find()->where(['member_card_id'=>$this->memberCardId])->andWhere(['venue_id'=>$v['venue_id']])->asArray()->one();
                    if(!empty($isVenueLimit)){
                        continue;
                    }
                    $venueLimit    = new VenueLimitTimes();
                    $venueLimit->member_card_id = $this->memberCardId;
                    $venueLimit->venue_id       = $v['venue_id'];
                    $venueLimit->total_times    = intval($v['times']);
                    $venueLimit->overplus_times = intval($v['times']);
                    if(!$venueLimit->save()){
                        return $venueLimit->errors;
                    }
                }
            }else{
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
            }
        }
        return true;
    }
    public function loadTwoData($val)
    {
        if(isset($val) && !empty($val) && is_array($val)){
            foreach ($val as $k=>$v){
                $params = self::PARAMS_THR;
                $key  = $params[$k];
                if(in_array($k,[4,15])){
                    $this->$key = strtotime($v);
                    continue;
                }
                $this->$key = $v;
            }
        }
    }
    public function loadTwoFile($path,$venue = '大上海',$name,$type='one'){
        $model = new Excel();
        $this->venueType    = $venue;
        $this->venueNameTwo = $name;
        $this->paramType    = $type;
        if($type == 'two'){
            $data = $model->loadFileAiBoNewMember($path,'R','two');
        }elseif($type == 'three'){
            $data = $model->loadFileAiBoNewMember($path,'R','two');
        }else{
            $data = $model->loadFileAiBoNewMember($path,'R','two');
        }
        $this->getAdminIdOne();
        $this->getVenueId();
        //插入到数据库
        foreach($data as $key=>$val){
            $this->loadTwoData($val);
            $member        = new Member();
            $transaction  = Yii::$app->db->beginTransaction();     //事务开始
            try{

                //插入员工表（会籍顾问）
                //判断员工是否存在，如果存在直接取id，否则直接插入
                if($this->memberConsultant) {
                    $employeeModel = Employee::findOne(['name' => $this->memberConsultant,'organization_id'=>$this->departId]);
                    if (empty($employeeModel)) {
                        $employee = new Employee();
                        $employee->name = $this->memberConsultant;
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
                    } else {
                        $this->employeeId = $employeeModel->id;
                    }
                }
                //插入会员表
                //判断会员是否存在(根据手机号码)

                $memberModel = Member::findOne(["username"=>$this->memberName,'venue_id'=>intval($this->venueId)]);
                if(empty($memberModel)){
                    $password = '123456';
                    $password = Yii::$app->security->generatePasswordHash($password);
                    $member->username      = isset($this->memberName)?$this->memberName:'暂无';
                    $member->mobile        = $this->memberMobile?"$this->memberMobile":'0';     //会员手机号
                    $member->password      = $password;
                    $member->register_time = time();
                    $member->counselor_id  = $this->employeeId;
                    $member->status        = 1;
                    $member->venue_id      = $this->venueId;
                    $member->company_id    = $this->organId;
                    if(!$member->save()){
                        $error = $member->errors;
                        echo "member>>".$this->memberNumber."<br /><br />";
                        return $error;
                    }
                    $memberDetail = new MemberDetails();
                    $memberDetail->member_id = $member->id;
                    $memberDetail->name      = $this->memberName;
                    $memberDetail->save();
                    $this->memberId = $member->id;
                }else{
                    if(empty($memberModel['venue_id']) || empty($memberModel['counselor_id'])){
                        $memberModel->venue_id = $this->venueId;
                        $memberModel->company_id    = $this->organId;
                        $memberModel->counselor_id  = $this->employeeId;
                        if(!$memberModel->save()){
                            return $memberModel->errors;
                        }
                        $this->memberId = isset($memberModel->id)?$memberModel->id:$memberModel['id'];
                    }else{
                        $this->memberId = isset($memberModel->id)?$memberModel->id:$memberModel['id'];
                    }
                }
                //插入会员卡表
                //判断会员卡号是否存在
                $memberCardModel = MemberCard::findOne(["member_id"=>intval($this->memberId)]);
                if(!empty($memberCardModel)){
                    if($memberCardModel->invalid_time < abs((int)$this->dateEnd)){
                        $memberCardModel->invalid_time     = abs((int)$this->dateEnd);
                        $memberCardModel->employee_id      = $this->employeeId;
                        $memberCardModel->company_id       = $this->organId;
                        $memberCardModel->venue_id         = $this->venueId;
                        $memberCardModel->amount_money     = intval($this->price);
                        $memberCardModel->describe         = "$this->note";
                        if(!$memberCardModel->save()){
                            $error = $memberCardModel->errors;
                            echo "memberCard>>".$this->memberNumber."<br /><br />";
                            return $error;
                        }
                        $this->memberCardId = $memberCardModel->id;
                        //消费表数据保存
                        $model = new ConsumptionHistory();
                        $model->member_id             = $this->memberId;     ;        //?从对方获取插入的会员id
                        $model->consumption_type      = "card";
                        $model->consumption_type_id   = $this->memberCardId;        //?从对方拿取  （对方插入会员卡表时的id）
                        $model->type                  = 1;        //消费方式暂定1（现金）；
                        $model->consumption_date      = intval($this->chargeDate);   //消费日期
                        $model->consumption_amount    = abs(intval($this->price));            //?消费金额 遍历数据拿出来
                        $model->consumption_times     = 1;                        //消费次数
                        $model->cashier_order         = $this->orderNumber;    //收银单号
                        $model->cash_payment          = abs(intval($this->price));             //现金付款
                        $model->seller_id              = $this->employeeId;          //销售人员id
                        $model->category               = '发卡';
                        $model->remarks                = $this->orderType;
                        $modelResult = $model->save() ? true :false ;
                        if($modelResult === false){
                            return $model->errors;
                        }
                    }else{
                        if($this->paramType == 'two'){
                            $memberCardModel->invalid_time     = abs((int)$this->dateEnd) + (90*24*60*60);
                            $memberCardModel->employee_id      = $this->employeeId;
                            $memberCardModel->company_id       = $this->organId;
                            $memberCardModel->venue_id         = $this->venueId;
                            $memberCardModel->amount_money     = intval($this->price);
                            $memberCardModel->describe         = "$this->note";
                            if(!$memberCardModel->save()){
                                $error = $memberCardModel->errors;
                                echo "memberCard>>".$this->memberNumber."<br /><br />";
                                return $error;
                            }
                            $this->memberCardId = $memberCardModel->id;
                            //消费表数据保存
                            $model = new ConsumptionHistory();
                            $model->member_id             = $this->memberId;     ;        //?从对方获取插入的会员id
                            $model->consumption_type      = "card";
                            $model->consumption_type_id   = $this->memberCardId;        //?从对方拿取  （对方插入会员卡表时的id）
                            $model->type                  = 1;        //消费方式暂定1（现金）；
                            $model->consumption_date      = intval($this->chargeDate);   //消费日期
                            $model->consumption_amount    = abs(intval($this->price));            //?消费金额 遍历数据拿出来
                            $model->consumption_times     = 1;                        //消费次数
                            $model->cashier_order         = $this->orderNumber;    //收银单号
                            $model->cash_payment          = abs(intval($this->price));             //现金付款
                            $model->seller_id              = $this->employeeId;          //销售人员id
                            $model->category               = '发卡';
                            $modelResult = $model->save() ? true :false ;
                            if($modelResult === false){
                                return $model->errors;
                            }
                        }
                    }
                }
                if($transaction->commit() !== null){
                    return false;
                }
            }catch(\Exception $ex){
                $transaction->rollBack();
                return  $ex->getMessage();
            }
        }
        if(empty($this->error)){
            return true;
        }else{
            return $this->error;
        }

    }

    /**
    * 亚星数据导入
    */
    public function loadYaXingDataMember($val)
    {
        if(isset($val) && !empty($val) && is_array($val))
//            var_dump($val);die();
            foreach ($val as $k=>$v){
                $params = self::PARAMS_YX;
                $key    = $params[$k];
//                if(in_array($k,[7,8,10])){
//                    $this->$key = strtotime($v);
//                    continue;
//                }
                $this->$key = $v;
            }
    }
    public function loadYaXingMember($path,$venue,$name,$type,$consoleType)
    {
        $model = new Excel();
        $this->venueType = $venue;
        $this->venueNameTwo = $name;
        $this->paramType = $type;
        if ($type == 'two') {
            $data = $model->loadFileYaMember($path);
        } elseif ($type == 'three') {
            $data = $model->loadFileYaMember($path);
        } else {
            $data = $model->loadFileYaMember($path);
        }
        $this->getAdminIdOne();
        $this->getVenueId();
        $this->venueId = 15;
        $this->organId = 1;
        $num = 0;
        foreach ($data as $key => $value) {
            $num++;
            $this->loadYaXingDataMember($value);
//            var_dump($this);die();
//            $transaction = Yii::$app->db->beginTransaction();     //事务开始
//            try {

                if(!$this->memberNumber){
                    continue;
                }
//                echo $num.',';
//                var_dump($this);die();

            if($consoleType == '20171218'){
                //更新定金备注及积分备注
                $card = MemberCard::findOne(['card_number'=>$this->memberNumber]);
                if(!empty($card)) {
                    $category = $this->getCategory($this->type);
                    $remarks = '';
                    if(!empty($this->note)) $remarks .= "【备注】{$this->note}";
                    if(!empty($this->score)) $remarks .= "【积分】{$this->score}";
                    $num = ConsumptionHistory::updateAll(['remarks'=>$remarks], ['consumption_type_id'=>$card->id, 'consumption_type'=>'card', 'category'=>$category]);
                    echo "card_number:{$card->card_number}($num)->";
                }
                continue;
            }
            continue;


            if($consoleType == 'edit'){
                if(strpos($this->type,'定金') !== FALSE){
                    continue;
                }
                //修复导入错误(1.回款的行为都成备注了2.身份证号也没有导入3.收费日期应该对应办卡日期)zxb<2017.11.25>
                $card = MemberCard::findOne(['card_number'=>$this->memberNumber]);
                if(!empty($card)){
                    echo "card_number:{$card->card_number}\r\n";

                    $category = $this->getCategory($this->type);

                    ConsumptionHistory::updateAll(['remarks'=>$this->note, 'category'=>$category], ['consumption_type_id'=>$card->id, 'consumption_type'=>'card', 'consumption_amount'=>intval($this->price)]);
                    ConsumptionHistory::updateAll(['consumption_date'=>abs((int)$this->chargeDate)], ['consumption_type_id'=>$card->id, 'consumption_type'=>'card', 'category'=>$category]);
                    ConsumptionHistory::updateAll(['due_date'=>abs((int)$this->dateEnd)], ['consumption_type_id'=>$card->id, 'consumption_type'=>'card']);

                    $member_detail = MemberDetails::findOne(['member_id'=>$card->member_id]);
                    $member_detail->id_card = $this->memberIdCard;
                    $member_detail->save();

                    $amount_money = ConsumptionHistory::find()->where(['consumption_type_id'=>$card->id, 'consumption_type'=>'card'])->sum('consumption_amount');
                    $card->amount_money = $amount_money;
                    $card->create_at = abs((int)$this->chargeDate);
                    $card->save();
                }
                continue;
            }


            if($consoleType == 'addhistory') {
                if(strpos($this->type,'定金') === FALSE){
                    continue;
                }
                //导入消费记录zxb<2017.11.22>
                $card = MemberCard::findOne(['card_number' => $this->memberNumber]);
                if (!empty($card)) {
                    $had_history = ConsumptionHistory::findOne(['consumption_type_id' => $card->id, 'category' => '定金']);
                    if (!empty($had_history)) continue;
                    $history                      = new ConsumptionHistory();
                    $history->member_id           = $card->member_id;
                    $history->consumption_type    = 'card';
                    $history->consumption_type_id = $card->id;
                    $history->type                = 1;
                    $history->consumption_date    = intval($this->chargeDate);
                    $history->consumption_amount  = intval($this->price);
                    $history->consumption_times   = 1;
                    $number                       = Func::setOrderNumber();
                    $history->cashier_order       = "$number";
                    $history->cash_payment        = intval($this->price);
                    $history->seller_id           = Employee::findOne(['name' => $this->memberConsultant, 'venue_id' => $this->venueId])->id;
                    $history->category            = '定金';

//                var_dump($history->attributes);exit;
                    echo "card_number:{$card->member_id}\r\n";

                    $history->save();
                }
                continue;
            }
            continue;
            //导入消费记录zxb<2017.11.22>
//            $card = MemberCard::findOne(['card_number'=>$this->memberNumber]);
//            if(!empty($card)){
//                $had_history = ConsumptionHistory::findOne(['consumption_type_id'=>$card->id, 'category'=>'定金']);
//                if(!empty($had_history)) continue;
//                $history                      = new ConsumptionHistory();
//                $history->member_id           = $card->member_id;
//                $history->consumption_type    = 'card';
//                $history->consumption_type_id = $card->id;
//                $history->type                = 1;
//                $history->consumption_date    = intval($this->chargeDate);
//                $history->consumption_amount  = intval($this->price);
//                $history->consumption_times   = 1;
//                $number                       = Func::setOrderNumber();
//                $history->cashier_order       = "$number";
//                $history->cash_payment        = intval($this->price);
//                $history->seller_id           = Employee::findOne(['name'=>$this->memberConsultant, 'venue_id'=>$this->venueId])->id;
//                $history->category            = '定金';
//
////                var_dump($history->attributes);exit;
//                echo "card_number:{$card->member_id}\r\n";
//
//                $history->save();
//            }
//            continue;
//
//

                //插入员工表（会籍顾问）
                //判断员工是否存在，如果存在直接取id，否则直接插入
                if($this->memberConsultant) {
                    $employeeModel = Employee::findOne(['name' => $this->memberConsultant,'organization_id'=>$this->departId]);
                    if (empty($employeeModel)) {
                        $employee = new Employee();
                        $employee->name = $this->memberConsultant;
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
                    } else {
                        $this->employeeId = $employeeModel->id;
                    }
                }
                $memberModel = Member::find()->where(['username' => $this->memberName, 'venue_id' => $this->venueId])->one();
                $password = '123456';     //会员临时密码
                $password = \Yii::$app->security->generatePasswordHash($password);
                if (empty($memberModel)) {

                    $model = new Member();
                    $model->username = (string)$this->memberName;       //用户名
                    $model->password = $password;               //密码
                    $model->mobile   =  (empty($this->memberMobile) || $this->memberMobile == "             ")?'0':(string)"$this->memberMobile";     //会员手机号
                    $model->register_time = time();//会员注册时间
                    $model->counselor_id  = $this->employeeId;
                    $model->venue_id = intval($this->venueId);        //场馆id
                    $model->company_id = intval($this->organId);        //场馆id
                    if (!$model->save()) {
                        var_dump($this->memberMobile);
                        $error = $model->errors;
                        var_dump($error);
                        echo "member>>" . $this->memberName .','. $this->memberNumber . "<br /><br />";
                        return $error;
                    }
                    $this->memberId = $model->id;
                } else {
                    if (empty($memberModel->mobile) && !empty($this->memberMobile)) {
                        $memberModel->mobile = (empty($this->memberMobile) || $this->memberMobile == "           ")?'0':"$this->memberMobile";
                        if (!$memberModel->save()) {
                            $error = $model->errors;
                            var_dump($error);
                            echo "member>>" . $this->memberName .','. $this->memberNumber . "<br /><br />";
                            return $error;
                        }
                        $this->memberId = $memberModel->id;
                    } else if ($memberModel->mobile != $this->memberMobile) {
                        $model = new Member();
                        $model->username = $this->memberName;       //用户名
                        $model->password = $password;               //密码
                        $model->mobile = (empty($this->memberMobile) || $this->memberMobile == "           ")?'0':"$this->memberMobile";     //会员手机号
                        $model->register_time = time();//会员注册时间
                        $model->venue_id = intval($this->venueId);        //场馆id
                        $model->company_id = intval($this->organId);        //场馆id
                        if (!$model->save()) {
                            $error = $model->errors;
                            var_dump($error);
                            echo "member>>" . $this->memberName .','. $this->memberNumber . "<br /><br />";
                            return $error;
                        }
                        $this->memberId = $model->id;
                    } else {
                        $this->memberId = $memberModel->id;
                    }
                }
//            if(empty(!$this->memberNumber)){
//                $number             = time().mt_rand(100,999);
//                $this->memberNumber = "$number";
//                $this->cardStatus   = 1;
//            }
                //插入卡种表
                //判断卡种是否存在
                $cardCategoryModel = CardCategory::find()->where(["card_name" => "$this->cardName",'venue_id'=>$this->venueId])->asArray()->one();
                if (empty($cardCategoryModel)) {
                    if (strpos($this->cardName, '次')) {
                        $num = 2;
                    } else {
                        $num = 1;
                    }
                    $cardCategory = new CardCategory();
                    $cardCategory->card_name = "$this->cardName";
                    $cardCategory->category_type_id = (int)$num;
                    $cardCategory->venue_id = $this->venueId;
                    $cardCategory->company_id = $this->organId;
                    $cardCategory->create_id = 2;
                    $cardCategory->deal_id = 0;
                    $cardCategory->times = intval($this->remainingDate);
                    if (!$cardCategory->save()) {
                        $error = $cardCategory->errors;
                        echo "cardCategory>>" . $this->memberNumber . "<br /><br />";
                        return $error;
                    }
                    $this->cardId = $cardCategory->id;
                } else {
                    $this->cardId = $cardCategoryModel['id'];
                }
                if (strpos($this->cardName, '金爵') || strpos($this->cardName, '尊爵')) {
                    $venue = Organization::find()->where(['pid' => $this->organId])->asArray()->all();
                    if (!empty($venue)) {
                        foreach ($venue as $v) {
                            $isLimit = LimitCardNumber::find()->where(['card_category_id' => $this->cardId])->andWhere(['venue_id' => $v['id']])->asArray()->one();
                            if (!empty($isLimit)) {
                                continue;
                            }
                            $limit = new LimitCardNumber();
                            if (strpos($this->cardName, '尊爵') && !strpos($v['name'], '大卫城') && $this->venueNameTwo == '大卫城') {
                                continue;
                            }
                            if (strpos($v['name'], '大卫城') && $this->venueNameTwo != '大卫城') {
                                $num = 6;
                            } else {
                                $num = -1;
                            }
                            $limit->card_category_id = $this->cardId;
                            $limit->venue_id = $v['id'];
                            $limit->times = $num;
                            $limit->level = 1;
                            $limit->surplus = -1;
                            if (!$limit->save()) {
                                return $limit->errors;
                            }
                        }
                    }
                } else {
                    $isLimit = LimitCardNumber::find()->where(['card_category_id' => $this->cardId])->andWhere(['venue_id' => $this->venueId])->asArray()->one();
                    if (empty($isLimit)) {
                        $limit = new LimitCardNumber();
                        $limit->card_category_id = $this->cardId;
                        $limit->venue_id = $this->venueId;
                        $limit->times = -1;
                        $limit->surplus = -1;
                        if (!$limit->save()) {
                            return $limit->errors;
                        }
                    }
                }

                //插入会员详情表
                $memberDetail_model = MemberDetails::find()->where(["member_id" => $this->memberId])->asArray()->one();
                if (empty($memberDetail_model)) {
                    $memberDetail = new MemberDetails();
                    $memberDetail->member_id = $this->memberId;
                    $memberDetail->name = (string)$this->memberName;
                    $memberDetail->birth_date = date('Y-m-d', $this->birth);
                    $memberDetail->sex = 0;
                    $memberDetail->created_at = time();
                    $memberDetail->recommend_member_id = 0;
                    if (!$memberDetail->save()) {
                        echo "memberDetail>>" . $this->memberNumber . "<br /><br />";
                        return $memberDetail->errors;
                    }
                }
                //插入会员卡表
                //判断会员卡号是否存在
                $memberCardModel = MemberCard::findOne(["card_number" => (string)$this->memberNumber]);
                if (empty($memberCardModel)) {
                    $memberCardModelTwo = MemberCard::findOne(["card_number" => (string)$this->memberMobile]);
                    if (empty($memberCardModelTwo)) {
                        $memberCard = new MemberCard();
                        $memberCard->card_number = (empty($this->memberNumber)) ? $this->memberMobile : (string)$this->memberNumber;
                        $memberCard->create_at = abs((int)$this->dateStart);
                        $memberCard->active_time = abs((int)$this->dateStart);
                        $memberCard->member_id = $this->memberId;
                        $memberCard->card_category_id = $this->cardId;
                        $memberCard->payment_type = 1;
                        $memberCard->payment_time = 1;
                        $memberCard->is_complete_pay = 1;
                        $memberCard->level = 1;
                        $memberCard->status = !empty($this->cardStatus) ? $this->cardStatus : 1;;
                        $memberCard->card_type = 1;
                        $memberCard->total_times = (strpos($this->remainingDate, '次')) ? intval($this->remainingDate) : 0;
                        $memberCard->consumption_times = 0;
                        $memberCard->card_name = "$this->cardName";
                        $memberCard->invalid_time = abs((int)$this->dateEnd);
                        $memberCard->payment_time = abs((int)$this->chargeDate);
                        $memberCard->present_money = $this->giveAmount;
                        $memberCard->amount_money = $this->businessAmount;
                        $memberCard->present_private_lesson = intval($this->givePrivate);
                        $memberCard->describe = "$this->note";
                        $memberCard->employee_id = $this->sellerId;
                        $memberCard->company_id = $this->organId;
                        $memberCard->venue_id = $this->venueId;
                        if (!$memberCard->save()) {
                            $error = $memberCard->errors;
                            echo "memberCard>>" . $this->memberNumber . "<br /><br />";
                            return $error;
                        }
                        $this->memberCardId = $memberCard->id;
                    } else {
                        $this->memberCardId = $memberCardModelTwo->id;
                    }
                } else {
                    $memberCardModelTwo = MemberCard::findOne(["member_id" => $this->memberId, 'invalid_time' => intval($this->dateEnd)]);
                    if (empty($memberCardModelTwo)) {
                        if ($memberCardModel['invalid_time'] < intval($this->dateEnd)) {
                            $memberCardModel->card_number = (string)$this->memberNumber;
                            if ((isset($memberCardModel->create_at) && empty($memberCardModel->create_at)) || (isset($memberCardModel['create_at']) && empty($memberCardModel['create_at']))) {
                                $memberCardModel->create_at = abs((int)$this->dateStart);
                            }
                            if ((isset($memberCardModel->active_time) && empty($memberCardModel->active_time)) || (isset($memberCardModel['active_time']) && empty($memberCardModel['active_time']))) {
                                $memberCardModel->active_time = abs((int)$this->dateStart);
                            }
                            $memberCardModel->member_id = $this->memberId;
                            $memberCardModel->card_category_id = $this->cardId;
                            $memberCardModel->payment_type = 1;
                            $memberCardModel->payment_time = 1;
                            $memberCardModel->is_complete_pay = 1;
                            $memberCardModel->level = 1;
                            $memberCardModel->status = 1;
                            $memberCardModel->card_type = 1;
                            $memberCardModel->total_times = (strpos($this->remainingDate, '次')) ? intval($this->remainingDate) : 0;
                            $memberCardModel->consumption_times = 0;
                            $memberCardModel->card_name = $this->cardName;
                            $memberCardModel->invalid_time = abs((int)$this->dateEnd);
                            $memberCardModel->payment_time = abs((int)$this->chargeDate);
                            $memberCardModel->present_money = $this->giveAmount;
                            $memberCardModel->amount_money = $this->businessAmount;
                            $memberCardModel->present_private_lesson = intval($this->givePrivate);
                            $memberCardModel->describe = "$this->note";
                            $memberCardModel->employee_id = $this->sellerId;
                            $memberCardModel->company_id = $this->organId;
                            $memberCardModel->venue_id = $this->venueId;
                            if (!$memberCardModel->save()) {
                                $error = $memberCardModel->errors;
                                echo "memberCard>>" . $this->memberNumber . "<br /><br />";
                                return $error;
                            }
                            $this->memberCardId = isset($memberCardModel->id) ? $memberCardModel->id : $memberCardModel['id'];
                        } else {
                            $this->memberCardId = isset($memberCardModel->id) ? $memberCardModel->id : $memberCardModel['id'];
                        }
                    } else {
                        $this->memberCardId = isset($memberCardModelTwo->id) ? $memberCardModelTwo->id : $memberCardModelTwo['id'];
                    }
                }
                $limitArr = LimitCardNumber::find()->where(['card_category_id' => $this->cardId])->asArray()->all();
                if (is_array($limitArr) && !empty($limitArr)) {
                    foreach ($limitArr as $v) {
                        $isVenueLimit = VenueLimitTimes::find()->where(['member_card_id' => $this->memberCardId])->andWhere(['venue_id' => $v['venue_id']])->asArray()->one();
                        if (!empty($isVenueLimit)) {
                            continue;
                        }
                        $venueLimit = new VenueLimitTimes();
                        $venueLimit->member_card_id = $this->memberCardId;
                        $venueLimit->venue_id = $v['venue_id'];
                        $venueLimit->total_times = intval($v['times']);
                        $venueLimit->overplus_times = intval($v['times']);
                        if (!$venueLimit->save()) {
                            return $venueLimit->errors;
                        }
                    }
                } else {
                    $isVenueLimit = VenueLimitTimes::find()->where(['member_card_id' => $this->memberCardId])->andWhere(['venue_id' => $this->venueId])->asArray()->one();
                    if (empty($isVenueLimit)) {
                        $venueLimit = new VenueLimitTimes();
                        $venueLimit->member_card_id = $this->memberCardId;
                        $venueLimit->venue_id = $this->venueId;
                        $venueLimit->total_times = -1;
                        $venueLimit->overplus_times = -1;
                        if (!$venueLimit->save()) {
                            return $venueLimit->errors;
                        }
                    }
                }
                $errors = $this->loadConsumptionData();
                if($errors !== true){
                    return  $errors;
                }
//                if ( !== null) {
//                    return false;
//                }
//                $transaction->commit();
//            } catch (\Exception $ex) {
//                $transaction->rollBack();
//                return $ex->getMessage();
//            }
        }
        return true;
    }

    private function getCategory($type)
    {
        $arr = explode('（', $type);
        if(!isset($arr[1])) $arr = explode('(', $type);

        if(!empty($arr) && isset($arr[1])){
            return mb_substr($arr[1], 0, -1);
        }
        return '';
    }
}
