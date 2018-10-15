<?php

namespace backend\rbac;

use backend\rbac\models\AuthRoleChildModel;
use backend\rbac\models\AuthRoleModel;
use backend\rbac\models\AuthModuleModel;

trait Relation
{
    /**
     * @describe 高级、基础角色关系表关联模块表 auth_role_item ^ auth_module
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-02
     */
    public function getModule()
    {
        return $this->hasOne(AuthModuleModel::className(), ['name' => 'auth_item']);
    }

    /**
     * @describe 高级角色、基础角色关系表关联高级角色表 auth_role_item ^ auth_role
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-05
     * @return mixed
     */
    public function getRole()
    {
        return $this->hasOne(AuthRoleModel::className(), ['id' => 'role_id']);
    }

    /**
     * @describe 高级角色表关联高级角色、用户关系表 auth_role ^ auth_role_child
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-05
     * @return mixed
     */
    public function getRoleChild()
    {
        return $this->hasOne(AuthRoleChildModel::className(), ['role_id' => 'id']);
    }

    /**
     * @describe 高级角色表关联组织机构表 auth_role ^ 组织机构表
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-03
     * @return mixed
     */
    public function getCompany()
    {
        return $this->hasOne(Config::getRelations(1), ['id' => 'company_id']);
    }

    /**
     * @describe 高级角色、用户关系表 关联项目用户表 auth_role_child ^ 用户表
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-04
     * @return mixed
     */
    public function getUser()
    {
        return $this->hasOne(Config::getRelations(2), ['id' => 'user_id']);
    }
}