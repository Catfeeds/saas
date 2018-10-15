<?php
namespace backend\models;

use common\models\base\BindPack;
use common\models\base\CardCategory;
use common\models\base\CardDiscount;
use common\models\base\CardTime;
use common\models\base\LimitCardNumber;
use common\models\base\MemberCard;
use common\models\base\MemberCardTime;
use Yii;
use yii\base\Model;

class CardCategoryUpdate extends Model
{
    public $scenarios;       //场景
    public $cardId;          //卡种id

    public $belongVenue;    //卡种所属场馆
    public $attributes;     //卡的属性
    public $cardType;       //卡的类型
    public $cardName;       //卡的名称
    public $anotherName;    //卡别名
    public $activeTime;     //激活期限
    public $activeUnit;     //激活期限单位
    public $duration;       //有效天数
    public $durationUnit;   //有效天数单位
    public $singular;       //单数
    public $bring;          //带人
    public $times;          //次数
    public $timesType;      //扣次方式
    public $pic;            //图片

    public $originalPrice;   //一口原价
    public $sellPrice;       //一口售价
    public $minPrice;        //最低价
    public $maxPrice;        //最高价
    public $offerPrice;      //优惠价
    public $appSellPrice;    //移动端售价
    public $ordinaryRenew;   //普通续费价
    public $validityRenew;   //有效期续费(天数、单位、价格)

    public $sellVenueId;     //售卖场馆
    public $sellNum;         //售卖张数
    public $sellStart;       //售卖开始日期
    public $sellEnd;         //售卖结束日期
    public $discount;        //折扣（几折）
    public $discountNum;     //折扣价售卖数

    public $applyVenueId;    //通用场馆id
    public $venueType;       //场馆类型(1普通，2尊爵)
    public $applyStart;      //进馆开始时间
    public $applyEnd;        //进馆结束时间
    public $applyTimes;      //通店次数
    public $applyUnit;       //通店次数单位
    public $cardLevel;       //卡的等级
    public $applyLength;     //通用场馆id数量
    public $aboutLimit;      //团课预约设置

    public $day;              //每个月的几号（数组）
    public $dayStart;         //天的开始时间
    public $dayEnd;           //天的结束时间
    public $week;             //星期（数组）
    public $weekStart;        //星期的开始时间
    public $weekEnd;          //星期的结束时间

    public $groupClassId;       //团课id
    public $groupNum;           //团课节数
    public $bindLength;         //团课id数量

    public $hsId;               //HS课程id
    public $hsNum;              //HS课程节数
    public $ptId;               //PT课程id
    public $ptNum;              //PT课程节数
    public $birthId;            //生日课id
    public $birthNum;           //生日课节数

    public $giftId;             //赠品id
    public $giftNum;            //赠品数量

    public $transferNum;        //转让次数
    public $transferPrice;      //转让价格

    public $leaveTotalDays;     //请假总天数
    public $onceLeastDays;      //每次最低天数
    public $leaveDaysArr;       //每次请假天数,请假次数
    public $studentLeaveDaysType;//学生请假天数

    public $deal;               //合同

    public $groupClassArr  = array();
    public $chargeClassArr = array();
    public $giftArr        = array();

    /**
     * @卡种管理 - 卡种修改 - 场景多表单定义
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/26
     * @return array
     */
    public function scenarios()
    {
        return [
            "attributes"  => ["scenarios","cardId","belongVenue","attributes","cardType","cardName","anotherName","activeTime",
                              "activeUnit","duration","durationUnit","singular","bring","times","timesType","pic"],
            "price"       => ["scenarios","cardId","originalPrice","sellPrice","minPrice","maxPrice","offerPrice","appSellPrice","ordinaryRenew","validityRenew"],
            "sellVenue"   => ["scenarios","cardId","sellVenueId","sellNum","sellStart","sellEnd","discount","discountNum"],
            "applyVenue"  => ["scenarios","cardId","applyVenueId","venueType","applyTimes","applyUnit","cardLevel","applyLength",
                              "applyStart","applyEnd","aboutLimit"],
            "time"        => ["scenarios","cardId","day","dayStart","dayEnd","week","weekStart","weekEnd"],
            "groupClass"  => ["scenarios","cardId","groupClassId","groupNum","bindLength"],
            "chargeClass" => ["scenarios","cardId","hsId","hsNum","ptId","ptNum","birthId","birthNum"],
            "gift"        => ["scenarios","cardId","giftId","giftNum"],
            "transfer"    => ["scenarios","cardId","transferNum","transferPrice"],
            "leave"       => ["scenarios","cardId","leaveTotalDays","onceLeastDays","leaveDaysArr","studentLeaveDaysType"],
            "deal"        => ["scenarios","cardId","deal"],
        ];
    }

