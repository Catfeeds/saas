<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/28 0028
 * Time: 上午 10:01
 */
namespace backend\models;
use common\models\base\ConsumptionHistory;
use common\models\base\Course;
use common\models\base\MemberCourseOrder;
use common\models\base\MemberCourseOrderDetails;
use common\models\base\Order;
use yii\base\Model;
class MemberCourseOrderForm extends Model
{
    public $chargeId;        //私课id
    public $className;       //课程名称
//    public $courseId;        //课种id
    public $totalNum;        //总节数
    public $overageNum;      //剩余节数
    public $totalMoney;      //总金额
    public $privateId;       //教练id
    public $createTime;      //办理日期
    public $deadlineTime;    //课程截止时间
    public $privateStartTime;//开课时间

    /**
     * @会员管理 - 私课修改 - 规则验证
     * @create 2017/11/28
     * @return array
     */
    public function rules()
    {
        return [
            [['chargeId','className','totalNum','overageNum','totalMoney','privateId','createTime','deadlineTime','privateStartTime'], 'safe'],
        ];
    }

    /**
     * @后台会员管理 - 私课修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/28
     * @return bool|string
     */
    public function chargeUpdate()
    {
        $courseOrder = MemberCourseOrder::findOne(['id' => $this->chargeId]);
        $consumption = ConsumptionHistory::findOne(['consumption_type' => 'charge','consumption_type_id' => $this->chargeId]);
        $orderDetail = MemberCourseOrderDetails::findOne(['course_order_id' => $this->chargeId]);
//        $course      = Course::findOne(['id' => $this->courseId]);
        $order       = Order::findOne(['consumption_type_id' => $this->chargeId,'consumption_type' => 'charge']);
        $transaction =  \Yii::$app->db->beginTransaction();       //开启事务
        try{
            if(!empty($courseOrder)){
                $courseOrder->product_name    = $this->className;                  //课程名称
                $courseOrder->course_amount   = $this->totalNum;                   //总节数
                $courseOrder->overage_section = $this->overageNum;                 //剩余节数
                $courseOrder->money_amount    = $this->totalMoney;                 //总金额
                $courseOrder->private_id      = $this->privateId;                  //教练
                $courseOrder->create_at       = strtotime($this->createTime);      //课程办理日期
                $courseOrder->deadline_time   = strtotime($this->deadlineTime) + 86399; //课程截止时间
                $courseOrder->activeTime      = strtotime($this->privateStartTime);//课程开始时间
                if($courseOrder->save() != true){
                    return $courseOrder->errors;
                }
            }

            if(!empty($orderDetail)){
                $orderDetail->product_name = $this->className;
//                $orderDetail->course_id   = $this->courseId;
//                $orderDetail->course_num  = $this->totalNum;
//                $orderDetail->course_name = $course['name'];
                if($orderDetail->save() != true){
                    return $orderDetail->errors;
                }
            }
//            else{
                $orderDetail = new MemberCourseOrderDetails();
//                $orderDetail->course_id   = $this->courseId;
//                $orderDetail->course_num  = $this->totalNum;
//                $orderDetail->course_name = $course['name'];
//            }

            if(!empty($consumption)){
                $consumption->cash_payment       = $this->totalMoney;
                $consumption->network_payment    = $this->totalMoney;
                $consumption->consumption_amount = $this->totalMoney;
                if($consumption->save() != true){
                    return $consumption->errors;
                }
            }

            if(!empty($order)){
                $order->total_price = $this->totalMoney;
                $order->card_name   = $this->className;
                if($order->save() != true){
                    return $order->errors;
                }
            }

            if($transaction->commit() == null){
                return true;
            }else{
                return false;
            }
        }catch(\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();  //获取抛出的错误
        }
    }
}