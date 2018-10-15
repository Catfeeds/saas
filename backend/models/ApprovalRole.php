<?php
namespace backend\models;

use common\models\relations\ApprovalRoleRelations;

class ApprovalRole extends \common\models\base\ApprovalRole
{
    use ApprovalRoleRelations;

    /**
     * @后台 - 卡种审核 - 获取审批人、抄送人数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/29
     * @param  $params
     * @return array
     */
    public function getApprovalRoleData($params)
    {
        return ApprovalRole::find()
            ->alias('ar')
            ->joinWith(['role role'],false)
            ->joinWith(['employee em'],false)
            ->joinWith(['approvalType at'],false)
            ->where(['at.type' => $params['appType'],'ar.type' => $params['roleType']])
            ->andWhere(['at.venue_id'=>$params['venueId']])
            ->select('ar.id,role.name as roleName,em.name')
            ->asArray()->all();
    }

    /**
     * @后台 - 卡种审核 - 删除审批人、抄送人数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/29
     * @param  $id  //ApprovalRole的id
     * @return boolean
     */
    public function delApprovalRole($id)
    {

        $appRole = ApprovalRole::findOne(['id' => $id]);
        if(!empty($appRole)){
            $appType = ApprovalDetails::findOne(['approver_id'=>$appRole->employee_id,'approval_process_id'=>$appRole->approval_type_id,'status'=>1]);
            if(!empty($appType)){
                $approval = Approval::findOne(['id'=>$appType->approval_id,'status'=>1]);
                if(!empty($approval)){
                    return false;
                }
            }
            if($appRole->delete()){
                return true;
            }else{
                return false;
            }
        }
        return false;

    }
}