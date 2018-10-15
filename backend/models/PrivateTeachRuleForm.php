<?php
namespace backend\models;

use common\models\base\ChargeClassService;
use yii\base\Model;
use common\models\base\ChargeClass;
use common\models\base\ClassSaleVenue;
use common\models\base\CoursePackageDetail;

class PrivateTeachRuleForm extends Model {
    public $belongVenue;                                //所属场馆
    public $name;                                       //产品名称
    public $validTime;                                  //产品有效期
    public $validTimeType;                              //产品有效期单位
    public $activatedTime;                              //产品激活期限
    public $activatedTimeType;                          //产品激活期限单位
    public $sellNum;                                    //售卖总数量
    public $unLimitNum;                                 //售卖数量
    public $saleStart;                                  //售卖开始日期
    public $saleEnd;                                    //售卖接收日期
    public $totalPrice;                                 //总原价
    public $appTotalOriginal;                           //移动端总原价
    public $totalSalePrice;                             //总售价
    public $totalPosPrice;                              //总POS价
    public $appTotalPrice;                              //移动端总售价
    public $notReservation;                             //不可预约时间限制（没用字段）
    public $notCancel;                                  //不可取消时间限制（没用字段）
    public $reservationDays;                            //可预约天数（没有字段）
    public $classId;                                    //课种id
    public $classTime;                                  //时长
    public $classNum;                                   //数量
    public $unitPrice;                                  //单节原价
    public $appUnitPrice;                               //移动端单节原价
    public $venueId;                                    //售卖场馆
    public $venueSaleNum;                               //售卖数量
    public $serverId;                                   //服务id
    public $serverNum;                                  //服务数量
    public $giftId;                                     //赠品id
    public $giftNum;                                    //赠品数量
    public $transferNum;                                //转让次数
    public $transferPrice;                              //转让金额
    public $desc;                                       //描述
    public $pic;                                        //图片
    public $courseType;                                //课程类型（1购买，2赠送）
    public $dealId;                                    //合同id
    public $productType;                               //产品类型（1常规PT，2特色课，3游泳课）
    public $dataArr = array();
    const notice = '操作失败';
    public $price = 0;                                      //计算出的总原价
    /**
     * 云运动 - 私课管理 - 私教课程表单提交(规则验证)
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/4/19
     * @return array
     */
    public function rules(){
        return [
//            ['name', 'unique', 'targetClass' => '\common\models\base\ChargeClass', 'message' => '产品名称已经存在'],
            ['name','trim'],
            ['name','string'],
            [['belongVenue','name','validTime','validTimeType','activatedTime','activatedTimeType','sellNum','unLimitNum',
                'saleStart','saleEnd','totalPrice','totalSalePrice','totalPosPrice',
                'notReservation','notCancel','reservationDays','classId',
                'classTime','classNum','unitPrice','venueId','venueSaleNum',
                'serverId','serverNum','giftId','giftNum','transferNum',
                'transferPrice','desc','pic','courseType','dealId','productType','appTotalPrice','appUnitPrice','appTotalOriginal'],'safe']
        ];
    }

    /**
     * 处理数据 - 课程数据、售卖场馆数据、服务数据
     * @return bool
     */
    public function setPackage()
    {
        $data   = [];
        $data[] = [$this->classId,$this->classTime,$this->classNum,$this->unitPrice,$this->appUnitPrice];
        $data[] = [$this->venueId,$this->venueSaleNum];
        $data[] = [$this->serverId,$this->serverNum];
        $data[] = [$this->giftId,$this->giftNum];
        $this->dataArr = $data;
        foreach ($this->dataArr[0][3] as $k=>$val)
        {
           $this->price += ($this->dataArr[0][2][$k] * $val);                                                            //计算总原价和前台发的数据对比
        }
        return true;
    }

