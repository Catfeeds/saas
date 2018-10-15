<?php
namespace backend\models;

use common\models\base\MemberDeposit;
use yii\base\Model;
use Yii;
use common\models\Func;
use common\models\base\Order;
use common\models\base\Employee;
use common\models\base\Member;
use common\models\base\MemberDetails;

class MemberDepositForm extends Model
{
    public $memberId; //会员ID
    public $price;    //金额
    public $startTime; //开始时间
    public $endTime;  //结束时间
    public $payMode;  //付款方式
    public $payType;  //定金类型
    public $seller;    //销售id
    public $id;         //定金id
    const NOTICE = '操作失败';

    public function rules()
    {
        return [
            [['memberId','price','startTime','endTime','payMode','payType','seller','id'],'safe']
        ];
    }

    public function saveDeposit($companyId,$venueId)
    {
        $member = Member::findOne(['id' => $this->memberId]);
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $memberDeposit = new MemberDeposit();
            $memberDeposit->member_id = $member['id'];
            $memberDeposit->price = $this->price;
            $memberDeposit->start_time = strtotime($this->startTime);
            $memberDeposit->end_time = strtotime($this->endTime);
            $memberDeposit->pay_mode = $this->payMode;
            $memberDeposit->type     = $this->payType;
            $memberDeposit->is_use   = 1;
            $memberDeposit = $memberDeposit->save() ? $memberDeposit : $memberDeposit->errors;
            if(!isset($memberDeposit->id)){
                throw new \Exception(self::NOTICE);
            }

            $order = $this->saveOrder($member,$companyId,$venueId,$memberDeposit);
            if(!isset($order->id)){
                return $order;
            }

            $consumption = $this->saveConsumptionHistory($member,$companyId,$venueId,$memberDeposit);
            if($consumption !== true){
                return $consumption;
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
     * 云运动 - 定金 - 存储订单表
     * @author 黄华<huanghua@itsports.club>
     * @create 2017/9/11
     * @param $member
     * @param $companyId
     * @param $venueId
     * @param $memberDeposit
     * @return array
     */
    public function saveOrder($member,$companyId,$venueId,$memberDeposit)
    {
        $adminModel    = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $sellModel     = Employee::findOne(['id'=>$this->seller]);
        $memberDetails = MemberDetails::findOne(['member_id'=>$member['id']]);
        $order                       = new Order();
        $order->venue_id             = $venueId;                                              //场馆id
        $order->company_id           = $companyId;                                           //公司id
        $order->card_category_id     = 0;                                                    //卡种id
        $order->member_id            = $member['id'];                                        //会员id
        $order->order_time           = time();                                               //订单创建时间
        $order->pay_money_time       = time();                                               //付款时间
        $order->pay_money_mode       = $this->payMode;                                       //付款方式
        $order->sell_people_id       = $sellModel['id'];                                    //售卖人id
        $order->create_id            = isset($adminModel->id)?intval($adminModel->id):0;    //操作人id
        $order->payee_id             = isset($adminModel->id)?intval($adminModel->id):0;    //操作人id
        $order->status               = 2;                                                    //订单状态：2已付款
        $note = $this->depositType();
        $order->note                 = $note;                                               //备注
        $number                      = Func::setOrderNumber();                               //订单号
        $order->order_number         = "{$number}";                                          //订单编号
        $order->deposit              = $this->price;                                         //定金
        $order->total_price          = $this->price;                                         //总价
        $order->card_name            = '定金';                                               //定金
        $order->all_price            = $this->price;                                         //商品总价格
        $order->sell_people_name     = $sellModel['name'];                                  //售卖人姓名
        $order->payee_name           = $adminModel['name'];                                  //收款人姓名
        $order->member_name          = $memberDetails['name'];                               //购买人姓名
        $order->pay_people_name      = $memberDetails['name'];                               //付款人姓名
        $order->consumption_type     = 'deposit';                                            //多态类型
        $order->consumption_type_id  = $memberDeposit->id;                                   //多态id
        $order = $order->save() ? $order : $order->errors;
        if ($order) {
            return $order;
        }else{
            return $order->errors;
        }
    }

    /**
     * 云运动 - 定金 - 存储消费记录表
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/20
     * @return array
     */
    public function saveConsumptionHistory($member,$companyId,$venueId,$memberDeposit)
    {
        $note = $this->depositType();
        $history = new ConsumptionHistory();
        $history->member_id           = $this->memberId;           //会员id
        $history->consumption_type    = 'deposit';                 //消费类型
        $history->consumption_type_id = $memberDeposit['id'];      //消费项目id
        $history->type                = (int)1;                    //消费方式（1现金2次卡3充值卡）
        $history->consumption_date    = time();                    //消费日期
        $history->consumption_time    = time();                    //消费时间
        $history->consumption_times   = 1;                         //消费次数
        $history->cash_payment        = $this->price;              //现金付款 金额
        $history->venue_id            = $venueId;                  //场馆id
        $history->seller_id           = $member['counselor_id'];   //销售员id
        $history->describe            = json_encode($note);    //消费描述
        $history->category            = '定金';                     //消费类型状态
        $history->company_id          = $companyId;                 //公司id
        $history->consumption_amount  = $this->price;               //消费金额
        $history->consume_describe    = json_encode($note);     //消费描述
        $history->remarks             = $note;                  //备注
        if($history->save()){
            return true;
        }else{
            return $history->errors;
        }
    }

    public function updateDeposit()
    {
        //获取当前定金信息
        $deposit = MemberDeposit::findOne(['id'=>$this->id]);
        if (!isset($deposit) && empty($old)) {
            return '定金不存在!';
        }
        //获取订单信息
        $order = Order::find()->where(['and',
            ['consumption_type_id'=>$this->id],
            ['consumption_type'=>'deposit'],
            ['member_id'=>$this->memberId],
        ])->one();
        //获取消费记录
        $history = \common\models\base\ConsumptionHistory::find()
            ->where(['and',
                ['consumption_type'=>'deposit'],
                ['consumption_type_id'=>$this->id],
                ['member_id'=>$this->memberId],
                ])->one();
        $adminModel    = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $sellModel     = Employee::findOne(['id'=>$this->seller]);
        $member      = Member::findOne(['id' => $this->memberId]);
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            //修改定金信息
            MemberDeposit::updateAll(['price'=>$this->price,'type'=>$this->payType,'pay_mode'=>$this->payMode,'start_time'=>strtotime($this->startTime),'end_time'=>strtotime($this->endTime)],['id'=>$this->id]);
            //修改订单信息
            $note = $this->depositType();
            $order->pay_money_mode       = $this->payMode;                                       //付款方式
            $order->sell_people_id       = $sellModel['id'];                                    //售卖人id
            $order->create_id            = isset($adminModel->id)?intval($adminModel->id):0;    //操作人id
            $order->payee_id             = isset($adminModel->id)?intval($adminModel->id):0;    //操作人id
            $order->deposit              = $this->price;                                         //定金
            $order->total_price          = $this->price;                                         //总价
            $order->all_price            = $this->price;                                         //商品总价格
            $order->sell_people_name     = $sellModel['name'];                                  //售卖人姓名
            $order->payee_name           = $adminModel['name'];                                  //收款人姓名
            $order->note                 = $note;                                               //备注
            $order->card_name            = '定金';                                               //定金
            $result = $order->save();
            if (!$result) {
                return '修改订单信息失败';
            }
            //修改消费信息
            $history->cash_payment        = $this->price;              //现金付款 金额
            $history->seller_id           = $member['counselor_id'];   //销售员id
            $history->consumption_amount  = $this->price;               //消费金额
            $history->describe            = json_encode($note);      //消费描述
            $history->consume_describe    = json_encode($note);      //消费描述
            $history->remarks             = $note;                   //备注
            $history->category            = '定金';                     //消费类型状态
            $res = $history->save();
            if (!$res) {
                return '修改消费信息失败';
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
     * @desc: 业务后台 - 定金 - 获取定金类型
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/17
     * @return string
     */
    private function depositType()
    {
        switch ($this->payType) {
            case 1 : $note = '购卡定金';break;
            case 2 : $note = '购课定金';break;
            case 3 : $note = '续费定金';break;
            case 4 : $note = '卡升级定金';break;
            case 5 : $note = '课升级定金';break;
        }
        return $note;
    }
}