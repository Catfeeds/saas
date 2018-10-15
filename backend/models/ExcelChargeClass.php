<?php
namespace backend\models;
use common\models\Excel;
use yii\base\Model;
class ExcelChargeClass extends Model
{
    const PARAM = ["orderNumber","chargeWay","memberCardNum","memberName","startDate","endDate"
                    ,"privateTeacherType","privateTeacherName","courseType","totalTimes","remainTimes",
                     "giveClass","lessonRemain","classHoursPrice","hadClassNum","courseMoney",
                    "surplusMoney"];
    public $orderNumber;  //序号
    public $chargeWay;    // 收费方式
    public $memberCardNum; //会员卡号
    public $memberName;   //会员姓名
    public $startDate;    //上课开始日期
    public $endDate;      // 上课结束日期
    public $privateTeacherType;  //私教类别
    public $privateTeacherName;   //私教姓名
    public $courseType;          //课程类型
    public $totalTimes;          //购买数量（60）
    public $remainTimes;         //当前剩余（1）
    public $giveClass;           //免费总数（0）
    public $lessonRemain;        //免费剩余（0）
    public $classHoursPrice;     //课时费（100元）

    public $hadClassNum;      // 已上课数量
    public $courseMoney;      // 课程金额
    public $surplusMoney;    // 剩余金额

    // 需要用到的属性
    public $memCourseOrderId;   // 会员课程订单id
    public $productId;           // 产品id

    public function handleData($data){
        $data  = array_values($data);
        $param =self::PARAM;
        foreach($data as $key=>$value){
           $keys = $param[$key];
           $this->$keys = $value;
        }
    }

    public function chargeClassFile($path,$type,$name){
        $model = new Excel();
        $data = $model->loadFileChargeClass($path,'charge');
        //检查场馆是否存在
        // 公司id  $check->organId  场馆id $check->venueId 部门id $check->$departId
        $check = new ExcelCharge();
        $check->venueType = $type;
        $check->venueNameTwo = $name;
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
        //检查默认产品是否存在 不存在话 生成默认产品
        // 获取产品id $check->productId
        $check->createProduct();
        $this->productId = $check->productId;
        foreach($data as $keys=>$values){
            // 属性赋值
            $this->handleData($values);
            /**私教数据插入，并且获取Id（私教id）-- 数据录入**/
            /**--获取私教id（$check->privateId）--**/
            $insertResult1 = $check->insertEmployeeData($this->privateTeacherName,"private");
            if($insertResult1 !== true){
                return $insertResult1;
            }
            // 会员数据导入，并且获取会员id
            /**--获取会员id（$nowModel->memberId） -**/
            $nowModel = new CabinetExcel();
            $nowModel->memberCardNum = $this->memberCardNum; // 会员卡号赋值
            $nowModel->memberName    =  $this->memberName;   // 会员姓名赋值
            $nowModel->fixPhone      = null;   //固定电话赋值
            $nowModel->mobile        = null; // 移动电话赋值
            $insertResult2 = $nowModel->checkMember($check->organId,$check->venueId,$check->privateId);
            if($insertResult2 !== true){
                return $insertResult2;
            }
            //会员详情表数据导入，
            $insertResult3 = $nowModel->checkMemberDetail();
            if($insertResult3 !== true){
                return $insertResult3;
            }
            /**检查会员卡号是否存在，不存在添加，并获取卡号id**/
            // 会员卡id   $nowModel->memberCardId
            $nowModel->theMemCardName = "时间卡";
            $nowModel->rentEndTime   = $this->endDate;
            $nowModel->activeTime    = $this->startDate;
            $insertResult4 = $nowModel->checkMemberCard($check->cardCategoryId,$check->organId,$check->venueId);
            if($insertResult4 !== "success"){
                return $insertResult4;
            }
            /**会员课程订单表的数据录**/
            $insertResult5 = $this->memCourseOrder($check->privateId,$nowModel->memberCardId,$nowModel->memberId);
            // 判断 是否能够在 缴费订单表 中查找到 相同数据 （找到直接跳出循环：不用录入数据）
            if($insertResult5==="endSuccess"){
                continue;
            }
            // 没有在缴费调单表中 查找到数据 再判是否成功 录入数据
            if($insertResult5!==true){
                return $insertResult5;
            }
            /**会员课程订单详情表**/
            $insertResult6 = $this->memCourseOrderDetail();
            if($insertResult6!==true){
                echo 6;
                print_r($insertResult6);
                return $insertResult6;
            }
            /**历史消费统计表数据录入**/
            $insertResult7 = $this->consumeHistory($nowModel->memberId,$check->organId,$check->venueId);
            if($insertResult7!==true){
                echo 7;
                print_r($insertResult7);
                return $insertResult7;
            }
        }
        return true;
    }

