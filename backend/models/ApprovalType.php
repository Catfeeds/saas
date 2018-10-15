<?php
namespace backend\models;

use common\models\relations\ApprovalTypeRelations;

class ApprovalType extends \common\models\base\ApprovalType
{
    use ApprovalTypeRelations;
    /**
     * @后台 - 卡种审核 - 获取审批类型
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/28
     * @param  $companyId  //公司ID
     * @return array
     */
    public function getApprovalTypeData($venueId)
    {
        return ApprovalType::find()->select('id,type')->where(['venue_id'=>$venueId])->asArray()->all();
    }
}