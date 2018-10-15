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
class AttributeMatchingForm extends Model
{
    public $checkArrId;         //多选属性数组
    public $oldCardId;            //会员卡id
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
     * @公共管理 - 属性匹配
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/2/2
     * @inheritdoc
     */
    public function setCardMatching($companyId)
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
                    $limitCard = LimitCardNumber::find()->where(['and',['card_category_id'=>$this->cardCategoryId],['status'=>[1,3]]])->asArray()->all();
                    if(!empty($limitCard) && $limitCard){
                        $memberLimitTime = $this->saveMemberLimitTime($limitCard,$companyId,$cardCategory);
                        if($memberLimitTime !== true){
                            throw new \Exception(self::NOTICE);
                        }
                    }
               
                } else if ($v == 5) {
                    $cardTime = CardTime::findOne(['card_category_id' => $this->cardCategoryId]);
                    $memberCardTime = $this->saveMemberCardTime($cardTime,$cardCategory);
                    if($memberCardTime != true){
                        throw new \Exception(self::NOTICE);
                    }
                } else if ($v == 6) {
                    $bindPack    = BindPack::find()->where(['and',['card_category_id'=>$this->cardCategoryId],['polymorphic_type'=>'class']])->asArray()->all();
                    $memberClass = $this->saveBindMemberClass($bindPack,$cardCategory);
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
                        $memberGifts = $this->saveBindMemberGift($memberGift,$cardCategory);
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
//                else if($v == 10){
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

        $oldCardCategory                     = CardCategory::findOne(['id'=>$this->oldCardId]);
        $oldCardCategory->attributes         = $cardCategory['attributes'];                       //属性
        if ($oldCardCategory->save()!=true) {
            return $oldCardCategory->errors;
        }else{
            $memberData = MemberCard::find()->where(['and',['venue_id'=>$cardCategory['venue_id']],['card_category_id'=>$oldCardCategory['id']]])->asArray()->all();
            foreach ($memberData as $key=>$value){
                $memberCardOne = MemberCard::findOne(['id'=>$value['id']]);
                $memberCardOne->attributes = $cardCategory['attributes'];
                if ($memberCardOne->save() != true) {
                    return $memberCardOne->errors;
                }
            }
            return true;
        }
    }
    //卡的类型
    public function saveMemberCardType($cardCategory)
    {
        $oldCardCategory                     = CardCategory::findOne(['id'=>$this->oldCardId]);
        $oldCardCategory->card_type          = $cardCategory['card_type'];                       //类型
        if (!$oldCardCategory->save()) {
            return $oldCardCategory->errors;
        }else{
            $memberData = MemberCard::find()->where(['and',['venue_id'=>$cardCategory['venue_id']],['card_category_id'=>$oldCardCategory['id']]])->asArray()->all();
            foreach ($memberData as $key=>$value){
                $memberCardOne = MemberCard::findOne(['id'=>$value['id']]);
                $memberCardOne->card_type = $cardCategory['card_type'];
                if ($memberCardOne->save() != true) {
                    return $memberCardOne->errors;
                }
            }
            return true;
        }
    }
    //是否带人
    public function saveMemberCardBring($cardCategory)
    {
        $oldCardCategory                     = CardCategory::findOne(['id'=>$this->oldCardId]);
        $oldCardCategory->bring              = $cardCategory['bring'];                       //是否带人
        if ($oldCardCategory->save()!=true) {
            return $oldCardCategory->errors;
        }else{
            $memberData = MemberCard::find()->where(['and',['venue_id'=>$cardCategory['venue_id']],['card_category_id'=>$oldCardCategory['id']]])->asArray()->all();
            foreach ($memberData as $key=>$value){
                $memberCardOne        = MemberCard::findOne(['id'=>$value['id']]);
                $memberCardOne->bring = $cardCategory['bring'];
                if ($memberCardOne->save() != true) {
                    return $memberCardOne->errors;
                }
            }
            return true;
        }
    }
    //请假
    public function saveMemberCardLeave($cardCategory)
    {
        $oldCardCategory                             = CardCategory::findOne(['id'=>$this->oldCardId]);
        $oldCardCategory->leave_long_limit           = $cardCategory['leave_long_limit'];
        $oldCardCategory->student_leave_limit        = $cardCategory['student_leave_limit'];
        $oldCardCategory->leave_total_days           = $cardCategory['leave_total_days'];
        $oldCardCategory->leave_least_Days           = $cardCategory['leave_least_Days'];
        if ($oldCardCategory->save()!=true) {
            return $oldCardCategory->errors;
        }else{
            $memberData = MemberCard::find()->where(['and',['venue_id'=>$cardCategory['venue_id']],['card_category_id'=>$oldCardCategory['id']]])->asArray()->all();
            foreach ($memberData as $key=>$value){
                $memberCardOne                             = MemberCard::findOne(['id'=>$value['id']]);
                $memberCardOne->leave_days_times           = $cardCategory['leave_long_limit'];
                $memberCardOne->student_leave_limit        = $cardCategory['student_leave_limit'];
                $memberCardOne->leave_total_days           = $cardCategory['leave_total_days'];
                $memberCardOne->leave_least_days           = $cardCategory['leave_least_Days'];
                if ($memberCardOne->save() != true) {
                    return $memberCardOne->errors;
                }
            }
            return true;
        }
    }
    //转让
    public function saveMemberCardTransfer($cardCategory)
    {
        $oldCardCategory                                = CardCategory::findOne(['id'=>$this->oldCardId]);
        $oldCardCategory->transfer_number               = $cardCategory['transfer_number'];
        $oldCardCategory->transfer_price                = $cardCategory['transfer_price'];
        if ($oldCardCategory->save()!=true) {
            return $oldCardCategory->errors;
        }else{
            $memberData = MemberCard::find()->where(['and',['venue_id'=>$cardCategory['venue_id']],['card_category_id'=>$oldCardCategory['id']]])->asArray()->all();
            foreach ($memberData as $key=>$value){
                $memberCardOne        = MemberCard::findOne(['id'=>$value['id']]);
                $memberCardOne->transfer_num   = $cardCategory['transfer_number'];
                $memberCardOne->transfer_price = $cardCategory['transfer_price'];
                $memberCardOne->surplus        = $cardCategory['transfer_number'];
                if ($memberCardOne->save() != true) {
                    return $memberCardOne->errors;
                }
            }
            return true;
        }
    }
    //合同
    public function saveMemberCardContract($cardCategory)
    {
        $oldCardCategory                           = CardCategory::findOne(['id'=>$this->oldCardId]);
        $oldCardCategory->deal_id                  = $cardCategory['deal_id'];
        if ($oldCardCategory->save()!=true) {
            return $oldCardCategory->errors;
        }else{
            $memberData = MemberCard::find()->where(['and',['venue_id'=>$cardCategory['venue_id']],['card_category_id'=>$oldCardCategory['id']]])->asArray()->all();
            foreach ($memberData as $key=>$value){
                $memberCardOne            = MemberCard::findOne(['id'=>$value['id']]);
                $memberCardOne->deal_id   = $cardCategory['deal_id'];
                if ($memberCardOne->save() != true) {
                    return $memberCardOne->errors;
                }
            }
            return true;
        }
    }
    //通用场馆限制
    public function saveMemberLimitTime($limitCard,$companyId,$cardCategory)
    {
        if (!empty($limitCard)) {
            $delLimitCard = LimitCardNumber::find()->where(['and',['card_category_id'=>$this->cardCategoryId],['status'=>3]])->asArray()->all();
            if(!empty($delLimitCard)){
                LimitCardNumber::deleteAll(['and', ['card_category_id' => $this->oldCardId], ['status' => [1,3]]]);
            }else{
                LimitCardNumber::deleteAll(['and', ['card_category_id' => $this->oldCardId], ['status' => 1]]);
            }

            LimitCardNumber::deleteAll(['and', ['card_category_id' => $this->oldCardId], ['status' => null]]);

            $memberData = MemberCard::find()->where(['and',['card_category_id' => $this->oldCardId],['venue_id'=>$cardCategory['venue_id']]])
                ->andWhere(['status'=>1])
                ->asArray()->all();
            $idArr = array_column($memberData,'id');
            VenueLimitTimes::deleteAll(['member_card_id' => $idArr]);

            $failureMemberData = MemberCard::find()->where(['and',['card_category_id' => $this->oldCardId],['venue_id'=>$cardCategory['venue_id']]])
                ->andWhere(['or',['status'=>2],['status'=>3]])
                ->asArray()->all();
            $failureIdArr = array_column($failureMemberData,'id');
            VenueLimitTimes::deleteAll(['member_card_id' => $failureIdArr]);

            $activeMemberData = MemberCard::find()->where(['and',['card_category_id' => $this->oldCardId],['venue_id'=>$cardCategory['venue_id']]])
                ->andWhere(['status'=>4])
                ->asArray()->all();
            $activeIdArr = array_column($activeMemberData,'id');
            VenueLimitTimes::deleteAll(['member_card_id' => $activeIdArr]);

            foreach ($limitCard as $key => $value) {
                $oldLimitCard = new LimitCardNumber();
                $oldLimitCard->card_category_id = $this->oldCardId;
                $oldLimitCard->venue_id = $value['venue_id'];
                $oldLimitCard->times = $value['times'];
//                $oldLimitCard->limit = $value['limit'];
                $oldLimitCard->level = $value['level'];
                $oldLimitCard->status = $value['status'];
//                $oldLimitCard->sell_start_time = $value['sell_start_time'];
//                $oldLimitCard->sell_end_time = $value['sell_end_time'];
//                $oldLimitCard->surplus = $value['surplus'];
                $oldLimitCard->week_times = $value['week_times'];
                $oldLimitCard->venue_ids = $value['venue_ids'];
                $oldLimitCard->identity = $value['identity'];
                $oldLimitCard->apply_start = $value['apply_start'];
                $oldLimitCard->apply_end = $value['apply_end'];
                $oldLimitCard->apply_end = $value['apply_end'];
                $oldLimitCard->about_limit = $value['about_limit'];
                if (!$oldLimitCard->save()) {
                    return $oldLimitCard->errors;
                } else {
                    foreach ($memberData as $h => $s) {
                        $limitTime = new VenueLimitTimes();
                        $limitTime->member_card_id   = $s['id'];
                        $limitTime->venue_id         = $value['venue_id'];
                        if(!empty($value['times'])){
                            $limitTime->total_times      = $value['times'];
                        }else{
                            $limitTime->overplus_times   = $value['week_times'];
                        }
                        $limitTime->company_id       = $companyId;
                        $limitTime->level            = $value['level'];
                        $limitTime->venue_ids        = $value['venue_ids'];
                        $limitTime->apply_start      = $value['apply_start'];
                        $limitTime->apply_end        = $value['apply_end'];
                        $limitTime->week_times       = $value['week_times'];
                        $limitTime->about_limit      = $value['about_limit'];
                        if (!$limitTime->save()) {
                            return $limitTime->errors;
                        }
                    }
                    foreach ($failureMemberData as $c => $x) {
                        $limitTime = new VenueLimitTimes();
                        $limitTime->member_card_id   = $x['id'];
                        $limitTime->venue_id         = $value['venue_id'];
                        if(!empty($value['times'])){
                            $limitTime->total_times      = $value['times'];
                        }else{
                            $limitTime->overplus_times   = $value['week_times'];
                        }
                        $limitTime->company_id       = $companyId;
                        $limitTime->level            = $value['level'];
                        $limitTime->venue_ids        = $value['venue_ids'];
                        $limitTime->apply_start      = $value['apply_start'];
                        $limitTime->apply_end        = $value['apply_end'];
                        $limitTime->week_times       = $value['week_times'];
                        $limitTime->about_limit      = $value['about_limit'];
                        if (!$limitTime->save()) {
                            return $limitTime->errors;
                        }
                    }

                    foreach ($activeMemberData as $a => $b) {
                        $limitTime = new VenueLimitTimes();
                        $limitTime->member_card_id   = $b['id'];
                        $limitTime->venue_id         = $value['venue_id'];
                        if(!empty($value['times'])){
                            $limitTime->total_times      = $value['times'];
                        }else{
                            $limitTime->overplus_times   = $value['week_times'];
                        }
                        $limitTime->company_id       = $companyId;
                        $limitTime->level            = $value['level'];
                        $limitTime->venue_ids        = $value['venue_ids'];
                        $limitTime->apply_start      = $value['apply_start'];
                        $limitTime->apply_end        = $value['apply_end'];
                        $limitTime->week_times       = $value['week_times'];
                        $limitTime->about_limit      = $value['about_limit'];
                        if (!$limitTime->save()) {
                            return $limitTime->errors;
                        }
                    }
                }
            }
            return true;
        }
    }
    //进馆时间限制
    public function saveMemberCardTime($cardTime,$cardCategory)
    {
            $oldCardTime   = CardTime::findOne(['card_category_id'=>$this->oldCardId]);
            if(!empty($oldCardTime)){
                $oldCardTime->start        = $cardTime['start'];
                $oldCardTime->end          = $cardTime['end'];
                $oldCardTime->day          = $cardTime['day'];
                $oldCardTime->week         = $cardTime['week'];
                $oldCardTime->month        = $cardTime['month'];
                $oldCardTime->quarter      = $cardTime['quarter'];
                $oldCardTime->year         = $cardTime['year'];
                $oldCardTime->update_at    = time();
                if ($oldCardTime->save()!=true) {
                    return $oldCardTime->errors;
                }else{
                    $memberData = MemberCard::find()->where(['and',['card_category_id'=>$this->oldCardId],['venue_id'=>$cardCategory['venue_id']]])->asArray()->all();
                    foreach ($memberData as $key=>$value){
                        $memberCardOne = MemberCardTime::findOne(['member_card_id'=>$value['id']]);
                        if(!empty($memberCardOne)){
                            $memberCardOne->start          = $cardTime['start'];
                            $memberCardOne->end            = $cardTime['end'];
                            $memberCardOne->day            = $cardTime['day'];
                            $memberCardOne->week           = $cardTime['week'];
                            $memberCardOne->month          = $cardTime['month'];
                            $memberCardOne->quarter        = $cardTime['quarter'];
                            $memberCardOne->year           = $cardTime['year'];
                            $memberCardOne->update_at      = time();
                            if ($memberCardOne->save() != true) {
                                return $memberCardOne->errors;
                            }
                        }else{
                            $memberCardAdd = new MemberCardTime();
                            $memberCardAdd->member_card_id = $value['id'];
                            $memberCardAdd->start          = $cardTime['start'];
                            $memberCardAdd->end            = $cardTime['end'];
                            $memberCardAdd->day            = $cardTime['day'];
                            $memberCardAdd->week           = $cardTime['week'];
                            $memberCardAdd->month          = $cardTime['month'];
                            $memberCardAdd->quarter        = $cardTime['quarter'];
                            $memberCardAdd->year           = $cardTime['year'];
                            $memberCardAdd->update_at      = time();
                            if ($memberCardAdd->save() != true) {
                                return $memberCardAdd->errors;
                            }
                        }
                    }
                    return true;
                }
            }else{
                $oldCardTime = new CardTime();
                $oldCardTime->card_category_id = $this->oldCardId;
                $oldCardTime->start        = $cardTime['start'];
                $oldCardTime->end          = $cardTime['end'];
                $oldCardTime->day          = $cardTime['day'];
                $oldCardTime->week         = $cardTime['week'];
                $oldCardTime->month        = $cardTime['month'];
                $oldCardTime->quarter      = $cardTime['quarter'];
                $oldCardTime->year         = $cardTime['year'];
                $oldCardTime->update_at    = time();
                if ($oldCardTime->save()!=true) {
                    return $oldCardTime->errors;
                }else{
                    $memberData = MemberCard::find()->where(['and',['card_category_id'=>$this->oldCardId],['venue_id'=>$cardCategory['venue_id']]])->asArray()->all();
                    foreach ($memberData as $key=>$value){
                        $memberCardOne = MemberCardTime::findOne(['member_card_id'=>$value['id']]);
                        if(!empty($memberCardOne)){
                            $memberCardOne->start          = $cardTime['start'];
                            $memberCardOne->end            = $cardTime['end'];
                            $memberCardOne->day            = $cardTime['day'];
                            $memberCardOne->week           = $cardTime['week'];
                            $memberCardOne->month          = $cardTime['month'];
                            $memberCardOne->quarter        = $cardTime['quarter'];
                            $memberCardOne->year           = $cardTime['year'];
                            $memberCardOne->update_at      = time();
                            if ($memberCardOne->save() != true) {
                                return $memberCardOne->errors;
                            }
                        }else{
                            $memberCardAdd = new MemberCardTime();
                            $memberCardAdd->member_card_id = $value['id'];
                            $memberCardAdd->start          = $cardTime['start'];
                            $memberCardAdd->end            = $cardTime['end'];
                            $memberCardAdd->day            = $cardTime['day'];
                            $memberCardAdd->week           = $cardTime['week'];
                            $memberCardAdd->month          = $cardTime['month'];
                            $memberCardAdd->quarter        = $cardTime['quarter'];
                            $memberCardAdd->year           = $cardTime['year'];
                            $memberCardAdd->update_at      = time();
                            if ($memberCardAdd->save() != true) {
                                return $memberCardAdd->errors;
                            }
                        }
                    }
                    return true;
                }
            }
    }
    //团课套餐限制
    public function saveBindMemberClass($bindPack,$cardCategory)
    {
        if (!empty($bindPack)){
            BindPack::deleteAll(['and',['card_category_id'=>$this->oldCardId],['polymorphic_type'=>'class']]);
            $memberData = MemberCard::find()->where(['and',['card_category_id'=>$this->oldCardId],['venue_id'=>$cardCategory['venue_id']]])->asArray()->all();
            foreach ($memberData as $k=>$v) {
                BindMemberCard::deleteAll(['and',['member_card_id' => $v['id']],['polymorphic_type'=>'class']]);
            }
            foreach ($bindPack as $key=>$value){
                $oldBindPack = new BindPack();
                $oldBindPack->card_category_id  = $this->oldCardId;
                $oldBindPack->polymorphic_id    = $value['polymorphic_id'];
                $oldBindPack->polymorphic_type  = $value['polymorphic_type'];
                $oldBindPack->number            = $value['number'];
                $oldBindPack->status            = $value['status'];
                $oldBindPack->company_id        = $value['company_id'];
                $oldBindPack->venue_id          = $value['venue_id'];
                $oldBindPack->polymorphic_ids   = $value['polymorphic_ids'];
                if ($oldBindPack->save() != true)  {
                    return $oldBindPack->errors;
                }else{
                    foreach ($memberData as $h => $s){
                        $memberBindPack = new BindMemberCard();
                        $memberBindPack->member_card_id    = $s['id'];
                        $memberBindPack->polymorphic_id    = $value['polymorphic_id'];
                        $memberBindPack->polymorphic_type  = $value['polymorphic_type'];
                        $memberBindPack->number            = $value['number'];
                        $memberBindPack->status            = $value['status'];
                        $memberBindPack->company_id        = $value['company_id'];
                        $memberBindPack->venue_id          = $value['venue_id'];
                        $memberBindPack->polymorphic_ids   = $value['polymorphic_ids'];
                        if ($memberBindPack->save() != true) {
                            return $memberBindPack->errors;
                        }
                    }
                }
            }
            return true;
        }else{
            return true;
        }
    }
    //赠品
    public function saveBindMemberGift($memberGift,$cardCategory)
    {
        if (!empty($memberGift)){
            BindPack::deleteAll(['and',['card_category_id'=>$this->oldCardId],['polymorphic_type'=>'gift']]);
            $memberData = MemberCard::find()->where(['and',['card_category_id'=>$this->oldCardId],['venue_id'=>$cardCategory['venue_id']]])->asArray()->all();
            foreach ($memberData as $k=>$v) {
                BindMemberCard::deleteAll(['and',['member_card_id' => $v['id']],['polymorphic_type'=>'gift']]);
            }
            foreach ($memberGift as $key=>$value){
                $oldMemberGift = new BindPack();
                $oldMemberGift->card_category_id  = $this->oldCardId;
                $oldMemberGift->polymorphic_id    = $value['polymorphic_id'];
                $oldMemberGift->polymorphic_type  = $value['polymorphic_type'];
                $oldMemberGift->number            = $value['number'];
                $oldMemberGift->status            = $value['status'];
                $oldMemberGift->company_id        = $value['company_id'];
                $oldMemberGift->venue_id          = $value['venue_id'];
                $oldMemberGift->polymorphic_ids   = $value['polymorphic_ids'];
                if ($oldMemberGift->save() != true)  {
                    return $oldMemberGift->errors;
                }else{
                    foreach ($memberData as $h=>$s) {
                        $memberBindPack = new BindMemberCard();
                        $memberBindPack->member_card_id    = $s['id'];
                        $memberBindPack->polymorphic_id    = $value['polymorphic_id'];
                        $memberBindPack->polymorphic_type  = $value['polymorphic_type'];
                        $memberBindPack->number            = $value['number'];
                        $memberBindPack->status            = $value['status'];
                        $memberBindPack->company_id        = $value['company_id'];
                        $memberBindPack->venue_id          = $value['venue_id'];
                        $memberBindPack->polymorphic_ids   = $value['polymorphic_ids'];
                        if ($memberBindPack->save() != true) {
                            return $memberBindPack->errors;
                        }
                    }
                }
            }
            return true;
        }
    }
    //有效期续费
    public function saveCardRenewal($cardCategory)
    {
        $oldCardCategory                     = CardCategory::findOne(['id'=>$this->oldCardId]);
        $oldCardCategory->validity_renewal   = $cardCategory['validity_renewal'];                       //属性
        if ($oldCardCategory->save()!=true) {
            return $oldCardCategory->errors;
        }else{
            $memberData = MemberCard::find()->where(['and',['venue_id'=>$cardCategory['venue_id']],['card_category_id'=>$oldCardCategory['id']]])->asArray()->all();
            foreach ($memberData as $key=>$value){
                $memberCardOne = MemberCard::findOne(['id'=>$value['id']]);
                $memberCardOne->validity_renewal = $cardCategory['validity_renewal'];
                if ($memberCardOne->save() != true) {
                    return $memberCardOne->errors;
                }
            }
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
        $machineRecord                        = new MatchingRecord();
        $machineRecord->member_card_id        = $this->oldCardId;                    //会员卡id
        $machineRecord->member_category_id    = $this->cardCategoryId;               //卡种id
        $machineRecord->create_at             = time();                              //创建时间
        $machineRecord->note                  = $this->note;                         //备注
        $machineRecord->create_id             = $this->getCreate();                  //操作人id
        $machineRecord->attribute_matching    = json_encode($this->checkArrId);      //通店属性
        //$machineRecord->status                = time();                    //状态
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