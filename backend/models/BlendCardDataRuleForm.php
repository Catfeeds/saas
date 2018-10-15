<?php
namespace backend\models;
use common\models\base\Approval;
use common\models\base\ApprovalRole;
use common\models\base\ApprovalType;
use common\models\base\BindPack;
use common\models\base\CardCategory;
use common\models\base\CardDiscount;
use common\models\base\Employee;
use common\models\Func;
use yii\base\Model;

/**
 * @云运动 - 后台 - 混合卡种表单验证
 * @author Huang Pengju <huangpengju@itsports.club>
 * @create 2017/4/13
 */
class BlendCardDataRuleForm extends  Model
{
    const CARD_DATA     = ['One','Two','Three','Four'];                            //定义常量用于取出session
    const BIND       = [['1','class'],['2','server'],['3','pay'],['4','gift'],['5','hs'],['6','pt'],['7','birth']];    //定义常量，用于卡种绑定产品
    public $attributes;                                                            //卡属性
    public $cardName;                                                              //卡名称
    public $anotherName;                                                           //卡种别名

    public $activeTime;                                                            //激活期限
    public $activeTimeUnit;                                                        //激活期限单位
    public $cardDuration;                                                          //卡有效期
    public $cardDurationUnit;                                                      //卡有效期单位
    public $pic;                                                                    //图片

    public $originalPrice;                                                         //一口原价
    public $sellPrice;                                                             //一口售价
    public $minPrice;                                                              //最低价
    public $maxPrice;                                                              //最高价
    public $renewPrice;                                                            //续费价
    public $offerPrice;                                                            //优惠价
    public $appSellPrice;                                                          //移动端售价
    public $renewUnit;                                                             //优惠多长时间

    public $timeDuration;                                                          //时间卡有效期
    public $timeDurationUnit;                                                      //时间卡有效期单位
    public $times;                                                                 //卡种次数
    public $countMethod;                                                           //扣次方式
    public $timesDuration;                                                         //次卡有效期
    public $timesDurationUnit;                                                     //次卡有效期单位
    public $discount;                                                              //折扣数组

    public $rechargePrice;                                                         //充值金额
    public $rechargeGivePrice;                                                     //赠送金额
    public $rechargeDuration;                                                      //充值卡有效期
    public $rechargeDurationUnit;                                                  //充值卡有效期单位
    public $applyWeeksTimes;
    public $applyType;

    public $sellVenueArr;                                                          //售卖场馆
    public $sellLimitArr;                                                          //售卖张数
    public $sellStartTimeArr;                                                      //售卖开始时间
    public $sellEndTimeArr;                                                        //售卖结束时间
    public $applyVenueArr;                                                         //通店场馆
    public $venueTimesArr;                                                         //进场次数
    public $dayArr;                                                                //卡时间段 每月固定日
    public $dayStart;                                                              //卡每天的特定开始时间
    public $dayEnd;                                                                //卡每天的特定结束时间

    public $weekArr;                                                               //卡时间段 每周固定日
    public $weekStart;                                                             //卡每周的特定开始时间
    public $weekEnd;                                                               //卡每周的特定结束时间

    public $start;                                                                 //卡特定开始时间
    public $end;                                                                   //卡特定结束时间

    public $classIdArr;                                                            //课程id
    public $classNumArr;                                                           //课程数量
    public $serverIdArr;                                                           //服务id
    public $serverNumArr;                                                          //服务数量
    public $tollIdArr;                                                             //扣费项目id
    public $tollNumArr;                                                            //扣费项目数量
    public $giftIdArr;                                                             //赠品项目id
    public $giftNumArr;                                                            //赠品项目数量
    //
    public $hsId;                          //HS私教ID
    public $hsNum;                         //HS节数
    //
    public $ptId;                          //PT私教ID
    public $ptNum;                         //PT节数
    //
    public $birthId;                       //Birth私教ID
    public $birthNum;                      //Birth节数

    public $transferNumber;                                                        //转让次数
    public $transferPrice;                                                         //转让金额
    public $leaveTotalDays;                                                        //请假总天数
    public $leastLeaveDays;                                                        //每次最少请假天数
    public $leaveSetDayArr;                                                        //特定请假天数，次数
    public $deal;                                                                  //合同
    public $ordinaryRenewal;                                                       //普通续费
    public $validityRenewal;                                                       //有效期续费

