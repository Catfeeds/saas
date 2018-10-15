<?php

namespace backend\rbac\controllers;

use backend\rbac\Config;
use backend\rbac\models\AuthModuleModel;
use backend\rbac\models\AuthRoleChildForm;
use backend\rbac\models\AuthRoleChildModel;
use backend\rbac\models\AuthRoleForm;
use backend\rbac\models\AuthRoleItemForm;
use backend\rbac\models\AuthRoleItemModel;
use backend\rbac\models\AuthRoleModel;

class AuthController extends BaseController
{
    /**
     * @describe 过滤器 //过滤http1.0下数据传输动作
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
                'insert' => ['POST'],
                'assign-user' => ['POST'],
                'add-venue' => ['POST'],
                'modify-role' => ['POST'],
                'saver' => ['POST'],
                'basic-role' => ['GET'],
                'view' => ['GET'],
                'index' => ['GET'],
                'company' => ['GET'],
                'venue' => ['GET'],
                'users' => ['GET'],
                'check' => ['GET'],
                'check-assign' => ['GET'],
                'del' => ['GET'],
                'del-item' => ['GET'],
                'menu' => ['GET'],
                'per' => ['GET'],
                'top' => ['GET'],
                'venues' => ['GET'],
                'del-venue' => ['GET'],
                'get-venue' => ['GET'],
                'role-detail' => ['GET'],
            ],
        ];

        return $behaviors;
    }

    /**
     * @describe 用户配置首页
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-27
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @describe 高级角色列表
     * @author <yanghuilei@itsport.club>
     * @param $isOption
     * @createAt 2018-07-02
     * @return string
     */
    public function actionView($isOption)
    {
        $model = new AuthRoleModel();
        $data = $model->getAllSeniorRole($isOption);

        return $this->response('请求成功', $data, 1, 'success');
    }

    /**
     * @describe 新增高级角色
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-02
     * @return string
     */
    public function actionInsert()
    {
        $post = $this->post;
        if (empty($post)) {
            return $this->response('添加失败', [], 0, 'error');
        }

        $model = new AuthRoleForm();
        $model->setScenario($post['scenario']);
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->save();

            if ($result) {
                return $this->response('添加成功', [], 1, 'success');
            }

            return $this->response('添加失败!', [], 0, 'error');
        }

