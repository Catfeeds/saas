<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/8/31
 * Time: 17:43
 */

namespace backend\models;


class Position extends \common\models\base\Position
{
    /**
     * 云运动 - 员工管理 - 添加员工职位
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/8/15
     * @param  $branchId
     * @param $companyIds
     * @return string
     */
    public function getPositionAllByVenueId($branchId, $companyIds)
    {
       return self::find()->where([
           'department_id'=>$branchId,
           'company_id' => $companyIds
       ])->asArray()->all();
    }
    /**
     * 云运动 - 员工管理 - 删除员工职位
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/8/15
     * @param  $Id
     * @return string
     */
    public function deletePositionById($Id)
    {
        $position =  \common\models\base\Position::findOne(['id'=>$Id]);
        $employee = Employee::findOne(['position'=>$position->name]);
        if(!empty($employee)){
            return 'error';
        }
        return $position->delete();
    }
}