    /**
     * @卡种管理 - 卡种修改 - 验证规则
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/26
     * @return array
     */
    public function rules()
    {
        return [
            [['scenarios','cardId',
              'belongVenue','attributes','cardType','cardName','anotherName','activeTime','activeUnit','duration','durationUnit','singular','bring','times','timesType','pic',
              'originalPrice','sellPrice','minPrice','maxPrice','offerPrice','appSellPrice','ordinaryRenew','validityRenew',
              'sellVenueId','sellNum','sellStart','sellEnd','discount','discountNum',
              'applyVenueId','venueType','applyTimes','applyUnit','cardLevel','applyLength','applyStart','applyEnd','aboutLimit',
              'day','dayStart','dayEnd','week','weekStart','weekEnd',
              'groupClassId','groupNum','bindLength',
              'hsId','hsNum','ptId','ptNum','birthId','birthNum',
              'giftId','giftNum',
              'transferNum','transferPrice',
              'leaveTotalDays','onceLeastDays','leaveDaysArr','studentLeaveDaysType',
              'deal',
            ],'safe'],
        ];
    }

    /**
     * @卡种管理 - 卡种修改 - 基本属性的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/26
     * @return boolean
     */
    public function attributesUpdate()
    {
        $card = CardCategory::find()->where(['and',['venue_id' => $this->belongVenue],['card_name' => $this->cardName],['<>','id',$this->cardId]])->one();
        if (isset($card)) {
            return '卡名称已存在';
        }
        $cardCategory = CardCategory::findOne(['id' => $this->cardId]);
        $cardCategory->venue_id     = $this->belongVenue;
        $cardCategory->attributes   = $this->attributes;
        $cardCategory->card_type    = $this->cardType;
        $cardCategory->card_name    = $this->cardName;
        $cardCategory->another_name = $this->anotherName;
        $cardCategory->active_time  = (int)$this->activeTime * (int)$this->activeUnit;
        $cardCategory->duration     = json_encode(['day'=>(int)$this->duration * (int)$this->durationUnit]);
        $cardCategory->single       = $this->singular;
        $cardCategory->bring        = $this->bring;
        $cardCategory->times        = $this->times;
        $cardCategory->count_method = $this->timesType;
        $cardCategory->pic          = $this->pic;
        if($cardCategory->save() == true){
            return true;
        }else{
            return $cardCategory->errors;
        }
    }

    /**
     * @卡种管理 - 卡种修改 - 定价和售卖的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/26
     * @return boolean
     */
    public function priceUpdate()
    {
        $cardCategory = CardCategory::findOne(['id' => $this->cardId]);
        $renew        = json_decode($cardCategory->validity_renewal,true);         //卡种有效期续费
        MemberCard::updateAll(['ordinary_renewal'=>$cardCategory['ordinary_renewal'],'validity_renewal'=>json_encode($renew)],['card_category_id'=>$this->cardId,'ordinary_renewal'=>NULL,'validity_renewal'=>NULL]);
        $cardCategory->original_price   = $this->originalPrice;
        $cardCategory->sell_price       = $this->sellPrice;
        $cardCategory->min_price        = $this->minPrice;
        $cardCategory->max_price        = $this->maxPrice;
        $cardCategory->offer_price      = $this->offerPrice;
        $cardCategory->ordinary_renewal = $this->ordinaryRenew;
        $cardCategory->validity_renewal = json_encode($this->validityRenew);
        $cardCategory->app_sell_price   = $this->appSellPrice;
        if($cardCategory->save() == true){
            return true;
        }else{
            return $cardCategory->errors;
        }
    }

