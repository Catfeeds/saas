<?php
namespace backend\models;

use common\models\base\MemberCourseOrder;
use common\models\base\ExtensionRecord;
use yii\base\Model;
use Yii;
class PrivateClassDelayForm extends Model
{
    public $id;
    public $days;
    public $remarks;

    public function rules()
    {
        return [
            [['id','days','remarks'], 'safe'],
        ];
    }

    public function delay()
    {
        $order = MemberCourseOrder::findOne(['id' => $this->id]);
        if(!empty($order)){
            $transaction = Yii::$app->db->beginTransaction();
        try{

            if($order['deadline_time']>time()){
                $order->deadline_time = $order['deadline_time']+$this->days*24*60*60;
            }else{
                $order->deadline_time = time()+$this->days*24*60*60;
            }

            $order = $order->save() ? $order : $order->errors;
        if(!isset($order->id)){
             return $order;
         }
         $extensionRecord = $this->saveExtensionRecord($order);
         if(!isset($extensionRecord->id)){
             return $extensionRecord;
         }
         if ($transaction->commit() === null) {
             return true;
         } else {
             return false;
         }
        }catch (\Exception $e) {
         //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
          $transaction->rollBack();
          return  $e->getMessage();
        }

        }
    }

    /**
     * 云运动 - 会员管理 - 储存私课延期记录
     * @author 黄华<huanghua@itsports.club>
     * @create 2017/10/13
     * @param $order
     * @return array
     */
    public function saveExtensionRecord($order)
    {
        $extensionRecord                     = new ExtensionRecord();
        $extensionRecord->course_order_id    = $order['id'];                                   //课程订单id
        $extensionRecord->course_name        = $order['product_name'];                         //课程名称
        $extensionRecord->course_num         = $order['overage_section'];                      //课程节数
        $extensionRecord->postpone_day       = $this->days;                                    //延期天数
        $extensionRecord->due_day            = $order['deadline_time'];                        //到期日期
        $extensionRecord->remark             = $this->remarks;                                 //延期备注
        $extensionRecord->create_at          = time();                                         //创建时间
        $extensionRecord->member_id          = $order['member_id'];                            //会员id
        $extensionRecord->create_id          = $this->getCreate();                             //创建人id
        $extensionRecord = $extensionRecord->save() ? $extensionRecord : $extensionRecord->errors;
        if ($extensionRecord) {
            return $extensionRecord;
        }else{
            return $order->$extensionRecord;
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