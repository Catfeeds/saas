<?php
namespace backend\models;
use common\models\base\Approval;
use common\models\base\ApprovalRole;
use common\models\base\ApprovalType;
use common\models\base\CardCategory;
use common\models\base\CardDiscount;
use common\models\base\CardTime;
use common\models\base\Employee;
use common\models\base\LimitCardNumber;
use common\models\base\BindPack;
use common\models\Func;
use yii\base\Model;

class TimesCardForm extends Model
{
    const CARD_DATA = ['One', 'Two', 'Three', 'Four'];
    const BIND      = [['1','class'],['2','server'],['3','goods'],['4','gift'],['5','hs'],['6','pt'],['7','birth']];
    public $attributes;               //卡的属性
    public $cardName;                //卡的名称
    public $anotherName;             //卡种别名
    public $cardTimes;               //卡的次数
    public $timesMethod;            //扣次方式
    public $activationTime;         //激活期限
    public $activationType;         //激活期限类型
    public $validTime;              //有效天数
    public $validTimeType;         //有效天数类型
    public $pic;                   //图片
    public $originalPrice;         //一口原价
    public $sellPrice;              //一口售价
    public $regionOriginalPrice;   //区域原价
    public $regionSellPrice;       //区域售价
    public $onceRenew;              //单次续费价
    public $offerPrice;             //优惠价
    public $appSellPrice;           //移动端售价
    public $renewUnit;            //续费多长时间
    public $sellVenue;             //售卖场馆
    public $sheetsNum;             //售卖张数
    public $totalSheets;           //总售卖张数
    public $sellStartTime;         //售卖开始时间
    public $sellEndTime;           //售卖结束时间
    public $currencyVenue;         //通用场馆
    public $currencyTimes;          //通店次数
    public $applyStart;            //通用开始时间
    public $applyEnd;              //通用结束时间
    public $aboutLimit;            //通用结束时间
    public $day;                     //特定日
    public $dayStartTime;           //特定日的开始时间
    public $dayEndTime;             //特定日的结束时间
    public $cardStartTime;          //卡的开始时间
    public $cardEndTime;           //卡的结束时间
    public $discount;
    public $week;                 //特定星期
    public $weekStartTime;        //特定星期开始时间
    public $weekEndTime;          //特定星期结束时间  1
    public $leagueClass;            //课程名称
    public $leagueTimes;            //每日课程节数
    public $binkClassIsArr;         //团课多选课程
    public $service;               //服务名称
    public $serviceTimes;          //每日服务数量
    public $goodsId;                 //扣次项目名称
    public $goodsNum;             //扣次数量
    public $giftId;                //赠品名称
    public $giftNum;            //赠品数量  2
    //
    public $hsId;                          //HS私教ID
    public $hsNum;                         //HS节数
    //
    public $ptId;                          //PT私教ID
    public $ptNum;                         //PT节数
    //
    public $birthId;                       //Birth私教ID
    public $birthNum;                      //Birth节数
    public $transferTimes;      //转让次数
    public $transferPrice;     //转让金额
    public $totalLeaveDays;    //请假总天数
    public $minLeaveDays;     //每次最低天数
    public $leaveSetDayArr;   //请假次数、每次请假天数  3
    public $deal;             //合同  4
    public $missed_times;
    public $limit_times;
    public $ordinaryRenewal;     //普通续费
    public $validityRenewal;     //有效期续费
    public $level;            //卡种级别
    public $single;           //单数
    public $package = array();
    public $applyWeeksTimes;
    public $applyType;
    public $cardType;
    public $venueId;
    const ATTR      = 'attributes';
    const NOTICE    = '操作失败';

    /**
     * 云运动 - 后台 - 卡种表单构造初始化函数
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/4/14
     */
    public function __construct(array $config,$scenario = 'one')
    {
        if ($scenario != "cancel") {
            $this->scenario = $scenario;
            parent::__construct($config);
        } else {
            $this->removeSession();                     //点击取消删除session
        }
    }

