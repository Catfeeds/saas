<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/4/13
 * Time: 20:29
 */

namespace common\models\relations;

use common\models\MemberCard;
use common\models\Employee;

trait EmployeeTurnMemberRecordRelations
{
    /**
     * 后台会员管理 - 转移会员记录表 - 关联会员表
     * @author huanghua <huanghua@itsports.club>
     * @create 2018/4/4
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(\backend\models\Employee::className(), ['id'=>'to_employee_id']);
    }
    /**
     * 后台会员管理 - 转移会员记录表 - 关联会员表
     * @author huanghua <huanghua@itsports.club>
     * @create 2018/4/4
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeS()
    {
        return $this->hasOne(\backend\models\Employee::className(), ['id'=>'from_employee_id']);
    }
    /**
     * 后台会员管理 - 转移会员记录表 - 关联员工表
     * @author huanghua <huanghua@itsports.club>
     * @create 2018/4/4
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeC()
    {
        return $this->hasOne(Employee::className(), ['id'=>'create_id']);
    }
}