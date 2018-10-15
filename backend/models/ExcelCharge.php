<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/5/16
 * Time: 15:01
 */

namespace backend\models;


use common\models\base\CardCategory;
use common\models\base\ChargeClass;
use common\models\base\ChargeClassPrice;
use common\models\base\ConsumptionHistory;
use common\models\base\Course;
use common\models\base\CoursePackageDetail;
use common\models\base\Employee;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\MemberCourseOrder;
use common\models\base\MemberCourseOrderDetails;
use common\models\base\MemberDetails;
use common\models\base\Organization;
use common\models\base\TransferRecord;
use common\models\Excel;
use yii\base\Model;

class ExcelCharge extends Model
{
    const  PARAMS = ['type','memberNumber','memberName','activeTime','invalidTime','ptType','salesperson','timesMode',
                     'classStyle','isSameClass','privateTrain','totalTimes','remainTimes','giveClass','lessonRemain',
                     'classHoursPrice','serviceNote','cashType','paymentDate', 'cashReceipt','cashier','note','price',
                     'cash','bankCard','memberCard','coupon','transferAccounts', 'otherPayment','discountPayment',
                     'networkPayment','integrationPayment','describe'];
    const INFO = [0=>'memberNumber',1=>'memberName',4=>'memberMobile',7=>'registerTime',8=>'idCard',9=>'familyAddress'];
    const TRANSFER = [1=>'transferTime',4=>'memberCardNum',8=>'memberName',10=>'memberSex',11=>'mobile',12=>'registerPerson',13=>'firstName',14=>'firstSex',15=>'firstMobile',16=>'note',18=>'cashierNumber',19=>'cashier',20=>'transferPrice',21=>'cashPayment',22=>'bankCardPayment',28=>'networkPayment',23=>'memberCardPayment',27=>'discount',24=>'coupon',25=>'transfer',26=>'other',29=>'integral',30=>'spare'];

    public $type;                //类型(PT)
    public $memberNumber;       //会员卡号(07000030993710101098)
    public $memberName;         //会员名字(王保通)
    public $activeTime;         //生效时间(2010/4/17)
    public $invalidTime;       //失效时间(2012/6/15)
    public $ptType;             //私教类别(健身私教)
    public $salesperson;        //销售员(王婷)
    public $timesMode;          //计次方式（计次课程）
    public $classStyle;         //上课方式 （单个教练）
    public $isSameClass;        //是否同时上课（否）
    public $privateTrain;        //私教姓名（mxy）
    public $totalTimes;          //购买总次数（60）
    public $remainTimes;         //剩余购买次数（1）
    public $giveClass;           //赠送课（0）
    public $lessonRemain;        //增课剩余（0）
    public $classHoursPrice;     //课时费（100元）
    public $serviceNote;         //业务备注（因会员工作忙不能按时训练，延期至2011.12.31 原私教李佳现转给）
    public $cashType;            //收银类型（转让）
    public $paymentDate;         //缴费日期（2015/3/3）
    public $cashReceipt;         //收银单号(1503030002)
    public $cashier;             //收银员(杜婷)
    public $note;                //备注(老卡到期转课至新卡)
    public $price;               //金额(0)
    public $cash;                //现金(0)
    public $bankCard;          //银行卡(0)
    public $memberCard;        //会员卡(0)
    public $coupon;            //优惠券(0)
    public $transferAccounts;  //转账(0)
    public $otherPayment;      //其他(0)
    public $discountPayment;   //折扣折让(0)
    public $networkPayment;    //网络支付(0)
    public $integrationPayment; //积分(0)
   // 所有的备用
    public $describe;           //备用(json字段)

    public $venueType;         // 场馆名称
    public $venueNameTwo;     // 场馆第二个细分名称
    public $companyName;      // 公司名字
    public $courseName;
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
    //场馆数据
    public $venueName; //组织名称
    public $venuePid;
    public $venueStyle;
    public $venueCode;
    public $classKey;
    public $classTime;
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
    public $mobile;            //会员手机号
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
    public $firstMemberId;      //原会员id

