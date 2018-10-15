<?php

namespace backend\rbac\models;

use yii\base\Model;
use backend\rbac\models\base\AuthRole;

class AuthRoleForm extends Model
{
    public $role_name;
    public $company_id;
    public $derive_id;
    public $venue_id;
    public $role_id;

    private $_object; /* this is owner */

    const SCENARIO_INSERT = 'insert';
    const SCENARIO_MODIFY = 'modify';
    const SCENARIO_UN_MODIFY = 'un_modify';

    /**
     * @describe 初始化实例AuthRole
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-28
     */
    public function init()
    {
        $this->_object = new AuthRole();
        parent::init();
    }

    /**
     * @describe 设置场景验证
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-27
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_INSERT => ['role_name', 'company_id', 'derive_id', 'venue_id'],
            self::SCENARIO_MODIFY => ['role_name', 'role_id'],
            self::SCENARIO_UN_MODIFY => ['role_name', 'company_id', 'derive_id', 'role_id'],
        ];
    }

    /**
     * @describe 设置验证规则
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-27
     * @return array
     */
    public function rules()
    {
        return [
            [['role_name', 'company_id', 'derive_id', 'venue_id'], 'safe', 'on' => self::SCENARIO_INSERT],
            [['role_name', 'company_id', 'derive_id', 'venue_id'], 'required', 'on' => self::SCENARIO_INSERT],
            [['role_name', 'role_id'], 'safe', 'on' => self::SCENARIO_MODIFY],
            [['role_name', 'role_id'], 'required', 'on' => self::SCENARIO_MODIFY],
            [['role_name', 'company_id', 'derive_id', 'role_id'], 'safe', 'on' => self::SCENARIO_UN_MODIFY],
            [['role_name', 'company_id', 'derive_id', 'role_id'], 'required', 'on' => self::SCENARIO_UN_MODIFY],
            ['role_name', 'unique', 'targetClass' => 'backend\rbac\models\base\AuthRole', 'targetAttribute' => 'name', 'on' => [self::SCENARIO_INSERT, self::SCENARIO_MODIFY]],
        ];
    }

    /**
     * @describe 新增高级角色
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-27
     * @return array|bool
     */
    public function save()
    {
        $this->_object->name = $this->role_name;
        $this->_object->company_id = $this->company_id;
        $this->_object->venue_id = json_encode($this->venue_id);
        $this->_object->derive_id = $this->derive_id;
        if ($this->_object->save()) {
            return true;
        }

        return $this->_object->errors;
    }

    /**
     * @describe 修改角色名 (已分配权限)
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-25
     * @return array|bool
     */
    public function modify()
    {
        $model = AuthRole::findOne($this->role_id);
        $model->name = $this->role_name;
        if ($model->save()) {
            return true;
        }

        return $model->errors;
    }

    /**
     * @describe 修改角色名 (未分配权限)
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-25
     * @return array|bool
     */
    public function unAllotModify()
    {
        $model = AuthRole::findOne($this->role_id);
        $model->name = $this->role_name;
        $model->derive_id = $this->derive_id;
        $model->company_id = $this->company_id;
        if ($model->save()) {
            return true;
        }

        return $model->errors;
    }
}