<?php

namespace common\models\relations;

use backend\models\ActionCategory;
use backend\models\ActionCategoryRelation;
use backend\models\ActionImages;

trait ActionRelations
{
    /**
     * 私教管理 - 动作库 - 动作表、分类表、关联表三表关联
     * @author jianbingqi <jianbingqi@itsports.club>
     * @return \yii\db\ActiveQuery
     */
    public function getCategorys()
    {
        return $this->hasMany(ActionCategory::className(), ['id' => 'cid'])
            ->viaTable(ActionCategoryRelation::tableName(), ['aid' => 'id']);
    }

    /**
     * 私教管理 - 动作库 - 动作表关联图片表
     * @author jianbingqi <jianbingqi@itsports.club>
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(ActionImages::className(), ['aid'=>'id']);
    }


}