<?php
/**
 * 导入会员卡到期数据
 * User: lihuien
 * Date: 2017/9/14
 * Time: 17:01
 */
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
use Yii;
use common\models\Excel;
use yii\base\Model;

class ExcelCardExpire extends Model
{
    const  PARAMS_ONE = ['memberNumber','memberName','memberSex','chargeDate','cardName','dateStart','dateEnd','price','money','memberConsultant','phone','mobile','note','idcard','cardCatName'];
    const  PARAMS_TWO = ['memberCardStatus','memberNumber','memberSex','memberName','memberConsultant','cardName','businessAmount','givePrivate','giveAmount','totalTimes','overTimes','dateStart','dateEnd','note','chargeDate','cashierOrder','price','cash','bankCard','memberCard','coupon','transferAccounts','discountPayment','otherPayment','networkPayment','integrationPayment','describe','crossShop','sellerName','cashierOrderTwo'];
    const  PRICE_TYPE = [1=>'定金',2=>'发卡',3=>'续费',4=>'回款',5=>'升级',6=>'续定',7=>'续回'];
    const  EMPLOYEE_DATA = ['company','store','employeeName','employeeAlias','employeeSex','employeeMobile','position','employeeStatus','employeeWorkTime'];
    const  INCUMBENCY    = ['在职'=>1,'离职'=>2,'调岗'=>3,'全职'=>4,'兼职'=>5,'停薪留职'=>6,'辞退'=>7];
    public $memberCardStatus;  //会员卡 消费状态
    public $memberNumber;      //会员卡 卡号
    public $memberSex;         //会员性别
    public $memberName;        //会员姓名
    public $memberConsultant;  //会员顾问
    public $cardName;
    public $businessAmount;    //业务金额
    public $giveAmount;        //买增金额
    public $givePrivate;       //赠送私教
    public $dateStart;         //开始日期
    public $dateEnd;           //结束日期
    public $note;              //备注
    public $money;
    public $chargeDate;        //收费日期
    public $cashierOrder;      //收费单号
    public $price;             //金额
    public $cash;              //现金
    public $bankCard;          //银行卡
    public $mobile;
    public $memberCard;        //会员卡
    public $coupon;            //优惠券
    public $transferAccounts;  //转账
    public $otherPayment;      //其他
    public $discountPayment;   //折扣折让
    public $networkPayment;    //网络支付
    public $integrationPayment; //积分
    public $describe;           //备用
    public $crossShop;            //跨店
    public $sellerName;         //销售id
    public $cashierOrderTwo;     //销售清单
    public $sellerId;            //销售员
    public $venueId;            //场馆ID
    //场馆数据
    public $venueName;
    public $phone;
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
    public $totalTimes;
    public $overTimes;
    public $venueNameTwo;
    public $venueType;
    public $cardType;

    public $paramType;
    public $adminId;
    public $error = array();

    //   start  Employee
    public $company;         //公司
    public $store;           //员工部门
    public $employeeName;    //员工姓名
    public $employeeAlias;   //员工别名
    public $employeeSex;     //员工性别
    public $employeeMobile;  //员工手机号
    public $position;       //职位
    public $employeeStatus; //
    public $employeeWorkTime;//
    public $idcard;//身份证
    public $cardCatName;//新卡种名称

