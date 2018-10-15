<?php
namespace backend\models;
use backend\modules\v1\models\Func;
use common\models\base\CardCategory;
use common\models\base\ConsumptionHistory;
use common\models\base\Employee;
use common\models\base\LimitCardNumber;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\MemberDetails;
use common\models\base\Order;
use common\models\base\Organization;
use common\models\base\VenueLimitTimes;
use Yii;
use common\models\Excel;
use yii\base\Model;

class ExcelOperate extends Model
{
    const  PARAMS_ONE = ['memberCardStatus','memberNumber','memberSex','memberName','memberConsultant','cardName','businessAmount','giveAmount','givePrivate','dateStart','dateEnd','note','chargeDate','cashierOrder','price','cash','bankCard','memberCard','coupon','transferAccounts','discountPayment','otherPayment','networkPayment','integrationPayment','describe','crossShop','sellerName','cashierOrderTwo','idCard','mobile','integral'];
    const  PARAMS_TWO = ['memberCardStatus','memberNumber','memberSex','memberName','memberConsultant','cardName','businessAmount','giveAmount','givePrivate','totalTimes','overTimes','dateStart','dateEnd','note','chargeDate','cashierOrder','price','cash','bankCard','memberCard','coupon','transferAccounts','discountPayment','otherPayment','networkPayment','integrationPayment','describe','crossShop','sellerName','cashierOrderTwo','mobile','idCard','integral'];
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
    public $chargeDate;        //收费日期
    public $cashierOrder;      //收费单号
    public $price;             //金额
    public $cash;              //现金
    public $bankCard;          //银行卡
    public $memberCard;        //会员卡
    public $coupon;            //优惠券
    public $transferAccounts;  //转账
    public $otherPayment;      //其他
    public $integral;          //积分
    public $discountPayment;   //折扣折让
    public $networkPayment;    //网络支付
    public $integrationPayment; //积分
    public $describe;           //备用
    public $crossShop;            //跨店
    public $sellerName;         //销售id
    public $cashierOrderTwo;     //销售清单
    public $sellerId;            //销售员
    public $venueId;            //场馆ID
    public $idCard;
    public $mobile;
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
    public $totalTimes;
    public $overTimes;
    public $venueNameTwo;
    public $venueType;
    public $cardType;
    public $bring;
    public $transferNum;
    public $transferPrice;
    public $surplus;

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
    //    end   Employee
    public function loadData($val)
    {
       if(isset($val) && !empty($val) && is_array($val)){
           $arr = [];
           if($this->paramType != 'three'){
               array_shift($val);
           }else{
               array_pop($val);
           }
           foreach ($val as $k=>$v){
               if($this->paramType == 'two'){
                   $params = self::PARAMS_TWO;
               }else{
                   $params = self::PARAMS_ONE;
               }
               if(24 <= $k && $k <= 34){
                  $arr[] = $v;
                  $this->describe = $arr;
                  continue;
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
    public function loadFile($path,$venue = '大上海',$name,$type='one'){ 
        $model = new Excel();
        $this->venueType    = $venue;
        $this->venueNameTwo = $name;
        $this->paramType    = $type;
        if($type == 'two'){
            $data = $model->loadFileTwo($path);
        }elseif($type == 'three'){
            $data = $model->loadFileThree($path);
        }elseif ($type == 'four'){
            $data = $model->loadFileTwo($path);
        }elseif($type == 'five'){
            $data = $model->loadFileFive($path);
        }else{
            $data = $model->loadFile($path);
        }
        $this->getAdminIdOne();
        $this->getVenueId();
        $this->setVenueData();

        //插入到数据库
        $nums = 0;
        $cardNameArr = ['瑜伽一年卡'=>'瑜伽卡', '瑜伽两年卡'=>'瑜伽卡', '瑜伽三年卡'=>'瑜伽卡', '游泳健身两年卡'=>'游泳健身卡','带人金爵卡'=>'带人金爵卡'];
        /**  $cardNameArr $cardNameArr = [
            '年卡'=>'YT24MD',
            '月卡'=>'YT24MD',
            '30年卡'=>'YT24MD',
            '双月卡'=>'Black Card60尊爵卡',
            '金卡'=>'YT24MD',
            '春季特价卡'=>'YT24MD',
            '赠月卡'=>'YT24MD',
            '双人30年卡'=>'YT24MD',
            'VIP'=>'YT24MD',
            '家庭金卡'=>'YT24MD',
            '双人VIP'=>'YT24MD',
            'vip卡'=>'Black Card60尊爵卡',
            'vip金卡'=>'YT24MD',
            '健身年卡'=>'YT24MD',
            'JXLQ-005'=>'PT60MD',
            '健身三年卡'=>'健身年卡',
            'TFT T36M'=>'帝湖亚星通用健身卡',
            'FT36M'=>'健身年卡',
            '升级瑜伽卡'=>'YT24MD',
            '商务年卡'=>'YT24MD',
            '加训练期'=>'Black Card60尊爵卡',
            '健身一年卡'=>'健身年卡',
            '健身两年卡'=>'健身年卡',
            'Fitness T24M'=>'YT24MD',
            'JSN-005-2'=>'YT24MD',
            'DH-FT12M'=>'健身年卡',
            'JSN-005-1'=>'健身年卡',
            'Fitness T12M'=>'YT24MD',
            'DH-HFT24MD'=>'健身年卡',
            '瑜伽健身年卡'=>'YT24MD',
            '瑜伽健身三年卡'=>'Black Card60尊爵卡',
            '带人瑜伽健身卡'=>'YT24MD',
            '赠年卡'=>'YT24MD',
            '赠卡'=>'YT24MD',
            '三个月装修升级卡'=>'YT24MD',
            '特价年卡'=>'YT24MD',
            '瑜伽卡（原金卡换）'=>'YT24MD',
            '瑜伽健身一年卡'=>'YT24MD',
            '五年卡'=>'YT24MD',
            '圣诞卡'=>'YT24MD',
            '瑜伽两年卡'=>'YT24MD',
            '瑜伽单节1年卡'=>'YT24MD',
            '店庆卡'=>'YT24MD',
            'Pepaid T24MD'=>'Black Card60尊爵卡',
            '次卡'=>'YT24MD',
            'DH-Platinum T36MD'=>'YT24MD',
            '瑜伽三年带人卡'=>'YT24MD',
            'YJN-005-1'=>'YT24MD',
            ' 赠半年卡'=>'YT24MD',
            'YJN-005-2'=>'YT24MD',
            'YJN-005-1-D'=>'瑜伽单节1年卡',
            'YGFLK-005-1'=>'YT24MD',
            '春季唤醒卡'=>'YT24MD',
            '定金'=>'YT24MD',
            'TPT T24MD'=>'YT24MD',
            'Pepaid T12MD'=>'YT24MD',
            'PT 24 SD'=>'瑜伽单节1年卡',
            'DHT24MD'=>'YT24MD',
            'PT 12 SD'=>'瑜伽单节1年卡',
            'PtmT30MD'=>'PT60MD',
            'ZJH-005-Z'=>'YT24MD',
            'YJY-005-6'=>'YT24MD',
            '12MMDS3'=>'YT24MD',
            'DHT30MD'=>'YT24MD',
            'YJN-005-1-Z'=>'YT24MD',
            '12MMD'=>'YT24MD',
            'Prepaid T10SD'=>'瑜伽单节1年卡',
            'T1M-6'=>'YT24MD',
            '增值卡'=>'Black Card60尊爵卡',
            '至尊卡'=>'YT24MD',
            '补余卡'=>'Black Card60尊爵卡',
            '尊爵一年卡'=>'Black Card60尊爵卡',
            'Black Card60尊爵卡'=>'Black Card60尊爵卡',
            'ZJ-005'=>'Black Card60尊爵卡',
            'PT60MD'=>'PT60MD',
            'ZBC36'=>'Black Card60尊爵卡',
            'BC36'=>'PT60MD',
            'BC36MD'=>'Black Card60尊爵卡',
            'Black Card60金爵'=>'Black Card60尊爵卡',
            'BC36-11'=>'Black Card60尊爵卡',
            'Prepaid T36MD'=>'PT60MD',
            'Platinum T36MD'=>'PT60MD',
            '新年团圆卡'=>'YT24MD',
            '半年卡'=>'YT24MD',
            '团购卡'=>'YT24MD',
            '一生一世卡'=>'YT24MD',
            'YJY-005-6-Z'=>'YT24MD',
            '10年卡'=>'YT24MD',
        ]; **/
        foreach($data as $key=>$val){
            $this->loadData($val);
            if((strstr($this->memberCardStatus, '共') && strstr($this->memberCardStatus, '条')) ||(strstr($this->memberCardStatus, '第') && strstr($this->memberCardStatus, '页'))){
                    continue;
            }
            if(!$this->departId){
                echo "venue>>".'场馆不存在'."<br /><br />";
            }

//            if($this->venueType == '大学路瑜伽'){
//                   if(is_bool(strpos('0950',$this->memberNumber))){
//                       continue;
//                   }
//            }elseif ($this->venueType == '大学路舞蹈'){
//                if(is_bool(strpos('0910',$this->memberNumber)) || is_bool(strpos('0710',$this->memberNumber)) || is_bool(strpos('0610',$this->memberNumber))){
//                    continue;
//                }
//            }
            //var_dump($this);exit;

            /*
            //更新会员卡名
            if(stripos($path, 'first1202')!==FALSE){
                $card = MemberCard::findOne(['card_number'=>$this->memberNumber]);
                if(!empty($card) && ($card->card_name != $this->cardName)){
                    echo "[card_numer:{$this->memberNumber}=card_name:{$card->card_name}->";
                    $card->card_name = $this->cardName;
                    $card->save();
                    echo "{$card->card_name}]\r\n";
                }
                continue;
            }

            if(stripos($path, 'second1202')===FALSE && stripos($path, 'third1202')===FALSE) continue;
*/
//            if(stripos($this->cardName,'次卡')!==FALSE) continue;
            //var_dump($this);exit;

            if(stripos($this->cardName,'次卡')!==FALSE){
                $memberCard = MemberCard::findOne(['card_number'=>$this->memberNumber]);
                if(!empty($memberCard)){
                    $memberCardId = $memberCard->id;
                    $memberId     = $memberCard->member_id;
                    //1、删除通店信息
                    VenueLimitTimes::deleteAll(['member_card_id'=>$memberCardId]);
                    //2、删除消费记录
                    ConsumptionHistory::deleteAll(['or',['consumption_type_id'=>$memberCardId, 'consumption_type'=>'card'],['member_id'=>$memberCard->member_id]]);
                    //3、删除会员
                    Member::deleteAll(['id'=>$memberId]);
                    //4、删除会员详情
                    MemberDetails::deleteAll(['member_id'=>$memberId]);
                    //5、删除会员卡
                    MemberCard::deleteAll(['card_number'=>$this->memberNumber]);
                    echo "{$memberCard->card_number}->";
                }
                //continue;
            }


            $num = 0;
            if($type == 'four'){
                $num++;
                echo $num;
                $this->saveOrder();
                continue;
            }
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
                $cardName = isset($cardNameArr[$this->cardName]) ? $cardNameArr[$this->cardName] : $this->cardName;
                $cardCategoryModel = CardCategory::find()->where(["card_name"=>$cardName,"venue_id"=>$this->venueId])->andWhere(['IS NOT','create_at',NULL])->asArray()->one();
                if(empty($cardCategoryModel)){
                    $cardCategoryModel = CardCategory::find()->where(["card_name"=>$cardName,"venue_id"=>$this->venueId])->asArray()->one();
                }
                if(empty($cardCategoryModel)){
                    if(strpos($this->cardName,'次')!==FALSE){
                        $num = 2;
                    }else{
                        $num = 1;
                    }
                    $cardCategory->card_name        = $cardName;
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
                }else{
                    $this->cardId        = $cardCategoryModel['id'];
                    $this->transferNum   = $cardCategoryModel['transfer_number'];
                    $this->transferPrice = $cardCategoryModel['transfer_price'];
                    $this->surplus       = $cardCategoryModel['transfer_number'];
                    $this->bring         = $cardCategoryModel['bring'];
                }
/*                if(strpos($this->cardName,'金爵') || strpos($this->cardName,'尊爵') || strpos($this->cardName,'36')){
                    $venue      =  Organization::find()->where(['pid'=>[$this->organId,75]])->asArray()->all();
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
                            if($v['id'] == 14){
                                $num = 6;
                            }else{
                                $num = -1;
                            }
                            $limit->card_category_id = $this->cardId;
                            $limit->venue_id         = $v['id'];
                            if($v['id'] == 76){
                                $limit->times            = 6;
                            }else{
                                $limit->times            = $num;
                            }
                            if($v['id'] == 13 || $v['id'] == 10){
                                $limit->level            = 2;
                            }else{
                                $limit->level            = 1;
                            }
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
                }*/
                //插入会员表
                //判断会员是否存在(根据手机号码)
                $memberCardModel = MemberCard::findOne(["card_number"=>(string)$this->memberNumber]);
                if(!empty($memberCardModel)){
                    $memberModel = Member::findOne($memberCardModel->member_id);
                    if(empty($memberModel)){
                        $memberModel = Member::findOne(["username"=>$this->memberName,'mobile'=>$this->mobile,'venue_id'=>intval($this->venueId)]);
                    }
                }else{
                    $memberModel = Member::findOne(["username"=>$this->memberName,'mobile'=>$this->mobile,'venue_id'=>intval($this->venueId)]);
                }

                if(empty($memberModel)){
                    $password = '123456';
                    $password = Yii::$app->security->generatePasswordHash($password);
                    $member->username      = isset($this->memberName)?$this->memberName:'暂无';
                    $member->mobile        = (string)$this->mobile ?: '0';
                    $member->password      = $password;
                    $member->register_time = abs((int)$this->chargeDate);
                    $member->counselor_id  = $this->employeeId;
                    $member->status        = 1;
                    $member->venue_id      = $this->venueId;
                    $member->company_id    = $this->organId;
                    $member->member_type = 1;
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
                        if(empty($memberModel->counselor_id)){
                            $member->counselor_id  = $this->employeeId;
                        }
                        if(!$memberModel->save()){
                            return $memberModel->errors;
                        }
                        if(empty($member->counselor_id)){
                            $member->counselor_id = $this->employeeId;
                        }
                        $member->member_type = 1;
                        if(!$memberModel->save()){
                            return $memberModel->errors;
                        }
                        $this->memberId = isset($memberModel->id)?$memberModel->id:$memberModel['id'];
                    }else{
                        if($memberModel->venue_id != $this->venueId){
                            $memberModel->venue_id = $this->venueId;
                            $memberModel->company_id    = $this->organId;
                        }
                        if(empty($memberModel->counselor_id)){
                            $member->counselor_id  = $this->employeeId;
                        }
                        $memberModel->member_type = 1;
                        if(!$memberModel->save()){
                            return $memberModel->errors;
                        }
                        $this->memberId = isset($memberModel->id)?$memberModel->id:$memberModel['id'];
                    }
                }

                //插入会员详情表
                $memberDetail_model = MemberDetails::find()->where(["member_id"=>$this->memberId])->one();
                $birth = $this->getIDCardInfo($this->idCard);
                $birth = isset($birth['birthday']) ? $birth['birthday'] : '';
                if(empty($memberDetail_model)){
                    $memberDetail->member_id = $this->memberId;
                    $memberDetail->name      = $this->memberName;
                    $memberDetail->sex       = $this->memberSex == '男' ? 1 : 2;
                    $memberDetail->document_type = 1;
                    $memberDetail->created_at = abs((int)$this->chargeDate);
                    $memberDetail->score      = $this->integral;
                    $memberDetail->id_card   = $this->idCard ?: '0';
                    $memberDetail->birth_date   = $birth;
                    $memberDetail->recommend_member_id = 0;
                    if(!$memberDetail->save()){
                        $error = $member->errors;
                        echo "memberDetail>>".$this->memberNumber."<br /><br />";
                        return $error;
                    }
                }else{
                    if(empty($memberDetail_model->document_type)){
                        $memberDetail_model->document_type = 1;
                    }
                    if(empty($memberDetail_model->birth_date)){
                        $memberDetail_model->birth_date   = $birth;
                    }
                    $memberDetail_model->save();
                }
                //插入员工表（会籍顾问）
                //判断员工是否存在，如果存在直接取id，否则直接插入
                if($this->sellerName){
                    $sellerModel = Employee::findOne(['name'=>$this->sellerName,'organization_id'=>$this->departId]);
                    if(empty($sellerModel)){
                        $employee                  = new Employee();
                        $employee->name            =  $this->sellerName;
                        $employee->organization_id =  $this->departId;
                        $employee->venue_id          = $this->venueId;
                        $employee->company_id        = $this->organId;
                        $employee->create_id         =  $this->adminId;
                        $employee->status            = 2;
                        if(!$employee->save()){
                            $error = $employee->errors;
                            echo "employee>>".$this->memberNumber."<br /><br />";
                            return $error;
                        }
                        $this->sellerId = $employee->id;
                    }else{
                        $this->sellerId = $sellerModel->id;
                    }
                }
                //插入会员卡表
                //判断会员卡号是否存在
                $cardCategory = CardCategory::findOne(['id'=>$this->cardId]);
                if(empty($memberCardModel)){
                    $this->getMemberType();
                    $priceType = array_flip(self::PRICE_TYPE);
                    if(!isset($priceType[$this->memberCardStatus])){
                        $type      = self::PRICE_TYPE;
                        $type[]    = $this->memberCardStatus;
                        if(!empty($this->memberCardStatus)){
                            $priceType = array_flip($type);
                        }
                    }
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
                    if($this->cardName == '次卡'){
                        $memberCard->card_type        = 2;
                    }else{
                        $memberCard->card_type        = 1;
                    }
                    $memberCard->total_times       = $this->totalTimes;
                    $memberCard->consumption_times = intval($this->totalTimes) - intval($this->overTimes);
                    $memberCard->card_name        = "$this->cardName";
                    $memberCard->invalid_time     = abs((int)$this->dateEnd);
                    $memberCard->payment_time     = abs((int)$this->chargeDate);
                    $memberCard->present_money    = $this->giveAmount;
                    $memberCard->amount_money     = $this->businessAmount;
                    $memberCard->present_private_lesson = $this->givePrivate;
                    $memberCard->describe         = "$this->note";
                    $memberCard->employee_id      = $this->sellerId;
                    $memberCard->consume_status   = !empty($this->memberCardStatus)?$priceType[$this->memberCardStatus]:1;
                    $memberCard->company_id  = $this->organId;
                    $memberCard->venue_id    = $this->venueId;
                    $memberCard->transfer_num = $this->transferNum;
                    $memberCard->transfer_price = $this->transferPrice;
                    $memberCard->surplus = $this->surplus;
                    $memberCard->bring = $this->bring;
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
                    $time          = json_decode($cardCategory->duration,true);                  //卡种有效期
                    $leave         = json_decode($cardCategory->leave_long_limit,true);         //卡种每次请假天数、请假次数
                    $renew         = json_decode($cardCategory->validity_renewal,true);         //卡种有效期续费
                    $memberCard->leave_days_times   = json_encode($leave);                   //每次请假天数、请假次数
                    $memberCard->ordinary_renewal    = $cardCategory->ordinary_renewal;
                    $memberCard->validity_renewal    = json_encode($renew);
                    $memberCard->pic                 = $cardCategory->pic;
                    $memberCard->deal_id        = $cardCategory->deal_id;               //合同id
                    $memberCard->card_type        = $cardCategory->category_type_id;
                    $memberCard->type             = $cardCategory->card_type;
                    if(!$memberCard->save()){
                        $error = $memberCard->errors;
                        echo "memberCard>>".$this->memberNumber."<br /><br />";
                        return $error;
                    }
                    $this->memberCardId = $memberCard->id;
                }else{
                    //$memberCardModelTwo = MemberCard::findOne(["member_id"=>$this->memberId,'invalid_time'=>intval($this->dateEnd)]);
                    //if(empty($memberCardModelTwo)){
                        if($memberCardModel->invalid_time < intval($this->dateEnd)){
                            $this->getMemberType();
                            $priceType = array_flip(self::PRICE_TYPE);
                            if(!isset($priceType[$this->memberCardStatus])){
                                $type      = self::PRICE_TYPE;
                                $type[]    = $this->memberCardStatus;
                                if(!empty($this->memberCardStatus)){
                                    $priceType = array_flip($type);
                                }
                            }
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
                            if($this->cardName == '次卡'){
                                $memberCard->card_type        = 2;
                            }else{
                                $memberCard->card_type        = 1;
                            }
                            $memberCardModel->total_times       = $this->totalTimes;
                            $memberCardModel->consumption_times = $this->totalTimes - $this->overTimes;
                            $memberCardModel->card_name        = $this->cardName;
                            $memberCardModel->invalid_time     = abs((int)$this->dateEnd);
                            $memberCardModel->payment_time     = abs((int)$this->chargeDate);
                            $memberCardModel->present_money    = $this->giveAmount;
                            $memberCardModel->amount_money     = $this->businessAmount;
                            $memberCardModel->present_private_lesson = $this->givePrivate;
                            $memberCardModel->describe         = "$this->note";
                            $memberCardModel->employee_id      = $this->sellerId;
                            $memberCardModel->consume_status   = !empty($this->memberCardStatus)?$priceType[$this->memberCardStatus]:1;
                            $memberCardModel->company_id       = $this->organId;
                            $memberCardModel->venue_id         = $this->venueId;
                            $memberCardModel->active_limit_time = $cardCategory->active_time;            //激活期限
                            $memberCardModel->transfer_num       = $cardCategory->transfer_number;       //转让次数
                            $memberCardModel->surplus            = $cardCategory->transfer_number;       //剩余转让次数
                            $memberCardModel->transfer_price     = $cardCategory->transfer_price;        //转让金额
                            $memberCardModel->recharge_price     = $cardCategory->recharge_price;        //充值卡充值金额
                            $memberCardModel->present_money      = $cardCategory->recharge_give_price;  //买赠金额
                            $memberCardModel->renew_price        = $cardCategory->renew_price;           //续费价
                            $memberCardModel->renew_best_price   = $cardCategory->offer_price;          //续费优惠价
                            $memberCardModel->renew_unit         = $cardCategory->renew_unit;            //续费多长时间/天
                            $memberCardModel->leave_total_days   = $cardCategory->leave_total_days;     //请假总天数
                            $memberCardModel->leave_least_days   = $cardCategory->leave_least_Days;     //每次请假最少天数
                            $time          = json_decode($cardCategory->duration,true);                  //卡种有效期
                            $leave         = json_decode($cardCategory->leave_long_limit,true);         //卡种每次请假天数、请假次数
                            $renew         = json_decode($cardCategory->validity_renewal,true);         //卡种有效期续费
                            $memberCardModel->leave_days_times   = json_encode($leave);                   //每次请假天数、请假次数
                            $memberCardModel->ordinary_renewal    = $cardCategory->ordinary_renewal;
                            $memberCardModel->validity_renewal    = json_encode($renew);
                            $memberCardModel->deal_id             = $cardCategory->deal_id;               //合同id
                            $memberCardModel->card_type        = $cardCategory->category_type_id;
                            $memberCardModel->type             = $cardCategory->card_type;
                            if(!$memberCardModel->save()){
                                $error = $memberCardModel->errors;
                                echo "memberCard>>".$this->memberNumber."<br /><br />";
                                return $error;
                            }

                            $member = Member::findOne($this->memberId);
                            $member->counselor_id = $this->employeeId;
                            $member->save();

                        }else{
                            $time          = json_decode($cardCategory->duration,true);                  //卡种有效期
                            $memberCardModel->deal_id             = $cardCategory->deal_id;               //合同id
                            $memberCardModel->save();
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
                $this->getMemberType();
                $consumption = ConsumptionHistory::findOne(['consumption_type_id'=>$this->memberCardId,'consumption_type'=>'card','category'=>$this->memberCardStatus]);
                if(!empty($consumption)){
                    if(!$consumption->seller_id){
                        $consumption->seller_id =  $this->sellerId;
                    }
                    if(!$consumption->category){
                        $consumption->category =  '购卡';
                    }
                    if($consumption->consumption_date != $this->chargeDate){
                        $consumption->consumption_date = $this->chargeDate;
                        $consumption->consumption_time = $this->chargeDate;
                    }
                    if(empty($consumption->venue_id)){
                        $consumption->venue_id = $this->venueId;
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
                return  $ex->getMessage();
            }
            $nums++;
            echo $nums.'->';
        }
        if(empty($this->error)){
            return true;
        }else{
            return $this->error;
        }

    }
    //保存订单
    public function saveOrder()
    {
        if($this->memberCardStatus == '会员卡(升级)'){
            $type = '升级';
        }elseif ($this->memberCardStatus == '会员卡(续费)'){
            $type = '续费';
        }else{
            $type = '售卡';
        }
        if(!empty($this->memberConsultant)){
            if($this->memberNumber == '09010206'){
                $this->memberConsultant = '弋位博';
            }
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
        }else{
            return true;
        }
        $card                        = MemberCard::findOne(['card_number'=>$this->memberNumber]);
        $member                      = Member::findOne(['id'=>$card->member_id]);
        if( $this->memberConsultant != '弋位博'){
            if(empty($member->counselor_id) || $member->counselor_id != $this->employeeId){
                $member->counselor_id = $this->employeeId;
                $member->save();
            }
        }
        $employee                    = Employee::findOne(['id'=>intval($this->employeeId)]);
        $detail                      = MemberDetails::findOne(['member_id'=>$card->member_id]);
        $order                       = new Order();
        $order->venue_id            = $this->venueId;                                              //场馆id
        $order->company_id          = $this->organId;                                           //公司id
        $order->member_id           = $card->member_id;                                          //会员id
        $order->card_category_id    = $card->id;                                     //会员卡id
        $order->order_time          = abs((int)$this->chargeDate);                                              //订单创建时间
        $order->pay_money_time      = abs((int)$this->chargeDate);                                               //付款时间
        $order->pay_money_mode      = 1;                                    //付款方式
        $order->sell_people_id      = $employee->id;                           //售卖人id
        $order->create_id           = $employee->id;    //操作人id
        $order->payee_id            = $employee->id;    //操作人id
        $order->status              = 2;                                                     //订单状态：2已付款
        $order->note                = $type;                                                //备注
        $number                     = \common\models\Func::setOrderNumber();
        $order->order_number        = "{$number}";                                           //订单编号
        $order->deposit             = null;                                                  //定金
        $order->cash_coupon         = null;                                                  //代金券
        $order->net_price           = $card->amount_money;                                   //实收价格
        $order->all_price           = $card->amount_money;                                    //商品总价格
        $order->total_price         = $card->amount_money;                               //总价
        $order->card_name           = $card->card_name;                              //卡名称
        $order->sell_people_name    = $employee->name;                                     //售卖人姓名
        $order->payee_name          = $employee->name;                                     //收款人姓名
        $order->member_name         = $detail->name;                                           //购买人姓名
        $order->pay_people_name     = $detail->name;                                           //付款人姓名
        $order->consumption_type    = 'card';
        $order->consumption_type_id = $card->id;
        $order = $order->save() ? $order : $order->errors;
        if ($order) {
            return $order;
        }else{
            return $order->errors;
        }
    }
    public function getMemberType()
    {
        $memberCardStatus = $this->memberCardStatus;
        $arr = explode('（', $this->memberCardStatus);
        if(!isset($arr[1])) $arr = explode('(', $this->memberCardStatus);

        if(!empty($arr) && isset($arr[1])){
            $memberCardStatus = mb_substr($arr[1], 0, -1);
        }
        $this->memberCardStatus = $memberCardStatus;
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
        $transaction = \Yii::$app->db->beginTransaction();                //开启事务
        try {
               //消费表数据保存
                $model = new ConsumptionHistory();
                $model->member_id             = $this->memberId;     ;        //?从对方获取插入的会员id
                $model->consumption_type      = "card";
                $model->consumption_type_id   = $this->memberCardId;        //?从对方拿取  （对方插入会员卡表时的id）
                $model->type                  = 1;        //消费方式暂定1（现金）；
                $model->consumption_date      = abs((int)$this->chargeDate);   //消费日期
                $model->consumption_amount    = $this->price;            //?消费金额 遍历数据拿出来
                $model->consumption_times     = 1;                        //消费次数
                $model->cashier_order         = (string)$this->cashierOrder;    //收银单号
                $model->cash_payment          = $this->cash;             //现金付款
                $model->bank_card_payment     = $this->bankCard;        //银行卡付款
                $model->mem_card_payment      = $this->memberCard;        //会员卡付款
                $model->coupon_payment        = $this->coupon;            //优惠券付款
                $model->transfer_accounts     = $this->transferAccounts;  //转账付款
                $model->other_payment         = $this->otherPayment;       //其它转账
                $model->network_payment       = $this->networkPayment;     //网络支付
                $model->integration_payment   = (int)$this->integrationPayment; //积分支付
                $model->discount_payment      = $this->discountPayment;    //折扣支付
                $model->seller_id              = $this->employeeId;          //销售人员id
                $model->venue_id               = $this->venueId;
                $model->company_id             = $this->organId;
                $model->describe               = json_encode(['describe'=>$this->describe,'cashierOrderTwo'=>$this->cashierOrderTwo]);  //备注
                $model->category               = !empty($this->memberCardStatus)?$this->memberCardStatus:'发卡';
                $model->due_date               = abs((int)$this->dateEnd);
                $model->remarks                = $this->note;

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
    public function getIDCardInfo($IDCard,$format = 1){
        $result['error']  = 0 ;//0：未知错误，1：身份证格式错误，2：无错误
        $result['flag']   = '';//0标示成年，1标示未成年
        $result['tdate']  = '';//生日，格式如：2012-11-15
        if(!preg_match("/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/",$IDCard)){
            $result['error']=1;
            return $result;
        }else{
            if(strlen($IDCard)==18)
            {
                $tyear=intval(substr($IDCard,6,4));
                $tmonth=intval(substr($IDCard,10,2));
                $tday=intval(substr($IDCard,12,2));
            }
            elseif(strlen($IDCard)==15)
            {
                $tyear=intval("19".substr($IDCard,6,2));
                $tmonth=intval(substr($IDCard,8,2));
                $tday=intval(substr($IDCard,10,2));
            }

            if($tyear>date("Y")||$tyear<(date("Y")-100))
            {
                $flag=0;
            }
            elseif($tmonth<0||$tmonth>12)
            {
                $flag=0;
            }
            elseif($tday<0||$tday>31)
            {
                $flag=0;
            }else
            {
                if($format)
                {
                    $tdate=$tyear."-".$tmonth."-".$tday;
                }
                else
                {
                    $tdate=$tmonth."-".$tday;
                }

                if((time()-mktime(0,0,0,$tmonth,$tday,$tyear))>18*365*24*60*60)
                {
                    $flag=0;
                }
                else
                {
                    $flag=1;
                }
            }
        }
        $result['error']=2;//0：未知错误，1：身份证格式错误，2：无错误
        $result['isAdult']=$flag;//0标示成年，1标示未成年
        $result['birthday']= isset($tdate)?$tdate:'';//生日日期
        return $result;
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

    public function loadPirvate()
    {
        $chargeClass1 = ChargeClass::findOne(['name'=>'健身私教','venue_id'=>$this->venueId]);
        $mco = MemberCourseOrder::findOne(['member_id'=>$this->memberId, 'member_card_id'=>$this->memberCardId, 'cashierOrder'=>$this->cashierOrder]);
        if(empty($mco)){
            $newmco = new MemberCourseOrder();
            $newmco->course_amount = (int)$this->givePrivate;
            $newmco->create_at = abs((int)$this->chargeDate);
            $newmco->money_amount = 0;
            $newmco->overage_section = (int)$this->givePrivate;
            $newmco->deadline_time = abs((int)$this->dateEnd);
            $newmco->product_id = '';//TODO
            $newmco->product_type = 1;
            $newmco->private_type = '健身私教';
            $newmco->charge_mode  = 1;
            $newmco->private_id   = '';//TODO
            $newmco->present_course_number = 0;
            $newmco->surplus_course_number = (int)$this->givePrivate;
            $newmco->cashier_type = '';//TODO
            $newmco->member_card_id = $this->memberCardId;
            $newmco->seller_id = '';//TODO
            $newmco->cashierOrder = $this->cashierOrder;
            $newmco->member_id = $this->memberId;
            $newmco->product_name = '';//TODO
            $newmco->type = 'HS';
            $newmco->activeTime = abs((int)$this->dateStart);
            $newmco->chargePersonId = '';//TODO
            $newmco->note = '购卡赠送';
            if(!$newmco->save()){
                return $newmco->errors;
            }

            $newmcod = new MemberCourseOrderDetails();
            $newmcod->course_order_id = $newmco->id;
            $newmcod->course_id = '';//TODO
            $newmcod->course_num = (int)$this->givePrivate;
            $newmcod->course_length = ceil((abs((int)$this->dateEnd) - abs((int)$this->dateStart))/60*60*24);
            $newmcod->original_price = '';//TODO
            $newmcod->pos_price = '';//TODO
            $newmcod->type = 1;
            $newmcod->category = 2;
            $newmcod->product_name = '';//TODO
            $newmcod->course_name = '';//TODO
            $newmcod->class_length = '';//TODO
            if(!$newmcod->save()){
                return $newmcod->errors;
            }
            //消费记录
            $consumption = new ConsumptionHistory();
            $consumption->member_id = $this->memberId;
            $consumption->consumption_type = 'charge';
            $consumption->consumption_type_id = $newmco->id;
            $consumption->type = 1;
            $consumption->consumption_date = abs((int)$this->chargeDate);
            $consumption->consumption_times = 1;
            $consumption->cashier_order = $this->cashierOrder;
            //TODO
            $consumption->cash_payment = $v[15];
            $consumption->bank_card_payment = $v[16];
            $consumption->mem_card_payment = $v[17];
            $consumption->coupon_payment = $v[18];
            $consumption->transfer_accounts = $v[19];
            $consumption->other_payment = $v[20];
            $consumption->network_payment = $v[22];
            $consumption->integration_payment = $v[23];
            $consumption->discount_payment = $v[21];
            $consumption->venue_id = $this->venueId;
            $consumption->seller_id = $sellerId;
            $consumption->category = '购课';
            $consumption->company_id = 1;
            $consumption->consumption_amount = $v[14];
            $consumption->remarks = $v[10];
            if(!$consumption->save()){
                return $consumption->errors;
            }

        }
    }
}