    /**
     * @卡种管理 - 卡种修改 - 售卖场馆的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/30
     * @return boolean
     */
    public function sellVenueUpdate()
    {
        $limitCard = LimitCardNumber::find()->where(['and',['card_category_id' => $this->cardId],['IS NOT','limit',NULL]])->asArray();
        if (!empty($limitCard->all())) {
            $idArr  = array_column($limitCard->all(),'id');
            $data   = [];
            $data[] = [$this->sellVenueId,$this->sellNum,$this->sellStart,$this->sellEnd,$this->discount,$this->discountNum,$idArr];
            $sellVenueId = $data[0][0];
            $sellNum     = $data[0][1];
            $sellStart   = $data[0][2];
            $sellEnd     = $data[0][3];
            $discount    = $data[0][4];
            $discountNum = $data[0][5];
            $idArr       = $data[0][6];
            CardDiscount::deleteAll(['limit_card_id' => $idArr]);
            if (count($this->sellVenueId) >= $limitCard->count()) {
                foreach ($sellVenueId as $key=>$value) {
                    if (!empty($idArr[$key])) {
                        $limit = LimitCardNumber::findOne(['id' => $idArr[$key],'status'=>[2,3]]);
                        if (!empty($limit) && $limit) {
                            $limit->venue_id        = $value;
                            $limit->limit           = $sellNum[$key];
                            $limit->sell_start_time = strtotime($sellStart[$key]);
                            $limit->sell_end_time   = strtotime($sellEnd[$key].' 23:59:59');
                            $limit->surplus         = $sellNum[$key];
                            $limit->status          = 2;
                            $limit->venue_ids       = NULL;
                        } else {
                            $limit = new LimitCardNumber();
                            $limit->card_category_id = $this->cardId;
                            $limit->venue_id         = $value;
                            $limit->limit            = $sellNum[$key];
                            $limit->sell_start_time  = strtotime($sellStart[$key]);
                            $limit->sell_end_time    = strtotime($sellEnd[$key].' 23:59:59');
                            $limit->surplus          = $sellNum[$key];
                            $limit->status           = 2;
                        }
                        if ($limit->save() != true) {
                            return $limit->errors;
                        }
                        $discountUpdate = $this->discountUpdate($limit->id,$discount[$key],$discountNum[$key]);
                        if ($discountUpdate != true) {
                            return $discountUpdate;
                        }
                    } else {
                        $limit = new LimitCardNumber();
                        $limit->card_category_id = $this->cardId;
                        $limit->venue_id         = $value;
                        $limit->limit            = $sellNum[$key];
                        $limit->sell_start_time  = strtotime($sellStart[$key]);
                        $limit->sell_end_time    = strtotime($sellEnd[$key].' 23:59:59');
                        $limit->surplus          = $sellNum[$key];
                        $limit->status           = 2;
                        if ($limit->save() != true) {
                            return $limit->errors;
                        }
                        $discountUpdate = $this->discountUpdate($limit->id,$discount[$key],$discountNum[$key]);
                        if ($discountUpdate != true) {
                            return $discountUpdate;
                        }
                    }
                }
                return true;
            } else {
                foreach ($idArr as $key=>$value) {
                    $limit = LimitCardNumber::findOne(['id' => $value]);
                    if (!empty($sellVenueId[$key])) {
                        if (empty($limit['times']) && empty($limit['week_times'])) {
                            $limit->venue_id        = $sellVenueId[$key];
                            $limit->limit           = $sellNum[$key];
                            $limit->sell_start_time = strtotime($sellStart[$key]);
                            $limit->sell_end_time   = strtotime($sellEnd[$key].' 23:59:59');
                            $limit->surplus         = $sellNum[$key];
                            $limit->status          = 2;
                            $limit->venue_ids       = NULL;
                            if ($limit->save() != true) {
                                return $limit->errors;
                            }
                        } else {
                            $limit->limit           = NULL;
                            $limit->sell_start_time = NULL;
                            $limit->sell_end_time   = NULL;
                            $limit->surplus         = NULL;
                            $limit->status          = 1;
                            if ($limit->save() != true) {
                                return $limit->errors;
                            }

                            $limits = new LimitCardNumber();
                            $limits->card_category_id = $this->cardId;
                            $limits->venue_id         = $sellVenueId[$key];
                            $limits->limit            = $sellNum[$key];
                            $limits->sell_start_time  = strtotime($sellStart[$key]);
                            $limits->sell_end_time    = strtotime($sellEnd[$key].' 23:59:59');
                            $limits->surplus          = $sellNum[$key];
                            $limits->status           = 2;
                            if ($limits->save() != true) {
                                return $limits->errors;
                            }
                        }
                        $discountUpdate = $this->discountUpdate($limit->id,$discount[$key],$discountNum[$key]);
                        if ($discountUpdate != true) {
                            return $discountUpdate;
                        }
                    } else {
                        if (empty($limit['times']) && empty($limit['week_times'])) {
                            $limit->delete();
                        } else {
                            $limit->limit           = NULL;
                            $limit->sell_start_time = NULL;
                            $limit->sell_end_time   = NULL;
                            $limit->surplus         = NULL;
                            $limit->status          = 1;
                            if ($limit->save() != true) {
                                return $limit->errors;
                            }
                            $discountUpdate = $this->discountUpdate($limit->id,$discount[$key],$discountNum[$key]);
                            if ($discountUpdate != true) {
                                return $discountUpdate;
                            }
                        }
                    }
                }
                return true;
            }
        } else {
            $data   = [];
            $data[] = [$this->sellVenueId,$this->sellNum,$this->sellStart,$this->sellEnd,$this->discount,$this->discountNum];
            $sellVenueId = $data[0][0];
            $sellNum     = $data[0][1];
            $sellStart   = $data[0][2];
            $sellEnd     = $data[0][3];
            $discount    = $data[0][4];
            $discountNum = $data[0][5];
            if (!empty($sellVenueId)) {
                foreach ($sellVenueId as $key=>$value) {
                    $limit = new LimitCardNumber();
                    $limit->card_category_id = $this->cardId;
                    $limit->venue_id         = $value;
                    $limit->limit            = $sellNum[$key];
                    $limit->sell_start_time  = strtotime($sellStart[$key]);
                    $limit->sell_end_time    = strtotime($sellEnd[$key].' 23:59:59');
                    $limit->surplus          = $sellNum[$key];
                    $limit->status           = 2;
                    if ($limit->save() != true) {
                        return $limit->errors;
                    }
                    $discountUpdate = $this->discountUpdate($limit->id,$discount[$key],$discountNum[$key]);
                    if ($discountUpdate != true) {
                        return $discountUpdate;
                    }
                }
                return true;
            }
            return true;
        }
    }