    public $chargeClassId;     // 私教产品id
    public $courseId;           // 课程id
    public $courseDetailId;    // 课程详情ID
    public function loadData($val)
    {
        if(isset($val) && !empty($val) && is_array($val)){
            $val = array_values($val);
            $arr = [];
            foreach ($val as $k=>$v){
                $params = self::PARAMS;
                if($k>=32 && $k <= 42){
                    $arr[] = $v;
                }else{
                    $key = $params[$k];
                    $this->$key = $v;
                }
            }
            $this->describe = json_encode($arr);
        }
    }
    // 文件数据加载 逻辑编写
    public function loadFile($path,$status,$type,$name)
    {
          $model = new Excel();
          $data  = "";
          if($status=="chargeClassList"){
              $data = $model->loadFileCharge($path,'charge');
          }else{
              $data = $model->loadEndTimeCharge($path,"charge");
              $model = new ExcelChargeEndTime();
              $endData = $model->getEndTimeData($data,$type,$name);
              return   $endData;
          }
          $this->venueType    = $type;
          $this->venueNameTwo = $name;
          /**场馆表插入数据，并且获取场馆id**/
          $this->getVenueId();
          if(!$this->departId){
              echo "venue>>".'场馆不存在'."<br /><br />";
          }
          /**检查默认卡种id是否存在**/
          $this->cardCategoryId();
          if(!$this->cardCategoryId){
              echo "cardCategoryId>>".'默认卡种id不存在'."<br /><br />";
          }

          /**对应生成默认的产品**/
          $createProduct  = $this->createProduct();
          if($createProduct!==true){
              return $createProduct;
          }
          $num = 0;
          foreach ($data as $k=>$val){
              $this->loadData($val);
              if(strstr($this->cashType, '共') && strstr($this->cashType, '条')){
                  continue;
              }
              if($this->cashType == '定金'){
                  continue;
              }
              echo "{$this->memberNumber}->";
              $member        = new Member();
              $memberCard    = new MemberCard();
              /**员工表数据插入，并且获取Id（销售人员）**/
               $result1 =  $this->insertEmployeeData($this->salesperson,"employee");
              if($result1!==true){
                  return $result1;
              }
              /**员工表数据插入，并且获取Id（私教人员）**/
               $result2 =  $this->insertEmployeeData($this->privateTrain,"private");
              if($result2!==true){
                 return $result2;
              }
              /**员工表数据插入，并且获取Id（收费人员）**/
              $result3 =  $this->insertEmployeeData($this->cashier,"chargePerson");
              if($result3!==true){
                  return $result3;
              }
              /**会员表数据插入，并且获取会员Id**/
                // 1 先从卡号 寻找会员id
               $memberModel = MemberCard::find()->where(["card_number"=>$this->memberNumber])->select("member_id")->asArray()->one();
               // 2.excel表无手机号，不用手机号查找
               // 3.卡号没找到 再从名字 寻找会员id
               if((empty($memberModel)&&!empty($this->memberName))||empty(Member::findOne($memberModel['member_id']))){
                     $memberModel = \backend\models\MemberDetails::find()
                     ->joinWith(["member"],false)
                     ->select("cloud_member_details.name,cloud_member_details.member_id,cloud_member.venue_id")
                     ->where(["and",["cloud_member.venue_id"=>$this->venueId],["cloud_member_details.name"=>$this->memberName]])
                     ->asArray()->one();
               }
               if(empty($memberModel)&&!empty($this->memberNumber)){
                   $member = new Member();
                   $password = '123456';
                   $password = \Yii::$app->security->generatePasswordHash($password);
                   $member->username      = isset($this->memberName)?$this->memberName:'暂无';
                   $member->mobile        = '0';
                   $member->password      = $password;
                   $member->register_time = time();
                   $member->counselor_id  = $this->employeeId;
                   $member->status        = 1;
                   $member->venue_id      = $this->venueId;
                   $member->company_id    = $this->organId;
                   if(!$member->save()){
                       return $member->errors;
                   }
                   $this->memberId   = $member->id;                      /*会员id*/
               }else{
                   $this->memberId =$memberModel['member_id'];         /*会员id*/
               }

               /**会员详情表数据插入，数据插入**/
               $memberDetail = MemberDetails::find()->where(["member_id"=>$this->memberId])->asArray()->one();
              if(empty($memberDetail)&&!empty($this->memberName)){
                  $memberDetail  = new MemberDetails();
                  $memberDetail->member_id = $this->memberId;
                  $memberDetail->name       = !empty($this->memberName)?$this->memberName:"excel无数据";
                  if (!$memberDetail->save()){
                      return $memberDetail->errors;
                  }
              }
            /**检查会员卡号是否存在，不存在添加，并获取卡号id**/
              $memberCardModel = MemberCard::find()->where(["card_number"=>$this->memberNumber])->one();

              if(empty($memberCardModel)&&isset($this->memberNumber)){
                  $memberCard->	card_number       = (string)$this->memberNumber;
                  $memberCard-> create_at         = time();     //开卡时间
                  $memberCard->card_name          = "时间卡";
                  if($this->invalidTime<time()){
                      $memberCard    -> status            =  2;    //异常 2（暂定：后期需要修改）
                  }else{
                      $memberCard    -> status            =  1;    //正常 1
                  }
                  $memberCard->active_time           = $this->activeTime; //卡的生效时间(暂定私教课的开始时间)
                  $memberCard->payment_type          = 1;       //是否全款（暂定全款）
                  $memberCard->is_complete_pay       = 1;        //是否完成付款（暂定是）
                  $memberCard->invalid_time          = $this->invalidTime;    // 卡的失效时间 暂定私教到期时间
                  $memberCard->level                  = 1;            //卡种等级默认1
                  $memberCard->card_category_id     = $this->cardCategoryId; //获取卡种id （上部方法已获取）
                  $memberCard->member_id             = $this->memberId;  //会员id
                  $memberCard->venue_id              = $this->venueId;
                  $memberCard->company_id            = $this->organId;    // 公司id
                  if(!$memberCard->save()){
                      return $memberCard->errors;
                  }
                  $this->memberCardId   = $memberCard->id;                      /*会员卡号id*/
              }else{
                  $memberCardModel->member_id             = $this->memberId;
                  if(!$memberCardModel->save()){
                      return $memberCardModel->errors;
                  }
                  $this->memberCardId   = $memberCardModel->id;                 /*会员卡号id*/
              }
              /**会员课程订单表数据录入**/
              $memCourseResult = $this->memCourseOrder();
              if($memCourseResult!==true){
                   return $memCourseResult;
              }
              /**会员课程订单详情表数据录入**/
              $memCourseOrderDetail = $this->memCourseOrderDetail();
              if($memCourseOrderDetail!==true){
                  return $memCourseOrderDetail;
              }

             /**会员消费历史记录表数据录入**/
              $consumeHistoryResult = $this->consumeHistory();
              if($consumeHistoryResult!==true){
                  return $consumeHistoryResult;
              }
         }
          return true;
      }
      // 对应生成默认的产品
     public function createProduct(){
          // 查询是否有对应产品
          $data = ChargeClass::find()->where(["name"=>"私教综合课"])->asArray()->one();
          if(empty($data)){
              $model = new ChargeClass();
              $model->name = "私教综合课";
              $model->create_id  = 2;
              $model->created_at = time();
              $model->category   = 1;
              $model->venue_id   = $this->venueId;  // 场馆id
              $model->company_id = $this->organId;  // 公司id
              $model->status     = 1;
              $model->valid_time = 3000000000;
              $model->activated_time = 30;
              $model->type        = 2;
              if(!$model->save()){
                    return $model->errors;
              }
              $this->productId = $model->id;  //生成 私教产品id
              // 课程详情表数据录入
              $chargeClassDetail = $this->chargeClassDetail();
              if($chargeClassDetail !== true ){
                  return $chargeClassDetail;
              }
              // 课程收费表 数据录入
              $chargeClassPrice = $this->chargeClassPrice();
              if($chargeClassPrice!==true){
                     return $chargeClassPrice;
              }
          }else{
              $this->productId = $data["id"];  //生成 私教产品id
          }
             return true;
     }
    // 收费课程价格
     public function  chargeClassPrice(){
         $model = new ChargeClassPrice();
         $model->charge_class_id = $this->productId;
         $model->course_package_detail_id = $this->courseDetailId;
         $model->create_time = time();
         if(!$model->save()){
               return $model->errors;
         }
         return true;
     }
     // 课程详情表 数据录入
     public function chargeClassDetail(){
         $model = new CoursePackageDetail();
         $model->charge_class_id =  $this->productId;      // 收费课程表id
         $model->type = 1;    // 私课
         $model->category = 2;
         $model->create_at = time();
         // 查询是否有瑜伽课
         $course = Course::find()->where(["and",["name"=>"瑜伽课"],["class_type"=>1]])->asArray()->one();
         if(empty($course)){
             $courseResult = $this->createCourse();
              if($courseResult !== true){
                    return $courseResult;
              }
         }
         $model->course_id = $this->courseId;
         if(!$model->save()){
             return $model->errors;
         }
         $this->courseDetailId = $model->id;
         return true;
     }