    public $totalCirculation;                                                      //卡种发行总量
    public $total_store_times;                                                     //卡种总通店次数
    public $missedTimes = -1;                                                      //未赴约次数限制
    public $limitTimes  = -1;                                                      //限制约课天数
    public $level;                                                                 //卡种级别
    public $single;                                                                //单数
    public $cardType;                                                              //卡种类别
    public $venueId;
    public $package     = array();                                                 //空数组用于存放绑定的产品

    const NOTICE_ERROR  = '操作失败';                                               //错误提示
    const CARD_NAME     = 'cardName';                                               //卡名称
    const ACTIVE_TIME   = 'activeTime';                                             //激活期限常量
    const CARD_DURATION = 'cardDuration';                                           //激活期限单位常量
    const ATTRIBUTES    = 'attributes';                                             //卡种属性
    const START         = 'start';                                                  //卡开始时间常量
    const THREE         = 'three';                                                  //场景3
    /**
     * 云运动 - 后台 - 混合卡种表单构造初始化函数（用于场景触发）
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * BlendCardDataRuleForm constructor.
     * @param array $config
     * @param string $scenario  (场景步骤)
     */
    public function __construct(array $config,$scenario = 'one')
    {
        if($scenario != 'cancel')
        {
            $this->scenario = $scenario;                                    //给场景步骤赋值
            parent::__construct($config);
        }else{
            $this->removeSession();                                         //删除session
        }

    }
    /**
     * 云运动 - 后台 - 定义场景
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * @return array (场景验证的表单卡种属性)
     */
    public function scenarios()
    {
        return [
            'one'        => [self::ATTRIBUTES,self::CARD_NAME,'anotherName','applyType','level','single',self::ACTIVE_TIME,'activeTimeUnit',self::CARD_DURATION,'cardDurationUnit','originalPrice','sellPrice','minPrice',
                        'maxPrice','renewPrice','offerPrice','appSellPrice','renewUnit','ordinaryRenewal','validityRenewal','timeDuration','rechargeDurationUnit','timeDurationUnit','times','countMethod','timesDuration','timesDurationUnit','rechargePrice',
                        'rechargeGivePrice','rechargeDuration','sellVenueArr','sellLimitArr','sellStartTimeArr',
                        'sellEndTimeArr','applyVenueArr','venueTimesArr','dayArr','dayStart','dayEnd','weekArr',
                        'weekStart','cardType',self::START,'end','venueId','pic'],
            'two'        => ['classIdArr','classNumArr','serverIdArr','serverNumArr','tollIdArr','tollNumArr','giftIdArr','giftNumArr','hsId','hsNum','ptId','ptNum','birthId','birthNum'],
            self::THREE  => ['transferNumber','transferPrice','leaveTotalDays','leastLeaveDays','leaveSetDayArr'],
            'four'       => ['deal'],
        ];
    }

    /**
     * 云运动 - 后台 - 验证场景的规则
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * @return array （验证场景）
     */
    public function rules()
    {
        return [
            [[self::ATTRIBUTES,self::CARD_NAME,self::CARD_DURATION],'required','on'=>['one','four']],
            [[self::ATTRIBUTES,self::ACTIVE_TIME,self::CARD_DURATION,'originalPrice','sellPrice','minPrice',
                'maxPrice','renewPrice','timeDuration','countMethod','times','timesDuration','rechargePrice',
                'rechargeGivePrice','rechargeDuration','transferNumber','transferPrice','leaveTotalDays',
                'leastLeaveDays','deal'],'integer','on'=>['one',self::THREE,'four']],
            [[self::CARD_NAME,'anotherName',self::START,'end'],'string','on'=>'one'],
        ];
    }

    /**
     * 云运动 - 后台 - 取出model中和场景相同的卡属性值，然后存到session中
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * @param $model    （验证过的表单Form模型对象）
     */
    public function setSessionData($model,$companyId,$venueId)
    {
        $cardData = [];                         //定义空数组
        $stepArr  = $this->scenarios();         //调用所有场景
        $stepArr  = $stepArr[$this->scenario];  //取出指定场景
        foreach ($model as $k=>$v)
        {
            if(in_array($k,$stepArr))           //判断卡种的属性是否在场景中
            {
                $cardData[$k] = $v;
            }
        }
        $this->saveSessionData($cardData,$companyId,$venueId);      //调用存储session的方法
    }