    /**
     * @卡种管理 - 卡种修改 - 售卖场馆折扣的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/30
     * @return boolean
     */
    public function discountUpdate($limitCardId,$discount,$discountNum)
    {
        $data   = [];
        $data[] = [$discount,$discountNum];
        $discount    = $data[0][0];
        $discountNum = $data[0][1];
        foreach ($discount as $key=>$value) {
            if(!empty($value)){
                $cardDis = new CardDiscount();
                $cardDis->limit_card_id = $limitCardId;
                $cardDis->surplus       = $discountNum[$key];
                $cardDis->discount      = $value;
                $cardDis->create_at     = time();
                $cardDis->update_at     = time();
                if($cardDis->save() != true){
                    return $cardDis->errors;
                }
            }
        }
        return true;

//        $cardDiscount = CardDiscount::find()->where(['limit_card_id' => $oldId])->asArray();
//        if (!empty($cardDiscount->all())) {
//            $idArr  = array_column($cardDiscount->all(),'id');
//            $data   = [];
//            $data[] = [$discount[0],$discountNum[0],$idArr];
//            $discount    = $data[0][0];
//            $discountNum = $data[0][1];
//            $idArr       = $data[0][2];
//            if (count($discount) >= $cardDiscount->count()) {
//                foreach ($discount as $key=>$value) {
//                    if (!empty($idArr[$key])) {
//                        $cardDis = CardDiscount::findOne(['id' => $idArr[$key]]);
//                        $cardDis->limit_card_id = $limitCardId;
//                        $cardDis->surplus       = $discountNum[$key];
//                        $cardDis->discount      = $value;
//                        $cardDis->update_at     = time();
//                    } else {
//                        $cardDis = new CardDiscount();
//                        $cardDis->limit_card_id = $limitCardId;
//                        $cardDis->surplus       = $discountNum[$key];
//                        $cardDis->discount      = $value;
//                        $cardDis->create_at     = time();
//                        $cardDis->update_at     = time();
//                    }
//                    if($cardDis->save() != true){
//                        return $cardDis->errors;
//                    }
//                }
//                return true;
//            } else {
//                foreach ($idArr as $key=>$value) {
//                    if (!empty($discount[$key])) {
//                        $cardDis = CardDiscount::findOne(['id' => $value]);
//                        $cardDis->limit_card_id = $limitCardId;
//                        $cardDis->surplus       = $discountNum[$key];
//                        $cardDis->discount      = $discount[$key];
//                        $cardDis->update_at     = time();
//                        if($cardDis->save() != true){
//                            return $cardDis->errors;
//                        }
//                    } else {
//                        CardDiscount::findOne(['id' => $value])->delete();
//                    }
//                }
//                return true;
//            }
//        } else {
//            $data   = [];
//            $data[] = [$discount[0],$discountNum[0]];
//            $discount    = $data[0][0];
//            $discountNum = $data[0][1];
//            if (!empty($discount)) {
//                foreach ($discount as $key=>$value) {
//                    $cardDis = new CardDiscount();
//                    $cardDis->limit_card_id = $limitCardId;
//                    $cardDis->surplus       = $discountNum[$key];
//                    $cardDis->discount      = $value;
//                    $cardDis->create_at     = time();
//                    $cardDis->update_at     = time();
//                    if ($cardDis->save() != true) {
//                        return $cardDis->errors;
//                    }
//                }
//                return true;
//            }
//            return true;
//        }
    }

