<?php
namespace common\models\relations;

use common\models\Employee;
use common\models\base\Role;
use backend\rbac\models\AuthRoleChildModel;

trait AdminRelations
{
    /**
     * 后台角色管理 - 管理员表查询 - 关联角色表
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/7/6
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'level']);
    }
    /**
     * 后台 - 会员行为轨迹 - 关联员工表
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/7/14
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(),['admin_user_id' => 'id']);
    }

    /**
     * @describe 审批 - 审批流程设置 - 根据角色ID获取用户信息
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-08-01
     * @return mixed
     */
    public function getRoleChild()
    {
        return $this->hasOne(AuthRoleChildModel::className(), ['user_id' => 'id']);
    }
}