    /**
     * 云运动 - 后台 - 卡种表单使用场景
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/4/10
     */
    public function scenarios()
    {
        return [
            'one'    => [self::ATTR, 'cardName','anotherName','level','applyType','cardType','ordinaryRenewal',
                        'validityRenewal','single', 'cardTimes', 'timesMethod', 'activationTime', 'activationType',
                        'validTime', 'validTimeType', 'originalPrice', 'sellPrice', 'regionOriginalPrice',
                        'regionSellPrice', 'onceRenew','offerPrice','appSellPrice','renewUnit', 'sellVenue', 'sheetsNum',
                        'sellStartTime', 'sellEndTime', 'currencyVenue', 'currencyTimes', 'applyStart','applyEnd','aboutLimit','day', 'dayStartTime',
                        'dayEndTime', 'cardStartTime', 'cardEndTime', 'week', 'weekStartTime', 'weekEndTime','venueId','pic'],
            'two'    => ['leagueClass', 'leagueTimes', 'binkClassIsArr', 'service', 'serviceTimes', 'goodsId', 'goodsNum', 'giftId', 'giftNum','hsId','hsNum','ptId','ptNum','birthId','birthNum'],
            'three'  => ['transferTimes', 'transferPrice', 'totalLeaveDays', 'minLeaveDays', 'leaveSetDayArr'],
            'four'   => ['deal'],
            'finish' => ['deal']
        ];
    }

    /**
     * @云运动 - 后台 - 卡种表单添加(规则验证)
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/4/10
     */
    public function rules()
    {
        return [
            [[self::ATTR, 'cardName', 'cardTimes', 'timesMethod'], 'required'],
            [[self::ATTR, 'cardName', 'cardTimes', 'timesMethod'], 'trim'],
            [[self::ATTR, 'cardTimes', 'timesMethod'], 'integer'],
            [self::ATTR, 'in', 'range' => [1, 2, 3]],
            ['cardName', 'string', 'min' => 2, 'max' => 255],
        ];
    }

    /**
     * @云运动 - 后台 - 卡种表单数据存到session
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/4/15
     */
    public function sessionLoadModel($model,$companyId,$venueId)
    {
        $cardData = [];
        $sceArr = $this->scenarios();
        $sceArr = $sceArr[$this->scenario];
        foreach ($model as $k => $v) {
            if (in_array($k, $sceArr)) {
                $cardData[$k] = $v;
            }
        }
        $this->saveSession($cardData,$companyId,$venueId);
    }

    /**
     * 云运动 - 后台 - 卡种表单设置session
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/4/15
     */
    public function saveSession($cardData,$companyId,$venueId)
    {
        $session = \Yii::$app->session;
        switch ($this->scenario){
            case 'one':
                $session->set('cardDataOne',$cardData);
                break;
            case 'two':
                $session->set('cardDataTwo',$cardData);
                break;
            case 'three':
                $session->set('cardDataThree',$cardData);
                break;
            case 'four':
                $session->set('cardDataFour',$cardData);
                return $this->saveCard($companyId,$venueId);
                break;
            default:
                $session->set('cardDataFour',$cardData);
        }
    }

