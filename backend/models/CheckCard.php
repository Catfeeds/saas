<?php
namespace backend\models;
use common\models\base\CardCategory;
use common\models\base\ConsumptionHistory;
use common\models\base\EntryRecord;
use backend\models\MemberCard;
use common\models\base\Member;
use common\models\base\MemberCardTime;
use common\models\base\VenueLimitTimes;
use yii\base\Model;
use common\models\Func;
class CheckCard extends Model
{
    public $id;
    public $card;
    public $cardId;
    public $status;
    public $venueId;
    public $return;
    public $message;
    public $price;
    public $singlePrice;
    public $surplusTimes;
    public $invalidTime;
    public $consumptionTimes;
    public $timeMethod = 2;//默认按次数消费
    public $limitType;     //限制设置
    public $cardStatus;
    public $memberId;
    public $companyId;
    public $cardName;
    public $memberStatus;
    public $activeTime;
    public $recharge;
    public $bring;
    public $timeStatus = 1;
    public $invalidFuTime;
    public $activeFuTime;
    public $venueIds;
    const ERROR = 'error';
    const SUCCESS = 'success';

    /*
     *  * 云运动 - 验卡模型 - 会员卡到期时间 当天晚上23：59：59
     * CheckCard constructor.
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @param array $config
     * @param $timeMethod
     * @param  $companyId
     * @param  $venueId
     * @param $id int//会员卡Id
     * */
    public  function getInvaTime()
    {
        if (self::decideString($this->invalidTime)) {

           return \common\models\Func::getTheEndTimeStamp($this->invalidTime);
           }

    }
    /**
     * 云运动 - 验卡模型 - 构造函数
     * CheckCard constructor.
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @param array $config
     * @param $timeMethod
     * @param  $companyId
     * @param  $venueId
     * @param $id int//会员卡Id
     */
    public function __construct(array $config, $id, $timeMethod, $companyId, $venueId)
    {
        $this->id = $id;
        $this->companyId = $companyId;
        $this->venueId = $venueId;
        if (isset($timeMethod) && !empty($timeMethod)) {
            $this->timeMethod = $timeMethod;
        }
        parent::__construct($config);
    }

