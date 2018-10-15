<?php
namespace backend\models;
use common\models\base\ChargeClassPrice;
use common\models\base\ChargeClassService;
use yii\base\Model;
use common\models\base\ChargeClass;
use common\models\base\ClassSaleVenue;
use common\models\base\CoursePackageDetail;
class PrivateServerRuleForm extends Model {
    public $belongVenue;        //所属场馆
    public $name;               //产品名称
    public $validTime;          //有效期
    public $validTimeType;      //有效期单位
    public $activatedTime;      //激活期限
    public $activatedTimeType;  //激活期限单位
    public $sellNum;            //售卖总数量
    public $saleStart;          //售卖起始日期
    public $saleEnd;            //售卖结束日期
    public $totalUnitPrice;     //总售价（总优惠价 2017/7/8 -不用了）
    public $totalPosPrice;      //总POS价（总POS价 2017/7/8 -不用了）
    public $classKey;           //课程id
    public $classTime;          //课程时长
    public $onePrice;           //单节原价
    public $appUnitPrice;       //移动端单节原价
    public $intervalStart;      //开始节数
    public $intervalEnd;        //结束节数
    public $unitPrice;          //优惠单价
    public $posPrice;           //POS价
    public $appDiscount;        //移动端折扣
    public $venueId;            //场馆id
    public $venueSaleNum;       //售卖数量
    public $serverId;           //服务id
    public $serverNum;          //服务数量
    public $giftId;             //赠品id
    public $giftNum;            //赠品数量
    public $transferNum;        //转让次数
    public $transferPrice;      //转让金额
    public $desc;               //课程介绍
    public $pic;                //图片
    public $dealId;             //合同ID
    public $courseType;        //课程类型（1购买，2赠送）
    public $productType;       //产品类型（1常规PT，2特色课，3游泳课）
    public $monthUpNum;
    public $dataArr = array();
    const notice = '操作失败';

    /**
     * 云运动 - 私课管理 - 私教课程表单提交(规则验证)
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/4/19
     * @return string
     */
    public function rules(){
        return [
//            ['name', 'unique', 'targetClass' => '\common\models\base\ChargeClass', 'message' => '产品名称已经存在'],
            ['name','trim'],
            ['name','string'],
            [['belongVenue','name','validTime','validTimeType','activatedTime','activatedTimeType','sellNum', 'saleStart',
                'saleEnd','totalUnitPrice','totalPosPrice', 'classKey',
                'classTime','onePrice','intervalStart','intervalEnd','unitPrice',
                'posPrice','appDiscount','venueId','venueSaleNum','serverId','serverNum',
                'giftId','giftNum','transferNum','monthUpNum','transferPrice','desc','pic','dealId','courseType','productType','appUnitPrice'],'safe']
        ];
    }

    /**
     * 处理数据 - 课程数据、售卖场馆数据、服务数据
     * @return bool
     */
    public function setPackage()
    {
        $data   = [];
        $data[] = [$this->intervalStart,$this->intervalEnd,$this->unitPrice,$this->posPrice,$this->appDiscount];
        $data[] = [$this->venueId,$this->venueSaleNum];
        $data[] = [$this->serverId,$this->serverNum];
        $data[] = [$this->giftId,$this->giftNum];
        $this->dataArr = $data;
        return true;
    }

    public function saveCharge()
    {
        $chargeName = ChargeClass::findOne(['name'=>$this->name,'venue_id'=>$this->belongVenue]);
        if(!empty($chargeName)){
            return '产品名称已经存在';
        }
        $transaction =  \Yii::$app->db->beginTransaction();       //开启事务
        try{
            $this->setPackage();
            $orga = \common\models\base\Organization::findOne(['id' => $this->belongVenue]);
            $chargeClass = new ChargeClass();
            $chargeClass->name             = $this->name;                           //产品名称
            $chargeClass->valid_time       = (int)$this->validTime * (int)$this->validTimeType;               //有效期
            $chargeClass->activated_time   = (int)$this->activatedTime * (int)$this->activatedTimeType;       //激活时间
            $chargeClass->total_sale_num   = $this->sellNum;                        //售卖总数量
            $chargeClass->sale_start_time  = strtotime($this->saleStart);           //售卖开始时间
            $chargeClass->sale_end_time    = strtotime($this->saleEnd)+86399;             //售卖接收时间
//            $chargeClass->total_amount     = $this->totalUnitPrice;               //（该值不用了）
//            $chargeClass->total_pos_price  = $this->totalPosPrice;                //
            $chargeClass->created_at       = time();                                //创建时间
            $chargeClass->create_id        = \Yii::$app->user->identity->id;        //创建人id
            $chargeClass->transfer_num     = $this->transferNum;                    //转让数量
            $chargeClass->transfer_price   = $this->transferPrice;                  //转让价
            $chargeClass->describe         = $this->desc;                           //描述
            $chargeClass->pic              = $this->pic;                            //图片
            $chargeClass->deal_id          = $this->dealId;                         //合同ID
            $chargeClass->type             = 2;                                     //2表示单课程
            $chargeClass->company_id       = $orga['pid'];                          //所属公司
            $chargeClass->venue_id         = $this->belongVenue;                    //所属场馆
            $chargeClass->course_type      = $this->courseType;                     //课程类型
            $chargeClass->month_up_num     = intval($this->monthUpNum);             //每月上课量
            $chargeClass->product_type     = intval($this->productType);            //产品类型（1常规PT，2特色课，3游泳课）
            $chargeClass->show             = 1;                                     //移动端价格:1显示,2不显示
            $chargeClass = $chargeClass->save() ? $chargeClass : $chargeClass->errors;
            if(!isset($chargeClass->id)){
                    throw new \Exception(self::notice);
                }
            if (isset($chargeClass->id)) {
                $saveDetail = $this->saveCourse($chargeClass);
                if(!isset($saveDetail->id)){
                    throw new \Exception(self::notice);
                }
                $savePrice = $this->savePrice($chargeClass,$saveDetail);
                if($savePrice !== true){
                    throw new \Exception(self::notice);
                }
                $saveVenue = $this->saveVenue($chargeClass);
                if($saveVenue !== true){
                    throw new \Exception(self::notice);
                }
                $saveServer = $this->saveServer($chargeClass);
                if($saveServer !== true){
                    throw new \Exception(self::notice);
                }
                $saveGift = $this->saveGift($chargeClass);
                if($saveGift !== true){
                    throw new \Exception(self::notice);
                }
            }
            $transaction->commit();
        }catch(\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return  $e->getMessage();  //获取抛出的错误
        }
    }