    public function createCourse(){
         $model = new Course();
         $model->pid = 0;
         $model->name = "瑜伽课";
         $model->category = "瑜伽";
         $model->created_at = time();
         $model->path  = json_encode(0);
         $model->class_type = 1;
         $model->create_id  = 2;
         $model->company_id = $this->organId;
         $model->venue_id   = $this->venueId;
         if(!$model->save()){
             return $model->errors;
         }
         $this->courseId =  $model->id;
         return true;
    }




    public function checkData(){
        $num1 = Member::find()->asArray()->count();
        echo "会员数量".$num1."<br>";
        $num2 = MemberDetails::find()->asArray()->count();
        echo "会员详情表".$num2."<br>";
        $num3 = MemberCourseOrder::find()->asArray()->count();
        echo "会员课程订单表".$num3."<br>";
        $num4 =MemberCourseOrderDetails::find()->asArray()->count();
        echo "会员课程订单详情表".$num4."<br>";
        $num5 = ConsumptionHistory::find()->asArray()->count();
        echo "历史记录消费表".$num5."<br>";
    }




      // 订单详情表 数据导入
       public function memCourseOrderDetail(){
            $memCourseOrderDetail = MemberCourseOrderDetails::findOne(["course_order_id"=>$this->memCourseOrderId]);
            if(empty($memCourseOrderDetail)){
                $model = new MemberCourseOrderDetails();
                $model->course_order_id = !empty($this->memCourseOrderId)?$this->memCourseOrderId:0;
                $model->course_id        = 0;
                $model->course_num       = $this->remainTimes;
                $model->course_length   = ceil(($this->invalidTime-$this->activeTime)/60*60*24);
                $model->original_price  = $this->classHoursPrice;
                $model->sale_price      = $this->classHoursPrice;
                $model->pos_price       = $this->classHoursPrice;
                $model->type             = 1;
                $model->category        = 2;
                $model->product_name    = $this->type;
                $model->course_name     = $this->type.'课程';
                $model->class_length    = 60;
                if(!$model->save()){
                    return $model->errors;
                }
                $this->memCourseOrderId = $model->course_order_id;
            }else{
                $this->memCourseOrderId = $memCourseOrderDetail['course_order_id'];
            }
           return true;
       }