    /**
     * @卡种管理 - 卡种修改 - 通用场馆的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/26
     * @return boolean
     */
    public function applyVenueUpdate()
    {
        $limitCard = LimitCardNumber::find()
            ->where(['card_category_id' => $this->cardId])
            ->andWhere(['or',['IS NOT','times',NULL],['IS NOT','week_times',NULL]])
            ->asArray();
        if(!empty($limitCard->all())){
            $idArr = array_column($limitCard->all(),'id');
            $data   = [];
            $data[] = [$this->applyVenueId,$this->venueType,$this->applyTimes,$this->applyUnit,
                $this->cardLevel,$this->applyLength,$idArr,$this->applyStart,$this->applyEnd,$this->aboutLimit];
            $applyVenueId = $data[0][0];
            $venueType    = $data[0][1];
            $applyTimes   = $data[0][2];
            $applyUnit    = $data[0][3];
            $cardLevel    = $data[0][4];
            $applyLength  = $data[0][5];
            $idArr        = $data[0][6];
            $applyStart   = $data[0][7];
            $applyEnd     = $data[0][8];
            $aboutLimit   = $data[0][9];
            if (count($this->applyVenueId) > $limitCard->count()) {
                foreach ($applyVenueId as $key=>$value) {
                    if (!empty($idArr[$key])) {
                        $limit = LimitCardNumber::findOne(['id' => $idArr[$key]]);
                        if (empty($limit['limit'])) {
                            $limit->venue_id  = 0;
                            $limit->venue_ids = json_encode($value);
                            $limit->status    = 1;
                            if ($applyUnit[$key] == 'w') {
                                $limit->week_times = $applyTimes[$key];
                                $limit->times      = NULL;
                            } else {
                                $limit->times      = $applyTimes[$key];
                                $limit->week_times = NULL;
                            }
                            $limit->level      = $cardLevel[$key];
                            $limit->identity   = $venueType[$key];
                            $limit->apply_start= strtotime($applyStart[$key])?:NULL;
                            $limit->apply_end  = strtotime($applyEnd[$key])?:NULL;
                            $limit->about_limit= $aboutLimit[$key];
                        } else {
                            $limit = new LimitCardNumber();
                            $limit->card_category_id = $this->cardId;
                            $limit->venue_id         = 0;
                            $limit->venue_ids        = json_encode($value);
                            if ($applyUnit[$key] == 'w') {
                                $limit->week_times = $applyTimes[$key];
                                $limit->times      = NULL;
                            } else {
                                $limit->times      = $applyTimes[$key];
                                $limit->week_times = NULL;
                            }
                            $limit->level          = $cardLevel[$key];
                            $limit->status         = 1;
                            $limit->identity       = $venueType[$key];
                            $limit->apply_start    = strtotime($applyStart[$key])?:NULL;
                            $limit->apply_end      = strtotime($applyEnd[$key])?:NULL;
                            $limit->about_limit    = $aboutLimit[$key];
                        }
                        if ($limit->save() != true) {
                            return $limit->errors;
                        }
                    } else {
                        $limit = new LimitCardNumber();
                        $limit->card_category_id = $this->cardId;
//                        if ($applyLength[$key] == 1) {
//                            $limit->venue_id  = $value[0];
//                            $limit->venue_ids = NULL;
//                        } else {
//                            $limit->venue_id  = 0;
//                            $limit->venue_ids = json_encode($value);
//                        }
                        $limit->venue_id  = 0;
                        $limit->venue_ids = json_encode($value);
                        if ($applyUnit[$key] == 'w') {
                            $limit->week_times = $applyTimes[$key];
                            $limit->times      = NULL;
                        } else {
                            $limit->times      = $applyTimes[$key];
                            $limit->week_times = NULL;
                        }
                        $limit->level          = $cardLevel[$key];
                        $limit->status         = 1;
                        $limit->identity       = $venueType[$key];
                        $limit->apply_start    = strtotime($applyStart[$key])?:NULL;
                        $limit->apply_end      = strtotime($applyEnd[$key])?:NULL;
                        $limit->about_limit    = $aboutLimit[$key];
                    }
                    if ($limit->save() != true) {
                        return $limit->errors;
                    }
                }
                return true;
            } else {
                foreach ($idArr as $key=>$value) {
                    $limit = LimitCardNumber::findOne(['id' => $value]);
                    if (!empty($applyVenueId[$key])) {
                        if (empty($limit['limit'])) {
                            $limit->venue_id  = 0;
                            $limit->venue_ids = json_encode($applyVenueId[$key]);
                            $limit->status = 1;
                            if ($applyUnit[$key] == 'w') {
                                $limit->week_times = $applyTimes[$key];
                                $limit->times      = NULL;
                            } else {
                                $limit->times      = $applyTimes[$key];
                                $limit->week_times = NULL;
                            }
                            $limit->level      = $cardLevel[$key];
                            $limit->identity   = $venueType[$key];
                            $limit->apply_start= strtotime($applyStart[$key])?:NULL;
                            $limit->apply_end  = strtotime($applyEnd[$key])?:NULL;
                            $limit->about_limit= $aboutLimit[$key];
                            if($limit->save() != true){
                                return $limit->errors;
                            }
                        } else {
                            $limit->times      = NULL;
                            $limit->level      = 0;
                            $limit->week_times = NULL;
                            $limit->status     = 2;
                            $limit->identity   = NULL;
                            $limit->apply_start= NULL;
                            $limit->apply_end  = NULL;
                            $limit->about_limit= NULL;
                            if($limit->save() != true){
                                return $limit->errors;
                            }

                            $limits = new LimitCardNumber();
                            $limits->card_category_id = $this->cardId;
                            $limits->venue_id         = 0;
                            $limits->venue_ids        = json_encode($applyVenueId[$key]);
                            if ($applyUnit[$key] == 'w') {
                                $limits->week_times = $applyTimes[$key];
                                $limits->times      = NULL;
                            } else {
                                $limits->times      = $applyTimes[$key];
                                $limits->week_times = NULL;
                            }
                            $limits->level          = $cardLevel[$key];
                            $limits->status         = 1;
                            $limits->identity       = $venueType[$key];
                            $limits->apply_start    = strtotime($applyStart[$key])?:NULL;
                            $limits->apply_end      = strtotime($applyEnd[$key])?:NULL;
                            $limits->about_limit    = $aboutLimit[$key];
                            if($limits->save() != true){
                                return $limits->errors;
                            }
                        }
                    } else {
                        if (empty($limit['limit'])) {
                            $limit->delete();
                        } else {
                            $limit->times      = NULL;
                            $limit->level      = 0;
                            $limit->week_times = NULL;
                            $limit->status     = 2;
                            $limit->identity   = NULL;
                            $limit->apply_start= NULL;
                            $limit->apply_end  = NULL;
                            $limit->about_limit= NULL;
                            if($limit->save() != true){
                                return $limit->errors;
                            }
                        }
                    }
                }
                return true;
            }
        } else {
            $data   = [];
            $data[] = [$this->applyVenueId,$this->venueType,$this->applyTimes,$this->applyUnit,
                $this->cardLevel,$this->applyLength,$this->applyStart,$this->applyEnd,$this->aboutLimit];
            $applyVenueId = $data[0][0];
            $venueType    = $data[0][1];
            $applyTimes   = $data[0][2];
            $applyUnit    = $data[0][3];
            $cardLevel    = $data[0][4];
            $applyLength  = $data[0][5];
            $applyStart   = $data[0][6];
            $applyEnd     = $data[0][7];
            $aboutLimit   = $data[0][8];
            if (!empty($applyVenueId)) {
                foreach ($applyVenueId as $key=>$value) {
                    $limit = new LimitCardNumber();
                    $limit->card_category_id = $this->cardId;
                    $limit->venue_id  = 0;
                    $limit->venue_ids = json_encode($value);
                    if ($applyUnit[$key] == 'w') {
                        $limit->week_times = $applyTimes[$key];
                        $limit->times      = NULL;
                    } else {
                        $limit->times      = $applyTimes[$key];
                        $limit->week_times = NULL;
                    }
                    $limit->level          = $cardLevel[$key];
                    $limit->status         = 1;
                    $limit->identity       = $venueType[$key];
                    $limit->apply_start    = strtotime($applyStart[$key])?:NULL;
                    $limit->apply_end      = strtotime($applyEnd[$key])?:NULL;
                    $limit->about_limit    = $aboutLimit[$key];
                    if($limit->save() != true){
                        return $limit->errors;
                    }
                }
                return true;
            }
            return true;
        }
    }

