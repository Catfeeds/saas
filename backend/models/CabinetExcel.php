<?php
namespace backend\models;
use common\models\base\Cabinet;
use common\models\base\ConsumptionHistory;
use common\models\base\Member;
use common\models\base\MemberCabinet;
use common\models\base\MemberCabinetRentHistory;
use common\models\base\MemberCard;
use common\models\base\MemberDetails;
use common\models\Excel;
use yii\base\Model;
use yii\helpers\VarDumper;

class CabinetExcel extends Model
{
    const  PARAMS =["memberCardNum","memberName","cabinetNum","memberAdviser","rentStartTime",
                     "rentEndTime","rentDeposit","rentMoney","rentType","consumeList","collectMoneyPerson",
                     "consumeDate","remark","consumeMoney","cash","bankCard","memberCard","coupon",
                     "transferAccounts","otherPayment","discountPayment","networkPayment",
                     "integrationPayment","describe"];
    public $memberCardNum;      //会员卡号
    public $memberName;      //会员姓名
    public $cabinetNum;      //衣柜编号
    public $memberAdviser;   //会籍顾问
    public $rentStartTime;   //租柜时间
    public $rentEndTime;     //租柜结时间
    public $rentDeposit;    //租用押金
    public $rentMoney;       //租金
    public $rentType;        //租柜类型(消费类型) 1：续组 2：新租 3：退押金 4：
    public $consumeList;    //消费单号
    public $collectMoneyPerson;  //收费人(操作员)
    public $consumeDate;    //交费日期
    public $remark;          //备注
    public $consumeMoney;   //消费金额
    public $cash;                //现金
    public $bankCard;          //银行卡
    public $memberCard;        //会员卡
    public $coupon;            //优惠券
    public $transferAccounts;  //转账
    public $otherPayment;      //其他
    public $discountPayment;   //折扣折让
    public $networkPayment;    //网络支付
    public $integrationPayment; //积分
    public $describe;           //备用



    //额外需要的属性
    public $memberId;         // 会员id
    public $memberCardId;     //会员卡号id
    public $cabinetId;        // 柜子id
    public $consumeIntroduce; // 消费介绍
    public $cabinetTypeId;   //柜子类型id
    public $theMemCardName;  //会员卡名字

    public $mobile;            //移动电话
    public $fixPhone;          //固定电话
    public $createCardDate;   // 会员卡开卡时间

    public $activeTime;       // 会员激活时间

    public function loadData($data){
        $data  = array_values($data);
        $param = self::PARAMS;
        $describe = [];
        foreach($data as $keys=>$values){
            if($keys>=23&&$keys<=33){
                 $describe[]=$values;
            }else{
                $key = $param[$keys];
                $this->$key = $values;
            }
        }
        $this->describe          = json_encode($describe);
        $this->consumeIntroduce = json_encode(["租金"=>$this->rentMoney,"押金"=>$this->rentDeposit]);
    }

