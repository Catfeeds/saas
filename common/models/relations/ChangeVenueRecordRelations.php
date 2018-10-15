<?php
/**
 * Created by PhpStorm.
 * User: 付钟超 <fuzhongchao@itsports.club>
 * Date: 2018/5/25 0025
 * Time: 19:50
 */

namespace common\models\relations;
use common\models\Employee;
use common\models\Organization;
trait ChangeVenueRecordRelations
{
    /**
     * @desc: 业务后台 - 关联组织表 -获取旧场馆名称
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/26
     * @return mixed
     */
    public function getOldOrganization()
    {
        return $this->hasOne(Organization::className(),['id'=>'old_venue_id']);
    }


    /**
     * @desc: 业务后台 - 关联组织表 -获取新场馆名称
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/26
     * @return mixed
     */
    public function getNewOrganization()
    {
        return $this->hasOne(Organization::className(),['id'=>'new_venue_id']);
    }

    /**
     * @desc: 业务后台 - 关联员工表 - 获取员工信息
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/26
     * @return mixed
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(),['admin_user_id'=>'create_id']);
    }
}