        return $this->response('添加失败!', [], 0, 'error');
    }

    /**
     * @describe 新增高级角色-公司
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-02
     * @return string
     */
    public function actionCompany()
    {
        $companies = Config::companies();

        return $this->response('请求成功', $companies, 1, 'success');
    }

    /**
     * @describe 新增高级角色-场馆
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-02
     * @param $company
     * @return string
     */
    public function actionVenue($company)
    {
        $venues = Config::venues($company);

        return $this->response('请求成功', $venues, 1, 'success');
    }

    /**
     * @describe 分配权限 - 获取权限列表
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-02
     * @param $highRole
     * @param $deriveId
     * @return string
     */
    public function actionBasicRole($highRole, $deriveId)
    {
        $model = new AuthRoleModel();
        $result = $model->getIsAllotBasicRoles($highRole, $deriveId);
        if (!$result) {
            return $this->response("请求失败", [], 0, 'error');
        }

        return $this->response("请求成功", $result, 1, 'success');
    }

    /**
     * @describe 角色分配权限 - 保存权限
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-09
     * @return string
     */
    public function actionCreate()
    {
        $transaction = self::$_db->beginTransaction();
        try {
            $post = $this->post;
            $model = new AuthRoleItemForm();
            $model->setScenario($post['scenario']);
            if (!isset($post['auth_item'])) {
                throw new \Exception('添加失败,错误代码163');
            }

            if (!$model->load($post, '') || !$model->validate()) {
                throw new \Exception($model->errors);
            }

            $result1 = $model->save();
            if (!$result1) {
                throw new \Exception($model->errors);
            }

            $auth = AuthRoleModel::findOne($post['auth_role_id']);
            if (!is_object($auth)) {
                throw new \Exception('添加失败,错误代码177');
            }

            $data = AuthRoleChildModel::find()->where(['role_id' => $post['auth_role_id']])->asArray()->all();
            if (!empty($data)) {
                $user_ids = array_column($data, 'user_id');
                $result2 = $model->bindNewPermissions($user_ids);
                if (!$result2) {
                    throw new \Exception('添加失败,错误代码185');
                }
            }

            if (isset($auth->status) && $auth->status == 2) {
                $affected_rows = AuthRoleModel::updateAll(['status' => 1], ['id' => $post['auth_role_id']]);
                if (!$affected_rows) {
                    throw new \Exception('添加失败,错误代码192');
                }
            }

            $transaction->commit();
            return $this->response('添加成功', [], 1, 'success');
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->response($e->getMessage(), [], 0, 'error');
        }
    }

    /**
     * @describe 分配用户-选择用户
     * @author <yanghuilei@itsport.club>
     * @param $company_id
     * @createAt 2018-07-03
     * @return string
     */
    public function actionUsers($company_id)
    {
        $users = Config::allUsers($company_id);

        return $this->response('请求成功', $users, 1, 'success');
    }

    /**
     * @describe 分配用户 - 保存
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-03
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionAssignUser()
    {
        $post = $this->post;
        $model = new AuthRoleChildForm();
        $model->setScenario($post['scenario']);
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->save();
            if ($result) {
                return $this->response('分配成功', [], 1, 'success');
            }

            return $this->response('分配失败!', [], 0, 'error');
        }

        return $this->response('分配失败!', [], 0, 'error');
    }

    /**
     * @describe 查看权限
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-03
     * @param $roleId
     * @return string
     */
    public function actionCheck($roleId)
    {
        $model = new AuthRoleItemModel();
        $data = $model->checkPermissions($roleId);
        $result = Config::recursive($data, 0, 0, 'pid');

        return $this->response('请求成功', $result, 1, 'success');
    }

    /**
     * @describe 查看用户
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-04
     * @param $role_id
     * @return string
     */
    public function actionCheckAssign($role_id)
    {
        $model = new AuthRoleChildModel();
        $result = $model->checkAssignedHighRoleUsers($role_id);

        return $this->response('请求成功', $result, 1, 'success');
    }

    /**
     * @describe 查看用户 - 删除用户
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-09
     * @param $child_id
     * @param $user_id
     * @return string
     */
    public function actionDel($child_id, $user_id)
    {
        $transaction = self::$_db->beginTransaction();
        try {
            $affected_rows = AuthRoleChildModel::deleteAll('id=:child', [':child' => $child_id]);
            if (!$affected_rows) {
                throw new \Exception('删除失败, 错误代码: 287');
            }

            $result = self::$_authManager->revokeAll($user_id);
            if (!$result) {
                throw new \Exception('删除失败, 错误代码: 292');
            }

            $transaction->commit();
            return $this->response('删除成功', [], 1, 'success');

        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->response($e->getMessage(), [], 0, 'error');
        }
    }

    /**
     * @describe 查看权限 - 删除权限
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-09
     * @param $item_name
     * @param $role_id
     * @return string
     */
    public function actionDelItem($item_name, $role_id)
    {
        $transaction = self::$_db->beginTransaction();
        try {
            $data = AuthRoleChildModel::find()->where(['role_id' => $role_id])->asArray()->all();
            if (!empty($data)) {
                $user_ids = array_unique(array_column($data, 'user_id'));
                $role = self::$_authManager->getRole($item_name);
                foreach ($user_ids as $key => $user_id) {
                    $bool = self::$_authManager->revoke($role, $user_id);
                    if (!$bool) {
                        throw new \Exception('删除失败, 错误代码324');
                    }
                }
            }

            //查看是否是父权限
            $isParent = (new AuthRoleItemModel())->isParentPermission($item_name, $role_id);
            if (!$isParent) {
                throw new \Exception('删除失败, 请先删除子权限!');
            }

            $affected_rows = AuthRoleItemModel::deleteAll(
                'auth_item=:item_name AND role_id=:role_id',
                [':item_name' => $item_name, ':role_id' => $role_id]
            );
            if (!$affected_rows) {
                throw new \Exception('删除失败, 错误代码340');
            }

            $transaction->commit();
            return $this->response('删除成功', [], 1, 'success');

        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->response($e->getMessage(), [], 0, 'error');
        }
    }

    /**
     * @describe 新增权限 - 菜单下拉列表
     * @author <yanghuilei@itsport.club>
     * @param $is_all
     * @createAt 2018-07-09
     * @return string
     */
    public function actionMenu($is_all = false)
    {
        $model = new AuthModuleModel();
        $data = $model->getTopMenu($is_all);

        return $this->response('请求成功', $data, 1, 'success');
    }

    /**
     * @describe 增加权限 - 权限列表
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-09
     * @param $module_id
     * @param $role_id
     * @return string
     */
    public function actionPer($module_id, $role_id)
    {
        $model = new AuthRoleItemModel();
        $new_per = Config::recursiveBySql($module_id, 0, ['status' => 1]);
        $role_per = $model->checkPermissions($role_id);
        foreach ($new_per as $c => $d) {
            foreach ($role_per as $a => $b) {
                if ($d['id'] == $b['id']) {
                    $new_per[$c]['is_disabled'] = 1;
                    continue 2;
                }
            }
            $new_per[$c]['is_disabled'] = 0;
        }

        return $this->response('请求成功', $new_per, 1, 'success');
    }

    /**
     * @describe 获取用户可访问的菜单
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-17
     * @return string
     */
    public function actionTop()
    {
        $user = \Yii::$app->user;
        if (empty($user)) {
            return $this->response('请求失败', [], 0, 'error');
        }

        $user_id = $user->identity->getId();
        $menu_cache = md5($user_id . 'menu');
        $data = self::$_cache->getOrSet($menu_cache, function () use ($user_id) {
            $model = new AuthRoleChildModel();
            return $model->getTopMenuByUserIdentify($user_id);
        });

        return $this->response('请求成功', $data, 1, 'success');
    }

    /**
     * @describe 角色列表 - 场馆详情
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-24
     * @param $role_id
     * @return string
     */
    public function actionVenues($role_id)
    {
        $model = new AuthRoleModel();
        $data = $model->getVenuesDetailOfRole($role_id);

        return $this->response('请求成功', $data, 1, 'success');
    }

    /**
     * @describe 角色列表 - 场馆详情 - 删除场馆
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-24
     * @param $role_id
     * @param $venue_id
     * @return string
     */
    public function actionDelVenue($role_id, $venue_id)
    {
        $model = new AuthRoleModel();
        $bool = $model->delAndAddVenueOfRole($role_id, $venue_id);

        if ($bool === true) {
            return $this->response('删除成功', [], 1, 'success');

        } elseif ($bool === null) {
            return $this->response('场馆不能为空, 至少保留一个!', [], 2, 'warning');

        } else {
            return $this->response('删除失败', [], 0, 'error');
        }
    }

    /**
     * @describe 角色列表 - 场馆详情 - 新增场馆
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-24
     * @return string
     */
    public function actionAddVenue()
    {
        $post = $this->post;
        if (!isset($post['role_id']) || !isset($post['venue_ids'])) {
            return $this->response('新增失败', [], 0, 'error');
        }

        $model = new AuthRoleModel();
        $bool = $model->delAndAddVenueOfRole($post['role_id'], $post['venue_ids'], true);

        if ($bool) {
            return $this->response('新增成功', [], 1, 'success');
        }

        return $this->response('新增失败', [], 0, 'error');
    }

    /**
     * @describe 角色列表 - 场馆详情 - 新增场馆 - 获取场馆
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-24
     * @param $role_id
     * @return string
     */
    public function actionGetVenue($role_id)
    {
        $model = new AuthRoleModel();
        $data = $model->getVenuesOfRole($role_id);

        return $this->response('请求成功', $data, 1, 'success');
    }

    /**
     * @describe 分配用户 - 角色名称修改
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-25
     * @return string
     */
    public function actionModifyRole()
    {
        $post = $this->post;
        $model = new AuthRoleForm();
        $model->setScenario($post['scenario']);
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->modify();
            if ($result === true) {
                return $this->response('修改成功', [], 1, 'success');
            }

            return $this->response('修改失败', [], 0, 'error');
        }
        return $this->response('修改失败', [], 0, 'error');
    }

    /**
     * @describe 通过角色ID获取角色详情
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-25
     * @param $role_id
     * @return string
     */
    public function actionRoleDetail($role_id)
    {
        $model = new AuthRoleModel();
        $data = $model->getRoleDetailById($role_id);
        if (empty($data)) {
            return $this->response('请求失败', [], 0, 'error');
        }
        unset($data['venue_id'], $data['create_at'], $data['update_at'], $data['status']);

        return $this->response('请求成功', $data, 1, 'success');
    }

    /**
     * @describe 修改角色名 (未分配权限)
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-25
     * @return string
     */
    public function actionSaver()
    {
        $post = $this->post;
        $model = new AuthRoleForm();
        $model->setScenario($post['scenario']);
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->unAllotModify();
            if ($result === true) {
                return $this->response('修改成功', [], 1, 'success');
            }
            return $this->response('修改失败', [], 0, 'error');
        }
        return $this->response('修改失败', [], 0, 'error');
    }
}