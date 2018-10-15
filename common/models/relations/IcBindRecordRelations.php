<?php
namespace common\models\relations;

use common\models\base\Member;
use common\models\base\Employee;

trait IcBindRecordRelations
{

    /**
     * 正式管理 - 绑定ic卡号记录表 - 关联会员表
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/5
     * @return \yii\db\ActiveQuery
     */
    public function getMember()
    {
        return $this->hasOne(Member::className(), ['id'=>'member_id']);
    }
    /**
     * 正式管理 - 绑定ic卡号记录表 - 关联员工表
     * @author Huang hua <huanghua@itsports.club>
     * @create 2018/3/16
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id'=>'create_id']);
    }
}