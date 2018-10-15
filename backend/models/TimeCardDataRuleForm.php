<?php
namespace backend\models;
use common\models\base\Approval;
use common\models\base\ApprovalDetails;
use common\models\base\ApprovalRole;
use common\models\base\ApprovalType;
use common\models\base\CardDiscount;
use common\models\base\Employee;
use common\models\Func;
use yii\base\Model;
use common\models\base\BindPack;
use common\models\base\CardCategory;
use common\models\base\CardTime;
use common\models\base\LimitCardNumber;

/**
 * @云运动 - 后台 - 时间卡种表单验证
 * @author Huang Pengju <huangpengju@itsports.club>
 * @create 2017/4/8
 */
class TimeCardDataRuleForm extends Model
{
    const CARD_DATA  =  ['One','Two','Three','Four'];
    const BIND       = [['1','class'],['2','server'],['3','gift'],['4','hs'],['5','pt'],['6','birth']];
                     /*第一步*/
      // 1.卡的属性
    public $attributes;                      //卡种属性
    public $cardName;                        //卡种名字
    public $anotherName;                                                           //卡种别名
    public $activeTime;                      //卡激活时间值
    public $activeUnit;                      //卡激活时间单位
    public $duration;                        //卡有效期值
    public $durationUnit;                    //卡的有效期单位
    public $originalPrice;                   //一口原价
    public $sellPrice;                       //一口售价
    public $weekTimes;                       //周限制
    public $applyWeeksTimes;
    public $applyType;
    public $discount;                       //数组 折扣数组
    public $pic;                            //图片
      // 2.定价和售卖（一口价和区域价二选择一）
    public $areaMinPrice;                    //区域最低价
    public $areaMaxPrice;                    //区域最高价
    public $renewPrice;                      //续费价
    public $offerPrice;                      //优惠价
    public $appSellPrice;                    //移动端售价
    public $renewUnit;                       //续费多长时间
      // 3.售卖场馆（数组，里边值一一对应）
    public $venueIds;                        //所有售卖场馆id（数组）
    public $sheets;                          //场馆售卖张数（数组）
    public $saleStart;                      //场馆售卖开始时间（数组）
    public $saleEnd;                        //场馆售卖结束时间（数组）
            //外加数据库保存所需属性
    public $totalSheets;                    //时间卡总发行量 （卡种表  total_circulation）

      //4.通用场馆限制(数组，里边值一一对应)
    public $applyVenueId;                   //通用场馆id(数组)
    public $applyTimes;                     //通用场馆次数（数组）
    public $applyStart;                     //通用开始时间
    public $applyEnd;                       //通用结束时间
    public $aboutLimit;                     //团课预约设置
       //5.进馆时间限制  （外层普通限制）
                 //卡时间段限制
    public $start;                           //卡的开始进馆时间
    public $end;                             //卡的结束进馆时间
                 //星期几时间段限制
    public $week;                           //获取星期（数组）
    public $weekTimeLimit;                  //进场馆时间段
       /**外加数据库保存所需属性**/
    public $weekStart;
    public $weekEnd;
                 //按月里边的几号限制
    public $day;                            //月里边的几号（数组）
    public $dayStart;                    //起点时间
    public $dayEnd;                       //终点时间
                     /*第二步*/
               //绑定团课课程(数组一一对应)
    public $classId;                        //获取课程id
    public $pitchNum;                       //获取课程数量
              //绑定服务（数组一一对应）
    public $serverId;                       //服务id
    public $serverNum;                      //服务数量
             //赠品(数组一一对应)
    public $donationId;                     //赠送id
    public $donationNum;                    //赠送数量

    public $hsId;                          //HS私教ID
    public $hsNum;                         //HS节数

    public $ptId;                          //PT私教ID
    public $ptNum;                         //PT节数

    public $birthId;                       //Birth私教ID
    public $birthNum;                      //Birth节数
                 /**第三步**/
            //时间卡转让
    public $transferNumber;                //转让次数
    public $transferPrice;                 //转让价格
            //请假设置
    public $leaveTimesTotal;               //请假总天数
    public $leaveDaysTotal;                //请假总次数
    public $leaveDaysType;                 //请假类型
    public $studentLeaveDaysType;                 //请假类型
               /**第四步**/
    public $deal;                           //合同id

