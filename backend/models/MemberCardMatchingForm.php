<?php
namespace backend\models;

use common\models\base\BindMemberCard;
use common\models\base\BindPack;
use common\models\base\CardTime;
use common\models\base\MemberCardTime;
use common\models\base\VenueLimitTimes;
use Yii;
use yii\base\Model;
use common\models\base\MemberCard;
use common\models\base\CardCategory;
use common\models\base\MatchingRecord;
use common\models\base\LimitCardNumber;
class MemberCardMatchingForm extends Model
{
    public $checkArrId;         //多选属性数组
    public $oldCardId;          //会员卡id
    public $cardCategoryId;    //卡种id
    public $note;              //备注
    const NOTICE = '操作失败';

    /**
     * 公共管理 - 属性匹配 - 表单规则验证
     * @author 黄华<huanghua@itsports.club>
     * @create 2017/2/2
     * @return array
     */
    public function rules()
    {
        return [
            [['checkArrId','oldCardId','cardCategoryId','note'],'safe'],
        ];
    }



    /**
     * @会员管理 - 属性匹配
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/3/14
     * @inheritdoc
     */
    public function setMemberCardMatching($companyId)
    {
        $cardCategory = CardCategory::findOne(['id' => $this->cardCategoryId]);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($this->checkArrId as $k => $v) {
                if ($v == 1) {
                    $memberCardAttributes = $this->saveMemberCardAttributes($cardCategory);
                    if($memberCardAttributes != true){
                        throw new \Exception(self::NOTICE);
                    }
                } else if ($v == 2) {
                    $memberCardType = $this->saveMemberCardType($cardCategory);
                    if($memberCardType != true){
                        throw new \Exception(self::NOTICE);
                    }
                } else if ($v == 3) {
                    $memberBring = $this->saveMemberCardBring($cardCategory);
                    if($memberBring != true){
                        throw new \Exception(self::NOTICE);
                    }
                } else if ($v == 4) {
                    $limit = LimitCardNumber::find()->where(['and',['card_category_id'=>$this->cardCategoryId],['status'=>[1,3]]])->asArray()->all();
                    $memberLimitTime = $this->saveMemberLimitTime($limit,$companyId);
                    if($memberLimitTime !== true){
                        throw new \Exception(self::NOTICE);
                    }
                } else if ($v == 5) {
                    $time = CardTime::findOne(['card_category_id' => $this->cardCategoryId]);
                    $memberCardTime = $this->saveMemberCardTime($time);
                    if($memberCardTime != true){
                        throw new \Exception(self::NOTICE);
                    }
                } else if ($v == 6) {
                    $bindData    = BindPack::find()->where(['and',['card_category_id'=>$this->cardCategoryId],['polymorphic_type'=>'class']])->asArray()->all();
                    $memberClass = $this->saveBindMemberClass($bindData);
                    if($memberClass != true){
                        throw new \Exception(self::NOTICE);
                    }
                } else if ($v == 7) {
                    $memberLeave = $this->saveMemberCardLeave($cardCategory);
                    if($memberLeave != true){
                        throw new \Exception(self::NOTICE);
                    }
                } else if ($v == 8) {
                    $memberGift =  BindPack::find()->where(['and',['card_category_id'=>$this->cardCategoryId],['polymorphic_type'=>'gift']])->asArray()->all();
                    if(!empty($memberGift)){
                        $memberGifts = $this->saveBindMemberGift($memberGift);
                        if($memberGifts != true){
                            throw new \Exception(self::NOTICE);
                        }
                    }

                } else if ($v == 9) {
                    $memberTransfer = $this->saveMemberCardTransfer($cardCategory);
                    if($memberTransfer != true){
                        throw new \Exception(self::NOTICE);
                    }
                }
//                else if ($v == 10){
//                    $memberContract = $this->saveMemberCardContract($cardCategory);
//                    if($memberContract != true){
//                        throw new \Exception(self::NOTICE);
//                    }
                else{
                    $cardRenewal = $this->saveCardRenewal($cardCategory);
                    if($cardRenewal != true){
                        throw new \Exception(self::NOTICE);
                    }
                }
            }
            $matchingRecord = $this->saveMatching();
            if($matchingRecord !== true){
                throw new \Exception(self::NOTICE);
            }
            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return  $e->getMessage();
        }
    }
    /**
     * 公共管理 - 属性匹配 - 修改会员卡属性
     * @author 黄华<huanghua@itsports.club>
     * @create 2018/2/2
     * @param $cardCategory
     * @return array
     */
    //卡的属性
    public function saveMemberCardAttributes($cardCategory)
    {
        $memberCardOne = MemberCard::findOne(['id'=>$this->oldCardId]);
        $memberCardOne ->attributes = $cardCategory['attributes'];
        if ($memberCardOne->save() != true) {
            return $memberCardOne->errors;
        }else{
            return true;
        }
    }
    //卡的类型
    public function saveMemberCardType($cardCategory)
    {
        $memberCardOne = MemberCard::findOne(['id'=>$this->oldCardId]);
        $memberCardOne->card_type = $cardCategory['card_type'];
        if ($memberCardOne->save() != true) {
            return $memberCardOne->errors;
        }else{
            return true;
        }
    }
    //是否带人
    public function saveMemberCardBring($cardCategory)
    {
        $memberCardOne        = MemberCard::findOne(['id'=>$this->oldCardId]);
        $memberCardOne->bring = $cardCategory['bring'];
        if ($memberCardOne->save() != true) {
            return $memberCardOne->errors;
        }else{
            return true;
        }
    }
    //请假
    public function saveMemberCardLeave($cardCategory)
    {
        $memberCardOne                             = MemberCard::findOne(['id'=>$this->oldCardId]);
        $memberCardOne->leave_days_times           = $cardCategory['leave_long_limit'];
        $memberCardOne->student_leave_limit        = $cardCategory['student_leave_limit'];
        $memberCardOne->leave_total_days           = $cardCategory['leave_total_days'];
        $memberCardOne->leave_least_days           = $cardCategory['leave_least_Days'];
        if ($memberCardOne->save() != true) {
            return $memberCardOne->errors;
        }else{
            return true;
        }
    }
    //转让
    public function saveMemberCardTransfer($cardCategory)
    {
        $memberCardOne                 = MemberCard::findOne(['id'=>$this->oldCardId]);
        $memberCardOne->transfer_num   = $cardCategory['transfer_number'];
        $memberCardOne->transfer_price = $cardCategory['transfer_price'];
        $memberCardOne->surplus        = $cardCategory['transfer_number'];
        if ($memberCardOne->save() != true) {
            return $memberCardOne->errors;
        }else{
            return true;
        }
    }
    //合同
    public function saveMemberCardContract($cardCategory)
    {
        $memberCardOne            = MemberCard::findOne(['id'=>$this->oldCardId]);
        $memberCardOne->deal_id   = $cardCategory['deal_id'];
        if ($memberCardOne->save() != true) {
            return $memberCardOne->errors;
        }else{
            return true;
        }
    }
    //通用场馆限制
    public function saveMemberLimitTime($limit,$companyId)
    {
        $limitTimes = VenueLimitTimes::find()->where(['member_card_id' => $this->oldCardId])->asArray()->all();
        if (!empty($limitTimes)){
            VenueLimitTimes::deleteAll(['member_card_id' => $this->oldCardId]);
        }
        if(isset($limit)){
            foreach($limit as $k=>$v){
                $limitVenue = new VenueLimitTimes();
                $limitVenue->member_card_id = $this->oldCardId;
                $limitVenue->venue_id       = $v['venue_id'];
                $limitVenue->total_times    = $v['times'];
                if(!empty($v['times'])){
                    $limitVenue->overplus_times = $v['times'];
                }else{
                    $limitVenue->overplus_times = $v['week_times'];
                }
                $limitVenue->week_times     = $v['week_times'];
                $limitVenue->venue_ids      = $v['venue_ids'];
                $limitVenue->company_id     = $companyId;
                $limitVenue->level          = $v['level'];
                $limitVenue->apply_start    = $v['apply_start'];
                $limitVenue->apply_end      = $v['apply_end'];
                $limitVenue->about_limit    = $v['about_limit'];
                if(!$limitVenue->save()){
                    return $limitVenue->errors;
                }
            }
            return true;
        }
        return true;
    }
    //进馆时间限制
    public function saveMemberCardTime($time)
    {
        $cardTimes = MemberCardTime::find()->where(['member_card_id' => $this->oldCardId])->asArray()->all();
        if (!empty($cardTimes)){
            MemberCardTime::deleteAll(['member_card_id' => $this->oldCardId]);
        }
        if(!empty($time)) {
            $cardTime = new MemberCardTime();
            $cardTime->member_card_id = $this->oldCardId;
            $cardTime->start = $time->start;
            $cardTime->end = $time->end;
            $cardTime->create_at = time();
            $cardTime->day = $time->day;
            $cardTime->week = $time->week;
            $cardTime->month = $time->month;
            $cardTime->quarter = $time->quarter;
            $cardTime->year = $time->year;
            if ($cardTime->save()) {
                return true;
            } else {
                return $cardTime->errors;
            }
        }else{
            return true;
        }
    }
    //团课套餐限制
    public function saveBindMemberClass($bindData)
    {
        $bindMemberCard = BindMemberCard::find()->where(['and',['polymorphic_type'=>'class'],['member_card_id' => $this->oldCardId]])->asArray()->all();
        if (!empty($bindMemberCard)){
            BindMemberCard::deleteAll(['and',['member_card_id' => $this->oldCardId],['polymorphic_type' => 'class']]);
        }
        if(!empty($bindData)){
            foreach($bindData as $k=>$v){
                $memberBindCard = new BindMemberCard();
                $memberBindCard->member_card_id    = $this->oldCardId;
                $memberBindCard->venue_id          = $v['venue_id'];
                $memberBindCard->company_id        = $v['company_id'];
                $memberBindCard->polymorphic_id    = $v['polymorphic_id'];
                $memberBindCard->polymorphic_type  = $v['polymorphic_type'];
                $memberBindCard->number            = $v['number'];
                $memberBindCard->status            = $v['status'];
                $memberBindCard->polymorphic_ids   = $v['polymorphic_ids'];
                if(!$memberBindCard->save()){
                    return $memberBindCard->errors;
                }
            }
            return true;
        }
        return true;
    }
    //赠品
    public function saveBindMemberGift($memberGift)
    {
        $bindMemberCard = BindMemberCard::find()->where(['and',['polymorphic_type'=>'gift'],['member_card_id' => $this->oldCardId]])->asArray()->all();
        if (!empty($bindMemberCard)){
            BindMemberCard::deleteAll(['and',['member_card_id' => $this->oldCardId],['polymorphic_type' => 'gift']]);
        }
        if(isset($memberGift)){
            foreach($memberGift as $k=>$v){
                $memberBindCard = new BindMemberCard();
                $memberBindCard->member_card_id    = $this->oldCardId;
                $memberBindCard->venue_id          = $v['venue_id'];
                $memberBindCard->company_id        = $v['company_id'];
                $memberBindCard->polymorphic_id    = $v['polymorphic_id'];
                $memberBindCard->polymorphic_type  = $v['polymorphic_type'];
                $memberBindCard->number            = $v['number'];
                $memberBindCard->status            = $v['status'];
                $memberBindCard->polymorphic_ids   = $v['polymorphic_ids'];
                if(!$memberBindCard->save()){
                    return $memberBindCard->errors;
                }
            }
            return true;
        }
        return true;
    }
    //有效期续费
    public function saveCardRenewal($cardCategory)
    {
        $renew         = json_decode($cardCategory['validity_renewal'],true);
        $memberCardOne = MemberCard::findOne(['id'=>$this->oldCardId]);
        $memberCardOne ->validity_renewal = json_encode($renew);
        if ($memberCardOne->save() != true) {
            return $memberCardOne->errors;
        }else{
            return true;
        }
    }
    /**
     * 公共管理 - 属性匹配 - 插入匹配记录表
     * @author 黄华<huanghua@itsports.club>
     * @create 2018/2/2
     * @return array
     */
    public function saveMatching()
    {
        $memberCard = MemberCard::findOne(['id'=>$this->oldCardId]);
        $machineRecord                        = new MatchingRecord();
        $machineRecord->member_card_id        = $this->oldCardId;                    //会员卡id
        $machineRecord->member_category_id    = $this->cardCategoryId;               //卡种id
        $machineRecord->create_at             = time();                              //创建时间
        $machineRecord->note                  = $this->note;                         //备注
        $machineRecord->create_id             = $this->getCreate();                  //操作人id
        $machineRecord->attribute_matching    = json_encode($this->checkArrId);      //通店属性
        $machineRecord->type                  = 2;                                   //会员卡匹配
        $machineRecord->member_id             = $memberCard['member_id'];            //会员id
        return $machineRecord->save() ? true : $machineRecord->errors;
    }
    public function getCreate()
    {
        if(isset(\Yii::$app->user->identity) && !empty(\Yii::$app->user->identity)){
            $create = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
            $create = isset($create->id)?intval($create->id):0;
            return $create;
        }
        return 0;
    }

}