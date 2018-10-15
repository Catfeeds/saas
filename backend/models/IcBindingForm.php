<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\MemberDetails;
use common\models\base\Member;
use common\models\base\Order;
use common\models\base\Employee;
use common\models\base\IcBindingRecord;
use common\models\Func;
use common\models\relations\IcBindRecordRelations;
class IcBindingForm extends Model
{
    public $id;                  //会员id
    public $icNumber;            //ic卡号
    public $amount;              //金额
    use IcBindRecordRelations;

    /**
     * @云运动 - 后台 - ic卡绑定
     * @create 2017/11/20
     * @return array
     */
    public function rules()
    {
        return [
            [['id','icNumber','amount'], 'safe'],
        ];
    }

    /**
     * @云运动 - 会员管理 - ic卡绑定
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/11/20
     * @param $companyId
     * @inheritdoc
     */
    public function updateData($companyId,$venueId)
    {
        //会员详情数据
        $member = Member::findOne(['id'=>$this->id]);
        $model = IcBindRecord::find()->alias("ibr")->joinWith(['member member'])->where(['and',['ibr.member_id' => $this->id],['ibr.status'=>1]])->andWhere(['member.company_id'=>$companyId])->asArray()->all();
        if(!empty($model)){
            return "该会员已经绑定过IC卡,请先解绑!";
        }
        $memberDetails = IcBindRecord::find()->alias("ibr")->joinWith(['member member'])->where(['and',['ibr.ic_number'=>$this->icNumber],['ibr.status'=>1]])->andWhere(['member.company_id'=>$companyId])->asArray()->count();
        if($memberDetails!=0 && $memberDetails==1){
            return "该IC卡号已经绑定过会员,不能重复绑定!";
        }else{
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $order = $this->saveIcBind($member);
                if(!isset($order->id)){
                    throw new \Exception('操作失败');
                }

                $order = $this->saveOrder($member,$companyId,$venueId);
                if(!isset($order->id)){
                    throw new \Exception('操作失败');
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
     * 云运动 - 会员管理 - 存储订单表
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/11/23
     * @param $member
     * @param $companyId
     * @param $venueId
     * @return array
     */
    public function saveOrder($member,$companyId,$venueId)
    {
        $adminModel = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $memberId   = MemberDetails::findOne(['member_id' => $this->id]);
        $order                     = new Order();
        $order->venue_id           = $venueId;                                             //场馆id
        $order->company_id         = $companyId;                                           //公司id
        $order->member_id          = $member->id;                                          //会员id
        $order->card_category_id   = $memberId['id'];                                      //会员详情id
        $order->order_time         = time();                                               //订单创建时间
        $order->pay_money_time     = time();                                               //付款时间
        $order->pay_money_mode     = 1;                                                    //付款方式
        $order->sell_people_id     = $adminModel['id'];                                    //售卖人id
        $order->create_id          = isset($adminModel->id)?intval($adminModel->id):0;    //操作人id
        $order->payee_id           = isset($adminModel->id)?intval($adminModel->id):0;    //操作人id
        $order->status             = 2;                                                    //订单状态：2已付款
        $order->note               = '手环工本费';                                         //备注
        $number                    = Func::setOrderNumber();
        $order->order_number       = "{$number}";                                           //订单编号
        $order->net_price          = $this->amount;                                       //实收价格
        $order->all_price          = $this->amount;                                      //商品总价格
       $order->total_price         = $this->amount;                                  //总价
        $order->card_name           = '手环工本费';                              //卡名称
        $order->sell_people_name    = $adminModel['name'];                                     //售卖人姓名
        $order->payee_name          = $adminModel['name'];                                     //收款人姓名
        $order->member_name         = $memberId['name'];                                           //购买人姓名
        $order->pay_people_name     = $memberId['name'];                                           //付款人姓名
        $order->consumption_type    = 'ic';
        $order->consumption_type_id = $memberId['id'];
        $order->new_note = '手环工本费';
        $order = $order->save() ? $order : $order->errors;
        if ($order) {
            return $order;
        }else{
            return $order->errors;
        }
    }

    /**
     * 云运动 - 会员管理 - 存储ic卡绑定记录表
     * @author huanghua<huanghua@itsports.club>
     * @create 2018/4/23
     * @param $member
     * @return array
     */
    public function saveIcBind($member)
    {
        $adminModel = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $order                       = new IcBindingRecord();
        $order->member_id            = (int)$member->id;
        $order->ic_number            = $this->icNumber;
        $order->custom_ic_number     = (string)time().(string)$member->id;
        $order->create_at            = time();
        $order->unbundling           = 0;
        $order->create_id            = isset($adminModel->id)?intval($adminModel->id):0;;
        $order->status               = 1;
        $order = $order->save() ? $order : $order->errors;
        if ($order) {
            return $order;
        }else{
            return $order->errors;
        }
    }


}