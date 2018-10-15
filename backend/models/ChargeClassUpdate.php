<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21 0021
 * Time: 下午 5:46
 */
namespace backend\models;

use common\models\base\ChargeClass;
use common\models\base\ChargeClassPrice;
use common\models\base\ChargeClassService;
use common\models\base\ClassSaleVenue;
use common\models\base\CoursePackageDetail;
use Yii;
use yii\base\Model;

class ChargeClassUpdate extends Model
{
    public $scenarios;       //场景
    public $chargeId;        //私课id
    public $type;            //类型：1多课程，2单课程

    public $name;            //产品名称
    public $productType;     //产品类型：1常规pt，2特色课，3游泳课
    public $validTime;       //产品有效期限
    public $validUnit;       //产品有效期限单位
    public $activatedTime;   //产品激活期限
    public $activatedUnit;   //产品激活期限单位
    public $sellNum;         //售卖总数量
    public $sellStart;       //售卖开始日期
    public $sellEnd;         //售卖结束日期
    public $courseType;      //课程类型:1购买，2赠送
    public $monthNum;        //每月上课数量
    public $belongVenue;     //所属场馆

    public $courseId;        //课种id
    public $courseLength;    //课程时长
    public $courseNum;       //课程节数
    public $originalPrice;   //单节原价
    public $appOriginalPrice;//移动端单节原价

    public $totalPrice;      //总售价
    public $totalPos;        //总pos价
    public $appTotalPrice;   //移动端总售价
    public $intervalStart;   //区间开始节数
    public $intervalEnd;     //区间结束节数
    public $unitPrice;       //优惠单价
    public $unitPos;         //POS价
    public $appDiscount;     //移动端折扣

    public $sellVenueId;     //售卖场馆id
    public $sellVenueNum;    //单馆售卖数量

    public $giftId;          //赠品id
    public $giftNum;         //赠品数量

    public $transferNum;     //转让次数
    public $transferPrice;   //转让金额

    public $note;            //课程介绍
    public $pic;             //照片

    public $dealId;          //合同id

    /**
     * @卡种管理 - 私课修改 - 场景多表单定义
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/12/21
     * @return array
     */
    public function scenarios()
    {
        return [
            "attributes" => ["scenarios","chargeId","type","name","productType","validTime","validUnit","activatedTime","activatedUnit","sellNum","sellStart","sellEnd","courseType","monthNum","belongVenue"],
            "course"     => ["scenarios","chargeId","type","courseId","courseLength","courseNum","originalPrice","appOriginalPrice"],
            "price"      => ["scenarios","chargeId","type","totalPrice","totalPos","appTotalPrice","intervalStart","intervalEnd","unitPrice","unitPos","appDiscount"],
            "sellVenue"  => ["scenarios","chargeId","sellVenueId","sellVenueNum"],
            "gift"       => ["scenarios","chargeId","giftId","giftNum"],
            "transfer"   => ["scenarios","chargeId","transferNum","transferPrice"],
            "note"       => ["scenarios","chargeId","note","pic"],
            "deal"       => ["scenarios","chargeId","dealId"],
        ];
    }

    /**
     * @卡种管理 - 私课修改 - 基本属性的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/12/22
     * @return boolean
     */
    public function attributesUpdate()
    {
        $orga        = \common\models\base\Organization::findOne(['id' => $this->belongVenue]);
        $chargeClass = ChargeClass::findOne(['id' => $this->chargeId]);
        $chargeClass->name            = $this->name;
        $chargeClass->product_type    = $this->productType;
        $chargeClass->activated_time  = $this->activatedTime * $this->activatedUnit;
        $chargeClass->total_sale_num  = $this->sellNum;
        $chargeClass->sale_start_time = strtotime($this->sellStart);
        $chargeClass->sale_end_time   = strtotime($this->sellEnd)+86399;
        $chargeClass->course_type     = $this->courseType;
        $chargeClass->venue_id        = $this->belongVenue;
        $chargeClass->company_id      = $orga['pid'];
        if($this->type == '1'){
            $chargeClass->valid_time   = $this->validTime * $this->validUnit;
        }else{
            $chargeClass->month_up_num = $this->monthNum;
        }
        if($chargeClass->save() == true){
            return true;
        }else{
            return $chargeClass->errors;
        }
    }

