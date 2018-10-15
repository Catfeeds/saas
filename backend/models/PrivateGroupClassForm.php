<?php
namespace backend\models;

use common\models\base\ChargeClassPrice;
use common\models\base\ChargeClassService;
use yii\base\Model;
use common\models\base\ChargeClass;
use common\models\base\ClassSaleVenue;
use common\models\base\CoursePackageDetail;
use common\models\base\ChargeClassPeople;
class PrivateGroupClassForm extends Model {
    public $name;                               //产品名称
    public $monthUpNum;                         //每月上课数量
    public $courseType;                         //课程类型(1购买,2赠送)
    public $sellNum;                            //售卖总数量
    public $saleStart;                          //售卖开始日期
    public $saleEnd;                            //售卖结束日期
    public $classId;                            //课种id
    public $classTime;                          //课程时长
    public $onePrice;                           //单节原价
    public $intervalStart;                      //课程节数左区间(数组)
    public $intervalEnd;                        //课程节数右区间(数组)
    public $classPrice;                         //课程价格区间(数组,包含人数区间,优惠价格,pos价格以及最低人数)
    public $venueId;                            //场馆id(数组)
    public $venueSaleNum;                       //单馆售卖数量(数组)
    public $giftId;                             //赠品id(数组)
    public $giftNum;                            //赠品数量(数组)
    public $transferNum;                        //转让次数
    public $transferPrice;                      //转让金额
    public $desc;                               //课程介绍
    public $pic;                                //课程照片
    public $dealId;                             //合同id
    public $group=2;                            //单人私课(状态)
    public $dataArr = array();
    const notice = '操作失败';

    
    /*
     * 私教管理 - 私教小团体 - 表单提交规则验证
     * */
    public function rules(){
        return [
//            ['name', 'unique', 'targetClass' => '\common\models\base\ChargeClass', 'message' => '产品名称已经存在'],
            ['name','trim'],
            ['name','string'],
            [['name','monthUpNum','sellNum', 'saleStart',
                'saleEnd', 'classId','classNum',
                'classTime','onePrice','intervalStart','intervalEnd','classPrice'
                ,'venueId','venueSaleNum',
                'giftId','giftNum','transferNum','transferPrice','desc','pic','dealId','courseType'],'safe']
        ];
    }

    /**
     * 处理数据 - 课种选择、多人阶梯价格、售卖场馆、赠品
     */
    public function setPackage()
    {
        $data   = [];
        //多人阶梯价格
        $data[] = [$this->intervalStart,$this->intervalEnd];
        //售卖场馆
        $data[] = [$this->venueId,$this->venueSaleNum];
        //赠品
        $data[] = [$this->giftId,$this->giftNum];
        $this->dataArr = $data;
        return true;
    }
    
