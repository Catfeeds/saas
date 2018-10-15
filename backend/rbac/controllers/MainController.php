<?php

namespace backend\rbac\controllers;

use backend\rbac\Config;
use backend\rbac\models\AuthRoleItemModel;
use backend\rbac\models\base\AuthModule;
use backend\rbac\models\AuthModuleModel;
use backend\rbac\models\AuthModuleForm;

class MainController extends BaseController
{
    /**
     * @describe behaviors
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-26
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'create' => ['POST'],
                'creates' => ['POST'],
                'insert' => ['POST'],
                'update' => ['POST'],
                'modify' => ['POST'],
                'move' => ['POST'],
                'view' => ['GET'],
                'index' => ['GET'],
                'detail' => ['GET'],
                'examine' => ['GET'],
            ],
        ];

        return $behaviors;
    }

    /**
     * @describe 开发者配置首页
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-27
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @describe 添加基础角色
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-27
     * @return string
     */
    public function actionCreate()
    {
        $post = $this->post;
        $pid = AuthModuleModel::findOne(['name' => $post['module_name']])->pid;
        $auth = AuthModuleModel::findOne(['id' => $pid]);
        if (!empty($auth) && $auth->status === 2) {
            return $this->response('请先添加父级模块', [], 3, 'warning');
        }

        $result = $this->authHandler($post['module_name']);
        if ($result) {
            return $this->response('添加成功', [], 1, 'success');
        }

        return $this->response('请求失败', [], 0, 'error');
    }

    /**
     * @describe 批量添加基础角色
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-27
     * @return string
     */
    public function actionCreates()
    {
        $names = !empty($this->post) ? $this->post['module_name'] : [];
        $transaction = self::$_db->db->beginTransaction();
        try {
            foreach ($names as $key => $item) {
                $result = $this->authHandler($item);
                if (!$result) {
                    throw new \Exception('error');
                }

            }

            $transaction->commit();
            return $this->response('请求成功', [], 1, 'success');
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->response($e->getMessage(), [], 0, 'error');
        }
    }

