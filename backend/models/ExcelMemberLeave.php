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
use common\models\Excel;
use yii\base\Model;
class ExcelMemberLeave extends Model
{
    const PARAM = ["type","memberCardNum","memberName","sex","adviserName",
                   "registerTime","leaveStartTime","leaveEndTime","cardCategory","hadLeaveTimes","hadLeaveDays","createCardDate"];
    public $type;  //请假类型
    public $memberCardNum; //会员卡
    public $memberName;  //会员姓名
    public $sex;   //性别
    public $adviserName;  // 会籍顾问
    public $registerTime;  //登记时间
    public $leaveStartTime; //请假开始日期
    public $leaveEndTime;   //请假结束日期
    public $cardCategory;    //卡种
    public $createCardDate;  // 办卡日期
    public $hadLeaveTimes;   // 已请假次数
    public $hadLeaveDays;    // 已请假天数

    public $venueType;      // 场馆名称
    public $venueNameTwo;   // 部门名称
    public function autoLoad($data){
          $data = array_values($data);
          foreach($data as $keys=>$values){
              $key = self::PARAM[$keys];
              $this->$key = $values;
          }
    }
    /**
     * 云运动 -  会员请假表数据导入
     * @param $path  // 文件路径
     * @param $venue  // 场馆名称
     * @param $name   // 部门名称
     * @author houkaixin<houkaixin@sports.club>
     * @create 2017/4/24
     * @return  boolean
     */
   public function loadMemberLeave($path,$venue = '大上海',$name){
       $model = new Excel();
       //检查场馆是否存在
       // 公司id  $check->organId  场馆id $check->venueId 部门id $check->$departId
       $check = new ExcelCharge();
       $check->venueType    = $venue;
       $check->venueNameTwo = $name;
       $check->getVenueId();
       //数据导入前 数据检查
       if(!$check->departId){
           echo "venue>>".'场馆不存在'."<br /><br />";
       }
       /**检查默认卡种id是否存在**/
       // 卡种id  $check->cardCategoryId  卡类型id $check->cardCategoryTypeId;
       $check->cardCategoryId();
       if(!$check->cardCategoryId){
           echo "cardCategoryId>>".'默认卡种id不存在'."<br /><br />";
       }
       $data = $model->loadMemberLeaveRecord($path);
         foreach($data as $keys=>$values){
             // 条件判断  当 卡号和姓名都为空的时候 停止循环（文件最后端）
             if(empty($values[2])&&empty($values[7])){
                   break;
             }
             $this->autoLoad($values);
             /**员工表数据插入，并且获取Id（销售人员）-- 数据录入**/
             /**--获取员工id（$check->employeeId）--**/
             $insertResult1 = $check->insertEmployeeData($this->adviserName,"employee");
             if($insertResult1 !== true){
                 echo 1;
                 print_r($insertResult1);
                 return $insertResult1;
             }
             // 初始化 下面方法需要的模型数据
             $memberModel = new CabinetExcel();
             $this->initMemberData($memberModel);

             // 会员数据导入，并且获取会员id
             /**--获取会员id（$memberModel->memberId） -**/
             $insertResult2  = $memberModel->checkMember($check->organId,$check->venueId,$check->employeeId);
             if($insertResult2 !== true){
                 echo 2;
                 print_r($insertResult2);
                 return $insertResult2;
             }

             //会员详情表数据导入
             $insertResult3 = $memberModel->checkMemberDetail();
             if($insertResult3 !== true){
                 echo 3;
                 print_r($insertResult3);
                 return $insertResult3;
             }

             /**检查会员卡号是否存在，不存在添加，并获取卡号id**/
             // 获取卡id   $memberModel->memberCardId
             $memberModel->createCardDate = $this->createCardDate;  // 开卡 时间设置
             $insertResult4 =$memberModel->checkMemberCard($check->cardCategoryId,$check->organId,$check->venueId);
             if($insertResult4 !== "success"){
                 echo 4;
                 print_r($insertResult4);
                 return $insertResult4;
             }
             /** 请假表数据录入**/
             $insertResult5 = $this->memberLeaveRecord($memberModel);
             if($insertResult5!=="success"){
                 echo 5;
                 print_r($insertResult5);
                 return $insertResult5;
             }
         }
         return true;
   }

   // 会员数据录入 前初始化模型数据
    public function initMemberData($memberModel){
          $memberModel->memberCardNum   = $this->memberCardNum;
          $memberModel->memberName      = $this->memberName;
          $memberModel->theMemCardName  = $this->cardCategory;
    }

    // 会员请假表数据录入
    public function memberLeaveRecord($memberModel){
          $model = new LeaveRecord();
          $model->leave_employee_id = $memberModel->memberId;
          $model->create_at          = $this->registerTime;
          $model->leave_start_time  = $this->leaveStartTime;
          $model->leave_end_time    = !empty($this->leaveEndTime)?$this->leaveEndTime:null;
          $model->member_card_id    = $memberModel->memberCardId;
          if(empty($this->leaveEndTime)||$this->leaveEndTime>time()){
              $model->status   = 1;
          }else{
              $model->status = 2;
          }
         if(!$model->save()){
             return $model->errors;
         }
         return "success";
    }


