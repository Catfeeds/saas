<?php
namespace common\models\relations;

use common\models\base\Employee;
use common\models\MemberCard;
use common\models\MemberCourseOrder;
use common\models\MemberDetails;

trait LeaveRecordRelations
{
    /**
     * 后台会员管理 - 请假 - 关联员工表
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/18
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id'=>'is_approval_id']);
    }
    /**
     * 后台会员管理 - 请假 - 关联会员表
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/18
     * @return \yii\db\ActiveQuery
     */
    public function getMember()
    {
        return $this->hasOne(\common\models\Member::className(), ['id'=>'leave_employee_id']);
    }
    /**
     * 后台会员管理 - 请假 - 关联会员卡表
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/18
     * @return \yii\db\ActiveQuery
     */
    public function getMemberCard()
    {
        return $this->hasOne(MemberCard::className(), ['id'=>'member_card_id']);
    }

    public function getMemberDetails()
    {
        return $this->hasOne(MemberDetails::className(), ['member_id'=>'leave_employee_id']);
    }

    public function getMemberCourseOrder()
    {
        return $this->hasMany(MemberCourseOrder::className(), ['member_id'=>'leave_employee_id']);
    }

}