    /**
     * @describe <添加权限、添加基础角色、绑定权限和基础角色>处理程序
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-27
     * @param $moduleName
     * @return string
     */
    private function authHandler($moduleName)
    {
        /* 模块名 */
        if (!isset($moduleName)) {
            return false;
        }

        $main = AuthModuleModel::find()->where(['name' => $moduleName])->asArray()->all();
        if (empty($main)) {
            return false;
        }

        $transaction = self::$_db->beginTransaction();
        try {
            /*添加角色*/
            $role = self::$_authManager->createRole($moduleName);
            $role->description = current($main)['desc'];
            $result_1 = self::$_authManager->add($role);
            if (!$result_1) {
                throw new \Exception('errors');
            }

            /*轮询添加权限*/
            foreach ($main as $key => $item) {
                $perModel = self::$_authManager->createPermission($item['route']);
                $perModel->description = $item['desc'];
                $result_2 = self::$_authManager->add($perModel);
                if (!$result_2) {
                    throw new \Exception('errors');
                }

                /*轮询分配基础角色*/
                $result_3 = self::$_authManager->addChild($role, $perModel);
                if (!$result_3) {
                    throw new \Exception('errors');
                }
            }
            /*修改模块状态*/
            $rows = AuthModule::updateAll(['status' => 1], ['name' => $moduleName]);
            if (!$rows) {
                throw new \Exception('errors');
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * @describe 新增模块
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-27
     * @return string
     */
    public function actionInsert()
    {
        $post = $this->post;
        if (!isset($post['scenario'])) {
            return $this->response('添加失败, 请求参数为空, 请求失败!', [], 0, 'error');
        }

        $model = new AuthModuleForm();
        $model->setScenario($post['scenario']);
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->save();
            if ($result === true) {
                return $this->response('添加成功', [], 1, 'success');
            }

            return $this->response('添加失败!', [], 0, 'error');
        }

        return $this->response('添加失败!', [], 0, 'error');
    }

    /**
     * @describe 模块列表
     * @author <yanghuilei@itsport.club>
     * @param $isOption
     * @param $isCache
     * @createAt 2018-06-27
     * @return string
     */
    public function actionView($isOption, $isCache)
    {
        if ($isOption) {
            if ($isCache) {
                $data = self::$_cache->getOrSet('option_modules', function () use ($isOption) {
                    $auth = new AuthModuleModel();
                    return $auth->getAuthModuleRecursive($isOption);

                });
            } else {
                if (self::$_cache->exists('option_modules')) {
                    self::$_cache->delete('option_modules');
                }

                $auth = new AuthModuleModel();
                $data = $auth->getAuthModuleRecursive($isOption);
            }
        } else {
            if ($isCache) {
                $data = self::$_cache->getOrSet('list_modules', function () use ($isOption) {
                    $auth = new AuthModuleModel();
                    $temp_data = $auth->getAuthModuleRecursive($isOption);
                    $data = $auth->isTwoLevelMenus($temp_data);

                    return $data;
                });
            } else {
                if (self::$_cache->exists('list_modules')) {
                    self::$_cache->delete('list_modules');
                }

                $auth = new AuthModuleModel();
                $temp_data = $auth->getAuthModuleRecursive($isOption);
                $data = $auth->isTwoLevelMenus($temp_data);
            }
        }

        return $this->response('请求成功', $data, 1, 'success');
    }

    /**
     * @describe 修改
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-04
     * @param $module_id
     * @param $option 0|1
     * @return string
     */
    public function actionDetail($module_id, $option = 0)
    {
        $model = new AuthModuleModel();
        $data = $model->getOneModule($module_id, $option);

        return $this->response('请求成功', $data, 1, 'success');
    }

    /**
     * @describe 点击查看
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-05
     * @param $module_name
     * @return string
     */
    public function actionExamine($module_name)
    {
        $model = new AuthRoleItemModel();
        $role_data = $model->getHighRoleOfBasicRole($module_name);
        $user_data = $model->getUserOfBasicRole($module_name);
        if (empty($role_data)) {
            $role_data = null;
        }

        if (empty($user_data)) {
            $user_data = null;
        }

        $data = ['role_data' => $role_data, 'user_data' => $user_data];

        return $this->response('请求成功', $data, 1, 'success');
    }

    /**
     * @describe 修改模块
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-09
     * @return string
     */
    public function actionUpdate()
    {
        $post = $this->post;
        $model = new AuthModuleForm();
        if (!isset($post['scenario'])) {
            return $this->response('修改失败, 错误代码281', [], 0, 'error');
        }

        $model->setScenario($post['scenario']);
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->update();
            if ($result === true) {
                return $this->response('修改成功', [], 1, 'success');
            }

            return $this->response($result, [], 0, 'error');
        }

        return $this->response('修改失败!', [], 0, 'error');
    }

    /**
     * @describe 开发者配置 - 菜单调换
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-28
     * @return string
     */
    public function actionMove()
    {
        $post = $this->post;
        if (!isset($post['two_id']) || !isset($post['one_id'])) {
            return $this->response('请求失败!', [], 0, 'error');

        }

        $module_model = AuthModuleModel::findOne($post['two_id']);
        if (!is_object($module_model)) {
            return $this->response('二级菜单不存在!', [], 0, 'error');
        }

        $status = $module_model->status;
        if ($status == 2) {
            return $this->response('请先分配权限!', [], 0, 'error');
        }

        $pid = $module_model->pid;
        if (empty($pid)) {
            return $this->response('数据错误PID!', [], 0, 'error');
        }

        $one_menu_model = AuthModuleModel::findOne($pid);
        if (!is_object($one_menu_model) || $one_menu_model->pid != 0) {
            return $this->response('请选择二级菜单!', [], 0, 'error');
        }

        $top_menu_name = $one_menu_model->name;
        if (in_array($top_menu_name, Config::$rbacModuleName)) {
            return $this->response('超级管理员权限菜单是特殊菜单, 不能被调换!', [], 0, 'error');
        }

        $prepare_top_module = AuthModuleModel::findOne($post['one_id']);
        if (!is_object($prepare_top_module)) {
            return $this->response('一级菜单不存在!', [], 0, 'error');
        }

        $one_menu_name = $prepare_top_module->name;
        if (in_array($one_menu_name, Config::$rbacModuleName)) {
            return $this->response('超级管理员权限菜单是特殊菜单, 不能被调换!', [], 0, 'error');
        }

        $module_model->pid = $post['one_id'];
        $result = $module_model->save();
        if ($result) {
            return $this->response('调换成功!', [], 1, 'success');
        }

        return $this->response('调换失败!', [], 0, 'error');
    }

    /**
     * @describe 修改已添加权限模块
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-30
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionModify()
    {
        $post = $this->post;
        $model = new AuthModuleForm();
        $model->setScenario($post['scenario']);
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->modify();
            if ($result === true) {
                return $this->response('修改成功!', [], 1, 'success');
            }

            return $this->response($result, [], 0, 'error');
        }

        return $this->response('修改失败!错误代码375', [], 0, 'error');
    }
}