  // 外加属性
    public $missedTimes = -1;             //未赴约次数限制
    public $limitTimes  = -1;             //限制约课天数：限制多长时间内不能约课/-1不限
    public $level;                        //卡在不同场馆的等级
    public $single;                       //单数
    public $package = array();            //公告套餐包
    public $bring;                        //带人卡

    public $binkClassIsArr;
    public $ordinaryRenewal;     //普通续费
    public $validityRenewal;     //有效期续费
    public $cardType;
    public $venueType;           // 场馆类型
    public $venueIsArr;          //场馆是否为json
    public $venueId;
    public $companyId;
    /*定义常量*/
    const DURATION_UNIT = 'durationUnit';   //单位常量
    const ACTIVE_TIME   = 'activeTime';     //卡激活时间常量
    const CARD_NAME     = 'cardName';       //卡名称
    const NOTICE_ERROR  = '操作失败';       //错误提示常量
    /**
     * 云运动 - 后台 - 卡种表单构造初始化函数
     * @author houakixin <houakixin@itsports.club>
     * @create 2017/4/10
     * CardDataRuleForm constructor.
     * @param array $config
     * @param string $scenario
     */
    public function __construct(array $config,$scenario = 'one')
    {
        if($scenario != "cancel")
        {
            $this->scenario = $scenario;
            parent::__construct($config);
        }else{
            $this->removeSession();                     //点击取消删除session
        }

    }
    /**
     * 云运动 - 后台 - 卡种步骤场景
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/4/10
     * @return array
     */
    public function scenarios()
    {
        return [
            'one'   => ['attributes',self::CARD_NAME,'level','discount','single','anotherName',self::ACTIVE_TIME,'activeUnit',"duration",self::DURATION_UNIT,
                        "originalPrice","sellPrice","areaMinPrice",'ordinaryRenewal','validityRenewal',"areaMaxPrice",'renewPrice','offerPrice','appSellPrice',"renewUnit","venueIds",
                        "sheets","saleStart","saleEnd","applyVenueId","applyTimes",'applyStart','applyEnd','applyType','aboutLimit',"start","end","week","weekTimeLimit",'day',"dayStart","dayEnd",
                        'cardType','binkClassIsArr','venueType','venueIsArr','venueId','bring','pic'],
            'two'   => ['classId','pitchNum','serverId','serverNum','hsId','hsNum','ptId','ptNum','birthId','birthNum','donationId','donationNum'],
            'three' => ['transferNumber','transferPrice','leaveTimesTotal',"leaveDaysTotal","leaveDaysType","studentLeaveDaysType"],
            'four'  => ['deal'],
        ];
    }

    /**
     * @云运动 - 后台 - 卡种表单添加(规则验证)
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/8
     * @return array
     */
    public function rules()
    {
       return [
           // 必填 数据过滤验证
           [['attributes',self::CARD_NAME,'activeUnit',"duration",self::DURATION_UNIT],'required','on'=>['one']],
       ];
    }

    /**
     * @云运动 - 后台 - 卡种表单数据存到session
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/8
     */
    public function sessionLoadModel($model,$companyId,$venueId)
    {
        $timeCardData = [];
        $stepArr  = $this->scenarios();           //调用场景方法
        $stepArr   = $stepArr[$this->scenario];
        foreach ($model as $k=>$v){
            if(in_array($k,$stepArr)){
                $timeCardData[$k] = $v;
            }
        }
       return $this->saveSession($timeCardData,$companyId,$venueId);            //调用存储方法
    }

    /**
     * @云运动 - 后台 - 卡种表单数据session存储方法
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/8
     * @param $cardData
     * @return bool
     */
    public function saveSession($cardData,$companyId,$venueId)
    {
        $session = \Yii::$app->session;
        switch ($this->scenario){
            case 'one':
                $session->set('timeCardDataOne',$cardData);
                break;
            case 'two':
                $session->set('timeCardDataTwo',$cardData);
                break;
            case 'three':
                $session->set('timeCardDataThree',$cardData);
                break;
            case 'four':
                $session->set('timeCardDataFour',$cardData);
                $this->saveCard($companyId,$venueId);
                break;
            default:
               echo "程序有错";

        }
        return true;
    }