    /**
     * @卡种管理 - 卡种修改 - 进馆时间的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/26
     * @return boolean
     */
    public function timeUpdate()
    {
        $cardTime = CardTime::findOne(['card_category_id' => $this->cardId]);
        if(!empty($cardTime)){
            $memberCard = MemberCard::find()->where(['card_category_id' => $this->cardId])->select('id')->asArray()->all();
            if(!empty($memberCard)){
                foreach ($memberCard as $key=>$value) {
                    $memberCardTime = MemberCardTime::findOne(['member_card_id' => intval($value)]);
                    if(!isset($memberCardTime)){
                        $memberCardTime                 = new MemberCardTime();
                        $memberCardTime->member_card_id = intval($value);
                        $memberCardTime->start          = $cardTime->start;
                        $memberCardTime->end            = $cardTime->end;
                        $memberCardTime->create_at      = time();
                        $memberCardTime->day            = $cardTime->day;
                        $memberCardTime->week           = $cardTime->week;
                        $memberCardTime->month          = $cardTime->month;
                        $memberCardTime->quarter        = $cardTime->quarter;
                        $memberCardTime->year           = $cardTime->year;
                        if($memberCardTime->save() != true){
                            return $memberCardTime->errors;
                        }
                    }
                }
            }

            $cardTime->update_at = time();
            $cardTime->day       = json_encode(['day'=>$this->day,'start'=>$this->dayStart,'end'=>$this->dayEnd]);
            $cardTime->week      = json_encode(['weeks'=>$this->week,'startTime'=>$this->weekStart,'endTime'=>$this->weekEnd]);
        }else{
            $cardTime = new CardTime();
            $cardTime->card_category_id = $this->cardId;
            $cardTime->create_at        = time();
            $cardTime->day              = json_encode(['day'=>$this->day,'start'=>$this->dayStart,'end'=>$this->dayEnd]);
            $cardTime->week             = json_encode(['weeks'=>$this->week,'startTime'=>$this->weekStart,'endTime'=>$this->weekEnd]);
        }
        if($cardTime->save() == true){
            return true;
        }else{
            return $cardTime->errors;
        }
    }