    // 爱博请假 会员参数说明
    const AiBoPARAM = ["store","memberCardNum","memberName","memberPhone","cardName",
        "createCardDate","cardEndDate","leaveStartTime","leaveEndTime","leaveTotalDay",
        "leaveStatus","operateStore","operatePerson","operatePersonStore","operateTime","remarks"];
    public $store;   // 门店
    // public $memberCardNum;   //会员卡号
    // public $memberName;     //会员姓名
    public $memberPhone;    // 会员电话
    public $cardName;       //卡名
    //public $createCardDate;  // 开卡日期
    public $cardEndDate;   //卡到期时间
    // public $leaveStartTime;  //请假开始时间
    // public  $leaveEndTime;   //请假结束时间
    public $leaveTotalDay;  // 请假总天数
    public $leaveStatus;    // 请假状态
    public $operateStore;   // 操作门店
    public $operatePerson;  //操作人
    public $operatePersonStore;  // 操作人门店
    public $operateTime;    // 操作时间
    public $remarks;         // 备注
    public function autoAiBoLoad($data){
        foreach($data as $keys=>$values){
            $key    = self::AiBoPARAM[$keys];
            $values = $keys==5||$keys==6||$keys==7||$keys==8||$keys==14?abs($data[$keys]):$data[$keys];
            $this->$key = $values;
        }
    }

    // 爱博 会员请假挂起（初始化参数）
    const AiBoHangUpPARAM = ["store","memberCardNum","memberName","memberPhone","registerTime",
        "operateStore","operatePerson","operatePersonStore","hangUpType","leaveStartTime","leaveEndTime","leaveTotalDay",
        "leaveStatus","operateTime","remarks"];

  //   public $registerTime;   注册时间（已存在）
  //   public $operatePersonStore; 操作人门店
       public $hangUpType;     // 挂起类型

    public function autoAiBoHangUp($data){
        foreach($data as $keys=>$values){
            $key    = self::AiBoHangUpPARAM[$keys];
            $this->$key = $values;
        }
    }

    /**
     * 云运动 -  爱博会员请假表数据导入
     * @param $path  // 文件路径
     * @param $venue  // 场馆名称
     * @param $name   // 部门名称
     * @param $status // 上传标志
     * @author houkaixin<houkaixin@sports.club>
     * @create 2017/7/3
     * @return  boolean
     */
    public function loadAiBoMemberLeave($path,$venue,$name,$status=null){
        $data  = [];      // 初始化模型数据
        $model = new Excel();
        // 标志为空：调用请假表数据
        if(empty($status)){
            $data = $model->loadAiBoMemberLeaveRecord($path);
        }else{
            $data = $model->loadAiBoMemberHangUp($path);
        }
        //检查场馆是否存在
        // 公司id  $check->organId  场馆id $check->venueId 部门id $check->$departId
        $check = new ExcelCharge();
        $check->venueType    = $venue;
        $check->venueNameTwo = $name;
        $check->companyName  = "郑州市艾搏健身服务有限公司";
        $check->getVenueId();
        //数据导入前 数据检查
        if(!$check->departId){
            echo "venue>>".'场馆不存在'."<br /><br />";
        }
        /**检查默认卡种id是否存在**/
        // 卡种id  $check->cardCategoryId  卡类型id $check->cardCategoryTypeId;
        $check->cardCategoryId();
        foreach($data as $keys=>$value){
            if(empty($status)){
                $this->autoAiBoLoad($value);
            }else{
                $this->autoAiBoHangUp($value);
            }
            // 停止循环判断
            if(!empty($this->store)&&$this->store!=="艾搏健身万达店"){
                break;
            }
            // 1. 操作人
            /**员工表数据插入，并且获取Id（销售人员）-- 数据录入**/
            /**--获取操作人id（$check->employeeId）--**/
            $insertResult1 = $check->insertEmployeeData($this->operatePerson,"employee");
            if($insertResult1 !== true){
                return $insertResult1;
            }
            //2. 会员数据录入
            // 初始化 下面方法需要的模型数据
            $memberModel = new CabinetExcel();
            $memberModel->memberCardNum   = $this->memberCardNum;
            $memberModel->theMemCardName   = $this->cardName;
            $memberModel->mobile            = $this->memberPhone;
            // 会员数据导入，并且获取会员id
            /**--获取会员id（$memberModel->memberId） -**/
            $insertResult2  = $memberModel->checkMember($check->organId,$check->venueId,$check->employeeId);
            if($insertResult2 !== true){
                return $insertResult2;
            }
            // 3.会员详情表导入数据(初始化会员名字)
            $memberModel->memberName  = $this->memberName;
            $insertResult3 = $memberModel->checkMemberDetail();
            if($insertResult3 !== true){
                return $insertResult3;
            }
            /**检查会员卡号是否存在，不存在添加，并获取卡号id**/
            // 获取卡id   $memberModel->memberCardId（注释：卡种id还没获取到）
            $memberModel->createCardDate = $this->createCardDate;  // 开卡 时间设置
            $memberModel->activeTime      = $this->createCardDate;  // 激活时间默认开卡时间
            $memberModel->rentEndTime     = $this->cardEndDate;     // 卡的到期时间
            $insertResult4 =$memberModel->checkMemberCard($check->cardCategoryId,$check->organId,$check->venueId);
            if($insertResult4 !== "success"){
                return $insertResult4;
            }
            /** 请假表数据录入**/
            $insertResult5 = $this->aiBoMemberLeaveRecord($memberModel->memberId,$memberModel->memberCardId,$check->employeeId,$status);
            if($insertResult5!=="success"){
                return $insertResult5;
            }
        }
        return true;
    }