    /**
     * 云运动 - 后台 - session存储方法
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * @param $cardData   （需求存到session 中的数据）
     * @return bool
     */
    public function saveSessionData($cardData,$companyId,$venueId)
    {
        $session = \Yii::$app->session;
        switch($this->scenario)                //判断场景步骤
        {
            case 'one':
                $session->set('blendCardDataOne',$cardData);
                break;
            case 'two':
                $session->set('blendCardDataTwo',$cardData);
                break;
            case self::THREE:
                $session->set('blendCardDataThree',$cardData);
                break;
            case 'four':
                $session->set('blendCardDataFour',$cardData);
                $this->saveCard($companyId,$venueId);
                break;
            default:
               $session->set('blendCardDataFour',$cardData);
        }
    }

    /**
     * 云运动 - 后台 - 过滤方法，把session中的值遍历出赋值给该类的属性
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * @param $data  （session中取出的数据）
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
     * 云运动 - 后台 - 把session中存储的数据取出来
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     */
    public function getSessionData()
    {
        $session = \Yii::$app->session;
        foreach(self::CARD_DATA as $v)
        {
            $data = $session->get('blendCardData'.$v);
            $this->loadData($data);
            if($v == 'Two')
            {
                $this->setPackage();                                //处理卡种绑定的数据
            }
        }
    }
    /**
     * 云运动 - 后台 - 配置套餐数组
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/17
     * @return bool
     */
    public function setPackage()
    {
        $data          = [];
        $data[]        = [$this->classNumArr,$this->classIdArr];       //课程数据
        $data[]        = [$this->serverNumArr,$this->serverIdArr];     //服务数据
        $data[]        = [$this->tollNumArr,$this->tollIdArr];         //扣费服务数据
        $data[]        = [$this->giftNumArr,$this->giftIdArr];         //赠送数据
        $data[]        = [$this->hsNum,$this->hsId];                   //HS
        $data[]        = [$this->ptNum,$this->ptNum];                  //PT
        $data[]        = [$this->birthNum,$this->birthId];             //生日课
        $this->package = $data;                                        //把绑定的产品数组给package属性
        return true;
    }
    /**
     * 云运动 - 后台 - 处理前台数据
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/15
     */
    public function blendDataModel()
   {
        /*计算卡种发行总量*/
       if(is_array($this->sellLimitArr) && !empty($this->sellLimitArr))
       {
           foreach ($this->sellLimitArr as $k=>$v)
           {
               if($v == '-1'){
                   $this->totalCirculation = $v;
                    break;
               }else{
                   $this->totalCirculation += (int)$v;
               }
           }
       }
       /*处理周的开始时间和结束时间*/
       if(is_array($this->weekStart) && !empty($this->weekStart))
       {
           $weekStarts          = [];
           $weekEnds            = [];
           foreach ($this->weekStart as $k=>$v){
               if(isset($v) && $v){
                   $week = explode('--',$v);
                   $weekStarts[] = $week[0];
                   $weekEnds[]   = $week[1];
               }else{
                   $weekStarts[] = NULL;
                   $weekEnds[]   = NULL;
               }
           }
           $this->weekStart      = $weekStarts;
           $this->weekEnd        = $weekEnds;
       }
   }
    /**
     * 云运动 - 后台 - 公共判断数组
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/17
     * @param $data  array //数组数据(售卖场馆数组，通店数组,绑定产品数组)
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
     * 云运动 - 后台 - 卡种提交数据是否有售卖 数组
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/17
     * @param $card     //卡种参数
     * @return bool     //返回值 布尔值
     */
    public function loadLimitCard($card)
    {
        if(self::commonJudgment($this->sellVenueArr)){              //判断是否有售卖场馆
            $this->saveVenueLimit($this->sellVenueArr,$card);       //有售卖场馆（1.有售卖场馆，又有通店次数 2.只有售卖场馆，无通店次数）
            $this->saveLimitTimes($card);                           //继续存储剩下的数据
            return true;
        }else{
            $this->saveLimitTimes($card);                           //无售卖场馆，存储数据
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
     * 云运动 - 后台 - 卡种售卖并且通店判断 3
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/17
     * @param  $data //售卖场馆 数组数据
     * @param  $card //卡种 调用添加的数据ID
     * @return boolean
     */
    public function saveVenueLimit($data,$card)
    {
        foreach ($data as $k=>$v){
            if(self::commonJudgment($this->applyVenueArr)){                     //在有售卖场馆的情况下，判断是否有通店次数
                if(in_array($v,$this->applyVenueArr)){
                    $saveVenue =  $this->saveVenueIdsLimit($card,$v,true,$k);   //有售卖场馆，又有通店次数
                    if($saveVenue !== true){
                        return $saveVenue;
                    }
                }else{
                    $this->saveVenueIdsLimit($card,$v,false,$k);                 //有售卖场馆，无通店次数
                }
            }
        }
        return true;
    }
    /**
     * 云运动 - 后台 - 卡种（有售卖数据，通店数据2种情况，有或无） 数据添加
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/17
     * @param $card   //卡种信息
     * @param $v     //场馆ID （售卖场馆数组）
     * @param $bool //判断是否售卖并且通店
     * @param $k //数组下标（售卖场馆数组）
     * @return boolean
     */
    public function saveVenueIdsLimit($card,$v,$bool,$k)
    {
        $limitVenue                   =  new LimitCardNumber();
        $limitVenue->card_category_id = $card->id;                                 //卡种id
        $limitVenue->venue_id         = $v;                                        //场馆id
        if($bool){
            $venue = array_flip($this->applyVenueArr);                             //通店数组，键值对反转，（通店和售卖数组，相同）
//            $limitVenue->times       = $this->venueTimesArr[$venue[$v]]?:NULL;     //(通过对应的场馆值，找场馆数组的下标，venueTimesArr的下标也就找到了）
            if($this->applyType[$venue[$v]] == 'w'){
                $limitVenue->week_times  = $this->venueTimesArr[$venue[$v]]?:NULL;
                $limitVenue->times       = NULL;
            }else{
                $limitVenue->times       = $this->venueTimesArr[$venue[$v]]?:NULL;
                $limitVenue->week_times  = NULL;
            }
            $limitVenue->status      = 3;                                          //可以售卖，也可以进店
            array_splice($this->applyVenueArr,$venue[$v],1);                       //删除通店数组中的值(因为还会存剩余的只有进店的数据数组)
            array_splice($this->venueTimesArr,$venue[$v],1);                       //删除通店数量数组中的值
            array_splice($this->applyType,$venue[$v],1);
        }else{
            $limitVenue->times       = NULL;                                       //通店次数
            $limitVenue->status      = 2;                                          //只卖卡状态
        }
        $limitVenue->limit           = (int)$this->sellLimitArr[$k]?:NULL ;        //售卖数量
        $limitVenue->surplus         = (int)$this->sellLimitArr[$k]?:NULL ;
        $limitVenue->sell_start_time = isset($this->sellStartTimeArr[$k])?strtotime($this->sellStartTimeArr[$k]):NULL;
                                                                                    //售卖开始时间
        $limitVenue->sell_end_time   = isset($this->sellEndTimeArr[$k])?strtotime($this->sellEndTimeArr[$k].' 23:59:59'):NULL;
                                                                                    //售卖开始时间
        $limitVenue->level           = isset($this->level[$k]) ? $this->level[$k] : 0;           //卡种级别
        if($limitVenue->save()){
            $this->saveDiscount($k,$limitVenue->id);
            return true;
        }else{
            return $limitVenue->errors;
        }
    }
    /**
     * 云运动 - 后台 - 卡种(有通店数据，无售卖数据)数据添加
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/17
     * @param  $card // Obj
     * @return boolean
     */
    public function saveLimitTimes($card)
    {
        if(self::commonJudgment($this->applyVenueArr)){
            foreach ($this->applyVenueArr as $k=>$v){
                $limitVenue                      = new LimitCardNumber();
                $limitVenue->card_category_id    = $card->id;                          //卡中id
                $limitVenue->venue_id            = $v;                                 //场馆
                if($this->applyType[$k] == 'w'){
                    $limitVenue->week_times  = $this->venueTimesArr[$k]?:NULL;
                    $limitVenue->times       = NULL;
                }else{
                    $limitVenue->times       = $this->venueTimesArr[$k]?:NULL;
                    $limitVenue->week_times  = NULL;
                }
                $limitVenue->limit               = NULL;                               //售卖数量
                $limitVenue->sell_start_time     = NULL;                               //售卖开始时间
                $limitVenue->sell_end_time       = NULL;                               //售卖接收时间
                $limitVenue->status              = 1;                                  //1状态表示只能进
                $limitVenue->level               = isset($this->level[$k]) ? $this->level[$k] : 0;    //卡种等级
                $limitVenue->save();
            }
        }
        return true;
    }
    /**
     * 云运动 - 后台 - 封装数据存储到数据库方法
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * @return string
     * @throws \yii\db\Exception
     */
    public function saveCard($companyId,$venueId)
    {
        $venueId = !empty($this->venueId) ? $this->venueId : $venueId;
        $transaction = \Yii::$app->db->beginTransaction();                                                               //开启事务
        try{
            $this->getSessionData();                                                                                     //取出session中存储的数据
            $this->blendDataModel();                                                                                     //计算总发行量、周的开始时间和结束时间
            $organ = Organization::getVenueOneDataByLikeName('大上海');
            $card                       =  new CardCategory();                                                           //卡种类型id
            $card->category_type_id     =  4;                                                                            //卡类别id,先给个随机数
            $card->card_name            =  $this->cardName;                                                              //卡名称
            $card->another_name         =  $this->anotherName;                                                           //卡种别名
            $card->create_at            =  time();                                                                       //创建时间
            $card->times                =  $this->times;                                                                 //次卡的次数
            $card->count_method         =  $this->countMethod;                                                           //计次方式
            $card->attributes           =  $this->attributes;                                                            //卡属性
            $card->payment              =   1;                                                                           //付款类型
            $card->total_circulation    =  $this->totalCirculation;                                                      //总发行量
            $card->sex                  =   -1;                                                                          //性别
            $card->age                  =   -1;                                                                          //年龄
            $card->transfer_number      =   $this->transferNumber;                                                       //可转让次数
            $card->create_id            =  \Yii::$app->user->identity->id;                                               //创建人id
            $card->original_price       =  $this->originalPrice;                                                         //一口原价
            $card->sell_price           =  $this->sellPrice;                                                             //一口售价
            $card->max_price            =  $this->maxPrice;                                                              //最高价
            $card->min_price            =  $this->minPrice;                                                              //最低价
            $card->missed_times         =  $this->missedTimes;                                                           //未赴约次数
            $card->limit_times          =  $this->limitTimes;                                                            //未限制次数
            $card->active_time          =  (int)$this->activeTime * (int)$this->activeTimeUnit;                          //激活时间
            $card->transfer_price       =  $this->transferPrice;                                                         //转让金额
            $card->leave_total_days     =  $this->leaveTotalDays;                                                        //请假总天数
            $card->leave_long_limit     =  json_encode($this->leaveSetDayArr);                                           //请假特定天和特定次数
            $card->recharge_price       =  $this->rechargePrice;                                                         //充值金额
            $card->recharge_give_price  =  $this->rechargeGivePrice;                                                     //赠送金额
            $card->renew_price          =  $this->renewPrice;                                                            //续费金额
            $card->offer_price          =  $this->offerPrice;                                                            //优惠金额
            $card->app_sell_price       =  $this->appSellPrice;                                                          //移动端售价
            $card->renew_unit           = $this->renewUnit;                                                              //优惠多长时间
            $card->leave_least_Days     =  $this->leastLeaveDays;                                                        //最少请假天数
            $card->duration             =  json_encode(['day'=>(int)$this->cardDuration * (int)$this->cardDurationUnit,
                                                        'timeCard'=>(int)$this->timeDuration * (int)$this->timeDurationUnit,
                                                        'timesCard'=>(int)$this->timesDuration * (int)$this->timesDurationUnit,
                                                        'rechargeCard'=>(int)$this->rechargeDuration * (int)$this->rechargeDurationUnit]);
                                                                                                                         //卡有效期
            $card->deal_id              = (isset($this->deal)&&!empty($this->deal)) ? $this->deal : 0;                                                                   //卡种合同
            $card->venue_id            = !empty($venueId)?$venueId:(isset($organ['id'])?$organ['id']:0);
            $card->company_id          = !empty($companyId)?$companyId:(isset($organ['pid'])?$organ['pid']:0);
            $card->single              = $this->single;     //单数
            $card->card_type           = $this->cardType;
            $card->status              = 4;
            $card->ordinary_renewal    = $this->ordinaryRenewal;//普通
            $card->validity_renewal    = json_encode($this->validityRenewal);//有效期
            $card->card_type           = $this->cardType;
            $card->pic                 = $this->pic;         //图片
            $card = $card->save() ? $card : $card->errors;
            if(!isset($card->id))
            {
                throw new \Exception(self::NOTICE_ERROR);
            }
            if(isset($card->id))
            {
                $cardTime = new CardTime();
                $cardTime->card_category_id = $card->id;                                                                      //卡种id
                $cardTime->start = $this->start;                                                                              //开始时间点
                $cardTime->end  = $this->end;                                                                                 //结束时间店
                $cardTime->create_at = time();                                                                                //添加时间
                $cardTime->day = json_encode(['day'=>$this->dayArr,self::START =>$this->dayStart,'end'=>$this->dayEnd]);     //天时段
                $cardTime->week = json_encode(['weeks'=>$this->weekArr,'startTime' =>$this->weekStart,'endTime'=>$this->weekEnd]);//周时段
                $cardTime->month              = json_encode([]);                                                              //月时段
                $cardTime->quarter            = json_encode([]);                                                              //季时段
                $cardTime->year               = json_encode([]);                                                              //年时段
                if(!$cardTime->save()){
                   throw new \Exception(self::NOTICE_ERROR);
                }
                $limit = $this->loadLimitCard($card);                                                                         //添加通店和发行量
                if($limit !== true){
                    throw new \Exception(self::NOTICE_ERROR);
                }
                $bind = $this->commonTwoSave($card);                                                                          //卡种绑定各种套餐服务
                if($bind !== true){
                    throw new \Exception(self::NOTICE_ERROR);
                }

                $approval = $this->saveApproval($card,$companyId,$venueId);
                if($approval !== true){
                    throw new \Exception(self::NOTICE_ERROR);
                }

                if($transaction->commit() === null)
                {
                    $this->removeSession();                                                                                  //插入成功删除session
                    return true;
                }else{
                    return $cardTime->errors;
                }
            }
        } catch (\Exception $e){
            $transaction->rollBack();                                                                                        //事务回滚
            return  $e->getMessage();                                                                                       //抛出错误
        }
    }
    /**
     * 云运动 - 后台 - 公共套餐保存
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/17
     * @param $card //卡种 数据（主要用卡种id）
     * @return bool
     */
    public function commonTwoSave($card)
    {
        if(self::commonJudgment($this->package)){
            foreach ($this->package as $k=>$v){                                        //['数量'=>'多态id']
                $bind = self::BIND;
                if(self::commonJudgment($v) && isset($v[1])){
                    $this->binkSave($card,$v[1],$v[0],$bind[$k][0],$bind[$k][1]);       //参数1 场馆数据 2 多态数据id 3 对应多态的数量，4 对应多态的状态 5 多态类型
                }
            }
        }
        return true;
    }
    /**
     * 云运动 - 后台 - 公共套餐保存
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/17
     * @param $card // 主要用卡种id
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
                $bind = new BindPack();                         //存卡种绑定的产品
                $bind->card_category_id = $card->id;            //卡种id
                $bind->polymorphic_id   = (int)$v;              //多态id
                $bind->polymorphic_type = $type;                //多态类型
                $bind->number           = $assist[$k];          //数量
                $bind->status           = (int)$status;         //状态
                if(!$bind->save()){
                    return $bind->errors;
                }
            }
            return true;
        }
        return true;
    }
    /**
     * @云运动 - 后台 - 卡种表单移除session数据
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/8
     */
    public function removeSession()
    {
        $session = \Yii::$app->session;
        foreach (self::CARD_DATA as $v){
            $session->remove('blendCardData'.$v);           //取出session，并且删除
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