    /**
     * @卡种管理 - 私课修改 - 课种的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/12/22
     * @return boolean
     */
    public function courseUpdate()
    {
        if($this->type == '1'){
            $totalOriginal    = 0;
            $appTotalOriginal = 0;
            foreach ($this->courseNum as $key => $value) {
                $totalOriginal    = $totalOriginal + ($value * $this->originalPrice[$key]);
                $appTotalOriginal = $appTotalOriginal + ($value * $this->appOriginalPrice[$key]);
            }
            $charge = ChargeClass::findOne(['id' => $this->chargeId]);
            $charge->original_price     = $totalOriginal;
            $charge->app_original_price = $appTotalOriginal;
            $charge->save();
            
            $course = CoursePackageDetail::find()->where(['charge_class_id' => $this->chargeId])->asArray();
            if(!empty($course->all())){
                $idArr  = array_column($course->all(),'id');
                $data   = [];
                $data[] = [$this->courseId,$this->courseLength,$this->courseNum,$this->originalPrice,$this->appOriginalPrice,$idArr];
                $courseId         = $data[0][0];
                $courseLength     = $data[0][1];
                $courseNum        = $data[0][2];
                $originalPrice    = $data[0][3];
                $appOriginalPrice = $data[0][4];
                $idArr            = $data[0][5];
                if (count($this->courseId) >= $course->count()) {
                    foreach ($courseId as $key=>$value) {
                        if (!empty($idArr[$key])) {
                            $course = CoursePackageDetail::findOne(['id' => $idArr[$key]]);
                            $course->course_id      = $value;
                            $course->course_length  = $courseLength[$key];
                            $course->course_num     = $courseNum[$key];
                            $course->original_price = $originalPrice[$key];
                            $course->app_original   = $appOriginalPrice[$key];
                        } else {
                            $course = new CoursePackageDetail();
                            $course->charge_class_id = $this->chargeId;
                            $course->course_id       = $value;
                            $course->course_length   = $courseLength[$key];
                            $course->course_num      = $courseNum[$key];
                            $course->original_price  = $originalPrice[$key];
                            $course->type            = 1;
                            $course->create_at       = time();
                            $course->category        = 1;
                            $course->app_original    = $appOriginalPrice[$key];
                        }
                        if($course->save() != true){
                            return $course->errors;
                        }
                    }
                    return true;
                } else {
                    foreach ($idArr as $key=>$value) {
                        if (!empty($courseId[$key])) {
                            $course = CoursePackageDetail::findOne(['id' => $value]);
                            $course->course_id      = $courseId[$key];
                            $course->course_length  = $courseLength[$key];
                            $course->course_num     = $courseNum[$key];
                            $course->original_price = $originalPrice[$key];
                            $course->app_original   = $appOriginalPrice[$key];
                            if ($course->save() != true) {
                                return $course->errors;
                            }
                        } else {
                            CoursePackageDetail::findOne(['id' => $value])->delete();
                        }
                    }
                    return true;
                }
            } else {
                $data   = [];
                $data[] = [$this->courseId,$this->courseLength,$this->courseNum,$this->originalPrice,$this->appOriginalPrice];
                $courseId         = $data[0][0];
                $courseLength     = $data[0][1];
                $courseNum        = $data[0][2];
                $originalPrice    = $data[0][3];
                $appOriginalPrice = $data[0][4];
                if(!empty($courseId)){
                    foreach ($courseId as $key=>$value) {
                        $course = new CoursePackageDetail();
                        $course->charge_class_id = $this->chargeId;
                        $course->course_id       = $value;
                        $course->course_length   = $courseLength[$key];
                        $course->course_num      = $courseNum[$key];
                        $course->original_price  = $originalPrice[$key];
                        $course->type            = 1;
                        $course->create_at       = time();
                        $course->category        = 1;
                        $course->app_original    = $appOriginalPrice[$key];
                        if($course->save() != true){
                            return $course->errors;
                        }
                    }
                    return true;
                }
            }
        }else{
            $course = CoursePackageDetail::findOne(['charge_class_id' => $this->chargeId]);
            $course->course_id      = $this->courseId;
            $course->course_length  = $this->courseLength;
            $course->original_price = $this->originalPrice;
            $course->app_original   = $this->appOriginalPrice;
            if($course->save() == true){
                return true;
            }else{
                return $course->errors;
            }
        }
    }