    // 爱博数据导入
    public function aiBoMemberLeaveRecord($memberId,$memberCardId,$operatorId,$status){
        $model = new LeaveRecord();
        $model-> leave_employee_id = $memberId;   // 请假人id
        $model-> is_approval       = 1;           // 默认批准
        $model-> create_at          = $this->operateTime;  // 操作时间
        $model-> leave_start_time  = $this->leaveStartTime;  // 请假开始时间
        $model-> leave_end_time     = $this->leaveEndTime;    // 请假结束时间、
        $model-> status              = time()>$this->leaveEndTime?2:1; // 假期状态
        $model-> member_card_id     = $memberCardId;
        $model-> is_approval_id     = $operatorId;      // 批准人ID
        // 请假类型判断
        if(empty($this->hangUpType)){
              $model->leave_type = 3;
        }elseif($this->hangUpType=="怀孕"){
            $model->leave_type = 1;
        }elseif($this->hangUpType=="伤病"){
            $model->leave_type = 2;
        }else{
            $model->leave_type = 3;
        }
        $model->leave_property      =  empty($status)?2:1;                // 请假 状态 [正常请假]
        if(!$model->save()){
            return $model->errors;
        }
        return  "success";
    }
    /**
     * 云运动 -  所有场馆 老卡种绑定 生日课
     * @author houkaixin<houkaixin@sports.club>
     * @create 2017/11/06
     * @return  boolean
     */
    public function cardBindBirthCourse(){
          // 查询指定的赠送的私教课程id
          $privateId = $this->gainPrivateId();
          //查询所有未绑定赠送2结私教课的卡种id
          $allCardCategoryId = $this->searchALLNotBindCardCategory($privateId);
          // 将未绑定卡种绑定赠送私教课程
          $this->bindPackCourse($allCardCategoryId,$privateId);

    }
    /**
     * 云运动 -   办卡赠送私教课程
     * @author houkaixin<houkaixin@sports.club>
     * @create 2017/11/06
     * @return  integer  //私教课程id
     */
    public function gainPrivateId(){
        $privateId = ChargeClass::find()
            ->where(["name"=>"办卡赠送私教课"])
            ->select("name,id")
            ->one();
        $privateId = $privateId->id;
        return  $privateId;
    }
    /**
     * 云运动 -  查询所有未绑定赠送私教课的卡种id
     * @author houkaixin<houkaixin@sports.club>
     * @create 2017/11/06
     * @param $privateId  // 私教课程id
     * @return  array     //未赠送私教课的
     */
    public function searchALLNotBindCardCategory($privateId){
          define("privateId",$privateId);
          $allCardCategoryId = \backend\models\CardCategory::find()
                                  ->alias("cardCategory")
                                  ->joinWith(["bindPackBirth bindPackBirth"])
                                  ->andWhere(["is","bindPackBirth.id",null])  // 未绑定赠送2节私教课程的
                                  ->select("cardCategory.id")
                                  ->asArray()
                                  ->column();
          return $allCardCategoryId;
    }
    /**
     * 云运动 -  绑定赠送的私教课程
     * @author houkaixin<houkaixin@sports.club>
     * @create 2017/11/06
     * @param $allCardCategoryId  // 所有卡种id
     * @param $privateId       // 私教课程id
     * @return  array     //未赠送私教课的
     */
    public function bindPackCourse($allCardCategoryId,$privateId){
        // 组装需要导入的数据
         $resultData = $this->dealData($allCardCategoryId,$privateId);
        //数据导入
        \Yii::$app->db->createCommand()
                ->batchInsert('cloud_bind_pack',['card_category_id',"polymorphic_id","polymorphic_type","number","status"],$resultData)->execute();
    }
    /**
     * 云运动 -  数据组装处理
     * @author houkaixin<houkaixin@sports.club>
     * @create 2017/11/16
     * @param $allCardCategoryId  // 所有卡种id
     * @param $privateId          // 私教课程id
     * @return  array             //组装
     */
    public function dealData($allCardCategoryId,$privateId){
        $arr = [];
        foreach($allCardCategoryId as $keys=>$values){
            $arr1 = [];
            $arr1[] = $values;     // 卡种id
            $arr1[] = $privateId;  // 私教课程id
            $arr1[] = "birth";
            $arr1[] = 2;
            $arr1[] = 4;
            $arr[] = $arr1;
        }
        return $arr;
    }
}