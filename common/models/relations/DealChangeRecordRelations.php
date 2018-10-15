<?php
namespace common\models\relations;

use common\models\base\DealType;

trait  DealChangeRecordRelations
{

    /**
     * 后台 - 合同管理- 管理合同类型表
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/25
     * @return string
     */
    public function getDealType(){
        return $this->hasOne(DealType::className(), ['id'=>'deal_type_id']);
    }
}