    //存储课种
    public function saveCourse($chargeClass)
    {
        $courseDetail                   = new CoursePackageDetail();
        $courseDetail->charge_class_id = $chargeClass->id;                      //收费课程表id
        $courseDetail->course_id        = $this->classKey;                      //课种id
        $courseDetail->course_length    = $this->classTime;                     //时长
        $courseDetail->original_price   = $this->onePrice;                      //单节原价
        $courseDetail->course_num       = 1;                                    //单节课（课量存1）
        $courseDetail->type             = 1;                                    //1表示私课
        $courseDetail->create_at        = time();                               //创建时间
        $courseDetail->category         = 2;                                    //2表示单节课程
        $courseDetail->app_original     = $this->appUnitPrice;                  //移动端单节原价
        $courseDetail = $courseDetail->save() ? $courseDetail : $courseDetail->errors;
        if ($courseDetail) {
           return $courseDetail;
        }else{
            return $courseDetail->errors;
        }
    }

    //存储区间
    public function savePrice($chargeClass,$saveDetail)
    {
        $intervalStart = $this->dataArr[0][0];                      //售卖区间开始数量 数组
        $intervalEnd   = $this->dataArr[0][1];                      //售卖区间结束数量 数组
        $unitPrice     = $this->dataArr[0][2];                      //优惠单价 数组
        $posPrice      = $this->dataArr[0][3];                      //pos价 数组
        $appDiscount   = $this->dataArr[0][4];                      //移动端折扣 数组
        if(isset($unitPrice) && $unitPrice){
            foreach ($unitPrice as $key=>$value){
                $price                            = new ChargeClassPrice();
                $price->charge_class_id           = $chargeClass->id;               //收费课程表id
                $price->course_package_detail_id  = $saveDetail->id;                //课程套餐详情表id
                $price->intervalStart             = (int)$intervalStart[$key];      //区间开始数量
                $price->intervalEnd               = (int)$intervalEnd[$key];        //区间结束数量
                $price->unitPrice                 = (int)$unitPrice[$key];          //优惠单价
                $price->posPrice                  = (int)$posPrice[$key];           //pos价
                $price->create_time               = time();                         //创建时间
                $price->app_discount              = (int)$appDiscount[$key];        //移动端折扣
                if (!$price->save()) {
                    return $price->errors;
                }
            }
        }
        return true;
    }

    //存储售卖场馆
    public function saveVenue($chargeClass)
    {
        $venueArr    = $this->dataArr[1][0];                                    //售卖场馆数组
        $venueNumArr = $this->dataArr[1][1];                                    //售卖数量数组
        if(isset($venueArr) && $venueArr){
            foreach ($venueArr as $key=>$value){
                $classSaleVenue                   = new ClassSaleVenue();
                $classSaleVenue->charge_class_id = $chargeClass->id;            //收费课程表id
                $classSaleVenue->venue_id         = (int)$value;                //场馆id
                $classSaleVenue->sale_num         = (int)$venueNumArr[$key];    //售卖数量
                $classSaleVenue->sale_start_time = NULL;
                $classSaleVenue->sale_end_time   = NULL;
                $classSaleVenue->status           = 1;                          //1表示私课
                if (!$classSaleVenue->save()) {
                    return $classSaleVenue->errors;
                }
            }
        }
        return true;
    }

    //存储服务
    public function saveServer($chargeClass)
    {
        $serverArr    = $this->dataArr[2][0];                               //服务id数组
        $serverNumArr = $this->dataArr[2][1];                               //服务数量数组
        if(isset($serverArr) && $serverArr){
            foreach ($serverArr as $key=>$value){
                $server                   = new ChargeClassService();
                $server->charge_class_id  = $chargeClass->id;               //收费课程id
                $server->service_id       = (int)$value;                    //服务id
                $server->service_num      = (int)$serverNumArr[$key];       //服务数量
                $server->type             = 1;                              //1服务
                $server->category         = 1;                              //1表示私课
                $server->create_time      = time();                          //创建时间
                if (!$server->save()) {
                    return $server->errors;
                }
            }
        }
        return true;
    }

    //存储赠品
    public function saveGift($chargeClass)
    {
        $giftArr      = $this->dataArr[3][0];                               //赠品id
        $giftNumArr   = $this->dataArr[3][1];                               //赠品数量
        if(isset($giftArr) && $giftArr){
            foreach ($giftArr as $key=>$value){
                $gift                   = new ChargeClassService();
                $gift->charge_class_id  = $chargeClass->id;               //收费课程id
                $gift->gift_id          = (int)$value;                    //赠品id
                $gift->gift_num         = (int)$giftNumArr[$key];         //赠品数量
                $gift->type             = 2;                              //2赠品
                $gift->category         = 1;                              //1表示私课
                $gift->create_time      = time();                          //创建时间
                if (!$gift->save()) {
                    return $gift->errors;
                }
            }
        }
        return true;
    }
}