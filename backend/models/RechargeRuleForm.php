<?php
namespace backend\models;
use common\models\base\Approval;
use common\models\base\ApprovalRole;
use common\models\base\ApprovalType;
use common\models\base\BindPack;
use common\models\base\CardCategory;
use common\models\base\CardDiscount;
use common\models\base\CardTime;
use common\models\base\Employee;
use common\models\base\LimitCardNumber;
use common\models\Func;
use yii\base\Model;

class RechargeRuleForm extends Model
{
    const CARD_DATA = ['one'=>'One','two'=>'Two','three'=>'Three','four'=>'Four'];
    const BIND       = [['1','class'],['2','server'],['3','pay'],['4','gift'],['5','hs'],['6','pt'],['7','birth']];
    public $attributes;             //1.卡种属性
    public $cardName;              //1.卡种名称
    public $anotherName;           //1.卡种别名
    public $duration;              //1.卡种有效期开始时间
    public $day;                    //1.卡时段天
    public $week;                   //1.卡时段周
    public $activeTime;            //激活期限
    public $renewPrice;             //续费价格
    public $renewUnit;              //续费多长时间
    public $offerPrice;             //优惠价
    public $appSellPrice;           //移动端售价
    public $start;                  //通用开始时间
    public $end;                    //通用结束时间
    public $hoursStart;             //1.卡时段开始几点
    public $hoursEnd;               //1.卡时段开始几点
    public $weekStart;              //周开始时间
    public $weekEnd;
    public $activeTimeType;
    public $durationType;
    public $apply_total_times;
    public $discount;               //折扣数组
    public $transferNumber;         //1.转让总次数
    public $transferPrice;          //1.转让总次数
    public $rechargePrice;          //充值钱数
    public $rechargeTimes;          //次数
    public $rechargeGivePrice;     //充值赠送
    public $pic;                    //图片
    public $originalPrice;        //一口原价
    public $sellPrice;            // 一口售价
    public $minPrice;             //最低价
    public $maxPrice;            //最高价
    public $venueId;             //场馆
    public $totalSheets;         // 售卖总张数
    public $saleStart;           // 开始售卖时间
    public $saleEnd;             //结束售卖时间
    public $venueIds;            // 多个售卖场馆Arr
    public $sheets;               //售卖张数
    public $applyVenueId;           //通店场馆
    public $applyTimes;             //通店次数
    public $classId;                //课程套餐
    public $pitchNum;
    public $serverId;              //服务套餐
    public $serverNum;
    public $shopId;               //产品
    public $shopNum;
    public $donationId;            //赠送
    public $donationNum;
    public $hsId;                          //HS私教ID
    public $hsNum;                         //HS节数
    //
    public $ptId;                          //PT私教ID
    public $ptNum;                         //PT节数
    //
    public $birthId;                       //Birth私教ID
    public $birthNum;                      //Birth节数
    public $leaveTimesTotal;       //请假总次数
    public $leaveTimes;            //请假次数
    public $leaveDaysTotal;        // 请假总天数
    public $leaveDays;             //  请假天数
    public $servicePayIds;
    public $deal;
    public $missedTimes = -1;
    public $limitTimes  = -1;
    public $level;            //卡种级别
    public $single;           //单数
    public $applyWeeksTimes;
    public $applyType;
    public $cardType;
    public $ordinaryRenewal;     //普通续费
    public $validityRenewal;     //有效期续费
    public $package     = array();
    const  NOTICE      = '操作失败';
    const  ATTR         = 'attributes';
    const  CARD_NAME   =  'cardName';
    const  DURATION    =  'duration';
    const  START_TIME  =  'startTime';
    const  END_TIME    =  'startTime';
    const  ANOTHER_NAME = 'anotherName';
    const  DEAL          = 'deal';
    const  HOURS_START  = 'hoursStart';
    const  HOURS_END    = 'hoursEnd';
    /**
     * 云运动 - 后台 - 卡种表单构造初始化函数
     * @author 李慧恩<lihuien@itsports.club>
     * @create 2017/4/8
     * @param array $config
     * @param string $scenario
     */
    public function __construct(array $config,$scenario = 'one')
    {
        if($scenario != 'cancel'){
            $this->scenario = $scenario;
            parent::__construct($config);
        }else{
            $this->removeSession();
        }

    }
    /**
     * 云运动 - 后台 - 卡种表单使用场景
     * @author 李慧恩<lihuien@itsports.club>
     * @create 2017/4/8
     * @return array
     */
    public function scenarios()
    {
        return [
          'one'    => [self::ATTR,self::CARD_NAME,self::ANOTHER_NAME,'level','applyType','ordinaryRenewal',
                      'validityRenewal','discount','single','activeTime','activeTimeType','durationType',
                      'start','saleStart','saleEnd','applyVenueId','end','venueIds','originalPrice','sheets',
                      'applyTimes','sellPrice','duration','rechargePrice','rechargeGivePrice','day','cardType',
                      'week','hoursStart','hoursEnd','weekStart','weekEnd','minPrice','maxPrice','renewPrice',
                      'renewUnit','offerPrice','appSellPrice','venueId','pic'],
          'two'    => ['pitchNum','classId','serverId','serverNum','shopId','shopNum','hsId','hsNum','ptId','ptNum','birthId','birthNum','donationId','donationNum'],
          'three'  => ['transferNumber','transferPrice','leaveTimesTotal','leaveTimes','leaveDaysTotal','leaveDays'],
          'four'   => ['deal'],
          'finish' => ['deal']
        ];
    }

