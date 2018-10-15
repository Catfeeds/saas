<?php
namespace backend\models;

use common\models\GiftCardList;
use common\models\MemberAccount;
use yii\base\Model;
use common\models\MemberCard;
use common\models\base\Member;
use common\models\base\MemberCardTime;
use common\models\base\VenueLimitTimes;
use common\models\base\MemberDealRecord;
use common\models\base\Deal;
use common\models\base\DealType;
class GiftCardBindForm extends Model
{
    public $memberName;                //会员姓名
    public $memberMobile;              //会员手机号
    public $idCard;                    //会员身份证号
    public $documentType = 1;	       //证件类型
    public $sendCode;                  //用户发送的验证码
    public $idCardAddress;             //会员身份证地址
    public $presentAddress;            //会员现住址
    public $gift_card_list_id;         //赠送会员卡列表数据表id
    public $venueId;                   //场馆id
    public $belongVenue;               //所属场馆id
    public $birth_date;                //会员出生日期
    public $sex;                       //会员性别
    /**
     * @desc: 卡种管理-赠卡管理-表单提交绑定验证规则
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/09
     * @return array
     */
    public function rules ()
    {
       return [
           ['sendCode','required','message'=>'请输入验证码'],
           [['memberName','memberMobile','sendCode'],'required'],
           [['memberName','memberMobile','idCard','sendCode','idCardAddress','presentAddress','gift_card_list_id'],'safe'],
       ];
    }

