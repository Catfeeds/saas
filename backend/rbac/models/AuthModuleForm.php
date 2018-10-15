<?php

namespace backend\rbac\models;

use backend\rbac\models\base\AuthRoleItem;
use yii\base\Model;
use backend\rbac\models\base\AuthModule;
use Yii;

class AuthModuleForm extends Model
{
    public $module_name;
    public $module_route;
    public $module_pid;
    public $desc;
    public $response_type;
    public $module_id;
    public $module_icon;
    private $_object;   /*this is owner*/

    const MODULE_X_ADD = 'x_add';
    const MODULE_X_MODIFY = 'x_modify';
    const MODULE_X_MODIFY_TWO = 'x_update';
    const MODULE_PID = 0;

    /**
     * @describe 设置场景认证, 控制方法: load() && validate()
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-26
     * @return array
     */
    public function scenarios()
    {
        return [
            self::MODULE_X_ADD => [
                'module_name',
                'module_route',
                'module_pid',
                'desc',
                'response_type',
                'module_icon'
            ],
            self::MODULE_X_MODIFY => [
                'module_name',
                'module_route',
                'module_pid',
                'desc',
                'module_id',
                'response_type',
                'module_icon'
            ],
            self::MODULE_X_MODIFY_TWO => [
                'module_name',
                'module_route',
                'desc',
                'module_id',
                'response_type',
                'module_icon'
            ],
        ];
    }

    /**
     * @describe 初始化实例AuthModule对象
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-28
     */
    public function init()
    {
        $this->_object = new AuthModule();
        parent::init();
    }

    /**
     * @describe 场景规则验证
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-26
     * @return array
     */
    public function rules()
    {
        return [
            [['module_name', 'module_route', 'module_pid', 'desc', 'response_type'], 'required',
                'on' => [self::MODULE_X_MODIFY, self::MODULE_X_ADD]],
            [['module_name', 'module_route', 'module_pid', 'desc', 'response_type', 'module_icon'], 'safe',
                'on' => [self::MODULE_X_MODIFY, self::MODULE_X_ADD]],
            ['module_id', 'safe', 'on' => [self::MODULE_X_MODIFY, self::MODULE_X_MODIFY_TWO]],
            ['module_id', 'required', 'on' => [self::MODULE_X_MODIFY, self::MODULE_X_MODIFY_TWO]],
            ['module_pid', 'default', 'value' => self::MODULE_PID,
                'on' => [self::MODULE_X_MODIFY, self::MODULE_X_ADD]],
            [['module_name', 'module_route', 'desc', 'response_type'], 'required',
                'on' => self::MODULE_X_MODIFY_TWO],
            [['module_name', 'module_route', 'desc', 'response_type', 'module_icon'], 'safe',
                'on' => self::MODULE_X_MODIFY_TWO],
        ];
    }

    /**
     * @describe 新增模块 - 保存模块
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-26
     * @param $data
     * @return array|bool
     */
    public function save()
    {
        $this->_object->setAttributes([
            'name' => $this->module_name,
            'route' => $this->module_route,
            'pid' => $this->module_pid,
            'response_type' => $this->response_type,
            'desc' => $this->desc,
            'icon' => $this->module_icon
        ]);
        $affect = $this->_object->save();
        if ($affect) {
            return true;
        }

        return $this->_object->errors;
    }

    /**
     * @describe 修改模块
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-09
     * @return array|bool
     */
    public function update()
    {
        $model = AuthModule::findOne($this->module_id);
        $model->name = $this->module_name;
        $model->route = $this->module_route;
        $model->pid = $this->module_pid;
        $model->response_type = $this->response_type;
        $model->desc = $this->desc;
        $model->icon = $this->module_icon;
        if ($model->save()) {
            return true;
        }

        return $model->errors;
    }

    /**
     * @describe 修改已添加权限模块
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-30
     * @return bool|string
     * @throws \yii\db\Exception
     */
    public function modify()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            //模块表修改
            $model = AuthModule::findOne($this->module_id);
            $old_module_name = $model->name;
            $model->name = $this->module_name;
            $model->route = $this->module_route;
            $model->response_type = $this->response_type;
            $model->desc = $this->desc;
            $model->icon = $this->module_icon;
            $bool1 = $model->save();
            if (!$bool1) {
                throw new \Exception('修改模块失败!错误代码159');
            }

            $auth_role_item = AuthRoleItem::findAll(['auth_item' => $old_module_name]);
            if (!empty($auth_role_item) && $old_module_name <> $this->module_name) {
                $affected_rows = AuthRoleItem::updateAll([
                    'auth_item' => $this->module_name],
                    'auth_item=:item_name',
                    [':item_name' => $old_module_name
                    ]);
                if (!$affected_rows) {
                    throw new \Exception('修改模块失败!错误代码170');
                }

            }

            if ($old_module_name <> $this->module_name) {
                $auth_manager = Yii::$app->getAuthManager();
                $role_model = $auth_manager->createRole($this->module_name);
                $bool2 = $auth_manager->update($old_module_name, $role_model);
                if (!$bool2) {
                    throw new \Exception('修改模块失败!错误代码179');

                }

            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $e->getMessage();
        }
    }
}