    /**
     * @云运动 - 后台 - 卡种表单添加(规则验证)
     * @create 2017/4/8
     * @return array
     */
    public function rules()
    {
        return [
            [[self::ATTR,self::CARD_NAME,'rechargePrice',self::DURATION,self::END_TIME],'required','message'=>'不能为空','on'=>['one','four']],

            [self::ATTR,'trim'],
            [self::ATTR,'integer'],
            [self::ATTR,'in','range' => [1,2,3]],
            [self::START_TIME,'trim'],
            [self::START_TIME,'string'],
            [self::END_TIME,'trim'],
            [self::END_TIME,'string'],
            [self::ANOTHER_NAME,'trim'],
            [self::ANOTHER_NAME,'string'],
            [self::HOURS_START,'trim'],
            [self::HOURS_START,'string'],
            [self::HOURS_END,'trim'],
            [self::HOURS_END,'string'],
        ];
    }

    /**
     * @云运动 - 后台 - 卡种表单数据存到session
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/8
     * @param $model //load后数据模型
     * @return array
     */
    public function sessionLoadModel($model,$companyId,$venueId)
    {
        $cardData = [];
        $sceArr = $this->scenarios();
        $sceArr = $sceArr[$this->scenario];
        foreach ($model as $k=>$v){
            if(in_array($k,$sceArr)){
                $cardData[$k] = $v;
            }
        }
        return $this->saveSession($cardData,$companyId,$venueId);
    }