    //会员课程订单统计表
    public function memCourseOrder($privateId,$memCardId,$memberId){
        // 过滤筛选判断(暂时根据如下字段刷选)[会员卡id，生效日期,截止日期，剩余课程，免费剩余课程]过滤
        $modelData = MemberCourseOrder::findOne(["and",["member_card_id"=>$memCardId],["activeTime"=>$this->startDate],
            ["deadline_time"=>$this->endDate],["overage_section"=>$this->remainTimes],
            ["surplus_course_number"=>$this->lessonRemain]]);
        if(!empty($modelData)){
            $this->memCourseOrderId = $modelData->id;
            return "endSuccess";
        }
        // 备注：目前 导入数据之前 只能 直接插入 没有可以供提前查询的标志
        if(empty($modelData)){
            $model = new MemberCourseOrder();
            $model->course_amount = $this->totalTimes;  // 购买次数
            $model->money_amount  = $this->courseMoney;  //总金额（暂定课程金额）
            $model->overage_section = $this->remainTimes;  // 课程剩余次数
            $model->deadline_time  = $this->endDate;        //课程结束日期
            $model->activeTime      = $this->startDate;     // 课程开始日期
            $model->create_at       =  $this->startDate;    // 课程办理日期
            $model->product_id      = !empty($this->productId)?$this->productId:null; // 商品id
            $model->product_type    = 1;                    // 商品类型
            $model->private_id      = !empty($privateId)?$privateId:0; // 私教id
            $model->present_course_number = abs($this->giveClass);    // 增课数量
            $model->surplus_course_number = abs($this->lessonRemain); // 课程剩余数量
            $model->member_card_id   = $memCardId;                     //会员卡id
            $model->member_id         = $memberId;                      // 会员id
            $model->product_name      = "私教上课统计";
            if(!$model->save()){
                return $model->errors;
            }
            $this->memCourseOrderId =  $model->id;
        }
        return true;
    }

    // 会员课程订单详情表统计
    public function memCourseOrderDetail(){
            $model = MemberCourseOrderDetails::findOne(["id"=>$this->memCourseOrderId]);
            if(empty($model)){
                $thisModel = new MemberCourseOrderDetails();
                $thisModel->course_order_id = !empty($this->memCourseOrderId)?$this->memCourseOrderId:0;
                $thisModel->course_id = 0;
                $thisModel->original_price = !empty($this->classHoursPrice)?$this->classHoursPrice:0;
                $thisModel->sale_price      = !empty($this->classHoursPrice)?$this->classHoursPrice:0;
                $thisModel->pos_price       =!empty($this->classHoursPrice)?$this->classHoursPrice:0;
                $thisModel->type             = 1;
                $thisModel->product_name = "私教收费清单";
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
        $model->member_id = $memberId;
        $model->consumption_type     = "私教综合课程(私教上课)";
        $model->consumption_type_id = $this->memCourseOrderId;
        $model->company_id            = $companyId;
        $model->venue_id              = $venueId;
        $model->consumption_amount   = abs($this->courseMoney);
        $model->consume_describe     = json_encode("私教上课记录表");
        $model->type                   = 1;
        if(!$model->save()){
            return $model->errors;
        }
        return true;
    }






}

