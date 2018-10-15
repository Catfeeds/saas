<?php
namespace backend\models;
use common\models\base\MemberAccount;
use yii\base\Model;
use common\models\base\Member;
use common\models\base\MemberDetails;
use common\models\base\ConsultantChangeRecord;
use common\models\relations\MemberRelations;


/**
 * @云运动 - 会员管理 - 会员修改表单验证
 * @author Huanghua <Huanghua @itsports.club>
 * @create 2017/4/19
 */
class MembersUpdateForm extends Model
{
    use MemberRelations;
    public $name;
    public $sex;
    public $birth_date;
    public $mobile;
    public $id_card;
    public $profession;
    public $family_address;
    public $adviserId;
    public $id;
    public $note;
    public $pic;
    public $fingerprint;
    public $documentType;
    const NOTICE_ERROR  = '操作失败';       //错误提示常量


    /**
     * @云运动 - 后台 - 会员表单修改验证(规则验证)
     * @create 2017/4/8
     * @return array
     */
    public function rules()
    {
        return [
            [["id","mobile"], 'required'],
            [["id",'mobile','sex'], 'integer'],
            [["name","sex",'birth_date','mobile','id_card','profession','family_address','adviserId','id','pic','fingerprint','note','documentType'],"safe"]
        ];
    }
    /**
     * 云运动 - 会员管理 - 点击修改单条信息
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/4/20
     * @param
     * @return boolean/object
     */
    public function updateData()
    {
        {
            $transaction                             =  \Yii::$app->db->beginTransaction();        //开启事务
            try{
                $member        = Member::findOne(['id'=>$this->id]);
                $memberDetail  = MemberDetails::findOne(['member_id'=>$this->id]);
                $memberAccount = MemberAccount::findOne(['id'=>$member['member_account_id']]);
                $memberAccountMobile = MemberAccount::findOne(['mobile'=>$this->mobile,'company_id'=>$member['company_id']]);

                $memberAllCount = Member::find()->where(['and',['company_id'=>$member['company_id']],['member_account_id'=>$member['member_account_id']]])->asArray()->all();
                $memberCount   = \backend\models\Member::find()->joinWith(['memberDetails memberDetails'])->where(['and',['company_id'=>$member['company_id']],['member_account_id'=>$member['member_account_id']]])
                    ->andWhere(['and',['memberDetails.id_card'=>$memberDetail['id_card']],['IS NOT','memberDetails.id_card',null],['<>','memberDetails.id_card',0]])
                    ->asArray()->all();
                $memberIdArr = array_column($memberCount,'id');

                if(count($memberAllCount) == count($memberCount)){
                    $memberAccount->mobile = $this->mobile;
                    if(!$memberAccount->save()){
                        \Yii::trace($memberAccount->errors);
                        throw new \Exception(self::NOTICE_ERROR);
                    }
                    $memberAll = Member::updateAll(['mobile'=>$this->mobile],['id'=>$memberIdArr]);
                }else{
                    if(!empty($memberAccountMobile)){
                        $memberAll = Member::updateAll(['member_account_id'=>$memberAccountMobile['id']],['id'=>$memberIdArr]);
                    }else{
                        $password = '123456';     //会员临时密码
                        $password = \Yii::$app->security->generatePasswordHash($password);
                        $memberAddAccount = new MemberAccount();
                        $memberAddAccount->mobile            = $this->mobile;
                        $memberAddAccount->username          = $this->mobile;
                        $memberAddAccount->password          = $password;
                        $memberAddAccount->create_at         = time();
                        $memberAddAccount->company_id        = $member['company_id'];
                        $memberAddAccount->save();
                        if (!isset($memberAddAccount->id)) {
                            return $memberAddAccount->errors;
                        }
                        $memberAll = Member::updateAll(['member_account_id'=>$memberAddAccount['id']],['id'=>$memberIdArr]);
                    }
                }

                if($this->adviserId != $member['counselor_id']){
                    $consultantChange = new ConsultantChangeRecord();
                    $consultantChange->member_id      = $this->id;
                    $consultantChange->create_id      = $this->getCreate();
                    $consultantChange->created_at     = time();
                    $consultantChange->consultant_id  = $this->adviserId;
                    $consultantChange->venue_id       = $member['venue_id'];
                    $consultantChange->company_id     = $member['company_id'];
                    $consultantChange->behavior       = 3;
                    if(!$consultantChange->save()){
                        \Yii::trace($consultantChange->errors);
                        throw new \Exception(self::NOTICE_ERROR);
                    }
                }
//                if(!empty($memberAccount) && empty($memberAccountMobile)){
//                    $memberAccount->mobile = $this->mobile;
//                    if(!$memberAccount->save()){
//                        \Yii::trace($memberAccount->errors);
//                        throw new \Exception(self::NOTICE_ERROR);
//                    }
//                    $memberAll = Member::updateAll(['mobile'=>$this->mobile],['member_account_id'=>$memberAccount['id']]);
//                }else{
//                    $memberAll = Member::updateAll(['member_account_id'=>$memberAccountMobile['id']],['and',['mobile'=>$member['mobile']],['company_id'=>$member['company_id']]]);
//                }

                $member->mobile          = $this->mobile;
                $member->counselor_id    = $this->adviserId;
                if(!$member->save()){
                    \Yii::trace($member->errors);
                    throw new \Exception(self::NOTICE_ERROR);
                }
                if(!empty($memberDetail)){
                    $memberDetail->name             = $this->name;
                    $memberDetail->sex              = $this->sex;
                    $memberDetail->birth_date       = $this->birth_date;
                    $memberDetail->id_card          = $this->id_card;
                    $memberDetail->profession       = $this->profession;
                    $memberDetail->family_address   = $this->family_address;
                    $memberDetail->note             = $this->note;
                    $memberDetail->document_type    = $this->documentType;
                    if(!empty($this->pic)){
                        $memberDetail->pic           = $this->pic;
                    }
               //     $memberDetail->ic_number        = $this->icNumber;
                    $memberDetail->fingerprint      = isset($this->fingerprint[0]) ? $this->fingerprint[0] : null;
                    if(!$memberDetail->save()){
                        throw new \Exception(self::NOTICE_ERROR);
                    }
                }else{
                    $model                      = new MemberDetails();
                    $model->name                = $this->name;
                    $model->sex                 = $this->sex;
                    $model->birth_date          = $this->birth_date;
                    $model->id_card             = $this->id_card;
                    $model->profession          = $this->profession;
                    $model->family_address      = $this->family_address;
                    $model->recommend_member_id = 0;
                    $model->pic                 = $this->pic;
                    $model->fingerprint         = isset($this->fingerprint[0]) ? $this->fingerprint[0] : null;
                    $model->note                = $this->note;
                    $model->document_type       = $this->documentType;
                    if($model->save()){
                        throw new \Exception(self::NOTICE_ERROR);
                    }
                }
                $transaction->commit();
                return true;
            }catch(\Exception $e){
                //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
                $transaction->rollBack();
                return $e->getMessage();  //获取抛出的错误
            }
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