  // 导入柜子租用信息（衣柜租用2008-2017.xls）
    public function loadFile($path,$type,$name)
    {
        $model = new Excel();
        $data = $model->loadCabinetFile($path);
        //检查场馆是否存在
        $check = new ExcelCharge();
        $check->venueType = $type;
        $check->venueNameTwo = $name;
        // 公司id  $check->organId  场馆id $check->venueId 部门id $check->
         $check->getVenueId();
        //数据导入前 数据检查
        if(!$check->departId){
            echo "venue>>".'场馆不存在'."<br /><br />";
        }
        //检查默认的卡种id是否存在
        // 卡类型id $check->cardCategoryTypeId  //卡种id   $check->cardCategoryId 
        $check->cardCategoryId();
        if(!$check->cardCategoryId){
            echo "cardCategoryId>>".'默认卡种id不存在'."<br /><br />";
        }
        //检查默认柜子类型是否存在（混合柜）
        // 柜子类型id  $this->cabinetTypeId;
        $insertResultEnd   = $this->checkCabinetType($check->organId,$check->venueId);
        if($insertResultEnd!=="success"){
            return $insertResultEnd;
        }
        // 数据导入执行
        foreach ($data as $k=>$val){
            // 数据加载前的判断 末端数据选择性加载
            $resultOne   = preg_match_all("/共/",$val[1]);
            if($resultOne!=0){
                break;
            }
            //数据加载
             $this->loadData($val);
            /**员工表数据插入，并且获取Id（销售人员）-- 数据录入**/
            /**--获取员工id（$check->employeeId）--**/
                $insertResult1 = $check->insertEmployeeData($this->memberAdviser,"employee");
                if($insertResult1 !== true){
                    print_r($insertResult1);
                    return $insertResult1;
                }
            // 会员数据导入，并且获取会员id
            /**--获取会员id（$this->memberId） -**/
                $insertResult2 = $this->checkMember($check->organId,$check->venueId,$check->employeeId);
                if($insertResult2 !== true){
                    print_r($insertResult2);
                    return $insertResult2;
                }

            //会员详情表数据导入，
                $insertResult3 = $this->checkMemberDetail();
                if($insertResult3 !== true){
                    print_r($insertResult3);
                    return $insertResult3;
                }

            /**检查会员卡号是否存在，不存在添加，并获取卡号id**/
                $insertResult4 = $this->checkMemberCard($check->cardCategoryId,$check->organId,$check->venueId);
                if($insertResult4 !== "success"){
                    print_r($insertResult4);
                    return $insertResult4;
                }

            /**柜子的录入**/
            // 柜子id  $this->cabinetId
                $insertResult51 = $this->cabinet($check->organId,$check->venueId);
                if($insertResult51 !== "success"){
                     print_r($insertResult51);
                     return $insertResult51;
                }
            /**历史消费记录的录入**/
                $insertResult6 = $this->consumeHistory($check->organId,$check->venueId,$check->employeeId);
                if($insertResult6 !== true){
                    print_r($insertResult6);
                    return $insertResult6;
                }
            /**会员历史动作记录表**/
                $insertResult7 = $this->memberHistoryCabinet();
                if($insertResult7!=="success"){
                    return $insertResult7;
                }
            /**当前会员柜子表租用数据录入，并且改变柜子表的租用状态**/
                $insertResult8 = $this->memberNowCabinetRent();
                if($insertResult8!=="success"){
                    return $insertResult8;
                }
        }
     //   $this->checkData();
        return '文件导入成功';
    }

    public function checkData(){
         $count1 = Employee::find()->asArray()->count();
         echo "员工数量:".$count1;
         $count2 = Member::find()->asArray()->count();
         echo "会员数量:".$count2;
         $count3 =MemberDetails::find()->asArray()->count();
         echo "会员详情数量:".$count3;
         $count4 = MemberCard::find()->asArray()->count();
         echo "会员卡数量:".$count4;
         $count5 = Cabinet::find()->asArray()->count();
         echo "柜子数量".$count5;
         $count6 = ConsumptionHistory::find()->asArray()->count();
         echo "历史消费记录数量".$count6;
         $count7 = MemberCabinetRentHistory::find()->asArray()->count();
         echo "会员柜子租用历史记录表".$count7;
    }



    // 柜子类型 默认导入
    public function  checkCabinetType($companyId,$venueId){
         $model = CabinetType::findOne(["type_name"=>"混合柜"]);
         if(!empty($model)){
             $this->cabinetTypeId = $model->id;
             return "success";
         }
         $model = new CabinetType();
         $model->type_name   = "混合柜";
         $model->sex          = 3;
         $model->created_at  = time();
         $model->venue_id    = $venueId;
         $model->company_id  = $companyId;
         $model->cabinet_model = 2;
         $model->cabinet_type  = 2;
         if(!$model->save()){
            return $model->errors;
         }
        $this->cabinetTypeId = $model->id;
        return "success";
    }



