<?php

namespace common\models\relations;

use common\models\base\TrainTemplates;
use common\models\base\TrainTemplateTags;
use backend\models\TrainStage;


trait TrainTemplatesRelations
{
    /**
     * 私教管理 - 训练模板 - 模板表、计划表关联（一对多）
     * @author jianbingqi <jianbingqi@itsports.club>
     * @return \yii\db\ActiveQuery
     */

    public function getStages()
    {
        return $this->hasMany(TrainStage::className(), ['template_id' => 'id']);
    }

    /**
     * 私教管理 - 训练模板 - 模板表、分类表关联（一对一）
     * @author jianbingqi <jianbingqi@itsports.club>
     * @return \yii\db\ActiveQuery
     */

    public function getTemplateTags()
    {
        return $this->hasOne(TrainTemplateTags::className(), ['id' => 'cid']);
    }

}