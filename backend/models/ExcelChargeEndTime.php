<?php
namespace backend\models;
use common\models\base\ConsumptionHistory;
use common\models\base\MemberCourseOrder;
use common\models\base\MemberCourseOrderDetails;
use common\models\base\ChargeClass;
use common\models\Excel;
use yii\base\Model;
class ExcelChargeEndTime extends Model
{
    const PARAM = ["memCard","memName","sex","paymentDate","privateTeacherName",
                    "activeTime","invalidTime",'totalTimes','remainTimes','giveClass',
                    'lessonRemain',"classHoursPrice","amountMoney","memberAdviser",
                    "mobilePhone","fixPhone"];
    public $memCard;    // 会员卡号
    public $memName;    // 会员姓名
    public $sex;         //性别
    public $paymentDate; // 缴费日期
    public $privateTeacherName;  // 私教姓名
    public $activeTime;   // 私教开始时间
    public $invalidTime;   // 私教截止时间

    public $totalTimes;   //购买次数
    public $remainTimes;  // 剩余次数、
    public $giveClass;    // 赠送次数
    public $lessonRemain; //免费剩余次数
    public $classHoursPrice;// 课时费

    public $amountMoney;      // 课程金额
    public $memberAdviser;    // 会籍顾问
    public $mobilePhone;      // 移动电话
    public $fixPhone;          // 固定电话

