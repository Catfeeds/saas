<?php

namespace common\models\relations;


trait ClassBeforeQuestionRelations
{


    /**
     * 关联课种
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(\common\models\base\Course::className(), ['id'=>'course_id']);
    }

}