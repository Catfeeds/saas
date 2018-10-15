<?php
namespace backend\models;
use common\models\base\Member;
use Yii;
use yii\base\Model;
use common\models\base\ConsumptionHistory;
use common\models\base\MemberCard;
use common\models\base\ConsultantChangeRecord;
use common\models\base\Order;
class ConsumptionHistoryForm extends Model
{
    public $id;                        //消费记录表id
    public $consumptionAmount;         //消费金额
    public $memberCardId;              //会员卡id
    public $sellerId;                  //会籍顾问
    public $time;                      //缴费时间(时间戳)
    public $name;                      //缴费名称
    public $dueDate;                   //到期日期
    public $behavior;                  //行为
    public $activateTime;              //激活时间

    /**
     * @云运动 - 后台 - 新增角色验证规则
     * @create 2017/11/16
     * @return array
     */
    public function rules()
    {
        return [
            [['id','consumptionAmount','memberCardId','sellerId','time','name','dueDate','behavior','activateTime'], 'safe'],
        ];
    }

    /**
     * @云运动 - 会员管理 - 修改卡种金额和消费记录金额
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/11/16
     * @inheritdoc
     */
    public function updateData()
    {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $consumption = $this->saveConsumption();
                if(!isset($consumption->id)){
                    return $consumption;
                }
                //此处改为不改变卡种金额，在其他地方单独修改2017.12.04
                $memberCard = $this->saveMemberCard();
                if($memberCard != true){
                    return $memberCard;
                }
                $consumptionHistory    = ConsumptionHistory::findOne(['id' => $this->id]);
                $order1   = Order::find()->where(['member_id'=>$consumptionHistory['member_id']])
                    ->andWhere(['and',['consumption_type'=>$consumptionHistory['consumption_type']],['consumption_type_id'=>$consumptionHistory['consumption_type_id']]])
                    ->asArray()->one();
                if(!empty($order1)){
                    $order = $this->saveOrder($order1);
                    if(!isset($order->id)){
                        return $order;
                    }
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
     * 云运动 - 修改 - 消费记录
     * @author 黄华<huanghua@itsports.club>
     * @create 2017/11/16
     * @return array
     */
    public function saveConsumption()
    {
        $consumptionHistory    = ConsumptionHistory::findOne(['id' => $this->id]);               //消费记录表数据
        $consumptionHistory->consumption_amount            = $this->consumptionAmount;           //消费金额
        $consumptionHistory->seller_id                     = $this->sellerId;                    //销售员Id
        $consumptionHistory->consumption_date              = $this->time;                        //缴费时间(时间戳)
        $consumptionHistory->payment_name                  = $this->name;                        //缴费名称
        $consumptionHistory->due_date                      = $this->dueDate;                     //到期日期
        $consumptionHistory->category                      = $this->behavior;                    //行为
        $consumptionHistory->activate_date                 = $this->activateTime;                //激活时间
        $consumptionHistory = $consumptionHistory->save() ? $consumptionHistory : $consumptionHistory->errors;
        if ($consumptionHistory) {
            return $consumptionHistory;
        }else{
            return $consumptionHistory->errors;
        }
    }

    /**
     * 云运动 - 修改 - 会员卡金额
     * @author 黄华<huanghua@itsports.club>
     * @create 2017/11/16
     * @return array
     */
    public function saveMemberCard()
    {
        $memberCard = MemberCard::findOne(['id' => $this->memberCardId]); //会员卡数据
        if($memberCard['status'] == 4){
            $memberCard->status   = 1;
        }
        $memberCard->create_at    = $this->time;
        $memberCard->active_time  = $this->activateTime;
        $memberCard->card_name    = $this->name;
        $memberCard->amount_money = $this->consumptionAmount;
        $memberCard->invalid_time = $this->dueDate;
        if ($memberCard->save() == true) {
            $member = Member::findOne(['id' => $memberCard['member_id']]);
            if($this->sellerId != $member['counselor_id']){
                $consultantChange = new ConsultantChangeRecord();
                $consultantChange->member_id      = $this->id;
                $consultantChange->create_id      = $this->getCreate();
                $consultantChange->created_at     = time();
                $consultantChange->consultant_id  = $this->sellerId;
                $consultantChange->venue_id       = $member['venue_id'];
                $consultantChange->company_id     = $member['company_id'];
                $consultantChange->behavior       = 3;
                if($consultantChange->save() != true){
                    return $consultantChange->errors;
                }
            }
            $member->counselor_id = $this->sellerId;
            if($member->save() == true){
                return true;
            }else{
                return $member->errors;
            }
        }else{
            return $memberCard->errors;
        }
    }

    /**
     * 云运动 - 修改 - 订单
     * @author 黄华<huanghua@itsports.club>
     * @create 2017/11/28
     * @param $order1
     * @return array
     */
    public function saveOrder($order1)
    {
        $order    = Order::findOne(['id' => $order1['id']]);
        $order->total_price    = $this->consumptionAmount;           //消费金额
        $order->sell_people_id = $this->sellerId;                    //售卖人姓名
        $order = $order->save() ? $order : $order->errors;
        if ($order) {
            return $order;
        }else{
            return $order->errors;
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