    public $productId;         // 产品id
    public $memCourseOrderId; // 会员课程订单id
    public $venueId;
    public $organId;
    public $courseId;
    public $courseName;
    public $employeeId;
    public $sellerId;
    public $chargeType;
    public $productName;
    public $memberCardId;
    public function loadData($val){
         $data = array_values($val);
         $param = self::PARAM;
         foreach($data as $key=>$value){
              $keys = $param[$key];
              $this->$keys = $value;
         }
    }
    public function getCourseId()
    {
        if(intval($this->giveClass) > 0 && intval($this->totalTimes) == 0){
            $name = 'HS课程';
            $this->productName = 'HS综合产品';
            $this->chargeType = 2;
        }else{
            $name = 'PT课程';
            $this->productName = 'PT综合产品';
            $this->chargeType = 1;
        }
        $course = Course::findOne(['name'=>$name]);
        if(empty($course)){
            $courseModel = new Course();
            $courseModel->name       = $name;
            $courseModel->pid      = 0;
            $courseModel->category = '私教课';
            $courseModel->create_id = 2;
            $courseModel->path      = json_encode('0');
            $courseModel->class_type = 1;
            $courseModel->venue_id   = $this->venueId;
            $courseModel->company_id = $this->organId;
            $courseModel->save();
            $this->courseId   = $courseModel->id;
            $this->courseName = $courseModel->name;
        }else{
            $this->courseId   = $course->id;
            $this->courseName = $course->name;
        }

    }
    public function getEndTimeData($data,$type,$name){
        //检查场馆是否存在
        // 公司id  $check->organId  场馆id $check->venueId 部门id $check->$departId
        $check = new ExcelCharge();
        //搜索默认场馆
        $check->venueType = $type;
        $check->venueNameTwo = $name;
        $check->getVenueId();
        $this->venueId = $check->venueId;
        $this->organId = $check->organId;
        //数据导入前 数据检查
        if(!$check->departId){
            echo "venue>>".'场馆不存在'."<br /><br />";
        }
        //检查默认的卡种id是否存在
        // 卡类型id $check->cardCategoryTypeId  //卡种id   $check->cardCategoryId
//        $check->cardCategoryId();
//        if(!$check->cardCategoryId){
//            echo "cardCategoryId>>".'默认卡种id不存在'."<br /><br />";
//        }
        //检查默认产品是否存在 不存在话 生成默认产品
        // 获取产品id $check->productId
        $this->createProduct();
        $num = 0;
        foreach($data as $keys=>$values){
              // 数据属性赋值
            $this->loadData($values);
            $this->getCourseId();
            $memberCard = MemberCard::find()->where(['card_number'=>$this->memCard])->asArray()->one();
            if(empty($memberCard)){
                continue;
            }
            $num++;
            echo $num;
            /**员工数据插入，并且获取Id（会籍顾问）-- 数据录入**/
            /**--获取员工id（$check->employeeId）--**/
            $insertResult1 = $check->insertEmployeeData($this->memberAdviser,"employee");
            if($insertResult1 !== true){
                return $insertResult1;
            }
            $this->employeeId = $check->employeeId;
            /**私教数据插入，并且获取Id（私教id）-- 数据录入**/
            /**--获取私教id（$check->privateId）--**/
            $insertResult2 = $check->insertEmployeeData($this->privateTeacherName,"private");
            if($insertResult2 !== true){
                return $insertResult2;
            }
            $this->sellerId = $check->privateId;
//            // 会员数据导入，并且获取会员id
//            /**--获取会员id（$nowModel->memberId） -**/
//            $nowModel = new CabinetExcel();
//            $nowModel->memberCardNum = $this->memCard;   // 会员卡号赋值
//            $nowModel->memberName    =  $this->memName;   // 会员姓名赋值
//            $nowModel->fixPhone      = $this->fixPhone;   //固定电话赋值
//            $nowModel->mobile        = $this->mobilePhone; // 移动电话赋值
//            $insertResult3 = $nowModel->checkMember($check->organId,$check->venueId,$check->employeeId);
//            if($insertResult3 !== true){
//                return $insertResult3;
//            }

            //会员详情表数据导入，
//            $nowModel->sex           = $this->sex;           // 性别
//            $insertResult4 = $nowModel->checkMemberDetail();
//            if($insertResult3 !== true){
//                return $insertResult4;
//            }

            /**检查会员卡号是否存在，不存在添加，并获取卡号id**/
            // 会员卡id   $nowModel->memberCardId

            // 数据 初始化 赋值
//            $nowModel->theMemCardName  = "时间卡";
//            $nowModel->rentEndTime      = $this->invalidTime;
//            $nowModel->activeTime       = $this->activeTime;
//            $nowModel->createCardDate  = $this->activeTime;   // 开卡时间 默认 激活时间
//            $insertResult5 = $nowModel->checkMemberCard($check->cardCategoryId,$check->organId,$check->venueId);
//            if($insertResult5 !== "success"){
//                return $insertResult5;
//            }
            /**会员课程订单表的数据录**/
            $insertResult6 = $this->memCourseOrder($check->privateId,$memberCard['id'],$memberCard['member_id']);
            // 检查是否有这样的课程订单，有的话 直接跳出来
            if($insertResult6 === "endSuccess"){
                $courseModel = MemberCourseOrder::findOne(['id'=>$this->memCourseOrderId]);
                if($courseModel['overage_section'] > $this->remainTimes){
                    $courseModel->overage_section = $this->remainTimes;
                    $courseModel->save();
                }
                $model = MemberCourseOrderDetails::findOne(["course_order_id"=>$this->memCourseOrderId]);
                if($model['course_num'] > $this->remainTimes){
                    $model->course_num = $this->remainTimes;
                    $model->save();
                }
                continue;
            }
            // 没有检查出来课程订单，有报错，显示报错
            if($insertResult6 !== true){
                return $insertResult6;
            }

            /**会员上详情课统计表**/
            $insertResult7 = $this->memCourseOrderDetail();
            if($insertResult7!==true){
                return $insertResult7;
            }
            /**会员历史数据统计表数据录入**/
            $insertResult8 = $this->consumeHistory($memberCard['member_id'],$check->organId,$check->venueId);
            if($insertResult8!==true){
                return  $insertResult8;
            }
        }
        return true;
    }