    public function saveBindMember($companyId)
    {
        $listInfo = $this->selectListInfo();
        if ($listInfo == 'overTime') {
            return '超过绑定有效期,不能绑定';
        }
        if (!$listInfo) {
            return '绑定失败,请重试';
        }
        //获取出生日期和性别
        $this->aboutIDCard();
        //获取卡种信息
        $cardCategory = CardCategory::findOne(['id' => $listInfo->card_category_id]);
        $time = json_decode($cardCategory->duration, true);                  //卡种有效期
        $leave = json_decode($cardCategory->leave_long_limit, true);         //卡种每次请假天数、请假次数
        $studentLeave = json_decode($cardCategory->student_leave_limit, true);      //学生暑寒假请假天数
        $renew = json_decode($cardCategory->validity_renewal, true);         //卡种有效期续费
        $memberAccount = MemberAccount::findOne(['mobile' => $this->memberMobile]);         //查询是否存在手机号
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if (empty($memberAccount)) {
                $memberAccount = $this->saveMemberAccount($companyId);
                if (!isset($memberAccount->id)) {
                    throw new \Exception(self::NOTICE);
                }
                $member = new Member();
                $member->username = $memberAccount->username;
                $member->password = $memberAccount->password;
                $member->mobile = $memberAccount->mobile;
                $member->register_time = time();
                $member->status = 1;
                $member->member_type = 1;
                $member->venue_id = $this->venueId;
                $member->company_id = $companyId;
                $member->member_account_id = $memberAccount->id;
                $member = $member->save() ? $member : $member->errors;

                if (!isset($member->id)) {
                    throw new \Exception(self::NOTICE);
                }
                //存储会员详情表
                $memberDetails = $this->saveMemberDetails($member);
                if (!isset($memberDetails->id)) {
                    throw new \Exception(self::NOTICE);
                }
                //存储会员卡详情表
                $memberCard = $this->saveMemberCard($listInfo, $member, $time, $cardCategory, $leave, $studentLeave, $renew, $companyId, $this->venueId);
                if (!isset($memberCard->id)) {
                    throw new \Exception(self::NOTICE);
                }
                //存储会员卡卡时间表
                $cardTime = $this->saveCardTime($memberCard, $listInfo);
                if ($cardTime !== true) {
                    throw new \Exception(self::NOTICE);
                }
                //存储消费记录表
                $consumption = $this->saveConsumption($member, $memberCard, $companyId, $this->venueId);
                if ($consumption !== true) {
                    throw new \Exception(self::NOTICE);
                }
                //存储进馆次数限制表
                $venueLimit = $this->saveVenueLimit($memberCard, $cardCategory, $listInfo);
                if ($venueLimit !== true) {
                    throw new \Exception(self::NOTICE);
                }
                //存储赠品记录表
                $giftRecord = $this->saveRecord($memberCard, $listInfo);
                if ($giftRecord !== true) {
                    throw new \Exception(self::NOTICE);
                }
                //存储进馆记录表
                $entryRecord = $this->setEntryRecord($member);
                if ($entryRecord !== true) {
                    throw new \Exception(self::NOTICE);
                }
                //储存会员卡套餐绑定表
                $bindMemberCard = $this->saveBindCard($memberCard);
                if($bindMemberCard !== true){
                    return $bindMemberCard;
                }
                //储存会员卡绑定合同内容表
                $dealRecord = $this->saveDealRecord($cardCategory,$memberCard);
                if($dealRecord !== true){
                    return $dealRecord;
                }
                //更新赠送会员卡列表表数据
                $updateListInfo = $this->updateListInfo($listInfo, $member);
                if ($updateListInfo !== true) {
                    throw new \Exception(self::NOTICE);
                }
                //执行
                if ($transaction->commit()) {
                    return false;
                } else {
                    return 'success';
                }
            } else {
                $memberInfo = Member::find()->where(['and', ['mobile' => $this->memberMobile, 'venue_id' => $this->venueId]])->one();
                if (empty($memberInfo)) {
                    $member = new Member();
                    $member->username = $memberAccount->username;
                    $member->password = $memberAccount->password;
                    $member->mobile = $memberAccount->mobile;
                    $member->register_time = time();
                    $member->status = 1;
                    $member->member_type = 1;
                    $member->venue_id = $this->venueId;
                    $member->company_id = $companyId;
                    $member->member_account_id = $memberAccount->id;
                    $member = $member->save() ? $member : $member->errors;

                    if (!isset($member->id)) {
                        throw new \Exception(self::NOTICE);
                    }
                    //存储会员详情表
                    $memberDetails = $this->saveMemberDetails($member);
                    if (!isset($memberDetails->id)) {
                        throw new \Exception(self::NOTICE);
                    }
                    //存储会员卡详情表
                    $memberCard = $this->saveMemberCard($listInfo, $member, $time, $cardCategory, $leave, $studentLeave, $renew, $companyId, $this->venueId);
                    if (!isset($memberCard->id)) {
                        throw new \Exception(self::NOTICE);
                    }
                    //存储会员卡卡时间表
                    $cardTime = $this->saveCardTime($memberCard, $listInfo);
                    if ($cardTime !== true) {
                        throw new \Exception(self::NOTICE);
                    }
                    //存储消费记录表
                    $consumption = $this->saveConsumption($member, $memberCard, $companyId, $this->venueId);
                    if ($consumption !== true) {
                        throw new \Exception(self::NOTICE);
                    }
                    //存储进馆次数限制表
                    $venueLimit = $this->saveVenueLimit($memberCard, $cardCategory, $listInfo);
                    if ($venueLimit !== true) {
                        throw new \Exception(self::NOTICE);
                    }
                    //存储赠品记录表
                    $giftRecord = $this->saveRecord($memberCard, $listInfo);
                    if ($giftRecord !== true) {
                        throw new \Exception(self::NOTICE);
                    }
                    //存储进馆记录表
                    $entryRecord = $this->setEntryRecord($member);
                    if ($entryRecord !== true) {
                        throw new \Exception(self::NOTICE);
                    }
                    //储存会员卡套餐绑定表
                    $bindMemberCard = $this->saveBindCard($memberCard);
                    if($bindMemberCard !== true){
                        return $bindMemberCard;
                    }
                    //储存会员卡绑定合同内容表
                    $dealRecord = $this->saveDealRecord($cardCategory,$memberCard);
                    if($dealRecord !== true){
                        return $dealRecord;
                    }
                    //更新赠送会员卡列表表数据
                    $updateListInfo = $this->updateListInfo($listInfo, $member);
                    if ($updateListInfo !== true) {
                        throw new \Exception(self::NOTICE);
                    }
                    //执行
                    if ($transaction->commit()) {
                        return false;
                    } else {
                        return 'success';
                    }
                } else {
                    //修改会员为普通会员
                    $memberInfo->member_type = 1;
                    $re = $memberInfo->save();
                    if (!$re) {
                        return $memberInfo->errors;
                    }
                    //判断会员身份证和现住址并修改
                    $data = \common\models\MemberDetails::findOne(['member_id' => $memberInfo->id]);
                    $data->id_card          = (isset($this->idCard) && !empty($this->idCard))? $this->idCard : $data->id_card;
                    $data->sex              = (isset($this->sex) && !empty($this->sex))? $this->sex : $data->sex;
                    $data->birth_date       = (isset($this->birth_date) && !empty($this->birth_date))? $this->birth_date : $data->birth_date;
                    $data->document_type    = (isset($this->idCard) && !empty($this->idCard)) ? 1 : $data->document_type;
                    $data->name             = (isset($this->memberName) && !empty($this->memberName)) ? $this->memberName : $data->name;
                    $data->family_address   = (isset($this->presentAddress) && !empty($this->presentAddress)) ? $this->presentAddress : $data->family_address;
                    $data->save();
                    //存储会员卡详情表
                    $memberCard = $this->saveMemberCard($listInfo, $memberInfo, $time, $cardCategory, $leave, $studentLeave, $renew, $companyId, $this->venueId);
                    if (!isset($memberCard->id)) {
                        throw new \Exception(self::NOTICE);
                    }
                    //存储会员卡卡时间表
                    $cardTime = $this->saveCardTime($memberCard, $listInfo);
                    if ($cardTime !== true) {
                        throw new \Exception(self::NOTICE);
                    }
                    //存储消费记录表
                    $consumption = $this->saveConsumption($memberInfo, $memberCard, $companyId, $this->venueId);
                    if ($consumption !== true) {
                        throw new \Exception(self::NOTICE);
                    }
                    //存储进馆次数限制表
                    $venueLimit = $this->saveVenueLimit($memberCard, $cardCategory, $listInfo);
                    if ($venueLimit !== true) {
                        throw new \Exception(self::NOTICE);
                    }
                    //存储赠品记录表
                    $giftRecord = $this->saveRecord($memberCard, $listInfo);
                    if ($giftRecord !== true) {
                        throw new \Exception(self::NOTICE);
                    }
                    //更新赠送会员卡列表表数据
                    $updateListInfo = $this->updateListInfo($listInfo, $memberInfo);
                    if ($updateListInfo !== true) {
                        throw new \Exception(self::NOTICE);
                    }
                    //执行
                    if ($transaction->commit()) {
                        return false;
                    } else {
                        return 'success';
                    }
                }
            }
        } catch (\Exception  $e) {
            $transaction->rollBack();                                                               //事务回滚
            return $e->getMessage();                                                               //捕捉错误，返回
        }
    }
    /**
     * @desc: 创建会员账户
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/22
     * @param $companyId
     * @return array|MemberAccount
     * @throws \yii\base\Exception
     */
    public function saveMemberAccount($companyId)
    {
        $memberAccount = new MemberAccount();
        $memberAccount->username    = $this->memberMobile;
        $password = '123456';
        $password = \Yii::$app->security->generatePasswordHash($password);
        $memberAccount->password    = $password;
        $memberAccount->mobile      = $this->memberMobile;
        $memberAccount->company_id  = $companyId;
        $memberAccount->create_at   = time();
        $memberAccount = $memberAccount->save() ? $memberAccount : $memberAccount->errors;
        if ($memberAccount) {
            return $memberAccount;
        }else {
            return $memberAccount->errors;
        }
    }
    /**
     * @desc: 卡种管理-赠卡管理-存储会员详细信息表
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/09
     * @param $member
     * @return array|MemberDetails
     */
    public function saveMemberDetails($member)
    {
        $memberDetails                        = new MemberDetails();
        $memberDetails->member_id             = $member->id;
        $memberDetails->name                  = $this->memberName;
        $memberDetails->sex                   = empty($this->sex) ? null : $this->sex;
        $memberDetails->id_card               = empty($this->idCard) ? null : $this->idCard;
        $memberDetails->recommend_member_id   = 0;
        $memberDetails->birth_date            = empty($this->birth_date) ? null : $this->birth_date;
        $memberDetails->created_at            = time();
        $memberDetails->document_type         = $this->documentType;
        $memberDetails->family_address        = $this->idCardAddress;
        $memberDetails->now_address           = $this->presentAddress;
        $memberDetails = $memberDetails->save() ? $memberDetails : $memberDetails->errors;
        if ($memberDetails) {
            return $memberDetails;
        }else{
            return $memberDetails->errors;
        }
    }

    /**
     * @desc: 卡种管理-赠卡管理-存储会员卡表
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/09
     * @param $listInfo
     * @param $member
     * @param $time
     * @param $cardCategory
     * @param $leave
     * @param $studentLeave
     * @param $renew
     * @param $companyId
     * @param $venueId
     * @return array|MemberCard
     */
    public function saveMemberCard($listInfo,$member,$time,$cardCategory,$leave,$studentLeave,$renew,$companyId,$venueId)
    {
        $memberCard = new MemberCard();
        $memberCard->member_id                  = $member->id;                                               //会员id
        $memberCard->card_category_id           = $listInfo->card_category_id;
        $memberCard->amount_money               = 0;                 //总金额
        $memberCard->create_at                  = time();                               //售卡时间
        $memberCard->level                      = 1;                                    //等级
        $memberCard->card_number                = $listInfo->card_number;
        $memberCard->is_complete_pay            = 1;
        $memberCard->payment_type               = 1;
        $memberCard->invalid_time               = time()+($time['day']*24*60*60);       //失效时间
        if($cardCategory->category_type_id == 3 || $cardCategory->category_type_id == 4){
            $memberCard->balance                = $cardCategory->recharge_price + $cardCategory->recharge_give_price;
        }else{
            $memberCard->balance                = 0;                                      //余额
        }
        $memberCard->total_times                = $cardCategory->times;                   //总次数(次卡)
        $memberCard->consumption_times          = 0;                                      //消费次数
        $memberCard->card_name                  = $cardCategory->card_name;              //卡名
        $memberCard->another_name               = $cardCategory->another_name;          //另一个卡名
        $memberCard->card_type                  = $cardCategory->category_type_id;      //卡类别
        $memberCard->count_method               = $cardCategory->count_method;          //计次方式
        $memberCard->attributes                 = $cardCategory->attributes;             //属性
        $memberCard->active_limit_time          = $cardCategory->active_time;            //激活期限
        $memberCard->transfer_num               = $cardCategory->transfer_number;       //转让次数
        $memberCard->surplus                    = $cardCategory->transfer_number;       //剩余转让次数
        $memberCard->transfer_price             = $cardCategory->transfer_price;        //转让金额
        $memberCard->recharge_price             = $cardCategory->recharge_price;        //充值卡充值金额
        $memberCard->present_money              = $cardCategory->recharge_give_price;  //买赠金额
        $memberCard->renew_price                = $cardCategory->renew_price;           //续费价
        $memberCard->renew_best_price           = $cardCategory->offer_price;          //续费优惠价
        $memberCard->renew_unit                 = $cardCategory->renew_unit;            //续费多长时间/天
        $memberCard->leave_total_days           = $cardCategory->leave_total_days;     //请假总天数
        $memberCard->leave_least_days           = $cardCategory->leave_least_Days;     //每次请假最少天数
        $memberCard->leave_days_times           = json_encode($leave);                   //每次请假天数、请假次数
        $memberCard->student_leave_limit        = json_encode($studentLeave);            //学生寒暑假请假天数 次数默认1

        $memberCard->deal_id                    = $cardCategory->deal_id;               //合同id
        $memberCard->duration                   = $time['day'];//有效期
        $memberCard->venue_id                   = $venueId;                              //场馆id
        $memberCard->company_id                 = $companyId;                            //公司id
        $memberCard->usage_mode                 = 1;
        $memberCard->bring                      = $cardCategory->bring;
        $memberCard->ordinary_renewal           = $cardCategory->ordinary_renewal;
        $memberCard->validity_renewal           = json_encode($renew);
        $memberCard->pic                        = $cardCategory->pic;
        $memberCard->type                       = $cardCategory->card_type;
        $memberCard = $memberCard->save() ? $memberCard : $memberCard->errors;
        if ($memberCard) {
            return $memberCard;
        }else{
            return $memberCard->errors;
        }
    }

    /**
     * @desc: 卡种管理-赠卡管理-存储消费记录表
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/10
     * @param $member
     * @param $memberCard
     * @param $companyId
     * @param $venueId
     * @return array|ConsumptionHistory
     */
    public function saveConsumption($member,$memberCard,$companyId,$venueId)
    {
        $consumption                            = new ConsumptionHistory();
        $consumption->member_id                 = $member->id;               //会员id
        $consumption->consumption_type          = 'card';                    //消费类型
        $consumption->type                      = 1;                          //消费方式
        $consumption->consumption_type_id       = $memberCard->id;           //消费项目id
        $consumption->consumption_date          = time();                    //消费日期
        $consumption->cash_payment              = 0;       //现金付款
        $consumption->consumption_amount        = 0;       //消费金额
        $consumption->consumption_time          = time();                    //消费时间
        $consumption->consumption_times         = 1;                         //消费次数
        $consumption->venue_id                  = $venueId;                 //场馆id
        $consumption->describe                  = json_encode('赠送会员卡'); //消费描述
        $consumption->category                  = '办卡';
        $consumption->company_id                = $companyId;              //公司id
        $consumption->due_date                  = $memberCard['invalid_time'];              //到期日期
        $consumption->remarks                   = '赠送会员卡';
        $consumption->payment_name              = $memberCard['card_name']; //会员卡名
        $consumption = $consumption->save() ? $consumption : $consumption->errors;
        if ($consumption) {
            return true;
        }else{
            return $consumption->errors;
        }
    }

    /**
     * @desc: 卡种管理-赠卡管理-卡进馆核算表
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/10
     * @param $memberCard
     * @param $cardCategory
     * @param $listInfo
     * @return array|bool
     */
    public function saveVenueLimit($memberCard,$cardCategory,$listInfo)
    {
        $limit = LimitCardNumber::find()->where(['and',['card_category_id' => $listInfo->card_category_id,'status'=>[1,3]]])->asArray()->all();
        if(isset($limit)){
            foreach($limit as $k=>$v){
                $limitVenue                         = new VenueLimitTimes();
                $limitVenue->member_card_id         = $memberCard->id;
                $limitVenue->venue_id               = $v['venue_id'];
                $limitVenue->total_times            = $v['times'];
                if(!empty($v['times'])){
                    $limitVenue->overplus_times     = $v['times'];
                }else{
                    $limitVenue->overplus_times     = $v['week_times'];
                }
                $limitVenue->week_times             = $v['week_times'];
                $limitVenue->venue_ids              = $v['venue_ids'];
                $limitVenue->company_id             = $cardCategory->company_id;
                $limitVenue->level                  = $v['level'];
                $limitVenue->apply_start            = $v['apply_start'];
                $limitVenue->apply_end              = $v['apply_end'];
                $limitVenue->about_limit            = $v['about_limit'];
                if(!$limitVenue->save()){
                    return $limitVenue->errors;
                }
            }
            return true;
        }
        return true;
    }

    /**
     * @desc: 卡种管理-赠卡管理-赠卡礼物
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/10
     * @param $memberCard
     * @param $limitInfo
     * @return array|bool
     */
    public function saveRecord($memberCard,$listInfo)
    {
        $limit = \common\models\base\BindPack::find()->where(['card_category_id' => $listInfo->card_category_id,'polymorphic_type'=>'gift'])->asArray()->all();
        if(isset($limit)){
            foreach($limit as $k=>$v){
                $goods                      = Goods::find()->where(['id'=>$v['polymorphic_id']])->asArray()->one();
                $gift                       = new GiftRecord();
                $gift->member_card_id       = $memberCard->id;
                $gift->member_id            = $memberCard->member_id;
                $gift->num                  = $v['number'];
                $gift->name                 = $goods['goods_name'];
                $gift->create_at            = time();
                $gift->service_pay_id       = $goods['id'];
                $gift->status               = 1;
                $gift->get_day = null;
                if(!$gift->save()){
                    return $gift->errors;
                }
            }
            return true;
        }
        return true;
    }
    /**
     * @desc: 卡种管理-赠卡管理-存储会员卡时间表
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/09
     * @param $memberCard
     * @param $listInfo
     * @return bool
     */
    public function saveCardTime($memberCard,$listInfo)
    {
        $time = CardTime::findOne(['card_category_id' => $listInfo->card_category_id]);
        if(!empty($time)) {
            $cardTime                   = new MemberCardTime();
            $cardTime->member_card_id   = $memberCard->id;
            $cardTime->start            = $time->start;
            $cardTime->end              = $time->end;
            $cardTime->create_at        = time();
            $cardTime->day              = $time->day;
            $cardTime->week             = $time->week;
            $cardTime->month            = $time->month;
            $cardTime->quarter          = $time->quarter;
            $cardTime->year             = $time->year;
            if ($cardTime->save()) {
                return true;
            } else {
                return $cardTime->errors;
            }
        }else{
            return true;
        }
    }

    /**
     * @desc: 卡种管理-赠卡管理-存储会员进馆记录表
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/09
     * @param $member
     * @return array|bool
     */
    public function setEntryRecord($member)
    {
        $entryRecord             = new EntryRecord();
        $entryRecord->entry_time = time();          //会员进场时间
        $entryRecord->create_at  = time();          //创建时间
        $entryRecord->member_id  = $member->id;       //会员id
        if($entryRecord->save())
        {
            return true;
        }else{
            return $entryRecord->errors;
        }
    }
    /**
     * @desc: 卡种管理-赠卡管理-从会员卡列表中获取一条数据
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/09
     * @return bool|static
     */
    public function selectListInfo()
    {
        $info = GiftCardList::findOne($this->gift_card_list_id);
        if (empty($info)) {
            return false;
        }
        $card = \common\models\GiftCardActivity::findOne($info->gift_card_activity_id);
        if (empty($card)) {
            return false;
        }
        $this->venueId = $info->venue_id;
        if (time()>((int)$card->end_time)) {
            return 'overTime';
        }
        return $info;
    }

    /**
     * @desc: 卡种管理-赠卡管理-更新会员卡列表中的数据
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/09
     * @param $info
     * @return bool
     */
    private function updateListInfo($info,$member)
    {
        $info->mobile           = $this->memberMobile;
        $info->nickname         = $this->memberName;
        $info->member_id        = $member->id;
        $info->is_bind          = 2;
        $info->update_time      = time();
        $re = $info->save();
        if (!$re) {
            return $info->errors;
        }
        $data = GiftCardActivity::findOne(['id'=>$info->gift_card_activity_id]);
        $data->active_card_num = (int)$data->active_card_num + 1;
        $re = $data->save();
        if (!$re) {
            return $data->errors;
        }
        return true;
    }

    private function aboutIDCard()
    {
        if (isset($this->idCard) && $this->idCard != '' && $this->idCard != null) {
            $birth = strlen($this->idCard)==15 ? ('19' . substr($this->idCard, 6, 6)) : substr($this->idCard, 6, 8);
            $this->birth_date = substr($birth,0,4) . '-' . substr($birth,4,2) . '-' . substr($birth,6);
            $this->sex = intval(substr($this->idCard, (strlen($this->idCard)==15 ? -1 : -2), 1)) % 2 ? 1 : 2;
        }
    }

    /**
     * 云运动 - 赠卡 - 存储会员卡绑定套餐表
     * @author huanghua<huanghua@itsports.club>
     * @param $memberCard
     * @create 2018/4/22
     * @return array
     */
    public function saveBindCard($memberCard)
    {
        $bindData = BindPack::find()->where(['card_category_id' => $this->cardCategoryId])->asArray()->all();
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
     * 云运动 - 赠卡 - 存储绑定合同记录表
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