    /**
     *  *云运动 - 验卡模型 - 初始化方法，判断会员卡的状态
     * CheckCard constructor.
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @return mixed
     */
    public function commonEntrance()
    {
        $this->getCardCategoryTypeData();
        if (!$this->setCardStatus()) {
            return false;
        }
        if (!$this->setMemberStatus()) {
            return false;
        }
        if (!$this->canInvalidTime()) {
            return false;
        }
        if ($this->getLeaveRecordMemberData()) {
            $this->setMessage(self::ERROR, '此类卡种正在请假中...');
            return false;
        }
        if (isset($this->card) && $this->card['usage_mode'] == 2) {
            $this->setMessage(self::ERROR, '此类卡种正在送人中...');
            return false;
        }
        $this->commonDecideStatus();
        if ($this->return == self::ERROR) {
            return $this->message;
        } elseif ($this->return == 'info') {
            if (!$this->setMemberActiveDecide()) {
                return false;
            }
            if($this->bring){
                $this->setMemberCardStatus(1);
            }
        } else {
            if($this->bring){
                $this->setMemberCardStatus(2);
            }
            $this->setUpdateCardTime();
            if ($this->getDecideCardPay()) {
                $towel = $this->getMemberTowelData();
                if (is_array($towel) && !empty($towel)) {
                    $this->setMessage(self::SUCCESS, '验卡成功,请领取' . $towel['serverName']);
                    return true;
                }
                if ($this->timeStatus == 2) {
                    return true;
                } else {
                    $this->setMessage(self::SUCCESS, '验卡成功,该卡的到期时间:' . date('Y-m-d', intval($this->invalidTime)));
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * 云运动 - 验卡模型 - 获取会员卡详细信息
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @return boolean
     */
    public function getCardCategoryTypeData()
    {
        $cardTypeId = MemberCard::find()->alias('mc')
            ->select('mc.*,cc.category_type_id,cc.single_price,cc.status as card_status,cc.bring')
            ->joinWith(['cardCategory cc'])
            ->where(['mc.id' => $this->id])->asArray()->one();
        $member = Member::find()->where(['id' => $cardTypeId['member_id']])->asArray()->one();
        $this->card = $cardTypeId;
        $this->status = $cardTypeId['status'];
        $this->cardId = $cardTypeId['card_category_id'];
        $this->invalidTime = $cardTypeId['invalid_time'];
        $this->activeTime = $cardTypeId['active_time'];
        $this->price = $cardTypeId['balance'];
        $this->singlePrice = $cardTypeId['single_price'];
        $this->consumptionTimes = $cardTypeId['consumption_times'];
        $this->cardStatus = $cardTypeId['card_status'];
        $this->memberId = $cardTypeId['member_id'];
        $this->cardName = $cardTypeId['card_name'];
        $this->memberStatus = $member['status'];
        $this->bring        = (!empty($cardTypeId['bring']) && empty($cardTypeId['pid'])) ? $cardTypeId['bring'] : null ;
    }

    /**
     * 云运动 - 验卡模型 - 获取卡种状态信息
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @return boolean
     */
    public function setMemberStatus()
    {
        switch ($this->memberStatus) {
            case 1:
                return true;
            case 2:
                $this->setMessage(self::ERROR, '该会员已经被冻结，请及时询问管理员');
                return false;
            default :
                return true;
        }
    }

    /**
     * 云运动 - 验卡模型 - 获取卡种状态信息
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @return boolean
     */
    public function setCardStatus()
    {
        switch ($this->cardStatus) {
            case 1:
                return true;
            case 2:
                return true;
//               $this->setMessage(self::ERROR,'此类卡种已经被冻结，请及时询问管理员');
//               return false;
            case 3:
                return true;
//               $this->setMessage(self::ERROR,'此类卡种已经过期，请及时询问管理员');
//               return false;
            default :
                $this->setMessage(self::ERROR, '此类卡种出现异常，请尽快沟通管理员');
                return true;
        }
    }

    /**
     * 云运动 - 验卡模型 - 激活会员卡
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @return boolean
     */
    public function setMemberActiveDecide()
    {
        $this->memberCardActive();
        if ($this->return == self::ERROR) {
            return false;
        } else {
            return $this->getDecideCardPay();
        }
    }

    /**
     * 云运动 - 验卡模型 - 获取会员卡的类型
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     */
    public function getDecideCardPay()
    {
//        if(empty($this->getThisCardVenueLimitTimes())){
//            $this->setMessage(self::ERROR,'会员卡不能在此场馆消费');
//            return  false;
//        }
        if (!empty($this->card['category_type_id'])) {
            if($this->cardName == '次卡'){
                $typeId = $this->card['card_type'];
            }else{
                $typeId = $this->card['category_type_id'];
            }
        } elsE {
            $typeId = $this->card['card_type'];
        }

        switch ($typeId) {
            case 1:
                return $this->getTimeMemberCard();
            case 2:
                return $this->getNumberMemberCard();
            case 3:
                $this->getRechargeSetting();
                return $this->getRechargeMemberCard();
            case 4:
                $this->getRechargeSetting();
                return $this->getBlendMemberCard();
            default:
                $this->setMessage(self::ERROR, '会员卡出现异常，请尽快沟通管理员');
                return false;
        }
    }

    /**
     * 云运动 - 验卡模型 - 根据时间卡进场次数统计
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/28
     * @return int|string  //会员的会员卡的进场次数
     */
    public function getEntryRecord()
    {
        if($this->limitType == 'week'){
            $monthStart = strtotime(Func::getGroupClassDate('w',true));
            $monthEnd   = strtotime(Func::getGroupClassDate('w',false));
        }else{
            $monthStart = mktime(0, 0, 0, date('m'), 1, date('Y'));                         //获取当月的开始时间戳
            $monthEnd = mktime(23, 59, 59, date('m'), date('t'), date('Y'));              //获取当月的最后时间戳
        }
        $venueId = VenueLimitTimes::find()->where(['member_card_id' => $this->id])->andWhere(['IS NOT','venue_ids',null])->asArray()->all();
        if(!empty($venueId)){
            foreach ($venueId as $k=>$v){
                 $idArr = json_decode($v['venue_ids']);
                 if(in_array($this->venueId,$idArr)){
                     $this->venueIds = $idArr;
                     break;
                 }
            }
        }else{
            $this->venueIds = $this->venueId;
        }
        return EntryRecord::find()
            ->where(['member_card_id' => $this->id])
            ->andWhere(['venue_id' => $this->venueIds])
            ->andWhere(['member_id' => $this->memberId])
            ->andWhere(['>=', 'entry_time', $monthStart])
            ->andWhere(['<=', 'entry_time', $monthEnd])
            ->count();
    }

    /**
     * 云运动 - 验卡模型 -  时间卡查询进场限制总次数
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/28
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getVenueLimitTimes()
    {
        $venue =  VenueLimitTimes::find()->where(['member_card_id' => $this->id])->andWhere(['venue_id' => $this->venueId])->andWhere(['or',['IS NOT','total_times',null],['IS NOT','week_times',null]])->select('total_times,week_times')->asArray()->one();
        if(empty($venue)){
            $venueId = VenueLimitTimes::find()->where(['member_card_id' => $this->id])->andWhere(['IS NOT','venue_ids',null])->andWhere(['or',['IS NOT','total_times',null],['IS NOT','week_times',null]])->asArray()->all();
            if(!empty($venueId)){
                foreach ($venueId as $k=>$v){
                    $idArr = json_decode($v['venue_ids']);
                    if(in_array($this->venueId,$idArr)){
                        $venue = $v;
                        break;
                    }
                }
            }
        }
        if(!empty($venue['total_times'])){
            $this->limitType = 'month';
            return $venue['total_times'];
        }
        $this->limitType = 'week';
        return $venue['week_times'];
    }

    /**
     * 云运动 - 验卡模型 -  时间卡查询进场限制总次数
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/28
     * @return array|null|\yii\db\ActiveRecord
     */
    public function canInvalidTime()
    {
        if (self::decideString($this->invalidTime)) {
            if (time() > $this->getInvaTime()) {
                $this->setMessage(self::ERROR, '会员卡已经失效，请重新办理');
                return false;
            } else {
                return true;
            }
        }
        $this->setMessage(self::ERROR, '会员卡已经失效，请重新办理');
        return false;
    }

    /**
     * 云运动 - 验卡模型 - 根据时间卡消费
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @param  $type //类型
     * @return bool
     */
    public function getTimeMemberCard($type = true)
    {
        $totalNum = $this->getVenueLimitTimes();             //查询馆次数核算表（获取总次数）
        $num      = $this->getEntryRecord();                 //统计会员卡进场次数
        $cardTime = $this->getCardTime();
        if ($cardTime === false) {
            $this->setMessage(self::ERROR, '您的进馆时间与卡限制时间不对应');
            return false;
        }
        if ($num >= $totalNum  && $totalNum != -1) {
            $this->setMessage(self::ERROR, '会员卡本月的使用次数已用完');
            return false;
        }
        if (self::decideString($this->invalidTime)) {
            if (time() > $this->getInvaTime()) {
                $this->setMessage(self::ERROR, '会员卡已经失效，请重新办理');
                return false;
            } else {
                if ($type === true) {
                    $this->saveEntryRecord();
                }
                return true;
            }
        } else {
            $this->setMessage(self::ERROR, '会员卡已经失效，请重新办理');
            return false;
        }
    }

    /**
     * 云运动 - 验卡模型 - 根据时间次卡消费
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @return bool
     */
    public function getNumberMemberCard()
    {
        $total = $this->card['total_times'];
        $payTime = $this->card['consumption_times'];
        $cardTime = $this->getCardTime();

        if ($cardTime === false) {
            $this->setMessage(self::ERROR, '您的进馆时间与卡限制时间不对应');
            return false;
        }
        if (isset($total) && isset($payTime)) {
            \Yii::trace($total,'$total');
            \Yii::trace($payTime,'$payTime');
            if (($total - $payTime) <= 0) {
                $this->setMessage(self::ERROR, '会员卡次数已经消费完，请及时购买1！');
                return false;
            } else {
                if ($this->getMemberVenueTimes()) {
                    $times = $this->updateMemberTimes();
                    if ($times === true) {
                        $this->saveEntryRecord();
                        $this->setMessage(self::SUCCESS, '扣除次数成功,正常进馆,此卡共:' . $total . '次' . ',剩余:' . (intval($total) - (intval($payTime) + 1)) . '次');
                    }
                    $this->timeStatus = 2;
                    return true;
                } else {
                    $this->timeMethod = 1;
//                    if($this->getBlendMemberCard()){
//                        return true;
//                    }
                    $this->setMessage(self::ERROR, '会员卡次数已经消费完，请及时购买2！');
                    return false;
                }
            }
        } else {
//            $this->timeMethod = 1;
//            if($this->getBlendMemberCard()){
//                 return true;
//            }
            $this->setMessage(self::ERROR, '会员卡次数已经消费完，请及时购买3！');
            return false;
        }
    }

    /**
     * 云运动 - 验卡模型 - 根据次卡消费
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @return bool
     */
    public function getMemberCardTimeCardNumber()
    {
        $total = $this->card['total_times'];
        $payTime = $this->card['consumption_times'];
        if (isset($total) && isset($payTime)) {
            if (($total - $payTime) <= 0) {
                $this->setMessage(self::ERROR, '会员卡次数已经消费完，请及时购买！');
                return false;
            } else {
                if ($this->getMemberVenueTimes()) {
                    $this->updateMemberTimes();
                    $this->saveEntryRecord();
                    $this->setMessage(self::SUCCESS, '扣除次数成功');
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            $this->setMessage(self::ERROR, '没有可以消费的次数哦');
            return false;
        }
    }

    /**
     * 云运动 - 验卡模型 - 根据充值卡消费
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @return bool
     */
    public function getRechargeMemberCard()
    {
        $cardTime = $this->getCardTime();

        if ($cardTime === false) {
            $this->setMessage(self::ERROR, '您的进馆时间与卡限制时间不对应');
            return false;
        }
        if (self::decideString($this->price) && $this->price > 0) {
            if (self::decideString($this->singlePrice) && $this->price > 0) {
//               var_dump($this->price);die();
                if (intval($this->price) > intval($this->singlePrice)) {
                    if ($this->updateMemberBalance()) {
                        $this->saveEntryRecord();
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    $this->setMessage(self::ERROR, '会员卡没有足够余额，请及时充值！');
                    return false;
                }
            } else {
                $this->setMessage(self::ERROR, '此卡种不能充值消费，请及时联系管理员');
                return false;
            }
        } else {
            $this->setMessage(self::ERROR, '会员卡没有余额，请及时充值！');
            return false;
        }
    }

    /**
     * 云运动 - 验卡模型 - 根据混合卡消费
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @return bool
     */
    public function getBlendMemberCard()
    {
        $card = CardCategory::findOne(['id' => $this->cardId]);
        $time = json_decode($card->duration, true);
        $blendCard = $time['timeCard'] * 24 * 60 * 60;               //混合卡的有效期
        $timeCard = $time['timesCard'] * 24 * 60 * 60;          //时间属性的有效期
        $cardTime = $this->getCardTime();

        if ($cardTime === false) {
            $this->setMessage(self::ERROR, '您的进馆时间与卡限制时间不对应');
            return false;
        }
        if ($this->activeTime != null) {
            if (time() > ($this->activeTime + $blendCard)) {
                if ((time() <= ($this->activeTime + $blendCard + $timeCard))) {
                    $total = $this->card['total_times'];
                    $payTime = $this->card['consumption_times'];
                    if (($total - $payTime) <= 0 || $total == null) {
                        return $this->getRechargeMemberCard();
                    } else {
                        $times = $this->updateMemberTimes();
                        if ($times === true) {
                            $this->saveEntryRecord();
                            $this->setMessage(self::SUCCESS, '扣除次数成功,正常进馆,此卡共:' . $total . '次' . ',剩余:' . (intval($total) - (intval($payTime) + 1)) . '次');
                        }
                        $this->timeStatus = 2;
                        return true;
                    }
                } else {
                    $this->getRechargeMemberCard();
                    return true;
                }
            } else {
                $this->saveEntryRecord();
                return true;
            }
        } else {
            $this->setUpdateCardTime();
        }
    }

    /**
     * 云运动 - 验卡模型 - 根据时间段消费
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @return bool
     */
    public function timeSlotPay()
    {
        $last = EntryRecord::find()
            ->where(['member_card_id' => $this->id])
            ->andWhere(['venue_id' => $this->venueId])
            ->asArray()->one();
        if (is_array($last) && !empty($last) && isset($last['entry_time'])) {
            $start = strtotime(date('Y-m-d', time()) . ' 00:00:00');
            $end = strtotime(date('Y-m-d', time()) . ' 23:59:59');
            $nowTime = $last['entry_time'];
            if ($start < $nowTime && $end > $nowTime) {
                $this->setMessage(self::SUCCESS, '验卡成功');
                $this->saveEntryRecord();
                return true;
            } else {
                if ($this->getMemberCardTimeCardNumber()) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            if ($this->getMemberCardTimeCardNumber()) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * 云运动 - 验卡模型 - 根据本场馆消费次数
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @return bool
     */
    public function getMemberCardVenueLimitTimes()
    {
        return $query = VenueLimitTimes::find()->where(['member_card_id' => $this->id])
            ->andWhere(['or',['venue_id' => $this->venueId],['like','venue_ids' ,'"'.$this->venueId.'"']]);

    }

    /**
     * 云运动 - 验卡模型 - 设置会员卡激活时间和失效时间
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @return bool
     */
    public function setUpdateCardTime()
    {
        if (time() < $this->activeTime && $this->venueId == 76) {
            $time = $this->invalidTime - $this->activeTime;
            $memberCard = MemberCard::findOne(['id' => $this->id]);
            $memberCard->active_time = time();
            $memberCard->invalid_time = time() + $time;
            if ($memberCard->save()) {
                $this->invalidTime = $memberCard->invalid_time;
            }
        }
    }

    /**
     * 云运动 - 验卡模型 - 根据本场馆消费次数
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @return bool
     */
    public function getMemberVenueTimes()
    {
        $times = $this->getThisCardVenueLimitTimes();
        if (self::decideArray($times)) {
            $this->surplusTimes = $times['overplus_times'];
            if (!isset($this->surplusTimes) && $this->surplusTimes <= 0) {
                if ($times['total_times'] != -1) {
                    $this->setMessage(self::ERROR, '会员卡在本店没有可以消费的次数哦');
                    return false;
                }
                return true;
            } else {
                return true;
            }
        } else {
            $this->setMessage(self::ERROR, '会员卡在本店没有可以消费的次数哦');
            return false;
        }
    }

    /**
     * 云运动 - 验卡模型 - 判断卡状态信息
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @return bool
     */
    public function commonDecideStatus()
    {
        switch ($this->status) {
            case 1:
                $this->setMessage(self::SUCCESS, '会员卡正常');
                break;
            case 2:
                $this->setMessage(self::ERROR, '会员卡出现异常，请尽快沟通管理员');
                break;
            case 3:
                $this->setMessage(self::ERROR, '会员卡已被冻结，请尽快沟通管理员');
                break;
            case 4:
                $this->setMessage('info', '会员卡未被激活，请尽快沟通管理员');
                break;
            case 5:
                $this->updateCardStatus();
                $this->setMessage(self::SUCCESS, '会员卡正常');
                break;
            default:
                $this->setMessage(self::ERROR, '会员卡出现异常，请尽快沟通管理员');
                break;

        }
    }

    /**
     * 云运动 - 验卡模型 - 会员卡激活方法
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @return boolean
     */
    public function memberCardActive()
    {
        $memberCard = \common\models\base\MemberCard::findOne(['id' => $this->id]);
//        $cardCategory = CardCategory::findOne(['id' => $member->card_category_id]);    //查出所选卡种的信息
//        $time = json_decode($cardCategory->duration, true);                  //卡种有效期
        $time  = $memberCard['duration'];
        $memberInfo = Member::findOne(['id' => $this->memberId]);
//        $member->active_time  = time();
        $theData = MemberAboutClass::editMemberCardData($memberCard, $time);
//        if(isset($time['day'])){
//            $member->invalid_time = time()+($time['day']*24*60*60);
//        }
        //如果卡在激活之前有过续费行为，到期时间需加上续费时长
        $history = \common\models\base\ConsumptionHistory::find()->select('due_date')->where(['consumption_type_id'=>$memberCard['id'],'consumption_type'=>'cardRenew'])->orderBy('due_date desc')->asArray()->one();
        if($history)
        {
            $theData["invalidTime"] = $history['due_date'];
        }
        if (isset($theData["activeTime"])) {
            $memberCard->active_time = $theData["activeTime"];
        }
        if (isset($theData["invalidTime"])) {
            $memberCard->invalid_time = $theData["invalidTime"];
        }
        $memberCard->status = 1;
        if ($memberCard->save()) {
            $this->setMessage(self::SUCCESS, '会员卡已激活');
            $this->invalidFuTime = $memberCard->invalid_time;
            $this->activeFuTime  = $memberCard->active_time;
            Func::sendMessage($memberInfo['mobile'], $this->cardName);
            //激活期限内激活，卡到期时间需同步到消费记录表
            $consumption =  \common\models\base\ConsumptionHistory::findOne(['consumption_type_id'=>$memberCard['id'],'category'=>'办卡']);
            if($consumption){
                $consumption->due_date = $memberCard->invalid_time;
                $consumption->save();
            }
            return true;
        } else {
            $this->setMessage(self::ERROR, '会员卡激活出现异常，请尽快沟通管理员');
            return false;
        }
    }

    /**
     * 云运动 - 验卡模型 - 公共判断数值
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @param  $str //字符串 数字
     * @return boolean
     */
    public static function decideString($str)
    {
        if (isset($str) && !empty($str)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 云运动 - 验卡模型 - 公共判断数值
     * @author lihuien <lihui@itsports.club>
     * @return boolean
     */
    public function updateCardStatus()
    {
        $memberCard = MemberCard::findOne(['id' => $this->id]);
        $memberCard->status = 1;
        if ($memberCard->save()) {
            return true;
        }
    }

    /**
     * 云运动 - 验卡模型 - 公共判断数组
     * @author lihuien <lihui@itsports.club>
     * @create 2017/4/51
     * @param  $arr //数组
     * @return boolean
     */
    public static function decideArray($arr)
    {
        if (isset($arr) && !empty($arr) && is_array($arr)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 云运动 - 公共提示框 - 赋值和状态
     * @param $attr //返回值状态
     * @param $message //返回提示消息
     */
    public function setMessage($attr = self::SUCCESS, $message)
    {
        $this->return = $attr;
        $this->message = $message;
    }

    /**
     * 云运动 - 验卡系统 - 进场记录
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/20
     * @return boolean
     */
    public function saveEntryRecord()
    {
        $entry = new EntryRecord();
        $entry->member_card_id = $this->id;
        $entry->member_id = $this->memberId;
        $entry->venue_id = $this->venueId;
        $entry->company_id = $this->companyId;
        $entry->entry_time = time();
        $entry->create_at = time();
        $entry->save();
    }

    /**
     * 云运动 - 验卡系统 - 场馆次数记录
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/20
     * @return boolean
     */
    public function saveMemberVenueLimitTimes()
    {
        $query = $this->getMemberCardVenueLimitTimes();
        $venue = $query->one();
        $venue->overplus_times = ($this->surplusTimes == 0) ? 0 : $this->surplusTimes - 1;
        $venue->save();
    }

    /**
     * 云运动 - 验卡系统 - 修改余额
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/20
     * @return boolean
     */
    public function updateMemberBalance()
    {
        $member = MemberCard::findOne(['id' => $this->id]);
        $member->balance = intval($this->price) - intval($this->singlePrice);
        if ($member->save()) {
            $this->setMessage(self::SUCCESS, '扣除余额成功');
            return true;
        } else {
            $this->setMessage(self::SUCCESS, '扣除余额失败，请及时联系管理员');
            return false;
        }

    }

    /**
     * 云运动 - 验卡系统 - 修改会员卡次数
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/20
     * @return boolean
     */
    public function updateMemberTimes()
    {
        $member = MemberCard::findOne(['id' => $this->id]);
        $member->consumption_times = $this->consumptionTimes + 1;
        if ($member->save()) {
            return true;
        }
        return $member->errors;
    }

    /**
     * 云运动 - 验卡系统 - 时间卡消费
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/20
     * @return boolean
     */
    public function addConsumptionHistory()
    {
        $history = new ConsumptionHistory();
        $history->member_id = $this->memberId;
        $history->consumption_type = 'card';
        $history->consumption_type_id = $this->id;
        $history->type = (int)2;
        $history->consumption_date = time();
        $history->consumption_times = 1;
        $history->venue_id = $this->venueId;
        $history->seller_id = \Yii::$app->user->identity->id;
        if ($history->save()) {
            return true;
        }
    }

    /**
     * 云运动 - 验卡系统 - 获取场馆
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/20
     * @return boolean
     */
    public function getVenueId()
    {
        $venue = Organization::find()->where(['like', 'name', '大上海'])->asArray()->one();
        if (isset($venue['id'])) {
            $this->venueId = $venue['id'];
        } else {
            $this->venueId = 2;
        }
    }

    /**
     * 云运动 - 验卡系统 - 获取会员请假
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/20
     * @return boolean
     */
    public function  getLeaveRecordMemberData()
    {
        return LeaveRecord::find()
//            ->where(['>', 'leave_end_time', time()])
//            ->andWhere(['<', 'leave_start_time', time()])
            ->where(['status' => 1])
            ->andWhere(['member_card_id' => $this->id])->one();
    }

    /**
     * 云运动 - 验卡系统 - 获取会员毛巾信息
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/20
     * @return boolean
     */
    public function getMemberTowelData()
    {
        $member = new MemberCard();
        return $member->getMemberTowelOne($this->cardId);
    }

    /**
     * 云运动 - 验卡系统 - 获取会员卡是否可以进馆
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/20
     * @return boolean
     */
    public function getThisCardVenueLimitTimes()
    {
        $query = $this->getMemberCardVenueLimitTimes();
        return $query->asArray()->one();
    }

    /**
     * 云运动 - 验卡系统 - 获取充值卡种设置
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/20
     * @return boolean
     */
    public function getRechargeSetting()
    {
        $config = Config::find()->where(['key' => 'recharge', 'type' => 'card', 'venue_id' => $this->venueId])->asArray()->one();
        $this->singlePrice = !empty($config) ? $config['value'] : null;
    }

    /**
     * 云运动 - 验卡模型 -  进馆时间限制公共方法
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/18
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getCardTime()
    {
        $applyTime = VenueLimitTimes::find()
            ->where(['member_card_id' => $this->id])
            ->andWhere(['or',['venue_id' => $this->venueId],['like','venue_ids','"'.$this->venueId.'"']])
            ->andWhere(['or', ['IS NOT','apply_start',NULL],['IS NOT','apply_end',NULL]])
            ->asArray()->one();
        if(isset($applyTime) && $applyTime['apply_start'] !=  $applyTime['apply_end'] ){
            $time  = date('H:i',time());
            $start = date('H:i',$applyTime['apply_start']);
            $end   = date('H:i',$applyTime['apply_end']);
            if($end == '00:00')$end = '24:00' ;
            if(!empty($applyTime['apply_start']) && !empty($applyTime['apply_end'])){
                if($time<$start || $time>$end){
                    return false;
                }
            }
            if(empty($applyTime['apply_start']) && !empty($applyTime['apply_end'])){
                if($time>$end){
                    return false;
                }
            }
            if(!empty($applyTime['apply_start']) && empty($applyTime['apply_end'])){
                if($time<$start){
                    return false;
                }
            }
        }
        $day  = date('d', time());
        $week = date('w', time());
        $week = $week == 0 ? 7 : $week;
//        var_dump($week);die();
        $cardTime = MemberCardTime::find()->where(['member_card_id' => $this->id])->select('day,week')->asArray()->one();

        if (!empty($cardTime['day'])) {
            $dayArr = json_decode($cardTime['day'], true);
            if (isset($dayArr['day']) && !empty($dayArr['day'])) {
                if (in_array($day, $dayArr['day'])) {
                    if (!empty($dayArr['start'])) {
                        $start = strtotime(date('Y-m-d') . ' ' . $dayArr['start']);
                        if (time() < $start) {
                            return false;
                        }
                    }
                    if (!empty($dayArr['end'])) {
                        $end = strtotime(date('Y-m-d') . ' ' . $dayArr['end']);
                        if (time() > $end) {
                            return false;
                        }
                    }
                    return true;
                } else {
                    return false;
                }
            }
        }
        if (!empty($cardTime['week'])) {
            $weekArr = json_decode($cardTime['week'], true);
            if (isset($weekArr['weeks']) && !empty($weekArr['weeks'])) {
                if (in_array($week, $weekArr['weeks'])) {
                    $flipArr = array_flip($weekArr['weeks']);
                    $start = $weekArr['startTime'][$flipArr[$week]];
                    if (!empty($start)) {
                        $start = strtotime(date('Y-m-d') . ' ' . $start);
                        if (time() < $start) {
                            return false;
                        }
                    }
                    $end = $weekArr['endTime'][$flipArr[$week]];
                    if (!empty($end)) {
                        $end = strtotime(date('Y-m-d') . ' ' . $end);
                        if (time() > $end) {
                            return false;
                        }
                    }
                    return true;
                } else {
                    return false;
                }
            }
            return true;
        }
    }
    /**
     * 云运动 - 验卡模型 -  统一激活
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/8/18
     * @param $type
     * @return array|null|\yii\db\ActiveRecord
     */
    public function setMemberCardStatus($type)
    {
        if($type == 1){
            \common\models\base\MemberCard::updateAll(['status'=>1,'active_time'=>$this->activeFuTime,'invalid_time'=>$this->invalidFuTime],['pid'=>$this->id]);
        }else{
            $card = MemberCard::findAll(['pid'=>$this->id,'status'=>4]);
            if(!empty($card)){
                \common\models\base\MemberCard::updateAll(['status'=>1,'active_time'=>$this->activeTime,'invalid_time'=>$this->invalidTime],['pid'=>$this->id]);
            }
        }
    }

    /**
     * 验卡管理 - 验证会员卡是否次数用完或在限制时间内
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/06/21
     * @param  $id //会员卡id
     * @return string
     */
    public function checkAbout($id,$startTime,$venueId)
    {
        $this->id       = $id;
        $this->venueId  = $venueId;
        $this->memberId = \common\models\base\MemberCard::findOne(['id' => $id])->member_id;
        $totalNum = $this->getVenueLimitTimes();             //查询馆次数核算表（获取总次数）
        $num      = $this->getEntryRecord();                 //统计会员卡进场次数
        if ($num >= $totalNum && $totalNum != -1) {
            $data = EntryRecord::find()
                ->where(['member_card_id' => $this->id])
                ->andWhere(['venue_id' => $this->venueId])
                ->andWhere(['member_id' => $this->memberId])
                ->orderBy(['entry_time' => SORT_DESC])
                ->select('id,entry_time')
                ->asArray()->one();
            if(date('Y-m-d',$startTime) != date('Y-m-d',$data['entry_time'])){
                return '会员卡本月的使用次数已用完';
            }
        }
        $cardTime = $this->checkCardTime($startTime);
        if ($cardTime === false) {
            return '您的进馆时间与卡限制时间不对应';
        }
        return true;
    }

    /**
     * 验卡管理 - 验证课程开始时间是否在限制时间内
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/06/21
     * @param  $startTime //课程开始时间
     * @return string
     */
    public function checkCardTime($startTime)
    {
        $applyTime = VenueLimitTimes::find()
            ->where(['member_card_id' => $this->id])
            ->andWhere(['or',['venue_id' => $this->venueId],['like','venue_ids','"'.$this->venueId.'"']])
            ->andWhere(['or', ['IS NOT','apply_start',NULL],['IS NOT','apply_end',NULL]])
            ->asArray()->one();
        if(isset($applyTime) && $applyTime['apply_start'] !=  $applyTime['apply_end'] ){
            $time  = date('H:i',$startTime);
            $start = date('H:i',$applyTime['apply_start']);
            $end   = date('H:i',$applyTime['apply_end']);
            if($end == '00:00')$end = '24:00' ;
            if(!empty($applyTime['apply_start']) && !empty($applyTime['apply_end'])){
                if($time<$start || $time>$end){
                    return false;
                }
            }
            if(empty($applyTime['apply_start']) && !empty($applyTime['apply_end'])){
                if($time>$end){
                    return false;
                }
            }
            if(!empty($applyTime['apply_start']) && empty($applyTime['apply_end'])){
                if($time<$start){
                    return false;
                }
            }
        }
        $day  = date('d', $startTime);
        $week = date('w', $startTime);
        $week = $week == 0 ? 7 : $week;
        $cardTime = MemberCardTime::find()->where(['member_card_id' => $this->id])->select('day,week')->asArray()->one();

        if (!empty($cardTime['day'])) {
            $dayArr = json_decode($cardTime['day'], true);
            if (isset($dayArr['day']) && !empty($dayArr['day'])) {
                if (in_array($day, $dayArr['day'])) {
                    if (!empty($dayArr['start'])) {
                        $start = strtotime(date('Y-m-d') . ' ' . $dayArr['start']);
                        if ($startTime < $start) {
                            return false;
                        }
                    }
                    if (!empty($dayArr['end'])) {
                        $end = strtotime(date('Y-m-d') . ' ' . $dayArr['end']);
                        if ($startTime > $end) {
                            return false;
                        }
                    }
                    return true;
                } else {
                    return false;
                }
            }
        }
        if (!empty($cardTime['week'])) {
            $weekArr = json_decode($cardTime['week'], true);
            if (isset($weekArr['weeks']) && !empty($weekArr['weeks'])) {
                if (in_array($week, $weekArr['weeks'])) {
                    $flipArr = array_flip($weekArr['weeks']);
                    $start = $weekArr['startTime'][$flipArr[$week]];
                    if (!empty($start)) {
                        $start = strtotime(date('Y-m-d') . ' ' . $start);
                        if ($startTime < $start) {
                            return false;
                        }
                    }
                    $end = $weekArr['endTime'][$flipArr[$week]];
                    if (!empty($end)) {
                        $end = strtotime(date('Y-m-d') . ' ' . $end);
                        if ($startTime > $end) {
                            return false;
                        }
                    }
                    return true;
                } else {
                    return false;
                }
            }
            return true;
        }
    }
}