    /**
     * @卡种管理 - 私课修改 - 价格的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/12/23
     * @return boolean
     */
    public function priceUpdate()
    {
        if($this->type == '1'){
            $chargeClass = ChargeClass::findOne(['id' => $this->chargeId]);
            $chargeClass->total_amount    = $this->totalPrice;      //总售价
            $chargeClass->total_pos_price = $this->totalPos;        //总pos价
            $chargeClass->app_amount      = $this->appTotalPrice;   //移动端总售价
            if($chargeClass->save() == true){
                return true;
            }else{
                return $chargeClass->errors;
            }
        }else{
            $price  = ChargeClassPrice::find()->where(['charge_class_id' => $this->chargeId])->asArray();
            $course = CoursePackageDetail::findOne(['charge_class_id' => $this->chargeId]);
            if(!empty($price->all())){
                $idArr   = array_column($price->all(),'id');
                $data    = [];
                $data[]  = [$this->intervalStart,$this->intervalEnd,$this->unitPrice,$this->unitPos,$this->appDiscount,$idArr];
                $intervalStart = $data[0][0];
                $intervalEnd   = $data[0][1];
                $unitPrice     = $data[0][2];
                $unitPos       = $data[0][3];
                $appDiscount   = $data[0][4];
                $idArr         = $data[0][5];
                if (count($this->intervalStart) >= $price->count()) {
                    foreach ($intervalStart as $key=>$value) {
                        if (!empty($idArr[$key])) {
                            $price = ChargeClassPrice::findOne(['id' => $idArr[$key]]);
                            $price->intervalStart = $value;                //区间开始数量
                            $price->intervalEnd   = $intervalEnd[$key];    //区间结束数量
                            $price->unitPrice     = $unitPrice[$key];      //优惠单价
                            $price->posPrice      = $unitPos[$key];        //pos价
                            $price->app_discount  = $appDiscount[$key];    //移动端折扣
                        } else {
                            $price                           = new ChargeClassPrice();
                            $price->charge_class_id          = $this->chargeId;         //收费课程表id
                            $price->course_package_detail_id = $course->id;             //课程套餐详情表id
                            $price->intervalStart            = $value;                  //区间开始数量
                            $price->intervalEnd              = $intervalEnd[$key];      //区间结束数量
                            $price->unitPrice                = $unitPrice[$key];        //优惠单价
                            $price->posPrice                 = $unitPos[$key];          //pos价
                            $price->create_time              = time();                  //创建时间
                            $price->app_discount             = $appDiscount[$key];      //移动端折扣
                        }
                        if($price->save() != true){
                            return $price->errors;
                        }
                    }
                    return true;
                } else {
                    foreach ($idArr as $key=>$value) {
                        if (!empty($intervalEnd[$key])) {
                            $price = ChargeClassPrice::findOne(['id' => $value]);
                            $price->intervalStart = $intervalStart[$key];     //区间开始数量
                            $price->intervalEnd   = $intervalEnd[$key];       //区间结束数量
                            $price->unitPrice     = $unitPrice[$key];         //优惠单价
                            $price->posPrice      = $unitPos[$key];           //pos价
                            $price->app_discount  = $appDiscount[$key];    //移动端折扣
                            if ($price->save() != true) {
                                return $price->errors;
                            }
                        } else {
                            ChargeClassPrice::findOne(['id' => $value])->delete();
                        }
                    }
                    return true;
                }
            } else {
                $data    = [];
                $data[]  = [$this->intervalStart,$this->intervalEnd,$this->unitPrice,$this->unitPos,$this->appDiscount];
                $intervalStart = $data[0][0];
                $intervalEnd   = $data[0][1];
                $unitPrice     = $data[0][2];
                $unitPos       = $data[0][3];
                $appDiscount   = $data[0][4];
                if(!empty($intervalEnd)){
                    foreach ($intervalEnd as $key=>$value) {
                        $price                           = new ChargeClassPrice();
                        $price->charge_class_id          = $this->chargeId;         //收费课程表id
                        $price->course_package_detail_id = $course->id;             //课程套餐详情表id
                        $price->intervalStart            = $intervalStart[$key];    //区间开始数量
                        $price->intervalEnd              = $value;                  //区间结束数量
                        $price->unitPrice                = $unitPrice[$key];        //优惠单价
                        $price->posPrice                 = $unitPos[$key];          //pos价
                        $price->create_time              = time();                  //创建时间
                        $price->app_discount             = $appDiscount[$key];      //移动端折扣
                        if($price->save() != true){
                            return $price->errors;
                        }
                    }
                    return true;
                }
            }
        }
    }

