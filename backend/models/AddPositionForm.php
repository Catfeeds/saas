<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/8/31
 * Time: 17:17
 */

namespace backend\models;

use common\models\base\Position;
use yii\base\Model;

class AddPositionForm extends Model
{
    public $name;
    public $companyId;
    public $venueId;
    public $branchId;

    /**
     * 云运动 - 员工管理 - 设置验证
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/15
     */
    public function rules()
    {
        return [
            [['name','branchId', 'companyId', 'venueId'],'safe']
        ];
    }

    /**
     * 云运动 - 员工管理 - 保存职位
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/15
     */
    public function savePosition()
    {
        $repeat   = Position::findOne(['name'=>$this->name,'department_id'=>$this->branchId]);
        if(!empty($repeat)){
            return '该职位部门下已经存在';
        }
        $position = new Position();
        $position->name          = $this->name;
        $position->venue_id      = $this->venueId;
        $position->department_id = $this->branchId;
        $position->company_id    = $this->companyId;
        $position->create_at     = time();
        $position->update_at     = time();
        if($position->save()){
            return $position;
        }
        return $position->errors;
    }
}