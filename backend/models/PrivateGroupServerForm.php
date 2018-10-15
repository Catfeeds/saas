<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/8 0008
 * Time: 17:51
 */
namespace backend\models;

use common\models\base\ChargeClassPrice;
use common\models\base\ChargeClassService;
use yii\base\Model;
use common\models\base\ChargeClass;
use common\models\base\ClassSaleVenue;
use common\models\base\CoursePackageDetail;
use common\models\base\ChargeClassPeople;
class PrivateGroupServerForm extends Model {
    public $name;
    public $validTime;
    public $validTimeType;
    public $courseType;
    public $sellNum;
    public $saleStart;
    public $saleEnd;
    public $classId;
    public $classTime;
    public $classNum;
    public $onePrice;
    public $classPersonLeft;
    public $classPersonRight;
    public $unitPrice;
    public $posPrice;
    public $lowNum;
    public $venueId;
    public $venueSaleNum;
    public $giftId;
    public $giftNum;
    public $transferNum;
    public $transferPrice;
    public $desc;
    public $pic;
    public $dealId;
    public $group = 2;
    public $totalPrice;
    public $dataArr = array();
    public $totalClass;
    const notice = '操作失败';
    /**
     * @私教管理 - 私教小团体 - 添加服务表单规则验证
     * @author 付钟超 <fuzhongchao@itsports.club>
     * @create 2018/01/09
     */
    public function rules()
    {
        return [
            ['name','trim'],
            ['name','string'],
            [[
                'name','validTime','validTimeType','courseType','sellNum','saleStart','saleEnd','classId','classTime',
                'classNum','onePrice','classPersonLeft','classPersonRight','unitPrice','posPrice','lowNum','venueId',
                'venueSaleNum','giftId','giftNum','transferNum','transferPrice','desc','pic','dealId',
            ],'safe'],
        ];
    }
    /**
     * @私教管理 - 私教小团体 - 添加服务(获取课种、区间、售卖场馆、赠品数组)
     * @author 付钟超 <fuzhongchao@itsports.club>
     * @create 2018/01/09
     */
    public function setPackage()
    {
        $data = [];
        $data[] = [$this->classId,$this->classNum,$this->classTime,$this->onePrice,$this->posPrice,$this->unitPrice];
        $data[] = [$this->classPersonRight,$this->posPrice,$this->unitPrice,$this->lowNum];
        $data[] = [$this->venueId,$this->venueSaleNum];
        $data[] = [$this->giftId,$this->giftNum];
        $this->dataArr = $data;
        $total = 0;
        $price = 0;
        foreach ($this->classNum as $k=>$value) {
            $total = $total + $value;
            $price += $value * $this->onePrice[$k];
        }
        $this->totalClass = $total;
        $this->totalPrice = $price;
    }