    /*
     * 私教课程 - 私教小团体课程 - 添加课程
     * */
    public function saveCharge($companyId,$venueId)
    {
        $chargeName = ChargeClass::findOne(['name'=>$this->name,'venue_id'=>$venueId,'group'=>2]);
        if (!empty($chargeName)) {
            return '产品名称已存在!';
        }
        $transaction = \Yii::$app->db->beginTransaction();                              //开启事务
        try{
            $this->setPackage();
            $chargeClass                    = new ChargeClass();
            $chargeClass->name              = $this->name;                              //产品名称
            $chargeClass->describe          = $this->desc;                              //产品介绍
            $chargeClass->pic               = $this->pic;                               //产品图片
            $chargeClass->create_id         = \Yii::$app->user->identity->id;           //创建人ID(员工ID)
            $chargeClass->created_at        = time();                                   //创建时间
            $chargeClass->category          = 2;                                        //1表示私教,2表示团课
            $chargeClass->venue_id          = $venueId;                                 //场馆id
            $chargeClass->status            = 1;                                        //1正常2冻结3过期
            $chargeClass->original_price    = $this->onePrice;                          //单节原价
            $chargeClass->total_sale_num    = $this->sellNum;                           //售卖总量
            $chargeClass->sale_start_time   = strtotime($this->saleStart);              //售卖开始日期
            $chargeClass->sale_end_time     = strtotime($this->saleEnd)+(int)(24*60*60-1);                //售卖结束日期
            $chargeClass->transfer_num      = $this->transferNum;                       //转让次数
            $chargeClass->transfer_price    = $this->transferPrice;                     //转让金额
            $chargeClass->type              = 2;                                        //1多课程2单课程
            $chargeClass->company_id        = $companyId;                               //公司id
            $chargeClass->deal_id           = $this->dealId;                            //合同id
            $chargeClass->course_type       = $this->courseType;                        //1赠送2购买
            $chargeClass->month_up_num      = $this->monthUpNum;                        //每月上课数量
            $chargeClass->group             = 2;                                        //1单人私课2多人私课
            $chargeClass->product_type      = 1;
            $chargeClass = $chargeClass->save() ? $chargeClass : $chargeClass->errors;
            if (!isset($chargeClass->id)) {
                throw new \Exception(self::notice);
            }
            if (isset($chargeClass->id)) {
                $saveCourseDetail = $this->saveCourseDetail($chargeClass);
                if (!isset($saveCourseDetail->id)) {
                    throw new \Exception(self::notice);
                }
                $saveClassPrice = $this->saveClassPrice($chargeClass, $saveCourseDetail);
                if ($saveClassPrice !== true) {
                    throw new \Exception(self::notice);
                }
                $saveSaleVenue = $this->saveSaleVenue($chargeClass);
                if ($saveSaleVenue !== true) {
                    throw new \Exception(self::notice);
                }
                $saveService = $this->saveService($chargeClass);
                if ($saveService !== true) {
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

    /*
     * 私教管理 - 私教小团体课程 - 添加课程(课种选择的添加存储)
     * */
    public function saveCourseDetail($chargeClass)
    {
        $cpd                    = new CoursePackageDetail();
        $cpd->charge_class_id   = $chargeClass->id;             //收费产品id
        $cpd->course_id         = $this->classId;               //课程id
        $cpd->course_length     = $this->classTime;             //课程时长
        $cpd->original_price    = $this->onePrice;              //单节原价
        $cpd->type              = 1;                            //状态(1私课,2团课)
        $cpd->create_at         = time();                       //创建时间
        $cpd->category          = 2;                            //类型(1多课程,2单课程)
        $cpd = $cpd->save() ? $cpd : $cpd->errors;
        if ($cpd) {
            return $cpd;
        } else {
            return $cpd->errors;
        }
    }

    /*
     * 私教管理 - 私教小团体课程 - 添加课程(多人阶梯价格的添加存储)
     * */
    public function saveClassPrice($chargeClass,$saveCourseDetail)
    {
        //$intervalStartArr     = $this->dataArr[0][0];                 //课程节数左区间 (数组)
        $intervalEndArr       = $this->dataArr[0][1];                 //课程节数右区间 (数组)
        $venueArr    = $this->dataArr[1][0];                                    //售卖场馆数组
        $venueNumArr = $this->dataArr[1][1];                                    //售卖数量数组
        if ($intervalEndArr) {
            foreach ($intervalEndArr as $key=>$value) {
                $ccp                             = new ChargeClassPrice();
                $ccp->charge_class_id            = $chargeClass->id;                                                 //产品id;
                $ccp->course_package_detail_id   = $saveCourseDetail->id;                                            //课种id
                //$ccp->intervalStart              = (int)isset($intervalStartArr[$key]) ? $intervalStartArr[$key] : null;         //课程节数左区间
                $ccp->intervalEnd                = (int)isset($intervalEndArr[$key]) ? $intervalEndArr[$key] : null;       //课程节数右区间
                $ccp->create_time                = time();
                $ccp = $ccp->save() ? $ccp : $ccp->errors;
                if (!isset($ccp->id)) {
                    return $ccp;
                }
                foreach ($this->classPrice[$key] as $k1=> $v2) {
                        $ccl                    = new ChargeClassPeople();
                        $ccl->charge_class_id   = $chargeClass->id;
                        $ccl->class_price_id    = $ccp->id;
                        //$ccl->people_least      = $v2['classPersonLeft'];
                        $ccl->people_most       = $v2['classPersonRight'];
                        $ccl->least_number      = $v2['lowNum'];
                        $ccl->unit_price        = $v2['unitPrice'];
                        $ccl->pos_price         = $v2['posPrice'];
                        $ccl = $ccl->save() ? $ccl : $ccl->errors;
                        if (!isset($ccl->id)) {
                            return $ccl;
                        }
                        foreach ($venueArr as $kk => $vv){
                            $this->saveOrderNumber($chargeClass,$ccp,$ccl,$vv,$venueNumArr[$kk]);
                        }

                }
            }
        }
        return true;
    }

    /*
     * 私教管理 - 私教小团体 - 添加课程(存储售卖场馆)
     * */
    public function saveSaleVenue($chargeClass)
    {
        $venueArr    = $this->dataArr[1][0];                                    //售卖场馆数组
        $venueNumArr = $this->dataArr[1][1];                                    //售卖数量数组
        if(isset($venueArr) && $venueArr){
            foreach ($venueArr as $key=>$value){
                $classSaleVenue                   = new ClassSaleVenue();
                $classSaleVenue->charge_class_id  = $chargeClass->id;            //收费课程表id
                $classSaleVenue->venue_id         = (int)$value;                //场馆id
                $classSaleVenue->sale_num         = (int)$venueNumArr[$key];    //售卖数量
                $classSaleVenue->sale_start_time  = NULL;
                $classSaleVenue->sale_end_time    = NULL;
                $classSaleVenue->status           = 1;                          //1表示私课,2表示团课
                if (!$classSaleVenue->save()) {
                    return $classSaleVenue->errors;
                }
            }
        }
        return true;
    }

    /*
     * 私教管理 - 私教小团体 - 添加课程(存储私教课程赠品)
     * */
    public function saveService($chargeClass)
    {
        $giftArr      = $this->dataArr[2][0];                               //赠品id
        $giftNumArr   = $this->dataArr[2][1];                               //赠品数量
        if(isset($giftArr) && $giftArr){
            foreach ($giftArr as $key=>$value){
                $gift                   = new ChargeClassService();
                $gift->charge_class_id  = $chargeClass->id;               //收费课程id
                $gift->gift_id          = (int)$value;                    //赠品id
                $gift->gift_num         = (int)$giftNumArr[$key];         //赠品数量
                $gift->type             = 2;                              //2赠品
                $gift->category         = 1;                              //1表示私课,2表示团课
                $gift->create_time      = time();                          //创建时间
                if (!$gift->save()) {
                    return $gift->errors;
                }
            }
        }
        return true;
    }

    /**
     * @私教管理 - 私教小团体 - 添加课程(存储私课编号表)
     * @author 付钟超 <fuzhongchao@itsports.club>
     * @param $ccp
     * @return array|string
     * @create 2018/01/06
     */
    public function saveOrderNumber($chargeClass,$ccp,$ccl,$venue_id,$sale_num)
    {
        $number                     = new ChargeClassNumber();
        $num = substr(date("ymdHis"),2,8).mt_rand(100000,999999);
        $result = ChargeClassNumber::findOne(['class_number'=>$num]);
        if ($result) {
            return '订单编号已存在';
        }
        $number->charge_class_id    = $chargeClass->id;
        $number->class_people_id    = $ccl->id;
        $number->class_number       = $num;
        $number->sell_number        = $ccl->people_most;
        $number->surplus            = $ccl->people_most;
        $number->total_class_num    = $ccp->intervalEnd;
        $number->attend_class_num   = $ccp->intervalEnd;
        $number->venue_id           = $venue_id;
        $number->company_id         = $chargeClass->company_id;
        $number->sale_num           = $sale_num;
        $number->surplus_sale_num   = $sale_num;
        $number = $number->save() ? $number : $number->errors;
        if ($number) {
            return $number;
        } else {
            return $number->errors;
        }
    }

}