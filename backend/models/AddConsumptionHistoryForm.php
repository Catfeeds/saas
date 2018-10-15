<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\ConsumptionHistory;
use common\models\base\MemberCard;
class AddConsumptionHistoryForm extends Model
{
    public $memberCardId;                //会员卡id
    public $paymentAmount;              //缴费金额
    public $paymentTime;                //缴费时间
    public $paymentName;                //缴费名称
    public $sellId;                     //会籍顾问
    public $dueDate;                    //到期时间
    public $behavior;                   //行为
    public $activateTime;               //激活时间



    /**
     * @云运动 - 后台 - 新增消费记录验证规则
     * @create 2017/12/6
     * @return array
     */
    public function rules()
    {
        return [
            [['memberCardId','paymentAmount', 'paymentTime','paymentName','sellId','dueDate','behavior','activateTime'], 'safe'],
        ];
    }

    /**
     * 云运动 - 后台- 新增角色信息录入
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/6/16
     * @param $companyId
     * @param $venueId
     * @return boolean/object
     */
    public function addMyData($companyId,$venueId)
    {
        $memberCard = MemberCard::findOne(['id'=>$this->memberCardId]);
        $model                       = new ConsumptionHistory();
        $model->member_id            = $memberCard['member_id'];
        $model->consumption_type     = 'card';
        $model->consumption_type_id  = $this->memberCardId;
        $model->type                 = 1;
        $model->consumption_date     = $this->paymentTime;
        $model->consumption_time     = $this->paymentTime;
        $model->consumption_times    = 1;
        $model->consumption_amount   = $this->paymentAmount;
        $model->cash_payment         = $this->paymentAmount;
        $model->seller_id            = $this->sellId;
        $model->due_date             = $this->dueDate;
        $model->category             = $this->behavior;
        $model->venue_id             = $venueId;
        $model->company_id           = $companyId;
        $model->payment_name         = $this->paymentName;
        $model->activate_date        = $this->activateTime;

        if ($model->save()) {
            return true;
        } else {
            return $model->errors;
        }
    }

}