    /**
     * @卡种管理 - 私课修改 - 售卖场馆的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/12/23
     * @return boolean
     */
    public function sellVenueUpdate()
    {
        $saleVenue = ClassSaleVenue::find()->where(['charge_class_id' => $this->chargeId])->asArray();
        if(!empty($saleVenue->all())){
            $idArr   = array_column($saleVenue->all(),'id');
            $data    = [];
            $data[]  = [$this->sellVenueId,$this->sellVenueNum,$idArr];
            $sellVenueId  = $data[0][0];
            $sellVenueNum = $data[0][1];
            $idArr        = $data[0][2];
            if (count($this->sellVenueId) >= $saleVenue->count()) {
                foreach ($sellVenueId as $key=>$value) {
                    if (!empty($idArr[$key])) {
                        $saleVenue = ClassSaleVenue::findOne(['id' => $idArr[$key]]);
                        $saleVenue->venue_id = $value;
                        $saleVenue->sale_num = $sellVenueNum[$key];
                    } else {
                        $saleVenue                  = new ClassSaleVenue();
                        $saleVenue->charge_class_id = $this->chargeId;        //收费课程表id
                        $saleVenue->venue_id        = $value;                 //场馆id
                        $saleVenue->sale_num        = $sellVenueNum[$key];    //售卖数量
                        $saleVenue->sale_start_time = NULL;
                        $saleVenue->sale_end_time   = NULL;
                        $saleVenue->status          = 1;                      //1表示私课
                    }
                    if($saleVenue->save() != true){
                        return $saleVenue->errors;
                    }
                }
                return true;
            } else {
                foreach ($idArr as $key=>$value) {
                    if (!empty($sellVenueId[$key])) {
                        $saleVenue = ClassSaleVenue::findOne(['id' => $value]);
                        $saleVenue->venue_id = $sellVenueId[$key];
                        $saleVenue->sale_num = $sellVenueNum[$key];
                        if ($saleVenue->save() != true) {
                            return $saleVenue->errors;
                        }
                    } else {
                        ClassSaleVenue::findOne(['id' => $value])->delete();
                    }
                }
                return true;
            }
        } else {
            $data    = [];
            $data[]  = [$this->sellVenueId,$this->sellVenueNum];
            $sellVenueId  = $data[0][0];
            $sellVenueNum = $data[0][1];
            if(!empty($sellVenueId)){
                foreach ($sellVenueId as $key=>$value) {
                    $saleVenue                  = new ClassSaleVenue();
                    $saleVenue->charge_class_id = $this->chargeId;        //收费课程表id
                    $saleVenue->venue_id        = $value;                 //场馆id
                    $saleVenue->sale_num        = $sellVenueNum[$key];    //售卖数量
                    $saleVenue->sale_start_time = NULL;
                    $saleVenue->sale_end_time   = NULL;
                    $saleVenue->status          = 1;                      //1表示私课
                    if($saleVenue->save() != true){
                        return $saleVenue->errors;
                    }
                }
                return true;
            }
        }
    }

