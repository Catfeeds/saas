<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/8 0008
 * Time: 下午 4:47
 */

namespace backend\models;

use common\models\base\AppCardDiscount;
use common\models\base\Approval;
use common\models\base\ApprovalDetails;
use common\models\base\Employee;
use common\models\base\Organization;
use common\models\Func;
use yii\base\Model;
use Yii;

class AppCardDiscountForm extends Model
{
    public $venueId;            //场馆id
    public $discount;           //折扣
    public $start;              //开始时间
    public $end;                //结束时间
    public $noDiscountCard;     //不打折卡种
    public $discountId;         //移动端卡种折扣id

    public function scenarios()
    {
        return [
            "add" => ["venueId", "discount", "start", "end", "noDiscountCard"],
            "update" => ["venueId", "discount", "start", "end", "noDiscountCard", "discountId"],
        ];
    }

    public function rules()
    {
        return [
            [["venueId", "discount", "start", "end", "noDiscountCard", "discountId"], 'safe'],
        ];
    }

    /**
     * 后台 - 手机折扣 - 新增移动端卡种折扣
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/8
     * @return bool|string
     */
    public function addAppDiscount()
    {
        $appD = AppCardDiscount::find()->where(['and', ['venue_id' => $this->venueId], ['status' => [1, 2]]])->asArray()->one();
        if (isset($appD) && $appD['status'] == 1) {
            return '此场馆的折扣正在审核中，请勿重复提交';
        }
        if (isset($appD) && $appD['status'] == 2) {
            return '此场馆已有折扣，请勿重复提交';
        }
        $transaction = \Yii::$app->db->beginTransaction();   //开启事务
        try {
            $discount = new AppCardDiscount();
            $discount->venue_id = $this->venueId;
            $discount->discount = $this->discount;
            $discount->start = strtotime($this->start . " 00:00");
            $discount->end = strtotime($this->end . " 23:59");
            $discount->status = 1;    //审核中
            $discount->no_discount_card = json_encode($this->noDiscountCard);
            $discount->create_at = time();
            $discount->update_at = time();
            if ($discount->save() != true) {
                throw new \Exception('操作失败');
            }

            $approval = $this->saveApproval($discount);
            if ($approval != true) {
                throw new \Exception('操作失败');
            }

            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();  //获取抛出的错误
        }
    }

    /**
     * 后台 - 手机折扣 - 新增移动端卡种折扣 - 生成审批表
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/8
     * @return bool|string
     */
    public function saveApproval($discount)
    {
        $adminModel = Employee::findOne(['admin_user_id' => \Yii::$app->user->identity->id]);
        $type = ApprovalType::findOne(['type' => '移动端会员卡折扣价', 'venue_id' => $this->venueId]);
        if (empty($type)) {
            $app = AppCardDiscount::findOne(['id' => $discount['id']]);
            $app->status = 2;   //正常
            if ($app->save() == true) {
                return true;
            }
            return $app->errors;
        }
        $approvalRole = ApprovalRole::find()->where(['type' => 1, 'approval_type_id' => $type->id])->all();
        if (empty($approvalRole)) {
            $app = AppCardDiscount::findOne(['id' => $discount['id']]);
            $app->status = 2;   //正常
            if ($app->save() == true) {
                return true;
            }
            return $app->errors;
        }
        $venue = Organization::findOne(['id' => $this->venueId]);
        $approval = new Approval();
        $approval->name = '移动端会员卡折扣价';         //审批名称
        $approval->polymorphic_id = $discount['id'];           //多态id:移动端卡种折扣id
        $number = Func::setOrderNumber();    //生成编号
        $approval->number = $number;                   //审批编号
        $approval->approval_type_id = $type['id'];               //审批类型id
        $approval->status = 1;                         //状态:1审批中，2已通过
        $approval->create_id = $adminModel->id;           //创建人id
        $approval->total_progress = count($approvalRole);      //总进度
        $approval->progress = 0;                         //当前进度
        $approval->note = '移动端卡种折扣价审批';       //备注
        $approval->company_id = $venue->pid;               //公司id
        $approval->venue_id = $this->venueId;            //场馆id
        $approval->create_at = time();                    //创建时间
        if ($approval->save()) {
            $this->saveApprovalDetail($approval, $type->id);
            return true;
        } else {
            return $approval->errors;
        }
    }

    /**
     * 后台 - 手机折扣 - 新增移动端卡种折扣 - 生成审批详情表
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/8
     * @return bool|string
     */
    public function saveApprovalDetail($approval, $typeId)
    {
        $approvalRole = ApprovalRole::find()->where(['approval_type_id' => $typeId])->all();
        if (!empty($approvalRole)) {
            foreach ($approvalRole as $k => $v) {
                $detail = new ApprovalDetails();
                $detail->approval_id = $approval->id;
                $detail->approver_id = $v['employee_id'];
                $detail->type = $v['type'];
                $detail->approval_process_id = $v['approval_type_id'];
                $detail->status = 1;
                $detail->create_at = time();
                $detail->update_at = time();
                $detail->save();
            }
        }
    }

    /**
     * 后台 - 手机折扣 - 修改移动端卡种折扣
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/13
     * @return bool|string
     */
    public function updateAppDiscount()
    {
        $appD = AppCardDiscount::find()->where(['and', ['venue_id' => $this->venueId], ['status' => [1, 2]], ['!=', 'id', $this->discountId]])->asArray()->one();
        if (isset($appD) && $appD['status'] == 1) {
            return '此场馆的折扣正在审核中，请勿重复提交';
        }
        if (isset($appD) && $appD['status'] == 2) {
            return '此场馆已有折扣，请勿重复提交';
        }
        $discount = AppCardDiscount::findOne(['id' => $this->discountId]);
        $approval = Approval::findOne(['polymorphic_id' => $this->discountId]);
        if (isset($approval) && $discount['status'] == 2) {
            $transaction = \Yii::$app->db->beginTransaction();   //开启事务
            try {
                $discount->venue_id = $this->venueId;
                $discount->discount = $this->discount;
                $discount->start = strtotime($this->start . " 00:00");
                $discount->end = strtotime($this->end . " 23:59");
                $discount->status = 1;
                $discount->update_at = time();
                if (!empty($this->noDiscountCard)) {
                    $discount->no_discount_card = json_encode($this->noDiscountCard);
                }
                if ($discount->save() != true) {
                    throw new \Exception('操作失败');
                }

                $approval->status = 1;
                $approval->progress = 0;
                if ($approval->save() != true) {
                    throw new \Exception('操作失败');
                }

                $details = ApprovalDetails::findAll(['approval_id' => $approval['id']]);
                if (isset($details)) {
                    foreach ($details as $key => $value) {
                        $value->status = 1;
                        $value->save();
                    }
                }

                if ($transaction->commit() === null) {
                    return true;
                } else {
                    return false;
                }
            } catch (\Exception $e) {
                //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
                $transaction->rollBack();
                return $e->getMessage();  //获取抛出的错误
            }
        } else {
            $discount->venue_id = $this->venueId;
            $discount->discount = $this->discount;
            $discount->start = strtotime($this->start . " 00:00");
            $discount->end = strtotime($this->end . " 23:59");
            $discount->update_at = time();
            if (!empty($this->noDiscountCard)) {
                $discount->no_discount_card = json_encode($this->noDiscountCard);
            }
            if ($discount->save() == true) {
                return true;
            } else {
                return $discount->errors;
            }
        }
    }
}