<?php
namespace backend\models;

use common\models\base\AppCardDiscount;
use common\models\base\Approval;
use common\models\base\ApprovalComment;
use common\models\base\ApprovalDetails;
use yii\base\Model;
class UpdateApprovalDetailForm extends Model
{
    public $status;                //状态
    public $describe;              //描述
    public $id;                    // 详情ID
    /**
     * @date:2017-09-28 10:34
     * @author :李慧恩
     * @content:增加审核详情属性规则
     * @return  array
     */
    public function rules()
    {
        return [
          [['status','describe','id'],'safe']
        ];
    }
    /**
     * @date:2017-09-28 10:34
     * @author :李慧恩
     * @content:增加审核详情
     * @return  array
     */
    public function saveApprovalDetails()
    {
        $details = ApprovalDetails::findOne(['id'=>$this->id]);
        $details->status   = $this->status;
        $details->describe = $this->describe;
        $approval = Approval::findOne(['id'=>$details->approval_id]);
        if($details->status == 2){    //同意
            $approval->progress = $approval->progress + 1;
            if($approval->total_progress == $approval->progress){
                $approval->status = 2;
                if($approval['note'] == '新增卡种审批'){
                    $card = \common\models\base\CardCategory::findOne(['id'=>$approval->polymorphic_id]);
                    $card->status = 1;    //正常
                    $card->save();
                }elseif($approval['note'] == '移动端卡种折扣价审批'){
                    $discount = AppCardDiscount::findOne(['id'=>$approval->polymorphic_id]);
                    $discount->status = 2;    //已通过
                    $discount->save();
                }
            }
            if($approval->progress > $approval->total_progress){
                $approval->progress = $approval->total_progress;
            }
        }else{
            $approval->progress = $approval->progress + 1;
            $approval->status   = $this->status;
            if($approval['note'] == '新增卡种审批'){
                $card = \common\models\base\CardCategory::findOne(['id'=>$approval->polymorphic_id]);
                $card->status = $this->status + 2;
                $card->save();
            }elseif($approval['note'] == '移动端卡种折扣价审批'){
                $discount = AppCardDiscount::findOne(['id'=>$approval->polymorphic_id]);
                if($details->status == 3){    //拒绝
                    $discount->status = 3;    //未通过
                }elseif($details->status == 4){    //撤销
                    $discount->status = 4;         //已撤销
                }
                $discount->save();
            }
        }
        if(!$details->save()){
            return $details->errors;
        }
        if(!$approval->save()){
            return $approval->errors;
        }
        return true;
    }
}