    /**
     * 云运动 - 后台 - 卡种表单设置session
     * @author 李慧恩<lihuien@itsports.club>
     * @create 2017/4/8
     * @param  $cardData
     * @return boolean
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
     * @author 李慧恩<lihuien@itsports.club>
     * @create 2017/4/8
     * @param  $data
     * @return boolean
     */
    public function loadData($data)
    {
        if(is_array($data)){
            foreach ($data as $k=>$v){
                $this->$k = $v;
            }
            return true;
        }
        return false;
    }
    /**
     * @云运动 - 后台 - 卡种表单获取session数据
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/8
     */
    public function getSessionCard()
    {
        $session = \Yii::$app->session;
        foreach (self::CARD_DATA as $v){
            $data = $session->get('cardData'.$v);
            $this->loadData($data);
            if($v == 'Two'){
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
        $data[] = [$this->pitchNum,$this->classId];
        $data[] = [$this->serverNum,$this->serverId];
        $data[] = [$this->shopNum,$this->shopId];
        $data[] = [$this->donationNum,$this->donationId];
        $data[] = [$this->hsNum,$this->hsId];
        $data[] = [$this->ptNum,$this->ptNum];
        $data[] = [$this->birthNum,$this->birthId];
        $this->package = $data;
        return true;
    }
    /**
     * @云运动 - 后台 - 卡种表单数据保存到数据库
     * @author 李慧恩 <lihuien@itsports.club>
     * @param $companyId
     * @param $venueId
     * @create 2017/4/8
     * @return  array
     */
    public function  saveCard($companyId,$venueId)
    {
        $venueId = !empty($this->venueId) ? $this->venueId : $venueId;
        $transaction                  =  \Yii::$app->db->beginTransaction();                //开启事务
        try{
            $this->getSessionCard();
            $this->handleModelData();
            $organ = Organization::getVenueOneDataByLikeName('大上海');
            $card = new CardCategory();
            $card->attributes        = $this->attributes;
            $card->category_type_id  = 3;
            $card->card_name         = $this->cardName;
            $card->another_name      = $this->anotherName;
            $card->create_id         = \Yii::$app->user->identity->id;
            $card->create_at         = time();
            $card->sell_start_time   = $this->saleStart ? strtotime($this->saleStart[0]) : null;
            $card->sell_end_time     = $this->saleEnd ? strtotime($this->saleEnd[0].' 23:59:59') : null;
            $card->total_store_times = $this->apply_total_times;
            $card->payment           = 1;
            $card->leave_total_days  = $this->leaveDaysTotal;
            $card->leave_least_Days  = $this->leaveTimesTotal;
            $card->leave_long_limit  = json_encode($this->leaveDays);
            $card->total_circulation = $this->totalSheets;
            $card->sex               = -1;
            $card->age               = -1;
            $card->transfer_number   = $this->transferNumber;
            $card->transfer_price    = $this->transferPrice;
            $card->max_price         = $this->maxPrice;
            $card->min_price         = $this->minPrice;
            $card->original_price    = $this->originalPrice;
            $card->sell_price        = $this->sellPrice;
            $card->active_time       = (int)$this->activeTime * (int)$this->activeTimeType;
            $card->missed_times      = $this->missedTimes;
            $card->limit_times       = $this->limitTimes;
            $card->times             = $this->rechargeTimes;
            $card->recharge_price    = $this->rechargePrice;
            $card->recharge_give_price = $this->rechargeGivePrice;
            $card->service_pay_ids     = json_encode($this->servicePayIds);
            $card->duration            = json_encode(['day'=>$this->duration * (int)$this->durationType]);
            $card->deal_id             = (isset($this->deal)&&!empty($this->deal)) ? $this->deal : 0;                                                                //卡种合同
            $card->renew_price         = $this->renewPrice;
            $card->renew_unit          = $this->renewUnit;
            $card->offer_price         = $this->offerPrice;
            $card->app_sell_price      = $this->appSellPrice;       //移动端售价
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
            if(!isset($card->id)){
                \Yii::trace($card,'$card');
                throw new \Exception(self::NOTICE);
            }
            if(isset($card->id)){
                $cardTime   = new CardTime();
                $cardTime->card_category_id   = $card->id;
                $cardTime->start              = $this->start;
                $cardTime->end                = $this->end;
                $cardTime->create_at          = time();
                $cardTime->day                = json_encode(['day'=>$this->day,'start'=>$this->hoursStart,'end'=>$this->hoursEnd]);
                $cardTime->week               = json_encode(['weeks'=>$this->week,'startTime'=>$this->weekStart,'endTime'=>$this->weekEnd]);
                $cardTime->month              = json_encode([]);
                $cardTime->quarter            = json_encode([]);
                $cardTime->year               = json_encode([]);
                if(!$time = $cardTime->save()){
                    \Yii::trace($cardTime->errors);
                    throw new \Exception(self::NOTICE);
                }
                $limit = $this->loadLimitCard($card);
                if($limit !== true){
                    throw new \Exception(self::NOTICE);
                }
                $bind = $this->commonTwoSave($card);
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
            return  $error = $e->getMessage();  //获取抛出的错误
        }
    }
    /**
     * @云运动 - 后台 - 卡种处理数据
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/8
     */
    public function handleModelData()
    {
        if(is_array($this->sheets) && !empty($this->sheets)){
              foreach ($this->sheets as $k=>$v){
                  if($v == '-1'){
                      $this->totalSheets = $v;
                      break;
                  }else{
                      $this->totalSheets += (int)$v;
                  }
              }
        }
        if(is_array($this->weekStart) && !empty($this->weekStart)){
            $weekStart = [];
            $weekEnd   = [];
            foreach ($this->weekStart as $k=>$v){
                if(isset($v) && $v){
                    $week = explode('--',$v);
                    $weekStart[] = $week[0];
                    $weekEnd[]   = $week[1];
                }else{
                    $weekStart[] = NULL;
                    $weekEnd[]   = NULL;
                }
            }
            $this->weekStart = $weekStart;
            $this->weekEnd   = $weekEnd;
        }

    }
    /**
     * 云运动 - 后台 - 公共套餐保存
     * @author 李慧恩<lihuien@itsports.club>
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
     * 云运动 - 后台 - 公共套餐保存
     * @author 李慧恩<lihuien@itsports.club>
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
               $bind->polymorphic_id   = (int)$v;
               $bind->polymorphic_type = $type;
               $bind->number           = $assist[$k];
               $bind->status           = (int)$status;
               if(!$bind->save()){return $bind->errors;}
           }
           return true;
       }
        return true;
    }
    /**
     * @云运动 - 后台 - 卡种表单移除session数据
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/8
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
     * @author 李慧恩 <lihuien@itsports.club>
     * @param $card
     * @create 2017/4/8
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
     * @云运动 - 后台 - 卡种处理全部通店数据
     * @author 李慧恩 <lihuien@itsports.club>
     * @param $card  //卡种信息
     * @param $v     //场馆ID
     * @param $bool //判断是否售卖并且通店
     * @param $k //数组下标
     * @create 2017/4/8
     * @return boolean
     */
    public function saveVenueIdsLimit($card,$v,$bool,$k)
    {
        $limitVenue    =  new LimitCardNumber();
        $limitVenue->card_category_id = $card->id;
        $limitVenue->venue_id         = $v;
        if($bool){
            $venue = array_flip($this->applyVenueId);
            if($this->applyType[$venue[$v]] == 'w'){
                $limitVenue->week_times  = $this->applyTimes[$venue[$v]]?:NULL;
                $limitVenue->times       = NULL;
            }else{
                $limitVenue->times       = $this->applyTimes[$venue[$v]]?:NULL;
                $limitVenue->week_times  = NULL;
            }
            $limitVenue->status = 3;
            array_splice($this->applyVenueId,$venue[$v],1);
            array_splice($this->applyTimes,$venue[$v],1);
            array_splice($this->applyType,$venue[$v],1);
        }else{
            $limitVenue->times     = NULL;
            $limitVenue->status    = 2;
        }
        $limitVenue->limit           = (int)$this->sheets[$k]?:NULL ;
        $limitVenue->surplus         = (int)$this->sheets[$k]?:NULL ;
        $limitVenue->sell_start_time = isset($this->saleStart[$k])?strtotime($this->saleStart[$k]):NULL;
        $limitVenue->sell_end_time   = isset($this->saleEnd[$k])?strtotime($this->saleEnd[$k].' 23:59:59'):NULL;
        $limitVenue->level           = isset($this->level[$k]) ? $this->level[$k] : 0;
        if($limitVenue->save()){
            $this->saveDiscount($k,$limitVenue->id);
            return true;
        }else{
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
     * @云运动 - 后台 - 卡种处理单个通店数据
     * @author 李慧恩 <lihuien@itsports.club>
     * @param  $data //数组数据
     * @param  $card //卡中添加ID
     * @create 2017/4/8
     * @return boolean
     */
    public function saveVenueLimit($data,$card)
    {
        foreach ($data as $k=>$v){
            if(self::commonJudgment($this->applyVenueId) && in_array($v,$this->applyVenueId)){  //1
                $saveVenue =  $this->saveVenueIdsLimit($card,$v,true,$k);
                if($saveVenue !== true){return $saveVenue;}
            }else{
                $this->saveVenueIdsLimit($card,$v,false,$k);//4
            }
        }
        return true;
    }
    /**
     * @云运动 - 后台 - 卡种处理多个售卖数据
     * @author 李慧恩 <lihuien@itsports.club>
     * @param  $card // Obj
     * @create 2017/4/8
     * @return boolean
     */
    public function saveLimitTimes($card)
    {
        if(self::commonJudgment($this->applyVenueId)){
            foreach ($this->applyVenueId as $k=>$v){
                $limitVenue = new LimitCardNumber();
                $limitVenue->card_category_id = $card->id;
                $limitVenue->venue_id  = $v;
                if($this->applyType[$k] == 'w'){
                    $limitVenue->week_times  = $this->applyTimes[$k]?:NULL;
                    $limitVenue->times       = NULL;
                }else{
                    $limitVenue->times       = $this->applyTimes[$k]?:NULL;
                    $limitVenue->week_times  = NULL;
                }
                $limitVenue->limit     = NULL;
                $limitVenue->sell_start_time     = NULL;
                $limitVenue->sell_end_time       = NULL;
                $limitVenue->status              = 1;
                $limitVenue->level     = isset($this->level[$k]) ? $this->level[$k] : 0;
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
          if(isset($data) && !empty($data) && is_array($data)){
              return true;
          }else{
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