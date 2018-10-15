<?php

namespace backend\modules\v2\models;


use backend\models\Employee;

class Admin extends \common\models\base\Admin
{
    /**
     * 员工 - 登录 - 获取员工数据
     * @author  Huang pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @param  $username  //员工帐号
     * @return array      //员工信息
     */
    public function getEmployeeOneData($username)
    {
        $admin =  Admin::find()->where(['username' =>$username])->one();
        return    Employee::find()->alias('ee')->where(['admin_user_id'=>$admin['id']])
            ->select('ee.id,ee.name,ee.pic,ee.position,ee.status,ee.organization_id,position.name as pName,organization.name as oName')
            ->joinWith(['position position'],false)
            ->joinWith(['organization organization'],false)
            ->asArray()->one();
    }
    /**
     * 员工 - 登录 - 获取员工数据
     * @author  Huang pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @param  $id  //员工帐号
     * @return array      //员工信息
     */
    public function getEmployeeOneInfo($id)
    {
        return    Employee::find()->alias('ee')->where(['ee.id'=>$id])
            ->select('ee.id,ee.name,ee.pic,ee.position,ee.status,ee.organization_id,position.name as pName,organization.name as oName')
            ->joinWith(['position position'],false)
            ->joinWith(['organization organization'],false)
            ->asArray()->one();
    }
}