    public function memberNowCabinetRent(){
             $rentEndTime = (int)$this->rentEndTime + 60*60*24*7;
             if(time()>=$this->rentStartTime&&time()<=$rentEndTime&&$this->rentType!="退押金"){
                 $model = new MemberCabinet();
                 $model->member_id   = $this->memberId;
                 $model->price        = $this->consumeMoney;
                 $model->start_rent  = $this->rentStartTime;
                 $model->end_rent    = $this->rentEndTime;
                 $model->status      = 1;
                 $model->creater_id  = 2;
                 $model->create_at   = time();
                 $model->cabinet_id  = $this->cabinetId;
                 $model->member_card_id = $this->memberCardId;
                 $model->rent_type = $this->rentType;
                 if(!$model->save()){
                     return $model->errors;
                 }
                 //当前租用柜子有数据录入 改变柜子租用状态
                    $changeCabinetStatus = $this->changeRentCabinetStatus();
                    if($changeCabinetStatus==="success"&&$model->save()){
                         return "success";
                    }
             }
                         return "success";
    }
   //改变已租柜子的状态
    public function changeRentCabinetStatus(){
           $model =Cabinet::findOne(["id"=>$this->cabinetId]);
           $model->status = 2;
           if(!$model->save()){
             return $model->errors;
           }
           return "success";
    }

   // 柜子的历史租用记录
    public function memberHistoryCabinet(){
            $model = new MemberCabinetRentHistory();
            $model->member_id   = $this->memberId;
            $model->price        = $this->consumeMoney;
            $model->start_rent  = $this->rentStartTime;
            $model->end_rent    = $this->rentEndTime;
            $model->create_at   = time();
            $model->cabinet_id  = $this->cabinetId;
            $model->member_card_id = $this->memberCardId;
            $model->rent_type    = $this->rentType;
            if(!$model->save()){
                return $model->errors;
            }
            return "success";
    }