    /**
     * @私教管理 - 私教小团体 - 添加服务
     * @author 付钟超 <fuzhongchao@itsports.club>
     * @create 2018/01/09
     */
    public function saveCharge($companyId,$venueId)
    {
        $chargeName = ChargeClass::findOne(['name'=>$this->name,'venue_id'=>$venueId]);
        if (!empty($chargeName)) {
            return '产品名称已存在!';
        }
        $transaction = \Yii::$app->db->beginTransaction();                              //开启事务
        try{
            $this->setPackage();
            $chargeClass = new ChargeClass();
            $chargeClass->name = $this->name;
            $chargeClass->describe = $this->desc;
            $chargeClass->pic = $this->pic;
            $chargeClass->create_id = \Yii::$app->user->identity->id;
            $chargeClass->created_at        = time();                                   //创建时间
            $chargeClass->category          = 2;                                        //1表示私教,2表示团课
            $chargeClass->venue_id          = $venueId;                                 //场馆id
            $chargeClass->status            = 1;                                        //1正常2冻结3过期
            $chargeClass->valid_time        = $this->validTime * $this->validTimeType;
            $chargeClass->original_price    = $this->totalPrice;                        //总单价
            $chargeClass->total_sale_num    = $this->sellNum;                           //售卖总量
            $chargeClass->amount            = $this->totalClass;                        //课量
            $chargeClass->sale_start_time   = strtotime($this->saleStart);              //售卖开始日期
            $chargeClass->sale_end_time     = strtotime($this->saleEnd)+(int)(24*60*60-1);                //售卖结束日期
            $chargeClass->transfer_num      = $this->transferNum;                       //转让次数
            $chargeClass->transfer_price    = $this->transferPrice;                     //转让金额
            $chargeClass->type              = 1;                                        //1多课程2单课程
            $chargeClass->company_id        = $companyId;                               //公司id
            $chargeClass->deal_id           = $this->dealId;                            //合同id
            $chargeClass->course_type       = $this->courseType;                        //1赠送2购买
            $chargeClass->group             = $this->group;                             //1单人私课2多人私课
            $chargeClass->product_type      = 1;
            $chargeClass = $chargeClass->save() ? $chargeClass : $chargeClass->errors;
            if (!isset($chargeClass->id)) {
                throw new \Exception(self::notice);
            }
            if (isset($chargeClass->id)) {
                $saveCourse = $this->saveCourse($chargeClass);
                if ($saveCourse !== true) {
                    throw new \Exception(self::notice);
                }
                $savePeople = $this->savePeople($chargeClass);

                if ($savePeople !== true) {
                    throw new \Exception(self::notice);
                }
                $saveVenue = $this->saveVenue($chargeClass);
                if ($saveVenue !== true) {
                    throw new \Exception(self::notice);
                }
                $saveGift = $this->saveGift($chargeClass);
                if ($saveGift !== true) {
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
    /**
     * @私教管理 - 私教小团体 - 添加服务(添加课种表)
     * @author 付钟超 <fuzhongchao@itsports.club>
     * @create 2018/01/09
     */
    public function saveCourse($chargeClass)
    {
        $classIdArr     = $this->dataArr[0][0];
        $classNumArr    = $this->dataArr[0][1];
        $classTimeArr   = $this->dataArr[0][2];
        $onePriceArr    = $this->dataArr[0][3];
        $posPriceArr    = $this->dataArr[0][4];
        $unitPrice      = $this->dataArr[0][5];
        if (isset($classIdArr) && $classIdArr) {
            foreach($classIdArr as $key=>$value) {
                $cpd = new CoursePackageDetail();
                $cpd->charge_class_id = $chargeClass->id;
                $cpd->course_id = $value;
                $cpd->course_num = $classNumArr[$key];
                $cpd->course_length = $classTimeArr[$key];
                $cpd->original_price = $onePriceArr[$key];
                //$cpd->sale_price = $unitPrice[$key];
                //$cpd->pos_price = $posPriceArr[$key];
                $cpd->type = 1;
                $cpd->create_at = time();
                $cpd->category = 1;
                $cpd = $cpd->save() ? $cpd : $cpd->errors;
                if ($cpd) {
                    $ccp = new ChargeClassPrice();
                    $ccp->charge_class_id = $chargeClass->id;
                    $ccp->course_package_detail_id = $cpd->id;
                    $ccp->intervalStart = $classNumArr[$key];
                    $ccp->intervalEnd = $classNumArr[$key];
                    //$ccp->unitPrice = $unitPrice[$key];
                    //$ccp->posPrice = $posPriceArr[$key];
                    $ccp->create_time = time();
                    if (!$ccp->save()) {
                        return $ccp->errors;
                    }
                } else {
                    $cpd->errors;
                }
            }
        }
        return true;
    }

    /**
     * @私教管理 - 私教小团体 - 添加服务(添加人数区间表)
     * @author 付钟超 <fuzhongchao@itsports.club>
     * @create 2018/01/09
     */
    public function savePeople($chargeClass)
    {
        //$classPersonLeft  = $this->dataArr[1][0];
        $classPersonRight = $this->dataArr[1][0];
        $posPrice         = $this->dataArr[1][1];
        $unitPrice        = $this->dataArr[1][2];
        $lowNum           = $this->dataArr[1][3];
        $venueId          = $this->dataArr[2][0];
        $venueSaleNum     = $this->dataArr[2][1];
        if (isset($classPersonRight) && $classPersonRight) {
            foreach ($classPersonRight as $key=>$value) {
                $ccl = new ChargeClassPeople();
                $ccl->charge_class_id   = $chargeClass->id;
                $ccl->people_least      = 0;
                $ccl->people_most       = $classPersonRight[$key];
                $ccl->least_number      = $lowNum[$key];
                $ccl->unit_price        = $unitPrice[$key];
                $ccl->pos_price         = $posPrice[$key];
                $ccl = $ccl->save() ? $ccl : $ccl->errors;
                if (!isset($ccl->id)) {
                    return $ccl->errors;
                }
                foreach ($venueId as $kk=>$vv) {
                    $this->saveNumber($chargeClass,$ccl,$vv,$venueSaleNum[$kk]);
                }
            }
        }
        return true;
    }

    /**
     * @私教管理 - 私教小团体 - 添加服务(添加售卖场馆表)
     * @author 付钟超 <fuzhongchao@itsports.club>
     * @create 2018/01/09
     */
    public function saveVenue($chargeClass)
    {
        $venueId      = $this->dataArr[2][0];
        $venueSaleNum = $this->dataArr[2][1];
        if (isset($venueId) && $venueId) {
            foreach ($venueId as $key=>$value) {
                $classSaleVenue                   = new ClassSaleVenue();
                $classSaleVenue->charge_class_id  = $chargeClass->id;
                $classSaleVenue->venue_id         = $value;
                $classSaleVenue->sale_num         = $venueSaleNum[$key];
                $classSaleVenue->sale_start_time  = NULL;
                $classSaleVenue->sale_end_time    = NULL;
                $classSaleVenue->status           = 2;
                if (!$classSaleVenue->save()) {
                    return $classSaleVenue->errors;
                }
            }
        }
        return true;
    }

    /**
     * @私教管理 - 私教小团体 - 添加服务(添加赠品表)
     * @author 付钟超 <fuzhongchao@itsports.club>
     * @create 2018/01/09
     */
    public function saveGift($chargeClass)
    {
        $giftId = $this->dataArr[3][0];
        $giftNum = $this->dataArr[3][1];
        if (isset($giftId) && $giftId) {
            foreach ($giftId as $key=>$value) {
                $gift = new ChargeClassService();
                $gift->charge_class_id      = $chargeClass->id;
                $gift->gift_id              = (int)$value;
                $gift->type                 = 1;
                $gift->category             = 1;
                $gift->create_time          = time();
                $gift->gift_num             = (int)$giftNum[$key];
            }
        }
        return true;
    }

    /**
     * @私教管理 - 私教小团体 - 添加服务(添加编号表)
     * @author 付钟超 <fuzhongchao@itsports.club>
     * @create 2018/01/09
     */
    public function saveNumber($chargeClass,$ccl,$venue_id,$sale_num)
    {
        $number = substr(date("ymdHis"),2,8).mt_rand(100000,999999);
        $result = ChargeClassNumber::findOne(['class_number'=>$number]);
        if ($result) {
            return '订单编号已存在,请重新填写!';
        }
        $ccn = new ChargeClassNumber();
        $ccn->charge_class_id           = $chargeClass->id;
        $ccn->class_people_id           = $ccl->id;
        $ccn->class_number              = $number;
        $ccn->sell_number               = $ccl->people_most;
        $ccn->surplus                   = $ccl->people_most;
        $ccn->total_class_num           = $this->totalClass;
        $ccn->attend_class_num          = $this->totalClass;
        $ccn->venue_id                  = $venue_id;
        $ccn->company_id                = $chargeClass->company_id;
        $ccn->valid_time                = $chargeClass->valid_time;
        $ccn->sale_num                  = $sale_num;
        $ccn->surplus_sale_num          = $sale_num;
        $ccn = $ccn->save() ? $ccn : $ccn->errors;
        if (!isset($ccn->id)){
            return $ccn->errors;
        }
    }
}