<?php
namespace backend\models;

use common\models\base\EntryRecord;
use common\models\base\MessageCode;
use common\models\base\MemberDetails;
use common\models\base\Config;
use common\models\base\Member;
use common\models\base\MemberAccount;
use yii\base\Model;
use Yii;
class RegistrationVenueForm extends Model
{
    public $name;          //姓名
    public $mobile;        //手机号
    public $code;          //填写的验证码
    public $newCode;       //生成的验证码
    public $venueId;
    public $companyId;
    public $url;
    public $adviserId;
    public $sourceId;
    const CODE   = 'code';
    const NOTICE = '操作失败';

    /**
     * 云运动 - 售卡系统 - 售卡表单规则验证
     * @author 朱梦珂<zhumengke@itsports.club>
     * @create 2017/6/6
     * @return array
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required', 'message' => '请填写姓名'],

            ['mobile', 'trim'],
            ['mobile', 'required', 'message' => '请填写手机号'],

            ['sourceId', 'trim'],
            ['sourceId', 'required', 'message' => '来源渠道不能为空'],

            ['adviserId', 'trim'],
            ['adviserId', 'required', 'message' => '会籍顾问不能为空'],

            [self::CODE, 'trim'],
            [self::CODE, 'required', 'message' => '请填写验证码'],
//            [self::CODE, 'compare', 'compareAttribute' => 'newCode', 'message' => '验证码错误'],
//            [self::CODE, 'newCodeTime'],

            [['venueId','companyId','adviserId'],'safe']
        ];
    }


    /**
     * @云运动 - 售卡系统 - 验证码
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/6
     * @inheritdoc
     */
    public function loadCode($mobile,$code)
    {
        $mesCode = MessageCode::findOne(['mobile' => $mobile]);
        if($mesCode['code'] != $code){
            return '验证码错误';
        }else{
            $this->delCode();
            return true;
        }
    }

    public function delCode()
    {
        $code = MessageCode::findOne(['mobile'=>$this->mobile]);
        $del  = $code->delete();
        return $del;
    }




    /**
     * @云运动 - 售卡系统 - 验证码时间
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/6
     * @inheritdoc
     */
    public function newCodeTime($attribute)
    {
        $temp = Yii::$app->session->get('sms');
        $time = $temp['time'];
        $num = time() - $time;
        if ($num > 300) {
            $this->addError($attribute, '验证码已失效');
        }
    }

    /**
     * @云运动 - 售卡系统 - 验证码手机号
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/6
     * @inheritdoc
     */
    public function setMobile($attribute)
    {
        $temp = Yii::$app->session->get('sms');
        $mobile = $temp['mobile'];
        if ($this->mobile != $mobile) {
            $this->addError($attribute, '手机号错误，请填写接收验证码的手机号');
        }
    }

    /**
     * @云运动 - 售卡系统 - 存储数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/6
     * @inheritdoc
     */
    public function setRegistration($companyId,$venueId)
    {
        $companyId     = $this->companyId;
        $venueId       = $this->venueId;
        $member        = Member::findOne(['and',['mobile' => $this->mobile],['venue_id' =>$this->venueId]]);
        $memberDetails = MemberDetails::findOne(['member_id' => isset($member['id'])?$member['id']:null]);
//        $config        = Config::findOne(['id'=>$this->sourceId]);

        if(isset($member) && !empty($member)){
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $member->member_type                      = 2;
                $member->company_id                       = $this->companyId;
                $member->venue_id                         = $this->venueId;
                $member = $member->save() ? $member : $member->errors;
                if(!isset($member->id)){
                    throw new \Exception(self::NOTICE);
                }
                if(isset($memberDetails) && !empty($memberDetails)){

                    $memberDetails->member_id             = $member->id;
                    $memberDetails->name                  = $this->name;
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
                $data = $this->setEntryRecord($member);
                if(!isset($data->id)){
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
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $memberAccount = MemberAccount::findOne(['mobile'=>$this->mobile,'company_id'=>$companyId]);
                $password = '123456';     //会员临时密码
                $password = \Yii::$app->security->generatePasswordHash($password);
                if(empty($memberAccount)){
                    $ma                    = new MemberAccount();
                    $ma->mobile            = $this->mobile;
                    $ma->username          = $this->name;
                    $ma->password          = $password;
                    $ma->create_at         = time();
                    $ma->company_id        = $companyId;
                    $ma->save();
                    if (!isset($ma->id)) {
                        return $ma->errors;
                    }
                }
                $member                  = new Member();
                $member->counselor_id    = $this->adviserId;
                $member->mobile          = $this->mobile;
                $member->username        = $this->name;
                $password                = '123456';
                $password                = Yii::$app->security->generatePasswordHash($password);
                $member->password        = $password;
                $member->register_time   = time();
                $member->status          = 0;
                $member->member_type     = 2;
                $member->company_id      = $this->companyId;
                $member->venue_id        = $this->venueId;
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
                $data = $this->setEntryRecord($member);
                if(!isset($data->id)){
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
     * @create 2017/6/6
     * @param $member
     * @return array
     */
    public function saveMemberDetails($member)
    {
        $memberDetails                        = new MemberDetails();
        $memberDetails->way_to_shop           = $this->sourceId;
        $memberDetails->member_id             = $member->id;
        $memberDetails->name                  = $this->name;
        $memberDetails->sex                   = null;
        $memberDetails->recommend_member_id   = 0;
        $memberDetails->created_at            = time();
        $memberDetails = $memberDetails->save() ? $memberDetails : $memberDetails->errors;
        if ($memberDetails) {
            return $memberDetails;
        }else{
            return $memberDetails->errors;
        }
    }

    /**
     * * 云运动 - 潜在会员 -  进场信息添加
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/27
     * @param $memberId     //会员id
     * @return bool
     */
    public function setEntryRecord($memberId)
    {
        $entryRecord = new EntryRecord();
        $entryRecord->entry_time = time();          //会员进场时间
        $entryRecord->create_at  = time();          //创建时间
        $entryRecord->member_id  = $memberId['id'];       //会员id
        $entryRecord = $entryRecord->save() ? $entryRecord : $entryRecord->errors;
        if ($entryRecord) {
            return $entryRecord;
        }else{
            return $entryRecord->errors;
        }
    }


}