    /**
     * 云运动 - 后台 - 卡种表单load数据
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/4/15
     */
    public function loadData($data)
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $this->$k = $v;
            }
            return true;
        }
        return false;
    }

    /**
     * @云运动 - 后台 - 卡种表单获取session数据
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/4/15
     */
    public function getSessionCard()
    {
        $session = \Yii::$app->session;
        foreach (self::CARD_DATA as $v){
            $data = $session->get('cardData'.$v);
            $this->loadData($data);
            if ($v == 'Two') {
                $this->setPackage();
            }
        }
    }

    /**
     * 云运动 - 后台 - 配置套餐数组
     * @return bool
     */
    public function setPackage()
    {
        $data = [];
        $data[] = [$this->leagueClass,$this->leagueTimes];
        $data[] = [$this->service,$this->serviceTimes];
        $data[] = [$this->goodsId,$this->goodsNum];
        $data[] = [$this->giftId,$this->giftNum];
        $data[] = [$this->hsNum,$this->hsId];
        $data[] = [$this->ptNum,$this->ptNum];
        $data[] = [$this->birthNum,$this->birthId];
        $this->package = $data;
        return true;
    }

    /**
     * @云运动 - 后台 - 卡种表单数据保存到数据库
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/4/10
     */
    public function saveCard($companyId,$venueId)
    {
        $venueId = !empty($this->venueId) ? $this->venueId : $venueId;
        //事务
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->getSessionCard();
            $this->handleModelData();
            $organ = Organization::getVenueOneDataByLikeName('大上海');
            $card = new CardCategory();
            $card->category_type_id    = 2;
            $card->card_name           = $this->cardName;
            $card->another_name        = $this->anotherName;
            $card->create_at           = time();
            $card->class_server_id     = NULL;
            $card->server_combo_id     = NULL;
            $card->times               = $this->cardTimes;
            $card->count_method        = $this->timesMethod;
            $card->sell_start_time     = NULL;
            $card->sell_end_time       = NULL;
            $card->attributes          = $this->attributes;
            $card->total_store_times   =  NULL;
            $card->payment             = 1;
            $card->total_circulation   = $this->totalSheets;   //总发行量
            $card->sex                 = -1;
            $card->age                 = -1;
            $card->transfer_number     = $this->transferTimes;
            $card->create_id           = 1;
            $card->original_price      = $this->originalPrice;
            $card->sell_price          = $this->sellPrice;
            $card->max_price           = $this->regionOriginalPrice;
            $card->min_price           = $this->regionSellPrice;
            $card->sales_mode          = $this->timesMethod;
            $card->missed_times        = -1;
            $card->limit_times         = -1;
            $card->active_time         = (int)$this->activationTime * (int)$this->activationType;
            $card->status              = 4;
            $card->transfer_price      = $this->transferPrice;
            $card->leave_total_days    = $this->totalLeaveDays;
            $card->leave_long_limit    = json_encode($this->leaveSetDayArr);
            $card->renew_price         = $this->onceRenew;
            $card->offer_price         = $this->offerPrice;
            $card->app_sell_price      = $this->appSellPrice;       //移动端售价
            $card->renew_unit          = $this->renewUnit;

            $card->leave_least_Days    = $this->minLeaveDays;
            $card->duration            = json_encode(['day'=>(int)$this->validTime * (int)$this->validTimeType]);
            $card->deal_id             = (isset($this->deal)&&!empty($this->deal)) ? $this->deal : 0;               //卡种合同
            $card->venue_id            = !empty($venueId)?$venueId:(isset($organ['id'])?$organ['id']:0);
            $card->company_id          = !empty($companyId)?$companyId:(isset($organ['pid'])?$organ['pid']:0);
            $card->single              = $this->single;     //单数
            $card->ordinary_renewal    = $this->ordinaryRenewal;//普通
            $card->validity_renewal    = json_encode($this->validityRenewal);//有效期
            $card->card_type           = $this->cardType;
            $card->pic                 = $this->pic;      //图片
            $card = $card->save() ? $card : $card->errors;
            if(!isset($card->id)){
                throw new \Exception(self::NOTICE);
            }
            if (isset($card->id)) {
                $cardTime = new CardTime();
                $cardTime->card_category_id = $card->id;
                $cardTime->start             = $this->cardStartTime;
                $cardTime->end               = $this->cardEndTime;
                $cardTime->create_at        = time();
                $cardTime->day              =  json_encode(['day'=>$this->day,'start'=>$this->dayStartTime,'end'=>$this->dayEndTime]);
                $cardTime->week             =  json_encode(['weeks'=>$this->week,'startTime'=>$this->weekStartTime,'endTime'=>$this->weekEndTime]);
                $cardTime->month            = json_encode([]);
                $cardTime->quarter          = json_encode([]);
                $cardTime->year             = json_encode([]);
                $time = $cardTime->save();
                if(!$time){
                    throw new \Exception(self::NOTICE);
                }
                $limit = $this->loadLimitCard($card);
                \Yii::trace($limit,'$limit');
                if($limit !== true){
                    throw new \Exception(self::NOTICE);
                }
                $bind = $this->commonTwoSave($card);
                \Yii::trace($bind,'$bind');
                if($bind !== true){
                    throw new \Exception(self::NOTICE);
                }
                $approval = $this->saveApproval($card,$companyId,$venueId);
                if($approval !== true){
                    throw new \Exception(self::NOTICE);
                }
                if($transaction->commit() === null)
                {
                    $this->removeSession(); //插入成功删除session
                    return true;
                }else{
                    return $cardTime->errors;
                }
            }
        }catch (\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return  $e->getMessage();  //获取抛出的错误
        }
    }

    /**
     * @云运动 - 后台 - 卡种处理数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/4/17
     */
    public function handleModelData()
    {
        if(is_array($this->sheetsNum) && !empty($this->sheetsNum)){
            foreach ($this->sheetsNum as $k=>$v){
                if($v == '-1') {
                    $this->totalSheets = $v;
                    break;
                }else {
                    $this->totalSheets += (int)$v;
                }
            }
        }
        if(is_array($this->weekStartTime) && !empty($this->weekStartTime)){
            $weekStart = [];
            $weekEnd   = [];
            foreach ($this->weekStartTime as $k=>$v){
                if(isset($v) && $v){
                    $weekTime = explode('-',$v);
                    $weekStart[] = $weekTime[0];
                    $weekEnd[]   = $weekTime[1];
                }else{
                    $weekStart[] = NULL;
                    $weekEnd[]   = NULL;
                }
            }
            $this->weekStartTime = $weekStart;
            $this->weekEndTime   = $weekEnd;
        }
    }

    /**
     * 云运动 - 后台 - 公共套餐保存
     * @author 朱梦珂<zhumengke@itsports.club>
     * @param $card //OBJ
     * @return bool
     */
    public function commonTwoSave($card)
    {
        if(self::commonJudgment($this->package)){
            foreach ($this->package as $k=>$v){
                $bind = self::BIND;
                if(self::commonJudgment($v) && isset($v[1])){
                    $this->binkSave($card,$v[0],$v[1],$bind[$k][0],$bind[$k][1]);
                }
            }
        }
        return true;
    }

    /**
     * 云运动 - 后台 - 公共套餐保存
     * @author 朱梦珂<zhumengke@itsports.club>
     * @param $card //OBJ
     * @param $data //数据数组
     * @param $assist  //辅助数组
     * @param $status   //状态
     * @param $type    //类型
     * @return array|bool
     */
    public function binkSave($card,$data,$assist,$status,$type)
    {
        if(self::commonJudgment($data)){
            foreach ($data as $k=>$v){
                $bind = new BindPack();
                $bind->card_category_id = $card->id;
                if($type == 'class'){
                    \Yii::trace($v,'$V');
                    \Yii::trace($this->binkClassIsArr ,'error2');
                    if($this->binkClassIsArr[$k] == 1){
                        $bind->polymorphic_id   = (int)$v;
                    }else{
                        $bind->polymorphic_ids  = json_encode($v);
                        $bind->polymorphic_id   = 0;
                    }
                }else{
                    $bind->polymorphic_id   = (int)$v;
                }
                $bind->polymorphic_type = $type;
                $bind->number           = $assist[$k];
                $bind->status           = (int)$status;
                if(!$bind->save()){
                    \Yii::trace($bind->errors,'error');
                    return $bind->errors;
                }
            }
            return true;
        }
        return true;
    }

    /**
     * @云运动 - 后台 - 卡种表单移除session数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/4/11
     */
    public function removeSession()
    {
        $session = \Yii::$app->session;
        foreach (self::CARD_DATA as $v){
            $session->remove('cardData'.$v);
        }
    }

    /**
     * @云运动 - 后台 - 卡种处理店数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @param $card
     * @create 2017/4/17
     * @return boolean
     */
    public function loadLimitCard($card)
    {
        if(self::commonJudgment($this->sellVenue)){
            $this->saveVenueLimit($this->sellVenue,$card);
            $this->saveLimitTimes($card);
            return true;
        }else{
            $this->saveLimitTimes($card);
            return true;
        }
    }
    /**
     * @云运动 - 后台 - 卡种处理多个售卖折扣
     * @author 侯凯新 <lihuien@itsports.club>
     * @param  $k // Obj
     * @param  $id // Obj
     * @create 2017/4/17
     * @return boolean
     */
    public function saveDiscount($k,$id)
    {
        if(!empty($this->discount[$k])){
            foreach ($this->discount[$k] as $key=>$v){
                $discount = new CardDiscount();
                $discount->limit_card_id = $id;
                $discount->surplus       = $v['surplus'];
                $discount->discount      = $v['discount'];
                $discount->create_at     = time();
                $discount->update_at     = time();
                $discount->save();
            }
        }
    }
    /**
     * @云运动 - 后台 - 次卡全部通店数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @param $card  //卡种信息
     * @param $v     //场馆ID
     * @param $bool //判断是否售卖并且通店
     * @param $k //数组下标
     * @create 2017/4/17
     * @return boolean
     */
    public function saveVenueIdsLimit($card,$v,$bool,$k)
    {
        $limitVenue    =  new LimitCardNumber();
        $limitVenue->card_category_id = $card->id;
        $limitVenue->venue_id          = $v;
        if($bool){
            $venue = array_flip($this->currencyVenue);
            if($this->applyType[$venue[$v]] == 'w'){
                $limitVenue->week_times  = $this->currencyTimes[$venue[$v]]?:NULL;
                $limitVenue->times       = NULL;
            }else{
                $limitVenue->times       = $this->currencyTimes[$venue[$v]]?:NULL;
                $limitVenue->week_times  = NULL;
            }
            $limitVenue->status = 3;
            $limitVenue->apply_start     = strtotime($this->applyStart[$venue[$v]])?:NULL;
            $limitVenue->apply_end       = strtotime($this->applyEnd[$venue[$v]])?:NULL;
            $limitVenue->about_limit     = $this->aboutLimit[$venue[$v]];
            array_splice($this->currencyVenue,$venue[$v],1);
            array_splice($this->currencyTimes,$venue[$v],1);
            array_splice($this->applyType,$venue[$v],1);
            array_splice($this->applyStart,$venue[$v],1);
            array_splice($this->applyEnd,$venue[$v],1);
            array_splice($this->aboutLimit,$venue[$v],1);
        }else{
            $limitVenue->times     = NULL;
            $limitVenue->status    = 2;
        }
        $limitVenue->limit            = (int)$this->sheetsNum[$k]?:NULL ;
        $limitVenue->surplus          = (int)$this->sheetsNum[$k]?:NULL ;
        $limitVenue->sell_start_time  = isset($this->sellStartTime[$k])?strtotime($this->sellStartTime[$k]):NULL;
        $limitVenue->sell_end_time    = isset($this->sellEndTime[$k])?strtotime($this->sellEndTime[$k].' 23:59:59'):NULL;
        $limitVenue->level            = isset($this->level[$k]) ? $this->level[$k] : 0;
        if($limitVenue->save()){
            $this->saveDiscount($k,$limitVenue->id);
            return true;
        }else{
            return $limitVenue->errors;
        }
    }
    /**
     * @云运动 - 后台 - 卡种处理单个通店数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @param  $data //数组数据
     * @param  $card //卡中添加ID
     * @create 2017/4/17
     * @return boolean
     */
    public function saveVenueLimit($data,$card)
    {
        foreach ($data as $k => $v) {
            if (self::commonJudgment($this->currencyVenue) && in_array($v, $this->currencyVenue)) {  //1
                $saveVenue = $this->saveVenueIdsLimit($card, $v, true, $k);
                if ($saveVenue !== true) {
                    return $saveVenue;
                }
            } else {
                $this->saveVenueIdsLimit($card, $v, false, $k);//4
            }

        }
        return true;
    }

    /**
     * @云运动 - 后台 - 次卡处理多个售卖数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @param  $card // Obj
     * @create 2017/4/17
     * @return boolean
     */
    public function saveLimitTimes($card)
    {
        if(self::commonJudgment($this->currencyVenue)){
            foreach ($this->currencyVenue as $k=>$v){
                $limitVenue = new LimitCardNumber();
                $limitVenue->card_category_id = $card->id;
                $limitVenue->venue_id          = $v;
                if($this->applyType[$k] == 'w'){
                    $limitVenue->week_times  = $this->currencyTimes[$k]?:NULL;
                    $limitVenue->times       = NULL;
                }else{
                    $limitVenue->times       = $this->currencyTimes[$k]?:NULL;
                    $limitVenue->week_times  = NULL;
                }
                $limitVenue->limit             = NULL;
                $limitVenue->sell_start_time  = NULL;
                $limitVenue->sell_end_time    = NULL;
                $limitVenue->status            = 1;
                $limitVenue->level             = isset($this->level[$k]) ? $this->level[$k] : 0;
                $limitVenue->apply_start     = strtotime($this->applyStart[$k])?:NULL;
                $limitVenue->apply_end       = strtotime($this->applyEnd[$k])?:NULL;
                $limitVenue->about_limit = $this->aboutLimit[$k];
                $limitVenue->save();
            }
        }
        return true;
    }

    /**
     * 云运动 - 后台 - 公共判断数组
     * @param $data  array //数组参数
     * @return bool  //返回值 布尔值
     */
    public static function commonJudgment($data)
    {
        if (isset($data) && !empty($data) && is_array($data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @后台 - 新增卡种 - 生成审批表
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/28
     * @return boolean
     */
    public function saveApproval($card,$companyId,$venueId){
        $adminModel                 = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $type                       = ApprovalType::findOne(['type' => '新增会员卡','company_id' => $companyId,'venue_id' => $venueId]);
        if(empty($type)){
            $cardOne = CardCategory::findOne(['id'=>$card['id']]);
            $cardOne->status = 1;
            if($cardOne->save()){
                return true;
            }
            return $cardOne->errors;
        }
        $approvalRole = ApprovalRole::find()->where(['type' => 1,'approval_type_id'=>$type->id])->all();
        if(empty($approvalRole)){
            $cardOne = CardCategory::findOne(['id'=>$card['id']]);
            $cardOne->status = 1;
            if($cardOne->save()){
                return true;
            }
            return $cardOne->errors;
        }
        $approval                   = new Approval();
        $approval->name             = $card['card_name'];              //审批名称
        $approval->polymorphic_id   = $card['id'];               //多态id:卡种id
        $number                     = Func::setOrderNumber();    //生成编号
        $approval->number           = $number;                   //审批编号
        $approval->approval_type_id = $type['id'];               //审批类型id
        $approval->status           = 1;                         //状态:1审批中，2已通过
        $approval->create_id        = $adminModel->id;           //创建人id
        $approval->total_progress   = count($approvalRole);      //总进度
        $approval->progress         = 0;                         //当前进度
        $approval->note             = '新增卡种审批';              //备注
        $approval->company_id       = $companyId;                //公司id
        $approval->venue_id         = $venueId;                  //场馆id
        $approval->create_at        = time();                    //创建时间
        if($approval->save()){
            $this->saveApprovalDetail($approval,$type->id);
            return true;
        }else{
            return $approval->errors;
        }
    }
    /**
     * @后台 - 新增卡种 - 生成审批详情表
     * @author lihuien <lihuien@itsports.club>
     * @param  $approval
     * @param  $typeId
     * @create 2017/9/28
     */
    public function saveApprovalDetail($approval,$typeId)
    {
        $approvalRole = ApprovalRole::find()->where(['approval_type_id' => $typeId])->all();
        if(!empty($approvalRole)){
            foreach ($approvalRole as $k=>$v){
                $detail = new ApprovalDetails();
                $detail->approval_id = $approval->id;
                $detail->approver_id = $v['employee_id'];
                $detail->type        = $v['type'];
                $detail->approval_process_id = $v['approval_type_id'];
                $detail->status      = 1;
                $detail->create_at   = time();
                $detail->update_at   = time();
                $detail->save();
            }
        }
    }
}