    /**
     * @卡种管理 - 卡种修改 - 设置团课数组
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/27
     * @return boolean
     */
    public function setGroupClassArr()
    {
        $data   = [];
        $data[] = [$this->groupClassId,$this->groupNum];
        $this->groupClassArr = $data;
    }
    /**
     * @卡种管理 - 卡种修改 - 绑定团课的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/27
     * @return boolean
     */
    public function groupClassUpdate()
    {
        $bindPack = BindPack::find()->where(['card_category_id' => $this->cardId,'polymorphic_type' => 'class'])->asArray();
        if (!empty($bindPack->all())) {
            $idArr  = array_column($bindPack->all(),'id');
            $data   = [];
            $data[] = [$this->groupClassId,$this->groupNum,$this->bindLength,$idArr];
            $groupClassId = $data[0][0];
            $groupNum     = $data[0][1];
            $bindLength   = $data[0][2];
            $idArr        = $data[0][3];
            if (count($this->groupClassId) >= $bindPack->count()) {
                foreach ($groupClassId as $key=>$value) {
                    if (!empty($idArr[$key])) {
                        $bindPack = BindPack::findOne(['id' => $idArr[$key]]);
                        if ($bindLength[$key] == 1) {
                            $bindPack->polymorphic_id  = $value[0];
                            $bindPack->polymorphic_ids = NULL;
                        } else {
                            $bindPack->polymorphic_id  = 0;
                            $bindPack->polymorphic_ids = json_encode($value);
                        }
                        $bindPack->number              = $groupNum[$key];
                    } else {
                        $bindPack = new BindPack();
                        $bindPack->card_category_id = $this->cardId;
                        $bindPack->polymorphic_type = 'class';
                        $bindPack->number           = $groupNum[$key];
                        $bindPack->status           = 1;
                        if ($bindLength[$key] == 1) {
                            $bindPack->polymorphic_id  = $value[0];
                            $bindPack->polymorphic_ids = NULL;
                        } else {
                            $bindPack->polymorphic_id  = 0;
                            $bindPack->polymorphic_ids = json_encode($value);
                        }
                    }
                    if($bindPack->save() != true){
                        return $bindPack->errors;
                    }
                }
                return true;
            } else {
                foreach ($idArr as $key=>$value) {
                    if (!empty($groupClassId[$key])) {
                        $bindPack = BindPack::findOne(['id' => $value]);
                        if ($bindLength[$key] == 1) {
                            $bindPack->polymorphic_id  = $groupClassId[$key][0];
                            $bindPack->polymorphic_ids = NULL;
                        } else {
                            $bindPack->polymorphic_id  = 0;
                            $bindPack->polymorphic_ids = json_encode($groupClassId[$key]);
                        }
                        $bindPack->number         = $groupNum[$key];
                        if($bindPack->save() != true){
                            return $bindPack->errors;
                        }
                    } else {
                        BindPack::findOne(['id' => $value])->delete();
                    }
                }
                return true;
            }
        } else {
            $data   = [];
            $data[] = [$this->groupClassId,$this->groupNum,$this->bindLength];
            $groupClassId = $data[0][0];
            $groupNum     = $data[0][1];
            $bindLength   = $data[0][2];
            if(!empty($groupClassId)){
                foreach ($groupClassId as $key=>$value) {
                    $bindPack = new BindPack();
                    $bindPack->card_category_id = $this->cardId;
                    $bindPack->polymorphic_type = 'class';
                    $bindPack->number           = $groupNum[$key];
                    $bindPack->status           = 1;
                    if ($bindLength[$key] == 1) {
                        $bindPack->polymorphic_id  = $value[0];
                        $bindPack->polymorphic_ids = NULL;
                    } else {
                        $bindPack->polymorphic_id  = 0;
                        $bindPack->polymorphic_ids = json_encode($value);
                    }
                    if($bindPack->save() != true){
                        return $bindPack->errors;
                    }
                }
                return true;
            }
        }
    }

    /**
     * @卡种管理 - 卡种修改 - 设置私课数组
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/27
     * @return boolean
     */
    public function setChargeClassArr()
    {
        $data   = [];
        $data[] = ['hs',$this->hsId,$this->hsNum,4];
        $data[] = ['pt',$this->ptId,$this->ptNum,5];
        $data[] = ['birth',$this->birthId,$this->birthNum,6];
        $this->chargeClassArr = $data;
    }
    /**
     * @卡种管理 - 卡种修改 - 绑定私课的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/26
     * @return boolean
     */
    public function chargeClassUpdate()
    {
        $bindPT = BindPack::findOne(['card_category_id' => $this->cardId,'polymorphic_type' => 'pt']);
        if(!empty($this->ptId) && !empty($this->ptNum)){
            if(!empty($bindPT)){
                $bindPT->polymorphic_id = $this->ptId;
                $bindPT->number         = $this->ptNum;
            }else{
                $bindPT                   = new BindPack();
                $bindPT->card_category_id = $this->cardId;
                $bindPT->polymorphic_type = 'pt';
                $bindPT->polymorphic_id   = $this->ptId;
                $bindPT->number           = $this->ptNum;
                $bindPT->status           = 5;
            }
            $bindPT->save();
        }else{
            if(!empty($bindPT)){
                $bindPT->delete();
            }
        }

        $bindHS = BindPack::findOne(['card_category_id' => $this->cardId,'polymorphic_type' => 'hs']);
        if(!empty($this->hsId) && !empty($this->hsNum)){
            if(!empty($bindHS)){
                $bindHS->polymorphic_id = $this->hsId;
                $bindHS->number         = $this->hsNum;
            }else{
                $bindHS                   = new BindPack();
                $bindHS->card_category_id = $this->cardId;
                $bindHS->polymorphic_type = 'hs';
                $bindHS->polymorphic_id   = $this->hsId;
                $bindHS->number           = $this->hsNum;
                $bindHS->status           = 4;
            }
            $bindHS->save();
        }else{
            if(!empty($bindHS)){
                $bindHS->delete();
            }
        }

        $bindBirth = BindPack::findOne(['card_category_id' => $this->cardId,'polymorphic_type' => 'birth']);
        if(!empty($this->birthId) && !empty($this->birthNum)){
            if(!empty($bindBirth)){
                $bindBirth->polymorphic_id = $this->birthId;
                $bindBirth->number         = $this->birthNum;
            }else{
                $bindBirth                   = new BindPack();
                $bindBirth->card_category_id = $this->cardId;
                $bindBirth->polymorphic_type = 'birth';
                $bindBirth->polymorphic_id   = $this->birthId;
                $bindBirth->number           = $this->birthNum;
                $bindBirth->status           = 6;
            }
            $bindBirth->save();
        }else{
            if(!empty($bindBirth)){
                $bindBirth->delete();
            }
        }
        return true;
    }