    public $historyCategory;//历史纪录行为
    //    end   Employee
    public function loadData($val)
    {
        if(isset($val) && !empty($val) && is_array($val)){
            foreach ($val as $k=>$v){
                if($this->paramType == 'two'){
                    $params = self::PARAMS_TWO;
                }else{
                    $params = self::PARAMS_ONE;
                }

                if($k > 34){
                    $key  = $params[$k-10];
                }else{
                    $key  = $params[$k];
                }
                $this->$key = $v;
            }
        }
    }
    public function loadFile($path,$venue = '大上海',$name,$type='one',$consoleType=''){

        $model = new Excel();
        $this->venueType    = $venue;
        $this->venueNameTwo = $name;
        $this->paramType    = $type;


        if($type == 'two'){
            $data = $model->loadFileTwo($path);
        }elseif($type == 'three'){
            $data = $model->loadFileThree($path);
        }else{
            $data = $model->loadExpireFile($path);
        }

        $this->getAdminIdOne();
        $this->getVenueId();
        $this->setVenueData();

        //插入到数据库
        $num = 0;
        foreach($data as $key=>$val){
            $this->loadData($val);
            if((strstr($this->memberCardStatus, '共') && strstr($this->memberCardStatus, '条')) ||(strstr($this->memberCardStatus, '第') && strstr($this->memberCardStatus, '页'))){
                continue;
            }

            if(!$this->departId){
                echo "venue>>".'场馆不存在'."<br /><br />";
            }
//            if($this->venueType == '大学路瑜伽'){
//                if(is_bool(strpos('0950',$this->memberNumber))){
//                    continue;
//                }
//            }elseif ($this->venueType == '大学路舞蹈'){
//                if(is_bool(strpos('0910',$this->memberNumber)) || is_bool(strpos('0710',$this->memberNumber)) || is_bool(strpos('0610',$this->memberNumber))){
//                    continue;
//                }
//            }
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



                        $card = MemberCard::findOne(['card_number'=>$this->memberNumber]);

            /*
                                   //处理会员卡错误归属 zxb 2017.11.22
                                   if(!empty($card)){
                                       $true_member = Member::findOne(['username'=>$this->memberName, 'mobile'=>$this->mobile, 'venue_id'=>$this->venueId]);
                                       if(!empty($true_member)){

                                           if($card->member_id != $true_member->id){
                                               echo "card_number:{$card->card_number}, card_member_id:{$card->member_id}, true_member_id:{$true_member->id}\r\n";
                                               $card->member_id = $true_member->id;
                                               $card->venue_id = $this->venueId;
                                               $card->company_id = $this->organId;
                                               $card->save();//变更该卡归属
                                               $true_member->venue_id = $this->venueId;
                                               $true_member->company_id = $this->organId;
                                               $true_member->counselor_id = $this->employeeId;
                                               $true_member->member_type = 1;
                                               $true_member->save();//变更会员场馆等信息

                                               //变更该卡消费纪录归属
                                               ConsumptionHistory::updateAll(['member_id'=>$true_member->id], ['consumption_type_id' => $card->id, 'consumption_type' => 'card']);
                                           }

                                           $charges = MemberCourseOrder::findAll(['member_card_id' => $card->id]);
                                           if(!empty($charges)){
                                               foreach ($charges as $charge){
                                                   if($charge->member_id != $true_member->id){
                                                       echo "charge_id:{$charge->id}, charge_member_id:{$charge->member_id}\r\n";
                                                       $charge->member_id = $true_member->id;
                                                       $charge->save();//变更该卡下私教课归属

                                                       //变更该私教课消费纪录归属
                                                       ConsumptionHistory::updateAll(['member_id'=>$true_member->id], ['consumption_type_id' => $charge->id, 'consumption_type' => 'charge']);
                                                   }
                                               }
                                           }
                                       }

                                   }
                                   continue;

           */
                        //补充会籍顾问 zxb 2017.11.21
                        if(!empty($card)){
                            $member_model = Member::findOne($card->member_id);
                            if(empty($member_model)){
                                continue;
                            }
                            if(empty($member_model->counselor_id)  && !empty($this->memberConsultant)){

                                $transaction  = Yii::$app->db->beginTransaction();
                                try {
                                    $employeeModel = Employee::findOne(['name' => $this->memberConsultant, 'organization_id' => $this->departId]);
                                    if (empty($employeeModel)) {
                                        $employee = new Employee();
                                        $employee->name = "$this->memberConsultant";
                                        $employee->organization_id = $this->departId;
                                        $employee->company_id = $this->organId;
                                        $employee->venue_id = $this->venueId;
                                        $employee->create_id = $this->adminId;
                                        $employee->status = 2;
                                        if (!$employee->save()) {
                                            $error = $employee->errors;
                                            echo "employee>>" . $this->memberNumber . "<br /><br />";
                                            return $error;
                                        }
                                        $this->employeeId = $employee->id;
                                    } else {
                                        $this->employeeId = $employeeModel->id;
                                    }

                                    echo "memberID:{$member_model->id}, counselorID:{$this->employeeId}\r\n";

                                    $member_model->counselor_id = $this->employeeId;
                                    $member_model->save();
                                    $transaction->commit();
                                }catch(\Exception $ex){
                                    $transaction->rollBack();
                                    return  $ex->getMessage();
                                }

                            }

                        }
                continue;
/*

                        if(!empty($card)){

                            if(($card['invalid_time'] > $this->dateEnd) && ($card['card_name'] == $this->cardName)){
                                if($card['active_time'] > $this->dateStart){
            //                        var_dump($val);die();
                                    echo $num++;
                                    $card->active_time = $this->dateStart;
                                    $card->create_at   = $this->chargeDate;
                                    $card->save();
                                }
                                continue;
                            }
            //                continue;
                            if($type == 'four') {
                                $memberModel = Member::findOne(["username" => $this->memberName, 'mobile' => $this->mobile, 'venue_id' => intval($this->venueId)]);
                                if (!empty($memberModel)) {
                                    if ($card->member_id != $memberModel->id) {
                                        $card->member_id = $memberModel->id;
                                        $card->save();
                                        $history = ConsumptionHistory::findOne(['consumption_type_id' => $card->id, 'consumption_type' => 'card']);
                                        $history->member_id = $memberModel->id;
                                        $history->save();
                                    }
                                    $charge = MemberCourseOrder::findAll(['member_card_id' => $card->id]);
                                    if (!empty($charge)) {
                                        foreach ($charge as $v) {
                                            if ($v->member_id != $memberModel->id) {
                                                $course = MemberCourseOrder::findOne(['id' => $v->id]);
                                                $course->member_id = $memberModel->id;
                                                $course->save();
                                                $history = ConsumptionHistory::findOne(['consumption_type_id' => $v->id, 'consumption_type' => 'charge']);
                                                if (!empty($history)) {
                                                    $history->member_id = $memberModel->id;
                                                    $history->save();
                                                }
                                            }
                                        }
                                    }
                                }
                                continue;
                            }
                        }
            //            continue;

            */

            //var_dump($this);exit;

            //删除旧数据
            if($consoleType == 'delold'){
                $memberCard = MemberCard::findOne(['card_number'=>$this->memberNumber]);
                if(!empty($memberCard)){
                    $memberCardId = $memberCard->id;
                    $memberIds[] = $memberCard->member_id;
                    $memberModels = Member::find()->select('id')->where(["username"=>$this->memberName,'mobile'=>$this->mobile,'venue_id'=>intval($this->venueId)])->all();
                    if(!empty($memberModels)){
                        foreach ($memberModels as $memberModel){
                            $memberIds[] = $memberModel->id;
                        }
                    }
                    //1、删除通店信息
                    VenueLimitTimes::deleteAll(['member_card_id'=>$memberCardId]);
                    //2、删除消费记录
                    ConsumptionHistory::deleteAll(['or',['consumption_type_id'=>$memberCardId, 'consumption_type'=>'card'],['member_id'=>$memberIds]]);
                    //3、删除会员
                    Member::deleteAll(['id'=>$memberIds]);
                    //4、删除会员详情
                    MemberDetails::deleteAll(['member_id'=>$memberIds]);
                    //5、删除会员卡
                    MemberCard::deleteAll(['member_id'=>$memberIds]);
                    echo "{$memberCard->card_number}->";
                }
                continue;
            }


            $consoleType == 'import' || exit('使用 ./yii import/card-expire import 导入新数据');
            
            $this->giveAmount = $this->businessAmount = $this->price;

            $transaction  = Yii::$app->db->beginTransaction();     //事务开始
            try{

                //插入员工表（会籍顾问）
                //判断员工是否存在，如果存在直接取id，否则直接插入
                if($this->memberConsultant) {
                    $employeeModel = Employee::findOne(['name' => $this->memberConsultant,'organization_id'=>$this->departId]);
                    if (empty($employeeModel)) {
                        $employee = new Employee();
                        $employee->name = "$this->memberConsultant";
                        $employee->organization_id = $this->departId;
                        $employee->company_id      = $this->organId;
                        $employee->venue_id        = $this->venueId;
                        $employee->create_id       = $this->adminId;
                        $employee->status          = 2;
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
                //插入卡种表
                //判断卡种是否存在
                $cardCategoryModel = CardCategory::find()->where(["card_name"=>"$this->cardCatName", 'venue_id'=>$this->venueId])->asArray()->one();
                if(empty($cardCategoryModel)){
                    $transaction->rollBack();
                    Yii::error("cardNumber:{$this->memberNumber},message:没有此卡种{{$this->cardCatName}}", 'import');
                    continue;
                    /*
                    if(strpos($this->cardName,'次')){
                        $num = 2;
                    }else{
                        $num = 1;
                    }
                    $cardCategory->card_name        = "$this->cardName";
                    $cardCategory->category_type_id = (int)$num;
                    $cardCategory->venue_id         = $this->venueId;
                    $cardCategory->company_id      = $this->organId;
                    $cardCategory->create_id        = 2;
                    $cardCategory->deal_id          = 0;
                    $cardCategory->times            = $this->totalTimes;
                    if(!$cardCategory->save()){
                        $error = $cardCategory->errors;
                        echo "cardCategory>>".$this->memberNumber."<br /><br />";
                        return $error;
                    }
                    $this->cardId = $cardCategory->id;
                    */
                }else{
                    $this->cardId = $cardCategoryModel['id'];
                }
                /*
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
                */

                //插入会员表
                $memberModel = Member::findOne(["username"=>$this->memberName,'mobile'=>$this->mobile,'venue_id'=>intval($this->venueId)]);
                //判断会员是否存在(根据手机号码)
                if(empty($memberModel)){
                    $password = '123456';
                    $password = Yii::$app->security->generatePasswordHash($password);
                    $member->username      = isset($this->memberName)?"$this->memberName":'暂无';
                    $member->mobile        = (string)$this->mobile ?: '0';
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
                    $memberModel->member_type = 1;
                    $memberModel->counselor_id = $this->employeeId;
                    if(empty($memberModel['venue_id'])){
                        $memberModel->venue_id = $this->venueId;
                        $memberModel->company_id    = $this->organId;
                    }
                    if(!$memberModel->save()){
                        return $memberModel->errors;
                    }
                    $this->memberId = isset($memberModel->id)?$memberModel->id:$memberModel['id'];
                }

                //插入会员详情表
                $memberDetail_model = MemberDetails::find()->where(["member_id"=>$this->memberId])->one();
                if(empty($memberDetail_model)){
                    $memberDetail->member_id = $this->memberId;
                    $memberDetail->name      = "$this->memberName";
                    $memberDetail->sex       = $this->memberSex == '男' ? 1 : 2;
                    $memberDetail->id_card   = "$this->idcard";
                    $memberDetail->created_at = time();
                    $memberDetail->recommend_member_id = 0;
                    if(!$memberDetail->save()){
                        $error = $memberDetail->errors;
                        echo "memberDetail>>".$this->memberNumber."<br /><br />";
                        return $error;
                    }
                }else{
                    $memberDetail_model->name      = $this->memberName;
                    $memberDetail_model->sex       = $this->memberSex == '男' ? 1 : 2;
                    $memberDetail_model->id_card   = $this->idcard;
                    if(!$memberDetail_model->save()){
                        return $memberDetail_model->errors;
                    }
                }
                $this->sellerId = $this->employeeId;
                //插入会员卡表
                //判断会员卡号是否存在
                $memberCardModel = MemberCard::findOne(["card_number"=>(string)$this->memberNumber]);
                if(empty($memberCardModel)){
                    $memberCard->card_number      = (string)$this->memberNumber;
                    $memberCard->create_at        = abs((double)$this->chargeDate);
                    $memberCard->active_time      = abs((double)$this->dateStart);
                    $memberCard->member_id        = $this->memberId;
                    $memberCard->card_category_id = $this->cardId;
                    $memberCard->payment_type     = 1;
                    $memberCard->payment_time     = 1;
                    $memberCard->is_complete_pay  = 1;
                    $memberCard->level            = 1;
                    $memberCard->status           = 1;
                    $memberCard->card_type        = 1;
                    $memberCard->total_times       = $this->totalTimes;
                    $memberCard->consumption_times = $this->overTimes;
                    $memberCard->card_name        = "$this->cardName";
                    $memberCard->invalid_time     = abs((double)$this->dateEnd);
                    $memberCard->payment_time     = abs((double)$this->chargeDate);
                    $memberCard->present_money    = $this->giveAmount;
                    $memberCard->amount_money     = $this->businessAmount;
                    $memberCard->present_private_lesson = $this->givePrivate;
                    $memberCard->describe         = "$this->note";
                    $memberCard->employee_id      = $this->sellerId;
                    $memberCard->consume_status   = 1;
                    $memberCard->company_id  = $this->organId;
                    $memberCard->venue_id    = $this->venueId;
                    if(!$memberCard->save()){
                        $error = $memberCard->errors;
                        echo "memberCard>>".$this->memberNumber."<br /><br />";
                        return $error;
                    }
                    $this->memberCardId = $memberCard->id;
                }else{
                    //$memberCardModelTwo = MemberCard::findOne(["member_id"=>$this->memberId,'invalid_time'=>intval($this->dateEnd)]);
                    //if(empty($memberCardModelTwo)){
                    $memberCardModel->member_id        = $this->memberId;
                    $memberCardModel->card_category_id = $this->cardId;
                    $memberCardModel->payment_type     = 1;
                    $memberCardModel->payment_time     = 1;
                    $memberCardModel->is_complete_pay  = 1;
                    $memberCardModel->level            = 1;
                    $memberCardModel->status           = 1;
                    $memberCardModel->card_type        = 1;
                    $memberCardModel->total_times       = $this->totalTimes;
                    $memberCardModel->consumption_times = $this->overTimes;
                    $memberCardModel->invalid_time     = abs((double)$this->dateEnd);
                    $memberCardModel->payment_time     = abs((double)$this->chargeDate);
                    $memberCardModel->present_private_lesson = $this->givePrivate;
                    $memberCardModel->describe         = "$this->note";
                    $memberCardModel->employee_id      = $this->sellerId;
                    $memberCardModel->company_id       = $this->organId;
                    $memberCardModel->venue_id         = $this->venueId;
                    if(!$memberCardModel->save()){
                        $error = $memberCardModel->errors;
                        echo "memberCard>>".$this->memberNumber."<br /><br />";
                        return $error;
                    }


                    $this->memberCardId = $memberCardModel->id;
                    /*
                    else{
                        $this->memberCardId = isset($memberCardModel->id)?$memberCardModel->id:$memberCardModel['id'];
                    }
                }else{
                    $this->memberCardId = isset($memberCardModelTwo->id)?$memberCardModelTwo->id:$memberCardModelTwo['id'];
                }*/
                }
                $limitArr = LimitCardNumber::find()->where(['card_category_id'=>$this->cardId])->asArray()->all();
                if(is_array($limitArr) && !empty($limitArr)){
                    VenueLimitTimes::deleteAll(['member_card_id'=>$this->memberCardId]);
                    foreach ($limitArr as $v){
                        $isVenueLimit = VenueLimitTimes::find()->where(['member_card_id'=>$this->memberCardId])->andWhere(['<>','venue_id',0])->andWhere(['venue_id'=>$v['venue_id']])->asArray()->one();
//                          if(!empty($isVenueLimit)){
//                              continue;
//                          }
                        if($v['status'] == 1 || $v['status'] == 3){
                            $venueLimit    = new VenueLimitTimes();
                            $venueLimit->member_card_id = $this->memberCardId;
                            $venueLimit->venue_id       = $v['venue_id'];
                            $venueLimit->venue_ids      = $v['venue_ids'];
                            $venueLimit->total_times    = intval($v['times']);
                            if(!empty($v['times'])){
                                $venueLimit->overplus_times = intval($v['times']);
                            }else{
                                $venueLimit->overplus_times = intval($v['week_times']);
                            }
                            $venueLimit->week_times     = intval($v['week_times']);
                            $venueLimit->level           = intval($v['level']);
                            if(!$venueLimit->save()){
                                return $venueLimit->errors;
                            }
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

                $had_consumption = ConsumptionHistory::findOne(['consumption_type_id'=>$this->memberCardId,'consumption_type'=>'card','category'=>'发卡']);
                $this->historyCategory = empty($had_consumption) || ($had_consumption->due_date == abs((double)$this->dateEnd)) ? '发卡' : '续费';
                $consumption = ConsumptionHistory::findOne(['consumption_type_id'=>$this->memberCardId,'consumption_type'=>'card','category'=>$this->historyCategory, 'due_date'=>abs((double)$this->dateEnd)]);
                if(!empty($consumption)){
                    if(!$consumption->seller_id){
                        $consumption->seller_id =  $this->sellerId;
                    }
                    if(!$consumption->category){
                        $consumption->category =  '发卡';
                    }
                    $consumption->save();
                }else{
                    //if(empty($memberCardModel)){
                    $errors = $this->loadConsumptionData();
                    if($errors !== true){
                        return  $errors;
                        //}
                    }
                }
                if($transaction->commit() !== null){
                    return false;
                }
            }catch(\Exception $ex){
                $transaction->rollBack();
                Yii::error("cardNumber:{$this->memberNumber},message:{$ex->getMessage()}",'import');exit;
                return  $ex->getMessage();
            }
            echo "{$this->memberNumber}->";
        }
        if(empty($this->error)){
            return true;
        }else{
            return $this->error;
        }

    }
    public function getMemberType()
    {
        $arr = explode('(',$this->memberCardStatus);
        if($arr && isset($arr[1])){
            $this->memberCardStatus = rtrim($arr[1],')');
        }
    }
    public function getVenueId()
    {
        $organ      =  Organization::find()->where(['like','name','我爱运动'])->andWhere(['style'=>1])->asArray()->one();
        if(empty($organ)){
            $this->venueName = '我爱运动';
            $this->venueCode = NULL;
            $this->venuePid  = 0;
            $this->venueStyle = 1;
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
    public function setVenueData()
    {
        $venueArr = ['大上海瑜伽健身馆','大学路舞蹈健身馆','帝湖瑜伽健身馆','丰庆路游泳健身馆','大学路瑜伽馆','大卫城店(尊爵汇)','亚星游泳健身馆'];
        $arr      = ['大上海','大学路舞蹈','帝湖','丰庆路','大学路瑜伽','大卫城','亚星'];
        foreach ($venueArr as $k=>$value){
            $one = Organization::find()->where(['pid'=>$this->organId])->andWhere(['like','name',$arr[$k]])->asArray()->one();
            if(empty($one)){
                $venue = new Organization();
                $venue->name = $value;
                $venue->pid = $this->organId;
                $venue->created_at = time();
                $venue->create_id  = $this->adminId;
                $venue->style      = 2;
                $venue->code       = null;
                if (!$venue->save()) {
                    return $venue->errors;
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
            //消费表数据保存
            $model = new ConsumptionHistory();
            $model->member_id             = $this->memberId;             //?从对方获取插入的会员id
            $model->consumption_type      = "card";
            $model->consumption_type_id   = $this->memberCardId;        //?从对方拿取  （对方插入会员卡表时的id）
            $model->type                  = 1;        //消费方式暂定1（现金）；
            $model->consumption_date      = abs((double)$this->chargeDate);   //消费日期
            $model->consumption_amount    = $this->price;            //?消费金额 遍历数据拿出来
            $model->consumption_times     = 1;                        //消费次数
            $model->cashier_order         = (string)$this->cashierOrder;    //收银单号
            $model->cash_payment          = $this->price;             //现金付款
            $model->bank_card_payment     = $this->bankCard;        //银行卡付款
            $model->mem_card_payment      = $this->memberCard;        //会员卡付款
            $model->coupon_payment        = $this->coupon;            //优惠券付款
            $model->transfer_accounts     = $this->transferAccounts;  //转账付款
            $model->other_payment         = $this->otherPayment;       //其它转账
            $model->network_payment       = $this->networkPayment;     //网络支付
            $model->integration_payment   = $this->integrationPayment; //积分支付
            $model->discount_payment      = $this->discountPayment;    //折扣支付
            $model->seller_id              = $this->sellerId;          //销售人员id
            $model->describe               = null;
            $model->category               = $this->historyCategory;
            $model->due_date               = abs((double)$this->dateEnd);
            $model->remarks               = $this->note;//备注
            $modelResult = $model->save() ? true :false ;
            if($modelResult === false){
                return $model->errors;
                throw new \Exception('导入失败');
            }
        return true;
    }
    //添加员工
    public function loadEmployeeData($val)
    {
        if(isset($val) && !empty($val) && is_array($val)){
            array_shift($val);
            foreach ($val as $k=>$v){
                $params     = self::EMPLOYEE_DATA;
                $key        = $params[$k];
                $this->$key = $v;
            }
        }
    }
    public function loadEmployeeFile($path)
    {
        $model = new Excel();
        $data = $model->loadEmployeeFile($path);
        $this->getAdminIdOne();
        $k1 = 1;
        //插入到数据库
        foreach($data as $key=>$val){
            $this->loadEmployeeData($val);

            //插入员工表（会籍顾问）
            //判断员工是否存在，如果存在直接取id，否则直接插入
            if($this->company == '科技公司' || $this->company == '花丹' || $this->company == '迈步' || $this->company == '丰庆路' || $this->company == '丰庆店' || $this->company == '大学路' || $this->company == '瑜伽馆'){
                continue;
            }
            $company      = $this->getCompanyByName('我爱运动',1,0);
            if(empty($company)){
                $companyModel = new Organization();
                $companyModel->name  = '郑州市管城区我爱运动健身馆';
                $companyModel->pid   = 0;
                $companyModel->style = 1;
                $companyModel->path  = json_encode('0');
                $companyModel->create_id = $this->adminId;
                $companyModel->created_at = time();
                if(!$companyModel->save()){
                    return $companyModel->errors;
                }
                $this->organId = $companyModel->id;
            }else{
                $this->organId = $company->id;
            }
            $params   = self::INCUMBENCY;
            if(empty($this->company)) {
                if($this->store == '会务部'){
                    $organModel = $this->getCompanyByName('管理公司',2,$this->organId);
                }else{
                    continue;
                }
            }else{
                if($this->company == '团操部' || $this->company == '团课部'){
                    $organModel = $this->getCompanyByName('管理公司',2,$this->organId);
                }else{
                    $organModel = $this->getCompanyByName($this->company,2,$this->organId);
                }
            }
            if(empty($organModel)){
                $companyModel = new Organization();
                $companyModel->name  = $this->company;
                $companyModel->pid   = $this->organId;
                $companyModel->style = 2;
                $companyModel->create_id = $this->adminId;
                $companyModel->path      = json_encode('0,'.$this->organId);
                $companyModel->created_at = time();
                if(!$companyModel->save()){
                    return $companyModel->errors;
                }
                $this->venueId = $companyModel->id;
            }else{
                if(empty($organModel->path)){
                    $organModel->path = json_encode('0,'.$this->organId);
                    if(!$organModel->save()){
                        return $organModel->errors;
                    }
                    $this->venueId = $organModel->id;
                }else{
                    $this->venueId = $organModel->id;
                }
            }

            $store = $this->getCompanyByName($this->store,3,$this->venueId);
            if(empty($store)){
                $companyModel = new Organization();
                $companyModel->name  = $this->store;
                $companyModel->pid   = $this->venueId;
                $companyModel->style = 3;
                $companyModel->create_id  = $this->adminId;
                $companyModel->path       = json_encode('0,'.$this->organId.','.$this->venueId);
                $companyModel->created_at = time();
                if(!$companyModel->save()){
                    return $companyModel->errors;
                }
                $this->departId = $companyModel->id;
            }else{
                if(empty($store->path)){
                    $store->path = json_encode('0,'.$this->organId.','.$this->venueId);
                    if(!$store->save()){
                        return $store->errors;
                    }
                    $this->departId = $store->id;
                }else{
                    $this->departId = $store->id;
                }
            }

            $this->employeeMobile = !empty($this->employeeMobile)?"{$this->employeeMobile}":null;
            $this->employeeAlias = !empty($this->employeeAlias)?"{$this->employeeAlias}":null;
            $this->employeeWorkTime = date('Y-m-d',abs(intval($this->employeeWorkTime)));
            if(!empty($this->employeeName)) {
                $employeeModel = Employee::findOne(['name' => $this->employeeName]);
                if (empty($employeeModel)) {
                    $employeeMobileModel = Employee::findOne(['mobile'=>$this->employeeMobile]);
                    if(empty($employeeMobileModel)){
                        $employee = new Employee();
                        $params   = self::INCUMBENCY;
                        $employee->name            = $this->employeeName;
                        $employee->alias           = $this->employeeAlias;
                        $employee->sex             = $this->employeeSex == '男'?1:2;
                        $employee->mobile          = $this->employeeMobile;
                        $employee->position        = $this->position;
                        $employee->status          = $params[$this->employeeStatus];
                        $employee->entry_date      = $this->employeeWorkTime;
                        $employee->organization_id = $this->departId;
                        $employee->company_id      = $this->organId;
                        $employee->venue_id        = $this->venueId;
                        $employee->create_id       = $this->adminId;
                        if (!$employee->save()) {
                            $error = $employee->errors;
                            echo "employee>>" . $this->memberNumber . "<br /><br />";
                            return $error;
                        }
                    }else{
                        $employeeMobileModel->alias           = $this->employeeAlias;
                        $employeeMobileModel->sex             = $this->employeeSex == '男'?1:2;
                        $employeeMobileModel->mobile          = $this->employeeMobile;
                        $employeeMobileModel->position        = $this->position;
                        $employeeMobileModel->status          = $params[$this->employeeStatus];
                        $employeeMobileModel->entry_date       = $this->employeeWorkTime;
                        $employeeMobileModel->organization_id = $this->departId;
                        $employeeMobileModel->company_id      = $this->organId;
                        $employeeMobileModel->venue_id        = $this->venueId;
                        if(!$employeeMobileModel->save()){
                            return $employeeMobileModel->errors;
                        }
                    }
                } else {
                    if(empty($employeeModel->organization_id)){
                        if(empty($employeeModel->mobile)){
                            $employeeModel->alias           = $this->employeeAlias;
                            $employeeModel->sex             = $this->employeeSex == '男'?1:2;
                            $employeeModel->mobile          = $this->employeeMobile;
                            $employeeModel->position        = $this->position;
                            $employeeModel->status          = $params[$this->employeeStatus];
                            $employeeModel->entry_date       = $this->employeeWorkTime;
                            $employeeModel->organization_id = $this->departId;
                            $employeeModel->company_id      = $this->organId;
                            $employeeModel->venue_id        = $this->venueId;
                            if(!$employeeModel->save()){
                                return $employeeModel->errors;
                            }
                            $this->employeeId = $employeeModel->id;
                        }else if($employeeModel->mobile == $this->employeeMobile){
                            $employeeModel->alias           = $this->employeeAlias;
                            $employeeModel->sex             = $this->employeeSex == '男'?1:2;
                            $employeeModel->mobile          = $this->employeeMobile;
                            $employeeModel->position        = $this->position;
                            $employeeModel->status          = $params[$this->employeeStatus];
                            $employeeModel->entry_date       = $this->employeeWorkTime;
                            $employeeModel->organization_id = $this->departId;
                            $employeeModel->company_id      = $this->organId;
                            $employeeModel->venue_id        = $this->venueId;
                            if(!$employeeModel->save()){
                                return $employeeModel->errors;
                            }
                            $this->employeeId = $employeeModel->id;
                        }else{
                            $employeeMobileModel = Employee::findOne(['mobile'=>$this->employeeMobile]);
                            if(empty($employeeMobileModel)){
                                $employee = new Employee();
                                $params   = self::INCUMBENCY;
                                $employee->name            = $this->employeeName;
                                $employee->alias           = $this->employeeAlias;
                                $employee->sex             = $this->employeeSex == '男'?1:2;
                                $employee->mobile          = $this->employeeMobile;
                                $employee->position        = $this->position;
                                $employee->status          = $params[$this->employeeStatus];
                                $employee->entry_date       = $this->employeeWorkTime;
                                $employee->organization_id = $this->departId;
                                $employee->company_id      = $this->organId;
                                $employee->venue_id        = $this->venueId;
                                $employee->create_id       = $this->adminId;
                                if (!$employee->save()) {
                                    $error = $employee->errors;
                                    echo "employee>>" . $this->memberNumber . "<br /><br />";
                                    return $error;
                                }
                            }else{
                                $employeeMobileModel->alias           = $this->employeeAlias;
                                $employeeMobileModel->sex             = $this->employeeSex == '男'?1:2;
                                $employeeMobileModel->mobile          = $this->employeeMobile;
                                $employeeMobileModel->position        = $this->position;
                                $employeeMobileModel->status          = $params[$this->employeeStatus];
                                $employeeMobileModel->entry_date       = $this->employeeWorkTime;
                                $employeeMobileModel->organization_id = $this->departId;
                                $employeeMobileModel->company_id      = $this->organId;
                                $employeeMobileModel->venue_id        = $this->venueId;
                                if(!$employeeMobileModel->save()){
                                    return $employeeMobileModel->errors;
                                }
                            }
                        }
                    }else{
                        if($employeeModel->organization_id == $this->departId){
                            if(empty($employeeModel->mobile)){
                                $employeeModel->alias           = $this->employeeAlias;
                                $employeeModel->sex             = $this->employeeSex == '男'?1:2;
                                $employeeModel->mobile          = $this->employeeMobile;
                                $employeeModel->position        = $this->position;
                                $employeeModel->status          = $params[$this->employeeStatus];
                                $employeeModel->entry_date       = $this->employeeWorkTime;
                                $employeeModel->company_id      = $this->organId;
                                $employeeModel->venue_id        = $this->venueId;
                                if(!$employeeModel->save()){
                                    return $employeeModel->errors;
                                }
                                $this->employeeId = $employeeModel->id;
                            }elseif ($employeeModel->mobile == $this->employeeMobile){
                                $employeeModel->alias           = $this->employeeAlias;
                                $employeeModel->sex             = $this->employeeSex == '男'?1:2;
                                $employeeModel->position        = $this->position;
                                $employeeModel->status          = $params[$this->employeeStatus];
                                $employeeModel->entry_date       = $this->employeeWorkTime;
                                $employeeModel->mobile          = $this->employeeMobile;
                                $employeeModel->company_id      = $this->organId;
                                $employeeModel->venue_id        = $this->venueId;
                                if(!$employeeModel->save()){
                                    return $employeeModel->errors;
                                }
                                $this->employeeId = $employeeModel->id;
                            }else{
                                $employeeMobileModel = Employee::findOne(['mobile'=>$this->employeeMobile]);
                                if(empty($employeeMobileModel)){
                                    $employee = new Employee();
                                    $params   = self::INCUMBENCY;
                                    $employee->name            = $this->employeeName;
                                    $employee->alias           = $this->employeeAlias;
                                    $employee->sex             = $this->employeeSex == '男'?1:2;
                                    $employee->mobile          = $this->employeeMobile;
                                    $employee->position        = $this->position;
                                    $employee->status          = $params[$this->employeeStatus];
                                    $employee->entry_date       = $this->employeeWorkTime;
                                    $employee->organization_id = $this->departId;
                                    $employee->company_id      = $this->organId;
                                    $employee->venue_id        = $this->venueId;
                                    $employee->create_id       = $this->adminId;
                                    if (!$employee->save()) {
                                        $error = $employee->errors;
                                        echo "employee>>" . $this->memberNumber . "<br /><br />";
                                        return $error;
                                    }
                                }else{
                                    $employeeMobileModel->alias           = $this->employeeAlias;
                                    $employeeMobileModel->sex             = $this->employeeSex == '男'?1:2;
                                    $employeeMobileModel->mobile          = $this->employeeMobile;
                                    $employeeMobileModel->position        = $this->position;
                                    $employeeMobileModel->status          = $params[$this->employeeStatus];
                                    $employeeMobileModel->entry_date       = $this->employeeWorkTime;
                                    $employeeMobileModel->organization_id = $this->departId;
                                    $employeeMobileModel->company_id      = $this->organId;
                                    $employeeMobileModel->venue_id        = $this->venueId;
                                    if(!$employeeMobileModel->save()){
                                        return $employeeMobileModel->errors;
                                    }
                                }
                            }
                        }else{
                            $employeeMobileModel = Employee::findOne(['mobile'=>$this->employeeMobile]);
                            if(empty($employeeMobileModel)){
                                $employee = new Employee();
                                $params   = self::INCUMBENCY;
                                $employee->name            = $this->employeeName;
                                $employee->alias           = $this->employeeAlias;
                                $employee->sex             = $this->employeeSex == '男'?1:2;
                                $employee->mobile          = $this->employeeMobile;
                                $employee->position        = $this->position;
                                $employee->status          = $params[$this->employeeStatus];
                                $employee->entry_date       = $this->employeeWorkTime;
                                $employee->organization_id = $this->departId;
                                $employee->company_id      = $this->organId;
                                $employee->venue_id        = $this->venueId;
                                $employee->create_id       = $this->adminId;
                                if (!$employee->save()) {
                                    $error = $employee->errors;
                                    echo "employee>>" . $this->memberNumber . "<br /><br />";
                                    return $error;
                                }
                            }else{
                                $employeeMobileModel->alias           = $this->employeeAlias;
                                $employeeMobileModel->sex             = $this->employeeSex == '男'?1:2;
                                $employeeMobileModel->mobile          = $this->employeeMobile;
                                $employeeMobileModel->position        = $this->position;
                                $employeeMobileModel->status          = $params[$this->employeeStatus];
                                $employeeMobileModel->entry_date       = $this->employeeWorkTime;
                                $employeeMobileModel->organization_id = $this->departId;
                                $employeeMobileModel->company_id      = $this->organId;
                                $employeeMobileModel->venue_id        = $this->venueId;
                                if(!$employeeMobileModel->save()){
                                    return $employeeMobileModel->errors;
                                }
                            }
                        }
                        $this->employeeId = $employeeModel->id;
                    }
                }
            }
//                if($transactions->commit() !== null){
//                    return false;
//                }
            $k1 += 1;
//            }catch(\Exception $ex){
//                $transactions->rollBack();
//                return  $ex->getMessage();
//            }
        }
        if(empty($this->error)){
            return $k1;
        }else{
            return $this->error;
        }

    }

    public function getCompanyByName($name,$style,$pid)
    {
        return Organization::find()->where(['like','name',$name])->andWhere(['style'=>$style,'pid'=>$pid])->one();
    }

    public function setEmployee()
    {
        $transaction  = Yii::$app->db->beginTransaction();     //事务开始
        try{
            $employee = new Employee();
            $params   = self::INCUMBENCY;
            $employee->name            = $this->employeeName;
            $employee->alias           = $this->employeeAlias;
            $employee->sex             = $this->employeeSex == '男'?1:2;
            $employee->mobile          = $this->employeeMobile;
            $employee->position        = $this->position;
            $employee->status          = $params[$this->employeeStatus];
            $employee->entry_date       = $this->employeeWorkTime;
            $employee->organization_id = $this->departId;
            $employee->company_id      = $this->organId;
            $employee->venue_id        = $this->venueId;
            $employee->create_id       = $this->adminId;
            if (!$employee->save()) {
                $error = $employee->errors;
                echo "employee>>" . $this->memberNumber . "<br /><br />";
                return $error;
            }
            $transaction->commit();
            return true;
        }catch(\Exception $ex){
            $transaction->rollBack();
            return  $ex->getMessage();
        }
    }

}