    /**
     * @云运动 - 后台 - 获取session存储的表单数据
     * @author houkxin <houkaixin@itsports.club>
     * @create 2017/4/17
     */
    public function getSessionCard()
    {
        $session = \Yii::$app->session;
        foreach (self::CARD_DATA as $v){
            $data = $session->get('timeCardData'.$v);
                $this->loadData($data);
            if($v == 'Two'){
                $this->setPackage();
            }
        }

    }
    /**
     * 云运动 - 后台 - 配置套餐数组
     * @author houkxin <houkaixin@itsports.club>
     * @return bool
     */
    public function setPackage()
    {
        $data   = [];
        $data[] = [$this->pitchNum,$this->classId];
        $data[] = [$this->serverNum,$this->serverId];
        $data[] = [$this->donationNum,$this->donationId];
        $data[] = [[$this->hsNum],[$this->hsId]];
        $data[] = [[$this->ptNum],[$this->ptId]];
        $data[] = [[$this->birthNum],[$this->birthId]];
        $this->package = $data;
        return true;
    }


    /**
     * @云运动 - 后台 - 卡种表单load数据
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/4/8
     * @param $data
     * @return bool
     */
    public function loadData($data)
    {
        if($data)
        {
            foreach ($data as $k=>$v)
            {
                $this->$k = $v;
            }
            return true;
        }
        return false;
    }
    /**
     * @云运动 - 后台 - 获取表单数据保存到数据库
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/4/17
     * @return array|bool|CardCategory
     */
    public function saveCard($companyId,$venueId)
    {
        $transaction                             =  \Yii::$app->db->beginTransaction();        //开启事务
        try{
            $this->getSessionCard();
            $this->handleModelData();                                                          //卡的总发行量 和 周开始进馆时间、周开始结束时间 数据处理
            $venueId = !empty($this->venueId) ? $this->venueId : $venueId;
            \Yii::trace($venueId,'venueIdWeb2');
            $organ = Organization::getVenueOneDataByLikeName('大上海');
            $card = new CardCategory();
            $card->attributes                    = $this->attributes;                          //卡种属性
            $card->category_type_id              = 1;                                          //卡类型id
            $card->card_name                     = $this->cardName;                            //卡种名字
            $card->another_name                  =  $this->anotherName;                        //卡种别名
            $card->create_id                     = \Yii::$app->user->identity->id;             //创建人id
            $card->create_at                     = time();                                     //创建时间
            $card->sell_start_time               =  null;                                      //售卖开始时间
            $card->sell_end_time                 =  null;                                      //售卖结束时间
            $card->total_store_times             = -1;                                          //总通店次数   -----需要修正
            $card->payment                       = 1;                                           //付款类型（界面没有input框）--需要修正
            $card->leave_total_days              = $this->leaveDaysTotal;                       //请假总次数
            $card->leave_least_Days              = $this->leaveTimesTotal;                      //每次请假最低天数
            $card->leave_long_limit              = json_encode($this->leaveDaysType);           //各种请假类型（请假次数，每次请假天数）
            $card->student_leave_limit           = json_encode($this->studentLeaveDaysType);    //学生请假类型（暑假天数，寒假天数,次数默认1）
            $card->total_circulation             = $this->totalSheets;                          //总发行量
            $card->sex                           = -1;                                          //办卡对性别的限制（不限）
            $card->age                           = -1;                                          //办卡对年龄的限制（不限）
            $card->transfer_number               = $this->transferNumber;                       //卡种转让次数（第三步）
            $card->transfer_price                = $this->transferPrice;                        //卡种转让价格（第三步）
            $card->max_price                     = $this->areaMaxPrice;                         //区域最高价
            $card->min_price                     = $this->areaMinPrice;                         //区域最低价
            $card->original_price                = $this->originalPrice;                        //一口原价
            $card->sell_price                    = $this->sellPrice;                            //一口售价
            $card->active_time                   =(int)$this->activeTime * (int)$this->activeUnit;  //激活期限（单位为天）
            $card->missed_times                  = $this->missedTimes;                          //未赴约次数限制
            $card->limit_times                   = $this->limitTimes;                           //限制约课天数：限制多长时间内不能约课
            $card->bring                         = $this->bring;
            $card->duration                      = json_encode(['day'=>$this->duration * (int)$this->durationUnit]); //卡有效天数
            $card->renew_price                   = $this->renewPrice;                           //续费价
            $card->offer_price                   = $this->offerPrice;                           //优惠价
            $card->app_sell_price                = $this->appSellPrice;                         //移动端售价
            $card->renew_unit                     = $this->renewUnit;                       //续费多长时间
            $card->deal_id                       = (isset($this->deal)&&!empty($this->deal)) ? $this->deal : 0;               //卡种合同
            $card->venue_id                      = !empty($venueId)?$venueId:(isset($organ['id'])?$organ['id']:0);
            $card->company_id                    = !empty($companyId)?$companyId:(isset($organ['pid'])?$organ['pid']:0);
            $card->single                        = $this->single;     //单数
            $card->status                        = 4;                 //状态：待审核
            $card->ordinary_renewal              = $this->ordinaryRenewal;
            $card->validity_renewal              = json_encode($this->validityRenewal);
            $card->card_type                     = $this->cardType;
            $card->pic                           = $this->pic;         //图片
            $card = $card->save() ? $card : $card->errors;
            if(!isset($card->id)){
                throw new \Exception(self::NOTICE_ERROR);
            }
            if(isset($card->id)){
                $cardTime   = new CardTime();
                $cardTime->card_category_id     = $card->id;
                $cardTime->start                = $this->start;      //按照天限制（开始时间）
                $cardTime->end                  = $this->end;        //按照天限制（结束时间）
                $cardTime->create_at            = time();            //创建时间
                $cardTime->day                  = json_encode(['day'=>$this->day,'start'=>$this->dayStart,'end'=>$this->dayEnd]); //每一月的时间段限制
                $cardTime->week                 = json_encode(['weeks'=>$this->week,'startTime'=>$this->weekStart,'endTime'=>$this->weekEnd]);//每一周的时间段限制
                $cardTime->month                = json_encode([]);   //按照月限制
                $cardTime->quarter              = json_encode([]);   //按照季限制
                $cardTime->year                 = json_encode([]);   //按照年限制
                $time = $cardTime->save();
                if(!$time){
                    throw new \Exception(self::NOTICE_ERROR);
                }
                //cloud_limit_card_number表   对通用场馆，售卖场馆存储
                $limit = $this->loadLimitCard($card);
                \Yii::trace($limit,'dddd');
                if($limit !== true){
                    throw new \Exception(self::NOTICE_ERROR);
                }

                $bind = $this->commonTwoSave($card);
                if($bind !== true){
                    throw new \Exception(self::NOTICE_ERROR);
                }

                $approval = $this->saveApproval($card,$companyId,$venueId);
                if($approval !== true){
                    throw new \Exception(self::NOTICE_ERROR);
                }
                $this->removeSession(); //插入成功删除session
                if($transaction->commit() === null){
                    return true;
                }else{
                    return $cardTime->errors;
                }
            }
        }catch(\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();  //获取抛出的错误
        }
    }


