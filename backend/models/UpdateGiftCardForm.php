<?php
namespace backend\models;
use common\models\base\MemberCard;
use common\models\base\InformationRecords;
use yii\base\Model;

class UpdateGiftCardForm extends Model
{
    public $memberCardId;       //会员卡id
    public $activeTime;         //修改后的激活时间
    public $invalidTime;        //修改后的到期时间

    /**
     * 潜在会员 - 赠卡修改 - 赠卡修改表单规则验证
     * @author huanghua<huanghua@itsports.club>
     * @create 2018/3/16
     * @return array
     */
    public function rules()
    {
        return [
            [['memberCardId','activeTime','invalidTime'], 'safe'],
        ];
    }

    /**
     * 潜在会员 - 赠卡修改 - 赠卡修改表单规则验证
     * @author huanghua <huanghua@itsports.club>
     * @create 2018/3/16
     * @inheritdoc
     */
    public function updateGiftCard()
    {
        $memberCard     = MemberCard::findOne(['id' => $this->memberCardId]);       //会员卡信息

        $consumptionHistoryOne = ConsumptionHistory::find()
            ->where(['and',['member_id'=>$memberCard['member_id']],['consumption_type_id'=>$memberCard['id']]])
            ->orderBy('id DESC')
            ->asArray()
            ->one();
        $consumptionHistory = ConsumptionHistory::findOne(['id' => $consumptionHistoryOne['id']]);

        $transaction = \Yii::$app->db->beginTransaction();
        try{

            //1.生成信息记录
            $informationRecord = $this->setInformationRecord($memberCard);//生成订单
            if ($informationRecord !== true) {
                return $informationRecord;
            }
            //2.修改会员卡到期时间和激活时间
            $memberCard->status       = 1;
            $memberCard->active_time  = $this->activeTime;
            $memberCard->invalid_time = $this->invalidTime;
            if (!empty($consumptionHistory)) {
                $consumptionHistory->due_date = $this->invalidTime;
                $consumptionHistory->save();
            }
            $memberCard = $memberCard->save() ? $memberCard : $memberCard->errors;
            if ($memberCard->save() != true) {
                throw new \Exception('修改失败');
            }

            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();
        }
    }
    /**
     * 潜在会员 - 修改赠卡 - 生成新修改赠卡记录
     * @author huanghua <huangpengju@itsports.club>
     * @create 2017/8/7
     * @param $memberCard
     * @return array|bool
     */
    public function setInformationRecord($memberCard)
    {
        if($memberCard['active_time']!= $this->activeTime && $memberCard['invalid_time']== $this->invalidTime){
            $informationData                     = new InformationRecords();
            $informationData->member_id          = $memberCard['member_id'];    //会员id
            $informationData->member_card_id     = $this->memberCardId;         //会员阿卡id
            $informationData->create_at          = time();                      //创建时间
            $informationData->note               = '修改赠卡激活时间';        //备注
            $informationData->behavior           = 4;                           //行为3激活日期4到期日期
            $informationData->create_id          = $this->getCreate();          //创建人id
            $informationData->old_time          = $memberCard['active_time'];          //创建人id
            $informationData->new_time          = $this->activeTime;          //创建人id
            if($informationData->save() != true)
            {
                return $informationData->errors;
            }else{
               return true;
            }
        }else if ($memberCard['active_time']== $this->activeTime && $memberCard['invalid_time']!= $this->invalidTime){
            $informationData                     = new InformationRecords();
            $informationData->member_id          = $memberCard['member_id'];    //会员id
            $informationData->member_card_id     = $this->memberCardId;         //会员阿卡id
            $informationData->create_at          = time();                      //创建时间
            $informationData->note               = '修改赠卡到期时间';        //备注
            $informationData->behavior           = 5;                           //行为3激活日期4到期日期
            $informationData->create_id          = $this->getCreate();          //创建人id
            $informationData->old_time          = $memberCard['invalid_time'];          //创建人id
            $informationData->new_time          = $this->invalidTime;          //创建人id
            if($informationData->save() != true)
            {
                return $informationData->errors;
            }else{
                return true;
            }
        }else if($memberCard['active_time']!= $this->activeTime && $memberCard['invalid_time']!= $this->invalidTime){
            $informationData                     = new InformationRecords();
            $informationData->member_id          = $memberCard['member_id'];    //会员id
            $informationData->member_card_id     = $this->memberCardId;         //会员阿卡id
            $informationData->create_at          = time();                      //创建时间
            $informationData->note               = '修改赠卡激活时间';        //备注
            $informationData->behavior           = 4;                           //行为3激活日期4到期日期
            $informationData->create_id          = $this->getCreate();          //创建人id
            $informationData->old_time          = $memberCard['active_time'];          //创建人id
            $informationData->new_time          = $this->activeTime;          //创建人id
            if($informationData->save()!=true)
            {
                return $informationData->errors;
            }else{
                $informationDataTwo                     = new InformationRecords();
                $informationDataTwo->member_id          = $memberCard['member_id'];    //会员id
                $informationDataTwo->member_card_id     = $this->memberCardId;         //会员阿卡id
                $informationDataTwo->create_at          = time();                      //创建时间
                $informationDataTwo->note               = '修改赠卡到期时间';        //备注
                $informationDataTwo->behavior           = 5;                           //行为3激活日期4到期日期
                $informationDataTwo->create_id          = $this->getCreate();          //创建人id
                $informationDataTwo->old_time           = $memberCard['invalid_time'];          //创建人id
                $informationDataTwo->new_time           = $this->invalidTime;          //创建人id
                if($informationDataTwo->save())
                {
                    return true;
                }else{
                    return $informationDataTwo->errors;
                }
            }
        }else{
            return true;
        }

    }

    /**
     * 云运动 - 后台- 操作人id
     * @author huanghua <huanghua@itsports.club>
     * @create 2018/3/16
     * @return boolean/object
     */
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