    /**
     * @卡种管理 - 私课修改 - 赠品的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/12/23
     * @return boolean
     */
    public function giftUpdate()
    {
        $gift = ChargeClassService::find()->where(['charge_class_id' => $this->chargeId,'type' => 2])->asArray();
        if(!empty($gift->all())){
            $idArr   = array_column($gift->all(),'id');
            $data    = [];
            $data[]  = [$this->giftId,$this->giftNum,$idArr];
            $giftId  = $data[0][0];
            $giftNum = $data[0][1];
            $idArr   = $data[0][2];
            if (count($this->giftId) >= $gift->count()) {
                foreach ($giftId as $key=>$value) {
                    if (!empty($idArr[$key])) {
                        $gift = ChargeClassService::findOne(['id' => $idArr[$key]]);
                        $gift->gift_id  = $value;
                        $gift->gift_num = $giftNum[$key];
                    } else {
                        $gift                   = new ChargeClassService();
                        $gift->charge_class_id  = $this->chargeId;           //收费课程id
                        $gift->gift_id          = $value;                    //赠品id
                        $gift->gift_num         = $giftNum[$key];            //赠品数量
                        $gift->type             = 2;                         //2赠品
                        $gift->category         = 1;                         //1表示私课
                        $gift->create_time      = time();                    //创建时间
                    }
                    if($gift->save() != true){
                        return $gift->errors;
                    }
                }
                return true;
            } else {
                foreach ($idArr as $key=>$value) {
                    if (!empty($giftId[$key])) {
                        $gift = ChargeClassService::findOne(['id' => $value]);
                        $gift->gift_id  = $giftId[$key];
                        $gift->gift_num = $giftNum[$key];
                        if ($gift->save() != true) {
                            return $gift->errors;
                        }
                    } else {
                        ChargeClassService::findOne(['id' => $value])->delete();
                    }
                }
                return true;
            }
        } else {
            $data    = [];
            $data[]  = [$this->giftId,$this->giftNum];
            $giftId  = $data[0][0];
            $giftNum = $data[0][1];
            if(!empty($giftId)){
                foreach ($giftId as $key=>$value) {
                    $gift                   = new ChargeClassService();
                    $gift->charge_class_id  = $this->chargeId;           //收费课程id
                    $gift->gift_id          = $value;                    //赠品id
                    $gift->gift_num         = $giftNum[$key];            //赠品数量
                    $gift->type             = 2;                         //2赠品
                    $gift->category         = 1;                         //1表示私课
                    $gift->create_time      = time();                    //创建时间
                    if($gift->save() != true){
                        return $gift->errors;
                    }
                }
                return true;
            }
        }
    }

    /**
     * @卡种管理 - 私课修改 - 转让设置的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/12/21
     * @return boolean
     */
    public function transferUpdate()
    {
        $chargeClass = ChargeClass::findOne(['id' => $this->chargeId]);
        $chargeClass->transfer_num   = $this->transferNum;
        $chargeClass->transfer_price = $this->transferPrice;
        if($chargeClass->save() == true){
            return true;
        }else{
            return $chargeClass->errors;
        }
    }

    /**
     * @卡种管理 - 私课修改 - 课程介绍、照片的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/12/21
     * @return boolean
     */
    public function noteUpdate()
    {
        $chargeClass = ChargeClass::findOne(['id' => $this->chargeId]);
        $chargeClass->describe = $this->note;
        $chargeClass->pic      = $this->pic;
        if($chargeClass->save() == true){
            return true;
        }else{
            return $chargeClass->errors;
        }
    }

    /**
     * @卡种管理 - 私课修改 - 合同的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/12/22
     * @return boolean
     */
    public function dealUpdate()
    {
        $chargeClass = ChargeClass::findOne(['id' => $this->chargeId]);
        $chargeClass->deal_id = $this->dealId;
        if($chargeClass->save() == true){
            return true;
        }else{
            return $chargeClass->errors;
        }
    }
}