    /**
     * @云运动 - 后台 - 卡种表单移除session数据
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/4/8
     */
    public function removeSession()
    {
        $session = \Yii::$app->session;
        foreach (self::CARD_DATA as $v){
            $session->remove('timeCardData'.$v);
        }
    }

    /**
     * @云运动 - 后台 - 时间卡（第一步：进馆时间限制-特定星期选择[$this->weekStart,$this->sheets]）
     * @author houkaixin <lihuien@itsports.club>
     * @create 2017/4/8
     */
    public function handleModelData()
    {
        if(is_array($this->sheets) && !empty($this->sheets)){
            foreach ($this->sheets as $k=>$v){
                if($v == '-1') {
                    $this->totalSheets = $v;
                    break;
                }else{
                    $this->totalSheets += (int)$v;
                }
            }
        }
        if(is_array($this->weekTimeLimit) && !empty($this->weekTimeLimit)){
            $weekStarts            = [];
            $weekEnds              = [];
            foreach ($this->weekTimeLimit as $k=>$v){
                if(isset($v) && $v){
                    $weeks = explode('--',$v);
                    $weekStarts[] = $weeks[0];
                    $weekEnds[]   = $weeks[1];
                }else{
                    $weekStarts[]  = NULL;
                    $weekEnds[]    = NULL;
                }
            }
            $this->weekStart     = $weekStarts;
            $this->weekEnd       = $weekEnds;
        }
    }
    