    /**
     * @卡种管理 - 卡种修改 - 设置赠品数组
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/26
     * @return boolean
     */
    public function setGiftArr()
    {
        $data   = [];
        $data[] = [$this->giftId,$this->giftNum];
        $this->giftArr = $data;
    }
    /**
     * @卡种管理 - 卡种修改 - 赠品的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/26
     * @return boolean
     */
    public function giftUpdate()
    {
        $bindPack = BindPack::find()->where(['card_category_id' => $this->cardId,'polymorphic_type' => 'gift'])->asArray();
        if(!empty($bindPack->all())){
            $idArr = array_column($bindPack->all(),'id');
            $data    = [];
            $data[]  = [$this->giftId,$this->giftNum,$idArr];
            $giftId  = $data[0][0];
            $giftNum = $data[0][1];
            $idArr   = $data[0][2];
            if (count($this->giftId) >= $bindPack->count()) {
                foreach ($giftId as $key=>$value) {
                    if (!empty($idArr[$key])) {
                        $bindPack = BindPack::findOne(['id' => $idArr[$key]]);
                        $bindPack->polymorphic_id = $value;
                        $bindPack->number         = $giftNum[$key];
                    } else {
                        $bindPack = new BindPack();
                        $bindPack->card_category_id = $this->cardId;
                        $bindPack->polymorphic_type = 'gift';
                        $bindPack->polymorphic_id   = $value;
                        $bindPack->number           = $giftNum[$key];
                        $bindPack->status           = 3;
                    }
                    if($bindPack->save() != true){
                        return $bindPack->errors;
                    }
                }
                return true;
            } else {
                foreach ($idArr as $key=>$value) {
                    if (!empty($giftId[$key])) {
                        $bindPack = BindPack::findOne(['id' => $value]);
                        $bindPack->polymorphic_id = $giftId[$key];
                        $bindPack->number         = $giftNum[$key];
                        if ($bindPack->save() != true) {
                            return $bindPack->errors;
                        }
                    } else {
                        BindPack::findOne(['id' => $value])->delete();
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
                    $bindPack = new BindPack();
                    $bindPack->card_category_id = $this->cardId;
                    $bindPack->polymorphic_type = 'gift';
                    $bindPack->polymorphic_id   = $value;
                    $bindPack->number           = $giftNum[$key];
                    $bindPack->status           = 3;
                    if($bindPack->save() != true){
                        return $bindPack->errors;
                    }
                }
                return true;
            }
        }
    }

    /**
     * @卡种管理 - 卡种修改 - 转让设置的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/26
     * @return boolean
     */
    public function transferUpdate()
    {
        $cardCategory = CardCategory::findOne(['id' => $this->cardId]);
        $cardCategory->transfer_number = $this->transferNum;
        $cardCategory->transfer_price  = $this->transferPrice;
        if($cardCategory->save() == true){
            return true;
        }else{
            return $cardCategory->errors;
        }
    }

    /**
     * @卡种管理 - 卡种修改 - 请假设置的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/26
     * @return boolean
     */
    public function leaveUpdate()
    {
        $cardCategory = CardCategory::findOne(['id' => $this->cardId]);
        $cardCategory->leave_total_days = $this->leaveTotalDays;
        $cardCategory->leave_least_Days = $this->onceLeastDays;
        $cardCategory->leave_long_limit = json_encode($this->leaveDaysArr);
        $cardCategory->student_leave_limit = json_encode($this->studentLeaveDaysType);
        if($cardCategory->save() == true){
            return true;
        }else{
            return $cardCategory->errors;
        }
    }

    /**
     * @卡种管理 - 卡种修改 - 绑定合同的修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/26
     * @return boolean
     */
    public function dealUpdate()
    {
        $cardCategory = CardCategory::findOne(['id' => $this->cardId]);
        $cardCategory->deal_id = $this->deal;
        if($cardCategory->save() == true){
            return true;
        }else{
            return $cardCategory->errors;
        }
    }
}
?>