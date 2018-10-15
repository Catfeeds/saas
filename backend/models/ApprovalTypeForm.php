<?php
namespace backend\models;

use common\models\base\ApprovalRole;
use common\models\base\ApprovalType;
use yii\base\Model;

class ApprovalTypeForm extends Model
{
    public $approvalType;  //审批类型
    public $roleType;      //角色类型：1审批人，2抄送人
    public $companyId;     //公司id
    public $venueId;       //场馆id
    public $departId;      //部门id
    public $roleId;        //角色id
    public $employeeId;    //人员id

    public function rules()
    {
        return [
            [['approvalType','roleType','companyId','venueId','departId','roleId','employeeId'], 'safe'],
        ];
    }

    /**
     * @后台 - 卡种审核 - 设置审批流程
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/28
     * @param $companyId
     * @param $venueId
     * @return boolean
     */
    public function setApprovalProcess($companyId,$venueId)
    {
            $type     = ApprovalType::findOne(['type' =>$this->approvalType,'venue_id' => $venueId]);
            if(empty($type)){
                $appType = new ApprovalType();
                $appType->type       = $this->approvalType;
                $appType->company_id = $companyId;
                $appType->create_at  = time();
                $appType->venue_id   = $venueId;
                if(!$appType->save()){
                    return $appType->errors;
                }
                $this->approvalType = $appType->id;
            }else{
                $this->approvalType = $type->id;
            }
        $appRole                   = new ApprovalRole();
        $appRole->type             = $this->roleType;       //类型：1审批角色，2抄送角色
        $appRole->approval_type_id = $this->approvalType;   //审批类型id
        $appRole->role_id          = $this->roleId;         //角色id
        $appRole->employee_id      = $this->employeeId;     //员工id
        $appRole->company_id       = $this->companyId;      //公司id
        $appRole->venue_id         = $this->venueId;        //场馆id
        $appRole->department_id    = $this->departId;       //部门id
        $appRole->create_at        = time();                //创建时间
        if($appRole->save() == true){
            return true;
        }else{
            return $appRole->errors;
        }
    }
//    public function setApprovalProcess($companyId,$venueId)
//    {
//        $approvalRole = new ApprovalRole();
//        $transaction = \Yii::$app->db->beginTransaction();
//        try {
//            $type     = ApprovalType::findOne(['type' =>$this->type,'company_id' => $companyId]);
//            if(empty($type)){
//                $appType = new ApprovalType();
//                $appType->type       = $this->type;
//                $appType->company_id = $companyId;
//                $appType->create_at  = time();
//                $appType->venue_id   = $venueId;
//                if(!$appType->save()){
//                    return $appType->errors;
//                }
//            }else{
//                $this->type = $type->id;
//            }
//            if(!empty($this->approverArr)){
//                foreach($this->approverArr as $key=>$value){
//                    $approvalRole->type             = 1;           //类型：1审批角色，2抄送角色
//                    $approvalRole->approval_type_id = $this->type; //审批类型id
//                    $approvalRole->company_id       = $value[0];   //公司id
//                    $approvalRole->venue_id         = $value[1];   //场馆id
//                    $approvalRole->department_id    = $value[2];   //部门id
//                    $approvalRole->role_id          = $value[3];   //角色id
//                    $approvalRole->employee_id      = $value[4];   //员工id
//                    $approvalRole->create_at        = time();      //创建时间
//                }
//                if($approvalRole->save() !== true){
//                    return $approvalRole->errors;
//                }
//            }
//
//            if(!empty($this->senderArr)){
//                foreach($this->senderArr as $k=>$v){
//                    $approvalRole->type             = 2;           //类型：1审批角色，2抄送角色
//                    $approvalRole->approval_type_id = $this->type; //审批类型id
//                    $approvalRole->company_id       = $v[0];       //公司id
//                    $approvalRole->venue_id         = $v[1];       //场馆id
//                    $approvalRole->department_id    = $v[2];       //部门id
//                    $approvalRole->role_id          = $v[3];       //角色id
//                    $approvalRole->employee_id      = $v[4];       //员工id
//                    $approvalRole->create_at        = time();      //创建时间
//                }
//                if($approvalRole->save() !== true){
//                    return $approvalRole->errors;
//                }
//            }
//
//            if ($transaction->commit() === null) {
//                return true;
//            } else {
//                return false;
//            }
//        } catch (\Exception $e) {
//            $transaction->rollBack();
//            return  $e->getMessage();
//        }
//    }
}