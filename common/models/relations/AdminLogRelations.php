<?php

namespace common\models\relations;


use common\models\Member;

trait AdminLogRelations
{


    /**
     * 关联会员表
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/11
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(\common\models\Admin::className(), ['id'=>'user_id']);
    }

}