    /**
     * 云运动 -  柜子表数据 - 会员表数据导入 获取会员Id）
     * @author lihuien<lihuien@sports.club>
     * @create 2017/4/24
     * @param $companyId   //场馆id
     * @param $venueId     //场馆id
     * @param $counselorId  //顾问id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function checkMember($companyId,$venueId,$counselorId){
        // 不符合查找条件 会员id=0
        if(empty($this->memberCardNum)&&empty($this->memberName)&&empty($this->mobile)){
            $this->memberId = 0;
            return true;
        }
        // 初始化值
        $memberModel = [];
        // 1.判断是否从卡号找到   $this->memberId
        if(!empty($this->memberCardNum)){
            $memberModel = MemberCard::find()->where(["card_number"=>$this->memberCardNum])->asArray()->one();
        }
        //2.卡号未找到，从手机号查找 $this->memberId
        if(empty($memberModel)&&!empty($this->mobile)){
            $memberModel = \backend\models\Member::find()
                ->select("cloud_member.id as member_id")
                ->where(["mobile"=>$this->mobile])
                ->asArray()->one();
        }
        // 3: 手机号没找到,在从会员名字查找 $this->memberId
        if(empty($memberModel)&&!empty($this->memberName)){
            $memberModel = MemberDetails::find()->where(["name"=>$this->memberName])
                  ->select("member_id")
                  ->asArray()->one();
        }
        // 卡号或名字 都未查找到 返回录入新数据
        if(empty($memberModel)){
            $member = new Member();
            $member->username       = isset($this->memberName)&&!empty($this->memberName)?$this->memberName:"excel表无姓名";
            $member->password       =  "0";
            $member->mobile         =  !empty($this->mobile)?$this->mobile:"0";
            $member->fixPhone       =  !empty($this->fixPhone)?$this->fixPhone:"0";
            $member->venue_id       = $companyId;
            $member->company_id     = $venueId;
            $member->member_type    = 1;
            $member->register_time  = time();
            $member->status         = 1;
            $member->counselor_id  = $counselorId;
            if(!$member->save()){
                return $member->errors;
            }
            $this->memberId   = $member->id;                      /*会员id*/
        }else{
            $this->memberId = $memberModel['member_id'];          /*会员id*/
        }
        return true;
    }

    //会员详情表数据导入
    public function checkMemberDetail(){
        $memberDetail = MemberDetails::find()->where(["member_id"=>$this->memberId])->asArray()->one();
        if(empty($memberDetail)){
            $memberDetail  = new MemberDetails();
            $memberDetail->member_id  = $this->memberId;
            $memberDetail->	name       = !empty($this->memberName)?$this->memberName:"excel表没有名字";
            $memberDetail->created_at = time();
            if($this->sex==="男"){
                  $this->sex = 1;
            }elseif($this->sex=="女"){
                  $this->sex = 2;
            }else{
                  $this->sex = null;
            }
            $memberDetail->sex         = !empty($this->sex)?$this->sex:null;
            if (!$memberDetail->save()){
                return $memberDetail->errors;
            }
        }
        return true;
    }

    //检查会员卡号是否存在，不存在的话，添加会员卡号
    public function checkMemberCard($cardCategoryId,$companyId,$venueId){
        if(empty($this->memberCardNum)){
            $this->memberCardId = 0;
            return "success";
        }
        $memberCardModel = MemberCard::find()->where(["card_number"=>$this->memberCardNum])->asArray()->one();
        if(empty($memberCardModel)&&isset($this->memberCardNum)){
            $memberCard = new MemberCard();
            $memberCard->card_number           = $this->memberCardNum;
            $memberCard->create_at             = !empty($this->createCardDate)?(int)$this->createCardDate:time();   //开卡时间
            $memberCard->payment_type          = 1;        //是否全款（暂定全款）
            $memberCard->is_complete_pay       = 1;        //是否完成付款（暂定是）
            $memberCard->level                  = 1;               //卡种等级默认1
            $memberCard->venue_id              = $venueId;         // 场馆id
            $memberCard->company_id            = $companyId;       // 公司id
            $memberCard->card_category_id     = $cardCategoryId;  //获取卡种id （上部方法已获取）
            $memberCard->member_id             = $this->memberId;  //会员id
            $memberCard->card_name             = !empty($this->theMemCardName)?$this->theMemCardName:null;
            $memberCard->invalid_time          = !empty($this->rentEndTime)?$this->rentEndTime:time(); //  卡的失效时间
            $memberCard->active_time           = !empty($this->activeTime)?$this->activeTime:time();   // 卡的激活时间
            if(!empty($this->rentEndTime)&&$this->rentEndTime>time()){
                $memberCard->status = 1;
            }else{
                $memberCard->status = 3;
            }
            if(!$memberCard->save()){
                return $memberCard->errors;
            }
            $this->memberCardId   = $memberCard->id;                        /*会员卡号id*/
        }else{
            $this->memberCardId   = $memberCardModel['id'];                 /*会员卡号id*/
            return "success";
        }
        return "success";
    }

   // 柜子表数据录入(减少重复柜子编号的录入)
    public function cabinet($companyId,$venueId){
          if(empty($this->memberCardNum)&&empty($this->cabinetNum)){
              $this->cabinetId = 0;
              return "success";
          }
          $findCabinet = Cabinet::findOne(["cabinet_number"=>$this->cabinetNum]);
          if(!empty($findCabinet)){
              $this->cabinetId = $findCabinet["id"];
              return "success";
          }
          $model = new Cabinet();
          $model->cabinet_type_id = $this->cabinetTypeId;
          $model->creater_id      = 2;
          $model->cabinet_number  = $this->cabinetNum;
          $model->cabinet_model   = 2;
          $model->cabinet_type     = 2;
          $model->created_at      = time();
          $model->company_id      = $companyId;
          $model->venue_id        = $venueId;
          if(!$model->save()){
              return $model->errors;
          }else{
              $this->cabinetId = $model->id;
              return "success";
          }
    }
    //消费历史记录表数据录入
    public function consumeHistory($companyId,$venueId,$employeeId){
        if(empty($this->consumeList)){
            return true;
        }
        $consumeHistoryRecord = ConsumptionHistory::find()->where(["cashier_order"=>"$this->consumeList"])->asArray()->one();
        if(empty($consumeHistoryRecord)&&!empty($this->consumeList)){
            $consumeHistory = new ConsumptionHistory();
            $consumeHistory->consumption_type    = $this->rentType;
            $consumeHistory->consumption_type_id = 11;  //会员订单id
            $consumeHistory->member_id           = $this->memberId;         //会员id
            $consumeHistory->consumption_date   = $this->consumeDate;     //缴费日期
            $consumeHistory->consumption_amount = abs($this->consumeMoney);   //缴费金额
            $consumeHistory->cashier_order       = (string)$this->consumeList;  //收银单号
            $consumeHistory->cash_payment        = $this->cash;          //现金付款
            $consumeHistory->bank_card_payment   = $this->bankCard;     //银行卡付款
            $consumeHistory->mem_card_payment    = $this->memberCard;     //会员卡付款
            $consumeHistory->coupon_payment      = $this->coupon;         //优惠券付款
            $consumeHistory->transfer_accounts   = $this->transferAccounts; //转账
            $consumeHistory->other_payment       = $this->otherPayment;     //其它付款
            $consumeHistory->discount_payment    = $this->discountPayment;  //折扣折让
            $consumeHistory->network_payment     = $this->networkPayment;   //网络支付
            $consumeHistory->integration_payment = $this->integrationPayment; //积分支付
            $consumeHistory->venue_id             = $venueId;          //场馆id
            $consumeHistory->company_id           = $companyId;        //公司id
            $consumeHistory->seller_id            = $employeeId;      //销售员id
            $consumeHistory->describe             = $this->describe;  //积分备用
            $consumeHistory->category             = $this->rentType;   //租用类型
            $consumeHistory->consume_describe    = $this->consumeIntroduce; // 消费详情介绍
            $consumeHistory->remarks              = $this->remark;  //会员租柜备注
            if(!$consumeHistory->save()){
                return $consumeHistory->errors;
            }
        }
        return true;
    }


   // 租赁新柜子
    public function newCabinet($cabinetNum){
        $model = new MemberCabinet();
        $model->member_id  = $this->memberId;
        $model->price       = $this->rentMoney;
        $model->start_rent = $this->rentStartTime;
        $model->end_rent    = $this->rentEndTime;
        $model->status      = 1;   //正常
        $model->create_at  = time();
        $model->cabinet_id  = 1;
        if(!$model->save()){
            return $model->errors;
        }
    }

    const  ANOTHER_PARAMETER =["theMemberName","sex","theMemberCard","theCabinetNumber","adviser","theRentStart","theRentEnd","surplusDayNum","phone","mobilePhone"];
    public $theMemberName;
    public $sex;
    public $theMemberCard;
    public $theCabinetNumber;
    public $adviser;
    public $theRentStart;
    public $theRentEnd;
    public $surplusDayNum;

    public $phone;
    public $mobilePhone;

    // 租赁新柜子逻辑运算
    public function autoLoadData($data){
          $data = array_values($data);
          $dataS = self::ANOTHER_PARAMETER;
          foreach($data as $keys=>$value){
              $key        = $dataS[$keys];
              $this->$key = $value;
          }
    }

    public function loadCabinetExpireFile($path){
        $model = new Excel();
        $data = $model->loadExpireCabinetFile($path);
        foreach ($data  as $keys=>$values){
            $this->autoLoadData($values);
        }
    }












}

?>