    //会员课程订单统计表
      public function memCourseOrder($privateId,$memCardId,$memberId){
          // 过滤筛选判断
          $modelData = MemberCourseOrder::find()->where(["and", ["member_id"=>$memberId], ["deadline_time"=>$this->invalidTime], ['course_amount'=>intval($this->totalTimes)]])->one();

          if(!empty($modelData)){
              $this->memCourseOrderId =$modelData->id;
              return "endSuccess";
          }
          // 备注：目前 导入数据之前 只能 直接插入 没有可以供提前查询的标志
          if(empty($modelData)){
              $model = new MemberCourseOrder();
              $model->course_amount   = $this->totalTimes;  // 购买次数
              $model->create_at       = $this->paymentDate;
              $model->money_amount    = $this->amountMoney;  //总金额
              $model->overage_section = $this->remainTimes;
              $model->deadline_time   = $this->invalidTime;
              $model->activeTime      = $this->activeTime;
              $model->product_id      = !empty($this->productId)?$this->productId:null;
              $model->product_type    = 1;
              $model->private_id      = !empty($privateId)?$privateId:0;
              $model->seller_id       = !empty($privateId)?$privateId:0;
              $model->present_course_number = $this->giveClass;
              $model->surplus_course_number = $this->lessonRemain;
              $model->member_card_id    = $memCardId;
              $model->member_id         = $memberId;
              $model->type              = $this->chargeType;
              $model->course_type       = $this->chargeType;
              $model->product_name      = $this->productName;
              if(!$model->save()){
                  return $model->errors;
              }
              $this->memCourseOrderId =  $model->id;
          }
          return true;
      }
    // 会员课程订单详情表统计
    public function memCourseOrderDetail(){
             $model = MemberCourseOrderDetails::findOne(["course_order_id"=>$this->memCourseOrderId]);
             if(empty($model)){
                 $thisModel = new MemberCourseOrderDetails();
                 $thisModel->course_order_id = $this->memCourseOrderId;
                 $thisModel->course_id       = $this->courseId;
                 $thisModel->course_length   = intval(($this->invalidTime - time())/(60*60*24));
                 $thisModel->course_num      = $this->remainTimes;
                 $thisModel->course_name     = $this->courseName;
                 $thisModel->category        = 1;
                 $thisModel->original_price  = $this->classHoursPrice;
                 $thisModel->sale_price      = $this->classHoursPrice;
                 $thisModel->pos_price       = $this->classHoursPrice;
                 $thisModel->type            = 1;
                 $thisModel->class_length    = 60;
                 $thisModel->product_name    = $this->productName;
                 if(!$thisModel->save()){
                     return $thisModel->errors;
                 }
             }
             return true;
    }
    // 历史消费统计表
    public function  consumeHistory($memberId,$companyId,$venueId){
         // 判重
          $modelData =ConsumptionHistory::findOne(["consumption_type_id"=>$this->memCourseOrderId]);
          if(!empty($modelData)){
               return true;
          }
          $model = new ConsumptionHistory();
          $model->	member_id = $memberId;
          $model->consumption_type = "charge";
          $model->consumption_type_id =  $this->memCourseOrderId;
          $model->consumption_date     = $this->paymentDate;
          $model->consumption_time     = $this->paymentDate;
          $model->type                   = 1;    // 消费方式：现金
          $model->company_id            = $companyId;
          $model->venue_id              = $venueId;
          $model->consumption_amount   = abs($this->amountMoney);
          $model->consume_describe     = json_encode("私教课-到期清单");
          if(!$model->save()){
              return $model->errors;
          }
          return true;
    }

    // 对应生成默认的产品
    public function createProduct(){
        // 查询是否有对应产品
        $this->getCourseId();
        $data = ChargeClass::find()->where(["name"=>$this->productName])->asArray()->one();
        if(empty($data)){
            $model = new ChargeClass();
            $model->name = $this->productName;
            $model->create_id  = 2;
            $model->created_at = time();
            $model->category   = 1;
            $model->venue_id   = $this->venueId;  // 场馆id
            $model->company_id = $this->organId;  // 公司id
            $model->status     = 1;
            $model->valid_time = 3000000000;
            $model->activated_time = 30;
            $model->type        = 2;
            $model->course_type = $this->chargeType;
            if(!$model->save()){
                return $model->errors;
            }
            $this->productId = $model->id;  //生成 私教产品id
            // 课程详情表数据录入
            $chargeClassDetail = $this->chargeClassDetail();
            if($chargeClassDetail !== true ){
                return $chargeClassDetail;
            }
        }else{
            $this->productId = $data["id"];  //生成 私教产品id
        }
        return true;
    }
    // 课程详情表 数据录入
    public function chargeClassDetail()
    {
        $courseDetail                   = new CoursePackageDetail();
        $courseDetail->charge_class_id  = $this->productId;                      //收费课程表id
        $courseDetail->course_id        = $this->courseId;                      //课种id
        $courseDetail->course_length    = 60;                     //时长
        $courseDetail->original_price   = 50;                      //单节原价
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

}