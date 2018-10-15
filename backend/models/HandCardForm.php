<?php

namespace backend\models;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\VenueLimitTimes;
use common\models\base\MemberAccount;
use yii\base\Model;
use common\models\base\MemberDealRecord;
use common\models\base\Deal;
use common\models\base\DealType;


class HandCardForm  extends Model
{
    public $username;               //姓名
    public $sex;                //性别
    public $idCard;             //身份证号
    public $mobile;             //手机号
    public $code;               //验证码
    public $memberCardId;       //会员卡ID
    public $cardCateGoryId;     //卡种ID
    public $saleMan;            //会籍顾问
    public $number;             //主卡号
    public $venueId;
    public $companyId;
    const CODE   = 'code';
    const NOTICE = '操作失败';
    /**
     * 业务后台 - 绑定带人卡 - 规则
     * @return array
     */
    public function rules()
    {
        return [
          [['username','sex','idCard','mobile','memberCardId','code'],'safe']
        ];
    }

    /**
     * @云运动 - 售卡系统 - 存储数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/15
     * @inheritdoc
     */
    public function setMainCard()
    {
        $mainCard      = MemberCard::findOne(['id'=>$this->memberCardId]);
        $this->cardCateGoryId = $mainCard->card_category_id;
        $this->number         = $mainCard->card_number;
        $cardCategory  = CardCategory::findOne(['id' => $this->cardCateGoryId]);    //查出所选卡种的信息
        $time          = json_decode($cardCategory->duration,true);                  //卡种有效期
        $leave         = json_decode($cardCategory->leave_long_limit,true);         //卡种每次请假天数、请假次数
        $mainMember    = Member::findOne(['id'=>$mainCard->member_id]);
        $this->saleMan = $mainMember->counselor_id;
        $this->venueId   = $mainMember->venue_id;
        $this->companyId = $mainMember->company_id;
        $member        = Member::findOne(['mobile' => $this->mobile,'venue_id' => $this->venueId]);               //查询所填手机号的会员信息
        $memberDetails = MemberDetails::findOne(['member_id' => $member['id']]);     //查询会员对应的详细信息
        if(isset($member)){
            $transaction = \Yii::$app->db->beginTransaction();
            if ($mainCard->member_id == $member->id) {
                return '带人卡不能绑定自己';
            }
            try {
                $member->member_type                      = 1;
                $member->status                           = 1;
                $member = $member->save() ? $member : $member->errors;
                if(!isset($member->id)){
                    throw new \Exception(self::NOTICE);
                }

                if(isset($memberDetails)){
                    $memberDetails->member_id             = $member->id;
                    $memberDetails->name                  = $this->username;
                    $memberDetails->id_card               = $this->idCard;
                    $memberDetails->sex                   = $this->sex;
                    $memberDetails->recommend_member_id = 0;
                    $memberDetails->updated_at           = time();
                    $memberDetails = $memberDetails->save() ? $memberDetails : $memberDetails->errors;
                    if(!isset($memberDetails->id)){
                        throw new \Exception(self::NOTICE);
                    }
                }else{
                    $memberDetails = $this->saveMemberDetails($member);
                    if(!isset($memberDetails->id)){
                        throw new \Exception(self::NOTICE);
                    }
                }

                $memberCard = $this->saveMemberCard($member,$time,$mainCard,$leave);
                if(!isset($memberCard->id)){
                    return $memberCard;
                }

                $bindMemberCard = $this->saveBindCard($memberCard);
                if($bindMemberCard !== true){
                    return $bindMemberCard;
                }

                $dealRecord = $this->saveDealRecord($cardCategory,$memberCard);
                if($dealRecord !== true){
                    return $dealRecord;
                }

                $limit = $this->saveVenueLimit($memberCard,$cardCategory);
                if($limit !== true){
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
        }else{
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $memberAccount = MemberAccount::findOne(['mobile'=>$this->mobile]);
                $password                = '123456';
                $password                = \Yii::$app->security->generatePasswordHash($password);
                if(empty($memberAccount)){
                    $ma                    = new MemberAccount();
                    $ma->mobile            = $this->mobile;
                    $ma->username          = $this->username;
                    $ma->password          = $password;
                    $ma->create_at         = time();
                    $ma->company_id        = $this->companyId;
                    $ma->save();
                    if (!isset($ma->id)) {
                        return $ma->errors;
                    }
                }
                $member                  = new Member();
                $member->username       = $this->mobile;
                $member->mobile         = $this->mobile;
                $member->password       = $password;
                $member->register_time = time();
                $member->status         = 1;
                $member->counselor_id   = $this->saleMan;
                $member->member_type    = 1;
                $member->venue_id       = $this->venueId;
                $member->company_id     = $this->companyId;
                if(!empty($memberAccount)){
                    $member->member_account_id          = $memberAccount['id'];
                }else{
                    $member->member_account_id          = $ma->id;
                }
                $member = $member->save() ? $member : $member->errors;
                if(!isset($member->id)){
                    throw new \Exception(self::NOTICE);
                }

                $memberDetails = $this->saveMemberDetails($member);
                if(!isset($memberDetails->id)){
                    throw new \Exception(self::NOTICE);
                }

                $memberCard = $this->saveMemberCard($member,$time,$mainCard,$leave);
                if(!isset($memberCard->id)){
                    return $memberCard;
                }

                $bindMemberCard = $this->saveBindCard($memberCard);
                if($bindMemberCard !== true){
                    return $bindMemberCard;
                }

                $dealRecord = $this->saveDealRecord($cardCategory,$memberCard);
                if($dealRecord !== true){
                    return $dealRecord;
                }

                $limit = $this->saveVenueLimit($memberCard,$cardCategory);
                if($limit !== true){
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
    }

    /**
     * 云运动 - 售卡系统 - 存储会员详情表
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/5/19
     * @return array
     */
    public function saveMemberDetails($member)
    {
        $memberDetails                        = new MemberDetails();
        $memberDetails->member_id            = $member->id;
        $memberDetails->name                  = $this->username;
        $memberDetails->id_card              = $this->idCard;
        $memberDetails->sex                   = $this->sex;
        $memberDetails->recommend_member_id = 0;
        $memberDetails->created_at           = time();
        $memberDetails = $memberDetails->save() ? $memberDetails : $memberDetails->errors;
        if ($memberDetails) {
            return $memberDetails;
        }else{
            return $memberDetails->errors;
        }
    }

    /**
     * 云运动 - 售卡系统 - 存储会员卡
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/5/19
     * @return array
     */
    public function saveMemberCard($member,$time,$mainCard,$leave)
    {
        $isMember = MemberCard::findOne(['pid'=>$this->memberCardId,'member_id'=>$member->id]);
        if(!empty($isMember)){
            return '此会员卡,已经绑定过该用户了';
        }
        $card = MemberCard::findOne(['pid'=>$this->memberCardId,'member_id'=>0]);
        if(!empty($card)){
            $card->member_id = $member->id;
            if($card->save()){
                return $card;
            }
            return $card->errors;
        }
        $count                         = count(MemberCard::findAll(['pid'=>$this->memberCardId]));
        $number                        = $count < 10 ?$this->number.'-0'.($count+1) : $this->number.'-'.($count+1);
        $memberCard                    = new MemberCard();
        $memberCard->member_id         = $member->id;                       //会员ID
        $memberCard->card_category_id  = $this->cardCateGoryId;            //卡种
        $memberCard->payment_type      = 1;                //付款方式
        $memberCard->amount_money      = 0;                 //总金额
        $memberCard->status            = $mainCard->status;
        $memberCard->active_time       =  $mainCard->active_time;
        $memberCard->employee_id       = $this->saleMan;                      //销售
        $memberCard->create_at         = time();                               //售卡时间
        $memberCard->level              = 1;                                    //等级
        $memberCard->card_number       = $number;    //卡号
        $memberCard->is_complete_pay  = 1;                                     //完成付款
        $memberCard->invalid_time       = $mainCard->invalid_time;          //失效时间
        if($mainCard->card_type == 3 || $mainCard->card_type == 4){
            $memberCard->balance         = 0;
        }else{
            $memberCard->balance         = 0;                                      //余额
        }
        $memberCard->total_times        = $mainCard->total_times;                   //总次数(次卡)
        $memberCard->consumption_times  = 0;                                      //消费次数
        $memberCard->card_name          = $mainCard->card_name.'(副卡)';              //卡名
        $memberCard->another_name       = $mainCard->another_name;          //另一个卡名
        $memberCard->card_type          = $mainCard->card_type;      //卡类别
        $memberCard->count_method       = $mainCard->count_method;          //计次方式
        $memberCard->attributes         = $mainCard->attributes;             //属性
        $memberCard->active_limit_time =  $mainCard->active_limit_time;            //激活期限
        $memberCard->transfer_num       = $mainCard->transfer_num;       //转让次数
        $memberCard->surplus            = $mainCard->surplus;       //剩余转让次数
        $memberCard->transfer_price     = $mainCard->transfer_price;        //转让金额
        $memberCard->recharge_price     = $mainCard->recharge_price;        //充值卡充值金额
        $memberCard->present_money      = $mainCard->present_money;  //买赠金额
        $memberCard->renew_price        = $mainCard->renew_price;           //续费价
        $memberCard->renew_best_price   = $mainCard->renew_best_price;          //续费优惠价
        $memberCard->renew_unit         = $mainCard->renew_unit;            //续费多长时间/天
        $memberCard->leave_total_days   = $mainCard->leave_total_days;     //请假总天数
        $memberCard->leave_least_days   = $mainCard->leave_least_days;     //每次请假最少天数
        $memberCard->leave_days_times   = json_encode($leave);                   //每次请假天数、请假次数
        $memberCard->deal_id             = $mainCard->deal_id;               //合同id
        $memberCard->duration            = $time['day'];                         //有效期
        $memberCard->venue_id            = $mainCard->venue_id;                              //场馆id
        $memberCard->company_id          = $mainCard->company_id;                            //公司id
        $memberCard->pid                 = $this->memberCardId;
        $memberCard->usage_mode          = !empty($this->usageMode)?$this->usageMode:1;
        $memberCard = $memberCard->save() ? $memberCard : $memberCard->errors;
        if ($memberCard) {
            return $memberCard;
        }else{
            return $memberCard->errors;
        }
    }
    /**
     * 云运动 - 售卡系统 - 存储进场次数核算表
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/6/23
     * @return array
     */
    public function saveVenueLimit($memberCard,$cardCategory)
    {
        $limit = LimitCardNumber::find()->where(['card_category_id' => $this->cardCateGoryId,'status'=>[1,3]])->asArray()->all();
        if(isset($limit)){
            foreach($limit as $k=>$v){
                $limitVenue = new VenueLimitTimes();
                $limitVenue->member_card_id = $memberCard->id;
                $limitVenue->venue_id       = $v['venue_id'];
                $limitVenue->total_times    = $v['times'];
                if(!empty($v['times'])){
                    $limitVenue->overplus_times = $v['times'];
                }else{
                    $limitVenue->overplus_times = $v['week_times'];
                }
                $limitVenue->week_times     = $v['week_times'];
                $limitVenue->venue_ids      = $v['venue_ids'];
                $limitVenue->company_id     = $cardCategory->company_id;
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

    /**
     * 云运动 - 会员带人卡 - 存储会员卡绑定套餐表
     * @author huanghua<huanghua@itsports.club>
     * @param $memberCard
     * @create 2018/4/22
     * @return array
     */
    public function saveBindCard($memberCard)
    {
        $bindData = BindPack::find()->where(['card_category_id' => $this->cardCateGoryId])->asArray()->all();
        if(isset($bindData)){
            foreach($bindData as $k=>$v){
                $memberBindCard = new BindMemberCard();
                $memberBindCard->member_card_id    = $memberCard->id;
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


    /**
     * 云运动 - 带人绑定 - 存储绑定合同记录表
     * @author huanghua<huanghua@itsports.club>
     * @param $cardCategory
     * @param $memberCard
     * @create 2018/5/4
     * @return array
     */
    public function saveDealRecord($cardCategory,$memberCard)
    {
        $dealId        = Deal::find()->where(['and',['type'=>1],['id'=>$cardCategory['deal_id']]])->asArray()->one();
        if (!empty($dealId)){
            $dealDetailsId = DealType::findOne(['id'=>$dealId['deal_type_id']]);
            $dealRecord    = MemberDealRecord::findOne(['type' => 1,'type_id' => $memberCard['id'],'member_id' => $memberCard['member_id']]);
            if(empty($dealRecord)){
                $dealRecord = new MemberDealRecord();
            }
            $dealRecord->type             = 1;
            $dealRecord->type_id          = $memberCard['id'];
            $dealRecord->member_id        = $memberCard['member_id'];
            $dealRecord->deal_number      = 'sp'.time().mt_rand(10000,99999);
            $dealRecord->type_name        = $dealDetailsId['type_name'];
            $dealRecord->intro            = $dealId['intro'];
            $dealRecord->company_id       = $memberCard['company_id'];
            $dealRecord->venue_id         = $memberCard['venue_id'];
            $dealRecord->create_at        = time();
            $dealRecord->name             = $dealId['name'];
            if(!$dealRecord->save()){
                return $dealRecord->errors;
            }
            $card = MemberCard::findOne(['id'=>$memberCard['id']]);
            $card ->deal_id = $dealRecord['id'];
            if(!$card->save()){
                return $card->errors;
            }
            return true;
        }else{
            return true;
        }

    }
}