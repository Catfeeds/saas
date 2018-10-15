<?php
namespace backend\models;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\SendRecord;
use common\models\base\MemberAccount;
use yii\base\Model;
use Yii;
class DeliveryCardForm extends Model
{
    public $name;
    public $idCard;
    public $sex;
    public $mobile;
    public $code;
    public $status;
    public $venueId;
    public $companyId;
    public $cardId;
    public $memberId;
    public $oldMemberId;
    public $newCode;
    const CODE = 'code';

    public function __construct(array $config,$scenario,$company,$venueId)
    {
        $this->scenario = $scenario;
        $this->companyId = $company;
        $this->venueId   = $venueId;
        parent::__construct($config);
    }
    public function scenarios()
    {
        return [
            'new' => ['name','idCard','sex','mobile','code','status','oldMemberId','cardId'],
            'old' => ['status','oldMemberId','memberId','cardId'],
        ];
    }

    /**
     * 业务后台 - 送人卡  -新会员验证
     * @author lihuien<lihuien@itsports.club>
     * @return array
     */
    public function rules()
    {
        return [
            [self::CODE, 'trim','on'=>'new'],
            [self::CODE, 'required', 'message' => '验证码不能为空！','on'=>'new'],
//            [self::CODE, 'compare', 'compareAttribute' => 'newCode', 'message' => '验证码错误！','on'=>'new'],
//            [self::CODE, 'newCodeTime','on'=>'new'],
            [['name','idCard','sex','mobile','code','status','cardId','oldMemberId','memberId'],'safe']
        ];
    }
    /**
     * @云运动 - 后台 - 注册验证码
     * @author Zhu Mengke <zhumengke@itsports.club>
     * @create 2017/4/1
     * @inheritdoc
     */
    public function loadCode()
    {
        if (Yii::$app->session->has('sms')) {
            $temp = Yii::$app->session->get('sms');
            $this->newCode = $temp['code'];
        }
    }

    /**
     * @云运动 - 后台 - 注册验证码验证
     * @author Zhu Mengke <zhumengke@itsports.club>
     * @create 2017/4/1
     * @inheritdoc
     */
    public function newCodeTime($attribute)
    {
        $temp = Yii::$app->session->get('sms');
        $time = $temp['time'];
        $num = time() - $time;
        if ($num > 300) {
            $this->addError($attribute, '验证码已失效！');
        }
    }
    /**
     *  * 业务后台 - 送人卡  - 保存卡种
     * @author lihuien<lihuien@itsports.club>
     * @return bool|string
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function saveCard(){
        $mcArr = MemberCard::findOne(['id'=>$this->cardId]);
        //根据手机号判断当前场馆是否存在此手机号的会员
        $result = Member::find()->select('id')->where(['and',['company_id'=>$this->companyId],['venue_id'=>$this->venueId],['mobile'=>$this->mobile]])->asArray()->one();
        //判断身份证是否在当前场馆存在
        $IDcardInfo = \common\models\MemberDetails::find()
                                            ->alias('mds')
                                            ->joinWith(['member member'],false)
                                            ->select('member.id')
                                            ->where([
                                                'and',
                                                ['member.company_id'=>$this->companyId],
                                                ['member.venue_id'=>$this->venueId],
                                                ['mds.id_card'=>$this->idCard],
                                            ])->asArray()->one();
        //送人卡不能绑定自己
        $memberCard = MemberCard::find()->where(['and',['id'=>$this->cardId],['member_id'=>$this->memberId]])->andWhere(['usage_mode'=>2])->asArray()->one();
        if ($this->status == 1 && !empty($result)) {
            return '手机号已存在,请选择绑定老会员!';
        }
        if ($this->status == 1 && !empty($IDcardInfo)) {
            return '证件号已存在,请选择绑定老会员!';
        }
     /*   if (!empty($memberCard)) {
            return '自己购买的送人卡不能绑定自己!';
        }*/
        if($this->status == 1){
            $transaction = Yii::$app->db->beginTransaction();
            try {

                $memberAccount = MemberAccount::findOne(['mobile'=>$this->mobile,'company_id'=>$this->companyId]);
                $password                = '123456';
                $password                = Yii::$app->security->generatePasswordHash($password);

                if(empty($memberAccount)){
                    $ma                    = new MemberAccount();
                    $ma->mobile            = $this->mobile;
                    $ma->username          = $this->mobile;
                    $ma->password          = $password;
                    $ma->create_at         = time();
                    $ma->company_id        = $this->companyId;
                    $ma->save();
                    if (!isset($ma->id)) {
                        return $ma->errors;
                    }
                }

                $member                 = new Member();
                $member->username       = $this->mobile;
                $member->mobile         = $this->mobile;
                $member->password       = $password;
                $member->register_time = time();
                $member->status         = 1;
                $member->member_type    = 1;
                $member->venue_id       = $this->venueId;
                $member->company_id     = $this->companyId;
                $member->counselor_id   = isset($mcArr->employee_id) ? $mcArr->employee_id : null;
                if(!empty($memberAccount)){
                    $member->member_account_id          = $memberAccount['id'];
                }else{
                    $member->member_account_id          = $ma->id;
                }
                $member = $member->save() ? $member : $member->errors;
                if(!isset($member->id)){
                    return $member;
                }
                $this->memberId = $member->id;

                $memberDetails = $this->saveMemberDetails($member);
                if(!isset($memberDetails->id)){
                    return $memberDetails;
                }

                $memberCard = $this->saveMemberCard();
                if(!isset($memberCard->id)){
                    return $memberCard;
                }
                $send = $this->sendRecordSave();
                if($send  !== true){
                    return $memberCard;
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
            $memberCard = $this->saveMemberCard();
            if(!isset($memberCard->id)){
                return $memberCard;
            }
            $send = $this->sendRecordSave();
            if($send  !== true){
                return $memberCard;
            }
            return true;
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
        $memberDetails->member_id             = $member->id;
        $memberDetails->name                  = $this->name;
        $memberDetails->id_card               = $this->idCard;
        $memberDetails->sex                   = $this->sex;
        $memberDetails->recommend_member_id   = 0;
        $memberDetails->created_at            = time();
        $memberDetails = $memberDetails->save() ? $memberDetails : $memberDetails->errors;
        if ($memberDetails) {
            return $memberDetails;
        }else{
            return $memberDetails->errors;
        }
    }

    public function saveMemberCard()
    {
        $member     = Member::findOne(['id'=>$this->memberId]);
        $member->member_type = 1;
        $member = $member->save() ? $member : $member->errors;
        if (!isset($member->id)) {
            Yii::trace($member,'aaa');
            return $member;
        } 
        $memberCard = MemberCard::findOne(['id'=>$this->cardId]);
        $memberCard->member_id  = $this->memberId;
        $memberCard->usage_mode = 1;
        $memberCard = $memberCard->save() ? $memberCard : $memberCard->errors;
        if (!isset($memberCard->id)) {
            Yii::trace($memberCard,'aaa');
            return $memberCard;
        } else {
           return $memberCard;
        }
    }

    public function sendRecordSave()
    {
        $send = new SendRecord();
        $send->member_id        = $this->oldMemberId;
        $send->cover_member_id  = $this->memberId;
        $send->member_card_id   = $this->cardId;
        $send->send_time        = time();
        $send->created_at       = time();
        if($send->save()){
            return true;
        }else{
            return $send->errors;
        }
    }
}