    //消费历史记录数据录入
    public function consumeHistory(){
            $consumeHistoryRecord = ConsumptionHistory::find()->where(["cashier_order"=>"$this->cashReceipt"])->andWhere(["venue_id"=>$this->venueId])->asArray()->one();
            if(empty($consumeHistoryRecord)&&!empty($this->memberNumber)){
                $consumeHistory = new ConsumptionHistory();
                $consumeHistory->consumption_type    = "私教综合课程(".$this->cashType.")";  // 消费项目解释
                $consumeHistory->consumption_type_id = $this->memCourseOrderId; //会员订单id
                $consumeHistory->member_id           = $this->memberId;         //会员id
                $consumeHistory->consumption_date   = intval($this->paymentDate);     //缴费日期
                $consumeHistory->consumption_amount = $this->price;          //缴费金额
                $consumeHistory->cashier_order       = "$this->cashReceipt";    //收银单号
                $consumeHistory->cash_payment        = $this->cash;          //现金付款
                $consumeHistory->bank_card_payment   = $this->bankCard;     //银行卡付款
                $consumeHistory->mem_card_payment    = $this->memberCard;     //会员卡付款
                $consumeHistory->coupon_payment      = $this->coupon;         //优惠券付款
                $consumeHistory->transfer_accounts   = $this->transferAccounts; //转账
                $consumeHistory->other_payment       = $this->otherPayment;     //其它付款
                $consumeHistory->discount_payment    = $this->discountPayment;  //折扣折让
                $consumeHistory->network_payment     = $this->networkPayment;   //网络支付
                $consumeHistory->integration_payment = $this->integrationPayment; //积分支付
                $consumeHistory->venue_id             = $this->venueId;          //场馆id
                $consumeHistory->seller_id            = $this->employeeId;      //销售员id
                $consumeHistory->describe             = $this->describe;         //备用
                $consumeHistory->type                  = 1;   // 消费方式：默认现金
                $consumeHistory->category              = '购课';
                $consumeHistory->remarks               = $this->note;
                if(!$consumeHistory->save()){
                    return $consumeHistory->errors;
                }
            }
           return true;
    }
    //会员课程订单表数据录入( 字段 未完整)
    public  function memCourseOrder(){
         $memberCourseOrder = MemberCourseOrder::find()->where(["cashierOrder"=>$this->cashReceipt,"member_id"=>$this->memberId])->asArray()->one();
         if(empty($memberCourseOrder)&&!empty($this->cashReceipt)){
             $memCourseOrder = new MemberCourseOrder();
             $memCourseOrder->course_amount   = $this->totalTimes;      //总次数
             $memCourseOrder->create_at       = intval($this->paymentDate);      //缴费时间
             $memCourseOrder->activeTime      = $this->activeTime;     // 激活时间
             $memCourseOrder->money_amount    = intval($this->price);           // 总金额
             $memCourseOrder->overage_section = $this->remainTimes;     //剩余次数
             $memCourseOrder->deadline_time   = $this->invalidTime;    //失效时间
             $memCourseOrder->product_id      = !empty($this->productId)?$this->productId:null ;
             $memCourseOrder->product_type   = 1;                       //课程类型(私课)
             $memCourseOrder->private_id      = $this->privateId;       //私教id
             $memCourseOrder->present_course_number  = intval($this->giveClass);       //赠课总数
             $memCourseOrder->surplus_course_number  = intval($this->lessonRemain);    //赠课剩余次数

             $memCourseOrder->service_pay_id   = 0;                //服务项目id暂定0
             $memCourseOrder->member_card_id  = $this->memberCardId;   //会员卡id
             $memCourseOrder->seller_id       = $this->employeeId;       //销售员id
             if($this->cashType!=="转让"){
                 $memCourseOrder->cashierOrder    = (string)$this->cashReceipt;     //会员课程表收银单号
             }

             /**注：课时费在其它表**/
             $memCourseOrder->business_remarks = "$this->serviceNote";      //业务备注
             $memCourseOrder->member_id       = isset($this->memberId)&&!empty($this->memberId)?$this->memberId:0;
             $memCourseOrder->private_type    = $this->ptType;         //私教类别
             $memCourseOrder->type             = $this->type=="PT"?1:2;
             $memCourseOrder->product_name    = $this->type;      // 产品名称 暂定 产品类型（PT或HS）
             $memCourseOrder->chargePersonId  = $this->chargePersonId;   // 消费人员id
             /**计费方式**/
             if($this->timesMode=="计次课程"){
                 $memCourseOrder->charge_mode     = 1;         //计次课程
             }else{
                 $memCourseOrder->charge_mode     = 2;         //其它
             }
             /**上课方式**/
             if($this->classStyle=="单个教练"){
                 $memCourseOrder->class_mode      = 1;       //上课方式
             }elseif($this->classStyle=="多个教练"){
                 $memCourseOrder->class_mode      = 2;       //上课方式
             }else{
                 $memCourseOrder->class_mode      = 3;       //上课方式
             }
             /**是否同时上课**/
             if($this->isSameClass=="否"){
                 $memCourseOrder->is_same_class   = 2;
             }else{
                 $memCourseOrder->is_same_class   = 1;
             }
             if($this->cashType=="全款"){
                 $memCourseOrder->cashier_type = 1;
             }elseif($this->cashType=="转让"){
                 $memCourseOrder->cashier_type = 2;
             }else{
                 $memCourseOrder->cashier_type = 3;
             }
             if(!$memCourseOrder->save()){
                 return $memCourseOrder->errors;
             }
             $this->memCourseOrderId  = $memCourseOrder->id;                   //会员课程订单id
         }else{
             $this->memCourseOrderId  = $memberCourseOrder["id"];              //会员课程订单id
         }
           return true;
    }
   // 员工表数据导入
    public function insertEmployeeData($person,$type){
        if(empty($person)){
            if($type=="employee"){
                $this->employeeId = 0;        /*员工id*/
            }elseif($type=="private"){
                $this->privateId  = 0;       /**私教人员id**/
            }else{
                $this->chargePersonId = 0;
            }
            return true;
        }
        $employeeModel = Employee::find()->where(['name'=>$person])->andWhere([	"venue_id"=>$this->venueId])->asArray()->one();
        if(empty($employeeModel)){
            $employee                   = new Employee();
            $employee->name             = $person;
            $employee->organization_id = $this->departId;
            $employee->company_id       = $this->organId;
            $employee->venue_id         = $this->venueId;
            $employee->create_id        =  0;
            $employee->created_at       = time();
            $employee->status           = 2;
            if(!$employee->save()){
                echo 'aaa';
                echo '...'.$this->memberNumber;
                var_dump($person);
                return $employee->errors;
            }
            if($type=="employee"){
                $this->employeeId = $employee->id;        /**销售人员id**/
            }elseif($type=="private"){
                $this->privateId  = $employee->id;       /**私教人员id**/
            }else{
                $this->chargePersonId = $employee->id;
            }
        }else{
            if($type=="employee"){
                $this->employeeId   = $employeeModel['id'];
            }elseif($type=="private"){
                $this->privateId    = $employeeModel['id'];;       /**私教人员id**/
            }else{
                $this->chargePersonId = $employeeModel['id'];
            }
        }
        return true;
    }
    //检查卡种是否存在
     public function cardCategoryId(){
         //先检查卡种类型是否存在
         $cardCategoryTypeData = CardCategoryType::find()->where(["type_name"=>"时间卡"])->asArray()->one();
         if(empty($cardCategoryTypeData)){
             $cardCategoryType = new CardCategoryType();
             $cardCategoryType->type_name = "时间卡";
             $cardCategoryType->create_at = time();
             $cardCategoryType->venue_id  = $this->venueId;
             $cardCategoryType->company_id = $this->organId;
             if(!$cardCategoryType->save()){
                 return $cardCategoryType->errors;
             }
             $this->cardCategoryTypeId  = $cardCategoryType->id;                      /*卡种类型id*/
         }else{
             $this->cardCategoryTypeId  = $cardCategoryTypeData["id"];               /*卡种类型id*/
         }
         //检查卡种是否存在
         $cardCategoryData = CardCategory::find()->where(["and",["card_name"=>"时间卡"],["category_type_id"=>$this->cardCategoryTypeId]])->asArray()->one();
         if(empty($cardCategoryData)){
             $model = new CardCategory();
             $model->category_type_id = $this->cardCategoryTypeId;
             $model->card_name         = "时间卡";
             $model->create_at         = time();
             $model->venue_id          = $this->venueId;
             $model->company_id        = $this->organId;
             $model->create_id         = 2;    //暂定后台管理员
             $model->deal_id           = 0;
             if(!$model->save()){
                 return $model->errors;
             }
             $this->cardCategoryId  = $model->id;
         }else{
             $this->cardCategoryId  = $cardCategoryData["id"];
         }
         return true;
     }
    //  检查是否存在指定部门和场馆
    public function getVenueId()
    {
        $data       = empty($this->companyName)?"我爱运动":$this->companyName;
        $organ      =  Organization::find()->where(['like','name',$data])->andWhere(['style'=>1])->asArray()->one();
        if(empty($organ)){
            $this->venueName = $data;
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
            $venue      =  Organization::find()->where(["and",['like','name',$this->venueType],['pid'=>$this->organId]])->asArray()->one();
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
                $department =  Organization::find()->where(['like','code','sijiao'])->andWhere(['pid'=>$this->venueId])->andWhere(['style'=>3])->asArray()->one();
                if(empty($department)){
                    $this->venueName  = '私教部';
                    $this->venueCode  = 'sijiao';
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
    public function getCourseId()
    {
        $course = Course::findOne(['name'=>'艾博遗留课程']);
        if(empty($course)){
            $courseModel = new Course();
            $courseModel->name = '艾博遗留课程';
            $courseModel->pid  = 0;
            $courseModel->category = '私教课';
            $courseModel->create_id = 2;
            $courseModel->path      = json_encode('0');
            $courseModel->class_type = 1;
            $courseModel->venue_id   = $this->venueId;
            $courseModel->company_id = $this->organId;
            $courseModel->save();
            $this->classKey  = $courseModel->id;
            $this->courseName = $courseModel->name;
            $this->classTime = 60;
        }else{
            $this->classKey  = $course->id;
            $this->courseName = $course->name;
            $this->classTime = 60;
        }

    }
    //增加新的场馆
    public function addVenue()
    {
        $venue = new Organization();
        $venue->name = $this->venueName;
        $venue->pid = $this->venuePid;
        $venue->created_at = time();
        $venue->create_id = 0;
        $venue->style = $this->venueStyle;
        $venue->code = $this->venueCode;
        if ($venue->save()) {
            return $venue;
        }else{
            return $venue->errors;
        }
    }
    public function setVenueData()
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
        $venueArr = ['大上海瑜伽健身馆','大学路舞蹈健身馆','帝湖瑜伽健身馆','丰庆路游泳健身馆','大学路瑜伽馆','尊爵汇','亚星游泳健身馆'];
        $arr      = ['大上海','大学路舞蹈','帝湖','丰庆路','大学路瑜伽','尊爵汇','亚星'];
        foreach ($venueArr as $k=>$value){
            $one = Organization::find()->where(['pid'=>$this->organId])->andWhere(['like','name',$arr[$k]])->asArray()->one();
            if(empty($one)){
                $venue = new Organization();
                $venue->name = $value;
                $venue->pid = $this->organId;
                $venue->created_at = time();
                $venue->create_id  = 2;
                $venue->style      = 2;
                $venue->code       = null;
                if (!$venue->save()) {
                    return $venue->errors;
                }
            }
        }
    }

    // 数据校验正确性代码
    public function getCheck(){
        $employeeNum = Employee::find()->asArray()->count();
        $consumeHistoryNum = ConsumptionHistory::find()->asArray()->count();
        $memCourseOrderNum = MemberCourseOrder::find()->asArray()->count();
        $memCardNum        = MemberCard::find()->asArray()->count();
        $memNum            = Member::find()->asArray()->count();
        $memDetail         = MemberDetails::find()->asArray()->count();
        $memCourseDetail   = MemberCourseOrderDetails::find()->asArray()->count();
        echo "员工数量";
        var_dump($employeeNum);
        echo "消费历史记录";
        var_dump($consumeHistoryNum);
        echo "会员课程消费订单";
        var_dump($memCourseOrderNum);
        echo "会员卡数量";
        var_dump($memCardNum);
        echo "会员数量";
        var_dump($memNum);
        echo "会员详情数量";
        var_dump($memDetail);
        echo "会员课程订单表";
        var_dump($memCourseDetail);
    }

    /**
     * @云运动 - 数据导入 - 导入会员手机号等信息
     * @author huangpengju <huangpengju@itsports>
     * @create 2017/5/24
     * @param $file  //表
     * @return bool|string
     * @throws \yii\db\Exception
     */
    public function memberInfoFile($file,$type)
    {
        $model = new Excel();
        $data  = $model->loadFileMember($file,'member');
        $this->setVenueData();
        $num = 0;
        foreach ($data as $k=>$v)
        {
            $this->loadMemberData($v);
            if(!$this->memberName && !$this->memberMobile){
                continue;
            }
            if(!$this->memberName){
                continue;
            }
            if(empty($this->memberName)){
                continue;
            }
            if(!$this->memberMobile){
                $this->memberMobile = '0';
            }
            $transaction = \Yii::$app->db->beginTransaction();
            $venueId = Organization::find()->where(['style'=>2])->andWhere(['like','name',$type])->select('id,pid')->asArray()->one();//获取场馆id
            try{
                //判断会员是否存在(根据姓名)
                $data = Member::find()->where(['username'=>$this->memberName])->andWhere(['venue_id'=>intval($venueId['id'])])->asArray()->one();
                $password = '123456';     //会员临时密码
                $password = \Yii::$app->security->generatePasswordHash($password);
                //会员不存在，则新增
                if(empty($data)) {
                    $memberModel = Member::find()->where(['username'=>$this->memberName])->andWhere(['venue_id'=>null])->one();
                    if(empty($memberModel)){
                        $model                = new Member();
                        $model->username      = $this->memberName;       //用户名
                        $model->password      = $password;               //密码
                        $model->mobile        = $this->memberMobile?"$this->memberMobile":'0';     //会员手机号
                        $model->register_time = $this->registerTime;//会员注册时间
                        $model->venue_id      = intval($venueId['id']);        //场馆id
                        $model->company_id    = intval($venueId['pid']);        //场馆id
                        if (!$model->save()) {
                            $error = $model->errors;
                            var_dump($error);die();
                            echo "member>>" . $this->memberName . "<br /><br />";
                            return $error;
                        }
                        $this->memberId = $model->id;
                    }else{
                        $memberModel->mobile        = "$this->memberMobile";
                        $memberModel->venue_id      = intval($venueId['id']);        //场馆id
                        $memberModel->company_id    = intval($venueId['pid']);        //场馆id
                        if (!$memberModel->save()) {
                            $error = $memberModel->errors;
                            var_dump($error);die();
                            echo "member>>" . $this->memberName . "<br /><br />";
                            return $error;
                        }
                        $this->memberId = $memberModel->id;
                    }
                }else {
                    //会员存在,判断手机号是否存在
                    if (isset($data['mobile']) && !empty($data['mobile']) && $data['mobile'] != 0 ) {
                        $detail = MemberDetails::find()->where(['member_id'=>$data['id']])->asArray()->one();
                        if(!empty($detail ) && $detail['id_card'] && ($detail['id_card'] == $this->idCard)){
                            //会员存在手机号不存在，或者等于 0的
                            $member = Member::findOne($data['id']);
                            $member->mobile        = "$this->memberMobile";
                            $member->venue_id      = intval($venueId['id']);        //场馆id
                            $member->company_id    = intval($venueId['pid']);        //场馆id
                            if(!$member->save())
                            {
                                $error = $member->errors;
                                echo "member>>" . $this->memberName . "<br /><br />";
                                return $error;
                            }
                            $this->memberId = $member->id;
                        }else{
                            if ($data['mobile'] != $this->memberMobile) {
                                $memberOne = Member::find()->where(['mobile'=>$this->memberMobile])->andWhere(['username'=>$this->memberName])->asArray()->one();
                                if(empty($memberOne)){
                                    //手机号存在(但是不相等)
                                    $model = new Member();
                                    $model->username = $this->memberName;       //用户名
                                    $model->password = $password;               //密码
                                    $model->mobile   = "$this->memberMobile";     //会员手机号
                                    $model->register_time = $this->registerTime;//会员注册时间
                                    $model->venue_id      = (int)$venueId['id'];        //场馆id
                                    $model->company_id    = intval($venueId['pid']);        //场馆id
                                    if (!$model->save()) {
                                        $error = $model->errors;
                                        echo "member>>" . $this->memberName . "<br /><br />";
                                        return $error;
                                    }
                                    $this->memberId = $model['id'];
                                }else{

                                    $this->memberId = $memberOne['id'];
                                }
                            }else{
                                $this->memberId = $data['id'];
                            }
                        }
                    }else{
                        $detail = MemberDetails::find()->where(['member_id'=>$data['id']])->asArray()->one();
                        if(!empty($detail ) && $detail['id_card'] && ($detail['id_card'] == $this->idCard)) {
                            //会员存在手机号不存在，或者等于 0的
                            $member = Member::findOne($data['id']);
                            $member->mobile = "$this->memberMobile";
                            $member->venue_id = (int)$venueId['id'];        //场馆id
                            $member->company_id    = intval($venueId['pid']);        //场馆id
                            if (!$member->save()) {
                                $error = $member->errors;
                                echo "member>>" . $this->memberName . "<br /><br />";
                                return $error;
                            }
                            $this->memberId = $member->id;
                        }else{
                            //会员存在手机号不存在，或者等于 0的
                            $member = Member::findOne($data['id']);
                            $member->mobile = "$this->memberMobile";
                            $member->venue_id = (int)$venueId['id'];        //场馆id
                            $member->company_id    = intval($venueId['pid']);        //场馆id
                            if (!$member->save()) {
                                $error = $member->errors;
                                echo "member>>" . $this->memberName . "<br /><br />";
                                return $error;
                            }
                            $this->memberId = $member->id;
                        }
                    }
                }
                //插入会员详细信息
                $detail = MemberDetails::find()->where(['member_id'=>$this->memberId])->asArray()->one();
                if(empty($detail))
                {
                    //会员详细信息不存在
                    $details = new MemberDetails();
                    $details->member_id = $this->memberId;       //会员id
                    $details->name      = $this->memberName;  //会员姓名
                    $details->sex       = 3;                    //性别保密
                    $details->id_card   = $this->idCard;        //会员身份证号
                    $details->family_address = $this->familyAddress;//会员地址
                    if(!$details->save())
                    {
                        $error = $details->errors;
                        echo "memberDetail>>".$this->memberName."<br /><br/>";
                        return $error;
                    }
                }else{
                    //会员详细信息存在
                    if(empty($detail['id_card']))
                    {
                        //会员身份证号不存在
                        $detailsInfo = MemberDetails::findOne([$detail['id']]);
                        $detailsInfo->id_card = $this->idCard;      //会员身份证号
                        if(!$detailsInfo->save())
                        {
                            $error = $detailsInfo->errors;
                            echo "memberDetail>>".$this->memberName."<br /><br/>";
                            return $error;
                        }
                    }
                }
                if($transaction->commit() !== null)                                                               //事务提交
                {
                    return false;
                }
            }catch (\Exception $e)
            {
                $transaction->rollBack();       //回滚
                return $e->getMessage();
            }
            $num++;
            echo $num;
        }
        return true;
    }

    /**
     * 数据 - 业务后台 - 会员信息 - 处理
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/23
     * @param $data
     */
    public function loadMemberData($data)
    {
        if(isset($data) && !empty($data) && is_array($data)){
            foreach($data as $k=>$v){
                $params = self::INFO;
                if($k <2){
                    $key = $params[$k];
                    $this->$key = $v;
//                    var_dump($this->$key);
                }else if($k == 4){
                    $key = $params[$k];
                    $this->$key = $v;
//                    var_dump($this->$key);
                }else if(6 < $k && $k < 10){
                    $key = $params[$k];
                    $this->$key = $v;
//                    var_dump($this->$key);
                }
            }
        }
    }
    /**
     * 数据 - 业务后台 - 会员卡转让 - 处理
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/21
     * @param $file //导入文件
     * @param $type //导入类型 transfer //转让记录
     * @param $venueName //场馆名称
     */
    public function setMemberCardTransfer($file,$type = 'transfer',$venueName = '大上海')
    {
        $model = new Excel();
        $data  = $model->loadFileTransfer($file,$type);             //excel表数据
        $this->venueName  = $venueName;
        $this->getVenueId();                                        //获取场馆id
        $this->setVenueData();                                      //设置场馆
        foreach($data as $k=>$v)
        {
            unset($v[2],$v[3],$v[5],$v[6],$v[7],$v[9],$v[17]);      //删除为空字段
            if(!$this->departId){
                echo "venue>>".'场馆不存在'."<br /><br />";
            }
            $this->getTransferInfo($v);                             //调用数据存放方法
        }
    }

    /**
     * 数据 - 业务后台 - 会员卡转让 - 处理
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/20
     * @param $v  //导入的数据
     * @return bool
     */
    public function getTransferInfo($v)
    {
        if(isset($v) && !empty($v) && is_array($v))
        {
            $spare      = [];
            foreach($v as $k=>$val) {
                if ($k <= 29) {
                    $params = self::TRANSFER;
                    $key = $params[$k];
                    $this->$key = $val;
                } else {
                    $params = self::TRANSFER;
                    $key = $params[30];
                    array_push($spare, $val);           //把备用放到数组中
                    $this->$key = $spare;
                }

            }
            $transaction                  = \Yii::$app->db->beginTransaction();
            try{
                /***查询原会员是否存在***/
                $firstMember = $this->getMemberExist($v[13],$v['15']);                        //查询原会员是否存在
                if(!$firstMember && empty($firstMember))
                {
                    //老会员为空走这里（转卡人）
                    $first = $this->setMemberInfo('first');                                      //主要用生成的会员id
                    echo "first>>".$first."<br /><br />";
                }else{
                    $this->firstMemberId = $firstMember['id'];                                  //原会员id
                    $details = $this->getMemberDetailsExist($this->firstMemberId);              //查询会员详情是否存在
                    if(!$details && empty($details)){
                        $firstDetail = $this->setMemberDetails('first');                        //生成会员详情
                        echo "firstDetail.2>>".$firstDetail."<br /><br />";
                    }
                }
                /***查询现持卡会员是否存在***/
                $nowMember   = $this->getMemberExist($v[8],$v[11]);                             //查询现会员是否存在
                if(!$nowMember && empty($nowMember))
                {
                    //新会员为空走这里(被转卡人)
                    $now = $this->setMemberInfo('now');                                         //主要用生成的会员id
                    echo "now>>".$now."<br /><br />";
                }else{
                    $this->memberId = $nowMember['id'];                                         //现会员id
                    $details = $this->getMemberDetailsExist($this->memberId);                  //查询会员详情是否存在
                    if(!$details && empty($details)){
                        $nowDetails = $this->setMemberDetails('now');                           //生成会员详情
                        echo "nowDetail.2>>".$nowDetails."<br /><br />";
                    }
                }
                /***查询会员卡是否存在***/
                $memberCard = $this->getMemberCardExist($v[4]);                                 //查询会员卡存不存在
                if(!$memberCard && empty($memberCard))
                {
                    //会员卡不存在 走这里
                    $memberCard = $this->setMemberCardInfo($this->memberId,$v[4]);              //用会员卡id(返回的id)
                    echo "memberCard>>".$memberCard."<br /><br />";                             //报错信息
                }else{
                    //用会员卡id $memberCard['id']
                    $this->memberCardId = $memberCard['id'];                                     //会员卡id
                }
//                /***查询转让记录是否存在***/
                $data = $this->getTransferRecord();                                              //查询转让记录是否存在
                if(!$data && empty($data))
                {
                    $transfer = $this->setTransferRecord();                                                  //生成转让记录
                    echo "transfer>>".$transfer."<br /><br />";
                }
                if($transaction->commit() !== null)                                                               //事务提交
                {
                    return false;
                }
            }catch (\Exception $e)
            {
                $transaction->rollBack();       //回滚
                return $e->getMessage();
            }
        }
    }

    /**
     *  数据 - 业务后台 - 会员卡转让 - 查询会员转让记录是否存在
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/21
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getTransferRecord()
    {
        return TransferRecord::find()
            ->where(['member_card_id'=>$this->memberCardId])
            ->andWhere(['to_member_id'=>$this->memberId])
            ->andWhere(['from_member_id'=>$this->firstMemberId])
            ->asArray()
            ->one();
    }
    /**
     * 数据 - 业务后台 - 会员卡转让 - 查询会员是否存在
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/20
     * @param $name         //会员姓名
     * @param $mobile       //会员手机号
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getMemberExist($name,$mobile)
    {
        return Member::find()->where(['username'=>$name])->andFilterWhere(['mobile'=>$mobile])->asArray()->one();
    }

    /**
     * 数据 - 业务后台 - 会员卡转让 - 查询会员详情是否存在
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/20
     * @param $memberId
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getMemberDetailsExist($memberId)
    {
        return MemberDetails::find()->where(['member_id'=>$memberId])->asArray()->one();
    }
    /**
     * 数据 - 业务后台 - 会员卡转让 - 添加会员基本信息
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/20
     * @param $type   //区分是新会员，还是被转让会员
     * @return array|bool|Member|string
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function setMemberInfo($type)
    {
        $password = '123456';     //会员临时密码
        $password = \Yii::$app->security->generatePasswordHash($password);
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $member = new Member();
            if($type == 'first'){
                $member->username  = $this->firstName;            //用户名(原卡会员)
                $member->mobile    = !empty($this->firstMobile)?$this->firstMobile:'0';          //手机号
            }else if ($type == 'now')
            {
                $member->username  = $this->memberName;          //用户名（现卡会员）
                $member->mobile    = !empty($this->mobile)?$this->mobile:'0';              //手机号
            }
            $member->password      = $password;                  //密码
            $member->register_time = $this->transferTime;        //注册时间(暂存转让时间)
            $member->update_at     = time();                     //修改时间(当前时间)
            $member->venue_id      = $this->venueId;             //场馆id
            $member->company_id    = $this->organId;             //公司id
            $member = $member->save()?$member:$member->errors;
            if($member->id)
            {
                if($type == 'first')
                {
                    $this->firstMemberId = $member->id;             //原会员
                }else if($type == 'now')
                {
                    $this->memberId = $member->id;                  //现会员
                }
            }else{
                return $member;
            }
            $detail         = $this->setMemberDetails($type);      //添加会员详细信息
            if($detail !== true)
            {
                return $detail;
            }
            if($transaction->commit() !== null)                                                               //事务提交
            {
                return false;
            }
        }catch (\Exception $e)
        {
            $transaction->rollBack();       //回滚
            return $e->getMessage();
        }
    }

    /**
     * 数据 - 业务后台 - 会员卡转让 - 添加会员详细信息
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/20
     * @param $type       //区分是新会员，还是被转让会员
     * @return array|bool
     */
    public function setMemberDetails($type)
    {
        $detail            = new MemberDetails();
        if($type == 'first')
        {
            $detail->member_id = $this->firstMemberId;  //原会员id
            $detail->name = $this->firstName;           //原会员名
            $detail->sex  = (empty($this->firstSex))?0:(($this->firstSex == '男')?1:2);//原会员性别
        }else if($type = 'now'){
            $detail->member_id = $this->memberId;       //现会员id
            $detail->name = $this->memberName;          //现会员名
            $detail->sex  = (empty($this->memberSex))?0:(($this->memberSex == '男')?1:2);//现会员性别
        }
        $detail->created_at = $this->transferTime;      //创建时间(暂存转让时间)
        $detail->updated_at = time();                   //修改时间(当前时间)
        if($detail->save())
        {
            return true;
        }else{
            return $detail->errors;
        }
    }

    /**
     * 数据 - 业务后台 - 会员卡转让 - 查询会员卡是否存在
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/20
     * @param $cardNumber         //会员卡 卡号
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getMemberCardExist($cardNumber)
    {
        return MemberCard::find()->where(['card_number'=>$cardNumber])->asArray()->one();   //查询会员卡是否存在
    }

    /**
     * 数据 - 业务后台 - 会员卡转让 - 会员卡信息生成
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/20
     * @param $memberId   //会员id
     * @param $cardNumber //会员卡号
     * @return array|bool
     */
    public function setMemberCardInfo($memberId,$cardNumber)
    {
        $memberCard                 = new MemberCard();
        $memberCard->card_number    = $cardNumber;             //会员卡号
        $memberCard->create_at      = $this->transferTime;      //开卡时间(暂存转让时间)
        $memberCard->amount_money   = 0;                       //金额
        $memberCard->status         = 1;                        //状态
        $memberCard->active_time    = $this->transferTime;      //激活时间(暂存转让时
        $memberCard->payment_type   = 1;                        //付款类型
        $memberCard->is_complete_pay= 1;                        //是否完成付款
        $memberCard->invalid_time   = $this->transferTime;      //失效时间(暂存转让时
        $memberCard->level          = 0;                        //等级
        $memberCard->card_category_id=0;                        //卡种id
        $memberCard->member_id       = $memberId;               //会员id
        $memberCard->company_id      = $this->organId;          //公司id
        $memberCard->venue_id        = $this->venueId;          //场馆id
        $memberCard = $memberCard->save()?$memberCard:$memberCard->errors;
        if(!$memberCard->id)
        {
            return $memberCard->errors;
        }else{
            $this->memberCardId = $memberCard->id;
        }
    }

    /**
     * 数据 - 业务后台 - 会员卡转让 - 会员卡转让记录生成
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/20
     * @return bool
     */
    public function setTransferRecord()
    {
        $transaction                  = \Yii::$app->db->beginTransaction();
        try {
            $model                    = new TransferRecord();
            $model->member_card_id    = $this->memberCardId;       //会员卡id
            $model->to_member_id      = $this->memberId;           //现会员id
            $model->from_member_id    = $this->firstMemberId;      //原会员id
            $model->transfer_time     = $this->transferTime;       //转让时间
            $model->path              = json_encode([$this->firstName . '转给' . $this->memberName]); //卡的转让经历
            $model->transfer_price    = $this->transferPrice;      //手续费
            $model->register_person   = $this->registerPerson;     //登记人
            $model->note              = $this->note;               //转让备注
            $model->cashier_number    = (String)$this->cashierNumber; //收银单号
            $model->cashier           = $this->cashier;            //收银员
            $model->cash_payment      = $this->cashPayment;       //现金支付
            $model->bank_card_payment = $this->bankCardPayment;   //银行卡支付
            $model->network_payment   = $this->networkPayment;    //网络支付
            $model->member_card       = $this->memberCardPayment; //会员卡支付
            $model->discount          = $this->discount;          //折扣
            $model->coupon            = $this->coupon;            //优惠卷
            $model->transfer          = $this->transfer;          //转账
            $model->other             = $this->other;             //其他
            $model->integral          = $this->integral;          //积分
            $model->spare             = json_encode($this->spare);//备用
            $model = $model->save() ? $model : $model->errors;
            if(!$model->id) {
                return $model;
            }
            $data = $this->getConsumptionHistory();                             //查询消费记录是否存在
            if(!$data && empty($data))
            {
                $data = $this->setConsumptionHistory($model->id);               //生成消费记录
                if($data != true)
                {
                    return $data;
                }
            }
            if($transaction->commit() !== null)                    //事务提交
            {
                return false;
            }
        }catch (\Exception $e){
            $transaction->rollBack();       //回滚
            return $e->getMessage();
        }
    }

    /**
     * 数据 - 业务后台 - 会员卡转让 - 查询会员卡转让生成消费记录是否存在
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/20
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getConsumptionHistory()
    {
        return ConsumptionHistory::find()
            ->where(['member_id'=>$this->memberId])
            ->andWhere(['consumption_type'=>'转卡'])
            ->andWhere(['consumption_time'=>$this->transferTime])
            ->asArray()
            ->one();
    }
    /**
     * 数据 - 业务后台 - 会员卡转让 - 会员卡转让生成消费记录
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/20
     * @param $transferId  //转让记录表id
     * @return bool
     */
    public function setConsumptionHistory($transferId)
    {
        $history                        = new ConsumptionHistory();
        $history->member_id             =  $this->memberId; //会员id
        $history->consumption_type      = '转卡';           //消费类型
        $history->consumption_type_id   = $transferId;      //消费项目id(转让记录表id)
        $history->consumption_date      = intval($this->transferTime);//消费日期
        $history->consumption_time      = $this->transferTime;//消费时间
        $history->consumption_times     = 1;                  //消费次数
        $history->cashier_order         = (String)$this->cashierNumber;      //收银单号
        $history->cash_payment          = $this->cashPayment;       //现金支付
        $history->bank_card_payment     = $this->bankCardPayment;   //银行卡支付
        $history->mem_card_payment      = $this->memberCardPayment; //会员卡支付
        $history->coupon_payment        = $this->coupon;            //优惠卷
        $history->transfer_accounts     = $this->transfer;          //转账
        $history->other_payment         = $this->other;             //其他
        $history->network_payment       = $this->networkPayment;    //网络支付
        $history->integration_payment   = $this->integral;          //积分
        $history->venue_id              = $this->venueId;           //场馆id
        $history->seller_id             = 0;                        //销售人id
        $history->describe              = json_encode($this->note);//转让备注
        $history->category              = '转卡';
        $history->company_id            = $this->organId;           //公司id
        $history->consumption_amount    = $this->transferPrice;     //手续费
        $history = $history->save()?$history:$history->errors;
        if($history->id)
        {
            return true;
        }else{
            return $history->errors;
        }
    }
}