    /**
     * 云运动 - 后台 - 公共套餐保存
     * @author houkaixin<houkaixin@itsports.club>
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
     * 云运动 - 后台 - 公共套餐保存
     * @author houkaixin<houkaixin@itsports.club>
     * @param $card //OBJ
     * @return bool
     */
    public function commonTwoSave($card)
    {
        if(self::commonJudgment($this->package)){
            foreach ($this->package as $k=>$v){
                $bind = self::BIND;
                if(self::commonJudgment($v) && isset($v[1])){
                    $this->binkSave($card,$v[1],$v[0],$bind[$k][0],$bind[$k][1]);
                }
            }
        }
        return true;
    }
    
    /**
     * 云运动 - 后台 - 公共判断数组
     * @author houkaixin <houkaixin@itsports.club>
     * @param $data  array //数组参数
     * @return bool  //返回值 布尔值
     */
    public static function commonJudgment($data)
    {
        if(isset($data) && !empty($data) && is_array($data)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @云运动 - 后台 - 卡种处理店数据
     * @author houkaixin <houkaixin@itsports.club>
     * @param $card
     * @create 2017/4/17
     * @return boolean
     */
    public function loadLimitCard($card)
    {
        if(self::commonJudgment($this->venueIds)){
            \Yii::trace($this->venueIds,'$this->venueIds');
            $this->saveVenueLimit($this->venueIds,$card);
            $this->saveLimitTimes($card);
            return true;
        }else{
            $this->saveLimitTimes($card);
            return true;
        }
    }

    /**
     * @云运动 - 后台 - 卡种处理单个通店数据
     * @author 侯凯新 <lihuien@itsports.club>
     * @param  $data //数组数据
     * @param  $card //卡中添加ID
     * @create 2017/4/17
     * @return boolean
     */
    public function saveVenueLimit($data,$card)
    {
        foreach ($data as $k=>$v){
            if(self::commonJudgment($this->applyVenueId)){
                if(in_array($v,$this->applyVenueId)){
                    $saveVenue     =  $this->saveVenueIdsLimit($card,$v,true,$k);
                    if($saveVenue !== true){
                        return $saveVenue;
                    }
                }else{
                    $this->saveVenueIdsLimit($card,$v,false,$k);//4
                }
            }
        }
        return true;
    }


    /**
     * @云运动 - 后台 - 卡种处理全部通店数据
     * @author 侯凯新<houkaixin@itsports.club>
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
        $limitVenue->venue_id         = $v;            //单个场馆
        if($bool){
            $venue              = array_flip($this->applyVenueId);
            if($this->applyType[$venue[$v]] == 'w'){
                $limitVenue->week_times  = $this->applyTimes[$venue[$v]]?:NULL;
                $limitVenue->times       = NULL;
            }else{
                $limitVenue->times       = $this->applyTimes[$venue[$v]]?:NULL;
                $limitVenue->week_times  = NULL;
            }
            $limitVenue->level           = isset($this->level[$k]) ? $this->level[$k] : 0;
            $limitVenue->status = 3;
            $limitVenue->identity        = $this->venueType[$venue[$v]];
            $limitVenue->apply_start     = strtotime($this->applyStart[$venue[$v]]) ?: NULL;
            $limitVenue->apply_end       = strtotime($this->applyEnd[$venue[$v]]) ?: NULL;
            $limitVenue->about_limit     = $this->aboutLimit[$venue[$v]];
            array_splice($this->applyVenueId,$venue[$v],1);
            array_splice($this->applyTimes,$venue[$v],1);
            array_splice($this->applyType,$venue[$v],1);
            array_splice($this->venueIsArr,$venue[$v],1);
            array_splice($this->venueType,$venue[$v],1);
            array_splice($this->applyStart,$venue[$v],1);
            array_splice($this->applyEnd,$venue[$v],1);
            array_splice($this->level,$k,1);
            array_splice($this->aboutLimit,$venue[$v],1);
        }else{
            $limitVenue->times     = NULL;
            $limitVenue->status    = 2;
            $limitVenue->level     = 0;
        }
        $limitVenue->limit            = (int)$this->sheets[$k]?:NULL ;
        $limitVenue->surplus          = (int)$this->sheets[$k]?:NULL ;
        $limitVenue->sell_start_time = isset($this->saleStart[$k])?strtotime($this->saleStart[$k]):NULL;
        $limitVenue->sell_end_time    = isset($this->saleEnd[$k])?strtotime($this->saleEnd[$k].' 23:59:59'):NULL;
        if($limitVenue->save()){
            $this->saveDiscount($k,$limitVenue->id);
            return true;
        }else{
            \Yii::trace($limitVenue->errors,'ccc');
            return $limitVenue->errors;
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
     * @云运动 - 后台 - 卡种处理多个售卖数据
     * @author 侯凯新 <lihuien@itsports.club>
     * @param  $card // Obj
     * @create 2017/4/17
     * @return boolean
     */
    public function saveLimitTimes($card)
    {
        if(self::commonJudgment($this->applyVenueId)){
            foreach ($this->applyVenueId as $k=>$v){
                $limitVenue = new LimitCardNumber();
                $limitVenue->card_category_id = $card->id;
                if($this->venueIsArr[$k] == 1){
                    $limitVenue->venue_id          = (int)$v[0];            //单个场馆
                }else{
                    if($v == -1){
                        $limitVenue->venue_ids         = json_encode($this->getVenueAllType($card,$this->venueType[$k]));            //多个场馆
                    }else{
                        $limitVenue->venue_ids         = json_encode($v);            //多个场馆
                    }
                    $limitVenue->venue_id        = 0;
                }
                if($this->applyType[$k] == 'w'){
                    $limitVenue->week_times  = $this->applyTimes[$k]?:NULL;
                    $limitVenue->times       = NULL;
                }else{
                    $limitVenue->times       = $this->applyTimes[$k]?:NULL;
                    $limitVenue->week_times  = NULL;
                }
                $limitVenue->identity        = $this->venueType[$k];
                $limitVenue->apply_start     = strtotime($this->applyStart[$k]) ?: NULL;
                $limitVenue->apply_end       = strtotime($this->applyEnd[$k]) ?: NULL;
                $limitVenue->limit              = NULL;
                $limitVenue->sell_start_time   = NULL;
                $limitVenue->sell_end_time      = NULL;
                $limitVenue->status              = 1;
                $limitVenue->level     = isset($this->level[$k]) ? $this->level[$k] : 0;
                $limitVenue->about_limit = $this->aboutLimit[$k];
                \Yii::trace($limitVenue,'$limitVenue1');
                $limitVenue->save();
                \Yii::trace($limitVenue->errors,'$limitVenue2');
            }
        }
        return true;
    }
    /**
     * @后台 - 新增卡种 - 获取场馆类型
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/9/28
     * @param  $card
     * @param  $type
     * @return boolean
     */
    public function getVenueAllType($card,$type)
    {
        $data = Organization::find()->where(['pid'=>$card->company_id,'identity'=>$type])->andWhere(['<>','id',$card->venue_id])->asArray()->all();
        return array_column($data,'id');
    }
    /**
     * @后台 - 新增卡种 - 生成审批表
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/28
     * @return boolean
     */
    public function saveApproval($card,$companyId,$venueId){
        $adminModel = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $type       = ApprovalType::findOne(['type' => '新增会员卡','venue_id' => $venueId]);
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