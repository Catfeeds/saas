<?php
namespace backend\models;

use common\models\base\EntryRecord;
use common\models\base\Member;
use common\models\base\MemberAccount;
use common\models\base\MemberDetails;
use yii\base\Model;
class MemberForm extends Model
{
    public $memberName;                //会员姓名
    public $memberMobile;              //会员手机号
    public $counselorId;               //会籍顾问id
    public $memberSex;                 //会员性别
    public $memberAge;                 //会员年龄
    public $idCard;                    //会员身份证号
    public $birthDate;                 //会员生日
    public $note;                      //备注
    public $wayToShop;	               //来店途径
    public $documentType;	               //证件类型
    /**
     * 云运动 - 潜在会员 -  表单验证规则
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/22
     * @return array
     */
    public function rules()
    {
        return [
            [['memberName', 'memberMobile', 'memberAge', 'idCard', 'birthDate'], 'trim'],
            [['memberName', 'memberMobile', 'counselorId'], 'required'],
            [['idCard', 'birthDate', 'note'], 'string'],
            [['memberAge', 'memberSex','documentType'], 'integer'],
            ['wayToShop','safe']
        ];
    }

    /**
     * 云运动 - 潜在会员 -  信息添加
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/22
     * @return array|string
     * @param $companyId
     * @param $venueId
     * @throws \yii\db\Exception
     */
    public function saveMemberInfo($companyId, $venueId)
    {
        $transaction                            = \Yii::$app->db->beginTransaction();
        try {
            $memberAccount = MemberAccount::findOne(['mobile'=>$this->memberMobile, 'company_id'=>$companyId]);
            $password = '123456';     //会员临时密码
            $password = \Yii::$app->security->generatePasswordHash($password);
            if(empty($memberAccount)){
                $ma                    = new MemberAccount();
                $ma->mobile            = $this->memberMobile;
                $ma->username          = $this->memberName;
                $ma->password          = $password;
                $ma->create_at         = time();
                $ma->company_id        = $companyId;
                $ma->save();
                if (!isset($ma->id)) {
                    return $ma->errors;
                }
            }
            $member                             = new Member();
            $member->username                   = $this->memberName;                               //用户名（用于登录，暂存手机号）
            $member->password                   = $password;                       
            $member->mobile                     = $this->memberMobile;                               //手机号
            $member->register_time              = time();                                            //注册时间
            $member->params                     = json_encode(['note' => $this->note]);  //备注('会籍id’=>'备注')
            $member->counselor_id               = $this->counselorId;                                //会籍顾问id
            $member->member_type                = 2;                                                 //会员类型（2表示是潜在会员）
            $member->company_id                 = $companyId;
            $member->venue_id                   = $venueId;
            $member->status                     = 1;
            if(!empty($memberAccount)){
                $member->member_account_id          = $memberAccount['id'];
            }else{
                $member->member_account_id          = $ma->id;
            }

            $memberSave = $member->save() ? $member : $member->errors;
            if (!isset($memberSave->id)) {
                return $member->errors;
            }

            $consultantChange = new ConsultantChangeRecord();
            $consultantChange->member_id      = $member['id'];
            $consultantChange->create_id      = $this->getCreate();
            $consultantChange->created_at     = time();
            $consultantChange->consultant_id  = $this->counselorId;
            $consultantChange->venue_id       = $member['venue_id'];
            $consultantChange->company_id     = $member['company_id'];
            $consultantChange->behavior       = 1;
            if(!$consultantChange->save()){
                \Yii::trace($consultantChange->errors);
                throw new \Exception('会籍记录新增失败');
            }

            $memberDetails                      = new MemberDetails();
            $memberDetails->member_id           = $memberSave->id;                                   //会员id
            $memberDetails->name                = $this->memberName;                                 //会员姓名
            $memberDetails->sex                 = $this->memberSex;                                  //会员性别(1男2女)
            $memberDetails->id_card             = $this->idCard;                                     //会员身份证号
            $memberDetails->birth_date          = $this->birthDate;                                  //生日
            $memberDetails->recommend_member_id = $this->counselorId;                                //推荐人id
            $memberDetails->way_to_shop         = $this->wayToShop;
            $memberDetails->note                = $this->note;                                       //备注
            $memberDetails->document_type       = $this->documentType;                              //证件类型
            if(!$memberDetails->save())
            {
                return $memberDetails->errors;
            }

            if($transaction->commit())                                                               //事务提交
            {
                return false;
            }else{
                return true;
            }
        } catch (\Exception  $e) {
            $transaction->rollBack();                                                               //事务回滚
            return $e->getMessage();                                                               //捕捉错误，返回
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
        $entryRecord->member_id  = $memberId;       //会员id
        if($entryRecord->save())
        {
            return true;
        }else{
            return $entryRecord->errors;
        }
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