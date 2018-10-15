<?php
namespace backend\models;
use common\models\relations\EmployeeTurnMemberRecordRelations;

class EmployeeTurnMemberRecord extends \common\models\base\EmployeeTurnMemberRecord
{
    use EmployeeTurnMemberRecordRelations;


    /**
     *后台员工管理 - 员工详情 -  转移会员列表
     * @author Huang hua <huanghua@itsports.club>
     * @create 2018/4/4
     * @param $id
     * @return bool|string
     */
    public function turnMemberRecord($id)
    {
        $model = EmployeeTurnMemberRecord::find()
            ->alias('et')
            ->joinWith(['employee toEmployee'],false)
            ->joinWith(['employeeS fromEmployee'],false)
            ->joinWith(['employeeC employeeC'],false)
            ->select(
                "
                      et.id,
                      et.from_employee_id,
                      et.to_employee_id,
                      et.member_count,
                      et.create_id,
                      et.created_at,
                      toEmployee.name as toName,
                      fromEmployee.name as fromName,
                      employeeC.name as createName,    
               "
            )
            ->where(['or',['et.to_employee_id' => $id],['et.from_employee_id'=> $id]])
            ->orderBy('et.id desc')
            ->asArray()
            ->all();
        return $model;
    }

}