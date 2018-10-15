<?php
/**
 * 审核详情模型
 * User: lihuien
 * Date: 2017/9/28
 * Time: 15:23
 */

namespace backend\models;


use common\models\relations\ApprovalDetailsRelations;

class ApprovalDetails  extends \common\models\base\ApprovalDetails
{
    use ApprovalDetailsRelations;
    /**
     * @date:2017-09-28 10:34
     * @author :李慧恩
     * @param  $id;
     * @content:获取审批详情数据
     * @return  array
     */
    public function getApprovalDetailsDataById($id)
    {
        return  self::find()
            ->alias('ad')
            ->joinWith(['approvalComment ac'=>function($query){
                    $query->select('ac.*,employee.name')->joinWith(['employee employee'],false);
            }])
            ->joinWith(['employee em'],false)
            ->where(['ad.approval_id'=>$id])
            ->andWhere(['ad.type' => 1])
            ->select('ad.id,ad.approval_id,ad.describe,ad.status,ad.approver_id,em.name,em.pic,ad.create_at,ad.update_at')
            ->orderBy('ad.id ASC')
            ->asArray()->all();
    }
}