    public function saveCharge()
    {
        $chargeName = ChargeClass::findOne(['name'=>$this->name,'venue_id'=>$this->belongVenue]);
        if(!empty($chargeName)){
            return '产品名称已经存在';
        }
        $transaction =  \Yii::$app->db->beginTransaction();       //开启事务
        $this->setPackage();                                                           //处理数据数组
        if($this->price != (int)$this->totalPrice)
        {
            return 'priceError';
        }
        try{
            $orga = \common\models\base\Organization::findOne(['id' => $this->belongVenue]);
            $chargeClass = new ChargeClass();
            $chargeClass->name             = $this->name;                                  //产品名称
            $chargeClass->valid_time       = (int)$this->validTime * (int)$this->validTimeType;                              //产品有效期
            $chargeClass->activated_time   = (int)$this->activatedTime * (int)$this->activatedTimeType;                          //产品激活时间
            $chargeClass->total_sale_num   = $this->sellNum;                                //售卖总数量
            $chargeClass->sale_start_time  = strtotime($this->saleStart);                   //售卖开始时间
            $chargeClass->sale_end_time    = strtotime($this->saleEnd)+86399;                     //售卖结束时间
            $chargeClass->original_price   = $this->price;                                  //总原价
            $chargeClass->total_amount     = $this->totalSalePrice;                         //总售价
            $chargeClass->total_pos_price  = $this->totalPosPrice;                          //总pos价
            $chargeClass->created_at        = time();                                       //创建时间
            $chargeClass->create_id         = \Yii::$app->user->identity->id;               //创建人id
            $chargeClass->transfer_num      = $this->transferNum;                           //转让数量
            $chargeClass->transfer_price    = $this->transferPrice;                         //转让价格
            $chargeClass->describe          = $this->desc;                                  //描述
            $chargeClass->pic               = $this->pic;                                   //图片
            $chargeClass->type              = 1;                                            //类型：1表示多课程
            $chargeClass->company_id        = $orga['pid'];                                 //所属公司
            $chargeClass->venue_id          = $this->belongVenue;                           //所属场馆
            $chargeClass->course_type       = $this->courseType;                            //课程类型
            $chargeClass->deal_id           = $this->dealId;                                //合同id
            $chargeClass->product_type      = intval($this->productType);                   //产品类型（1常规PT，2特色课，3游泳课）
            $chargeClass->app_amount        = $this->appTotalPrice;                         //移动端总售价
            $chargeClass->show              = 1;                                            //移动端价格:1显示,2不显示
            $chargeClass->app_original_price= $this->appTotalOriginal;                      //移动端总原价
            $chargeClass = $chargeClass->save() ? $chargeClass : $chargeClass->errors;
            if(!isset($chargeClass->id)){
                throw new \Exception(self::notice);
            }
            if (isset($chargeClass->id)) {
                $saveDetail = $this->saveDetail($chargeClass);
                if($saveDetail !== true){
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

            if($transaction->commit() == NULL)
            {
                return true;
            }else{
                return false;
            }
        }catch(\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return  $e->getMessage();  //获取抛出的错误
        }
    }

    //存储课种
    public function saveDetail($chargeClass)
    {
       // $this->classId,$this->classTime,$this->classNum,$this->unitPrice
        $detailArr       = $this->dataArr[0][0];                                   //课种id数组
        $detailLengthArr = $this->dataArr[0][1];                                   //时长数组
        $detailNumArr    = $this->dataArr[0][2];                                   //课量数组
        $detailPriceArr  = $this->dataArr[0][3];                                   //单价原价数组
        $appPriceArr     = $this->dataArr[0][4];                                   //单价原价数组
        if (isset($detailArr) && $detailArr) {
            foreach ($detailArr as $k=>$v){
                $courseDetail                   = new CoursePackageDetail();
                $courseDetail->charge_class_id  = $chargeClass->id;                //收费课程表id
                $courseDetail->course_id        = (int)$v;                         //课种id
                $courseDetail->course_num       = (int)$detailNumArr[$k];          //课量
                $courseDetail->course_length    = (int)$detailLengthArr[$k];       //时长
                if($detailPriceArr[$k]!="暂无数据"){
                    $courseDetail->original_price   = (int)$detailPriceArr[$k];    //单节原价
                }
                $courseDetail->type              = 1;                              //type:1表示私课
                $courseDetail->create_at         = time();                         //创建时间
                $courseDetail->category          = 1;                              //1表示多课程，2表示单课程
                $courseDetail->app_original      = $appPriceArr[$k];               //移动端单节原价
                if (!$courseDetail->save()) {
                    return $courseDetail->errors;
                }
            }
        }
        return true;
    }

    //存储售卖场馆
    public function saveVenue($chargeClass)
    {
        $venueArr    = $this->dataArr[1][0];                                        //售卖场馆数组
        $venueNumArr = $this->dataArr[1][1];                                        //售卖数量数组
        if(isset($venueArr) && $venueArr){
            foreach ($venueArr as $key=>$value){
                $classSaleVenue                   = new ClassSaleVenue();
                $classSaleVenue->charge_class_id  = $chargeClass->id;                //收费课程表id
                $classSaleVenue->venue_id         = (int)$value;                     //场馆id
                $classSaleVenue->sale_num         = (int)$venueNumArr[$key];         //售卖数量
                $classSaleVenue->sale_start_time  = NULL;                           //售卖开始时间
                $classSaleVenue->sale_end_time    = NULL;                           //售卖结束时间
                $classSaleVenue->status           = 1;                              //1表示私课
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
        $serverArr    = $this->dataArr[2][0];                                       //服务数组
        $serverNumArr = $this->dataArr[2][1];                                       //服务数量
        if(isset($serverArr) && $serverArr){
            foreach ($serverArr as $key=>$value){
                $server                   = new ChargeClassService();
                $server->charge_class_id  = $chargeClass->id;                       //收费课程表id
                $server->service_id       = (int)$value;                            //服务id
                $server->service_num      = (int)$serverNumArr[$key];               //服务数量
                $server->type             = 1;                                      //1服务
                $server->category         = 1;                                      //1表示私课
                $server->create_time      = time();                                 //表示创建时间
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
        $giftArr      = $this->dataArr[3][0];                                       //赠品数组
        $giftNumArr   = $this->dataArr[3][1];                                       //赠品数量
        if(isset($giftArr) && $giftArr){
            foreach ($giftArr as $key=>$value){
                $gift                   = new ChargeClassService();
                $gift->charge_class_id  = $chargeClass->id;                       //收费课程表id
                $gift->gift_id          = (int)$value;                            //赠品id
                $gift->gift_num         = (int)$giftNumArr[$key];                 //赠品数量
                $gift->type             = 2;                                      //2赠品
                $gift->category         = 1;                                      //1表示私课
                $gift->create_time      = time();                                 //表示创建时间
                if (!$gift->save()) {
                    return $gift->errors;
                }
            }
        }
        return true;
    }
}