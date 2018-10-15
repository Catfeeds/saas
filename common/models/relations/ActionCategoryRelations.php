<?php


namespace common\models\relations;

use backend\models\Action;

use backend\models\ActionCategoryRelation;

trait ActionCategoryRelations
{
    /**
     * 私教管理 - 动作库 - 动作表、分类表、关联表三表关联
     * @author jianbingqi <jianbingqi@itsports.club>
     * @return \yii\db\ActiveQuery
     */
    public function getActions()
    {
        return $this->hasMany(Action::className(), ['id' => 'aid'])
            ->viaTable(ActionCategoryRelation::tableName(), ['cid' => 'id']);
    }

}